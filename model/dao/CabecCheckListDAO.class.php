<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once './dbutil/Conn.class.php';
require_once 'AjusteDataHoraDAO.class.php';
/**
 * Description of CabecChecklist
 *
 * @author anderson
 */
class CabecCheckListDAO extends Conn {

    //put your code here

    public function verifCabecCheckList($d) {

        $ajusteDataHoraDAO = new AjusteDataHoraDAO();

        $select = " SELECT "
                . " COUNT(*) AS QTDE "
                . " FROM "
                . " BOLETIM_CHECK "
                . " WHERE "
                . " DT = " . $ajusteDataHoraDAO->dataHoraNroEquip($d->equipCab, $d->dtCab)
                . " AND "
                . " EQUIP_NRO = " . $d->equipCab . " ";

        $this->Conn = parent::getConn();
        $this->Read = $this->Conn->prepare($select);
        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
        $this->Read->execute();
        $result = $this->Read->fetchAll();

        foreach ($result as $item) {
            $v = $item['QTDE'];
        }

        return $v;
    }

    public function idCabecCheckList($d) {

        $ajusteDataHoraDAO = new AjusteDataHoraDAO();

        $select = " SELECT "
                . " ID_BOLETIM AS ID "
                . " FROM "
                . " BOLETIM_CHECK "
                . " WHERE "
                . " DT = " . $ajusteDataHoraDAO->dataHoraNroEquip($d->equipCab, $d->dtCab)
                . " AND "
                . " EQUIP_NRO = " . $d->equipCab . " ";

        $this->Read = $this->Conn->prepare($select);
        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
        $this->Read->execute();
        $result = $this->Read->fetchAll();

        foreach ($result as $item) {
            $id = $item['ID'];
        }

        return $id;
        
    }
    
    public function insCabecCheckList($d) {

        $ajusteDataHoraDAO = new AjusteDataHoraDAO();

        $select = " SELECT "
                . " NRO_TURNO "
                . " FROM "
                . " USINAS.TURNO_TRAB "
                . " WHERE TURNOTRAB_ID = " . $d->turnoCab;

        $this->Read = $this->Conn->prepare($select);
        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
        $this->Read->execute();
        $result = $this->Read->fetchAll();

        foreach ($result as $item) {
            $turno = $item['NRO_TURNO'];
        }

        $sql = " INSERT INTO BOLETIM_CHECK ( "
                . " EQUIP_NRO "
                . " , FUNC_CD "
                . " , DT "
                . " , NRO_TURNO "
                . " ) "
                . " VALUES ( "
                . " " . $d->equipCab . " "
                . " , " . $d->funcCab . ""
                . " , " . $ajusteDataHoraDAO->dataHoraNroEquip($d->equipCab, $d->dtCab)
                . " , " . $turno . ")";

        $this->Create = $this->Conn->prepare($sql);
        $this->Create->execute();

        if ($d->dtAtualCab != "0") {

            $sql = " UPDATE USINAS.ATUALIZA_CHECKLIST_MOBILE  "
                    . " SET DT_MOBILE = TO_DATE('" . $d->dtAtualCab . "','DD/MM/YYYY HH24:MI') "
                    . " WHERE EQUIP_NRO = " . $d->equipCab;

            $this->Create = $this->Conn->prepare($sql);
            $this->Create->execute();
        }
    }

}