<?php
	include_once ("include/template.class.php");
	include_once ("include/admin.class.php");
	
	$template = new DxTemplate();
	$section  = new Admin ();
	
	@$action = intval ($_GET['action']);
	
	print $template->Head("Administration Page");
	print $template->includeCSS ("template/Default/style.tmp");
	print $template->includeJS ("include/menu.js");
	print $template->openBody(0);
	print '<center>';
	print $template->openDiv ("header");
	print $template->closeDiv ();
	print $template->setMenu(explode('/', $_SERVER['PHP_SELF']), 4);
	print $template->openDiv ("body");
	print $section->setMenu ();
	print '<h2 align="center">Administration Pannel Control</h2>';

		if ($section->is_admin ())
		{
			if ($action == 1)
			{
				print '<form method="POST" action="?action=1">
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
					<td> <input type="submit" value="New Section" /> </td>
				</tr>
			</table>
		</form>';
				if (!empty ($_POST['name']) && !empty ($_POST['description'])) 
				{
					if (!$section->newSection ($_POST['name'], $_POST['description']))
					{
						print "Section inserted with success.<br />";
						print '<meta http-equiv="refresh" content="3;url=admin.php" />';
					}
				}
			}
			elseif ($action == 2)
			{
				$name        = (!empty($_POST['name']))        ? htmlspecialchars($_POST['name'])        : "";
				$description = (!empty($_POST['description'])) ? htmlspecialchars($_POST['description']) : "";
				
				print '<form method="POST" action="?action=2">
			<table width="100%" valign="top">
				<tr>
					<td> Name: </td>
					<td> <input type="text" name="name" value="'.$name.'" /> </td>
				</tr>
				<tr>
					<td>Description: </td>
					<td><input type="text" name="description" value="'.$description.'" /> </td>
				</tr>
				<tr /> 
				<tr>
					<td> </td>
					<td> <input type="submit" value="Edit Section" /> </td>
				</tr>
			</table>
			<input type="hidden" name="id_topic" value="'.(int) @$_GET['id'].'" />
		</form>';
				if (!empty ($_POST['name']) && !empty ($_POST['description'])) 
				{
					if (!$section->editSection ($_POST['id'], $_POST['name'], $_POST['description']))
					{
						print "Section edited with success.<br />";
						print '<meta http-equiv="refresh" content="3;url=admin.php" />';
					}
				}
			}
			elseif ($action == 3)
			{
				@$id = protectVar($_REQUEST['id']);
				if(empty($id)) {
					print '<form method="POST" action="?action=3&id='.$id.'" />ID Section: <input type="text" name="id" value="'.$id.'" /><br /><input type="submit" value="Delete" /></form>';
				}else{
					if(empty($id))
						die("ID NON specificato!");
						
					if ($section->deleteSection ($id) == TRUE)
					{
						print "Section deleted with success.<br />";
						print '<meta http-equiv="refresh" content="3;url=index.php" />';
					}
				}
			}
			elseif ($action == 4)
			{
				$name        = (!empty($_POST['name']))        ? htmlspecialchars($_POST['name'])        : "";
				$description = (!empty($_POST['description'])) ? htmlspecialchars($_POST['description']) : "";
				
				print '<form method="POST" action="?action=4">
			<table width="100%" valign="top">
				<tr>
					<td> Name: </td>
					<td> <input type="text" name="name" value="'.$name.'" /> </td>
				</tr>
				<tr>
					<td>Description: </td>
					<td><input type="text" name="description" value="'.$description.'" /> </td>
				</tr>
				<tr /> 
				<tr>
					<td> </td>
					<td> <input type="submit" value="Edit Topic" /> </td>
				</tr>
			</table>
			<input type="hidden" name="id_topic" value="'.(int) @$_POST['id_topic'].'" />
			<input type="hidden" name="edit" value="edit_topic" />
		</form>';
				if(@$_POST['edit'] == 'edit_topic') 
				{
					if (!empty ($_POST['name']) && !empty ($_POST['description'])) 
					{
						if (!$section->editTopic ($_POST['id_topic'], $_POST['name'], $_POST['description']))
						{
							print "Topic edited with success.<br />";
							print '<meta http-equiv="refresh" content="3;url=viewTopic.php?id='.$_POST['id_topic'].'" />';						
						}
					}
				}
			}elseif ($action == 5) {
			
				if(empty($_GET['id']))
					die("ID NON specificato!");
				
				if ($section->deleteTopic ($_GET['id']) == TRUE)
				{
					print "Topic deleted with success.<br />";
					print '<meta http-equiv="refresh" content="3;url=index.php" />';					
				}
			}elseif($action == 6) {
				if(empty($_GET['id']))
					die("ID NON specificato!");
				
				if ($section->deletePost ($_GET['id']) == TRUE)
				{
					print "Post deleted with success.<br />";
					print '<meta http-equiv="refresh" content="3;url=index.php" />';					
				}
			}
		}else{
			print "You aren't admin.<br />";
		}
	print $template->closeDiv();
	print $template->closeBody();
?>
