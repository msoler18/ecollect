
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
			
	<div class="clearfix">


		<!-- Logo -->

		<nav class="logo_block">
			
		<a class="logo " href="http://pruebascolor2.com/proksol/"><img alt="Logo Proksol" src="http://pruebascolor2.com/proksol/assets/img/logo.png"></a>

		</nav>

		<!-- Login -->
		<nav class="login_block">
		<div class="usuario">
			<?php echo $result['CompradorResult']['lstComprador']['Comprador']['Nombre'].'&nbsp;&nbsp;&nbsp; <br>C.C '.$result['CompradorResult']['lstComprador']['Comprador']['Identificacion']; ?>
		</div>  
			<a href="logout.php" class="login" >CERRAR<br>SESI&Oacute;N</a>

		</nav>	

	</div>	

</header>