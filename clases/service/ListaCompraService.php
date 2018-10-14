<?php
	class ListaCompraService extends Service
	{	
		public function lista_compra_usuario(Usuario $usuario, ListaCompra $listaCompra = null)
		{
			$sql = 'select distinct lis.*, ali.id_clase_alimento from ListaCompra lis';
			$sql .= ' join Alimento ali on (lis.id_alimento = ali.id_alimento)';
			$sql .= ' where true';
			if ($listaCompra)
			{
				if ($listaCompra->alimento)
				{
					if ($listaCompra->alimento->nombre_alimento)
					{
						$sql .= ' and ali.nombre_alimento like \'' . $listaCompra->alimento->nombre_alimento 
								. '%\'';
					}
					if ($listaCompra->alimento->clase and $listaCompra->alimento->clase->id_clase_alimento)
					{
						$sql .= ' and ali.id_clase_alimento =  \'' 
								. $listaCompra->alimento->clase->id_clase_alimento . '\'';
					}
				}
			}
			$sql .= ' and lis.id_usuario = \'' . $usuario->id_usuario . '\'';
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
				$registros[$registro['id_alimento']] = new ListaCompra($registro);
			}
			$consulta->libera();
			return $registros;
		}
	}