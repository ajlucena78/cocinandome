<?php
	class AlimentoClase extends Model
	{
		protected $id_clase_alimento;
		protected $nombre_clase_alimento;
		protected $foto_clase_alimento;
		protected $clase_padre;
		protected $clases_hijas;
		protected $vegetariano;
		protected $celiaco;
		protected $alimentos;
		
		public function __construct($datos = null)
		{
			parent::__construct($datos);
			$this->pk['id_clase_alimento'] = 'auto';
			//$this->fk['clase_padre'] = array('AlimentoClase', 'id_clase_padre', 'id_clase_alimento', false, 'ManyToOne');
			$this->fk['clase_padre'] = new FK('AlimentoClase', ManyToOne, 'id_clase_padre', 'id_clase_alimento');
			//$this->fk['clases_hijas'] = array('AlimentoClase', 'id_clase_alimento', 'id_clase_padre', false, 'OneToMany', 'id_clase_alimento');
			$this->fk['clases_hijas'] = new FK('AlimentoClase', OneToMany, 'id_clase_padre', null, null, null
					, 'id_clase_alimento');
		}
		
		public function alimento($alimento)
		{
			$this->alimentos[] = $alimento;
		}
	}