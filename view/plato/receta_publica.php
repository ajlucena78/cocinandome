<?php require_once APP_ROOT . 'clases/util/Numero.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php $TITULO_PAGINA = $plato->nombre_plato; ?>
 		<?php include PATH_VIEW . 'includes/head.php'; ?>
	</head>
	<body>
		<?php include PATH_VIEW . 'includes/top_publico.php'; ?>
		<h1><?php echo formato_html($plato->nombre_plato); ?></h1>
		<div class="a_la_izquierda" style="width: 69%; padding-right: 1%;">
			<div class="a_la_izquierda">
				<?php if ($plato->usuario) { ?>
					<div>
						Publicada por:
						<div>
							<div>
								<?php if ($plato->usuario->foto) { ?>
									<img src="<?php echo URL_APP; 
											?>res/img/usuario/mini/<?php 
											echo $plato->usuario->foto; ?>.jpg" alt="<?php 
											echo formato_html($plato->usuario->nombre); ?>"
											style="width: 40px;" />
								<?php }else{ ?>
									<img src="<?php echo URL_APP; 
											?>res/img/usuario/mini/sin_foto.jpg" alt="Sin foto (<?php 
											echo formato_html($plato->usuario->nombre); ?>)" 
											style="width: 40px;" />
								<?php } ?>
							</div>
							<div>
								<?php echo formato_html($plato->usuario->nombre); ?>
							</div>
						</div>
					</div>
				<?php } ?>
				<div>
					<strong>Calor&iacute;as:</strong> <?php 
							echo Numero::convierte_BBDD_a_web($plato->calorias()); ?> Kcal
				</div>
				<?php if ($plato->tiempo_preparacion) { ?>
					<div>
						<strong>Tiempo de preparaci&oacute;n:</strong> <?php echo 
								$plato->tiempo_preparacion; ?> minutos
					</div>
				<?php } ?>
				<?php if ($plato->comensales) { ?>
					<div>
						<strong>Comensales:</strong> <?php echo $plato->comensales; ?>
					</div>
				<?php } ?>
				<?php if ($plato->categoria) { ?>
					<div>
						<?php if ($plato->categoria->foto_categoria) { ?>
							<img src="<?php echo URL_APP; 
									?>res/img/categoriaPlato/mini/<?php 
									echo $plato->categoria->foto_categoria; ?>" alt="<?php 
									echo formato_html($plato->categoria->nombre_categoria); 
									?>" title="<?php 
									echo formato_html($plato->categoria->nombre_categoria); 
									?>" style="width: 40px;" />
						<?php }else{ ?>
							<img src="<?php echo URL_APP; 
									?>res/img/categoriaPlato/mini/sin_foto.jpg" alt="<?php 
									echo formato_html($plato->categoria->nombre_categoria); ?>" 
									title="<?php 
									echo formato_html($plato->categoria->nombre_categoria); ?>" 
									style="width: 40px;" />
						<?php } ?>
						<?php echo $plato->categoria->nombre_categoria; ?>
					</div>
				<?php } ?>
				<?php if ($plato->vegetariano) { ?>
					<div>
						<span style="color: green;">Apta para vegetarianos</span>
					</div>
				<?php } ?>
				<?php if ($plato->celiaco) { ?>
					<div>
						<span style="color: green;">Apta para cel&iacute;acos</span>
					</div>
				<?php } ?>
			</div>
			<div class="a_la_derecha" style="padding-right: 10px;">
				<?php if ($plato->foto) { ?>
					<div>
						<img src="<?php echo URL_APP; ?>res/img/plato/<?php 
								echo $plato->foto; ?>.jpg" alt="<?php 
								echo formato_html($plato->nombre_plato); ?>" 
								style="width: 200px;" />
					</div>
				<?php } ?>
				<?php if ($plato->video) { ?>
					<div style="margin-top: 12px;">
						<iframe width="200" height="131" src="<?php echo $plato->video; ?>" 
								frameborder="0"><?php echo $plato->video; ?></iframe>
					</div>
				<?php } ?>
			</div>
			<div class="separador"></div>
			<?php if ($plato->preparacion) { ?>
				<div>
					<h2>Preparaci&oacute;n</h2>
					<?php echo str_replace("\n", "\n<br />\n", formato_html($plato->preparacion)); ?>
				</div>
			<?php } ?>
		</div>
		<div class="a_la_derecha" style="width: 30%;">
			<?php if ($plato->ingredientes) { ?>
				<div id="ingredientes">
					<?php foreach ($plato->ingredientes as $ingrediente) { ?>
						<div>
							<?php include PATH_VIEW . 'includes/receta/ingrediente.php'; ?>
						</div>
					<?php } ?>
				</div>
			<?php } ?>
		</div>
		<div class="separador"></div>
		<div class="a_la_izquierda" style="width: 60%;">
			<h2>Informaci&oacute;n nutricional</h2>
			<?php $alimento = $plato; ?>
			<?php include PATH_VIEW . 'includes/info_nutricional_horizontal.php'; ?>
		</div>
		<div class="a_la_derecha" style="width: 40%;">
			<div id="recetas_por_categoria">
				<?php carga('recetas_publicas_por_categoria', 'recetas_por_categoria'
						, array('id_categoria' => $plato->categoria->id_categoria
						, 'id_plato' => $plato->id_plato)); ?>
			</div>
		</div>
		<div class="separador"></div>
		<?php include PATH_VIEW . 'includes/bottom_publico.php'; ?>
	</body>
</html>