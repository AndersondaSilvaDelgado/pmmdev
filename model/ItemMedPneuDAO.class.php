<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of ItemMedPneuDAO
 *
 * @author anderson
 */
class ItemMedPneuDAO extends Conn {
    //put your code here
    
    
    public function verifItemMedPneu($idBolPneu, $itemPneu, $base) {

        $select = " SELECT "
                . " COUNT(*) AS QTDE "
                . " FROM "
                . " PMP_ITEM_MED "
                . " WHERE "
                . " BOLETIM_ID = " . $idBolPneu
                . " AND "
                . " CEL_ID = " . $itemPneu->idItemMedPneu;

        $this->Conn = parent::getConn($base);
        $this->Read = $this->Conn->prepare($select);
        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
        $this->Read->execute();
        $result = $this->Read->fetchAll();

        foreach ($result as $item) {
            $v = $item['QTDE'];
        }

        return $v;
    }

    public function insItemMedPneu($idBolPneu, $itemPneu, $base) {

        $sql = "INSERT INTO PMP_ITEM_MED ("
                . " BOLETIM_ID "
                . " , POSPNCONF_ID "
                . " , NRO_PNEU "
                . " , PRESSAO_ENC "
                . " , PRESSAO_COL "
                . " , DTHR "
                . " , DTHR_CEL "
                . " , DTHR_TRANS "
                . " , CEL_ID "
                . " ) "
                . " VALUES ("
                . " " . $idBolPneu
                . " , " . $itemPneu->idPosConfPneu
                . " , '" . $itemPneu->nroPneuItemMedPneu . "'"
                . " , " . $itemPneu->pressaoEncItemMedPneu
                . " , " . $itemPneu->pressaoColItemMedPneu
                . " , TO_DATE('" . $itemPneu->dthrItemMedPneu . "','DD/MM/YYYY HH24:MI') "
                . " , TO_DATE('" . $itemPneu->dthrItemMedPneu . "','DD/MM/YYYY HH24:MI') "
                . " , SYSDATE "
                . " , " . $itemPneu->idItemMedPneu
                . " )";

        $this->Conn = parent::getConn($base);
        $this->Create = $this->Conn->prepare($sql);
        $this->Create->execute();
        
    }
    
}
