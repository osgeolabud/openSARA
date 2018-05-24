<?php

namespace servicioBeneficiario;

// Evitar un acceso directo a este archivo
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");

include_once ('Funcion.class.php');
class servicioWeb {
	var $miFuncion;
	var $miConfigurador;
	function __construct() {
		$this->miConfigurador = \Configurador::singleton ();
		$this->miFuncion = new Funcion ();
	}
	public function servidorSOAP() {
		$rutaURL = $this->miConfigurador->getVariableConfiguracion ( "host" ) . $this->miConfigurador->getVariableConfiguracion ( "site" );
		$rutaURL .= "/webServices";
		
		$directorioWDLS = $rutaURL . "/directorioWSDL/";
		$nombreArchivoWSDL = "archivoWSDL.wsdl";
		
		$urlWSDL = $directorioWDLS . $nombreArchivoWSDL;
		
		$uri = $rutaURL . "/" . $_REQUEST ['nombreServicio'] . "/";
		
		$parametroSOAP = array (
				'uri' => $uri,
				'soap_version' => SOAP_1_2 
		);
		
		ini_set ( "soap.wsdl_cache_enabled", "0" );
		
		$objetoServidorSOAP= new \SoapServer($urlWSDL,$parametroSOAP);
		$objetoServidorSOAP->setClass("Beneficiario");
		$objetoServidorSOAP->handle();
		
	}
}

$Objeto = new servicioWeb ();

$Objeto->servidorSOAP ();

?>