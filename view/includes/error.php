<h2>Error</h2>
<?php if ($error) { ?>
	<div class="error">
		<?php echo formato_html($error); ?>
	</div>
<?php }else{ ?>
	<div>
		Error no especificado
	</div>
<?php } ?>