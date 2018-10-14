<?php
	class ActividadUsuarioService extends Service
	{
		public function total_actividades(Usuario $usuario, $verAmigos = false)
		{
			if (!$usuario->id_usuario)
			{
				return false;
			}
			$sql = 'select count(*) as total from ActividadUsuario where true';
			$sql .= $this->sql_actividades($usuario, $verAmigos);
			$consulta = new Consulta(self::$conexion);
			if (!$consulta->ejecuta($sql))
			{
				$this->error = $consulta->error();
				return false;
			}
			if (!$registro = $consulta->lee_registro())
			{
				return false;
			}
			$consulta->libera();
			return $registro['total'];
		}
		
		public function actividades(Usuario $usuario, $inicio = 0, $max = 10, $verAmigos = false)
		{
			if (!$usuario->id_usuario)
			{
				return false;
			}
			if ($verAmigos and count($usuario->amigos) == 0)
			{
				return array();
			}
			$sql = 'select * from ActividadUsuario where true';
			$sql .= $this->sql_actividades($usuario, $verAmigos);
			$sql .= ' order by fecha desc';
			$sql .= ' limit ' . $inicio . ', ' . $max;
			$consulta = new Consulta(self::$conexion);
			if (!$consulta->ejecuta($sql))
			{
				$this->error = $consulta->error();
				return false;
			}
			$res = array();
			while ($registro = $consulta->lee_registro())
			{
				$res[$registro['id_actividad']] = new ActividadUsuario($registro);
			}
			$consulta->libera();
			return $res;
		}
		
		public function sql_actividades(Usuario $usuario, $verAmigos = false)
		{
			$sql = '';
			if ($verAmigos)
			{
				if (count($usuario->amigos) == 0)
				{
					return '';
				}
				$sql .= ' and id_usuario in (\'0\'';
				foreach ($usuario->amigos as $id)
				{
					$sql .= ', \'' . $id . '\'';
				}
				$sql .= ')';
				$sql .= ' and id_usuario <> \'' . $usuario->id_usuario . '\'';
			}
			else
			{
				$sql .= ' and id_usuario = \'' . $usuario->id_usuario . '\'';
			}
			return $sql;
		}
	}