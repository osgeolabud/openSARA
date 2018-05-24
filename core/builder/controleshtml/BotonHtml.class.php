<?php

require_once ("core/builder/HtmlBase.class.php");

require_once ("core/builder/controleshtml/Input.class.php");

/**
 * 
 *  $atributos['nombreFormulario']: Nombre del formulario al cual pertenece el botón.
 *  $atributos ["id"] = Atributo id del botón.
 *  $atributos ["tabIndex"] = A los cuantos TABs el botón capturará el enfoque.
 *  $atributos ["tipo"] = 'boton' para tipo button, cualquier otro valor generará un input.
 *  $atributos ['submit'] = Solo para tipo boton, agrega el atributo type='submit'.
 *  $atributos ["estiloMarco"] = '';
 *  $atributos ["estiloBoton"] = 'jqueryui botonAceptar';
 *  $atributos ["verificar"] = ???
 *  $atributos ["tipoSubmit"] = 
 *  $atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
 * 
 * 
 */

class BotonHtml extends HtmlBase {

    /**
     * 
     * @param string $atributos
     * @return type
     * 
     * Se encarga de poner una división que servirá como contenedor del botón
     */
    function campoBoton($atributos) {

        $this->setAtributos($atributos);

        //Codificar el nombre y el ID del control
        $this->campoSeguro();


        if (isset($_REQUEST['formSecureId'])) {
            $this->atributos [self::NOMBREFORMULARIO] = $_REQUEST['formSecureId'];
        }

        $this->cadenaHTML = '';

        $final = '';

        if (!isset($atributos [self::ESTILOMARCO]) || $atributos [self::ESTILOMARCO] == '' || $atributos [self::ESTILOMARCO] == 'jqueryui') {
            $atributos [self::ESTILOMARCO] = 'campoBoton';
        }

        if (!isset($atributos [self::SINDIVISION])) {

            $this->cadenaHTML .= "<div class='" . $atributos [self::ESTILOMARCO] . "'>\n";

            $final = '</div>';
        }

        //Armar el código HTML del botón de acuerdo a los atributos definidos
        $this->cadenaHTML .= $this->boton($this->configuracion);


        return $this->cadenaHTML . $final;
    }

    private function boton($datosConfiguracion) {

        if (isset($this->atributos [self::ESTILOBOTON])) {

            $this->atributos [self::ESTILOBOTON] = str_replace("jqueryui", "ui-button ui-state-default ui-corner-all ui-button-text-only", $this->atributos [self::ESTILOBOTON]);
        }

        if ($this->atributos [self::TIPO] == "boton") {

            $cadena = $this->tipoButton();
        } else {

            $cadena = $this->tipoInput();
        }

        // El cuadro de Texto asociado
        $cadena .= $this->cuadroAsociado();
        return $cadena;
    }

    function tipoButton() {

        $cadena = "<button ";
        //Atributos del Botón
        $cadena .= $this->atributosGeneralesBoton();
        $cadena .= $this->atributoTipoSubmit();
        $cadena .= ">" . $this->atributos [self::VALOR] . "</button>\n";
        return $cadena;
    }

    function tipoInput() {
        $cadena = "<input ";
        $cadena .= self::HTMLVALUE . "'" . $this->atributos [self::VALOR] . "' ";
        $cadena .= self::HTMLNAME . "'" . $this->atributos [self::ID] . "' ";
        $cadena .= "id='" . $this->atributos [self::ID] . "' ";
        $cadena .= self::HTMLTABINDEX . "'" . $this->atributos [self::TABINDEX] . "' ";
        $cadena .= "type='submit' ";
        $cadena .= ">\n";
        return $cadena;
    }

