<?php

if (! isset ( $GLOBALS ["autorizado"] )) {
    include ("../index.php");
    exit ();
}

include_once ("core/builder/blockTemplate/Bloque.interface.php");
include_once ("core/manager/Configurador.class.php");
include_once ("core/builder/FormularioHtml.class.php");


 abstract class TBloque implements \IBloque  {
        var $nombreBloque;
        var $miFuncion;
        var $miSql;
        var $miConfigurador;
        var $miFormulario;
        
        public function __construct($esteBloque, $lenguaje = "") {
            
            // El objeto de la clase Configurador debe ser único en toda la aplicación
            $this->miConfigurador = \Configurador::singleton ();
            
            $ruta = $this->miConfigurador->getVariableConfiguracion ( "raizDocumento" );
            $rutaURL = $this->miConfigurador->getVariableConfiguracion ( "host" ) . $this->miConfigurador->getVariableConfiguracion ( "site" );
            
            if (! isset ( $esteBloque ["grupo"] ) || $esteBloque ["grupo"] == "") {
                $ruta .= "/blocks/" . $esteBloque ["nombre"] . "/";
                $rutaURL .= "/blocks/" . $esteBloque ["nombre"] . "/";
            } else {
                $ruta .= "/blocks/" . $esteBloque ["grupo"] . "/" . $esteBloque ["nombre"] . "/";
                $rutaURL .= "/blocks/" . $esteBloque ["grupo"] . "/" . $esteBloque ["nombre"] . "/";
            }
            
            $this->miConfigurador->setVariableConfiguracion ( "rutaBloque", $ruta );
            $this->miConfigurador->setVariableConfiguracion ( "rutaUrlBloque", $rutaURL );
            $this->inicializar();
        }
        
        abstract public function inicializar();
        
        public function bloque() {
            
            if (isset ( $_REQUEST ['botonCancelar'] ) && $_REQUEST ['botonCancelar'] == "true") {
                $this->miFuncion->redireccionar ( "paginaPrincipal" );
            } else {
                
                /**
                 * Injección de dependencias
                 */
                
                // Para la frontera
                $this->miFrontera->setSql ( $this->miSql );
                $this->miFrontera->setFuncion ( $this->miFuncion );
                $this->miFrontera->setFormulario ( $this->miFormulario );
                $this->miFrontera->setLenguaje ( $this->miLenguaje );
                
                // Para la entidad
                $this->miFuncion->setSql ( $this->miSql );
                $this->miFuncion->setEntidad ( $this->miFuncion );
                $this->miFuncion->setLenguaje ( $this->miLenguaje );
                
                if (! isset ( $_REQUEST ['action'] )) {
                    $this->miFrontera->frontera ();
                } else {
                    
                    $respuesta = $this->miFuncion->action ();
                    
                    /**
                     * Esta sección es la que implementa el mecanismo tipo 2 (procesar y cargar la misma página)
                     */
                    // Si $respuesta==false, entonces el formulario muestra un mensaje de error.
                    if (! $respuesta) {
                        $miBloque = $this->miConfigurador->getVariableConfiguracion ( 'esteBloque' );
                        $this->miConfigurador->setVariableConfiguracion ( 'mostrarMensaje', $miBloque ['nombre'] );
                    
                    }
                    if (! isset ( $_REQUEST ['procesarAjax'] )) {
                        $this->miFrontera->frontera ();
                    }
                }
            
            }
        }
    }