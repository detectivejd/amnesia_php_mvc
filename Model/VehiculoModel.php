<?php
namespace Model;
use \Clases\Vehiculo;
class VehiculoModel extends AppModel
{
    private $mod_tv;
    private $mod_mod;
    function __construct() {
        parent::__construct();
        $this->mod_tv = new TipovehModel();
        $this->mod_mod = new ModeloModel();
    }  
    public function findByModelos($criterio){
        $datos= array();
        $consulta = $this->fetch(
            "select * from modelos where modNombre like ? limit 0,10", 
            array("%".$criterio."%")
        );
        foreach($consulta as $row){
            $modelo = $this->mod_mod->createEntity($row); 
            array_push($datos,$modelo);
        }
        return $datos;
    }
    public function updateImg($veh){
        return $this->executeQuery(
            "update vehiculos set vehFoto=? where vehId=?", 
            array($veh->getFoto(),$veh->getId())
        );
    }
    public function reactive($veh){
        return $this->executeQuery(
            "update vehiculos set vehStatus=1 where vehId=?", 
            array($veh->getId())
        );        
    }
    public function createEntity($row) {
        $tipo = $this->mod_tv->findById($row['tvId']); 
        $modelo = $this->mod_mod->findById($row['modId']);
        $obj = new Vehiculo();
        $obj->setId($row['vehId']);
        $obj->setMat($row['vehMatricula']);
        $obj->setPrecio($row['vehPrecio']);
        $obj->setCant($row['vehCantidad']);
        $obj->setDescrip($row['vehDescrip']);
        $obj->setFoto($row['vehFoto']);
        $obj->setStatus($row['vehStatus']);
        $obj->setModelo($modelo);
        $obj->setTipo($tipo);
        return $obj;
    }

    protected function getCheckMessage() {
        return "El Vehículo ya existe";
    }
    protected function getCheckParameter($unique) {
        return [$unique->getMat()];
    }
    protected function getCheckQuery() {
        return 'SELECT vehId FROM vehiculos WHERE vehMatricula = ?';
    }

    protected function getCreateParameter($object) {
        return array(
            $object->getMat(),$object->getPrecio(),$object->getCant(),$object->getDescrip(),
            $object->getFoto(),$object->getModelo()->getId(),$object->getTipo()->getId()
        );
    }

    protected function getCreateQuery() {
        return "insert into vehiculos(vehMatricula,vehPrecio,vehCantidad,vehDescrip,vehFoto,modId,tvId) values(?,?,?,?,?,?,?)";
    }

    protected function getDeleteParameter($object) {
        return array($object->getId());
    }

    protected function getDeleteQuery($notUsed = true) {
        return "update vehiculos set vehStatus=0 where vehId=?";
    }

    protected function getFindParameter($criterio = null) {
        return array("%".$criterio."%");
    }

    protected function getFindQuery($criterio = null) {
        return ($criterio == null) ? "select * from vehiculos" : "select * from vehiculos where vehMatricula like ?";
    }

    protected function getFindXIdQuery() {
        return "select * from vehiculos WHERE vehId = ?";
    }

    protected function getUpdateParameter($object) {
        return array(
            $object->getMat(),$object->getPrecio(),$object->getCant(),$object->getDescrip(),
            $object->getModelo()->getId(),$object->getTipo()->getId(),$object->getId()
        );
    }

    protected function getUpdateQuery() {
        return "update vehiculos set vehMatricula=?,vehPrecio=?,vehCantidad=?,vehDescrip=?,modId=?,tvId=? where vehId=?";
    }    
}