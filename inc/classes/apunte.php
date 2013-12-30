<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class apunte {
	
	private $concepto;
	private $importe;
	private $fecha;
	private $fechaValor;
	private $tipoApunte;
	private $cuenta;        

	private $abono;
        
        private $db;
	
	public function __construct ($_concepto, $_importe, $_fecha, $_fechaValor, $_tipoApunte, $_cuenta, $_db, $_abono=FALSE){
		$this->db = $_db;
            
                $this->setConcepto($_concepto);
		$this->setImporte($_importe);
		$this->setFecha($_fecha);
		$this->setFechaValor($_fechaValor);
		 
                
                $this->setCuenta($_cuenta);
		$this->setAbono($_abono);
		
		$this->setTipoApunte($_tipoApunte);
		$this->setCuenta($_cuenta); 
	}

	public function getConcepto() {
		return $this->concepto;
	} 

	public function setConcepto($_concepto) {
		$this->concepto = $_concepto;
	}

	public function getImporte() {
		return $this->importe;
	}

	public function setImporte($_importe) {
		$this->importe = $_importe;
	}

	public function getFecha() {
		return $this->fecha;
	}

	public function setFecha($_fecha) {
		$this->fecha = $_fecha;
	}

	public function getFechaValor() {
		return $this->fechaValor;
	}

	public function setFechaValor($_fechaValor) {
		$this->fechaValor = $_fechaValor;
	}

	public function isAbono() {
		return (int)$this->abono;
	}

	public function setAbono($_abono) {
		$this->abono = $_abono;
	}

	public function getCuenta() {
		return $this->cuenta;
	}

	public function setCuenta($_cuenta) {
		$this->cuenta = $_cuenta;
	}

	public function getTipoApunte() {
		return $this->tipoApunte;
	}

	public function setTipoApunte($_tipoApunte) {
		$this->tipoApunte = $_tipoApunte;
	}

	public function commit(){
               $sql = "INSERT INTO Apuntes VALUES('','$this->concepto', $this->importe, '$this->fecha', ".$this->cuenta->getId().",'$this->fechaValor', $this->tipoApunte, ".$this->isAbono().")";
echo $sql;
               if ($this->db->Execute($sql) == false) echo $this->db->ErrorMsg();  
        }
}

?>
 