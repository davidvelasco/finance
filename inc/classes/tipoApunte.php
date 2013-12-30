<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class TiposApunte {
	
	private $idTipoApunte;
	
	private $nombre;
	private $detalle;
	
	private $db;
        
        public function __construct($_id, $_db, $_nombre = '', $_detalle = '') {
            
                $this->db = $_db;
            
                $rs = $this->db->Execute("SELECT * 
                                    FROM tiposApunte 
                                    WHERE idTipo = $_id");
                
                if ($rs->RecordCount() == 0){
                    $this->setNombre($_nombre);
                    $this->setDetalle($_detalle);
                } else {
                   $valores = $rs->FetchRow();

                   $this->idTipoApunte = $valores['idTipo'];
                   $this->setNombre($valores['nombre']);
                   $this->setDetalle($valores['detalle']);
                }
                
	}
        
	public function getNombre() {
		return $this->nombre;
	}
	public function setNombre($nombre) {
		$this->nombre = $nombre;
	}
	public function getDetalle() {
		return $this->detalle;
	}
	public function setDetalle($detalle) {
		$this->detalle = $detalle;
	}

	public function getIdTipoApunte() {
		return $this->idTipoApunte;
	}

        public function commit(){
                $rs = $this->db->Execute("SELECT * 
                                    FROM tiposApunte 
                                    WHERE idTipo = $this->idTipoApunte");

                if ($rs->RecordCount() == 0){
                    $sql = "INSERT INTO tiposApunte VALUES('','$this->nombre','$this->detalle')";
                    
                    if ($GLOBALS['db']->Execute($sql) == false) echo $GLOBALS['db']->ErrorMsg();   
                } else {
                    $sql = "UPDATE Cuentas SET nombre='$this->nombre', detalle = '$this->detalle')";
                    
                    if ($GLOBALS['db']->Execute($sql) == false) echo $$GLOBALS['db']->ErrorMsg();   
                }
        }
}

?>
