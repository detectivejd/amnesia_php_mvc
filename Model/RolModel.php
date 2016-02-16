<?php
namespace Model;
use \Clases\Rol;
class RolModel extends AppModel
{
    function __construct() {
        parent::__construct();
    }
    protected function getCreateParameter($object) {
        return array($object->getNombre());
    }
    protected function getCreateQuery() {
        return "insert into roles(rolNombre) values(?)";
    }
    protected function getUpdateQuery(){
        return "update roles set rolNombre=? where rolId=?";
    }
    protected function getUpdateParameter($object){
        return array($object->getNombre(),$object->getId());
    }
    protected function getCheckMessage() {
        return "El Rol ya Existe";
    }
    protected function getCheckParameter($unique) {
        return [$unique->getNombre()];
    }
    protected function getCheckQuery() {
        return 'SELECT rolId FROM roles WHERE rolNombre = ?'; 
    }
    public function createEntity($row) {
        $obj = new Rol();
        $obj->setId($row['rolId']);
        $obj->setNombre($row['rolNombre']);
        return $obj;
    }
    protected function getFindXIdQuery() {
        return "SELECT * FROM roles WHERE rolId = ?";
    }
    protected function getFindParameter($criterio = null) {
        return [$criterio];
    }
    protected function getFindQuery($criterio = null) {
        return "select * from roles";
    }
    protected function getDeleteParameter($object) {
        return array($object->getId());
    }
    protected function getDeleteQuery($notUsed = true) {
        $sql = "DELETE FROM roles WHERE rolId = ?";
        if ($notUsed === true) {
            $sql .= ' AND rolId NOT IN (SELECT DISTINCT rolId FROM usuarios)';
        }
        return $sql;
    }
}