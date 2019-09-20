<?php

class DespensaAction extends Action
{
    protected $despensaService;
    protected $alimentoService;
    protected $alimentoClaseService;
    protected $listaCompraService;
    protected $ingredienteService;
    protected $despensa;
    protected $clasesAlimentos;
    protected $alimentos;
    protected $ingrediente;
    protected $art;
    protected $alimento;

    public function __construct($servicios)
    {
        parent::__construct($servicios);
        if (! isset($_SESSION['usuario']) or ! $this->usuarioService->check_usuario($_SESSION['usuario'], $_SESSION['session_id'])) {
            $this->redirect_to_view('usuario/redirect_to_login.php');
        }
    }

    public function mostrar()
    {
        if (! isset($_SESSION['clases_alimentos'])) {
            $_SESSION['clases_alimentos'] = $this->alimentoClaseService->findAll(array(
                'nombre_clase_alimento'
            ), 'id_clase_alimento');
            if ($_SESSION['clases_alimentos'] === false) {
                return 'error';
            }
        }
        $this->clasesAlimentos = $_SESSION['clases_alimentos'];
        $_SESSION['filtros']['nombre_alimento_despensa'] = null;
        $_SESSION['filtros']['id_clase_alimento_despensa'] = null;
        return 'success';
    }

    public function despensa()
    {
        if (! isset($_SESSION['clases_alimentos'])) {
            return 'error';
        }
        if (isset($_GET['v']) and $_GET['v'] == 'todos') {
            $_SESSION['filtros']['nombre_alimento_despensa'] = null;
            $_SESSION['filtros']['id_clase_alimento_despensa'] = null;
        }
        if (isset($_GET['nombre_alimento'])) {
            $_SESSION['filtros']['nombre_alimento_despensa'] = $_GET['nombre_alimento'];
        }
        if (isset($_GET['id_clase_alimento'])) {
            $_SESSION['filtros']['id_clase_alimento_despensa'] = $_GET['id_clase_alimento'];
        }
        if ((isset($_SESSION['filtros']['nombre_alimento_despensa']) and $_SESSION['filtros']['nombre_alimento_despensa']) 
                or (isset($_SESSION['filtros']['id_clase_alimento_despensa']) and ($_SESSION['filtros']['id_clase_alimento_despensa'] 
                or $_SESSION['filtros']['id_clase_alimento_despensa'] === '0'))) {
            $despensa = new Despensa();
            $alimento = new Alimento();
            if ((isset($_SESSION['filtros']['nombre_alimento_despensa']) and $_SESSION['filtros']['nombre_alimento_despensa'])) {
                $alimento->nombre_alimento = $_SESSION['filtros']['nombre_alimento_despensa'];
            }
            if (isset($_SESSION['filtros']['id_clase_alimento_despensa']) and ($_SESSION['filtros']['id_clase_alimento_despensa'] 
                    or $_SESSION['filtros']['id_clase_alimento_despensa'] === '0')) {
                $clase = new AlimentoClase();
                $clase->id_clase_alimento = $_SESSION['filtros']['id_clase_alimento_despensa'];
                $alimento->clase = $clase;
            }
            $despensa->alimento = $alimento;
        } else {
            $despensa = null;
        }
        $this->despensa = $this->despensaService->despensa_usuario($_SESSION['usuario'], $despensa);
        if ($this->despensa === false) {
            $this->error = $this->despensaService->error();
            return 'error';
        }
        return 'success';
    }

    public function alimentos()
    {
        $_SESSION['id_clase_alimento_despensa'] = $_GET['id_clase_alimento'];
        $alimento = new Alimento();
        $claseAlimento = new AlimentoClase($_GET);
        $alimento->clase = $claseAlimento;
        $excludes = array();
        foreach (array_keys($_SESSION['usuario']->despensa()) as $idAlimento) {
            $excludes[] = $idAlimento;
        }
        $this->alimentos = $this->alimentoService->find($alimento, null, null, null, $excludes);
        if ($this->alimentos === false) {
            if ($this->alimentoService->error()) {
                $this->error = $this->alimentoService->error();
            }
            return 'error';
        }
        return 'success';
    }

    public function quit_alimento()
    {
        if (! $_GET['id_alimento']) {
            return 'error';
        }
        if (! isset($_SESSION['usuario']->despensa[$_GET['id_alimento']])) {
            return 'success';
        }
        $id = $_SESSION['usuario']->despensa[$_GET['id_alimento']];
        if ($this->despensaService->removeById($id) === false) {
            return 'error';
        }
        $despensa = new Despensa();
        $despensa->alimento = new Alimento();
        $despensa->alimento->id_alimento = $_GET['id_alimento'];
        $_SESSION['usuario']->despensa($despensa, true);
        
        // Redo the list of dishes that I can cook with my pantry
        $_SESSION['usuario']->platos_puedo_hacer(null);
        return 'success';
    }

    public function add_ingrediente()
    {
        if (! isset($_GET['id_ingrediente']) or ! $_GET['id_ingrediente']) {
            exit();
        }
        $this->ingrediente = $this->ingredienteService->findById($_GET['id_ingrediente']);
        if (! $this->ingrediente) {
            exit();
        }
        $alimento = $this->ingrediente->alimento;
        if (! $alimento) {
            return 'error';
        }
        $art = new Despensa();
        $art->alimento = $alimento;
        if ($_SESSION['usuario']->despensa[$alimento->id_alimento]) {
            return 'success';
        }
        $art->id_despensa = uniqid();
        $art->usuario = $_SESSION['usuario'];
        if ($this->despensaService->save($art) === false) {
            return 'error';
        }
        $_SESSION['usuario']->despensa($art);
        
        // Redo the list of dishes that I can cook with my pantry
        $_SESSION['usuario']->platos_puedo_hacer(null);
        return 'success';
    }

    public function clases_alimentos()
    {
        $this->alimentos = array();
        if (isset($_GET['id_alimento']) and $_GET['id_alimento']) {
            $despensa = new Despensa();
            $alimento = new Alimento();
            $alimento->id_alimento = $_GET['id_alimento'];
            $despensa->alimento = $alimento;
            if (! isset($_SESSION['usuario']->despensa[$_GET['id_alimento']])) {
                return 'error';
            }
            $despensa->id_despensa = $_SESSION['usuario']->despensa[$_GET['id_alimento']];
            $this->alimentos[] = $despensa;
        }
        return 'success';
    }

    public function guardar_alimento()
    {
        if (! isset($_GET['id_alimento']) or ! $_GET['id_alimento']) {
            return 'error';
        }
        $despensa = new Despensa();
        $this->alimento = new Alimento();
        $this->alimento->id_alimento = $_GET['id_alimento'];
        $despensa->alimento = $this->alimento;
        if (isset($_SESSION['usuario']->despensa[$_GET['id_alimento']])) {
            $id = $_SESSION['usuario']->despensa[$_GET['id_alimento']];
            $this->art = $this->despensaService->findById($id);
            if (! $this->art) {
                return 'error';
            }
            $editar = true;
        } else {
            $this->alimento = $this->alimentoService->findById($_GET['id_alimento']);
            if (! $this->alimento) {
                return 'error';
            }
            $despensa->alimento = $this->alimento;
            $this->art = $despensa;
            $this->art->id_despensa = uniqid();
            $editar = false;
        }
        $this->art->usuario = $_SESSION['usuario'];
        if ($this->despensaService->save($this->art, $editar) === false) {
            return 'error';
        }
        $_SESSION['usuario']->despensa($this->art);
        $_SESSION['usuario']->platos_puedo_hacer(null);
        return 'success';
    }
}
