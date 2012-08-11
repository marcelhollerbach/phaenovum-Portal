<?php
class forwarding {
	
	static function routeBack($bash){
		
			echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">
<html>
	<head>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
		<title>Phaenovum Portal</title>
	</head>
	<body>
		<form name=\"back\" action=\"index.php\" method=\"POST\">";
		if($bash == TRUE){
		echo"<input type=\"hidden\" name=\"request\" value=\"settings\">";
		}
		echo"</form>
		Wenn sie das sehen können haben sie Möglicherweise Javascript deaktiviert, bitte aktivieren sie Javascript.
		<script type=\"text/javascript\">
			document.back.submit();
		</script>
	</body>
</html>";
	}
}

?>