<?php
namespace Model;
use \Clases\Modelo;
class ModeloModel extends AppModel
{
    private $mod_mar;
    function __construct() {
        parent::__construct();
        $this->mod_mar = new MarcaModel();
    }
    public function findByMarcas($criterio){
        $datos= array();
        $consulta = $this->fetch(
            "select * from marcas where marNombre like ? limit 0,10", 
            array("%".$criterio."%")
        );
        foreach($consulta as $row){
            $marca = $this->mod_mar->createEntity($row);
            array_push($datos,$marca);
        }
        return $datos;
    }
    
    public function createEntity($row) {
        $marca = $this->mod_mar->findById($row['marId']);
        $obj = new Modelo();
        $obj->setId($row['modId']);
        $obj->setNombre($row['modNombre']);
        $obj->setMarca($marca);
        return $obj;
    }

    protected function getCheckMessage() {
        return 'El Modelo ya existe';
    }

    protected function getCheckParameter($unique) {
        return [$unique->getNombre()];
    }

    protected function getCheckQuery() {
        return 'SELECT modId FROM modelos WHERE modNombre = ?';
    }

    protected function getCreateParameter($object) {
        return array($object->getNombre(),$object->getMarca()->getId());
    }

    protected function getCreateQuery() {
        return "insert into modelos(modNombre,marId) values(?,?)";
    }

    protected function getDeleteParameter($object) {
        return array($object->getId());
    }

    protected function getDeleteQuery($notUsed = true) {
        $sql="delete from modelos where modId=?";
        if ($notUsed === true) {
            $sql .= ' AND modId NOT IN (SELECT DISTINCT modId FROM vehiculos)';
        }
        return $sql;
    }

    protected function getFindParameter($criterio = null) {
        return array("%".$criterio."%");
    }

    protected function getFindQuery($criterio = null) {
        return "select * from modelos where modNombre like ?";
    }

    protected function getFindXIdQuery() {
        return "SELECT * FROM modelos WHERE modId = ?";
    }

    protected function getUpdateParameter($object) {
        return array($object->getNombre(),$object->getMarca()->getId(),$object->getId());
    }

    protected function getUpdateQuery() {
        return "update modelos set modNombre=?,marId=? where modId=?";
    }    
}