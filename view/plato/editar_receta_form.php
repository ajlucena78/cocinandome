<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php $TITULO_PAGINA = 'Editar receta'; ?>
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
				<div id="nueva_receta" style="padding-right: 4%;">
					<h1>Editar receta</h1>
					<?php if ($error) { ?>
						<div class="error">
							<?php echo formato_html($error); ?>
						</div>
					<?php } ?>
					<form action="<?php vlink('ingredientes_receta_form'); ?>" method="post" 
							enctype="multipart/form-data" id="form_receta">
						<?php include PATH_VIEW . 'includes/receta/form.php'; ?>
					</form>
					<script type="text/javascript">
						document.getElementById('nombre_plato').focus();
					</script>
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