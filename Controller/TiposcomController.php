<?php
namespace Controller;
use \App\Session;
use \Clases\TipoCompra;
class TiposcomController extends AppController
{
    function __construct() {
        parent::__construct();
    }
    public function index(){
        if($this->checkUser()){
            $this->redirect(array("index.php"),array(
                "tiposcom" => (new TipoCompra())->find()
            )); 
        }    
    }
    public function add(){
        if($this->checkUser()){
            if (isset($_POST['btnaceptar'])) {
                if($this->checkDates()) { 
                    $tc= $this->createEntity();
                    $id = $tc->save();
                    Session::set("msg",(isset($id)) ? "Tipo de Compra Creada" : Session::get('msg'));
                    header("Location:index.php?b=backend&c=tiposcom&a=index");
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
                    $tc= $this->createEntity();
                    $id = $tc->save();
                    Session::set("msg",(isset($id)) ? "Tipo de Compra Editada" : Session::get('msg'));
                    header("Location:index.php?b=backend&c=tiposcom&a=index"); 
                    exit();
                }
            }
            $this->redirect(array('edit.php'),array(
                "tipocom" => (new TipoCompra())->findById(Session::get('id'))
            ));
        }       
    }
    public function delete(){
        if($this->checkUser()){
            if (isset($_GET['p'])){
                $tc = (new TipoCompra())->findById($_GET['p']); 
                $id = $tc->del($tc);
                Session::set("msg", (isset($id)) ? "Tipo de Compra Borrada" : "No se pudo borrar el tipo");
                header("Location:index.php?b=backend&c=tiposcom&a=index");
            }                           
        }
        else {
            Session::set("msg","Debe ser administrador para acceder.");
            $this->redirect(array('Main','index.php'));
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
    protected function getMessageRole() {
        return "administrador";
    }
    protected function getTypeRole() {
        return "ADMIN";
    }
    protected function createEntity() {        
        $obj = new TipoCompra();
        $obj->setId(isset($_POST['hid']) ? $_POST['hid'] : 0);
        $obj->setNombre($_POST['txtnom']);
        return $obj;
    }
}