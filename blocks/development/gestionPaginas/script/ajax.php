<?php
/**
 * 
 * Los datos del bloque se encuentran en el arreglo $esteBloque.
 */
// URL base
$url = $this->miConfigurador->getVariableConfiguracion ( "host" );
$url .= $this->miConfigurador->getVariableConfiguracion ( "site" );
$url .= "/index.php?";

// Variables
$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
$cadenaACodificar .= "&procesarAjax=true";
$cadenaACodificar .= "&action=index.php";
$cadenaACodificar .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar .= "&funcion=consultarPaginas";

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificar, $enlace );

// URL definitiva
$urlTablaDinamica = $url . $cadena;

// Variables
$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
$cadenaACodificar .= "&procesarAjax=true";
$cadenaACodificar .= "&action=index.php";
$cadenaACodificar .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar .= "&funcion=crearPagina";

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificar, $enlace );

// URL definitiva
$urlCrearBloque = $url . $cadena;

// Variables
$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
$cadenaACodificar .= "&procesarAjax=true";
$cadenaACodificar .= "&action=index.php";
$cadenaACodificar .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar .= "&funcion=editarPagina";

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificar, $enlace );

// URL definitiva
$urlEditarBloque = $url . $cadena;

// Variables
$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
$cadenaACodificar .= "&procesarAjax=true";
$cadenaACodificar .= "&action=index.php";
$cadenaACodificar .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar .= "&funcion=eliminarPagina";

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificar, $enlace );

// URL definitiva
$urlEliminarBloque = $url . $cadena;

?>
<script type='text/javascript'>


function accionBloque(url) {

 	$.ajax({
            url: url,
            data: {
                status:1
            },
            dataType : 'json'
        });

        location.reload(true);
}

