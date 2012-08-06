<?php
/**
 *
 */
class UserBash {

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
		if(isset($_SESSION['login'])&&$_SESSION['login']){
			echo "<div id=\"head\">";
			$this -> newTabbedItem('test', 'niergents');
			echo "<a id=\"tabbeditem\" onclick=\"logout()\">Logout</a>";
			echo "</div>";
		}
	}
	private function newTabbedItem($name,$to_link){
		echo "<a id=\"tabbeditem\" onclick=\"to('".$to_link."')\">".$name."</a>";
	}

}
?>