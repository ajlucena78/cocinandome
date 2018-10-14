<div>
	<?php if (isset($_SESSION['usuario']->despensa[$alimento->id_alimento])) { ?>
		<div class="a_la_izquierda" style="width: 60%;">
			<span style="color: green;">En tu despensa</span>
		</div>
		<div style="width: 40%; text-align: right;" class="a_la_derecha" title="Quitar de la despensa">
			<?php olink('quit_despensa', 'op_alimento_' . $alimento->id_alimento
					, array('id_alimento' => $alimento->id_alimento), false, null, null, false, null
					, 'boton_mini eliminar'); ?>Quitar<?php clink(); ?>
		</div>
		<div class="separador"></div>
		<a href="javascript:popup_cantidad_alimento('<?php vlink('elegir_cantidad_despensa_a_lista_compra'
				, array('id_alimento' => $alimento->id_alimento, 'destino' => 'op_alimento_' 
				. $alimento->id_alimento, 'r' => 'op')); ?>');" 
				title="Pasa este alimento a la lista de compra y lo elimina de tu despensa">Mover a la lista de 
				la compra</a>
	<?php }else{ ?>
		<div class="a_la_izquierda" style="width: 60%;">
			<span style="color: red;">No lo tienes</span>
		</div>
		<div style="width: 40%; text-align: right;" class="a_la_derecha">
			<a href="javascript:popup_cantidad_alimento('<?php vlink('elegir_cantidad_alimento_despensa'
					, array('id_alimento' => $alimento->id_alimento, 'destino' => 'op_alimento_' 
					. $alimento->id_alimento, 'r' => 'op')); ?>');" class="boton_mini"
					title="A&ntilde;adir a la despensa">A&ntilde;adir</a>
		</div>
		<div class="separador" style="padding-bottom: 4%;"></div>
	<?php } ?>
</div>
<div>
	<?php if (isset($_SESSION['usuario']->lista_compra[$alimento->id_alimento])) { ?>
		<div style="width: 60%;" class="a_la_izquierda">
			En tu lista de la compra
		</div>
		<div style="width: 40%; text-align: right;" class="a_la_derecha" title="Quitar de la lista de la compra">
			<?php olink('quit_lista_compra', 'op_alimento_' . $alimento->id_alimento
					, array('id_alimento' => $alimento->id_alimento), false, null, null, false
					, 'boton_mini eliminar'); ?>Quitar<?php clink(); ?>
		</div>
		<div class="separador"></div>
		<a href="javascript:popup_cantidad_alimento('<?php vlink('elegir_cantidad_lista_compra_a_despensa'
				, array('id_alimento' => $alimento->id_alimento, 'destino' => 'op_alimento_' 
				. $alimento->id_alimento, 'r' => 'op')); ?>');" 
				title="Pasa este alimento a la despensa y lo elimina de tu lista de compra">Mover a la 
				despensa</a>
	<?php }else{ ?>
		<div style="width: 60%; color: #999;" class="a_la_izquierda">
			No est&aacute; en tu lista de compra
		</div>
		<div style="width: 40%; text-align: right;" class="a_la_derecha">
			<a href="javascript:popup_cantidad_alimento('<?php vlink('elegir_cantidad_alimento_lista_compra'
					, array('id_alimento' => $alimento->id_alimento, 'destino' => 'op_alimento_' 
					. $alimento->id_alimento, 'r' => 'op')); ?>');" class="boton_mini"
					title="A&ntilde;adir a la lista de la compra">A&ntilde;adir</a>
		</div>
		<div class="separador"></div>
	<?php } ?>
	<div>
		<a href="javascript:popup_elegir_dia_plan(<?php echo $alimento->id_alimento; 
				?>);">A&ntilde;adir a mi plan semanal</a>
	</div>
</div>