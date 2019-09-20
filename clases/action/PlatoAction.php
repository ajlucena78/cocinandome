<?php

require_once APP_ROOT . 'clases/util/Fecha.php';
require_once APP_ROOT . 'clases/util/Imagen.php';
require_once APP_ROOT . 'clases/util/Cadena.php';

class PlatoAction extends Action
{
    private $MAX_COMENTARIOS_RECETA = 10;
    private $MAX_RECETAS = 10;
    private $TAM_IMAGEN_RECETA = 300;
    private $MAX_SUGERENCIA_RECETAS = 4;
    private $MAX_RECETAS_CONTACTO = 3;
    private $TAM_FOTO_MINI = 100;

    protected $platoService;
    protected $despensaService;
    protected $usuarioService;
    protected $alimentoClaseService;
    protected $actividadUsuarioService;
    protected $ingredienteService;
    protected $alimentoService;
    protected $comentarioPlatoService;
    protected $categoriaPlatoService;
    protected $plato;
    protected $platos;
    protected $clases;
    protected $errores;
    protected $alimento;
    protected $categoria;
    protected $categorias;
    protected $verMas;
    protected $pagina;
    protected $platoBuscar;
    protected $id_u;
    protected $no_results;
    protected $categorias_marcadas;
    protected $recetas_amigos;
    protected $orden;
    protected $tipo_orden;
    protected $redir;
    protected $action;
    protected $art;
    protected $destino;
    protected $funcion;
    protected $me_mola;

    public function __construct($servicios)
    {
        parent::__construct($servicios);
        if ($_GET['action'] != 'receta' and $_GET['action'] != 'recetas_publicas_por_categoria' and $_GET['action'] != 'recetas_publicas_por_alimento' 
                and $_GET['action'] != 'recetas_publico' and $_GET['action'] != 'sitemap') {
            if (! isset($_SESSION['usuario']) or ! $this->usuarioService->check_usuario($_SESSION['usuario'], $_SESSION['session_id'])) {
                $this->redirect_to_view('usuario/redirect_to_login.php');
            }
        }
    }

    public function mostrar()
    {
        if (! isset($_GET['id_receta']) or ! $_GET['id_receta']) {
            if (isset($_SESSION['id_receta']) and $_SESSION['id_receta']) {
                $_GET['id_receta'] = $_SESSION['id_receta'];
            } else {
                return 'error';
            }
        }
        $this->plato = $this->platoService->findById($_GET['id_receta']);
        if ($this->plato === false) {
            return 'error';
        }
        if (! isset($_SESSION['usuario']) or ! $_SESSION['usuario']) {
            if ($this->plato->publico != 1) {
                $this->redirect_to_view('usuario/redirect_to_login.php');
            }
            return 'publica';
        }
        $_SESSION['id_receta'] = $this->plato->id_plato;
        $_SESSION['criterios']['dia_plan_mostrado'] = null;
        $_SESSION['criterios']['comida_plan_mostrado'] = null;
        return 'success';
    }

    public function que_puedo_cocinar()
    {
        return 'success';
    }

    public function recetas_despensa()
    {
        if (!$_SESSION['usuario']->despensa) {
            $this->platos = array();
            return 'success';
        }
        if (! isset($_GET['p']) or ! ($_GET['p'] += 0)) {
            $this->pagina = 0;
        } else {
            $this->pagina = $_GET['p'];
        }
        $inicio = $this->pagina * $this->MAX_RECETAS;
        $this->platoBuscar = new Plato();
        if (isset($_GET['nombre_plato']) and $_GET['nombre_plato']) {
            $this->platoBuscar->nombre_plato = $_GET['nombre_plato'];
        }
        $total = $this->platoService->total_platos_por_despensa($_SESSION['usuario'], $this->platoBuscar);
        if (($inicio + $this->MAX_RECETAS) < $total) {
            $this->verMas = true;
        }
        $this->platos = $this->platoService->platos_por_despensa($_SESSION['usuario'], null, $this->MAX_RECETAS, $inicio, $this->platoBuscar);
        if ($this->platos === false) {
            return 'error';
        }
        return 'success';
    }

    public function sug_recetas_despensa()
    {
        if (count($_SESSION['usuario']->despensa) == 0) {
            $this->platos = array();
            return 'success';
        }
        if ($_SESSION['usuario']->platos_puedo_hacer() === null) {
            $platos = $this->platoService->id_platos_por_despensa($_SESSION['usuario'], 50);
            if ($platos === false) {
                return 'error';
            }
            $_SESSION['usuario']->platos_puedo_hacer($platos);
        }
        $total = count($_SESSION['usuario']->platos_puedo_hacer());
        if (! $total) {
            return 'success';
        }
        if ($total < $this->MAX_SUGERENCIA_RECETAS) {
            $inicio = 0;
        } else {
            $inicio = rand(0, $total - $this->MAX_SUGERENCIA_RECETAS);
        }
        $platos = array_slice($_SESSION['usuario']->platos_puedo_hacer(), $inicio, $this->MAX_SUGERENCIA_RECETAS);
        $this->platos = $this->platoService->find(new Plato(), null, null, null, null, null, null, $platos);
        if ($this->platos === false) {
            return 'error';
        }
        shuffle($this->platos);
        return 'success';
    }

