<?php

/*------------------------------------------------------------------------
# J DContact
# ------------------------------------------------------------------------
# author                Md. Shaon Bahadur
# copyright             Copyright (C) 2013 j-download.com. All Rights Reserved.
# @license -            http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites:             http://www.j-download.com
# Technical Support:    http://www.j-download.com/request-for-quotation.html
-------------------------------------------------------------------------*/

defined('_JEXEC') or die;

class modSvformularioHelper
{
	static function preLoadprocess(&$params)
	{
		// resultado es para devolver parametros.
		$resultado = array() ;
		// Array [show] los que selecionamos que se muestra. valor es 1-> Si se muestra .. 0-> No se muestra.
		$resultado['show']['nombre'] = $params->get( 'nombre', '1' );
		$resultado['show']['telefono'] = $params->get( 'telephone', '1' );
		$resultado['show']['asunto'] = $params->get( 'subject', '1' );
		$resultado['show']['departamentos'] = $params->get( 'showdepartment', '1' );
		$resultado['show']['copy'] = $params->get( 'showsendcopy', '1' );
		$resultado['show']['captcha'] = $params->get( 'humantestpram', '1' );
		$resultado['show']['lopd'] = $params->get( 'selectlopd', '1' );

		if ($resultado['show']['departamentos'] === 1) {
			// Array a quien mandamos email.
			$resultado['to']['ventas']	=	$params->get( 'sales_address', 'info@solucionesvigo.es' );
			$resultado['to']['ayuda']	=	$params->get( 'support_address', 'support@yourdomain.com' );
			$resultado['to']['facturacion']	=	$params->get( 'billing_address', 'billing@yourdomain.com' );
		}
		// Array [obligatorio] los que seleccionamos como obligatorios.
		$resultado['obligatorio']['nombre'] = $params->get( 'Ob_nombre', '1' );
		$resultado['obligatorio']['telefono'] = $params->get( 'Ob_telephone', '1' );
		$resultado['obligatorio']['email'] = $params->get( 'Ob_email', '1' );
		$resultado['obligatorio']['asunto'] = $params->get( 'Ob_subject', '1' );
		if ($params->get('filtroActivos','0') === '1' ){
			$filtros = $params->get('filtroGeneral');
			$resultado['filtros'] = explode(';',$filtros);
		}
		if ( $resultado['show']['lopd'] === '1'){
			// Tengo que obtener texto que puso en parametros o los textos por defectos de idiomas... según..
			$resultado['textos']['lopd'] = $params->get( 'lopd');
		}
		
		return $resultado;
	}
	static function obtenerDatos($show,$obligatorio)
	{
		/* Obtenemos datos y saneamos posibles errores. */
			$resultado = array();
			// Expresion regular para controlar email y telefono.
			$exp_telefono = '/^[6-9][0-9]{8}$/';
			$exp_email = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/";
			if(preg_match($exp_telefono, $_REQUEST['phno']))
			{ // Si es correcto telefono
				$phno = trim($_REQUEST['phno']);
			} else {
				$phno='';
			}
			if(preg_match($exp_email, mb_strtolower($_REQUEST['email'])))
			{ // Si es correcto email
				$email= trim($_REQUEST['email']);
			} else {
				$email = '';
			}
		    // El resto de campo los limpiamos de etiquetas y caracteres especiales.
		    $department                 =  preg_replace('([^A-Za-z0-9])', '', strip_tags($_REQUEST['dept']));
            $name                       =  preg_replace('([^\.,;:_ A-Za-z0-9-])', '', strip_tags($_REQUEST['name']));
            $subject                    =  preg_replace('([^\.,;:_ A-Za-z0-9-])', '', strip_tags($_REQUEST['subject']));
            $msg                        =  preg_replace('([^\.,;:_ A-Za-z0-9-])', '',strip_tags($_REQUEST['msg']));
			
			// Los posibles errores que vamos mostrar es ( debería crear parametro de si es obligatorio o no el campo)
			switch (true) {
				case ($obligatorio['nombre'] === '1'):
					// Quiere decir que es obligatorio el nombre
					if ( strlen($name) === 0 ){
						$resultado['error']['name'] = 'Error nombre';
					}
				
				
				case ($obligatorio['telefono'] === '1'):
					// Quiere decir que es obligatorio el telefono
					if ( strlen($phno) === 0 ){
						$resultado['error']['phno'] = 'Error telefono';
					}

				
				case ($obligatorio['email'] === '1' ):
					// Quiere decir que es obligatorio el email
					if ( strlen($email) === 0 ){
						$resultado['error']['email'] = 'Error email';
					}
					
				
				case ($obligatorio['asunto'] === '1'):
					// Quiere decir que es obligatorio el asunto
					if ( strlen($subject) === 0 ){
						$resultado['error']['subject'] = 'Error asunto';
					}
				
			}
			
			
			
			if (!isset($resultado['error'])) {
				// Creo array para devolver resultado ya que no hay errores
				$resultado['mensaje'] = array('Svdepartment' => $department,
												'name'=> $name,
												'email' => $email,
												'phno' => $phno,
												'subject' => $subject,
												'msg' => $msg								
												);
				if ($show['copy'] === '1'){
					// Quiere decir que es muestra botton de marcar SI/NO enviar copia uno mismo.
					if (isset($_REQUEST['selfcopy'])){
						$resultado['mensaje']['copia'] = $_REQUEST['selfcopy'];
					} 
				} 
			}
			
			return $resultado;
	}	 
 
