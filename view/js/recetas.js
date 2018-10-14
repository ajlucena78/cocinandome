var palabra_consulta_recetas = null;
var no_buscar_recetas = false;
var tiempo = 0;
var action_buscador_recetas = null;
var destino_buscador_recetas = null;
var dia_plan_elegido = null;
var comida_plan_elegida = null;
var donde_buscador_recetas = null;

setInterval('actualiza_tiempo_buscador();', 100);

function actualiza_tiempo_buscador()
{
	if (tiempo == 7 && action_buscador_recetas && palabra_consulta_recetas)
	{
		var action = URL_BASE + '?action=' + action_buscador_recetas + '&nombre_plato=' 
				+ palabra_consulta_recetas;
		if (dia_plan_elegido)
			action += '&dia=' + dia_plan_elegido;
		if (comida_plan_elegida)
			action += '&comida=' + comida_plan_elegida;
		if (donde_buscador_recetas)
			action += '&donde=' + donde_buscador_recetas;
		if (destino_buscador_recetas)
			var destino = destino_buscador_recetas;
		else
			var destino = 'recetas';
		carga(action, destino, 'check_consulta_recetas');
		palabra_consulta_recetas = '';
		tiempo = 0;
	}
	tiempo++;
}

function buscar_recetas(action, destino = null, donde = null, dia_plan = null, comida_plan = null)
{
	action_buscador_recetas = action;
	if (dia_plan)
		dia_plan_elegido = dia_plan;
	if (comida_plan)
		comida_plan_elegida = comida_plan;
	if (destino)
		destino_buscador_recetas = destino;
	if (donde)
		donde_buscador_recetas = donde;
	var consulta = document.getElementById('consulta_recetas');
	if (!consulta)
		return false;
	consulta = consulta.value;
	if (consulta.length < 3)
		return false;
	if (palabra_consulta_recetas)
	{
		if (consulta.substr(0, palabra_consulta_recetas.length) != palabra_consulta_recetas)
			no_buscar_recetas = false;
	}
	else
		no_buscar_recetas = false;
	if (no_buscar_recetas)
		return false;
	palabra_consulta_recetas = consulta;
	tiempo = 0;
	return true;
}

function check_consulta_recetas(cargador, param)
{
	if (cargador.responseText == '')
	{
		no_buscar_recetas = true;
		var recetas = document.getElementById('recetas');
		if (recetas)
			recetas.innerHTML = 'No se han encontrado resultados';
	}
	return true;
}

function carga_categorias_recetas()
{
	carga(URL_BASE + '?action=categorias_recetas', 'recetas');
	return true;
}

function carga_recetas(id)
{
	if (id == null)
		return false;
	carga(URL_BASE + '?action=recetas&id_categoria=' + id, 'ing_lista');
	return true;
}

function reordenar_recetas()
{
	return envia_form('form_buscador_avanzado_recetas', 'recetas');
}

function cambiar_orden()
{
	var tipo_orden = document.getElementById('tipo_orden');
	if (!tipo_orden)
		return false;
	var boton_tipo_orden = document.getElementById('boton_tipo_orden');
	if (!boton_tipo_orden)
		return false;
	if (tipo_orden.value == 'desc')
	{
		boton_tipo_orden.value = "Asc";
		tipo_orden.value = 'asc';
	}
	else
	{
		boton_tipo_orden.value = "Desc";
		tipo_orden.value = 'desc';
	}
	reordenar_recetas();
}

function actualiza_info_nutricional_receta()
{
	carga(URL_BASE + '?action=info_nutricional_receta', 'info_nutricional_receta');
}

function publicar_receta(id)
{
	ver_popup(600, 400, URL_BASE + '?action=publicar_receta&id_receta=' + id);
}

function despublicar_receta(id)
{
	ver_popup(600, 400, URL_BASE + '?action=despublicar_receta&id_receta=' + id);
}