<?php

//ini_set('display_errors', 'On');
//ini_set('display_errors', 1);
require_once '../config/init.php';
$varPost = filter_input_array(INPUT_POST);
include('soap_conexion.php');
$parameters = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/" xmlns:sin="http://schemas.datacontract.org/2004/07/Sinco.ERP.CBR.Comunicaciones.WebServices.Extranet">
   <soapenv:Header/>
   <soapenv:Body>
      <tem:RecordarClave>
         <!--Optional:-->
         <tem:recordarClave>
            <sin:Comprador>' . $varPost['comprador'] . '</sin:Comprador>
         </tem:recordarClave>
      </tem:RecordarClave>
   </soapenv:Body>
</soapenv:Envelope>';
$soapaction = "http://tempuri.org/IExtranetService/RecordarClave";
$result = $client->send($parameters, $soapaction);
$respuesta = $result['RecordarClaveResult']['Envio'];
if ($respuesta=="true") {
  echo "Se ha enviado la contraseña a su correo electrónico";
} else {
  echo "Error al recuperar la contraseña <br> Valide sus datos";
}
//Array
//(
//    [RecordarClaveResult] => Array
//        (
//            [Envio] => true
//            [Mensaje] => El correo fue enviado
//        )
//
//)
//          
