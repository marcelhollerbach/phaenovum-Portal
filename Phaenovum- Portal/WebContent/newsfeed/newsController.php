<?php
/**
 * Diese Klasse representiert den Haupteingang um Nachrichten abzurufen
 */
 require_once("includes/Database.php");
 require_once("includes/News.php");
 
 class newsController{
  
    /**
	 * Die Funktion gibt alle News zurück
	 */
   function render(){
   	 //Datenbankverbindung herstellen
   	 $DB = new Database("127.0.0.1","root","server","news");
	 //Newsarray clonen und durchlaufen
	 $newsArray = $DB->getNews();
	 
	 foreach($newsArray as $key => $value){
	 	echo $value->getFormattedText();
	 }
   }
 	
 }
?>