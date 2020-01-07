<?php

namespace NFePHP\eSocial;

/**
 * Classe Tools, performs communication with the e-Social webservice
 *
 * @category  NFePHP
 * @package   NFePHP\eSocial\Tools
 * @copyright Copyright (c) 2017
 * @license   https://www.gnu.org/licenses/lgpl-3.0.txt LGPLv3
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt GPLv3
 * @license   https://opensource.org/licenses/mit-license.php MIT
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-esocial for the canonical source repository
 */

use App\Exceptions\Handler;
use App\Http\ValidatesJsonRequests;
use App\Model\Evento;
use App\Model\EventoFila;
use App\Model\EventoOcorrencia;
use App\Traits\SaveOcorrenciasTrait;
use InvalidArgumentException;
use NFePHP\Common\Certificate;
use NFePHP\Common\Exception\ValidatorException;
use NFePHP\Common\Validator;
use NFePHP\eSocial\Common\FactoryInterface;
use NFePHP\eSocial\Common\Soap\SoapCurl;
use NFePHP\eSocial\Common\Soap\SoapInterface;
use NFePHP\eSocial\Common\Tools as ToolsBase;
use RuntimeException;

class Tools extends ToolsBase
{
    use SaveOcorrenciasTrait;

    /**
     * @var string
     */
    public $lastRequest;
    /**
     * @var string
     */
    public $lastResponse;
    /**
     * @var \NFePHP\Common\Soap\SoapInterface
     */
    protected $soap;
    /**
     * @var array
     */
    protected $soapnamespaces = [
        'xmlns:xsi' => "http://www.w3.org/2001/XMLSchema-instance",
        'xmlns:xsd' => "http://www.w3.org/2001/XMLSchema",
        'xmlns:soap' => "http://www.w3.org/2003/05/soap-envelope",
    ];
    /**
     * @var \SoapHeader
     */
    protected $objHeader;
    /**
     * @var string
     */
    protected $xmlns;
    /**
     * @var string
     */
    protected $uri;
    /**
     * @var string
     */
    protected $action;
    /**
     * @var string
     */
    protected $method;
    /**
     * @var array
     */
    protected $parameters;
    /**
     * @var string
     */
    protected $envelopeXmlns;
    /**
     * @var array
     */
    protected $urlbase;

    /**
     * Constructor
     * @param string $config
     * @param Certificate $certificate
     */
    public function __construct($config, Certificate $certificate)
    {
        parent::__construct($config, $certificate);
        //define o ambiente a ser usado
        $this->urlbase = [
            'consulta' => 'https://webservices.producaorestrita.esocial.gov.br/'
                . 'servicos/empregador/consultarloteeventos/WsConsultarLoteEventos.svc',
            'envio' => 'https://webservices.producaorestrita.esocial.gov.br/'
                . 'servicos/empregador/enviarloteeventos/WsEnviarLoteEventos.svc'
        ];
        if ($this->tpAmb == 1) {
            $this->urlbase = [
                'consulta' => 'https://webservices.consulta.esocial.gov.br/'
                    . 'servicos/empregador/consultarloteeventos/WsConsultarLoteEventos.svc',
                'envio' => 'https://webservices.envio.esocial.gov.br/'
                    . 'servicos/empregador/enviarloteeventos/WsEnviarLoteEventos.svc'
            ];
        }
    }

    /**
     * SOAP communication dependency injection
     * @param SoapInterface $soap
     */
    public function loadSoapClass(SoapInterface $soap)
    {
        $this->soap = $soap;
    }

