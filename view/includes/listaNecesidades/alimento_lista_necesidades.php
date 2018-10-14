<div id="lista_necesidades_<?php echo $art->alimento->id_alimento; ?>" class="fila">
	<div class="a_la_izquierda" style="width: 7%;">
		<a href="<?php vlink('ficha_alimento', array('id_alimento' => $art->alimento->id_alimento)); ?>">
			<?php if ($art->alimento->foto_alimento and file_exists(APP_ROOT 
								. 'res/img/alimento/' . $art->alimento->foto_alimento)) { ?>
				<img src="<?php echo URL_APP; ?>res/img/alimento/mini/<?php 
						echo $art->alimento->foto_alimento; ?>" alt="<?php 
						echo formato_html($art->alimento->nombre_alimento); ?>"
						style="width: 100%;" />
			<?php }else{ ?>
				<img src="<?php echo URL_APP; 
						?>res/img/alimento/mini/sin_foto.jpg" alt="<?php 
						echo formato_html($art->alimento->nombre_alimento); ?>" 
						style="width: 100%;" />
			<?php } ?>
		</a>
	</div>
	<div class="a_la_derecha" style="width: 92%;">
		<div class="a_la_izquierda" style="width: 55%;">
			<a href="<?php vlink('ficha_alimento', array('id_alimento' => $art->alimento->id_alimento)); ?>">
				<strong><?php echo formato_html($art->alimento->nombre_alimento); ?></strong>
			</a>
			<?php if ($art->plato) { ?>
				<div style="color: #999;">
					Lo necesitas para hacer la receta de <a href="<?php vlink('receta'
							, array('id_receta' => $art->plato->id_plato)); ?>"><?php 
							echo formato_html(lcfirst($art->plato->nombre_plato)); ?>
						<?php /* if ($art->plato->foto) { ?>
							<img src="<?php echo URL_APP; 
									?>res/img/plato/mini/<?php echo $art->plato->foto; 
									?>.jpg" alt="<?php 
									echo formato_html($art->plato->nombre_plato); ?>" 
									style="width: 20px;" />
						<?php } */ ?>
					</a>
				</div>
			<?php } ?>
		</div>
		<div class="a_la_derecha" style="width: 45%; text-align: right;">
			<div id="op_alimento_<?php echo $art->alimento->id_alimento; ?>">
				<a href="javascript:popup_cantidad_alimento('<?php vlink('elegir_cantidad_alimento_despensa'
						, array('id_alimento' => $art->alimento->id_alimento, 'r' => 'ocultar'
						, 'funcion' => 'removeElement(\\\'lista_necesidades_' 
						. $art->alimento->id_alimento . '\\\')', 'destino' => '')); 
						?>');" class="boton">+ despensa</a>
				<a href="javascript:popup_cantidad_alimento('<?php vlink('elegir_cantidad_alimento_lista_compra'
						, array('id_alimento' => $art->alimento->id_alimento, 'r' => 'ocultar'
						, 'funcion' => 'removeElement(\\\'lista_necesidades_' 
						. $art->alimento->id_alimento . '\\\')', 'destino' => '')); ?>');" 
						class="boton">+ lista de la compra</a>
			</div>
		</div>
		<div class="separador"></div>
	</div>
	<div class="separador"></div>
</div>