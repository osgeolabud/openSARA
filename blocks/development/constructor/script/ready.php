<?php 
    $_REQUEST['tiempo']=time();
?>

setTimeout(function() {
    $('#divMensaje').hide( "drop", { direction: "up" }, "slow" );
}, 4000); // <-- time in milliseconds


$("button").button().click(function (event) {

    var blocks = {"bloques": []};

    var paneles = ['bloquesdivA', 'bloquesdivB', 'bloquesdivC', 'bloquesdivD', 'bloquesdivE'];

    var longitud = paneles.length;

    for (i = 0; i < longitud; i++) {

        indice = 1;
        var items = $('#' + paneles[i]).find('li').map(function () {
            var item = {};
            item.seccion = paneles[i].substr(paneles[i].length - 1);
            item.bloque = $(this).text().replace(/\n/g, '');
            item.posicion = indice++;
            return item;
        }
        ).get();

        blocks.bloques.push(items);
    }

    var v = JSON.stringify(blocks);
    v = v.replace(/"/g, "'");

    control = '<input type="hidden" name="misBloques" value="' + v + '"  />';
    $(control).appendTo('#formDatos');
    
    
    swal.mixin({
    position: 'top-end',
    timer: 3000
  });

    swal({
            title: '<span style="font-size:20px;font-family:\'arial\'">Desea guardar la página?</span>',
            html: '<span style="font-size:14px;font-family:\'arial\'">La estructura anterior será sobrescrita</span>',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, guardar!!',
            cancelButtonText: 'Me arrepiento!!'
            }).then((result) => {
    if (result.value) {
        
        $('#formDatos').submit();
    }
    });

            
});
