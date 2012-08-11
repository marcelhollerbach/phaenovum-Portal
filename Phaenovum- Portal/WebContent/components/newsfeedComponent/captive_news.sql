-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 08. Aug 2012 um 19:00
-- Server Version: 5.5.24
-- PHP-Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `news`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `captive_news`
--

CREATE TABLE IF NOT EXISTS `captive_news` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `author` text,
  `date` char(30) DEFAULT NULL,
  `headline` text,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Daten für Tabelle `captive_news`
--

INSERT INTO `captive_news` (`id`, `author`, `date`, `headline`, `content`) VALUES
(1, 'Marcel Neidinger', '07.08.12', 'TEST Nr.1', 'Das ist eine Testnachricht. Wie man <strong>sieht</strong> funktionieren HTML Spielereihen wie <br /> ein Zeilenumbruch wunderbar !');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
