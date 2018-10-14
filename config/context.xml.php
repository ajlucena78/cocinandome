<?php
	if (!isset($XML_KEY) or $XML_KEY != date('Ymdh'))
		exit();
	echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<context>
	<appname>cocinandome.es</appname>
	<email>info@cocinandome.es</email>
	<!-- Origen de datos -->
    <db>
        <url value="mysql:dbname=dbname;host=localhost;charset=UTF8" />
        <username value="dbusername" />
        <password value="dbpassword" />
    </db>
	<!-- Servicios -->
	<service id="alimentoClaseService" class="AlimentoClaseService" />
	<service id="alimentoService" class="AlimentoService" />
	<service id="planSemanalService" class="PlanSemanalService" />
	<service id="despensaService" class="DespensaService" />
	<service id="platoService" class="PlatoService" />
	<service id="usuarioService" class="UsuarioService" />
	<service id="invitacionAmistadService" class="InvitacionAmistadService" />
	<service id="emailUsuarioService" class="EmailUsuarioService" />
	<service id="actividadUsuarioService" class="ActividadUsuarioService" />
	<service id="ingredienteService" class="IngredienteService" />
	<service id="categoriaPlatoService" class="CategoriaPlatoService" />
	<service id="listaCompraService" class="ListaCompraService" />
	<service id="comentarioPlatoService" class="ComentarioPlatoService" />
	<service id="listaNecesidadesService" class="ListaNecesidadesService" />
	<!-- Actions -->
    <action id="alimentoClaseAction" class="AlimentoClaseAction">
    	<service ref="alimentoClaseService" />
    </action>
    <action id="alimentoAction" class="AlimentoAction">
    	<service ref="alimentoService" />
    	<service ref="alimentoClaseService" />
    	<service ref="usuarioService" />
    	<service ref="despensaService" />
    	<service ref="listaCompraService" />
    </action>
    <action id="planSemanalAction" class="PlanSemanalAction">
    	<service ref="planSemanalService" />
    	<service ref="alimentoService" />
    	<service ref="usuarioService" />
    	<service ref="platoService" />
    	<service ref="categoriaPlatoService" />
    	<service ref="actividadUsuarioService" />
    </action>
    <action id="despensaAction" class="DespensaAction">
    	<service ref="despensaService" />
    	<service ref="alimentoService" />
    	<service ref="alimentoClaseService" />
    	<service ref="usuarioService" />
    	<service ref="listaCompraService" />
    	<service ref="ingredienteService" />
    </action>
    <action id="platoAction" class="PlatoAction">
    	<service ref="platoService" />
    	<service ref="despensaService" />
    	<service ref="alimentoService" />
    	<service ref="usuarioService" />
    	<service ref="alimentoClaseService" />
    	<service ref="actividadUsuarioService" />
    	<service ref="ingredienteService" />
    	<service ref="comentarioPlatoService" />
    	<service ref="categoriaPlatoService" />
    </action>
    <action id="usuarioAction" class="UsuarioAction">
    	<service ref="usuarioService" />
    	<service ref="emailUsuarioService" />
    	<service ref="platoService" />
    	<service ref="categoriaPlatoService" />
    	<service ref="actividadUsuarioService" />
    </action>
    <action id="invitacionAmistadAction" class="InvitacionAmistadAction">
    	<service ref="invitacionAmistadService" />
    	<service ref="usuarioService" />
    	<service ref="emailUsuarioService" />
    	<service ref="actividadUsuarioService" />
    </action>
    <action id="listaCompraAction" class="ListaCompraAction">
    	<service ref="listaCompraService" />
    	<service ref="alimentoService" />
    	<service ref="usuarioService" />
    	<service ref="ingredienteService" />
    	<service ref="alimentoClaseService" />
    </action>
    <action id="listaNecesidadesAction" class="ListaNecesidadesAction">
    	<service ref="usuarioService" />
    	<service ref="listaNecesidadesService" />
    	<service ref="alimentoClaseService" />
    </action>
</context>