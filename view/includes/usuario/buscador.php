<?php if (!is_array($usuarios) or count($usuarios) == 0) { ?>
	<div>
		No se han encontrado usuarios con el nombre <strong><?php 
				echo formato_html($_GET['consulta']); ?></strong>
	</div>
<?php }else{ ?>
	<?php foreach($usuarios as $amigo) { ?>
		<div id="amigo_<?php echo $amigo->id_usuario; ?>" class="a_la_izquierda amigo" style="width: 150pt; 
				padding-top: 2%;">
			<?php include PATH_VIEW . 'includes/usuario/amigo.php'; ?>
		</div>
	<?php } ?>
	<div class="separador"></div>
	<?php if ($verMas) { ?>
		<div id="ver_mas_usuarios">
			<?php olink('buscar_usuarios', 'buscar_usuarios', array('consulta' => $_GET['consulta']
					, 'p' => ($_GET['p'] + 1)), false, null, 'removeElement("ver_mas_usuarios")', true); 
					?>Mostrar m&aacute;s usuarios<?php clink(); ?>
		</div>
	<?php } ?>
<?php } ?>