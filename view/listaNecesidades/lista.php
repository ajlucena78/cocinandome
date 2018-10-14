<?php require_once APP_ROOT . 'clases/util/Numero.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php $TITULO_PAGINA = 'Mi lista de necesidades'; ?>
 		<?php include PATH_VIEW . 'includes/head.php'; ?>
 		<script type="text/javascript" src="<?php echo URL_APP; ?>view/js/lista_necesidades.js"></script>
 		<script type="text/javascript" src="<?php echo URL_APP; ?>view/js/alimento.js"></script>
 		<script type="text/javascript" src="<?php echo URL_APP; ?>view/js/teclado.js"></script>
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
				<h1>Mi lista de necesidades</h1>
				<div style="padding-right: 1%;">
					<div style="color: #999; padding-bottom: 1%;">
						Aqu&iacute; tienes la lista de alimentos que necesitas para llevar a cabo tu plan semanal.
						<br />
						Estos alimentos no est&aacute;n ni en tu despensa ni en tu lista de la compra.
					</div>
					<form action="<?php vlink('lista_necesidades_usuario'); ?>" 
							onsubmit="buscar_lista_necesidades(); return false;" id="buscador_lista_necesidades">
						<div class="a_la_izquierda" style="width: 60%;">
							<input type="text" id="consulta_lista_necesidades" value="" style="width: 30%;" 
									onkeyup="buscar_lista_necesidades();" onfocus="this.value = '';"
									class="texto_buscador" />
							<select id="clases_alimentos_lista_necesidades" name="id_clase_alimento" 
									onchange="filtrar_lista_necesidades();">
								<option class="gris" value="">Elegir clase...</option>
								<?php foreach ($clasesAlimentos as $clase) { ?>
									<option value="<?php echo $clase->id_clase_alimento; ?>"><?php 
											echo formato_html($clase->nombre_clase_alimento); ?></option>
								<?php } ?>
							</select>
							<input type="submit" value="Buscar" style="display: none;" />
						</div>
						<div class="a_la_derecha" style="width: 40%; text-align: right;">
							<a href="#" class="boton" 
									onclick="document.getElementById('buscador_lista_necesidades').reset(); buscar_lista_necesidades();">
								Limpiar
							</a>
							<?php olink('lista_necesidades_usuario_grupos', 'lista_necesidades', null, false
									, null, 'limpia_buscador_lista_necesidades();', false, null, 'boton'); 
									?>Mostrar todo<?php clink(); ?>
						</div>
						<div class="separador"></div>
					</form>
					<script type="text/javascript">
						document.getElementById('consulta_lista_necesidades').focus();
					</script>
				</div>
				<div id="lista_necesidades" style="padding-right: 1%; padding-top: 1%; width: 100%;">
					<?php carga('lista_necesidades_usuario_grupos', 'lista_necesidades'); ?>
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