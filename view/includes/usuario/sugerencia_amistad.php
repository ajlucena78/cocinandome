<div id="sugerencia_amistad_<?php echo $amigo->id_usuario; ?>" class="amigo" style="margin-bottom: 4pt;">
	<?php include PATH_VIEW . 'includes/usuario/amigo.php'; ?>
	<div>
		<?php if ($amigo->me_invita()) { ?>
			<div class="a_la_izquierda">
				<?php olink('aceptar_amistad', 'sugerencia_amistad_' . $amigo->id_usuario
						, array('id_usuario' => $amigo->id_usuario), true, null, 'carga_sugerencia_amistad'); 
						?>Aceptar invitaci&oacute;n<?php clink(); ?>&nbsp;
			</div>
			<div class="a_la_derecha">
				<?php olink('rechazar_amistad', 'sugerencia_amistad_' . $amigo->id_usuario
						, array('id_usuario' => $amigo->id_usuario), true, null
						, 'carga_sugerencia_amistad'); ?><span style="color: red;">Rechazar</span><?php 
						clink(); ?>&nbsp; &nbsp;
			</div>
		<?php }else{ ?>
			<div class="a_la_izquierda">
				<img src="<?php echo URL_APP; ?>res/img/web/email_go.png" 
						alt="Enviar invitaci&oacute;n de contacto" style="vertical-align: middle; border: 0;" />
				<?php olink('invitar', 'sugerencia_amistad_' . $amigo->id_usuario
						, array('id_usuario' => $amigo->id_usuario), true, null, 'carga_sugerencia_amistad'); 
						?>Enviar invitaci&oacute;n<?php clink(); ?>
			</div>
			<div class="a_la_derecha">
				<?php olink('quitar_no_amigo', 'sugerencia_amistad_' . $amigo->id_usuario
						, array('id_usuario' => $amigo->id_usuario), true, null
						, 'carga_sugerencia_amistad'); ?><span style="color: red;">Ocultar</span><?php 
						clink(); ?>&nbsp; &nbsp;
			</div>
		<?php } ?>
		<div class="separador"></div>
	</div>
</div>