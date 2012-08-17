<?php
/**
 *
 */
class PortalBuilder {
	private $_icon_settings_files;
	private $_ursprung;

	function __construct() {
		require_once './bash/UserBash.php';
		require_once './settings/Settings.php';
		require_once './bash/Authorization.php';
		$this -> _ursprung = $_SERVER['SERVER_NAME'];
		$this -> _icon_settings_files = array();
		$this -> readIcons();
	}

	private function readIcons() {
		$this -> _icon_settings_files;
		$comand = 'SELECT * FROM com_icons';
		$result = mysql_query($comand);
		if (!$result) {
			echo "error".mysql_error();
		} else {
			while ($icon = mysql_fetch_array($result)) {
				$this -> _icon_settings_files[$icon['name']] = $icon;
			}
		}
	}

	function content() {
		echo "<div id=\"small_sidebar\" onclick=\"dropOut()\" ></div>
		<div id=\"sidebar_holder\" style=\"display: none\">
		<div id=\"halbtransparent\"></div>
		<div id=\"sidebar\" onmouseleave=\"dropin()\">";
		$i = 0;
		foreach ($this ->_icon_settings_files as $icon) {
			if($icon['published']){
				$link;
				if ($this -> _ursprung == '192.168.3.10' || $this -> _ursprung == 'fileserver') {
					//netzwerk intern
					$link = $icon['in_network'];
				} else {
					//nicht intern
					$link = $icon['out_network'];
				}
				$this -> barIcon($link,  $icon['icon'],  $icon['name'], $icon['popup'], $i);
				$i += 1;
			}else{
				//echo "hidden";
			}
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
			echo "<a href=\"" . $link . "\" onclick=\"setSite('" . $link . "')\" target=\"output\"  oncontextmenu=\"contextOut(" . $id . "); return false\">";
		}
		echo "<img src=\"" . $icon . "\" title=\"" . $name . "\" /></a>";
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
		//echo "<div id=\"barIcon_settings\">
		//			<div id=\"doc\">
		//				<a href=\"#\" oncontextmenu=\"return false\" onclick=\"showSettingsBash();refreshlogin(1)\"><img src=\"./icon_images/ICONPORTALphaenovum.png\"/></a>
		//			</div>
		//		</div>";
		echo "<div id=\"barIcon_settings\">";
		echo "<div id=\"doc\">";
		echo "<form name=\"setting\" action=\"index.php\" method=\"POST\">";
		echo "<input type=\"hidden\" name=\"request\" value=\"bash\">";
		echo "<input type=\"hidden\" name=\"site\" value=\"\">";
		echo "<input type=\"image\" src=\"./icon_images/ICONPORTALphaenovum.png\">";
		echo "</form>";
		echo "</div>";
		echo "</div>";

	}

	public function createbash() {
		echo "<div id=\"bash_holder\" style=\" display: none;\">";
		//background
		echo "<div id=\"bash_background\">";
		echo "</div>";
		//bash
		echo "<div id=\"bash\">";
		echo "<div id=\"bash_content\" name=\"bash_content\">";
		//content
		$userbash = new UserBash();
		if (!isset($_SESSION['login']) || !$_SESSION['login']) {
			//nicht eingeloggt
			$userbash -> login('none');
		} else {
			if (isset($_POST['application'])) {
				$userbash -> content($_POST['application']);
			} else {
				$userbash -> content('none');
			}
		}
		echo "</div>";
		echo "</div>";
		echo "<div id=\"bash_topbar\">";
		echo "<div id=\"bash_close\">";
		echo "<a onclick=\"hideSettingsBash()\"><img src=\"./icons/close_button.png\"/></a>";
		echo "</div>";
		echo "<div id=\"bash_name\"><h4>Phaenovum-Bash</h4></div>";
		echo "</div>";
		echo "</div>";

	}

}
?>