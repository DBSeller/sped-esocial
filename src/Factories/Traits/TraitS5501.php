<?php

namespace NFePHP\eSocial\Factories\Traits;

trait TraitS5501
{
    /**
     * builder for version 2.5.0
     */
    protected function toNode250()
    {
        throw new \Exception("Este evento não existem na versão 2.5.");
    }  
 
        /**
     * builder for version 1.0.0
     */
    protected function toNode100()
    {
        throw new \Exception("Este evento não existem na versão 1.0.");
    }  

    /**
     * builder for version S.1.1.0
     */
    protected function toNodeS110()
    {
        $ideEmpregador = $this->node->getElementsByTagName('ideEmpregador')->item(0);
        $ideEvento = $this->dom->createElement("ideEvento");
        $this->dom->addChild(
            $ideEvento,
            "indRetif",
            $this->std->indretif,
            true
        );
        $this->dom->addChild(
            $ideEvento,
            "nrRecibo",
            !empty($this->std->nrrecibo) ? $this->std->nrrecibo : null,
            false
        );
        $this->dom->addChild(
            $ideEvento,
            "tpAmb",
            $this->tpAmb,
            true
        );
        $this->dom->addChild(
            $ideEvento,
            "procEmi",
            $this->procEmi,
            true
        );
        $this->dom->addChild(
            $ideEvento,
            "verProc",
            $this->verProc,
            true
        );
        $this->node->insertBefore($ideEvento, $ideEmpregador);
        //Identificação do processo (obrigatório).
        $identificacaoProcesso = $this->dom->createElement("ideProc");
        $this->dom->addChild(
            $identificacaoProcesso,
            "nrProcTrab",
            $this->std->ideproc->nrproctrab,
            true
        );
        $this->dom->addChild(
            $identificacaoProcesso,
            "perApur",
            $this->std->ideproc->perapur,
            true
        );
        $this->node->appendChild($identificacaoProcesso);
        foreach ($this->std->infotributos as $periodoReferencia) {
            //Identificação do período e da base de cálculo dos tributos referentes ao processo trabalhista.
            $peridoReferencia = $this->dom->createElement("infoTributos");
            $this->dom->addChild(
                $peridoReferencia,
                "perRef",
                $this->std->ideproc->perref,
                true
            );
            $this->xml = $this->dom->saveXML($this->eSocial);
        } 
        //finalização do xml
        $this->eSocial->appendChild($this->node);

        /** 
         * A rotina comentada abaixo poderá ser utilizada no auxilio da montagem da estrutura do XML.
         * Ela apoderá ser colocada abaixo de cada nó.
         * Por exemplo, abaixo da linha 89 e terá a visualização até o nó ideTrab.
         * Ao executar, no terminal, o comando php7.2 artisan esocial:consulta será exibido a estrutura.
        */

        // $this->xml = $this->dom->saveXML($this->eSocial);
        // var_dump($this->xml);
        // die();
        
        $this->sign();
        
    }
}
