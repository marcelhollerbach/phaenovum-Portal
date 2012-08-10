<?php
/**
 * 
 */
class Authorization {
	
	function __construct($argument) {
		
	}
	static function auth($usr,$pw){
		session_start();
		//Usergruppen: 
		//icons Menubar
		//news_p news-publishment
		//news_e news-einreichen
		//irc chat jeder
		if($usr == 'admin'&& Settings::checkAdminPW($pw)){
			//admin logged in
			$_SESSION['login'] = TRUE;
			$_SESSION['usr'] = $usr;
			$_SESSION['permission'] = 'icons&news_p&news_e&irc';
			return TRUE;
		}else{
			//TODO LDAP- auth
			return FALSE;
		}
	}
	static function getPermissions(){
		if(isset($_SESSION['permission'])){
		return $_SESSION['permission'];
		}else{
			return null;
		}
	}
	static function searchForPermissions($searchedpermission){
		$permission = self::getPermissions();
		$permissions = explode("&", $permission);
		return self::searchInArray($permissions,$searchedpermission);
	}
	private static function searchInArray($array, $word) {
		foreach ($array as $part) {
			if ($part == $word) {
				return TRUE;
			}
		}
		return FALSE;
	}
	static function getUserName(){
		if(isset($_SESSION['usr'])){
		return $_SESSION['usr'];
		}else{
			return null;
		}
	}
}


?>