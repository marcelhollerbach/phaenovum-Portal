<?php 
class LdapBackend{
	private $ldapcon;
	public function __construct(){
		$this->ldapcon = ldap_connect(Settings::getLDAPServer());
		ldap_set_option($this -> ldapcon, LDAP_OPT_PROTOCOL_VERSION, 3);
		if(!$this ->ldapcon){
			forwarding::routeBack(TRUE,"none",ldap_error($this ->ldapcon));
		}
		//$this ->getAllmysqlGroups();
	}
	public function bind($usr = NULL,$pw = NULL){
		if($pw != NULL && $usr != NULL){
			$dn = "uid=".$usr.",".Settings::getLDAPUserDirectory().",".Settings::getLDAPBaseDN();
			return ldap_bind($this ->ldapcon,$dn,$pw);
		}else{
			return ldap_bind($this ->ldapcon);
		}
	}
	public function getAllLdapGroups(){
		if(Settings::getLDAPServer() != 'disable'){
			$result = ldap_search($this->ldapcon,Settings::getLDAPGroupDirectory().",".Settings::getLDAPBaseDN(),'cn=*');
			$data = ldap_get_entries($this->ldapcon, $result);
			foreach($data as $group){
				if($group['cn'][0] != ''){
					$data = array();
					$data['cn'] = $group['cn'][0];
					$data['gidnumber'] = $group['gidnumber'][0];
					$names[] = $data;
				}
			}
			return $names;
		}
	}
	public function groupOfUser($usr){
		if(Settings::getLDAPServer() != 'disable'){
			$groups = array();
			$attribute = array("*");
			$result = ldap_search($this->ldapcon,Settings::getLDAPGroupDirectory().",".Settings::getLDAPBaseDN(),'cn=*');
			$datagroups = ldap_get_entries($this->ldapcon, $result);
			$result = ldap_search($this->ldapcon,Settings::getLDAPUserDirectory().",".Settings::getLDAPBaseDN(),'uid='.$usr,$attribute);
			$entryuser = ldap_get_entries($this->ldapcon, $result);
			$usrgidnumber = $entryuser[0]['gidnumber'][0];
			//echo $usrgidnumber;
			foreach($datagroups as $group){
				//print_r($group);
				if(isset($group['memberuid'])){
					$members = $group['memberuid'];
					foreach($members as $member){
						if($member != $members['count']){
							//echo $member."</br>";
							if($member == Session::getUser()){
								$groups[] = $group['cn'][0];
							}
						}
					}
				}
				//echo "Group: ".$group['gidnumber'][0]."<br/>";
				//echo "Usr: ". $usrgidnumber."<br/>";
				if($group['gidnumber'][0] == $usrgidnumber){
					$groups[] = $group['cn'][0];
				}
			}
			//print_r($groups);
			//exit();
			return $groups;
		}
	}
	public function getAllmysqlGroups(){
		$cmd = "SELECT * FROM com_ldap_group;";
		$result = mysql_query($cmd,Settings::getMYSQLConnection());
		$groups = '';
		while ($group = mysql_fetch_array($result)) {
			$data = array();
			$data['names'] = $group['name'];
			$data['componentgroups'] = $group['componentgroups'];
			$groups[] = $data;
		}
		//print_r($groups);
		//exit();
		return $groups;
	}
	function logout(){
		ldap_close($this->ldapcon);
	}
	public function getLdapField($_field){
		if(Session::getUser() != 'admin'){
			$attribute = array($_field);
			$result = ldap_search($this->ldapcon,Settings::getLDAPUserDirectory().",".Settings::getLDAPBaseDN(),'uid='.Session::getUser(),$attribute);
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
	public function editLDAPField($_field,$_newvalue){
		$attribute = array();
		$attribute[$_field] = array();
		$attribute[$_field] = $_newvalue;
		$result = ldap_modify($this -> ldapcon,'uid='.Session::getUser().
				Settings::getLDAPUserDirectory().",".Settings::getLDAPBaseDN(),
				$attribute);
		if(!$result){
			$result = ldap_error($this -> ldapcon);
			print_r($attribute);
			echo "<br/>";
			echo "result: ".$result;
			exit();
			forwarding::routeBack(TRUE,"LdapUserData",$result);
		}

	}
}

?>