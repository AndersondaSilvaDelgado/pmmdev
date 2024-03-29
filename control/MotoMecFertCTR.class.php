<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../control/AtualAplicCTR.class.php');
require_once('../model/BoletimMMFertDAO.class.php');
require_once('../model/ApontMMFertDAO.class.php');
require_once('../model/ApontMecanDAO.class.php');
require_once('../model/ImplementoMMDAO.class.php');
require_once('../model/BoletimPneuDAO.class.php');
require_once('../model/ItemMedPneuDAO.class.php');
require_once('../model/ItemManutPneuDAO.class.php');
require_once('../model/LeiraDAO.class.php');
require_once('../model/RendimentoMMDAO.class.php');
require_once('../model/RecolhimentoFertDAO.class.php');
require_once('../model/MotoMecDAO.class.php');
require_once('../model/CarregDAO.class.php');
/**
 * Description of MotoMecFert
 *
 * @author anderson
 */
class MotoMecFertCTR {
 
    private $idBolMMArray;
    private $idApontArray;
    private $idApontImplArray;
    private $idBolPneuArray;
    private $idCarregArray;
    private $idMovLeiraArray;
    private $idApontMecanArray;
    private $idRendArray;
    private $idRecolhArray;
    
    public function salvarBolAbertoMMFert($info) {

        $dados = $info['dado'];
        $array = explode("_",$dados);
//{"boletim":[{"ativPrincBolMMFert":618,"dthrInicialBolMMFert":"15/09/2023 10:05","dthrLongFinalBolMMFert":0,"hodometroInicialBolMMFert":154263.0,"idBolMMFert":1,"idEquipBolMMFert":2621,"idExtBolMMFert":742100,"idTurnoBolMMFert":60,"latitudeBolMMFert":-21.8184081,"longitudeBolMMFert":-48.6124837,"matricFuncBolMMFert":11,"osBolMMFert":179109,"statusBolMMFert":1,"statusConBolMMFert":1,"tipoBolMMFert":1}]}_
//{"apont":[{"ativApontMMFert":618,"bocalApontMMFert":0,"dthrApontLongMMFert":1694783400000,"dthrApontMMFert":"15/09/2023 10:10","idApontMMFert":2,"idBolMMFert":1,"idFrenteApontMMFert":0,"idMotoMec":0,"idProprApontMMFert":0,"latitudeApontMMFert":-21.8184084,"longitudeApontMMFert":-48.6124798,"osApontMMFert":179109,"paradaApontMMFert":0,"pressaoApontMMFert":0.0,"statusApontMMFert":2,"statusConApontMMFert":1,"transbApontMMFert":0,"velocApontMMFert":0}]}_
//{"implemento":[]}_
//{"movleira":[]}_
//{"apontmecan":[]}_
//{"boletimpneu":[{"dthrBolPneu":"15/09/2023 10:06","dthrLongBolPneu":1694783160000,"idBolMMPneu":1,"idBolPneu":1,"idEquipBolPneu":2621,"matricFuncBolPneu":11,"statusBolPneu":2}]}_
//{"itemmedpneu":[]}_
//{"carreg":[]}
        $jsonObjBoletim = json_decode($array[0]);
        $jsonObjApont = json_decode($array[1]);
        $jsonObjImplemento = json_decode($array[2]);
        $jsonObjMovLeira = json_decode($array[3]);
        $jsonObjApontMecan = json_decode($array[4]);
        $jsonObjBoletimPneu = json_decode($array[5]);
        $jsonObjItemMedPneu = json_decode($array[6]);
        $jsonObjItemManutPneu = json_decode($array[7]);
        $jsonObjCarreg = json_decode($array[8]);

        $dadosBoletim = $jsonObjBoletim->boletim;
        $dadosApont = $jsonObjApont->apont;
        $dadosImplemento = $jsonObjImplemento->implemento;
        $dadosMovLeira = $jsonObjMovLeira->movleira;
        $dadosApontMecan = $jsonObjApontMecan->apontmecan;
        $dadosBoletimPneu = $jsonObjBoletimPneu->boletimpneu;
        $dadosItemMedPneu = $jsonObjItemMedPneu->itemmedpneu;
        $dadosItemManutPneu = $jsonObjItemManutPneu->itemmanutpneu;
        $dadosCarreg = $jsonObjCarreg->carreg;

        $ret = $this->salvarBoletimAbertoMMFert($dadosBoletim, $dadosApont, $dadosImplemento, $dadosMovLeira, $dadosApontMecan, $dadosBoletimPneu, $dadosItemMedPneu, $dadosItemManutPneu, $dadosCarreg);

        return $ret;

    }
    
