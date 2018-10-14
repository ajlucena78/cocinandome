<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php $TITULO_PAGINA = 'Buscador avanzado de recetas'; ?>
 		<?php include PATH_VIEW . 'includes/head.php'; ?>
 		<script type="text/javascript" src="<?php echo URL_APP; ?>view/js/recetas.js"></script>
 		<script type="text/javascript" src="<?php echo URL_APP; ?>view/js/plan.js"></script>
	</head>
	<body>
		<div id="top">
			<?php include PATH_VIEW . 'includes/top.php'; ?>
		</div>
		<div id="menu">
			<?php include PATH_VIEW . 'includes/menu.php'; ?>
		</div>
		<div id="contenido">
			<div id="main" class="a_la_izquierda">
				<h1>Buscador avanzado de recetas</h1>
				<div style="padding-right: 1%;">
					<form action="<?php vlink('buscar_recetas_avanzado'); ?>" method="post" 
							id="form_buscador_avanzado_recetas">
						<div class="a_la_izquierda" style="width: 30%;">
							<a href="<?php vlink('buscador_avanzado'); ?>" 
									class="boton">Cambiar la b&uacute;squeda</a>
						</div>
						<div class="a_la_derecha" style="width: 70%; text-align: right;">
							Ordenadas por 
							<select name="orden" onchange="reordenar_recetas();">
								<option value="" class="gris">Fecha</option>
								<option value="nombre_plato">Nombre de la receta</option>
								<option value="tiempo_preparacion">Tiempo de preparaci&oacute;n</option>
								<option value="comensales">Comensales</option>
								<option value="calorias">Calor&iacute;as</option>
								<option value="proteinas">Proteinas</option>
								<option value="hidratos_carbono">Hidratos de carbono</option>
								<option value="fibra">Fibra</option>
								<option value="lipidos">L&iacute;pidos</option>
								<option value="colesterol">Colesterol</option>
								<option value="agp">AGP (&Aacute;cidos grasos poliinsaturados)</option>
								<option value="ags">AGS (&Aacute;cidos grasos saturados)</option>
								<option value="agm">AGM (&Aacute;cidos grasos monosaturados)</option>
								<option value="vitamina_a">Vitamina A</option>
								<option value="vitamina_b1">Vitamina B1</option>
								<option value="vitamina_b2">Vitamina B2</option>
								<option value="vitamina_b6">Vitamina B6</option>
								<option value="vitamina_b12">Vitamina  B12</option>
								<option value="vitamina_c">Vitamina C</option>
								<option value="vitamina_d">Vitamina D</option>
								<option value="hierro">Hierro</option>
								<option value="calcio">Calcio</option>
								<option value="sodio">Sodio</option>
								<option value="acido_folico">&Aacute;cido f&oacute;lico</option>
								<option value="retinol">Retinol</option>
								<option value="yodo">Yodo</option>
								<option value="potasio">Potasio</option>
								<option value="fosforo">F&oacute;sforo</option>
							</select>
							<input type="button" value="Desc" onclick="cambiar_orden();" id="boton_tipo_orden" 
									class="boton" />
							<input type="hidden" name="tipo_orden" id="tipo_orden" value="desc" />
							<input type="submit" value="Buscar" style="display: none;" />
						</div>
						<div class="separador"></div>
					</form>
				</div>
				<div class="separador"></div>
				<div id="recetas" style="margin-top: 2%;">
					<?php carga('buscar_recetas_avanzado', 'recetas'); ?>
				</div>
			</div>
			<div id="bloque_derecha" class="a_la_derecha">
				<?php include PATH_VIEW . 'includes/bloque_derecha.php'; ?>
			</div>
			<div class="separador"></div>
		</div>
		<?php include PATH_VIEW . 'includes/popup.php'; ?>
		<div id="pie">
			<?php include PATH_VIEW . 'includes/pie.php'; ?>
		</div>
	</body>
</html>