<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Cuenta{
	
        private $id;
	private $nombre;
	private $numero;
	private $saldo;
	private $ahorro;
        private $activa;
        
        private $db;

        public function __construct($_id, $_db, $_nombre = '', $_numero = '0000-0000-00000000', $_ahorro= false, $_activa = true) {
                $this->db = $_db;

                $rs = $this->db->Execute("SELECT * 
                                    FROM Cuentas 
                                    WHERE idCuentas = ".$_id);

                if ($rs->RecordCount() == 0){ 
                    $this->setNombre($_nombre);
                    $this->setNumero($_numero);
                    $this->setAhorro($_ahorro);
                    $this->setActiva($_activa);
                } else {
                   $valores = $rs->FetchRow();

                   $this->id = $valores['idCuentas'];
                   $this->setNombre($valores['Nombre']);
                   $this->setNumero($valores['numero']);
                   $this->setSaldo($valores['saldo']);
                   $this->setAhorro($valores['ahorro']);
                   $this->setActiva($valores['activa']);
                }
                
	}
        
        public function __toString() {
            return "Numero: $this->numero \n Nombre: $this->nombre \n Saldo: $this->saldo \n";
            //(string)var_export($this);
        }

	public function getId() {
		return $this->id;
        }
        
	public function getNombre() {
		return $this->nombre;
	}

	public function setNombre($_nombre){
		$this->nombre = $_nombre;
	}

	public function getNumero() {
		return $this->numero;
	}

	public function setNumero($_numero) {
		$this->numero = $_numero;
	}

	public function getSaldo() {
		return $this->saldo;
	}

	public function setSaldo($_saldo) {
		$this->saldo = $_saldo;
	}

	public function isAhorro() {
		return $this->ahorro;
	}

	public function setAhorro($_ahorro){
		$this->ahorro = $_ahorro;
	}

        public function isActiva() { 
		return $this->activa;
	}

	public function setActiva($_activa){
		$this->activa = $_activa;
	} 

        public function commit(){
                $rs = $this->db->Execute("SELECT * 
                                    FROM Cuentas 
                                    WHERE idCuentas = ".$this->id);
                
                if ($rs->RecordCount() == 0){
                    $sql = "INSERT INTO Cuentas VALUES('','$this->nombre','$this->numero',$this->saldo, $this->ahorro, $this->activa)";
                    
                    if ($this->db->Execute($sql) == false) echo $this->db->ErrorMsg();   
                } else {
                    $sql = "UPDATE Cuentas SET nombre='$this->nombre', numero = '$this->numero', saldo = $this->saldo, ahorro = $this->ahorro, activa = $this->activa WHERE numero = '".$this->numero."'";
                    
                    if ($this->db->Execute($sql) == false) echo $this->db->ErrorMsg();   
                }
        }
}

?> 
