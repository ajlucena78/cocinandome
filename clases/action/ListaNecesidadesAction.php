<?php

class ListaNecesidadesAction extends Action
{
    protected $usuarioService;
    protected $listaNecesidadesService;
    protected $alimentoClaseService;
    protected $lista;
    protected $clasesAlimentos;

    public function __construct($servicios)
    {
        parent::__construct($servicios);
        if (! isset($_SESSION['usuario']) or ! $this->usuarioService->check_usuario($_SESSION['usuario'], $_SESSION['session_id'])) {
            $this->redirect_to_view('usuario/redirect_to_login.php');
        }
    }

    public function lista()
    {
        if (! isset($_SESSION['clases_alimentos'])) {
            $this->clasesAlimentos = $this->alimentoClaseService->findAll(array(
                'nombre_clase_alimento'
            ), 'id_clase_alimento');
            if ($this->clasesAlimentos === false) {
                return 'error';
            }
            $_SESSION['clases_alimentos'] = $this->clasesAlimentos;
        } else {
            $this->clasesAlimentos = $_SESSION['clases_alimentos'];
        }
        return 'success';
    }

    public function lista_necesidades()
    {
        $plan = $this->usuarioService->plan_usuario($_SESSION['usuario']);
        if ($plan === false) {
            return 'error';
        }
        if ((isset($_GET['nombre_alimento']) and $_GET['nombre_alimento']) or (isset($_GET['id_clase_alimento']) and ($_GET['id_clase_alimento'] 
                or $_GET['id_clase_alimento'] === '0'))) {
            
            // Búsqueda por criterios
            $this->lista = array();
            foreach ($this->listaNecesidadesService->lista_usuario($_SESSION['usuario'], $plan) as $lista) {
                $guardar = true;
                
                // Si viene un nombre hay que buscar si lo contiene
                if (isset($_GET['nombre_alimento']) and $_GET['nombre_alimento'] 
                        and stripos($lista->alimento->nombre_alimento, $_GET['nombre_alimento']) === false) {
                    $guardar = false;
                }
                
                // Si viene la categoría si pertenece a ésta
                if ($guardar and isset($_GET['id_clase_alimento']) and ($_GET['id_clase_alimento'] or $_GET['id_clase_alimento'] === '0') 
                        and $lista->alimento->clase->id_clase_alimento != $_GET['id_clase_alimento']) {
                    $guardar = false;
                }
                if ($guardar) {
                    $this->lista[] = $lista;
                }
            }
        } else {
            $this->lista = $this->listaNecesidadesService->lista_usuario($_SESSION['usuario'], $plan);
        }
        return 'success';
    }

    public function lista_necesidades_grupos()
    {
        if (! isset($_SESSION['clases_alimentos'])) {
            return 'error';
        }
        $plan = $this->usuarioService->plan_usuario($_SESSION['usuario']);
        if ($plan === false) {
            return 'error';
        }
        $this->clasesAlimentos = array();
        foreach ($_SESSION['clases_alimentos'] as $clase) {
            $claseAlimentos = new AlimentoClase();
            foreach ($this->listaNecesidadesService->lista_usuario($_SESSION['usuario'], $plan) as $lista) {
                if ($lista->alimento->clase->id_clase_alimento == $clase->id_clase_alimento) {
                    $claseAlimentos->alimento($lista);
                }
            }
            if ($claseAlimentos->alimentos) {
                $claseAlimentos->id_clase_alimento = $clase->id_clase_alimento;
                $claseAlimentos->nombre_clase_alimento = $clase->nombre_clase_alimento;
                $this->clasesAlimentos[] = $claseAlimentos;
            }
        }
        return 'success';
    }
}
