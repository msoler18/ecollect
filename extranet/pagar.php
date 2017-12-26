<?php session_start(); ?>
<html>
	<head>
		<title>Proksol - pagar</title>
	</head>
	<body>
<?php 
	$url = 'http://pruebascolor2.com/proksol/';
	if(isset($_SESSION['url_pagar'])) :
 ?>


	<a href="<?php echo $url ?>extranet/index.php">Regresar a proksol</a>
	<iframe src="<?php echo $_SESSION['url_pagar']; ?>" width="100%" height="100%" frameborder="0">
	</iframe>
	

<?php else : ?>

	<script type="text/javascript">
		window.location.href = '<?php echo $url; ?>';
	</script>

<?php endif; ?>
	</body>
</html>