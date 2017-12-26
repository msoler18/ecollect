<?php
ini_set('display_errors', 'On');
ini_set('display_errors', 1);
require_once '../config/init.php';
$varPost = filter_input_array(INPUT_POST);
include('soap_conexion.php');
$parameters = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/" xmlns:sin="http://schemas.datacontract.org/2004/07/Sinco.ERP.CBR.Comunicaciones.WebServices.Extranet">
					   <soapenv:Header/>
					   <soapenv:Body>
					      <tem:CambioClave>
					         <!--Optional:-->
					         <tem:cambioClave>
					            <sin:ClaveActual>'.$varPost['actuPassword'].'</sin:ClaveActual>
					            <sin:ClaveNueva>'.$varPost['newPassword'].'</sin:ClaveNueva>
					            <sin:Comprador>'.$varPost['idUser'].'</sin:Comprador>
					         </tem:cambioClave>
					      </tem:CambioClave>
					   </soapenv:Body>
					</soapenv:Envelope>';
	$soapaction = "http://tempuri.org/IExtranetService/CambioClave";
	$result = $client->send($parameters, $soapaction);

	 echo  $result['CambioClaveResult']['Cambio'];
