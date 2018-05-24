<?php
use servicioBeneficiario\Sql;
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
class Beneficiario {
	function __construct() {
		$this->miConfigurador = \Configurador::singleton ();
		$this->miSql = new Sql ();
	}
	function informacionBeneficiario($variable = '') {
		$conexion = "logica";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'informacion_beneficiario', $variable );
		$informacionBeneficiario = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
		if ($informacionBeneficiario) {
			$informacionBeneficiario = $informacionBeneficiario [0];
			$arregloResultado = array (
					
					"Id Beneficiario" => $informacionBeneficiario [0],
					"Cedula" => $informacionBeneficiario [1],
					"Nombre" => $informacionBeneficiario [2],
					"Dirección" => $informacionBeneficiario [3],
					"Código Dane Centro Poblado" => $informacionBeneficiario [4],
					"Código Dane Departamento" => $informacionBeneficiario [5],
					"Código Dane Municipio" => $informacionBeneficiario [6],
					"Código Dane Institución" => $informacionBeneficiario [7],
					"Territorio" => $informacionBeneficiario [8],
					"Región" => $informacionBeneficiario [9] 
			);
		} else {
			
			$arregloResultado = array (
					"Error" => "Beneficiario No Existe" 
			);
		}
		return $arregloResultado;
	}
}
?>
