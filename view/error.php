<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php $TITULO_PAGINA = 'Error'; ?>
 		<?php include PATH_VIEW . 'includes/head.php'; ?>
	</head>
	<body>
		<h1>Error</h1>
		<?php if ($error) { ?>
			<div class="error">
				<?php echo formato_html($error); ?>
			</div>
		<?php }else{ ?>
			<div>
				Error no especificado
			</div>
		<?php } ?>
	</body>
</html>