<?php
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
		$this -> items = array();
		$components = ComponentController::getComponents();
		foreach($components as $comp){
			$name = $comp->getName();
			$inst = $comp->getInstance();
			if (Authorization::searchForPermissions($name)) {
				$this -> items[] = new TabbedItem($name,$inst);
			}
		}
	}

	public function login($succes) {
		echo "<div id=\"login\">";
		if ($succes == 'failed') {
			echo "<h4> Login Fehlgeschlafen, bitte Probieren Sie es erneut </h4>";
		} else {
			echo "<h4> Login:</h4>";
		}
		echo "<form action=\"index.php\" method=\"POST\">";
		FormBuilder::renderHidden('login','request');
		FormBuilder::renderTextField('usr','Benutzername');
		FormBuilder::renderPasswordfield('pw','Password');
		FormBuilder::renderButton('Login','login');
		echo "</form>";
		echo "</div>";

	}

	public function content($request) {
		$this -> buildMenu();
		$contents = array();
		echo "<div id=\"head\">";
		$counter = 0;
		$selected = FALSE;
		foreach (($this -> items) as $component) {
			$inst = $component -> getInstance();
			$name = $component -> getName();
			if ($name == $request) {
				echo "<div id=\"tabbeditemselect\">";
				$selected = TRUE;
			} else {
				echo "<div id=\"tabbeditem\">";
			}
			echo "<form id=\"tabbeditem\" action=\"index.php\" method=\"POST\">";
			echo "<input type=\"hidden\" name=\"request\" value=\"bash\">";
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
			if(sizeof($application) > 0){
				$content = $application[0] -> getInstance();
				$name = $application[0] -> getName();
				echo "<div id=\"tabbedpane\" >";
				$content -> render();
				echo "</div>";
			}
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