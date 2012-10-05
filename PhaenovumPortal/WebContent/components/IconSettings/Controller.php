<?php
/*
 *
*/
class IconSettingsController {
	private $_icons;
	private $con;
	private $index;
	function __construct() {
		$this -> con = Settings::getMYSQLConnection();
		mysql_select_db(Settings::getMYSQLDatenbank(), $this -> con);
		$this -> index = -1;
	}

	private function readIcons() {
		$this -> _icons;
		$comand = 'SELECT * FROM com_icons';
		$result = mysql_query($comand);
		if (!$result) {
			echo "error" . mysql_error();
		} else {
			while ($icon = mysql_fetch_array($result)) {
				$this -> _icons[] = $icon;
			}
		}
	}

	function render() {
		$this -> readIcons();
		if($this -> index == -1){
			$this -> index = 0;
		}
		echo "<div id=\"leftlist\">";
		echo "<form name=\"iconselect\" method=\"POST\" action=\"index.php\">";
		echo "<input type=\"hidden\" name=\"com\" value=\"IconSettings\">";
		echo "<input type=\"hidden\" name=\"task\" value=\"deleteIcon\">";
		$counter = 0;
		if (sizeof($this -> _icons) != 0) {
			foreach ($this -> _icons as $icon) {
				echo "<div onClick=\"setEdit(".$counter.")\">";
				echo $icon['name'] . "</br>";
				echo "</div>";
				$counter = $counter + 1;
			}
		}
		echo "</form>";
		echo "<form name=\"editIcon\" method=\"POST\" action=\"index.php\">";
		echo "<input type=\"hidden\" name=\"com\" value=\"IconSettings\">";
		echo "<input type=\"hidden\" name=\"task\" value=\"chIcon\">";
		echo "<input type=\"hidden\" name=\"iconName\" value=\"\">";
		echo "</form>";
		echo "</div>";
		echo "<div id=\"toolbar\">";
		echo "<form method=\"POST\" name=\"newIcon\" action=\"index.php\">";
		echo "<input type=\"hidden\" name=\"com\" value=\"IconSettings\">";
		echo "<input type=\"hidden\" name=\"task\" value=\"newIcon\">";
		echo "<input type=\"hidden\" name=\"iconname\" value=\"\">";
		echo "</form>";
		echo "<div id=\"holder\">";
		echo "<input id=\"left\"  onclick=\"setIconName();\"type=\"submit\" value=\"newIcon\"/>";
		echo "</div>";
		echo "</div>";
		echo "<div id=\"editor\">";
		echo "<form enctype=\"multipart/form-data\"  method=\"POST\" name=\"editIcon\" action=\"index.php\">";
		echo "<input type=\"hidden\" name=\"com\" value=\"IconSettings\">";
		echo "<input type=\"hidden\" name=\"task\" value=\"editIcon\">";
		if(sizeof($this->_icons) != 0){
			$icon = $this->_icons[$this -> index];
			$position = $icon['position'];
			$name = $icon['name'];
			$iconurl = $icon['icon'];
			$in = $icon['in_network'];
			$out = $icon['out_network'];
			$popup = $icon['popup'];
			$publish = $icon['published'];
		}
		echo "<input type=\"hidden\" name=\"currentname\" value=\"".$name."\">";
		//Name
		$this -> textfield('new_name', 'Name',$name);
		//Icon
		echo "Icon Url: <input name=\"icon\" type=\"file\" size=\"30\" accept=\"*.png\">";
		echo" <div  name=\"currentpic\">Aktuelles Bild:</br>
				<img name=\"currpic\" src=\"".$iconurl."\"/> </div> </br>";
		//in network
		$this -> textfield('in_network', 'In Netwerk Adresse',$in);
		//outnetwork
		$this -> textfield('out_network', 'Außen Adresse',$out);
		//popup
		$this -> checkbox('popup', 'Popup',$popup);
		//publish
		$this -> checkbox('published', 'veröffentlichen',$publish);
		echo "<input  type=\"submit\" value=\"Edit\">";
		echo "</form>";
		echo "<form method=\"POST\" action=\"index.php\">";
		echo "<input type=\"hidden\" name=\"com\" value=\"IconSettings\">";
		echo "<input type=\"hidden\" name=\"task\" value=\"deleteIcon\">";
		echo "<input type=\"hidden\" name=\"iconName\" value=\"$name\">";
		echo "<input type=\"submit\" value=\"deleteIcon\">";
		echo "</form>";
		echo "</div>";
	}

