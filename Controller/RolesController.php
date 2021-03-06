<?php
namespace Controller;
use \App\Session;
use \Clases\Rol;
class RolesController extends AppController 
{
    function __construct() {
        parent::__construct();
    }
    public function index(){
        if($this->checkUser()){
            $this->redirect(array("index.php"),array(
                "roles" => (new Rol())->find()
            )); 
        }   
    }
    public function add(){
        if($this->checkUser()){
            if (isset($_POST['btnaceptar'])) {
                if($this->checkDates()) {                
                    $rol= $this->createEntity();
                    $id = $rol->save();
                    Session::set("msg",(isset($id)) ? "Rol Creado" : Session::get('msg')); 
                    header("Location:index.php?b=backend&c=roles&a=index");
                    exit();
                }
            }
            $this->redirect(array('add.php'));
        }
    }   
    public function edit(){        
        if($this->checkUser()){
            Session::set("id",$_GET['p']);
            if (Session::get('id')!=null && isset($_POST['btnaceptar'])){                             
                if($this->checkDates()) {                
                    $rol= $this->createEntity();
                    $id = $rol->save();
                    Session::set("msg",(isset($id)) ? "Rol Editado" : Session::get('msg'));
                    header("Location:index.php?b=backend&c=roles&a=index");
                    exit();
                }
            }
            $this->redirect(array('edit.php'),array(
                "rol" => (new Rol())->findById(Session::get('id'))
            ));
        }        
    }
    public function delete(){
        if($this->checkUser()){
            if (isset($_GET['p'])){
                $rol = (new Rol())->findById($_GET['p']);
                $id= $rol->del();
                Session::set("msg", (isset($id)) ? "Rol Borrado" : "No se pudo borrar el rol");
                header("Location:index.php?b=backend&c=roles&a=index");
            }                           
        }
    }
    private function checkDates(){
        if(empty($_POST['txtnom'])){
            Session::set("msg","Ingrese los datos obligatorios (*) para continuar.");
            return false;
        }
        else{
            return true;
        }
    }
    private function createEntity(){
        $obj = new Rol();
        $obj->setId((isset($_POST['hid'])) ? $_POST['hid'] : 0);
        $obj->setNombre($_POST['txtnom']);
        return $obj;
    }
    protected function getMessageRole() {
        return "administrador";
    }
    protected function getTypeRole() {
        return "ADMIN";
    }
}