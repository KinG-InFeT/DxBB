<?php
	include ("include/config.php");
	include ("include/mysql.class.php");
	
	$sql = new MySQL ($date["db_host"], $date["db_user"], $date["db_pass"], $date["db_name"]);
	
	mysql_query ("CREATE TABLE IF NOT EXISTS `user` (
  `id` int(5) NOT NULL auto_increment,
  `username` varchar(255) default NULL,
  `password` varchar(255) default NULL,
  `class` varchar(255) default NULL,
  `timesession` int(11) NOT NULL default '0',
  `clickup` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;") or die (mysql_error ());
	
	echo "Table 'user' created with success<br>";

	mysql_query ("CREATE TABLE IF NOT EXISTS `sections` (
  `id` int(5) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `description` varchar(225) NOT NULL default '',
  `last_author` varchar(225) NOT NULL default '',
  `date_time` varchar(225) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;") or die (mysql_error ());
	
	echo "Table 'sections' created with success<br>";

	mysql_query ("CREATE TABLE IF NOT EXISTS `topics` (
  `id` int(5) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `author` varchar(255) NOT NULL default '',
  `last_author` varchar(255) NOT NULL default '',
  `text` text NOT NULL,
  `date_time` varchar(255) NOT NULL default '',
  `id_sections` int(5) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;") or die (mysql_error ());
	
	echo "Table 'topics' created with success<br>";

	mysql_query ("CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(5) NOT NULL auto_increment,
  `author` varchar(255) default NULL,
  `text` varchar(255) default NULL,
  `date_time` text NOT NULL,
  `id_topics` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;") or die (mysql_error ());
	
	echo "Table 'posts' created with success<br>";
?>
