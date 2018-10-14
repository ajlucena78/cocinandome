<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php $TITULO_PAGINA = 'Mis contactos'; ?>
 		<?php include PATH_VIEW . 'includes/head.php'; ?>
	</head>
	<body>
		<div id="top">
			<?php include PATH_VIEW . 'includes/top.php'; ?>
		</div>
		<div id="menu">
			<?php include PATH_VIEW . 'includes/menu.php'; ?>
		</div>
		<div id="contenido">
			<div id="main" class="a_la_izquierda">
				<h1>Mis contactos</h1>
				<div style="color: #999;">
					Aqu&iacute; podr&aacute;s consultar todos tus contactos y eliminarlos de esta lista si ya 
					no est&aacute;s interesado en seguir si&eacute;ndolo de alguno de ellos. 
					Recuerda que tus recetas privadas s&oacute;lo pueden ser consultadas por ellos.
				</div>
				<?php foreach($usuarios as $amigo) { ?>
					<div id="amigo_<?php echo $amigo->id_usuario; ?>" class="a_la_izquierda amigo" 
							style="width: 160pt; padding-top: 6pt;">
						<?php include PATH_VIEW . 'includes/usuario/amigo.php'; ?>
						<div title="Eliminar a <?php echo formato_html($amigo->nombre); ?> de mis contactos">
							<?php olink('eliminar_amistad', 'amigo_' . $amigo->id_usuario
									, array('id_usuario' => $amigo->id_usuario), true);?><span 
									class="eliminar">Eliminar de mis contactos</span><?php clink(); ?>
						</div>
					</div>
				<?php } ?>
			</div>
			<div id="bloque_derecha" class="a_la_derecha">
				<?php include PATH_VIEW . 'includes/bloque_derecha.php'; ?>
			</div>
			<div class="separador"></div>
		</div>
		<div id="pie">
			<?php include PATH_VIEW . 'includes/pie.php'; ?>
		</div>
	</body>
</html>