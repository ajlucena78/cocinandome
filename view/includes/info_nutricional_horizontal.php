<?php require_once APP_ROOT . 'clases/util/Numero.php'; ?>
<div <?php if (!$alimento->calorias()) { ?>class="no_info_nutri"<?php } ?> style="float: left; width: 50%;">
	Calor&iacute;as: <?php echo Numero::convierte_BBDD_a_web($alimento->calorias(), 0); 
			?> Kcal
</div>
<div <?php if (!$alimento->proteinas()) { ?>class="no_info_nutri"<?php } ?> style="float: left; width: 50%;">
	Proteinas: <?php echo Numero::convierte_BBDD_a_web($alimento->proteinas()); ?> g
</div>
<div <?php if (!$alimento->hidratos_carbono()) { ?>class="no_info_nutri"<?php } ?> 
		style="float: left; width: 50%;">
	Hidratos de carbono: <?php 
			echo Numero::convierte_BBDD_a_web($alimento->hidratos_carbono()); ?> g
</div>
<div <?php if (!$alimento->fibra()) { ?>class="no_info_nutri"<?php } ?> style="float: left; width: 50%;">
	Fibra: <?php echo Numero::convierte_BBDD_a_web($alimento->fibra()); ?> g
</div>
<div <?php if (!$alimento->lipidos()) { ?>class="no_info_nutri"<?php } ?> style="float: left; width: 50%;">
	L&iacute;pidos: <?php echo Numero::convierte_BBDD_a_web($alimento->lipidos()); ?> g
</div>
<div <?php if (!$alimento->colesterol()) { ?>class="no_info_nutri"<?php } ?> style="float: left; width: 50%;">
	Colesterol: <?php echo Numero::convierte_BBDD_a_web($alimento->colesterol()); ?> mg
</div>
<div <?php if (!$alimento->agp()) { ?>class="no_info_nutri"<?php } ?> style="float: left; width: 50%;">
	AGP (&Aacute;cidos grasos poliinsaturados): <?php 
			echo Numero::convierte_BBDD_a_web($alimento->agp()); ?> g
</div>
<div <?php if (!$alimento->ags()) { ?>class="no_info_nutri"<?php } ?> style="float: left; width: 50%;">
	AGS (&Aacute;cidos grasos saturados): <?php echo Numero::convierte_BBDD_a_web($alimento->ags()); ?> g
</div>
<div <?php if (!$alimento->agm()) { ?>class="no_info_nutri"<?php } ?> style="float: left; width: 50%;">
	AGM (&Aacute;cidos grasos monosaturados): <?php 
			echo Numero::convierte_BBDD_a_web($alimento->agm()); ?> g
</div>
<div <?php if (!$alimento->vitamina_a()) { ?>class="no_info_nutri"<?php } ?> style="float: left; width: 50%;">
	Vitamina A: <?php echo Numero::convierte_BBDD_a_web($alimento->vitamina_a()); ?> &micro;g
</div>
<div <?php if (!$alimento->vitamina_b1()) { ?>class="no_info_nutri"<?php } ?> style="float: left; width: 50%;">
	Vitamina B1: <?php echo Numero::convierte_BBDD_a_web($alimento->vitamina_b1()); ?> mg
</div>
<div <?php if (!$alimento->vitamina_b2()) { ?>class="no_info_nutri"<?php } ?> style="float: left; width: 50%;">
	Vitamina B2: <?php echo Numero::convierte_BBDD_a_web($alimento->vitamina_b2()); ?> mg
</div>
<div <?php if (!$alimento->vitamina_b6()) { ?>class="no_info_nutri"<?php } ?> style="float: left; width: 50%;">
	Vitamina B6: <?php echo Numero::convierte_BBDD_a_web($alimento->vitamina_b6()); ?> mg
</div>
<div <?php if (!$alimento->vitamina_b12()) { ?>class="no_info_nutri"<?php } ?> 
		style="float: left; width: 50%;">
	Vitamina B12: <?php echo Numero::convierte_BBDD_a_web($alimento->vitamina_b12()); ?> &micro;g
</div>
<div <?php if (!$alimento->vitamina_c()) { ?>class="no_info_nutri"<?php } ?> style="float: left; width: 50%;">
	Vitamina C: <?php echo Numero::convierte_BBDD_a_web($alimento->vitamina_c()); ?> mg
</div>
<div <?php if (!$alimento->vitamina_d()) { ?>class="no_info_nutri"<?php } ?> style="float: left; width: 50%;">
	Vitamina D: <?php echo Numero::convierte_BBDD_a_web($alimento->vitamina_d()); ?> &micro;g
</div>
<div <?php if (!$alimento->hierro()) { ?>class="no_info_nutri"<?php } ?> style="float: left; width: 50%;">
	Hierro: <?php echo Numero::convierte_BBDD_a_web($alimento->hierro()); ?> mg
</div>
<div <?php if (!$alimento->calcio()) { ?>class="no_info_nutri"<?php } ?> style="float: left; width: 50%;">
	Calcio: <?php echo Numero::convierte_BBDD_a_web($alimento->calcio()); ?> mg
</div>
<div <?php if (!$alimento->sodio()) { ?>class="no_info_nutri"<?php } ?> style="float: left; width: 50%;">
	Sodio: <?php echo Numero::convierte_BBDD_a_web($alimento->sodio()); ?> mg
</div>
<div <?php if (!$alimento->acido_folico()) { ?>class="no_info_nutri"<?php } ?> 
		style="float: left; width: 50%;">
	&Aacute;cido f&oacute;lico: <?php 
			echo Numero::convierte_BBDD_a_web($alimento->acido_folico()); ?> &micro;g
</div>
<div <?php if (!$alimento->retinol()) { ?>class="no_info_nutri"<?php } ?> style="float: left; width: 50%;">
	Retinol: <?php echo Numero::convierte_BBDD_a_web($alimento->retinol()); ?> &micro;g
</div>
<div <?php if (!$alimento->yodo()) { ?>class="no_info_nutri"<?php } ?> style="float: left; width: 50%;">
	Yodo: <?php echo Numero::convierte_BBDD_a_web($alimento->yodo()); ?> &micro;g
</div>
<div <?php if (!$alimento->potasio()) { ?>class="no_info_nutri"<?php } ?> style="float: left; width: 50%;">
	Potasio: <?php echo Numero::convierte_BBDD_a_web($alimento->potasio()); ?> mg
</div>
<div <?php if (!$alimento->fosforo()) { ?>class="no_info_nutri"<?php } ?> style="float: left; width: 50%;">
	F&oacute;sforo: <?php echo Numero::convierte_BBDD_a_web($alimento->fosforo()); ?> mg
</div>
<div class="separador">&nbsp;</div>