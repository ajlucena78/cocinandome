<h2>&iquest;Qu&eacute; comemos hoy?</h2>
<?php if ($queTocaHoy) { ?>
	<?php for ($comida = 1; $comida <= 4; $comida++) { ?>
		<?php if (isset($queTocaHoy[$comida]) and $queTocaHoy[$comida]) { ?>
			<div style="padding-bottom: 1%; float: left; margin-right: 4pt;">
				<div>
					<strong>En tu <a href="<?php vlink('plan_semanal', array('dia' => $plan->dia
							, 'comida' => $comida)); ?>"><?php 
							echo formato_html(lcfirst($plan->nombre_comida($comida))); ?></a>:</strong>
				</div>
				<?php foreach ($queTocaHoy[$comida] as $plan) { ?>
					<div class="a_la_izquierda" style="width: 100pt; margin-right: 4pt; text-align: center;">
						<?php if ($plan->plato) { ?>
							<a href="<?php vlink('receta', array('id_receta' 
									=> $plan->plato->id_plato)); ?>">
								<img src="<?php echo URL_APP; ?>res/img/plato/<?php 
										echo $plan->plato->foto; ?>.jpg" 
										alt="<?php echo formato_html($plan->plato->nombre_plato); ?>" 
										title="<?php echo formato_html($plan->plato->nombre_plato); ?>"
										style="width: 100%;" />
								<br />
								<span class="fuenteMini"><?php 
										echo formato_html($plan->plato->nombre_plato); ?></span>
							</a>
						<?php } ?>
						<?php if ($plan->alimento) { ?>
							<a href="<?php vlink('ficha_alimento', array('id_alimento' 
									=> $plan->alimento->id_alimento)); ?>">
								<?php if ($plan->alimento->foto_alimento 
										and file_exists(APP_ROOT . 'res/img/alimento/' 
										. $plan->alimento->foto_alimento)) { ?>
									<img src="<?php echo URL_APP; 
											?>res/img/alimento/<?php 
											echo $plan->alimento->foto_alimento; ?>" alt="<?php 
											echo formato_html($plan->alimento->nombre_alimento); ?>" 
											title="<?php 
											echo formato_html($plan->alimento->nombre_alimento); ?>" 
											style="width: 100%;" />
								<?php }else{ ?>
									<img src="<?php echo URL_APP; 
											?>res/img/alimento/sin_foto.jpg" alt="<?php 
											echo formato_html($plan->alimento->nombre_alimento); ?>" 
											title="<?php 
											echo formato_html($plan->alimento->nombre_alimento); ?>" 
											style="width: 100%;" />
							<?php } ?>
							<br />
							<span class="fuenteMini"><?php echo 
									formato_html($plan->alimento->nombre_alimento); ?></span>
						</a>
					<?php } ?>
					</div>
				<?php } ?>
			</div>
		<?php } ?>
	<?php } ?>
	<div class="separador"></div>
<?php }else{ ?>
	<div>
		A&uacute;n no tienes nada en tu plan, puedes a&ntilde;adir recetas y otros alimentos 
		haciendo <a href="<?php vlink('plan_semanal', array('dia' => $plan->dia
				, 'comida' => $plan->comida)); ?>">clic en este enlace</a>.
	</div>
<?php } ?>