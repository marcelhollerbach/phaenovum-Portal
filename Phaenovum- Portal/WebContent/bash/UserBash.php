<?php
include 'Compontents.php';
include '../newsfeed/newsController.php';
/**
 *
 */
class UserBash {
	private $items;
	function __construct() {
		$this -> items = array();
		$this -> items[] = new TabbedItem('Newsfeed', new newsController());
		$this -> items[] = new TabbedItem('News2', new Component('news2'));
		$this -> items[] = new TabbedItem('News3', new Component('news3'));
		$this -> items[] = new TabbedItem('News4', new Component('news4'));
	}

	public function login() {
		echo "<div id=\"login\">";
		echo "<div class=\"overlay\">";
		echo "<input type=\"textfield\" name=\"usr\"/> <br>";
		echo "<input type=\"password\" name=\"pw\"/> <br>";
		echo "<input type=\"submit\" onclick=\"login()\" value=\"Login\"/>";
		echo "</div>";
		//	echo "<a id=\"login\" onclick=\"login()\">Login</a>";

	}

	public function content() {
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