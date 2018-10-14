<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php $TITULO_PAGINA = 'Buscador'; ?>
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
				<h1>Resultados de la b&uacute;squeda de personas</h1>
				<?php if (strlen(trim($_GET['consulta_usuarios'])) < 3) { ?>
					Introduce al menos tres caracteres en la palabra a buscar. <a href="<?php 
							vlink('buscar_amigos'); ?>">Volver</a>
				<?php }else{ ?>
					<div id="buscar_usuarios">
						<?php carga('buscar_usuarios', null, array('consulta' => $_GET['consulta_usuarios'])); ?>
					</div>
				<?php } ?>
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