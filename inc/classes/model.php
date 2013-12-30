<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('inc/adodb5/adodb.inc.php');
require_once('inc/classes/cuenta.php');
require_once('inc/classes/apunte.php');
require_once('inc/classes/tipoApunte.php');
require_once('inc/classes/periodicos.php');

class model{
    private $driver = 'mysql';
    private $server = 'localhost';
    private $user = 'dalamar_php';
    private $password = 'M0nd3030';
    private $database = 'dalamar_finance';
    private $debugging = false;
    private $db;
    
    

    public function __construct() {
        $this->db = ADONewConnection($this->driver);
        
        $this->db->Connect($this->server, $this->user, $this->password, $this->database);    
        $this->db->debug = $this->debugging;
    }

    public function insertar_cuenta($_cuenta){
        $cuenta = new cuenta($_cuenta, $this->db);
        
        if (!is_null($cuenta)){
            $sql = "DELETE FROM Cuentas WHERE numero = $cuenta->getNumero()";
            
            if ($this->db->Execute($sql) == false) echo $this->db->ErrorMsg(); 
        }
    }

    
    public function borrar_cuenta($_cuenta){
        $cuenta = new cuenta($_cuenta, $this->db);
        
        if (!is_null($cuenta)){
            $sql = "DELETE FROM Cuentas WHERE numero = $cuenta->getNumero()";
            
            if ($this->db->Execute($sql) == false) echo $this->db->ErrorMsg(); 
        }
    }
    
    public function desactivar_cuenta($_cuenta){
        $cuenta = new cuenta($_cuenta, $this->db);
        
        if (!is_null($cuenta)){
            $cuenta->setActiva(FALSE);
            $cuenta->commit();
        }
    }

    public function activar_cuenta($_cuenta){
        $cuenta = new cuenta($_cuenta, $this->db);
        
        if (!is_null($cuenta)){
            $cuenta->setActiva(TRUE);
            $cuenta->commit();
        }
    }
    
    public function insertar_apunte($_concepto, $_importe, $_fecha, $_fechaValor, $_tipoApunte, $_idCuenta, $_abono=FALSE){
        
        $cuenta = new Cuenta($_idCuenta, $this->db);
        
        $apunte = new apunte($_concepto, $_importe, $_fecha, $_fechaValor, $_tipoApunte, $cuenta, $this->db, $_abono);
  
        $apunte->commit();
    }

    public function transferencia_interna($_cuenta_origen, $_cuenta_destino, $_importe){
        $cuenta_origen = new Cuenta($_cuenta_origen, $this->db);
        $cuenta_destino = new Cuenta($_cuenta_destino, $this->db);
        $fecha = date("y-m-d");

        if ($cuenta_origen->isActiva() && $cuenta_destino->isActiva()){
            $apunte_origen = new apunte('Transferencia hacia cuenta '.$cuenta_destino->getNumero(), $_importe, $fecha, $fecha, '1', $cuenta_origen, $this->db, FALSE);
            $apunte_destino = new apunte('Transferencia desde '.$cuenta_origen->getNumero(), $_importe, $fecha, $fecha, '1', $cuenta_destino, $this->db, TRUE);

            $apunte_origen->commit();
            $apunte_destino->commit();
            
            return true;
        } else {
            return false;
        }
    }  
    
    public function estado_cuentas(){
            $sql = "SELECT * FROM Cuentas WHERE activa = true";
            
            $this->db->SetFetchMode(ADODB_FETCH_ASSOC);
            $rs = $this->db->Execute($sql); 
            
            if (is_null($rs)){
                print $this->db->ErrorMsg();
            } else {
                while (!$rs->EOF){
                    $cuenta = new cuenta($rs->fields['idCuentas'],$this->db);

                    echo $cuenta;

                    $rs->MoveNext();
                }
            }
    }   

    public function insertar_periodico($_importe, $_descripcion, $_periodicidad, $_fechaLimitePeriodicidad, $_fechaValor, $_tipoApunte, $_idCuenta, $_abono=FALSE, $_activo = TRUE){
        
        $cuenta = new Cuenta($_idCuenta, $this->db);
        
        $periodico = new Periodicos(-1, $this->db, $_importe, $cuenta, $_descripcion, $_periodicidad, $_fechaValor, $_fechaLimitePeriodicidad, $_tipoApunte, $_abono, $_activo);
  
        $periodico->commit();
    } 
    
    public function desactivar_periodico($_id){
        $periodico = new Periodicos($_id, $this->db);
        
        $periodico->setActivo(FALSE);
        $periodico->commit();
    }

    public function activar_periodico($_id){
        $periodico = new Periodicos($_id, $this->db);
        
        if (!is_null($periodico)){
            $periodico->setActivo(TRUE);
            $periodico->commit();
        }
    }
     
    public function check_periodicos(){
        $dateTime = new DateTime($fecha);

        $DateTimeZone = timezone_open ( 'Europe/Madrid' );
        $dateTime->setTimezone( $DateTimeZone );

        $fecha = $dateTime->format("d-m-y");

        $sql = "SELECT * FROM Periodicos WHERE activo = true AND limitePeriodicidad <= CURDATE()";
            
        $this->db->SetFetchMode(ADODB_FETCH_ASSOC);
        $rs = $this->db->Execute($sql); 
            
        if (is_null($rs)){
            print $this->db->ErrorMsg();
        } else {
            while (!$rs->EOF){
                $periodico = new Periodicos($rs->fields['idPeriodico'],$this->db); 

                $apunte = new apunte($periodico->getDescripcion(), $periodico->getImporte(), $fecha, $fecha, $periodico->getTipoApunte(), $periodico->getCuenta(), $this->db, $periodico->getAbono());
                $apunte->commit();
                
                $rs->MoveNext();
            }
        }
        
    }
    
    
    public function prevision_meses($meses = 2){
            $sql = "SELECT * FROM Cuentas WHERE activa = true"; 
            
            $this->db->SetFetchMode(ADODB_FETCH_ASSOC);
            $rs = $this->db->Execute($sql); 
            
            if (is_null($rs)){
                print $this->db->ErrorMsg();
            } else {
                while (!$rs->EOF){
                    $cuenta = new cuenta($rs->fields['numero'],$this->db);

                    echo $cuenta;

                    $rs->MoveNext();
                }
            }
        
        
    }
    
}

 
?>
