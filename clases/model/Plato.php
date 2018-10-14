<?php
	class Plato extends Model
	{
		protected $id_plato;
		protected $nombre_plato;
		protected $preparacion;
		protected $tiempo_preparacion;
		protected $comensales;
		protected $foto;
		protected $video;
		protected $categoria;
		protected $ingredientes;
		protected $usuario;
		protected $comentarios;
		protected $publico;
		protected $me_mola;
		protected $vegetariano;
		protected $celiaco;
		private $alimento;	//usado para las búsquedas
		
		public function __construct($datos = null)
		{
			parent::__construct($datos);
			$this->pk['id_plato'] = 'manual';
			//$this->fk['categoria'] = array('CategoriaPlato', 'id_categoria', 'id_categoria', false, 'ManyToOne', 'id_plato');
			$this->fk['categoria'] = new FK('CategoriaPlato', ManyToOne, 'id_categoria');
			//$this->fk['ingredientes'] = array('Ingrediente', 'id_plato', 'id_plato', false, 'OneToMany');
			$this->fk['ingredientes'] = new FK('Ingrediente', OneToMany, 'id_plato', null, null, null
					, 'id_alimento');
			//$this->fk['usuario'] = array('Usuario', 'id_usuario', 'id_usuario', false, 'ManyToOne', 'id_plato');
			$this->fk['usuario'] = new FK('Usuario', ManyToOne, 'id_usuario');
			//$this->fk['comentarios'] = array('ComentarioPlato', 'id_plato', 'id_plato', false, 'OneToMany');
			$this->fk['comentarios'] = new FK('ComentarioPlato', OneToMany, 'id_plato');
		}
		
		public function puedo_hacerlo()
		{
			//localiza los alimentos que tengo en mi despensa para hacer el plato
			if (count($this->ingredientes()) > 0 and count($_SESSION['usuario']->despensa) > 0)
			{
				$puedoHacerla = true;
				$despensa = $_SESSION['usuario']->despensa;
				foreach ($this->ingredientes as $ing)
				{
					if (!isset($despensa[$ing->alimento->id_alimento]))
					{
						$puedoHacerla = false;
					}
				}
			}
			else
			{
				$puedoHacerla = false;
			}
			return $puedoHacerla;
		}
		
		public function es_plato_favorito()
		{
			if (isset($_SESSION['usuario']->platos_favoritos[$this->id_plato]))
			{
				return true;
			}
			return false;
		}
		
		private function calcula_info_nutricional($atributo)
		{
			$info = 0;
			foreach ($this->ingredientes() as $ingrediente)
			{
				$info += $ingrediente->$atributo();
			}
			return $info;
		}
		
		public function calorias()
		{
			return $this->calcula_info_nutricional('calorias');
			
		}
		
		public function proteinas()
		{
			return $this->calcula_info_nutricional('proteinas');
		}
		
		public function hidratos_carbono()
		{
			return $this->calcula_info_nutricional('hidratos_carbono');
		}
		
		public function fibra()
		{
			return $this->calcula_info_nutricional('fibra');
		}
		
		public function lipidos()
		{
			return $this->calcula_info_nutricional('lipidos');
		}
		
		public function colesterol()
		{
			return $this->calcula_info_nutricional('colesterol');
		}
		
		public function agp()
		{
			return $this->calcula_info_nutricional('agp');
		}
		
		public function ags()
		{
			return $this->calcula_info_nutricional('ags');
		}
		
		public function agm()
		{
			return $this->calcula_info_nutricional('agm');
		}
		
		public function vitamina_a()
		{
			return $this->calcula_info_nutricional('vitamina_a');
		}
		
		public function vitamina_b1()
		{
			return $this->calcula_info_nutricional('vitamina_b1');
		}
		
		public function vitamina_b2()
		{
			return $this->calcula_info_nutricional('vitamina_b2');
		}
		
		public function vitamina_b6()
		{
			return $this->calcula_info_nutricional('vitamina_b6');
		}
		
		public function vitamina_b12()
		{
			return $this->calcula_info_nutricional('vitamina_b12');
		}
		
		public function vitamina_c()
		{
			return $this->calcula_info_nutricional('vitamina_c');
		}
		
		public function vitamina_d()
		{
			return $this->calcula_info_nutricional('vitamina_d');
		}
		
		public function hierro()
		{
			return $this->calcula_info_nutricional('hierro');
		}
		
		public function calcio()
		{
			return $this->calcula_info_nutricional('calcio');
		}
		
		public function sodio()
		{
			return $this->calcula_info_nutricional('sodio');
		}
		
		public function acido_folico()
		{
			return $this->calcula_info_nutricional('acido_folico');
		}
		
		public function retinol()
		{
			return $this->calcula_info_nutricional('retinol');
		}
		
		public function yodo()
		{
			return $this->calcula_info_nutricional('yodo');
		}
		
		public function potasio()
		{
			return $this->calcula_info_nutricional('potasio');
		}
		
		public function fosforo()
		{
			return $this->calcula_info_nutricional('fosforo');
		}
		
		public function ingrediente(Ingrediente $ingrediente, $quitar = false)
		{
			$this->ingredientes();
			if ($quitar and isset($this->ingredientes[$ingrediente->alimento->id_alimento]))
			{
				unset($this->ingredientes[$ingrediente->alimento->id_alimento]);
			}
			else
			{
				$this->ingredientes[$ingrediente->alimento->id_alimento] = $ingrediente;
			}
		}
	}