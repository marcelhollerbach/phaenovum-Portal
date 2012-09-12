<?php
/**
 *

 class Authorization {
 private static $inst;
 private $ldapcon;
 private $bind;
 function __construct() {
 if(Settings::getLDAPServer() != 'disable'){
 $this -> ldapcon = ldap_connect('ldap://'.Settings::getLDAPServer()) or die('Error: cannot connect');
 ldap_set_option($this -> ldapcon, LDAP_OPT_PROTOCOL_VERSION, 3);
 if(!$this -> ldapcon){
 forwarding::routeBack(TRUE,'none',"error: cannot connect");
 }
 if(isset($_SESSION['usr'])&&$_SESSION['usr'] != 'admin'){
 $usr = $_SESSION['usr'];
 $pw = $_SESSION['pw'];
 $this -> bind = ldap_bind($this -> ldapcon,"uid=".$usr.", ou=people, dc=marcel, dc=local",$pw);
 }else{
 $this -> bind = ldap_bind($this -> ldapcon) or die ('no anonymos bind');
 //echo "anonym";
 }
 if(!$this ->bind){
 forwarding::routeBack(TRUE,'none',"error: cannot bind anonymos");
 }
 }
 }
 // 	function getAllLdapGroups(){
 // 		if(Settings::getLDAPServer() != 'disable'){
 // 			$names = array();
 // 			$result = ldap_search($this->ldapcon,'ou=group,dc=marcel,dc=local','cn=*');
 // 			$data = ldap_get_entries($this->ldapcon, $result);
 // 			//print_r($data);
 // 			//exit();
 // 			foreach($data as $group){
 // 				if($group['cn'][0] != ''){
 // 					$names['cn'][] = $group['cn'][0];
 // 					$names['gidnumber'][] = $group['gidnumber'][0];
 // 				}
 // 			}
 // 			return $names;
 // 		}
 // 	}
 // 	function groupOfUser($usr){
 // 		$groups = $this -> getAllLdapGroups();
 // 		if(Settings::getLDAPServer() != 'disable'){
 // 			$attribute = array("gidnumber");
 // 			$result = ldap_search($this->ldapcon,'ou=people,dc=marcel,dc=local','uid='.$usr,$attribute);
 // 			$entry = ldap_get_entries($this->ldapcon, $result);
 // 			$gidnumber = $entry[0]['gidnumber'][0];
 // 			$this -> getPrimaryGroup();
 // 			foreach($groups['gidnumber'] as $key => $groupgidnumber){
 // 				if($gidnumber == $groupgidnumber){
 // 					return $groups['cn'][$key];
 // 				}
 // 			}
 // 			return null;
 // 		}
 // 	}
 // 	function getPrimaryGroup($usr){
 // 		$attribute = array();
 // 		$result = ldap_search($this->ldapcon,'ou=group,dc=marcel,dc=local','cn=*');
 // 		$entry = ldap_get_entries($this->ldapcon, $result);
 // 		$primarygroup = array();
 // 		foreach($entry as $ent){
 // 			//print_r($ent);
 // 			if(isset($ent['memberuid'])){
 // 				//print_r($ent['memberuid']);
 // 				//echo "<br/>";
 // 				foreach($ent['memberuid'] as $member){
 // 					//echo $member."<br/>";
 // 					$primarygroup[] = $member;
 // 				}
 // 			}
 // 		}
 // 		return $primarygroup;
 // 		//exit();
 // 	}
 // 	function getAllmysqlGroups(){
 // 		$cmd = "SELECT * FROM com_ldap_group;";
 // 		$result = mysql_query($cmd,Settings::getMYSQLConnection());
 // 		$groups = '';
 // 		while ($group = mysql_fetch_array($result)) {
 // 			$groups['names'][] = $group['name'];
 // 			$groups['componentgroups'][] = $group['componentgroups'];
 // 		}
 // 		return $groups;
 // 	}
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
 $permission .= $component -> getPrimaryPermission();
 $permission .= '&'.$component -> getPermission();
 }else{
 $permission .= '&'.$component -> getPrimaryPermission();
 $permission .= '&'.$component -> getPermission();
 }
 }
 $_SESSION['permission'] = $permission;
 $succes = TRUE;
 }else{
 if(Settings::getLDAPServer() != 'disable'){
 $this -> bind = ldap_bind($this -> ldapcon,"uid=".$usr.", ou=people, dc=marcel, dc=local",$pw);
 if($this -> bind){
 $_SESSION['login'] = TRUE;
 $_SESSION['usr'] = $usr;
 $_SESSION['pw'] = $pw;
 $_SESSION['prigroup'] = "";
 $_SESSION['secgroup'] = "";
 $group = $this -> groupOfUser($usr);
 $permission = $this -> getPermissionFor($group);
 //echo $permission;
 $_SESSION['permission'] = $permission;
 }else{
 forwarding::routeBack(TRUE, 'none', ldap_error($this ->ldapcon));
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
 }*/
