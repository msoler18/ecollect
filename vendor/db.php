<?php


	


	Class Db
	{

		

		protected static $table_name;

		function __construct()
		{	// Ejecutar el método que abre la conexión con la BD
			$this->__connect();
	
		}



		public static function __connect()
		{

			$connect = mysqli_connect(HOST,USER,PASSWORD,DBNAME, 8889) or die("Error " . mysqli_error($connect));
		
			return $connect;


		}


		public  static function __query($query)
		{


			$db = static::__connect();

			$result = $db->query($query);

		
			// echo $query;

			while ($row = $result->fetch_assoc()) {
 				 
 				$results[] = $row; 

 		

             }
		

			return isset($results) ? $results : false;



		}

		public static function last_id(){

			
			$query = 'SELECT id FROM '.static::$table_name. ' ORDER BY id DESC LIMIT 1';
			$result = static::__query($query);

		
			return $result;

		}

		public static function find_id($id)
		{

			$query = 'SELECT * FROM '.static::$table_name. ' WHERE id='.$id.'';
			$result = static::__query($query);

		
			return $result;

		}

		public static function find_all()
		{

			

			$query = 'SELECT * FROM '.static::$table_name;
			$result = static::__query($query);

		

			return $result;

		}

		
		public static function find_by_attr($array, $res = '*', $union = '', $more = '') {

           $query = 'SELECT ' . $res . ' FROM ' . static::$table_name . ' ' . $union . '  WHERE ';
           $count = count($array);

           $i = 1;

           foreach ($array as $k => $v):

                   $query .= ($i == $count) ? $k . ' = "' . $v . '" ' : $k . '= "' . $v . '" AND ';

                   $i++;

           endforeach;

           $query = rtrim($query, 'AND');
           $query .= $more;

           $result = static::__query($query);

           return $result;

       }

		public static function delete_by_id($id)
		{


			$query = "DELETE FROM ".static::$table_name." WHERE id =".$id." ";

			$db = static::__connect();

			$result = $db->query($query);

			return $result;

		}


		public static function save($array)
		{


			$query = "INSERT INTO ".static::$table_name."";
			$keys = ' ( ';
			$values = ' VALUES (';

			foreach ($array as $k => $v) :
				if (gettype($v) == 'string') :
					if($v != '') :
						$keys    .= $k.',';	
						$values  .= "'".$v."',";	
					endif;	
					else : 
						if($v != 0) :
						$values  .= $v.',';
						endif;
				endif; 
			endforeach;	

			$keys   = rtrim($keys, ',').' )';
			$values = rtrim($values, ',').' )';
			$nd = $query.$keys.$values;
			$db = static::__connect();

			$result = $db->query($nd);
			// echo $db->error;

			//echo $nd;
			return $result;	

		}

		

		public static function update($array, $where = '')
		{

			$query = "UPDATE ".static::$table_name." SET  ";
			$values =  "";

			foreach ($array as $k => $v) :
				
					
					

				if (gettype($v) == 'string') :

						

						if($v != '') :

							$values  .= $k."='".$v."',";

						endif;	


					else : 

					
					
					if($v != 0) :	

						$values  .= $k.'='.$v.',';

					endif;

				endif; 	


			endforeach;

			$values = rtrim($values, ',');

			$nd = $query.$values.$where;

			 //echo $nd; 

			$db = static::__connect();

			$result = $db->query($nd);

			return $result;	

		}



	}

	$db = new Db;

?>