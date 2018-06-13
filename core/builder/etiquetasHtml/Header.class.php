<?php
/**
 * $atributos['nivel']: Entero. Nivel de encabezado, 1 genera h1, 2 genera h2, etc.
 * $atributos['texto']: String. Texto que mostrará el encabezado
 * $atributos['estilo']:String. Clases css que se aplicarán al encabezado (definidas en un archivo .css)
 * $atributos['estiloEnLinea']: String. Reglas css que se aplicarán al encabezado (en línea)
 */

//<h4 class="ui-widget-header"><span class="ui-icon ui-icon-trash">Trash</span> Trash</h4>


class Header extends HtmlBase {
    
    function encabezado($atributos = "") {
        
        $this->setAtributos ( $atributos );
        
        $this->cadenaHTML = '';
        
        //Predeterminado encabezado h1
        if (isset ( $this->atributos [self::NIVELENCABEZADO] )) {
            $tipo='h'.$this->atributos [self::NIVELENCABEZADO]." ";
        } else {
             $tipo = 'h1 ';
        }
        
        $this->cadenaHTML = '<'.$tipo;
         
        if (isset ( $this->atributos [self::ESTILO] )) {
                $this->cadenaHTML .= "class='" . $this->atributos [self::ESTILO] . "' ";
        }
        
        if (isset ( $this->atributos [self::ESTILOENLINEA] )) {
             $this->cadenaHTML .= "style='" . $this->atributos [self::ESTILOENLINEA] . "' ";
        }
        
        $this->cadenaHTML .='>';

         if (isset ( $this->atributos [self::TEXTO] )) {
             $this->cadenaHTML .= $this->atributos [self::TEXTO];
         }

         $this->cadenaHTML .= '</'.$tipo.'>';
        return $this->cadenaHTML;
    
    }
}
    