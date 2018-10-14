<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php $TITULO_PAGINA = 'Invitaciones de contacto'; ?>
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
				<h1>Invitaciones de contacto</h1>
				<?php if (count($invitaciones) == 0) { ?>
					<div>
						No tienes ninguna invitaci&oacute;n recibida.
						<br />
						No te preocupes, tan pronto como tengas alguna te avisaremos.
					</div>
				<?php }else{ ?>
					<div>
						Los siguientes usuarios desean formar parte de tus contactos:
						<br />
						&nbsp;
					</div>
					<?php foreach($invitaciones as $invitacion) { ?>
						<div id="invitacion_amistad_<?php 
								echo $invitacion->usuario_invita->id_usuario; ?>" 
								class="a_la_izquierda amigo" style="width: 29%;">
							<?php $amigo = $invitacion->usuario_invita; ?>
							<?php include PATH_VIEW . 'includes/usuario/amigo.php'; ?>
							<?php if ($invitacion->mensaje) { ?>
								<div>
									<?php echo formato_html($invitacion->mensaje); ?>
								</div>
							<?php } ?>
							<div class="a_la_izquierda">
								<?php olink('aceptar_amistad', 'invitacion_amistad_' 
										. $invitacion->usuario_invita->id_usuario
										, array('id_usuario' => $invitacion->usuario_invita->id_usuario)
										, true); ?>Aceptar invitaci&oacute;n<?php clink(); ?>&nbsp;
							</div>
							<div class="a_la_derecha">
								<?php olink('rechazar_amistad', 'invitacion_amistad_' 
										. $invitacion->usuario_invita->id_usuario
										, array('id_usuario' => $invitacion->usuario_invita->id_usuario)
										, true); ?><span style="color: red;">Rechazar</span><?php clink(); 
										?>&nbsp; &nbsp;
							</div>
							<div class="separador"></div>
						</div>
					<?php } ?>
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