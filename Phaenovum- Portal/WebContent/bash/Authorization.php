<?php
/**
 * 
 */
class Authorization {
	
	function __construct($argument) {
		
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