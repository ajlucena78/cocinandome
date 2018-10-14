<?php require_once APP_ROOT . 'clases/util/Numero.php'; ?>
<h2>&iquest;Guardar la receta en el plan?</h2>
<hr />
<div>
	<form id="form_elegir_receta" action="<?php vlink('guardar_receta_plan', array('r' => $redir)); ?>" 
			method="post" onsubmit="envia_form(this.id, '<?php 
			echo $destino; ?>', '<?php if (isset($funcion) and $funcion) { echo $funcion; } 
			else { echo 'quitar_popup();'; } ?>'); return false;">
		<input type="hidden" name="dia" value="<?php echo $_GET['dia']; ?>" />
		<input type="hidden" name="comida" value="<?php echo $_GET['comida']; ?>" />
		<input name="id_receta" value="<?php echo $art->plato->id_plato; ?>" type="hidden" />
		<div class="a_la_izquierda" style="width: 30%;">
			<?php if ($art->plato->foto) { ?>
				<img src="<?php echo URL_APP; ?>res/img/plato/<?php 
						echo $art->plato->foto; ?>.jpg" alt="<?php 
						echo formato_html($art->plato->nombre_plato); ?>" style="width: 200px;" />
			<?php }else{ ?>
				<img src="<?php echo URL_APP; ?>res/img/plato/sin_foto.jpg" 
						alt="<?php echo formato_html($art->plato->nombre_plato); ?>" 
						style="width: 200px;" />
			<?php } ?>
		</div>
		<div class="a_la_derecha" style="width: 70%;">
			<div>
				<strong><?php echo formato_html($art->plato->nombre_plato); ?></strong>
			</div>
			<div style="color: #999;">
				<?php echo Numero::convierte_BBDD_a_web(round($art->plato->calorias())); 
						?> Kcalor&iacute;as por persona
			</div>
			<div style="padding-top: 4%;">
				<input type="submit" value="S&iacute;" class="boton" style="width: 20%;" />
				<input type="button" value="No" onclick="quitar_popup();" class="boton eliminar" />
			</div>
		</div>
	</form>
</div>