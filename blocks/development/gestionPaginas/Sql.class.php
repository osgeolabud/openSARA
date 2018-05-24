<?php

namespace development\gestionPaginas;

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
			case 'consultarPaginas' :
				
				$cadenaSql = " SELECT id_pagina, "
                                . "trim(nombre) as nombre, "
                                . "trim(descripcion) as descripcion, "
                                . "trim(modulo) as modulo, "
                                . "nivel, "
                                . "parametro " 
                                ."FROM " . $prefijo . "pagina " 
                                ."WHERE id_pagina >0 " 
                                . "ORDER BY  id_pagina " . $_REQUEST ['sord'] . " ;";
                            	break;
			
			case 'insertarPagina' :
				$cadenaSql = 'INSERT INTO '
                                . $prefijo . 'pagina '
                                . '( '
                                . 'nombre,'
                                . 'descripcion,'
                                . 'modulo,'
                                . 'nivel,'
                                . 'parametro'
                                . ')'
                                . 'VALUES '
                                . '( '
                                . '\'' . $_REQUEST ['nombre'] . '\', '
                                . '\'' . $_REQUEST ['descripcion'] . '\', '
                                . '\'' . $_REQUEST ['modulo'] . '\','
                                . '\'' . $_REQUEST ['nivel'] . '\','
                                . '\'' . $_REQUEST ['parametro'] . '\''
                                . '); ';
				break;
                            
                        case 'actualizarPagina' :
				$cadenaSql = " UPDATE "
                                . $prefijo . "pagina "
                                . "SET "
                                . "nombre='" . $_REQUEST ['nombre'] . "', "
                                . "descripcion='" . $_REQUEST ['descripcion'] . "',"
                                . "modulo='" . $_REQUEST ['modulo'] . "', "
                                . "nivel='" . $_REQUEST ['nivel'] . "', "
                                . "parametro='" . $_REQUEST ['parametro'] . "' "
                                . "WHERE "
                                . "id_pagina='" . $_REQUEST ['id'] . "';";
				break;
			
			case 'eliminarPagina' :
				$cadenaSql = " DELETE FROM " . $prefijo . "pagina ";
				$cadenaSql .= " WHERE id_pagina='" . $_REQUEST ['id'] . "';";
				break;
		}
		
		return $cadenaSql;
	}
}
?>
