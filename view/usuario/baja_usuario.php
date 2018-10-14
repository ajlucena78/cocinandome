<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="refresh" content="5;url=<?php echo vlink('show_login'); ?>" />
		<?php $TITULO_PAGINA = 'Baja de usuario'; ?>
 		<?php include PATH_VIEW . 'includes/head.php'; ?>
	</head>
	<body>
		<script type="text/javascript">
			window.alert('Tu usuario ha sido dado de baja.\nGracias por usar nuestros servicios.');
			window.location.href = "<?php echo vlink('show_login'); ?>";
		</script>
		<noscript>
			<h1><a href="<?php echo vlink('show_login'); ?>">Ir a la p&aacute;gina principal</a></h1>
		</noscript>
	</body>
</html>