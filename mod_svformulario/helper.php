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
         
			if($_POST)
			{
			/* Debería entrar solo si hay envio ...*/
			// Tomamos datos de parametros. 
			$mostrarnombre =  $params->get( 'nombre', '1' );
			$mostrartelephone =  $params->get( 'telephone', '1' );	
			$mostrarsubject =  $params->get( 'subject', '1' );
			$showdepartment  	     =        $params->get( 'showdepartment', '1' );
			$showsendcopy            =        $params->get( 'showsendcopy', '1' );
			$humantestpram           =        $params->get( 'humantestpram', '1' );
			
			$department                 =       trim($_REQUEST['dept']);
            $name                       =       trim($_REQUEST['name']);
            //~ $email                      =       trim($_REQUEST['email']);
            //~ $phno                       =       trim($_REQUEST['phno']);
            $subject                    =       trim($_REQUEST['subject']);
            $msg                        =       trim($_REQUEST['msg']);
			// Saneamos posible resultado.
			$exp_telefono = '/^[6-9][0-9]{8}$/';
			$exp_email = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/"
			
			if(preg_match($exp_telefono, $_REQUEST['phno']))
			{ // Si es correcto telefono
				$phno = trim($_REQUEST['phno']);
				
			}
			if(preg_match($exp_email, $_REQUEST['email']))
			{ // Si es correcto email
				$email= trim($_REQUEST['email']);
				
			}
			
			
			// Creo array para devolver resultado
			$resultado = array() ;
			$resultado = array('Svdepartment' => $department,
								'name'=> $name,
								'email' => $email,
								'phno' => $phno,
								'subject' => $subject,
								'msg' => $msg								
								);
			
			 
 
			/* Aquí tomamos datos de a email ( departamento) enviamos email...
			 * si no mostramos departamentos ¿ A quien enviamos ? */
			
            $sales_address              =       $params->get( 'sales_address', 'info@solucionesvigo.es' );
            $support_address            =       $params->get( 'support_address', 'support@yourdomain.com' );
            $billing_address            =       $params->get( 'billing_address', 'billing@yourdomain.com' );
            
            
            $selfcopy                   =       isset($_REQUEST['selfcopy']) ? $_REQUEST['selfcopy'] : "";
            
            

			
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
				$sent = $mail->Send();
				if ( $sent !== true ) {
					/*echo '<pre>';
					print_r ($destinatario);
					echo '</pre>';*/
					echo Jtext::_('MOD_SVFORMULARIO_MAILSERVPROB').':'. $sent->__toString();
					
				} else {
					$ok= Jtext::_('MOD_SVFORMULARIO_SUCCESSMSG');
					// Para añadir al array el resultado correcto.
					$resultado['resultado'] = $ok;
					return $resultado;
				}
				
			}
		}
    }
}


