<?php
 //Some check code in here !!!
?>
<html>
	<head>
		<title>phaenovum Portal - News Editor</title>
		<!-- CSS und Javascript einbinden -->
		<link href="scripts/css/style_editor.css" type="text/css" rel="stylesheet" />
		<script type="text/javascript" src="scripts/js/common.js" /> </script>
	</head>
	<body>
		<!-- Ein div das die ganze seite einschließt, um einen Abstand auf der linken Seite zu ermöglichen -->
		<div id="site">
			<span id="headline" name="headline" style="font-family: Times; font-weight: bold; font-size: 1.4em; padding-left: 2%;"><img src="images/Pen-icon.png">&nbsp;Schreiben</span>
			<form action="edit.php" method="get" name="editor">
				<input id="titel" name="titel" type="text" value="Titel" size="63" onclick="leeren('titel');"> <br />
				<span id="menubar">
						<a href="#" onclick="insert('text','<u>','</u>')" ><img src="images/underline.png" /></a>
						<a href="#" onclick="insert('text','<i>','</i>')" /><img src="images/kursiv.png" /></a> 
						<a href="#" onclick="insert('text','<strong>','</strong>')" /><img src="images/bold.png" /></a> 
					</span> <br />
				<textarea id="text" name="text" cols="90" rows="20"></textarea><br /> <br />
				<span style="padding-left: 2%;"><input id="submitButton" class="subButton" value="Speichern" type="submit"/> &nbsp; <input type="reset" class="subButton" style="line-height: 1.5em;" value="L&ouml;schen" /></span>
			</form>
		</div>
	</body>
</html>