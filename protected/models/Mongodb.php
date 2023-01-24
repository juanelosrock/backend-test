<?php

require 'protected/vendor/vendor/autoload.php';	
/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class Mongodb extends CFormModel
{
	public $username;
	public $password;
	public $rememberMe;

    public function getConect(){
        
		$user = "sibcouser";
		$pwd = 'S1st3m4s2808';
		$connection = new MongoDB\Client('mongodb://127.0.0.1:27017', array("username" => $user, "password" => $pwd));
        return $connection;
    }
}
