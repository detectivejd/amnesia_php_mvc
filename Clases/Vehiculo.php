<?php
namespace Clases;
use \App\IPersiste;
use \Model\VehiculoModel;
class Vehiculo implements IPersiste
{
    private $id;
    private $mat;
    private $precio;
    private $cant;
    private $descrip;
    private $foto;
    private $status;
    private $modelo;
    private $tipo;
    function getId() {
        return $this->id;
    }
    function getMat() {
        return $this->mat;
    }
    function getPrecio() {
        return $this->precio;
    }
    function getCant() {
        return $this->cant;
    }
    function getDescrip() {
        return $this->descrip;
    }
    function getFoto() {
        return $this->foto;
    }
    function getStatus() {
        return $this->status;
    }
    function getModelo() {
        return $this->modelo;
    }
    function getTipo() {
        return $this->tipo;
    }
    function setId($id) {
        $this->id = $id;
    }
    function setMat($mat) {
        $this->mat = $mat;
    }
    function setPrecio($precio) {
        $this->precio = $precio;
    }
    function setCant($cant) {
        $this->cant = $cant;
    }
    function setDescrip($descrip) {
        $this->descrip = strtoupper($descrip);
    }
    function setFoto($foto) {
        $this->foto = $foto;
    }
    function setStatus($status) {
        $this->status = $status;
    }
    function setModelo($modelo) {
        $this->modelo = $modelo;
    }
    function setTipo($tipo) {
        $this->tipo = $tipo;
    }
    function __construct() { }
    public function equals(Vehiculo $obj){
        return $this->mat == $obj->mat;                
    }
    public function quitarStock($xcant){
        if($this->hayStock()){
            $this->cant -= $xcant;
        }
    }
    private function hayStock(){
        return $this->cant >0;
    }
    public function save(){
        return ($this->id == 0) ? (new VehiculoModel())->create($this) : (new VehiculoModel())->update($this); 
    }
    public function saveImg(){
        (new VehiculoModel())->updateImg($this);
    }
    public function del(){
        return (new VehiculoModel())->delete($this);
    }
    public function rec(){
        return (new VehiculoModel())->reactive($this);
    }
    public function find($criterio = null){
        return (new VehiculoModel())->find($criterio); 
    }
    public function findById($id){
        return (new VehiculoModel())->findById($id);
    }
    public function findByModelos($criterio){
        return (new VehiculoModel())->findByModelos($criterio); 
    }
}