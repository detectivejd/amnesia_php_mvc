<?php
namespace Model;
class ConsultaModel extends AppModel
{
    private $mod_c;
    function __construct() {
        parent::__construct();
        $this->mod_c = new CompraModel();
    }
    public function cons1ByDay($user_id){        
        $datos= array();
        $consulta = $this->fetch(
            "select c.comId as id, c.tcId as tipoc, c.usuId as usuario, c.vehId as veh, c.comFecha as fecha,"
            . "c.comCuotas as cuotas, c.comCantidad as cant from compras c where c.comFecha = NOW() and c.usuId = ?",
            [$user_id]    
        );
        foreach($consulta as $row){
            $com = $this->mod_c->createEntity($row);
            array_push($datos, $com);          
        }
        return $datos;
    }
    public function cons1ByMonth($user_id){
        $datos= array();
        $consulta = $this->fetch(
            "select c.comId as id, c.tcId as tipoc, c.usuId as usuario, c.vehId as veh, c.comFecha as fecha,"
            . "c.comCuotas as cuotas, c.comCantidad as cant from compras c where "
            . "MONTH(c.comFecha) = MONTH(NOW()) and YEAR(c.comFecha) = YEAR(NOW()) and c.usuId = ?",
            [$user_id]    
        );
        foreach($consulta as $row){
            $com = $this->mod_c->createEntity($row);
            array_push($datos, $com);          
        }
        return $datos;
    }
    public function cons1ByYear($user_id){
        $datos= array();
        $consulta = $this->fetch(
            "select c.comId as id, c.tcId as tipoc, c.usuId as usuario, c.vehId as veh, c.comFecha as fecha,"
            . "c.comCuotas as cuotas, c.comCantidad as cant from compras c where "
            . "YEAR(c.comFecha) = YEAR(NOW()) and c.usuId = ?",
            [$user_id]    
        );
        foreach($consulta as $row){
            $com = $this->mod_c->createEntity($row);
            array_push($datos, $com);          
        }
        return $datos;
    }
    public function cons2($user_id){
        $datos= array();
        $consulta = $this->fetch(
            "select c.comId as id, c.tcId as tipoc, c.usuId as usuario, c.vehId as veh, c.comFecha as fecha,"
            . "c.comCuotas as cuotas, c.comCantidad as cant from compras c inner join pagos p on c.comId = p.comId "
            . "inner join vehiculos v on c.vehId = v.vehId where c.usuId = ? having c.comCuotas > max(p.pagId)",
            [$user_id]     
        );
        foreach($consulta as $row){
            $com = $this->mod_c->createEntity($row); 
            array_push($datos, $com);          
        }
        return $datos;
    }
    public function cons3($fec_ini,$fec_fin,$user_id){
        $datos= array();
        $consulta = $this->fetch(
            "select c.comId as id, c.tcId as tipoc, c.usuId as usuario, c.vehId as veh, "
            . "c.comFecha as fecha, c.comCuotas as cuotas, c.comCantidad as cant from compras c "
            . "where c.comFecha between ? and ? and c.usuId = ?", 
            [$fec_ini,$fec_fin,$user_id]
        );
        foreach($consulta as $row){
            $com = $this->mod_c->createEntity($row);
            array_push($datos, $com);          
        }
        return $datos;
    }
    public function cons4($user_id){
        $datos= array();
        $consulta = $this->fetch(
            "select c.comId as id, c.tcId as tipoc, c.usuId as usuario, c.vehId as veh, "
            . "c.comFecha as fecha, c.comCuotas as cuotas, c.comCantidad as cant from compras c "
            . "where c.usuId = ?",
            [$user_id]    
        );
        foreach($consulta as $row){
            $com= $this->mod_c->createEntity($row);
            array_push($datos, $com);          
        }
        return $datos;
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
    public function createEntity($row) { }
}