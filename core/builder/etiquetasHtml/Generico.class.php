<?php
/**
 * $atributos['nivel']: Entero. Nivel de encabezado, 1 genera h1, 2 genera h2, etc.
 * $atributos['texto']: String. Texto que mostrará el encabezado
 * $atributos['tipo']: String. Tipo de etiqueta p, span, etc
 * $atributos['tipo']: String. Tipo de etiqueta p, span, etc
 * $atributos['estilo']:String. Clases css que se aplicarán al encabezado (definidas en un archivo .css)
 * $atributos['estiloEnLinea']: String. Reglas css que se aplicarán al encabezado (en línea)
 */

//<h4 class="ui-widget-header"><span class="ui-icon ui-icon-trash">Trash</span> Trash</h4>


class Generico extends HtmlBase {
    
    function tag($ubicacion='',$atributos = '') {
        
        $this->setAtributos ( $atributos );
        
        $this->cadenaHTML = '';
        
        
        if($ubicacion=='inicio'){
        
            $this->cadenaHTML = '<'.$this->atributos['tipo'].' ';

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
        }else{  
                 $this->cadenaHTML .= '</'.$this->atributos["tipo"].'>';
        }
        return $this->cadenaHTML;
    
    }
}
    