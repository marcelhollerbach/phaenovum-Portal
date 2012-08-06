<?php
include 'components.php';
/**
 *
 */
class UserBash {
	private $items;
	function __construct() {
		$this -> items = array();
		$this -> items[] = new TabbedItem('News', new Component('news'));
		$this -> items[] = new TabbedItem('News2',  new Component('news2'));
		$this -> items[] = new TabbedItem('News3',  new Component('news3'));
		$this -> items[] = new TabbedItem('News4',  new Component('news4'));
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
		if (isset($_SESSION['login']) && $_SESSION['login']) {
			$this -> render();
		}
	}

	public function render() {
		$contents = array();
		echo "<a id=\"tabbeditem\" onclick=\"logout()\">Logout</a>";
		echo "<div id=\"head\">";
		$first = 1;
		foreach (($this -> items) as $lalab) {
			$inst = $lalab -> getInstance();
			$name = $lalab -> getName();
			echo "<a id=\"tabbeditem\" onclick=\"to('".$name."')\">" . $name . "</a>";
			$style = 'none';
			if($first == 1){
				$style = "block";
				$first = 0;
			}
			$contents[] = "<div id=\"tabbedpane\" name=\"".$name."\" style=\"display:".$style.";\">" .$inst.render(). "</div>";
		}
		echo "</div>";
		echo "<div id=\"content\">";
		foreach ($contents as $content) {
			echo $content;
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