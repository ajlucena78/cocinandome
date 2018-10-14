<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php $TITULO_PAGINA = $usuario->nombre; ?>
 		<?php include PATH_VIEW . 'includes/head.php'; ?>
 		<script type="text/javascript" src="<?php echo URL_APP; ?>view/js/usuario.js"></script>
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
				<div class="a_la_izquierda">
					<h1><?php echo formato_html($usuario->nombre); ?></h1>
				</div>
				<div class="a_la_derecha" style="padding-right: 1%;">
					<?php if ($usuario->yo_mismo()) { ?>
						<a href="<?php vlink('editar_perfil'); ?>" class="boton">Editar mi perfil</a> 
						<a href="javascript:dar_baja();" class="boton eliminar">Darme de baja</a>
					<?php }elseif ($usuario->plan_publico == 2 
							or ($usuario->plan_publico == 1 and $usuario->es_amigo())) { ?>
						<a href="<?php vlink('plan_semanal'
								, array('id_usuario' => $usuario->id_usuario)); ?>" 
								class="boton">Consultar su plan semanal</a>
					<?php } ?>
				</div>
				<div class="separador"></div>
				<div class="a_la_izquierda" style="width: 30%;">
					<div>
						<?php if ($usuario->foto) { ?>
							<img src="<?php echo URL_APP; ?>res/img/usuario/<?php 
									echo $usuario->foto; ?>.jpg" alt="<?php 
									echo formato_html($usuario->nombre); ?>"
									style="width: 100%;" />
						<?php }else{ ?>
							<img src="<?php echo URL_APP; 
									?>res/img/usuario/sin_foto.jpg" alt="<?php 
									echo formato_html($usuario->nombre); ?>" style="width: 100%;" />
						<?php } ?>
					</div>
				</div>
				<div class="a_la_derecha" style="width: 68%;">
					<div id="relaciones_usuario_<?php echo $usuario->id_usuario; ?>">
						<?php if (!$usuario->yo_mismo() and !$usuario->es_amigo() and !$usuario->invitado() 
								and !$usuario->me_invita()) { ?>
							<div id="invitar_<?php echo $usuario->id_usuario; ?>">
								<img src="<?php echo URL_APP; ?>res/img/web/email_go.png" 
										alt="Enviar invitaci&oacute;n de contacto" 
										style="vertical-align: middle; border: 0;" />
								<?php olink('invitar', 'relaciones_usuario_' . $usuario->id_usuario
										, array('id_usuario' => $usuario->id_usuario), true); 
										?>Enviar invitaci&oacute;n de contacto<?php clink(); ?>
							</div>
						<?php } ?>
						<?php if ($usuario->invitado()) { ?>
							<div>
								Petici&oacute;n de contacto enviada
							</div>
						<?php } ?>
						<?php if ($usuario->me_invita()) { ?>
							<div>
								<?php olink('aceptar_amistad', null, array('id_usuario' => $usuario->id_usuario
										, 'r' => 'perfil')); ?>Aceptar invitaci&oacute;n de contacto<?php 
										clink(); ?>
							</div>
							<div>
								<?php olink('rechazar_amistad', 'relaciones_usuario_' . $usuario->id_usuario
										, array('id_usuario' => $usuario->id_usuario), true); 
										?><span style="color: red;">Rechazar la invitaci&oacute;n</span><?php 
										clink(); ?>
							</div>
						<?php } ?>
					</div>
					<?php if ($usuario->es_amigo()) { ?>
						<?php if ($usuario->platos()) { ?>
							<h2>Algunas recetas publicadas por este usuario...</h2>
							<div id="recetas">
								<?php carga('recetas_usuario', 'recetas'
										, array('id_u' => $usuario->id_usuario)); ?>
							</div>
						<?php } ?>
					<?php } ?>
				</div>
				<div class="separador"></div>
				<?php if ($usuario->amigos) { ?>
					<h2>Contactos</h2>
					<div id="amigos" style="width: 100%;">
						<?php carga('contactos_usuario', 'amigos', array('id_u' => $usuario->id_usuario)); ?>
					</div>
					<div class="separador"></div>
				<?php } ?>
				<?php if ($usuario->es_amigo()) { ?>
					<h2>Actividades</h2>
					<div id="actividades" style="width: 100%;">
						<?php carga('actividades_usuario', 'actividades'
								, array('id_u' => $usuario->id_usuario)); ?>
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