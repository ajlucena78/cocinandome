<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php $TITULO_PAGINA = $alimento->nombre_alimento; ?>
 		<?php include PATH_VIEW . 'includes/head.php'; ?>
	</head>
	<body>
		<?php include PATH_VIEW . 'includes/top_publico.php'; ?>
		<h1><?php echo formato_html($alimento->nombre_alimento); ?></h1>
		<div id="main">
			<div class="a_la_izquierda" style="width: 65%;">
				<div>
					<?php if ($alimento->foto_alimento and file_exists(APP_ROOT 
							. 'res/img/alimento/' . $alimento->foto_alimento)) { ?>
						<img src="<?php echo URL_APP; ?>res/img/alimento/<?php 
								echo $alimento->foto_alimento; ?>" alt="<?php 
								echo formato_html($alimento->nombre_alimento); ?>" 
								style="width: 200px;" />
					<?php }else{ ?>
						<img src="<?php echo URL_APP; ?>res/img/alimento/sin_foto.jpg" 
								alt="<?php echo formato_html($alimento->nombre_alimento); ?>" 
								style="width: 200px;" />
					<?php } ?>
				</div>
				<div>&nbsp;</div>
				<div id="recetas_por_alimento">
					<?php carga('recetas_publicas_por_alimento', 'recetas_por_alimento'
							, array('id_alimento' => $alimento->id_alimento)); ?>
				</div>
			</div>
			<div class="a_la_derecha" style="width: 35%;">
				<strong>Informaci&oacute;n nutricional</strong>
				<br />
				<span style="color: gray;">Por 100g de producto:</span>
				<?php include PATH_VIEW . 'includes/info_nutricional.php'; ?>
			</div>
		</div>
		<?php include PATH_VIEW . 'includes/bottom_publico.php'; ?>
	</body>
</html>