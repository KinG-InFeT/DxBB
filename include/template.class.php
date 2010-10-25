<?php
	include ("engine.class.php");
	include ("markasnewpost.class.php");
	
	define("__VERSION__","0.1 - Beta");

	class DxTemplate extends Engine
	{
		public function __construct ()
		{
			include ("config.php");
			include_once ("mysql.class.php");
			$this->sql = new MySQL ($date["db_host"], $date["db_user"], $date["db_pass"], $date["db_name"]);
			$this->MarkAsNewPost = new MarkAsNewPost ();
		}
		public function Head ($title)
		{
			$this->title = $title;
			$header = new Engine();
			
			return $header -> assign ("template/Default/header.tmp", "TITLE", $this->title);
		}
		
		public function includeCSS ($css)
		{
			$css = "\n" . '<link rel="stylesheet" type="text/css" href="' . $css . '" />';
			
			return $css;
		}
		
		public function includeJS ($script)
		{
			$source = "\n" . '<script type="text/javascript" src="' . $script . "\">\n</script>" . "\n";
			
			return $source;
		}
		
		public function openBody ($n)
		{
			$source = "\t</head>\n\n\t<body onload=\"slideMenuInit()\">";
			($n == 1) ? $source .= "<br />\n" : null;
			
			return $source;
		}
		
		public function closeBody ()
		{
			$source = "\n\t</body>\n<font size=\"2\"><p align=\"center\">Powered By <a href=\"http://0xproject.hellospace.net/#DxBB\">DxBB v".__VERSION__."</a></a>\n</font>\n</html>";
			return $source;
		}
		
		public function openDiv ($class)
		{
			$source = "\t\t" . '<div class = "' . $class . '">' . "\n";
			return $source;
		}
		
		public function closeDiv ()
		{
			$source = "\n\t\t</div>\n";
			
			return $source;
		}
		
		public function setMenu ($php_self, $n)
		{
			
			$php_self = $php_self[count($php_self)-1];
			
			$main = '<table width="100%"><tr><td class="border"><a class="link" href="index.php">Home</a> | <a class="link" href="register.php">Register</a> | <a class="link" href="login.php">Login</a>';
					
			if ($php_self == 'index.php' || $php_self == 'register.php' || $php_self == 'login.php')
			{
				include("admin.class.php");
				$admin = new Admin();
				if($admin->is_admin())
					$menu = $main . ' | <a class="link" href="admin.php">Administration</a></td></tr></table>';
				else
					$menu = $main . '</td></tr></table>';
			}
			else if ($php_self == 'viewSection.php')
			{
				$id = protectVar ($_GET['id']);
				if (empty($_GET['action']))
				{
					$user = new User();
					if($user->is_user()) {
						$vs = '| <a class="link" href="' . $php_self . '?id=' . $id . '&action=newTopic' . '">New Topic</a></td>';
						$menu = $main . $vs . '</td></tr></table>';
					}else{
						$menu = $main . '</td></tr></table>';
					}
				}
			}
			else if ($php_self == 'viewTopic.php')
			{
				$id = protectVar ($_GET['id']);
				if (empty($_GET['action']))
				{
					$user = new User();
					if($user->is_user()) {
						$menu = '<table class="border"><tr><td class="border"><a class="link" href="' . $php_self . '?id=' . $id . '&action=newPost' . '">New Post</a> | <a class="link" href="javascript:history.back()">Back</a></td></tr></table>';
					}else{
						$menu = '<table class="border"><tr><td class="border"><a class="link" href="javascript:history.back()">Back</a></td></tr></table>';
					}
				}
			}
			
			return @$menu;
		}
		
		public function printForum()
		{
			$query_f = $this->sql->sendQuery ("SELECT * FROM ".__PREFIX__."sections");
			$query_m = $this->sql->sendQuery ("SELECT * FROM ".__PREFIX__."sections");
			$control_admin = $this->sql -> sendQuery ("SELECT * FROM ".__PREFIX__."user WHERE username = '" . protectVar(@$_COOKIE['username']) . "'");
			
			while ($result = mysql_fetch_array ($control_admin))
			{
				$class    = $result['class'];
				$password = $result['password'];
			}

			print '<table width="100%" class="body">
					<tr><td>Forum:</td><td>Ultimo messaggio:</td></tr>';
			
			while ($result_f = mysql_fetch_array ($query_f))
			{
				$code_left[] = '<td><p class="sections"> <a class="link" href="viewSection.php?id=' . $result_f['id'] . '">'. $result_f['name'] . "</a> <br />" . $result_f['description'];

				if (@$class == 'admin' && $password == $_COOKIE['password']) {
					$code_left[] = "<a class='link' href='admin.php?action=3&id=" . $result_f['id'] . "'>[x]</a></p></td>\n\t\t\t";
				}else{
					$code_left[] = "</p></td>\n\t\t\t";
				}
			}
	
			while ($result_m = mysql_fetch_array ($query_m)) {
				$code_right[] = '<td><p class="sections">' . $result_m['date_time'] . ' <br /> ' . $result_m['last_author'] . " </p></td>\n\t\t\t";
			}
			
			@$count_left  = count ($code_left);
			@$count_right = count ($code_right);
			$i = 0;
			$j = 0;
			
			while ($i < $count_left-1) {
				print "<tr>";
				print $code_left[$i] . $code_left[++$i];
				print $code_right[$j++];
				print "</tr>";
				$i++;
			}
			print "</table>";
		}
		
		public function printLastMessage()
		{
			$query = $this->sql->sendQuery ("SELECT * FROM ".__PREFIX__."sections");
	
			while ($result = mysql_fetch_array ($query)) {
				//print '<p class="sections">' . $result['date_time'] . ' <br /> ' . $result['last_author'] . " </p>\n\t\t\t";
			}
		}
		
		public function printTopics($id)
		{
			$query_t = $this->sql -> sendQuery ("SELECT * FROM ".__PREFIX__."topics WHERE id_sections = '". (int) $id."'");
			$query_m = $this->sql -> sendQuery ("SELECT * FROM ".__PREFIX__."topics WHERE id_sections = '". (int) $id."'");
			$control_admin = $this->sql -> sendQuery ("SELECT * FROM ".__PREFIX__."user WHERE username = '" . protectVar(@$_COOKIE['username']) . "'");
			
			print '<table width="100%" class="body">
					<tr><td>Topics:</td><td>Ultimo messaggio:</td></tr>';
					
			while ($result = mysql_fetch_array ($control_admin))
			{
				$class    = $result['class'];
				$password = $result['password'];
			}
			
			while ($result_t = mysql_fetch_array ($query_t))
			{
				$date_time = preg_replace ("[/,: ]", "", $result_t['date_time']);
				$code_left[] = '<td><p class="sections"><a class="link" href="viewTopic.php?id=' . $result_t['id'] . '">'. $result_t['name'] . "</a><br />";
				
				if (@$class == 'admin' && $password == $_COOKIE['password'])
				{
					if ($this->MarkAsNewPost->SetNewPost ($date_time))
					{
						if ($this->MarkAsNewPost->UnsetNewPost ($result_t['id'], $date_time))
						{
							$code_left[] = "<a class='link' href='admin.php?action=5&id=" . $result_t['id'] . "'>[x]</a></p></td>\n\t\t\t";
						}else{
							$code_left[] = "<a class='link' href='admin.php?action=5&id=" . $result_t['id'] . "'>[x]</a>[NEW]</p></td>\n\t\t\t";
						}
					}else{
						$code_left[] = "<a class='link' href='admin.php?action=5&id=" . $result_t['id'] . "'>[x]</a> </p></td>\n\t\t\t";
					}
				}else{
					if ($this->MarkAsNewPost->SetNewPost ($date_time))
					{
						if ($this->MarkAsNewPost->UnsetNewPost ($result_t['id'], $date_time))
						{
							$code_left[] = "</p></td>\n\t\t\t";
						}else{
							$code_left[] = "[NEW]</p></td>\n\t\t\t";
						}
					}else{
						$code_left[] = "</p></td>\n\t\t\t";
					}
				}
			}
			
			while ($result_m = mysql_fetch_array ($query_m))
			{
				$code_right[] = '<td><p class="sections">' . $result_m['date_time'] .'<br />' . $result_m['last_author'] . '</p></td>' . "\n\t\t\t";
			}
			
			@$count_left  = count ($code_left);
			@$count_right = count ($code_right);
			$i = 0;
			$j = 0;
			
			while ($i < $count_left-1)
			{
				print "<tr>";
				print $code_left[$i] . $code_left[++$i];
				print $code_right[$j++];
				print "</tr>";
				$i++;
			}
			print "</table>";
		}
		
		public function printLastMessageTopics ($id)
		{
			$query = $this->sql -> sendQuery ("SELECT * FROM ".__PREFIX__."topics WHERE id_sections = '". (int) $id."'");
			print '			Ultimo Messaggio:';
		
			while ($result = mysql_fetch_array ($query))
			{
				print '<p class="sections">' . $result['date_time'] .'<br />' . $result['last_author'] . '</p>' . "\n\t\t\t";
			}
		}
		
		public function printTopicAndPost ($id)
		{
			include("admin.class.php");
			
			$admin = new Admin();
			
			$query = $this->sql->sendQuery ("SELECT * FROM ".__PREFIX__."topics WHERE id='". (int) $id."'");

			$result = mysql_fetch_array ($query);
			
			$date_time = preg_replace("[/,: ]", "", $result['date_time']);
			$this->MarkAsNewPost->SetClickUp ($result['id'], $date_time);
			
			print "			<table width='100%' class='border'>\n			<tr>\n";
			print '				<td class="body-right" valign="top"><p align="justify" class="sections">' . $result['author'] . ":</p></td>\n";
			print '				<td class="body-left" valign="top"><p align="justify" class="sections">' . $result['text'] . "</p></p>";
			
				if($admin->is_admin())
					print "<p><form method='POST' action='admin.php?action=4' />\n
						<input type=\"hidden\" name=\"id_topic\" value=\"".(int) $result['id']."\" />\n
						<input type=\"hidden\" name=\"name\" value=\"" . $result['author'] . "\" />\n
						<input type=\"hidden\" name=\"description\" value=\"" . $result['text'] . "\" />\n												
						<input type=\"submit\" value=\"Edit Topic\" /></form><a href=\"admin.php?action=5&id=".(int) $result['id']."\">[x]</a></p>";
						
			print "</td></tr>\n</tr><tr>";
			
			$query_post = $this->sql->sendQuery ("SELECT * FROM ".__PREFIX__."posts WHERE id_topics='". (int) $id."'");
			
			while ($result_post = mysql_fetch_array($query_post))
			{
				print '				<td class="body-right" valign="top"><p align="justify" class="sections">' . $result_post['author'] . ":</p></td>\n";
				print '				<td class="body-left" valign="top"><p align="justify" class="sections">' . $result_post['text'] . "</p>";
				
				if($admin->is_admin())
					print "<p><form method='POST' action='admin.php?action=4' />\n
						<input type=\"hidden\" name=\"id_topic\" value=\"".(int) $result_post['id']."\" />\n
						<input type=\"hidden\" name=\"name\" value=\"" . $result_post['author'] . "\" />\n
						<input type=\"hidden\" name=\"description\" value=\"" . $result_post['text'] . "\" />\n												
						<input type=\"submit\" value=\"Edit Topic\" /></form><a href=\"admin.php?action=6&id=".(int) $result_post['id']."\">[x]</a></p>";
						
				print "</td></tr>\n</tr><tr>";
			}
			print "</table>";
		}
	}
?>
