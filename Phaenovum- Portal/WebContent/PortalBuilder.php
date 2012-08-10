<?php
/**
 *
 */
class PortalBuilder {
	private $_icon_settings_files;
	private $_ursprung;

	function __construct() {
		$this -> _ursprung = $_SERVER['SERVER_NAME'];
		$this -> _icon_settings_files = array();
		$icon_settings_files = array();
		if (is_dir('./icon_settings/')) {
			if ($dir = opendir('./icon_settings/')) {
				while (($file = readdir($dir)) !== FALSE) {
					if ($file != '..' && $file != '.'&&$file != 'default.ini') {
						if (is_file('./icon_settings/'.$file)) {
							$icon_settings_files[] = $file;
						}
					}
				}
				closedir($dir);
			}
		}
		$this -> _icon_settings_files = $icon_settings_files;
	}

	function content() {
		echo "<div id=\"small_sidebar\" onclick=\"dropOut()\" ></div>
		<div id=\"sidebar_holder\" style=\"display: none\">
			<div id=\"halbtransparent\"></div>
			<div id=\"sidebar\" onmouseleave=\"dropin()\">";

		for ($i = 0, $groesse = sizeof($this -> _icon_settings_files); $i < $groesse; ++$i) {
			$parsed_ini = parse_ini_file('./icon_settings/' . $this -> _icon_settings_files[$i]);
			$icon = $parsed_ini['icon'];
			$name = $parsed_ini['name'];
			$popup = $parsed_ini['popup'];
			$link;
			if ($this -> _ursprung == '192.168.3.10' || $this -> _ursprung == 'fileserver') {
				//netzwerk intern
				$link = $parsed_ini['in_network'];
			} else {
				//nicht intern
				$link = $parsed_ini['out_network'];
			}
			$this -> barIcon($link, $icon, $name, $popup, $i);

		}
		$this -> barSettings();
		echo "</div>
			</div>";
		$this -> createbash();
	}

	protected function barIcon($link, $icon, $name, $popup, $id) {
		echo "<div id=\"barIcon\">";
		echo "<div id=\"doc\">";
		if ($popup == 1) {
			echo "<a href=\"#\" onclick=\"pop('" . $link . "')\" oncontextmenu=\"return false;\">";
		} else {
			echo "<a href=\"" . $link . "\" target=\"output\"  oncontextmenu=\"contextOut(" . $id . "); return false\">";
		}
		echo "<img src=\"./icon_images/" . $icon . "\" title=\"" . $name . "\" /></a>";
		echo "</div>";
		//Contextmenu
		echo "<div id=\"context_menu\" name=\"context\" onmouseleave=\"contextIn(" . $id . ")\" style=\" display: none;\">";
		echo "<div id=\"transparent\" >";
		echo "</div>";
		echo "<div id=\"context_menu_content\" >";
		echo "<a href=\"#\" onclick=\"pop('" . $link . "')\" oncontextmenu=\"return false;\">Extern öffnen</a><br>";
		echo "<a href=\"" . $link . "\" target=\"output\"  oncontextmenu=\"contextOut(" . $id . "); return false\">normal öffnen</a>";
		echo "</div>";
		echo "</div>";
		echo "</div>";
	}

	public function barSettings() {
		echo "<div id=\"barIcon_settings\">
					<div id=\"doc\">
						<a href=\"#\" oncontextmenu=\"return false\" onclick=\"showSettingsBash();refreshlogin(1)\"><img src=\"./icon_images/ICONPORTALphaenovum.png\"/></a>
					</div>
				</div>";

	}

	public function createbash() {
		echo "<div id=\"bash_holder\" style=\" display: none;\">";
		//background
		echo "<div id=\"bash_background\">";
		echo "</div>";
		//bash
		echo "<div id=\"bash\">";
		//topbar
		//content
		echo "<div id=\"bash_content\" name=\"bash_content\">";
		//what ever
		//echo "<div id=\"bash_pane\" name=\"bash_pane0\" style=\"  display: block;\">"; 
			
		//echo "</div>";
		//echo "<div id=\"bash_pane\" name=\"bash_pane1\" style=\"  display: none;\"> 
		//<iframe name=\"_bash_output\" src=\"#\">
		//	
		//</iframe> </div>";
		////inhalt
		echo "</div>";
		echo "</div>";
		echo "<div id=\"bash_topbar\">";
		echo "<div id=\"bash_close\">";
		echo "<a onclick=\"hideSettingsBash()\"><img src=\"./icons/close_button.png\"/></a>";
		echo "</div>";
		echo "<div id=\"bash_name\"><h4>Phaenovum- Bash</h4></div>";
		echo "</div>";
		echo "</div>";
		
	}

}
?>