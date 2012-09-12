<?php
/**
 * 
 */
 class editorController {
 	
	function render(){
		include("includes/editor.php");
	}
	
	function task(){
		$settings = new Settings();
 		$DB = new Database($settings);
 
 		$headline = $_GET['titel'];
 		$content = $_GET['text'];
 
 		$today = date("d.m.y");
 		//TODO: Hier müsste der Autor jetzt durch den benutzer aus der Sessionvariable 
 		//      ersezt werden
 		$news = new News("phaenoBot",$today,$content,$headline);
 		$DB->store($news);
 		echo '<p style="border-style: solid; border-color: green; color: black; background-color: #7FFA81; text-align: center;">Die News wurde eingetragen</p>';
	}

 }
?>
