<form action="<?php vlink('publicar_plan'); ?>" method="post" id="form_publico">
	<strong>Mostrar a otros usuarios:</strong>
	<br />
	<input id="no_publico" type="radio" name="publico" value="0" <?php 
			if (!$_SESSION['usuario']->plan_publico) { ?>checked="checked"<?php } ?> 
			onclick="publicar_plan();" />
	<label for="no_publico">No</label>
	<input id="solo_contactos" type="radio" name="publico" value="1" <?php 
			if ($_SESSION['usuario']->plan_publico == 1) { ?>checked="checked"<?php } ?> 
			onclick="publicar_plan();" />
	<label for="solo_contactos">S&oacute;lo a mis contactos</label>
	<input id="todos" type="radio" name="publico" value="2" <?php 
			if ($_SESSION['usuario']->plan_publico == 2) { ?>checked="checked"<?php } ?> 
			onclick="publicar_plan();" />
	<label for="todos">A todos</label>
</form>