function dar_baja()
{
	var mensaje = '¿Deseas dar de baja tu usuario?\nSi lo haces se borrará permanentemente toda tu información.';
	if (window.confirm(mensaje))
	{
		window.location.href = '?action=baja_usuario';
	}
}