    public function salvarBolFechadoMMFert($info) {

        $dados = $info['dado'];
        $array = explode("_",$dados);

        $jsonObjBoletim = json_decode($array[0]);
        $jsonObjApont = json_decode($array[1]);
        $jsonObjImpl = json_decode($array[2]);
        $jsonObjMovLeira = json_decode($array[3]);
        $jsonObjApontMecan = json_decode($array[4]);
        $jsonObjBoletimPneu = json_decode($array[5]);
        $jsonObjItemMedPneu = json_decode($array[6]);
        $jsonObjItemManutPneu = json_decode($array[7]);
        $jsonObjCarreg = json_decode($array[8]);
        $jsonObjRend = json_decode($array[9]);
        $jsonObjRecolh = json_decode($array[10]);

        $dadosBoletim = $jsonObjBoletim->boletim;
        $dadosApont = $jsonObjApont->apont;
        $dadosImplemento = $jsonObjImpl->implemento;
        $dadosMovLeira = $jsonObjMovLeira->movleira;
        $dadosApontMecan = $jsonObjApontMecan->apontmecan;
        $dadosBoletimPneu = $jsonObjBoletimPneu->boletimpneu;
        $dadosItemMedPneu = $jsonObjItemMedPneu->itemmedpneu;
        $dadosItemManutPneu = $jsonObjItemManutPneu->itemmanutpneu;
        $dadosCarreg = $jsonObjCarreg->carreg;
        $dadosRendimento = $jsonObjRend->rendimento;
        $dadosRecolhimento = $jsonObjRecolh->recolhimento;

        $ret = $this->salvarBoletimFechMMFert($dadosBoletim, $dadosApont, $dadosImplemento, $dadosMovLeira, $dadosApontMecan, $dadosBoletimPneu, $dadosItemMedPneu, $dadosItemManutPneu, $dadosCarreg, $dadosRendimento, $dadosRecolhimento);

        return $ret;

    }

