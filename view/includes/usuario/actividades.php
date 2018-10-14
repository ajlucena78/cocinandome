<?php if ($actividades) { ?>
	<?php foreach ($actividades as $actividad) { ?>
		<div id="actividad_<?php echo $actividad->id_actividad(); ?>" style="padding: 4px;">
			<?php include PATH_VIEW . 'includes/usuario/actividad.php'; ?>
		</div>
	<?php } ?>
	<?php if ($verMas) { ?>
		<div id="ver_mas_actividades">
			<?php olink('actividades_usuario', 'actividades', array('p' => ($pagina + 1), 'id_u=' => $id_u)
					, false, null, 'removeElement("ver_mas_actividades")', true); ?>Ver m&aacute;s<?php 
					clink(); ?>
		</div>
	<?php } ?>
<?php }elseif ($id_u === null) { ?>
	<div>
		Todav&iacute;a no tenemos nada que contarte de tus contactos.
		<br />
		Si lo deseas puedes <!-- buscar en <a href="<?php 
				vlink('login_gmail'); ?>">tus contactos de Gmail</a> o -->buscarlos por su nombre con nuestro 
				<a href="<?php vlink('buscar_amigos'); ?>">buscador</a>.
	</div>
<?php }else{ ?>
	<div>
		<?php echo formato_html($usuario->nombre); ?> a&uacute;n no ha hecho nada que podemos contar :) 
	</div>
<?php } ?>