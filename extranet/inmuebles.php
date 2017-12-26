<?php 
session_start();

if(!isset($_SESSION['id_usuario'])) {
	echo '<script>location.href="index.php";</script>';
}
include('soap_conexion.php');

require_once '../config/init.php';

//obtener inmuebles
 $parameters_inmuebles = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/" xmlns:sin="http://schemas.datacontract.org/2004/07/Sinco.ERP.CBR.Comunicaciones.WebServices.Extranet">
						   <soapenv:Header/>
						   <soapenv:Body>
						      <tem:Inmuebles>
						         <!--Optional:-->
						         <tem:inmueble>
						            <sin:Comprador>'.$_SESSION['id_usuario'].'</sin:Comprador>
						            <sin:Proyecto>'.$_GET['id_pro'].'</sin:Proyecto>
						         </tem:inmueble>
						      </tem:Inmuebles>
						   </soapenv:Body>
						</soapenv:Envelope>';
$soapaction_inmuebles = "http://tempuri.org/IExtranetService/Inmuebles";
$result_inmuebles = $client->send($parameters_inmuebles, $soapaction_inmuebles);

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
					<li><b>Mis inmuebles</b></li>
				</ul>
			</div> -->
		</div>
		<div class="contenedor_acordeon1">
			<div class="dat">
				<span>
					MIS	
				</span>
				<span>
					INMUEBLES
				</span>
				<span>
					Estos son los proyectos de los que usted hace parte
				</span>
			</div>
		</div>
		<div class="acordeon">
			<div class="contenedor_acordeon">
				<h2>Estos son todos sus inmuebles:</h2>
					<div id="accordion">
						
						<?php 
						if(!array_key_exists(0,$result_inmuebles['InmueblesResult']['lstInmueble']['Inmueble'])):
						$result_inmuebles['InmueblesResult']['lstInmueble']['Inmueble'] = Array($result_inmuebles['InmueblesResult']['lstInmueble']['Inmueble']);
						endif;
						foreach ($result_inmuebles['InmueblesResult']['lstInmueble']['Inmueble'] as $key => $value) {?>

							<h3><?php echo $value['Nombre']; ?></h3>
							<div class="contenidoi" style="height: 181px !important;" >
								<div class="izq">
									<?php 
									//obtener descripcion de proyectos
									 $parameters_desc_inmuebles = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/" xmlns:sin="http://schemas.datacontract.org/2004/07/Sinco.ERP.CBR.Comunicaciones.WebServices.Extranet">
																   <soapenv:Header/>
																   <soapenv:Body>
																      <tem:InmuebleDetalle>
																         <!--Optional:-->
																         <tem:inmueble>
																            <sin:Comprador>'.$_SESSION['id_usuario'].'</sin:Comprador>
																            <sin:Inmueble>'.$value['Id'].'</sin:Inmueble>
																         </tem:inmueble>
																      </tem:InmuebleDetalle>
																   </soapenv:Body>
																</soapenv:Envelope>';
									$soapaction_desc_inmuebles = "http://tempuri.org/IExtranetService/InmuebleDetalle";
									$detalle_inmuebles = $client->send($parameters_desc_inmuebles, $soapaction_desc_inmuebles); 
									//var_dump($detalle_inmuebles);
									?>
									
									<strong>Nombre:</strong> <?php echo utf8_encode($value['Nombre']); ?><br>
									<strong>Comprador:</strong> <?php echo utf8_encode($detalle_inmuebles['InmuebleDetalleResult']['lstInmuebleDetalle']['InmuebleDetalle']['Comprador']); ?><br>
									<strong>Fecha Venta:</strong> <?php echo $detalle_inmuebles['InmuebleDetalleResult']['lstInmuebleDetalle']['InmuebleDetalle']['FechaVenta']; ?><br>
									<strong>Proyecto:</strong> <?php echo utf8_encode($detalle_inmuebles['InmuebleDetalleResult']['lstInmuebleDetalle']['InmuebleDetalle']['Proyecto']); ?><br>
									<strong>Tipo Venta:</strong> <?php echo utf8_encode($detalle_inmuebles['InmuebleDetalleResult']['lstInmuebleDetalle']['InmuebleDetalle']['TipoVenta']); ?><br>
									<strong>Nº Escritura:</strong> <?php echo $detalle_inmuebles['InmuebleDetalleResult']['lstInmuebleDetalle']['InmuebleDetalle']['NoEscritura']; ?><br>
									<strong>Subtotal:</strong> <?php echo '$ '.number_format($detalle_inmuebles['InmuebleDetalleResult']['lstInmuebleDetalle']['InmuebleDetalle']['SubTotal'], 0, ',', '.'); ?><br>
									<strong>Descuento:</strong> <?php echo '$ '.number_format($detalle_inmuebles['InmuebleDetalleResult']['lstInmuebleDetalle']['InmuebleDetalle']['Descuento'], 0, ',', '.'); ?><br>
									<strong>Valor Neto:</strong> <?php echo '$ '.number_format($detalle_inmuebles['InmuebleDetalleResult']['lstInmuebleDetalle']['InmuebleDetalle']['ValorNeto'], 0, ',', '.'); ?><br>
									<strong>Nº Encargo:</strong> <?php echo $detalle_inmuebles['InmuebleDetalleResult']['lstInmuebleDetalle']['InmuebleDetalle']['NoEncargo']; ?><br>
								</div>
								<div class="der">
									<a href="estado_cuenta.php?id_inmueble=<?php echo $value['Id']; ?>&id_pro=<?php echo $_GET['id_pro']; ?>">
										<img src="assets/img/ver_estado_cuenta-02.png" style="border:0">	
									</a>
								</div>
							</div>

						<?php } ?>


					</div>
			</div>
		</div>
		
	</section>

	<?php include('footer.php'); ?>
</body>
</html>
