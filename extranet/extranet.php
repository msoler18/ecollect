<?php session_start(); 

require_once '../config/init.php';

?>

<html>
<head>
	<title>Datos extranet</title>
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
	<style type="text/css">
	.cambioPass{
	   background-color: #f6c908;
    /* float: right; */
    height: 28px;
    padding-left: 0px;
    padding-top: 11px;
    text-align: center;
    width: 145px;
    position: absolute;
    right: 0px;
    top: 77px;
}
	

	.cambioPass span{
		color: rgba(0,0,0,0.4);
	    font-family: 'bebas_neuebold';
	    font-size: 16px;
	    text-decoration: none;
	}
	input{
    color: #000000;
    height: 45px;
    margin-bottom: 10px;
    padding-left: 20px;
    width: 75%;
    font-family: 'HelveticaNeueLTStd-Cn';
    font-size: 15px;

	}
	input:focus{
		outline: none;
	 background-color: #DDD;
	}
	label{
    font-size: 19px;
    color: #656565;
	}
	#cerrar{
    margin: -8px 0 0 85%;
    font-size: 19px;
    color: CCC;
	}
	#cambiarPass{
    background: #52748a;
    border: none;
    color: #ffffff;
    height: 75px;
    width: 75%;
    appearance: none;
    -moz-appearance: none;
    -webkit-appearance: none;
    font-family: 'bebas_neue_regularregular';
    font-size: 32px;
	}
 
	</style>
	<script type="text/javascript">
	$(document).ready(function(){
		//FUNCION DE MODAL
		  var alerta = function (mensaje) { 
	     $.blockUI({ message:'<form method="post" id="frmCamioPass"><i class="fa fa-close" id="cerrar"></i><input placeholder="Contraseña" type="password"name="actuPassword" id="actuPassword" required=""><input type="password" placeholder="Nueva Contraseña" name="newPassword" id="newPassword" required=""><input placeholder="Confirmar Contraseña" type="password"  name="newPasswordC" id="newPasswordC" required=""><input type="hidden" name="idUser" value="<?php echo $_SESSION['id_usuario'] ?>" required=""><button type="button" id="cambiarPass">Enviar</button></form><div id="mensajeCambio"></div>',
	        css: { 
	        cursor:  'pointer',
	        border: 'none', 
	        padding: '15px', 
	        backgroundColor: '#FFF', 
	        '-webkit-border-radius': '0px', 
	        '-moz-border-radius': '0px', 
	        opacity: 1, 
	        color: '#000',
	        'font-family': 'HelveticaNeueLTStd-Cn',
	        padding: '40px 0 40px'
	    } });
			$("#cerrar").click(function(){
	      $.unblockUI();
	    });
	    $("#cambiarPass").click(function(){
	    	var nueva = $("#newPassword").val();
				var confir = $("#newPasswordC").val();
				var actual = $("#actuPassword").val();
				if(nueva!="" && confir!="" && actual!=""){
					if(nueva==confir){
						$.ajax({
							url:'cambioContrasena.php',
							data:$("#frmCamioPass").serialize(),
							method:'post'
						}).success(function(resp){
							if(resp=="true"){
								$("#mensajeCambio").text("Contraseña cambiada con éxito");
								setTimeout(function(){ $.unblockUI(); }, 1500);
							}else{
								$("#mensajeCambio").text("Error al cambiar la contraseña.  \n Por favor valide los datos");
							}
						})
					}else{
						$("#mensajeCambio").text("Las contraseñas no coinciden");
					}
				}else{
					$("#mensajeCambio").text("Por favor complete todos los datos");
				}
	    }); 
	    	//CUANDO LE CLICK AL BOTON DE CAMBIAR CONTRASEÑA
		$(".cambiarPass").click(function(){
			
		});
		}
		$(".cambioPass").click(function(){
			var form = $("#form").html();
			alerta(form);
			//$("#form").fadeIn(1000);
		});
	
	});
	</script>
