<?php
namespace Clases;
use \App\IPersiste;
use \Model\TipovehModel;
class TipoVehiculo implements IPersiste
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
    public function equals(TipoVehiculo $obj){
        return $this->nombre == $obj->nombre;                
    }
    public function save(){
        return ($this->id == 0) ? (new TipovehModel())->create($this) : (new TipovehModel())->update($this); 
    }
    public function del(){
        return (new TipovehModel())->delete($this);
    }
    public function find($criterio = null){
        return (new TipovehModel())->find();
    }
    public function findById($id){
        return (new TipovehModel())->findById($id);
    }
}