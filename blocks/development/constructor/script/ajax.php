<?php
/**
 * 
 * Los datos del bloque se encuentran en el arreglo $esteBloque.
 */
// URL base
$url = $this->miConfigurador->getVariableConfiguracion("host");
$url .= $this->miConfigurador->getVariableConfiguracion("site");
$url .= "/index.php?";

// Variables para Codificar
$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar .= "&procesarAjax=true";
$cadenaACodificar .= "&action=index.php";
$cadenaACodificar .= "&bloqueNombre=" . $esteBloque["nombre"];
$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque["grupo"];
$cadenaACodificar .= "&funcion=consultarPagina";

$cadenaACodificar2 = $cadenaACodificar . "&funcion=consultarBloques";

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar, $enlace);

$cadena2 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar2, $enlace);

// URL definitiva que procesará las peticiones Ajax

$url2 = $url . $cadena2;

$url = $url . $cadena;
?>
<script type='text/javascript'>
    $("#paginaMaestra").devbridgeAutocomplete({
        minChars: 1,
        serviceUrl: '<?php echo $url; ?>',
        onSelect: function (suggestion) {
            $("#paginaMaestra").val(suggestion.value);
            $("#paginaMaestra").attr("id_pagina", suggestion.data);
            $("#divEstructura").show();
            $("#divNavegador").show();            
            $('ul','#divEstructura').each(function(index) {
                        this.remove();
            });
            rescatarBloques('<?php echo $url2; ?>');
        }
    });


    function rescatarBloques(url) {

        var page = $("#paginaMaestra").attr("id_pagina");

        $.ajax({
            url: url,
            data: {
                paginaMaestra: page
            },
            dataType: 'json',
            success: function (data) {

                $.each(data, function (index, value) {
                    $.each(value, function (index, objeto) {
                        agregarItem($('#div'+objeto.seccion), $('<li>'+objeto.nombre+'</li>'));
                    });
                });
            },
            error: function () {

            }
        });


    }


    function agregarItem($contenedor, $item) {

        var $list = $("ul", $contenedor).length ?
                $("ul", $contenedor) :
                $("<ul id='bloques" + $contenedor.attr('id') + "' class='listaBloques'/>").appendTo($contenedor);

        
        
        $item.addClass("ui-state-default sinLista");
        $item.appendTo($list).fadeIn(function () {
            $item
                    .animate();
        });

        $item.draggable({
            opacity: .8,
            addClasses: false,
            helper: 'clone',
            revert: "invalid",
            cursor: "move",
            zIndex: 100
        });
    }
    ;
</script>

