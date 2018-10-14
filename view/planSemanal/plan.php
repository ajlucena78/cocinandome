<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php $TITULO_PAGINA = 'Plan semanal'; ?>
 		<?php include PATH_VIEW . 'includes/head.php'; ?>
 		<script type="text/javascript" src="<?php echo URL_APP; ?>view/js/alimento.js"></script>
 		<script type="text/javascript" src="<?php echo URL_APP; ?>view/js/teclado.js"></script>
 		<script type="text/javascript" src="<?php echo URL_APP; ?>view/js/plan.js"></script>
 		<script type="text/javascript" src="<?php echo URL_APP; ?>view/js/recetas.js"></script>
	</head>
	<body>
		<div id="top">
			<?php include PATH_VIEW . 'includes/top.php'; ?>
		</div>
		<div id="menu">
			<?php include PATH_VIEW . 'includes/menu.php'; ?>
		</div>
		<div id="contenido">
			<div id="main" class="a_la_izquierda" style="width: 100%;">
				<div>
					<div class="a_la_izquierda" style="width: 65%;">
						<h1>Plan semanal</h1>
						<?php if (!$usuario) { ?>
							<span style="color: #999;">Aqu&iacute; puedes a&ntilde;adir los alimentos y 
									recetas que quieras para cada comida de la semana</span>
						<?php } ?>
					</div>
					<?php if ($usuario) { ?>
						<div class="a_la_derecha" style="width: 50%; text-align: right;">
							<div class="a_la_izquierda" style="width: 29%; text-align: right;">
								<a href="<?php vlink('perfil_usuario'
										, array('id_usuario' => $usuario->id_usuario)); ?>">
									<?php if ($usuario->foto) { ?>
										<img src="<?php echo URL_APP; 
												?>res/img/usuario/mini/<?php echo $usuario->foto; ?>.jpg" 
												alt="<?php echo formato_html($usuario->nombre); ?>"
												style="width: 40%; vertical-align: middle;" />
									<?php }else{ ?>
										<img src="<?php echo URL_APP; 
												?>res/img/usuario/mini/sin_foto.jpg" 
												alt="<?php echo formato_html($usuario->nombre); ?>"
												style="width: 40%;" />
									<?php } ?>
								</a>
							</div>
							<div class="a_la_derecha" style="width: 70%; text-align: left;">
								<span style="color: #999;">Este plan pertenece a</span>
								<br />
								<a href="<?php vlink('perfil_usuario'
										, array('id_usuario' => $usuario->id_usuario)); ?>"><?php 
										echo formato_html($usuario->nombre); ?></a>
							</div>
							<div class="separador" style="padding-bottom: 2%;"></div>
						</div>
					<?php } else { ?>
						<div id="publicidad_plan" class="a_la_derecha" style="width: 35%;">
							<?php carga('publicidad_plan'); ?>
						</div>
					<?php } ?>
					<div class="separador"></div>
					<div>
						<div class="texto_centrado" style="width: 69%;">
							<?php include PATH_VIEW . 'includes/plan/dias_semana.php'; ?>
						</div>
						<div id="plan" class="a_la_izquierda" style="width: 67%;">
							<?php if ($plan->comida) { ?>
								<?php carga('plan_comida', 'plan', array('dia' => $plan->dia
										, 'comida' => $plan->comida)); ?>
							<?php }else{ ?>
								<?php carga('plan_dia', 'plan', array('dia' => $plan->dia)); ?>
							<?php } ?>
						</div>
						<div class="a_la_derecha" style="width: 32%;">
							<div>
								<?php if (!$usuario) { ?>
									<a href="javascript:popup_elegir_dia_plan();" 
											class="boton negro">A&ntilde;adir alimento</a>
									<a href="javascript:popup_elegir_dia_plan(null,null,'receta','plan');" 
											class="boton negro">A&ntilde;adir receta</a>
								<?php } ?>
							</div>
							<h2>Informaci&oacute;n nutricional</h2>
							<div id="info_nutricional_plan">
							</div>
							<script type="text/javascript">
								actualiza_info_nutricional_plan();
							</script>
						</div>
						<div class="separador"></div>
					</div>
				</div>
			</div>
			<?php /* <div id="bloque_derecha" class="a_la_derecha">
				<?php include PATH_VIEW . 'includes/bloque_derecha.php'; ?>
			</div> */ ?>
			<div class="separador"></div>
		</div>
		<?php include PATH_VIEW . 'includes/popup.php'; ?>
		<div id="pie">
			<?php include PATH_VIEW . 'includes/pie.php'; ?>
		</div>
	</body>
</html>