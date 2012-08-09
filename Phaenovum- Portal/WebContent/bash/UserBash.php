<?php
include 'Compontents.php';
include 'Authorization.php';
include '../newsfeed/newsController.php';
/**
 *
 */
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
	private function buildMenu(){
		//icons Menubar
		//news_p news-publishment
		//news_e news-einreichen
		//irc chat jeder
		$permissions_string = Authorization::getPermissions();
		$permissions = explode("&", $permissions_string);
		$this -> items = array();
		if ($this -> searchInArray($permissions, 'news_p')) {
			$this -> items[] = new TabbedItem('Newsfeed', new newsController());
		}
		if ($this -> searchInArray($permissions, 'news_e')) {
			$this -> items[] = new TabbedItem('Newsfeed-einreichung', new Component('News einrichtung'));
		}
		if ($this -> searchInArray($permissions, 'irc')) {
			$this -> items[] = new TabbedItem('IRC', new Component('irc-Chat'));
		}
		if ($this -> searchInArray($permissions, 'icons')) {
			$this -> items[] = new TabbedItem('Icons', new Component('icons'));
		}
	}
	public function login() {
		echo "<div id=\"login\">";
		echo "<h4> Login:</h4>";
		echo "<div id=\"field\">";
		echo "<label id=\"label_usr\" for=\"usr\"> Benutzername </label>";
		echo "<input onmouseover=\"unvisible('label_usr',this,0)\" onkeydown=\"unvisible('label_usr',this,1)\" onmouseleave=\"unvisible('label_usr',this,-1)\"id=\"usr\" type=\"text\" name=\"usr\"/> <br>";
		echo "</div>";
		echo "<div id=\"field\">";
		echo "<label id=\"label_pw\" for=\"usr\"> Passwort </label>";
		echo "<input onmouseover=\"unvisible('label_pw',this,0)\" onkeydown=\"unvisible('label_pw',this,1)\" onmouseleave=\"unvisible('label_pw',this,-1)\" id=\"pw\"type=\"password\" name=\"pw\"/> <br>";
		echo "</div>";
		echo "<input type=\"submit\" onclick=\"login()\" value=\"Login\"/>";
		echo "</div>";
		//	echo "<a id=\"login\" onclick=\"login()\">Login</a>";

	}

	public function content() {
		$this -> buildMenu();
		$contents = array();
		echo "<div id=\"head\">";
		$counter = 0;
		foreach (($this -> items) as $lalab) {
			$inst = $lalab -> getInstance();
			$name = $lalab -> getName();
			echo "<a id=\"tabbeditem\" onclick=\"to('tabbed" . $counter . "')\">" . $name . "</a>";
			$contents[] = $inst;
			$counter = $counter + 1;
			//$contents[] = "<div id=\"tabbedpane\" name=\"".$name."\" style=\"display:".$style.";\">" .$inst -> render(). "</div>";
		}
		echo "<a id=\"tabbeditem\" name=\"a_logout\" onclick=\"logout()\" >Logout</a>";
		echo "</div>";
		echo "<div id=\"content\">";

		$first = 1;
		$counter = 0;
		foreach ($contents as $content) {
			$style = 'none';
			if ($first == 1) {
				$style = "block";
				$first = 0;
			}
			echo "<div id=\"tabbedpane\" name=\"tabbed" . $counter . "\" style=\"display:" . $style . ";\">";
			$content -> render();
			echo "</div>";
			$counter = $counter + 1;
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