<?php
	class ComentarioPlatoService extends Service
	{
		/**
		 * Valida un comentario dado para autorizar su alta o edición en la base de datos
		 * @param ComentarioPlato $comentario
		 */
		public function valida(ComentarioPlato $comentario)
		{
			if (!$comentario->id_comentario)
			{
				$this->error = 'El identificador del comentario es obligatorio';
				return false;
			}
			if (!is_object($comentario->usuario) or !$comentario->usuario->id_usuario)
			{
				$this->error = 'El identificador del usuario que comenta es necesario';
				return false;
			}
			if (!is_object($comentario->plato) or !$comentario->plato->id_plato)
			{
				$this->error = 'El identificador del plato a comentar no ha sido indicado';
				return false;
			}
			if (!$comentario->fecha)
			{
				$this->error = 'La fecha del comentario es obligatoria';
				return false;
			}
			if (!$comentario->comentario)
			{
				$this->error = 'Es necesario indicar un texto en el comentario';
				return false;
			}
			return true;
		}
	}