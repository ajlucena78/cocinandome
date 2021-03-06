<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php $TITULO_PAGINA = 'Recetas que puedo cocinar'; ?>
 		<?php include PATH_VIEW . 'includes/head.php'; ?>
 		<script type="text/javascript" src="<?php echo URL_APP; ?>view/js/recetas.js"></script>
 		<script type="text/javascript" src="<?php echo URL_APP; ?>view/js/plan.js"></script>
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
				<h1>Recetas que puedo cocinar</h1>
				<div style="padding-right: 1%;">
					<form action="#" onsubmit="buscar_recetas('recetas_que_puedo_cocinar'); return false;">
						<div class="a_la_izquierda" style="width: 50%;">
							<input type="text" id="consulta_recetas"  value="Buscar por nombre de receta" 
									onkeyup="buscar_recetas('recetas_que_puedo_cocinar');" 
									onfocus="this.value = '';" style="width: 90%; color: #AAA;" 
									class="texto_buscador" />
							<input type="submit" value="Buscar" style="display: none;" />
						</div>
						<div class="a_la_derecha" style="width: 50%; text-align: right;">
							<?php olink('recetas_que_puedo_cocinar', 'recetas', null, null, null, null, null
									, null, 'boton'); ?>Mostrar todas<?php clink(); ?>
						</div>
						<div class="separador"></div>
					</form>
				</div>
				<div id="recetas" style="padding-right: 1%; padding-top: 2%; width: 100%;">
					<?php carga('recetas_que_puedo_cocinar', 'recetas'); ?>
				</div>
			</div>
			<div id="bloque_derecha" class="a_la_derecha">
				<?php include PATH_VIEW . 'includes/bloque_derecha.php'; ?>
			</div>
			<div class="separador"></div>
		</div>
		<?php include PATH_VIEW . 'includes/popup.php'; ?>
		<div id="pie">
			<?php include PATH_VIEW . 'includes/pie.php'; ?>
		</div>
	</body>
</html>