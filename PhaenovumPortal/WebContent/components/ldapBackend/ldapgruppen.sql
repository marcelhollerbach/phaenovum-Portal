CREATE TABLE IF NOT EXISTS `com_ldap_group` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `name` text,
  `componentgroups` text,
  PRIMARY KEY (`id`)
);