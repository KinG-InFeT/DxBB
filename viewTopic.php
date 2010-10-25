<?php
	include ("include/template.class.php");
	include ("include/user.class.php");
	
	if (@$_GET['action'] == 'newPost')
	{
		$newPost  = new User();
		$template = new DxTemplate();
		
		if (!$newPost -> is_user())
			die("<p align='center'>Non sei loggato!</p>");
		
		print $template->Head ("viewTopic");
		print $template->includeCSS ("template/Default/viewTopic/style.tmp");
		print $template->includeJS ("include/menu.js");
		print $template->openBody(1);
		print '<center>';
		print $template->openDiv ("header");
		print $template->closeDiv ();
		print $template->openDiv ("body");
		print $template->setMenu(explode('/', $_SERVER['PHP_SELF']), 4);
		
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
			<input type="hidden" name="new" value="new_post" />
			</form>';
			
		print $template->closeDiv();
		print "</center>";
		
		if(@$_POST['new'] == 'new_post') 
		{	
			if (!empty($_POST['text'])) 
			{
				if ($newPost -> is_user()) 
				{
					$newPost -> newPost ($_POST['text'], $_GET['id']);
					print "<script> window.location='viewTopic.php?id=".(int) $_GET['id']."' </script>";
				}else{
					print "<script> window.location='index.php' </script>";
				}
			}else{
				echo "<script>alert(\"Errore! Inserire Testo.\"); windows.location=\"viewTopic.php\";</script>";
			}
		}
			
	}else{
	
		include ("include/security.php");
	
		$id = protectVar ($_GET['id']);
		
		if(empty($id))
			die("<p align='center'>ID non specificato!");
			
		$template = new DxTemplate();
		
		print $template->Head ("viewTopic");
		print $template->includeCSS ("template/Default/viewTopic/style.tmp");
		print $template->includeJS ("include/menu.js");
		print $template->openBody(0);
		print "<center>";
		print $template->openDiv ("header");
		print $template->closeDiv ();
		print $template->setMenu(explode('/', $_SERVER['PHP_SELF']), 5);
		$template->printTopicAndPost ($id);
		print "\n</center>";
	}
		print $template->closeBody();
?>
