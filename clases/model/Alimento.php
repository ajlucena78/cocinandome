<?php
	class Alimento extends Model
	{
		protected $id_alimento;
		protected $nombre_alimento;
		protected $foto_alimento;
		protected $clase;
		protected $peso_unidad;
		protected $calorias;
		protected $vegetariano;
		protected $celiaco;
		protected $proteinas;
		protected $hidratos_carbono;
		protected $fibra;
		protected $lipidos;
		protected $colesterol;
		protected $vitamina_d;
		protected $hierro;
		protected $calcio;
		protected $sodio;
		protected $acido_folico;
		protected $vitamina_a;
		protected $vitamina_b1;
		protected $vitamina_b2;
		protected $vitamina_b6;
		protected $vitamina_b12;
		protected $vitamina_c;
		protected $retinol;
		protected $yodo;
		protected $potasio;
		protected $fosforo;
		protected $agp;
		protected $ags;
		protected $agm;
		
		public function __construct($datos = null)
		{
			parent::__construct($datos);
			$this->pk['id_alimento'] = 'auto';
			//$this->fk['clase'] = array('AlimentoClase', 'id_clase_alimento', 'id_clase_alimento', false, 'ManyToOne', 'id_alimento');
			$this->fk['clase'] = new FK('AlimentoClase', ManyToOne, 'id_clase_alimento');
		}
	}