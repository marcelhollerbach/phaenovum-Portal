<?php
/**
 * Diese Klasse representiert den Haupteingang um Nachrichten abzurufen
 */
 require_once("includes/Database.php");
 require_once("includes/News.php");
 require_once("../settings/Settings.php");
 
 class newsController{
  
    /**
	 * Die Funktion gibt alle News zurück
	 */
   function render(){
   	 //Datenbankverbindung herstellen
   	 $settings = new Settings();
	 
   	 $DB = new Database($settings);
	 //Newsarray clonen und durchlaufen
	 $newsArray = $DB->getNews();
	 
	 foreach($newsArray as $key => $value){
	 	echo $value->getFormattedText();
	 }
   }
 	
 }
?>