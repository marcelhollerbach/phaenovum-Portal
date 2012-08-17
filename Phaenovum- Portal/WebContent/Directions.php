<?php
class forwarding {
	static $url;
	/**
	 * Will route back the the index.php
	 * @param string $bash
	 * 		if true the bashboard will be opened
	 * @param string $application
	 * 		If you enter the name of an application this one will be displayed.
	 * 		But you have to be loged in. otherwise you only will see the loginscreen.
	 * 		If you leave this option blank or NULL the first apllication will be displayed
	 * @param string $error
	 * 		If this is not NULL a alert message with the this string as Error will be displayed
	 */
	static function routeBack($bash = FALSE,$application = NULL,$error = NULL){
		$host  = $_SERVER['HTTP_HOST'];
		$uri   = Settings::getHostverzeichniss();
		$extra = 'index.php';
		self::$url = 'http://'.$host.$uri.'/'.$extra.')';

		echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">
			<html>
		<head>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
		<title>Phaenovum Portal</title>
		</head>
		<body>
		<form name=\"back\" action=\"index.php\" method=\"POST\">";
		if ($bash == TRUE) {
			echo "<input type=\"hidden\" name=\"request\" value=\"settings\">";
		}
		if ($application != NULL) {
			echo "<input type=\"hidden\" name=\"application\" value=\"".$application."\">";
		}
		if ($error != NULL) {
			echo "<input type=\"hidden\" name=\"error\" value=\"".$error."\">";
		}
		echo "</form>
		Wenn sie das sehen können haben sie Möglicherweise Javascript deaktiviert, bitte aktivieren sie Javascript.
		<script type=\"text/javascript\">
			document.back.submit();
		</script>
		</body>
		</html>";
	}
// 	static function routeBack($bash, $application) {
// 		$host  = $_SERVER['HTTP_HOST'];
// 		$uri   = Settings::getHostverzeichniss();
// 		$extra = 'index.php';
// 		self::$url = 'http://'.$host.$uri.'/'.$extra.')';

// 		echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">
// 			<html>
// 	<head>
// 		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
// 		<title>Phaenovum Portal</title>
// 	</head>
// 	<body>
// 		<form name=\"back\" action=\"index.php\" method=\"POST\">";
// 		if ($bash == TRUE) {
// 			echo "<input type=\"hidden\" name=\"request\" value=\"settings\">";
// 		}
// 		if ($application != NULL) {
// 			echo "<input type=\"hidden\" name=\"application\" value=\"".$application."\">";
// 		}
// 		echo "</form>
// 		Wenn sie das sehen können haben sie Möglicherweise Javascript deaktiviert, bitte aktivieren sie Javascript.
// 		<script type=\"text/javascript\">
// 			document.back.submit();
// 		</script>
// 	</body>
// </html>";
// 	}

}
?>