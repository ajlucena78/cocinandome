<?php if (count($alimentos) > 0) { ?>
	<h2>Elija un alimento</h2>
	<div style="margin-top: 2pt; margin-bottom: 6pt;">
		Mostrando <?php echo count($alimentos); ?> de <?php echo $total; ?> alimentos encontrados
	</div>
	<div class="separador"></div>
	<div id="alimentos" style="margin: 0 auto;">
		<?php foreach($alimentos as $alimento) { ?>
			<div id="alimento_<?php echo $alimento->id_alimento; ?>" class="a_la_izquierda" 
					style="width: 18%; height: 130pt; padding: 1%;">
				<?php if (isset($_GET['destino']) and $_GET['destino']) { ?>
					<?php olink($_GET['act'], $_GET['destino'], array('id_alimento' => $alimento->id_alimento)
						, false, null, (isset($_GET['function']) ? $_GET['function'] : null)); ?>
				<?php }else{ ?>
					<?php olink($_GET['act'], 'elegir_alimento', array('id_alimento' => $alimento->id_alimento
							, 'dia' => ((isset($_GET['dia'])) ? $_GET['dia'] : '')
							, 'comida' => ((isset($_GET['comida'])) ? $_GET['comida'] : '')), false, null
							, 'setFocoCantidad();'); ?>
				<?php } ?>
					<?php if ($alimento->foto_alimento and file_exists(APP_ROOT . 'res/img/alimento/' 
							. $alimento->foto_alimento)) { ?>
						<img src="<?php echo URL_APP; ?>res/img/alimento/<?php 
								echo $alimento->foto_alimento; ?>" alt="<?php 
								echo formato_html($alimento->nombre_alimento); ?>" style="width: 100%;" />
					<?php }else{ ?>
						<img src="<?php echo URL_APP; ?>res/img/alimento/sin_foto.jpg" 
								alt="<?php echo formato_html($alimento->nombre_alimento); ?>" 
								style="width: 100%;" />
					<?php } ?>
					<br />
					<span class="fuenteMini" style="width: 100%; text-align: center;"><?php 
							echo formato_html($alimento->nombre_alimento); ?></span>
				<?php clink(); ?>
			</div>
		<?php } ?>
	</div>
	<div class="separador"></div>
	<?php if (count($alimentos) < $total) { ?>
		<?php
			$paginas = ceil($total / ALIMENTOS_POPUP);
			$pag = isset($_GET['pag']) ? $_GET['pag'] : 1;
		?>
		<div class="a_la_derecha" style="width: 30%;">
			<?php if ($pag == $paginas) { ?>
				<img src="<?php echo URL_APP; ?>res/img/web/siguiente-null.png" alt="P&aacute;gina siguiente" 
						style="width: 30%;" />
			<?php }else{ ?>
				<?php olink('elegir_alimento', 'elegir_alimento', array('pag' => $pag + 1, 'act' => $_GET['act']
						, 'id_clase_alimento' => isset($_GET['id_clase_alimento']) ? $_GET['id_clase_alimento'] 
						: null, 'dia' => ((isset($_GET['dia'])) ? $_GET['dia'] : '')
						, 'destino' => ((isset($_GET['destino'])) ? $_GET['destino'] : '')
						, 'function' => ((isset($_GET['function'])) ? $_GET['function'] : '')
						, 'comida' => ((isset($_GET['comida'])) ? $_GET['comida'] : '')))?>
					<img src="<?php echo URL_APP; ?>res/img/web/siguiente.png" alt="P&aacute;gina siguiente" 
							style="width: 30%;" title="P&aacute;gina siguiente" />
				<?php clink(); ?>
			<?php } ?>
		</div>
		<div class="a_la_derecha" style="width: 40%; padding-top: 20pt;">
			P&aacute;gina <strong><?php echo $pag; ?></strong> de <strong><?php echo $paginas; ?></strong>
		</div>
		<div class="a_la_derecha" style="width: 30%;">
			<?php if ($pag == 1) { ?>
				<img src="<?php echo URL_APP; ?>res/img/web/anterior-null.png" alt="P&aacute;gina anterior" 
						style="width: 30%;" />
			<?php }else{ ?>
				<?php olink('elegir_alimento', 'elegir_alimento', array('pag' => $pag - 1, 'act' => $_GET['act']
						, 'id_clase_alimento' => isset($_GET['id_clase_alimento']) ? $_GET['id_clase_alimento'] 
						: null, 'dia' => ((isset($_GET['dia'])) ? $_GET['dia'] : '')
						, 'destino' => ((isset($_GET['destino'])) ? $_GET['destino'] : '')
						, 'function' => ((isset($_GET['function'])) ? $_GET['function'] : '')
						, 'comida' => ((isset($_GET['comida'])) ? $_GET['comida'] : '')))?>
					<img src="<?php echo URL_APP; ?>res/img/web/anterior.png" alt="P&aacute;gina anterior" 
							style="width: 30%;" title="P&aacute;gina anterior" />
				<?php clink(); ?>
			<?php } ?>
		</div>
	<?php } ?>
<?php }else{ ?>
	<div>
		No se han encontrado resultados :|
	</div>
<?php } ?>