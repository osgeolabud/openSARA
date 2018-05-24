<?php

namespace development\gestionPaginas\funcion;

class procesarAjax {
	var $miConfigurador;
	var $sql;
	function __construct($sql) {
		$this->miConfigurador = \Configurador::singleton ();
		
		$this->ruta = $this->miConfigurador->getVariableConfiguracion ( "rutaBloque" );
		
		$this->sql = $sql;

		$this->conexion = $this->miConfigurador->fabricaConexiones->getRecursoDB ( 'estructura' );
                
              
		switch ($_REQUEST ['funcion']) {
			
			case 'consultarPaginas' :				
				$opcion='consultar';
				include ('AdministradorPagina.php');
				break;
                            
			case 'crearPagina' :
                                $opcion='crear';
				include ('AdministradorPagina.php');				
				break;
			
			case 'editarPagina' :
				$opcion='editar';
				include ('AdministradorPagina.php');
				
				break;
			
			case 'eliminarPagina' :
				$opcion='eliminar';
				include ('AdministradorPagina.php');
				break;
		}
	}
}

$miProcesarAjax = new procesarAjax ( $this->sql );

?>