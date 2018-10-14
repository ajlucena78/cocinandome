var palabra_consulta_alimentos = null;
var no_buscar_alimentos = false;
var tiempo_alimentos = 0;
var dia_plan_elegido = null;
var comida_plan_elegida = null;
var action_alimentos = null;
var destino_alimentos = null;
var funcion_alimentos = null;

setInterval('actualiza_tiempo_buscador_alimentos();', 100);

function actualiza_tiempo_buscador_alimentos()
{
	if (tiempo_alimentos == 7 && palabra_consulta_alimentos)
	{
		carga(URL_BASE + '?action=elegir_alimento&nombre_alimento=' + palabra_consulta_alimentos + '&dia=' 
				+ dia_plan_elegido + '&comida=' + comida_plan_elegida + '&act=' + action_alimentos 
				+ '&destino=' + destino_alimentos + '&function=' + funcion_alimentos
				, 'elegir_alimento', 'check_consulta_alimentos');
		palabra_consulta_alimentos = '';
		tiempo = 0;
	}
	tiempo_alimentos++;
}

function buscar_alimentos(action = null, dia_plan = null, comida_plan = null, destino = null, funcion = null)
{
	if (action)
		action_alimentos = action;
	if (dia_plan)
		dia_plan_elegido = dia_plan;
	if (comida_plan)
		comida_plan_elegida = comida_plan;
	if (destino)
		destino_alimentos = destino;
	if (funcion)
		funcion_alimentos = funcion;
	var consulta = document.getElementById('consulta_alimentos');
	if (!consulta)
		return false;
	consulta = consulta.value;
	if (consulta.length < 3)
		return false;
	if (palabra_consulta_alimentos)
	{
		if (consulta.substr(0, palabra_consulta_alimentos.length) != palabra_consulta_alimentos)
			no_buscar_alimentos = false;
	}
	else
		no_buscar_alimentos = false;
	if (no_buscar_alimentos)
		return false;
	palabra_consulta_alimentos = consulta;
	tiempo_alimentos = 0;
	return true;
}

function check_consulta_alimentos(cargador, param)
{
	if (cargador.responseText == '')
	{
		no_buscar_alimentos = true;
		var alimentos = document.getElementById('alimentos');
		if (alimentos)
			alimentos.innerHTML = 'No se han encontrado resultados';
	}
	return true;
}

function setFocoBuscador()
{
	var consulta = document.getElementById('consulta_despensa');
	if (consulta)
		consulta.focus();
}

function setFocoCantidad()
{
	var cantidad = document.getElementById('cantidad');
	if (cantidad)
		cantidad.focus();
	carga_calorias_alimento();
}

function carga_calorias_alimento()
{
	var calorias_gr = document.getElementById('calorias_gr');
	if (!calorias_gr)
		return false;
	var peso_unidad = document.getElementById('peso_unidad');
	if (!peso_unidad)
		return false;
	var calorias = document.getElementById('calorias');
	if (!calorias)
		return false;
	var cantidad = document.getElementById('cantidad');
	if (!cantidad)
		return false;
	var tipo_cantidad_unidades = document.getElementById('tipo_cantidad_unidades');
	var tipo_cantidad_gr = document.getElementById('tipo_cantidad_gr');
	if (!tipo_cantidad_unidades || !tipo_cantidad_gr)
		return false;
	var res;
	if (tipo_cantidad_gr.checked)
		res = cantidad.value * calorias_gr.value / 100;
	if (tipo_cantidad_unidades.checked)
		res = cantidad.value * peso_unidad.value * calorias_gr.value / 100;
	calorias.value = res.toString().replace('.', ',');
	return true;
}

function popup_clases_alimentos(action, destino = '', funcion = '')
{
	if (!action)
		return false;
	ver_popup(700, 560, URL_BASE + '?action=elegir_clase_alimentos&act=' + action + '&destino=' + destino 
				+ '&function=' + funcion, 'setFocoBuscador');
}

function popup_cantidad_alimento(url)
{
	ver_popup(700, 560, url);
}