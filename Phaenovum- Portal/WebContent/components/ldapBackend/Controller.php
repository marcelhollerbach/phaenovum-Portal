<?php 
class ldapBackendController{
	private $con;
	private $groups;
	private $name;
	private $permission;
	function __construct(){
		if(Settings::getLDAPServer() != 'disable'){
			$this -> groups = array();
			$this ->con = Settings::getMYSQLConnection();
			$this ->getAllmysqlGroups();
			$this ->fixDatabase();
			mysql_select_db(Settings::getMYSQLDatenbank());
			$this -> name = "";
			$this -> permission = "";
		}
	}
	function render(){
		if(Settings::getLDAPServer() != 'disable'){
			if($this -> name == ""){
				$this -> name = $this -> groups['names'][0];
				$this -> permission = $this -> groups['componentgroups'][0];
			}
			echo "<div id=\"ldap-sidebar\">";
			foreach($this -> groups['names'] as $key => $group){
				//echo $key;
				//echo $this ->groups['componentgroups'][$key];
				//$this ->checkPermission($this ->groups['componentgroups'][$key]);
				echo "<form action=\"index.php\" method=\"POST\">";
				echo "<input type=\"hidden\" name=\"com\" value=\"ldapBackend\">";
				echo "<input type=\"hidden\" name=\"task\" value=\"chgroup\"/>";
				echo "<input type=\"hidden\" name=\"groupname\"value=\"$group\">";
				echo "<input type=\"hidden\" name=\"groupPermission\"value=\"".$this ->groups['componentgroups'][$key]."\">";
				//echo "<input onclick=\"setChecks('".$group."','".$this ->groups['componentgroups'][$key]."')\" id=\"linkstyle-button\" type=\"submit\" value=\"".$group."\"/><br>";
				echo "<input id=\"linkstyle-button\" type=\"submit\" value=\"".$group."\"/><br>";
				echo "</form>";
			}
			echo "</div>";
			echo "<div id=\"ldap-content\">";
			echo "<form action=\"index.php\" method=\"POST\">";
			echo "<input type=\"hidden\" name=\"com\" value=\"ldapBackend\"/>";
			echo "<input type=\"hidden\" name=\"task\" value=\"update\"/>";
			echo "<input type=\"hidden\" name=\"groupname\" value=\"".$this ->name."\"/>";
			echo "<h4 name=\"ldap-headline\">".$this ->name."</h4>";
			foreach (ComponentController::getComponents() as $component){
				$name = $component->getName();
				$permissions = explode("&", $component -> getPermission());
				$perm = $component->getPrimaryPermission();
				if($this -> isChecked($this -> permission,$perm)){
					echo "<input type=\"checkbox\" name=\"permission[]\" checked=\"true\" value=\"$perm\"/>$perm</br>";
				}else{
					echo "<input type=\"checkbox\" name=\"permission[]\" value=\"$perm\"/>$perm</br>";
				}
				foreach($permissions as $permission){
					if($this -> isChecked($this -> permission,$permission)){
						echo "u. <input type=\"checkbox\" name=\"permission[]\" checked=\"true\" value=\"$permission\"/>$permission</br>";
					}else{
						echo "u. <input type=\"checkbox\" name=\"permission[]\" value=\"$permission\"/>$permission</br>";
					}
				}
			}
			echo "<input type=\"submit\" value=\"update\">";
			echo "</form>";
			//if(sizeof($this -> groups['names']) > 0){
			//	echo "<script type=\"text/javascript\">";
			//	echo "setChecks('".$this -> groups['names'][0]."','".$this ->groups['componentgroups'][0]."')";
			//	echo "</script>";
			//}
			echo "</div>";
		}else{
			echo " LDAP-Backend disabled";
		}
	}
	function isChecked($checkedpermission,$totest){
		$permissions = explode("&", $checkedpermission);
		foreach($permissions as $permission){
			if($totest == $permission){
				return TRUE;
			}
		}
		return FALSE;

	}
	function getAllmysqlGroups(){
		if(Settings::getLDAPServer() != 'disable'){
			$cmd = "SELECT * FROM com_ldap_group;";
			$result = mysql_query($cmd,$this ->con);
			while ($group = mysql_fetch_array($result)) {
				$this -> groups['names'][] = $group['name'];
				$this -> groups['componentgroups'][] = $group['componentgroups'];
			}
		}
		//print_r($this -> groups);
	}
	// 	function checkPermission($rawpermission){
	// 		if(Settings::getLDAPServer() != 'disable'){
	// 			$permissions = explode("&", $rawpermission);
	// 			$result = "";
	// 			foreach($permissions as $permission){
	// 				$found = FALSE;
	// 				foreach (ComponentController::getComponents() as $name => $component){
	// 					if($permission == $name){
	// 						$found = TRUE;
	// 					}
	// 				}
	// 				if($found){
	// 					$result .= "&".$permission;
	// 				}
	// 			}
	// 			return $result;
	// 		}
	// 	}
	function fixDatabase(){
		if(Settings::getLDAPServer() != 'disable'){
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
	}
	function update($name,$permission){
		if(Settings::getLDAPServer() != 'disable'){
			$cmd = "UPDATE com_ldap_group SET componentgroups='" . $permission . "'WHERE name='" . $name . "';";
			$result = mysql_query($cmd,$this->con);
			return $result;
		}
	}

	function create($ldapname){
		if(Settings::getLDAPServer() != 'disable'){
			$cmd = 'INSERT INTO com_ldap_group (name) VALUES (\'' . $ldapname . '\');';
			$result = mysql_query($cmd,$this->con);
		}
		return $result;
	}
	function task(){
		if(Settings::getLDAPServer() != 'disable'){
			switch ($_POST['task']){
				case 'update':
					$permission = "";
					foreach($_POST['permission'] as $checked){
						$permission .= "&".$checked;
					}
					$result =	$this ->update($_POST['groupname'],$permission);
					if($result!= "1"){
						forwarding::routeBack(TRUE, 'ldapBackend',$result);
					}
					//forwarding::routeBack(TRUE, 'IconSettings');
					break;
				case 'chgroup':
					$this -> name = $_POST['groupname'];
					$this -> permission = $_POST['groupPermission'];
					break;
			}
		}
	}
}
?>