$(document).ready(function() {
	$(function() {
	         	$('#tabla_gestion').ready(function() {
                            $("#tabla_gestion").jqGrid({
	                     url:	"<?php echo $urlTablaDinamica?>",
	                     datatype:  "json",
	                     mtype:     "GET",
	                     colModel: [
                                            {
                                                    label: 'ID',
                                                    name: 'id',
                                                    width: 40,
                                                    key: true,
                                                    editable: false,
                                                    sorttype:'number',
                                                    editrules : {required: true}
                                             },
                                            {
                                               label: 'Nombre',
                                               name: 'nombre',
                                               width: 40,
                                               editable: true,
                                               sorttype:'text',

                                            },
                                            {
                                               label: 'Descripción',
                                               name: 'descripcion',
                                               width: 100,
                                               editable: true,
                                               sorttype:'text', 
                                               editrules : {required: true} 
                                            },
                                            {
                                                label : 'Módulo',
                                                name: 'modulo',
                                                width: 40,
                                                editable: true,
                                                sorttype:'text',
                                            },
                                            {
                                                label : 'Nivel',
                                                name: 'nivel',
                                                width: 80,
                                                editable: true,
                                                sorttype:'text',
                                                align: 'center'
                                            },
                                            {
                                                label : 'Parámetro',
                                                name: 'parametro',
                                                width: 80,
                                                editable: true,
                                                sorttype:'text',
                                                align: 'center'
                                            }
	                         ],
	                   	sortname: 'id',
                                sortorder : 'asc',
                                viewrecords: true,
                                rownumbers: false,
                                loadonce : false,
                                rowNum: 100, 
                                width: 1010,
                                height: 300,
                                pager: "#barra_herramientas",
                                caption: "Gestión de Páginas"
	                 });


                        // Barra de Navegación Inferior
                        
                            $("#tabla_gestion").navGrid('#barra_herramientas',
                                    
                                    {	
                                        edit:true,
                                        edittext:'Actualizar Página',	    		
                                        
                                        add:true,
                                        addtext:'Crear Página',
                                        
                                        del:true ,
                                        deltext:'Eliminar Página',
                                        
                                        alertcap:"Alerta",
                                        alerttext:"Seleccione Página",
                                        search:false ,
                                        
                                        refresh:true,
                                        refreshstate: 'current',
                                        refreshtext:'Recargar Páginas',
                                    },
                                    {    
                                        editCaption: "Actualizar Página",
                                        mtype:'GET',
                                        url:'<?php echo $urlEditarBloque?>',
                                        bSubmit: "Actualizar",
                                        bCancel: "Cancelar",
                                        bClose: "Close",
                                        saveData: "Los datos han cambiado! Guardar los cambios?",
                                        bYes : "Yes",
                                        bNo : "No",
                                        bExit : "Cancel",
                                        closeOnEscape:true,
                                        closeAfterEdit:true,
                                        refresh:true,
                                        reloadAfterSubmit:true,
                                        recreateForm: true,
                                        onclickSubmit:function(params, postdata){
                                            //save add
                                            var p=params;
                                            var pt=postdata;
                                        },
                                        beforeSubmit : function(postdata, formid) { 
                                            var p = postdata;
                                            var id=id;
                                            var success=true;
                                            var message="Continuar";
                                            return[success,message]; 
                                        },    
                                        afterSubmit : function(response, postdata) 
                                        { 
                                            var r=response; 
                                            var p=postdata;
                                            var responseText=jQuery.jgrid.parse(response.responseText);
                                            var success=true;
                                            var message="Continuar";
                                            return [success,message] 
                                        },
                                        afterComplete : function (response, postdata, formid) {        
                                            var responseText=jQuery.jgrid.parse(response.responseText);
                                            var r=response;
                                            var p=postdata;
                                            var f=formid;
                                        }
                                    },//edit
                                    { 
                                        caption:"Crear Página",
                                        addCaption: "Crear Página",
                                        //width: 350, 
                                        //height: 190,
                                        mtype:'GET',
                                        url:'<?php echo $urlCrearBloque?>',
                                        bSubmit: "Crear",
                                        bCancel: "Cancelar",
                                        bClose: "Cerrar",
                                        saveData: "Los datos han cambiado! Guardar los cambios?",
                                        bYes : "Si",
                                        bNo : "No",
                                        bExit : "Cancelar",
                                        closeOnEscape:true,
                                        closeAfterAdd:true,
                                        refresh:true,
                                        reloadAfterSubmit:true,
                                        recreateForm: true,
                                        onclickSubmit:function(params, postdata){
                                            //save add
                                            var p=params;
                                            var pt=postdata;
                                        },
                                        beforeSubmit : function(postdata, formid) { 
                                            var p = postdata;
                                            var id=id;
                                            var success=true;
                                            var message="continue";
                                            return[success,message]; 
                                        },    
                                        afterSubmit : function(response, postdata) 
                                        { 
                                            var r=response; 
                                            var p=postdata;
                                            var responseText=jQuery.jgrid.parse(response.responseText);
                                            var success=true;
                                            var message="continue";
                                            return [success,message] 
                                        },
                                        afterComplete : function (response, postdata, formid) {        
                                            var responseText=jQuery.jgrid.parse(response.responseText);
                                            var r=response;
                                            var p=postdata;
                                            var f=formid;
                                        }


               	                    },//add                                    
                                    {
	              			url:'<?php echo $urlEliminarBloque?>',
                                        caption: "Eliminar Pagina",
                                        //width: 350,
                                        //height:125,
                                        mtype:'GET',
                                        bSubmit: "Eliminar",
                                        bCancel: "Cancelar",
                                        bClose: "Close",
                                        msg:" <b>¿Desea Eliminar Página?</b><br>¡ <b>NO</b> se podrán reversar los Cambios !",
                                        bYes : "Yes",
                                        bNo : "No",
                                        bExit : "Cancel",
                                        closeOnEscape:true,
                                        closeAfterDell:true,
                                        refresh:true,
                                        reloadAfterSubmit:true,
                                        recreateForm: true,
                                        onclickSubmit:function(params, postdata,id_items){
                                            //save add
                                            var p=params;
                                            var pt=postdata;


                                        },
                                        beforeSubmit : function(postdata, formid) { 
                                            var p = postdata;
                                            var id=formid;
                                            var success=true;
                                            var message="continue";
                                            return[success,message]; 
                                        }, 
                                        afterSubmit : function(response, postdata) 
                                        { 
                                            var r=response; 
                                            var p=postdata;
                                            var responseText=jQuery.jgrid.parse(response.responseText);
                                            var success=true;
                                            var message="continue";
                                            return [success,message] 
                                        },
                                        afterComplete : function (response, postdata, formid) {        
                                            var responseText=jQuery.jgrid.parse(response.responseText);
                                            var r=response;
                                            var p=postdata;
                                            var f=formid;

                                        } 
                                    },//del 
                                    {},
                                    {}
	                 	);


	                 
	         			                  
	       });

	});
});

</script>

