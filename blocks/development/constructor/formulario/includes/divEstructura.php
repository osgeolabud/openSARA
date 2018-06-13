<?php
        // Rescatar los datos de este bloque
        $esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
        division('divEstructura',$this->miFormulario);        
        $divisiones=array('A','B','C','D','E');
        foreach ($divisiones as $valor){
            division('div'.$valor,$this->miFormulario);            
            encabezado($valor, $this->miFormulario);              
            division('',$this->miFormulario);
        }
        division('',$this->miFormulario);
            
        
        // ---------------- FIN SECCION: Controles del Formulario -------------------------------------------
        
        
        function encabezado($texto, $formulario){
            
            // ---------------- SECCION: Header ----------------------------------------------------------
            unset ( $atributos );
            $atributos ['nivel'] = '4';
            $atributos ['texto'] = $texto;
            echo $formulario->encabezado($atributos );            
            // ---------------- FIN SECCION: Header ----------------------------------------------------------            
            
        }
        
        
        function division($texto, $formulario ){            
            if($texto!=''){
            // ---------------- SECCION: División ----------------------------------------------------------
            unset ( $atributos );
            $esteCampo = $texto;
            $atributos ['id'] = $esteCampo;
            $atributos ['estiloEnLinea'] = 'z-index: 2;';
            echo $formulario->division ( "inicio", $atributos );           
            
            }else{
                   // ---------------- FIN SECCION: División ----------------------------------------------------------
                    echo $formulario->division ( 'fin' );
            }
        }