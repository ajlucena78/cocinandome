var text_tec = 'cantidad';

function type_tec(tecla, funcion = null)
{
	if (!tecla)
		return false;
	if (!text_tec)
		return false;
	var text = document.getElementById(text_tec);
	if (!text)
		return false;
	if (text.value.length >= 6)
		return true;
	if (tecla == 'del')
		text.value = text.value.substr(0, text.value.length - 1);
	else
		text.value += tecla;
	if (funcion)
		eval(funcion + '();');
	return true;
}