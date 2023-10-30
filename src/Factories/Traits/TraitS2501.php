<?php

namespace NFePHP\eSocial\Factories\Traits;

trait TraitS2501
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
            "perApurPgto",
            $this->std->ideproc->perapurpgto,
            true
        );
        if (isset($this->std->ideproc->obs)){
            $this->dom->addChild(
                $identificacaoProcesso,
                "obs",
                $this->std->ideproc->obs,
                false
            );
        }
        $this->node->appendChild($identificacaoProcesso);
        foreach ($this->std->idetrab as $trabalhador) {
            //Identificação do trabalhador (obrigatório).
            $identificacaoTrabalhador = $this->dom->createElement("ideTrab");
            $nodeIdeTrab = $this->node->appendChild($identificacaoTrabalhador);
            $nodeIdeTrab->setAttribute("cpfTrab",$trabalhador->cpftrab);
            foreach ($trabalhador->calctrib as $baseCalculo) {
                //Identificação do período e da base de cálculo dos tributos (obrigatório).
                $baseCalculoTributo = $this->dom->createElement("calcTrib");
                $nodeCalcTrib = $this->node->appendChild($baseCalculoTributo);
                $nodeCalcTrib->setAttribute("perRef",$baseCalculo->perref);
                $nodeCalcTrib->setAttribute("vrBcCpMensal",$baseCalculo->vrbccpmensal);
                $nodeCalcTrib->setAttribute("vrBcCp13",$baseCalculo->vrbccp13);
                $nodeCalcTrib->setAttribute("vrRendIRRF",$baseCalculo->vrrendirrf);
                $nodeCalcTrib->setAttribute("vrRendIRRF13",$baseCalculo->vrrendirrf13);
                if (isset($baseCalculo->infocrcontrib)) {
                    foreach ($baseCalculo->infocrcontrib as $previdencial) {
                        //Informações das contribuições sociais devidas à Previdência Social e Outras Entidades 
                        //e Fundos, por Código de Receita - CR (não obrigatório).
                        $infoCRContrib = $this->dom->createElement("infoCRContrib");
                        $nodeInfoCRContrib = $this->node->appendChild($infoCRContrib);
                        $nodeInfoCRContrib->setAttribute("tpCR",$previdencial->tpcr);
                        $nodeInfoCRContrib->setAttribute("vrCR",$previdencial->vrcr);
                        $baseCalculoTributo->appendChild($infoCRContrib);
                    }
                }
                $identificacaoTrabalhador->appendChild($baseCalculoTributo);
            }
            if (isset($trabalhador->infocrirrf)) {
                foreach ($trabalhador->infocrirrf as $irrf) {
                    //Informações de Imposto de Renda Retido na Fonte, por Código de Receita - CR (não obrigatório).
                    $infoCRIRRF = $this->dom->createElement("infoCRIRRF");
                    $nodeInfoCRIRRF = $this->node->appendChild($infoCRIRRF);
                    $nodeInfoCRIRRF->setAttribute("tpCR",$irrf->tpcr);
                    $nodeInfoCRIRRF->setAttribute("vrCR",$irrf->vrcr);
                    $identificacaoTrabalhador->appendChild($infoCRIRRF);
                }
            }
            $this->node->appendChild($identificacaoTrabalhador);
        } 
        //finalização do xml
        $this->eSocial->appendChild($this->node);

        /** 
         * A rotina comentada abaixo poderá ser utilizada no auxilio da montagem da estrutura do XML.
         * Ela apoderá ser colocada abaixo de cada nó.
         * Por exemplo, abaixo da linha 89 e terá a visualização até o nó ideTrab.
         * Ao executar, no terminal, o comando php artisan esocial:consulta será exibido a estrutura.
        */

        // $this->xml = $this->dom->saveXML($this->eSocial);
        // var_dump($this->xml);
        // die();
        
        $this->sign();
        
    }
}
