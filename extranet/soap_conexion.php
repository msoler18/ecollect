<?php 
error_reporting(0);

include("lib/nusoap.php");

//$client = new nusoap_client('http://pruebas.sincoerp.com/SincoProksol_PRBINT/ERPNet/CBR/Comunicaciones/WebServices/Extranet/ExtranetService.svc?WSDL', true);
$client = new nusoap_client('http://www.sincoerp.com/SincoProksol//ERPNet/CBR/Comunicaciones/WebServices/Extranet/ExtranetService.svc?wsdl', true);

$client->soap_defencoding = 'UTF-8';

?>