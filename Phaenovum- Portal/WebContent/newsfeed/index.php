<?php
/**
 * Test 
 */

 require_once("includes/News.php");
 require_once("includes/Database.php");
 
 $heute = date("d.m.y");
 
 $Obj = new News("Marcel Neidinger",$heute,"Das ist eine Testnachricht. Wie man <strong>sieht</strong> funktionieren HTML Spielereihen wie <br /> ein Zeilenumbruch wunderbar !","TEST Nr.1");
 echo $Obj->getFormattedText();
 
 $DB = new Database("127.0.0.1","root","server","news");
 $neuigkeiten = $DB->getNews();
 echo "<pre>";
 print_r($neuigkeiten);
 echo "</pre>";
 $DB->store($Obj);
 
 
?>