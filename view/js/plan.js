function actualiza_info_nutricional_plan()
{
	carga(URL_BASE + '?action=info_nutricional_plan', 'info_nutricional_plan');
}

function popup_elegir_dia_plan(id_alimento = null, id_receta = null, tipo = null, donde = null)
{
	var url = URL_BASE + '?action=elegir_dia_plan';
	if (id_alimento)
		url += '&id_alimento=' + id_alimento;
	if (id_receta)
		url += '&id_receta=' + id_receta;
	if (tipo)
		url += '&tipo=' + tipo;
	if (donde)
		url += '&donde=' + donde;
	ver_popup(700, 560, url, 'setFocoBuscador');
}

function popup_elegir_comida_plan(dia_plan)
{
	if (!dia_plan)
		return false;
	ver_popup(700, 560, URL_BASE + '?action=elegir_comida_plan&dia=' + dia_plan, 'setFocoBuscador');
}

function ver_plan(dia, comida)
{
	var capa_dia = document.getElementById('dia_' + dia);
	if (!capa_dia)
		return false;
	capa_dia.style.display = 'block';
	var capa_comida = document.getElementById('comida_' + dia + '_' + comida);
	if (!capa_comida)
		return false;
	capa_comida.style.display = 'block';
	var capa = document.getElementById('no_hay_planes');
	if (!capa)
		return false;
	capa.style.display = 'none';
	return true;
}

function publicar_plan()
{
	setTimeout("envia_form('form_publico', 'publicidad_plan'" + 
			", 'window.alert(\\'Privacidad del plan modificada\\');');", 100);
}