    public function lista()
    {
        if (isset($_GET['dia']) and $_GET['dia']) {
            $_SESSION['dia_plan'] = $_GET['dia'];
        }
        if (isset($_GET['comida']) and $_GET['comida']) {
            $_SESSION['comida_plan'] = $_GET['comida'];
        }
        if (isset($_GET['id_alimento']) and $_GET['id_alimento']) {
            $this->alimento = new Alimento();
            $this->alimento->id_alimento = $_GET['id_alimento'];
        }
        if (isset($_GET['id_categoria']) and $_GET['id_categoria']) {
            $this->categoria = new CategoriaPlato();
            $this->categoria->id_categoria = $_GET['id_categoria'];
        }
        if (isset($_GET['r'])) {
            if ($_GET['r'] == 'dia' or $_GET['r'] == 'comida') {
                $_SESSION['r'] = $_GET['r'];
            }
        }
        return 'success';
    }

    public function recetas()
    {
        if (! isset($_GET['id_u']) or ! $_GET['id_u']) {
            
            // Si no viene el id de usuario se muestran mis recetas
            $usuario = $_SESSION['usuario'];
            $this->id_u = null;
        } else {
            
            // Si viene el id de usuario se muestran las recetas del mismo, siempre que sea yo o alguno de mis amigos
            if ($_SESSION['usuario']->id_usuario == $_GET['id_u']) {
                $usuario = $_SESSION['usuario'];
            } else {
                if (! isset($_SESSION['usuario']->amigos[$_GET['id_u']])) {
                    return 'error';
                }
                $usuario = $this->usuarioService->findById($_GET['id_u']);
                if (! $usuario) {
                    return 'error';
                }
            }
            $this->id_u = $_GET['id_u'];
        }
        if (! isset($_GET['p']) or ! ($_GET['p'] += 0)) {
            $this->pagina = 0;
        } else {
            $this->pagina = $_GET['p'];
        }
        $inicio = $this->pagina * $this->MAX_RECETAS_CONTACTO;
        $total = $this->usuarioService->total_platos_usuario($usuario);
        if (($inicio + $this->MAX_RECETAS_CONTACTO) < $total) {
            $this->verMas = true;
        }
        $this->platos = $this->usuarioService->platos_usuario($usuario, $this->MAX_RECETAS_CONTACTO, $inicio);
        if ($this->platos === false) {
            return 'error';
        }
        return 'success';
    }

    public function nueva()
    {
        $this->plato = new Plato(array(
            'categoria' => new CategoriaPlato()
        ));
        $_SESSION['receta'] = $this->plato;
        return 'success';
    }

    public function nuevo_form()
    {
        if (! $_SESSION['receta']) {
            return 'inicio';
        }
        if (! isset($_SESSION['categorias_alimentos'])) {
            $_SESSION['categorias_alimentos'] = $this->categoriaPlatoService->findAll(array('nombre_categoria'
                
            ), 'id_categoria');
            if ($_SESSION['categorias_alimentos'] === false) {
                return 'error';
            }
        }
        $this->categorias = $_SESSION['categorias_alimentos'];
        $this->plato = $_SESSION['receta'];
        return 'success';
    }

    public function ingredientes_form()
    {
        if (! isset($_SESSION['receta']) or ! $_SESSION['receta']) {
            return 'error';
        }
        if (! isset($_SESSION['categorias_alimentos'])) {
            return 'error';
        }
        $this->categorias = $_SESSION['categorias_alimentos'];
        $this->plato = new Plato($_POST);
        $this->plato->categoria = new CategoriaPlato($_POST);
        if ($_SESSION['receta']->id_plato) {
            $this->plato->id_plato = $_SESSION['receta']->id_plato;
            if (! isset($_SESSION['usuario']->platos[$this->plato->id_plato])) {
                return 'inicio';
            }
        }
        if ($_SESSION['receta']->ingredientes) {
            $this->plato->ingredientes = $_SESSION['receta']->ingredientes;
        } else {
            $this->plato->ingredientes = array();
        }
        if ($_SESSION['receta']->foto) {
            $this->plato->foto = $_SESSION['receta']->foto;
        } elseif (isset($_FILES['foto']['tmp_name']) and $_FILES['foto']['tmp_name']) {
            $this->plato->foto = md5(uniqid());
        }
        $error = false;
        // validación de los datos de la receta
        if (! $this->platoService->valida($this->plato)) {
            $this->errores = $this->platoService->errores();
            $error = true;
        }
        // foto de la receta (temporal)
        if (isset($_FILES['foto']['tmp_name']) and $_FILES['foto']['tmp_name']) {
            $imagen = new Imagen();
            if (! $imagen->upload_foto($_FILES['foto'], APP_ROOT . 'temp/' . $this->plato->foto, $this->TAM_IMAGEN_RECETA)) {
                $this->errores['foto'] = $imagen->error();
                $this->plato->foto = null;
                $error = true;
            }
        }
        $this->platoService->cargaInfo($this->plato);
        $_SESSION['receta'] = $this->plato;
        if ($error) {
            if ($this->plato->id_plato) {
                return 'form_receta';
            } else {
                return 'form_editar_receta';
            }
        }
        return 'success';
    }

