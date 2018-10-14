<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php $TITULO_PAGINA = 'Ingredientes de nuestra receta'; ?>
 		<?php include PATH_VIEW . 'includes/head.php'; ?>
 		<script type="text/javascript" src="<?php echo URL_APP; ?>view/js/alimento.js"></script>
 		<script type="text/javascript" src="<?php echo URL_APP; ?>view/js/teclado.js"></script>
 		<script type="text/javascript" src="<?php echo URL_APP; ?>view/js/recetas.js"></script>
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
				<div id="nueva_receta" style="padding-right: 1%;">
					<form id="form_ing_indicados" action="<?php vlink('guardar_receta'); ?>" method="post">
						<h1>Ingredientes de nuestra receta</h1>
						<div>
							<div class="a_la_izquierda" style="width: 60%;">
								<input type="button" value="Volver al paso anterior" class="boton"
										onclick="ir_a('<?php vlink('editar_receta_form'); ?>');" />
								<input type="button" value="+ A&ntilde;adir ingredientes" class="boton" 
										onclick="popup_clases_alimentos('elegir_cantidad_ingrediente');"
										style="color: black;" />
							</div>
							<div class="a_la_derecha" style="width: 40%; text-align: right;">
								<input type="submit" value="Guardar receta" class="boton" />
							</div>
							<div class="separador"></div>
						</div>
						<?php if ($error) { ?>
							<div class="error texto_centrado">
								<?php echo formato_html($error); ?>
								<script type="text/javascript">
									window.alert('<?php echo $error; ?>');
								</script>
							</div>
						<?php } ?>
						<div>
							<h2>Ingredientes:</h2>
							<div id="ingredientes">
								<?php include PATH_VIEW . 'includes/receta/ingredientes.php'; ?>
								<div class="separador"></div>
							</div>
						</div>
						<div class="separador">
							<h2>Informaci&oacute;n nutricional:</h2>
							<div id="info_nutricional_receta">
								<?php $alimento = $plato; ?>
								<?php include PATH_VIEW . 'includes/info_nutricional_horizontal.php'; ?>
							</div>
						</div>
					</form>
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