    function atributosGeneralesBoton() {

        $cadena = '';

        //ID del botón
        $cadena .= "id='" . $this->atributos [self::ID] . "A' ";

        //Estilos
        $cadena .= "class='" . $this->atributos [self::ESTILOBOTON] . "' ";

        //Etiqueta del Botón
        $cadena .= self::HTMLVALUE . "'" . $this->atributos [self::VALOR] . "' ";

        //Índice Tabulador
        $cadena .= self::HTMLTABINDEX . "'" . $this->atributos [self::TABINDEX] . "' ";


        if (isset($this->atributos ['submit']) && $this->atributos ['submit']) {
            $cadena .= "type='submit' ";
        } else {
            $cadena .= "type='button' ";
        }

        if (!isset($this->atributos ["onsubmit"])) {
            $this->atributos ["onsubmit"] = "";
        }

        // Poner el estilo en línea definido por el usuario
        if (isset($this->atributos [self::ESTILOENLINEA]) && $this->atributos [self::ESTILOENLINEA] != "") {
            $cadena .= "style='" . $this->atributos [self::ESTILOENLINEA] . "' ";
        }

        return $cadena;
    }

    function cuadroAsociado() {

        $cuadroTexto = new Input();
        $this->atributos [self::TIPO] = self::HIDDEN;
        $this->atributos ["obligatorio"] = false;
        $this->atributos [self::ETIQUETA] = "";
        $this->atributos [self::VALOR] = "false";
        return $cuadroTexto->cuadro_texto($this->atributos);
    }

    function atributoTipoSubmit() {
        
        if (!isset($this->atributos [self::TIPOSUBMIT])) {
            
            /**
             * Si el atributo no está declarado entonces los eventos del botón deben ser procesados por funciones definidas en ready,js
             */
            return '';
        }
        


        /**
         * Desde $atributos["tipoSubmit"] se puede declarar cierta funcionalidad:
         * 
         * 
         * '': Vacio. El botón envía el formulario al que pertenece
         * 'todos': El botón envía todos los formularios que se encuentran en la página
         * 'jquery': El botón envía el formulario al que pertenece usando la sintaxis de jquery
         * 'ready': El click en el botón es procesado por una función que debe estar definida en el archivo ready.js (predeterminado)
         * 'verificar': El click en el botón es procesado por la biblioteca (o función) de verificación definida en $atributos['verificar']
         * 
         * En todo caso, $atributos['onClick'] tiene prelación.
         *          
         */
        $cadena = '';

        if (isset($this->atributos [self::ONCLICK]) && $this->atributos [self::ONCLICK] != '') {
            $cadena .= 'onclick=" ' . $this->atributos [self::ONCLICK] . '" ';
        } else {


            if (!isset($this->atributos ["cancelar"]) && (isset($this->atributos [self::VERIFICARFORMULARIO]) && $this->atributos [self::VERIFICARFORMULARIO] != "")) {
                
                $cadena .= "onclick=\"if(" . $this->atributos [self::VERIFICARFORMULARIO] . "){document.forms['" . $this->atributos [self::NOMBREFORMULARIO] . $cadenaHtml[0] . $this->atributos [self::ID] . "'].value= 'true';";

                if ($this->atributos [self::TIPOSUBMIT] == "jquery") {
                    $cadena .= " $(this).closest('form').submit();";
                } else {
                    $cadena .= "document.forms['" . $this->atributos [self::NOMBREFORMULARIO] . "'].submit()";
                }
                $cadena .= "}else{this.disabled=false;false}\"";
            } else {

                if ($this->atributos [self::TIPOSUBMIT] == "jquery") {
                    // Utilizar esto para garantizar que se procesan los controladores de eventos de javascript al momento de enviar el form
                    $cadena .= "onclick=\"document.forms['" . $this->atributos [self::NOMBREFORMULARIO] . "'].elements['" . $this->atributos [self::ID] . "'].value='true';";
                    $cadena .= " $(this).closest('form').submit();\"";
                } else {
                    if ($this->atributos [self::TIPOSUBMIT] != "ready") {

                        $cadena .= "onclick=\"document.forms['" . $this->atributos [self::NOMBREFORMULARIO] . "'].elements['" . $this->atributos [self::ID] . "'].value='true';";
                        $cadena .= "document.forms['" . $this->atributos [self::NOMBREFORMULARIO] . "'].submit()\"";
                    }
                }
            }
        }


        return $cadena;
    }

}
