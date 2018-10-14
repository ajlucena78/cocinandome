<?php foreach ($usuarios as $amigo) { ?>
	<div class="a_la_izquierda amigo" style="width: 160pt;">
		<?php include PATH_VIEW . 'includes/usuario/amigo.php'; ?>
		<?php if (!$amigo->yo_mismo() and !$amigo->es_amigo() and !$amigo->invitado() 
				and !$amigo->me_invita()) { ?>
			<div id="invitar_<?php echo $amigo->id_usuario; ?>">
				<img src="<?php echo URL_APP; ?>res/img/web/email_go.png" 
						alt="Enviar invitaci&oacute;n de contacto" 
						style="vertical-align: middle; border: 0;" />
				<?php olink('invitar', 'invitar_' . $amigo->id_usuario
						, array('id_usuario' => $amigo->id_usuario, 'r' => 'perfil'), true); ?>
				Enviar invitaci&oacute;n de contacto<?php clink(); ?>
			</div>
		<?php } elseif ($amigo->es_amigo()) { ?>
			<div title="Eliminar a <?php echo formato_html($amigo->nombre); ?> de mis contactos" 
					style="margin-bottom: 6pt;">
				<?php olink('eliminar_amistad', 'amigo_' . $amigo->id_usuario
						, array('id_usuario' => $amigo->id_usuario), true);?><span 
						class="eliminar">Eliminar de mis contactos</span><?php clink(); ?>
			</div>
		<?php } elseif ($amigo->invitado()) { ?>
			<div class="gris">Invitaci&oacute;n enviada</div>
		<?php } elseif ($amigo->yo_mismo()) { ?>
			<div class="gris">Mira qui&eacute;n es XD</div>
		<?php } elseif ($amigo->me_invita()) { ?>
			<?php olink('perfil_usuario', null, array('id_usuario' => $amigo->id_usuario)); ?>
				<div>Te ha mandado una invitaci&oacute;n</div>
			<?php clink(); ?>
		<?php } ?>
	</div>
<?php } ?>
<?php if ($verMas) { ?>
	<div id="ver_mas_contactos">
		<?php olink('contactos_usuario', 'amigos', array('p' => ($pagina + 1), 'id_u' => $id_u), false, null
				, 'removeElement("ver_mas_contactos")', true); ?>Ver m&aacute;s<?php clink(); ?>
	</div>
<?php } ?>