    private function salvarBoletimAbertoMMFert($dadosBoletim, $dadosApont, $dadosImplemento, $dadosMovLeira, $dadosApontMecan, $dadosBoletimPneu, $dadosItemMedPneu, $dadosItemManutPneu, $dadosCarreg) {
        
        $boletimMMFertDAO = new BoletimMMFertDAO();
        $this->idBolMMArray = array();
        $this->idApontArray = array();
        $this->idApontImplArray = array();
        $this->idBolPneuArray = array();
        $this->idCarregArray = array();
        $this->idMovLeiraArray = array();
        $this->idApontMecanArray = array();
        
        foreach ($dadosBoletim as $bol) {
            if($bol->tipoBolMMFert === 1){
                $v = $boletimMMFertDAO->verifBoletimMM($bol);
                if ($v == 0) {
                    $boletimMMFertDAO->insBoletimMMAberto($bol);
                }
                $idBolBD = $boletimMMFertDAO->idBoletimMM($bol);
                $this->salvarApontMM($idBolBD, $bol->idBolMMFert, $dadosApont, $dadosImplemento, $dadosCarreg);
                $this->salvarBoletimPneu($idBolBD, $bol->idBolMMFert, $dadosBoletimPneu, $dadosItemMedPneu, $dadosItemManutPneu, 1);
                $this->salvarMovLeiraMM($idBolBD, $bol->idBolMMFert, $dadosMovLeira);
                $this->salvarApontMecan($idBolBD, $bol->idBolMMFert, $dadosApontMecan);
            }
            else{
                $v = $boletimMMFertDAO->verifBoletimFert($bol);
                if ($v == 0) {
                    $boletimMMFertDAO->insBoletimFertAberto($bol);
                }
                $idBolBD = $boletimMMFertDAO->idBoletimFert($bol);
                $this->salvarApontFert($idBolBD, $bol->idBolMMFert, $dadosApont, $dadosImplemento, $dadosBoletimPneu, $dadosItemMedPneu, $dadosCarreg);
                $this->salvarMovLeiraMM($idBolBD, $bol->idBolMMFert, $dadosMovLeira);
                $this->salvarApontMecan($idBolBD, $bol->idBolMMFert, $dadosApontMecan);
            }
            $this->idBolMMArray[] = array("idBolMMFert" => $bol->idBolMMFert, "idExtBolMMFert" => $idBolBD);
        }
        
        $dadoBol = array("boletim"=>$this->idBolMMArray);
        $retBol = json_encode($dadoBol);
                
        $dadoApont = array("apont"=>$this->idApontArray);
        $retApont = json_encode($dadoApont);
        
        $dadoApontImpl = array("apontimpl"=>$this->idApontImplArray);
        $retApontImpl = json_encode($dadoApontImpl);
        
        $dadoBolPneu = array("boletimpneu"=>$this->idBolPneuArray);
        $retBolPneu = json_encode($dadoBolPneu);
        
        $dadoCarreg = array("carreg"=>$this->idCarregArray);
        $retCarreg = json_encode($dadoCarreg);
        
        $dadoApontMecan = array("apontmecan"=>$this->idApontMecanArray);
        $retApontMecan = json_encode($dadoApontMecan);
        
        $dadoMovLeira = array("movleira"=>$this->idMovLeiraArray);
        $retMovLeira = json_encode($dadoMovLeira);
        
        return 'BOLABERTOMM_' . $retBol . "_" . $retApont . "_" . $retApontImpl . "_" . $retBolPneu . "_" . $retCarreg . "_" . $retMovLeira . "_" . $retApontMecan;
        
    }

