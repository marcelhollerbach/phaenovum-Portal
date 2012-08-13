<?php
include './Directions.php';
include './ComponentController.php';
include './PortalBuilder.php';
include './settings/Settings.php';
include './bash/UserBash.php';
include './bash/Compontents.php';
include './bash/Authorization.php';
//Componentobject
ComponentController::init();
//all componentdirs
$componentdirs = array();
//all css file
$css = array();
//all js files
$js = array(); 
//draw settings
$settings = FALSE;
//site to display
$site = '';
//posible errormessages;
$error = '';
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
						$name = $dir;
						include './components/'.$name.'/Controller.php';
						$classname = $name.'Controller';
						$inst = new $classname();
						ComponentController::addComponent($name,$inst);
						
					}
				}
			}
		}
	//	foreach ($componentdirs as $componentdir) {
	//			$files = scandir($componentdir);
	//			if(file_exists($componentdir.'/Controller.php')){
	//				ComponentController::init();
	//			}
	//	}
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
session_start();
//create the Portal
$builder = new PortalBuilder();
//MethodCaller
//Post abfragen
if(isset($_POST['request'])){
	if($_POST['request'] == 'settings'){
		$settings = TRUE;
	}
}
if(isset($_POST['site'])){
	$site = $_POST['site'];
}
if(isset($_POST['error'])){
	$error = $_POST['error'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Phaenovum Portal</title>
		<?php
		foreach ($css as $file ){
			echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . $file . "\" />";
			
		}
		foreach ($js as $file ){
					echo "<script src=\"" . $file . "\" type=\"text/javascript\"></script>";
		}		
		?>
	</head>
	<body>
		<iframe name="output" scrolling="no" src="./Tutorial.html">

		</iframe>
		<?php
		$builder -> content();
		if($settings){
			echo "<script type=\"text/javascript\">showSettingsBash();";
		}
		if($site != ''){
			echo "setIFrame('".$site."');";
		}
		if($error != ''){
			echo "throwError(\"".$error."\");";
		}
		echo "</script>";
		?>
	</body>
</html>