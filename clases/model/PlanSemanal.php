<?php
	class PlanSemanal extends Model
	{
		protected $id_plan;
		protected $dia;
		protected $comida;
		protected $alimento;
		protected $plato;
		protected $usuario;
		protected $cantidad;
		protected $tipo_cantidad;
		
		public function __construct($datos = null)
		{
			parent::__construct($datos);
			$this->pk['id_plan'] = 'manual';
			//$this->fk['alimento'] = array('Alimento', 'id_alimento', 'id_alimento', false, 'ManyToOne', 'id_plan');
			$this->fk['alimento'] = new FK('Alimento', ManyToOne, 'id_alimento');
			$this->load();
			//$this->fk['usuario'] = array('Usuario', 'id_usuario', 'id_usuario', false, 'ManyToOne', 'id_despensa');
			$this->fk['usuario'] = new FK('Usuario', ManyToOne, 'id_usuario');
			//$this->fk['plato'] = array('Plato', 'id_plato', 'id_plato', false, 'ManyToOne', 'id_plan');
			$this->fk['plato'] = new FK('Plato', ManyToOne, 'id_plato');
		}
		
		public function nombre_comida($comida = null)
		{
			$comidas = array('Desayuno', 'Almuerzo', 'Merienda', 'Cena');
			if (!$comida)
			{
				$comida = $this->comida;
			}
			return $comidas[$comida - 1];
		}
		
		public function nombre_dia($dia = null)
		{
			$dias = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
			if (!$dia)
			{
				$dia = $this->dia;
			}
			return $dias[$dia - 1];
		}
		
		private function calcula_info_nutricional($metodo)
		{
			$res = 0;
			if ($this->alimento())
			{
				if ($this->tipo_cantidad == 1)
				{
					//unidades
					$res += round($this->alimento->peso_unidad * $this->cantidad 
							* $this->alimento->$metodo() / 100);
				}
				else
				{
					//gr
					$res += round($this->cantidad * $this->alimento->$metodo() / 100);
				}
			}
			if ($this->plato)
			{
				$res += round($this->plato->$metodo() / $this->plato->comensales);
			}
			return $res;
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
	}