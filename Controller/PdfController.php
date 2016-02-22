<?php
namespace Controller;
use \App\Session;
use \Clases\Vehiculo;
use \Clases\Consulta;
class PdfController extends AppController
{
    function __construct() {
        parent::__construct();
    }
    public function rep_vehiculos(){
        if($this->checkUser()){
            $this->getPdf()->AddPage();
            $this->getPdf()->SetFont('Arial','B',16);
            $this->getPdf()->Cell(40,10,utf8_decode('Reporte de Vehículos'));
            $this->getPdf()->Ln(5);
            $this->getPdf()->SetFont('Arial','B',12);
            $this->getPdf()->Ln(8);
            foreach ((new Vehiculo())->find() as $vehiculo){
                $this->getPdf()->Cell(20,5,$this->getPdf()->Image($vehiculo->getFoto(),null,null,40,40));
                $this->getPdf()->Cell(30);
                $this->getPdf()->Cell(20,-70,utf8_decode('Vehículo:')." ".$vehiculo->getId()." ".utf8_decode('Matrícula:')." ".$vehiculo->getMat()." Tipo:"." ".$vehiculo->getTipo()->getNombre());                
                $this->getPdf()->Ln(5);
                $this->getPdf()->Cell(50);
                $this->getPdf()->Cell(20,-70,"Precio: ".$vehiculo->getPrecio()." Cantidad: ".$vehiculo->getCant()." Modelo: ".$vehiculo->getModelo()->getNombre());
                $this->getPdf()->Ln(5);
                $this->getPdf()->Cell(50);
                $this->getPdf()->Cell(20,-70,utf8_decode('Descripción:'));
                $this->getPdf()->Ln(5);
                $this->getPdf()->Cell(50);
                $this->getPdf()->Cell(20,-70,$vehiculo->getDescrip());
                $this->getPdf()->Ln(10);
            }
            $this->getPdf()->Output();
        }
    }
    public function c1(){
        if (Session::get("log_in") != null and Session::get("log_in")->getRol()->getNombre() == "NORMAL") {
            Session::set('p', isset($_GET['p']) ? $_GET['p'] : Session::get('p'));             
            $compras=array();
            if(Session::get('p') == "d"){
                $compras = (new Consulta())->cons1ByDay(Session::get('log_in')->getId());
            }
            else if(Session::get('p') == "m"){
                $compras = (new Consulta())->cons1ByMonth(Session::get('log_in')->getId());
            }
            else {
                $compras = (new Consulta())->cons1ByYear(Session::get('log_in')->getId());
            } 
            $this->getPdf()->AddPage();
            $this->getPdf()->AliasNbPages();
            $this->getPdf()->SetFont('Arial','B',16);
            $this->getPdf()->Cell(40,10,utf8_decode('Mostrar Compras por período'));
            $this->getPdf()->SetFont('Arial','B',12);            
            $this->getPdf()->Ln(20);
            $this->getPdf()->Cell(20,5,"Cliente: ". Session::get('log_in')->getApellido() ." ".Session::get('log_in')->getNombre());
            $this->getPdf()->Ln(10);
            $this->getPdf()->Cell(20,5,"Compra",'B',null,"C");
            $this->getPdf()->Cell(20,5,"Fecha",'B',null,"C");
            $this->getPdf()->Cell(30,5,"Cuotas",'B',null,"C");
            $this->getPdf()->Ln(8);
            foreach ($compras as $compra){
                $this->getPdf()->Cell(20,5,$compra->getId(),null,null,"C");
                $this->getPdf()->Cell(20,5,$compra->getFecha(),null,null,"C");
                $this->getPdf()->Cell(20,5,count($compra->getPagos())."/".$compra->getCuotas(),null,null,"C");
                $this->getPdf()->Ln(5);
            }
            $this->getPdf()->SetFont('Arial','BI',12);
            // Número de página
            $this->getPdf()->SetY(265);
            $this->getPdf()->Cell(0,10,utf8_decode('Página: ').$this->getPdf()->PageNo(),'T',0,'C');
            $this->getPdf()->Output();
        }
        else {
            Session::set("msg", "Debe loguearse como cliente para acceder.");
            header("Location:index.php?c=main&a=index");
        }
    }
    public function c2(){
        if (Session::get("log_in") != null and Session::get("log_in")->getRol()->getNombre() == "NORMAL") {
            $compras=(new Consulta())->cons2(Session::get('log_in')->getId());
            $this->getPdf()->AddPage();
            $this->getPdf()->AliasNbPages();
            $this->getPdf()->SetFont('Arial','B',16);
            $this->getPdf()->Cell(40,10,'Mostrar Compras sin pagar');
            $this->getPdf()->SetFont('Arial','B',12);            
            $this->getPdf()->Ln(20);
            $this->getPdf()->Cell(20,5,"Cliente: ". Session::get('log_in')->getApellido() ." ".Session::get('log_in')->getNombre());
            $this->getPdf()->Ln(10);
            $this->getPdf()->Cell(20,5,"Compra",'B',null,"C");
            $this->getPdf()->Cell(20,5,"Fecha",'B',null,"C");
            $this->getPdf()->Cell(30,5,"Cuotas",'B',null,"C");
            $this->getPdf()->Ln(8);
            foreach ($compras as $compra){
                $this->getPdf()->Cell(20,5,$compra->getId(),null,null,"C");
                $this->getPdf()->Cell(20,5,$compra->getFecha(),null,null,"C");
                $this->getPdf()->Cell(20,5,count($compra->getPagos())."/".$compra->getCuotas(),null,null,"C");
                $this->getPdf()->Ln(5);
            }
            $this->getPdf()->SetFont('Arial','BI',12);
            // Número de página
            $this->getPdf()->SetY(265);
            $this->getPdf()->Cell(0,10,utf8_decode('Página: ').$this->getPdf()->PageNo(),'T',0,'C');
            $this->getPdf()->Output();
        }
        else {
            Session::set("msg", "Debe loguearse como cliente para acceder.");
            header("Location:index.php?c=main&a=index");
        }
    }
    public function c3(){
        if (Session::get("log_in") != null and Session::get("log_in")->getRol()->getNombre() == "NORMAL") {
            $compras=array();            
            if(isset($_GET["d1"]) and isset($_GET["d2"])){
                if($_GET["d1"] > $_GET["d2"]){
                    Session::set('msg', "La fecha de inicio debe ser menor a la fecha de cierre");
                }
                else {
                    $compras = (new Consulta())->cons3($_GET["d1"], $_GET["d2"], Session::get('log_in')->getId());
                    $this->getPdf()->AddPage();
                    $this->getPdf()->AliasNbPages();
                    $this->getPdf()->SetFont('Arial','B',16);
                    $this->getPdf()->Cell(40,10,'Mostrar Compras por fechas');
                    $this->getPdf()->SetFont('Arial','B',12);            
                    $this->getPdf()->Ln(20);
                    $this->getPdf()->Cell(20,5,"Cliente: ". Session::get('log_in')->getApellido() ." ".Session::get('log_in')->getNombre());
                    $this->getPdf()->Ln(10);
                    $this->getPdf()->Cell(20,5,"Compra",'B',null,"C");
                    $this->getPdf()->Cell(20,5,"Fecha",'B',null,"C");
                    $this->getPdf()->Cell(30,5,"Cuotas",'B',null,"C");
                    $this->getPdf()->Ln(8);
                    foreach ($compras as $compra){
                        $this->getPdf()->Cell(20,5,$compra->getId(),null,null,"C");
                        $this->getPdf()->Cell(20,5,$compra->getFecha(),null,null,"C");
                        $this->getPdf()->Cell(20,5,count($compra->getPagos())."/".$compra->getCuotas(),null,null,"C");
                        $this->getPdf()->Ln(5);
                    }
                    $this->getPdf()->SetFont('Arial','BI',12);
                    // Número de página
                    $this->getPdf()->SetY(265);
                    $this->getPdf()->Cell(0,10,utf8_decode('Página: ').$this->getPdf()->PageNo(),'T',0,'C');
                    $this->getPdf()->Output();
                }
            }
        }
        else {
            Session::set("msg", "Debe loguearse como cliente para acceder.");
            header("Location:index.php?c=main&a=index");
        }
    }
    public function c4(){
        if (Session::get("log_in") != null and Session::get("log_in")->getRol()->getNombre() == "NORMAL") {
            $compras=(new Consulta())->cons4(Session::get('log_in')->getId());
            $this->getPdf()->AddPage();
            $this->getPdf()->AliasNbPages();
            $this->getPdf()->SetFont('Arial','B',16);
            $this->getPdf()->Cell(40,10,'Mostrar Mis Compras y Pagos');
            $this->getPdf()->SetFont('Arial','B',12);            
            $this->getPdf()->Ln(20);
            $this->getPdf()->Cell(20,5,"Cliente: ". Session::get('log_in')->getApellido() ." ".Session::get('log_in')->getNombre());
            $this->getPdf()->Ln(8);
            foreach ($compras as $compra){
                $this->getPdf()->Cell(20,5,"Compra: ".$compra->getId()." Fecha: ".$compra->getFecha()." Cuotas: ".count($compra->getPagos())."/".$compra->getCuotas());
                $this->getPdf()->Ln(10);
                $this->getPdf()->Cell(20,5,"Pago",'B',null,"C");
                $this->getPdf()->Cell(30,5,"Fecha de Pago",'B',null,"C");
                $this->getPdf()->Cell(40,5,"Fecha de Venc",'B',null,"C");
                $this->getPdf()->Cell(30,5,"Monto",'B',null,"C");
                $this->getPdf()->Ln(8);
                foreach ($compra->getPagos() as $pago){
                    $this->getPdf()->Cell(20,5,$pago->getId(),null,null,"C");
                    $this->getPdf()->Cell(30,5,$pago->getFecpago(),null,null,"C");
                    $this->getPdf()->Cell(40,5,$pago->getFecvenc(),null,null,"C");
                    $this->getPdf()->Cell(30,5,"$".$pago->getMonto(),null,null,"C");
                    $this->getPdf()->Ln(5);
                }
                $this->getPdf()->Ln(10);
            }
            $this->getPdf()->SetFont('Arial','BI',12);
            // Número de página
            $this->getPdf()->SetY(265);
            $this->getPdf()->Cell(0,10,utf8_decode('Página: ').$this->getPdf()->PageNo(),'T',0,'C');
            $this->getPdf()->Output();
        }
        else {
            Session::set("msg", "Debe loguearse como cliente para acceder.");
            header("Location:index.php?c=main&a=index");
        }        
    }
    protected function getMessageRole() {
        return "administrador";
    }
    protected function getTypeRole() {
        return "ADMIN";
    }
}