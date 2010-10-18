<?php
	include ("engine.class.php");
	include ("markasnewpost.class.php");

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
			$source = "\n\t</body>\n</html>";
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
				$menu = $main . '</td></tr></table>';
			}
			else if ($php_self == 'viewSection.php')
			{
				$id = protectVar ($_GET['id']);
				if (empty($_GET['action']))
				{
					$vs = '| <a class="link" href="' . $php_self . '?id=' . $id . '&action=newTopic' . '">New Topic</a></td>';
					$menu = $main . $vs . '</td></tr></table>';
				}
			}
			else if ($php_self == 'viewTopic.php')
			{
				$id = protectVar ($_GET['id']);
				if (empty($_GET['action']))
				{
					$menu = '<table class="border"><tr><td class="border"><a class="link" href="' . $php_self . '?id=' . $id . '&action=newPost' . '">New Post</a> | <a class="link" href="javascript:history.back()">Back</a></td></tr></table>';
				}
			}
			
			return $menu;
		}
		
		public function printForum()
		{
			$query_f = $this->sql->sendQuery ("SELECT * FROM sections");
			$query_m = $this->sql->sendQuery ("SELECT * FROM sections");
			$control_admin = $this->sql -> sendQuery ("SELECT * FROM user WHERE username = '" . $_COOKIE['username'] . "'");
			//print '			Forum:';
			
			while ($result = mysql_fetch_array ($control_admin))
			{
				$class = $result['class'];
				$password = $result['password'];
			}

			print '<table width="100%" class="body">
					<tr><td>Forum:</td><td>Ultimo messaggio:</td></tr>';
			
			while ($result_f = mysql_fetch_array ($query_f))
			{
				$code_left[] = '<td><p class="sections"> <a class="link" href="viewSection.php?id=' . $result_f['id'] . '">'. $result_f['name'] . "</a> <br />" . $result_f['description'];

				if ($class == 'admin' && $password == $_COOKIE['password'])
				{

					$code_left[] = "<a class='link' href='admin.php?deleteSection=" . $result_f['id'] . "'>[x]</a></p></td>\n\t\t\t";
				}
				else
				{
					$code_left[] = "</p></td>\n\t\t\t";
				}
			}
			//print '			Ultimo Messaggio:';
	
			while ($result_m = mysql_fetch_array ($query_m))
			{
				$code_right[] = '<td><p class="sections">' . $result_m['date_time'] . ' <br /> ' . $result_m['last_author'] . " </p></td>\n\t\t\t";
			}
			
			$count_left = count ($code_left);
			$count_right = count ($code_right);
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
		
		public function printLastMessage()
		{
			$query = $this->sql->sendQuery ("SELECT * FROM sections");
			//print '			Ultimo Messaggio:';
	
			while ($result = mysql_fetch_array ($query))
			{
				//print '<p class="sections">' . $result['date_time'] . ' <br /> ' . $result['last_author'] . " </p>\n\t\t\t";
			}
		}
		
		public function printTopics($id)
		{
			$query_t = $this->sql -> sendQuery ("SELECT * FROM topics WHERE id_sections = '$id'");
			$query_m = $this->sql -> sendQuery ("SELECT * FROM topics WHERE id_sections = '$id'");
			$control_admin = $this->sql -> sendQuery ("SELECT * FROM user WHERE username = '" . $_COOKIE['username'] . "'");

			//print '			Section:';
			
			print '<table width="100%" class="body">
					<tr><td>Topics:</td><td>Ultimo messaggio:</td></tr>';
					
			while ($result = mysql_fetch_array ($control_admin))
			{
				$class = $result['class'];
				$password = $result['password'];
			}
			
			while ($result_t = mysql_fetch_array ($query_t))
			{
				$date_time = eregi_replace("[/,: ]", "", $result_t['date_time']);
				$code_left[] = '<td><p class="sections"><a class="link" href="viewTopic.php?id=' . $result_t['id'] . '">'. $result_t['name'] . "</a><br />";
				
				if ($class == 'admin' && $password == $_COOKIE['password'])
				{
					if ($this->MarkAsNewPost->SetNewPost ($date_time))
					{
						if ($this->MarkAsNewPost->UnsetNewPost ($result_t['id'], $date_time))
						{
							$code_left[] = "<a class='link' href='admin.php?deleteTopic=" . $result_t['id'] . "'>[x]</a></p></td>\n\t\t\t";
						}
						else
						{
							$code_left[] = "<a class='link' href='admin.php?deleteTopic=" . $result_t['id'] . "'>[x]</a>[NEW]</p></td>\n\t\t\t";
						}
					}
					else
					{
						$code_left[] = "<a class='link' href='admin.php?deleteTopic=" . $result_t['id'] . "'>[x]</a> </p></td>\n\t\t\t";
					}
				}
				else
				{
					if ($this->MarkAsNewPost->SetNewPost ($date_time))
					{
						if ($this->MarkAsNewPost->UnsetNewPost ($result_t['id'], $date_time))
						{
							$code_left[] = "</p></td>\n\t\t\t";
						}
						else
						{
							$code_left[] = "[NEW]</p></td>\n\t\t\t";
						}
					}
					else
					{
						$code_left[] = "</p></td>\n\t\t\t";
					}
				}
			}
			
			while ($result_m = mysql_fetch_array ($query_m))
			{
				$code_right[] = '<td><p class="sections">' . $result_m['date_time'] .'<br />' . $result_m['last_author'] . '</p></td>' . "\n\t\t\t";
			}
			
			$count_left = count ($code_left);
			$count_right = count ($code_right);
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
			$query = $this->sql -> sendQuery ("SELECT * FROM topics WHERE id_sections = '$id'");
			print '			Ultimo Messaggio:';
		
			while ($result = mysql_fetch_array ($query))
			{
				print '<p class="sections">' . $result['date_time'] .'<br />' . $result['last_author'] . '</p>' . "\n\t\t\t";
			}
		}
		
		public function printTopicAndPost ($id)
		{
			$query = $this->sql->sendQuery ("SELECT * FROM topics WHERE id='$id'");
			$query_post = $this->sql->sendQuery ("SELECT * FROM posts WHERE id_topics='$id'");

			$result = mysql_fetch_array ($query);

			//$clickUp = unserialize ($_COOKIE['clickUp']);			
			//$clickUp[] = $result['id'];
			//$clickUp = serialize ($clickUp);
			//setcookie ("clickUp", $clickUp, time () + (3600 * 24), "/");				
			
			$date_time = eregi_replace("[/,: ]", "", $result['date_time']);
			$this->MarkAsNewPost->SetClickUp ($result['id'], $date_time);
		
			print "			<table width='100%' class='border'>\n			<tr>\n";
	
			print '				<td class="body-right" valign="top"><p align="justify" class="sections">' . $result['author'] . ":</p></td>\n";
			print '				<td class="body-left" valign="top"><p align="justify" class="sections">' . $result['text'] . "</p></td></tr>\n</tr><tr>";
			
			while ($result_post = mysql_fetch_array($query_post))
			{
				print '				<td class="body-right" valign="top"><p align="justify" class="sections">' . $result_post['author'] . ":</p></td>\n";
				print '				<td class="body-left" valign="top"><p align="justify" class="sections">' . $result_post['text'] . "</p></td></tr>\n";
			}
		}
	}
?>
