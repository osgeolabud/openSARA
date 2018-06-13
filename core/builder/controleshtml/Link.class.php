<?php

/**
 * $atributos['id']
 * $atributos['enlace']
 * $atributos['enlacecodificar']=true si se desea que se codifique el enlace contenido en la variable  $atributos['enlace']
 * $atributos['tabIndex']
 * $atributos['estilo']
 * $atributos['enlaceTexto']
 */
require_once ("core/builder/HtmlBase.class.php");

class Link extends HtmlBase {

    function enlace($atributos) {

        $this->setAtributos($atributos);
        $this->campoSeguro();

        $this->cadenaHTML = "";
        $this->cadenaHTML .= "<a ";

        if (isset($atributos ["id"])) {
            $this->cadenaHTML .= "id='" . $atributos ["id"] . "' ";
        }

        if (isset($atributos ["name"])) {
            $this->cadenaHTML .= "name='" . $atributos ["name"] . "' ";
        }

        if (isset($atributos [self::ENLACECODIFICAR]) && $atributos [self::ENLACECODIFICAR] == true) {

            $url = $this->miConfigurador->getVariableConfiguracion("host");
            $url .= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
            $url .= $this->miConfigurador->getVariableConfiguracion("enlace");
            $this->cadenaHTML .= "href='" . $this->miConfigurador->fabricaConexiones->crypto->codificar_url($atributos[self::ENLACE], $url) . "' ";
        } else {
            $this->cadenaHTML .= "href='" . $atributos [self::ENLACE] . "' ";
            exit;
        }

        if (isset($atributos ["tabIndex"])) {
            $this->cadenaHTML .= "tabindex='" . $atributos ["tabIndex"] . "' ";
        }

        if (isset($atributos [self::ESTILO]) && $atributos [self::ESTILO] != "") {

            if ($atributos [self::ESTILO] == self::JQUERYUI) {
                $this->cadenaHTML .= " class='botonEnlace ui-widget ui-widget-content ui-state-default ui-corner-all' ";
            } else {

                $this->cadenaHTML .= "class='" . $atributos [self::ESTILO] . "' ";
            }
        }
        $this->cadenaHTML .= ">\n";
        if (isset($atributos ["enlaceTexto"])) {
            $this->cadenaHTML .= "<span>" . $atributos ["enlaceTexto"] . "</span>";
        }
        $this->cadenaHTML .= "</a>\n";

        return $this->cadenaHTML;
    }

    function enlaceWiki($cadena, $titulo = "", $datoConfiguracion, $elEnlace = "") {

        if ($elEnlace != "") {
            $enlaceWiki = "<a class='wiki' href='" . $datoConfiguracion ["wikipedia"] . $cadena . "' title='" . $titulo . "'>" . $elEnlace . "</a>";
        } else {
            $enlaceWiki = "<a class='wiki' href='" . $datoConfiguracion ["wikipedia"] . $cadena . "' title='" . $titulo . "'>" . $cadena . "</a>";
        }
        return $enlaceWiki;
    }

}
