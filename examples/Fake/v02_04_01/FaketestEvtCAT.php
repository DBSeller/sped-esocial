<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../../../bootstrap.php';

use NFePHP\Common\Certificate;
use NFePHP\eSocial\Event;

$config     = [
    'tpAmb'          => 2,
    //tipo de ambiente 1 - Produção; 2 - Produção restrita - dados reais;3 - Produção restrita - dados fictícios.
    'verProc'        => '2_4_01',
    //Versão do processo de emissão do evento. Informar a versão do aplicativo emissor do evento.
    'eventoVersion'  => '2.4.1',
    //versão do layout do evento
    'serviceVersion' => '1.1.1',
    //versão do webservice
    'empregador'     => [
        'tpInsc'  => 1,  //1-CNPJ, 2-CPF
        'nrInsc'  => '99999999', //numero do documento
        'nmRazao' => 'Razao Social',
    ],
    'transmissor'    => [
        'tpInsc' => 1,  //1-CNPJ, 2-CPF
        'nrInsc' => '99999999999999' //numero do documento
    ],
];
$configJson = json_encode($config, JSON_PRETTY_PRINT);


$std = new \stdClass();
$std->sequencial = 1;
$std->indretif = 1;
$std->nrrecibo = 'ABJBAJBJAJBAÇÇAAKJ';
$std->tpregistrador = 5;
$std->tpinsc = 1;
$std->nrinsc = '12345678901234';
$std->cpftrab = '12345678901';
$std->nistrab = '12345678901';
$std->dtacid = '2017-12-10';
$std->tpacid = '12.456';
$std->hracid = '0522';
$std->hrstrabantesacid = '0522';
$std->tpcat = 2;
$std->indcatobito = 'N';
$std->dtobito = null;
$std->indcomunpolicia = 'S';
$std->codsitgeradora = '222';
$std->iniciatcat = 3;
$std->observacao = 'lksjlskjlskjslkjslkjslkjslksjl';
$std->tplocal = 8;
$std->dsclocal = 'klçkdçldkdlkdlk';
$std->dsclograd = 'poiwpoiwowiowi';
$std->nrlograd = '2929b';
$std->codmunic = '1200104';
$std->uf = 'AC';
$std->cnpjlocalacid = '12345678901234';
$std->pais = '105';
$std->codpostal = '123456789012';

$std->parteatingida[1] = new \stdClass();
$std->parteatingida[1]->codparteating = '123456789';
$std->parteatingida[1]->lateralidade = 2;

$std->agentecausador[1] = new \stdClass();
$std->agentecausador[1]->codagntcausador = '123456789';

$std->atestado = new \stdClass();
$std->atestado->codcnes = '8282828';
$std->atestado->dtatendimento = '2017-02-01';
$std->atestado->hratendimento = '1255';
$std->atestado->indinternacao = 'N';
$std->atestado->durtrat = 52;
$std->atestado->indafast = 'N';
$std->atestado->dsclesao = '123456789';
$std->atestado->dsccompLesao = 'lskjslkjslkjslksjlskjslkj';
$std->atestado->diagprovavel = 'kkhjskjhskjhskjhskjshkjh';
$std->atestado->codcid = 'a234';
$std->atestado->observacao = 'llksjlkjslksjlskjlsjlskj';
$std->atestado->nmemit = 'Dr Estranho';
$std->atestado->ideoc = 2;
$std->atestado->nroc = '12222kkkk';
$std->atestado->ufoc = 'AC';

$std->catorigem = new \stdClass();
$std->catorigem->dtcatorig = '2016-12-14';
$std->catorigem->nrcatorig = '2565656556';

try {
    //carrega a classe responsavel por lidar com os certificados
    $content     = file_get_contents('expired_certificate.pfx');
    $password    = 'associacao';
    $certificate = Certificate::readPfx($content, $password);

    //cria o evento e retorna o XML assinado
    $xml = Event::evtCAT(
        $configJson,
        $std,
        $certificate,
        '2017-08-03 10:37:00'
    )->toXml();

    //$xml = Evento::s2210($json, $std, $certificate)->toXML();
    //$json = Event::evtCAT($configjson, $std, $certificate)->toJson();

    header('Content-type: text/xml; charset=UTF-8');
    echo $xml;
} catch (\Exception $e) {
    echo $e->getMessage();
}
