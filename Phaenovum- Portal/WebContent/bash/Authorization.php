<?php
/**
 *
 */
class Authorization {
	private static $inst;
	private $ldapcon;
	private $bind;
	function __construct() {
		if(Settings::getLDAPServer() != 'disable'){
			$this -> ldapcon = ldap_connect('ldap://'.Settings::getLDAPServer()) or die('Error: cannot connect');
			if($this -> ldapcon){
				ldap_set_option($this -> ldapcon, LDAP_OPT_PROTOCOL_VERSION, 3);
			}else{
				echo "error: cannot connect";
			}
		}
	}
	function getAllLdapGroups(){
		if(Settings::getLDAPServer() != 'disable'){
			$result = ldap_search($this->ldapcon,'ou=group,dc=marcel,dc=local','(objectClass=cn)');
			print_r($result);
		}
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
			if(Settings::getLDAPServer() != 'disable'){
				$this -> bind = ldap_bind($this -> ldapcon,"uid=".$usr.",ou=people,dc=marcel,dc=local",$pw);
				if($this -> bind){
					$_SESSION['login'] = TRUE;
					$_SESSION['usr'] = $usr;
					$_SESSION['permission'] = '';
				}else{
					forwarding::routeBackwithError(TRUE, 'none', ldap_error($this ->ldapcon));
					//$succes = FALSE;
				}
			}
		}
		$this ->getAllLdapGroups();
	}
	function logout(){
		if(Settings::getLDAPServer() != 'disable'){
			ldap_close($this->ldapcon);
		}
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