?>
<?php
class Authorization {
	private static $inst;
	private $ldapcon;
	private $bind;
	function __construct() {
		if(Settings::getLDAPServer() != 'disable'){
			$this -> ldapcon = ldap_connect('ldap://'.Settings::getLDAPServer()) or die('Error: cannot connect');
			ldap_set_option($this -> ldapcon, LDAP_OPT_PROTOCOL_VERSION, 3);
			if(!$this -> ldapcon){
				forwarding::routeBack(TRUE,'none',"error: cannot connect");
			}
			if(isset($_SESSION['usr'])&&$_SESSION['usr'] != 'admin'){
				$usr = $_SESSION['usr'];
				$pw = $_SESSION['pw'];
				$this -> bind = ldap_bind($this -> ldapcon,"uid=".$usr.", ou=people, dc=marcel, dc=local",$pw);
			}else{
				$this -> bind = ldap_bind($this -> ldapcon) or die ('no anonymos bind');
				//echo "anonym";
			}
			if(!$this ->bind){
				forwarding::routeBack(TRUE,'none',"error: cannot bind anonymos");
			}
		}
	}
	function getAllLdapGroups(){
		if(Settings::getLDAPServer() != 'disable'){
			$names = array();
			$result = ldap_search($this->ldapcon,'ou=group,dc=marcel,dc=local','cn=*');
			$data = ldap_get_entries($this->ldapcon, $result);
			//print_r($data);
			//exit();
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
			$this -> getPrimaryGroup();
			foreach($groups['gidnumber'] as $key => $groupgidnumber){
				if($gidnumber == $groupgidnumber){
					return $groups['cn'][$key];
				}
			}
			return null;
		}
	}
	function getPrimaryGroup($usr){
		$attribute = array();
		$result = ldap_search($this->ldapcon,'ou=group,dc=marcel,dc=local','cn=*');
		$entry = ldap_get_entries($this->ldapcon, $result);
		$primarygroup = array();
		foreach($entry as $ent){
			//print_r($ent);
			if(isset($ent['memberuid'])){
				//print_r($ent['memberuid']);
				//echo "<br/>";
				foreach($ent['memberuid'] as $member){
					//echo $member."<br/>";
					$primarygroup[] = $member;
				}
			}
		}
		return $primarygroup;
		//exit();
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
					$permission .= $component -> getPrimaryPermission();
					$permission .= '&'.$component -> getPermission();
				}else{
					$permission .= '&'.$component -> getPrimaryPermission();
					$permission .= '&'.$component -> getPermission();
				}
			}
			$_SESSION['permission'] = $permission;
			$succes = TRUE;
		}else{
			if(Settings::getLDAPServer() != 'disable'){
				$this -> bind = ldap_bind($this -> ldapcon,"uid=".$usr.", ou=people, dc=marcel, dc=local",$pw);
				if($this -> bind){
					$_SESSION['login'] = TRUE;
					$_SESSION['usr'] = $usr;
					$_SESSION['pw'] = $pw;
					$_SESSION['prigroup'] = "";
					$_SESSION['secgroup'] = "";
					$group = $this -> groupOfUser($usr);
					$permission = $this -> getPermissionFor($group);
					//echo $permission;
					$_SESSION['permission'] = $permission;
				}else{
					forwarding::routeBack(TRUE, 'none', ldap_error($this ->ldapcon));
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
	function getLdapField($_field){
		if(self::getUserName() != 'admin'){
			$attribute = array($_field);
			$result = ldap_search($this->ldapcon,'ou=people,dc=marcel,dc=local','uid='.self::getUserName(),$attribute);
			$entry = ldap_get_entries($this->ldapcon, $result);
			//print_r($entry);
			if(!isset($entry[0][$_field])){
				return NULL;
				exit();
			}
			return $entry[0][$_field][0];
			//print_r($entry);
		}else{
			return NULL;
		}
	}
	function editLDAPField($_field,$_newvalue){
		$attribute = array();
		$attribute[$_field] = $_newvalue;
		$result = ldap_modify($this -> ldapcon,'uid='.self::getUserName().', ou=people, dc=marcel, dc=local', $attribute);
		if(!$result){
			$result = ldap_error($this -> ldapcon);
			forwarding::routeBack(TRUE,"LdapUserData",$result.$attribute);
		}

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