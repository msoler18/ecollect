<?php 
//session_destroy();
session_start();

$url = 'http://www.proksol.com';


require_once '../config/init.php';




if(isset($_POST) and !isset($_SESSION['login'])  ) :
	
	
	$_SESSION['login'] = true;
	$_SESSION['pass_usuario'] = $_POST['pass_usuario'];
    $_SESSION['nombre_usuario'] = $_POST['nombre_usuario'];

    unset($_POST);

endif;



if(!isset($_SESSION['login'])) :


	// header("Location: {$url}");
	// exit();

else :

	

?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta content="width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0" name="viewport">
		<title>Proksol</title>
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


include('soap_conexion.php');

			//Obtener id usuario login
			
			$parameters = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/" xmlns:sin="http://schemas.datacontract.org/2004/07/Sinco.ERP.CBR.Comunicaciones.WebServices.Extranet">
						   <soapenv:Header/>
						   <soapenv:Body>
						      <tem:Login>
						         <!--Optional:-->
						         <tem:login>
						            <!-- Contraseña -->
						            <sin:Clave>'.$_SESSION['pass_usuario'].'</sin:Clave>
						            <!-- Cedula -->
						            <sin:NitComprador>'.$_SESSION['nombre_usuario'].'</sin:NitComprador>
						         </tem:login>
						      </tem:Login>
						   </soapenv:Body>
						</soapenv:Envelope>';

			$soapaction = "http://tempuri.org/IExtranetService/Login";
			$result = $client->send($parameters, $soapaction);

			//  si esta logeado
			//echo $result['LoginResult']['Logeado'];exit;
			if($result['LoginResult']['Logeado'] == 'true') :

				$_SESSION['id_usuario'] = $result['LoginResult']['IdComprador'];
				//obtener proyectos
				$parameters_proyectos = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/" xmlns:sin="http://schemas.datacontract.org/2004/07/Sinco.ERP.CBR.Comunicaciones.WebServices.Extranet">
										   <soapenv:Header/>
										   <soapenv:Body>
										      <tem:Proyectos>
										         <!--Optional:-->
										         <tem:proyecto>
										            <sin:Comprador>'.$_SESSION['id_usuario'].'</sin:Comprador>
										         </tem:proyecto>
										      </tem:Proyectos>
										   </soapenv:Body>
										</soapenv:Envelope>';
				$soapaction_proyectos = "http://tempuri.org/IExtranetService/Proyectos";
				$result_proyectos = $client->send($parameters_proyectos, $soapaction_proyectos);


				

				// si tiene un proyecto
				//var_dump($result_proyectos['ProyectosResult']['lstProyecto']['Proyecto']);
				if(!empty($result_proyectos['ProyectosResult']['lstProyecto']['Proyecto'])) :
					if(!array_key_exists(0,$result_proyectos['ProyectosResult']['lstProyecto']['Proyecto'])):
						$result_proyectos['ProyectosResult']['lstProyecto']['Proyecto'] = Array($result_proyectos['ProyectosResult']['lstProyecto']['Proyecto']);
						endif;

					$_SESSION['id_primer_proyecto'] = $result_proyectos['ProyectosResult']['lstProyecto']['Proyecto'][0]['Id'];
					$_SESSION['proyectos']          = $result_proyectos['ProyectosResult']['lstProyecto']['Proyecto'];
					$parameters1 = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/" xmlns:sin="http://schemas.datacontract.org/2004/07/Sinco.ERP.CBR.Comunicaciones.WebServices.Extranet">
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

					$soapaction1 = "http://tempuri.org/IExtranetService/Comprador";
					$result1 = $client->send($parameters1, $soapaction1); 

					// echo '<pre>';
					// 	var_dump(empty($result1['CompradorResult']['lstComprador']));
					// echo '</pre>';	

						//  Si tiene datos como comprador
						if(!empty($result1['CompradorResult']['lstComprador'])) :

							?>
							<header>
								<?php add_widget('menu_top'); ?>
							</header>


							<!-- <header>
								<div class="menu_block">
									<div class="header_menu">
										
										<nav class="logo_block">
											<a class="logo" href="http://pruebascolor2.com/proksol/"><img alt="Logo Proksol" src="../assets/img/logo.png"></a>
											<div class="linea_logo"></div>
										</nav>
										<ul>
											<li>
												<a href="http://pruebascolor2.com/proksol/nuestros_proyectos">Proyectos</a>
												<span ><i class="fa fa-angle-right"></i></span>
											</li>
											<li><a href="http://pruebascolor2.com/proksol/quienes_somos">¿Quiénes somos?</a></li>
											<li><a href="http://pruebascolor2.com/proksol/servicios">Servicios</a></li>
											<li><a href="http://pruebascolor2.com/proksol/clientes">Clientes</a></li>
											<li><a href="http://pruebascolor2.com/proksol/noticias/">Noticias</a></li>
											<li><a href="http://pruebascolor2.com/proksol/contactenos">Cont&aacute;ctenos</a></li>
											<li class="zona_clientes"><a href="#">ZONA CLIENTES</a></li>
										</ul>
									</div>
								</div>
							</header> -->
							<div class="two">
								<div class="content">
									<div class="titulo">
										<span>
											NUESTRO
										</span>
										<span>
											PORTAL
										</span>
										<span>
											Escoge la opción que deseas realizar
										</span>
									</div>
									<div class="extranet">
										<a href="<?php echo $url ?>/extranet/extranet.php">CONSULTA</a>
									</div>
									<div class="pagar">
										<?php
										$wsdl = "https://gateway3.e-collect.com/eCollectAgentV2/webservice/eCollectCustomersAgentv1.asmx?WSDL"; 
		    							$soap = new nusoap_client($wsdl, true);

									    $parameters2 = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ecol="http://www.avisortech.com/eCollectCustomersAgentServices" xmlns:ecol1="http://www.avisortech.com/eCollectAgentServices">
									   <soapenv:Header/>
									   <soapenv:Body>
									      <ecol:getUserExternalLogin>
									         <!--Optional:-->
									       <ecol:request>
									            <!--Optional:-->
									            <ecol1:EntityCode>10442</ecol1:EntityCode>
									            <!--Optional:-->
									            <ecol1:ParentPerId1>'.$result1['CompradorResult']['lstComprador']['Comprador']['Identificacion'].'</ecol1:ParentPerId1>
									            <!--Optional:-->
									            <ecol1:ParentPerId2></ecol1:ParentPerId2>
									            <!--Optional:-->
									            <ecol1:ParentPerName>'.$result1['CompradorResult']['lstComprador']['Comprador']['Nombre'].'</ecol1:ParentPerName>
									            <!--Optional:-->
									            <ecol1:ParentPerLast></ecol1:ParentPerLast>
									            <!--Optional:-->
									            <ecol1:ParentPerEmail></ecol1:ParentPerEmail>
									            <!--Optional:-->
									            <ecol1:ParentProfileCode>1</ecol1:ParentProfileCode>
									            <!--Zero or more repetitions:-->
									            <ecol1:Reference1Array>
									               <!--Optional:-->
									               <ecol1:ChildPerId></ecol1:ChildPerId>
									               <!--Optional:-->
									               <ecol1:ChildPerName></ecol1:ChildPerName>
									               <!--Optional:-->
									               <ecol1:ChildPerLast></ecol1:ChildPerLast>
									               <!--Optional:-->
									               <ecol1:ChildPerEmail></ecol1:ChildPerEmail>
									               <!--Zero or more repetitions:-->
									               <ecol1:Reference2Array>
									                  <!--Optional:-->
									                  <ecol1:Reference2></ecol1:Reference2>
									                  <!--Optional:-->
									                  <ecol1:Reference2Desc></ecol1:Reference2Desc>
									                  <!--Optional:-->
									                  <ecol1:Reference2Email></ecol1:Reference2Email>
									                  <!--Optional:-->
									                  <ecol1:ServiceCode></ecol1:ServiceCode>
									                  <!--Zero or more repetitions:-->
									                  <ecol1:Reference3Array>
									                     <!--Optional:-->
									                     <ecol1:Reference3>null</ecol1:Reference3>
									                     <!--Optional:-->
									                     <ecol1:Reference3Desc>null</ecol1:Reference3Desc>
									                     <!--Optional:-->
									                     <ecol1:Reference3Email>null</ecol1:Reference3Email>
									                     <!--Optional:-->
									                     <ecol1:ServiceCode>null</ecol1:ServiceCode>
									                  </ecol1:Reference3Array>
									               </ecol1:Reference2Array>
									            </ecol1:Reference1Array>
									            <!--Optional:-->
									            <ecol1:AdditionalInfoArray>
									               <!--Zero or more repetitions:-->
									               <ecol1:string></ecol1:string>
									            </ecol1:AdditionalInfoArray>
									         </ecol:request>
									      </ecol:getUserExternalLogin>
									   </soapenv:Body>
									</soapenv:Envelope>';

									$soapaction2 = "http://www.avisortech.com/eCollectCustomersAgentServices/getUserExternalLogin";
									$result2 = $soap->send($parameters2, $soapaction2);

									$_SESSION['url_pagar'] = $result2['getUserExternalLoginResult']['URLRedirect'];

								 	?>

								 	<a href="<?php echo $_SESSION['url_pagar']; ?>" target="_blank">PAGOS ONLINE</a>

									</div>
								</div>
							</div>


							<?php

						else :
							echo '<div class="error">

								<p>El cliente no tiene registro de datos de comprador</p>
								<a href="'.$url.'">Regresar a proksol</a>

								</div>';
						endif;

				else :

					echo '<div class="error">

						<p>Este cliente no tiene proyectos</p>
						<a href="'.$url.'">Regresar a proksol</a>

					</div>';

				endif;

			else : 
				session_destroy();
				echo '<div class="error">

						<p>Datos erroneos favor intentarlo de nuevo</p>
						<a href="'.$url.'">Regresar a proksol</a>
				</div>';

			endif;


