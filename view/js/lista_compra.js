var palabra_consulta_listaCompra = null;
var no_buscar_listaCompra = false;
var tiempo_listaCompra = 0;

setInterval('actualiza_tiempo_buscador_listaCompra();', 100);

function actualiza_tiempo_buscador_listaCompra()
{
	if (tiempo_listaCompra == 7 && palabra_consulta_listaCompra)
	{
		var clase = document.getElementById('clases_alimentos_lista_compra');
		if (!clase)
			return false;
		carga(URL_BASE + '?action=lista_compra_usuario&nombre_alimento=' + palabra_consulta_listaCompra 
					+ '&id_clase_alimento=' + clase.value, 'alimentos-lista-compra'
					, 'check_consulta_listaCompra');
		palabra_consulta_listaCompra = '';
		tiempo_listaCompra = 0;
	}
	tiempo_listaCompra++;
}

function filtrar_lista_compra()
{
	var consulta = document.getElementById('consulta_lista_compra');
	if (!consulta)
		return false;
	var clase = document.getElementById('clases_alimentos_lista_compra');
	if (!clase)
		return false;
	carga(URL_BASE + '?action=lista_compra_usuario&nombre_alimento=' + consulta.value + '&id_clase_alimento=' 
			+ clase.value, 'alimentos-lista-compra', 'check_consulta_listaCompra');
}

function buscar_lista_compra()
{
	var consulta = document.getElementById('consulta_lista_compra');
	if (!consulta)
		return false;
	consulta = consulta.value;
	if (consulta.length < 3)
		return false;
	if (palabra_consulta_listaCompra)
	{
		if (consulta.substr(0, palabra_consulta_listaCompra.length) != palabra_consulta_listaCompra)
			no_buscar_listaCompra = false;
	}
	else
		no_buscar_listaCompra = false;
	if (no_buscar_listaCompra)
		return false;
	palabra_consulta_listaCompra = consulta;
	tiempo_listaCompra = 0;
	return true;
}

function limpia_buscador_lista_compra()
{
	carga(URL_BASE + '?action=lista_compra_usuario&v=todos', 'alimentos-lista-compra');
	var form = document.getElementById('buscador_lista_compra');
	if (!form)
		return false;
	form.reset();
	return true;
}

function check_consulta_listaCompra(cargador, param)
{
	if (cargador.responseText == '')
	{
		no_buscar = true;
		var lista_compra = document.getElementById('alimentos-lista-compra');
		if (lista_compra)
			lista_compra.innerHTML = 'No se han alimentos con ese nombre en tu lista de la compra';
	}
	return true;
}