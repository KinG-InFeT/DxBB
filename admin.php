<?php
	include_once ("include/template.class.php");
	include_once ("include/admin.class.php");
	
	$template = new DxTemplate();
	$section = new Admin ();
	
	print $template->Head("Register");
	print $template->includeCSS ("template/Default/style.tmp");
	print $template->includeJS ("include/menu.js");
	print $template->openBody(0);
	print '<center>';
	print $template->openDiv ("header");
	print $template->closeDiv ();
	print $template->setMenu(split('/', $_SERVER['PHP_SELF']), 4);
	print $template->openDiv ("body");
	print $section->setMenu ();
	print '<form method="POST">
			<table width="100%" valign="top">
				<tr>
					<td> Name: </td>
					<td> <input type="text" name="name" /> </td>
				</tr>
				<tr>
					<td>Description: </td>
					<td><input type="text" name="description" /> </td>
				</tr>
				<tr /> 
				<tr>
					<td> </td>
					<td> <input type="submit" value="Send" /> </td>
				</tr>
			</table>
		</form>';
	$id = intval ($_GET['action']);
	print $template->closeDiv();
	print $template->closeBody();

	
	if (isset ($_POST['name']) && isset ($_POST['description']))
	{
		if ($section->is_admin ())
		{
			if ($id == 1)
			{
				if (!$section->newSection ($_POST['name'], $_POST['description']))
				{
					print "Section inserted with success.<br />";
				}
			}
			elseif ($id == 2)
			{
				if (!$section->editSection (1, $_POST['name'], $_POST['description']))
				{
					print "Section edited with success.<br />";
				}
			}
			elseif ($id == 3)
			{
				if (!$section->deleteSection (2))
				{
					print "Section deleted with success.<br />";
				}
			}
			elseif ($id == 4)
			{
				if (!$section->editTopic (1, $_POST['name'], $_POST['description']))
				{
					print "Topic edited with success.<br />";
				}
			}
		}
		else
		{
			print "You aren't admin.<br />";
		}
	}
?>
