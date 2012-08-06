<?php
/**
 *
 */
class UserBash {
	private $items;
	function __construct() {
		$this -> items = array();
		$this -> items[] = new TabbedItem('News', NULL);
		$this -> items[] = new TabbedItem('News2', NULL);
		$this -> items[] = new TabbedItem('News3', NULL);
		$this -> items[] = new TabbedItem('News4', NULL);
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
		echo "<a id=\"tabbeditem\" onclick=\"logout()\">Logout</a>";
		echo "<div id=\"head\">";
		foreach (($this -> items) as $lalab) {
			$name = $lalab -> getName();
			echo "<a id=\"tabbeditem\" onclick=\"to('".$name."')\">" . $name . "</a>";
		}
		echo "</div>";
		echo "<div id=\"content\">";
		$counter = 0;
		foreach (($this -> items) as $lalab) {
			$inst = $lalab -> getInstance();
			$name = $lalab -> getName();
			echo "<a id=\"tabbeditem\" name=\"".$name."\" onclick=\"to()\" style=\"display:";
			if($counter == 0){
				echo "block";
			}else{
				echo "none";
			}
			echo ";\">" .$inst.render(). "</a>";
			$counter = 1;
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