    public function guardar()
    {
        if (! isset($_SESSION['receta'])) {
            return 'form_receta';
        }
        $this->plato = $_SESSION['receta'];
        if ($this->plato->id_plato and ! isset($_SESSION['usuario']->platos[$this->plato->id_plato])) {
            return 'inicio';
        }
        $this->plato->ingredientes = array();
        // validación de los datos de la receta
        if (! isset($_POST['alimentos']) or ! is_array($_POST['alimentos']) or count($_POST['alimentos']) == 0) {
            $this->error = 'No has indicado ningún ingrediente';
            return 'error';
        }
        $cont = 0;
        $error = false;
        foreach ($_POST['alimentos'] as $id) {
            if ($id <= 0) {
                continue;
            }
            $ingrediente = new Ingrediente();
            $alimento = $this->alimentoService->findById($id);
            if (! $alimento) {
                return 'error';
            }
            $ingrediente->alimento = $alimento;
            // si el ingrediente ya está en la receta, se le pone su id
            if ($this->plato->id_plato) {
                if ($ing = $this->plato->ingredientes[$alimento->id_alimento]) {
                    $ingrediente->id_ingrediente = $ing->id_ingrediente;
                }
            }
            $ingrediente->plato = $this->plato;
            $_POST['cantidad'][$cont] = floatval($_POST['cantidad'][$cont]);
            if ($_POST['cantidad'][$cont] < 0 or $_POST['cantidad'][$cont] > 50000) {
                $this->error = 'Es necesario indicar bien las cantidades de los ingredientes';
                $this->error .= ', o no indicarlas';
                $error = true;
            }
            $ingrediente->cantidad = $_POST['cantidad'][$cont];
            $ingrediente->tipo_cantidad = $_POST['tipo_cantidad'][$cont ++];
            $this->plato->ingrediente($ingrediente);
        }
        if ($error) {
            return 'error';
        }
        if (! $this->plato->id_plato) {
            $editar = false;
            $this->plato->id_plato = uniqid();
            $this->plato->publico = 0;
            $this->plato->me_mola = 0;
        } else {
            $editar = true;
        }
        if (! $this->platoService->valida($this->plato)) {
            if ($editar) {
                return 'editar_form_receta';
            } else {
                $this->plato->id_plato = null;
                return 'form_receta';
            }
        }
        $this->plato->usuario = $_SESSION['usuario'];
        $this->plato->nombre_plato = ucfirst($this->plato->nombre_plato);
        $this->platoService->inicia_transaccion();
        if ($this->platoService->save($this->plato, $editar) === false) {
            $this->error = $this->platoService->error();
            $this->platoService->cancela_transaccion();
            return 'fatal';
        }
        if ($editar) {
            $id = $this->plato->id_plato;
        }
        // ingredientes
        if ($editar and $this->plato->id_plato) {
            $plato = $this->platoService->findById($this->plato->id_plato);
            if (! $plato) {
                return 'error';
            }
            foreach ($plato->ingredientes as $ingAnterior) {
                // si el anterior ingrediente no está ya, se quita de la receta
                if (! isset($this->plato->ingredientes[$ingAnterior->alimento->id_alimento])) {
                    $this->ingredienteService->removeById($ingAnterior->id_ingrediente);
                }
            }
        }
        foreach ($this->plato->ingredientes as $ingrediente) {
            if ($ingrediente->id_ingrediente) {
                $editarIng = true;
            } else {
                $editarIng = false;
                $ingrediente->id_ingrediente = $this->plato->id_plato . $ingrediente->alimento->id_alimento;
            }
            if ($this->ingredienteService->save($ingrediente, $editarIng) === false) {
                $this->error = $this->ingredienteService->error();
                $this->ingredienteService->cancela_transaccion();
                return 'fatal';
            }
        }
        // foto de la receta
        if ($this->plato->foto and file_exists(APP_ROOT . 'temp/' . $this->plato->foto)) {
            require_once APP_ROOT . 'clases/util/Imagen.php';
            if (! Imagen::thumb_jpeg(APP_ROOT . 'temp/' . $this->plato->foto, APP_ROOT . 'res/img/plato/' . $this->plato->foto . '.jpg', $this->TAM_IMAGEN_RECETA)) {
                $this->error = 'No se ha podido mover la imagen';
                if (isset($_SESSION['error_foto_receta']))
                    $this->error .= ' (' . $_SESSION['error_foto_receta'] . ')';
                {
                    if (! $editar) {
                        $this->plato->id_plato = null;
                    }
                    return 'error';
                }
            }
            if (! is_dir(APP_ROOT . 'res/img/plato/mini')) {
                if (! @mkdir(APP_ROOT . 'res/img/plato/mini')) {
                    $this->error = 'No se ha podido mover la imagen';
                    return 'success';
                }
            }
            if (! Imagen::thumb_jpeg(APP_ROOT . 'res/img/plato/' . $this->plato->foto . '.jpg', APP_ROOT . 'res/img/plato/mini/' . $this->plato->foto . '.jpg', $this->TAM_FOTO_MINI)) {
                $this->error = 'No se ha podido mover la imagen';
                return 'success';
            }
            @unlink(APP_ROOT . 'temp/' . $this->plato->foto);
        }
        if (! $editar) {
            // se guarda la actividad del usuario (nueva receta)
            $actividadUsuario = new ActividadUsuario();
            $actividadUsuario->fecha = date('Y-m-d H:i:s');
            $actividadUsuario->id_actividad = uniqid();
            $actividadUsuario->tipo = 2;
            $actividadUsuario->plato = $this->plato;
            $actividadUsuario->usuario = $_SESSION['usuario'];
            if ($this->actividadUsuarioService->save($actividadUsuario) === false) {
                $this->error = $this->actividadUsuarioService->error();
                $this->actividadUsuarioService->cancela_transaccion();
                return 'fatal';
            }
        }
        if (! $this->platoService->cierra_transaccion()) {
            if (! $editar) {
                $this->plato->id_plato = null;
            }
            $this->error = 'No ha sido posible guardar la receta, inténtalo más tarde';
            return 'error';
        }
        $_SESSION['usuario']->plato($this->plato);
        $_SESSION['receta'] = null;
        $_SESSION['id_receta'] = $this->plato->id_plato;
        return 'success';
    }

