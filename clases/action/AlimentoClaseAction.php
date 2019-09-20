<?php

class AlimentoClaseAction extends Action
{
    protected $alimentoClaseService;
    protected $clasesAlimentos;
    protected $tamColumna;

    public function elegir()
    {
        if (! isset($_GET['act']) or ! $_GET['act']) {
            return 'error';
        }
        if (! isset($_SESSION['clases_alimentos'])) {
            $_SESSION['clases_alimentos'] = $this->alimentoClaseService->findAll(array(
                'nombre_clase_alimento'
            ), 'id_clase_alimento');
            if ($_SESSION['clases_alimentos'] === false) {
                return 'error';
            }
        }
        $this->clasesAlimentos = array();
        foreach ($_SESSION['clases_alimentos'] as $clase) {
            if (! $clase->clase_padre) {
                $this->clasesAlimentos[] = $clase;
            }
        }
        $nClases = count($this->clasesAlimentos);
        if ($nClases >= 5) {
            $this->tamColumna = 20;
        } elseif ($nClases > 0) {
            $this->tamColumna = round(100 / $nClases);
        }
        return 'success';
    }

    public function lista()
    {
        if (! isset($_GET['act']) or ! $_GET['act']) {
            return 'error';
        }
        if (! isset($_SESSION['clases_alimentos'])) {
            $_SESSION['clases_alimentos'] = $this->alimentoClaseService->findAll(array('nombre_clase_alimento'), 'id_clase_alimento');
            if ($_SESSION['clases_alimentos'] === false) {
                return 'error';
            }
        }
        $this->clasesAlimentos = array();
        if (isset($_GET['id_clase_alimento']) and $_GET['id_clase_alimento']) {
            if (! isset($_SESSION['clases_alimentos'][$_GET['id_clase_alimento']])) {
                return 'error';
            }
            foreach ($_SESSION['clases_alimentos'] as $clase) {
                if ($clase->clase_padre and $clase->clase_padre->id_clase_alimento == $_GET['id_clase_alimento']) {
                    $this->clasesAlimentos[] = $clase;
                }
            }
        } else {
            foreach ($_SESSION['clases_alimentos'] as $clase) {
                if (! $clase->clase_padre) {
                    $this->clasesAlimentos[] = $clase;
                }
            }
        }
        $nClases = count($this->clasesAlimentos);
        if ($_SESSION['navegador'] == 'movil') {
            if ($nClases >= 3) {
                $this->tamColumna = 33;
            } elseif ($nClases > 0) {
                $this->tamColumna = round(100 / $nClases);
            }
        } else {
            if ($nClases >= 5) {
                $this->tamColumna = 20;
            } elseif ($nClases > 0) {
                $this->tamColumna = round(100 / $nClases);
            }
        }
        return 'success';
    }
}
