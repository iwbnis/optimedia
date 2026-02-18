<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Router_Hook
{
        /**
         * Loads routes from database.
         *
         * @access public
         * @params array : hostname, username, password, database, db_prefix
         * @return void
         */
    function get_routes($params)
    {
        global $DB_ROUTES;

        $con = mysqli_connect($params[0], $params[1], $params[2], $params[3]);


       	$sql = "SELECT * FROM users where type = 'admin'";
		$result = $con -> query($sql);

        $routes = array();
        $result = $result -> fetch_all(MYSQLI_ASSOC);
        
        foreach ($result as $key => $value) {
        	# code...
        	$route['mysecuredlogin'] = 'AuthController/direct_login';
        }

        $con -> close();

        $DB_ROUTES = $route;
    }
}

?>