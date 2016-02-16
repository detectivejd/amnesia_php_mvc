<?php
namespace Clases;
use \App\IPersiste;
use \Model\UsuarioModel;
class Usuario implements IPersiste
{
    private $id;
    private $nick;
    private $pass;
    private $correo;
    private $nombre;
    private $apellido;
    private $status;
    private $rol;
    function getId() {
        return $this->id;
    }
    function getNick() {
        return $this->nick;
    }
    function getPass() {
        return $this->pass;
    }
    function getCorreo() {
        return $this->correo;
    }
    function getNombre() {
        return $this->nombre;
    }
    function getApellido() {
        return $this->apellido;
    }
    function getStatus() {
        return $this->status;
    }
    function getRol() {
        return $this->rol;
    }
    function setId($id) {
        $this->id = $id;
    }
    function setNick($nick) {
        $this->nick = $nick;
    }
    function setPass($pass) {
        $this->pass = $pass;
    }
    function setCorreo($correo) {
        $this->correo = $correo;
    }
    function setNombre($nombre) {
        $this->nombre = strtoupper($nombre);
    }
    function setApellido($apellido) {
        $this->apellido = strtoupper($apellido);
    }
    function setStatus($status) {
        $this->status = $status;
    }
    function setRol($rol) {
        $this->rol = $rol;
    }
    function __construct() { }
    public function equals(Usuario $obj){
        return $this->nick == $obj->nick;                
    }  
    public function save(){
        return ($this->id == 0) ? (new UsuarioModel())->create($this) : (new UsuarioModel())->update($this); 
    }
    public function del(){
        return (new UsuarioModel())->delete($this);
    }
    public function rec(){
        return (new UsuarioModel())->reactive($this);
    }
    public function find($criterio = null){
        return (new UsuarioModel())->find($criterio); 
    }
    public function findById($id){
        return (new UsuarioModel())->findById($id);
    }
    public function findByLogin($dates = array()){
        return (new UsuarioModel())->findBylogin($dates);
    }
}