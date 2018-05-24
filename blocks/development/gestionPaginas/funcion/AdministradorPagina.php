<?php

namespace development\gestionPaginas\funcion;

use bloquesModelo\bloqueModelo1\Funcion;

class AdministradorPagina {
	var $miConfigurador;
	var $miSql;
        var $opcion;
	var $conexion;
	var $rutaNuevoBloque;
	var $rutaFrontera;
	var $rutaScript;
	var $rutaCss;
	var $rutaControl;
	var $rutaEntidad;
	var $rutaLocale;
	var $rutaIdioma;
	var $namespace;
	function __construct($sql) {
		$this->miConfigurador = \Configurador::singleton ();
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		$this->miSql = $sql;}
        
        function administrarPagina($opcion){
            
            switch ($opcion){
                
                case 'consultar':
                    $this->consultarPaginas();
                    break;
                case 'editar':
                    $this->editarPagina();
                    break;
                
                case 'crear':
                    $this->crearPagina();
                    break;
                
                case 'eliminar':
                    $this->eliminarPagina();
                    break;
                    
                }
        }
        
	function crearPagina() {
		
            $this->conexion = $this->miConfigurador->fabricaConexiones->getRecursoDB ( 'estructura' );
            $cadenaSql = $this->miSql->getCadenaSql ( 'insertarPagina' );
            $resultado = $this->conexion->ejecutarAcceso ( $cadenaSql, 'acceso' );
	}
        
        function editarPagina() {
		$this->conexion = $this->miConfigurador->fabricaConexiones->getRecursoDB ( 'estructura' );
		$cadenaSql = $this->miSql->getCadenaSql ( 'actualizarPagina' );
                $actualizacionBloque = $this->conexion->ejecutarAcceso ( $cadenaSql, 'acceso' );
	}
        
        function eliminarPagina() {
		$this->conexion = $this->miConfigurador->fabricaConexiones->getRecursoDB ( 'estructura' );
		$cadenaSql = $this->miSql->getCadenaSql ( 'eliminarPagina' );
                $actualizacionBloque = $this->conexion->ejecutarAcceso ( $cadenaSql, 'acceso' );
	}
        
        function consultarPaginas() {
		$this->conexion = $this->miConfigurador->fabricaConexiones->getRecursoDB ( 'estructura' );
		if (! $this->conexion) {
			error_log ( "No se conectó" );
			$resultado = false;
		}
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'consultarPaginas' );
            	
		$this->resultadoItems = $this->conexion->ejecutarAcceso ( $cadenaSql, 'busqueda' );
                
                if($this->resultadoItems){
                    $tabla=$this->generarTabla('llena');
                }else{
                    
                   $tabla=$this->generarTabla('vacia');
                }
		echo $tabla;
	}

        
        private function generarTabla($opcion){
            
            $tabla = new \stdClass ();
            $page = $_REQUEST ['page'];		
            $limit = $_REQUEST ['rows'];
            isset($_REQUEST ['sidx'])?$sidx = $_REQUEST ['sidx']:$sidx = 1;		
            $sord = $_REQUEST ['sord'];
            if($opcion=='llena'){
                
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

                $tabla->page = $page;
                $tabla->total = $total_pages;
                $tabla->records = $filas;

                $i = 0;
                $j = 1;
                foreach ( $this->resultadoItems as $row ) {

                    if(isset($row ['id_pagina'])){
                        $tabla->rows [$i] ['id'] = $row ['id_pagina'];
                        $tabla->rows [$i] ['cell'] = array (
                                        $row ['id_pagina'],
                                        trim ( $row ['nombre'] ),
                                        trim ( $row ['descripcion'] ),
                                        trim ( $row ['modulo'] ), 
                                        trim ( $row ['nivel'] ),
                                        trim ( $row ['parametro'] )

                        );
                        $i ++;
                    }
                }

                return json_encode ( $tabla );   
            }else{
                
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
                return json_encode ( $tabla );
                
            }
            
            
        }
}

$miRegistrador = new AdministradorPagina ( $this->sql);

$resultado = $miRegistrador->administrarPagina($opcion);

?>