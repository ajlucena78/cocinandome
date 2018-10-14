<?php if (count($platos) > 0) { ?>
	<?php foreach ($platos as $plato) { ?>
		<div>
			<div>
				<h2>
					Te presentamos...
					<br />
					<a href="<?php vlink('receta', array('id_receta' => $plato->id_plato)); ?>"><?php 
						echo formato_html($plato->nombre_plato); ?></a>
				</h2>
			</div>
			<div id="receta_<?php echo $plato->id_plato; ?>">
				<a href="<?php vlink('receta', array('id_receta' => $plato->id_plato)); ?>">
					<img src="<?php echo URL_APP; ?>res/img/plato/<?php 
							echo $plato->foto; ?>.jpg" alt="<?php 
							echo formato_html($plato->nombre_plato); ?>" 
							style="width: 100%;" />
				</a>
				<?php if ($plato->usuario) { ?>
					<div>
						<span style="color: #666;">Publicada por</span>
						<?php $amigo = $plato->usuario; ?>
						<?php include PATH_VIEW . 'includes/usuario/amigo.php'; ?>
					</div>
				<?php } ?>
			</div>
			<div class="texto_centrado">
				<a href="<?php vlink('recetas'); ?>">Ver m&aacute;s recetas</a>
			</div>
		</div>
	<?php } ?>
<?php } ?>