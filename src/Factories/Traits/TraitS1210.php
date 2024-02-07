<?php

namespace NFePHP\eSocial\Factories\Traits;

trait TraitS1210
{
    /**
     * builder for version 2.5.0
     */
    protected function toNode250()
    {
        $ideEmpregador = $this->node->getElementsByTagName('ideEmpregador')->item(0);
        //o idEvento pode variar de evento para evento
        //entÃ£o cada factory individualmente terÃ¡ de construir o seu
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
            ! empty($this->std->nrrecibo) ? $this->std->nrrecibo : null,
            false
        );
        $this->dom->addChild(
            $ideEvento,
            "indApuracao",
            $this->std->indapuracao,
            true
        );
        $this->dom->addChild(
            $ideEvento,
            "perApur",
            $this->std->perapur,
            true
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

        $ideBenef = $this->dom->createElement("ideBenef");
        $this->dom->addChild(
            $ideBenef,
            "cpfBenef",
            $this->std->idebenef->cpfbenef,
            true
        );

        if (!empty($this->std->idebenef->deps->vrdeddep)) {
            $deps = $this->dom->createElement("deps");
            $this->dom->addChild(
                $deps,
                "vrDedDep",
                $this->std->idebenef->deps->vrdeddep,
                true
            );
            $ideBenef->appendChild($deps);
        }

        foreach ($this->std->idebenef->infopgto as $pgto) {
            $infoPgto = $this->dom->createElement("infoPgto");
            $this->dom->addChild(
                $infoPgto,
                "dtPgto",
                $pgto->dtpgto,
                true
            );
            $this->dom->addChild(
                $infoPgto,
                "tpPgto",
                $pgto->tppgto,
                true
            );
            $this->dom->addChild(
                $infoPgto,
                "indResBr",
                $pgto->indresbr,
                true
            );

            if (!empty($pgto->detpgtofl)) {
                foreach ($pgto->detpgtofl as $pgtofl) {
                    $detPgtoFl = $this->dom->createElement("detPgtoFl");
                    $this->dom->addChild(
                        $detPgtoFl,
                        "perRef",
                        !empty($pgtofl->perref) ? $pgtofl->perref : null,
                        false
                    );
                    $this->dom->addChild(
                        $detPgtoFl,
                        "ideDmDev",
                        $pgtofl->idedmdev,
                        true
                    );
                    $this->dom->addChild(
                        $detPgtoFl,
                        "indPgtoTt",
                        $pgtofl->indpgtott,
                        true
                    );
                    $this->dom->addChild(
                        $detPgtoFl,
                        "vrLiq",
                        $pgtofl->vrliq,
                        true
                    );
                    $this->dom->addChild(
                        $detPgtoFl,
                        "nrRecArq",
                        !empty($pgtofl->nrrecarq) ? $pgtofl->nrrecarq : null,
                        false
                    );
                    if (!empty($pgtofl->retpgtotot)) {
                        foreach ($pgtofl->retpgtotot as $pg) {
                            $retPgtoTot  = $this->dom->createElement("retPgtoTot");
                            $this->dom->addChild(
                                $retPgtoTot,
                                "codRubr",
                                $pg->codrubr,
                                true
                            );
                            $this->dom->addChild(
                                $retPgtoTot,
                                "ideTabRubr",
                                $pg->idetabrubr,
                                true
                            );
                            $this->dom->addChild(
                                $retPgtoTot,
                                "qtdRubr",
                                !empty($pg->qtdrubr) ? $pg->qtdrubr : null,
                                false
                            );
                            $this->dom->addChild(
                                $retPgtoTot,
                                "fatorRubr",
                                !empty($pg->fatorrubr) ? $pg->fatorrubr : null,
                                false
                            );
                            $this->dom->addChild(
                                $retPgtoTot,
                                "vrUnit",
                                !empty($pg->vrunit) ? $pg->vrunit : null,
                                false
                            );
                            $this->dom->addChild(
                                $retPgtoTot,
                                "vrRubr",
                                $pg->vrrubr,
                                true
                            );
                            if (!empty($pg->penalim)) {
                                foreach ($pg->penalim as $pa) {
                                    $penAlim = $this->dom->createElement("penAlim");
                                    $this->dom->addChild(
                                        $penAlim,
                                        "cpfBenef",
                                        $pa->cpfbenef,
                                        true
                                    );
                                        $this->dom->addChild(
                                            $penAlim,
                                            "dtNasctoBenef",
                                            !empty($pa->dtnasctobenef) ? $pa->dtnasctobenef : null,
                                            true
                                        );
                                        $this->dom->addChild(
                                            $penAlim,
                                            "nmBenefic",
                                            $pa->nmbenefic,
                                            true
                                        );
                                        $this->dom->addChild(
                                            $penAlim,
                                            "vlrPensao",
                                            $pa->vlrpensao,
                                            true
                                        );
                                        $retPgtoTot->appendChild($penAlim);
                                        $penAlim = null;
                                }
                            }
                            $detPgtoFl->appendChild($retPgtoTot);
                            $retPgtoTot = null;
                        }
                    }
                    if (!empty($pgtofl->infopgtoparc)) {
                        foreach ($pgtofl->infopgtoparc as $pp) {
                            $infoPgtoParc = $this->dom->createElement("infoPgtoParc");
                            $this->dom->addChild(
                                $infoPgtoParc,
                                "matricula",
                                !empty($pp->matricula) ? $pp->matricula : null,
                                false
                            );

                            $this->dom->addChild(
                                $infoPgtoParc,
                                "codRubr",
                                $pp->codrubr,
                                true
                            );
                            $this->dom->addChild(
                                $infoPgtoParc,
                                "ideTabRubr",
                                $pp->idetabrubr,
                                true
                            );
                            $this->dom->addChild(
                                $infoPgtoParc,
                                "qtdRubr",
                                !empty($pp->qtdrubr) ? $pp->qtdrubr : null,
                                false
                            );
                            $this->dom->addChild(
                                $infoPgtoParc,
                                "fatorRubr",
                                !empty($pp->fatorrubr) ? $pp->fatorrubr : null,
                                false
                            );
                            $this->dom->addChild(
                                $infoPgtoParc,
                                "vrUnit",
                                !empty($pp->vrunit) ? $pp->vrunit : null,
                                false
                            );
                            $this->dom->addChild(
                                $infoPgtoParc,
                                "vrRubr",
                                $pp->vrrubr,
                                true
                            );
                            $detPgtoFl->appendChild($infoPgtoParc);
                            $infoPgtoParc = null;
                        }
                    }
                    $infoPgto->appendChild($detPgtoFl);
                    $detPgtoFl = null;
                }
            }
            if (!empty($pgto->detpgtobenpr)) {
                $detPgtoBenPr = $this->dom->createElement("detPgtoBenPr");
                $this->dom->addChild(
                    $detPgtoBenPr,
                    "perRef",
                    $pgto->detpgtobenpr->perref,
                    true
                );
                $this->dom->addChild(
                    $detPgtoBenPr,
                    "ideDmDev",
                    $pgto->detpgtobenpr->idedmdev,
                    true
                );
                $this->dom->addChild(
                    $detPgtoBenPr,
                    "indPgtoTt",
                    $pgto->detpgtobenpr->indpgtott,
                    true
                );
                $this->dom->addChild(
                    $detPgtoBenPr,
                    "vrLiq",
                    $pgto->detpgtobenpr->vrliq,
                    true
                );
                if (!empty($pgto->detpgtobenpr->retpgtotot)) {
                    foreach ($pgto->detpgtobenpr->retpgtotot as $rpt) {
                        $retPgtoTot = $this->dom->createElement("retPgtoTot");
                        $this->dom->addChild(
                            $retPgtoTot,
                            "codRubr",
                            $rpt->codrubr,
                            true
                        );
                        $this->dom->addChild(
                            $retPgtoTot,
                            "ideTabRubr",
                            $rpt->idetabrubr,
                            true
                        );
                        $this->dom->addChild(
                            $retPgtoTot,
                            "qtdRubr",
                            !empty($rpt->qtdrubr) ? $rpt->qtdrubr : null,
                            false
                        );
                        $this->dom->addChild(
                            $retPgtoTot,
                            "fatorRubr",
                            !empty($rpt->fatorrubr) ? $rpt->fatorrubr : null,
                            false
                        );
                        $this->dom->addChild(
                            $retPgtoTot,
                            "vrUnit",
                            !empty($rpt->vrunit) ? $rpt->vrunit : null,
                            false
                        );
                        $this->dom->addChild(
                            $retPgtoTot,
                            "vrRubr",
                            $rpt->vrrubr,
                            true
                        );
                        $detPgtoBenPr->appendChild($retPgtoTot);
                        $retPgtoTot = null;
                    }
                }
                if (!empty($pgto->detpgtobenpr->infopgtoparc)) {
                    foreach ($pgto->detpgtobenpr->infopgtoparc as $rpt) {
                        $infoPgtoParc = $this->dom->createElement("infoPgtoParc");
                        $this->dom->addChild(
                            $infoPgtoParc,
                            "codRubr",
                            $rpt->codrubr,
                            true
                        );
                        $this->dom->addChild(
                            $infoPgtoParc,
                            "ideTabRubr",
                            $rpt->idetabrubr,
                            true
                        );
                        $this->dom->addChild(
                            $infoPgtoParc,
                            "qtdRubr",
                            !empty($rpt->qtdrubr) ? $rpt->qtdrubr : null,
                            false
                        );
                        $this->dom->addChild(
                            $infoPgtoParc,
                            "fatorRubr",
                            !empty($rpt->fatorrubr) ? $rpt->fatorrubr : null,
                            false
                        );
                        $this->dom->addChild(
                            $infoPgtoParc,
                            "vrUnit",
                            !empty($rpt->vrunit) ? $rpt->vrunit : null,
                            false
                        );
                        $this->dom->addChild(
                            $infoPgtoParc,
                            "vrRubr",
                            $rpt->vrrubr,
                            true
                        );
                        $detPgtoBenPr->appendChild($infoPgtoParc);
                        $infoPgtoParc = null;
                    }
                }
                $infoPgto->appendChild($detPgtoBenPr);
                $detPgtoBenPr = null;
            }
            if (!empty($pgto->detpgtofer)) {
                foreach ($pgto->detpgtofer as $rpt) {
                    $detPgtoFer = $this->dom->createElement("detPgtoFer");
                    $this->dom->addChild(
                        $detPgtoFer,
                        "codCateg",
                        $rpt->codcateg,
                        true
                    );
                    $this->dom->addChild(
                        $detPgtoFer,
                        "matricula",
                        $rpt->matricula,
                        true
                    );
                    $this->dom->addChild(
                        $detPgtoFer,
                        "dtIniGoz",
                        $rpt->dtinigoz,
                        true
                    );
                    $this->dom->addChild(
                        $detPgtoFer,
                        "qtDias",
                        $rpt->qtdias,
                        true
                    );
                    $this->dom->addChild(
                        $detPgtoFer,
                        "vrLiq",
                        $rpt->vrliq,
                        true
                    );
                    if (!empty($rpt->detrubrfer)) {
                        foreach ($rpt->detrubrfer as $dpt) {
                            $detRubrFer = $this->dom->createElement("detRubrFer");
                            $this->dom->addChild(
                                $detRubrFer,
                                "codRubr",
                                $dpt->codrubr,
                                true
                            );
                            $this->dom->addChild(
                                $detRubrFer,
                                "ideTabRubr",
                                $dpt->idetabrubr,
                                true
                            );
                            $this->dom->addChild(
                                $detRubrFer,
                                "qtdRubr",
                                !empty($dpt->qtdrubr) ? $dpt->qtdrubr : null,
                                false
                            );
                            $this->dom->addChild(
                                $detRubrFer,
                                "fatorRubr",
                                !empty($dpt->fatorrubr) ? $dpt->fatorrubr : null,
                                false
                            );
                            $this->dom->addChild(
                                $detRubrFer,
                                "vrUnit",
                                !empty($dpt->vrunit) ? $dpt->vrunit : null,
                                false
                            );
                            $this->dom->addChild(
                                $detRubrFer,
                                "vrRubr",
                                $dpt->vrrubr,
                                true
                            );
                            if (!empty($dpt->penalim)) {
                                foreach ($dpt->penalim as $xf) {
                                    $penAlim = $this->dom->createElement("penAlim");
                                    $this->dom->addChild(
                                        $penAlim,
                                        "cpfBenef",
                                        $xf->cpfbenef,
                                        true
                                    );
                                    $this->dom->addChild(
                                        $penAlim,
                                        "dtNasctoBenef",
                                        !empty($xf->dtnasctobenef) ? $xf->dtnasctobenef : null,
                                        true
                                    );
                                    $this->dom->addChild(
                                        $penAlim,
                                        "nmBenefic",
                                        $xf->nmbenefic,
                                        true
                                    );
                                    $this->dom->addChild(
                                        $penAlim,
                                        "vlrPensao",
                                        $xf->vlrpensao,
                                        true
                                    );
                                    $detRubrFer->appendChild($penAlim);
                                    $penAlim = null;
                                }
                            }
                            $detPgtoFer->appendChild($detRubrFer);
                            $detRubrFer = null;
                        }
                    }
                    $infoPgto->appendChild($detPgtoFer);
                    $detPgtoFer = null;
                }
            }
            if (!empty($pgto->detpgtoant)) {
                foreach ($pgto->detpgtoant as $pgant) {
                    $detPgtoAnt = $this->dom->createElement("detPgtoAnt");
                    $this->dom->addChild(
                        $detPgtoAnt,
                        "codCateg",
                        $pgant->codcateg,
                        true
                    );
                    foreach ($pgant->infopgtoant as $ipa) {
                        $infoPgtoAnt = $this->dom->createElement("infoPgtoAnt");
                        $this->dom->addChild(
                            $infoPgtoAnt,
                            "tpBcIRRF",
                            $ipa->tpbcirrf,
                            true
                        );
                        $this->dom->addChild(
                            $infoPgtoAnt,
                            "vrBcIRRF",
                            $ipa->vrbcirrf,
                            true
                        );
                        $detPgtoAnt->appendChild($infoPgtoAnt);
                        $infoPgtoAnt = null;
                    }
                    $infoPgto->appendChild($detPgtoAnt);
                    $detPgtoAnt = null;
                }
            }
            if (!empty($pgto->idepgtoext)) {
                $idePgtoExt = $this->dom->createElement("idePgtoExt");
                $idePais = $this->dom->createElement("idePais");
                $this->dom->addChild(
                    $idePais,
                    "codPais",
                    $pgto->idepgtoext->idepais->codpais,
                    true
                );
                $this->dom->addChild(
                    $idePais,
                    "indNIF",
                    $pgto->idepgtoext->idepais->indnif,
                    true
                );
                $this->dom->addChild(
                    $idePais,
                    "nifBenef",
                    !empty($pgto->idepgtoext->idepais->nifbenef) ? $pgto->idepgtoext->idepais->nifbenef : null,
                    false
                );
                $endExt = $this->dom->createElement("endExt");
                $this->dom->addChild(
                    $endExt,
                    "dscLograd",
                    $pgto->idepgtoext->endext->dsclograd,
                    true
                );
                $this->dom->addChild(
                    $endExt,
                    "nrLograd",
                    !empty($pgto->idepgtoext->endext->nrlograd) ? $pgto->idepgtoext->endext->nrlograd : null,
                    false
                );
                $this->dom->addChild(
                    $endExt,
                    "complem",
                    !empty($pgto->idepgtoext->endext->complem) ? $pgto->idepgtoext->endext->complem : null,
                    false
                );
                $this->dom->addChild(
                    $endExt,
                    "bairro",
                    !empty($pgto->idepgtoext->endext->bairro) ? $pgto->idepgtoext->endext->bairro : null,
                    false
                );
                $this->dom->addChild(
                    $endExt,
                    "nmCid",
                    $pgto->idepgtoext->endext->nmcid,
                    true
                );
                $this->dom->addChild(
                    $endExt,
                    "codPostal",
                    !empty($pgto->idepgtoext->endext->codoostal) ? $pgto->idepgtoext->endext->codoostal : null,
                    false
                );
                $idePgtoExt->appendChild($idePais);
                $idePgtoExt->appendChild($endExt);
                $infoPgto->appendChild($idePgtoExt);
            }
            $ideBenef->appendChild($infoPgto);
            $infoPgto = null;
        }
        $this->node->appendChild($ideBenef);
        //finalizaÃ§Ã£o do xml
        $this->eSocial->appendChild($this->node);
        //$this->xml = $this->dom->saveXML($this->eSocial);
        $this->sign();
    }

