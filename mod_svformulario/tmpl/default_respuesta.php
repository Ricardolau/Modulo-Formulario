<?php

/*------------------------------------------------------------------------
# SV Formulario
# ------------------------------------------------------------------------
# author                Solucionesvigo.es
# copyright             Libre.
# @license -            http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites:             http://solucionesvigo.es
# Technical Support:    http://ayuda.svigo.es
* -------------------------------------------------------------------------*/

defined('_JEXEC') or die('Restricted access');
	
	
	
?>
<div id="Svformulario">
 <p><?php 
	echo ' <h1> Hubo un error , no se envio</h1>';
	//~ echo '<pre>';
	//~ print_r($svform);
	if (isset($datos['error'])) {
		echo 'Error en campos:<br/>';
		echo '<ul>';
		foreach ($datos['error'] as $mensaje) {
			echo '<li>'.$mensaje."</li>";
		}
		echo '</ul>';
	} else if (isset($res_filtro)) {
		echo 'Respuesta de filtro:<br/>';
		echo "<ul><li>".$res_filtro."</li></ul>";
	}
	//~ print_r($datos['error']);
	//~ echo 'Datos a enviar :<br/>';
	//~ print_r($datos);
	//~ echo 'Respuesta Envio:<br/>';
	//~ if (isset($res_envio)){
	//~ print_r($res_envio);
	//~ }
	//~ echo '</pre>';
	
	?>
</p>

</div>
