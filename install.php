<?php
	include ("include/config.php");
	include ("include/mysql.class.php");
	include ("include/security.php");	
	
if(@$_REQUEST['install'] == 1) {
	
	$sql = new MySQL ($date["db_host"], $date["db_user"], $date["db_pass"], $date["db_name"]);
	
	mysql_query ("CREATE TABLE IF NOT EXISTS `".__PREFIX__."user` (
  `id` int(5) NOT NULL auto_increment,
  `username` varchar(255) default NULL,
  `password` varchar(255) default NULL,
  `class` varchar(255) default NULL,
  `timesession` int(11) NOT NULL default '0',
  `clickup` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;") or die (mysql_error ());
	
	echo "Table 'user' created with success<br>";

	mysql_query ("CREATE TABLE IF NOT EXISTS `".__PREFIX__."sections` (
  `id` int(5) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `description` varchar(225) NOT NULL default '',
  `last_author` varchar(225) NOT NULL default '',
  `date_time` varchar(225) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;") or die (mysql_error ());
	
	echo "Table 'sections' created with success<br>";

	mysql_query ("CREATE TABLE IF NOT EXISTS `".__PREFIX__."topics` (
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

	mysql_query ("CREATE TABLE IF NOT EXISTS `".__PREFIX__."posts` (
  `id` int(5) NOT NULL auto_increment,
  `author` varchar(255) default NULL,
  `text` varchar(255) default NULL,
  `date_time` text NOT NULL,
  `id_topics` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;") or die (mysql_error ());
	
	echo "Table 'posts' created with success<br>";
	
	$user = protectVar($_REQUEST['username']);
	$pass = sha1 (md5 ($_REQUEST['password']));
	
	mysql_query("INSERT INTO `".__PREFIX__."user` (`id`, `username`, `password`, `class`, `timesession`, `clickup`) VALUES ('1', '{$user}', '{$pass}', 'admin', '0', '');");
	
	echo "User <b>'{$user}'</b> created with success<br>";
	
	print "<br><br><br><br><p><a href=\"index.php\">Vai alla Home Page</a><br/><br/> <font color='red'>PRIMA CANCELLA IL FILE SEGENTE <u>install.php</u></font></p>";
	
}else{
?>
<html>
<head><title>Installation DxBB</title></head>
<body>
<h2 align="center">Installation</h2>
<br />
<form methos="POST" />
=> Dati di amministrazione_</br /><br />
Username: <input type="text" name="username" /><br /><br />
Password: <input type="password" name="password" /><br /><br />
<input type="hidden" name="install" value="1" />
<input type="submit" value="Installa" />
</form>
</body>
</html>
<?php
}
?>
