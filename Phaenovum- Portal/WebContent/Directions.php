<?php
class forwarding {
	static $url;
	static function routeBackwithError($bash,$application,$error){
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
	static function routeBack($bash, $application) {
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
		echo "</form>
		Wenn sie das sehen können haben sie Möglicherweise Javascript deaktiviert, bitte aktivieren sie Javascript.
		<script type=\"text/javascript\">
			document.back.submit();
		</script>
	</body>
</html>";
	}

}
?>