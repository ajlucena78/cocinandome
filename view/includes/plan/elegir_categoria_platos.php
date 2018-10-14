<div>
	<form action="#" onsubmit="buscar_recetas('elegir_recetas_plan', 'elegir_receta', '<?php 
			echo $_GET['donde']; ?>', '<?php echo $_GET['dia']; ?>', '<?php echo $_GET['comida']; 
			?>'); return false;"> 
		<input type="text" id="consulta_recetas" value="Buscar por nombre de receta" 
				onkeyup="buscar_recetas('elegir_recetas_plan', 'elegir_receta', '<?php 
				echo $_GET['donde']; ?>', '<?php echo $_GET['dia']; ?>', '<?php echo $_GET['comida']; ?>');" 
				onfocus="this.value = ''; this.style.color = '#000';" style="color: #BBB; width: 40%;" />
		<input type="submit" value="Buscar" class="invisible" />
		<?php olink('categorias_platos_popup', 'elegir_receta', array('dia' => $_GET['dia']
				, 'comida' => $_GET['comida'], 'donde' => $_GET['donde']), false, null, null, false, null
				, 'boton'); ?>Mostrar las categor&iacute;as<?php clink(); ?>
	</form>
</div>
<div id="elegir_receta">
	<?php include PATH_VIEW . 'includes/categoriaPlato/lista_popup.php'; ?>
</div>