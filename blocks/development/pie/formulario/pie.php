<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

$rutaPrincipal = $this->miConfigurador->getVariableConfiguracion ( 'host' ) . $this->miConfigurador->getVariableConfiguracion ( 'site' );

$indice = $rutaPrincipal . "/index.php?";

$directorio = $rutaPrincipal . '/' . $this->miConfigurador->getVariableConfiguracion ( 'bloques' ) . "/menu_principal/imagen/";

$urlBloque = $this->miConfigurador->getVariableConfiguracion ( 'rutaUrlBloque' );

$enlace = $this->miConfigurador->getVariableConfiguracion ( 'enlace' );

?><hr>
<div class="pie">
	<div class="seccionDerecha">
			<span class="pieEncabezado">OpenSARA Framework</span><br><br>
			(R)2013 -2018. OpenSARA es código abierto.<br>
			OSGeoLabUD - Universidad Distrital Francisco José de Caldas<br><br>
			<span class="pieEncabezado">Powered by: openSARA Framework</span><br>
			<a href="mailto:paulo_cesar@udistrital.edu.co">paulo_cesar@udistrital.edu.co</a><br><br>
			
	</div>
	<div class="pieDivision">
			<br> <img src="<?php echo $urlBloque.'/imagen/' ?>bg_ulfooter.gif">
	</div>	
	<div class="seccionIzquierda">
			<p>
				<img src="<?php echo $urlBloque.'/imagen/' ?>arrow_footer.gif"> <a
					href="https://github.com/frameworksara/openSARA" target="_blank"
					title="">Fork me on Github</a>
			</p>
	</div>
</div>