<?php 
session_start();
if(!isset($_SESSION['id_usuario'])) {
	echo '<script>location.href="index.php";</script>';
}

include('soap_conexion.php');

require_once '../config/init.php';


//obtener inmuebles
 $parameters_cartera = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/" xmlns:sin="http://schemas.datacontract.org/2004/07/Sinco.ERP.CBR.Comunicaciones.WebServices.Extranet">
								   <soapenv:Header/>
								   <soapenv:Body>
								      <tem:Cartera>
								         <!--Optional:-->
								         <tem:cartera>
								            <sin:Comprador>'.$_SESSION['id_usuario'].'</sin:Comprador>
							            	<sin:Inmueble>'.$_GET['id_inmueble'].'</sin:Inmueble>
								         </tem:cartera>
								      </tem:Cartera>
								   </soapenv:Body>
								</soapenv:Envelope>';
$soapaction_cartera = "http://tempuri.org/IExtranetService/Cartera";
$detalle_cartera = $client->send($parameters_cartera, $soapaction_cartera); 

?>

<html>
<head>
	<title>Inmuebles</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta content="width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0" name="viewport">
	<!-- <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.css"/>
	<link href="assets/css/style.css" rel="stylesheet" type="text/css" />
	<link href="../assets/css/color.css" rel="stylesheet" type="text/css" /> -->

	<link rel="icon" type="image/png" href="<?php echo URL; ?>assets/img/img_favicon.ico" />

	<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.css"/>
	<link href="assets/css/style.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo URL; ?>assets/css/color.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo URL; ?>assets/css/media.css" rel="stylesheet" type="text/css" />
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
</head>
<body>
	<?php 
		//Obtener id usuario login


		$parameters = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/" xmlns:sin="http://schemas.datacontract.org/2004/07/Sinco.ERP.CBR.Comunicaciones.WebServices.Extranet">
						   <soapenv:Header/>
						   <soapenv:Body>
						      <tem:Comprador>
						         <!--Optional:-->
						         <tem:comprador>
						            <sin:Comprador>'.$_SESSION['id_usuario'].'</sin:Comprador>
						            <sin:Venta>'.$_SESSION['id_primer_proyecto'].'</sin:Venta>
						         </tem:comprador>
						      </tem:Comprador>
						   </soapenv:Body>
						</soapenv:Envelope>';

		$soapaction = "http://tempuri.org/IExtranetService/Comprador";
		$result = $client->send($parameters, $soapaction);
	?>
	<header>
		<?php add_widget('menu_top'); ?>
		<!-- <div class="menu_block">
			<div class="header_menu">
				
				<nav class="logo_block">
					<a class="logo" href="http://www.proksol.com/"><img alt="Logo Proksol" src="../assets/img/logo.png"></a>
					<div class="linea_logo"></div>
				</nav>
				<ul>
					<li>
						<a href="http://www.proksol.com/nuestros_proyectos">Proyectos</a>
						<span ><i class="fa fa-angle-right"></i></span>
					</li>
					<li><a href="http://www.proksol.com/quienes_somos">¿Quiénes somos?</a></li>
					<li><a href="http://www.proksol.com/servicios">Servicios</a></li>
					<li><a href="http://www.proksol.com/clientes">Clientes</a></li>
					<li><a href="http://www.proksol.com/noticias/">Noticias</a></li>
					<li><a href="http://www.proksol.com/contactenos">Cont&aacute;ctenos</a></li>
					<li class="zona_clientes"><a href="#">ZONA CLIENTES</a></li>
				</ul>
			</div>
		</div> -->
	</header><!-- /header -->

	
	<section class="conteiner">
		<div class="header">
			<div class="volver">
				<a href="http://www.proksol.com/extranet/extranet.php"><i class="fa fa-long-arrow-left"></i></a>
			</div>
			<div class="usuario">
				<?php echo $result['CompradorResult']['lstComprador']['Comprador']['Nombre'].'&nbsp;&nbsp;&nbsp; <br> <span>C.C '.$result['CompradorResult']['lstComprador']['Comprador']['Identificacion'].'</span>'; ?>
			</div>
			<div class="cerrar_sesion">
				<a href="logout.php" class="login" >CERRAR SESI&Oacute;N</a>
			</div>
			<!-- <div class="miga_pan">
				<ul>
					<li><a href="extranet.php">Mis Proyectos</a></li>
					<li><a href="#">/</a></li>
					<li><a href="inmuebles.php">Mis inmuebles</a></li>
					<li><a href="#">/</a></li>
					<li><b>Mi Estado de Cuenta</b></li>
				</ul>
			</div> -->
		</div>
		<div class="contenedor_acordeon1" id="fondo_estado_cuenta">
			<div class="dat">
				<span>
					MI ESTADO
				</span>
				<span>
					DE CUENTA
				</span>
				<span>
					Este es el estado de su cuenta
				</span>
			</div>
		</div>
		<div class="acordeon">
			<div class="contenedor_estado_cuenta">
				<h2>Este es su estado de cuenta:</h2>
					<div id="accordion">
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
						  <tr class="encabezado">
						    <td><div>NOMBRE</div></td>
						    <td><div>FECHA</div></td>
						    <td><div>VALOR</div></td>
						    <td><div>DOCUMENTO</div></td>
						    <td><div>FECHA DOCUMENTO </div></td>
						    <td><div>VALOR DOCUMENTO</div></td>
						  </tr>
						<?php foreach ($detalle_cartera['CarteraResult']['lstConceptos']['Concepto'] as $key => $value) {?>
						 <tr class="listado">
						    <td><?php echo utf8_encode($value['Nombre'])	; ?></td>
						    <td><?php echo $value['FechaPago']; ?></td>
						    <td><?php echo '$ '.number_format($value['Valor'], 0, ',', '.'); ?></td>
						    <td><?php echo $value['Documento']; ?></td>
						    <td><?php echo $value['FechaDocumento']; ?></td>
						    <td><?php echo '$ '.number_format($value['ValorDocumento'], 0, ',', '.'); ?></td>
						  </tr>
						<?php } ?>
						</table>

					</div>
			</div>
		</div>
	</section>

	<?php include('footer.php'); ?>
</body>
</html>
