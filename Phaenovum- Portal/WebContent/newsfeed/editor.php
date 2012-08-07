<?php
 //Some check code in here !!!
?>
<html>
	<head>
		<title>phaenovum Portal - News Editor</title>
		<!-- CSS und Javascript einbinden -->
		<link href="scripts/css/style_editor.css" type="text/css" rel="stylesheet" />
	</head>
	<body>
		<!-- Ein div das die ganze seite einschließt, um einen Abstand auf der linken Seite zu ermöglichen -->
		<div id="site">
			<span id="headline" name="headline" style="font-weight: bold; font-size: 1.4em; padding-left: 2%;"><img src="images/Pen-icon.png">&nbsp;Schreiben</span>
			<form action="edit.php" method="get">
				<input id="titel" type="text" value="Titel" size="63"> <br />
				<span id="menubar"><img src="images/underline.png" /></span> <br />
				<textarea id="text" cols="90" rows="20"></textarea>
			</form>
		</div>
	</body>
</html>