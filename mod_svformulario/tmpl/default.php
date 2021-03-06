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
	//~ echo '<pre>';
	//~ print_r ($module->title);
	//~ print_r($svform);
	//~ echo '</pre>';
?>
 <link rel="stylesheet" href="modules/mod_svformulario/tmpl/lib/svformulario.css" media="screen" />
  
    <script type="text/javascript">
				
		function validar() 
		{
		  var ok = false;
		  var numeroint = document.Svformulario.human_test.value ;
		  var f =  document.Svformulario.sum_test.value ;
		  expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		  var email = document.Svformulario.email.value ;
		  var msg = "";
		  
			  // Compruebo si el numero introducido es el correcto.
			  if(numeroint != f)
			  {
				
				var msg = "Suma bien \n"
			  } 
			  
			 if ( !expr.test(email) ){
				var msg = msg + "Error: La dirección de correo " + email + " es incorrecta.";
			 }
			// Aquí compruebo si msg tiene datos 
			if (msg !="")
			{
				if(ok == false)
				alert(msg);
				return ok
			 }
		}
	</script>
<?php
	// Creamos variables de parametros de modulo
	$selfcopy                =        '';
    $varone                  =        rand(5, 15);
    $vartwo                  =        rand(5, 15);
    $sum_rand                =        $varone+$vartwo;
	
	

?>
<style>
.humano:before{
	content:"<?php echo $varone;?>"}

</style>

     <div id="Svformulario">

		<form name="Svformulario" id="form" method="post" action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" onsubmit="return validar(this)">
            <!-- Presentadicon de department -->
            <?php if ($svform['show']['departamentos'] === '1') : ?>
              <div class="department">
              <label><?php echo JText::_('MOD_SVFORMULARIO_DEPARTMENT'); ?></label>
              <select name="dept" class="text">
              	<option value="sales"><?php echo JText::_('MOD_SVFORMULARIO_SALES'); ?></option>
              	<option value="support"><?php echo JText::_('MOD_SVFORMULARIO_SUPPORT'); ?></option>
              	<option value="billing"><?php echo JText::_('MOD_SVFORMULARIO_BILLING'); ?></option>
              </select>
              </div>
            <?php endif; ?>
            <!-- Presentacion de nombre -->
            <?php if ($svform['show']['nombre'] === '1') : ?>
            <div class="name">
            <label class="name"><?php echo JText::_('MOD_SVFORMULARIO_NAME'); ?></label>
            
            <input class="text" name="name" type="text" value="" <?php echo ($svform['obligatorio']['nombre'] === '1') ? ' required' : ''; ?> />
            </div>
			<?php endif; ?>
			<!-- Presentacion de email -->
            <?php if ($svform['show']['email'] === '1') : ?>
            <div class="email">
            <label class="email"><?php echo JText::_('MOD_SVFORMULARIO_EMAIL'); ?></label>
            <input class="text" name="email" type="text" value="" <?php echo ($svform['obligatorio']['email'] === '1') ? ' required' : ''; ?> />
            </div>
			<?php endif; ?>
			<!-- Presentacion de telefono -->
            <?php if ($svform['show']['telefono'] === '1') : ?>
            <div class="phno">
            <label class="phno"><?php echo JText::_('MOD_SVFORMULARIO_TELEPHONE'); ?></label>
            <input class="text" name="phno" type="text" value="" pattern="[0-9]{9}"<?php echo ($svform['obligatorio']['telefono'] === '1') ? 'required' : ''; ?> />
            </div>
			<?php endif; ?>
			<!-- Presentacion de asunto -->
            <?php if ($svform['show']['asunto'] === '1') : ?>
			<div class="subject">
            <label class="subject"><?php echo JText::_('MOD_SVFORMULARIO_SUBJECT'); ?></label>
            <input class="text" name="subject" type="text" value="" <?php echo ($svform['obligatorio']['asunto'] === '1') ? ' required' : ''; ?> />
            </div>
			<?php endif; ?>
			<!-- Presentacion de Mensaje -->
            <div class="msg">
            <label class="msg"><?php echo JText::_('MOD_SVFORMULARIO_MESSAGE'); ?></label>
            <textarea class="text" name="msg" required></textarea>
            </div>
			<!-- Presentacion de Lopd -->
            <?php if ($svform['show']['lopd'] === '1') : ?>
				<div class="lopd">
                 <label class="lopd"><?php echo $svform['textos']['lopd']; ?></label>
                </div>
            <?php endif; ?>
 
 
            <?php
			 if($svform['show']['copy'] ==='1') : ?>
			<!-- Presentacion de Envio de Copia -->
				<div class="checkbox">
				<input type="checkbox" name="selfcopy" <?php if($selfcopy == "yes") echo "checked='checked'"; ?> value="yes" />
				<label><?php echo JText::_('MOD_SVFORMULARIO_SELFCOPY'); ?></label>
				</div>
			<?php endif; ?>
			<?php if($svform['show']['captcha'] ==='1') : ?>
			<!-- Presentacion de Control de Spam -->
			<div class="humantest">
				<label for='message'><?php echo JText::_('MOD_SVFORMULARIO_HUMANTEST'); ?></label>
				<?php echo '<b class="humano"> + '.$vartwo.' =</b>'; ?>
				<input id="human_test" name="human_test" size="3" type="text" class="text">
				<input type="hidden" id="sum_test" name="sum_test" value="<?php echo $sum_rand; ?>" />
			</div>
			<?php endif; ?>
            
            
            <div class ="enviar">
                <input type="submit" name="submit" value="<?php echo JText::_('MOD_SVFORMULARIO_SUBMIT'); ?>" id="submit" />
           </div>
              
        </form>

      
    </div>
