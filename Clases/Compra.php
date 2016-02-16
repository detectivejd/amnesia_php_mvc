<?php
namespace Clases;
use \App\IPersiste;
use \Model\CompraModel;
class Compra implements IPersiste
{
    private $id;
    private $fecha;
    private $cuotas;
    private $cant;
    private $tipo;
    private $user;
    private $veh;
    private $pagos;
    function getId() {
        return $this->id;
    }
    function getFecha() {
        return $this->fecha;
    }
    function getCuotas() {
        return $this->cuotas;
    }
    function getCant() {
        return $this->cant;
    }
    function getTipo() {
        return $this->tipo;
    }
    function getUser() {
        return $this->user;
    }
    function getVeh() {
        return $this->veh;
    }
    function getPagos() {
        return $this->pagos;
    }
    function setId($id) {
        $this->id = $id;
    }
    function setFecha($fecha) {
        $this->fecha = $fecha;
    }
    function setCuotas($cuotas) {
        $this->cuotas = $cuotas;
    }
    function setCant($cant) {
        $this->cant = $cant;
    }
    function setTipo($tipo) {
        $this->tipo = $tipo;
    }
    function setUser($user) {
        $this->user = $user;
    }
    function setVeh($veh) {
        $this->veh = $veh;
    }
    function setPagos($pagos) {
        $this->pagos = $pagos;
    }
    function __construct() {
    }
    public function obtenerPagoTotal(){
        return $this->veh->getPrecio() * $this->cant;
    }
    public function obtenerPagoMinimo(){
        return $this->obtenerPagoTotal() / $this->cuotas;
    }
    public function obtenerCuotasRestantes(){
        return $this->cuotas - (new CompraModel())->find_sum_cuotas($this->id);
    }
    public function obtenerCuotasPagadas(){
        return ((new CompraModel())->find_sum_cuotas($this->id) > 0) ? (new CompraModel())->find_sum_cuotas($this->id) : 0;
    }
    public function generarFecVenc(){
        if($this->cuotas == $this->find_max_pago()){ 
            return date("Y-m-d");
        } 
        else {
            $MaxDias = 30;
            for ($i=0; $i<$MaxDias; $i++) {  
                $Segundos += 86400;            
                $caduca = date("D",time()+$Segundos);  
                if ($caduca == "Sat") {  
                    $i--;  
                }  
                else if ($caduca == "Sun"){  
                    $i--;  
                }  
                else {  
                    $FechaFinal = date("Y-m-d",time()+$Segundos);  
                }  
            } 
            return $FechaFinal;
        }
    }
    
    public function save(){
        return ($this->id == 0) ? (new CompraModel())->create($this) : (new CompraModel())->update($this); 
    }
    public function find($criterio = null){
        return (new CompraModel())->find($criterio); 
    }
    public function findById($id){
        return (new CompraModel())->findById($id);
    }
    public function findByClientes($criterio){
        return (new CompraModel())->findByClientes($criterio);
    }
    public function findByVeh($criterio){
        return (new CompraModel())->findByVeh($criterio);
    }
    public function add_pago($pago){
        return (new CompraModel())->add_pago($this,$pago);
    }
    public function del_pago($pago){
        return (new CompraModel())->del_pago($this,$pago);
    }
    public function find_pago($pago_id){
        return (new CompraModel())->find_pago($this->id, $pago_id);
    }
    public function find_max_pago(){
        return (new CompraModel())->find_max_pago($this->id);
    }
    public function check_fec_venc(){  
        return (new CompraModel())->check_fec_venc($this->id);
    }
    public function del() { }
}