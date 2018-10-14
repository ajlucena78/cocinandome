<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php $TITULO_PAGINA = 'Mi despensa'; ?>
 		<?php include PATH_VIEW . 'includes/head.php'; ?>
 		<script type="text/javascript" src="<?php echo URL_APP; ?>view/js/despensa.js"></script>
 		<script type="text/javascript" src="<?php echo URL_APP; ?>view/js/alimento.js"></script>
 		<script type="text/javascript" src="<?php echo URL_APP; ?>view/js/teclado.js"></script>
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
				<h1>Mi despensa</h1>
				<div style="padding-right: 1%;">
					<form action="<?php vlink('despensa_usuario'); ?>" onsubmit="buscar_despensa(); return false;"
							id="buscador_despensa">
						<div class="a_la_izquierda" style="width: 50%;">
							<input type="text" id="consulta_despensa" value="" onkeyup="buscar_despensa();"
									onfocus="this.value = '';" style="width: 30%;" class="texto_buscador" />
							<select id="clases_alimentos_despensa" name="id_clase_alimento" 
									onchange="filtrar_despensa();">
								<option class="gris" value="">Elegir clase...</option>
								<?php foreach ($clasesAlimentos as $clase) { ?>
									<option value="<?php echo $clase->id_clase_alimento; ?>"><?php 
											echo formato_html($clase->nombre_clase_alimento); ?></option>
								<?php } ?>
							</select>
							<input type="submit" value="Buscar" style="display: none;" />
						</div>
						<div class="a_la_derecha" style="width: 50%; text-align: right;">
							<?php olink('despensa_usuario', 'alimentos-despensa', array('v' => 'todos'), false
									, null, 'limpia_buscador_despensa();', false, null, 'boton'); 
									?>Mostrar todos<?php clink(); ?>
							<a href="#" class="boton" style="color: black;"
									onclick="popup_clases_alimentos('guardar_alimento_despensa'
									, 'alimentos-despensa', 'quitar_popup()');">A&ntilde;adir alimentos</a>
						</div>
						<div class="separador"></div>
					</form>
					<script type="text/javascript">
						document.getElementById('consulta_despensa').focus();
					</script>
				</div>
				<div id="alimentos-despensa" style="padding-right: 1%; width: 100%;">
					<?php carga('despensa_usuario', 'alimentos-despensa'); ?>
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