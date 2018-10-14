<?php
	class ComentarioPlato extends Model
	{
		protected $id_comentario;
		protected $usuario;
		protected $plato;
		protected $fecha;
		protected $comentario;
		
		public function __construct($datos = null)
		{
			parent::__construct($datos);
			$this->pk['id_comentario'] = 'manual';
			//$this->fk['usuario'] = array('Usuario', 'id_usuario', 'id_usuario', false, 'ManyToOne', 'id_comentario');
			$this->fk['usuario'] = new FK('Usuario', ManyToOne, 'id_usuario');
			//$this->fk['plato'] = array('Plato', 'id_plato', 'id_plato', false, 'ManyToOne', 'id_comentario');
			$this->fk['plato'] = new FK('Plato', ManyToOne, 'id_plato');
		}
	}