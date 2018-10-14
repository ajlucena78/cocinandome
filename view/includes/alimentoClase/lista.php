<h2>Elija un grupo de alimentos o busque el alimento por su nombre</h2>
<?php foreach($clasesAlimentos as $clase) { ?>
	<div class="a_la_izquierda" style="width: <?php echo $tamColumna; ?>%; padding-bottom: 1%;">
		<?php if (!$clase->clases_hijas) { ?>
			<?php olink('elegir_alimento', 'elegir_alimento'
					, array('id_clase_alimento' => $clase->id_clase_alimento
					, 'destino' => ((isset($_GET['destino'])) ? $_GET['destino'] : '')
					, 'function' => ((isset($_GET['function'])) ? $_GET['function'] : '')
					, 'dia' => ((isset($_GET['dia'])) ? $_GET['dia'] : '')
					, 'comida' => ((isset($_GET['comida'])) ? $_GET['comida'] : ''), 'act' => $_GET['act'])); ?>
		<?php  }else{ ?>
			<?php olink('clases_alimentos', 'elegir_alimento'
					, array('id_clase_alimento' => $clase->id_clase_alimento
					, 'destino' => ((isset($_GET['destino'])) ? $_GET['destino'] : '')
					, 'function' => ((isset($_GET['function'])) ? $_GET['function'] : '')
					, 'dia' => ((isset($_GET['dia'])) ? $_GET['dia'] : '')
					, 'comida' => ((isset($_GET['comida'])) ? $_GET['comida'] : ''), 'act' => $_GET['act'])); ?>
		<?php } ?>
			<img src="<?php echo URL_APP; ?>res/img/alimentoClase/<?php 
					echo $clase->foto_clase_alimento; ?>" alt="<?php 
					echo formato_html($clase->nombre_clase_alimento); ?>" style="width: 85%;" />
			<br />
			<?php echo formato_html($clase->nombre_clase_alimento); ?>
		<?php clink(); ?>
	</div>
<?php } ?>