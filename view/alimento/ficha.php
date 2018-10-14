<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php $TITULO_PAGINA = $alimento->nombre_alimento; ?>
 		<?php include PATH_VIEW . 'includes/head.php'; ?>
 		<script type="text/javascript" src="<?php echo URL_APP; ?>view/js/alimento.js"></script>
 		<script type="text/javascript" src="<?php echo URL_APP; ?>view/js/teclado.js"></script>
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
				<div class="a_la_izquierda" style="width: 60%;">
					<h1><?php echo formato_html($alimento->nombre_alimento); ?></h1>
					<div>
						<?php if ($alimento->foto_alimento  and file_exists(APP_ROOT 
								. 'res/img/alimento/' . $alimento->foto_alimento)) { ?>
							<img src="<?php echo URL_APP; ?>res/img/alimento/<?php 
									echo $alimento->foto_alimento; ?>" alt="<?php 
									echo formato_html($alimento->nombre_alimento); ?>" 
									style="width: 200px;" />
						<?php }else{ ?>
							<img src="<?php echo URL_APP; ?>res/img/alimento/sin_foto.jpg" alt="<?php 
									echo formato_html($alimento->nombre_alimento); ?>" 
									style="width: 200px;" />
						<?php } ?>
					</div>
					<div id="op_alimento_<?php echo $alimento->id_alimento; ?>" style="width: 90%;">
						<?php carga('op_alimento', 'op_alimento_' . $alimento->id_alimento
								, array('id_alimento' => $alimento->id_alimento)); ?>
					</div>
					<div>&nbsp;</div>
					<div id="recetas_por_alimento">
						<?php carga('recetas_por_alimento', null
								, array('id_alimento' => $alimento->id_alimento)); ?>
					</div>
				</div>
				<div class="a_la_derecha" style="width: 40%;">
					<strong>Informaci&oacute;n nutricional</strong>
					<br />
					<span style="color: gray;">Por 100g de producto:</span>
					<?php include PATH_VIEW . 'includes/info_nutricional.php'; ?>
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