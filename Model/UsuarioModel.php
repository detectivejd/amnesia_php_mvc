<?php
namespace Model;
use \Clases\Usuario;
class UsuarioModel extends AppModel
{    
    private $mod_r;
    function __construct() {
        parent::__construct();
        $this->mod_r= new RolModel();
    }    
    public function reactive($usuario){
        return $this->executeQuery(
            "update usuarios set usuStatus=1 where usuId=?", 
            array($usuario->getId())
        );
    }
    public function findBylogin($load = array()){
        return $this->findByCondition(
            "SELECT u.usuId as id, u.usuNick as nick, u.usuPass as pass, u.usuMail as mail, u.usuNombre as nom,"
            . "u.usuApellido as ape, u.usuStatus as status, u.rolId as rol from usuarios u where "
            . "u.usuNick = :user and u.usuPass = :pass and u.usuStatus = 1"
            , 
            array('user' =>$load[0],'pass' => md5($load[1]))
        );
    }
    /*------------------------------------------------------------------*/
    public function createEntity($row) {
        $rol= $this->mod_r->findById($row['rol']);
        $obj = new Usuario();
        $obj->setId($row['id']);
        $obj->setNick($row['nick']);
        $obj->setPass($row['pass']);
        $obj->setCorreo($row['mail']); 
        $obj->setNombre($row['nom']); 
        $obj->setApellido($row['ape']); 
        $obj->setStatus($row['status']); 
        $obj->setRol($rol); 
        return $obj;        
    }
    /*------------------------------------------------------------------*/    
    protected function getCheckMessage() {
        return "El Usuario ya existe";
    }

    protected function getCheckParameter($unique) {
        return [$unique->getNick()];
    }

    protected function getCheckQuery() {
        return 'SELECT usuId FROM usuarios WHERE usuNick = ?';
    }
    /*------------------------------------------------------------------*/
    protected function getCreateParameter($object) {
        return array(
            $object->getNick(),$object->getPass(),$object->getCorreo(),
            $object->getNombre(),$object->getApellido(),$object->getRol()->getId()
        );
    }

    protected function getCreateQuery() {
        return "insert into usuarios(usuNick,usuPass,usuMail,usuNombre,usuApellido,rolId) values(?,?,?,?,?,?)";
    }
    /*------------------------------------------------------------------*/
    protected function getDeleteParameter($object) {
        return array($object->getId());
    }

    protected function getDeleteQuery($notUsed = true) {
        return "update usuarios set usuStatus=0 where usuId=?";
    }
    /*------------------------------------------------------------------*/
    protected function getFindParameter($criterio = null) {
        return array("%".$criterio."%");
    }

    protected function getFindQuery($criterio = null) {
        return "SELECT u.usuId as id, u.usuNick as nick, u.usuPass as pass, u.usuMail as mail, u.usuNombre as nom, "
                . "u.usuApellido as ape, u.usuStatus as status, u.rolId as rol from usuarios u where u.usuNick like ?";
    }
    /*------------------------------------------------------------------*/
    protected function getUpdateParameter($object) {
        return array(
            $object->getNick(),$object->getPass(),$object->getCorreo(),
            $object->getNombre(),$object->getApellido(),$object->getRol()->getId(),
            $object->getId()
        );
    }
    protected function getUpdateQuery() {
        return "update usuarios set usuNick=?,usuPass=?,usuMail=?,usuNombre=?,usuApellido=?,rolId=? where usuId=?";
    }
    /*------------------------------------------------------------------*/
    protected function getFindXIdQuery() {
        return "SELECT u.usuId as id, u.usuNick as nick, u.usuPass as pass, u.usuMail as mail, "
        . "u.usuNombre as nom, u.usuApellido as ape, u.usuStatus as status, u.rolId as rol "
        . "from usuarios u WHERE u.usuId = ?";
    }    
}