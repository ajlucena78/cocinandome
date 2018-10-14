<h2>Elija una de las siguientes categor&iacute;as o busque la receta por el nombre</h2>
<div>
	<?php foreach ($categorias as $categoria) { ?>
		<div class="a_la_izquierda" style="width: 25%; padding-bottom: 1%;">
			<div>
				<?php olink('elegir_recetas_plan', 'elegir_receta'
						, array('id_categoria' => $categoria->id_categoria, 'dia' => $_GET['dia']
						, 'comida' => $_GET['comida'], 'donde' => $_GET['donde'])); ?>
					<img src="<?php echo URL_APP;
							?>res/img/categoriaPlato/<?php echo $categoria->foto_categoria; 
							?>" alt="<?php echo formato_html($categoria->nombre_categoria); 
							?>" title="<?php echo formato_html($categoria->nombre_categoria); 
							?>" style="width: 70%;" />
					<br />
					<?php echo formato_html($categoria->nombre_categoria); ?>
				<?php clink(); ?>
			</div>
		</div>
	<?php } ?>
	<div class="separador"></div>
</div>