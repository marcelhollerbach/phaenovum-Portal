<?php
/**
 * 
 */
class Authorization {
	
	function __construct($argument) {
		
	}
	static function auth($usr,$pw){
		if($usr == 'admin'&& Settings::checkAdminPW($pw)){
			return TRUE;
		}else{
			//TODO LDAP- auth
			return FALSE;
		}
	}
}


?>