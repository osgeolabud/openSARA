<?php

namespace development\navegadorBloques\formulario;

/**
 * IMPORTANTE: Este formulario está utilizando jquery.
 * Por tanto en el archivo ready.php se declaran algunas funciones js
 * que lo complementan.
 */
class Registrador {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
        
        var $grupos;
        var $maxNivel=0;
        var $indice=0;
        
	function __construct($lenguaje, $formulario) {
		$this->miConfigurador = \Configurador::singleton ();
		
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		
		$this->lenguaje = $lenguaje;
		
		$this->miFormulario = $formulario;
	}
	function navegador($gestorConexiones) {
            //1. Obtener los bloques que se tienen registrados
            $this->conexion = $this->miConfigurador->fabricaConexiones->getRecursoDB ( 'estructura' );
            $cadenaSql = $gestorConexiones->getCadenaSql ( 'consultarBloques' );
            $resultado = $this->conexion->ejecutarAcceso ( $cadenaSql, 'busqueda' );
            // ---------------- SECCION: División ----------------------------------------------------------
            unset ( $atributos );
            $esteCampo = 'divNavegador';
            $atributos ['id'] = $esteCampo;
            echo $this->miFormulario->division ( "inicio", $atributos );
            if($resultado){
                $this->procesarJerarquia($resultado);
                $this->armarNavegador(0,0);
                
            }
            // ---------------- FIN SECCION: División ----------------------------------------------------------
            echo $this->miFormulario->division ( 'fin' );
            
	}
        
        
        private function procesarJerarquia($resultado){
            foreach ($resultado as $registro){
                    //1A. Determinar en que nivel se encuentra el bloque
                    $gruposBloque= explode("/",$registro['grupo']);
                    $nivelBloque=count($gruposBloque);
                    
                    //1B. Poblar el arreglo bi-dimensional $grupos
                    foreach ($gruposBloque as $clave => $valor){
                        
                        if($clave==0){
                            $valorPadre='';
                        }else{
                            $valorPadre=$gruposBloque[$clave-1];
                        }
                        
                        $idPadre=$this->registrarGrupo($clave, $valor,$valorPadre);                         
                    }
                    
                    $this->registrarBloque($nivelBloque, $registro['nombre'],$idPadre);                         
                }
        }
        
        
        private function registrarBloque($clave, $valor, $idPadre){
            
            $this->grupos[$this->indice]=array('id'=>$this->indice, 
                'nombre'=>$valor, 
                'nivel'=>$clave, 
                'idPadre'=>$idPadre,
                'tipo'=>'bloque');
            
            $this->indice++;
            
            if($clave>$this->maxNivel){
                $this->maxNivel=$clave;
            }
            
        }
        
        
        
        private function registrarGrupo($clave, $valor, $valorPadre){
            
            $guardar=false;
            $idPadre=0;
            if(is_array($this->grupos)){
                foreach ($this->grupos as $arreglo) {
                    
                    if($arreglo['nivel']==$clave && $arreglo['nombre']==$valor && $arreglo['idPadre']==$valorPadre){
                        return $arreglo['nivel'];                    
                    }

                    if($clave>0 
                            &&$arreglo['nivel']==($clave-1) 
                            && array_search($valorPadre, $arreglo)){

                        $idPadre=$arreglo['id'];                    

                    }                    
                }
            }
            
            
            $this->grupos[$this->indice]=array('id'=>$this->indice, 
                'nombre'=>$valor, 
                'nivel'=>$clave, 
                'idPadre'=>$idPadre,
                'tipo'=>'paquete');
            
            $this->indice++;
            
            if($clave>$this->maxNivel){
                $this->maxNivel=$clave;
            }
            return $this->indice-1;
        }
        
        
        private function armarNavegador($nivel, $idPadre){
            
                foreach($this->grupos as $nodo){
                    
                    if($nodo['nivel']==$nivel && $nodo['idPadre']==$idPadre  ){                        
                        
                        
                        echo "<ul class='navegadorBloques'>\n";
                        echo "<li class='".$nodo['tipo']."'>\n".$nodo['nombre'];
                        
                        if($nivel<=$this->maxNivel){
                            $this->armarNavegador($nivel+1, $nodo['id']);
                        }
                        echo "\n</li>\n";
                        echo "</ul>\n";
                        
                    } 
                
                
                }
            }
            
        }
        
        
        
        

$miSeleccionador = new Registrador ( $this->lenguaje, $this->miFormulario );

$miSeleccionador->navegador ($this->sql);

?>

