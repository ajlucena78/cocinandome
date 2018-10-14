function mostrar_mensaje(mensaje)
{
	var mensajes = document.getElementById('mensajes');
	if (!mensajes)
		return false;
	mensajes.innerHTML = mensaje;
	return true;
}

function carga_sugerencia_amistad(id)
{
	if (!id)
		id = 'sugerencias_amistad';
	carga(URL_BASE + '?action=sugerencia_amigo', null, 'mostrar_sugerencia_amistad', id);
	return true;
}

function mostrar_sugerencia_amistad(cargador, id)
{
	if (!cargador || !cargador.responseText)
	{
		var capaPadre = document.getElementById(id);
		if (!capaPadre)
			return false;
		var divsSug = capaPadre.getElementsByTagName('div');
		if (divsSug.length == 0)
			capaPadre.style.display = 'none';
		return true;
	}
	var capa = document.createElement("div");
	capa.innerHTML = cargador.responseText;
	var divsCapa = capa.getElementsByTagName('div');
	var divsPagina = document.getElementsByTagName('div');
	for (var i = 0; i < divsPagina.length; i++)
	{
		if (divsCapa[0].id == divsPagina[i].id)
			removeElement(divsPagina[i]);
	}
	var capaPadre = document.getElementById(id);
	if (!capaPadre)
		return false;
	capaPadre.innerHTML += cargador.responseText;
	return true;
}