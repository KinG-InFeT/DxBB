<?php
	include ("include/template.class.php");
	include ("include/user.class.php");
	
	if ($_GET['action'] == 'newPost')
	{
		$newPost = new User();
		$template = new DxTemplate();
		
		print $template->Head ("viewTopic");
		print $template->includeCSS ("template/Default/viewTopic/style.tmp");
		print $template->includeJS ("include/menu.js");
		print $template->openBody(1);
		print '<center>';
		print $template->openDiv ("header");
		print $template->closeDiv ();
		print $template->openDiv ("body");
		print $template->setMenu(split('/', $_SERVER['PHP_SELF']), 4);
		
		print '<form method="POST">
			<table width="50%" valign="top">
				<tr>
					<td> Text: </td>
				</tr>
				<tr>
					<td><textarea name = "text" rows="12" cols="60" id="textarea"></textarea></td>
				</tr>
				<tr>
					<td> <input type="submit" value="Insert" /> </td>
				</tr>
			</table>
			
			</form>';
			
		print $template->closeDiv();
		print "</center>";
		print $template->closeBody();
			
		if (isset ($_POST['text']))
		{
			if ($newPost -> is_user())
			{
				$newPost -> newPost ($_POST['text'], $_GET['id']);
				
				print '<script type="text/javascript">
					window.setTimeout("history.go(-2)", 1000);
				</script>';
			}
			else
			{
				print "<script> window.location='index.php' </script>";
			}
		}
	}
	else
	{
		include ("include/security.php");
	
		$id = protectVar ($_GET['id']);
		$template = new DxTemplate();
		
		print $template->Head ("viewTopic");
		print $template->includeCSS ("template/Default/viewTopic/style.tmp");
		print $template->includeJS ("include/menu.js");
		print $template->openBody(0);
		print "<center>";
		print $template->openDiv ("header");
		print $template->closeDiv ();
		print $template->setMenu(split('/', $_SERVER['PHP_SELF']), 5);
		$template->printTopicAndPost ($id);
		print $template->closeDiv();
		print "</center>";
		print $template->closeBody();
	}
?>
