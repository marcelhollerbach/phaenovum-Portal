<?php
/**
 * 
 */
class Authorization {
	private static $inst;
	function __construct() {
		
	}
	function login($usr,$pw){
		if($usr == 'admin'&& Settings::checkAdminPW($pw)){
		//admin logged in
		$_SESSION['login'] = TRUE;
		$_SESSION['usr'] = $usr;
		//Superadmin => all rights
		$permission = '';
		foreach (ComponentController::getComponents() as $name => $component) {
			if($permission == ''){
				$permission = $name;
			}else{
				$permission .= '&'.$name;
			}
		}

		$_SESSION['permission'] = $permission;
		$succes = TRUE;
		}else{
			$succes = FALSE;
			//TODO LDAP- auth
		}
	}
	function logout(){
		session_destroy();
	}
	static function getInst(){
        if (null === self::$inst) {
             self::$inst = new self;
         }
         return self::$inst;
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