<?php

namespace development\gestionBloques\funcion;

class ConsultarBloques {
	var $miConfigurador;
	var $miSql;
	var $conexion;
	var $directorioInstalacion = "blocks";
	function __construct($sql) {
		$this->miConfigurador = \Configurador::singleton ();
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		$this->miSql = $sql;
	}
	function procesarConsultaBloque() {
		$this->conexion = $this->miConfigurador->fabricaConexiones->getRecursoDB ( 'estructura' );
		if (! $this->conexion) {
			error_log ( "No se conectó" );
			$resultado = false;
		}
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'consultarBloques' );
		
		$this->resultadoItems = $this->conexion->ejecutarAcceso ( $cadenaSql, 'busqueda' );

	
		/**
		 * Clasifica los bloques registrados y los no registrados
		 */

		$this->ajustarItems();

		
		
		$tabla = new \stdClass ();
		
		$page = $_REQUEST ['page'];
		
		$limit = $_REQUEST ['rows'];
		
		$sidx = $_REQUEST ['sidx'];
		
		$sord = $_REQUEST ['sord'];
		
		if (! $sidx)
			$sidx = 1;
		
		$filas = count ( $this->resultadoItems );
		
		if ($filas > 0 && $limit > 0) {
			$total_pages = ceil ( $filas / $limit );
		} else {
			$total_pages = 0;
		}
		
		if ($page > $total_pages) {
			$page = $total_pages;
		}
		$start = $limit * $page - $limit;

		if ( isset($this->resultadoItems) && !is_null($this->resultadoItems) && $this->resultadoItems ) {
			$tabla->page = $page;
			$tabla->total = $total_pages;
			$tabla->records = $filas;
			
			$i = 0;
			$j = 1;
			foreach ( $this->resultadoItems as $row ) {
				$tabla->rows [$i] ['id'] = $row ['id_bloque'];
				$tabla->rows [$i] ['cell'] = array (
						$row ['id_bloque'],
						trim ( $row ['nombre'] ),
						trim ( $row ['descripcion'] ),
						trim ( $row ['grupo'] ), 
						trim ( $row ['registro'] ) 
				);
				$i ++;
			}
			
			$tabla = json_encode ( $tabla );
		} else {
			$tabla->page = 1;
			$tabla->total = 1;
			$tabla->records = 1;
			
			$tabla->rows [0] ['id'] = 1;
			$tabla->rows [0] ['cell'] = array (
					" ",
					" ",
					" ",
					" " 
			);
			$tabla = json_encode ( $tabla );
		}
		
		echo $tabla;
	}

	function ajustarItems(){

		/**
		 * Clasifica los bloques registrados y los no registrados
		 */


		$this->consultarBloquesDirectorio($this->directorioInstalacion);

		if($this->resultadoItems){
			foreach ($this->resultadoItems as $key => $value) {
				foreach ($this->arregloBloque as $llave => $valor ) {
					
					if ($value['nombre'] == $valor['nombre']) {
						unset($this->arregloBloque[$llave]);
					}

				}
			}

			$this->resultadoItems = array_merge($this->resultadoItems,$this->arregloBloque);

		}elseif(isset($this->arregloBloque)&&!is_null($this->arregloBloque)){

			$this->resultadoItems = $this->arregloBloque;

		}
		
	}

	function consultarBloquesDirectorio($directorio) {
		
		/**
		 * Lista los bloques existentes en el blocks/
		 */


		$directorios = $this->escanearDirectorio($directorio);

		if($directorios){

			foreach ($directorios as $valor) {
				
				if (file_exists($directorio."/".$valor."/bloque.php")) {

					$nombre_bloque=$valor;

					$arreglo = array(
						"id_bloque" => "9999",
						"nombre" => $valor,
						"descripcion" => "",
						"grupo" => ($directorio!='blocks')? str_replace("blocks/","",$directorio):"",
						 );



					 $arreglo["registro"] = "Bloque no registrado.<br>¿Desea " .$this->crearBotonesBloque($arreglo)." ?";

					 $this->arregloBloque[] = $arreglo;



				}else{

					$this->consultarBloquesDirectorio($directorio."/".$valor);
				}
			}
		}
		
	}

	function escanearDirectorio($dir=''){

		/**
		 * Escanear los directorios en blocks/
		 */

		if (is_dir($dir)) {

			$var = scandir($dir);
			foreach ($var as $key => $value) {
				switch ($value) {
					case '.':
						unset($var[$key]);
						break;
					case '..':
						unset($var[$key]);
						break;
					case 'bloquesModelo':
						unset($var[$key]);
						break;
					case 'development':
						unset($var[$key]);
						break;
				}
			}
			
		} else {
			$var= false;
		}
		
		
		return $var; 

		
	}

	function crearBotonesBloque($arreglo){


		/**
		 * Crear un boton para registrar los bloques no registrados
		 */

		$esteBloque = $this->miConfigurador->configuracion['esteBloque'];
		// URL base
		$url = $this->miConfigurador->getVariableConfiguracion ( "host" );
		$url .= $this->miConfigurador->getVariableConfiguracion ( "site" );
		$url .= "/index.php?";
		// Variables
		$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
		$cadenaACodificar .= "&procesarAjax=true";
		$cadenaACodificar .= "&action=index.php";
		$cadenaACodificar .= "&bloqueNombre=" . $esteBloque ["nombre"];
		$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque ["grupo"];
		$cadenaACodificar .= "&funcion=registrarBloque";
		$cadenaACodificar .= "&nombre=".$arreglo['nombre'];
		$cadenaACodificar .= "&descripcion=".$arreglo['descripcion'];
		$cadenaACodificar .= "&grupo=".$arreglo['grupo'];

		// Codificar las variables
		$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
		$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificar, $enlace );

		// URL Registrar
		$urlRegistrarBloque = $url . $cadena;

		$boton = "<input type='button' value='Registrar' class='ui-state-default ui-corner-all'";
		$boton .=" onclick= 'accionBloque(\"".$urlRegistrarBloque."\")'></input>";

		// Variables
		$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
		$cadenaACodificar .= "&procesarAjax=true";
		$cadenaACodificar .= "&action=index.php";
		$cadenaACodificar .= "&bloqueNombre=" . $esteBloque ["nombre"];
		$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque ["grupo"];
		$cadenaACodificar .= "&funcion=eliminarBloque";
		$cadenaACodificar .= "&nombre=".$arreglo['nombre'];
		$cadenaACodificar .= "&descripcion=".$arreglo['descripcion'];
		$cadenaACodificar .= "&grupo=".$arreglo['grupo'];
		$cadenaACodificar .= "&bloqueNoRegistrado=true";

		// Codificar las variables
		$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
		$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificar, $enlace );

		// URL Eliminar
		$urlEliminarBloque = $url . $cadena;

		$boton .= " o ";

		$boton .= "<input type='button' value='Eliminar' class='ui-state-default ui-corner-all'";
		$boton .=" onclick= 'accionBloque(\"".$urlEliminarBloque."\")'></input>";	

		return $boton;
	
	}
}

$miRegistrador = new ConsultarBloques ( $this->sql );

$resultado = $miRegistrador->procesarConsultaBloque ();

?>