	static function aplicarFiltros($datos,$filtros) {
		// Aplicamos filtros.
		$resultado = '';
		$busqueda= array();
		foreach ($filtros as $filtro) {
			$busqueda[1] = strpos($datos['name'], $filtro);
			$busqueda[2] = strpos($datos['email'], $filtro);
			$busqueda[3] = strpos($datos['phno'], $filtro);
			$busqueda[4] = strpos($datos['msg'], $filtro);
			$busqueda[5] = strpos($datos['subject'], $filtro);
			for ($i = 1; $i <= 5; $i++) {
				if ($busqueda[$i] != false){
				// Encontro palabra del filtro en contenido, se cancela todo.
				$resultado = ' Filtro de palabra - '.$filtro;
				break;
				}
			}
			if ($resultado !=''){
				// No continuo buscando, devuelvo error.
				break;
			}
			// Si tiene numero es que entro, si es false es que no lo encontro..
			
		}
		if ($resultado === ''){
			$resultado = 'Correcto';
		}
		return $resultado;
	}
 
 
	static function enviarEmail($datos) 
	{
		
            
            
            
            
            

			
			// Aqui seleciona el correo a enviar , si no hay por  primero... 
        	if ( $department == "sales")        $to     =   $sales_address;
        	elseif ( $department == "support")  $to     =   $support_address;
        	elseif ( $department == "billing")  $to     =   $billing_address;
            else                                $to     =   $sales_address;
			
        	// Ahora comprobamos el contenido de otros campos
        	// Y si no tienen valor porque no se muestras o algo similar entonces le ponemos al campo el 
        	// valos por dedefecto de validad que tenemos en languages
			    	
        	
        	
        	
        	if ( $subject == "" )
        	{
				// Ponemos valor subject como titulo de formulario 
        		$subject = $module->title;
        	}
        	// El unico posibles error es que no tenga email y no tenga telefono, por lo que 
        	// el formulario está mal por ello debería mostrar un error.
        	
              		
        	 /* http://docs.joomla.org/Sending_email_from_extensions  */
        	 // Antes de enviar tenemos que saber que hay email... 
        	if (preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", $email))
        	{
				$mail = JFactory::getMailer();
				
				// Crear destinatarios
				if( $selfcopy == "yes" ){
				$destinatario = array( $to, $email );
				} 
				else {
				$destinatario  = $to;
				}
				// Creamos el body del mensaje bien ...
				$body = Jtext::_('MOD_SVFORMULARIO_NAME').':'.$name.'<br/>';
				$body = $body.Jtext::_('MOD_SVFORMULARIO_TELEPHONE').':'.$phno.'<br/>';
				$body = $body.$msg;
				
				// Creo que para mandar por SMTP tengo añadir usuario y contraseña 
				// Que la obtendo con ... 
				$app = JFactory::getApplication();
				$mailfrom = $app->get('mailfrom');
				$fromname = $app->get('fromname');
				$sitename = $app->get('sitename');
				// El subject ,es el que tenemos pero indicando el sitio tambien
				
				$subject = $sitename . $subject;
				
				// Ahora montamos el correo para enviarlos.
				$mail->isHTML(true); // Indicamos que el body puede tener html
				$mail->addRecipient($destinatario);
				//$mail->addReplyTo(array($email, $name));
				$mail->setSender(array($mailfrom, $fromname));
				$mail->setSubject($subject);
				$mail->setBody($body);
				
				
				// Envio de email
				//~ $sent = $mail->Send();
				//~ // Contestación de envio.
				//~ if ( $sent !== true ) {
					//~ /*echo '<pre>';
					//~ print_r ($destinatario);
					//~ echo '</pre>';*/
					//~ echo Jtext::_('MOD_SVFORMULARIO_MAILSERVPROB').':'. $sent->__toString();
					//~ 
				//~ } else {
					//~ $ok= Jtext::_('MOD_SVFORMULARIO_SUCCESSMSG');
					//~ // Para añadir al array el resultado correcto.
					//~ $resultado['resultado'] = $ok;
				//~ }
				
			}
			
		
		return $resultado;
    }
}


