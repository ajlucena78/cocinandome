<?php
	class Usuario extends Model
	{
		protected $id_usuario;
		protected $nombre;
		protected $clave;
		protected $email;
		protected $foto;
		protected $despensa;
		protected $plan;
		protected $platos;
		protected $amigos;
		protected $emails;
		protected $invitaciones_amistad;
		protected $invitaciones_amistad_enviadas;
		protected $no_amigos;
		protected $fecha_confirm_registro;
		protected $lista_compra;
		protected $platos_favoritos;
		protected $me_mola_plato;
		protected $plan_publico;
		private $sugerencias_amistad;
		private $contactos_gmail;
		private $platos_puedo_hacer;
		
		public function __construct($datos = null)
		{
			parent::__construct($datos);
			$this->pk['id_usuario'] = 'manual';
			$this->fk['despensa'] = new FK('Alimento', ManyToMany, 'id_usuario', 'id_alimento'
					, 'nombre_alimento', 'Despensa', 'id_alimento', 'id_despensa');
			$this->fk['plan'] = new FK('PlanSemanal', OneToMany, 'id_usuario', null, array('dia', 'comida')
					, null, array('dia', 'comida', 'id_plan'));
			$this->fk['platos'] = new FK('Plato', OneToMany, 'id_usuario', null, null, null, 'id_plato');
			$this->fk['amigos'] = new FK('Usuario', ManyToMany, 'id_usuario', 'id_amigo', 'nombre', 'Amigo'
					, 'id_amigo', 'id_amigo');
			/*
			$this->fk['emails'] = array('EmailUsuario', 'id_usuario', 'id_usuario', false, 'OneToMany');
			$this->cargaRef('emails', 'email', true, 'invitado');
			*/
			$this->fk['emails'] = new FK('EmailUsuario', OneToMany, 'id_usuario', null, null, null, 'email'
					, 'invitado');
			$this->fk['invitaciones_amistad'] = new FK('InvitacionAmistad', OneToMany, 'id_usuario', null
					, null, null, 'id_usuario_invita', 'id_usuario_invita');
			$this->fk['invitaciones_amistad_enviadas'] = new FK('InvitacionAmistad', OneToMany
					, 'id_usuario_invita', 'id_usuario', null, null, 'id_usuario', 'id_usuario');
			/*
			$this->fk['no_amigos'] = array('NoAmigo', 'id_usuario', 'id_no_amigo', false, 'ManyToMany'
					, 'Usuario', 'id_no_amigo');
			$this->cargaRef('no_amigos', 'id_no_amigo', true);
			*/
			$this->fk['no_amigos'] = new FK('Usuario', ManyToMany, 'id_usuario', 'id_no_amigo', null
					, 'NoAmigo', 'id_no_amigo', 'id_no_amigo');
			$this->fk['lista_compra'] = new FK('ListaCompra', OneToMany, 'id_usuario', null
					, 'nombre_alimento', 'Alimento', 'id_alimento', 'id_lista');
			$this->fk['platos_favoritos'] = new FK('Plato', ManyToMany, 'id_plato', 'id_usuario'
					, 'nombre_plato', 'PlatoFavorito', 'id_plato', 'id_plato');
			/*
			$this->fk['me_mola_plato'] = array('MeMolaPlato', 'id_plato', 'id_usuario', false, 'ManyToMany'
					, 'Plato', 'id_plato', array('nombre_plato'));
			parent::cargaRef('me_mola_plato', 'id_plato', true);
			*/
			$this->fk['me_mola_plato'] = new FK('Plato', ManyToMany, 'id_plato', 'id_usuario', 'nombre_plato'
					, 'MeMolaPlato', 'id_plato', 'id_plato');
			if (!$this->foto)
			{
				$this->foto = null;
			}
		}
		
		public function sugerencias_amistad($max = null, $usuarios = false)
		{
			if ($max)
			{
				if (!isset($_SESSION['cont_sugerencias_amistad']) 
						or $_SESSION['cont_sugerencias_amistad'] >= count($this->sugerencias_amistad))
				{
					$_SESSION['cont_sugerencias_amistad'] = 0;
				}
				$cont = $_SESSION['cont_sugerencias_amistad'];
				$_SESSION['cont_sugerencias_amistad'] += $max;
				return array_slice($this->sugerencias_amistad, $cont, $max, true);
			}
			else if ($usuarios !== false)
			{
				$this->sugerencias_amistad = $usuarios;
			}
			else
			{
				return $this->sugerencias_amistad;
			}
		}
		
		public function es_amigo()
		{
			if ($_SESSION['usuario']->id_usuario != $this->id_usuario 
					and isset($_SESSION['usuario']->amigos[$this->id_usuario]))
			{
				return true;
			}
			return false;
		}
		
		public function invitado()
		{
			if (isset($_SESSION['usuario']->invitaciones_amistad_enviadas[$this->id_usuario]))
			{
				return true;
			}
			return false;
		}
		
		public function me_invita()
		{
			if (isset($_SESSION['usuario']->invitaciones_amistad[$this->id_usuario]))
			{
				return true;
			}
			return false;
		}
		
		public function yo_mismo()
		{
			if ($_SESSION['usuario']->id_usuario == $this->id_usuario)
			{
				return true;
			}
			return false;
		}
		
		public function get_plan(PlanSemanal $plan = null)
		{
			$this->plan();
			if ($plan)
			{
				if ($plan->id_plan and $plan->dia and $plan->comida)
				{
					if (isset($this->plan[$plan->dia][$plan->comida][$plan->id_plan]))
					{
						return $this->plan[$plan->dia][$plan->comida][$plan->id_plan];
					}
				}
				elseif ($plan->dia and $plan->comida)
				{
					if (isset($this->plan[$plan->dia][$plan->comida]))
					{
						return $this->plan[$plan->dia][$plan->comida];
					}
				}
				elseif ($plan->dia and isset($this->plan[$plan->dia]))
				{
					return $this->plan[$plan->dia];
				}
			}
			else
				return $this->plan;
		}
		
		public function set_plan(PlanSemanal $plan, $quitar = false)
		{
			$this->plan();
			if ($quitar)
			{
				unset($this->plan[$plan->dia][$plan->comida][$plan->id_plan]);
			}
			else
			{
				$this->plan[$plan->dia][$plan->comida][$plan->id_plan] = $plan;
			}
		}
		
		public function plato(Plato $plato)
		{
			$this->platos();
			$this->platos[$plato->id_plato] = $plato;
		}
		
		public function despensa(Despensa $despensa, $quitar = false)
		{
			if ($quitar and isset($this->despensa[$despensa->alimento->id_alimento]))
			{
				unset($this->despensa[$despensa->alimento->id_alimento]);
			}
			else
			{
				$this->despensa[$despensa->alimento->id_alimento] = $despensa->id_despensa;
			}
		}
		
		public function lista_compra(ListaCompra $lista, $quitar = false)
		{
			if ($quitar and isset($this->lista_compra[$lista->alimento->id_alimento]))
			{
				unset($this->lista_compra[$lista->alimento->id_alimento]);
			}
			else
			{
				$this->lista_compra[$lista->alimento->id_alimento] = $lista->id_lista;
			}
		}
		
		public function invitaciones_amistad(Usuario $usuario, $quitar = false)
		{
			if ($quitar and isset($this->invitaciones_amistad[$usuario->id_usuario]))
			{
				unset($this->invitaciones_amistad[$usuario->id_usuario]);
			}
			else
			{
				$this->invitaciones_amistad[$usuario->id_usuario] = $usuario->id_usuario;
			}
		}
		
		public function invitaciones_amistad_enviadas(InvitacionAmistad $invitacion)
		{
			$this->invitaciones_amistad_enviadas[$invitacion->usuario->id_usuario] = 
					$invitacion->usuario->id_usuario;
		}
		
		public function no_amigos(Usuario $usuario, $completo = false)
		{
			if ($completo)
			{
				$this->no_amigos[$usuario->id_usuario] = $usuario;
			}
			else
			{
				$this->no_amigos[$usuario->id_usuario] = $usuario->id_usuario;
			}
		}
		
		public function emails(EmailUsuario $email, $quitar = false)
		{
			if ($quitar and isset($this->emails[$email->email]))
			{
				unset($this->emails[$email->email]);
			}
			else
			{
				$this->emails[$email->email] = $email->email;
			}
		}
		
		public function contactos_gmail($x = null, $tipo = null)
		{
			if ($tipo)
			{
				if ($x)
					$this->contactos_gmail[$tipo] = $x;
				else
					return $this->contactos_gmail[$tipo];
			}
			else
			{
				if ($x)
					$this->contactos_gmail = $x;
				else
					$this->contactos_gmail;
			}
		}
		
		public function contacto_gmail($x, $tipo, $quitar = false)
		{
			if ($quitar)
			{
				unset($this->contactos_gmail[$tipo][$x->email]);
			}
			else
			{
				$this->contactos_gmail[$tipo][$x->email] = $x;
			}
		}
		
		public function platos_favoritos(Plato $plato, $quitar = false)
		{
			if ($quitar and isset($this->platos_favorito[$plato->id_plato]))
			{
				unset($this->platos_favorito[$plato->id_plato]);
			}
			else
			{
				$this->platos_favorito[$plato->id_plato] = $plato->id_plato;
			}
		}
		
		public function amigos(Usuario $amigo, $soloId = true, $quitar = false)
		{
			if ($quitar)
			{
				if (isset($this->amigos[$amigo->id_usuario]))
				{
					unset($this->amigos[$amigo->id_usuario]);
				}
			}
			elseif ($soloId)
			{
				$this->amigos[$amigo->id_usuario] = $amigo->id_usuario;
			}
			else
			{
				$this->amigos[$amigo->id_usuario] = $amigo;
			}
		}
		
		function sugerencia_amistad(Usuario $usuario, $quitar = false)
		{
			if ($quitar and isset($this->sugerencias_amistad[$usuario->id_usuario]))
			{
				unset($this->sugerencias_amistad[$usuario->id_usuario]);
			}
		}
		
		public function platos_puedo_hacer($platos = false)
		{
			if ($platos !== false)
			{
				$this->platos_puedo_hacer = $platos;
			}
			else
			{
				return $this->platos_puedo_hacer;
			}
		}
	}