    /**
     * Event batch query
     * @param string $protocolo
     * @return string
     */
    public function consultarLoteEventos($protocolo)
    {
        $operationVersion = $this->serviceXsd['ConsultaLoteEventos']['version'];
        if (empty($operationVersion)) {
            throw new \InvalidArgumentException(
                'Schemas não localizados, verifique de passou as versões '
                . 'corretamente no config.'
            );
        }
        $verWsdl = $this->serviceXsd['WsConsultarLoteEventos']['version'];
        $this->action = "http://www.esocial.gov.br/servicos/empregador/lote"
            . "/eventos/envio/consulta/retornoProcessamento/$verWsdl"
            . "/ServicoConsultarLoteEventos/ConsultarLoteEventos";
        $this->method = "ConsultarLoteEventos";
        $this->uri = $this->urlbase['consulta'];
        $this->envelopeXmlns = [
            'xmlns:soapenv' => "http://schemas.xmlsoap.org/soap/envelope/",
            'xmlns:v1' => "http://www.esocial.gov.br/servicos/empregador/lote"
                . "/eventos/envio/consulta/retornoProcessamento/$verWsdl",
        ];
        $request = "<eSocial xmlns=\"http://www.esocial.gov.br/schema/lote"
            . "/eventos/envio/consulta/retornoProcessamento/"
            . $operationVersion . "\" "
            . "xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\">"
            . "<consultaLoteEventos>"
            . "<protocoloEnvio>$protocolo</protocoloEnvio>"
            . "</consultaLoteEventos>"
            . "</eSocial>";
        //validar a requisição conforme o seu respectivo XSD
        Validator::isValid(
            $request,
            $this->path
            . "schemes/comunicacao/$this->serviceStr/"
            . "ConsultaLoteEventos-$operationVersion.xsd"
        );
        $body = "<v1:ConsultarLoteEventos>"
            . "<v1:consulta>"
            . $request
            . "</v1:consulta>"
            . "</v1:ConsultarLoteEventos>";
        $this->lastRequest = $body;
        $this->lastResponse = $this->sendRequest($body);
        return $this->lastResponse;
    }

    /**
     * Send request to webservice
     * @param string $request
     * @return string
     */
    protected function sendRequest($request)
    {
        if (empty($this->soap)) {
            $this->soap = new SoapCurl($this->certificate);
        }
        $envelope = "<soapenv:Envelope ";
        foreach ($this->envelopeXmlns as $key => $xmlns) {
            $envelope .= "$key = \"$xmlns\" ";
        }
        $envelope .= ">"
            . "<soapenv:Header/>"
            . "<soapenv:Body>"
            . $request
            . "</soapenv:Body>"
            . "</soapenv:Envelope>";
        $msgSize = strlen($envelope);
        $parameters = [
            "Content-Type: text/xml;charset=UTF-8",
            "SOAPAction: \"$this->action\"",
            "Content-length: $msgSize",
        ];
        //return $envelope;
        return (string)$this->soap->send(
            $this->method,
            $this->uri,
            $this->action,
            $envelope,
            $parameters
        );
    }

