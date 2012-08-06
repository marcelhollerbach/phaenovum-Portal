<?php
/**
 * Diese Datei enthält die Datenbankklasse zur Abstraktion von Datenbank Funktionalitäten
 * @author Marcel Neidinger
 */
 class Database{
 	//Die MySQL Serveradresse
 	private $db_server;
	//Der MySQL User
	private $db_user;
	//Das Passwort des oberen Users
	private $db_passwort;
	//Die Datenbank
	private $db_base;
	//Link Objekt für die Datenbank
	private $db_link;
	//DB Select
	private $db_selected;
	
	/**
	 * Konstruktor, in dem wir die Verbindung zur Datenbank versuchen
	 */
	function __construct($_db_server,$_db_user,$_db_passwort,$_db_base){
		//Alle Variablen setzen
		$this->db_server   = $_db_server;
		$this->db_user     = $_db_user;
		$this->db_passwort = $_db_passwort;
		$this->db_base     = $_db_base;
		
		//Mit der Datenbank connecten
		$this->db_link = mysql_connect($this->db_server,$this->db_user,$this->db_passwort) or die("Konnte keine Verbindung zur Datenbank aufbauen");
		$db_selected = mysql_select_db($this->db_base,$this->db_link); 
	}
 }
?>