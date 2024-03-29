<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../dbutil/Conn.class.php');

/**
 * Description of ImplementoDAO
 *
 * @author anderson
 */
class ImplementoMMDAO extends Conn {

    public function verifImplementoMM($idApont, $imp) {

        $select = " SELECT "
                        . " COUNT(*) AS QTDE "
                    . " FROM "
                        . " PMM_IMPLEMENTO "
                    . " WHERE "
                        . " APONTAMENTO_ID = " . $idApont
                        . " AND "
                        . " ID_CEL = " . $imp->idApontImplMM;

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

    public function insImplementoMM($idApont, $imp) {

        $sql = "INSERT INTO PMM_IMPLEMENTO ("
                . " APONTAMENTO_ID "
                . " , NRO_EQUIP "
                . " , POS_EQUIP "
                . " , DTHR "
                . " , DTHR_CEL "
                . " , DTHR_TRANS "
                . " , ID_CEL "
                . " ) "
                . " VALUES ("
                . " " . $idApont
                . " , " . $imp->codEquipImplMM
                . " , " . $imp->posImplMM
                . " , TO_DATE('" . $imp->dthrImplMM . "','DD/MM/YYYY HH24:MI')"
                . " , TO_DATE('" . $imp->dthrImplMM . "','DD/MM/YYYY HH24:MI')"
                . " , SYSDATE "
                . " , " . $imp->idApontImplMM
                . " )";

        $this->Conn = parent::getConn();
        $this->Create = $this->Conn->prepare($sql);
        $this->Create->execute();
    }

}
