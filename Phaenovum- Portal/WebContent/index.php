<?php
include './PortalBuilder.php';
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Phaenovum Portal</title>
		<link rel="stylesheet" type="text/css" href="./css/application-style.css" />
		<link rel="stylesheet" type="text/css" href="./css/icons.css" />
		<link rel="stylesheet" type="text/css" href="./css/bash.css"/>
		<link rel="stylesheet" type="text/css" href="./css/UserBash.css"/>
		<script src="./js/bash.js" type="text/javascript"></script>
		<script src="./js/UserBash_Login.js" type="text/javascript"></script>
		<script src="./js/sidebar.js" type="text/javascript"></script>
		<script src="./js/bash_settings.js" type="text/javascript"></script>
	</head>
	<body>
		<?php
		$builder = new PortalBuilder();
		?>
		<iframe name="output" scrolling="no" src="./Tutorial.html">

		</iframe>
		<?php
		$builder -> content();
		?>
	</body>
</html>