<?php 
require_once('inc/classes/model.php');
 
$boooh = new model();
/*$boooh->actualizar_saldo('0000-0000-00000000001');
$boooh->actualizar_saldo('0000-0000-00000000000');*/

//$fecha = date("d-m-y");
$fecha = date('c');

/*$dateTime = date_create($fecha);
$DateTimeZone = timezone_open ( 'Europe/Madrid' );
date_timezone_set( $dateTime, $DateTimeZone );*/


$dateTime = new DateTime($fecha);

$DateTimeZone = timezone_open ( 'Europe/Madrid' );
$dateTime->setTimezone( $DateTimeZone );


$fecha = $dateTime->format("d-m-y");

//$fecha = date('cO');
/*$boooh->insertar_apunte("Insercion de retirada de efectivo", 1500, $fecha, $fecha, 1, 1, FALSE);
$boooh->insertar_apunte("Insercion de retirada de efectivo", 200, $fecha, $fecha, 1, 2, FALSE);
$boooh->insertar_apunte("Insercion de retirada de efectivo", 300, $fecha, $fecha, 1, 1, FALSE);
$boooh->insertar_apunte("Insercion de retirada de efectivo", 100, $fecha, $fecha, 1, 2, FALSE);
$boooh->insertar_apunte("Insercion de retirada de efectivo", 1200, $fecha, $fecha, 1, 2, FALSE);
$boooh->insertar_apunte("Insercion de retirada de efectivo", 100, $fecha, $fecha, 1, 1, FALSE);*/

//$boooh->insertar_apunte("Primera insercion desde el modelo, retirada de efectivo", 250, $fecha, $fecha, 1, '0000-0000-00000000001');
if (!$boooh->transferencia_interna(1, 2, 50)) echo "Error en la transferencia";
//$boooh->desactivar_cuenta('0000-0000-00000000001');
$boooh->estado_cuentas();



//1500+300+1200-50 = 2950
//200+100+100+50 = 450
//$boooh->activar_cuenta('0000-0000-00000000001');
//echo($dateTime->format("d-m-y H:i"));
/*
$db = ADONewConnection($driver); # eg. 'mysql' or 'oci8' 

$db->debug = true;
$db->Connect($server, $user, $password, $database);
*/
//$paco = new Cuenta('0000-0000-00000000001','Prueba', false);
/*$paco = new Cuenta('0000-0000-00000000001');//,'Prueba', false);
$alberto = new TiposApunte("Retirada de efectivo", "Retiradas de efectivo de cajero");

$fecha = date("d-m-y");

$pepe = new apunte('Apunte de pruebas', 20, $fecha, $fecha, $alberto->getIdTipoApunte(), $paco, false, '00-00-0000', '00-00-0000', false, NULL);
$pepe->commit();

'
//$alberto->commit();

//$pepe->commit();
/*
$rs = $db->Execute('select * from Cuentas');
print "<pre>";
print_r($rs->GetRows());
print "</pre>";*/
?> 
       