<?php
include './lib/Directions.php';
include './lib/ComponentController.php';
include './lib/PortalBuilder.php';
include './lib/Formbuilder.php';
include './settings/Settings.php';
include './bash/UserBash.php';
include './bash/Authorization.php';
include './bash/LdapBackend.php';
include './bash/Session.php';
session_start();
//Componentobject
ComponentController::init();
//all componentdirs
$componentdirs = array();
//all css file
$css = array();
//all js files
$js = array();
//draw settings
$openbash = FALSE;
//site to display
$site = '';
//posible errormessages;
$error = '';
//application
$application = 'none';
//InternetExplorer detection
$u_agent = $_SERVER['HTTP_USER_AGENT'];
$ub = False;
//check for stylesheets and Javascriptdatas for the system
if (is_dir('./css/')) {
	$files = scandir('./css/');
	foreach ($files as $file) {
		if ($file != '.' && $file != '..') {
			$css[] = './css/'.$file;
		}
	}
}
if (is_dir('./js/')) {
	$files = scandir('./js/');
	foreach ($files as $file) {
		if ($file != '.' && $file != '..') {
			$js[] = './js/'.$file;
		}
	}
}
//check for stylesheets and Javascriptdatas in the datas
$componentdirs = array();
if (is_dir('./components/')) {
	$dirs = scandir('./components/');
	foreach ($dirs as $dir) {
		if ($dir != '.' && $dir != '..') {
			if (is_dir('./components/'.$dir)) {
				$componentdirs[] = './components/'.$dir;
			}
		}
	}
}
foreach ($componentdirs as $componentdir) {
	if (is_dir($componentdir . '/css')) {
		$files = scandir($componentdir . '/css');
		foreach ($files as $file) {
			if ($file != '.' && $file != '..') {
				$css[] = $componentdir . '/css/' . $file;
				//echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$componentdir . '/css/' . $file . "\" />";
			}
		}
	}
	if (is_dir($componentdir . '/js')) {
		$files = scandir($componentdir . '/js');
		foreach ($files as $file) {
			if ($file != '.' && $file != '..') {
				$js[] = $componentdir . '/js/' . $file;
				//echo "<script src=\"".$componentdir . '/js/' . $file . "\" type=\"text/javascript\"></script>";
			}
		}
	}
}
//create the Portal
$builder = new PortalBuilder();
//MethodCaller
//Post abfragen
if(isset($_POST['request'])){
	if($_POST['request'] == 'bash'){
		$openbash = TRUE;
	}else if($_POST['request'] == 'login'){
		//login
		$usr = $_POST['usr'];
		$pw = $_POST['pw'];
		$inst = Authorization::getInst();
		$inst -> login($usr,$pw);
		forwarding::routeBack(TRUE);
	}else if($_POST['request'] == 'logout'){
		$inst = Authorization::getInst();
		$inst -> logout();
		forwarding::routeBack();
	}
}
if(isset($_POST['site'])){
	$site = $_POST['site'];
}
if(isset($_POST['application'])){
	$application = $_POST['application'];
}
if(isset($_POST['com'])){
	$component = ComponentController::getComponent($_POST['com']);
	$component ->getInstance()->task();
	$openbash = TRUE;
	$application = $_POST['com'];
	//$settings = TRUE;
}
if(isset($_POST['error'])){
	$error = $_POST['error'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>phaenovum Portal</title>
<?php
foreach ($css as $file ){
			echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . $file . "\" />";

		}
		foreach ($js as $file ){
					echo "<script src=\"" . $file . "\" type=\"text/javascript\"></script>";
		}
		?>
</head>
<body onload="rendersize()">
	<iframe name="output" scrolling="no" src="./Tutorial.html"> </iframe>
	<?php
	$builder -> content($application);
	if($openbash){
			echo "<script type=\"text/javascript\">showSettingsBash();";
		}
		if($site != ''){
			echo "setIFrame('".$site."');";
		}
		if($error != ''){
			echo "throwError(\"".$error."\");";
		}
		if(preg_match('/MSIE/i',$u_agent))
		{
			echo "alert('Mit Internetexplorer könnte es zu Problemem kommen, bitte benutzen sie einen der Verfügbaren Browsern:Mozila,Chrome,Opera,Safari\');";
		}
		echo "</script>";
		?>
</body>
</html>
