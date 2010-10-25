<?php
	include ("include/template.class.php");
	include ("include/user.class.php");
	include_once "include/mysql.class.php";
	
	$template = new DxTemplate();
	$register = new User ();
	
	print $template->Head("Register");
	print $template->includeCSS ("template/Default/style.tmp");
	print $template->includeJS ("include/menu.js");
	print $template->openBody(1);
	print '<center>';
	print $template->openDiv ("header");
	print $template->closeDiv ();
	print $template->openDiv ("body");
	print $template->setMenu(explode('/', $_SERVER['PHP_SELF']), 4);
	
	if(	$register -> is_user())
		die("Ma Sei cretino? sei loggato e vuoi registrarti? LOL");
	
	print '<form method="POST">
			<table width="100%" valign="top">
				<tr>
					<td> Nickname: </td>
					<td> <input type="text" name="username" /> </td>
				</tr>
				<tr>
					<td>Password: </td>
					<td><input type="password" name="password" /> </td>
				</tr>
				<tr /> 
				<tr>
					<td> </td>
					<td> <input type="submit" value="Register" /> </td>
				</tr>
			</table>
			
			</form>';

	print $template->closeDiv ();
	print '</center>';
	print $template->closeBody();
	
	$register = new User ();
	
	if (isset ($_POST['username']) && isset ($_POST['password']))
	{
		if (!$register->register ($_POST['username'], $_POST['password']))
		{
			print "<script>alert ('You are registered!'); window.location='login.php'</script>";
		}
	}
?>
