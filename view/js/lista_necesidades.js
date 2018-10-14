var palabra_consulta = null;
var no_buscar = false;
var tiempo = 0;

setInterval('actualiza_tiempo_buscador();', 100);

function actualiza_tiempo_buscador()
{
	if (tiempo == 7 && palabra_consulta)
	{
		var clase = document.getElementById('clases_alimentos_lista_necesidades');
		if (!clase)
			return false;
		carga(URL_BASE + '?action=lista_necesidades_usuario&nombre_alimento=' + palabra_consulta + '&id_clase_alimento=' 
				+ clase.value, 'lista_necesidades', 'check_consulta');
		palabra_consulta = '';
		tiempo = 0;
	}
	tiempo++;
}

function filtrar_lista_necesidades()
{
	var consulta = document.getElementById('consulta_lista_necesidades');
	if (!consulta)
		return false;
	var clase = document.getElementById('clases_alimentos_lista_necesidades');
	if (!clase)
		return false;
	carga(URL_BASE + '?action=lista_necesidades_usuario&nombre_alimento=' + consulta.value + '&id_clase_alimento=' 
			+ clase.value, 'lista_necesidades', 'check_consulta');
}

function buscar_lista_necesidades()
{
	var consulta = document.getElementById('consulta_lista_necesidades');
	if (!consulta)
		return false;
	consulta = consulta.value;
	if (consulta.length < 3)
		return false;
	if (palabra_consulta)
	{
		if (consulta.substr(0, palabra_consulta.length) != palabra_consulta)
			no_buscar = false;
	}
	else
		no_buscar = false;
	if (no_buscar)
		return false;
	palabra_consulta = consulta;
	tiempo = 0;
	return true;
}

function limpia_buscador_lista_necesidades()
{
	var form = document.getElementById('buscador_lista_necesidades');
	if (!form)
		return false;
	form.reset();
	return true;
}

function check_consulta(cargador, param)
{
	if (cargador.responseText == '')
	{
		no_buscar = true;
		var lista_necesidades = document.getElementById('lista_necesidades');
		if (lista_necesidades)
			lista_necesidades.innerHTML = 'No se han alimentos con ese nombre en tu lista de necesidades';
	}
	return true;
}