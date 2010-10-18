<?php
	include_once ("include/template.class.php");
	include_once ("include/user.class.php");
	
	if ($_GET['action'] == 'newTopic')
	{
		$newTopic = new User();
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
			<table width="100%" valign="top">
				<tr>
					<td> Subject: </td>
					<td><textarea name = "name" rows="1" cols="60" id="textarea"></textarea></td>
				</tr>

				<tr>
					<td valign="top"> Message body: </td>
					<td><textarea name = "text" rows="12" cols="60" id="textarea"></textarea></td>
				</tr>
				<tr>
					<td> <input type="submit" value="Insert" /> </td>
					<td> <td/>
				</tr>
			</table>
			
			</form>';
		print $template->closeDiv();
		print "</center>";
		print $template->closeBody();
		
		if (isset ($_POST['name']) && isset ($_POST['text']))
		{
			if ($newTopic -> is_user())
			{
				$newTopic -> newTopic ($_POST['name'], $_POST['text'], $_GET['id']);
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
		
		$template = new DxTemplate();
		print $template->Head ("viewSection");
		print $template->includeCSS ("template/Default/style.tmp");
		print $template->includeJS ("include/menu.js");
		print $template->openBody(0);
		print '<center>';
		print $template->openDiv ("header");
		print $template->closeDiv ();
		print $template->openDiv ("body");
		print $template->setMenu(split('/', $_SERVER['PHP_SELF']), 5);
		$id = protectVar ($_GET['id']);
		$template->printTopics($id);
		print $template->closeDiv ();
//		print $template->openDiv ("body-left");
//		$template->printLastMessageTopics ($id);
//		print $template->closeDiv();
		print '</center>';
		print $template->closeBody();
	}
?>
