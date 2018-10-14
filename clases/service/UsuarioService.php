<?php
	class UsuarioService extends Service
	{
		private $errores;
		
		public function errores()
		{
			return $this->errores;
		}
		
		public function valida(Usuario $usuario)
		{
			$error = false;
			$this->errores = array();
			if (!$usuario->nombre)
			{
				$this->errores['nombre'] = 'El nombre es obligatorio';
				$error = true;
			}
			elseif (strlen(trim($usuario->nombre)) < 6)
			{
				$this->errores['nombre'] = 'El nombre debe tener 6 caracteres como mínimo';
				$error = true;
			}
			elseif (strlen(trim($usuario->nombre)) > 30)
			{
				$this->errores['nombre'] = 'El nombre no puede tener más de 30 caracteres';
				$error = true;
			}
			if (!$usuario->email)
			{
				$this->errores['email'] = 'El correo electrónico es obligatorio';
				$error = true;
			}
			elseif (strlen(trim($usuario->email)) > 50)
			{
				$this->errores['email'] = 'El correo electrónico no puede tener más de 50 caracteres';
				$error = true;
			}
			else
			{
				require_once APP_ROOT . 'clases/util/Email.php';
				if (!Email::check_email_address($usuario->email))
				{
					$this->errores['email'] = 'El correo electrónico no es correcto';
					$error = true;
				}
			}
			if (!$usuario->clave)
			{
				$this->errores['clave'] = 'La contraseña es obligatoria';
				$error = true;
			}
			elseif (strlen(trim($usuario->clave)) < 6)
			{
				$this->errores['clave'] = 'La contraseña debe tener 6 caracteres como mínimo';
				$error = true;
			}
			elseif (strlen(trim($usuario->clave)) > 20)
			{
				$this->errores['clave'] = 'La contraseña no puede tener más de 20 caracteres';
				$error = true;
			}
			return !$error;
		}
		
		public function login(Usuario & $usuario)
		{
			$sql = 'select * from Usuario';
			$sql .= ' where email = \'' . str_replace('\'', '', $usuario->email) . '\'';
			$sql .= ' and clave = \'' . str_replace('\'', '', $usuario->clave) . '\'';
			$consulta = new Consulta(parent::$conexion);
			if (!$consulta->ejecuta($sql))
			{
				$this->error = $consulta->error();
				return false;
			}
			$res = true;
			if ($registro = $consulta->lee_registro())
			{
				$usuario = new Usuario($registro);
			}
			else
			{
				$res = null;
			}
			$consulta->libera();
			return $res;
		}
		
		public function find_by_confirm(Usuario $usuario)
		{
			$sql = 'select * from Usuario where md5(id_usuario) = \'' . $usuario->id_usuario . '\'';
			$consulta = new Consulta(parent::$conexion);
			if (!$consulta->ejecuta($sql))
			{
				$this->error = $consulta->error();
				return false;
			}
			if ($registro = $consulta->lee_registro())
			{
				$usuario = new Usuario($registro);
			}
			else
			{
				$usuario = null;
			}
			$consulta->libera();
			return $usuario;
		}
		
		public function check_usuario($usuario, $sessionId)
		{
			$res = false;
			if (isset($usuario) and is_object($usuario) and isset($sessionId) and $sessionId)
			{
				if (md5($usuario->email) == $sessionId)
				{
					$res = true;
				}
			}
			return $res;
		}
		
		public function sugerencias_amistad(Usuario $usuario, $limit = null)
		{
			$numAmigos = count($usuario->amigos);
			$numEmails = count($usuario->emails);
			$sql2 = '';
			$sql = 'select * from (';
			if ($numAmigos > 0)
			{
				//por amigos de mis amigos
				$sql .= 'select distinct usu.* from Usuario usu';
				$sql .= ' join Amigo ami on (ami.id_usuario <> \'' . $usuario->id_usuario . '\'';
				foreach ($usuario->amigos as $id)
				{
					$sql .= ' and ami.id_amigo = usu.id_usuario and ami.id_usuario = \'' . $id . '\'';
					$sql2 .= ', \'' . $id . '\'';
				}
				$sql .= ')';
			}
			if ($numEmails > 0)
			{
				//por emails de mis contactos
				if ($numAmigos > 0)
				{
					$sql .= ' union';
				}
				$sql .= ' select distinct usu.* from Usuario usu';
				$sql .= ' where true and (false';
				foreach ($usuario->emails as $email => $invitado)
				{
					$sql .= ' or usu.email = \'' . $email . '\'';
				}
				$sql .= ')';
			}
			//por mi email en los contactos de otros usuarios
			if ($numAmigos or $numEmails)
			{
				$sql .= ' union';
			}
			$sql .= ' select distinct usu.* from Usuario usu';
			$sql .= ' join EmailUsuario ema on (ema.email = \'' . $usuario->email 
					. '\' and usu.id_usuario = ema.id_usuario)';
			//se omite el propio usuario y los ya amigos
			$sql .= ') as tabla where id_usuario not in (\'' . $usuario->id_usuario . '\'' . $sql2 . ')';
			//se omiten los usuarios que ya han sido invitados
			if ($usuario->invitaciones_amistad_enviadas)
			{
				$sql .= ' and id_usuario not in (\'0\'';
				foreach ($usuario->invitaciones_amistad_enviadas as $id)
				{
					$sql .= ', \'' . $id . '\'';
				}
				$sql .= ')';
			}
			//se omiten los indicados como no amigos
			if (count($usuario->no_amigos) > 0)
			{
				$sql .= ' and id_usuario not in (\'0\'';
				foreach ($usuario->no_amigos as $id)
				{
					$sql .= ', \'' . $id . '\'';
				}
				$sql .= ')';
			}
			if ($limit)
			{
				$sql .= ' limit ' . $limit;
			}
			$consulta = new Consulta(self::$conexion);
			if (!$consulta->ejecuta($sql))
			{
				$this->error = $consulta->error();
				return false;
			}
			$registros = array();
			while ($registro = $consulta->lee_registro())
			{
				$registros[$registro['id_usuario']] = $registro['id_usuario'];
			}
			$consulta->libera();
			return $registros;
		}
		
		public function crear_amistad(Usuario $usuarioSesion, Usuario $amigo)
		{
			//no hacerme amigo de mí mismo...
			if ($usuarioSesion->id_usuario == $amigo->id_usuario)
			{
				return false;
			}
			$usuario = new Usuario();
			$usuario->id_usuario = $usuarioSesion->id_usuario;
			$usuario->amigos($amigo);
			$this->save_relation($usuario, 'amigos');
			$amigoAux = new Usuario();
			$amigoAux->id_usuario = $amigo->id_usuario;
			$amigoAux->amigos($usuario, false);
			$this->save_relation($amigoAux, 'amigos');
			//se guarda el amigo con sus amigos en mis amigos, y me añado yo
			$amigo->amigos($usuarioSesion);
			$usuarioSesion->amigos($amigo);
			return true;
		}
		
		public function eliminar_amistad(Usuario $usuario, Usuario $amigo)
		{
			if ($usuario->id_usuario == $amigo->id_usuario)
			{
				return false;
			}
			$usuarioAux = new Usuario();
			$usuarioAux->id_usuario = $usuario->id_usuario;
			$amigoAux = new Usuario();
			$amigoAux->id_usuario = $amigo->id_usuario;
			$usuarioAux->amigos($amigo, false);
			$amigoAux->amigos($usuario, false);
			$this->destroy_relation($usuarioAux, 'amigos');
			$this->destroy_relation($amigoAux, 'amigos');
			return true;
		}
		
		public function es_plato_favorito(Usuario $usuario, Plato $plato)
		{
			$sql = 'select id_plato from Plato where id_plato = \'' . $plato->id_plato . '\'';
			$sql .= ' and id_usuario = \'' . $usuario->id_usuario . '\'';
			$consulta = new Consulta(self::$conexion);
			if (!$consulta->ejecuta($sql))
			{
				$this->error = $consulta->error();
				return false;
			}
			if ($consulta->lee_registro())
			{
				$esta = true;
			}
			else
			{
				$esta = false;
			}
			$consulta->libera();
			return $esta;
		}
		
		private function sql_platos_favoritos(Usuario $usuario, Plato $plato = null)
		{
			$sql = ' join PlatoFavorito fav on (fav.id_plato = pla.id_plato';
			$sql .= ' and fav.id_usuario = \'' . $usuario->id_usuario . '\')';
			if ($plato)
			{
				$sql .= ' where true';
				if ($plato->nombre_plato)
				{
					$sql .= ' and pla.nombre_plato like \'%' . $plato->nombre_plato . '%\'';
				}
			}
			return $sql;
		}
		
		public function total_platos_favoritos(Usuario $usuario, Plato $plato = null)
		{
			$sql = 'select count(*) as total from Plato pla';
			$sql .= $this->sql_platos_favoritos($usuario, $plato);
			$consulta = new Consulta(self::$conexion);
			if (!$consulta->ejecuta($sql))
			{
				$this->error = $consulta->error();
				return false;
			}
			$registro = $consulta->lee_registro();
			$total = $registro['total'];
			$consulta->libera();
			return $total;
		}
		
		public function platos_favoritos(Usuario $usuario, $max = 1, $inicio = 0, Plato $plato = null)
		{
			$sql = 'select distinct pla.* from Plato pla';
			$sql .= $this->sql_platos_favoritos($usuario, $plato);
			$sql .= ' order by pla.nombre_plato';
			if ($max)
			{
				$sql .= ' limit ' . $inicio . ', ' . $max;
			}
			$consulta = new Consulta(self::$conexion);
			if (!$consulta->ejecuta($sql))
			{
				$this->error = $consulta->error();
				return false;
			}
			$registros = array();
			while ($registro = $consulta->lee_registro())
			{
				$registros[] = new Plato($registro);
			}
			$consulta->libera();
			return $registros;
		}
		
		private function sql_platos_usuario(Usuario $usuario, Plato $plato = null)
		{
			$sql = ' where pla.id_usuario = \'' . $usuario->id_usuario . '\'';
			if ($plato)
			{
				if ($plato->nombre_plato)
				{
					$sql .= ' and pla.nombre_plato like \'' . $plato->nombre_plato . '%\'';
				}
			}
			return $sql;
		}
		
		public function total_platos_usuario(Usuario $usuario, Plato $plato = null)
		{
			$sql = 'select count(*) as total from Plato pla';
			$sql .= $this->sql_platos_usuario($usuario, $plato);
			$consulta = new Consulta(self::$conexion);
			if (!$consulta->ejecuta($sql))
			{
				$this->error = $consulta->error();
				return false;
			}
			$registro = $consulta->lee_registro();
			$total = $registro['total'];
			$consulta->libera();
			return $total;
		}
		
		public function platos_usuario(Usuario $usuario, $max = 1, $inicio = 0, Plato $plato = null)
		{
			$sql = 'select distinct pla.* from Plato pla';
			$sql .= $this->sql_platos_usuario($usuario, $plato);
			$sql .= ' order by pla.nombre_plato';
			if ($max)
			{
				$sql .= ' limit ' . $inicio . ', ' . $max;
			}
			$consulta = new Consulta(self::$conexion);
			if (!$consulta->ejecuta($sql))
			{
				$this->error = $consulta->error();
				return false;
			}
			$registros = array();
			while ($registro = $consulta->lee_registro())
			{
				$registros[] = new Plato($registro);
			}
			$consulta->libera();
			return $registros;
		}
		
		public function total_contactos_usuario(Usuario $usuario)
		{
			$sql = 'select count(*) as total from Usuario usu';
			$sql .= ' join Amigo ami on (ami.id_usuario = \'' . $usuario->id_usuario . '\'';
			$sql .= ' and ami.id_amigo = usu.id_usuario)';
			$consulta = new Consulta(self::$conexion);
			if (!$consulta->ejecuta($sql))
			{
				$this->error = $consulta->error();
				return false;
			}
			$registro = $consulta->lee_registro();
			$total = $registro['total'];
			$consulta->libera();
			return $total;
		}
		
		public function contactos_usuario(Usuario $usuario, $max = 1, $inicio = 0)
		{
			$sql = 'select distinct usu.* from Usuario usu';
			$sql .= ' join Amigo ami on (ami.id_usuario = \'' . $usuario->id_usuario . '\'';
			$sql .= ' and ami.id_amigo = usu.id_usuario)';
			$sql .= ' order by usu.nombre';
			if ($max)
			{
				$sql .= ' limit ' . $inicio . ', ' . $max;
			}
			$consulta = new Consulta(self::$conexion);
			if (!$consulta->ejecuta($sql))
			{
				$this->error = $consulta->error();
				return false;
			}
			$registros = array();
			while ($registro = $consulta->lee_registro())
			{
				$registros[] = new Usuario($registro);
			}
			$consulta->libera();
			return $registros;
		}
		
		public function plan_usuario(Usuario $usuario, PlanSemanal $plan = null, $comidas = null)
		{
			$sql = 'select distinct plan.*, ali.*, pla.* from PlanSemanal plan';
			$sql .= ' left join Alimento ali on (ali.id_alimento = plan.id_alimento)';
			$sql .= ' left join Plato pla on (pla.id_plato = plan.id_plato)';
			$sql .= ' where plan.id_usuario = \'' . $usuario->id_usuario . '\'';
			if ($plan)
			{
				if ($plan->dia)
				{
					$sql .= ' and plan.dia = ' . $plan->dia;
				}
				if ($plan->comida)
				{
					$sql .= ' and plan.comida = ' . $plan->comida;
				}
			}
			if ($comidas)
			{
				$sql .= ' and (false';
				foreach ($comidas as $comida)
				{
					$sql .= ' or plan.comida = ' . $comida;
				}
				$sql .= ')';
			}
			$consulta = new Consulta(self::$conexion);
			if (!$consulta->ejecuta($sql))
			{
				$this->error = $consulta->error();
				return false;
			}
			$registros = array();
			while ($registro = $consulta->lee_registro())
			{
				$plan = new PlanSemanal($registro);
				if ($registro['id_plato'])
				{
					$plan->plato = new Plato($registro);
				}
				if ($registro['id_alimento'])
				{
					$plan->alimento = new Alimento($registro);
				}
				$registros[$registro['dia']][$registro['comida']][$registro['id_plan']] = $plan;
			}
			$consulta->libera();
			return $registros;
		}
		
		public function invitaciones_amistad_usuario(Usuario $usuario, $max = null, $inicio = 0)
		{
			$sql = 'select distinct inv.* from InvitacionAmistad inv';
			$sql .= ' where inv.id_usuario = \'' . $usuario->id_usuario . '\'';
			$sql .= ' order by inv.id_invitacion';
			if ($max)
			{
				$sql .= ' limit ' . $inicio . ', ' . $max;
			}
			$consulta = new Consulta(self::$conexion);
			if (!$consulta->ejecuta($sql))
			{
				$this->error = $consulta->error();
				return false;
			}
			$registros = array();
			while ($registro = $consulta->lee_registro())
			{
				$registros[] = new InvitacionAmistad($registro);
			}
			$consulta->libera();
			return $registros;
		}
		
		public function publica_plan(Usuario $usuario)
		{
			$sql = 'update Usuario set plan_publico = \'' . $usuario->plan_publico . '\'';
			$sql .= ' where id_usuario = \'' . $usuario->id_usuario . '\'';
			$res = self::$conexion->ejecuta($sql);
			if ($res === false)
			{
				$this->error = self::$conexion->error();
				return false;
			}
			return $res;
		}
	}