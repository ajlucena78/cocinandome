<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php $TITULO_PAGINA = 'Mis recetas'; ?>
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
				<h1>Mis recetas</h1>
				<div style="padding-right: 1%;">
					<form action="#" onsubmit="buscar_recetas('buscar_mis_recetas'); return false;">
						<div class="a_la_izquierda" style="width: 50%;">
							<input type="text" id="consulta_recetas" value="Buscar por nombre de receta" 
									onkeyup="buscar_recetas('buscar_mis_recetas');" onfocus="this.value = '';" 
									style="width: 90%; color: #AAA;" class="texto_buscador"
									onclick="this.style.color = 'black';" />
							<input type="submit" value="Buscar" style="display: none;" />
						</div>
						<div class="a_la_derecha" style="width: 50%; text-align: right;">
							<?php olink('buscar_mis_recetas', 'recetas', null, false, null, null, false, null
									, 'boton'); ?>Mostrar todas mis recetas<?php clink(); ?>
							<a href="<?php vlink('nueva_receta'); ?>" class="boton">+ Nueva receta</a>
						</div>
						<div class="separador"></div>
					</form>
				</div>
				<div id="recetas" style="padding-right: 1%; padding-top: 2%; width: 100%;">
					<?php carga('buscar_mis_recetas', 'recetas'); ?>
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