<?php
namespace Clases;
use \App\IPersiste;
use \Model\ModeloModel;
class Modelo implements IPersiste
{
    private $id;
    private $nombre;
    private $marca;
    function getId() {
        return $this->id;
    }
    function getNombre() {
        return $this->nombre;
    }
    function getMarca() {
        return $this->marca;
    }
    function setId($id) {
        $this->id = $id;
    }
    function setNombre($nombre) {
        $this->nombre = strtoupper($nombre);
    }
    function setMarca($marca) {
        $this->marca = $marca;
    }
    function __construct() { }
    public function equals(Modelo $obj){
        return $this->nombre == $obj->nombre;                
    }
    public function save(){
        return ($this->id == 0) ? (new ModeloModel())->create($this) : (new ModeloModel())->update($this); 
    }
    public function del(){
        return (new ModeloModel())->delete($this);
    }
    public function find($criterio = null){
        return (new ModeloModel())->find($criterio); 
    }
    public function findById($id){
        return (new ModeloModel())->findById($id);
    }
    public function findByMarcas($criterio){
        return (new ModeloModel())->findByMarcas($criterio); 
    }
}