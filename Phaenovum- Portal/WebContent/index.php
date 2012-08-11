<?php
include './PortalBuilder.php';
include './settings/Settings.php';
include './Directions.php';
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Phaenovum Portal</title>
		<?php
		echo "<!-- System files -->";
		if (is_dir('./css/')) {
			$files = scandir('./css/');
			foreach ($files as $file) {
				if ($file != '.' && $file != '..') {
					echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"./css/" . $file . "\" />";
				}
			}
		}
		if (is_dir('./js/')) {
			$files = scandir('./js/');
			foreach ($files as $file) {
				if ($file != '.' && $file != '..') {
					echo "<script src=./js/" . $file . " type=\"text/javascript\"></script>";
				}
			}
		}
		echo "<!-- Component files -->";
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
						echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$componentdir . '/css/' . $file . "\" />";
					}
				}
			}
			if (is_dir($componentdir . '/js')) {
				$files = scandir($componentdir . '/js');
				foreach ($files as $file) {
					if ($file != '.' && $file != '..') {
						echo "<script src=\"".$componentdir . '/js/' . $file . "\" type=\"text/javascript\"></script>";
					}
				}
			}
		}
		?>
	</head>
	<body>
		<?php
		$builder = new PortalBuilder();
		?>
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