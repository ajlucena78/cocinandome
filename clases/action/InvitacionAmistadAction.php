<?php
	class InvitacionAmistadAction extends Action
	{
		protected $invitacionAmistadService;
		protected $usuarioService;
		protected $emailUsuarioService;
		protected $actividadUsuarioService;
		protected $invitaciones;
		
		public function __construct($servicios)
		{
			parent::__construct($servicios);
			if (!isset($_SESSION['usuario']) or !$this->usuarioService->check_usuario($_SESSION['usuario']
					, $_SESSION['session_id']))
			{
				$this->redirect_to_view('usuario/redirect_to_login.php');
			}
		}
		
		public function lista()
		{
			$this->invitaciones = $this->usuarioService->invitaciones_amistad_usuario($_SESSION['usuario']);
			return 'success';
		}
		
		/**
		 * Crea una invitación de amistad
		 */
		public function nueva()
		{
			$ret = 'success';
			if (!$_GET['id_usuario'])
			{
				return $ret;
			}
			//existe ya la invitación?
			if (isset($_SESSION['usuario']->invitaciones_amistad_enviadas[$_GET['id_usuario']]))
			{
				return $ret;
			}
			//existe ya la amistad?
			if (isset($_SESSION['usuario']->amigos[$_GET['id_usuario']]))
			{
				return $ret;
			}
			//si la persona que invitamos nos ha invitado también, se hacen contactos
			$invitacion = new InvitacionAmistad();
			$invitacion->usuario = $_SESSION['usuario'];
			$invitacion->usuario_invita = new Usuario(array('id_usuario' => $_GET['id_usuario']));
			$invitacion = $this->invitacionAmistadService->find($invitacion);
			if ($invitacion === false)
			{
				$this->error = $this->invitacionAmistadService->error();
				return 'error';
			}
			if ($invitacion)
			{
				$invitacion = $invitacion[0];
				$this->usuarioService->inicia_transaccion();
				//se crea la relación de amistad entre ambos
				if (!$this->usuarioService->crear_amistad($_SESSION['usuario'], $invitacion->usuario_invita))
				{
					return $ret;
				}
				//se borra la invitación del amigo
				if (!$this->invitacionAmistadService->removeById($invitacion->id_invitacion))
				{
					$this->error = $this->invitacionAmistadService->error();
					return 'error';
				}
				if (!$this->usuarioService->cierra_transaccion())
				{
					return $ret;
				}
				$_SESSION['usuario']->invitaciones_amistad($invitacion->usuario_invita);
				$_SESSION['usuario']->sugerencia_amistad($invitacion->usuario_invita, true);
				return $ret;
			}
			//existe la invitación ya?
			$invitacion = new InvitacionAmistad();
			$invitacion->usuario = new Usuario(array('id_usuario' => $_GET['id_usuario']));
			$invitacion->usuario_invita = $_SESSION['usuario'];
			$invitacion = $this->invitacionAmistadService->find($invitacion);
			if ($invitacion)
			{
				return $ret;
			}
			//se crea la invitación
			$invitacion = new InvitacionAmistad();
			$invitacion->id_invitacion = uniqid();
			$usuario = $this->usuarioService->findById($_GET['id_usuario']);
			if (!$usuario)
			{
				return $ret;
			}
			$invitacion->usuario = $usuario;
			$invitacion->usuario_invita = $_SESSION['usuario'];
			$this->usuarioService->inicia_transaccion();
			$this->invitacionAmistadService->save($invitacion);
			//se quita el email si está en mi lista de correos
			$email = new EmailUsuario();
			$email->email = $invitacion->usuario->email;
			$email->usuario = $_SESSION['usuario'];
			if ($email = $this->emailUsuarioService->find($email))
			{
				$this->emailUsuarioService->removeById($email[0]->id_email);
			}
			$this->usuarioService->cierra_transaccion();
			//se crea en la sesión
			$_SESSION['usuario']->invitaciones_amistad_enviadas($invitacion);
			//se quita de los usuarios sugeridos como contactos
			$_SESSION['usuario']->sugerencia_amistad($invitacion->usuario, true);
			if ($email)
			{
				//se borra de la sesión si está el email
				$_SESSION['usuario']->emails($email[0], true);
			}
			return $ret;
		}
		
		/**
		 * Crea una nueva amistad a partir de la aceptación de una invitación de otro usuario
		 */
		public function aceptar()
		{
			if (isset($_GET['r']))
			{
				$ret = $_GET['r'];
			}
			else
			{
				$ret = null;
			}
			if (!$_GET['id_usuario'])
			{
				return $ret;
			}
			//si no se encuentra la invitación se obvia
			if (!isset($_SESSION['usuario']->invitaciones_amistad[$_GET['id_usuario']]))
			{
				return $ret;
			}
			//se carga la invitación
			$id = $_SESSION['usuario']->invitaciones_amistad[$_GET['id_usuario']];
			//se comprueba que no sea amigo ya
			if (isset($_SESSION['usuario']->amigos[$id]))
			{
				$_SESSION['usuario']->invitaciones_amistad(new Usuario($_GET), true);
				return $ret;
			}
			//se carga la invitación
			$invitacion = new InvitacionAmistad();
			$invitacion->usuario = $_SESSION['usuario'];
			$amigo = new Usuario();
			$amigo->id_usuario = $id;
			$invitacion->usuario_invita = $amigo;
			$invitacion = $this->invitacionAmistadService->find($invitacion);
			if (!$invitacion[0])
			{
				return 'success';
			}
			$invitacion = $invitacion[0];
			//se crea la amistad
			$this->usuarioService->inicia_transaccion();
			if (!$this->usuarioService->crear_amistad($_SESSION['usuario'], $invitacion->usuario_invita))
			{
				return $ret;
			}
			//se quita el email si está en mi lista de correos
			$email = new EmailUsuario();
			$email->email = $invitacion->usuario_invita->email;
			$email->usuario = $_SESSION['usuario'];
			if ($email = $this->emailUsuarioService->find($email))
			{
				$this->emailUsuarioService->removeById($email[0]->id_email);
			}
			//se borra de la sesión si está
			if ($email and isset($_SESSION['usuario']->emails[$email[0]->email]))
			{
				$_SESSION['usuario']->emails($email[0], true);
			}
			//se borra la invitación
			if (!$this->invitacionAmistadService->removeById($invitacion->id_invitacion))
			{
				$this->error = $this->invitacionAmistadService->error();
				return 'error';
			}
			//quitamos la invitación de la sesión
			$_SESSION['usuario']->invitaciones_amistad(new Usuario($_GET), true);
			//se quita la sugerencia de amigo de la sesión
			$_SESSION['usuario']->sugerencia_amistad($invitacion->usuario_invita, true);
			//se inserta la actividad (para los dos usuarios), y se añade a nuestra sesión
			$actividad = new ActividadUsuario();
			$actividad->id_actividad = $_SESSION['usuario']->id_usuario . uniqid();
			$actividad->usuario = $_SESSION['usuario'];
			$actividad->amigo = $invitacion->usuario_invita;
			$actividad->tipo = 1;
			$actividad->fecha = date('Y-m-d H:i:s');
			if (!$this->actividadUsuarioService->save($actividad))
			{
				$this->error = $this->actividadUsuarioService->error();
				return 'error';
			}
			$actividad = new ActividadUsuario();
			$actividad->id_actividad = $invitacion->usuario_invita->id_usuario . uniqid();
			$actividad->usuario = $invitacion->usuario_invita;
			$actividad->amigo = $_SESSION['usuario'];
			$actividad->tipo = 1;
			$actividad->fecha = date('Y-m-d H:i:s');
			if (!$this->actividadUsuarioService->save($actividad))
			{
				$this->error = $this->actividadUsuarioService->error();
				return 'error';
			}
			$this->usuarioService->cierra_transaccion();
			return $ret;
		}
		
		/**
		 * Rechaza una amistad que proviene de una invitación de un usuario
		 */
		public function rechazar()
		{
			$ret = null;
			if (!$_GET['id_usuario'])
			{
				return $ret;
			}
			if (!isset($_SESSION['usuario']->invitaciones_amistad[$_GET['id_usuario']]))
			{
				return $ret;
			}
			//si ya es amigo sólo se quita la invitación
			$id = $_SESSION['usuario']->invitaciones_amistad[$_GET['id_usuario']];
			$amigo = new Usuario();
			$amigo->id_usuario = $id;
			if (isset($_SESSION['usuario']->amigos[$id]))
			{
				$_SESSION['usuario']->invitaciones_amistad($amigo, true);
				return $ret;
			}
			//se carga la invitación
			$invitacion = new InvitacionAmistad();
			$invitacion->usuario = $_SESSION['usuario'];
			$invitacion->usuario_invita = $amigo;
			$invitacion = $this->invitacionAmistadService->find($invitacion);
			if (!$invitacion)
			{
				return 'success';
			}
			$invitacion = $invitacion[0];
			//se borra la invitación
			$this->usuarioService->inicia_transaccion();
			if (!$this->invitacionAmistadService->removeById($invitacion->id_invitacion))
			{
				$this->error = $this->invitacionAmistadService->error();
				return 'error';
			}
			$_SESSION['usuario']->invitaciones_amistad($amigo, true);
			$_SESSION['usuario']->sugerencia_amistad($amigo, true);
			//se añade como usuario no amigo
			$usuario = new Usuario();
			$usuario->id_usuario = $_SESSION['usuario']->id_usuario;
			$usuario->no_amigos($amigo);
			$this->usuarioService->save_relation($usuario, 'no_amigos');
			$this->usuarioService->cierra_transaccion();
			$_SESSION['usuario']->no_amigos($amigo);
			$_SESSION['usuario']->contacto_gmail($amigo, 'usuarios', true);
			return $ret;
		}
	}