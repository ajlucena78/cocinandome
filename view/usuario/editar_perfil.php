<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php $TITULO_PAGINA = 'Editar mi perfil'; ?>
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
				<h1>Editar perfil</h1>
				<div style="padding-right: 1%;">
					<?php if ($error) { ?>
						<div><?php echo formato_html($error); ?></div>
					<?php } ?>
					<div class="a_la_izquierda" style="width: 25%;">
						<?php if ($usuario->foto) { ?>
							<img src="<?php echo URL_APP; ?>res/img/usuario/<?php 
									echo $usuario->foto; ?>.jpg?r=<?php echo rand(0, 100000); ?>" alt="<?php 
									echo formato_html($usuario->nombre); ?>" style="width: 100%;" 
									title="Tu foto actual" />
						<?php }else{ ?>
							<img src="<?php echo URL_APP; ?>res/img/usuario/sin_foto.jpg" 
									alt="<?php echo formato_html($usuario->nombre); ?>"
									style="width: 100%;" />
						<?php } ?>
					</div>
					<div class="a_la_derecha" style="width: 73%;">
						<form action="<?php vlink('subir_foto_usuario'); ?>" method="post" 
								enctype="multipart/form-data">
							<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
							Cambiar mi foto de perfil:
							<br />
							<span style="color: #999;">Recuerda que la imagen debe estar en formato JPG y no  
							ser mayor en tama&ntilde;o a 2 megas</span>
							<br />
							<input type="file" name="foto" class="boton" />
							<input type="submit" value="Subir imagen" class="boton" />
						</form>
					</div>
					<div class="separador"></div>
				</div>
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