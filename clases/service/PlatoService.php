<?php

class PlatoService extends Service
{
	private $errores;
	
	public function errores()
	{
		return $this->errores;
	}
	
	public function cargaInfo(Plato $plato)
	{
		$plato->vegetariano = true;
		$plato->celiaco = true;
		foreach ($plato->ingredientes as $ing)
		{
			if (!$ing->alimento->vegetariano)
			{
				$plato->vegetariano = false;
			}
			if (!$ing->alimento->celiaco)
			{
				$plato->celiaco = false;
			}
		}
	}
	
	public function save(Model $plato, $update = false, $transaccion = false)
	{
		$this->cargaInfo($plato);
		return parent::save($plato, $update);
	}
	
	public function valida(Plato $plato)
	{
		if ($plato->tiempo_preparacion > 0)
		{
			$plato->tiempo_preparacion = number_format($plato->tiempo_preparacion);
		}
		else
		{
			$plato->tiempo_preparacion = null;
		}
		if ($plato->comensales > 0)
		{
			$plato->comensales = number_format($plato->comensales);
		}
		else
		{
			$plato->comensales = null;
		}
		$error = false;
		$this->errores = array();
		if (!$plato->nombre_plato)
		{
			$this->errores['nombre_plato'] = 'El nombre es obligatorio';
			$error = true;
		}
		elseif (strlen(trim($plato->nombre_plato)) < 6)
		{
			$this->errores['nombre_plato'] = 'El nombre debe tener 6 caracteres como mínimo';
			$error = true;
		}
		elseif (strlen(trim($plato->nombre_plato)) > 255)
		{
			$this->errores['nombre_plato'] = 'El nombre no puede tener más de 255 caracteres';
			$error = true;
		}
		if ($plato->comensales < 1 or $plato->comensales > 20)
		{
			$this->errores['comensales'] = 'El número de comensales no es correcto';
			$error = true;
		}
		if (strlen(trim($plato->preparacion)) < 10 or strlen(trim($plato->preparacion)) > 5000)
		{
			$plato->preparacion = '';
			//$this->errores['preparacion'] = 'La descripción de la preparación es necesaria';
			//$error = true;
		}
		if (!is_object($plato->categoria) or $plato->categoria->id_categoria === null)
		{
			$this->errores['categoria'] = 'La categoría es necesaria';
			$error = true;
		}
		if (!$plato->foto)
		{
			$this->errores['foto'] = 'La fotografía de la receta es obligatoria';
			$error = true;
		}
		return !$error;
	}
	
