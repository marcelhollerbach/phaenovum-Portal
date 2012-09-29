<?php
 /**
  * Diese Datei beinhaltet die News Klasse, welche die News selber enthält
  * @author Marcel Neidinger
  * 
  */
 class News{
 	//Autor der News
 	private $autor;
	//Datum
	private $datum;
	//Id der News(aus Datenbank)
	private$id;
	//Content, also der Raw Text der News
	private $content;
	//Überschrift ohne formatierungen
	private $headline;
	
	/**
	 * Der Konstruktor erhält alle Informationen über die News, und setzt entsprechend die
	 * Lokalen Variablen. 
	 */
	function __construct($_author,$_date,$_content,$_headline){
		$this->autor = $_author;
		$this->datum = $_date;
		$this->content = $_content;
		$this->headline = $_headline;
	}
	
	//GETTER 
	
	/**
	 * Funktion zur Rückgabe des authors
	 */
	function getAuthor(){
		return $this->correctInput($this->autor);
	}
	
	/**
	 * Funktion zur Rückgabe des Erstellungsdatum
	 */
	function getDate(){
		return $this->datum;
	}
	
	/**
	 * Funktion gibt die Id zurück, wenn Sie exsistiert
	 */
	function getId(){
		return $this->id;
	}
	
	/**
	 * Funktion gibt die Überschrift zurück
	 */
	function getHeadline(){
		return $this->correctInput($this->headline);
	}
	
	
	/**
	 * Die Funktion gibt nur den Unformatierten messagetext zurück
	 */
	function getRawText(){
		return $this->correctInput($this->content);
		
	}
	
	/**
	 * Funktion zur Rückgabe von vorformatierten News
	 */
	function getFormattedText(){
		//Formatierten Text Konstruieren
		$text = '<br /><span style="font-size: 1.8em">'.$this->getHeadline().'</span> <br /><span style="font-size: 0.8em;, float:left;">
				 '.$this->getAuthor().'&nbsp;-&nbsp;'.$this->getDate().'</span> <br /><span>'.$this->getRawText().'</span>';
		//und zurückgeben
		return $text;
	}
	
	/**
	 * Funktion um den Wert der ID zu setzen, da dies nur die Datenbank tut, und nicht 
	 * der ersteller
	 */
	function setId($_id){
		$this->id = $_id;
	}
	
	/**
	 * Diese Funktion ersetzt alle sonderzeichen durch den entsprechenden html code, und smileys
	 * sind auch dabei :)
	 */
	function correctInput($text){
		//Umlaute, zeilenumbrüche und ähnliches
		$text = str_replace("Ä", "&Auml;", $text);
		$text = str_replace("Ö", "&Ouml;", $text);
		$text = str_replace("Ü", "&Uuml;", $text);
		$text = str_replace("ä", "&auml;", $text);
		$text = str_replace("ö", "&ouml;", $text);
		$text = str_replace("ü", "&uuml;", $text);
		$text = str_replace("\\\"", "\"", $text);
		$text = str_replace("\\\'", "\'", $text);
		$text = str_replace("\\\]", "]", $text);
		$text = str_replace("\\\[", "[", $text);
		$text = str_replace("\'", "&prime;", $text);
		$text = str_replace("\n",'<br>', $text);
		
		//Jetzt die Smileys
		$text = str_replace("<3", '<img src="icons/heart.png" />', $text);
		$text = str_replace(":)", '<img src="icons/smile.png" />', $text);
		$text = str_replace(":O", '<img src="icons/surprised.png" />', $text);
		$text = str_replace(":D", '<img src="icons/grin.png" />', $text);
		$text = str_replace(":P", '<img src="icons/tongue.png" />', $text);
		$text = str_replace(":(", '<img src="icons/unhappy.png" />', $text);
		$text = str_replace(";)", '<img src="icons/wink.png" />', $text);
		
		return $text;
	}
	
 }
?>