    /**
     * Send batch of events
     * @param integer $grupo
     * @param array $eventos
     * @return string
     */
    public function enviarLoteEventos($grupo, $eventos = [])
    {
        if (empty($eventos)) {
            return '';
        }
        $xml = "";
        $nEvt = count($eventos);
        if ($nEvt > 50) {
            throw new InvalidArgumentException(
                "O numero máximo de eventos em um lote é 50, "
                . "você está tentando enviar $nEvt eventos !"
            );
        }
        foreach ($eventos as $evt) {
            //verifica se o evento pertence ao grupo indicado
            if (!in_array($evt->alias(), $this->grupos[$grupo])) {
                throw new RuntimeException(
                    'O evento ' . $evt->alias() . ' não pertence a este grupo [ '
                    . $this->eventGroup[$grupo] . ' ].'
                );
            }
            $this->checkCertificate($evt);
            $xmlEvento = "<evento Id=\"$evt->evtid\">";

            try {
                $xmlEvento .= $evt->toXML();
                $xmlEvento .= "</evento>";

            } catch (ValidatorException $exception) {
                $evtEsocialId = $evt->evtid;

                //Retorna o Evento_id que é utilizado no find.
                $eventoFila = EventoFila::where('evento_esocial_id', '=', $evtEsocialId)->first();
                $eventoInvalido = Evento::find($eventoFila->evento_id);

                //Atualiza o status do evento.
                Evento::where('id', '=', $eventoInvalido->id)->update(['status' => '7']);

                //Retira da evento_fila, fazendo com que a mesma não fique trancada por causa de 1 ocorrência.
                $eventoFila->delete();

                // Remove todas as ocorrências do evento
                EventoOcorrencia::where('evento_id', '=', $eventoInvalido->id)->delete();

                // Recupera o nome do campo para adicionar uma nova ocorrência
                $inicioCampo = substr($exception->getMessage(), strpos($exception->getMessage(), '}', 0) + 1);
                $campo = substr($inicioCampo, 0, strpos($inicioCampo, "'"));

                $mensagemErro = "Erro ao processar as informações para envio no eSocial.<br>";
                $mensagemErro .= "Consulte o manual para preenchimento correto das informações.";
                $mensagemErro .= "<br><br>";
                $mensagemErro .= "Mensagem técnica:<br>";
                $mensagemErro .= $exception->getMessage();

                $this->saveOcorrencias(
                    [
                        (object) [
                            'codigo' => $exception->getCode(),
                            'tipo' => 1,
                            'descricao' => $mensagemErro,
                            'localizacao' => sprintf("/eSocial/%s/IDENTIFICADOR_GRUPO/%s", $evt->getEventName(), $campo)
                        ],
                    ],
                    $eventoInvalido
                );

                continue;

            }
            $xml .= $xmlEvento;

        }

        if (empty($xml)) {
            return null;
        }

        $operationVersion = $this->serviceXsd['EnvioLoteEventos']['version'];
        if (empty($operationVersion)) {
            throw new \InvalidArgumentException(
                'Schemas não localizados, verifique de passou as versões '
                . 'corretamente no config.'
            );
        }
        $verWsdl = $this->serviceXsd['WsEnviarLoteEventos']['version'];
        $this->method = "EnviarLoteEventos";
        $this->action = "http://www.esocial.gov.br/servicos/empregador/lote"
            . "/eventos/envio/"
            . $verWsdl
            . "/ServicoEnviarLoteEventos"
            . "/EnviarLoteEventos";
        $this->uri = $this->urlbase['envio'];
        $this->envelopeXmlns = [
            'xmlns:soapenv' => "http://schemas.xmlsoap.org/soap/envelope/",
            'xmlns:v1' => "http://www.esocial.gov.br/servicos/empregador"
                . "/lote/eventos/envio/$verWsdl",
        ];
        $request = "<eSocial xmlns=\"http://www.esocial.gov.br/schema/lote"
            . "/eventos/envio/$operationVersion\" "
            . "xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\">"
            . "<envioLoteEventos grupo=\"$grupo\">"
            . "<ideEmpregador>"
            . "<tpInsc>$this->tpInsc</tpInsc>"
            . "<nrInsc>$this->nrInsc</nrInsc>"
            . "</ideEmpregador>"
            . "<ideTransmissor>"
            . "<tpInsc>$this->transmissortpInsc</tpInsc>"
            . "<nrInsc>$this->transmissornrInsc</nrInsc>"
            . "</ideTransmissor>"
            . "<eventos>"
            . "$xml"
            . "</eventos>"
            . "</envioLoteEventos>"
            . "</eSocial>";
        //validar a requisição conforme o seu respectivo XSD

        Validator::isValid(
            $request,
            $this->path
            . "schemes/comunicacao/$this->serviceStr/"
            . "EnvioLoteEventos-$operationVersion.xsd"
        );
        $body = "<v1:EnviarLoteEventos>"
            . "<v1:loteEventos>"
            . $request
            . "</v1:loteEventos>"
            . "</v1:EnviarLoteEventos>";

        $this->lastRequest = $body;
        $this->lastResponse = $this->sendRequest($body);
        return $this->lastResponse;

    }

    /**
     * Verify the availability of a digital certificate.
     * If available, place it where it is needed
     * @param FactoryInterface $evento
     * @throws RuntimeException
     */
    protected function checkCertificate(FactoryInterface $evento)
    {
        if (empty($this->certificate)) {
            //try to get certificate from event
            $certificate = $evento->getCertificate();
            if (empty($certificate)) {
                //oops no certificate avaiable
                throw new \RuntimeException("Não temos um certificado disponível!");
            }
            $this->certificate = $certificate;
        } else {
            $certificate = $evento->getCertificate();
            if (empty($certificate)) {
                $evento->setCertificate($this->certificate);
            }
        }
    }
}
