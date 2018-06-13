<?php
/**
 * $atributos['id']: String.
 * $atributos['nombre']: String.
 * $atributos['ubicacion']: String. inicio: es una etqieuta de inicio.
 * $atributos['tipo']: String. Tipo de etiqueta p, span, etc
 * $atributos['estilo']:String. Clases css que se aplicarán al encabezado (definidas en un archivo .css)
 * $atributos['estiloEnLinea']: String. Reglas css que se aplicarán al encabezado (en línea)
 */




class Generico extends HtmlBase {
    
    function tag($atributos = '') {
        
        $this->setAtributos ( $atributos );
        
        $this->predeterminados();
        
        
        
        $this->cadenaHTML = '';
        
        
        if($atributos['ubicacion']=='inicio'){
        
            $this->cadenaHTML = '<'.$this->atributos['tipo'].' ';
            
            $this->cadenaHTML .= "id='" . $this->atributos [self::ID] . "' ";
            
            $this->cadenaHTML .= "name='" . $this->atributos [self::NOMBRE] . "' ";
            

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
    
    function predeterminados(){
        
        
        if(!isset($this->atributos['ubicacion'])){
            $this->atributos['ubicacion']='inicio';
        }
        
        if(!isset($this->atributos['id'])){
            $this->atributos['id']='OS_indefinido';
        }
        
        if(!isset($this->atributos['nombre'])){
            $this->atributos['id']='OS_indefinido';
        }
        
    }
}
    