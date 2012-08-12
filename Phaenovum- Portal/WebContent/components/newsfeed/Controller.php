<?php
/**
 * Diese Klasse representiert den Haupteingang um Nachrichten abzurufen
 */
 require_once("includes/Database.php");
 require_once("includes/News.php");
 
 class newsfeedController{
  
    /**
	 * Die Funktion gibt alle News zurück
	 */
   function render(){
   	 //Datenbankverbindung herstellen
   	 $settings = new Settings();
	 
   	 $DB = new Database($settings);
	 //Newsarray clonen und durchlaufen
	 $newsArray = $DB->getNews();
	 
	/*foreach($newsArray as $key => $value){
	 	echo $value->getFormattedText();
	}*/
	//Damit die neusten News(d.h. die mit der höchsten ID) auch oben stehen
	for($count = count($newsArray);$count >0;$count--){
		//Sollte ein Eintrag gelöscht worde sein, ist die Idee leer
		if($newsArray[$count] == NULL){
			//Do nothing in here
		}else{
			echo $newsArray[$count]->getFormattedText();
		}
	}
   }
 	
 }
?>