    private function salvarBoletimFechMMFert($dadosBoletim, $dadosApont, $dadosImplemento, $dadosMovLeira, $dadosApontMecan, $dadosBoletimPneu, $dadosItemMedPneu, $dadosItemManutPneu, $dadosCarreg, $dadosRendimento, $dadosRecolhimento) {
        
        $boletimMMFertDAO = new BoletimMMFertDAO();
        $this->idBolMMArray = array();
        $this->idApontArray = array();
        $this->idApontImplArray = array();
        $this->idBolPneuArray = array();
        $this->idCarregArray = array();
        $this->idMovLeiraArray = array();
        $this->idApontMecanArray = array();
        $this->idRendArray = array();
        $this->idRecolhArray = array();
        
        foreach ($dadosBoletim as $bol) {
            if($bol->tipoBolMMFert === 1){
                $v = $boletimMMFertDAO->verifBoletimMM($bol);
                if ($v == 0) {
                    $boletimMMFertDAO->insBoletimMMFechado($bol);
                    $idBolBD = $boletimMMFertDAO->idBoletimMM($bol);
                } else {
                    $idBolBD = $boletimMMFertDAO->idBoletimMM($bol);
                    $boletimMMFertDAO->updateBoletimMMFechado($idBolBD, $bol);
                }
                $this->salvarApontMM($idBolBD, $bol->idBolMMFert, $dadosApont, $dadosImplemento, $dadosCarreg);
                $this->salvarBoletimPneu($idBolBD, $bol->idBolMMFert, $dadosBoletimPneu, $dadosItemMedPneu, $dadosItemManutPneu, 1);
                $this->salvarMovLeiraMM($idBolBD, $bol->idBolMMFert, $dadosMovLeira);
                $this->salvarApontMecan($idBolBD, $bol->idBolMMFert, $dadosApontMecan);
                $this->salvarRendMM($idBolBD, $bol->idBolMMFert, $dadosRendimento);
            }
            else{
                $v = $boletimMMFertDAO->verifBoletimFert($bol);
                if ($v == 0) {
                    $boletimMMFertDAO->insBoletimFertFechado($bol);
                    $idBolBD = $boletimMMFertDAO->idBoletimFert($bol);
                } else {
                    $idBolBD = $boletimMMFertDAO->idBoletimFert($bol);
                    $boletimMMFertDAO->updateBoletimFertFechado($idBolBD, $bol);
                }
                $this->salvarApontFert($idBolBD, $bol->idBolMMFert, $dadosApont, $dadosImplemento, $dadosCarreg);
                $this->salvarBoletimPneu($idBolBD, $bol->idBolMMFert, $dadosBoletimPneu, $dadosItemMedPneu, 2);
                $this->salvarMovLeiraMM($idBolBD, $bol->idBolMMFert, $dadosMovLeira);
                $this->salvarApontMecan($idBolBD, $bol->idBolMMFert, $dadosApontMecan);
                $this->salvarRecolhFert($idBolBD, $bol->idBolMMFert, $dadosRecolhimento);
            }
            $this->idBolMMArray[] = array("idBolMMFert" =>$bol->idBolMMFert);
        }
        
        $dadoBol = array("boletim"=>$this->idBolMMArray);
        $retBol = json_encode($dadoBol);
        
        $dadoApont = array("apont"=>$this->idApontArray);
        $retApont = json_encode($dadoApont);
        
        $dadoApontImpl = array("apontimpl"=>$this->idApontImplArray);
        $retApontImpl = json_encode($dadoApontImpl);
        
        $dadoBolPneu = array("boletimpneu"=>$this->idBolPneuArray);
        $retBolPneu = json_encode($dadoBolPneu);
        
        $dadoCarreg = array("carreg"=>$this->idCarregArray);
        $retCarreg = json_encode($dadoCarreg);
        
        $dadoApontMecan = array("apontmecan"=>$this->idApontMecanArray);
        $retApontMecan = json_encode($dadoApontMecan);
        
        $dadoMovLeira = array("movleira"=>$this->idMovLeiraArray);
        $retMovLeira = json_encode($dadoMovLeira);
        
        $dadoRend = array("rend"=>$this->idRendArray);
        $retRend = json_encode($dadoRend);
        
        $dadoRecolh = array("recolh"=>$this->idRecolhArray);
        $retRecolh = json_encode($dadoRecolh);
        
        return 'BOLFECHADOMM_' . $retBol . "_" . $retApont . "_" . $retApontImpl . "_" . $retBolPneu . "_" . $retCarreg . "_" . $retMovLeira . "_" . $retApontMecan . "_" . $retRend . "_" . $retRecolh;
        
    }

    private function salvarApontMM($idBolBD, $idBolCel, $dadosApont, $dadosImplemento, $dadosCarreg) {
        $apontMMFertDAO = new ApontMMFertDAO;
        $boletimMMFertDAO = new BoletimMMFertDAO();
        foreach ($dadosApont as $apont) {
            if ($idBolCel == $apont->idBolMMFert) {
                $v = $apontMMFertDAO->verifApontMM($idBolBD, $apont);
                if ($v == 0) {
                    $apontMMFertDAO->insApontMM($idBolBD, $apont);
                }
                if($apont->osApontMMFert > 0){
                    $boletimMMFertDAO->updateBoletimMMOSAtiv($idBolBD, $apont);
                    $apontMMFertDAO->updateApontMMOSAtiv($idBolBD, $apont);
                }
                $idApontBD = $apontMMFertDAO->idApontMM($idBolBD, $apont);
                $this->salvarImplMM($idApontBD, $apont->idApontMMFert, $dadosImplemento);
                $this->salvarCarreg($idApontBD, $apont->idApontMMFert, $dadosCarreg);
                $this->idApontArray[] = array("idApontMMFert" => $apont->idApontMMFert);
            }
        }
        
    }

