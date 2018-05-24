<?php

namespace development\constructor;

if (!isset($GLOBALS ["autorizado"])) {
    include ("../index.php");
    exit();
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
        $prefijo = $this->miConfigurador->getVariableConfiguracion("prefijo");
        $idSesion = $this->miConfigurador->getVariableConfiguracion("id_sesion");

        switch ($tipo) {

            /**
             * Clausulas específicas
             */
            case 'consultarPaginas' :

                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'id_pagina as data, ';
                $cadenaSql .= 'nombre as value ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= $prefijo . 'pagina ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'nombre LIKE \'' . $_REQUEST['query'] . '%\' ';
                break;

            case 'consultarPagina' :

                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'id_pagina ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= $prefijo . 'pagina ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'nombre =\'' . $_REQUEST['paginaMaestra'] . '\' ';
                break;

            case 'consultarBloque' :
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'id_bloque ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= $prefijo . 'bloque ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'nombre =\'' . $variable . '\' ';
                break;

            case 'consultarBloques' :
                $cadenaSql = 'SELECT ';
                $cadenaSql .= $prefijo . 'bloque_pagina.id_bloque, ';
                $cadenaSql .= $prefijo . 'bloque_pagina.id_pagina, ';
                $cadenaSql .= $prefijo . 'bloque_pagina.seccion, ';
                $cadenaSql .= $prefijo . 'bloque_pagina.posicion, ';
                $cadenaSql .= $prefijo . 'bloque.nombre ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= $prefijo . 'bloque_pagina, ';
                $cadenaSql .= $prefijo . 'bloque ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= $prefijo . 'bloque_pagina.id_bloque=' . $prefijo . 'bloque.id_bloque ';
                $cadenaSql .= 'AND ';
                $cadenaSql .= $prefijo . 'bloque_pagina.id_pagina =' . $_REQUEST['paginaMaestra'];
                break;


            case 'insertarBloquePagina' :
                $cadenaSql = 'INSERT INTO ';
                $cadenaSql .= $prefijo . 'bloque_pagina ';
                $cadenaSql .= '(id_pagina, id_bloque, seccion, posicion) ';
                $cadenaSql .= 'VALUES ';
                $cadenaSql .= '(' . $variable['paginaMaestra'] . ',';
                $cadenaSql .= $variable['bloque'] . ',';
                $cadenaSql .= "'" . $variable['seccion'] . "',";
                $cadenaSql .= $variable['posicion'] . ')';
                break;
            
            case 'borrarBloquePagina' :
                $cadenaSql = 'DELETE FROM ';
                $cadenaSql .= $prefijo . 'bloque_pagina ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'id_pagina='.$variable;
                
                break;
        }

        
        return $cadenaSql;
    }

}

?>