    public function nuevo_comentario()
    {
        if (! isset($_POST['id_plato'])) {
            return 'error';
        }
        $comentario = new ComentarioPlato();
        $comentario->id_comentario = uniqid();
        $comentario->fecha = Fecha::fecha_hoy();
        $comentario->usuario = $_SESSION['usuario'];
        $comentario->comentario = $_POST['comentario'];
        $plato = new Plato();
        $plato->id_plato = $_POST['id_plato'];
        $comentario->plato = $plato;
        if (! $this->comentarioPlatoService->valida($comentario)) {
            $this->error = $this->comentarioPlatoService->error();
            return 'success';
        }
        // se carga el plato a comentar
        $plato = $this->platoService->platos_para_usuario($_SESSION['usuario'], null, 0, $plato);
        // se comprueba que el usuario sólo comente las recetas a las que tiene acceso
        if (! $plato) {
            $this->error = 'La receta no se puede comentar';
            return 'success';
        }
        $this->plato = $plato[0];
        $this->comentarioPlatoService->inicia_transaccion();
        // se guarda el comentario
        if ($this->comentarioPlatoService->save($comentario) === false) {
            $this->error = $this->comentarioPlatoService->error();
            $this->comentarioPlatoService->cancela_transaccion();
            return 'fatal';
        }
        // se guarda la actividad asociada al usuario y la receta
        $actividad = new ActividadUsuario();
        $actividad->id_actividad = uniqid();
        $actividad->usuario = $_SESSION['usuario'];
        $actividad->plato = $this->plato;
        $actividad->tipo = 3;
        $actividad->comentario_plato = $comentario;
        $actividad->fecha = Fecha::fecha_hoy();
        if ($this->actividadUsuarioService->save($actividad) === false) {
            $this->error = $this->actividadUsuarioService->error();
            $this->actividadUsuarioService->cancela_transaccion();
            return 'fatal';
        }
        if (! $this->platoService->cierra_transaccion()) {
            $this->error = 'No ha sido posible guardar el comentario, inténtalo más tarde';
            return 'error';
        }
        $comentarioPlato = new ComentarioPlato();
        $comentarioPlato->plato = $this->plato;
        $comentarios = $this->comentarioPlatoService->find($comentarioPlato, $this->MAX_COMENTARIOS_RECETA, 'fecha desc', null, null, false, 0);
        if ($comentarios === false) {
            return 'error';
        }
        $this->plato->comentarios = $comentarios;
        return 'success';
    }

    public function recetas_alimento()
    {
        if (! $_GET['id_alimento']) {
            exit();
        }
        $this->alimento = $this->alimentoService->findById($_GET['id_alimento']);
        if (! $this->alimento) {
            exit();
        }
        $total = $this->platoService->total_platos_para_usuario($_SESSION['usuario'], null, $this->alimento);
        if ($total === false) {
            return 'error';
        }
        if (! $total) {
            return 'success';
        }
        if ($total > 3) {
            $pos = rand(0, $total - 3);
        } else {
            $pos = 0;
        }
        $this->platos = $this->platoService->platos_para_usuario($_SESSION['usuario'], 3, $pos, null, $this->alimento);
        if ($this->platos === false) {
            return 'error';
        }
        shuffle($this->platos);
        if ($total > 3) {
            $this->verMas = true;
        }
        return 'success';
    }

    public function recetas_publicas_alimento()
    {
        if (! $_GET['id_alimento']) {
            exit();
        }
        $this->alimento = $this->alimentoService->findById($_GET['id_alimento']);
        if (! $this->alimento) {
            exit();
        }
        $total = $this->platoService->total_recetas_publicas(null, null, $this->alimento);
        if ($total === false) {
            return 'error';
        }
        if (! $total) {
            return 'success';
        }
        if ($total > 3) {
            $pos = rand(0, $total - 3);
        } else {
            $pos = 0;
        }
        $this->platos = $this->platoService->recetas_publicas(null, null, 3, $pos, $this->alimento);
        if ($this->platos === false) {
            return 'error';
        }
        shuffle($this->platos);
        return 'success';
    }