    private function salvarApontFert($idBolBD, $idBolCel, $dadosApont, $dadosImplemento, $dadosBoletimPneu, $dadosItemMedPneu, $dadosCarreg) {
        $apontMMFertDAO = new ApontMMFertDAO();
        foreach ($dadosApont as $apont) {
            if ($idBolCel == $apont->idBolMMFert) {
                $v = $apontMMFertDAO->verifApontFert($idBolBD, $apont);
                if ($v == 0) {
                    $apontMMFertDAO->insApontFert($idBolBD, $apont);
                }
                $idApontBD = $apontMMFertDAO->idApontFert($idBolBD, $apont);
                $this->salvarImplMM($idApontBD, $apont->idApontMMFert, $dadosImplemento);
                $this->salvarCarreg($idApontBD, $apont->idApontMMFert, $dadosCarreg);
                $this->idApontArray[] = array("idApontMMFert" => $apont->idApontMMFert);
            }
        }

    }
        
    private function salvarApontMecan($idBolBD, $idBolCel, $dadosApontMecan) {
        $apontMecanDAO = new ApontMecanDAO();
        foreach ($dadosApontMecan as $apontMecan) {
            if ($idBolCel == $apontMecan->idBolApontMecan) {
                $v = $apontMecanDAO->verifApontMecan($idBolBD, $apontMecan);
                if ($v == 0) {
                    if($apontMecan->statusApontMecan == 1){
                        $apontMecanDAO->insApontMecanAberto($idBolBD, $apontMecan);
                    }
                    else if($apontMecan->statusApontMecan == 3){
                        $apontMecanDAO->insApontMecanFechado($idBolBD, $apontMecan);
                    }
                }
                else{
                    if($apontMecan->statusApontMecan == 3){
                        $apontMecanDAO->updateApontMecan($idBolBD, $apontMecan);
                    }
                }
                $this->idApontMecanArray[] = array("idApontMecan" => $apontMecan->idApontMecan);
            }
        }

    }
    
    private function salvarImplMM($idApontaBD, $idApontaCel, $dadosImplemento) {
        $implementoMMDAO = new ImplementoMMDAO();
        foreach ($dadosImplemento as $imp) {
            if ($idApontaCel == $imp->idApontMMFert) {
                $v = $implementoMMDAO->verifImplementoMM($idApontaBD, $imp);
                if ($v == 0) {
                    $implementoMMDAO->insImplementoMM($idApontaBD, $imp);
                }
                $this->idApontImplArray[] = array("idApontImplMM" => $imp->idApontImplMM);
            }
        }
    }

    private function salvarBoletimPneu($idBolBD, $idBolCel, $dadosBolPneu, $dadosItemCalibPneu, $dadosItemManutPneu, $tipoAplic) {
        $boletimPneuDAO = new BoletimPneuDAO();
        foreach ($dadosBolPneu as $bolPneu) {
            if ($idBolCel == $bolPneu->idBolMMFertPneu) {
                $v = $boletimPneuDAO->verifBoletimPneu($idBolBD, $bolPneu);
                if ($v == 0) {
                    $boletimPneuDAO->insBoletimPneu($idBolBD, $bolPneu, $tipoAplic);
                    $idBolPneu = $boletimPneuDAO->idBoletimPneu($idBolBD, $bolPneu);
                    $this->salvarItemMedPneu($idBolPneu, $bolPneu->idBolPneu, $dadosItemCalibPneu);
                    $this->salvarItemManutPneu($idBolPneu, $bolPneu->idBolPneu, $dadosItemManutPneu);
                }
                $this->idBolPneuArray[] = array("idBolPneu" => $bolPneu->idBolPneu);
            }
        }
    }