</head>
<body>
<?php 
	$url = 'http://www.proksol.com/extranet';
	


	if(isset($_SESSION['proyectos'])) :
		$url = 'http://www.proksol.com/extranet';

	//Obtener id usuario login
	include('soap_conexion.php');
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
</header>

<section class="conteiner">
	<div class="header">
		<div class="volver">
			<a href="http://www.proksol.com/extranet/index.php"><i class="fa fa-long-arrow-left"></i></a>
		</div>
		<div class="usuario">
			<?php echo $result['CompradorResult']['lstComprador']['Comprador']['Nombre'].'&nbsp;&nbsp;&nbsp; <br> <span>C.C '.$result['CompradorResult']['lstComprador']['Comprador']['Identificacion'].'</span>'; ?>
		</div>
		<div class="cerrar_sesion">
			<a href="logout.php" class="login" >CERRAR SESI&Oacute;N</a>
		</div>
		
		<!-- <div class="miga_pan">
			<ul>
				<li><b>Mis Proyectos</b></li>
			</ul>
		</div> -->
	</div>
	<div class="cambioPass">
		<span>CAMBIAR CONTRASEÑA</span>
		
	</div>
	<div id="form" style="display:none">
		
	</div>
	<div class="contenedor_acordeon1" id="fondo_proyectos">
		<div class="dat">
			<span>
				MIS	
			</span>
			<span>
				PROYECTOS
			</span>
			<span>
				Estos son los proyectos de los que usted hace parte
			</span>
		</div>
	</div>
	<div class="acordeon">
		<div class="contenedor_acordeon">
				<div id="accordion">
					
					<?php 
					//print_r($_SESSION['proyectos']);
					foreach ($_SESSION['proyectos'] as $key => $value) {?>

						<h3><?php echo $value['Nombre']; ?></h3>
						<div class="contenido" style="height: 175px !important; padding-bottom: 63px !important;">
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

								<b>Nombre: </b><?php echo utf8_encode($value['Nombre']); ?><br>
								<b>Direcci&oacute;n: </b><?php echo utf8_encode($detalle_pro['ProyectoDetalleResult']['lstProyectoDetalle']['ProyectoDetalle']['Direccion']); ?><br>
								<b>Tel&eacute;fono: </b><?php echo $detalle_pro['ProyectoDetalleResult']['lstProyectoDetalle']['ProyectoDetalle']['Telefono']; ?><br>
								<b>Ciudad: </b><?php echo utf8_encode($detalle_pro['ProyectoDetalleResult']['lstProyectoDetalle']['ProyectoDetalle']['Ciudad']); ?><br>
								<b>Horario: </b><?php echo $detalle_pro['ProyectoDetalleResult']['lstProyectoDetalle']['ProyectoDetalle']['Horario']; ?><br>
								<b>Estrato: </b><?php echo $detalle_pro['ProyectoDetalleResult']['lstProyectoDetalle']['ProyectoDetalle']['Estrato']; ?><br>
								<b>Entidad Cr&eacute;dito: </b><?php echo $detalle_pro['ProyectoDetalleResult']['lstProyectoDetalle']['ProyectoDetalle']['EntidadCredito']; ?><br>
 								<b>Porcentaje Financiaci&oacute;n: </b><?php echo $detalle_pro['ProyectoDetalleResult']['lstProyectoDetalle']['ProyectoDetalle']['PorcentajeFinanciacion'].'%'; ?><br><br><br>
							</div>
							<div class="der">
								<a href="inmuebles.php?id_pro=<?php echo $value['Id']; ?>">
									VER INMUEBLE
								</a>
							</div>
						</div>

					<?php } ?>


				</div>
		</div>
	</div>
	
</section>


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
<script src="<?php echo URL; ?>js/blockUI.js"></script>

<script type="text/javascript">
	
$( "#accordion" ).accordion({
  animate: 500
});
</script>


<?php else : ?>

	<script type="text/javascript">
		window.location.href = '<?php echo $url; ?>';
	</script>

<?php endif; ?>

</body>
</html>