<?php
/**
 *
 */
class SettingsController{
	private $_icon_settings_files;
	function __construct() {
		$icon_settings_files = array();
		if (is_dir('../icon_settings/')) {
			if ($dir = opendir('../icon_settings/')) {
				while (($file = readdir($dir)) !== FALSE) {
					if ($file != '..' && $file != '.') {
						$icon_settings_files[] = $file;
					}
				}
				closedir($dir);
			}
		}
		$this -> _icon_settings_files = $icon_settings_files;
	}
	function render(){
		echo "<ul>";
		foreach ($this -> _icon_settings_files as $icon) {
			$ini = parse_ini_file('../icon_settings/'.$icon);
			echo "<li>".$ini['name']."</li>";
		}
		echo "</ul>";
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