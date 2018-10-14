<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php $TITULO_PAGINA = 'Registro'; ?>
 		<?php include PATH_VIEW . 'includes/head.php'; ?>
	</head>
	<body>
		<script type="text/javascript">
			window.alert('Su usuario ha sido registrado. Por favor, ingrese con los datos proporcionados');
			window.location.href = '/';
		</script>
		<noscript>
			<h1><?php echo formato_html($usuario->nombre); ?> ha sido registrado</h1>
			<p>
				Su usuario ha sido registrado. Por favor, <a href="/">ingrese en la web</a> con los datos 
				proporcionados.
			</p>
		</noscript>
		<!--
		<h1><?php echo formato_html($usuario->nombre); ?> ha sido registrado</h1>
		<div>
			Ahora debes confirmar el correo electr&oacute;nico que te hemos enviado a la direcci&oacute;n 
			<?php echo $usuario->email; ?>.
		</div>
		-->
	</body>
</html>