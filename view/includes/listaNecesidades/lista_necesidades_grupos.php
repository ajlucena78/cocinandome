<?php require_once APP_ROOT . 'clases/util/Numero.php'; ?>
<?php foreach ($clasesAlimentos as $clase) { ?>
	<div>
		<h2 onclick="mostrar_ocultar('alimentos_lista_necesidades_grupo_<?php 
				echo $clase->id_clase_alimento; ?>');" style="cursor: pointer; text-align: center;" 
				title="Clic para mostrar u ocultar">
			<?php echo formato_html($clase->nombre_clase_alimento); ?>
		</h2>
		<hr />
		<div id="alimentos_lista_necesidades_grupo_<?php echo $clase->id_clase_alimento; ?>">
			<?php foreach($clase->alimentos as $art) { ?>
				<div id="lista_necesidades_<?php echo $art->alimento->id_alimento; ?>">
					<?php include PATH_VIEW . 'includes/listaNecesidades/alimento_lista_necesidades.php'; ?>
				</div>
			<?php } ?>
		</div>
		<hr />
	</div>
<?php } ?>