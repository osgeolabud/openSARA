<?php
namespace servicioBeneficiario;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/builder/InspectorHTML.class.php");
include_once ("Sql.class.php");

class Funcion {
	var $miSql;
	var $miConfigurador;
	var $miInspectorHTML;
	var $ruta;
	function __construct() {
		$this->miConfigurador = \Configurador::singleton ();
		$this->miInspectorHTML = \InspectorHTML::singleton ();
		
	}
	
}
include('funcion/procesarServicio.php');


?>
