<?php
/*
 *
 */
class IconSettingsController {
	private $_icons;
	private $con;
	function __construct() {
		$this -> con = Settings::getMYSQLConnection();
		mysql_select_db(Settings::getMYSQLDatenbank(), $this -> con);
	}

	private function readIcons() {
		$this -> _icons;
		$comand = 'SELECT * FROM com_icons';
		$result = mysql_query($comand);
		if (!$result) {
			echo "error" . mysql_error();
		} else {
			while ($icon = mysql_fetch_array($result)) {
				$this -> _icons[$icon['name']] = $icon;
			}
		}
	}

	function render() {
		$this -> readIcons();
		if (sizeof(($this -> _icons)) != 0) {
			$position = array();
			$name = array();
			$iconurl = array();
			$in = array();
			$out = array();
			$popup = array();
			$publish = array();
			//arrays formen
			foreach ($this -> _icons as $icon) {
				$position[] = $icon['position'];
				$name[] = $icon['name'];
				$iconurl[] = $icon['icon'];
				$in[] = $icon['in_network'];
				$out[] = $icon['out_network'];
				$popup[] = $icon['popup'];
				$publish[] = $icon['published'];
			}
			echo "<script type=\"text/javascript\">";
			//name
			$this -> jsarray('names', $name);
			//position
			$this -> jsarray('position', $position);
			//icon
			$this -> jsarray('icon', $iconurl);
			//in_network
			$this -> jsarray('in_net', $in);
			//out_network
			$this -> jsarray('out_net', $out);
			//popup
			$this -> jsarray('popup', $popup);
			//published
			$this -> jsarray('published', $publish);
			echo "setEdits(names,position,icon,in_net,out_net,popup,published);";
			echo "</script>";
		}
		echo "<div id=\"leftlist\">";
		//echo "<div id=\"icons\">";
		echo "<form name=\"iconselect\" method=\"POST\" action=\"index.php\">";
		echo "<input type=\"hidden\" name=\"com\" value=\"IconSettings\">";
		echo "<input type=\"hidden\" name=\"task\" value=\"Icon\">";
		$counter = 0;
		if (sizeof($this -> _icons) != 0) {
			foreach ($this -> _icons as $icon) {
				//setEdit($counter,names,position,icon,in_net,out_net,popup,published)
				echo "<input type=\"checkbox\" name=\"icons[]\" onClick=\"setEdit($counter)\" value=\"" . $icon['name'] . "\" />" . $icon['name'] . "</br>";

				$counter = $counter + 1;
			}
		}
		echo "</form>";
		echo "</div>";
		echo "<div id=\"toolbar\">";
		echo "<form method=\"POST\" name=\"newIcon\" action=\"index.php\">";
		echo "<input type=\"hidden\" name=\"com\" value=\"IconSettings\">";
		echo "<input type=\"hidden\" name=\"task\" value=\"newIcon\">";
		echo "<input type=\"hidden\" name=\"iconname\" value=\"\">";
		echo "</form>";
		echo "<input  onclick=\"setIconName();\"type=\"submit\" value=\"newIcon\">";

		echo "<input  onclick=\"submitDelete();\"type=\"submit\" value=\"deleteIcon\">";
		echo "</div>";
		echo "<div id=\"editor\">";
		echo "<form enctype=\"multipart/form-data\"  method=\"POST\" name=\"editIcon\" action=\"index.php\">";
		echo "<input type=\"hidden\" name=\"com\" value=\"IconSettings\">";
		echo "<input type=\"hidden\" name=\"task\" value=\"editIcon\">";
		echo "<input type=\"hidden\" name=\"currentname\" value=\"\">";
		//Name
		$this -> textfield('new_name', 'Name');
		//Icon
		echo "Icon Url: <input name=\"icon\" type=\"file\" size=\"30\" accept=\"*.png\"> <div style=\"display:none\" name=\"currentpic\">Aktuelles Bild:</br><img name=\"currpic\"/> </div> </br>";
		//in network
		$this -> textfield('in_network', 'In Netwerk Adresse');
		//outnetwork
		$this -> textfield('out_network', 'Außen Adresse');
		//popup
		$this -> checkbox('popup', 'Popup');
		//publish
		$this -> checkbox('published', 'veröffentlichen');
		echo "<input  type=\"submit\" value=\"Edit\">";
		echo "</form>";
		echo "<script type=\"text/javascript\">";
		if (sizeof($name) > 0) {
			echo "setEdit(0);";
		}
		echo "</script>";
		echo "</div>";
	}