    private function salvarItemMedPneu($idBolPneuBD, $idBolPneuCel, $dadosItemCalibPneu) {
        $itemMedPneuDAO = new ItemMedPneuDAO();
        foreach ($dadosItemCalibPneu as $itemCalibPneu) {
            if ($idBolPneuCel == $itemCalibPneu->idBolItemCalibPneu) {
                $v = $itemMedPneuDAO->verifItemMedPneu($idBolPneuBD, $itemCalibPneu);
                if ($v == 0) {
                    $itemMedPneuDAO->insItemMedPneu($idBolPneuBD, $itemCalibPneu);
                }
            }
        }
    }
    
    private function salvarItemManutPneu($idBolPneuBD, $idBolPneuCel, $dadosItemManutPneu) {
        $itemManutPneuDAO = new ItemManutPneuDAO();
        foreach ($dadosItemManutPneu as $itemManutPneu) {
            if ($idBolPneuCel == $itemManutPneu->idBolItemManutPneu) {
                $v = $itemManutPneuDAO->verifItemManutPneu($idBolPneuBD, $itemManutPneu);
                if ($v == 0) {
                    $itemManutPneuDAO->insItemManutPneu($idBolPneuBD, $itemManutPneu);
                }
            }
        }
    }
    
    private function salvarCarreg($idApontBD, $idApontCel, $dadosCarreg) {
        $carregDAO = new CarregDAO();
        $tipo = 0;
        foreach ($dadosCarreg as $carreg) {
            if ($idApontCel == $carreg->idApontCarreg) {
                $tipo = $carreg->tipoCarreg;
                if ($carreg->tipoCarreg == 1) {
                    $carregDAO->updDescarregProd($idApontBD, $carreg);
                } else {
                    $v = $carregDAO->verifCarregComp($carreg);
                    $carregDAO->cancelCarregComp($carreg);
                    if ($v == 0) {
                        $carregDAO->insCarregComp($idApontBD, $carreg);
                    }
                }
                $this->idCarregArray[] = array("idCarreg" => $carreg->idCarreg);
            }
        }
    }
    
    private function salvarMovLeiraMM($idBolBD, $idBolCel, $dadosMovLeira) {
        $leiraDAO = new LeiraDAO;
        foreach ($dadosMovLeira as $movleira) {
            if ($idBolCel == $movleira->idBolMMFert) {
                $v = $leiraDAO->verifMovLeiraMM($idBolBD, $movleira);
                if ($v == 0) {
                    $leiraDAO->insMovLeiraMM($idBolBD, $movleira);
                }
                $this->idMovLeiraArray[] = array("idMovLeira" => $movleira->idMovLeira);
            }
        }
    }
        
    private function salvarRendMM($idBolBD, $idBolCel, $dadosRendimento) {
        $rendimentoMMDAO = new RendimentoMMDAO();
        foreach ($dadosRendimento as $rend) {
            if ($idBolCel == $rend->idBolMMFert) {
                $v = $rendimentoMMDAO->verifRendimentoMM($idBolBD, $rend);
                if ($v == 0) {
                    $rendimentoMMDAO->insRendimentoMM($idBolBD, $rend);
                }
                $this->idRendArray[] = array("idRendMM" => $rend->idRendMM);
            }
        }
    }
    
    private function salvarRecolhFert($idBolBD, $idBolCel, $dadosRecolhimento) {
        $recolhimentoFertDAO = new RecolhimentoFertDAO();
        foreach ($dadosRecolhimento as $recolh) {
            if ($idBolCel == $recolh->idBolMMFert) {
                $v = $recolhimentoFertDAO->verifRecolhimentoFert($idBolBD, $recolh);
                if ($v == 0) {
                    $recolhimentoFertDAO->insRecolhimentoFert($idBolBD, $recolh);
                }
                $this->idRecolhArray[] = array("idRecolhFert" => $recolh->idRecolhFert);
            }
        }
    }
    
    public function dados($info) {

        $atualAplicCTR = new AtualAplicCTR();
        
        if($atualAplicCTR->verifToken($info)){
            
            $motoMecDAO = new MotoMecDAO();

            $dados = array("dados" => $motoMecDAO->dados());
            $json_str = json_encode($dados);

            return $json_str;
        
        }

    }
    
}
