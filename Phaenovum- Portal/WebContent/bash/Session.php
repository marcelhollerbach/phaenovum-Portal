<?php 
class Session{
	/**
	 * If a User is logged in, the result will be the Username,
	 * if not it will return FALSE.
	 *
	 * @return String|boolean
	 */
	static function getUser(){
		if(isset($_SESSION['usr'])){
			return $_SESSION['usr'];
		}else{
			return FALSE;
		}
	}
	/**
	 * If a User is logged in, the result will be the Password,
	 * if not it will return FALSE.
	 *
	 * @return String|boolean
	 */
	static function getPW(){
		if(isset($_SESSION['pw'])){
			return $_SESSION['pw'];
		}else{
			return FALSE;
		}

	}
	static function getPermissions(){
		if(isset($_SESSION['permission'])){
			return $_SESSION['permission'];
		}else{
			return FALSE;
		}
	}
}
?>