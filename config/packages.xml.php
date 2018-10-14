<?php
	if (!isset($XML_KEY) or $XML_KEY != date('Ymdh'))
		exit();
	echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<packages>
	<package name="main">
    	<action name="sitemap" method="todos_platos_publicos" class="platoAction">
            <result name="success">sitemap.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="activa_javascript" method="activa_javascript" class="usuarioAction">
        </action>
	</package>
    <package name="alimentoClase">
    	<action name="elegir_clase_alimentos" method="elegir" class="alimentoClaseAction">
            <result name="success">includes/alimentoClase/elegir_clase.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="clases_alimentos" method="lista" class="alimentoClaseAction">
            <result name="success">includes/alimentoClase/lista.php</result>
            <result name="error">error.php</result>
        </action>
    </package>
    <package name="alimento">
    	<action name="elegir_alimento" method="elegir" class="alimentoAction">
            <result name="success">includes/alimento/elegir.php</result>
            <result name="elegir_cantidad_alimento_plan">elegir_cantidad_alimento_plan</result>
            <result name="elegir_cantidad_alimento_despensa">elegir_cantidad_alimento_despensa</result>
            <result name="elegir_cantidad_alimento_lista_compra">elegir_cantidad_alimento_lista_compra</result>
            <result name="error">error.php</result>
        </action>
        <action name="ficha_alimento" method="ficha" class="alimentoAction">
            <result name="success">alimento/ficha.php</result>
            <result name="error">error.php</result>
            <result name="publica">alimento/ficha_publica.php</result>
        </action>
        <action name="mueve_despensa_a_lista_compra" method="mueve_despensa_a_lista_compra" 
        		class="alimentoAction">
            <result name="success">includes/alimento/op.php</result>
            <result name="ocultar"></result>
            <result name="error">error.php</result>
        </action>
        <action name="mueve_lista_compra_a_despensa" method="mueve_lista_compra_a_despensa" 
        		class="alimentoAction">
            <result name="success">includes/alimento/op.php</result>
            <result name="ocultar"></result>
            <result name="error">error.php</result>
        </action>
        <action name="op_alimento" method="op" class="alimentoAction">
            <result name="success">includes/alimento/op.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="quit_despensa" method="quit_despensa" class="alimentoAction">
            <result name="success">includes/alimento/op.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="quit_lista_compra" method="quit_lista_compra" class="alimentoAction">
            <result name="success">includes/alimento/op.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="elegir_cantidad_despensa_a_lista_compra" method="elegir_cantidad_despensa_a_lista_compra" 
        		class="alimentoAction">
            <result name="success">includes/alimento/elegir_cantidad.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="elegir_cantidad_lista_compra_a_despensa" method="elegir_cantidad_lista_compra_a_despensa" 
        		class="alimentoAction">
            <result name="success">includes/alimento/elegir_cantidad.php</result>
            <result name="error">error.php</result>
        </action>
    </package>
    <package name="planSemanal">
    	<action name="plan_semanal" method="mostrar_plan" class="planSemanalAction">
            <result name="success">planSemanal/plan.php</result>
            <result name="error">error.php</result>
            <result name="plan-privado">planSemanal/plan_privado.php</result>
        </action>
        <action name="clases_alimentos_plan" method="clases_alimentos" class="planSemanalAction">
            <result name="success">planSemanal/clasesAlimentos.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="alimentos_plan" method="alimentos" class="planSemanalAction">
            <result name="success">planSemanal/alimentos.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="add_alimento_plan" method="add_alimento" class="planSemanalAction">
            <result name="success">plan_semanal</result>
            <result name="dia">plan_dia</result>
            <result name="comida">plan_comida</result>
            <result name="error">error.php</result>
        </action>
        <action name="quit_art_plan" method="quit_art" class="planSemanalAction">
            <result name="success"></result>
            <result name="error">error.php</result>
        </action>
        <action name="add_plato_plan" method="add_plato" class="planSemanalAction">
            <result name="success">plan_semanal</result>
            <result name="dia">plan_dia</result>
            <result name="comida">plan_comida</result>
            <result name="error">error.php</result>
        </action>
        <action name="add_alimentos_plan" method="add_alimentos" class="planSemanalAction">
            <result name="success">plan_semanal</result>
            <result name="dia">plan_dia</result>
            <result name="comida">plan_comida</result>
            <result name="error">planSemanal/clasesAlimentos.php</result>
            <result name="fatal">error.php</result>
        </action>
        <action name="plan_dia" method="dia" class="planSemanalAction">
            <result name="success">includes/plan/planes.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="plan_comida" method="comida" class="planSemanalAction">
            <result name="success">includes/plan/planes.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="add_plan" method="add" class="planSemanalAction">
            <result name="success">planSemanal/dias.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="add_art_plan" method="add_art" class="planSemanalAction">
            <result name="success">plan_semanal</result>
            <result name="receta">receta</result>
            <result name="recetas">recetas</result>
            <result name="error">error.php</result>
        </action>
        <action name="elegir_cantidad_alimento_plan" method="elegir_cantidad_alimento" class="planSemanalAction">
            <result name="success">includes/alimento/elegir_cantidad.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="guardar_alimento_plan" method="guardar_alimento" class="planSemanalAction">
            <result name="success">includes/plan/plan.php</result>
            <result name="warning">includes/alimento/elegir_cantidad.php</result>
            <result name="op">includes/alimento/op.php</result>
            <result name="alimento_plan">includes/plan/art_plan.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="elegir_dia_plan" method="elegir_dia" class="planSemanalAction">
            <result name="success">includes/plan/elegir_dia_plan.php</result>
            <result name="error">error.php</result>
            <result name="elegir_comida">elegir_comida_plan</result>
        </action>
        <action name="elegir_comida_plan" method="elegir_comida" class="planSemanalAction">
            <result name="success">includes/plan/elegir_comida_plan.php</result>
            <result name="error">error.php</result>
            <result name="elegir_clases_alimentos">elegir_clase_alimentos</result>
            <result name="elegir_categoria_platos_plan">elegir_categoria_platos_plan</result>
        </action>
        <action name="plan" method="plan" class="planSemanalAction">
            <result name="success">includes/plan/planes.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="info_nutricional_plan" method="info_nutricional" class="planSemanalAction">
            <result name="success">includes/info_nutricional.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="elegir_receta_plan" method="elegir_receta" class="planSemanalAction">
            <result name="success">includes/plan/elegir_receta.php</result>
            <result name="ya-existe">includes/plan/receta_ya_existe_en_plan.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="guardar_receta_plan" method="guardar_receta" class="planSemanalAction">
            <result name="success">includes/plan/plan.php</result>
            <result name="warning">includes/plan/elegir_receta.php</result>
            <result name="receta_plan">includes/plan/art_plan.php</result>
            <result name="ya-existe">includes/plan/receta_ya_existe_en_plan.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="elegir_categoria_platos_plan" method="elegir_categoria_platos" class="planSemanalAction">
            <result name="success">includes/plan/elegir_categoria_platos.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="elegir_recetas_plan" method="elegir_recetas" class="planSemanalAction">
            <result name="success">includes/plan/elegir_recetas.php</result>
            <result name="sin-resultados">includes/plan/sin_resultados.php</result>
            <result name="elegir_receta">elegir_receta_plan</result>
            <result name="error">error.php</result>
        </action>
        <action name="publicidad_plan" method="publicidad" class="planSemanalAction">
            <result name="success">includes/plan/publicidad.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="publicar_plan" method="publicar" class="planSemanalAction">
            <result name="success">includes/plan/publicidad.php</result>
            <result name="error">error.php</result>
        </action>
    </package>
    <package name="despensa">
    	<action name="mi_despensa" method="mostrar" class="despensaAction">
            <result name="success">despensa/queTengo.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="despensa_usuario" method="despensa" class="despensaAction">
            <result name="success">includes/despensa/despensa_grupos.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="add_ingrediente_despensa" method="add_ingrediente" class="despensaAction">
            <result name="success">includes/receta/ingrediente.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="quit_alimento_despensa" method="quit_alimento" class="despensaAction">
            <result name="success"></result>
            <result name="error">error.php</result>
        </action>
        <action name="clases_alimentos_despensa" method="clases_alimentos" class="despensaAction">
            <result name="success">despensa/clasesAlimentos.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="elegir_cantidad_alimento_despensa" method="elegir_cantidad_alimento" class="despensaAction">
            <result name="success">includes/alimento/elegir_cantidad.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="guardar_alimento_despensa" method="guardar_alimento" class="despensaAction">
            <result name="success">despensa_usuario</result>
            <result name="warning">includes/alimento/elegir_cantidad.php</result>
            <result name="op">includes/alimento/op.php</result>
            <result name="alimento_despensa">includes/despensa/alimento_despensa.php</result>
            <result name="ocultar"></result>
            <result name="error">error.php</result>
        </action>
    </package>
    <package name="lista_compra">
		<action name="mi_lista" method="mostrar" class="listaCompraAction">
			<result name="success">listaCompra/lista.php</result>
			<result name="error">error.php</result>
		</action>
        <action name="quit_alimento" method="quit_alimento" class="listaCompraAction">
            <result name="success"></result>
            <result name="error">error.php</result>
        </action>
        <action name="add_ingrediente_lista_compra" method="add_ingrediente" class="listaCompraAction">
            <result name="success">includes/receta/ingrediente.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="clases_alimentos_lista_compra" method="clases_alimentos" class="listaCompraAction">
            <result name="success">listaCompra/clasesAlimentos.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="lista_compra_usuario" method="lista_compra" class="listaCompraAction">
            <result name="success">includes/listaCompra/lista_compra_grupos.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="elegir_cantidad_alimento_lista_compra" method="elegir_cantidad_alimento" 
        		class="listaCompraAction">
            <result name="success">includes/alimento/elegir_cantidad.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="guardar_alimento_lista_compra" method="guardar_alimento" class="listaCompraAction">
            <result name="success">lista_compra_usuario</result>
            <result name="warning">includes/alimento/elegir_cantidad.php</result>
            <result name="op">includes/alimento/op.php</result>
            <result name="alimento_lista_compra">includes/listaCompra/alimento_lista_compra.php</result>
            <result name="ocultar"></result>
            <result name="error">error.php</result>
        </action>
	</package>
    <package name="plato">
    	<action name="receta" method="mostrar" class="platoAction">
            <result name="success">plato/receta.php</result>
            <result name="error">main</result>
            <result name="publica">plato/receta_publica.php</result>
        </action>
        <action name="que_recetas_puedo_cocinar" method="que_puedo_cocinar" class="platoAction">
            <result name="success">plato/recetas_despensa.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="recetas_que_puedo_cocinar" method="recetas_despensa" class="platoAction">
            <result name="success">includes/receta/que_puedo_cocinar.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="sug_que_platos_puedo_hacer" method="sug_recetas_despensa" class="platoAction">
            <result name="success">includes/receta/sug_recetas_despensa.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="recetas" method="lista" class="platoAction">
            <result name="success">plato/recetas.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="nueva_receta" method="nueva" class="platoAction">
            <result name="success">nueva_receta_form</result>
        </action>
        <action name="nueva_receta_form" method="nuevo_form" class="platoAction">
            <result name="success">plato/nueva_receta_form.php</result>
            <result name="inicio">index</result>
            <result name="error">error.php</result>
        </action>
        <action name="ingredientes_receta_form" method="ingredientes_form" class="platoAction">
            <result name="success">plato/ingredientes_form.php</result>
            <result name="error">plato/ingredientes_form.php</result>
            <result name="form_receta">plato/nueva_receta_form.php</result>
            <result name="form_editar_receta">plato/editar_receta_form.php</result>
            <result name="inicio">index</result>
        </action>
        <action name="guardar_receta" method="guardar" class="platoAction">
            <result name="success">receta</result>
            <result name="error">plato/ingredientes_form.php</result>
            <result name="form_receta">nueva_receta_form</result>
            <result name="form_editar_receta">editar_receta_form</result>
            <result name="fatal">error.php</result>
        </action>
        <action name="nuevo_comentario_plato" method="nuevo_comentario" class="platoAction">
            <result name="success">includes/receta/comentarios.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="recetas_por_alimento" method="recetas_alimento" class="platoAction">
            <result name="success">includes/receta/recetas_alimento.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="recetas_publicas_por_alimento" method="recetas_publicas_alimento" class="platoAction">
            <result name="success">includes/receta/recetas_publicas_alimento.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="recetas_por_categoria" method="recetas_categoria" class="platoAction">
            <result name="success">includes/receta/recetas_categoria.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="recetas_publicas_por_categoria" method="recetas_publicas_categoria" class="platoAction">
            <result name="success">includes/receta/recetas_publicas_categoria.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="sugerencias_recetas" method="sugerencias_recetas" class="platoAction">
            <result name="success">includes/receta/sug_recetas.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="buscar_recetas" method="buscar" class="platoAction">
            <result name="success">includes/receta/buscador.php</result>
        </action>
        <action name="categorias_platos" method="categorias" class="platoAction">
            <result name="success">includes/categoriaPlato/lista.php</result>
        </action>
        <action name="comentarios_plato" method="comentarios" class="platoAction">
            <result name="success">includes/receta/comentarios.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="editar_receta_form" method="editar_form" class="platoAction">
            <result name="success">plato/editar_receta_form.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="recetas_usuario" method="recetas" class="platoAction">
            <result name="success">includes/receta/recetas_usuario.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="buscador_avanzado" method="buscar_avanzado_form" class="platoAction">
            <result name="success">plato/buscador_avanzado_form.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="buscador_recetas_avanzado" method="buscador_avanzado" class="platoAction">
            <result name="success">plato/buscador_avanzado.php</result>
            <result name="no_results">buscador_avanzado</result>
            <result name="error">error.php</result>
        </action>
        <action name="buscar_recetas_avanzado" method="buscar_avanzado" class="platoAction">
            <result name="success">includes/receta/recetas_buscador_avanzado.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="elegir_cantidad_ingrediente" method="elegir_cantidad_ingrediente" class="platoAction">
            <result name="success">includes/alimento/elegir_cantidad.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="guardar_ingrediente" method="guardar_ingrediente" class="platoAction">
            <result name="success">ingredientes_receta</result>
            <result name="warning">includes/alimento/elegir_cantidad.php</result>
            <result name="ingrediente_receta">includes/despensa/ingrediente_receta.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="ingredientes_receta" method="ingredientes" class="platoAction">
            <result name="success">includes/receta/ingredientes.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="quit_ingrediente_receta" method="quit_ingrediente" class="platoAction">
            <result name="success"></result>
            <result name="error">error.php</result>
        </action>
        <action name="info_nutricional_receta" method="info_nutricional" class="platoAction">
            <result name="success">includes/info_nutricional_horizontal.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="categorias_platos_popup" method="categorias" class="platoAction">
            <result name="success">includes/categoriaPlato/lista_popup.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="recetas_publico" method="recetas_publicas" class="platoAction">
            <result name="success">includes/receta/recetas_publicas.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="me-mola-receta" method="me_mola" class="platoAction">
            <result name="success">includes/receta/me-mola.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="anunciar-me-mola-receta" method="anunciar_me_mola" class="platoAction">
            <result name="success">includes/receta/me-mola.php</result>
            <result name="error">error.php</result>
        </action>
    </package>
    <package name="usuario">
    	<action name="index" method="inicio" class="usuarioAction">
            <result name="success">usuario/main.php</result>
        </action>
        <action name="main" method="main" class="usuarioAction">
            <result name="success">usuario/main.php</result>
        </action>
        <action name="show_login" method="show_login" class="usuarioAction">
            <result name="success">usuario/login.php</result>
        </action>
        <action name="login" method="login" class="usuarioAction">
        	<result name="error">usuario/login.php</result>
            <result name="success">main</result>
        </action>
        <action name="salir" method="logout" class="usuarioAction">
            <result name="success">main</result>
        </action>
        <action name="amigos" method="amigos" class="usuarioAction">
            <result name="success">usuario/amigos.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="perfil_usuario" method="perfil" class="usuarioAction">
            <result name="success">usuario/perfil.php</result>
            <result name="error">error.php</result>
            <result name="amigos">amigos</result>
        </action>
        <action name="quizas_conozcas" method="sugerencias_amigos" class="usuarioAction">
            <result name="success">usuario/quizas_conozcas.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="sugerencia_amigo" method="sugerencia_amigo" class="usuarioAction">
            <result name="success">includes/usuario/sugerencia_amistad.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="invitaciones_amistad" method="lista" class="invitacionAmistadAction">
            <result name="success">usuario/invitaciones_amistad.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="invitar" method="nueva" class="invitacionAmistadAction">
            <result name="error">error.php</result>
        </action>
        <action name="aceptar_amistad" method="aceptar" class="invitacionAmistadAction">
        	<result name="perfil">perfil_usuario</result>
            <result name="error">error.php</result>
        </action>
        <action name="rechazar_amistad" method="rechazar" class="invitacionAmistadAction">
            <result name="error">error.php</result>
        </action>
        <action name="eliminar_amistad" method="eliminar_amistad" class="usuarioAction">
            <result name="error">error.php</result>
        </action>
        <action name="login_gmail" method="login_gmail" class="usuarioAction">
        	<result name="success">contactos_gmail</result>
        	<result name="error">error.php</result>
        </action>
        <action name="contactos_gmail" method="contactos_gmail" class="usuarioAction">
            <result name="success">usuario/contactos_gmail.php</result>
            <result name="login">main</result>
            <result name="error">error.php</result>
        </action>
        <action name="buscar_amigos" method="buscar_amigos" class="usuarioAction">
            <result name="success">usuario/buscar_amigos.php</result>
            <result name="error">error.php</result>
        </action>
       	<action name="quitar_no_amigo" method="quitar_no_amigo" class="usuarioAction">
            <result name="error">error.php</result>
        </action>
        <action name="invitar_contactos_email" method="invitar_contactos_email" class="usuarioAction">
            <result name="success">usuario/invitar_contactos_email.php</result>
           	<result name="contactos">contactos_gmail</result>
            <result name="error">error.php</result>
        </action>
        <action name="registro_usuario_form" method="registro_form" class="usuarioAction">
            <result name="success">usuario/registro_form.php</result>
        </action>
        <action name="registro_usuario" method="registro" class="usuarioAction">
            <result name="success">usuario/registro.php</result>
            <result name="error">usuario/registro_form.php</result>
        </action>
        <action name="confirm_registro_usuario" method="confirm_registro" class="usuarioAction">
            <result name="success">main</result>
            <result name="error">main</result>
        </action>
        <action name="editar_perfil" method="editar_perfil" class="usuarioAction">
            <result name="success">usuario/editar_perfil.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="subir_foto_usuario" method="subir_foto" class="usuarioAction">
            <result name="success">editar_perfil</result>
        </action>
        <action name="actividades" method="actividades" class="usuarioAction">
            <result name="success">usuario/actividades.php</result>
        </action>
        <action name="buscador" method="buscador" class="usuarioAction">
            <result name="success">usuario/buscador.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="buscador_usuarios" method="buscador_usuarios" class="usuarioAction">
            <result name="success">usuario/buscador_usuarios.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="buscar_usuarios" method="buscar" class="usuarioAction">
            <result name="success">includes/usuario/buscador.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="actividades_usuario" method="actividades" class="usuarioAction">
            <result name="success">includes/usuario/actividades.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="contactos_usuario" method="contactos" class="usuarioAction">
            <result name="success">includes/usuario/contactos.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="mis_recetas_favoritas" method="recetas_favoritas" class="usuarioAction">
            <result name="success">usuario/recetas_favoritas.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="buscar_mis_recetas_favoritas" method="buscar_recetas_favoritas" class="usuarioAction">
            <result name="success">includes/usuario/recetas_favoritas.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="add_plato_favoritos" method="add_plato_favoritos" class="usuarioAction">
        	<result name="success"></result>
            <result name="error"></result>
        </action>
        <action name="quit_plato_favoritos" method="quit_plato_favoritos" class="usuarioAction">
        	<result name="success"></result>
            <result name="error"></result>
        </action>
        <action name="buscar_mis_recetas" method="recetas_usuario" class="usuarioAction">
            <result name="success">includes/usuario/mis_recetas.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="mis_recetas" method="mis_recetas" class="usuarioAction">
            <result name="success">usuario/mis_recetas.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="que_toca_hoy" method="que_toca_hoy" class="usuarioAction">
            <result name="success">includes/usuario/que_toca_hoy.php</result>
            <result name="error">includes/error.php</result>
        </action>
        <action name="publicar_receta" method="publicar_receta" class="usuarioAction">
            <result name="success">includes/usuario/publicar_receta.php</result>
            <result name="error">includes/error.php</result>
        </action>
        <action name="envio_publicacion_receta" method="envio_publicacion_receta" class="usuarioAction">
            <result name="success">includes/usuario/envio_publicacion_receta.php</result>
            <result name="error">includes/error.php</result>
        </action>
        <action name="despublicar_receta" method="despublicar_receta" class="usuarioAction">
            <result name="success">includes/usuario/despublicar_receta.php</result>
            <result name="error">includes/error.php</result>
        </action>
        <action name="despublicacion_receta" method="despublicacion_receta" class="usuarioAction">
            <result name="success"></result>
            <result name="error">includes/error.php</result>
        </action>
        <action name="baja_usuario" method="baja" class="usuarioAction">
            <result name="success">usuario/baja_usuario.php</result>
            <result name="error">error.php</result>
        </action>
    </package>
    <package name="lista_necesidades">
		<action name="lista_necesidades" method="lista" class="listaNecesidadesAction">
			<result name="success">listaNecesidades/lista.php</result>
			<result name="error">error.php</result>
		</action>
		<action name="lista_necesidades_usuario" method="lista_necesidades" class="listaNecesidadesAction">
            <result name="success">includes/listaNecesidades/lista_necesidades_usuario.php</result>
            <result name="error">error.php</result>
        </action>
        <action name="lista_necesidades_usuario_grupos" method="lista_necesidades_grupos" 
        		class="listaNecesidadesAction">
            <result name="success">includes/listaNecesidades/lista_necesidades_grupos.php</result>
            <result name="error">error.php</result>
        </action>
	</package>
</packages>