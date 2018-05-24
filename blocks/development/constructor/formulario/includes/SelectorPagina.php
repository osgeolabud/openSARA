<?php
        // Rescatar los datos de este bloque
        $esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
        
        // ---------------- SECCION: Parámetros Generales del Formulario ----------------------------------
        $esteFormulario = 'formDatos';
        $atributos ['id'] = $esteFormulario;
        $atributos ['nombre'] = $esteFormulario;
        // Si no se coloca, entonces toma el valor predeterminado 'application/x-www-form-urlencoded'
        $atributos ['tipoFormulario'] = '';
        // Si no se coloca, entonces toma el valor predeterminado 'POST'
        $atributos ['metodo'] = 'POST';
        // Si no se coloca, entonces toma el valor predeterminado 'index.php'
        //Se recomienda dejar vacío y pasar los valores de los bloques como campos codificados
        $atributos ['action'] = 'index.php';
        // Si no se coloca, entonces toma el valor predeterminado.
        $atributos ['estilo'] = '';
        $atributos ['marco'] = true;
        $tab = 1;
        // ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------
        
        // ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
        $atributos ['tipoEtiqueta'] = 'inicio';
        echo $this->miFormulario->formulario ( $atributos );
        
        // ---------------- SECCION: Controles del Formulario -----------------------------------------------
        
        // ---------------- CONTROL: Cuadro Texto --------------------------------------------------------
            unset ( $atributos );
            $esteControl = 'paginaMaestra';
            $atributo['name']=$esteControl;
            $atributo['id']=$esteControl;
            $atributo['valor']='';
            $atributo['deshabilitado']=false;
            $atributo['tamanno']=20;
            $atributo['estilo'] ='';
            $atributo['marco']='true';
            //$atributo['estiloMarco']='';
            $atributo['columnas']=2;
            $atributo['etiqueta']=$this->lenguaje->getCadena ($esteControl);
            //$atributo['anchoEtiqueta']='';
            //$atributo['estiloEtiqueta']='';
            $atributo['dobleLinea']=false;
            $atributo['tipo']='text';
            $atributo['maximoTamanno']=100;
            //$atributo['data-validate']='';
            //$atributo['validar']='';
            //$atributo['evento']='';
            $atributo['textoFondo']=$this->lenguaje->getCadena ($esteControl.'TextoFondo');
            $atributo['tabIndex']=$tab;
            $tab ++;
            // Aplica atributos globales al control
            //$atributos = array_merge ( $atributos, $atributosGlobales );
            echo $this->miFormulario->campoCuadroTexto ( $atributo );
        
        // --------------- FIN CONTROL : Cuadro Texto --------------------------------------------------
            // ------------------Division para los botones-------------------------
            $atributos ["id"] = "botones";
            $atributos ["estilo"] = "marcoBotones";
            echo $this->miFormulario->division ( "inicio", $atributos );

            // -----------------CONTROL: Botón ----------------------------------------------------------------
            $esteCampo = 'botonAceptar';
            $atributos ["id"] = $esteCampo;
            $atributos ["tabIndex"] = $tab;
            $atributos ["tipo"] = 'boton';
            // submit: no se coloca si se desea un tipo button genérico
           //    $atributos ['submit'] = true;
            $atributos ["estiloMarco"] = '';
            $atributos ["estiloBoton"] = 'jqueryui botonAceptar';
            // verificar: true para verificar el formulario antes de pasarlo al servidor.
            //$atributos ["tipoSubmit"] = 'jquery'; // Dejar vacio para un submit normal. Si es jquery ejecuta la función submit declarada en ready.js
            $atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
            $atributos ['nombreFormulario'] = $esteFormulario;
            $tab ++;

            echo $this->miFormulario->campoBoton ( $atributos );
            // -----------------FIN CONTROL: Botón -----------------------------------------------------------
             // ------------------Fin Division para los botones-------------------------
            echo $this->miFormulario->division ( "fin" );
            
            // ------------------- SECCION: Paso de variables ------------------------------------------------

            /**
             * En algunas ocasiones es útil pasar variables entre las diferentes páginas.
             * SARA permite realizar esto a través de tres
             * mecanismos:
             * (a). Registrando las variables como variables de sesión. Estarán disponibles durante toda la sesión de usuario. Requiere acceso a
             * la base de datos.
             * (b). Incluirlas de manera codificada como campos de los formularios. Para ello se utiliza un campo especial denominado
             * formsara, cuyo valor será una cadena codificada que contiene las variables.
             * (c) a través de campos ocultos en los formularios. (deprecated)
             */

            // En este formulario se utiliza el mecanismo (b) para pasar las siguientes variables:
            //Estas variables permiten que el procesamiento del formulario sea direccionado al bloque correspondiente

            // Paso 1: crear el listado de variables
            $valorCodificado = "actionBloque=" . $esteBloque ["nombre"];
            $valorCodificado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
            $valorCodificado .= "&bloque=" . $esteBloque ["id_bloque"];
            $valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
            $valorCodificado .= "&opcion=guardarEstructura";
            $valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar ( $valorCodificado );

            $atributos ["id"] = "formSaraData"; // No cambiar este nombre
            $atributos ["tipo"] = "hidden";
            $atributos ['estilo'] = '';
            $atributos ["obligatorio"] = false;
            $atributos ['marco'] = true;
            $atributos ["etiqueta"] = "";
            $atributos ["valor"] = $valorCodificado;
            echo $this->miFormulario->campoCuadroTexto ( $atributos );
            unset ( $atributos );

            // ----------------FIN SECCION: Paso de variables -------------------------------------------------
            
            
        
        // ---------------- FIN SECCION: Controles del Formulario -------------------------------------------
        
        // ----------------FINALIZAR EL FORMULARIO ----------------------------------------------------------
        // Se debe declarar el mismo atributo de marco con que se inició el formulario.
        $atributos ['marco'] = true;
        $atributos ['tipoEtiqueta'] = 'fin';
        echo $this->miFormulario->formulario ( $atributos );
    
    
