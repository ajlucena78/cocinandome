<?php
	require_once APP_ROOT . 'clases/model/PlanUsuario.php';
	
	class PlanSemanalAction extends Action
	{
		private $MAX_PLANES_COMIDA = 10;
		protected $planSemanalService;
		protected $alimentoService;
		protected $usuarioService;
		protected $platoService;
		protected $categoriaPlatoService;
		protected $actividadUsuarioService;
		protected $plan;
		protected $planes;
		protected $art;
		protected $action;
		protected $destino;
		protected $funcion;
		protected $redir;
		protected $alimento;
		protected $dia;
		protected $comida;
		protected $diaMostrar;
		protected $categorias;
		protected $categoria;
		protected $platos;
		protected $verMas;
		protected $hayPlanes;
		protected $tamColumna;
		protected $comidas;
		protected $usuario;
		
		public function __construct($servicios)
		{
			parent::__construct($servicios);
			if (!isset($_SESSION['usuario']) or !$this->usuarioService->check_usuario($_SESSION['usuario']
					, $_SESSION['session_id']))
			{
				$this->redirect_to_view('usuario/redirect_to_login.php');
			}
		}
		
		public function mostrar_plan()
		{
			if (isset($_GET['id_usuario']) and $_GET['id_usuario'])
			{
				//mostrar el plan de un amigo o plan público
				$this->usuario = $this->usuarioService->findById($_GET['id_usuario']);
				if (!$this->usuario)
				{
					return 'error';
				}
				if (!$this->usuario->plan_publico)
				{
					return 'plan-privado';
				}
				if ($this->usuario->plan_publico == 1)
				{
					if (!$this->usuario->es_amigo())
					{
						return 'plan-privado';
					}
				}
				$_SESSION['filtros']['id_usuario_plan'] = $this->usuario->id_usuario;
				$_SESSION['criterios']['dia_plan_mostrado'] = null;
				$_SESSION['criterios']['comida_plan_mostrado'] = null;
			}
			elseif (isset($_SESSION['filtros']['id_usuario_plan']))
			{
				$_SESSION['filtros']['id_usuario_plan'] = null;
			}
			$this->plan = new PlanSemanal();
			if (isset($_GET['dia']) and $_GET['dia'] >= 1 and $_GET['dia'] <= 7)
			{
				$this->plan->dia = $_GET['dia'];
			}
			else
			{
				$this->plan->dia = date('w');
			}
			if (isset($_GET['comida']) and $_GET['comida'] >= 1 and $_GET['comida'] <= 4)
			{
				$this->plan->comida = $_GET['comida'];
			}
			return 'success';
		}
		
		public function plan()
		{
			$this->plan = new PlanSemanal();
			if (count($_SESSION['usuario']->plan) == 0)
			{
				$this->planes = array();
				$this->hayPlanes = false;
			}
			else
			{
				$this->planes = $this->usuarioService->plan_usuario($_SESSION['usuario']);
				if ($this->planes === false)
				{
					return 'error';
				}
				$this->hayPlanes = true;
			}
			$this->diaMostrar = array();
			$this->planSemanalService->rellena_plan($this->planes, null, $this->diaMostrar);
			$_SESSION['criterios']['dia_plan_mostrado'] = null;
			$_SESSION['criterios']['comida_plan_mostrado'] = null;
			return 'success';
		}
		
		public function dia()
		{
			if (!isset($_GET['dia']) or !$_GET['dia'] or $_GET['dia'] < 1 or $_GET['dia'] > 7)
			{
				if (isset($_SESSION['dia_plan']) and ($_SESSION['dia_plan'] >= 1 or $_SESSION['dia_plan'] <= 7))
				{
					$_GET['dia'] = $_SESSION['dia_plan'];
				}
				else
				{
					return 'error';
				}
			}
			else
			{
				$_SESSION['dia_plan'] = $_GET['dia'];
			}
			$this->plan = new PlanSemanal();
			$this->plan->dia = $_SESSION['dia_plan'];
			if (isset($_SESSION['filtros']['id_usuario_plan']) and $_SESSION['filtros']['id_usuario_plan'])
			{
				$usuario = $this->usuarioService->findById($_SESSION['filtros']['id_usuario_plan']);
				if (!$usuario)
				{
					return 'error';
				}
				$this->usuario = $usuario;
			}
			else
			{
				$usuario = $_SESSION['usuario'];
			}
			if (count($usuario->plan) == 0)
			{
				$this->planes = array();
				$this->hayPlanes = false;
			}
			else
			{
				$this->planes = $this->usuarioService->plan_usuario($usuario, $this->plan);
				if ($this->planes === false)
				{
					return 'error';
				}
				if (count($this->planes) == 0)
				{
					$this->hayPlanes = false;
				}
				else
				{
					$this->hayPlanes = true;
				}
			}
			$this->diaMostrar = array();
			$this->planSemanalService->rellena_plan($this->planes, $_GET['dia'], $this->diaMostrar);
			$_SESSION['criterios']['dia_plan_mostrado'] = $_GET['dia'];
			$_SESSION['criterios']['comida_plan_mostrado'] = null;
			return 'success';
		}
		
		public function comida()
		{
			if (!isset($_GET['dia']) or !$_GET['dia'] or $_GET['dia'] < 1 or $_GET['dia'] > 7)
			{
				if (isset($_SESSION['dia_plan']) and ($_SESSION['dia_plan'] >= 1 or $_SESSION['dia_plan'] <= 7))
				{
					$_GET['dia'] = $_SESSION['dia_plan'];
				}
				else
				{
					return 'error';
				}
			}
			else
			{
				$_SESSION['dia_plan'] = $_GET['dia'];
			}
			if (!isset($_GET['comida']) or !$_GET['comida'] or $_GET['comida'] < 1 or $_GET['comida'] > 4)
			{
				if (isset($_SESSION['comida_plan']) and ($_SESSION['comida_plan'] >= 1 
						or $_SESSION['comida_plan'] <= 4))
				{
					$_GET['comida'] = $_SESSION['comida_plan'];
				}
				else
				{
					return 'error';
				}
			}
			$_SESSION['comida_plan'] = $_GET['comida'];
			$this->plan = new PlanSemanal();
			$this->plan->dia = $_SESSION['dia_plan'];
			$this->plan->comida = $_SESSION['comida_plan'];
			$this->plan->dia = $_SESSION['dia_plan'];
			if (isset($_SESSION['filtros']['id_usuario_plan']) and $_SESSION['filtros']['id_usuario_plan'])
			{
				$usuario = $this->usuarioService->findById($_SESSION['filtros']['id_usuario_plan']);
				if (!$usuario)
				{
					return 'error';
				}
				$this->usuario = $usuario;
			}
			else
			{
				$usuario = $_SESSION['usuario'];
			}
			if (count($usuario->plan) == 0)
			{
				$this->planes = array();
				$this->hayPlanes = false;
			}
			else
			{
				$this->planes = $this->usuarioService->plan_usuario($usuario, $this->plan);
				if ($this->planes === false)
				{
					return 'error';
				}
				if (count($this->planes) == 0)
				{
					$this->hayPlanes = false;
				}
				else
				{
					$this->hayPlanes = true;
				}
			}
			$_SESSION['criterios']['dia_plan_mostrado'] = $_GET['dia'];
			$_SESSION['criterios']['comida_plan_mostrado'] = $_GET['comida'];
			$this->diaMostrar = array($_GET['dia'] => true);
			return 'success';
		}
		
		public function clases_alimentos()
		{
			if (!isset($_GET['dia']) or !$_GET['dia'])
			{
				return 'error';
			}
			if (!isset($_GET['comida']) or !$_GET['comida'])
			{
				return 'error';
			}
			$_SESSION['dia_plan'] = $_GET['dia'];
			$_SESSION['comida_plan'] = $_GET['comida'];
			if (isset($_GET['r']))
			{
				if ($_GET['r'] == 'dia' or $_GET['r'] == 'comida')
				{
					$_SESSION['r'] = $_GET['r'];
				}
			}
			return 'success';
		}
		
		public function quit_art()
		{
			if (!isset($_GET['id_plan']) or !$_GET['id_plan'])
			{
				return 'error';
			}
			$plan = new PlanSemanal($_GET);
			if (!$_SESSION['usuario']->get_plan($plan))
			{
				return 'success';
			}
			$plan = $this->planSemanalService->findById($_GET['id_plan']);
			if ($plan === false)
			{
				return 'error';
			}
			if ($plan and $this->planSemanalService->removeById($plan->id_plan) === false)
			{
				return 'error';
			}
			$_SESSION['usuario']->set_plan($plan, true);
			return 'success';
		}
		
		public function elegir_cantidad_alimento()
		{
			if (!isset($_GET['id_alimento']) or !$_GET['id_alimento'])
			{
				return 'error';
			}
			if (!isset($_GET['dia']) or !$_GET['dia'] or $_GET['dia'] < 1 or $_GET['dia'] > 7)
			{
				return 'error';
			}
			if (!isset($_GET['comida']) or !$_GET['comida'] or $_GET['comida'] < 1 or $_GET['comida'] > 4)
			{
				return 'error';
			}
			$plan = new PlanSemanal();
			$plan->dia = $_GET['dia'];
			$plan->comida = $_GET['comida'];
			$plan->usuario = $_SESSION['usuario'];
			$alimento = new Alimento();
			$alimento->id_alimento = $_GET['id_alimento'];
			$plan->alimento = $alimento;
			$this->art = $this->planSemanalService->find($plan);
			if ($this->art === false)
			{
				return 'error';
			}
			if ($this->art)
			{
				$this->art = $this->art[0];
			}
			else
			{
				$alimento = $this->alimentoService->findById($_GET['id_alimento']);
				if (!$alimento)
				{
					return 'error';
				}
				$plan->alimento = $alimento;
				$this->art = $plan;
			}
			$this->action = 'guardar_alimento_plan';
			if (isset($_GET['destino']) and $_GET['destino'])
			{
				$this->destino = trim($_GET['destino']);
			}
			else
			{
				$this->destino = 'plan_' . $_GET['dia'] . '_' . $_GET['comida'];
			}
			if (isset($_GET['r']) and $_GET['r'])
			{
				$this->redir = $_GET['r'];
			}
			$this->funcion = 'ver_plan(' . $_GET['dia'] . ', ' . $_GET['comida'] 
					. '); actualiza_info_nutricional_plan(); quitar_popup();';
			return 'success';
		}
		
		public function guardar_alimento()
		{
			if (!isset($_POST['id_alimento']) or !$_POST['id_alimento'])
			{
				return 'error';
			}
			if (!isset($_POST['dia']) or !$_POST['dia'] or $_POST['dia'] < 1 or $_POST['dia'] > 7)
			{
				return 'error';
			}
			if (!isset($_POST['comida']) or !$_POST['comida'] or $_POST['comida'] < 1 or $_POST['comida'] > 4)
			{
				return 'error';
			}
			$plan = new PlanSemanal();
			$plan->dia = $_POST['dia'];
			$plan->comida = $_POST['comida'];
			if (count($_SESSION['usuario']->get_plan($plan)) > $this->MAX_PLANES_COMIDA)
			{
				$this->error = 'En esta comida no puedes añadir más alimentos ni recetas';
				return 'error';
			}
			$this->alimento = new Alimento();
			$this->alimento->id_alimento = $_POST['id_alimento'];
			$plan->alimento = $this->alimento;
			$plan->usuario = $_SESSION['usuario'];
			$this->art = $this->planSemanalService->find($plan);
			if ($this->art === false)
			{
				return 'error';
			}
			if ($this->art)
			{
				$this->art = $this->art[0];
				$editar = true;	
			}
			else
			{
				$this->alimento = $this->alimentoService->findById($_POST['id_alimento']);
				if (!$this->alimento)
				{
					return 'error';
				}
				$plan->alimento = $this->alimento;
				$this->art = $plan;
				$this->art->id_plan = uniqid();
				$editar = false;
			}
			if (($_POST['cantidad'] += 0) and $_POST['cantidad'] < 0)
			{
				$this->error = 'Es necesario indicar la cantidad correctamente';
				return 'error';
			}
			$this->art->usuario = $_SESSION['usuario'];
			$this->art->cantidad = $_POST['cantidad'];
			$this->art->tipo_cantidad = $_POST['tipo_cantidad'] + 0;
			$this->art->dia = $_POST['dia'];
			$this->art->comida = $_POST['comida'];
			if ($this->planSemanalService->save($this->art, $editar) === false)
			{
				return 'error';
			}
			$_SESSION['usuario']->set_plan($this->art);
			if (!$editar)
			{
				$plan = new PlanSemanal();
				$plan->dia = $_POST['dia'];
				$plan->comida = $_POST['comida'];
				$this->planes = $this->usuarioService->plan_usuario($_SESSION['usuario'], $plan);
				if ($this->planes === false)
				{
					return 'error';
				}
			}
			$this->dia = $_POST['dia'];
			$this->comida = $_POST['comida'];
			if (isset($_GET['r']) and $_GET['r'])
			{
				return $_GET['r'];
			}
			return 'success';
		}
		
		public function elegir_dia()
		{
			if (!isset($_GET['id_alimento']) and !isset($_GET['id_receta']))
			{
				if (isset($_SESSION['criterios']['dia_plan_mostrado']) 
						and $_SESSION['criterios']['dia_plan_mostrado'])
				{
					if (isset($_GET['tipo']) and $_GET['tipo'])
					{
						$_SESSION['get']['tipo'] = $_GET['tipo'];
					}
					if (isset($_GET['donde']) and $_GET['donde'])
					{
						$_SESSION['get']['donde'] = $_GET['donde'];
					}
					return 'elegir_comida';
				}
			}
			if (!isset($_GET['id_alimento']))
			{
				$_GET['id_alimento'] = null;
			}
			if (!isset($_GET['id_receta']))
			{
				$_GET['id_receta'] = null;
			}
			if (!isset($_GET['tipo']))
			{
				$_GET['tipo'] = null;
			}
			if (!isset($_GET['donde']))
			{
				$_GET['donde'] = null;
			}
			$this->plan = new PlanSemanal();
			return 'success';
		}
		
		public function elegir_comida()
		{
			$this->plan = new PlanSemanal();
			if (!isset($_GET['id_alimento']) and !isset($_GET['id_receta']))
			{
				if (isset($_SESSION['criterios']['dia_plan_mostrado']))
				{
					$_GET['dia'] = $_SESSION['criterios']['dia_plan_mostrado'];
					if (isset($_SESSION['criterios']['comida_plan_mostrado']) 
							and $_SESSION['criterios']['comida_plan_mostrado'])
					{
						$plan = new PlanSemanal();
						$plan->dia = $_GET['dia'];
						$plan->comida = $_SESSION['criterios']['comida_plan_mostrado'];
						if (count($_SESSION['usuario']->plan($plan)) > $this->MAX_PLANES_COMIDA)
						{
							$this->error = 'En esta comida no puedes añadir más alimentos ni recetas';
							return 'error';
						}
						$_SESSION['get']['dia'] = $_GET['dia'];
						$_SESSION['get']['comida'] = $_SESSION['criterios']['comida_plan_mostrado'];
						if (isset($_GET['donde']) and $_GET['donde'])
						{
							$_SESSION['get']['donde'] = $_GET['donde'];
						}
						if (isset($_GET['tipo']) and $_GET['tipo'] == 'receta')
						{
							return 'elegir_categoria_platos_plan';
						}
						$_SESSION['get']['act'] = 'elegir_cantidad_alimento_plan';
						return 'elegir_clases_alimentos';
					}
				}
			}
			if (!isset($_GET['id_alimento']))
			{
				$_GET['id_alimento'] = null;
			}
			if (!isset($_GET['id_receta']))
			{
				$_GET['id_receta'] = null;
			}
			if (!isset($_GET['donde']))
			{
				$_GET['donde'] = null;
			}
			$this->comidas = array();
			for ($comida = 1; $comida <= 4; $comida++)
			{
				$plan = new PlanSemanal();
				$plan->dia = $_GET['dia'];
				$plan->comida = $comida;
				if (count($_SESSION['usuario']->get_plan($plan)) > $this->MAX_PLANES_COMIDA)
				{
					$this->comidas[$comida] = true;
				}
			}
			return 'success';
		}
		
		public function elegir_receta()
		{
			if (!isset($_GET['id_receta']) or !$_GET['id_receta'])
			{
				return 'error';
			}
			if (!isset($_GET['dia']) or !$_GET['dia'] or $_GET['dia'] < 1 or $_GET['dia'] > 7)
			{
				return 'error';
			}
			if (!isset($_GET['comida']) or !$_GET['comida'] or $_GET['comida'] < 1 or $_GET['comida'] > 4)
			{
				return 'error';
			}
			$plan = new PlanSemanal();
			$receta = new Plato();
			$receta->id_plato = $_GET['id_receta'];
			$plan->plato = $receta;
			$plan->dia = $_GET['dia'];
			$plan->comida = $_GET['comida'];
			$plan->usuario = $_SESSION['usuario'];
			$this->art = $this->planSemanalService->find($plan);
			if ($this->art === false)
			{
				return 'error';
			}
			if ($this->art)
			{
				return 'ya-existe';
			}
			else
			{
				$receta = $this->platoService->findById($_GET['id_receta']);
				if (!$receta)
				{
					return 'error';
				}
				$plan->plato = $receta;
				$this->art = $plan;
			}
			if (isset($_GET['destino']) and $_GET['destino'])
			{
				$this->destino = trim($_GET['destino']);
			}
			else
			{
				$this->destino = 'plan_' . $_GET['dia'] . '_' . $_GET['comida'];
			}
			if (isset($_GET['r']) and $_GET['r'])
			{
				$this->redir = $_GET['r'];
			}
			if (isset($_GET['donde']) and $_GET['donde'] == 'plan')
			{
				$this->funcion = 'ver_plan(' . $_GET['dia'] . ', ' . $_GET['comida'] 
						. '); actualiza_info_nutricional_plan(); quitar_popup();';
			}
			return 'success';
		}
		
		public function guardar_receta()
		{
			if (!isset($_POST['id_receta']) or !$_POST['id_receta'])
			{
				return 'error';
			}
			if (!isset($_POST['dia']) or !$_POST['dia'] or $_POST['dia'] < 1 or $_POST['dia'] > 7)
			{
				return 'error';
			}
			if (!isset($_POST['comida']) or !$_POST['comida'] or $_POST['comida'] < 1 or $_POST['comida'] > 4)
			{
				return 'error';
			}
			$plan = new PlanSemanal();
			$receta = new Plato();
			$receta->id_plato = $_POST['id_receta'];
			$plan->plato = $receta;
			$plan->dia = $_POST['dia'];
			$plan->comida = $_POST['comida'];
			if (count($_SESSION['usuario']->get_plan($plan)) > $this->MAX_PLANES_COMIDA)
			{
				$this->error = 'En esta comida no puedes añadir más alimentos ni recetas';
				return 'error';
			}
			$plan->usuario = $_SESSION['usuario'];
			$this->art = $this->planSemanalService->find($plan);
			if ($this->art === false)
			{
				return 'error';
			}
			if ($this->art)
			{
				return 'ya-existe';
			}
			else
			{
				$receta = $this->platoService->findById($_POST['id_receta']);
				if (!$receta)
				{
					return 'error';
				}
				$plan->plato = $receta;
				$this->art = $plan;
				$this->art->id_plan = uniqid();
			}
			$this->art->usuario = $_SESSION['usuario'];
			$this->art->dia = $_POST['dia'];
			$this->art->comida = $_POST['comida'];
			if ($this->planSemanalService->save($this->art) === false)
			{
				return 'error';
			}
			$_SESSION['usuario']->set_plan($this->art);
			$plan = new PlanSemanal();
			$plan->dia = $_POST['dia'];
			$plan->comida = $_POST['comida'];
			$this->planes = $this->usuarioService->plan_usuario($_SESSION['usuario'], $plan);
			if ($this->planes === false)
			{
				return 'error';
			}
			$this->dia = $_POST['dia'];
			$this->comida = $_POST['comida'];
			if (isset($_GET['r']) and $_GET['r'])
			{
				return $_GET['r'];
			}
			return 'success';
		}
		
		public function info_nutricional()
		{
			$planUsuario = new PlanUsuario();
			$plan = new PlanSemanal();
			if (isset($_SESSION['criterios']['dia_plan_mostrado']) 
					and $_SESSION['criterios']['dia_plan_mostrado'])
			{
				$plan->dia = $_SESSION['criterios']['dia_plan_mostrado'];
			}
			if (isset($_SESSION['criterios']['comida_plan_mostrado']) 
					and $_SESSION['criterios']['comida_plan_mostrado'])
			{
				$plan->comida = $_SESSION['criterios']['comida_plan_mostrado'];
			}
			if (isset($_SESSION['filtros']['id_usuario_plan']) and $_SESSION['filtros']['id_usuario_plan'])
			{
				$usuario = $this->usuarioService->findById($_SESSION['filtros']['id_usuario_plan']);
				if (!$usuario)
				{
					return 'error';
				}
				$this->usuario = $usuario;
			}
			else
			{
				$usuario = $_SESSION['usuario'];
			}
			$plan = $this->usuarioService->plan_usuario($usuario, $plan);
			if ($plan === false)
			{
				return 'error';
			}
			$planUsuario->planes = $plan;
			$this->alimento = $planUsuario;
			return 'success';
		}
		
		public function elegir_categoria_platos()
		{
			if (!isset($_SESSION['categorias_alimentos']))
			{
				$_SESSION['categorias_alimentos'] = $this->categoriaPlatoService->findAll(
						array('nombre_categoria'), 'id_categoria');
				if ($_SESSION['categorias_alimentos'] === false)
				{
					return 'error';
				}
			}
			$this->categorias = $_SESSION['categorias_alimentos'];
			return 'success';
		}
		
		public function elegir_recetas()
		{
			if ((!isset($_GET['id_categoria']) or !$_GET['id_categoria']) and (!isset($_GET['nombre_plato']) 
					or !$_GET['nombre_plato']))
			{
				return 'error';
			}
			$plato = new Plato();
			if (isset($_GET['id_categoria']))
			{
				if (!isset($_SESSION['categorias_alimentos']))
				{
					$_SESSION['categorias_alimentos'] = $this->categoriaPlatoService->findAll(
							array('nombre_categoria'), 'id_categoria');
					if ($_SESSION['categorias_alimentos'] === false)
					{
						return 'error';
					}
				}
				if (!$_SESSION['categorias_alimentos'][$_GET['id_categoria']])
				{
					return 'error';
				}
				$this->categoria = $_SESSION['categorias_alimentos'][$_GET['id_categoria']];
				$plato->categoria = new CategoriaPlato($_GET);
			}
			if (isset($_GET['nombre_plato']) and strlen($_GET['nombre_plato']) >= 3)
			{
				$plato->nombre_plato = $_GET['nombre_plato'];
			}
			$total = $this->platoService->total_platos_para_usuario($_SESSION['usuario'], $plato);
			if ($total === false)
			{
				return 'error';
			}
			if (!$total)
			{
				return 'sin-resultados';
			}
			if ($total > 12)
			{
				$pos = rand(0, $total - 12);
			}
			else
			{
				$pos = 0;
			}
			$this->platos = $this->platoService->platos_para_usuario($_SESSION['usuario'], 12, $pos, $plato);
			if ($this->platos === false)
			{
				return 'error';
			}
			$nPlatos = count($this->platos);
			if ($nPlatos == 1)
			{
				$_SESSION['get']['id_receta'] = $this->platos[0]->id_plato;
				$_SESSION['get']['dia'] = $_GET['dia'];
				$_SESSION['get']['comida'] = $_GET['comida'];
				return 'elegir_receta';
			}
			if ($nPlatos >= 4)
				$this->tamColumna = 25;
			else
				$this->tamColumna = round(100 / $nPlatos);
			if ($total > 12)
				$this->verMas = true;
			return 'success';
		}
		
		public function publicidad()
		{
			return 'success';
		}
		
		public function publicar()
		{
			if (!isset($_POST['publico']) or $_POST['publico'] < 0 or $_POST['publico'] > 2)
			{
				return 'error';
			}
			if ($_SESSION['usuario']->plan_publico == $_POST['publico'])
			{
				return 'success';
			}
			$_SESSION['usuario']->plan_publico = $_POST['publico'];
			$this->usuarioService->inicia_transaccion();
			if (!$this->usuarioService->publica_plan($_SESSION['usuario']))
			{
				return 'error';
			}
			if ($_POST['publico'] != 0)
			{
				$actividadUsuario = new ActividadUsuario();
				$actividadUsuario->tipo = 5;
				$actividadUsuario->usuario = $_SESSION['usuario'];
				if (!$this->actividadUsuarioService->find($actividadUsuario))
				{
					$actividadUsuario->fecha = date('Y-m-d H:i:s');
					$actividadUsuario->id_actividad = uniqid();
					if (!$this->actividadUsuarioService->save($actividadUsuario))
					{
						return 'error';
					}
				}
			}
			if (!$this->usuarioService->cierra_transaccion())
			{
				return 'error';
			}
			return 'success';
		}
	}