    public function recetas_categoria()
    {
        if (! $_GET['id_categoria']) {
            exit();
        }
        $this->categoria = $this->categoriaPlatoService->findById($_GET['id_categoria']);
        if (! $this->categoria) {
            exit();
        }
        $plato = new Plato();
        $plato->categoria = new CategoriaPlato($_GET);
        if ($_GET['id_plato']) {
            $excludes = array(
                'id_plato' => $_GET['id_plato']
            );
        } else {
            $excludes = null;
        }
        $total = $this->platoService->total_platos_para_usuario($_SESSION['usuario'], $plato, null, $excludes);
        if ($total === false) {
            return 'error';
        }
        if (! $total) {
            return 'success';
        }
        if ($total > 4) {
            $pos = rand(0, $total - 4);
        } else {
            $pos = 0;
        }
        $this->platos = $this->platoService->platos_para_usuario($_SESSION['usuario'], 4, $pos, $plato, null, $excludes);
        if ($this->platos === false) {
            return 'error';
        }
        shuffle($this->platos);
        if ($total > 4) {
            $this->verMas = true;
        }
        return 'success';
    }

    public function recetas_publicas_categoria()
    {
        if (! $_GET['id_categoria']) {
            exit();
        }
        $this->categoria = $this->categoriaPlatoService->findById($_GET['id_categoria']);
        if (! $this->categoria) {
            exit();
        }
        $plato = new Plato();
        $plato->categoria = new CategoriaPlato($_GET);
        if (isset($_GET['id_plato']) and $_GET['id_plato']) {
            $id_receta = $_GET['id_plato'];
        } else {
            $id_receta = null;
        }
        $plato->publico = 1;
        $total = $this->platoService->total_recetas_publicas($plato, $id_receta);
        if ($total === false) {
            return 'error';
        }
        if (! $total) {
            return 'success';
        }
        if ($total > 3) {
            $pos = rand(0, $total - 3);
        } else {
            $pos = 0;
        }
        $this->platos = $this->platoService->recetas_publicas($plato, $id_receta, 3, $pos);
        if ($this->platos === false) {
            return 'error';
        }
        shuffle($this->platos);
        return 'success';
    }

    public function sugerencias_recetas()
    {
        $totalPlatos = $this->platoService->total_platos_para_usuario($_SESSION['usuario']);
        if ($totalPlatos === false) {
            if ($this->platoService->error()) {
                $this->error = $this->platoService->error();
            }
            return 'error';
        }
        if (! $totalPlatos) {
            return 'success';
        }
        $pos = rand(0, $totalPlatos - 1);
        $this->platos = $this->platoService->platos_para_usuario($_SESSION['usuario'], 1, $pos);
        if ($this->platos === false) {
            if ($this->platoService->error()) {
                $this->error = $this->platoService->error();
            }
            return 'error';
        }
        return 'success';
    }

    public function buscar()
    {
        if (isset($_GET['nombre_plato']) and $_GET['nombre_plato'] and strlen(trim($_GET['nombre_plato'])) < 3) {
            return 'success';
        }
        $this->platoBuscar = new Plato($_GET);
        $categoria = new CategoriaPlato();
        if (isset($_GET['id_categoria']) and $_GET['id_categoria'] > 0) {
            $categoria->id_categoria = $_GET['id_categoria'];
        }
        $this->platoBuscar->categoria = $categoria;
        $this->alimento = new Alimento();
        if (isset($_GET['id_alimento']) and $_GET['id_alimento'] > 0) {
            $this->alimento->id_alimento = $_GET['id_alimento'];
        }
        if (! isset($_GET['p']) or ! ($_GET['p'] += 0)) {
            $_GET['p'] = 0;
        }
        $inicio = $_GET['p'] * $this->MAX_RECETAS;
        $total = $this->platoService->total_platos_para_usuario($_SESSION['usuario'], $this->platoBuscar, $this->alimento);
        if (($inicio + $this->MAX_RECETAS) < $total) {
            $this->verMas = true;
        }
        $this->platos = $this->platoService->platos_para_usuario($_SESSION['usuario'], $this->MAX_RECETAS, $inicio, $this->platoBuscar, $this->alimento);
        if ($this->platos === false) {
            return 'error';
        }
        return 'success';
    }

    public function buscar_avanzado_form()
    {
        if (isset($_GET['limpiar_form']) and isset($_SESSION['criterios_buscador_recetas'])) {
            unset($_SESSION['criterios_buscador_recetas']);
        }
        if (! isset($_SESSION['categorias_alimentos'])) {
            $this->categorias = $this->categoriaPlatoService->findAll(array(
                'nombre_categoria'
            ), 'id_categoria');
            if ($this->categorias === false) {
                return 'error';
            }
            $_SESSION['categorias_alimentos'] = $this->categorias;
        } else {
            $this->categorias = $_SESSION['categorias_alimentos'];
        }
        if (isset($_SESSION['msg_no_results'])) {
            $this->no_results = true;
            unset($_SESSION['msg_no_results']);
        }
        if (isset($_SESSION['criterios_buscador_recetas'])) {
            $this->plato = new Plato($_SESSION['criterios_buscador_recetas']);
            if (isset($_SESSION['criterios_buscador_recetas']['consulta'])) {
                $this->plato->nombre_plato = $_SESSION['criterios_buscador_recetas']['consulta'];
            }
            if (isset($_SESSION['criterios_buscador_recetas']['categorias'])) {
                $this->categorias_marcadas = array();
                foreach ($_SESSION['criterios_buscador_recetas']['categorias'] as $id) {
                    $this->categorias_marcadas[$id] = true;
                }
            }
            if (isset($_SESSION['criterios_buscador_recetas']['red'])) {
                if ($_SESSION['criterios_buscador_recetas']['red'] == 'publicas') {
                    $this->plato->publico = true;
                } elseif ($_SESSION['criterios_buscador_recetas']['red'] == 'amigos') {
                    $this->recetas_amigos = true;
                }
            }
        } else {
            $this->plato = new Plato();
        }
        return 'success';
    }