	/**
	 * Obtiene el total de recetas que un usuario puede hacer, al que se puede indicar un plato
	 * con criterios de búsqueda
	 * @param Usuario $usuario
	 * @param Plato $plato
	 */
	public function total_platos_por_despensa(Usuario $usuario, Plato $plato = null)
	{
		if (count($usuario->despensa) == 0)
		{
			return 0;
		}
		$sql = 'select count(*) as total from Plato pla where';
		$sql .= $this->sql_platos_por_despensa($usuario);
		if ($plato)
		{
			if ($plato->nombre_plato)
			{
				$sql .= ' and pla.nombre_plato like \'%' . $plato->nombre_plato . '%\'';
			}
		}
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
	
	/**
	 * Carga las recetas que puede un usuario dado cocinar con los ingredientes de su receta
	 * @param Usuario $usuario
	 * @param $id
	 * @param $max
	 * @param $inicio
	 * @param Plato $plato
	 * @return array|bool
	 */
	public function platos_por_despensa(Usuario $usuario, $id = null, $max = 1, $inicio = 0
			, Plato $plato = null)
	{
		if (count($usuario->despensa) == 0)
		{
			return array();
		}
		$sql = 'select distinct pla.* from Plato pla where';
		$sql .= $this->sql_platos_por_despensa($usuario);
		if ($id)
		{
			$sql .= ' and pla.id_plato = \'' . $id . '\'';
		}
		if ($plato)
		{
			if ($plato->nombre_plato)
			{
				$sql .= ' and pla.nombre_plato like \'%' . $plato->nombre_plato . '%\'';
			}
		}
		$sql .= ' limit ' . $inicio . ', ' . $max;
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
	
	public function id_platos_por_despensa(Usuario $usuario, $max = 1)
	{
		if (count($usuario->despensa) == 0)
		{
			return array();
		}
		$sql = 'select distinct pla.id_plato from Plato pla where';
		$sql .= $this->sql_platos_por_despensa($usuario);
		$sql .= ' limit ' . $max;
		$consulta = new Consulta(self::$conexion);
		if (!$consulta->ejecuta($sql))
		{
			$this->error = $consulta->error();
			return false;
		}
		$registros = array();
		while ($registro = $consulta->lee_registro())
		{
			$registros[] = $registro['id_plato'];
		}
		$consulta->libera();
		return $registros;
	}
	
	/**
	 * Obtiene la sql de las recetas que un usuario puede hacer
	 * @param Usuario $usuario
	 */
	private function sql_platos_por_despensa(Usuario $usuario)
	{
		$sql = ' (select count(ing1.id_ingrediente) from Ingrediente ing1';
		$sql .= ' where ing1.id_plato = pla.id_plato)';
		$sql .= ' = (select count(ing2.id_ingrediente) from Ingrediente ing2 ';
		$sql .= ' where ing2.id_plato = pla.id_plato and (false';
		foreach ($usuario->despensa as $idAlimento => $idDespensa)
		{
			$sql .= ' or ing2.id_alimento = \'' . $idAlimento . '\'';
		}
		$sql .= '))';
		$sql .= ' and (' . $this->sql_platos_usuario($usuario) . ')';
		return $sql;
	}
	
	/**
	 * Obtiene el total de recetas para un usuario
	 * @param Usuario $usuario
	 * @param Plato $plato
	 * @param Alimento $alimento
	 * @param $excludes
	 */
	public function total_platos_para_usuario(Usuario $usuario, Plato $plato = null
			, Alimento $alimento = null, $excludes = null)
	{
		$sql = 'select count(*) as total from Plato pla';
		$sql .= $this->sql_platos_para_usuario($usuario, $plato, $alimento, $excludes);
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
	
	/**
	 * Obtiene las recetas que sean públicas, propias o de amigos. Puede discriminar por criterios de plato
	 * @param Usuario $usuario
	 * @param $max
	 * @param $inicio
	 * @param Plato $plato
	 * @param Alimento $alimento
	 * @param $excludes
	 */
	public function platos_para_usuario(Usuario $usuario, $max = 1, $inicio = 0, Plato $plato = null
			, Alimento $alimento = null, $excludes = null)
	{
		$sql = 'select distinct pla.* from Plato pla';
		$sql .= $this->sql_platos_para_usuario($usuario, $plato, $alimento, $excludes);
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
	
	/**
	 * Obtiene el total de recetas encontradas usando la búsqueda avanzada
	 * @param Usuario $usuario
	 * @param Plato $plato
	 * @param $categorias
	 * @param $recetasAmigos
	 */
	public function total_platos_para_usuario_avanzado(Usuario $usuario, Plato $plato, $categorias = null
			, $recetasAmigos = null)
	{
		$sql = 'select count(*) as total from Plato pla';
		$sql .= $this->sql_platos_para_usuario_avanzado($usuario, $plato, $categorias, $recetasAmigos);
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
	
	public function platos_para_usuario_avanzado(Usuario $usuario, $max = 1, $inicio = 0, Plato $plato
			, $categorias = null, $recetasAmigos = null, $orden = null)
	{
		$sql = 'select distinct pla.* from Plato pla';
		$sql .= $this->sql_platos_para_usuario_avanzado($usuario, $plato, $categorias, $recetasAmigos);
		if ($orden)
		{
			$sql .= ' order by pla.' . $orden[0];
		}
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
	
	private function sql_platos_para_usuario_avanzado(Usuario $usuario, Plato $plato, $categorias = null
			, $recetasAmigos = null)
	{
		$sql = $this->sql_platos_para_usuario($usuario, $plato);
		if ($categorias)
		{
			$sql .= ' and (false';
			foreach ($categorias as $id_categoria)
			{
				$sql .= ' or pla.id_categoria = \'' . $id_categoria . '\'';
			}
			$sql .= ')';
		}
		if ($plato->tiempo_preparacion)
		{
			$sql .= ' and pla.tiempo_preparacion <= \'' . $plato->tiempo_preparacion . '\'';
		}
		if ($plato->comensales)
		{
			if ($plato->comensales >= 1 and $plato->comensales <= 4)
			{
				$sql .= ' and pla.comensales = \'' . $plato->comensales . '\'';
			}
			else
			{
				$sql .= ' and pla.comensales > 4';
			}
		}
		if ($plato->video)
		{
			$sql .= ' and not(pla.video is null) and pla.video <> \'\'';
		}
		if ($plato->publico)
		{
			$sql .= ' and pla.publico is true';
		}
		if ($recetasAmigos)
		{
			if (count($usuario->amigos > 0))
			{
				$sql .= ' and pla.id_usuario in (\'0\'';
				foreach ($usuario->amigos as $idAmigo)
				{
					$sql .= ', \'' . $idAmigo . '\'';
				}
				$sql .= ')';
			}
		}
		if ($plato->calorias())
			$sql .= ' and pla.calorias > 0';
		if ($plato->proteinas())
			$sql .= ' and pla.proteinas > 0';
		if ($plato->hidratos_carbono())
			$sql .= ' and pla.hidratos_carbono > 0';
		if ($plato->fibra())
			$sql .= ' and pla.fibra > 0';
		if ($plato->lipidos())
			$sql .= ' and pla.lipidos > 0';
		if ($plato->colesterol())
			$sql .= ' and pla.colesterol > 0';
		if ($plato->agp())
			$sql .= ' and pla.agp > 0';
		if ($plato->ags())
			$sql .= ' and pla.ags > 0';
		if ($plato->agm())
			$sql .= ' and pla.agm > 0';
		if ($plato->vitamina_a())
			$sql .= ' and pla.vitamina_a > 0';
		if ($plato->vitamina_b1())
			$sql .= ' and pla.vitamina_b1 > 0';
		if ($plato->vitamina_b2())
			$sql .= ' and pla.vitamina_b2 > 0';
		if ($plato->vitamina_b6())
			$sql .= ' and pla.vitamina_b6 > 0';
		if ($plato->vitamina_b12())
			$sql .= ' and pla.vitamina_b12 > 0';
		if ($plato->vitamina_c())
			$sql .= ' and pla.vitamina_c > 0';
		if ($plato->vitamina_d())
			$sql .= ' and pla.vitamina_d > 0';
		if ($plato->hierro())
			$sql .= ' and pla.hierro > 0';
		if ($plato->calcio())
			$sql .= ' and pla.calcio > 0';
		if ($plato->sodio())
			$sql .= ' and pla.sodio > 0';
		if ($plato->acido_folico())
			$sql .= ' and pla.acido_folico > 0';
		if ($plato->retinol())
			$sql .= ' and pla.retinol > 0';
		if ($plato->yodo())
			$sql .= ' and pla.yodo > 0';
		if ($plato->potasio())
			$sql .= ' and pla.potasio > 0';
		if ($plato->fosforo())
			$sql .= ' and pla.fosforo > 0';
		return $sql;
	}
	
	/**
	 * Prepara la consulta de los platos que puede ver un usuario dado
	 * @param Usuario $usuario
	 * @param Plato $plato
	 * @param Alimento $alimento
	 * @param $excludes
	 */
	private function sql_platos_para_usuario(Usuario $usuario, Plato $plato = null
			, Alimento $alimento = null, $excludes = null)
	{
		$sql = '';
		if ($alimento and $alimento->id_alimento)
		{
			$sql .= ' inner join Ingrediente ing on (ing.id_plato = pla.id_plato and ing.id_alimento = ';
			$sql .= '\'' . $alimento->id_alimento . '\')';
		}
		$sql .= ' where (' . $this->sql_platos_usuario($usuario) . ')';
		if ($plato)
		{
			if ($plato->nombre_plato)
			{
				$sql .= ' and pla.nombre_plato like \'%' . $plato->nombre_plato . '%\'';
			}
			if ($plato->categoria and $plato->categoria->id_categoria)
			{
				$sql .= ' and pla.id_categoria = ' . $plato->categoria->id_categoria;
			}
			if ($plato->id_plato)
			{
				$sql .= ' and pla.id_plato = \'' . $plato->id_plato . '\'';
			}
			if ($plato->vegetariano)
			{
				$sql .= ' and pla.vegetariano is true';
			}
			if ($plato->celiaco)
			{
				$sql .= ' and pla.celiaco is true';
			}
		}
		if ($excludes)
		{
			foreach ($excludes as $campo => $valor)
			{
				$sql .= ' and ' . $campo . ' <> \'' . $valor . '\'';
			}
		}
		return $sql;
	}
	
	/**
	 * Carga la sql para obtener sólo las recetas de un usuario, públicas y de amigos
	 * @param Usuario $usuario
	 */
	private function sql_platos_usuario(Usuario $usuario)
	{
		$sql = 'pla.publico is true or pla.id_usuario in (\'' . $usuario->id_usuario . '\'';
		if ($usuario->amigos)
		{
			foreach ($usuario->amigos as $id_amigo)
			{
				$sql .= ', \'' . $id_amigo . '\'';
			}
		}
		$sql .= ')';
		return $sql;
	}
	
	public function total_recetas_publicas(Plato $plato = null, $id_receta = null, Alimento $alimento = null)
	{
		$sql = 'select count(*) as total from Plato pla';
		if ($alimento)
		{
			if ($alimento->id_alimento)
			{
				$sql .= ' join Ingrediente ing on (ing.id_plato = pla.id_plato and ing.id_alimento = '
						. $alimento->id_alimento . ')';
			}
		}
		$sql .= ' where pla.publico = \'1\'';
		if ($plato)
		{
			if ($plato->categoria and $plato->categoria->id_categoria)
			{
				$sql .= ' and pla.id_categoria = ' . $plato->categoria->id_categoria;
			}
		}
		if ($id_receta)
		{
			$sql .= ' and pla.id_plato <> \'' . $id_receta . '\'';
		}
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
	
	public function recetas_publicas(Plato $plato = null, $id_receta = null, $max = null, $inicio = 0
			, Alimento $alimento = null)
	{
		$sql = 'select distinct pla.* from Plato pla';
		if ($alimento)
		{
			if ($alimento->id_alimento)
			{
				$sql .= ' join Ingrediente ing on (ing.id_plato = pla.id_plato and ing.id_alimento = '
						. $alimento->id_alimento . ')';
			}
		}
		$sql .= ' where pla.publico = \'1\'';
		if ($plato)
		{
			if ($plato->categoria and $plato->categoria->id_categoria)
			{
				$sql .= ' and pla.id_categoria = ' . $plato->categoria->id_categoria;
			}
		}
		if ($id_receta)
		{
			$sql .= ' and pla.id_plato <> \'' . $id_receta . '\'';
		}
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
	
	public function me_mola(Plato $plato)
	{
		$usuario = new Usuario();
		$usuario->id_usuario = $_SESSION['usuario']->id_usuario;
		$usuario->me_mola_plato = array($plato);
		if ($this->exist_relation($usuario, 'me_mola_plato'))
		{
			return null;
		}
		if (!$this->save_relation($usuario, 'me_mola_plato'))
		{
			return 'error';
		}
		$sql = 'update Plato set me_mola = me_mola + 1 where id_plato = \'' . $plato->id_plato . '\'';
		$res = self::$conexion->ejecuta($sql);
		if ($res === false)
		{
			$this->error = self::$conexion->error();
			return false;
		}
		return $res;
	}
}
