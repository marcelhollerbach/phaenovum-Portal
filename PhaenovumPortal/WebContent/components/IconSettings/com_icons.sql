CREATE TABLE IF NOT EXISTS `com_icons` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `position` mediumint(9),
  `icon` text,
  `name` text,
  `in_network` text,
  `out_network` text,
  `popup` BOOLEAN,
  `published` BOOLEAN,
  PRIMARY KEY (`id`)
);