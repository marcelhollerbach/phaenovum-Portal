<?php 
class ldapBackendController{
	private $con;
	function __construct(){
		if(Settings::getLDAPServer() != 'disable'){
			$this -> groups = array();
			$this ->con = Settings::getMYSQLConnection();
			$this ->fixDatabase();
			mysql_select_db(Settings::getMYSQLDatenbank());
			$this -> name = "";
			$this -> permission = "";
		}
	}
	function render(){
		if(Settings::getLDAPServer() != 'disable'){
			echo "<div id=\"ldap-sidebar\">";
			$groups = $this -> getAllmysqlGroups();
			//print_r($groups);
			foreach($groups as $group)
			{
				//print_r($group);
				//echo "</br>";
				//echo $group['names']."</br>";
				echo "<form action=\"index.php\" method=\"POST\">";
				echo "<input type=\"hidden\" name=\"com\" value=\"ldapBackend\">";
				echo "<input type=\"hidden\" name=\"task\" value=\"chgroup\"/>";
				echo "<input type=\"hidden\" name=\"groupname\"value=\"".$group['names']."\">";
				echo "<input type=\"hidden\" name=\"groupPermission\"value=\"".$group['componentgroups']."\">";
				//echo "<input onclick=\"setChecks('".$group."','".$this ->groups['componentgroups'][$key]."')\" id=\"linkstyle-button\" type=\"submit\" value=\"".$group."\"/><br>";
				echo "<input id=\"linkstyle-button\" type=\"submit\" value=\"".$group['names']."\"/><br>";
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
				//if(sizeof($permissions)!=0){
				foreach($permissions as $permission){
					if($permission != ""&&$permission != " "){
						if($this -> isChecked($this -> permission,$permission)){
							echo "<input style=\"margin-left:20px\" type=\"checkbox\" name=\"permission[]\" checked=\"true\" value=\"$permission\"/>$permission</br>";
						}else{
							echo "<input style=\"margin-left:20px\" type=\"checkbox\" name=\"permission[]\" value=\"$permission\"/>$permission</br>";
						}
					}
					//}
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
		return Authorization::getInst() -> getLDAPBackend() ->getAllmysqlGroups();
	}
	function fixDatabase(){
		if(Settings::getLDAPServer() != 'disable'){
			$inst = Authorization::getInst() ->getLDAPBackend();
			$ldapgroups = $inst ->getAllLdapGroups();
			foreach($ldapgroups as $realldapgroup){
				$found = FALSE;
				$mysqlgroups = $inst->getAllmysqlGroups();
				foreach($mysqlgroups as $mysqlgroup){
					//echo "-".$realldapgroup['cn']."-<br>";
					//	echo "-".$mysqlgroup['names']."-<br>";
					if($realldapgroup['cn'] == $mysqlgroup['names']){
						//gruppe existiert bereits
						$found = TRUE;
						break;
					}else{
						$found = FALSE;
					}
				}
				if(!$found){
					if($realldapgroup != ''){
						$this -> create($realldapgroup['cn']);
					}
				}
			}
		}
		foreach($mysqlgroups as $mysqlgroup){
			$found = FALSE;
			foreach($ldapgroups as $realldapgroup){
				if($mysqlgroup['names'] == $realldapgroup['cn']){
					$found = TRUE;
				}
			}
			if(!$found){
				//echo $mysqlgroup['names'];
				$this -> delete($mysqlgroup['names']);
			}
		}
	}
	function delete($name){
		if(Settings::getLDAPServer() != 'disable'){
			$cmd = "DELETE FROM com_ldap_group WHERE name=\"".$name."\";";
			$result = mysql_query($cmd,$this->con);
			return $result;
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