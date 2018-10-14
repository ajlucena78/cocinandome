<div>
	<form action="#" onsubmit="buscar_alimentos('<?php echo $_GET['act']; ?>', <?php 
			echo ((isset($_GET['dia']) and $_GET['dia']) ? $_GET['dia'] : '0'); ?>, <?php 
			echo ((isset($_GET['comida']) and $_GET['comida']) ? $_GET['comida'] : '0'); ?>, '<?php 
			echo ((isset($_GET['destino']) and $_GET['destino']) ? $_GET['destino'] : ''); ?>', '<?php 
			echo ((isset($_GET['function']) and $_GET['function']) ? $_GET['function'] : ''); 
			?>'); return false;">
		<input type="text" id="consulta_alimentos" value="Buscar por nombre de alimento" 
				onkeyup="buscar_alimentos('<?php echo $_GET['act']; ?>', <?php 
				echo ((isset($_GET['dia']) and $_GET['dia']) ? $_GET['dia'] : '0'); ?>, <?php 
				echo ((isset($_GET['comida']) and $_GET['comida']) ? $_GET['comida'] : '0'); ?>, '<?php 
				echo ((isset($_GET['destino']) and $_GET['destino']) ? $_GET['destino'] : ''); ?>', '<?php 
				echo ((isset($_GET['function']) and $_GET['function']) ? $_GET['function'] : ''); ?>');" 
				onfocus="this.value = ''; this.style.color = '#000';" style="color: #BBB; width: 40%;" />
		<input type="submit" value="Buscar" class="invisible" />
		<?php olink('clases_alimentos', 'elegir_alimento'
				, array('dia' => ((isset($_GET['dia']) and $_GET['dia']) ? $_GET['dia'] : '')
				, 'comida' => ((isset($_GET['comida']) and $_GET['comida']) ? $_GET['comida'] : '')
				, 'destino' => ((isset($_GET['destino']) and $_GET['destino']) ? $_GET['destino'] : '')
				, 'function' => ((isset($_GET['function']) and $_GET['function']) ? $_GET['function'] : '')
				, 'act' => $_GET['act']), false, null, null, false, null, 'boton'); 
				?>Mostrar las clases de alimentos<?php clink(); ?>
	</form>
	<script type="text/javascript">
		document.getElementById('consulta_alimentos').focus();
	</script>
</div>
<div class="separador"></div>
<div id="elegir_alimento">
	<?php include PATH_VIEW . 'includes/alimentoClase/lista.php'; ?>
</div>