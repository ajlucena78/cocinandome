<?php if (count($usuarios) > 0) { ?>
	<h2>Personas que quiz&aacute;s conozcas...</h2>
	<?php foreach($usuarios as $amigo) { ?>
		<?php include PATH_VIEW . 'includes/usuario/sugerencia_amistad.php'; ?>
	<?php } ?>
	<hr />
<?php } ?>