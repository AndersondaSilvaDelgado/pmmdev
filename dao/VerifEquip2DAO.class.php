<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'Conn.class.php';
/**
 * Description of VerEquip
 *
 * @author anderson
 */
class VerifEquip2DAO extends Conn {
    //put your code here

    /** @var PDOStatement */
    private $Read;

    /** @var PDO */
    private $Conn;

    public function dados($valor) {

        $this->Conn = parent::getConn();
        
        $select = " SELECT "
                . " E.EQUIP_ID AS \"idEquip\" "
                . " , E.NRO_EQUIP AS \"codEquip\" "
                . " , E.CLASSOPER_CD AS \"codClasseEquip\" "
                . " , CARACTER(E.CLASSOPER_DESCR) AS \"descrClasseEquip\" "
                . " , E.TPTUREQUIP_CD AS \"codTurno\" "
                . " , NVL(C.PLMANPREV_ID, 0) AS \"idChecklist\" "
                . " , CASE WHEN E.CLASSOPER_CD = 211 AND R.TP_EQUIP IS NULL THEN 4  "
                . " ELSE NVL(R.TP_EQUIP, 0) END AS \"tipoEquipFert\" "
                . " , NVL(PBH.HOD_HOR_FINAL, 0) AS \"horimetroEquip\" "
                . " , NVL(PBFH.HOD_HOR_FINAL, 0) AS \"medicaoEquipFert\" "
                . " FROM "
                . " USINAS.V_SIMOVA_EQUIP E "
                . " , USINAS.V_EQUIP_PLANO_CHECK C "
                . " , USINAS.ROLAO R "
                . " , (SELECT PB.EQUIP_ID, PB.HOD_HOR_FINAL "
                        . " FROM INTERFACE.PMM_BOLETIM PB "
                        . " WHERE PB.ID IN "
                            . " (SELECT MAX(PB2.ID) "
                            . " FROM PMM_BOLETIM PB2"
                            . " GROUP BY PB2.EQUIP_ID)) PBH "
                . " , (SELECT PBF.EQUIP_ID, PBF.HOD_HOR_FINAL "
                        . " FROM INTERFACE.PMM_BOLETIM_FERT PBF "
                        . " WHERE PBF.ID IN "
                            . " (SELECT MAX(PBF2.ID) "
                            . " FROM PMM_BOLETIM_FERT PBF2 "
                            . " GROUP BY PBF2.EQUIP_ID)) PBFH "
                . " WHERE  "
                . " E.NRO_EQUIP = " . $valor
                . " AND E.NRO_EQUIP = C.EQUIP_NRO(+) "
                . " AND E.EQUIP_ID = R.EQUIP_ID(+) "
                . " AND E.EQUIP_ID = PBH.EQUIP_ID(+) "
                . " AND E.EQUIP_ID = PBFH.EQUIP_ID(+) ";
        
        $this->Read = $this->Conn->prepare($select);
        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
        $this->Read->execute();
        $r1 = $this->Read->fetchAll();

        $dados = array("dados"=>$r1);
        $res1 = json_encode($dados);
        
        $select = " SELECT "
                    . " ROWNUM AS \"idEquipAtiv\" "
                    . " , VE.EQUIP_ID AS \"idEquip\" "
                    . " , AA.ATIVAGR_ID AS \"idAtiv\" "
                . " FROM "
                    . " V_SIMOVA_EQUIP VE "
                    . " , V_SIMOVA_MODELO_ATIVAGR VA "
                    . " , V_SIMOVA_ATIVAGR_NEW AA "
                . " WHERE "
                . " VE.NRO_EQUIP = " . $valor . ""
                . " AND "
                . " VE.MODELEQUIP_ID = VA.MODELEQUIP_ID "
                . " AND "
                . " VA.ATIVAGR_CD = AA.ATIVAGR_CD "
                . " AND "
                . " AA.DESAT = 0 " 
                . " ORDER BY ROWNUM ASC "
                ;
        $this->Read = $this->Conn->prepare($select);
        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
        $this->Read->execute();
        $r2 = $this->Read->fetchAll();
        
        $dados = array("dados"=>$r2);
        $res2 = json_encode($dados);

        $select = " SELECT " 
                    . " ROWNUM AS \"idRAtivParada\" "
                    . " , AA.ATIVAGR_ID AS \"idAtiv\" "
                    . " , MOT.MOTPARADA_ID AS \"idParada\" "
                    . " FROM " 
                    . " V_SIMOVA_EQUIP VE " 
                    . " , V_SIMOVA_MODELO_ATIVAGR VA " 
                    . " , V_SIMOVA_ATIVAGR_NEW AA " 
                    . " , USINAS.R_ATIVAGR_MOTPARADA MOT " 
                    . " WHERE " 
                    . " VE.NRO_EQUIP = " . $valor . ""
                    . " AND " 
                    . " VE.MODELEQUIP_ID = VA.MODELEQUIP_ID " 
                    . " AND " 
                    . " VA.ATIVAGR_CD = AA.ATIVAGR_CD " 
                    . " AND " 
                    . " MOT.ATIVAGR_ID = AA.ATIVAGR_ID " 
                    . " AND " 
                    . " AA.DESAT = 0 ";
        
        $this->Read = $this->Conn->prepare($select);
        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
        $this->Read->execute();
        $r3 = $this->Read->fetchAll();
        
        $dados = array("dados"=>$r3);
        $res3 = json_encode($dados);
        
        $select = " SELECT " 
                    . " VEP.POSPNCONF_ID AS \"idPosConfPneu\" "
                    . " , VEP.POS_PNEU AS \"posPneu\" "
                    . " FROM " 
                    . " VMB_EQUIP_PNEU VEP "
                    . " , EQUIP E"
                    . " WHERE"
                    . " E.NRO_EQUIP = " . $valor
                    . " AND "
                    . " VEP.EQUIP_ID = E.EQUIP_ID ";
        
        $this->Read = $this->Conn->prepare($select);
        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
        $this->Read->execute();
        $r4 = $this->Read->fetchAll();
        
        $dados = array("dados"=>$r4);
        $res4 = json_encode($dados);
        
        return $res1 . "#" . $res2 . "|" . $res3 . "_" . $res4;
//        return $res1 . "#" . $res2 . "|" . $res3;
        
    }

}