    /**
     * builder for version S.1.0.0
     */
    protected function toNodeS100()
    {
        $ideEmpregador = $this->node->getElementsByTagName('ideEmpregador')->item(0);
        //o idEvento pode variar de evento para evento
        //entÃ£o cada factory individualmente terÃ¡ de construir o seu
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
            ! empty($this->std->nrrecibo) ? $this->std->nrrecibo : null,
            false
        );
        $this->dom->addChild(
            $ideEvento,
            "perApur",
            $this->std->perapur,
            true
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

        $ideBenef = $this->dom->createElement("ideBenef");
        $this->dom->addChild(
            $ideBenef,
            "cpfBenef",
            $this->std->idebenef->cpfbenef,
            true
        );

        foreach ($this->std->idebenef->infopgto as $pgto) {
            $infoPgto = $this->dom->createElement("infoPgto");
            $this->dom->addChild(
                $infoPgto,
                "dtPgto",
                $pgto->dtpgto,
                true
            );
            $this->dom->addChild(
                $infoPgto,
                "tpPgto",
                $pgto->tppgto,
                true
            );
            $this->dom->addChild(
                $infoPgto,
                "perRef",
                !empty($pgto->perref) ? $pgto->perref : null,
                false
            );
            $this->dom->addChild(
                $infoPgto,
                "ideDmDev",
                $pgto->idedmdev,
                true
            );
            $this->dom->addChild(
                $infoPgto,
                "vrLiq",
                $pgto->vrliq,
                true
            );

            $ideBenef->appendChild($infoPgto);
            $infoPgto = null;
        }
        $this->node->appendChild($ideBenef);
        //finalizaÃ§Ã£o do xml
        $this->eSocial->appendChild($this->node);
        //$this->xml = $this->dom->saveXML($this->eSocial);
        $this->sign();
    }

