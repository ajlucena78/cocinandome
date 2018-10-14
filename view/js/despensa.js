var palabra_consulta_despensa = null;
var no_buscar_despensa = false;
var tiempo_despensa = 0;

setInterval('actualiza_tiempo_buscador_despensa();', 100);

function actualiza_tiempo_buscador_despensa()
{
	if (tiempo_despensa == 7 && palabra_consulta_despensa)
	{
		var clase = document.getElementById('clases_alimentos_despensa');
		if (!clase)
			return false;
		carga(URL_BASE + '?action=despensa_usuario&nombre_alimento=' + palabra_consulta_despensa 
					+ '&id_clase_alimento=' + clase.value, 'alimentos-despensa', 'check_consulta_despensa');
		palabra_consulta_despensa = '';
		tiempo_despensa = 0;
	}
	tiempo_despensa++;
}

function filtrar_despensa()
{
	var consulta = document.getElementById('consulta_despensa');
	if (!consulta)
		return false;
	var clase = document.getElementById('clases_alimentos_despensa');
	if (!clase)
		return false;
	carga(URL_BASE + '?action=despensa_usuario&nombre_alimento=' + consulta.value + '&id_clase_alimento=' 
			+ clase.value, 'alimentos-despensa', 'check_consulta_despensa');
}

function buscar_despensa()
{
	var consulta = document.getElementById('consulta_despensa');
	if (!consulta)
		return false;
	consulta = consulta.value;
	if (consulta.length < 3)
		return false;
	if (palabra_consulta_despensa)
	{
		if (consulta.substr(0, palabra_consulta_despensa.length) != palabra_consulta_despensa)
			no_buscar_despensa = false;
	}
	else
		no_buscar_despensa = false;
	if (no_buscar_despensa)
		return false;
	palabra_consulta_despensa = consulta;
	tiempo_despensa = 0;
	return true;
}

function limpia_buscador_despensa()
{
	carga(URL_BASE + '?action=despensa_usuario&v=todos', 'alimentos-despensa');
	var form = document.getElementById('buscador_despensa');
	if (!form)
		return false;
	form.reset();
	return true;
}

function check_consulta_despensa(cargador)
{
	if (cargador.responseText == '')
	{
		no_buscar_despensa = true;
		var despensa = document.getElementById('alimentos-despensa');
		if (despensa)
			despensa.innerHTML = 'No se han enconctrado alimentos con ese nombre en tu despensa';
	}
	return true;
}