<?php
include './Directions.php';
include './PortalBuilder.php';
include './settings/Settings.php';
include './bash/UserBash.php';
include './bash/Compontents.php';
include './bash/Authorization.php';
$componentdirs = array();
$css = array();
$js = array(); 
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
				$files = scandir($componentdir);
				if(file_exists($componentdir.'/Controller.php')){
					include $componentdir.'/Controller.php';
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
//check for includes for the components
// if (is_dir('./components/')) {
			// $dirs = scandir('./components/');
			// foreach ($dirs as $dir) {
				// if ($dir != '.' && $dir != '..') {
					// if (is_dir('./components/'.$dir)) {
						// $componentdirs[] = './components/'.$dir;
					// }
				// }
			// }
		// }
// 		
session_start();
//create the Portal
$builder = new PortalBuilder();
//MethodCaller
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
		if(isset($_POST['request'])){
			if($_POST['request'] == 'settings'){
				echo "<script type=\"text/javascript\">showSettingsBash();</script>";
			}
		}
		?>
	</body>
</html>