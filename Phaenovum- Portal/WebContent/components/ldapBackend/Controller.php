<?php 
class ldapBackendController{
	private $con;
	private $groups;
	function __construct(){
		if(Settings::getLDAPServer() != 'disable'){
			$this -> groups = array();
			$this ->con = Settings::getMYSQLConnection();
			$this ->getAllmysqlGroups();
			$this ->fixDatabase();
			mysql_select_db($this ->con,Settings::getMYSQLDatenbank());
		}
	}
	function render(){
		if(Settings::getLDAPServer() != 'disable'){
			echo "<div id=\"ldap-sidebar\">";
			foreach($this -> groups['names'] as $key => $group){
				//echo $key;
				//echo $this ->groups['componentgroups'][$key];
				$this ->checkPermission($this ->groups['componentgroups'][$key]);
				echo "<input onclick=\"setChecks('".$group."','".$this ->groups['componentgroups'][$key]."')\" id=\"linkstyle-button\" type=\"submit\" value=\"".$group."\"/><br>";
			}
			echo "</div>";
			echo "<div id=\"ldap-content\">";
			echo "<form action=\"index.php\" method=\"POST\">";
			echo "<input type=\"hidden\" name=\"com\" value=\"ldapBackend\"/>";
			echo "<input type=\"hidden\" name=\"groupname\" value=\"\"/>";
			echo "<h4 name=\"ldap-headline\">asd</h4>";
			foreach (ComponentController::getComponents() as $name => $component){
				echo "<input type=\"checkbox\" name=\"permission[]\" value=\"$name\"/>$name</br>";
			}
			echo "<input type=\"submit\" value=\"update\">";
			echo "</form>";
			if(sizeof($this -> groups['names']) > 0){
				echo "<script type=\"text/javascript\">";
				echo "setChecks('".$this -> groups['names'][0]."','".$this ->groups['componentgroups'][0]."')";
				echo "</script>";
			}
			echo "</div>";
		}else{
			echo " LDAP-Backend disabled";
		}
	}
	function getAllmysqlGroups(){
		$cmd = "SELECT * FROM com_ldap_group;";
		$result = mysql_query($cmd,$this ->con);
		while ($group = mysql_fetch_array($result)) {
			$this -> groups['names'][] = $group['name'];
			$this -> groups['componentgroups'][] = $group['componentgroups'];
		}
		//print_r($this -> groups);
	}
	function checkPermission($rawpermission){
		$permissions = explode("&", $rawpermission);
		$result = "";
		foreach($permissions as $permission){
			$found = FALSE;
			foreach (ComponentController::getComponents() as $name => $component){
				if($permission == $name){
					$found = TRUE;
				}
			}
			if($found){
				$result .= "&".$permission;
			}
		}
	}
	function fixDatabase(){
		$inst = Authorization::getInst();
		$ldapgroups = $inst ->getAllLdapGroups();
		foreach($ldapgroups['cn'] as $realldapgroup){
			$found = FALSE;
			//look for all groups
			foreach($this ->groups['names'] as $mysqlLdapName){
				if($mysqlLdapName == $realldapgroup){
					$found = TRUE;
				}
			}
			if(!$found){
				//group not in mysql => create it.
				//$this -> create($realldapgroup);
				if(!$this -> create($realldapgroup)){
					echo mysql_error($this ->con);
				}

			}
		}
	}
	function update($name,$permission){
		$cmd = "UPDATE com_ldap_group SET componentgroups='" . $permission . "'WHERE name='" . $name . "';";
		$result = mysql_query($cmd,$this->con);
		return $result;
	}

	function create($ldapname){
		$cmd = 'INSERT INTO com_ldap_group (name) VALUES (\'' . $ldapname . '\');';
		$result = mysql_query($cmd,$this->con);
		return $result;
	}
	function task(){
		$permission = "";
		foreach($_POST['permission'] as $checked){
			$permission .= "&".$checked;
		}
		$this ->update($_POST['groupname'],$permission);
		forwarding::routeBack(TRUE, 'IconSettings');
	}
}
?>