<?php
include 'UserBash.php';
include '../settings/Settings.php';
$userbash = new UserBash();
session_start();
if (isset($_POST['type']) && $_POST['type'] == "log") {
	$usr = $_POST['usr'];
	$pw = $_POST['pw'];
	if($usr == 'admin'&& Settings::checkAdminPW($pw)){
		$_SESSION['login'] = TRUE;
	}else{
		//TODO ldap-auth
		echo "-1";
		exit();
	}
	echo "1";

} else if (isset($_POST['type']) && $_POST['type'] == "logout") {
	session_destroy();
} else {

	if (!isset($_SESSION['login']) || !$_SESSION['login']) {
		//nicht eingeloggt
		$userbash -> login();
	} else {
		$userbash -> content();

	}
}
?>