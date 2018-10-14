<?php
	class PlanSemanalService extends Service
	{
		public function rellena_plan(& $registros, $diaMostrar = null, & $diasMostrar = null)
		{
			if (!$diaMostrar)
			{
				$dia = 1;
				$limiteDia = 7;
			}
			else
			{
				$dia = $limiteDia = $diaMostrar;
			}
			for (; $dia <= $limiteDia; $dia++)
			{
				if (!isset($registros[$dia]))
				{
					$registros[$dia] = array('1' => array(), '2' => array(), '3' => array(), '4' => array());
				}
				else
				{
					for ($comida = 1; $comida <= 4; $comida++)
					{
						if (!isset($registros[$dia][$comida]))
						{
							$registros[$dia][$comida] = array();
						}
					}
					ksort($registros[$dia]);
					if ($diasMostrar !== null)
					{
						$diasMostrar[$dia] = true;
					}
				}
			}
			if (!$diaMostrar)
			{
				ksort($registros);
			}
			return true;
		}
	}