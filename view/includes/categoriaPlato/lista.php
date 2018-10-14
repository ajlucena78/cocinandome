<?php $cont = 0; ?>
<?php foreach ($categorias as $categoria) { ?>
	<div class="a_la_izquierda" style="width: 25%; text-align: center; padding-bottom: 1%;">
		<?php olink('buscar_recetas', 'recetas', array('id_categoria' => $categoria->id_categoria)); ?>
			<?php if ($categoria->foto_categoria) { ?>
				<img src="<?php echo URL_APP; 
						?>res/img/categoriaPlato/<?php echo $categoria->foto_categoria; 
						?>" alt="<?php echo formato_html($categoria->nombre_categoria); 
						?>" title="<?php echo formato_html($categoria->nombre_categoria); 
						?>" style="width: 80%;" />
			<?php }else{ ?>
				<img src="<?php echo URL_APP; ?>res/img/categoriaPlato/sin_foto.jpg" 
						alt="<?php echo formato_html($categoria->nombre_categoria); ?>" 
						title="<?php echo formato_html($categoria->nombre_categoria); ?>" 
						style="width: 80%;" />
			<?php } ?>
			<br />
			<?php echo formato_html($categoria->nombre_categoria); ?>
		<?php clink(); ?>
	</div>
	<?php if (++$cont % 4 == 0) { ?>
		<div class="separador"></div>
	<?php } ?>
<?php } ?>
<div class="separador"></div>