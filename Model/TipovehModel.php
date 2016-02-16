<?php
namespace Model;
use \Clases\TipoVehiculo;
class TipovehModel extends AppModel
{
    function __construct() {
        parent::__construct();
    }
    public function createEntity($row) {
        $obj = new TipoVehiculo();
        $obj->setId($row['tvId']);
        $obj->setNombre($row['tvNombre']);
        return $obj;
    }

    protected function getCheckMessage() {
        return 'El Tipo de vehículo ya existe';
    }

    protected function getCheckParameter($unique) {
        return [$unique->getNombre()];
    }

    protected function getCheckQuery() {
        return 'SELECT tvId FROM tipo_vehiculos WHERE tvNombre = ?';
    }

    protected function getCreateParameter($object) {
        return array($object->getNombre());
    }

    protected function getCreateQuery() {
        return "insert into tipo_vehiculos(tvNombre) values(?)";
    }

    protected function getDeleteParameter($object) {
        return array($object->getId());
    }

    protected function getDeleteQuery($notUsed = true) {
        $sql="delete from tipo_vehiculos where tvId=?";
        if ($notUsed === true) {
            $sql .= ' AND tvId NOT IN (SELECT DISTINCT tvId FROM vehiculos)';
        }
        return $sql;
    }

    protected function getFindParameter($criterio = null) {
        return [$criterio];
    }

    protected function getFindQuery($criterio = null) {
        return "select * from tipo_vehiculos";
    }

    protected function getFindXIdQuery() {
        return "SELECT * FROM tipo_vehiculos WHERE tvId = ?";
    }

    protected function getUpdateParameter($object) {
        return array($object->getNombre(),$object->getId());
    }

    protected function getUpdateQuery() {
        return "update tipo_vehiculos set tvNombre=? where tvId=?";
    }
}