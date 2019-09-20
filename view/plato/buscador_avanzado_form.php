<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php $TITULO_PAGINA = 'Buscador avanzado de recetas'; ?>
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
			<h1>B&uacute;squeda avanzada de recetas</h1>
			<?php if ($no_results) { ?>
				<div style="color: red;">
					No se han encontrado recetas con los criterios indicados
				</div>
			<?php } ?>
			<div id="main" class="a_la_izquierda">
				<div style="padding-right: 1%;">
					<form name="buscador_avanzado" action="" method="get" id="buscador_avanzado">
						<input type="hidden" name="action" value="buscador_recetas_avanzado" />
						<div style="padding-bottom: 1%;">
							<div class="a_la_izquierda" style="width: 40%;">
								Contiene el texto
							</div>
							<div class="a_la_derecha" style="width: 60%;">
								<input type="text" name="consulta" id="consulta" value="<?php 
										echo $plato->nombre_plato; ?>" style="width: 97%;" />
							</div>
							<div class="separador"></div>
						</div>
						<div>
							<hr />
							<h2>Intolerancias</h2>
							<div style="width: 30%;" class="a_la_izquierda">
								<input type="checkbox" name="vegetariano" id="vegetariano" value="1" <?php 
										if ($plato->vegetariano) { echo 'checked'; } ?> />
								<label for="vegetariano">Apto para vegetarianos</label>
							</div>
							<div style="width: 30%;" class="a_la_izquierda">
								<input type="checkbox" name="celiaco" id="celiaco" value="1" <?php 
										if ($plato->celiaco) { echo 'checked'; } ?> />
								<label for="celiaco">Apto para cel&iacute;acos</label>
							</div>
							<div class="separador"></div>
						</div>
						<div>
							<hr />
							<h2>Categor&iacute;as</h2>
							<?php foreach ($categorias as $categoria) { ?>
								<div style="width: 33%;" class="a_la_izquierda">
									<input type="checkbox" name="categorias[]" id="categorias_<?php 
											echo $categoria->id_categoria; ?>" 
											value="<?php echo $categoria->id_categoria; ?>" <?php 
											if (isset($categorias_marcadas[$categoria->id_categoria])) { 
												echo 'checked'; } ?> />
									<label for="categorias_<?php echo $categoria->id_categoria; ?>"><?php 
											echo formato_html($categoria->nombre_categoria); ?></label>
								</div>
							<?php } ?>
							<div class="separador"></div>
						</div>
						<div>
							<hr />
							<h2>Tiempo de preparaci&oacute;n</h2>
							<div style="width: 33%;" class="a_la_izquierda">
								<input type="radio" name="tiempo_preparacion" id="tiempo_preparacion_10" 
										value="10" <?php 
										if ($plato->tiempo_preparacion == 10) { echo 'checked'; } ?> />
								<label for="tiempo_preparacion_10">Max. 10 min</label>
							</div>
							<div style="width: 33%;" class="a_la_izquierda">
								<input type="radio" name="tiempo_preparacion" id="tiempo_preparacion_20" 
										value="20" <?php 
										if ($plato->tiempo_preparacion == 20) { echo 'checked'; } ?> />
								<label for="tiempo_preparacion_20">Max. 20 min</label>
							</div>
								<input type="radio" name="tiempo_preparacion" id="tiempo_preparacion_30" 
										value="30" <?php 
										if ($plato->tiempo_preparacion == 30) { echo 'checked'; } ?> />
								<label for="tiempo_preparacion_30">Max. 30 min</label>
							<div style="width: 33%;" class="a_la_izquierda">
								<input type="radio" name="tiempo_preparacion" id="tiempo_preparacion_40" 
										value="40" <?php 
										if ($plato->tiempo_preparacion == 40) { echo 'checked'; } ?> />
								<label for="tiempo_preparacion_40">Max. 40 min</label>
							</div>
							<div style="width: 33%;" class="a_la_izquierda">
								<input type="radio" name="tiempo_preparacion" id="tiempo_preparacion_50" 
										value="50" <?php 
										if ($plato->tiempo_preparacion == 50) { echo 'checked'; } ?> />
								<label for="tiempo_preparacion_50">Max. 50 min</label>
							</div>
							<div style="width: 33%;" class="a_la_izquierda">
								<input type="radio" name="tiempo_preparacion" id="tiempo_preparacion_60" 
										value="60" <?php 
										if ($plato->tiempo_preparacion == 60) { echo 'checked'; } ?> />
								<label for="tiempo_preparacion_60">Max. 60 min</label>
							</div>
							<div class="separador"></div>
						</div>
						<div>
							<hr />
							<h2>Comensales</h2>
							<div style="width: 20%;" class="a_la_izquierda">
								<input type="radio" name="comensales" id="comensales_1" value="1" <?php 
										if ($plato->comensales == 1) { echo 'checked'; } ?> />
								<label for="comensales_1">1</label>
							</div>
							<div style="width: 20%;" class="a_la_izquierda">
								<input type="radio" name="comensales" id="comensales_2" value="2" <?php 
										if ($plato->comensales == 2) { echo 'checked'; } ?> />
								<label for="comensales_2">2</label>
							</div>
							<div style="width: 20%;" class="a_la_izquierda">
								<input type="radio" name="comensales" id="comensales_3" value="3" <?php 
										if ($plato->comensales == 3) { echo 'checked'; } ?> />
								<label for="comensales_3">3</label>
							</div>
							<div style="width: 20%;" class="a_la_izquierda">
								<input type="radio" name="comensales" id="comensales_4" value="4" <?php 
										if ($plato->comensales == 4) { echo 'checked'; } ?> />
								<label for="comensales_4">4</label>
							</div>
							<div style="width: 20%;" class="a_la_izquierda">
								<input type="radio" name="comensales" id="comensales_5" value="5" <?php 
										if ($plato->comensales == 5) { echo 'checked'; } ?> />
								<label for="comensales_5">+4</label>
							</div>
							<div class="separador"></div>
						</div>
						<div>
							<hr />
							<h2>Multimedia</h2>
							<input type="checkbox" name="video" id="video" value="1" <?php 
									if ($plato->video) { echo 'checked'; } ?> />
							<label for="video">S&oacute;lo recetas con v&iacute;deo</label>
						</div>
						<div>
							<hr />
							<h2>Red</h2>
							<div style="width: 30%;" class="a_la_izquierda">
								<input type="radio" name="red" id="recetas_publica" value="publicas" <?php 
										if ($plato->publico) { echo 'checked'; } ?> />
								<label for="recetas_publica">S&oacute;lo recetas p&uacute;blicas</label>
							</div>
							<div style="width: 30%;" class="a_la_izquierda">
								<input type="radio" name="red" id="recetas_amigos" value="amigos" <?php 
										if ($recetas_amigos) { echo 'checked'; } ?> />
								<label for="recetas_amigos">S&oacute;lo recetas de amigos</label>
							</div>
							<div class="separador"></div>
						</div>
						<div>
							<hr />
							<h2>Informaci&oacute;n nutricional</h2>
							<div style="width: 33%;" class="a_la_izquierda">
								<input type="checkbox" name="calorias" id="calorias" value="1" <?php 
										if ($plato->calorias()) { echo 'checked'; } ?> />
								<label for="calorias">Calor&iacute;as</label>
							</div>
							<div style="width: 33%;" class="a_la_izquierda">
								<input type="checkbox" name="proteinas" id="proteinas" value="1" <?php 
										if ($plato->proteinas()) { echo 'checked'; } ?> />
								<label for="proteinas">Proteinas</label>
							</div>
							<div style="width: 33%;" class="a_la_izquierda">
								<input type="checkbox" name="hidratos_carbono" id="hidratos_carbono" 
										value="1" <?php 
										if ($plato->hidratos_carbono()) { echo 'checked'; } ?> />
								<label for="hidratos_carbono">Hidratos de carbono</label>
							</div>
							<div style="width: 33%;" class="a_la_izquierda">
								<input type="checkbox" name="fibra" id="fibra" value="1" <?php 
										if ($plato->fibra()) { echo 'checked'; } ?> />
								<label for="fibra">Fibra</label>
							</div>
							<div style="width: 33%;" class="a_la_izquierda">
								<input type="checkbox" name="lipidos" id="lipidos" value="1" <?php 
										if ($plato->lipidos()) { echo 'checked'; } ?> />
								<label for="lipidos">L&iacute;pidos</label>
							</div>
							<div style="width: 33%;" class="a_la_izquierda">
								<input type="checkbox" name="colesterol" id="colesterol" value="1" <?php 
										if ($plato->colesterol()) { echo 'checked'; } ?> />
								<label for="colesterol">Colesterol</label>
							</div>
							<div style="width: 33%;" class="a_la_izquierda">
								<input type="checkbox" name="agp" id="agp" value="1" <?php 
										if ($plato->agp()) { echo 'checked'; } ?> />
								<label for="agp">AGP (&Aacute;cidos grasos poliinsaturados)</label>
							</div>
							<div style="width: 33%;" class="a_la_izquierda">
								<input type="checkbox" name="ags" id="ags" value="1" <?php 
										if ($plato->ags()) { echo 'checked'; } ?> />
								<label for="ags">AGS (&Aacute;cidos grasos saturados)</label>
							</div>
							<div style="width: 33%;" class="a_la_izquierda">
								<input type="checkbox" name="agm" id="agm" value="1" <?php 
										if ($plato->agm()) { echo 'checked'; } ?> />
								<label for="agm">AGM (&Aacute;cidos grasos monosaturados)</label>
							</div>
							<div style="width: 33%;" class="a_la_izquierda">
								<input type="checkbox" name="vitamina_a" id="vitamina_a" value="1" <?php 
										if ($plato->vitamina_a()) { echo 'checked'; } ?> />
								<label for="vitamina_a">Vitamina A</label>
							</div>
							<div style="width: 33%;" class="a_la_izquierda">
								<input type="checkbox" name="vitamina_b1" id="vitamina_b1" value="1" <?php 
										if ($plato->vitamina_b1()) { echo 'checked'; } ?> />
								<label for="vitamina_b1">Vitamina B1</label>
							</div>
							<div style="width: 33%;" class="a_la_izquierda">
								<input type="checkbox" name="vitamina_b2" id="vitamina_b2" value="1" <?php 
										if ($plato->vitamina_b2()) { echo 'checked'; } ?> />
								<label for="vitamina_b2">Vitamina B2</label>
							</div>
							<div style="width: 33%;" class="a_la_izquierda">
								<input type="checkbox" name="vitamina_b6" id="vitamina_b6" value="1" <?php 
										if ($plato->vitamina_b6()) { echo 'checked'; } ?> />
								<label for="vitamina_b6">Vitamina B6</label>
							</div>
							<div style="width: 33%;" class="a_la_izquierda">
								<input type="checkbox" name="vitamina_b12" id="vitamina_b12" value="1" <?php 
										if ($plato->vitamina_b12()) { echo 'checked'; } ?> />
								<label for="vitamina_b12">Vitamina B12</label>
							</div>
							<div style="width: 33%;" class="a_la_izquierda">
								<input type="checkbox" name="vitamina_c" id="vitamina_c" value="1" <?php 
										if ($plato->vitamina_c()) { echo 'checked'; } ?> />
								<label for="vitamina_c">Vitamina C</label>
							</div>
							<div style="width: 33%;" class="a_la_izquierda">
								<input type="checkbox" name="vitamina_d" id="vitamina_d" value="1" <?php 
										if ($plato->vitamina_d()) { echo 'checked'; } ?> />
								<label for="vitamina_d">Vitamina D</label>
							</div>
							<div style="width: 33%;" class="a_la_izquierda">
								<input type="checkbox" name="hierro" id="hierro" value="1" <?php 
										if ($plato->hierro()) { echo 'checked'; } ?> />
								<label for="hierro">Hierro</label>
							</div>
							<div style="width: 33%;" class="a_la_izquierda">
								<input type="checkbox" name="calcio" id="calcio" value="1" <?php 
										if ($plato->calcio()) { echo 'checked'; } ?> />
								<label for="calcio">Calcio</label>
							</div>
							<div style="width: 33%;" class="a_la_izquierda">
								<input type="checkbox" name="sodio" id="sodio" value="1" <?php 
										if ($plato->sodio()) { echo 'checked'; } ?> />
								<label for="sodio">Sodio</label>
							</div>
							<div style="width: 33%;" class="a_la_izquierda">
								<input type="checkbox" name="acido_folico" id="acido_folico" value="1" <?php 
										if ($plato->acido_folico()) { echo 'checked'; } ?> />
								<label for="acido_folico">&Aacute;cido f&oacute;lico</label>
							</div>
							<div style="width: 33%;" class="a_la_izquierda">
								<input type="checkbox" name="retinol" id="retinol" value="1" <?php 
										if ($plato->retinol()) { echo 'checked'; } ?> />
								<label for="retinol">Retinol</label>
							</div>
							<div style="width: 33%;" class="a_la_izquierda">
								<input type="checkbox" name="yodo" id="yodo" value="1" <?php 
										if ($plato->yodo()) { echo 'checked'; } ?> />
								<label for="yodo">Yodo</label>
							</div>
							<div style="width: 33%;" class="a_la_izquierda">
								<input type="checkbox" name="potasio" id="potasio" value="1" <?php 
										if ($plato->potasio()) { echo 'checked'; } ?> />
								<label for="potasio">Potasio</label>
							</div>
							<div style="width: 33%;" class="a_la_izquierda">
								<input type="checkbox" name="fosforo" id="fosforo" value="1" <?php 
										if ($plato->fosforo()) { echo 'checked'; } ?> />
								<label for="fosforo">F&oacute;sforo</label>
							</div>
							<div class="separador"></div>
						</div>
						<div style="text-align: right;">
							<hr />
							<br />
							<a href="javascript:document.getElementById('buscador_avanzado').submit();" 
									class="boton">Buscar recetas</a>
							<a href="<?php vlink('buscador_avanzado', array('limpiar_form' => 1)); 
									?>" class="boton eliminar">Limpiar criterios</a>
							<br />
							&nbsp;
						</div>
					</form>
				</div>
				<script type="text/javascript">
					document.getElementById('consulta').focus();
				</script>
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