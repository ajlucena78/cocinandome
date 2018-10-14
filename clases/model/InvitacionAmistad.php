<?php
	class InvitacionAmistad extends Model
	{
		protected $id_invitacion;
		protected $mensaje;
		protected $usuario;
		protected $usuario_invita;
		
		public function __construct($datos = null)
		{
			parent::__construct($datos);
			$this->pk['id_invitacion'] = 'manual';
			//$this->fk['usuario'] = array('Usuario', 'id_usuario', 'id_usuario', false, 'ManyToOne', 'id_invitacion');
			$this->fk['usuario'] = new FK('Usuario', ManyToOne, 'id_usuario');
			//$this->fk['usuario_invita'] = array('Usuario', 'id_usuario_invita', 'id_usuario', false, 'ManyToOne', 'id_invitacion');
			$this->fk['usuario_invita'] = new FK('Usuario', ManyToOne, 'id_usuario_invita', 'id_usuario');
		}
	}