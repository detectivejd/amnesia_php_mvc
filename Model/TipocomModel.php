<?php
namespace Model;
use \Clases\TipoCompra;
class TipocomModel extends AppModel
{
    function __construct() {
        parent::__construct();
    }
    
    public function createEntity($row) {
        $obj = new TipoCompra();
        $obj->setId($row['tcId']);
        $obj->setNombre($row['tcNombre']);
        return $obj;
    }

    protected function getCheckMessage() {
        return  'El Tipo de compra ya existe';
    }

    protected function getCheckParameter($unique) {
        return [$unique->getNombre()];
    }

    protected function getCheckQuery() {
        return 'SELECT tcId FROM tipo_compras WHERE tcNombre = ?';
    }

    protected function getCreateParameter($object) {
        return array($object->getNombre());
    }

    protected function getCreateQuery() {
        return "insert into tipo_compras(tcNombre) values(?)";
    }

    protected function getDeleteParameter($object) {
        return array($object->getId());
    }

    protected function getDeleteQuery($notUsed = true) {
        $sql="delete from tipo_compras where tcId=?";
        if ($notUsed === true) {
            $sql .= ' AND tcId NOT IN (SELECT DISTINCT tcId FROM compras)';
        }
        return $sql;
    }

    protected function getFindParameter($criterio = null) {
        return [$criterio];
    }

    protected function getFindQuery($criterio = null) {
        return "select * from tipo_compras";        
    }

    protected function getFindXIdQuery() {
        return "SELECT * FROM tipo_compras WHERE tcId = ?";
    }

    protected function getUpdateParameter($object) {
        return array($object->getNombre(),$object->getId());
    }

    protected function getUpdateQuery() {
        return "update tipo_compras set tcNombre=? where tcId=?";
    }
}