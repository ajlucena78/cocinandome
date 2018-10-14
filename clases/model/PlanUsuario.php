<?php
	class PlanUsuario
	{
		public $planes;
		
		private function calcula_info_nutricional($metodo)
		{
			if (!$this->planes)
			{
				return 0;
			}
			$res = 0;
			foreach ($this->planes as $planesDias)
			{
				foreach ($planesDias as $planesComidas)
				{
					foreach ($planesComidas as $plan)
					{
						$res += $plan->$metodo();
					}
				}
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