    public function buscador_avanzado()
    {
        if (isset($_GET['limpiar_form'])) {
            unset($_SESSION['criterios_buscador_recetas']);
            return 'no_results';
        }
        if (! isset($_SESSION['categorias_alimentos'])) {
            $categorias = $this->categoriaPlatoService->findAll(array(
                'nombre_categoria'
            ), 'id_categoria');
            if ($this->categorias === false) {
                return 'error';
            }
            $_SESSION['categorias_alimentos'] = $categorias;
        }
        $criterios = $_GET;
        if (isset($criterios['categorias']) and is_array($criterios['categorias'])) {
            foreach ($criterios['categorias'] as $id) {
                if (! $_SESSION['categorias_alimentos'][$id]) {
                    return 'error';
                }
            }
        } else {
            $criterios['categorias'] = null;
        }
        $_SESSION['criterios_buscador_recetas'] = $criterios;
        $plato = new Plato($criterios);
        if (isset($criterios['consulta'])) {
            $plato->nombre_plato = $criterios['consulta'];
        }
        if (isset($criterios['red']) and $criterios['red'] == 'publicas') {
            $plato->publico = true;
        }
        if (isset($criterios['red']) and $criterios['red'] == 'amigos') {
            $recetasAmigos = true;
        } else {
            $recetasAmigos = false;
        }
        $total = $this->platoService->total_platos_para_usuario_avanzado($_SESSION['usuario'], $plato, $criterios['categorias'], $recetasAmigos);
        if (! $total) {
            $_SESSION['msg_no_results'] = true;
            return 'no_results';
        }
        return 'success';
    }

    public function buscar_avanzado()
    {
        if (! isset($_SESSION['criterios_buscador_recetas'])) {
            return 'success';
        }
        $criterios = $_SESSION['criterios_buscador_recetas'];
        $plato = new Plato($criterios);
        if (isset($criterios['consulta'])) {
            $plato->nombre_plato = $criterios['consulta'];
        }
        if (isset($criterios['red']) and $criterios['red'] == 'publicas') {
            $plato->publico = true;
        }
        if (isset($criterios['red']) and $criterios['red'] == 'amigos') {
            $recetasAmigos = true;
        } else {
            $recetasAmigos = false;
        }
        if (! isset($_GET['p']) or ! ($_GET['p'] += 0)) {
            $this->pagina = 0;
        } else {
            $this->pagina = $_GET['p'];
        }
        $inicio = $this->pagina * $this->MAX_RECETAS;
        $total = $this->platoService->total_platos_para_usuario_avanzado($_SESSION['usuario'], $plato, $criterios['categorias'], $recetasAmigos);
        if (($inicio + $this->MAX_RECETAS) < $total) {
            $this->verMas = true;
        }
        // ordenar por un campo de la receta
        if (! isset($_POST['orden']) and isset($_SESSION['orden_buscador_avanzado_recetas'])) {
            $_POST['orden'] = $_SESSION['orden_buscador_avanzado_recetas'];
        }
        if (isset($_POST['orden']) and $_POST['orden']) {
            // TODO controlar que no se mande un campo que no exista
            $orden = array(
                $_POST['orden']
            );
        } else {
            $orden = array(
                'id_plato'
            );
        }
        // tipo de orden (asc o desc)
        $_SESSION['orden_buscador_avanzado_recetas'] = $orden[0];
        if (! isset($_POST['tipo_orden']) and isset($_SESSION['tipo_orden_buscador_avanzado_recetas'])) {
            $_POST['tipo_orden'] = $_SESSION['tipo_orden_buscador_avanzado_recetas'];
        }
        if (isset($_POST['tipo_orden'])) {
            if ($_POST['tipo_orden'] == 'asc' or $_POST['tipo_orden'] == 'desc') {
                $orden[0] .= ' ' . $_POST['tipo_orden'];
                $_SESSION['tipo_orden_buscador_avanzado_recetas'] = $orden[0];
            }
        } else {
            $orden[0] .= ' desc';
            unset($_SESSION['tipo_orden_buscador_avanzado_recetas']);
        }
        $this->platos = $this->platoService->platos_para_usuario_avanzado($_SESSION['usuario'], $this->MAX_RECETAS, $inicio, $plato, $criterios['categorias'], $recetasAmigos, $orden);
        if ($this->platos === false) {
            return 'error';
        }
        return 'success';
    }

