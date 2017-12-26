<?php

	// Redirect function

	function url_redirect($url) 
	{	
		
		header("Location: ".$url);
		exit();
	}	

	// function get_vars($array) {

	// 	$i = 1;

		

	// 	foreach($array as $k => $v) :

		
	// 		if ($i % 2 == 0) :
 		 		
	// 			$new_array[$array[$k-1]] = $array[$k];	

	// 		endif;	

	// 		$i++;

	// 	endforeach;	


	// 	return isset($new_array) ? $new_array : null;

	// }

	function special_characters ($url)
	{

		if(is_numeric(strpos($url, '&'))) :
			$url = strstr($url, '&', true);
			return (substr($url, -1) == '/') ? str_replace('/', '', $url) : $url; 


		endif;

		if(is_numeric(strpos($url, '?'))) :

			$url = strstr($url, '?', true);
			return (substr($url, -1) == '/') ? str_replace('/', '', $url) : $url; 
			
		endif;

		return $url;	

	}

	function get_vars($array, $array_keys_get) {

		$i = 0;

		foreach ($array as $k => $v):

			if($is_exist = if_key_exist($i, $array_keys_get)) :
				$new_array[$is_exist] = $v;
			else :

				url_redirect(URL.'404');
			endif;
		$i++;
		endforeach;

		return isset($new_array) ? $new_array : null;

	}

	function  if_key_exist($key, $array)
	{

		foreach($array as $k => $v) :

			if($key == $k) :

				return $v;

			endif;

		endforeach;

		return false;

	}

	function dump($var)
	{

		echo '<pre>';
			var_dump($var);
		echo '</pre>';

	}

	function url($title)
	{

		// reemplaza cualquier cadena inválida por "-";
		$title = str_replace("&", "and", $title);
		$arrStupid = array('feat.', 'feat', '.com', '(tm)', ' ', '*', "'s", '"', ",", ":", ";", "@", "#", "(", ")", "?", "!", "_",
		"$","+", "=", "|", "'", '/', "~", "`s", "`", "\\", "^", "[","]","{", "}", "<", ">", "%", "&#8482;");

		$title = htmlentities($title);
		$title = preg_replace('/&([a-zA-Z])(.*?);/','$1',$title);
		$title = strtolower("$title");
		$title = str_replace(".", "", $title);
		$title = str_replace($arrStupid, "_", $title);
		$flag = 1;
		while($flag){
		$newtitle = str_replace("--","-",$title);
		if($title != $newtitle) {
		$flag = 1;
		}
		else $flag = 0;
		$title = $newtitle;
		}
		$len = strlen($title);
		if($title[$len-1] == "") {
		$title = substr($title, 0, $len-1);
		}
		return $title;	

	}

	function __title()
	{

		$url = $_SERVER['REQUEST_URI'];	

		$url = is_null(LOCAL) ? $url : str_replace(LOCAL, "", $url);
	
		$array = explode('/', $url);

		$title = array_pop($array);


		

		if($url == '') : 

				$title = ucwords(SITENAME);

			elseif(is_numeric($title)) :

				$count = count($array);

				if($count > 1) :

					$title = ucwords(str_replace('_', ' ', $array[0]).' '.str_replace('_', ' ', $array[1]));	

				else :

					$title = ucwords(str_replace('_', ' ', $array[0]));
				
				endif;	

				

			elseif(!is_numeric($title)) :

			$title = ucwords(str_replace('_', ' ', $title));

		


		endif;	

		

		

		 echo $title;


	}

	function files_multidimensional($path, $file, $tmp, $name_file)
	{

		$now = date("Y-m-d-H-i-s");


		if (isset($file["name"][$name_file]) && ($file["name"][$name_file] != '')):
			// $file_count = count($file['name'][$name_file]);
			
			



			foreach($file as $k => $v) :

				
				foreach($v[$name_file] as $k1 => $v1) :
					$name = $file['name'][$name_file][$k1];
					$file_basename = str_replace(' ', '', substr($file['name'][$name_file][$k1], 0, strripos($file['name'][$name_file][$k1], '.')));
	 				$file_ext = substr($file['name'][$name_file][$k1], strripos($file['name'][$name_file][$k1], '.'));


	 				if(!is_dir($tmp)) :

	 					// echo $tmp;
	 				// exit();
	 				
	 					mkdir($tmp, 0777, true);
	 				endif;


	 				move_uploaded_file($file['tmp_name'][$name_file][$k1], $tmp.'/'.$file_basename.$file_ext);
					@rename($tmp.$file_basename.$file_ext, $path.$file_basename.$now.$file_ext);
					$images[$k1] = $file_basename.$now.$file_ext;

				endforeach;
			endforeach;

		
			// for ($i = 0; $i < $file_count; $i++) {
			// 	$name = $file['name'][$name_file][$i];
			// 	$file_basename = str_replace(' ', '', substr($file['name'][$name_file][$i +1], 0, strripos($file['name'][$name_file][$i+1], '.')));
	 	// 		$file_ext = substr($file['name'][$name_file][$i+1], strripos($file['name'][$name_file][$i+1], '.'));

	 			

	 	// 		move_uploaded_file($file['tmp_name'][$name_file][$i+1], $tmp.'/'.$file_basename.$file_ext);
			// 	rename($tmp.'/'.$file_basename.$file_ext, $path.'/'.$file_basename.$now.$file_ext);
			// 	$images[$i+1] = $file_basename.$now.$file_ext;
			// }

			return $images;
		else :
			
			return null;
		endif;
	}


	function __upload_file($path, $file, $tmp, $multiple = false, $type = false) {

		// Si es multiple
		$now = date("Y-m-d-H-i-s");

		


		if ($multiple):

			if (isset($file["name"]) && ($file["name"] != '')):

				$file_count = count($file['name']);

				for ($i = 0; $i < $file_count; $i++) {

					$name = $file['name'][$i];
					

					$file_basename = str_replace(' ', '', substr($file['name'][$i], 0, strripos($file['name'][$i], '.')));
		 			$file_ext = substr($file['name'][$i], strripos($file['name'][$i], '.'));

					if($type == false) :

					// move_uploaded_file($file['tmp_name'][$i], $path . $name);
					move_uploaded_file($file['tmp_name'][$i], $tmp.'/'.$file_basename.$file_ext);
					rename($tmp.'/'.$file_basename.$file_ext, $path.'/'.$file_basename.$now.$file_ext);
					
					$images[] = $file_basename.$now.$file_ext;

					elseif($file['type'] == $type) :

						// move_uploaded_file($file['tmp_name'][$i], $path . $name);
						move_uploaded_file($file['tmp_name'][$i], $tmp.'/'.$file_basename.$file_ext);
						rename($tmp.'/'.$file_basename.$file_ext, $path.'/'.$file_basename.$now.$file_ext);
						
					else :

						return null;

					endif;

				}
				// die();
				return $images;

			else:

				return null;

			endif;

		// Si es sencillo

		else:

			if (isset($file["name"]) && ($file["name"] != '')):
				$file_name =  str_replace(' ', '', $file["name"]);
				$fileNameTemp = $file["tmp_name"];
				$fileNameNew = $tmp . basename($file_name);


				$file_basename = str_replace(' ', '', substr($file['name'], 0, strripos($file['name'], '.')));
	 			$file_ext = substr($file['name'], strripos($file['name'], '.'));



 				if($type == false) :

 		
						if (move_uploaded_file($fileNameTemp, $fileNameNew)):


					rename($tmp.'/'.$file_basename.$file_ext, $path.'/'.$file_basename.$now.$file_ext);
					
					return $file_basename.$now.$file_ext;

					else:
						echo '1';
						return null;

					endif;


				elseif($file['type'] == $type) :


					if (move_uploaded_file($fileNameTemp, $fileNameNew)):


					rename($tmp.'/'.$file_basename.$file_ext, $path.'/'.$file_basename.$now.$file_ext);
					
					return $file_basename.$now.$file_ext;

					else:
					
						// echo '2';
						return null;

					endif;

				else :
					// echo '3';
					return null;

					
					endif;




			else:

				return null;

			endif;

		endif;

	}



	
	function __content($url, $routes)
	{

		

        // $url = is_null(LOCAL) ? $url : str_replace(LOCAL, "", $url);
		$url = is_null(LOCAL) ? ltrim ($url, '/') : str_replace(LOCAL, "", $url);


		foreach($routes as $route => $route_val) :


			
			

			if (strpos($route, '$1')):

				$route = explode("$1", $route);
				$route = $route[0];

				// if(is_numeric(strpos(trim($url, '1'), $route)) and ($url != $route)) :

				if (strstr($url, substr($url, strlen($route), strlen($url)), true) === $route):

					$url = str_replace($route, '', $url);

					$get_vars = explode("/", $url);

					$array_keys_get = $route_val['get_vars'];


					$get_vars = get_vars($get_vars, $array_keys_get);

					$url = $route;

				endif;

			endif;
			
			// dump($url);
			// dump($get_vars);

			// die();

			if($url == $route) :

	

				switch (key($route_val)) {
					
					case 'view':
						
						

						if (isset($route_val['perm']) && $perms = $route_val['perm']):

							
							foreach($perms as $perm) :

								if(isset($_SESSION['user']) && $_SESSION['user']['tipo'] == $perm) :

									return __view($route_val['view']);	
									return isset($get_vars) ? __view($route_val['view'], $get_vars) : __view($route_val['view']);

								endif;	

							endforeach;	

							return isset($_SESSION['user']) ? url_redirect(URL.'perm') : url_redirect(URL.'login_form');

						else :	

						 	return isset($get_vars) ? __view($route_val['view'], $get_vars) : __view($route_val['view']);

						endif;	






					break;

					case 'controller':

						if (isset($route_val['perm']) && $perms = $route_val['perm']):
							
							foreach($perms as $perm) :

								if(isset($_SESSION['user']) && $_SESSION['user']['tipo'] == $perm) :

									return isset($get_vars) ? __controller($route_val['controller'], $get_vars) : __controller($route_val['controller']);

								endif;	

							endforeach;	

							return isset($_SESSION['user']) ? url_redirect(URL.'perm') : url_redirect(URL.'login_form');

						else :

							return isset($get_vars) ? __controller($route_val['controller'], $get_vars) : __controller($route_val['controller']);

						endif;	

						

					break;
					
				

				}

			


			endif;	


		endforeach;	



		 return require_once PATH.'views/404.tpl';


	}

	function body_class_()
	{

		$url = $_SERVER['REQUEST_URI'];	
		$url = is_null(LOCAL) ? $url : str_replace(LOCAL, "", $url);

		return $url;
	}


	function __view($file, $params = null)
	{

		
		$url = explode(":", $file);



		if (file_exists(PATH.'views/'.$url[0].'.tpl') && file_exists(PATH.'views/'.$url[1].'.tpl')) :

			$content =  PATH.'views/'.$url[0].'.tpl';

			require_once PATH.'views/'.$url[1].'.tpl';



		elseif (file_exists(PATH.'views/'.$url[0].'.tpl') && $url[1] == 'no_layout') :

			require_once PATH.'views/'.$url[0].'.tpl';


			
		elseif (!file_exists(PATH.'views/'.$url[0].'.tpl') && !file_exists(PATH.'views/'.$url[1].'.tpl')) :	

			echo 'La vista no existe <br/>';	

		endif;	

		

	}



	function __controller($file, $params = null)
	{

		$url = explode(":", $file);

		if (file_exists(PATH.'controllers/'.$url[1].'.php')) :

			if (file_exists(PATH.'models/'.$url[1].'.php')) :

				require_once PATH.'models/'.$url[1].'.php';


			endif;	

		
			
			require_once PATH.'controllers/'.$url[1].'.php';

			$name = ucfirst($url[1]);

			$app = new $name();

			if(method_exists($app,$url[0])) :

				
			
				return is_null($params) ? $app->{$url[0]}() : $app->{$url[0]}($params);


				else :	

					echo 'este metdodo no existe';


			endif;
				


		else :

			echo 'el controlador no existe no existe <br/>';


		endif;	


	}

	function quitar_tildes($cadena) {
		$no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
		$permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
		$texto = str_replace($no_permitidas, $permitidas ,$cadena);
		return $texto;
	}


	function add_widget($name, $params = null)
	{




		if (file_exists(PATH.'widgets/'.$name.'.php')) :

			return require_once PATH.'widgets/'.$name.'.php';

		else :

			echo 'el widget no existe <br/>';


		endif;	

	}

	//  Extranet
		function nusoap_avisor(){

		error_reporting(0);
	    
	    /*************** WEB services **************************************************************/
	  
	    require_once PATH."libs/nusoap/nusoap.php";
  
	    ini_set('display_errors', true);
   		 error_reporting(E_ALL); 

	    $wsdl = "https://test1.e-collect.com/d_eCollectAgentV2/webservice/eCollectCustomersAgentv1.asmx?WSDL"; 
	    
	    $soap = new nusoap_client($wsdl, true);
	    


	    $parameters = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ecol="http://www.avisortech.com/eCollectCustomersAgentServices" xmlns:ecol1="http://www.avisortech.com/eCollectAgentServices">
	   <soapenv:Header/>
	   <soapenv:Body>
	      <ecol:getUserExternalLogin>
	         <!--Optional:-->
	       <ecol:request>
	            <!--Optional:-->
	            <ecol1:EntityCode>10442</ecol1:EntityCode>
	            <!--Optional:-->
	            <ecol1:ParentPerId1>79779311</ecol1:ParentPerId1>
	            <!--Optional:-->
	            <ecol1:ParentPerId2></ecol1:ParentPerId2>
	            <!--Optional:-->
	            <ecol1:ParentPerName>ARANGUREN BARRAGAN GERMAN</ecol1:ParentPerName>
	            <!--Optional:-->
	            <ecol1:ParentPerLast></ecol1:ParentPerLast>
	            <!--Optional:-->
	            <ecol1:ParentPerEmail>garanguren@proksol.com</ecol1:ParentPerEmail>
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

			$soapaction = "http://www.avisortech.com/eCollectCustomersAgentServices/getUserExternalLogin";
			// $result = $soap->call('getUserExternalLogin', $parameters);
			// $_SESSION['id_usuario'] = $result['LoginResult']['IdComprador'];

			$result = $soap->send($parameters, $soapaction);

	    // $parameters['request']['EntityCode'] = 10442;
	    
	    // $parameters['request']['ParentPerId1'] = 79779311;
	    
	    // $parameters['request']['ParentPerName'] = 'ARANGUREN BARRAGAN GERMAN'; 

	    // $parameters['request']['ParentPerEmail'] = 'garanguren@proksol.com'; 
	    
	    // $parameters['request']['ParentProfileCode'] = 1; 
	    
	    // $result = $soap->call("getUserExternalLogin", $parameters);
	    
	    // echo '<pre>';
	    // 	var_dump($result);
	    // echo '</pre>';



	    // if($error = $soap->getError()){ 
	      
	    //   die("ERROR: ".$error);
	    
	    // }else{ 

	   	// 	$r = $result['ConsultarContactoResult']['body']['strActivo'];
	    
	    //   if($r != ""){

	    //     return 1;  
	      
	    //   }else{
	      
	    //     return 0;  
	      
	    //   }
	    
	    // }

	}




?>