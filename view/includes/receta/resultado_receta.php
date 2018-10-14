<?php require_once APP_ROOT . 'clases/util/Numero.php'; ?>
<div id="receta_<?php echo $plato->id_plato; ?>" class="fila">
	<div class="a_la_izquierda" style="width: 14%;">
		<a href="<?php vlink('receta', array('id_receta' => $plato->id_plato)); ?>">
			<img src="<?php echo URL_APP; ?>res/img/plato/<?php echo $plato->foto; ?>.jpg" 
					alt="<?php echo formato_html($plato->nombre_plato); ?>" style="width: 100%;" />
		</a>
	</div>
	<div class="a_la_derecha" style="width: 85%;">
		<div class="a_la_izquierda" style="width: 65%;">
			<div>
				<a href="<?php vlink('receta', array('id_receta' => $plato->id_plato)); ?>">
					<strong><?php echo formato_html($plato->nombre_plato); ?></strong>
				</a>
			</div>
			<div>
				<?php if ($plato->usuario and !$plato->usuario->yo_mismo()) { ?>
					<div class="a_la_izquierda" style="width: 50%;">
						<?php $amigo = $plato->usuario; ?>
						<?php include PATH_VIEW . 'includes/usuario/amigo.php'; ?>
					</div>
				<?php } ?>
				<div class="a_la_izquierda" style="width: 50%;">
					<?php if ($plato->puedo_hacerlo()) { ?>
						<div>
							<span style="color: #999;">Puedes hacer esta receta</span>
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
				<div class="separador"></div>
			</div>
		</div>
		<div class="a_la_derecha" style="width: 35%; text-align: right;">
			<div style="padding-bottom: 2px;">
				<a href="javascript:popup_elegir_dia_plan(null, '<?php echo $plato->id_plato; 
						?>');" class="boton" title="A&ntilde;adir a mi plan semanal" 
						style="width: 70px;">+ Plan</a>
			</div>
			<?php if (!$plato->es_plato_favorito()) { ?>
				<div id="add_favoritos_<?php echo $plato->id_plato; ?>" style="padding-bottom: 2px;"
						title="A&ntilde;adir a mis recetas favoritas">
					<?php olink('add_plato_favoritos', 'add_favoritos_' . $plato->id_plato
							, array('id_plato' => $plato->id_plato), true, null, null, false, null, 'boton'
							, 'width: 70px;'); ?>+ Favoritas<?php clink(); ?>
				</div>
			<?php }else{ ?>
				<div id="receta_favoritos_<?php echo $plato->id_plato; ?>" style="padding-bottom: 2px;"
						title="Quitar de mis recetas favoritas">
					<?php olink('quit_plato_favoritos', 'receta_favoritos_' . $plato->id_plato
							, array('id_plato' => $plato->id_plato), true, null, null, false, null
							, 'boton eliminar', 'width: 70px;'); ?>- Favoritas<?php clink(); ?>
				</div>
			<?php } ?>
			<?php if ($plato->usuario and $plato->usuario->yo_mismo()) { ?>
				<div>
					<a href="<?php vlink('editar_receta_form', array('id_receta' => $plato->id_plato)); 
							?>" class="boton" style="width: 70px;">Modificar</a>
				</div>
			<?php } ?>
		</div>
		<div class="separador"></div>
	</div>
	<div class="separador"></div>
</div>