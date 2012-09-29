<?php
/**
 * Hier schreiben wir alle Daten aus dem Editor in die Datenbank
 */
 require_once("settings/Settings.php");
 require_once("components/newsfeed/includes/Database.php");
 require_once("components/newsfeed/includes/News.php");
 
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
?>