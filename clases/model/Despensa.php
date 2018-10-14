<?php
	class Despensa extends Model
	{
		protected $id_despensa;
		protected $alimento;
		protected $usuario;
		protected $cantidad;
		protected $tipo_cantidad;
		
		public function __construct($datos = null)
		{
			parent::__construct($datos);
			$this->pk['id_despensa'] = 'manual';
			//$this->fk['alimento'] = array('Alimento', 'id_alimento', 'id_alimento', false, 'ManyToOne', 'id_despensa');
			$this->fk['alimento'] = new FK('Alimento', ManyToOne, 'id_alimento');
			$this->load();
			//$this->fk['usuario'] = array('Usuario', 'id_usuario', 'id_usuario', false, 'ManyToOne', 'id_despensa');
			$this->fk['usuario'] = new FK('Usuario', ManyToOne, 'id_usuario');
		}
	}