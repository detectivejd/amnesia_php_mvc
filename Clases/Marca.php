<?php
namespace Clases;
use \App\IPersiste;
use \Model\MarcaModel;
class Marca implements IPersiste
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
    public function equals(Marca $obj){
        return $this->nombre == $obj->nombre;                
    }
    public function save(){
        return ($this->id == 0) ? (new MarcaModel())->create($this) : (new MarcaModel())->update($this); 
    }
    public function del(){
        return (new MarcaModel())->delete($this);
    }
    public function find($criterio = null){
        return (new MarcaModel())->find($criterio); 
    }
    public function findById($id){
        return (new MarcaModel())->findById($id);
    }
}