<?php require_once APP_ROOT . 'clases/util/Numero.php'; ?>
<div class="a_la_izquierda" style="width: 30%;">
	<?php /* <a href="javascript:popup_cantidad_alimento('<?php vlink('elegir_cantidad_alimento_lista_compra'
			, array('id_alimento' => $art->alimento->id_alimento, 'r' => 'alimento_lista_compra'
			, 'destino' => 'lista_compra_' . $art->id_lista())); ?>');"> */ ?>
	<a href="<?php vlink('ficha_alimento', array('id_alimento' => $art->alimento->id_alimento)); ?>">
		<?php if ($art->alimento->foto_alimento and file_exists(APP_ROOT 
								. 'res/img/alimento/' . $art->alimento->foto_alimento)) { ?>
			<img src="<?php echo URL_APP; ?>res/img/alimento/mini/<?php 
					echo $art->alimento->foto_alimento; ?>" alt="<?php 
					echo formato_html($art->alimento->nombre_alimento); ?>" style="width: 95%;" />
		<?php }else{ ?>
			<img src="<?php echo URL_APP; ?>res/img/alimento/mini/sin_foto.jpg" 
					alt="<?php echo formato_html($art->alimento->nombre_alimento); ?>" 
					style="width: 95%;" />
		<?php } ?>
	</a>
</div>
<div class="a_la_derecha" style="width: 70%;">
	<?php /*
	<a href="javascript:popup_cantidad_alimento('<?php vlink('elegir_cantidad_alimento_lista_compra'
		, array('id_alimento' => $art->alimento->id_alimento, 'r' => 'alimento_lista_compra'
		, 'destino' => 'lista_compra_' . $art->id_lista())); ?>');">
		<strong><?php echo formato_html($art->alimento->nombre_alimento); ?></strong>
	</a>
	<?php if ($art->cantidad) { ?>
		<span style="color: #666;">
			<?php echo Numero::convierte_BBDD_a_web($art->cantidad); ?>
			<?php if ($art->tipo_cantidad == 1) { ?>
				unidad/es
			<?php }else{ ?>
				gr
			<?php } ?>
		</span>
	<?php } ?>
	<br />
	*/ ?>
	<a href="<?php vlink('ficha_alimento', array('id_alimento' => $art->alimento->id_alimento)); 
			?>"><strong><?php echo formato_html($art->alimento->nombre_alimento); ?></strong></a>
	<br />
	<?php /*
	<a href="javascript:popup_cantidad_alimento('<?php vlink('elegir_cantidad_lista_compra_a_despensa'
			, array('id_alimento' => $art->alimento->id_alimento, 'r' => 'ocultar'
			, 'funcion' => 'removeElement(\\\'lista_compra_' . $art->id_lista() . '\\\')')); 
			?>');">Mover a la despensa</a>
	*/ ?>
	<?php olink('mueve_lista_compra_a_despensa', 'lista_compra_' . $art->id_lista
			, array('id_alimento' => $art->alimento->id_alimento), true); ?>Mover a la despensa<?php 
			clink(); ?>
	<br />
	<?php olink('quit_lista_compra', 'lista_compra_' . $art->id_lista
			, array('id_alimento' => $art->alimento->id_alimento), true, null, null, false
			, null, null, 'color: red;'); ?>Eliminar<?php clink(); ?>
</div>
<div class="separador"></div>