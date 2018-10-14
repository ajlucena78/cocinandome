<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="refresh" content="1;url=<?php echo vlink('show_login'); ?>" />
		<?php $TITULO_PAGINA = 'Redireccionando...'; ?>
 		<?php include PATH_VIEW . 'includes/head.php'; ?>
 		<script type="text/javascript" src="<?php echo URL_APP; ?>view/js/ajax.js"></script>
	</head>
	<body>
		<?php carga('activa_javascript'); ?>
		<script type="text/javascript">
			window.location.href = "<?php echo vlink('show_login'); ?>";
		</script>
		<noscript>
			<h1><a href="<?php echo vlink('show_login'); ?>">Ir al inicio</a></h1>
		</noscript>
	</body>
</html>