    /**
     * builder for version S.1.1.0
     */

    protected function toNodeS110()
    {
        $ideEmpregador = $this->node->getElementsByTagName('ideEmpregador')->item(0);
        //o idEvento pode variar de evento para evento
        //entÃ£o cada factory individualmente terÃ¡ de construir o seu
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
            ! empty($this->std->nrrecibo) ? $this->std->nrrecibo : null,
            false
        );
        $this->dom->addChild(
            $ideEvento,
            "perApur",
            $this->std->perapur,
            true
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

        $ideBenef = $this->dom->createElement("ideBenef");
        $this->dom->addChild(
            $ideBenef,
            "cpfBenef",
            $this->std->idebenef->cpfbenef,
            true
        );

        foreach ($this->std->idebenef->infopgto as $pgto) {
            $infoPgto = $this->dom->createElement("infoPgto");
            $this->dom->addChild(
                $infoPgto,
                "dtPgto",
                $pgto->dtpgto,
                true
            );
            $this->dom->addChild(
                $infoPgto,
                "tpPgto",
                $pgto->tppgto,
                true
            );
            $this->dom->addChild(
                $infoPgto,
                "perRef",
                !empty($pgto->perref) ? $pgto->perref : null,
                false
            );
            $this->dom->addChild(
                $infoPgto,
                "ideDmDev",
                $pgto->idedmdev,
                true
            );
            $this->dom->addChild(
                $infoPgto,
                "vrLiq",
                $pgto->vrliq,
                true
            );

            $ideBenef->appendChild($infoPgto);
            $infoPgto = null;
        }
        $this->node->appendChild($ideBenef);
        //finalizaÃ§Ã£o do xml
        $this->eSocial->appendChild($this->node);
        //$this->xml = $this->dom->saveXML($this->eSocial);
        $this->sign();
    }

