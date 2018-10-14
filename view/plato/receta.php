<?php require_once APP_ROOT . 'clases/util/Numero.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php $TITULO_PAGINA = $plato->nombre_plato; ?>
 		<?php include PATH_VIEW . 'includes/head.php'; ?>
 		<script type="text/javascript" src="<?php echo URL_APP; ?>view/js/alimento.js"></script>
 		<script type="text/javascript" src="<?php echo URL_APP; ?>view/js/teclado.js"></script>
 		<script type="text/javascript" src="<?php echo URL_APP; ?>view/js/plan.js"></script>
 		<script type="text/javascript" src="<?php echo URL_APP; ?>view/js/recetas.js"></script>
 		<script type="text/javascript">
 			var comentariosPulsado = false;
 		</script>
	</head>
	<body>
		<div id="top">
			<?php include PATH_VIEW . 'includes/top.php'; ?>
		</div>
		<div id="menu">
			<?php include PATH_VIEW . 'includes/menu.php'; ?>
		</div>
		<div id="contenido">
			<div class="a_la_izquierda" style="width: 100%;">
				<div class="a_la_izquierda" style="width: 50%;">
					<h1><?php echo formato_html(strtoupper($plato->nombre_plato)); ?></h1>
				</div>
				<div class="a_la_derecha" style="width: 50%; text-align: right;">
					<a href="#comentarios"><?php 
							echo count($plato->comentarios); ?> comentarios</a>
					 | 
					<a href="#ingredientes">Ingredientes</a>
					 | 
					<a href="#info_nutricional">Informaci&oacute;n nutricional</a>
				</div>
				<div class="separador"></div>
				<hr />
				<div class="a_la_izquierda" style="width: 20%;">
					<img src="<?php echo URL_APP; ?>res/img/plato/<?php 
							echo $plato->foto; ?>.jpg" alt="<?php 
							echo formato_html($plato->nombre_plato); ?>" style="width: 100%;" />
					<?php if ($plato->video) { ?>
						<div style="margin-top: 1%;">
							<iframe width="100%" src="<?php echo $plato->video; ?>" frameborder="0"><?php 
									echo $plato->video; ?></iframe>
						</div>
					<?php } ?>
				</div>
				<div class="a_la_derecha" style="width: 79%;">
					<div class="a_la_izquierda" style="width: 58%;">
						<?php if ($plato->puedo_hacerlo()) { ?>
							<div style="color: green;">
								Puedes hacer esta receta con los alimentos de tu despensa
							</div>
						<?php } ?>
						<?php if ($plato->vegetariano or $plato->celiaco) { ?>
							<div>
								<?php if ($plato->vegetariano) { ?>
									<span style="color: #999;">Apta para vegetarianos</span>
								<?php } ?>
								<?php if ($plato->vegetariano or $plato->celiaco) { ?>
								 | 
								<?php } ?>
								<?php if ($plato->celiaco) { ?>
									<span style="color: #999;">Apta para cel&iacute;acos</span>
								<?php } ?>
							</div>
						<?php } ?>
						<div>
							<strong>Calor&iacute;as:</strong> <?php 
									echo Numero::convierte_BBDD_a_web($plato->calorias()); ?> Kcal
						</div>
						<?php if ($plato->tiempo_preparacion) { ?>
							<div>
								<strong>Tiempo de preparaci&oacute;n:</strong> <?php echo 
										$plato->tiempo_preparacion; ?> minutos
							</div>
						<?php } ?>
						<?php if ($plato->comensales) { ?>
							<div>
								<strong>Comensales:</strong> <?php echo $plato->comensales; ?>
							</div>
						<?php } ?>
						<div>
							<?php if ($plato->usuario) { ?>
								<div class="a_la_izquierda" style="width: 50%;">
									<span style="color: #999;">Publicada por:</span>
									<?php $amigo = $plato->usuario; ?>
									<?php include PATH_VIEW 
											. 'includes/usuario/amigo.php'; ?>
								</div>
							<?php } ?>
							<?php if ($plato->categoria) { ?>
								<div class="a_la_derecha" style="width: 48%;">
									<span style="color: #999;">Categor&iacute;a:</span>
									<div>
										<div class="a_la_izquierda" style="width: 25%;">
											<a href="<?php vlink('recetas', array('id_categoria' 
													=> $plato->categoria->id_categoria)); ?>">
												<?php if ($plato->categoria->foto_categoria) { ?>
													<img src="<?php echo URL_APP; 
															?>res/img/categoriaPlato/mini/<?php echo $plato->categoria->foto_categoria; 
															?>" alt="<?php echo formato_html($plato->categoria->nombre_categoria); 
															?>" title="<?php echo formato_html($plato->categoria->nombre_categoria); 
															?>" style="width: 100%;" />
												<?php }else{ ?>
													<img src="<?php echo URL_APP; 
															?>res/img/categoriaPlato/mini/sin_foto.jpg" alt="<?php 
															echo formato_html($plato->categoria->nombre_categoria); ?>" 
															title="<?php echo formato_html($plato->categoria->nombre_categoria); ?>" 
															style="width: 100%;" />
												<?php } ?>
											</a>
										</div>
										<div class="a_la_derecha" style="width: 70%;">
											<a href="<?php vlink('recetas', array('id_categoria' 
													=> $plato->categoria->id_categoria)); ?>">
												<?php echo $plato->categoria->nombre_categoria; ?>
											</a>
										</div>
										<div class="separador"></div>
									</div>
								</div>
							<?php } ?>
							<div class="separador"></div>
						</div>
					</div>
					<div class="a_la_derecha" style="width: 42%; text-align: right;">
						<?php if ($plato->usuario and $plato->usuario->yo_mismo()) { ?>
							<div>
								<span style="color: #999;">
									<?php if (!$plato->publico) { ?>
										(<a href="javascript:publicar_receta('<?php echo $plato->id_plato; 
												?>');">Publicar mi receta</a>)
									<?php }elseif ($plato->publico == 2){ ?>
										La receta est&aacute; pendiente de publicaci&oacute;n (<a 
												href="javascript:despublicar_receta('<?php 
												echo $plato->id_plato; 
												?>');">Cancelar publicaci&oacute;n</a>)
									<?php }else{ ?>
										La receta est&aacute; publicada (<a 
												href="javascript:despublicar_receta('<?php 
												echo $plato->id_plato; 
												?>');">Cancelar publicaci&oacute;n</a>)
									<?php } ?>
								</span>
							</div>
						<?php } ?>
						<div>
							<br />
							<a class="boton" style="width: 100px;" 
									href="javascript:popup_elegir_dia_plan(null, '<?php 
									echo $plato->id_plato; ?>');">A&ntilde;adir a mi plan</a>
							<?php if (!$plato->es_plato_favorito()) { ?>
								<div id="add_favoritos_<?php echo $plato->id_plato; ?>">
									<?php olink('add_plato_favoritos', 'add_favoritos_' . $plato->id_plato, 
											array('id_plato' => $plato->id_plato), true, null, null, false, null
											, 'boton', 'width: 100px;'); ?>A&ntilde;adir a favoritas<?php 
											clink(); ?>
								</div>
							<?php }else{ ?>
								<div id="receta_favoritos_<?php echo $plato->id_plato; ?>">
									En tus recetas favoritas (<?php olink('quit_plato_favoritos',
											'receta_favoritos_' . $plato->id_plato
											, array('id_plato' => $plato->id_plato
											, true, null, null, false, null, 'boton eliminar', 'width: 100px;'));
											?>Quitar<?php clink(); ?>)
								</div>
							<?php } ?>
							<?php if ($plato->usuario and $plato->usuario->yo_mismo()) { ?>
								<a class="boton" style="width: 100px;" href="<?php vlink('editar_receta_form'
										, array('id_receta' => $plato->id_plato)); ?>">Editar la receta</a>
							<?php } ?>
						</div>
					</div>
					<div class="separador"></div>
				</div>
				<div class="separador"></div>
				<div>
					<div class="a_la_izquierda" style="width: 60%; padding-top: 1%;">
						<div id="me-mola-receta">
							<?php carga('me-mola-receta', null, array('id_receta' => $plato->id_plato)); ?>
						</div>
						<?php if ($plato->preparacion) { ?>
							
								<h2 style="padding-top: 2%;">Preparaci&oacute;n</h2>
								<?php echo str_replace("\n", "\n<br />\n"
										, formato_html($plato->preparacion)); ?>
						<?php } ?>
					</div>
					<div id="recetas_por_categoria" class="a_la_derecha" style="width: 38%;">
						<?php carga('recetas_por_categoria', null
								, array('id_categoria' => $plato->categoria->id_categoria
								, 'id_plato' => $plato->id_plato)); ?>
					</div>
					<div class="separador"></div>
				</div>
				<div class="separador"></div>
				<?php if ($plato->ingredientes) { ?>
					<a name="ingredientes"></a>
					<h2 style="padding-top: 2%;">Ingredientes</h2>
					<div id="ingredientes">
						<?php $cont = 0; ?>
						<?php foreach ($plato->ingredientes as $ingrediente) { ?>
							<div id="ingrediente_<?php echo $ingrediente->id_ingrediente; ?>"
									style="width: 33%; margin-bottom: 1%;" class="a_la_izquierda">
								<?php include PATH_VIEW . 'includes/receta/ingrediente.php'; ?>
							</div>
							<?php if (++$cont % 3 == 0) { ?>
								<div class="separador"></div>
							<?php } ?>
						<?php } ?>
						<div class="separador"></div>
					</div>
				<?php } ?>
				<div>
					<a name="info_nutricional"></a>
					<h2 style="padding-top: 2%;">Informaci&oacute;n nutricional</h2>
					<?php $alimento = $plato; ?>
					<?php include PATH_VIEW . 'includes/info_nutricional_horizontal.php'; ?>
				</div>
				<div id="comentarios_receta" style="width: 70%;">
					<h2>Comentarios (<?php echo count($plato->comentarios); ?>)</h2>
					<div>
						<form action="<?php vlink('nuevo_comentario_plato'); ?>" method="post" 
								id="form_nuevo_comentario" 
								onsubmit="envia_form(this.id, 'lista_comentarios_receta'); return false;">
							<div>
								<div class="a_la_izquierda" style="width: 9%;">
									<?php if ($_SESSION['usuario']->foto) { ?>
										<img src="<?php echo URL_APP; ?>res/img/usuario/mini/<?php 
												echo $_SESSION['usuario']->foto; ?>.jpg?r=<?php echo rand(0, 100000); ?>" 
												alt="<?php echo formato_html($_SESSION['usuario']->nombre); ?>"
												style="width: 100%;" />
									<?php }else{ ?>
										<img src="<?php echo URL_APP; ?>res/img/usuario/mini/sin_foto.jpg" 
												alt="Sin foto (<?php echo formato_html($_SESSION['usuario']->nombre); ?>)" 
												style="width: 100%;" />
									<?php } ?>
								</div>
								<div class="a_la_derecha" style="width: 90%; text-align: right;">
									<textarea name="comentario" rows="2" style="width: 98%; color: #666;"
											onclick="if (!comentariosPulsado) {this.value = ''; comentariosPulsado = true;} this.style.color = 'black';"
											cols="40">Escribe aqu&iacute; tu comentario sobre la receta</textarea>
								</div>
								<div class="separador"></div>
							</div>
							<div style="text-align: right; padding-top: 1%;">
								<input type="hidden" name="id_plato" value="<?php 
										echo $plato->id_plato; ?>" />
								<input type="submit" value="Enviar comentario" class="boton" />
							</div>
						</form>
						<hr />
					</div>
					<a name="comentarios"></a>
					<div id="lista_comentarios_receta">
						<?php carga('comentarios_plato', 'lista_comentarios_receta'
								, array('id_receta' => $plato->id_plato)); ?>
					</div>
				</div>
				<div class="separador">&nbsp;</div>
			</div>
		</div>
		<?php include PATH_VIEW . 'includes/popup.php'; ?>
		<div id="pie">
			<?php include PATH_VIEW . 'includes/pie.php'; ?>
		</div>
	</body>
</html>