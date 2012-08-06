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
		return $this->autor;
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
		return $this->headline;
	}
	
	
	/**
	 * Die Funktion gibt nur den Unformatierten messagetext zurück
	 */
	function getRawText(){
		return $this->content;
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
	
 }
?>