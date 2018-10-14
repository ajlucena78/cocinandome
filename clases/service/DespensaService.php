<?php
	class DespensaService extends Service
	{
		
		public function despensa_usuario(Usuario $usuario, Despensa $despensa = null)
		{
			$sql = 'select distinct des.*, ali.id_alimento from Despensa des';
			$sql .= ' join Alimento ali on (des.id_alimento = ali.id_alimento)';
			$sql .= ' where true';
			if ($despensa)
			{
				if ($despensa->alimento)
				{
					if ($despensa->alimento->nombre_alimento)
					{
						$sql .= ' and ali.nombre_alimento like \'' . $despensa->alimento->nombre_alimento . '%\'';
					}
					if ($despensa->alimento->clase and ($despensa->alimento->clase->id_clase_alimento 
							or $despensa->alimento->clase->id_clase_alimento === '0'))
					{
						$sql .= ' and ali.id_clase_alimento =  \'' . $despensa->alimento->clase->id_clase_alimento 
								. '\'';
					}
				}
			}
			$sql .= ' and des.id_usuario = \'' . $usuario->id_usuario . '\'';
			$sql .= ' order by ali.nombre_alimento';
			$consulta = new Consulta(self::$conexion);
			if (!$consulta->ejecuta($sql))
			{
				$this->error = $consulta->error();
				return false;
			}
			$registros = array();
			while ($registro = $consulta->lee_registro())
			{
				$registros[$registro['id_alimento']] = new Despensa($registro);
			}
			$consulta->libera();
			return $registros;
		}
	}