    public function categorias()
    {
        if (! isset($_SESSION['categorias_alimentos'])) {
            $_SESSION['categorias_alimentos'] = $this->categoriaPlatoService->findAll(array(
                'nombre_categoria'
            ), 'id_categoria');
            if ($_SESSION['categorias_alimentos'] === false) {
                return 'error';
            }
        }
        $this->categorias = $_SESSION['categorias_alimentos'];
        return 'success';
    }

    public function comentarios()
    {
        if (! isset($_GET['id_receta']) or ! $_GET['id_receta']) {
            return 'error';
        }
        $plato = new Plato();
        $plato->id_plato = $_GET['id_receta'];
        $plato = $this->platoService->platos_para_usuario($_SESSION['usuario'], null, 0, $plato);
        if (! $plato) {
            return 'error';
        }
        $this->plato = $plato[0];
        if (! isset($_GET['p']) or ! ($_GET['p'] += 0)) {
            $_GET['p'] = 0;
        }
        $inicio = $_GET['p'] * $this->MAX_COMENTARIOS_RECETA;
        $comentarioPlato = new ComentarioPlato();
        $comentarioPlato->plato = $this->plato;
        $total = $this->comentarioPlatoService->find($comentarioPlato, null, null, null, null, true);
        if ($total === false) {
            return 'error';
        }
        if (($inicio + $this->MAX_COMENTARIOS_RECETA) < $total) {
            $this->verMas = true;
        }
        $comentarios = $this->comentarioPlatoService->find($comentarioPlato, $this->MAX_COMENTARIOS_RECETA, 'fecha desc', null, null, false, $inicio);
        if ($comentarios === false) {
            return 'error';
        }
        $this->plato->comentarios = $comentarios;
        return 'success';
    }

    public function buscar_recetas_usuario()
    {
        if (! isset($_GET['nombre_plato']) or ! $_GET['nombre_plato']) {
            return 'error';
        }
        $consulta = Cadena::quita_acentos(trim($_GET['nombre_plato']));
        $platos = array();
        foreach ($_SESSION['usuario']->platos() as $plato) {
            if (stripos(Cadena::quita_acentos($plato->nombre_plato), $consulta) !== false) {
                $platos[] = $plato;
            }
        }
        if (! isset($_GET['p']) or ! ($_GET['p'] += 0)) {
            $this->pagina = 0;
        } else {
            $this->pagina = $_GET['p'];
        }
        $inicio = $this->pagina * $this->MAX_RECETAS;
        if (($inicio + $this->MAX_RECETAS) < count($platos)) {
            $this->verMas = true;
        }
        $this->platos = array_slice($platos, $inicio, $this->MAX_RECETAS);
        $this->platoBuscar = new Plato();
        $this->platoBuscar->nombre_plato = $consulta;
        return 'success';
    }

    public function ingredientes()
    {
        if (! isset($_SESSION['receta']) or ! $_SESSION['receta']) {
            return 'error';
        }
        $this->plato = $_SESSION['receta'];
        return 'success';
    }

    public function quit_ingrediente()
    {
        if (! isset($_GET['id_alimento']) or ! $_GET['id_alimento']) {
            return 'error';
        }
        if (! isset($_SESSION['receta']) or ! $_SESSION['receta']) {
            return 'error';
        }
        if (! isset($_SESSION['receta']->ingredientes[$_GET['id_alimento']])) {
            return 'error';
        }
        $ingrediente = new Ingrediente();
        $ingrediente->alimento = new Alimento();
        $ingrediente->alimento->id_alimento = $_GET['id_alimento'];
        $_SESSION['receta']->ingrediente($ingrediente, true);
        $this->platoService->cargaInfo($_SESSION['receta']);
        return 'success';
    }

    public function elegir_cantidad_ingrediente()
    {
        if (! isset($_GET['id_alimento']) or ! $_GET['id_alimento']) {
            return 'error';
        }
        if (! isset($_SESSION['receta']) or ! $_SESSION['receta']) {
            return 'error';
        }
        $ingrediente = new Ingrediente();
        if (! isset($_SESSION['receta']->ingredientes[$_GET['id_alimento']])) {
            $alimento = $this->alimentoService->findById($_GET['id_alimento']);
            if (! $alimento) {
                return 'error';
            }
            $ingrediente->alimento = $alimento;
            $this->art = $ingrediente;
        } else {
            $this->art = $_SESSION['receta']->ingredientes[$_GET['id_alimento']];
        }
        $this->action = 'guardar_ingrediente';
        $this->destino = 'ingredientes';
        $this->funcion = 'popup_clases_alimentos(\\\'elegir_cantidad_ingrediente\\\'); ' . 'actualiza_info_nutricional_receta();';
        return 'success';
    }

