<?php

namespace NFePHP\eSocial\Factories\Traits;

trait TraitS2500
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

        $infoProcesso = $this->dom->createElement("infoProcesso");
        $this->dom->addChild(
            $infoProcesso,
            "origem",
            $this->std->infoprocesso->origem,
            true
        );
        $this->dom->addChild(
            $infoProcesso,
            "nrProcTrab",
            $this->std->infoprocesso->nrproctrab,
            true
        );
        $this->dom->addChild(
            $infoProcesso,
            "obsProcTrab",
            $this->std->infoprocesso->obsproctrab,
            false
        );
        $dadosCompl = $this->dom->createElement("dadosCompl");
        $compl = $this->std->infoprocesso->dadoscompl;
        if (isset($compl->infoprocjud)) {
            $infoProcJud = $this->dom->createElement("infoProcJud");
            $this->dom->addChild(
                $infoProcJud,
                "dtSent",
                !empty($compl->infoprocjud->dtsent) ? $compl->infoprocjud->dtsent : null,
                true
            );
            $this->dom->addChild(
                $infoProcJud,
                "ufVara",
                $compl->infoprocjud->ufvara,
                true
            );
            $this->dom->addChild(
                $infoProcJud,
                "codMunic",
                $compl->infoprocjud->codmunic,
                true
            );
            $this->dom->addChild(
                $infoProcJud,
                "idVara",
                $compl->infoprocjud->idvara,
                true
            );
            $dadosCompl->appendChild($infoProcJud);
        }
        if (isset($compl->infoccp)) {
            $infoCCP = $this->dom->createElement("infoCCP");
            $this->dom->addChild(
                $infoCCP,
                "dtCCP",
                !empty($compl->infoccp->dtccp) ? $compl->infoccp->dtccp : null,
                true
            );
            $this->dom->addChild(
                $infoCCP,
                "tpCCP",
                $compl->infoccp->tpccp,
                true
            );
            if (isset($compl->infoccp->cnpjccp) && !empty($compl->infoccp->cnpjccp)) {
                $this->dom->addChild(
                    $infoCCP,
                    "cnpjCCP",
                    $compl->infoccp->cnpjccp,
                    false
                );
            }
            $dadosCompl->appendChild($infoCCP);
        }

        $infoProcesso->appendChild($dadosCompl);
        //Encerra infoProcesso
        $this->node->appendChild($infoProcesso);
        //Inicia idTrab
        $ideTrab = $this->dom->createElement("ideTrab");
        $trabalhador = $this->std->idetrab;
        $this->dom->addChild(
            $ideTrab,
            "cpfTrab",
            $trabalhador->cpftrab,
            true
        );
        if (isset($trabalhador->nmtrab)) {
            $this->dom->addChild(
                $ideTrab,
                "nmTrab",
                $trabalhador->nmtrab,
                false
            );
        }
        if (isset($trabalhador->dtnascto) && !empty($trabalhador->dtnascto)) {
            $this->dom->addChild(
                $ideTrab,
                "dtNascto",
                !empty($trabalhador->dtnascto) ? $trabalhador->dtnascto : null,
                false
            );
        }
        if (isset($this->std->idetrab->dependente) &&
            !empty($this->std->idetrab->dependente)) {
            foreach ($this->std->idetrab->dependente as $dep) {
                $dependente = $this->dom->createElement("dependente");
                $this->dom->addChild(
                    $dependente,
                    "cpfDep",
                    $dep->cpfdep,
                    true
                );
                $this->dom->addChild(
                    $dependente,
                    "tpDep",
                    $dep->tpdep,
                    true
                );
                if (isset($dep->descpep)) {
                    $this->dom->addChild(
                        $dependente,
                        "descDep",
                        $dep->descpep,
                        false
                    );
                }
                $ideTrab->appendChild($dependente);
            }
        }

        foreach ($this->std->idetrab->infocontr as $info) {
            $infoContr = $this->dom->createElement("infoContr");
            $this->dom->addChild(
                $infoContr,
                "tpContr",
                $info->tpcontr,
                true
            );
            $this->dom->addChild(
                $infoContr,
                "indContr",
                $info->indcontr,
                true
            );
            $this->dom->addChild(
                $infoContr,
                "dtAdmOrig",
                !empty($info->dtadmorig) ? $info->dtadmorig : null,
                false
            );
            if (isset($info->indreint)) {
                $this->dom->addChild(
                    $infoContr,
                    "indReint",
                    $info->indreint,
                    false
                );
            }
            $this->dom->addChild(
                $infoContr,
                "indCateg",
                $info->indcateg,
                true
            );
            $this->dom->addChild(
                $infoContr,
                "indNatAtiv",
                $info->indnatativ,
                true
            );
            $this->dom->addChild(
                $infoContr,
                "indMotDeslig",
                $info->indmotdeslig,
                true
            );
            $this->dom->addChild(
                $infoContr,
                "indUnic",
                $info->indunic,
                false
            );
            if (isset($info->matricula)) {
                $this->dom->addChild(
                    $infoContr,
                    "matricula",
                    $info->matricula,
                    false
                );
            }
            if (isset($info->codcateg)) {
                $this->dom->addChild(
                    $infoContr,
                    "codCateg",
                    $info->codcateg,
                    false
                );
            }
            $this->dom->addChild(
                $infoContr,
                "dtInicio",
                !empty($info->dtinicio) ? $info->dtinicio : null,
                false
            );
            $ideTrab->appendChild($infoContr);
            
            if (isset($info->infocompl) && !empty($info->infocompl)) {
                $infoCompl = $this->dom->createElement("infoCompl");
                $compl = $info->infocompl;
                if (isset($compl->codcbo)) {
                    $this->dom->addChild(
                        $infoCompl,
                        "codCBO",
                        $compl->codcbo,
                        false
                    );
                }
                if (isset($compl->natatividade) && !empty($compl->natatividade)) {
                    if ((int) $compl->natatividade > 0) {
                        $this->dom->addChild(
                            $infoCompl,
                            "natAtividade",
                            $compl->natatividade,
                            false
                        );
                    }
                }
                $infoContr->appendChild($infoCompl);
            }
            if (isset($info->infocompl)) {
                if (isset($info->infocompl->remuneracao) &&
                    !empty($info->infocompl->remuneracao)) {
                    foreach ($info->infocompl->remuneracao as $remunera) {
                        $remuneracao = $this->dom->createElement("remuneracao");
                        $this->dom->addChild(
                            $remuneracao,
                            "dtRemun",
                            $remunera->dtremun,
                            true
                        );
                        $this->dom->addChild(
                            $remuneracao,
                            "vrSalFx",
                            $remunera->vrsalfx,
                            true
                        );
                        $this->dom->addChild(
                            $remuneracao,
                            "undSalFixo",
                            $remunera->undsalfixo,
                            true
                        );
                        if (isset($remunera->dscsalvar)) {
                            $this->dom->addChild(
                                $remuneracao,
                                "dscSalVar",
                                $remunera->dscsalvar,
                                false
                            );
                        }
                    }
                    $infoCompl->appendChild($remuneracao);
                }
            }
            if (isset($info->infocompl)) {
                if (isset($info->infocompl->infovinc)) {
                    $vinculo = $info->infocompl->infovinc;
                    $informacaoVinculo = $this->dom->createElement("infoVinc");
                    $this->dom->addChild(
                        $informacaoVinculo,
                        "tpRegTrab",
                        $vinculo->tpregtrab,
                        true
                    );
                    $this->dom->addChild(
                        $informacaoVinculo,
                        "tpRegPrev",
                        $vinculo->tpregprev,
                        true
                    );
                    $this->dom->addChild(
                        $informacaoVinculo,
                        "dtAdm",
                        $vinculo->dtadm,
                        true
                    );
                    if (isset($vinculo->tmpparc) && !empty($vinculo->tmpparc)) {
                        $this->dom->addChild(
                            $informacaoVinculo,
                            "tmpParc",
                            $vinculo->tmpparc,
                            false
                        );
                    }
                    $infoCompl->appendChild($informacaoVinculo);
                }
                if (isset($info->infocompl->infovinc)) {
                    if (isset($info->infocompl->infovinc)) {
                        if (isset($info->infocompl->infovinc->duracao)) {
                            $duracao = $info->infocompl->infovinc->duracao;
                            $duracaoContrato = $this->dom->createElement("duracao");
                            $this->dom->addChild(
                                $duracaoContrato,
                                "tpContr",
                                $duracao->tpcontr,
                                true
                            );
                            if (isset($duracao->dtterm) && !empty($duracao->dtterm)) {
                                $this->dom->addChild(
                                    $duracaoContrato,
                                    "dtTerm",
                                    $duracao->dtterm,
                                    false
                                );
                            }
                            if (isset($duracao->clauassec) && !empty($duracao->clauassec)) {
                                $this->dom->addChild(
                                    $duracaoContrato,
                                    "clauAssec",
                                    $duracao->clauassec,
                                    false
                                );
                            }
                            if (isset($duracao->objdet) && !empty($duracao->objdet)) {
                                $this->dom->addChild(
                                    $duracaoContrato,
                                    "objDet",
                                    $duracao->objdet,
                                    false
                                );
                            }
                            $informacaoVinculo->appendChild($duracaoContrato);
                        }
                    }
                }
            }
            if (isset($info->infocompl->infovinc->observacoes) &&
                !empty($info->infocompl->infovinc->observacoes)) {
                foreach ($info->infocompl->infovinc->observacoes as $observacao) {
                    $observacoes = $this->dom->createElement("observacoes");
                    $this->dom->addChild(
                        $observacoes,
                        "observacao",
                        $observacao->observacao,
                        true
                    );
                }
                $informacaoVinculo->appendChild($observacoes);
            }

            if (isset($info->infocompl->infovinc)) {
                if (isset($info->infocompl->infovinc->sucessaovinc)) {
                    $sucessaoVinculo = $info->infocompl->infovinc->sucessaovinc;
                    $sucessaoVinculoTrabalhista = $this->dom->createElement("sucessaoVinc");
                    $this->dom->addChild(
                        $sucessaoVinculoTrabalhista,
                        "tpInsc",
                        $sucessaoVinculo->tpinsc,
                        true
                    );
                    $this->dom->addChild(
                        $sucessaoVinculoTrabalhista,
                        "nrInsc",
                        $sucessaoVinculo->nrinsc,
                        true
                    );
                    if (isset($sucessaoVinculo->matricant) && !empty($sucessaoVinculo->matricant)) {
                        $this->dom->addChild(
                            $sucessaoVinculoTrabalhista,
                            "matricAnt",
                            $sucessaoVinculo->matricant,
                            false
                        );
                    }
                    $this->dom->addChild(
                        $sucessaoVinculoTrabalhista,
                        "dtTransf",
                        $sucessaoVinculo->dttransf,
                        true
                    );
                    $informacaoVinculo->appendChild($sucessaoVinculoTrabalhista);
                }
                if (isset($info->infocompl->infovinc->infodeslig)) {
                    $infoDesligamento = $info->infocompl->infovinc->infodeslig;

                    $informacaoDesligamento = $this->dom->createElement("infoDeslig");
                    $this->dom->addChild(
                        $informacaoDesligamento,
                        "dtDeslig",
                        $infoDesligamento->dtdeslig,
                        true
                    );
                    $this->dom->addChild(
                        $informacaoDesligamento,
                        "mtvDeslig",
                        $infoDesligamento->mtvdeslig,
                        true
                    );
                    if (isset($infoDesligamento->dtprojfimapi) && !empty($infoDesligamento->dtprojfimapi)) {
                        $this->dom->addChild(
                            $informacaoDesligamento,
                            "dtProjFimAPI",
                            $infoDesligamento->dtprojfimapi,
                            false
                        );
                    }
                    $informacaoVinculo->appendChild($informacaoDesligamento);
                }
            }
            if (isset($info->infocompl)) {
                if (isset($info->infocompl->infoterm)) {
                    $termino = $info->infocompl->infoterm;
                    $terminoTSVE = $this->dom->createElement("infoTerm");
                    $this->dom->addChild(
                        $terminoTSVE,
                        "dtTerm",
                        $termino->dtterm,
                        true
                    );
                    if (isset($termino->mtvdesligtsv) && !empty($termino->mtvdesligtsv)) {
                        $this->dom->addChild(
                            $terminoTSVE,
                            "mtvDesligTSV",
                            $$termino->mtvdesligtsv,
                            false
                        );
                    }
                    $infoCompl->appendChild($terminoTSVE);
                }
            }
            if (isset($info->mudcategativ) && !empty($info->mudcategativ)) {
                $mudancaCategoria = $this->dom->createElement("mudCategAtiv");
                foreach ($info->mudcategativ as $mudanca) {
                    $this->dom->addChild(
                        $mudancaCategoria,
                        "codCateg",
                        $mudanca->codcateg,
                        true
                    );
                    if (isset($mudanca->natatividade) && !empty($mudanca->natatividade)) {
                        if ((int) $mudanca->natatividade > 0) {
                            $this->dom->addChild(
                                $mudancaCategoria,
                                "natAtividade",
                                $mudanca->natatividade,
                                false
                            );
                        }
                    }             
                    $this->dom->addChild(
                        $mudancaCategoria,
                        "dtMudCategAtiv",
                        $mudanca->dtmudcategativ,
                        true
                    );
                }
                $infoContr->appendChild($mudancaCategoria);
            }
            if (isset($info->uniccontr) && !empty($info->uniccontr)) {
                $reconhecimentoUnicidade = $this->dom->createElement("unicContr");
                foreach ($info->uniccontr as $unicidade) {
                    if (isset($unicidade->matunic) && !empty($unicidade->matunic)) {
                        $this->dom->addChild(
                            $reconhecimentoUnicidade,
                            "matUnic",
                            $unicidade->matunic,
                            false
                        );
                    }
                    if (isset($unicidade->codcateg) && !empty($unicidade->codcateg)) {
                        $this->dom->addChild(
                            $reconhecimentoUnicidade,
                            "codCateg",
                            $unicidade->codcateg,
                            false
                        );
                    }
                    if (isset($unicidade->dtinicio) && !empty($unicidade->dtinicio)) {
                        $this->dom->addChild(
                            $reconhecimentoUnicidade,
                            "dtInicio",
                            $unicidade->dtinicio,
                            false
                        );
                    }
                }
                $infoContr->appendChild($reconhecimentoUnicidade);
            }
            if (isset($info->ideestab)) {
                $identificacaoEstabelcimento = $this->dom->createElement("ideEstab");
                $this->dom->addChild(
                    $identificacaoEstabelcimento,
                    "tpInsc",
                    $info->ideestab->tpinsc,
                    true
                );
                $this->dom->addChild(
                    $identificacaoEstabelcimento,
                    "nrInsc",
                    $info->ideestab->nrinsc,
                    true
                );
                $infoContr->appendChild($identificacaoEstabelcimento);
            }
            if (isset($info->ideestab->infovlr)) {
                $informacoesValores = $this->dom->createElement("infoVlr");
                $this->dom->addChild(
                    $informacoesValores,
                    "compIni",
                    $info->ideestab->infovlr->compini,
                    true
                );
                $this->dom->addChild(
                    $informacoesValores,
                    "compFim",
                    $info->ideestab->infovlr->compfim,
                    true
                );
                $this->dom->addChild(
                    $informacoesValores,
                    "indReperc",
                    $info->ideestab->infovlr->indreperc,
                    true
                );
                $this->dom->addChild(
                    $informacoesValores,
                    "vrRemun",
                    $info->ideestab->infovlr->vrremun,
                    true
                );
                $this->dom->addChild(
                    $informacoesValores,
                    "vrAPI",
                    $info->ideestab->infovlr->vrapi,
                    true
                );
                $this->dom->addChild(
                    $informacoesValores,
                    "vr13API",
                    $info->ideestab->infovlr->vr13api,
                    true
                );
                $this->dom->addChild(
                    $informacoesValores,
                    "vrInden",
                    $info->ideestab->infovlr->vrinden,
                    true
                );
                if (isset($info->ideestab->infovlr->vrbaseindenfgts)) {
                    $this->dom->addChild(
                        $informacoesValores,
                        "vrBaseIndenFGTS",
                        $info->ideestab->infovlr->vrbaseindenfgts,
                        false
                    );
                }
                if (isset($info->ideestab->infovlr->pagdiretoresc)) {
                    $this->dom->addChild(
                        $informacoesValores,
                        "pagDiretoResc",
                        $info->ideestab->infovlr->pagdiretoresc,
                        false
                    );
                }
                $identificacaoEstabelcimento->appendChild($informacoesValores);
            }
            if (isset($info->ideestab->infovlr->ideperiodo) &&
                !empty($info->ideestab->infovlr->ideperiodo)) {
                foreach ($info->ideestab->infovlr->ideperiodo as $periodo) {
                    $periodoBase = $this->dom->createElement("idePeriodo");
                    $this->dom->addChild(
                        $periodoBase,
                        "perRef",
                        $periodo->perref,
                        true
                    );
                    if (isset($periodo->basecalculo->vrbccpmensal)) {
                        $periodoBaseCalculo = $this->dom->createElement("baseCalculo");
                        $this->dom->addChild(
                            $periodoBaseCalculo,
                            "vrBcCpMensal",
                            $periodo->basecalculo->vrbccpmensal,
                            true
                        );
                        $this->dom->addChild(
                            $periodoBaseCalculo,
                            "vrBcCp13",
                            $periodo->basecalculo->vrbccp13,
                            true
                        );
                        $this->dom->addChild(
                            $periodoBaseCalculo,
                            "vrBcFgts",
                            $periodo->basecalculo->vrbcfgts,
                            true
                        );
                        $this->dom->addChild(
                            $periodoBaseCalculo,
                            "vrBcFgts13",
                            $periodo->basecalculo->vrbcfgts13,
                            true
                        );
                        $periodoBase->appendChild($periodoBaseCalculo);
                        if (isset($periodo->basecalculo->infoagnocivo)) {
                            $periodoBaseCalculoAgenteNocivo = $this->dom->createElement("infoAgNocivo");
                            $this->dom->addChild(
                                $periodoBaseCalculoAgenteNocivo,
                                "grauExp",
                                $periodo->basecalculo->infoagnocivo->grauexp,
                                true
                            );
                            $periodoBaseCalculo->appendChild($periodoBaseCalculoAgenteNocivo);
                        }
                    }
                    if (isset($periodo->infofgts)) {
                        $periodoFgts = $this->dom->createElement("infoFGTS");
                        $this->dom->addChild(
                            $periodoFgts,
                            "vrBcFgtsGuia",
                            $periodo->infofgts->vrbcfgtsguia,
                            true
                        );
                        $this->dom->addChild(
                            $periodoFgts,
                            "vrBcFgts13Guia",
                            $periodo->infofgts->vrbcfgtsguia,
                            true
                        );
                        $this->dom->addChild(
                            $periodoFgts,
                            "pagDireto",
                            $periodo->infofgts->pagdireto,
                            true
                        );
                        $periodoBase->appendChild($periodoFgts);
                        if (isset($periodo->baseMudCateg) &&
                            (!empty($periodo->baseMudCateg->codCateg) ||
                            !empty($periodo->baseMudCateg->vrBcCPrev))) {
                            $periodoBasePrevidenciaria = $this->dom->createElement("baseMudCateg");
                            $this->dom->addChild(
                                $periodoBasePrevidenciaria,
                                "codCateg",
                                $periodo->basemudCateg->codcateg,
                                true
                            );
                            $this->dom->addChild(
                                $periodoBasePrevidenciaria,
                                "vrBcCPrev",
                                $periodo->basemudCateg->vrbccprev,
                                true
                            );
                            $periodoFgts->appendChild($periodoBasePrevidenciaria);
                        }
                    }
                    $informacoesValores->appendChild($periodoBase);
                }
            }
        } 
        //Finaliza idTrab
        $this->node->appendChild($ideTrab);

        //finalização do xml
        $this->eSocial->appendChild($this->node);
        //$this->xml = $this->dom->saveXML($this->eSocial);;
        $this->sign();
        
    }

    /**
     * builder for version S.1.2.0
     */
    protected function toNodeS120()
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

        $infoProcesso = $this->dom->createElement("infoProcesso");
        $this->dom->addChild(
            $infoProcesso,
            "origem",
            $this->std->infoprocesso->origem,
            true
        );
        $this->dom->addChild(
            $infoProcesso,
            "nrProcTrab",
            $this->std->infoprocesso->nrproctrab,
            true
        );
        $this->dom->addChild(
            $infoProcesso,
            "obsProcTrab",
            $this->std->infoprocesso->obsproctrab,
            false
        );
        $dadosCompl = $this->dom->createElement("dadosCompl");
        $compl = $this->std->infoprocesso->dadoscompl;
        if (isset($compl->infoprocjud)) {
            $infoProcJud = $this->dom->createElement("infoProcJud");
            $this->dom->addChild(
                $infoProcJud,
                "dtSent",
                !empty($compl->infoprocjud->dtsent) ? $compl->infoprocjud->dtsent : null,
                true
            );
            $this->dom->addChild(
                $infoProcJud,
                "ufVara",
                $compl->infoprocjud->ufvara,
                true
            );
            $this->dom->addChild(
                $infoProcJud,
                "codMunic",
                $compl->infoprocjud->codmunic,
                true
            );
            $this->dom->addChild(
                $infoProcJud,
                "idVara",
                $compl->infoprocjud->idvara,
                true
            );
            $dadosCompl->appendChild($infoProcJud);
        }
        if (isset($compl->infoccp)) {
            $infoCCP = $this->dom->createElement("infoCCP");
            $this->dom->addChild(
                $infoCCP,
                "dtCCP",
                !empty($compl->infoccp->dtccp) ? $compl->infoccp->dtccp : null,
                true
            );
            $this->dom->addChild(
                $infoCCP,
                "tpCCP",
                $compl->infoccp->tpccp,
                true
            );
            if (isset($compl->infoccp->cnpjccp) && !empty($compl->infoccp->cnpjccp)) {
                $this->dom->addChild(
                    $infoCCP,
                    "cnpjCCP",
                    $compl->infoccp->cnpjccp,
                    false
                );
            }
            $dadosCompl->appendChild($infoCCP);
        }

        $infoProcesso->appendChild($dadosCompl);
        //Encerra infoProcesso
        $this->node->appendChild($infoProcesso);
        //Inicia idTrab
        $ideTrab = $this->dom->createElement("ideTrab");
        $trabalhador = $this->std->idetrab;
        $this->dom->addChild(
            $ideTrab,
            "cpfTrab",
            $trabalhador->cpftrab,
            true
        );
        if (isset($trabalhador->nmtrab)) {
            $this->dom->addChild(
                $ideTrab,
                "nmTrab",
                $trabalhador->nmtrab,
                false
            );
        }
        if (isset($trabalhador->dtnascto) && !empty($trabalhador->dtnascto)) {
            $this->dom->addChild(
                $ideTrab,
                "dtNascto",
                !empty($trabalhador->dtnascto) ? $trabalhador->dtnascto : null,
                false
            );
        }

        foreach ($this->std->idetrab->infocontr as $info) {
            $infoContr = $this->dom->createElement("infoContr");
            $this->dom->addChild(
                $infoContr,
                "tpContr",
                $info->tpcontr,
                true
            );
            $this->dom->addChild(
                $infoContr,
                "indContr",
                $info->indcontr,
                true
            );
            $this->dom->addChild(
                $infoContr,
                "dtAdmOrig",
                !empty($info->dtadmorig) ? $info->dtadmorig : null,
                false
            );
            if (isset($info->indreint) && !empty($info->indreint)) {
                $this->dom->addChild(
                    $infoContr,
                    "indReint",
                    $info->indreint,
                    false
                );
            }
            $this->dom->addChild(
                $infoContr,
                "indCateg",
                $info->indcateg,
                true
            );
            $this->dom->addChild(
                $infoContr,
                "indNatAtiv",
                $info->indnatativ,
                true
            );
            $this->dom->addChild(
                $infoContr,
                "indMotDeslig",
                $info->indmotdeslig,
                true
            );
            if (isset($info->matricula) && !empty($info->matricula)) {
                $this->dom->addChild(
                    $infoContr,
                    "matricula",
                    $info->matricula,
                    false
                );
            }
            if (isset($info->codcateg) && !empty($info->codcateg)) {
                $this->dom->addChild(
                    $infoContr,
                    "codCateg",
                    $info->codcateg,
                    false
                );
            }
            $this->dom->addChild(
                $infoContr,
                "dtInicio",
                !empty($info->dtinicio) ? $info->dtinicio : null,
                false
            );
            $ideTrab->appendChild($infoContr);
            
            if (isset($info->infocompl) && !empty($info->infocompl)) {
                $infoCompl = $this->dom->createElement("infoCompl");
                $compl = $info->infocompl;
                if (isset($compl->codcbo) && !empty($compl->codcbo)) {
                    $this->dom->addChild(
                        $infoCompl,
                        "codCBO",
                        $compl->codcbo,
                        false
                    );
                }
                if (isset($compl->natatividade) && !empty($compl->natatividade)) {
                    if ((int) $compl->natatividade > 0) {
                        $this->dom->addChild(
                            $infoCompl,
                            "natAtividade",
                            $compl->natatividade,
                            false
                        );
                    }
                }
                $infoContr->appendChild($infoCompl);
            }
            if (isset($info->infocompl)) {
                if (isset($info->infocompl->remuneracao) &&
                    !empty($info->infocompl->remuneracao)) {
                    foreach ($info->infocompl->remuneracao as $remunera) {
                        $remuneracao = $this->dom->createElement("remuneracao");
                        $this->dom->addChild(
                            $remuneracao,
                            "dtRemun",
                            $remunera->dtremun,
                            true
                        );
                        $this->dom->addChild(
                            $remuneracao,
                            "vrSalFx",
                            $remunera->vrsalfx,
                            true
                        );
                        $this->dom->addChild(
                            $remuneracao,
                            "undSalFixo",
                            $remunera->undsalfixo,
                            true
                        );
                        if (isset($remunera->dscsalvar) && !empty($remunera->dscsalvar)) {
                            $this->dom->addChild(
                                $remuneracao,
                                "dscSalVar",
                                $remunera->dscsalvar,
                                false
                            );
                        }
                    }
                    $infoCompl->appendChild($remuneracao);
                }
            }
            if (isset($info->infocompl)) {
                if (isset($info->infocompl->infovinc)) {
                    $vinculo = $info->infocompl->infovinc;
                    $informacaoVinculo = $this->dom->createElement("infoVinc");
                    $this->dom->addChild(
                        $informacaoVinculo,
                        "tpRegTrab",
                        $vinculo->tpregtrab,
                        true
                    );
                    $this->dom->addChild(
                        $informacaoVinculo,
                        "tpRegPrev",
                        $vinculo->tpregprev,
                        true
                    );
                    $this->dom->addChild(
                        $informacaoVinculo,
                        "dtAdm",
                        $vinculo->dtadm,
                        true
                    );
                    if (isset($vinculo->tmpparc) && !empty($vinculo->tmpparc)) {
                        $this->dom->addChild(
                            $informacaoVinculo,
                            "tmpParc",
                            $vinculo->tmpparc,
                            false
                        );
                    }
                    $infoCompl->appendChild($informacaoVinculo);
                }
                if (isset($info->infocompl->infovinc)) {
                    if (isset($info->infocompl->infovinc)) {
                        if (isset($info->infocompl->infovinc->duracao)) {
                            $duracao = $info->infocompl->infovinc->duracao;
                            $duracaoContrato = $this->dom->createElement("duracao");
                            $this->dom->addChild(
                                $duracaoContrato,
                                "tpContr",
                                $duracao->tpcontr,
                                true
                            );
                            if (isset($duracao->dtterm) && !empty($duracao->dtterm)) {
                                $this->dom->addChild(
                                    $duracaoContrato,
                                    "dtTerm",
                                    $duracao->dtterm,
                                    false
                                );
                            }
                            if (isset($duracao->clauassec) && !empty($duracao->clauassec)) {
                                $this->dom->addChild(
                                    $duracaoContrato,
                                    "clauAssec",
                                    $duracao->clauassec,
                                    false
                                );
                            }
                            if (isset($duracao->objdet) && !empty($duracao->objdet)) {
                                $this->dom->addChild(
                                    $duracaoContrato,
                                    "objDet",
                                    $duracao->objdet,
                                    false
                                );
                            }
                            $informacaoVinculo->appendChild($duracaoContrato);
                        }
                    }
                }
            }
            if (isset($info->infocompl->infovinc->observacoes) &&
                !empty($info->infocompl->infovinc->observacoes)) {
                foreach ($info->infocompl->infovinc->observacoes as $observacao) {
                    $observacoes = $this->dom->createElement("observacoes");
                    $this->dom->addChild(
                        $observacoes,
                        "observacao",
                        $observacao->observacao,
                        true
                    );
                }
                $informacaoVinculo->appendChild($observacoes);
            }
            if (isset($info->infocompl->infovinc)) {
                if (isset($info->infocompl->infovinc->sucessaovinc)) {
                    $sucessaoVinculo = $info->infocompl->infovinc->sucessaovinc;
                    $sucessaoVinculoTrabalhista = $this->dom->createElement("sucessaoVinc");
                    $this->dom->addChild(
                        $sucessaoVinculoTrabalhista,
                        "tpInsc",
                        $sucessaoVinculo->tpinsc,
                        true
                    );
                    $this->dom->addChild(
                        $sucessaoVinculoTrabalhista,
                        "nrInsc",
                        $sucessaoVinculo->nrinsc,
                        true
                    );
                    if (isset($sucessaoVinculo->matricant) && !empty($sucessaoVinculo->matricant)) {
                        $this->dom->addChild(
                            $sucessaoVinculoTrabalhista,
                            "matricAnt",
                            $sucessaoVinculo->matricant,
                            false
                        );
                    }
                    $this->dom->addChild(
                        $sucessaoVinculoTrabalhista,
                        "dtTransf",
                        $sucessaoVinculo->dttransf,
                        true
                    );
                    $informacaoVinculo->appendChild($sucessaoVinculoTrabalhista);
                }
                if (isset($info->infocompl->infovinc->infodeslig)) {
                    $infoDesligamento = $info->infocompl->infovinc->infodeslig;
                    $informacaoDesligamento = $this->dom->createElement("infoDeslig");
                    $this->dom->addChild(
                        $informacaoDesligamento,
                        "dtDeslig",
                        $infoDesligamento->dtdeslig,
                        true
                    );
                    $this->dom->addChild(
                        $informacaoDesligamento,
                        "mtvDeslig",
                        $infoDesligamento->mtvdeslig,
                        true
                    );
                    if (isset($infoDesligamento->dtprojfimapi) && !empty($infoDesligamento->dtprojfimapi)) {
                        $this->dom->addChild(
                            $informacaoDesligamento,
                            "dtProjFimAPI",
                            $infoDesligamento->dtprojfimapi,
                            false
                        );
                    }
                    if (isset($infoDesligamento->pensalim) && !empty($infoDesligamento->pensalim)) {
                        $this->dom->addChild(
                            $informacaoDesligamento,
                            "pensAlim",
                            $infoDesligamento->pensalim,
                            false
                        );
                    }
                    if (isset($infoDesligamento->percaliment) && !empty($infoDesligamento->percaliment)) {
                        $this->dom->addChild(
                            $informacaoDesligamento,
                            "percAliment",
                            $infoDesligamento->percaliment,
                            false
                        );
                    }
                    if (isset($infoDesligamento->vralim) && !empty($infoDesligamento->vralim)) {
                        $this->dom->addChild(
                            $informacaoDesligamento,
                            "vrAlim",
                            $infoDesligamento->vralim,
                            false
                        );
                    }
                    $informacaoVinculo->appendChild($informacaoDesligamento);
                }
            }
            if (isset($info->infocompl)) {
                if (isset($info->infocompl->infoterm)) {
                    $termino = $info->infocompl->infoterm;
                    $terminoTSVE = $this->dom->createElement("infoTerm");
                    $this->dom->addChild(
                        $terminoTSVE,
                        "dtTerm",
                        $termino->dtterm,
                        true
                    );
                    if (isset($termino->mtvdesligtsv) && !empty($termino->mtvdesligtsv)) {
                        $this->dom->addChild(
                            $terminoTSVE,
                            "mtvDesligTSV",
                            $$termino->mtvdesligtsv,
                            false
                        );
                    }
                    $infoCompl->appendChild($terminoTSVE);
                }
            }
            if (isset($info->mudcategativ) && !empty($info->mudcategativ)) {
                $mudancaCategoria = $this->dom->createElement("mudCategAtiv");
                foreach ($info->mudcategativ as $mudanca) {
                    $this->dom->addChild(
                        $mudancaCategoria,
                        "codCateg",
                        $mudanca->codcateg,
                        true
                    );
                    if (isset($mudanca->natatividade) && !empty($mudanca->natatividade)) {
                        if ((int) $mudanca->natatividade > 0) {
                            $this->dom->addChild(
                                $mudancaCategoria,
                                "natAtividade",
                                $mudanca->natatividade,
                                false
                            );
                        }
                    }
                    $this->dom->addChild(
                        $mudancaCategoria,
                        "dtMudCategAtiv",
                        $mudanca->dtmudcategativ,
                        true
                    );
                }
                $infoContr->appendChild($mudancaCategoria);
            }
            if (isset($info->uniccontr) && !empty($info->uniccontr)) {
                $reconhecimentoUnicidade = $this->dom->createElement("unicContr");
                foreach ($info->uniccontr as $unicidade) {
                    if (isset($unicidade->matunic) && !empty($unicidade->matunic)) {
                        $this->dom->addChild(
                            $reconhecimentoUnicidade,
                            "matUnic",
                            $unicidade->matunic,
                            false
                        );
                    }
                    if (isset($unicidade->codcateg) && !empty($unicidade->codcateg)) {
                        $this->dom->addChild(
                            $reconhecimentoUnicidade,
                            "codCateg",
                            $unicidade->codcateg,
                            false
                        );
                    }
                    if (isset($unicidade->dtinicio) && !empty($unicidade->dtinicio)) {
                        $this->dom->addChild(
                            $reconhecimentoUnicidade,
                            "dtInicio",
                            $unicidade->dtinicio,
                            false
                        );
                    }
                }
                $infoContr->appendChild($reconhecimentoUnicidade);
            }
            if (isset($info->ideestab)) {
                $identificacaoEstabelcimento = $this->dom->createElement("ideEstab");
                $this->dom->addChild(
                    $identificacaoEstabelcimento,
                    "tpInsc",
                    $info->ideestab->tpinsc,
                    true
                );
                $this->dom->addChild(
                    $identificacaoEstabelcimento,
                    "nrInsc",
                    $info->ideestab->nrinsc,
                    true
                );
                $infoContr->appendChild($identificacaoEstabelcimento);
            }
            if (isset($info->ideestab->infovlr)) {
                $informacoesValores = $this->dom->createElement("infoVlr");
                $this->dom->addChild(
                    $informacoesValores,
                    "compIni",
                    $info->ideestab->infovlr->compini,
                    true
                );
                $this->dom->addChild(
                    $informacoesValores,
                    "compFim",
                    $info->ideestab->infovlr->compfim,
                    true
                );
                $this->dom->addChild(
                    $informacoesValores,
                    "indReperc",
                    $info->ideestab->infovlr->indreperc,
                    true
                );
                if (isset($info->ideestab->infovlr->indensd) && !empty($info->ideestab->infovlr->indensd)) {
                    $this->dom->addChild(
                        $informacoesValores,
                        "indenSD",
                        $info->ideestab->infovlr->indensd,
                        false
                    );
                }
                if (isset($info->ideestab->infovlr->indenabono) && !empty($info->ideestab->infovlr->indenabono)) {
                    $this->dom->addChild(
                        $informacoesValores,
                        "indenAbono",
                        $info->ideestab->infovlr->indenabono,
                        false
                    );
                }
                $identificacaoEstabelcimento->appendChild($informacoesValores);
            }
            if (isset($info->ideestab->infovlr->abono) &&
                !empty($info->ideestab->infovlr->abono)) {
                foreach ($info->ideestab->infovlr->abono as $abono) {
                    $abonos = $this->dom->createElement("abono");
                    $this->dom->addChild(
                        $abonos,
                        "anoBase",
                        $abono->anobase,
                        true
                    );
                }
                $informacoesValores->appendChild($abonos);
            }
            if (isset($info->ideestab->infovlr->ideperiodo) &&
                !empty($info->ideestab->infovlr->ideperiodo)) {
                foreach ($info->ideestab->infovlr->ideperiodo as $periodo) {
                    $periodoBase = $this->dom->createElement("idePeriodo");
                    $this->dom->addChild(
                        $periodoBase,
                        "perRef",
                        $periodo->perref,
                        true
                    );
                    if (isset($periodo->basecalculo->vrbccpmensal)) {
                        $periodoBaseCalculo = $this->dom->createElement("baseCalculo");
                        $this->dom->addChild(
                            $periodoBaseCalculo,
                            "vrBcCpMensal",
                            $periodo->basecalculo->vrbccpmensal,
                            true
                        );
                        if (isset($periodo->basecalculo->vrbccp13) && !empty($periodo->basecalculo->vrbccp13)) {
                            $this->dom->addChild(
                                $periodoBaseCalculo,
                                "vrBcCp13",
                                $periodo->basecalculo->vrbccp13,
                                false
                            );
                        }
                        $periodoBase->appendChild($periodoBaseCalculo);
                        if (isset($periodo->basecalculo->infoagnocivo) && !empty($periodo->basecalculo->infoagnocivo)) {
                            $periodoBaseCalculoAgenteNocivo = $this->dom->createElement("infoAgNocivo");
                            $this->dom->addChild(
                                $periodoBaseCalculoAgenteNocivo,
                                "grauExp",
                                $periodo->basecalculo->infoagnocivo->grauexp,
                                true
                            );
                            $periodoBaseCalculo->appendChild($periodoBaseCalculoAgenteNocivo);
                        }
                    }
                    if (isset($periodo->infofgts)) {
                        $periodoFgts = $this->dom->createElement("infoFGTS");
                        $this->dom->addChild(
                            $periodoFgts,
                            "vrBcFGTSProcTrab",
                            $periodo->infofgts->vrbcfgtsproctrab,
                            true
                        );
                        if (isset($periodo->infofgts->vrbcfgtssefip) && !empty($periodo->infofgts->vrbcfgtssefip)) {
                            $this->dom->addChild(
                                $periodoFgts,
                                "vrBcFGTSSefip",
                                $periodo->infofgts->vrbcfgtssefip,
                                false
                            );
                        }
                        if (isset($periodo->infofgts->vrbcfgtsdecant) && !empty($periodo->infofgts->vrbcfgtsdecant)) {
                            $this->dom->addChild(
                                $periodoFgts,
                                "vrBcFGTSDecAnt",
                                $periodo->infofgts->vrbcfgtsdecant,
                                false
                            );
                        }
                        $periodoBase->appendChild($periodoFgts);
                        if (isset($periodo->baseMudCateg) &&
                            (!empty($periodo->baseMudCateg->codCateg) ||
                            !empty($periodo->baseMudCateg->vrBcCPrev))) {
                            $periodoBasePrevidenciaria = $this->dom->createElement("baseMudCateg");
                            $this->dom->addChild(
                                $periodoBasePrevidenciaria,
                                "codCateg",
                                $periodo->basemudCateg->codcateg,
                                true
                            );
                            $this->dom->addChild(
                                $periodoBasePrevidenciaria,
                                "vrBcCPrev",
                                $periodo->basemudCateg->vrbccprev,
                                true
                            );
                            $periodoFgts->appendChild($periodoBasePrevidenciaria);
                        }
                    }
                    $informacoesValores->appendChild($periodoBase);
                }
            }
        } 
        //Finaliza idTrab
        $this->node->appendChild($ideTrab);

        //finalização do xml
        $this->eSocial->appendChild($this->node);
        // $this->xml = $this->dom->saveXML($this->eSocial);
        $this->sign();
        
    }
}
