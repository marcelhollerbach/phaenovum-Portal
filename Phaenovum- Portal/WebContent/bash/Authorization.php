<?php
/**
 * 
 */
class Authorization {
	
	function __construct($argument) {
		
	}
	static function auth($usr,$pw){
		//Usergruppen: 
		//icons Menubar
		//news news
		//irc chat jeder
		if($usr == 'admin'&& Settings::checkAdminPW($pw)){
			//admin logged in
			$_SESSION['login'] = TRUE;
			$_SESSION['usr'] = $usr;
			$_SESSION['permission'] = 'icon&news&irc';
			return TRUE;
		}else{
			//TODO LDAP- auth
			return FALSE;
		}
	}
	static function getPermissions(){
		return $_SESSION['permission'];
	}
	static function getUserName(){
		return $_SESSION['usr'];
	}
}


?>