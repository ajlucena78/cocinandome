<?php
	class ListaCompraAction extends Action
	{
		protected $listaCompraService;
		protected $alimentoService;
		protected $ingredienteService;
		protected $alimentoClaseService;
		protected $lista;
		protected $ingrediente;
		protected $clasesAlimentos;
		protected $alimentos;
		protected $art;
		protected $alimento;
		
		public function __construct($servicios)
		{
			parent::__construct($servicios);
			if (!isset($_SESSION['usuario']) or !$this->usuarioService->check_usuario($_SESSION['usuario']
					, $_SESSION['session_id']))
			{
				$this->redirect_to_view('usuario/redirect_to_login.php');
			}
		}
		
		public function mostrar()
		{
			if (!isset($_SESSION['clases_alimentos']))
			{
				$_SESSION['clases_alimentos'] = $this->alimentoClaseService->findAll(
						array('nombre_clase_alimento'), 'id_clase_alimento');
				if ($_SESSION['clases_alimentos'] === false)
				{
					return 'error';
				}
			}
			$this->clasesAlimentos = $_SESSION['clases_alimentos'];
			$_SESSION['filtros']['nombre_alimento_listaCompra'] = null;
			$_SESSION['filtros']['id_clase_alimento_listaCompra'] = null;
			return 'success';
		}
		
		public function lista_compra()
		{
			if (!isset($_SESSION['clases_alimentos']))
			{
				$_SESSION['clases_alimentos'] = $this->alimentoClaseService->findAll(
						array('nombre_clase_alimento'), 'id_clase_alimento');
				if ($_SESSION['clases_alimentos'] === false)
				{
					return 'error';
				}
			}
			if (isset($_GET['v']) and $_GET['v'] == 'todos')
			{
				$_SESSION['filtros']['nombre_alimento_listaCompra'] = null;
				$_SESSION['filtros']['id_clase_alimento_listaCompra'] = null;
			}
			if (isset($_GET['nombre_alimento']))
			{
				$_SESSION['filtros']['nombre_alimento_listaCompra'] = $_GET['nombre_alimento'];
			}
			if (isset($_GET['id_clase_alimento']))
			{
				$_SESSION['filtros']['id_clase_alimento_listaCompra'] = $_GET['id_clase_alimento'];
			}
			if ((isset($_SESSION['filtros']['nombre_alimento_listaCompra']) 
					and $_SESSION['filtros']['nombre_alimento_listaCompra']) 
					or (isset($_SESSION['filtros']['id_clase_alimento_listaCompra']) 
					and ($_SESSION['filtros']['id_clase_alimento_listaCompra'] 
					or $_SESSION['filtros']['id_clase_alimento_listaCompra'] === '0')))
			{
				$listaCompra = new ListaCompra();
				$alimento = new Alimento();
				if ((isset($_SESSION['filtros']['nombre_alimento_listaCompra']) 
						and $_SESSION['filtros']['nombre_alimento_listaCompra']))
				{
					$alimento->nombre_alimento = $_SESSION['filtros']['nombre_alimento_listaCompra'];
				}
				if (isset($_SESSION['filtros']['id_clase_alimento_listaCompra']) 
						and ($_SESSION['filtros']['id_clase_alimento_listaCompra'] 
						or $_SESSION['filtros']['id_clase_alimento_listaCompra'] === '0'))
				{
					$clase = new AlimentoClase();
					$clase->id_clase_alimento = $_SESSION['filtros']['id_clase_alimento_listaCompra'];
					$alimento->clase = $clase;
				}
				$listaCompra->alimento = $alimento;
			}
			else
			{
				$listaCompra = null;
			}
			$this->lista = $this->listaCompraService->lista_compra_usuario($_SESSION['usuario'], $listaCompra);
			if ($this->lista === false)
			{
				$this->error = $this->listaCompraService->error();
				return 'error';
			}
			return 'success';
		}
		
		public function guardar_alimento()
		{
			if (!isset($_GET['id_alimento']) or !$_GET['id_alimento'])
			{
				return 'error';
			}
			$listaCompra = new ListaCompra();
			$this->alimento = new Alimento();
			$this->alimento->id_alimento = $_GET['id_alimento'];
			$listaCompra->alimento = $this->alimento;
			if (isset($_SESSION['usuario']->lista_compra[$_GET['id_alimento']]))
			{
				$id = $_SESSION['usuario']->lista_compra[$_GET['id_alimento']];
				$this->art = $this->listaCompraService->findById($id);
				if (!$this->art)
				{
					return 'error';
				}
				$editar = true;
			}
			else
			{
				$this->alimento = $this->alimentoService->findById($_GET['id_alimento']);
				if (!$this->alimento)
				{
					return 'error';
				}
				$listaCompra->alimento = $this->alimento;
				$this->art = $listaCompra;
				$this->art->id_lista = uniqid();
				$editar = false;
			}
			$this->art->usuario = $_SESSION['usuario'];
			if ($this->listaCompraService->save($this->art, $editar) === false)
			{
				return 'error';
			}
			$_SESSION['usuario']->lista_compra($this->art);
			return 'success';
		}
		
		public function quit_alimento()
		{
			if (!isset($_GET['id_alimento']) or !$_GET['id_alimento'])
			{
				return 'error';
			}
			if (!isset($_SESSION['usuario']->lista_compra[$_GET['id_alimento']]))
			{
				return 'success';
			}
			$id = $_SESSION['usuario']->lista_compra[$_GET['id_alimento']];
			if ($this->listaCompraService->removeById($id) === false)
			{
				return 'error';
			}
			$lista = new ListaCompra();
			$lista->alimento = new Alimento();
			$lista->alimento->id_alimento = $_GET['id_alimento'];
			$_SESSION['usuario']->lista-compra($lista, true);
			return 'success';
		}
		
		public function clases_alimentos()
		{
			$this->alimentos = array();
			if (isset($_GET['id_alimento']) and $_GET['id_alimento'])
			{
				$alimento = new Alimento();
				$alimento->id_alimento = $_GET['id_alimento'];
				if (!isset($_SESSION['usuario']->lista_compra[$_GET['id_alimento']]))
				{
					return 'error';
				}
				$id = $_SESSION['usuario']->lista_compra[$_GET['id_alimento']];
				$alimento = $this->alimentoService->findById($id);
				if (!$alimento)
				{
					return 'error';
				}
				$this->alimentos[] = $alimento;
			}
			return 'success';
		}
		
		public function add_ingrediente()
		{
			if (!isset($_GET['id_ingrediente']) or !$_GET['id_ingrediente'])
			{
				exit();
			}
			$this->ingrediente = $this->ingredienteService->findById($_GET['id_ingrediente']);
			if (!$this->ingrediente)
			{
				exit();
			}
			$alimento = $this->ingrediente->alimento;
			if (!$alimento)
			{
				return 'error';
			}
			$art = new ListaCompra();
			$art->alimento = $alimento;
			if (isset($_SESSION['usuario']->lista_compra[$art->alimento->id_alimento]))
			{
				return 'success';
			}
			$art->id_lista = uniqid();
			$art->usuario = $_SESSION['usuario'];
			if ($this->listaCompraService->save($art) === false)
			{
				return 'error';
			}
			$_SESSION['usuario']->lista_compra($art);
			return 'success';
		}
	}