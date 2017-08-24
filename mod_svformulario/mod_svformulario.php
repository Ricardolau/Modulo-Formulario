<?php

/*
# author                Ricardo Carpintero Gil
# @license -            http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Support:             	http://ayuda.svigo.es
# Email Support:    	info@solucionesvigo.es
-------------------------------------------------------------------------*/
defined('_JEXEC') or die;
require_once __DIR__ . '/helper.php';

$params->def('greeting', 1);

// Con $svform recuperamos los datos devueltos por helper
$svform = modSvformularioHelper::preLoadprocess($params);
$layout           = $params->get('layout', 'default');

if ($_POST) {
	// Cargamos valore de enviados.

	$datos= modSvformularioHelper::obtenerDatos($svform['show'],$svform['obligatorio'],$svform['to']);

	$res_filtro = 'Correcto';
	if (isset($svform['filtros'])) {
	// Quiere decir que no hay errores y hay filtros que comprobar
		$res_filtro = modSvformularioHelper::aplicarFiltros($datos['mensaje'] ,$svform['filtros']);
	}

	if (($res_filtro === 'Correcto') and (!isset( $datos['error']))){
		// Quiere decir que es todo correcto, por lo que enviamos.
		$res_envio = modSvformularioHelper::enviarEmail($datos['mensaje'],$svform['to'],$module->title);
	}

	$layout .= modSvformularioHelper::consigueLayout($datos, $res_filtro);
}

require JModuleHelper::getLayoutPath('mod_svformulario', $layout);
