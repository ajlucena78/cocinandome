<div>
	<div class="a_la_izquierda" style="width: 35%;">
		<?php olink('perfil_usuario', null, array('id_usuario' => $amigo->id_usuario)); ?>
			<?php if ($amigo->foto) { ?>
				<img src="<?php echo URL_APP; ?>res/img/usuario/mini/<?php echo $amigo->foto; ?>.jpg" 
						alt="<?php echo formato_html($amigo->nombre); ?>" style="width: 100%;" />
			<?php }else{ ?>
				<img src="<?php echo URL_APP; ?>res/img/usuario/mini/sin_foto.jpg" 
						alt="Sin foto (<?php echo formato_html($amigo->nombre); ?>)" 
						style="width: 100%;" />
			<?php } ?>
		<?php clink(); ?>
	</div>
	<div class="a_la_derecha" style="width: 63%;">
		<?php olink('perfil_usuario', null, array('id_usuario' => $amigo->id_usuario)); ?>
			<?php echo formato_html($amigo->nombre); ?>
		<?php clink(); ?>
	</div>
	<div class="separador"></div>
</div>