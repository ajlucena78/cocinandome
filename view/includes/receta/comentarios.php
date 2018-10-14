<?php if ($error) { ?>
	<div class="error">
		<?php echo formato_html($error); ?>
	</div>
<?php }else{ ?>
	<?php foreach ($plato->comentarios as $comentario) { ?>
		<div style="padding-bottom: 1%;">
			<div class="a_la_izquierda" style="width: 35%;">
				<?php $amigo = $comentario->usuario; ?>
				<?php include PATH_VIEW . 'includes/usuario/amigo.php'; ?>
			</div>
			<div class="a_la_derecha" style="width: 64%;">
				<?php echo formato_html($comentario->comentario); ?>
				<br />
				<span style="color: #666;"><?php 
						echo Fecha::convierte_BBDD_a_web($comentario->fecha); ?></span>
			</div>
			<div class="separador"></div>
		</div>
	<?php } ?>
	<?php if ($verMas) { ?>
		<div id="ver_mas_comentarios_plato">
			<?php olink('comentarios_plato', 'lista_comentarios_receta', array('id_receta' => $plato->id_plato
					, 'p' => ($_GET['p'] + 1)), false, null, 'removeElement("ver_mas_comentarios_plato")', true); 
					?>Ver m&aacute;s<?php clink(); ?>
		</div>
	<?php } ?>
<?php } ?>