<?php
/**
 * Diese Datei enthält die Datenbankklasse zur Abstraktion von Datenbank Funktionalitäten
 * @author Marcel Neidinger
 */
 require_once('News.php');
 //require_once('../settings/Settings.php');
 class Database{
	//Die Settings Datei
	private $settings;
	//Link Objekt für die Datenbank
	private $db_link;
	//DB Select
	private $db_selected;
	//News Array
	private $news;
	
	/**
	 * Konstruktor, in dem wir die Verbindung zur Datenbank versuchen
	 */
	function __construct($_settings){
		//Alle Variablen setzen
		$this->settings = $_settings;
		
		
		//Mit der Datenbank connecten
		$this->db_link = $_settings->getMYSQLConnection();
		$db_selected = mysql_select_db($_settings->getMYSQLDatenbank()); 
	}
	
	/**
	 * Die Funktion gibt das News Array zurück
	 */
	function getNews(){
		//Results aus der Datenbank ziehen
		$sql = "SELECT * FROM captive_news";
		$result = mysql_query($sql);
		
		//Checken ob keine Daten ausgelesen wurden
		if(!$result){
			die("Ungültige Anfrage".mysql_error());
		}
		
		//Daten in assoziatives Array schreiben
		$news = array();
		while($zeile=mysql_fetch_array($result)){
			//News Objekt erstellen
			$curnews = new News($zeile['author'],$zeile['date'],$zeile['content'],$zeile['headline']);
			$curnews->setId($zeile['id']);
			$news[$zeile['id']] = $curnews;
			$curnews = null;	
		}
		//Jetzt returnen wir das Newsarray
		return $news;
	}
	
	/**
	 * Diese Funktion speichert ein Newsobjekt in der Datenbank und gibt True oder False 
	 * zurück 
	 */
	function store($_news){
		$sql = "INSERT INTO captive_news (author,date,headline,content) VALUES('".$_news->getAuthor()."','".$_news->getDate()."','".$_news->getHeadline()."','".$_news->getRawText()."')";
		$query = mysql_query($sql);
		if(!$query){
			echo mysql_error();
		}        
	}
 }
?>