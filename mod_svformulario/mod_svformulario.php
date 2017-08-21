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
		// Cambiamos de layout
		$layout .= '_respuesta';

		// Cargamos valore de enviados.
		
		$datos= modSvformularioHelper::obtenerDatos($svform['show'],$svform['obligatorio']);
		if (!isset($datos['error'])){
			if (isset($svform['filtros'])) {
			// Quiere decir que no hay errores y hay filtros que comprobar
				$res_filtro = modSvformularioHelper::aplicarFiltros($datos['mensaje'] ,$svform['filtros']);
			} else {
				// Quiere decir que no tiene ativado lo filtros.. por lo que lo ponemos correcto
				$res_filtro = 'Correcto';
			}
		}
		if (!isset($datos['error']) && ($res_filtro === 'Correcto')) {
			// Quiere decir que es todo correcto, por lo que enviamos.
			$res_envio = modSvformularioHelper::enviarEmail($datos);
		}
		
		
		
	}
	require JModuleHelper::getLayoutPath('mod_svformulario', $layout);
