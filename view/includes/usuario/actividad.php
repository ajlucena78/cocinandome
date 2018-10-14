<?php require_once APP_ROOT . 'clases/util/Fecha.php'; ?>
<div class="a_la_izquierda" style="width: 8%;">
	<?php if ($actividad->usuario->foto) { ?>
		<?php olink('perfil_usuario', null, array('id_usuario' => $actividad->usuario->id_usuario)); ?>
			<img src="<?php echo URL_APP; ?>res/img/usuario/mini/<?php echo $actividad->usuario->foto; ?>.jpg" 
					alt="<?php echo formato_html($actividad->usuario->nombre); ?>" style="width: 100%;" />
		<?php clink(); ?>
	<?php }else{ ?>
		<?php olink('perfil_usuario', null, array('id_usuario' => $actividad->usuario->id_usuario)); ?>
			<img src="<?php echo URL_APP; ?>res/img/usuario/mini/sin_foto.jpg" 
					alt="<?php echo formato_html($actividad->usuario->nombre); ?>" style="width: 100%;" />
		<?php clink(); ?>
	<?php } ?>
</div>
<div class="a_la_derecha" style="width: 91%;">
	<?php if ($actividad->tipo == 1) {	//contacto ?>
		<?php olink('perfil_usuario', null, array('id_usuario' => $actividad->usuario->id_usuario)); ?><?php 
				echo formato_html($actividad->usuario->nombre); ?><?php 
				clink(); ?> es ahora contacto de <?php olink('perfil_usuario', null
				, array('id_usuario' => $actividad->amigo->id_usuario)); ?><?php 
				echo formato_html($actividad->amigo->nombre); ?><?php clink(); ?>
	<?php }elseif ($actividad->tipo == 2) { ?>
		<?php olink('perfil_usuario', null, array('id_usuario' => $actividad->usuario->id_usuario)); ?><?php 
				echo formato_html($actividad->usuario->nombre); ?><?php clink(); ?> ha a&ntilde;adido la 
				receta <?php olink('receta', null, array('id_receta' => $actividad->plato->id_plato)); ?><?php 
				echo formato_html($actividad->plato->nombre_plato); ?><?php clink(); ?>
	<?php }elseif ($actividad->tipo == 3) { ?>
		<?php olink('perfil_usuario', null, array('id_usuario' => $actividad->usuario->id_usuario)); ?><?php 
				echo formato_html($actividad->usuario->nombre); ?><?php clink(); ?> ha comentado la 
				receta <?php olink('receta', null, array('id_receta' => $actividad->plato->id_plato), false
				, null, null, false, 'comentarios'); ?><?php 
				echo formato_html($actividad->plato->nombre_plato); ?><?php clink(); ?>
	<?php }elseif ($actividad->tipo == 4) { ?>
		<img src="<?php echo URL_APP; ?>res/img/web/me-mola.jpg" alt="Me mola" style="vertical-align: middle;" />
		a <?php olink('perfil_usuario', null, array('id_usuario' => $actividad->usuario->id_usuario)); ?><?php 
				echo formato_html($actividad->usuario->nombre); ?><?php clink(); ?> le mola la 
				receta <?php olink('receta', null, array('id_receta' => $actividad->plato->id_plato)); ?><?php 
				echo formato_html($actividad->plato->nombre_plato); ?><?php clink(); ?>
	<?php }elseif ($actividad->tipo == 5) { ?>
		<?php olink('perfil_usuario', null, array('id_usuario' => $actividad->usuario->id_usuario)); ?><?php 
				echo formato_html($actividad->usuario->nombre); ?><?php clink(); ?> ha publicado 
				su <a href="<?php vlink('plan_semanal'
						, array('id_usuario' => $actividad->usuario->id_usuario)); ?>">plan semanal</a>
	<?php } ?>
	<br />
	<span style="color: #999;"><?php echo Fecha::convierte_BBDD_a_web($actividad->fecha); ?></span>
</div>
<div class="separador"></div>