    /**
     * builder for version S.1.2.0
     */
    protected function toNodeS120()
    {
        $ideEmpregador = $this->node->getElementsByTagName('ideEmpregador')->item(0);
        //o idEvento pode variar de evento para evento
        //entÃ£o cada factory individualmente terÃ¡ de construir o seu
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
            ! empty($this->std->nrrecibo) ? $this->std->nrrecibo : null,
            false
        );
        $this->dom->addChild(
            $ideEvento,
            "perApur",
            $this->std->perapur,
            true
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

        $ideBenef = $this->dom->createElement("ideBenef");
        $this->dom->addChild(
            $ideBenef,
            "cpfBenef",
            $this->std->idebenef->cpfbenef,
            true
        );

        foreach ($this->std->idebenef->infopgto as $pgto) {
            $infoPgto = $this->dom->createElement("infoPgto");
            $this->dom->addChild(
                $infoPgto,
                "dtPgto",
                $pgto->dtpgto,
                true
            );
            $this->dom->addChild(
                $infoPgto,
                "tpPgto",
                $pgto->tppgto,
                true
            );
            $this->dom->addChild(
                $infoPgto,
                "perRef",
                !empty($pgto->perref) ? $pgto->perref : null,
                false
            );
            $this->dom->addChild(
                $infoPgto,
                "ideDmDev",
                $pgto->idedmdev,
                true
            );
            $this->dom->addChild(
                $infoPgto,
                "vrLiq",
                $pgto->vrliq,
                true
            );

            $ideBenef->appendChild($infoPgto);
            $infoPgto = null;
        }
        if (isset($this->std->idebenef->infoircomplem)) {
            $infoIrComplem = $this->dom->createElement("infoIRComplem");

                $this->dom->addChild(
                    $infoIrComplem,
                    "dtLaudo",
                    !empty($this->std->idebenef->infoircomplem->dtlaudo) ?
                     $this->std->idebenef->infoircomplem->dtlaudo : null,
                    false
                );
            if (isset($this->std->idebenef->infoircomplem->infodep)
            && !empty($this->std->idebenef->infoircomplem->infodep)) {
                foreach ($this->std->idebenef->infoircomplem->infodep as $dep) {

                    $infoDep = $this->dom->createElement("infoDep");

                    $this->dom->addChild(
                        $infoDep,
                        'cpfDep',
                        $dep->cpfdep,
                        true
                    );

                    $this->dom->addChild(
                        $infoDep,
                        'dtNascto',
                        !empty($dep->dtnascto) ? $dep->dtnascto : null,
                        false
                    );

                    $this->dom->addChild(
                        $infoDep,
                        'nome',
                        !empty($dep->nome) ? $dep->nome : null,
                        false
                    );

                    $this->dom->addChild(
                        $infoDep,
                        'depIRRF',
                        !empty($dep->depirrf) ? $dep->depirrf : null,
                        false
                    );

                    $this->dom->addChild(
                        $infoDep,
                        'tpDep',
                        !empty($dep->tpdep) ? $dep->tpdep : null,
                        false
                    );

                    $this->dom->addChild(
                        $infoDep,
                        'descrDep',
                        !empty($dep->descrdep) ? $dep->descrdep : null,
                        false
                    );

                    $infoIrComplem->appendChild($infoDep);
                    $infoDep = null;
                }
            }

            if (isset($this->std->idebenef->infoircomplem->infoircr)
            && !empty($this->std->idebenef->infoircomplem->infoircr)) {
                foreach ($this->std->idebenef->infoircomplem->infoircr as $ircr) {
                    $infoIrcr = $this->dom->createElement("infoIRCR");
                    $this->dom->addChild(
                        $infoIrcr,
                        'tpCR',
                        $ircr->tpcr,
                        true
                    );
                    if (isset($ircr->deddepen) && !empty($ircr->deddepen)) {
                        foreach ($ircr->deddepen as $dedDepen) {
                            $infoDedDepen = $this->dom->createElement("dedDepen");

                            $this->dom->addChild(
                                $infoDedDepen,
                                'tpRend',
                                $dedDepen->tprend,
                                true
                            );

                            $this->dom->addChild(
                                $infoDedDepen,
                                'cpfDep',
                                $dedDepen->cpfdep,
                                true
                            );

                            $this->dom->addChild(
                                $infoDedDepen,
                                'vlrDedDep',
                                $dedDepen->vlrdeddep,
                                true
                            );

                            $infoIrcr->appendChild($infoDedDepen);
                            $infoDedDepen = null;
                        }
                    }
                    if (isset($ircr->penalim) && !empty($ircr->penalim)) {

                        foreach ($ircr->penalim as $penAlim) {
                            $infoPenAlim = $this->dom->createElement("penAlim");

                            $this->dom->addChild(
                                $infoPenAlim,
                                'tpRend',
                                $penAlim->tprend,
                                true
                            );

                            $this->dom->addChild(
                                $infoPenAlim,
                                'cpfDep',
                                $penAlim->cpfdep,
                                true
                            );

                            $this->dom->addChild(
                                $infoPenAlim,
                                'vlrDedPenAlim',
                                $penAlim->vlrdedpenalim,
                                true
                            );
                            $infoIrcr->appendChild($infoPenAlim);
                            $infoPenAlim = null;
                        }
                    }
                    if ( isset($ircr->previdcompl) && !empty($ircr->previdcompl)){
                        foreach ($ircr->previdcompl as $previdCompl) {
                            $infoPrevid = $this->dom->createElement("previdCompl");

                            $this->dom->addChild(
                                $infoPrevid,
                                'tpPrev',
                                $previdCompl->tpprev,
                                true
                            );

                            $this->dom->addChild(
                                $infoPrevid,
                                'cnpjEntidPC',
                                $previdCompl->cnpjentidpc,
                                true
                            );

                            $this->dom->addChild(
                                $infoPrevid,
                                'vlrDedPC',
                                $previdCompl->vlrdedpc,
                                true
                            );

                            $this->dom->addChild(
                                $infoPrevid,
                                'vlrPatrocFunp',
                                !empty($previdCompl->vlrpatrocfunp) ? $previdCompl->vlrpatrocfunp : null,
                                false
                            );
                            $infoIrcr->appendChild($infoPrevid);
                            $infoPrevid = null;
                        }
                    }
                    if (isset($ircr->infoprocret) && !empty($ircr->infoprocret)) {

                        foreach ($ircr->infoprocret as $procret) {
                            $infoProcRet = $this->dom->createElement("infoProcRet");

                            $this->dom->addChild(
                                $infoProcRet,
                                'tpProcRet',
                                $procret->tpprocret,
                                true
                            );

                            $this->dom->addChild(
                                $infoProcRet,
                                'nrProcRet',
                                $procret->nrprocret,
                                true
                            );

                            $this->dom->addChild(
                                $infoProcRet,
                                'codSusp',
                                !empty($procret->codsusp) ? $procret->codsusp : null,
                                false
                            );
                            if (isset($procret->infovalores) && !empty($procret->infovalores)) {
                                foreach ($procret->infovalores as $valores) {
                                    $infoValores = $this->dom->createElement("infoValores");
                                    $this->dom->addChild(
                                        $infoValores,
                                        'indApuracao',
                                        $valores->indapuracao,
                                        true
                                    );

                                    $this->dom->addChild(
                                        $infoValores,
                                        'vlrNRetido',
                                        !empty($valores->vlrnretido) ? $valores->vlrnretido : null,
                                        false
                                    );

                                    $this->dom->addChild(
                                        $infoValores,
                                        'vlrDepJud',
                                        !empty($valores->vlrdepjud) ? $valores->vlrdepjud : null,
                                        false
                                    );

                                    $this->dom ->addChild(
                                        $infoValores,
                                        'vlrCmpAnoCal',
                                        !empty($valores->vlrcmpanocal) ? $valores->vlrcmpanocal : null,
                                        false
                                    );

                                    $this->dom->addChild(
                                        $infoValores,
                                        'vlrCmpAnoAnt',
                                        !empty($valores->vlrcmpanoant) ? $valores->vlrcmpanoant : null,
                                        false
                                    );

                                    $this->dom->addChild(
                                        $infoValores,
                                        'vlrRendSusp',
                                        !empty($valores->vlrrendsusp) ? $valores->vlrrendsusp : null,
                                        false
                                    );
                                    if (isset($valores->dedsusp) && !empty($valores->dedsusp)) {

                                        foreach ($valores->dedsusp as $dedSusp) {
                                            $infoDedSusp = $this->dom->createElement("dedSusp");

                                            $this->dom->addChild(
                                                $infoDedSusp,
                                                'indTpDeducao',
                                                $dedSusp->indtpdeducao,
                                                true
                                            );

                                            $this->dom->addChild(
                                                $infoDedSusp,
                                                'vlrDedSusp',
                                                !empty($dedSusp->vlrdedsusp) ? $dedSusp->vlrdedsusp : null,
                                                false
                                            );

                                            $this->dom->addChild(
                                                $infoDedSusp,
                                                'cnpjEntidPC',
                                                !empty($dedSusp->cnpjentidpc) ? $dedSusp->cnpjentidpc : null,
                                                false
                                            );

                                            $this->dom->addChild(
                                                $infoDedSusp,
                                                'vlrPatrocFunp',
                                                !empty($dedSusp->vlrpatrocfunp)
                                                    ? $dedSusp->vlrpatrocfunp : null,
                                                false
                                            );
                                            if (isset($dedSusp->benefpen) &&
                                            !empty($dedSusp->benefpen)) {


                                                foreach ($dedSusp->benefpen as $benefPen) {
                                                    $infoBenefPen = $this->dom->createElement("benefPen");

                                                    $this->dom->addChild(
                                                        $infoBenefPen,
                                                        'cpfDep',
                                                        $benefPen->cpfdep,
                                                        true
                                                    );

                                                    $this->dom->addChild(
                                                        $infoBenefPen,
                                                        'vlrDepenSusp',
                                                        $benefPen->vlrdepensusp,
                                                        true
                                                    );
                                                    $infoDedSusp->appendChild($infoBenefPen);
                                                    $infoBenefPen = null;

                                                }
                                            }
                                            $infoValores->appendChild($infoDedSusp);
                                            $infoDedSusp = null;
                                        }

                                    }
                                    $infoProcRet->appendChild($infoValores);
                                    $infoValores = null;
                                }
                            }


                            $infoIrcr->appendChild($infoProcRet);
                            $infoProcRet = null;
                        }
                    }
                    $infoIrComplem->appendChild($infoIrcr);
                    $infoIrcr = null;
                }
            }
            if (isset($this->std->idebenef->infoircomplem->plansaude) &&
            !empty($this->std->idebenef->infoircomplem->plansaude)) {
                foreach ($this->std->idebenef->infoircomplem->plansaude as $planos) {
                    $infoPlanSaude = $this->dom->createElement("planSaude");

                    $this->dom->addChild(
                        $infoPlanSaude,
                        'cnpjOper',
                        $planos->cnpjoper,
                        true
                    );

                    $this->dom->addChild(
                        $infoPlanSaude,
                        'regANS',
                        !empty($planos->regans) ? $planos->regans : null,
                        false
                    );

                    $this->dom->addChild(
                        $infoPlanSaude,
                        'vlrSaudeTit',
                        $planos->vlrsaudetit,
                        true
                    );

                    if (isset($planos->infodepsau) && !empty($planos->infodepsau)) {
                        foreach ($planos->infodepsau as $depPlanos) {
                            $infoDepSau = $this->dom->createElement("infoDepSau");
                            $this->dom->addChild(
                                $infoDepSau,
                                'cpfDep',
                                $depPlanos->cpfdep,
                                true
                            );

                            $this->dom->addChild(
                                $infoDepSau,
                                'vlrSaudeDep',
                                $depPlanos->vlrsaudedep,
                                true
                            );

                            $infoPlanSaude->appendChild($infoDepSau);
                            $infoDepSau = null;
                        }
                    }
                    $infoIrComplem->appendChild($infoPlanSaude);
                    $infoPlanSaude = null;
                }

            }
            if (isset($this->std->idebenef->infoircomplem->inforeembmed) &&
                !empty($this->std->idebenef->infoircomplem->inforeembmed)) {
                foreach($this->std->idebenef->infoircomplem->inforeembmed  as $reemb) {
                    $infoReembMed = $this->dom->createElement("infoReembMed");
                    $this->dom->addChild(
                        $infoReembMed,
                        'indOrgReemb',
                        $reemb->indorgreemb,
                        true
                    );
                    $this->dom->addChild(
                        $infoReembMed,
                        'cnpjOper',
                        !empty($reemb->cnpjoper) ? $reemb->cnpjoper : null,
                        false
                    );

                    $this->dom->addChild(
                        $infoReembMed,
                        'regANS',
                        !empty($reemb->regans) ? $reemb->regans : null,
                        false
                    );
                    if (isset($reemb->detreembtit) && !empty($reemb->detreembtit)) {

                        foreach ($reemb->detreembtit as $reembtit) {
                            $infoReembTit = $this->dom->createElement("detReembTit");
                            $this->dom->addChild(
                                $infoReembTit,
                                'tpInsc',
                                $reembtit->tpinsc,
                                true
                            );

                            $this->dom->addChild(
                                $infoReembTit,
                                'nrInsc',
                                $reembtit->nrinsc,
                                true
                            );

                            $this->dom->addChild(
                                $infoReembTit,
                                'vlrReemb',
                                !empty($reembtit->vlreemb) ? $reembtit->vlreemb : null,
                                false
                            );

                            $this->dom->addChild(
                                $infoReembTit,
                                'vlrReembAnt',
                                !empty($reembtit->vlreembant) ? $reembtit->vlreembant : null,
                                false
                            );

                            $infoReembMed->appendChild($infoReembTit);
                            $infoReembTit = null;
                        }
                    }
                    if (isset($reemb->inforeembdep) && !empty($reemb->inforeembdep)) {
                        foreach($reemb->inforeembdep as $reembdep) {
                            $infoReembDep = $this->dom->createElement("infoReembDep");
                            $this->dom->addChild(
                                $infoReembDep,
                                'cpfBenef',
                                $reembdep->cpfbenef,
                                true
                            );
                            if (isset($reembdep->detreembdep) && !empty($reembdep->detreembdep)) {
                                foreach ($reembdep->detreembdep as $detReemb) {
                                    $infoDetReembDep = $this->dom->createElement("detReembDep");
                                    $this->dom->addChild(
                                        $infoDetReembDep,
                                        'tpInsc',
                                        $detReemb->tpinsc,
                                        true
                                    );
                                    $this->dom->addChild(
                                        $infoDetReembDep,
                                        'nrInsc',
                                        $detReemb->nrinsc,
                                        true
                                    );

                                    $this->dom->addChild(
                                        $infoDetReembDep,
                                        'vlrReemb',
                                        !empty($detReemb->vlrreemb) ? $detReemb->vlrreemb : null ,
                                        false
                                    );

                                    $this->dom->addChild(
                                        $infoDetReembDep,
                                        'vlrReembAnt',
                                        !empty($detReemb->vlrreembant) ? $detReemb->vlrreembant : null ,
                                        false
                                    );

                                    $infoReembDep->appendChild($infoDetReembDep);
                                    $infoDetReembDep= null;
                                }

                            }
                            $infoReembMed->appendChild($infoReembDep);
                            $infoReembDep = null;
                        }
                    }
                    $infoIrComplem->appendChild($infoReembMed);
                    $infoReembMed = null;
                }
            }
            $ideBenef->appendChild($infoIrComplem);
        }
        $this->node->appendChild($ideBenef);

        //finalizaÃ§Ã£o do xml
        $this->eSocial->appendChild($this->node);
        //$this->xml = $this->dom->saveXML($this->eSocial);
        $this->sign();
                // var_dump($this->xml);
        // die();


    }

}
