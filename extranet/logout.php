<?php 
	session_start();
	session_destroy();
	$url = 'http://www.proksol.com/';
	header("Location: {$url}");
	exit();
 ?>	