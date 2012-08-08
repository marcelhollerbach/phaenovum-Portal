<?php
	/**
	 * 
	 */
	class Settings {
		
		public static function getLDAPServer(){
			$ini = parse_ini_file('./settings.ini');
			return $ini['ldap-server'];
		}
		public static function getIRCServer(){
			$ini = parse_ini_file('./settings.ini');
			return $ini['irc-server'];
		}
		public static function getMYSQLServer(){
			$ini = parse_ini_file('./settings.ini');
			return $ini['mysql-server'];
		}
		public static function getMYSQLUser(){
			$ini = parse_ini_file('./settings.ini');
			return $ini['mysql-benutzer'];
		}
		public static function getMYSQLPW(){
			$ini = parse_ini_file('./settings.ini');
			return $ini['mysql-passwort'];
		}
		public static function getMYSQLDatenbank(){
			$ini = parse_ini_file('./settings.ini');
			return $ini['mysql-datenbank'];
		}
		public static function checkAdminPW($pw){
			$ini = parse_ini_file('settings.ini');
			if($pw == $ini['super-admin-pw']){
				return TRUE;
			}else{
				return FALSE;
			}
		}
		
	}
	
?>