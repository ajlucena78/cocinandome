<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php $TITULO_PAGINA = 'Registro de usuario'; ?>
 		<?php include PATH_VIEW . 'includes/head.php'; ?>
	</head>
	<body class="body_publico">
		<div class="fondo_publico">
		</div>
		<div class="contenedor_publico">
			<div class="fondo_blanco">
				<div class="contenido_fondo">
					<div style="width: 50%; margin: 0 auto;">
						<?php include PATH_VIEW . 'includes/top_publico.php'; ?>
						<h2>Crear nueva cuenta de usuario</h2>
						<?php if ($error) { ?>
							<div class="error">
								<?php echo formato_html($error); ?>
							</div>
						<?php } ?>
						<form action="<?php vlink('registro_usuario'); ?>" method="post">
							<?php if (isset($errores['nombre'])) { ?>
								<div class="error"><?php echo $errores['nombre']; ?></div>
							<?php } ?>
							<div class="a_la_izquierda" style="width: 40%; height: 30px;">
								<label for="nombre">Nombre:</label>
							</div>
							<div class="a_la_derecha" style="width: 60%; height: 30px;">
								<input name="nombre" id="nombre" type="text" value="<?php 
										echo $usuario->nombre; ?>" style="width: 100%;" maxlength="30" />
							</div>
							<div class="separador"></div>
							<?php if (isset($errores['email'])) { ?>
									<div class="error"><?php echo $errores['email']; ?></div>
								<?php } ?>
							<div class="a_la_izquierda" style="width: 40%; height: 30px;">
								<label for="email">Correo electr&oacute;nico:</label>
							</div>
							<div class="a_la_derecha" style="width: 60%; height: 30px;">
								<input name="email" id="email" type="text" value="<?php echo $usuario->email; ?>"
										style="width: 100%;" maxlength="50" />
							</div>
							<div class="separador"></div>
							<?php if (isset($errores['clave'])) { ?>
									<div class="error"><?php echo $errores['clave']; ?></div>
								<?php } ?>
							<div class="a_la_izquierda" style="width: 40%; height: 30px;">
								<label for="clave">Contrase&ntilde;a:</label>
							</div>
							<div class="a_la_derecha" style="width: 60%; height: 30px;">
								<input name="clave" id="clave" type="password" value="" maxlength="20"
										style="width: 50%;" />
							</div>
							<div class="separador"></div>
							<div class="a_la_izquierda" style="width: 40%; height: 30px;">
								<label for="clave2">Repite la contrase&ntilde;a:</label>
							</div>
							<div class="a_la_derecha" style="width: 60%; height: 30px;">
								<input name="clave2" id="clave2" type="password" value="" maxlength="20" 
								style="width: 50%;" />
							</div>
							<div class="separador"></div>
							<div class="a_la_izquierda" style="width: 40%; height: 100px;">
								&nbsp;
							</div>
							<div class="a_la_derecha" style="width: 60%;">
								<img src="<?php echo URL_APP; ?>res/img/captcha.php" 
										alt="captcha" style="width: 100%;" />
							</div>
							<div class="separador"></div>
							<?php if (isset($errores['captcha'])) { ?>
								<div class="error"><?php echo $errores['captcha']; ?></div>
							<?php } ?>
							<div class="a_la_izquierda" style="width: 40%; height: 30px;">
								<label for="captcha">Introduce el c&oacute;digo <i>captcha</i>:</label>
							</div>
							<div class="a_la_derecha" style="width: 60%;">
								<input name="captcha" id="captcha" type="text" value="" maxlength="10"
										style="width: 50%;" />
							</div>
							<div class="separador"></div>
							<div style="text-align: center; padding-top: 4%;">
								<input type="submit" value="Crear cuenta" class="boton" />
							</div>
						</form>
						<script type="text/javascript">
							document.getElementById('nombre').focus();
						</script>
						<?php include PATH_VIEW . 'includes/bottom_publico.php'; ?>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>