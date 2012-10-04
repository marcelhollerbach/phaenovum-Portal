<?php
/**
 *
 */
class Authorization {
	private static $inst;
	private $ldapbackend;
	function __construct() {
		if(Settings::getLDAPServer() != 'disable'){
			$this -> ldapbackend = new LdapBackend();
			if(isset($_SESSION['usr'])&&$_SESSION['usr'] != 'admin'){
				$usr = $_SESSION['usr'];
				$pw = $_SESSION['pw'];
				$this -> ldapbackend -> bind($usr,$pw);
			}else{
				$this -> ldapbackend -> bind();
			}
		}
	}
	function login($usr,$pw){
		if($usr == 'admin'&& Settings::checkAdminPW($pw)){
			//admin logged in
			$_SESSION['login'] = TRUE;
			$_SESSION['usr'] = $usr;
			//Superadmin => all rights
			$permission = '';
			foreach (ComponentController::getComponents() as $component) {
				if($permission == ''){
					$permission .= $component -> getPrimaryPermission();
					$permission .= '&'.$component -> getPermission();
				}else{
					$permission .= '&'.$component -> getPrimaryPermission();
					$permission .= '&'.$component -> getPermission();
				}
			}
			$_SESSION['permission'] = $permission;
			ComponentController::init();
			$succes = TRUE;
		}else{
			if(Settings::getLDAPServer() != 'disable'){
				$bind = $this -> ldapbackend -> bind($usr,$pw);
				if($bind){
					$_SESSION['login'] = TRUE;
					$_SESSION['usr'] = $usr;
					$_SESSION['pw'] = $pw;
					$this -> ldapbackend ->groupOfUser($usr);
					//TODO new Permission generation
					$permission = "";
					$groups = $this -> ldapbackend -> groupOfUser($usr);
					foreach($groups as $group){
						$perm = $this -> getPermissionFor($group);
						$permission .= $perm;

					}
					$_SESSION['permission'] = $permission;
					ComponentController::init();
				}else{
					forwarding::routeBack(TRUE, 'none', ldap_error($this ->ldapcon));
					//$succes = FALSE;
				}
			}
		}
		//$this ->getAllLdapGroups();
	}
	public function getPermissionFor($group){
		$groups = $this -> ldapbackend -> getAllmysqlGroups();
		//print_r($groups);
		//exit();
		foreach($groups as $groupdb){
			//echo $groupdb['names']."==";
			//echo $group."</br>";
			if($groupdb['names'] == $group ){
				return $groupdb['componentgroups'];
			}
		}
		return '';
	}
	function logout(){
		if(Settings::getLDAPServer() != 'disable'){
			$this -> ldapbackend ->logout();
		}
		session_destroy();
	}
	static function getInst(){
		if (null === self::$inst) {
			self::$inst = new self;
		}
		return self::$inst;
	}
	function getLDAPBackend(){
		return $this->ldapbackend;
	}
	static function searchForPermissions($searchedpermission){
		$permission = Session::getPermissions();
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
}
?>