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
	
	
	echo '<pre>';
	print_r($svform);
	echo 'Respuesta de filtro:<br/>';
	print_r($res_filtro);
	echo '<br/>';
	print_r($datos);
	echo 'Envio:<br/>';
	if (isset($res_envio)){
	print_r($res_envio);
	}
	echo '</pre>';
?>
 

      
