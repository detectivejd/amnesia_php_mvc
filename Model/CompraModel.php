<?php
namespace Model;
use \Clases\Compra;
class CompraModel extends AppModel
{
    private $mod_u;
    private $mod_v;
    private $mod_tc;
    private $mod_p;
    function __construct() {
        parent::__construct();
        $this->mod_u = new UsuarioModel();
        $this->mod_tc = new TipocomModel();
        $this->mod_v = new VehiculoModel();
        $this->mod_p = new PagoModel();
    }
    public function findByClientes($criterio){
        $datos= array();        
        $consulta = $this->fetch(
            "SELECT u.usuId as id, u.usuNick as nick, u.usuPass as pass, u.usuMail as mail, u.usuNombre as nom, "
                . "u.usuApellido as ape, u.usuStatus as status, u.rolId as rol from usuarios u "
                . "inner join roles r on u.rolId = r.rolId where u.usuStatus = 1 and not r.rolNombre = 'admin' "
                . "and u.usuNick like ? limit 0,10", 
            ["%".$criterio."%"]
        );
        foreach($consulta as $row){
            $usuario = $this->mod_u->createEntity($row);
            array_push($datos,$usuario);
        }
        return $datos;
    }
    public function findByVeh($criterio){
        $datos= array();
        $consulta = $this->fetch(
                "select * from vehiculos where vehCantidad > 0 and vehMatricula like ? limit 0,10", 
                ["%".$criterio."%"]
        );
        foreach($consulta as $row){
            $veh = $this->mod_v->createEntity($row); 
            array_push($datos, $veh);
        }
        return $datos;
    }    
    
    public function add_pago($com,$pago){
        return $this->mod_p->add_pago($com, $pago);
    }
    public function del_pago($com,$pago){
        return $this->mod_p->del_pago($com, $pago);
    }
    public function find_pago($com_id,$pago_id){
        return $this->mod_p->find_pago($com_id, $pago_id);
    }
    public function find_max_pago($com){
        return $this->mod_p->find_max_pago($com);
    }
    public function find_sum_cuotas($com){
        return $this->mod_p->find_sum_cuotas($com);
    }
    public function find_pagos($com){
        return $this->mod_p->find_pagos($com);
    }
    public function check_fec_venc($com){
        return $this->mod_p->check_fec_venc($com);
    }

    public function createEntity($row) {
        $tipo = $this->mod_tc->findById($row['tipoc']);
        $user = $this->mod_u->findById($row['usuario']);
        $veh = $this->mod_v->findById($row['veh']);
        $obj = new Compra();
        $obj->setId($row['id']);
        $obj->setFecha($row['fecha']);
        $obj->setCuotas($row['cuotas']);
        $obj->setCant($row['cant']);
        $obj->setTipo($tipo);
        $obj->setUser($user);
        $obj->setVeh($veh);
        $obj->setPagos($this->find_pagos($obj->getId()));
        return $obj;
    }
    
    protected function getCreateParameter($object) { 
        return [
            $object->getTipo()->getId(),$object->getUser()->getId(),
            $object->getVeh()->getId(),$object->getFecha(),$object->getCuotas(),
            $object->getCant()
        ];
    }

    protected function getCreateQuery() {
        return "insert into compras(tcId,usuId,vehId,comFecha,comCuotas,comCantidad) values(?,?,?,?,?,?)";
    }

    protected function getFindParameter($criterio = null) {
        return ["%".$criterio."%"];
    }

    protected function getFindQuery($criterio = null) {
        return "select c.comId as id, c.tcId as tipoc, c.usuId as usuario, c.vehId as veh, "
        . "c.comFecha as fecha, c.comCuotas as cuotas, c.comCantidad as cant from compras c "
        . "inner join usuarios u on c.usuId = u.usuId where u.usuNick like ?";
    }

    protected function getFindXIdQuery() {
        return "select c.comId as id, c.tcId as tipoc, c.usuId as usuario, c.vehId as veh, "
        . "c.comFecha as fecha, c.comCuotas as cuotas, c.comCantidad as cant from compras c "
        . "where c.comId = ?";
    }

    protected function getUpdateParameter($object) {
        return [
            $object->getTipo()->getId(),$object->getUser()->getId(),$object->getVeh()->getId(),
            $object->getFecha(),$object->getCuotas(),$object->getCant(),$object->getId()
        ];
    }

    protected function getUpdateQuery() {
        return "update compras set tcId=?,usuId=?,vehId=?,comFecha=?,comCuotas=?,comCantidad=? where comId=?";
    }
    
    protected function getDeleteParameter($object) { }
    protected function getDeleteQuery($notUsed = true) { }        
    protected function getCheckMessage() { }
    protected function getCheckParameter($unique) { }
    protected function getCheckQuery() { }
}