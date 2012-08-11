<?php
//require_once './bash/Authorization.php';
require_once './settings/Settings.php';
require_once 'Directions.php';
session_start();
$succes = FALSE;
//Usergruppen: 
//icons Menubar
//news_p news-publishment
//news_e news-einreichen
//irc chat jeder
if (isset($_POST['request']) && $_POST['request'] == "login") {
	$usr = $_POST['usr'];
	$pw = $_POST['pw'];
	if($usr == 'admin'&& Settings::checkAdminPW($pw)){
		//admin logged in
		$_SESSION['login'] = TRUE;
		$_SESSION['usr'] = $usr;
		$_SESSION['permission'] = 'icons&news_p&news_e&irc';
		$succes = TRUE;
		}else{
			$succes = FALSE;
			//TODO LDAP- auth
		}

}else if(isset($_POST['request']) && $_POST['request'] == "logout"){
	session_destroy();
}
forwarding::routeBack(TRUE,NULL);
?>
