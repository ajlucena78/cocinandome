<div>
	<div style="width: 20%;" class="a_la_izquierda logo">
		<strong><a href="<?php echo URL_APP; ?>"><span 
				style="color: yellow;">C</span><span style="color: white;">ocinandome.es</span></a></strong>
	</div>
	<div class="a_la_derecha" style="width: 80%;">
		<div class="a_la_derecha" style="padding-top: 4px;">
			&nbsp;
			<a href="<?php vlink('perfil_usuario'); ?>"><span style="color: white;"><?php 
					echo formato_html($_SESSION['usuario']->nombre); ?></span></a>
			<a href="<?php vlink('salir'); ?>"><span style="color: red;">Desconectar</span></a>
		</div>
		<div class="a_la_derecha" style="width: 30px;">
			<a href="<?php vlink('perfil_usuario'); ?>">
				<?php if ($_SESSION['usuario']->foto) { ?>
					<img src="<?php echo URL_APP; ?>res/img/usuario/mini/<?php 
							echo $_SESSION['usuario']->foto; ?>.jpg?r=<?php echo rand(0, 100000); ?>" 
							alt="<?php echo formato_html($_SESSION['usuario']->nombre); ?>"
							style="width: 100%;" />
				<?php }else{ ?>
					<img src="<?php echo URL_APP; ?>res/img/usuario/mini/sin_foto.jpg" 
							alt="Sin foto (<?php echo formato_html($_SESSION['usuario']->nombre); ?>)" 
							style="width: 100%;" />
				<?php } ?>
			</a>
		</div>
		<div class="a_la_derecha" style="width: 12%; text-align: center; padding-top: 4px;">
			<a href="<?php vlink('invitaciones_amistad'); ?>" title="Tienes <?php 
					echo count($_SESSION['usuario']->invitaciones_amistad); ?> alertas"><span 
					id="invitaciones" style="color: white;">Alertas (
			<?php if (count($_SESSION['usuario']->invitaciones_amistad) > 0) { ?>
				<span style="color: yellow; text-decoration: blink;"><strong><?php 
					echo count($_SESSION['usuario']->invitaciones_amistad); ?></strong></span>
			<?php }else{ ?>
				<span style="color: gray;">0</span>
			<?php } ?>
			)</span></a>
		</div>
		<div class="a_la_derecha" style="width: 35%; padding-top: 1px;">
			<form name="buscador" action="<?php vlink('buscador'); ?>" method="get">
				<input type="text" class="texto_buscador" style="width: 90%; color: gray;" name="consulta" 
						value="<?php if (isset($_GET['consulta'])){echo $_GET['consulta'];}
						else{echo 'Buscar recetas o usuarios';} ?>" 
						onfocus="this.value = ''; this.style.color = 'black';" />
			</form>
		</div>
	</div>
	<div class="separador"></div>
</div>