    public function guardar_ingrediente()
    {
        if (! isset($_POST['id_alimento']) or ! $_POST['id_alimento']) {
            return 'error';
        }
        if (! isset($_SESSION['receta']) or ! $_SESSION['receta']) {
            return 'error';
        }
        $ingrediente = new Ingrediente();
        $this->alimento = new Alimento();
        $this->alimento->id_alimento = $_POST['id_alimento'];
        $ingrediente->alimento = $this->alimento;
        if (isset($_SESSION['receta']->ingredientes[$_POST['id_alimento']])) {
            $this->art = $_SESSION['receta']->ingredientes[$_POST['id_alimento']];
        } else {
            $this->alimento = $this->alimentoService->findById($_POST['id_alimento']);
            if (! $this->alimento) {
                return 'error';
            }
            $ingrediente->alimento = $this->alimento;
            $this->art = $ingrediente;
            $this->art->id_ingrediente = uniqid();
        }
        if (($_POST['cantidad'] += 0) and $_POST['cantidad'] < 0) {
            $this->error = 'Es necesario indicar la cantidad correctamente';
            return 'error';
        }
        $this->art->cantidad = $_POST['cantidad'];
        $this->art->tipo_cantidad = $_POST['tipo_cantidad'] + 0;
        $ingredientes = $_SESSION['receta']->ingredientes;
        $ingredientes[$_POST['id_alimento']] = $this->art;
        $_SESSION['receta']->ingredientes = $ingredientes;
        $this->platoService->cargaInfo($_SESSION['receta']);
        if (isset($_GET['r']) and $_GET['r']) {
            return $_GET['r'];
        }
        return 'success';
    }

    public function editar_form()
    {
        if (isset($_GET['id_receta']) and $_GET['id_receta']) {
            $plato = new Plato();
            $plato->id_plato = $_GET['id_receta'];
            if (! $_SESSION['usuario']->platos($plato)) {
                return 'error';
            }
            $plato = $this->platoService->findById($_GET['id_receta']);
            if (! $plato) {
                return 'error';
            }
            $_SESSION['receta'] = $plato;
        } elseif (! isset($_SESSION['receta'])) {
            return 'error';
        }
        $this->plato = $_SESSION['receta'];
        if (! isset($_SESSION['categorias_alimentos'])) {
            $_SESSION['categorias_alimentos'] = $this->categoriaPlatoService->findAll(array(
                'nombre_categoria'
            ), 'id_categoria');
            if ($_SESSION['categorias_alimentos'] === false) {
                return 'error';
            }
        }
        $this->categorias = $_SESSION['categorias_alimentos'];
        return 'success';
    }

    public function info_nutricional()
    {
        if (! isset($_SESSION['receta']) or ! $_SESSION['receta']) {
            return 'error';
        }
        $this->alimento = $_SESSION['receta'];
        return 'success';
    }

    public function recetas_publicas()
    {
        $plato = new Plato();
        $plato->publico = 1;
        $total = $this->platoService->total_recetas_publicas($plato);
        if ($total === false) {
            return 'error';
        }
        if (! $total) {
            return 'success';
        }
        if ($total > 3) {
            $pos = rand(0, $total - 3);
        } else {
            $pos = 0;
        }
        $this->platos = $this->platoService->recetas_publicas($plato, null, 3, $pos);
        if ($this->platos === false) {
            return 'error';
        }
        shuffle($this->platos);
        return 'success';
    }

    public function me_mola()
    {
        if (! isset($_GET['id_receta']) or ! $_GET['id_receta']) {
            return 'error';
        }
        $this->plato = new Plato();
        $this->plato->id_plato = $_GET['id_receta'];
        $this->plato = $this->platoService->platos_para_usuario($_SESSION['usuario'], null, 0, $this->plato);
        if (! $this->plato) {
            return 'error';
        }
        $this->plato = $this->plato[0];
        $usuario = new Usuario();
        $usuario->id_usuario = $_SESSION['usuario']->id_usuario;
        $usuario->me_mola_plato = array(
            $this->plato
        );
        if ($this->usuarioService->exist_relation($usuario, 'me_mola_plato')) {
            $this->me_mola = true;
        }
        return 'success';
    }

    public function anunciar_me_mola()
    {
        if (! isset($_GET['id_receta']) or ! $_GET['id_receta']) {
            return 'error';
        }
        $this->plato = new Plato();
        $this->plato->id_plato = $_GET['id_receta'];
        $this->plato = $this->platoService->platos_para_usuario($_SESSION['usuario'], null, 0, $this->plato);
        if (! $this->plato) {
            return 'error';
        }
        $this->plato = $this->plato[0];
        $this->platoService->inicia_transaccion();
        $res = $this->platoService->me_mola($this->plato);
        if ($res === false) {
            return 'error';
        }
        if (! $res) {
            return 'success';
        }
        $actividadUsuario = new ActividadUsuario();
        $actividadUsuario->fecha = date('Y-m-d H:i:s');
        $actividadUsuario->id_actividad = uniqid();
        $actividadUsuario->tipo = 4;
        $actividadUsuario->plato = $this->plato;
        $actividadUsuario->usuario = $_SESSION['usuario'];
        if (! $this->actividadUsuarioService->save($actividadUsuario)) {
            return 'error';
        }
        if (! $this->platoService->cierra_transaccion()) {
            return 'error';
        }
        $this->plato->me_mola = $this->plato->me_mola + 1;
        $this->me_mola = true;
        return 'success';
    }

    public function todos_platos_publicos()
    {
        $plato = new Plato();
        $plato->publico = 1;
        $this->platos = $this->platoService->recetas_publicas($plato);
        if ($this->platos === false) {
            return 'error';
        }
        return 'success';
    }
}