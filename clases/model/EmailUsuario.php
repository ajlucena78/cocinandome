<?php
	class EmailUsuario extends Model
	{
		protected $id_email;
		protected $email;
		protected $usuario;
		protected $invitado;
		
		public function __construct($datos = null)
		{
			parent::__construct($datos);
			$this->pk['id_email'] = 'manual';
			//$this->fk['usuario'] = array('Usuario', 'id_usuario', 'id_usuario', false, 'ManyToOne', 'id_email');
			$this->fk['usuario'] = new FK('Usuario', ManyToOne, 'id_usuario');
			if (!$this->invitado)
			{
				$this->invitado = '0';
			}
		}
	}