	function jsarray($name, $array) {
		echo " var $name = new Array(";
		echo '"' . implode('","', $array) . '"); ';
	}

	function textfield($name,$value, $schrift) {
		FormBuilder::renderTextField($name,$value,FALSE,$schrift);
	}

	function checkbox($name, $schrift,$checked = FALSE) {
		echo "<input type=\"checkbox\" ";
		if($checked){
			echo "checked=1";
		}
		echo " name=\"".$name."[]\" value=\"" . $name . "\" /> " . $schrift . "<br />";
	}

	function task() {
		if (isset($_POST['task'])) {
			switch ($_POST['task']) {
				case 'chIcon':
					$this -> index = $_POST['iconName'];
					break;
				case 'newIcon' :
					if(isset($_POST['iconname'])){
						$result = $this ->createIcon($_POST['iconname']);
						if ($result != NULL) {
							forwarding::routeBack(TRUE, 'IconSettings', $result);
						} else {
							forwarding::routeBack(TRUE, 'IconSettings');
						}
					}else{
						forwarding::routeBack(TRUE, 'IconSettings', "Namen Angeben !");
					}
					break;
				case 'deleteIcon' :
					if (isset($_POST['iconName'])) {
						$icon = $_POST['iconName'];
						if (($result = $this ->deleteIcon($icon)) != NULL) {
							forwarding::routeBack(TRUE, 'IconSettings', $result);
							exit();
						}
					}
					break;
				case 'editIcon' :
					$currentname = $_POST['currentname'];
					$new_name = $_POST['new_name'];
					$icon = "";
					if ($_FILES['icon']['name'] != '') {
						$this ->uploadFile($_FILES['icon']['tmp_name']);
						$icon = './icon_images/' . $_FILES['icon']['name'];
					}
					$in_network = $_POST['in_network'];
					$out_network = $_POST['out_network'];
					$popup = FALSE;
					$published = FALSE;
					if(isset($_POST['popup'])){
						$popup = TRUE;
					}
					if(isset($_POST['published'])){
						$published = TRUE;
					}
					$result = $this ->editIcon($currentname, $new_name, $icon, $in_network, $out_network, $popup, $published);
					if ($result == NULL) {
						forwarding::routeBack(TRUE, 'IconSettings');
					} else {
						forwarding::routeBack(TRUE, 'IconSettings', $result);
					}
					break;
				default :
					break;
			}
		}
	}

	function deleteIcon($name) {
		$con = Settings::getMYSQLConnection();
		mysql_select_db(Settings::getMYSQLDatenbank(), $con);
		$result = mysql_query('DELETE FROM com_icons WHERE name =\'' . $name . '\'');
		if (!$result) {
			return "Fehler:" . mysql_error($con);
		} else {
			return NULL;
		}
	}
	function createIcon($name) {
		$con = Settings::getMYSQLConnection();
		mysql_select_db(Settings::getMYSQLDatenbank(), $con);
		$result = mysql_query('INSERT INTO com_icons (name) VALUES (\'' . $name . '\')');
		if (!$result) {
			return "Fehler:" . mysql_error($con);
		} else {
			return NULL;
		}
	}

	function editIcon($currentname, $name, $icon, $in_network, $out_network, $popup, $published) {
		$con = Settings::getMYSQLConnection();
		mysql_select_db(Settings::getMYSQLDatenbank(), $con);
		$cmd = "UPDATE com_icons SET name='" . $name . "' ";
		if ($icon != "") {
			$cmd .= ",icon='" . $icon . "'";
		}
		$cmd .= ",in_network='" . $in_network . "' ,out_network='" . $out_network . "' ,popup='" . $popup . "' ,published='" . $published . "' WHERE name='" . $currentname . "';";
		$result = mysql_query($cmd);
		if (!$result) {
			return "Error:" . mysql_error($con);
		} else {
			return NULL;
		}
	}

	function uploadFile($filename) {
		if (move_uploaded_file($filename, './icon_images/' . $_FILES["icon"]["name"])) {
			return NULL;
		} else {
			return "Error";
		}
	}
}
?>