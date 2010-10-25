<?php
	include_once ("include/template.class.php");
	
	$template = new DxTemplate();
	
	print $template->Head ("Home");
	print $template->includeCSS ("template/Default/style.tmp");
	print $template->includeJS ("include/menu.js");
	print $template->openBody(0);
	print '<center>';
	print $template->openDiv ("header");
	print $template->closeDiv ();
	print $template->openDiv ("body");
	print $template->setMenu(explode('/', $_SERVER['PHP_SELF']), 4);
	$template->printForum ();
	print $template->closeDiv ();
	print $template->closeDiv();
	print '</center>';
	print $template->closeBody();
?>