	function jsarray($name, $array) {
		echo " var $name = new Array(";
		echo '"' . implode('","', $array) . '"); ';
	}

	function textfield($name, $schrift) {
		echo $schrift . ": <input type=\"text\" name=\"" . $name . "\"/> <br>";
	}

	function checkbox($name, $schrift) {
		echo "<input type=\"checkbox\" name=\"check[]\" value=\"" . $name . "\" /> " . $schrift . "<br />";
	}

	function task() {
		if (isset($_POST['task'])) {
			switch ($_POST['task']) {
				case 'newIcon' :
					$result = IconSettingsController::createIcon($_POST['iconname']);
					if ($result != NULL) {
						forwarding::routeBack(TRUE, 'IconSettings', $result);
					} else {
						forwarding::routeBack(TRUE, 'IconSettings');
					}
					break;
				case 'deleteIcon' :
					if (isset($_POST['icons'])) {
						$selectedicons = $_POST['icons'];
						foreach ($selectedicons as $icon) {
							if (($result = IconSettingsController::deleteIcon($icon)) != NULL) {
								forwarding::routeBackwithError(TRUE, 'IconSettings', $result);
								exit();
							}
						}
						forwarding::routeBack(TRUE, 'IconSettings');
					} else {
						forwarding::routeBack(TRUE, 'IconSettings', 'Icon zum Löschen auswählen !');
						exit();
					}
					break;
				case 'editIcon' :
					$currentname = $_POST['currentname'];
					$new_name = $_POST['new_name'];
					$icon = "";
					if ($_FILES['icon']['name'] != '') {
						IconSettingsController::uploadFile($_FILES['icon']['tmp_name']);
						$icon = './icon_images/' . $_FILES['icon']['name'];
					}
					$in_network = $_POST['in_network'];
					$out_network = $_POST['out_network'];
					$popup = FALSE;
					$published = FALSE;
					if (isset($_POST['check'])) {
						if ($_POST['check'][0] == 'popup') {
							$popup = TRUE;
							if (sizeof($_POST['check']) > 1) {
								if ($_POST['check'][1] == 'published') {
									$published = TRUE;
								}
							}
						}
						if ($_POST['check'][0] == 'published') {
							$published = TRUE;
						}

					}
					$result = IconSettingsController::editIcon($currentname, $new_name, $icon, $in_network, $out_network, $popup, $published);
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

	static function deleteIcon($name) {
		$con = Settings::getMYSQLConnection();
		mysql_select_db(Settings::getMYSQLDatenbank(), $con);
		$result = mysql_query('DELETE FROM com_icons WHERE name =\'' . $name . '\'');
		if (!$result) {
			return "Fehler:" . mysql_error($con);
		} else {
			return NULL;
		}
	}

	static function createIcon($name) {
		$con = Settings::getMYSQLConnection();
		mysql_select_db(Settings::getMYSQLDatenbank(), $con);
		$result = mysql_query('INSERT INTO com_icons (name) VALUES (\'' . $name . '\')');
		if (!$result) {
			return "Fehler:" . mysql_error($con);
		} else {
			return NULL;
		}
	}

	static function editIcon($currentname, $name, $icon, $in_network, $out_network, $popup, $published) {
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

	static function uploadFile($filename) {
		if (move_uploaded_file($filename, './icon_images/' . $_FILES["icon"]["name"])) {
			return NULL;
		} else {
			return "Error";
		}
	}
}
?>