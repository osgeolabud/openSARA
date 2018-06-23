<?php

namespace development\gestionBloques\funcion;

use bloquesModelo\bloqueModelo1\Funcion;

class CrearBloques {

    var $miConfigurador;
    var $miSql;
    var $conexion;
    var $rutaNuevoBloque;
    var $rutaFrontera;
    var $rutaFunciones;
    var $rutaFormularios;
    var $rutaScript;
    var $rutaCss;
    var $rutaControl;
    var $rutaEntidad;
    var $rutaLocale;
    var $rutaIdioma;
    var $namespace;
    var $indice = 0;
    var $arregloFicheros = array();

    function __construct($sql) {
        $this->miConfigurador = \Configurador::singleton();
        $this->miConfigurador->fabricaConexiones->setRecursoDB('principal');
        $this->miSql = $sql;
    }

    function procesarCrearBloque() {

        /**
         * 1.Creación Directorios
         */
        $this->crearDirectorio();

        /**
         * 2.Creación Ficheros
         */
        $this->crearFicheros();

        /**
         * 3.Registro DB Bloque
         */
       $this->procesarCreacionBloqueSql();

        return true;
    }

    private function crearArchivo($plantilla, $archivo, $ruta) {
        $rutaPlantillas = $this->miConfigurador->getVariableConfiguracion("rutaUrlBloque") . "funcion/plantillasFicheros/";
        $plantillaBloque = file_get_contents($rutaPlantillas . $plantilla);
        $ficheroBloque = fopen($ruta . "/" . $archivo, "w");
        fwrite($ficheroBloque, $plantillaBloque);
        fclose($ficheroBloque);
        $this->reescribirNamespace($ruta . "/" . $archivo);
        $this->arregloFicherosPermisos [$this->indice++] = $ruta . "/" . $archivo;
    }

    function crearFicheros() {

        $this->crearArchivo('bloque', 'bloque.php', $this->rutaNuevoBloque);
        $this->crearArchivo('index', 'index.php', $this->rutaNuevoBloque);
        $this->crearArchivo('dependencias', 'dependencias.php', $this->rutaNuevoBloque);

        /**
         * Directorio Frontera
         */
        $this->crearArchivo('frontera', 'Frontera.class.php', $this->rutaFrontera);
        $this->crearArchivo('lenguaje', 'Lenguaje.class.php', $this->rutaFrontera);
        $this->crearArchivo('estilobloque', 'estiloBloque.css', $this->rutaCss);
        $this->crearArchivo('estilo', 'Estilo.php', $this->rutaCss);
        $this->crearArchivo('miformulario', 'miFormulario.php', $this->rutaFormularios);
        $this->crearArchivo('mensaje', 'Mensaje.php', $this->rutaIdioma);

        /**
         * Directorio Entidad
         */
        $this->crearArchivo('entidad', 'Entidad.class.php', $this->rutaEntidad);
        $this->crearArchivo('ready', 'ready.js', $this->rutaScripts);
        $this->crearArchivo('script', 'Script.php', $this->rutaScripts);
        $this->crearArchivo('ajax', 'ajax.php', $this->rutaScripts);
        $this->crearArchivo('procesarajax', 'procesarAjax.php', $this->rutaFunciones);
        $this->crearArchivo('redireccionador', 'Redireccionador.php', $this->rutaFunciones);
        $this->crearArchivo('procesarformulario', 'procesarFormulario.php', $this->rutaFunciones);

        /**
         * Directorio Control
         */
        $this->crearArchivo('sql', 'Sql.class.php', $this->rutaControl);


        $this->permisosFicheros();
    }

    function permisosFicheros() {
        foreach ($this->arregloFicherosPermisos as $valor) {
            chmod($valor, 0777);
        }
    }

    function reescribirNamespace($archivo, $extensionNamespace = '') {
        $extensionNamespace = str_replace(' ', '', $extensionNamespace);

        $contenidoArchivo = file_get_contents($archivo);

        $contenidoArchivo = explode("\n", $contenidoArchivo);

        $contenidoArchivo [1] = 'namespace ' . $this->namespace . $extensionNamespace . ';';
        $archivoReescribir = fopen($archivo, "w+b");

        foreach ($contenidoArchivo as $linea) {
            fwrite($archivoReescribir, $linea . "\n");
        }

        fclose($archivoReescribir);
    }

