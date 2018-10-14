<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php $TITULO_PAGINA = 'Contactos de Google'; ?>
 		<?php include PATH_VIEW . 'includes/head.php'; ?>
	</head>
	<body>
		<div id="top">
			<?php include PATH_VIEW . 'includes/top.php'; ?>
		</div>
		<div id="menu">
			<?php include PATH_VIEW . 'includes/menu.php'; ?>
		</div>
		<div id="contenido">
			<div id="main" class="a_la_izquierda">
				<h1>Contactos de Google</h1>
				<div style="padding-right: 1%;">
					<?php if (count($usuarios) == 0 and count($emails) == 0) { ?>
						<div style="color: #999">
							No hay ning&uacute;n contacto que podamos mostrarte para invitar.
						</div>
					<?php }else{  ?>
						<?php foreach($usuarios as $amigo) { ?>
							<div style="width: 33%;">
								<?php include PATH_VIEW 
										. 'includes/usuario/sugerencia_amistad.php'; ?>
							</div>
						<?php } ?>
						<?php if (count($emails) > 0) { ?>
							<div style="color: #999">
								Puedes invitar al resto de tus contactos a unirse a la p&aacute;gina, 
								envi&aacute;ndoles un correo electr&oacute;nico de invitaci&oacute;n
							</div>
							<form action="<?php vlink('invitar_contactos_email'); ?>" method="post">
								<?php foreach ($emails as $email) { ?>
									<div style="width: 33%;" class="a_la_izquierda">
										<input type="checkbox" value="<?php echo formato_html($email); ?>"
												name="contactos[]" id="<?php echo formato_html($email); ?>" />
										<label for="<?php echo formato_html($email); ?>" style="cursor: pointer;">
											<?php echo formato_html($email); ?>
										</label>
									</div>
								<?php } ?>
								<div class="separador"></div>
								<div style="text-align: center;">
									<br />
									<input type="submit" value="Enviar invitaciones" class="boton" />
									<br />
								</div>
							</form>
						<?php } ?>
					<?php }  ?>
				</div>
			</div>
			<div id="bloque_derecha" class="a_la_derecha">
				<?php include PATH_VIEW . 'includes/bloque_derecha.php'; ?>
			</div>
			<div class="separador"></div>
		</div>
		<div id="pie">
			<?php include PATH_VIEW . 'includes/pie.php'; ?>
		</div>
	</body>
</html>