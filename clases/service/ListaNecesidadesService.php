<?php
	class ListaNecesidadesService extends Service
	{
		public function lista_usuario(Usuario $usuario, $planSemanal)
		{
			$lista = array();
			foreach ($planSemanal as $planDia)
			{
				foreach ($planDia as $planComida)
				{
					foreach ($planComida as $plan)
					{
						$alimentos = null;
						$plato = null;
						if ($plan->alimento)
						{
							//en la despensa?
							if (!isset($usuario->despensa[$plan->alimento->id_alimento]))
							{
								//en la lista de la compra?
								if (!isset($usuario->lista_compra[$plan->alimento->id_alimento]))
								{
									$alimentos[] = $plan->alimento;
								}
							}
						}
						elseif ($plan->plato)
						{
							foreach ($plan->plato->ingredientes as $ingrediente)
							{
								//en la despensa?
								if (!isset($usuario->despensa[$ingrediente->alimento->id_alimento]))
								{
									//en la lista de la compra?
									if (!isset($usuario->lista_compra[$ingrediente->alimento->id_alimento]))
									{
										$alimentos[] = $ingrediente->alimento;
										$plato = $plan->plato;
									}
								}
							}
						}
						if ($alimentos)
						{
							foreach ($alimentos as $alimento)
							{
								$listaNecesidad = new ListaNecesidades();
								$listaNecesidad->alimento = $alimento;
								if ($plato)
								{
									$listaNecesidad->plato = $plato;
								}
								$lista[$alimento->nombre_alimento] = $listaNecesidad;
							}
						}
					}
				}
			}
			ksort($lista);
			return $lista;
		}
	}