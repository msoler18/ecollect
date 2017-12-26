<?php


    /*
    |--------------------------------------------------------------------------
    | Configuracion General
    |--------------------------------------------------------------------------
    |
    |
    */

    // echo ini_get('display_errors');
    // error_reporting(E_ALL);


    //echo $_SERVER['DOCUMENT_ROOT'];
    define('URL', 'http://www.proksol.com/');
    define('PATH', $_SERVER['DOCUMENT_ROOT'].'/');
    // LOCAL variable que define si el sitio esta local o en linea, si esta en linea el valor debe ser null sino debe ser /sitio/
    define('LOCAL', null);
    define('SITENAME', 'proksol');
    define('DBNAME', 'proksol_proyectos');    
    define('HOST', 'localhost');
    define('USER', 'proksol_admin');
    define('PASSWORD', '1Q$(~#,hJP4)');

    $files = glob(PATH.'/vendor/*.php');
 

    foreach ($files as $file) {
         

        

        require_once $file;
        

    }



?>