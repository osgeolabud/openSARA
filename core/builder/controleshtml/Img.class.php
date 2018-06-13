<?php
require_once ("core/builder/HtmlBase.class.php");

/**
 * $atributos['imagen']: ruta de la imagen (requerido)
 * $atributos['estilo']: Estilo que se aplicará ala división que contiene la imagen (opcional)
 * $atributos['etiqueta']: Texto alternativo de la imagen (opcional)
 * $atributos['borde']: Borde decorativo de la imagen (opcional) 
 * $atributos['ancho']: Ancho de la imagen (opcional)
 * $atributos['alto']: Altura de la imagen (opcional)
 *
 */


class Img extends HtmlBase{
    
    function campoImagen($atributos) {
    
        if (isset ( $atributos [self::ESTILO] ) && $atributos [self::ESTILO] != "") {
            $this->cadenaHTML = "<div class='" . $atributos [self::ESTILO] . "' ";
        } else {
            $this->cadenaHTML = "<div class='campoImagen' ";
        }
        
        if (!isset ( $atributos [self::ID] )) {
            $atributos [self::ID]=time();
        }
        $this->cadenaHTML .="id ='".$atributos [self::ID]."' name='".$atributos [self::ID] ."' >";
    
        $this->cadenaHTML .= "<div class='marcoCentrado'>\n";
        $this->cadenaHTML .= "<img src='" . $atributos ["imagen"] . "' ";
    
        if (isset ( $atributos [self::ETIQUETA] ) && $atributos [self::ETIQUETA] != "") {
            $this->cadenaHTML .= "alt='" . $atributos [self::ETIQUETA] . "' ";
        }
    
        if (isset ( $atributos ["borde"] )) {
            $this->cadenaHTML .= "border='" . $atributos ["borde"] . "' ";
        } 
        if (isset ( $atributos [self::ANCHO] ) && $atributos [self::ANCHO] != "") {
                $this->cadenaHTML .= "width='" . $atributos [self::ANCHO] . "' ";                
        }
    
        if (isset ( $atributos ["alto"] )  && $atributos ["alto"] != "") {
                $this->cadenaHTML .= "height='" . $atributos [self::ALTO] . "' ";
        }
        
        $this->cadenaHTML .= " />";
        $this->cadenaHTML .= "</div>\n";
        $this->cadenaHTML .= "</div>\n";
        return $this->cadenaHTML;
    
    }
    
    
}