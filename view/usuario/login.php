<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php $TITULO_PAGINA = 'Iniciar sesi&oacute;n'; ?>
 		<?php include PATH_VIEW . 'includes/head.php'; ?>
	</head>
	<body class="body_publico">
		<div class="fondo_publico">
		</div>
		<div class="contenedor_publico">
			<div class="fondo_blanco">
				<div class="contenido_fondo">
					<div class="a_la_izquierda" style="width: 40%;">
						<div style="width: 90%;">
							<h1>
								<a href="<?php echo URL_APP; ?>">cocinandome.es</a>
							</h1>
							<div>
								<span style="color: #999;">La plataforma de alimentaci&oacute;n para los amantes 
									de la cocina, y los no tan amantes</span>
							</div>
							<div>&nbsp;</div>
							<h2>Iniciar sesi&oacute;n</h2>
							<?php if ($error) { ?>
								<div class="error">
									<?php echo $error; ?>
								</div>
							<?php } ?>
							<form action="<?php vlink('login'); ?>" method="post">
								<div class="a_la_izquierda" style="width: 50%; height: 30px;">
									<label for="email">Correo electr&oacute;nico:</label>
								</div>
								<div class="a_la_derecha" style="width: 50%; height: 30px;">
									<input name="email" id="email" type="text" value="<?php 
											echo $usuario->email; ?>" style="width: 100%;" />
								</div>
								<div class="separador"></div>
								<div class="a_la_izquierda" style="width: 50%; height: 30px;">
									<label for="clave">Contrase&ntilde;a:</label>
								</div>
								<div class="a_la_derecha" style="width: 50%; height: 30px;">
									<input name="clave" id="clave" type="password" value="" 
											style="width: 100%;" />
								</div>
								<div class="separador">&nbsp;</div>
								<div style="text-align: right;">
									<input type="submit" value="Entrar" class="boton" />
								</div>
							</form>
							<script type="text/javascript">
								document.getElementById('email').focus();
							</script>
							<div style="text-align: right;">
								<a href="<?php 
										vlink('registro_usuario_form'); ?>">Crear nueva cuenta de usuario</a>
							</div>
						</div>
					</div>
					<div class="a_la_derecha" style="width: 60%;">
						<div id="recetas_publico">
							<?php carga_rotativa('recetas_publico', 5); ?>
						</div>
					</div>
					<div class="separador"></div>
				</div>
			</div>
		</div>
		<?php include PATH_VIEW . 'includes/bottom_publico.php'; ?>
	</body>
</html>