    function crearDirectorio() {
        $DirectorioInstalacion = "blocks/";

        /**
         * Creación Grupo Bloque
         */
        $_REQUEST ['grupo'] = str_replace(' ', '', $_REQUEST ['grupo']);

        if ($_REQUEST ['grupo'] != '') {

            $gruposBusqueda = strpos($_REQUEST ['grupo'], "/");

            if ($gruposBusqueda) {

                $arrayGrupo = explode("/", $_REQUEST ['grupo']);

                $cadenaGrupo = '';

                foreach ($arrayGrupo as $valor) {

                    $rutaGrupo = ($cadenaGrupo != '') ? $DirectorioInstalacion . $cadenaGrupo . "/" . $valor : $DirectorioInstalacion . $valor;
                    mkdir($rutaGrupo, 0777, true);
                    chmod($rutaGrupo, 0777);
                    $cadenaGrupo .= ($cadenaGrupo != '') ? "/" . $valor : $valor;
                }
            } else {

                $rutaGrupo = $DirectorioInstalacion . $_REQUEST ['grupo'];
                mkdir($rutaGrupo, 0777, true);
                chmod($rutaGrupo, 0777);
            }
        }

        /**
         * Creación Bloque
         */
        $_REQUEST ['nombre'] = str_replace(' ', '', $_REQUEST ['nombre']);

        $this->rutaNuevoBloque = ($_REQUEST ['grupo'] != '') ? $DirectorioInstalacion . $_REQUEST ['grupo'] . "/" . $_REQUEST ['nombre'] : $DirectorioInstalacion . $_REQUEST ['nombre'];

        $this->namespace = ($_REQUEST ['grupo'] != '') ? $_REQUEST ['grupo'] . "/" . $_REQUEST ['nombre'] : $_REQUEST ['nombre'];
        $this->namespace = str_replace(' ', '', str_replace('/', ' \ ', $this->namespace));

        mkdir($this->rutaNuevoBloque, 0777, true);
        chmod($this->rutaNuevoBloque, 0777);

        /**
         * Estructura de Directorios del Bloque:
         *
         * Frontera
         *  ->css
         *  ->formularios
         *  ->locale
         *      ->es_es
         * Control
         * Entidad
         *  ->funciones
         *  ->scripts
         */
        $this->rutaFrontera = $this->rutaNuevoBloque . "/Frontera";
        mkdir($this->rutaFrontera, 0777);
        chmod($this->rutaFrontera, 0777);

        $this->rutaCss = $this->rutaFrontera . "/css";
        mkdir($this->rutaCss, 0777);
        chmod($this->rutaCss, 0777);

        $this->rutaFormularios = $this->rutaFrontera . "/formularios";
        mkdir($this->rutaFormularios, 0777);
        chmod($this->rutaFormularios, 0777);

        $this->rutaLocale = $this->rutaFrontera . "/locale";
        mkdir($this->rutaLocale, 0777);
        chmod($this->rutaLocale, 0777);

        $this->rutaIdioma = $this->rutaLocale . "/es_es";
        mkdir($this->rutaIdioma, 0777);
        chmod($this->rutaIdioma, 0777);

        $this->rutaControl = $this->rutaNuevoBloque . "/Control";
        mkdir($this->rutaControl, 0777);
        chmod($this->rutaControl, 0777);

        $this->rutaEntidad = $this->rutaNuevoBloque . "/Entidad";
        mkdir($this->rutaEntidad, 0777);
        chmod($this->rutaEntidad, 0777);

        $this->rutaFunciones = $this->rutaEntidad . "/funciones";
        mkdir($this->rutaFunciones, 0777);
        chmod($this->rutaFunciones, 0777);

        $this->rutaScripts = $this->rutaEntidad . "/scripts";
        mkdir($this->rutaScripts, 0777);
        chmod($this->rutaScripts, 0777);
    }

    function procesarCreacionBloqueSql() {
        $this->conexion = $this->miConfigurador->fabricaConexiones->getRecursoDB('estructura');

        $cadenaSql = $this->miSql->getCadenaSql('insertarBloque');
        $resultado = $this->conexion->ejecutarAcceso($cadenaSql, 'acceso');
    }

}

$miRegistrador = new CrearBloques($this->sql);

$resultado = $miRegistrador->procesarCrearBloque();
?>