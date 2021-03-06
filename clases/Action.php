<?php

abstract class Action
{
    protected $id;
    protected $error;

    public function __construct($services = array())
    {
        if (is_array($services) and count($services) > 0) {
            foreach ($services as $propService => $service) {
                if ($service->error()) {
                    $this->error = $service->error();
                    break;
                }
                $this->$propService = $service;
            }
        }
    }

    public function __get($atributo)
    {
        return $this->$atributo;
    }

    public function __set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }

    public function to_view()
    {
        $propiedades = array_keys(get_class_vars(get_class($this)));
        foreach ($propiedades as $propiedad) {
            if ($propiedad == 'id' or substr($propiedad, (strlen($propiedad) - 7)) == 'Service') {
                continue;
            }
            global $$propiedad;
            $$propiedad = $this->$propiedad;
        }
    }

    public static function cargaAction($action, $services = array(), $actionPadre = null)
    {
        require_once 'clases/action/' . $action . '.php';
        foreach ($services as $service) {
            require_once ('clases/service/' . ucfirst($service) . '.php');
        }
        $args = array();
        foreach ($services as $service) {
            if (! $service) {
                continue;
            }
            $args[$service] = new $service();
        }
        $actionObj = new $action($args);
        if (! $actionPadre) {
            $actionPadre = get_parent_class($actionObj);
        } else {
            $actionPadre = get_parent_class(new $actionPadre());
        }
        if ($actionPadre != 'Action') {
            if ($actionPadreDatos = $_SESSION['config']->action_by_class(get_parent_class($actionObj))) {
                foreach ($actionPadreDatos['services'] as $service) {
                    if (array_search($service, $services) === false) {
                        $services[] = $service;
                    }
                }
                $actionObj = Action::cargaAction($action, $services, $actionPadre);
            }
        }
        return $actionObj;
    }

    protected function redirect_to_action($action)
    {
        header('Location:' . link_action($action));
        exit();
    }

    protected function redirect_to_view($view)
    {
        $this->to_view();
        include './view/' . $view;
        exit();
    }

    protected function redirect_to_url($url)
    {
        header('Location:' . $url);
        exit();
    }

    public function id()
    {
        return $this->id;
    }

    public function _id($id)
    {
        $this->id = $id;
    }

    public function error()
    {
        return $this->error;
    }
}