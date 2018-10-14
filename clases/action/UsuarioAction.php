<?php
	class UsuarioAction extends Action
	{
		private $MAX_ACTIVIDADES = 10;
		private $MAX_SUG_AMISTAD = 3;
		private $MAX_CONTACTOS = 10;
		private $MAX_RECETAS = 10;
		private $TAM_FOTO_MINI = 100;
		protected $usuarioService;
		protected $emailUsuarioService;
		protected $platoService;
		protected $categoriaPlatoService;
		protected $actividadUsuarioService;
		protected $usuario;
		protected $usuarios;
		protected $emails;
		protected $errores;
		protected $amigo;
		protected $platos;
		protected $categoriasPlatos;
		protected $verMas;
		protected $actividades;
		protected $pagina;
		protected $id_u;
		protected $platoBuscar;
		protected $queTocaHoy;
		protected $plan;
		protected $plato;
		
		public function __construct($servicios)
		{
			parent::__construct($servicios);
			if ($_GET['action'] != 'show_login' and $_GET['action'] != 'login' and 
					$_GET['action'] != 'redirect_to_login' and $_GET['action'] != 'registro_usuario_form' and
					$_GET['action'] != 'registro_usuario' and $_GET['action'] != 'confirm_registro_usuario'
					and $_GET['action'] != 'activa_javascript')
			{
				if (!isset($_SESSION['usuario']) or !$this->usuarioService->check_usuario($_SESSION['usuario']
						, $_SESSION['session_id']))
				{
					$this->redirect_to_view('usuario/redirect_to_login.php');
				}
			}
		}
		
		public function activa_javascript()
		{
			$_SESSION['javascript'] = true;
		}
		
		public function show_login()
		{
			$_SESSION['usuario'] = null;
			$this->usuario = new Usuario();
			if (isset($_SERVER['HTTP_REFERER']) and $_SERVER['HTTP_REFERER'] 
					and strpos($_SERVER['HTTP_REFERER'], 'baja_usuario') === false)
			{
				$_SESSION['url_acceso'] = $_SERVER['HTTP_REFERER'];
			}
			else
			{
				$_SESSION['url_acceso'] = null;
			}
			return 'success';
		}
		
		public function login()
		{
			$this->usuario = new Usuario($_POST);
			if (!$this->usuario->email or !$this->usuario->clave)
			{
				$this->error = 'El correo electrónico y la clave son obligatorios';
				return 'error';
			}
			$this->usuario->clave = md5($this->usuario->clave);
			$res = $this->usuarioService->login($this->usuario);
			if ($res === false)
			{
				$this->error = $this->usuarioService->error();
				return 'error';
			}
			elseif (!$res)
			{
				$this->error = 'Datos incorrectos';
				return 'error';
			}
			if (!$this->usuario->fecha_confirm_registro)
			{
				$this->error = 'Este usuario aún no ha confirmado su registro en su correo electrónico';
				return 'error';
			}
			$_SESSION['usuario'] = $this->usuario;
			$_SESSION['session_id'] = md5($this->usuario->email);
			if (isset($_SESSION['url_acceso']))
			{
				$url = $_SESSION['url_acceso'];
				$_SESSION['url_acceso'] = null;
				$this->redirect_to_url($url);
			}
			return 'success';
		}
		
		public function logout()
		{
			$_SESSION['usuario'] = null;
			$_SESSION['session_id'] = null;
			$_SESSION['filtros'] = null;
			$_SESSION['clases_alimentos'] = null;
			$_SESSION['receta'] = null;
			$_SESSION['criterios'] = null;
			return 'success';
		}
		
		public function inicio()
		{
			return 'success';
		}
		
		public function main()
		{
			return 'success';
		}
		
		public function amigos()
		{
			if ($_SESSION['usuario']->amigos == 0)
			{
				return 'success';
			}
			$this->usuarios = $this->usuarioService->contactos_usuario($_SESSION['usuario'], null);
			return 'success';
		}

		public function perfil()
		{
			if (!isset($_GET['id_usuario']) or !$_GET['id_usuario'])
			{
				if (isset($_SESSION['usuario']) and $_SESSION['usuario'])
				{
					$_GET['id_usuario'] = $_SESSION['usuario']->id_usuario;
				}
				else
				{
					return 'amigos';
				}
			}
			if ($_SESSION['usuario']->id_usuario == $_GET['id_usuario'])
			{
				$this->usuario = $_SESSION['usuario'];
			}
			else
			{
				$this->usuario = $this->usuarioService->findById($_GET['id_usuario']);
				if ($this->usuario === false)
				{
					$this->error = $this->usuarioService->error();
					return 'error';
				}
				if (!$this->usuario)
				{
					return 'amigos';
				}
			}
			$_SESSION['id_usuario_perfil'] = $_GET['id_usuario'];
			return 'success';
		}
		
		public function sugerencias_amigos()
		{
			if ($_SESSION['usuario']->sugerencias_amistad() === null)
			{
				$usuarios = $this->usuarioService->sugerencias_amistad($_SESSION['usuario'], 50);
				if ($usuarios === false)
				{
					return 'error';
				}
				$_SESSION['usuario']->sugerencias_amistad(null, $usuarios);
			}
			if (count($_SESSION['usuario']->sugerencias_amistad($this->MAX_SUG_AMISTAD)) > 0)
			{
				$this->usuarios = $this->usuarioService->find(new Usuario(), null, null, null, null, false, null
						, $_SESSION['usuario']->sugerencias_amistad($this->MAX_SUG_AMISTAD));
				shuffle($this->usuarios);
			}
			return 'success';
		}
		
		public function sugerencia_amigo()
		{
			if ($_SESSION['usuario']->sugerencias_amistad() === null)
			{
				$usuarios = $this->usuarioService->sugerencias_amistad($_SESSION['usuario'], 50);
				if ($usuarios === false)
				{
					$this->error = $this->usuarioService->error();
					return 'error';
				}
				$_SESSION['usuario']->sugerencias_amistad(null, $usuarios);
			}
			if (count($_SESSION['usuario']->sugerencias_amistad()) > 0)
			{
				if (!$id = $_SESSION['usuario']->sugerencias_amistad(1))
				{
					return null;
				}
				$this->amigo = $this->usuarioService->findById($id);
				if (!$this->amigo)
				{
					return 'error';
				}
				return 'success';
			}
			else
			{
				return null;
			}
		}
		
		public function eliminar_amistad()
		{
			if (!isset($_GET['id_usuario']) or !$_GET['id_usuario'])
			{
				return 'error';
			}
			//si no es amigo no se elimina
			if (!isset($_SESSION['usuario']->amigos[$_GET['id_usuario']]))
			{
				return null;
			}
			//se busca el usuario amigo
			$amigo = $this->usuarioService->findById($_GET['id_usuario']);
			if ($amigo === false)
			{
				$this->error = $this->usuarioService->error();
				return 'error';
			}
			if (!$amigo)
			{
				return null;
			}
			//se borra la amistad
			$this->usuarioService->inicia_transaccion();
			$this->usuarioService->eliminar_amistad($_SESSION['usuario'], $amigo);
			if ($this->usuarioService->cierra_transaccion())
			{
				$_SESSION['usuario']->amigos($amigo, false, true);
			}
			return null;
		}
		
		public function login_gmail()
		{
			$_SESSION['usuario']->sugerencias_amistad(null, null);
			require_once APP_ROOT . 'clases/util/GoogleMail.php';
			$gMail = new GoogleMail();
			if (!$gMail->login(HOST_APP . $_SERVER['PHP_SELF'] . link_action('contactos_gmail')))
			{
				$this->error = $gMail->error();
				return 'error';
			}
			return 'success';
		}
		
		public function buscar_amigos()
		{
			return 'success';
		}
		
		public function contactos_gmail()
		{
			require_once APP_ROOT . 'clases/util/GoogleMail.php';
			$gMail = new GoogleMail();
			$contactos = $gMail->emails();
			if ($contactos === false)
			{
				return 'error';
			}
			if ($contactos === null)
			{
				return 'login';
			}
			if (count($contactos) == 0)
			{
				return 'success';
			}
			$usuarios = array();
			$emails = array();
			foreach ($contactos as $email)
			{
				//si es él mismo no lo trata
				if ($email == $_SESSION['usuario']->email)
				{
					continue;
				}
				//obtiene los usuarios que ya existen con ese email
				$usuario = new Usuario();
				$usuario->email = $email;
				if ($usuario = $this->usuarioService->find($usuario))
				{
					$usuarios[$usuario[0]->email] = $usuario[0];
				}
				else
				{
					//si no ha sido ya invitado se muestra para invitar este email
					if (!isset($_SESSION['usuario']->emails[$email]) or !$_SESSION['usuario']->emails[$email])
					{
						$emails[$email] = $email;
					}
				}
				//se guarda en los emails del usuario si no es amigo
				if ($_SESSION['usuario']->emails[$email] !== null)
				{
					continue;
				}
				$emailUsuario = new EmailUsuario();
				$emailUsuario->email = $email;
				$emailUsuario->usuario = $_SESSION['usuario'];
				$emailUsuario->id_email = md5($email . uniqid());
				$this->emailUsuarioService->save($emailUsuario);
				$_SESSION['usuario']->emails($emailUsuario);
			}
			$_SESSION['usuario']->contactos_gmail($usuarios, 'usuarios');
			$_SESSION['usuario']->contactos_gmail($emails, 'emails');
			$this->usuarios = array();
			foreach ($_SESSION['usuario']->contactos_gmail(null, 'usuarios') as $usuario)
			{
				//si ya es amigo se omite
				if ($usuario->es_amigo())
				{
					continue;
				}
				//si ya ha sido invitado no se indica
				if ($usuario->invitado())
				{
					continue;
				}
				//si se ha indicado como no amigo que no salga
				if (isset($_SESSION['usuario']->no_amigos[$usuario->id_usuario]))
				{
					continue;
				}
				$this->usuarios[$usuario->email] = $usuario;
			}
			$this->emails = $_SESSION['usuario']->contactos_gmail(null, 'emails');
			return 'success';
		}
		
		public function invitar_contactos_email()
		{
			if (!isset($_POST['contactos']) or !$_POST['contactos'])
			{
				return 'contactos';
			}
			if (!$_SESSION['usuario']->contactos_gmail())
			{
				return 'contactos';
			}
			require_once APP_ROOT . 'clases/util/PHPMailer/class.phpmailer.php';
			foreach ($_POST['contactos'] as $email)
			{
				//sólo se envían a los contactos de gmail en sesión
				if (!$_SESSION['usuario']->contactos_gmail($email, 'emails'))
				{
					continue;
				}
				//si ya ha sido invitado no se envía (lista de emails del usuario)
				$emailUsuario = $_SESSION['usuario']->emails[$email];
				if ($emailUsuario)
				{
					continue;
				}
				$url = HOST_APP . URL_APP . link_action('registro_usuario_form', array('email' => $email));
				$asunto = $_SESSION['usuario']->nombre . ' quiere que seas uno de sus contactos en ' . APP_NAME;
				$mensaje = 'Hola, ' . $_SESSION['usuario']->nombre 
						. ' te envía una invitación para formar parte de su red de contactos en la plataforma '
						. 'de alimentación <a href="http://cocinandome.es" target="_blank">cocinandome.es</a>.'
						. '<br /><br />Si quieres registrarte pulsa en este enlace:<br /><br />';
				$mensaje .= '<a href="' . $url . '">' . $url . '</a>';
				$mensaje .= '<br /><br /><br />Recibe un cordial saludo de nuestra parte.';
				$mensaje .= '<br /><a href="http://cocinandome.es" target="_blank">cocinandome.es</a>';
				$mail = new PHPMailer();
				$mail->AddAddress($email);
				$mail->Subject = $asunto;
				$mail->Body = $mensaje;
				$mail->CharSet = 'utf-8';
				$mail->IsHTML(true);
				$mail->Mailer = 'smtp';
				$mail->SetLanguage('es', APP_ROOT . 'clases/util/PHPMailer/language/');
				$mail->From = EMAIL_FROM;
				$mail->FromName = APP_NAME;
				@$mail->Send();
				$_SESSION['usuario']->contacto_gmail($email, 'emails', true);
				//si está como email se pone como invitado
				if ($emailUsuario)
				{
					$emailUsuario->invitado = true;
					$this->emailUsuarioService->save($emailUsuario, true);
					$_SESSION['usuario']->emails($emailUsuario);
				}
			}
			return 'success';
		}
		
		public function quitar_no_amigo()
		{
			if (!$_GET['id_usuario'])
			{
				return 'success';
			}
			//si ya está quitado no hace nada
			if (isset($_SESSION['usuario']->no_amigos[$_GET['id_usuario']]))
			{
				return 'success';
			}
			if (!$noAmigo = $this->usuarioService->findById($_GET['id_usuario']))
			{
				return 'success';
			}
			$this->usuarioService->inicia_transaccion();
			//se añade como usuario no amigo
			$usuario = new Usuario();
			$usuario->id_usuario = $_SESSION['usuario']->id_usuario;
			$usuario->no_amigos($noAmigo, true);
			$this->usuarioService->save_relation($usuario, 'no_amigos');
			//se quita de los emails si está
			if (isset($_SESSION['usuario']->emails[$noAmigo->email]))
			{
				$this->emailUsuarioService->removeById($noAmigo->id_usuario);
				$email = new EmailUsuario();
				$email->email = $noAmigo->email;
				$_SESSION['usuario']->emails(email, true);
			}
			if ($this->usuarioService->cierra_transaccion())
			{
				//se quita de la sesión de sugerencias de amistad y emails, y se añade como no amigo
				$_SESSION['usuario']->no_amigos($noAmigo);
				$_SESSION['usuario']->sugerencia_amistad($noAmigo, true);
				$_SESSION['usuario']->contacto_gmail($noAmigo, 'usuarios', true);
			}
			return 'success';
		}
		
		public function registro_form()
		{
			$this->usuario = new Usuario();
			if (isset($_GET['email']) and $_GET['email'])
			{
				$this->usuario->email = $_GET['email'];
			}
			return 'success';
		}
		
		public function registro()
		{
			$this->usuario = new Usuario($_POST);
			//validación de los datos del usuario
			if (!$this->usuarioService->valida($this->usuario))
			{
				$this->errores = $this->usuarioService->errores();
				return 'error';
			}
			//coincidencia de las claves
			if ($this->usuario->clave != $_POST['clave2'])
			{
				$this->errores['clave'] = 'Las contraseñas no coinciden';
				return 'error';
			}
			//texto del captcha
			if ($_POST['captcha'] != $_SESSION["captcha"])
			{
				$this->errores['captcha'] = 'El texto de la imagen no es correcto';
				return 'error';
			}
			$_SESSION["captcha"] = null;
			//comprueba que no exista ya un usuario con ese email
			$usuario = new Usuario();
			$usuario->email = $this->usuario->email;
			if ($this->usuarioService->find($usuario))
			{
				$this->errores['email'] = 'Ya existe un usuario con esta dirección de correo';
				return 'error';
			}
			$this->usuario->id_usuario = uniqid();
			$this->usuario->clave = md5($this->usuario->clave);
			$this->usuario->plan_publico = '0';
			$this->usuario->fecha_confirm_registro = date('Y-m-d H:i:s');
			$this->usuarioService->inicia_transaccion();
			if (!$this->usuarioService->save($this->usuario))
			{
				$this->error = 'No ha sido posible realizar el registro, inténtalo más tarde';
				return 'error';
			}
			/*
			require_once APP_ROOT . 'clases/util/PHPMailer/class.phpmailer.php';
			$mail = new PHPMailer();
			$mail->AddAddress($this->usuario->email);
			$mail->Subject 	= 'Registro de usuario';
			$url = HOST_APP . URL_APP . link_action('confirm_registro_usuario') . '&amp;key=' 
					. md5($this->usuario->id_usuario);
			$mail->Body 	= 'Hola ' . $this->usuario->nombre . '.<br /><br />Has dado este correo para '
					. 'verificar tu registro en nuestra página.<br />Haz clic en el siguiente enlace: <br />'
					. '<br /><a href="' . $url . '">' . $url . '</a>';
			$mail->CharSet = 'utf-8';
			$mail->IsHTML(true);
			$mail->Mailer = 'smtp';
			$mail->SetLanguage('es', APP_ROOT . 'clases/util/PHPMailer/language/');
			$mail->From = EMAIL_FROM;
			$mail->FromName = APP_NAME;
			if (!@$mail->Send())
			{
				$this->error = 'No ha sido posible realizar el registro, inténtalo más tarde';
				return 'error';
			}
			*/
			if (!$this->usuarioService->cierra_transaccion())
			{
				$this->error = 'Se ha producido un error en el registro';
				return 'error';
			}
			return 'success';
		}
		
		public function confirm_registro()
		{
			if (!isset($_GET['key']) or !$_GET['key'])
			{
				return 'error';
			}
			$usuario = new Usuario();
			$usuario->id_usuario = $_GET['key'];
			if (!$usuario = $this->usuarioService->find_by_confirm($usuario))
			{
				return 'error';
			}
			if ($usuario->fecha_confirm_registro)
			{
				return 'success';
			}
			$usuario->fecha_confirm_registro = date('Y-m-d H:i:s');
			if (!$this->usuarioService->save($usuario, true))
			{
				return 'error';
			}
			$_SESSION['usuario'] = $usuario;
			$_SESSION['session_id'] = md5($usuario->email);
			return 'success';
		}
		
		public function editar_perfil()
		{
			$this->usuario = $_SESSION['usuario'];
			return 'success';
		}
		
		public function subir_foto()
		{
			if (!isset($_FILES['foto']) or !is_array($_FILES['foto']) or !$_FILES['foto']['tmp_name'])
			{
				return 'success';
			}
			if ($_FILES['foto']['type'] != 'image/jpeg' and $_FILES['foto']['type'] != 'image/jpg'
					and $_FILES['foto']['type'] != 'image/pjpeg')
			{
				$this->error = 'Sólo fotos en formato JPG';
				return 'success';
			}
			if ($_FILES['foto']['size'] > 4000000)	//4 megas
			{
				$this->error = 'El tamaño de la foto excede el máximo permitido';
				return 'success';
			}
			if (!@is_uploaded_file($_FILES['foto']['tmp_name']))
			{
				$this->error = 'No se ha podido subir la imagen';
				return 'success';
			}
			$idFoto = md5($_SESSION['usuario']->id_usuario);
			require_once APP_ROOT . 'clases/util/Imagen.php';
			if (!Imagen::thumb_jpeg($_FILES['foto']['tmp_name'], APP_ROOT . 'res/img/usuario/' . $idFoto 
					. '.jpg'))
			{
				$this->error = 'No se ha podido mover la imagen';
				return 'success';
			}
			if (!is_dir(APP_ROOT . 'res/img/usuario/mini'))
			{
				if (!@mkdir(APP_ROOT . 'res/img/usuario/mini'))
				{
					$this->error = 'No se ha podido crear el directorio para las miniaturas';
					return 'success';
				}
			}
			if (!Imagen::thumb_jpeg(APP_ROOT . 'res/img/usuario/' . $idFoto . '.jpg', APP_ROOT 
					. 'res/img/usuario/mini/' . $idFoto . '.jpg', $this->TAM_FOTO_MINI))
			{
				$this->error = 'No se ha podido mover la imagen';
				return 'success';
			}
			if (!$_SESSION['usuario']->foto)
			{
				$_SESSION['usuario']->foto = $idFoto;
				if (!$this->usuarioService->save($_SESSION['usuario'], true))
				{
					$this->error = 'No se ha podido editar el perfil';
				}
			}
			return 'success';
		}
		
		public function buscador()
		{
			return 'success';
		}
		
		public function buscador_usuarios()
		{
			return 'success';
		}
		
		public function buscar()
		{
			$MAX_USUARIOS_BUSCADOR = 10;
			$usuario = new Usuario();
			$usuario->nombre = $_GET['consulta'];
			if (!isset($_GET['p']) or !($_GET['p'] += 0))
			{
				$_GET['p'] = 0;
			}
			$inicio = $_GET['p'] * $MAX_USUARIOS_BUSCADOR;
			$total = $this->usuarioService->find($usuario, null, 'nombre', array('nombre' => true), null, true);
			if (($inicio + $MAX_USUARIOS_BUSCADOR) < $total)
			{
				$this->verMas = true;
			}
			$this->usuarios = $this->usuarioService->find($usuario, $MAX_USUARIOS_BUSCADOR, 'nombre'
					, array('nombre' => true), null, false, $inicio);
			if ($this->usuarios === false)
			{
				return 'error';
			}
			return 'success';
		}
		
		public function actividades()
		{
			if (!isset($_GET['p']) or !($_GET['p'] += 0))
			{
				$this->pagina = 0;
			}
			else
			{
				$this->pagina = $_GET['p'];
			}
			$inicio = $this->pagina * $this->MAX_ACTIVIDADES;
			if (!isset($_GET['id_u']) or !$_GET['id_u'])
			{
				//si no viene el id de usuario se muestran las actividades de mis amigos
				$this->usuario = $_SESSION['usuario'];
				$verAmigos = true;
				$this->id_u = null;
			}
			else
			{
				//si viene el id de usuario se muestran las actividades del mismo, siempre que sea yo o alguno 
				//de mis amigos
				if ($_SESSION['usuario']->id_usuario == $_GET['id_u'])
				{
					$this->usuario = $_SESSION['usuario'];
				}
				else
				{
					if (!isset($_SESSION['usuario']->amigos[$_GET['id_u']]))
					{
						return 'error';
					}
					$this->usuario = $this->usuarioService->findById($_GET['id_u']);
					if (!$this->usuario)
					{
						return 'error';
					}
				}
				$verAmigos = false;
				$this->id_u = $_GET['id_u'];
			}
			$this->actividades = $this->actividadUsuarioService->actividades($this->usuario, $inicio
					, $this->MAX_ACTIVIDADES, $verAmigos);
			if ($this->actividadUsuarioService->total_actividades($this->usuario, $verAmigos) > ($inicio 
					+ $this->MAX_ACTIVIDADES))
			{
				$this->verMas = true;
			}
			return 'success';
		}
		
		public function contactos()
		{
			if (!isset($_GET['id_u']) or !$_GET['id_u'])
			{
				//si no viene el id de usuario se muestran mis contactos
				$usuario = $_SESSION['usuario'];
				$this->id_u = null;
			}
			else
			{
				//si viene el id de usuario se muestran los contactos del mismo
				if ($_SESSION['usuario']->id_usuario == $_GET['id_u'])
				{
					$usuario = $_SESSION['usuario'];
				}
				else
				{
					$usuario = $this->usuarioService->findById($_GET['id_u']);
					if (!$usuario)
					{
						return 'error';
					}
				}
				$this->id_u = $_GET['id_u'];
			}
			if (!isset($_GET['p']) or !($_GET['p'] += 0))
			{
				$this->pagina = 0;
			}
			else
			{
				$this->pagina = $_GET['p'];
			}
			$inicio = $this->pagina * $this->MAX_CONTACTOS;
			$total = $this->usuarioService->total_contactos_usuario($usuario);
			if (($inicio + $this->MAX_CONTACTOS) < $total)
			{
				$this->verMas = true;
			}
			$this->usuarios = $this->usuarioService->contactos_usuario($usuario, $this->MAX_CONTACTOS, $inicio);
			if ($this->usuarios === false)
			{
				return 'error';
			}
			return 'success';
		}
		
		public function recetas_favoritas()
		{
			return 'success';
		}
		
		public function buscar_recetas_favoritas()
		{
			if (!isset($_GET['p']) or !($_GET['p'] += 0))
			{
				$this->pagina = 0;
			}
			else
			{
				$this->pagina = $_GET['p'];
			}
			$inicio = $this->pagina * $this->MAX_RECETAS;
			$this->platoBuscar = new Plato();
			if (isset($_GET['nombre_plato']) and $_GET['nombre_plato'])
			{
				$this->platoBuscar->nombre_plato = $_GET['nombre_plato'];
			}
			$total = $this->usuarioService->total_platos_favoritos($_SESSION['usuario'], $this->platoBuscar);
			if (($inicio + $this->MAX_RECETAS) < $total)
			{
				$this->verMas = true;
			}
			$this->platos = $this->usuarioService->platos_favoritos($_SESSION['usuario'], $this->MAX_RECETAS
					, $inicio, $this->platoBuscar);
			if ($this->platos === false)
			{
				return 'error';
			}
			return 'success';
		}
	
		public function add_plato_favoritos()
		{
			if (!isset($_GET['id_plato']) or !$_GET['id_plato'])
			{
				return 'error';
			}
			if ($_SESSION['usuario']->plato_favorito($_GET['id_plato']))
			{
				return 'success';
			}
			$plato = new Plato();
			$plato->id_plato = $_GET['id_plato'];
			if (!$this->platoService->platos_para_usuario($_SESSION['usuario'], null, 0, $plato))
			{
				return 'error';
			}
			$usuario = new Usuario();
			$usuario->id_usuario = $_SESSION['usuario']->id_usuario;
			$usuario->platos_favorito[0] = $plato;
			if (!$this->usuarioService->save_relation($usuario, 'platos_favoritos'))
			{
				return 'error';
			}
			$_SESSION['usuario']->platos_favorito($plato);
			return 'success';
		}
		
		public function quit_plato_favoritos()
		{
			if (!isset($_GET['id_plato']) or !$_GET['id_plato'])
			{
				return 'error';
			}
			if (!$_SESSION['usuario']->plato_favorito($_GET['id_plato']))
			{
				return 'success';
			}
			$usuario = new Usuario();
			$usuario->id_usuario = $_SESSION['usuario']->id_usuario;
			$plato = new Plato();
			$plato->id_plato = $_GET['id_plato'];
			$usuario->platos_favorito[] = $plato;
			if (!$this->usuarioService->destroy_relation($usuario, 'platos_favoritos'))
			{
				return 'error';
			}
			$_SESSION['usuario']->platos_favorito($plato, true);
			return 'success';
		}
		
		public function mis_recetas()
		{
			return 'success';
		}
		
		public function recetas_usuario()
		{
			if ($_SESSION['usuario']->platos() === false)
			{
				return 'error';
			}
			if (!isset($_GET['p']) or !($_GET['p'] += 0))
			{
				$this->pagina = 0;
			}
			else
			{
				$this->pagina = $_GET['p'];
			}
			$inicio = $this->pagina * $this->MAX_RECETAS;
			$this->platoBuscar = new Plato();
			if (isset($_GET['nombre_plato']) and $_GET['nombre_plato'])
			{
				$this->platoBuscar->nombre_plato = trim($_GET['nombre_plato']);
			}
			$total = $this->usuarioService->total_platos_usuario($_SESSION['usuario'], $this->platoBuscar);
			if (($inicio + $this->MAX_RECETAS) < $total)
			{
				$this->verMas = true;
			}
			$this->platos = $this->usuarioService->platos_usuario($_SESSION['usuario'], $this->MAX_RECETAS
					, $inicio, $this->platoBuscar);
			if ($this->platos === false)
			{
				return 'error';
			}
			return 'success';
		}
		
		public function que_toca_hoy()
		{
			$this->plan = new PlanSemanal();
			$dia = (date('w')) ? date('w') : 7 ;
			$this->plan->dia = $dia;
			$hora = date('H');
			if ($hora >= 20)
			{
				$comidas = array(4);
			}
			elseif ($hora >= 17)
			{
				$comidas = array(3, 4);
			}
			elseif ($hora >= 12)
			{
				$comidas = array(2, 3, 4);
			}
			else
			{
				$comidas = array(1, 2, 3, 4);
			}
			$planes = $this->usuarioService->plan_usuario($_SESSION['usuario'], $this->plan, $comidas);
			if ($planes === false)
			{
				return 'error';
			}
			if ($planes)
			{
				$this->queTocaHoy = $planes[$dia];
			}
			return 'success';
		}
		
		public function publicar_receta()
		{
			if (!isset($_GET['id_receta']) or !$_GET['id_receta'])
			{
				return 'error';
			}
			$plato = new Plato();
			$plato->id_plato = $_GET['id_receta'];
			if (!isset($_SESSION['usuario']->platos[$_GET['id_receta']]))
			{
				return 'error';
			}
			$this->plato = $this->platoService->findById($_GET['id_receta']);
			if (!$this->plato)
			{
				return 'error';
			}
			if ($this->plato->publico)
			{
				$this->error = 'Esta receta ya ha sido publicada o está pendiente de serlo';
				return 'error';
			}
			return 'success';
		}
		
		public function envio_publicacion_receta()
		{
			if (!isset($_GET['id_receta']) or !$_GET['id_receta'])
			{
				return 'error';
			}
			$plato = new Plato();
			$plato->id_plato = $_GET['id_receta'];
			if (!isset($_SESSION['usuario']->platos[$_GET['id_receta']]))
			{
				return 'error';
			}
			$plato = $this->platoService->findById($_GET['id_receta']);
			if (!$plato)
			{
				return 'error';
			}
			if ($plato->publico)
			{
				return 'success';
			}
			require_once APP_ROOT . 'clases/util/PHPMailer/class.phpmailer.php';
			$mail = new PHPMailer();
			$mail->AddAddress('ajlucena78@gmail.com');
			$mail->Subject = 'Publicar receta: ' . $plato->nombre_plato;
			$url = HOST_APP . URL_APP . link_action('receta') . '&id_receta=' . $plato->id_plato;
			$mensaje = 'El usuario ' . $_SESSION['usuario']->nombre . ' desea publicar la receta '
					. '<a href="' . $url . '">' . $plato->nombre_plato . '</a> (' . $plato->id_plato . ').';
			$mail->Body = $mensaje;
			$mail->CharSet = 'utf-8';
			$mail->IsHTML(true);
			$mail->Mailer = 'smtp';
			$mail->SetLanguage('es', APP_ROOT . 'clases/util/PHPMailer/language/');
			$mail->From = EMAIL_FROM;
			$mail->FromName = APP_NAME;
			if (!@$mail->Send())
			{
				return 'error';
			}
			$plato->publico = 2;
			if (!$this->platoService->save($plato, true))
			{
				return 'error';
			}
			return 'success';
		}
		
		public function despublicar_receta()
		{
			if (!isset($_GET['id_receta']) or !$_GET['id_receta'])
			{
				return 'error';
			}
			if (!isset($_SESSION['usuario']->platos[$_GET['id_receta']]))
			{
				return 'error';
			}
			$this->plato = $this->platoService->findById($_GET['id_receta']);
			if (!$this->plato)
			{
				return 'error';
			}
			if ($this->plato->publico == 0)
			{
				$this->error = 'Esta receta no está publicada';
				return 'error';
			}
			return 'success';
		}
		
		public function despublicacion_receta()
		{
			if (!isset($_GET['id_receta']) or !$_GET['id_receta'])
			{
				return 'error';
			}
			if (!isset($_SESSION['usuario']->platos[$_GET['id_receta']]))
			{
				return 'error';
			}
			$plato = new Plato();
			$plato->id_plato = $_GET['id_receta'];
			$plato = $this->platoService->findById($_GET['id_receta']);
			if (!$plato)
			{
				return 'error';
			}
			if ($plato->publico == 0)
			{
				return 'error';
			}
			$plato->publico = 0;
			if (!$this->platoService->save($plato, true))
			{
				return 'error';
			}
			return 'success';
		}
		
		public function baja()
		{
			$platos = $this->usuarioService->platos_usuario($_SESSION['usuario'], null);
			if ($platos === false)
			{
				return 'error';
			}
			foreach ($platos as $plato)
			{
				$foto = APP_ROOT . 'res/img/plato/mini/' . $plato->foto . '.jpg';
				if (file_exists($foto))
				{
					unlink($foto);
				}
				$foto = APP_ROOT . 'res/img/plato/' . $plato->foto . '.jpg';
				if (file_exists($foto))
				{
					unlink($foto);
				}
			}
			$this->usuarioService->inicia_transaccion();
			if (!$this->usuarioService->removeById($_SESSION['usuario']->id_usuario))
			{
				return 'error';
			}
			if ($_SESSION['usuario']->foto)
			{
				$foto = APP_ROOT . 'res/img/usuario/mini/' . $_SESSION['usuario']->foto . '.jpg';
				if (file_exists($foto))
				{
					unlink($foto);
				}
				$foto = APP_ROOT . 'res/img/usuario/' . $_SESSION['usuario']->foto . '.jpg';
				if (file_exists($foto))
				{
					unlink($foto);
				}
			}
			if (!$this->usuarioService->cierra_transaccion())
			{
				return 'error';
			}
			$this->logout();
			return 'success';
		}
		
		public function main_movil()
		{
			return 'success';
		}
	}