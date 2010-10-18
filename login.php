<?php
	include_once ("include/template.class.php");
	include_once ("include/user.class.php");


	if (isset ($_POST['username']) && isset ($_POST['password']))
	{
		$login = new User ();
		
		if ($login->login ($_POST['username'], $_POST['password']))
		{
			echo '<script> window.location="index.php"; </script>';
		}
	}
	
	$template = new DxTemplate();
	
	print $template->Head("Login");
	print $template->includeCSS ("template/Default/style.tmp");
	print $template->includeJS ("include/menu.js");
	print $template->openBody(1);
	print '<center>';
	print $template->openDiv ("header");
	print $template->closeDiv ();
	print $template->openDiv ("body");
	print $template->setMenu(split('/', $_SERVER['PHP_SELF']), 4);
	print '<form action="login.php" method="POST">
			<table width="100%" valign="top">
				<tr>
					<td> Nickname: </td>
					<td> <input type="text" name="username" /> </td>
				</tr>
				<tr>
					<td> Password: </td>
					<td> <input type="password" name="password" /> </td>
				</tr>
				<tr /> <tr />
				<tr>
					<td> </td>
					<td> <input type="submit" value="Login" /> </td>
				</tr>
			</table>
			
			</form>';
	
	print $template->closeDiv ();
	print '</center>';
	print $template->closeBody ();
?>
