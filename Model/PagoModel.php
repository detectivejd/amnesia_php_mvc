<?php
namespace Model;
use Clases\Pago;
class PagoModel extends AppModel
{
    function __construct() {
        parent::__construct();
    }
    public function add_pago($com,$pago){
        return $this->executeQuery(
            "insert into pagos(comId,pagId,pagFecPago,pagFecVenc,pagMonto,pagCuotas) values(?,?,?,?,?,?)",
            array(
                $com->getId(),$pago->getId(),$pago->getFecpago(),
                $pago->getFecvenc(),$pago->getMonto(),$pago->getCuotas()
            )
        );        
    }
    public function del_pago($com,$pago){
        return $this->executeQuery(
            "delete from pagos where comId=? and pagId=?",
            array($com->getId(),$pago->getId())
        );
    }
    public function find_pago($com_id,$pago_id){
        $consulta = $this->fetch(
            "select * from pagos where comId=? and pagId=?", 
            array($com_id,$pago_id)
        );
        if(count($consulta) > 0) {
            $row = $consulta[0];
            return $this->createEntity($row);  
        }
        else {
            return null;
        }
    }
    public function find_max_pago($com){
        $consulta = $this->fetch(
            "SELECT max(pagId) as pago from pagos where comId = ?", 
            array($com)
        );
        return $consulta[0]['pago'] +1;
    }
    public function find_sum_cuotas($com){
        $consulta = $this->fetch(
            "SELECT sum(pagCuotas) as cuotas from pagos where comId = ?", 
            array($com)
        );
        return $consulta[0]['cuotas'];
    }
    public function check_fec_venc($com){
        $consulta = $this->fetch(
            "SELECT pagFecVenc as vence from pagos where comId = ? order by pagId desc limit 0,1", 
            array($com)
        );
        return count($this->find_pagos($com))>0 and date("Y-m-d") > $consulta[0]['vence'];
    }
    public function find_pagos($com){
        $datos = array();
        $consulta = $this->fetch(
            "SELECT * from pagos where comId = ? order by pagId desc", 
            [$com]
        );
        foreach($consulta as $row){
            $pago = $this->createEntity($row); 
            array_push($datos, $pago); 
        } 
        return $datos;
    }
    public function createEntity($row) { 
        return new Pago($row['pagId'], $row['pagFecPago'], $row['pagFecVenc'], $row['pagMonto'],$row['pagCuotas']);
    }
    
    protected function getCheckMessage() { }
    protected function getCheckParameter($unique) { }
    protected function getCheckQuery() { }
    protected function getCreateParameter($object) { }
    protected function getCreateQuery() { }
    protected function getDeleteParameter($object) { }
    protected function getDeleteQuery($notUsed = true) { }
    protected function getFindParameter($criterio = null) { }
    protected function getFindQuery($criterio = null) { }
    protected function getFindXIdQuery() { }
    protected function getUpdateParameter($object) { }
    protected function getUpdateQuery() { }
}