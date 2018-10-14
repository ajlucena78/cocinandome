<?php require_once APP_ROOT . 'clases/util/Numero.php'; ?>
<div style="width: 20%;" class="a_la_izquierda">
	<a href="<?php vlink('ficha_alimento', array('id_alimento' => $ingrediente->alimento->id_alimento)); ?>">
		<?php if ($ingrediente->alimento->foto_alimento and file_exists(APP_ROOT . 'res/img/alimento/' 
				. $ingrediente->alimento->foto_alimento)) { ?>
			<img src="<?php echo URL_APP; ?>res/img/alimento/mini/<?php 
					echo $ingrediente->alimento->foto_alimento; ?>" alt="<?php 
					echo formato_html($ingrediente->alimento->nombre_alimento); ?>" style="width: 100%;" />
		<?php }else{ ?>
			<img src="<?php echo URL_APP; ?>res/img/alimento/mini/sin_foto.jpg" alt="Sin foto" 
					style="width: 100%;" />
		<?php } ?>
	</a>
</div>
<div style="width: 76%; padding-right: 2%;" class="a_la_derecha">
	<a href="<?php vlink('ficha_alimento'
			, array('id_alimento' => $ingrediente->alimento->id_alimento)); ?>"><strong><?php 
			echo formato_html($ingrediente->alimento->nombre_alimento); ?></strong></a>
	<?php if ($ingrediente->cantidad) { ?>
		<br />
		<span style="color: #666;">
			<strong><?php echo Numero::convierte_BBDD_a_web($ingrediente->cantidad, 0); ?> <?php 
					echo ($ingrediente->tipo_cantidad == 1) ? 'unidad/es' : 'gr'; ?>
			</strong> 
			<?php if ($ingrediente->calorias()) { ?>
				 (<?php echo Numero::convierte_BBDD_a_web($ingrediente->calorias(), 0); ?> Kcal)
			<?php } ?>
		</span>
	<?php } ?>
	<?php if (isset($_SESSION['usuario'])) { ?>
		<?php $alimento = $ingrediente->alimento; ?>
		<div id="op_alimento_<?php echo $alimento->id_alimento; ?>">
			<?php include PATH_VIEW . 'includes/alimento/op.php'; ?>
		</div>
	<?php } ?>
</div>
<div class="separador"></div>