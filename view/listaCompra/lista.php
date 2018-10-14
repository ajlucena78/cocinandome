<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php $TITULO_PAGINA = 'Mi lista de la compra'; ?>
 		<?php include PATH_VIEW . 'includes/head.php'; ?>
 		<script type="text/javascript" src="<?php echo URL_APP; ?>view/js/lista_compra.js"></script>
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
				<h1>Mi lista de la compra</h1>
				<div style="padding-right: 1%;">
					<form action="<?php vlink('lista_compra_usuario'); ?>" 
							onsubmit="buscar_lista_compra(); return false;" id="buscador_lista_compra">
						<div class="a_la_izquierda" style="width: 50%;">
							<input type="text" id="consulta_lista_compra" value="" 
									onkeyup="buscar_lista_compra();" onfocus="this.value = '';" 
									class="texto_buscador" style="width: 30%;" />
							<select id="clases_alimentos_lista_compra" name="id_clase_alimento" 
									onchange="filtrar_lista_compra();">
								<option class="gris" value="">Elegir clase...</option>
								<?php foreach ($clasesAlimentos as $clase) { ?>
									<option value="<?php echo $clase->id_clase_alimento; ?>"><?php 
											echo formato_html($clase->nombre_clase_alimento); ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="a_la_derecha" style="width: 50%; text-align: right;">
							<?php olink('lista_compra_usuario', 'alimentos-lista-compra', array('v' => 'todos')
									, false, null, 'limpia_buscador_lista_compra();', false, null, 'boton'); 
									?>Mostrar todos<?php clink(); ?>
							<a href="#" class="boton" style="color: black;"
									onclick="popup_clases_alimentos('guardar_alimento_lista_compra'
									, 'alimentos-lista-compra', 'quitar_popup()');">A&ntilde;adir alimentos</a>
						</div>
						<div class="separador"></div>
					</form>
					<script type="text/javascript">
						document.getElementById('consulta_lista_compra').focus();
					</script>
				</div>
				<div id="alimentos-lista-compra" style="width: 100%;">
					<?php carga('lista_compra_usuario', 'alimentos-lista-compra'); ?>
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