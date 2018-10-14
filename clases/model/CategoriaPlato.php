<?php
	class CategoriaPlato extends Model
	{
		protected $id_categoria;
		protected $nombre_categoria;
		protected $foto_categoria;
		
		public function __construct($datos = null)
		{
			parent::__construct($datos);
			$this->pk['id_categoria'] = 'auto';
		}
	}