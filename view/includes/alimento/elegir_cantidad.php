<?php require_once APP_ROOT . 'clases/util/Numero.php'; ?>
<h2>Elija la cantidad o pulse en <i>Guardar</i> si no desea indicarla</h2>
<hr />
<div>
	<form id="form_elegir_cantidad_alimento" action="<?php vlink($action, array('r' => $redir)); ?>" 
			method="post" onsubmit="envia_form(this.id, '<?php 
			echo $destino; ?>', '<?php if (isset($funcion) and $funcion) { echo $funcion; } 
			else {echo 'quitar_popup();';} ?>'); return false;">
		<?php if (isset($_GET['dia'])) { ?>
			<input type="hidden" name="dia" value="<?php echo $_GET['dia']; ?>" />
		<?php } ?>
		<?php if (isset($_GET['comida'])) { ?>
			<input type="hidden" name="comida" value="<?php echo $_GET['comida']; ?>" />
		<?php } ?>
		<div class="a_la_izquierda" style="width: 30%;">
			<?php if ($art->alimento->foto_alimento and file_exists(APP_ROOT 
							. 'res/img/alimento/' . $art->alimento->foto_alimento)) { ?>
				<img src="<?php echo URL_APP; ?>res/img/alimento/<?php echo $art->alimento->foto_alimento; ?>" 
						alt="<?php echo formato_html($art->alimento->nombre_alimento); ?>" style="width: 100%;" />
			<?php }else{ ?>
				<img src="<?php echo URL_APP; ?>res/img/alimento/sin_foto.jpg" 
						alt="<?php echo formato_html($art->alimento->nombre_alimento); ?>" style="width: 100%;" />
			<?php } ?>
		</div>
		<div class="a_la_derecha" style="width: 70%;">
			<div>
				<strong><?php echo formato_html($art->alimento->nombre_alimento); ?></strong>
			</div>
			<div style="color: #999;">
				<?php echo Numero::convierte_BBDD_a_web($art->alimento->calorias); 
					?> Kcalor&iacute;as por 100 gr
			</div>
			<div>&nbsp;</div>
			<div>
				Cantidad: <input name="cantidad" value="<?php if ($art->cantidad) echo $art->cantidad; 
						?>" id="cantidad" onkeyup="carga_calorias_alimento();" maxlength="6" type="text" 
						style="width: 80px;" />
				<input type="radio" name="tipo_cantidad" id="tipo_cantidad_gr" value="0" <?php 
						if ($art->tipo_cantidad == 0) { ?>checked="checked"<?php } ?> 
						onclick="carga_calorias_alimento();" /> gramo/s
				<?php if ($art->alimento->peso_unidad) { ?>
						<input type="radio" name="tipo_cantidad" id="tipo_cantidad_unidades" value="1" <?php 
						if ($art->tipo_cantidad == 1) { ?>checked="checked"<?php } ?> 
						onclick="carga_calorias_alimento();" /> unidad/es
				<?php } ?>: 
				<input id="calorias" value="" style="width: 80px;" disabled="disabled" type="text" /> Kcal
				<input name="id_alimento" value="<?php echo $art->alimento->id_alimento; ?>" type="hidden" />
				<input id="calorias_gr" value="<?php echo $art->alimento->calorias; ?>" type="hidden" />
				<input id="peso_unidad" value="<?php echo $art->alimento->peso_unidad; ?>" type="hidden" />
			</div>
			<div class="separador">&nbsp;</div>
			<div>
				<?php include PATH_VIEW . 'includes/teclado_num.php'; ?>
			</div>
		</div>
		<div class="separador">&nbsp;</div>
		<div style="padding-top: 5%;">
			<input type="submit" value="Guardar" class="boton" style="width: 20%;" /> 
			<input type="button" value="Cancelar" class="boton eliminar" onclick="quitar_popup();" />
		</div>
	</form>
	<script type="text/javascript">
		document.getElementById('cantidad').focus();
		carga_calorias_alimento();
	</script>
</div>