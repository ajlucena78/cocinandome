<?php

class AlimentoAction extends Action
{
    protected $alimentoService;
    protected $usuarioService;
    protected $despensaService;
    protected $listaCompraService;
    protected $alimentos;
    protected $alimento;
    protected $redir;
    protected $action;
    protected $destino;
    protected $funcion;
    protected $art;
    protected $total;

    public function __construct($servicios)
    {
        parent::__construct($servicios);
        if ($_GET['action'] != 'ficha_alimento') {
            if (! isset($_SESSION['usuario']) or ! $this->usuarioService->check_usuario($_SESSION['usuario'], $_SESSION['session_id'])) {
                $this->redirect_to_view('usuario/redirect_to_login.php');
            }
        }
    }

    public function elegir()
    {
        if (! isset($_GET['act']) or ! $_GET['act']) {
            return 'error';
        }
        if ((! isset($_GET['id_clase_alimento']) or (! $_GET['id_clase_alimento'] and $_GET['id_clase_alimento'] !== '0')) 
            and (! isset($_GET['nombre_alimento']) or ! $_GET['nombre_alimento'])) {
            return 'error';
        }
        if (! isset($_SESSION['clases_alimentos'])) {
            return 'error';
        }
        if (isset($_GET['id_clase_alimento']) and ($_GET['id_clase_alimento'] or $_GET['id_clase_alimento'] === '0')) {
            if (! isset($_SESSION['clases_alimentos'][$_GET['id_clase_alimento']])) {
                return 'error';
            }
        }
        $alimento = new Alimento($_GET);
        $claseAlimento = new AlimentoClase($_GET);
        $alimento->clase = $claseAlimento;
        $likes = array();
        if (isset($_GET['nombre_alimento']) and $_GET['nombre_alimento']) {
            if (strlen($_GET['nombre_alimento']) < 3) {
                exit();
            }
            $likes['nombre_alimento'] = true;
        }
        if (isset($_GET['pag']) and ($_GET['pag'] += 0) > 0) {
            $inicio = ($_GET['pag'] - 1) * ALIMENTOS_POPUP;
        } else {
            $inicio = 0;
        }
        $this->alimentos = $this->alimentoService->find($alimento, ALIMENTOS_POPUP, 'nombre_alimento', $likes, null, false, $inicio);
        if ($this->alimentos === false) {
            return 'error';
        }
        $this->total = $this->alimentoService->find($alimento, null, null, $likes, null, true);
        if ($this->total == 1) {
            $_SESSION['get']['id_alimento'] = $this->alimentos[0]->id_alimento;
            if (isset($_GET['dia'])) {
                $_SESSION['get']['dia'] = $_GET['dia'];
            }
            if (isset($_GET['comida'])) {
                $_SESSION['get']['comida'] = $_GET['comida'];
            }
            if (isset($_GET['act']) and $_GET['act']) {
                return $_GET['act'];
            } else {
                return 'elegir_cantidad_alimento_plan';
            }
        }
        return 'success';
    }

    public function ficha()
    {
        if (! isset($_GET['id_alimento']) or ! $_GET['id_alimento']) {
            return 'error';
        }
        $this->alimento = $this->alimentoService->findById($_GET['id_alimento']);
        if (! $this->alimento) {
            return 'error';
        }
        if (! isset($_SESSION['usuario']) or ! $_SESSION['usuario']) {
            return 'publica';
        }
        return 'success';
    }

    public function mueve_despensa_a_lista_compra()
    {
        if (! isset($_GET['id_alimento']) or ! $_GET['id_alimento']) {
            exit();
        }
        if (! isset($_SESSION['usuario']->despensa[$_GET['id_alimento']])) {
            return 'success';
        }
        $id = $_SESSION['usuario']->despensa[$_GET['id_alimento']];
        $despensa = $this->despensaService->findById($id);
        if (! $despensa) {
            return 'success';
        }
        $this->alimento = $despensa->alimento;
        $this->despensaService->inicia_transaccion();
        $this->despensaService->removeById($despensa->id_despensa);
        $art = new ListaCompra();
        $art->alimento = $despensa->alimento;
        if (isset($_SESSION['usuario']->lista_compra[$_GET['id_alimento']])) {
            $id = $_SESSION['usuario']->lista_compra[$_GET['id_alimento']];
            $lista = $this->listaCompraService->findById($id);
            if ($lista === false) {
                return 'error';
            }
            if ($lista) {
                $art->id_lista = $id;
                $editar = true;
            }
        }
        if (! $art->id_lista) {
            $art->id_lista = uniqid();
            $editar = false;
        }
        $art->usuario = $_SESSION['usuario'];
        $id = $this->listaCompraService->save($art, $editar);
        if (! $this->despensaService->cierra_transaccion()) {
            return 'error';
        }
        $_SESSION['usuario']->lista_compra($art);
        $_SESSION['usuario']->despensa($despensa, true);
        return 'success';
    }

    public function mueve_lista_compra_a_despensa()
    {
        if (! isset($_GET['id_alimento']) or ! $_GET['id_alimento']) {
            exit();
        }
        if (! isset($_SESSION['usuario']->lista_compra[$_GET['id_alimento']])) {
            return 'success';
        }
        $id = $_SESSION['usuario']->lista_compra[$_GET['id_alimento']];
        $lista = $this->listaCompraService->findById($id);
        if (! $lista) {
            return 'success';
        }
        $this->alimento = $lista->alimento;
        $this->listaCompraService->inicia_transaccion();
        $this->listaCompraService->removeById($lista->id_lista);
        $art = new Despensa();
        $art->alimento = $lista->alimento;
        if (isset($_SESSION['usuario']->despensa[$art->alimento->id_alimento])) {
            $id = $_SESSION['usuario']->despensa[$art->alimento->id_alimento];
            $despensa = $this->despensaService->findById($id);
            if ($despensa === false) {
                return 'error';
            }
            if ($despensa) {
                $art->id_despensa = $id;
                $editar = true;
            }
        }
        if (! $art->id_despensa) {
            $art->id_despensa = uniqid();
            $editar = false;
        }
        $art->usuario = $_SESSION['usuario'];
        $this->despensaService->save($art, $editar);
        if (! $this->listaCompraService->cierra_transaccion()) {
            return 'error';
        }
        $_SESSION['usuario']->lista_compra($lista);
        $_SESSION['usuario']->despensa($art);
        $_SESSION['usuario']->platos_puedo_hacer(null);
        return 'success';
    }

    public function op()
    {
        if (! isset($_GET['id_alimento']) or ! $_GET['id_alimento']) {
            return 'error';
        }
        $this->alimento = $this->alimentoService->findById($_GET['id_alimento']);
        if (! $this->alimento) {
            return 'error';
        }
        return 'success';
    }

    public function quit_despensa()
    {
        if (! isset($_GET['id_alimento']) or ! $_GET['id_alimento']) {
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

    public function quit_lista_compra()
    {
        if (! isset($_GET['id_alimento']) or ! $_GET['id_alimento']) {
            return 'error';
        }
        $lista = new ListaCompra();
        $this->alimento = new Alimento();
        $this->alimento->id_alimento = $_GET['id_alimento'];
        $lista->alimento = $this->alimento;
        if (! isset($_SESSION['usuario']->lista_compra[$_GET['id_alimento']])) {
            return 'success';
        }
        $id = $_SESSION['usuario']->lista_compra[$_GET['id_alimento']];
        if ($this->listaCompraService->removeById($id) === false) {
            return 'error';
        }
        $_SESSION['usuario']->lista_compra($lista, true);
        return 'success';
    }
}
