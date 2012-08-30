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
			$this -> bind = ldap_bind($this -> ldapcon) or die ('no anonymos bind');
		}
	}
	function getAllLdapGroups(){
		if(Settings::getLDAPServer() != 'disable'){
			$names = array();
			$result = ldap_search($this->ldapcon,'ou=group,dc=marcel,dc=local','cn=*');
			$data = ldap_get_entries($this->ldapcon, $result);
			foreach($data as $group){
				if($group['cn'][0] != ''){
					$names['cn'][] = $group['cn'][0];
					$names['gidnumber'][] = $group['gidnumber'][0];
				}
			}
			return $names;
		}
	}
	function groupOfUser($usr){
		$groups = $this -> getAllLdapGroups();
		if(Settings::getLDAPServer() != 'disable'){
			$attribute = array("gidnumber");
			$result = ldap_search($this->ldapcon,'ou=people,dc=marcel,dc=local','uid='.$usr,$attribute);
			$entry = ldap_get_entries($this->ldapcon, $result);
			$gidnumber = $entry[0]['gidnumber'][0];
			foreach($groups['gidnumber'] as $key => $groupgidnumber){
				if($gidnumber == $groupgidnumber){
					return $groups['cn'][$key];
				}
			}
			return null;
		}
	}
	function getAllmysqlGroups(){
		$cmd = "SELECT * FROM com_ldap_group;";
		$result = mysql_query($cmd,Settings::getMYSQLConnection());
		$groups = '';
		while ($group = mysql_fetch_array($result)) {
			$groups['names'][] = $group['name'];
			$groups['componentgroups'][] = $group['componentgroups'];
		}
		return $groups;
	}
	function getPermissionFor($group){
		$groups = $this -> getAllmysqlGroups();
		foreach($groups['names'] as $key => $groupdb){
			if($group == $groupdb ){
				return $groups['componentgroups'][$key];
			}
		}
		return '';
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
					$permission = $component -> getPermission();
				}else{
					$permission .= '&'.$component -> getPermission();
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
					$group = $this -> groupOfUser($usr);
					$permission = $this -> getPermissionFor($group);
					//echo $permission;
					$_SESSION['permission'] = $permission;
				}else{
					forwarding::routeBackwithError(TRUE, 'none', ldap_error($this ->ldapcon));
					//$succes = FALSE;
				}
			}
		}
		//$this ->getAllLdapGroups();
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