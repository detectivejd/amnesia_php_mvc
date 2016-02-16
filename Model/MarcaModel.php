<?php
namespace Model;
use \Clases\Marca;
class MarcaModel extends AppModel
{
    function __construct() {
        parent::__construct();
    }
    public function createEntity($row) {
        $obj = new Marca();
        $obj->setId($row['marId']);
        $obj->setNombre($row['marNombre']);
        return $obj;
    }
    protected function getCheckMessage() {
        return 'La Marca ya existe';
    }

    protected function getCheckParameter($unique) {
        return [$unique->getNombre()];
    }

    protected function getCheckQuery() {
        return 'SELECT marId FROM marcas WHERE marNombre = ?';
    }

    protected function getCreateParameter($object) {
        return array($object->getNombre());
    }

    protected function getCreateQuery() {
        return "insert into marcas(marNombre) values(?)";
    }

    protected function getDeleteParameter($object) {
        return array($object->getId());
    }

    protected function getDeleteQuery($notUsed = true) {
        $sql="delete from marcas where marId=?";
        if ($notUsed === true) {
            $sql .= ' AND marId NOT IN (SELECT DISTINCT marId FROM modelos)';
        }
        return $sql;
    }

    protected function getFindParameter($criterio = null) {
        return array("%".$criterio."%");
    }

    protected function getFindQuery($criterio = null) {
        return "select * from marcas where marNombre like ?";
    }

    protected function getFindXIdQuery() {
        return "SELECT * FROM marcas WHERE marId = ?";
    }

    protected function getUpdateParameter($object) {
        return array($object->getNombre(),$object->getId());
    }

    protected function getUpdateQuery() {
        return "update marcas set marNombre=? where marId=?";
    }
}