endif; ?>
	
		<footer>
			
		<!-- Address Block -->

			<address>
				<b>Visítenos en:</b> Calle 97 Nº 23-60 Ofincina 201 <b>PBX:</b> (57+1) 795 3010 Ext: 4181  <b>CEL:</b> <a href="tel:+573107888888">310 788 8888</a>
			</address>

			<!--  Social Block -->

			<div class="social_block">

			<p>Siguenos en:</p>
			<div class="icons">

			<a href="https://www.facebook.com/Proksol" target="_blank"><i class="fa fa-facebook"></i></a>
			<a href="https://www.youtube.com/user/ProksolConstructora" target="_blank"><i class="fa fa-youtube"></i></a>
			<a href="https://plus.google.com/+ProksolConstructora/posts" target="_blank"><i class="fa fa-google-plus"></i></a>	

			</div>

			</div>	
		</footer>
		<script src="assets/js/acordeon/external/jquery/jquery.js"></script>
		<script src="assets/js/acordeon/jquery-ui.js"></script>
		<script type="text/javascript">
			
		$( "#accordion" ).accordion({
		  animate: 500
		});
		</script>
	</body>
</html>

<!-- <html>
					<head>
						<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
						<title></title>
						<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.css"/>
						<link href="assets/css/style.css" rel="stylesheet" type="text/css" />
					</head>
					<body>
						<?php /*include('header.php'); ?>
					<section class="conteiner">
						<div class="contenedor_acordeon">
							<h1>BIENVENIDO <br><span>a su portal.</span> </h1>
						</div>
						<div class="acordeon">
							<div class="contenedor_acordeon">
								<h2>Estos son los proyectos de los que usted hace parte:</h2>
									<div id="accordion">
										
										<?php foreach ($result_proyectos['ProyectosResult']['lstProyecto']['Proyecto'] as $key => $value) {?>

											<h3><?php echo $value['Nombre']; ?></h3>
											<div class="contenido">
												<div class="izq">
													<?php 
													//obtener descripcion de proyectos
														$parameters_desc_proyectos = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/" xmlns:sin="http://schemas.datacontract.org/2004/07/Sinco.ERP.CBR.Comunicaciones.WebServices.Extranet">
																   <soapenv:Header/>
																   <soapenv:Body>
																      <tem:ProyectoDetalle>
																         <!--Optional:-->
																         <tem:proyecto>
																            <sin:Proyecto>'.$value['Id'].'</sin:Proyecto>
																         </tem:proyecto>
																      </tem:ProyectoDetalle>
																   </soapenv:Body>
																</soapenv:Envelope>';
														$soapaction_desc_proyectos = "http://tempuri.org/IExtranetService/ProyectoDetalle";
														$detalle_pro = $client->send($parameters_desc_proyectos, $soapaction_desc_proyectos);	 ?>

													Nombre: <?php echo $value['Nombre']; ?><br>
													Direcci&oacute;n: <?php echo $detalle_pro['ProyectoDetalleResult']['lstProyectoDetalle']['ProyectoDetalle']['Direccion']; ?><br>
													Tel&eacute;fono: <?php echo $detalle_pro['ProyectoDetalleResult']['lstProyectoDetalle']['ProyectoDetalle']['Telefono']; ?><br>
													Ciudad: <?php echo $detalle_pro['ProyectoDetalleResult']['lstProyectoDetalle']['ProyectoDetalle']['Ciudad']; ?><br>
													Horario: <?php echo $detalle_pro['ProyectoDetalleResult']['lstProyectoDetalle']['ProyectoDetalle']['Horario']; ?><br>
													Estrato: <?php echo $detalle_pro['ProyectoDetalleResult']['lstProyectoDetalle']['ProyectoDetalle']['Estrato']; ?><br>
													Entidad Cr&eacute;dito: <?php echo $detalle_pro['ProyectoDetalleResult']['lstProyectoDetalle']['ProyectoDetalle']['EntidadCredito']; ?><br>
													Porcentaje Financiaci&oacute;n: <?php echo $detalle_pro['ProyectoDetalleResult']['lstProyectoDetalle']['ProyectoDetalle']['PorcentajeFinanciacion'].'%'; ?><br>
												</div>
												<div class="der">
													<a href="inmuebles.php?id_pro=<?php echo $value['Id']; ?>">
														<img src="assets/img/ver_inmueble-02.png" style="border:0">	
													</a>
												</div>
											</div>

										<?php } ?>


									</div>
							</div>
						</div>
						
					</section>

						<?php include('footer.php');*/ ?>
					</body>
				</html> -->






