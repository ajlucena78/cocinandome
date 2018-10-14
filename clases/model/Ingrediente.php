<?php
	class Ingrediente extends Model
	{
		protected $id_ingrediente;
		protected $plato;
		protected $alimento;
		protected $cantidad;
		protected $tipo_cantidad;
		
		public function __construct($datos = null)
		{
			$this->noMap = array();
			$this->noMap['enmidespensa'] = true;
			parent::__construct($datos);
			$this->pk['id_ingrediente'] = 'manual';
			//$this->fk['plato'] = array('Plato', 'id_plato', 'id_plato', false, 'ManyToOne', 'id_ingrediente');
			$this->fk['plato'] = new FK('Plato', ManyToOne, 'id_plato');
			//$this->fk['alimento'] = array('Alimento', 'id_alimento', 'id_alimento', false, 'ManyToOne', 'id_ingrediente');
			$this->fk['alimento'] = new FK('Alimento', ManyToOne, 'id_alimento');
		}
		
		private function calcula_info_nutricional($atributo)
		{
			if ($this->alimento())
			{
				$valor = $this->alimento->$atributo * $this->cantidad / 100;
				if ($this->tipo_cantidad == 1 and $this->alimento->peso_unidad)
				{
					$valor *= $this->alimento->peso_unidad;
				}
				return round($valor, 2);
			}
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
	}