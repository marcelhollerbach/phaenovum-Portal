<?php
class SettingsController {
	private $_icon_settings_files;
	private function readINIFiles() {
		$icon_settings_files = array();
		if (is_dir('./../icon_settings/')) {
			if ($dir = opendir('./../icon_settings/')) {
				while (($file = readdir($dir)) !== FALSE) {
					if ($file != '..' && $file != '.' && $file != 'default.ini') {
						if (is_file('./../icon_settings/' . $file)) {
							$icon_settings_files[] = $file;
						}
					}
				}
				closedir($dir);
			}
		}
		$this -> _icon_settings_files = $icon_settings_files;
	}

	function render() {
		$this -> readINIFiles();
		echo "<div id=\"leftlist\">";
		//echo "<div id=\"icons\">";
		echo "<table>";
		$counter = 0;
		foreach ($this -> _icon_settings_files as $icon) {
			echo "<tr id=\"iconliste\">";
			echo "<td><input type=\"checkbox\" name=\"Kenntnisse".$counter."\" value=\"HTML\" /></td>";
			$ini = parse_ini_file('./../icon_settings/' . $icon);
			echo "<td><a id=\"iconlist\">" . $ini['name'] ."</a></td>";
			echo "</tr>";
			$counter = $counter +1;
		}
		echo "</table>";
		echo "</div>";
		echo "<div id=\"toolbar\">";
		echo "<a onclick=\"createIcon()\">new icon</a>";
		echo "</div>";
		//echo "</div>";
	}

	function write_php_ini($array, $file) {
		$res = array();
		foreach ($array as $key => $val) {
			if (is_array($val)) {
				$res[] = "[$key]";
				foreach ($val as $skey => $sval)
					$res[] = "$skey = " . (is_numeric($sval) ? $sval : '"' . $sval . '"');
			} else
				$res[] = "$key = " . (is_numeric($val) ? $val : '"' . $val . '"');
		}
		safefilerewrite($file, implode("\r\n", $res));
	}

}
?>