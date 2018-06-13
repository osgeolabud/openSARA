<?php

//--------------------Plantilla Cuadro de Texto ---------------------------------
//Código

/**
    * Importante descargar el arreglo atributos para evitar que los atributos de controles anteriores se
    * propaguen a este
*/
unset ( $atributos );
$atributo['name']='';
$atributo['id']='';
$atributo['valor']='';;
$atributo['deshabilitado']='';
$atributo['tamanno']='';
$atributo['estilo'] ='';
$atributo['marco']='';
$atributo['estiloMarco']='';
$atributo['columnas']='';
$atributo['etiqueta']='';
$atributo['anchoEtiqueta']='';
$atributo['estiloEtiqueta']='';
$atributo['dobleLinea']='';
$atributo['tipo']='';
$atributo['maximoTamanno']='';
$atributo['data-validate']='';
$atributo['validar']='';
$atributo['evento']='';
$atributo['tabIndex']='';
$atributo['placeHolder']='';
 
// Aplica atributos globales al control
/**
 * Los atributos globales se aplican a todos los controles del formulario 
 */
$atributos = array_merge ( $atributos, $atributosGlobales );
echo $this->miFormulario->campoCuadroTexto ( $atributos );
         
/** 
 * Descripción
 * 
 * Solo se procesan los atributos que están explícitamente definidos * 
 * 
 * $atributo['estilo']: Clases CSS que se aplicarán al control
 * $atributos['marco']: Especifica si se coloca un marco alrededor del control
 * $atributos['estiloMarco']: Clase CSS que se aplicará al marco del control. $atributos['marco'] debe estar especificado
 * $atributo['columnas']: Cantidad de espacio que ocupa el control en pantalla: 1 - 100%, 2 - 50%, 3 - 33%.
 * $atributo['etiqueta']: Etiqueta que parece al lado del control
 * $atributo['anchoEtiqueta']: Atributo width de la etiqueta (No Recomendado)
 * $atributo['estiloEtiqueta']: Clase CSS que se aplicará a la etiqueta
 * $atributo['dobleLinea']:Define si la etiqueta va en una línea diferente a la del control;
 * $atributo['tipo']: Tipo de control puede cualquiera definido en HTML5, excepto radio, checkbox, img pues en OpenSARA tienen una clase propia
 * $atributo['maximoTamanno']: Máxima cantidad de caracteres que puede aceptar el control
 * $atributo['data-validate']: Validaciones a realizar con la biblioteca Ketchup;
 * $atributo['validar']: Validaciones a realziar con la biblioteca validation-engin;
 * $atributo['evento']: Para registrar llamados a funciones para un evento que ocurra al control
 * $atributo['tabIndex': En que momento obtendrá el enfoque el control cuando se presione la tecla tab
 * $atributo['name']: Atributo name del control. Importante pues es el que se recoge en $_REQUEST;
 * $atributo['id']: Atributo id del control. Importante pues es la manera de referenciar al control en javascript
 * $atributo['valor']: Dato que presenta el control de manera predeterminada
 * $atributo['deshabilitado']: true si el control no acepta ingreso de datos, false si acepta ingreso de datos
 * $atributo['tamanno']: Tamaño en pantalla del control. No tiene nada que ver con la cantidad de caracteres que puede aceptar.
 * $atributo['textoFondo']: Texto que se mostrará dentro del control como ayuda. Desaparece cuando el usuario ingresa datos
 */
 

 
 
 

         