<?php
//require_once 'Compontents.php';
//require_once 'Authorization.php';
//require_once '../components/newsfeed/newsController.php';
//require_once './newsfeed/newsController.php';
//require_once './components/iconssettingsComponent/SettingsController.php';
class UserBash {
	private $items;
	function __construct() {

	}

	private function searchInArray($array, $word) {
		foreach ($array as $part) {
			if ($part == $word) {
				return TRUE;
			}
		}
		return FALSE;
	}

	private function buildMenu() {
		//icons Menubar
		//news_p news-publishment
		//news_e news-einreichen
		//irc chat jeder
		//$permissions_string = Authorization::getPermissions();
		//$permissions = explode("&", $permissions_string);
		$this -> items = array();
		foreach(ComponentController::getComponents() as $name => $component){
			if (Authorization::searchForPermissions($name)) {
				$this -> items[] = new TabbedItem($name,$component);
			}
		}
		//if (Authorization::searchForPermissions('newsfeed')) {
		//	$this -> items[] = new TabbedItem('newsfeed', ComponentController::getComponent('newsfeed'));
		//}
		// 		if (Authorization::searchForPermissions('news_e')) {
		// 			$this -> items[] = new TabbedItem('Newsfeed-einreichung', new Component('News einrichtung'));
		// 		}
		// 		if (Authorization::searchForPermissions('irc')) {
			// 			$this -> items[] = new TabbedItem('IRC', new Component('irc-Chat'));
			// 		}
		//if (Authorization::searchForPermissions('IconSettings')) {
			//$this -> items[] = new TabbedItem('IconSettings', ComponentController::getComponent('IconSettings'));
		//}
	}

	public function login($succes) {
		echo "<div id=\"login\">";
		if ($succes == 'failed') {
			echo "<h4> Login Fehlgeschlafen, bitte Probieren Sie es erneut </h4>";
		} else {
			echo "<h4> Login:</h4>";
		}
		echo "<div id=\"field\">";
		echo "<form action=\"index.php\" method=\"POST\">";
		echo "<input type=\"hidden\" name=\"request\" value=\"login\">";
		echo "<label id=\"label_usr\" for=\"usr\"> Benutzername </label>";
		echo "<input onmouseover=\"unvisible('label_usr',this,0)\" onkeydown=\"unvisible('label_usr',this,1)\" onmouseleave=\"unvisible('label_usr',this,-1)\"id=\"usr\" type=\"text\" name=\"usr\"/> <br>";
		echo "</div>";
		echo "<div id=\"field\">";
		echo "<label id=\"label_pw\" for=\"usr\"> Passwort </label>";
		echo "<input onmouseover=\"unvisible('label_pw',this,0)\" onkeydown=\"unvisible('label_pw',this,1)\" onmouseleave=\"unvisible('label_pw',this,-1)\" id=\"pw\"type=\"password\" name=\"pw\"/> <br>";
		echo "</div>";
		echo "<input type=\"submit\" value=\"Login\"/>";
		echo "</form>";
		echo "</div>";

	}

	public function content($request) {
		$this -> buildMenu();
		$contents = array();
		echo "<div id=\"head\">";
		$counter = 0;
		foreach (($this -> items) as $lalab) {
			$inst = $lalab -> getInstance();
			$name = $lalab -> getName();
			if ($name == $request) {
				echo "<div id=\"tabbeditemselect\">";
			} else {
				echo "<div id=\"tabbeditem\">";
			}
			echo "<form id=\"tabbeditem\" action=\"index.php\" method=\"POST\">";
			echo "<input type=\"hidden\" name=\"request\" value=\"settings\">";
			echo "<input type=\"hidden\" name=\"application\" value=\"" . $name . "\">";
			echo "<input type=\"submit\" value=\"" . $name . "\">";
			echo "</form>";
			echo "</div>";
			$contents[] = $inst;
			$counter = $counter + 1;
		}
		//echo "<a id=\"tabbeditem\" name=\"a_logout\" onclick=\"logout()\" >Logout</a>";
		echo "<form id=\"tabbeditemselect\" action=\"index.php\" method=\"POST\">";
		echo "<input type=\"hidden\" name=\"request\" value=\"logout\">";
		echo "<input type=\"submit\" value=\"Logout\"\">";
		echo "</form>";
		echo "</div>";
		echo "<div id=\"content\">";

		if ($request == 'none') {
			$application = ($this -> items);
			$content = $application[0] -> getInstance();
			$name = $application[0] -> getName();
			echo "<div id=\"tabbedpane\" >";
			$content -> render();
			echo "</div>";
		} else {
			foreach (($this -> items) as $application) {
				$content = $application -> getInstance();
				$name = $application -> getName();
				if ($name == $request) {
					echo "<div id=\"tabbedpane\"\">";
					$content -> render();
					echo "</div>";
				}
			}
		}
		echo "</div>";
	}

}

/**
 *
 */
class TabbedItem {
	private $_name;
	private $_instance;
	function __construct($name, $instance) {
		$this -> _name = $name;
		$this -> _instance = $instance;
	}

	function getName() {
		return $this -> _name;
	}

	function getInstance() {
		return $this -> _instance;
	}

}
?>