<div>
	<label for="nombre_plato">Nombre:</label>
</div>
<div>
	<input name="nombre_plato" id="nombre_plato" type="text" value="<?php echo $plato->nombre_plato; ?>" 
			style="width: 100%;" maxlength="255" />
	<?php if (isset($errores['nombre_plato'])) { ?>
		<span class="error"><?php echo formato_html($errores['nombre_plato']); ?></span>
	<?php } ?>
</div>
<div>
	<label for="preparacion">Preparaci&oacute;n:</label>
</div>
<div>
	<textarea name="preparacion" id="preparacion" style="width: 100%;" rows="12" cols="40"><?php 
			echo $plato->preparacion; ?></textarea>
	<?php if (isset($errores['preparacion'])) { ?>
		<span class="error"><?php echo formato_html($errores['preparacion']); ?></span>
	<?php } ?>
</div>
<div style="width: 100%; height: 30px;">
	<div class="a_la_izquierda" style="width: 30%;">
		<label for="tiempo_preparacion">Tiempo de preparaci&oacute;n:</label>
	</div>
	<div class="a_la_derecha" style="width: 70%;">
		<input name="tiempo_preparacion" id="tiempo_preparacion" type="text" 
				value="<?php echo $plato->tiempo_preparacion; ?>" style="width: 50px;" 
				maxlength="4" /> minutos
		<?php if (isset($errores['tiempo_preparacion'])) { ?>
			<span class="error"><?php echo formato_html($errores['tiempo_preparacion']); ?></span>
		<?php } ?>
	</div>
	<div class="separador"></div>
</div>
<div style="width: 100%; height: 30px;">
	<div class="a_la_izquierda" style="width: 30%;">
		<label for="comensales">Comensales:</label>
	</div>
	<div class="a_la_derecha" style="width: 70%;">
		<input name="comensales" id="comensales" type="text" value="<?php echo $plato->comensales; ?>" 
				style="width: 50px;" maxlength="2" />
		<?php if (isset($errores['comensales'])) { ?>
			<span class="error"><?php echo formato_html($errores['comensales']); ?></span>
		<?php } ?>
	</div>
	<div class="separador"></div>
</div>
<div>
	<label for="foto">Foto:</label>
</div>
<div>
	<?php if ($plato->foto) { ?>
		<?php if (file_exists(APP_ROOT . 'res/img/plato/mini/' . $plato->foto . '.jpg')) { ?>
			<img src="<?php echo URL_APP; ?>res/img/plato/mini/<?php 
					echo $plato->foto; ?>.jpg" alt="<?php echo formato_html($plato->nombre_plato); ?>" 
					style="width: 6%;" />
		<?php }elseif (file_exists(APP_ROOT . 'temp/' . $plato->foto)) { ?>
			<img src="<?php echo URL_APP; ?>temp/<?php echo $plato->foto; ?>" 
					alt="<?php echo formato_html($plato->nombre_plato); ?>" style="width: 6%;" />
		<?php } ?>
	<?php } ?>
	<input type="hidden" name="MAX_FILE_SIZE" value="4000000" />
	<input type="file" name="foto" id="foto" style="width: 70%;" maxlength="255" />
	<span style="color: #666;">M&aacute;ximo 4 Mb</span>
	<?php if (isset($errores['foto'])) { ?>
		<br /><span class="error"><?php echo formato_html($errores['foto']); ?></span>
	<?php } ?>
</div>
<div>
	<label for="video">Enlace del v&iacute;deo:</label>
</div>
<div>
	<input name="video" id="video" type="text" value="<?php echo $plato->video; ?>" style="width: 100%;" 
			maxlength="255" />
	<?php if (isset($errores['video'])) { ?>
		<span class="error"><?php echo formato_html($errores['video']); ?></span>
	<?php } ?>
</div>
<div>
	Categor&iacute;a:
	<?php if (isset($errores['categoria'])) { ?>
		<br /><span class="error"><?php echo formato_html($errores['categoria']); ?></span>
	<?php } ?>
</div>
<div>
	<?php $cont = 0; ?>
	<?php foreach ($categorias as $categoria) { ?>
		<div class="a_la_izquierda" style="width: 33%;">
			<input type="radio" name="id_categoria" id="categoria<?php echo ++$cont; ?>" 
					value="<?php echo $categoria->id_categoria; ?>" <?php 
					if ($plato->categoria->id_categoria == $categoria->id_categoria) { 
					?>checked="checked"<?php } ?> />
			<label for="categoria<?php echo $cont; ?>"><?php 
					echo formato_html($categoria->nombre_categoria); ?></label>
		</div>
	<?php } ?>
	<div class="separador"></div>
</div>
<div>&nbsp;</div>
<div style="text-align: right;">
	<input type="submit" value="Continuar al siguiente paso" class="boton" />
</div>
<div>&nbsp;</div>
<?php //TODO errores en alerta de Javascript ?>