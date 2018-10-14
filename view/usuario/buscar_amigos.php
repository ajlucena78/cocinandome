<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php $TITULO_PAGINA = 'Buscar contactos'; ?>
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
				<h1>Buscar contactos</h1>
				<div style="color: #999;">
					En este apartado podr&aacute;s localizar en nuestra red a algunos de tus conocidos por el 
					nombre de estos, o bien buscar si están registrados en nuestra p&aacute;gina con un correo 
					de tus contactos de Gmail.
				</div>
				<div style="padding-top: 4%;">
					<form name="buscador" action="" method="get">
						<input type="hidden" name="action" value="buscador_usuarios" />
						Buscar por nombre de usuario: 
						<input type="text" name="consulta_usuarios" id="consulta_buscador_amigos" value="" 
								style="width: 300px;" /> 
						<input type="submit" value="Buscar" class="boton" />
					</form>
					<script type="text/javascript">
						document.getElementById('consulta_buscador_amigos').focus();
					</script>
				</div>
				<!--
				<div style="padding-top: 2%;">
					Invitar a mis contactos de Gmail: 
					<a href="<?php vlink('login_gmail'); ?>">
						<img src="<?php echo URL_APP; ?>res/img/web/gmail-logo.jpg" 
								alt="Logo de Gmail" /> Conectar con <strong>Gmail</strong>
					</a>
					(Tendr&aacute;s que identificarte en la p&aacute;gina de Google)
				</div>
				-->
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