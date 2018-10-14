<?php
	require_once 'Conexion.php';
	
	abstract class Service
	{
		protected static $conexion;
		private $model;
		protected $error;
		protected $transaccion;
		
		public function __construct()
		{
			if (!self::$conexion)
			{
				self::$conexion = new Conexion();
				if (!self::$conexion->conecta(DB_URL, DB_USERNAME, DB_PASSWORD))
				{
					$this->error = self::$conexion->error();
					echo $this->error;
					exit();
				}
			}
			if (get_class($this) != 'Service')
			{
				require_once(APP_ROOT . 'clases/model/' . str_replace('Service', '', get_class($this)) 
						. '.php');
				$clase = str_replace('Service', '', get_class($this));
				$this->model = new $clase();
			}
		}
		
		public static function cargaService($service)
		{
			$res = new $service();
			return $res;
		}
		
		public function inicia_transaccion()
		{
			$res = self::$conexion->inicia_transaccion();
			if ($res)
			{
				$this->transaccion = true;
			}
			return $res;
		}
		
		public function cierra_transaccion()
		{
			$res = self::$conexion->cierra_transaccion();
			if ($res)
			{
				$this->transaccion = false;
			}
			else
			{
				$this->cancela_transaccion();
			}
			return $res;
		}
		
		public function cancela_transaccion()
		{
			$res = self::$conexion->cancela_transaccion();
			if ($res)
			{
				$this->transaccion = false;
			}
			return $res;
		}
		
		public function error()
		{
			return $this->error;
		}
		
		public static function cargaRef(Model $model, $propiedad, $limite = null, $inicio = 0, $soloId = false
				, $total = false, $criterios = null)
		{
			foreach ($model->pk as $pk => $tipo);
			$id = $model->$pk;
			if (!$id)
			{
				return array();
			}
			$fk = $model->fk($propiedad);
			if (!$fk)
			{
				return null;
			}
			if ($fk->index())
			{
				$index = $fk->index();
			}
			else
			{
				$index = null;
			}
			if ($fk->campo())
			{
				$soloId = true;
				if ($fk->campo() === true)
				{
					$campo = false;
				}
				else
				{
					$campo = $fk->campo();
				}
			}
			else
			{
				$campo = null;
			}
			if ($total or ($soloId and $index))
			{
				if ($total)
				{
					$sql = 'select count(*) as total ';
				}
				else
				{
					$sql = 'select ';
					if (is_array($index) and count($index) > 0)
					{
						$cont = 0;
						foreach ($index as $ind)
						{
							if ($cont++)
							{
								$sql .= ', ';
							}
							$sql .= $ind;
						}
					}
					else
					{
						$sql .= $index;
					}
					if ($campo)
					{
						$sql .= ', ' . $campo;
					}
				}
				$fkModel = $fk->model();
				require_once 'clases/model/' . $fkModel . '.php';
				if ($fk->relation_type() == ManyToMany)
				{
					$sql .= ' from ' . $fk->model_relational() . ' model';
				}
				else
				{
					$sql .= ' from ' . $fk->model() . ' model';
				}
				if (!$total)
				{
					Service::sql_clase_padre($sql, new $fkModel());
				}
				$sql .= ' where ' . $fk->link_model() .' = \'' . $id . '\'';
				if ($criterios !== null and is_array($criterios))
				{
					foreach ($criterios as $criterio => $valor)
					{
						$sql .= ' and ' . $criterio . ' = \'' . $valor . '\'';
					}
				}
			}
			else
			{
				$sql = 'select distinct * from ' . $fk->model() . ' model';
				$fkModel = $fk->model();
				require_once 'clases/model/' . $fkModel . '.php';
				Service::sql_clase_padre($sql, new $fkModel());
				if ($fk->relation_type() == ManyToMany)
				{
					$sql .= ' join ' . $fk->model_relational() . ' d2 on (d2.' . $fk->link_external_model();
					require_once(APP_ROOT . 'clases/model/' . $fk->model() . '.php');
					$modelFk = $fk->model();
					$modelFk = new $modelFk();
					foreach ($modelFk->pk as $pk2 => $tipo);
					$sql .= ' = \'' . $id . '\' and model.' . $fk->link_model() . ' = d2.' . $pk2 . ')';
				}
				elseif ($fk->relation_type() == OneToMany)
				{
					$sql .= ' where model.' . $fk->link_model() . ' = \'' . $id . '\'';
				}
				elseif ($fk->relation_type() == ManyToOne or $fk->relation_type() == OneToOne)
				{
					$modelExternalClass = $fk->model();
					require_once(APP_ROOT . 'clases/model/' . $modelExternalClass . '.php');
					$modelExternal = new $modelExternalClass();
					foreach ($modelExternal->pk as $pk2 => $tipo);
					$modelExternal = null;
					$nombreModel = null;
					$modelAux = new $model();
					do
					{
						$clasePadre = get_parent_class($modelAux);
						if ($modelAux->propiedades_clase($propiedad))
						{
							$nombreModel = get_class($modelAux);
							if ($nombreModel == $fk->model() or $clasePadre == 'Model')
							{
								$sql = 'select distinct model.* from ' . $fk->model() . ' model';
							}
						}
						else
						{
							$modelAux = new $clasePadre();
						}
					}
					while ($clasePadre != 'Model' and !$nombreModel);
					$sql .= ' join ' . $nombreModel . ' d2 on (d2.' . $fk->link_model() . ' = model.' 
							. $pk2 . ' and d2.' . $pk . ' = \'' . $id . '\')';
				}
				if ($criterios !== null and is_array($criterios))
				{
					foreach ($criterios as $criterio => $valor)
					{
						$sql .= ', ' . $criterio = '\'' . $valor . '\'';
					}
				}
				if ($fk->order())
				{
					$sql .= ' order by ';
					if (!is_array($fk->order()))
					{
						$sql .= $fk->order();
					}
					else
					{
						$cont = 1;
						foreach ($fk->order() as $key)
						{
							$sql .= $key;
							if ($cont++ < count($fk->order()))
							{
								$sql .= ', ';
							}
						}
					}
				}
			}
			if ($limite)
			{
				$sql .= ' limit';
				if ($inicio)
				{
					$sql .= ' ' . $inicio . ',';
				}
				$sql .= ' ' . $limite;
			}
			$consulta = new Consulta(self::$conexion);
			if (!$consulta->ejecuta($sql))
			{
				return false;
			}
			if ($total)
			{
				$registros = $consulta->lee_registro();
				$registros = $registros['total'];
			}
			else
			{
				$registros = array();
				if ($soloId and $index)
				{
					while ($registro = $consulta->lee_registro())
					{
						if (is_array($index) and count($index) > 0)
						{
							/*
							para cada elemento del array 'index' se crea una dimensión en los valores devueltos
							*/
							$orden = '$registros';
							foreach ($index as $ind)
							{
								$orden .= '[$registro[\'' . $ind . '\']]';
							}
							$orden .= ' = $registro[\'' . $ind . '\'];';
							eval ($orden);
						}
						else
						{
							if ($campo)
							{
								//se ha especificado un campo para que se cargue su valor en lugar del Model
								$registros[$registro[$index]] = $registro[$campo];
							}
							else
							{
								//se carga sólo el ID aportado, o bien si no viene, la clave primaria
								$registros[$registro[$index]] = $registro[$index];
							}
						}
					}
				}
				else
				{
					$fk_model = $fk->model();
					require_once(APP_ROOT . 'clases/model/' . $fk_model . '.php');
					while ($registro = $consulta->lee_registro())
					{
						if ($index and $index !== true)
						{
							if (is_array($index) and count($index) > 0)
							{
								//Para cada elemento del array 'index' se crea una dimensión en los valores 
								//devueltos
								$orden = '$registros';
								foreach ($index as $ind)
								{
									$orden .= '[$registro[\'' . $ind . '\']]';
								}
								$orden .= ' = new $fk_model($registro);';
								eval ($orden);
							}
							else
							{
								$registros[$registro[$index]] = new $fk_model($registro);
							}
						}
						else
						{
							$registros[] = new $fk_model($registro);
						}
					}
				}
			}
			$consulta->libera();
			return $registros;
		}
		
		public function findAll($order = null, $index = null)
		{
			$sql = 'select * from ' . get_class($this->model) . ' model';
			Service::sql_clase_padre($sql, $this->model);
			if ($order)
			{
				$sql .= ' order by ';
				$cont = 1;
				if ($order)
				{
					if (is_array($order))
					{
						foreach ($order as $key)
						{
							$sql .= $key;
							if ($cont++ < count($order))
							{
								$sql .= ', ';
							}
						}
					}
					else
					{
						$sql .= $order;
					}
				}
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
				$clase = get_class($this->model);
				if ($index)
				{
					$registros[$registro[$index]] = new $clase($registro);
				}
				else
				{
					$registros[] = new $clase($registro);
				}
			}
			$consulta->libera();
			return $registros;
		}
		
		public function find(Model $model, $max = null, $order = null, $likes = null, $excludes = null
				, $total = false, $inicio = 0, $listaId = null)
		{
			if ($total)
			{
				$sql = 'select count(*) as total';
			}
			else
			{
				$sql = 'select *';
			}
			$sql .= ' from ' . get_class($this->model) . ' model';
			Service::sql_clase_padre($sql, $this->model);
			$sql2 = ' where true';
			foreach ($model->propiedades() as $nombre)
			{
				$campo = null;
				if ($fk = $model->fk($nombre))
				{
					if ($fk->relation_type() == ManyToOne)
					{
						$campo = $fk->link_model();
					}
				}
				else
				{
					$campo = $nombre;
				}
				if ($campo)
				{
					$valor = $model->$nombre;
					if (!is_null($valor) and !($valor === ''))
					{
						if ($this->model->propiedades_clase($nombre))
						{
							$nombreModel = 'model';
						}
						else
						{
							$nombreModel = 'padre';
						}
						if ($fk and $fk->relation_type() == ManyToOne)
						{
							if ($valor == 'null')
							{
								$sql2 .= ' and ' . $nombreModel . '.' . $fk->link_model() . ' is null';
								continue;
							}
							if (!is_object($valor))
							{
								continue;
							}
							$obj = $valor;
							if (!in_array($campo, $model->propiedades()))
							{
								$metodo = $fk->link_external_model();
							}
							else
							{
								$metodo = $campo;
							}
							$valor = $obj->$metodo;
							if ($valor === null)
							{
								$propiedadesObj = array();
								foreach ($obj->propiedades_clase() as $propiedadObj)
								{
									if ($obj->$propiedadObj)
									{
										$propiedadesObj[$propiedadObj] = $obj->$propiedadObj;
									}
								}
								if (count($propiedadesObj) > 0)
								{
									$sql .= ' inner join ' . get_class($obj) . ' model2 on (';
									$sql .= 'model2.' . $fk->link_external_model() . ' = model.' 
											. $fk->link_model();
									foreach ($propiedadesObj as $propiedadObj => $valorObj)
									{
										$sql .= ' and model2.' . $propiedadObj . ' like \'' . $valorObj . '\'';
									}
									$sql .= ')';
								}
								continue;
							}
						}
						if (isset($likes[$nombre]))
						{
							$sql2 .= ' and ' . $nombreModel . '.' . $campo . ' like ' . '\'%' . $valor . '%\'';
						}
						elseif ($valor == 'null')
						{
							$sql2 .= ' and ' . $nombreModel . '.' . $campo . ' is null';
						}
						else
						{
							$sql2 .= ' and ' . $nombreModel . '.' . $campo . ' = ';
							$sql2 .= "'" . str_replace("'", "\'", $valor) . "'";
						}
					}
				}
			}
			$sql .= $sql2;
			if (is_array($excludes) and count($excludes) > 0)
			{
				foreach ($model->pk() as $pk => $tipo);
				$sql .= ' and ' . $pk . ' not in (';
				$cont = 1;
				foreach ($excludes as $id)
				{
					$sql .= '\'' . $id . '\'';
					if ($cont < count($excludes))
					{
						$sql .= ', ';
					}
					$cont++;
				}
				$sql .= ')';
			}
			if ($listaId)
			{
				foreach ($model->pk() as $pk => $tipo);
				$sql .= ' and ' . $pk . ' in (';
				$cont = 0;
				foreach ($listaId as $id)
				{
					if ($cont++)
					{
						$sql .= ', ';
					}
					$sql .= '\'' . $id . '\'';
				}
				$sql .= ')';
			}
			if ($order and !$total)
			{
				if (!is_array($order))
				{
					$order = array($order);
				}
				$sql .= ' order by ';
				$cont = 0;
				foreach ($order as $key)
				{
					if ($cont++)
					{
						$sql .= ', ';
					}
					$sql .= $key;
				}
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
			if ($total)
			{
				if (!$registro = $consulta->lee_registro())
				{
					return false;
				}
				$res = $registro['total'];
			}
			else
			{
				$res = array();
				while ($registro = $consulta->lee_registro())
				{
					$clase = get_class($this->model);
					$res[] = new $clase($registro);
				}
			}
			$consulta->libera();
			return $res;
		}
		
		public function total()
		{
			$sql = 'select count(*) as total from ' . get_class($this->model);
			$consulta = new Consulta(self::$conexion);
			if (!$consulta->ejecuta($sql))
			{
				$this->error = $consulta->error();
				return false;
			}
			if ($registro = $consulta->lee_registro())
			{
				$total = $registro['total'];
			}
			else
			{
				$total = 0;
			}
			$consulta->libera();
			return $total;
		}
		
		public function save(Model $model, $update = false, $transaccion = false)
		{
			$cerrarTransaccion = false;
			$clasePadreModel = get_parent_class($model);
			if ($clasePadreModel != 'Model')
			{
				$modelPadre = new $clasePadreModel($model->data());
				if (!$transaccion and !$this->transaccion)
				{
					$this->inicia_transaccion();
					$cerrarTransaccion = true;
				}
				$id = $this->save($modelPadre, $update, true);
				if (!$id)
				{
					if (!$transaccion)
					{
						$this->cancela_transaccion();
					}
					return false;
				}
				if (!$update)
				{
					foreach ($model->pk() as $pk => $tipo)
					{
						if (!$model->$pk)
						{
							$model->$pk = $id;
						}
					}
				}
			}
			if (!$update)
			{
				//nuevo registro
				$sql = 'insert into ' . get_class($model) . ' (';
				$cont = 0;
				$sql2 = '';
				foreach ($model->propiedades_clase() as $nombre)
				{
					if ($model->pk($nombre) == 'auto' and $clasePadreModel == 'Model')
					{
						continue;
					}
					$fk = $model->fk($nombre);
					if ($fk and ($fk->relation_type() == ManyToMany or $fk->relation_type() == OneToMany))
					{
						//no se tienen en cuenta las relaciones de tipo ManyToMany y OneToMany
						continue;
					}
					$valor = $model->$nombre();
					if ($fk)
					{
						if ($fk->relation_type() == ManyToOne or $fk->relation_type() == OneToOne)
						{
							if ($cont > 0)
							{
								$sql .= ', ';
							}
							$sql .= $fk->link_model();
						}
					}
					else
					{
						if ($cont > 0)
						{
							$sql .= ', ';
						}
						$sql .= $nombre;
					}
					if ($fk = $model->fk($nombre))
					{
						if (($fk->relation_type() == ManyToOne or $fk->relation_type() == OneToOne) 
								and $valor != null)
						{
							foreach ($valor->pk() as $pk2 => $tipo)
							{
								$valor = $valor->$pk2;
							}
						}
					}
					if (!$fk or ($fk->relation_type() == ManyToOne or $fk->relation_type() == OneToOne))
					{
						if ($cont++ > 0)
						{
							$sql2 .= ', ';
						}
						if ($valor === null or $valor === 'null' or $valor === array())
						{
							$sql2 .= 'null';
						}
						elseif ($valor === true)
						{
							$sql2 .= 'true';
						}
						elseif ($valor === false)
						{
							$sql2 .= 'false';
						}
						else
						{
							$sql2 .= "'" . $valor . "'";
						}
					}
				}
				$sql .= ') values (' . $sql2 . ')';
			}
			else
			{
				//actualización de registro
				$sql = 'update ' . get_class($model) . ' set ';
				$cont = 0;
				foreach ($model->propiedades_clase() as $nombre)
				{
					if ($model->pk($nombre))
					{
						continue;
					}
					$fk = $model->fk($nombre);
					if ($fk and ($fk->relation_type() == ManyToMany or $fk->relation_type() == OneToMany))
					{
						//no se tienen en cuenta las relaciones de tipo ManyToMany y OneToMany
						continue;
					}
					$valor = $model->$nombre;
					if ($fk)
					{
						if ($fk->relation_type() == ManyToOne)
						{
							if ($cont > 0)
							{
								$sql .= ', ';
							}
							$sql .= $fk->link_model() . ' = ';
						}
					}
					else
					{
						if ($cont > 0)
						{
							$sql .= ', ';
						}
						$sql .= $nombre . ' = ';
						$cont++;
					}
					if ($fk = $model->fk($nombre))
					{
						if ($fk->relation_type() == ManyToOne and $valor != null)
						{
							$submetodo = $fk->link_external_model();
							$valor = $valor->$submetodo;
						}
					}
					if (!$fk or $fk->relation_type() == ManyToOne)
					{
						if ($valor === null or $valor === 'null' or $valor === array())
						{
							$sql .= 'null';
						}
						elseif ($valor === true)
						{
							$sql .= 'true';
						}
						elseif ($valor === false)
						{
							$sql .= 'false';
						}
						else
						{
							$sql .= "'" . $valor . "'";
						}
						$cont++;
					}
				}
				$sql .= ' where true';
				foreach ($model->pk() as $pk => $tipo)
				{
					$sql .= ' and ' . $pk . " = '" . $model->$pk . "'";
				}
			}
			$res = self::$conexion->ejecuta($sql);
			if ($res === false)
			{
				$this->error = self::$conexion->error();
				return false;
			}
			if (!$transaccion and $cerrarTransaccion)
			{
				if (!$this->cierra_transaccion())
				{
					$this->cancela_transaccion();
					$this->error = self::$conexion->error();
					return false;
				}
			}
			//obtener el id insertado y devolverlo si es uno nuevo
			if (!$update and !$transaccion and !$this->transaccion)
			{
				if ($clasePadreModel == 'Model')
				{
					$id = $this->last_insert_id();
					if ($id === false)
					{
						return false;
					}
					if ($id == 0)
					{
						return true;
					}
					return $id;
				}
			}
			return true;
		}
		
		public function last_insert_id()
		{
			if ($this->transaccion)
			{
				$this->error = 'No es posible obtener el último ID insertado dentro de una transacción';
				return false;
			}
			//obtiene el id si se ha generado
			$sql = 'select last_insert_id() as id from ' . get_class($this->model);
			$consulta = new Consulta(self::$conexion);
			if (!$consulta->ejecuta($sql))
			{
				$this->error = $consulta->error();
				return false;
			}
			if ($registro = $consulta->lee_registro())
			{
				$id = $registro['id'];
			}
			else
			{
				$id = null;
			}
			return $id;
		}
		
		public function findById($id)
		{
			$clase = get_class($this->model);
			$sql = 'select * from ' . $clase . ' model';
			Service::sql_clase_padre($sql, $this->model, $id);
			$sql .= ' where true';
			foreach ($this->model->pk() as $pk => $tipo)
			{
				if (is_array($id))
				{
					$sql .= ' and model.' . $pk . ' = \'' . $id[$pk] . '\'';
				}
				else
				{
					$sql .= ' and model.' . $pk . ' = \'' . $id . '\'';
				}
			}
			$consulta = new Consulta(self::$conexion);
			if (!$consulta->ejecuta($sql))
			{
				$this->error = $consulta->error();
				return false;
			}
			$model = null;
			if ($registro = $consulta->lee_registro())
			{
				$model = new $clase($registro);
			}
			$consulta->libera();
			return $model;
		}
		
		public function removeById($id)
		{
			if (!$res = $this->findById($id))
			{
				if ($res === null)
				{
					$this->error = 'Elemento de tipo ' . get_class($this->model) . ' no localizado para ' . $id;
				}
				return $res;
			}
			$sql = "delete from " . get_class($this->model) . ' where true';
			foreach ($this->model->pk() as $pk => $tipo)
			{
				if (is_array($id))
				{
					$sql .= ' and ' . $pk . ' = \'' . $id[$pk] . '\'';
				}
				else
				{
					$sql .= ' and ' . $pk . ' = \'' . $id . '\'';
				}
			}
			$consulta = new Consulta(self::$conexion);
			if (!$consulta->ejecuta($sql))
			{
				$this->error = $consulta->error();
				return false;
			}
			return true;
		}
		
		public function save_relation(Model $model, $relacion)
		{
			if (!$fk = $model->fk($relacion))
			{
				$this->error = 'La relación ' . $relacion . ' no existe';
				return false;
			}
			foreach ($model->pk() as $pk => $tipo);
			$id = $model->$pk;
			if (!$id)
			{
				$this->error = 'No se puede guardar la relación con ' . $relacion . ' porque el ID no consta';
				return false;
			}
			if (!is_array($model->$relacion) or count($model->$relacion) == 0)
			{
				return true;
			}
			$metodo2 = $fk->link_model();
			foreach ($model->$relacion as $elemento)
			{
				$id2 = $elemento;
				if (!$id2)
				{
					return false;
				}
				if (is_object($id2))
				{
					$id2 = $elemento->$metodo2;
				}
				if ($fk->link_model() == $pk)
				{
					$pk2 = $fk->link_external_model();
				}
				else
				{
					$pk2 = $fk->link_model();
				}
				$sql = 'insert into ' . $fk->model_relational() . ' (' . $pk . ', ' . $pk2 . ')';
				$sql .= ' values (\'' . $id . '\', \'' . $id2 . '\')';
				if (self::$conexion->ejecuta($sql) === false)
				{
					$this->error = self::$conexion->error();
					return false;
				}
			}
			return true;
		}
		
		public function destroy_relation(Model $model, $relacion, $todo = false)
		{
			if (!$fk = $model->fk($relacion))
			{
				return false;
			}
			foreach ($model->pk() as $pk => $tipo);
			$id = $model->$pk;
			if (!$id)
			{
				return false;
			}
			$sql1 = 'delete from ' . $fk->model_relational() . ' where ' . $pk . ' = \'' . $id . '\'';
			if ($todo)
			{
				if (self::$conexion->ejecuta($sql1) === false)
				{
					$this->error = self::$conexion->error();
					return false;
				}
			}
			else
			{
				$metodo2 = $fk->link_model();
				foreach ($model->$relacion as $elemento)
				{
					$id2 = $elemento->$metodo2();
					if (!$id2)
					{
						return false;
					}
					if ($fk->link_model() == $pk)
					{
						$pk2 = $fk->link_external_model();
					}
					else
					{
						$pk2 = $fk->link_model();
					}
					$sql .= $sql1 . ' and ' . $pk2 . ' = \'' . $id2 . '\'';
					if (self::$conexion->ejecuta($sql) === false)
					{
						$this->error = self::$conexion->error();
						return false;
					}
				}
			}
			return true;
		}
		
		public function exist_relation(Model $model, $relacion)
		{
			if (!$fk = $model->fk($relacion))
			{
				return false;
			}
			foreach ($model->pk() as $pk => $tipo);
			$id = $model->$pk;
			if (!$id)
			{
				return false;
			}
			if (!is_array($model->$relacion) or count($model->$relacion) == 0)
			{
				return true;
			}
			$metodo2 = $fk->link_model();
			foreach ($model->$relacion as $elemento)
			{
				$id2 = $elemento->$metodo2();
				if (!$id2)
				{
					return false;
				}
				if ($fk->link_model() == $pk)
				{
					$pk2 = $fk->link_external_model();
				}
				else
				{
					$pk2 = $fk->link_model();
				}
				$sql = 'select * from ' . $fk->model_relational() . ' where ' . $pk . ' = \'' . $id 
						. '\' and ' . $pk2 . ' = \'' . $id2 . '\'';
				$consulta = new Consulta(self::$conexion);
				if (!$consulta->ejecuta($sql))
				{
					$this->error = $consulta->error();
					return false;
				}
				$registro = $consulta->lee_registro();
				if (!$registro)
				{
					return false;
				}
				return true;
			}
			return true;
		}
		
		private static function sql_clase_padre(& $sql, Model $model, $id = null)
		{
			$clasePadre = get_parent_class($model);
			if ($clasePadre and $clasePadre != 'Model')
			{
				$modelPadre = new $clasePadre();
				foreach ($modelPadre->pk() as $pk => $tipo);
				if ($id)
				{
					if (is_array($id))
					{
						$id = $id[$pk];
					}
					$sql .= ' inner join ' . $clasePadre . ' padre on (padre.' . $pk . ' = \'' . $id . '\')';
				}
				else
				{
					$sql .= ' inner join ' . $clasePadre . ' padre on (padre.' . $pk . ' = model.' . $pk . ')';
				}
			}
		}
	}