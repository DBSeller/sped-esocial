<?php

namespace NFePHP\eSocial\Factories\Traits;

trait TraitS5503
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
            "nrRecArqBase",
            $this->std->nrrecarqbase,
            true
        );
        $this->dom->addChild(
            $ideEvento,
            "perApur",
            $this->std->perapur,
            true
        );
        $this->node->insertBefore($ideEvento, $ideEmpregador);
        $this->eSocial->appendChild($this->node);
        $this->xml = $this->dom->saveXML($this->eSocial);
        $this->sign();
    }
}
