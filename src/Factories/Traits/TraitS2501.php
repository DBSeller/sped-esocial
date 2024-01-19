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


    /**
     * builder for version S.1.2.0
     */
    protected function toNodeS120()
    {
        $ideEmpregador = $this->node->getElementsByTagName('ideEmpregador')->item(0);
        //o idEvento pode variar de evento para evento
        //então cada factory individualmente terá de construir o seu
        $ideEvento = $this->dom->createElement("ideEvento");
        $this->dom->addChild(
            $ideEvento,
            "indRetif",
            $this->std->indretif,
            true
        );
        if ($this->std->indretif == 2) {
            $this->dom->addChild(
                $ideEvento,
                "nrRecibo",
                $this->std->nrrecibo,
                true
            );
        }
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
        $ideproc = $this->dom->createElement("ideProc");
        $this->dom->addChild(
            $ideproc,
            "nrProcTrab",
            $this->std->ideproc->nrproctrab,
            true
        );
        $this->dom->addChild(
            $ideproc,
            "perApurPgto",
            $this->std->ideproc->perapurpgto,
            true
        );
        if (isset($this->std->ideproc->obs) &&
            !empty($this->std->ideproc->obs)){
            $this->dom->addChild(
                $ideproc,
                "obs",
                $this->std->ideproc->obs,
                false
            );
        }
        $this->node->appendChild($ideproc);

        foreach ($this->std->idetrab as $ide) {
            $idetrab = $this->dom->createElement("ideTrab");
            $nodeIdeTrab = $this->node->appendChild($idetrab);
            $nodeIdeTrab->setAttribute("cpfTrab",$ide->cpftrab);
            foreach ($ide->calctrib as $baseCalculo) {
                //Identificação do período e da base de cálculo dos tributos (obrigatório).
                $baseCalculoTributo =$this->dom->createElement("calcTrib");
                $nodeCalcTrib = $this->node->appendChild($baseCalculoTributo);
                $nodeCalcTrib->setAttribute("perRef",$baseCalculo->perref);
                $nodeCalcTrib->setAttribute("vrBcCpMensal",$baseCalculo->vrbccpmensal);
                $nodeCalcTrib->setAttribute("vrBcCp13",$baseCalculo->vrbccp13);
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
                $idetrab->appendChild($baseCalculoTributo);
            }
            if (isset($ide->infocrirrf) &&
                !empty($ide->infocrirrf)) {
                foreach ($ide->infocrirrf as $cr) {
                    $infocrirrf = $this->dom->createElement("infoCRIRRF");
                    $nodeInfoCRIRRF = $this->node->appendChild($infocrirrf);
                    $nodeInfoCRIRRF->setAttribute("tpCR",$cr->tpcr);
                    $nodeInfoCRIRRF->setAttribute("vrCR",$cr->vrcr);
                    if (!empty($cr->infoir)) {
                        $iir = $cr->infoir;
                        $infoir = $this->dom->createElement("infoIR");
                        $nodeinfoir = $this->node->appendChild($infoir);
                        $nodeinfoir->setAttribute("vrRendTrib",$iir->vrrendtrib);
                        $nodeinfoir->setAttribute("vrRendTrib13",$iir->vrrendtrib13);
                        $nodeinfoir->setAttribute("vrRendMoleGrave",$iir->vrrendmolegrave);
                        $nodeinfoir->setAttribute("vrRendIsen65",$iir->vrrendisen65);
                        $nodeinfoir->setAttribute("vrJurosMora",$iir->vrjurosmora);
                        $nodeinfoir->setAttribute("vrRendIsenNTrib",$iir->vrrendisenntrib);
                        if ($iir->vrrendisenntrib > 0) {
                            $nodeinfoir->setAttribute("descIsenNTrib",$iir->descisenntrib);
                        }
                        $nodeinfoir->setAttribute("vrPrevOficial",$iir->vrprevoficial);

                        $infocrirrf->appendChild($infoir);
                    }
                    if (!empty($cr->inforra)) {
                        $rra = $cr->inforra;
                        $inforra = $this->dom->createElement("infoRRA");
                        $nodeinforra = $this->node->appendChild($inforra);
                        $nodeinforra->setAttribute('descRRA', $rra->descrra);
                        $nodeinforra->setAttribute('qtdMesesRRA', $rra->qtdmesesrra);
                        if (!empty($rra->despprocjud)) {
                            $des = $rra->despprocjud;
                            $despprocjud = $this->dom->createElement("despProcJud");
                            $nodedespprocjud = $this->node->appendChild($despprocjud);
                            $nodedespprocjud->setAttribute('vlrDespCustas', $des->vlrdespcustas);
                            $nodedespprocjud->setAttribute('vlrDespAdvogados', $des->vlrdespadvogados);
                            $inforra->appendChild($despprocjud);
                        }
                        if (!empty($rra->ideadv)) {
                            foreach ($rra->ideadv as $adv) {
                                $ideadv = $this->dom->createElement("ideAdv");
                                $nodeideadv = $this->node->appendChild($ideadv);
                                $nodeideadv->setAttribute('tpInsc', $adv->tpinsc);
                                $nodeideadv->setAttribute('nrInsc', $adv->nrinsc);
                                $nodeideadv->setAttribute('vlrAdv', $adv->vlradv);
                                $inforra->appendChild($ideadv);
                            }
                        }
                        $infocrirrf->appendChild($inforra);
                    }
                    if (!empty($cr->deddepen)) {
                        foreach ($cr->deddepen as $ded) {
                            $deddepen = $this->dom->createElement("dedDepen");
                            $nodededdepen = $this->node->appendChild($deddepen);
                            $nodededdepen->setAttribute('tpRend', $ded->tprend);
                            $nodededdepen->setAttribute('cpfDep', $ded->cpfdep);
                            $nodededdepen->setAttribute( 'vlrDeducao', $ded->vlrdeducao);
                            $infocrirrf->appendChild($deddepen);
                        }
                    }
                    if (!empty($cr->penalim)) {
                        foreach ($cr->penalim as $pen) {
                            $penalim = $this->dom->createElement("penAlim");
                            $nodepenalim = $this->node->appendChild($penalim);
                            $nodepenalim->setAttribute('tpRend', $pen->tprend);
                            $nodepenalim->setAttribute('cpfDep', $pen->cpfdep);
                            $nodepenalim->setAttribute('vlrPensao', $pen->vlrpensao);
                            $infocrirrf->appendChild($penalim);
                        }
                    }
                    if (!empty($cr->infoprocret)) {
                        foreach ($cr->infoprocret as $ret) {
                            $infoprocret = $this->dom->createElement("infoProcRet");
                            $nodeinfoprocret = $this->node->appendChild($infoprocret);
                            $nodeinfoprocret->setAttribute('tpProcRet', $ret->tpprocret);
                            $nodeinfoprocret->setAttribute('nrProcRet', $ret->nrprocret);
                            $nodeinfoprocret->setAttribute('codSusp', $ret->codsusp);
                            if (!empty($ret->infovalores)) {
                                foreach ($ret->infovalores as $val) {
                                    $infovalores = $this->dom->createElement("infoValores");
                                    $nodeinfovalores = $this->node->appendChild($infovalores);
                                    $nodeinfovalores->setAttribute('indApuracao', $val->indapuracao);
                                    $nodeinfovalores->setAttribute('vlrNRetido', $val->vlrnretido);
                                    $nodeinfovalores->setAttribute('vlrDepJud', $val->vlrdepjud);
                                    $nodeinfovalores->setAttribute('vlrCmpAnoCal', $val->vlrcmpanocal);
                                    $nodeinfovalores->setAttribute('vlrCmpAnoAnt', $val->vlrcmpanoant);
                                    $nodeinfovalores->setAttribute('vlrRendSusp', $val->vlrrendsusp);
                                    if (!empty($val->dedsusp)) {
                                        foreach ($val->dedsusp as $sus) {
                                            $dedsusp = $this->dom->createElement("dedSusp");
                                            $nodededsusp = $this->node->appendChild($dedsusp);
                                            $nodededsusp->setAttribute(
                                                'indTpDeducao',
                                                $sus->indtpdeducao
                                            );
                                            $nodededsusp->setAttribute($dedsusp, 'vlrDedSusp', $sus->vlrdedsusp);
                                            if (!empty($sus->benefpen)) {
                                                foreach ($sus->benefpen as $ben) {
                                                    $benefpen = $this->dom->createElement("benefPen");
                                                    $nodebenefpen = $this->node->appendChild($benefpen);
                                                    $nodebenefpen->setAttribute('cpfDep', $ben->cpfdep);
                                                    $nodebenefpen->setAttribute(
                                                        'vlrDepenSusp',
                                                        $ben->vlrdepensusp
                                                    );
                                                    $dedsusp->appendChild($benefpen);
                                                }
                                            }
                                            $infovalores->appendChild($dedsusp);
                                        }
                                    }
                                    $infoprocret->appendChild($infovalores);
                                }
                            }
                            $infocrirrf->appendChild($infoprocret);
                        }
                    }
                    $idetrab->appendChild($infocrirrf);
                }
            }
            if (!empty($ide->infoircomplem)) {
                $infoircomplem = $this->dom->createElement("infoIRComplem");
                $nodeinfoircomplem = $this->node->appendChild($infoircomplem);
                $nodeinfoircomplem->setAttribute('dtLaudo', $ide->infoircomplem->dtlaudo);
                if (!empty($ide->infoircomplem->infodep)) {
                    foreach ($ide->infoircomplem->infodep as $dep) {
                        $infodep = $this->dom->createElement("infoDep");
                        $nodeinfodep = $this->node->appendChild($infodep);
                        $nodeinfodep->addAttribute($infodep, 'cpfDep', $dep->cpfdep ?? null);
                        $nodeinfodep->addAttribute($infodep, 'dtNascto', $dep->dtnascto ?? null);
                        $nodeinfodep->addAttribute($infodep, 'nome', $dep->nome ?? null);
                        $nodeinfodep->addAttribute($infodep, 'depIRRF', $dep->depirrf ?? null);
                        $nodeinfodep->addAttribute($infodep, 'tpDep', $dep->tpdep ?? null);
                        $nodeinfodep->addAttribute($infodep, 'descrDep', $dep->descrdep ?? null);
                        $infoircomplem->appendChild($infodep);
                    }
                }
                $idetrab->appendChild($infoircomplem);
            }
        }
        $this->node->appendChild($idetrab);
        //finalização do xml
        $this->eSocial->appendChild($this->node);
        //$this->xml = $this->dom->saveXML($this->eSocial);
        $this->xml = $this->dom->saveXML($this->eSocial);
        // var_dump($this->xml);
        // die();
        $this->sign();
  
    }
}
