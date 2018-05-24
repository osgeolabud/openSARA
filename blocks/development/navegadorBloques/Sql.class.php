<?php

namespace development\navegadorBloques;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

// Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precedida por la palabra sql
class Sql extends \Sql {
	var $miConfigurador;
	function getCadenaSql($tipo, $variable = '') {
		
		/**
		 * 1.
		 * Revisar las variables para evitar SQL Injection
		 */
		$prefijo = $this->miConfigurador->getVariableConfiguracion ( "prefijo" );
		$idSesion = $this->miConfigurador->getVariableConfiguracion ( "id_sesion" );
		
		switch ($tipo) {
			
			/**
			 * Clausulas específicas
			 */
			case 'consultarBloques' :
				
				$cadenaSql = " SELECT id_bloque, "
                                . "trim(nombre) as nombre, "
                                . "trim(descripcion) as descripcion, "
                                . "trim(grupo) as grupo "
                                ."FROM " . $prefijo . "bloque "
                                . "ORDER BY nombre asc";
                                //."WHERE id_bloque>0 ";
                                
                            	break;			
		}
		
		return $cadenaSql;
	}
}
?>