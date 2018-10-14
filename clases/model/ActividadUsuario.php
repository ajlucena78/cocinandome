<?php
	class ActividadUsuario extends Model
	{
		protected $id_actividad;
		protected $usuario;
		protected $tipo;
		protected $amigo;
		protected $fecha;
		protected $plato;
		protected $comentario_plato;
		
		public function __construct($datos = null)
		{
			parent::__construct($datos);
			$this->pk['id_actividad'] = 'manual';
			//$this->fk['usuario'] = array('Usuario', 'id_usuario', 'id_usuario', false, 'ManyToOne', 'id_actividad');
			$this->fk['usuario'] = new FK('Usuario', ManyToOne, 'id_usuario');
			//$this->fk['amigo'] = array('Usuario', 'id_amigo', 'id_usuario', false, 'ManyToOne', 'id_actividad');
			$this->fk['amigo'] = new FK('Usuario', ManyToOne, 'id_amigo', 'id_usuario');
			//$this->fk['plato'] = array('Plato', 'id_plato', 'id_plato', false, 'ManyToOne', 'id_actividad');
			$this->fk['plato'] = new FK('Plato', ManyToOne, 'id_plato');
			//$this->fk['comentario_plato'] = array('ComentarioPlato', 'id_comentario', 'id_comentario', false, OneToOne, 'id_actividad');
			$this->fk['comentario_plato'] = new FK('ComentarioPlato', OneToOne, 'id_comentario', null, null, null
					, 'id_actividad');
		}
	}