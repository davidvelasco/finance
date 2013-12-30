<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Periodicos{
	
	
        private $id;
        private $periodicidad;
	private $limitePeridicidad;
	private $importe;
	private $abono;
        private $activo;
        private $descripcion;
	private $Cuenta;
        private $tipoApunte;
        private $ultima_ejecucion;

        private $db;

        public function __construct($_id, $_db, $_importe = 0, $_Cuenta = 0, $_descripcion = '', $_periodicidad = 'Mensual', $_limitePeriodicidad = '00-00-0000', $_tipoApunte = 0, $_abono = FALSE, $_activo = TRUE, $_ultima_ejecucion = '0000-00-00') {
                $this->db = $_db;

                $rs = $this->db->Execute("SELECT * 
                                    FROM Periodicos 
                                    WHERE idPeriodicos = $_id");

                if ($rs->RecordCount() == 0){ 
                    $this->setImporte($_importe);
                    $this->setDescripcion($_descripcion);
                    $this->setPeriodicidad($_periodicidad);
                    $this->setLimitePeriodicidad($_limitePeriodicidad);
                    $this->setCuenta($_Cuenta);
                    $this->setAbono($_abono);
                    $this->setTipoApunte($_tipoApunte);
                    $this->setUltima_ejecucion($_ultima_ejecucion);

                    $this->setActivo($_activo);
                } else {
                    $valores = $rs->FetchRow();

                    $this->id = $_id;
                    
                    $this->setImporte($valores['importe']);
                    $this->setDescripcion($valores['descripcion']);
                    $this->setPeriodicidad($valores['periodicidad']);
                    $this->setLimitePeriodicidad($valores['limitePeriodicidad']);
                    $this->setCuenta($valores['idCuenta']);
                    $this->setAbono($valores['abono']);
                    $this->setTipoApunte($valores['tipoApunte']);
                    $this->setUltima_ejecucion($valores['ultima_ejecucion']);
                    
                    $this->setActivo($valores['activo']);
                }
                
	}
        
        public function __toString() {
            //return "Cuenta: $this->Cuenta \n Numero: $this->nombre \n Saldo: $this->saldo \n";
            //(string)var_export($this);
        }

	public function getId() {
            return $this->id;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function getPeriodicidad() {
            return $this->periodicidad;
        }

        public function setPeriodicidad($periodicidad) {
            $this->periodicidad = $periodicidad;
        }

        public function getLimitePeridicidad() {
            return $this->limitePeridicidad;
        }

        public function setLimitePeridicidad($limitePeridicidad) {
            $this->limitePeridicidad = $limitePeridicidad;
        }

        public function getDescripcion() {
            return $this->descripcion;
        }

        public function setDescripcion($descripcion) {
            $this->descripcion = $descripcion;
        }
        public function getImporte() {
            return $this->importe;
        }

        public function setImporte($importe) {
            $this->importe = $importe;
        }

        public function getAbono() {
            return $this->abono;
        }

        public function setAbono($abono) {
            $this->abono = $abono;
        }

        public function getActivo() {
            return $this->activo;
        }

        public function setActivo($activo) {
            $this->activo = $activo;
        }

        public function getCuenta() {
            return $this->Cuenta;
        }

        public function setCuenta($Cuenta) {
            $this->Cuenta = $Cuenta;
        }

        public function getTipoApunte() {
            return $this->tipoApunte;
        }

        public function setTipoApunte($tipoApunte) {
            $this->tipoApunte = $tipoApunte;
        }
        
        public function getUltima_ejecucion() {
            return $this->ultima_ejecucion;
        }

        public function setUltima_ejecucion($ultima_ejecucion) {
            $this->ultima_ejecucion = $ultima_ejecucion;
        }

                
        public function commit(){
                $rs = $this->db->Execute("SELECT * 
                                    FROM Periodicos 
                                    WHERE idPeriodicos = $this->id");
                
                if ($rs->RecordCount() == 0){
                    $sql = "INSERT INTO Periodicos VALUES('','$this->descripcion','$this->periodicidad','$this->limitePeriodicidad', $this->importe, $this->abono, $this->activo, $this->Cuenta->getID(), $this->tipoApunte->getID())";
                    
                    if ($this->db->Execute($sql) == false) echo $this->db->ErrorMsg();   
                } else {
                    $sql = "UPDATE Periodicos SET descripcion = '$this->descripcion', periodicidad = '$this->periodicidad', limitePeriodicidad = '$this->limitePeriodicidad', importe = $this->importe, abono = $this->abono, activo = $this->activo, idCuenta = $this->Cuenta->getID(), idTipoApunte = $this->tipoApunte->getID()) WHERE idPeriodicos = $this->id";
                    
                    if ($this->db->Execute($sql) == false) echo $this->db->ErrorMsg();   
                }
        }
}

?>
