<?php

date_default_timezone_set('Europe/Madrid');
require_once 'clases/Config.php';
require_once 'clases/Action.php';
require_once 'clases/Model.php';
require_once 'clases/Service.php';
global $argv;
if (isset($argv[1]) and $argv[1]) {
    $_GET['action'] = $argv[1];
} elseif (! isset($_GET['action']) or ! $_GET['action']) {
    $_GET['action'] = 'index';
}
define('APP_ROOT', Config::app_root() . '/');
include 'requires.php';
include 'conf.php';
session_start();

// Redirige a la version movil si es un navegador de estos
require_once 'clases/util/Movil.php';
if (isset($_SERVER['HTTP_USER_AGENT']) and Movil::es_navegador_movil()) {
    $_SESSION['navegador'] = 'movil';
} else {
    $_SESSION['navegador'] = 'desktop';
}

// Se carga en sesion la configuración si no lo está ya, o bien si se ha cambiado de versión de navegador
if (!isset($_SESSION['config']) or (isset($_SERVER['HTTP_USER_AGENT']) and $_SESSION['HTTP_USER_AGENT'] != $_SERVER['HTTP_USER_AGENT'])) {
    $_SESSION['config'] = new Config();
}
if (! isset($_SESSION['HTTP_USER_AGENT']) or $_SESSION['HTTP_USER_AGENT'] != $_SERVER['HTTP_USER_AGENT']) {
    $_SESSION['HTTP_USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];
}

// Url relativa al proyecto
define('URL_APP', $_SESSION['config']->url_app());

// Url relativa al directorio res
define('URL_RES', URL_APP . 'res/');

// Nombre de la aplicacion
define('APP_NAME', $_SESSION['config']->app_name());

// Conexion a la base de datos
define('DB_URL', '' . $_SESSION['config']->db_url());
define('DB_USERNAME', '' . $_SESSION['config']->db_username());
define('DB_PASSWORD', '' . $_SESSION['config']->db_password());

// Ruta física al directorio de las vistas view
define('PATH_VIEW', $_SESSION['config']->path_view());

// Url relativa al directorio de las vistas view
define('URL_VIEW', $_SESSION['config']->url_view());

// Host del sitio
define('HOST_APP', $_SESSION['config']->host_app());
include 'functions.php';
if (! $actionPackage = $_SESSION['config']->actionPackage($_GET['action'])) {
    
    // Es una permalink de una página
    $_GET['permalink'] = $_GET['action'];
    $_GET['action'] = 'index';
    if (! $actionPackage = $_SESSION['config']->actionPackage($_GET['action'])) {
        exit();
    }
}
if (! $action = $_SESSION['config']->action($actionPackage['class'])) {
    exit();
}
$action = Action::cargaAction($action['class'], $action['services']);
if ($action->error()) {
    echo $action->error();
    exit();
}
define('ACTION', $_GET['action']);
define('PACKAGE', $actionPackage['package']);
$method = $actionPackage['method'];
$view = $action->$method();
if ($view !== null and isset($actionPackage['results'][$view]['ruta']) and $actionPackage['results'][$view]['ruta']) {
    $action->to_view();
    if (file_exists(PATH_VIEW . $actionPackage['results'][$view]['ruta'])) {
        if (isset($actionPackage['results'][$view]['frame']) and $actionPackage['results'][$view]['frame']) {
            $frame = $_SESSION['config']->frame($actionPackage['results'][$view]['frame']);
            if (! isset($frame)) {
                echo 'Error: No se encuentra el marco de vista concreta: ' . $actionPackage['results'][$view]['frame'];
                exit();
            }
            global $FILE_VIEW;
            $FILE_VIEW = PATH_VIEW . $actionPackage['results'][$view]['ruta'];
            echo $FILE_VIEW;
            include PATH_VIEW . $frame;
        } elseif (isset($actionPackage['frame']) and $actionPackage['frame']) {
            $frame = $_SESSION['config']->frame($actionPackage['frame']);
            if (! isset($frame)) {
                echo 'Error: No se encuentra el marco: ' . $actionPackage['frame'];
                exit();
            }
            global $FILE_VIEW;
            $FILE_VIEW = PATH_VIEW . $actionPackage['results'][$view]['ruta'];
            echo $FILE_VIEW;
            include PATH_VIEW . $frame;
        } else {
            include PATH_VIEW . $actionPackage['results'][$view]['ruta'];
        }
    } else {
        $action = link_action($actionPackage['results'][$view]['ruta']);
        if (isset($_SESSION['get']) and is_array($_SESSION['get']) and count($_SESSION['get']) > 0) {
            foreach ($_SESSION['get'] as $var => $valor) {
                $action .= '&' . $var . '=' . $valor;
            }
            $_SESSION['get'] = null;
        }
        header('Location:' . $action);
    }
} elseif ($view and isset($actionPackage[$view])) {
    
    // Se llama directamente a un action concreto con el nombre del resultado devuelto
    header('Location:' . URL_APP . $view);
} elseif (isset($_SESSION['HTTP_REFERER']) and $_SESSION['HTTP_REFERER']) {
    header('Location:' . $_SESSION['HTTP_REFERER']);
    $_SESSION['HTTP_REFERER'] = null;
}
