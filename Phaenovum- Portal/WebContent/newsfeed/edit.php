<?php
/**
 * Hier schreiben wir alle Daten aus dem Editor in die Datenbank
 */
 //Includes und Variablen
 require_once("includes/News.php");
 require_once("includes/Database.php");
 
 $DB = new Database("127.0.0.1","root","server","news");
 
 $headline = $_GET['titel'];
 $content = $_GET['text'];
 
 $today = date("d.m.y");
 //TODO: Hier müsste der Autor jetzt durch den benutzer aus der Sessionvariable 
 //      ersezt werden
 $news = new News("phaenoBot",$today,$content,$headline);
 $DB->store($news);
 echo '<p style="border-style: solid; border-color: green; color: green;">Die News wurde eingetragen</p>';
 include("index.php");
?>