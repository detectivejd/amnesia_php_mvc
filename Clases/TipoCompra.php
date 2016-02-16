<?php
namespace Clases;
use \App\IPersiste;
use \Model\TipocomModel;
class TipoCompra implements IPersiste
{
    private $id;
    private $nombre;
    function getId() {
        return $this->id;
    }
    function getNombre() {
        return $this->nombre;
    }    
    function setId($id) {
        $this->id = $id;
    }
    function setNombre($nombre) {
        $this->nombre = strtoupper($nombre);
    }
    function __construct() { }
    public function equals(TipoCompra $obj){
        return $this->nombre == $obj->nombre;                
    }
    public function save(){
        return ($this->id == 0) ? (new TipocomModel())->create($this) : (new TipocomModel())->update($this); 
    }
    public function del(){
        return (new TipocomModel())->delete($this);
    }
    public function find($criterio = null){
        return (new TipocomModel())->find();
    }
    public function findById($id){
        return (new TipocomModel())->findById($id);
    }
}