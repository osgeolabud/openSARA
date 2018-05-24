<?php

namespace development\constructor\funcion;

class Estructurador {

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
    var $pagina;

    function __construct($sql) {
        $this->miConfigurador = \Configurador::singleton();
        $this->miConfigurador->fabricaConexiones->setRecursoDB('principal');
        $this->miSql = $sql;
        $this->conexion = $this->miConfigurador->fabricaConexiones->getRecursoDB('estructura');
        if (!$this->conexion) {
            error_log("No se conectó a la base de datos");
        }
    }

    function guardarEstructura() {

        /**
         * @todo Por el momento solo está guardando páginas que no se encuentren registradas en el sistema
         */
        
        if ($_REQUEST['paginaMaestra'] != '') {
                
            $this->pagina = $this->consultar('pagina');
            if ($this->pagina != false) {
                
                $this->borrarBloquePagina();
                $this->procesarSecciones();
                
            }
        }
        
        return true;
    }
    
    function borrarBloquePagina(){

        $cadenaSql = $this->miSql->getCadenaSql('borrarBloquePagina',$this->pagina);
        $this->conexion->ejecutarAcceso($cadenaSql, 'borrar');
        
        return true;
        
    }
    
    
    function procesarSecciones(){
        $json = str_replace("'", '"', $_REQUEST['misBloques']);
        $estructura = (json_decode($json, true));
        
       

        foreach ($estructura['bloques'] as $seccion) {
            foreach ($seccion as $bloque) {
                $bloque['bloque'] = $this->consultar('bloque', $bloque['bloque']);                
                if($bloque['bloque']!=false){                    
                    $bloque['paginaMaestra']=  $this->pagina;
                    $this->guardar($bloque);                    
                }
            }
        };
    }
    
    
    function guardar($bloque){
        
        $cadenaSql = $this->miSql->getCadenaSql('insertarBloquePagina',$bloque);
        $this->conexion->ejecutarAcceso($cadenaSql, 'insertar');
        
        return true;
        
    }

    function consultar($opcion,$variable='') {

        
        if($opcion=='pagina'){
            $cadenaSql = $this->miSql->getCadenaSql('consultarPagina');
        }else{
            $cadenaSql = $this->miSql->getCadenaSql('consultarBloque',$variable);
        }
        $this->resultadoItems = $this->conexion->ejecutarAcceso($cadenaSql, 'busqueda');
        if ($this->resultadoItems) {
            return $this->resultadoItems[0][0];
        } else {
            return false;
        }
    }

}

$miEstructurador = new Estructurador($this->sql);
$resultado = $miEstructurador->guardarEstructura();
?>