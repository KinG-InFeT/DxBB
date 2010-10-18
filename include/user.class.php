<?php

	class User 
	{
		public function __construct ()
		{
			include ("config.php");
			include_once ("mysql.class.php");
			include_once ("security.php");
			
			$this->sql = new MySQL ($date["db_host"], $date["db_user"], $date["db_pass"], $date["db_name"]);
			$this->date_time = date ("d/m/y") . ", " . date("G:i");
		}
		
		public function is_user ()
		{
			
			$this->username = protectVar ($_COOKIE['username']);
			$this->password = protectVar ($_COOKIE['password']);
			
			$query = $this->sql -> sendQuery ("SELECT * FROM user WHERE username='$this->username'")
							or die (mysql_error ());
			
			while ($ris = mysql_fetch_array ($query))
			{
				if ($this->username == $ris['username'] && $this->password == $ris['password'])
				{
					return true;
				}
				else
				{
					return false;
				}
			}
		}
		
		public function register ($username, $password)
		{
			$this->username = protectVar ($username);
			$this->password = _crypt ($password);
			
			$query = $this->sql -> sendQuery ("INSERT INTO user (username, password, class) VALUES ('$this->username', '$this->password', '')");

			if (!$query)
			{
				return true;
			}
			
			return false;
		}

		public function login ($username, $password)
		{
			$this->username = protectVar ($username);
			$this->password = _crypt ($password);
			
			$query = $this->sql -> sendQuery ("SELECT * FROM user WHERE username = '$this->username' LIMIT 1");
			
			while ($res = mysql_fetch_array ($query))
			{
				if ($this->username == $res['username'] && $this->password == $res['password'])
				{
					setcookie ("id", $res['id'], time () + (3600 * 24), "/");
					setcookie ("username", $this->username, time () + (3600 * 24), "/");
					setcookie ("password", $this->password, time () + (3600 * 24), "/");
					
					if ($res['timesession'] == 0)
					{
						$id = $res['id'];
						$datetime = date ("dmyGi");
						setcookie ("TimeSession", $datetime, time () + (3600 * 24), "/");
						$this->sql -> sendQuery ("UPDATE user SET timesession = '$datetime' WHERE id = '$id'");
					}
					else
					{
						setcookie ("TimeSession", $res['timesession'], time () + (3600 * 24), "/");
					}
					
					if (!empty ($res['clickup']))
					{
						setcookie ("clickUp", $res['clickup'], time () + (3600 * 24), "/");
					}
					
					return true;
				}
				else
				{
					return false;
				}
			}
		}
		
		public function newTopic ($name, $text, $id_section)
		{
			$this->name = protectVar ($name);
			$this->username = protectVar ($_COOKIE['username']);
			$this->text = protectVar ($text);
			$this->id_section = protectVar ($id_section);
			
			$query = $this->sql -> sendQuery ("INSERT INTO topics (name, author, last_author, text, date_time, id_sections) VALUES ('$this->name', '$this->username', '$this->username', '$this->text', '$this->date_time', '$this->id_section')")
				or die (mysql_error ());
				
			$query = $this->sql -> sendQuery ("UPDATE sections SET date_time = '$this->date_time', last_author = '$this->username' WHERE id = $this->id_section")
				or die (mysql_error ());
		}
		
		public function newPost ($text, $id_posts)
		{
			$this->username = protectVar ($_COOKIE['username']);
			$this->text = protectVar ($text);
			$this->id_posts = protectVar ($id_posts);
			
			$query = $this->sql -> sendQuery ("INSERT INTO posts (author, text, date_time, id_topics) VALUES ('$this->username', '$this->text', '$this->date_time', '$this->id_posts')")
				or die (mysql_error ());
				
			$query = $this->sql -> sendQuery ("UPDATE topics SET date_time = '$this->date_time', last_author = '$this->username' WHERE id = '$this->id_posts'")
				or die (mysql_error ());
				
			$query = $this->sql -> sendQuery ("SELECT * FROM topics WHERE id = '$this->id_posts'")
				or die (mysql_error ());
			
			$ris = mysql_fetch_array ($query);
			$id_section = $ris['id_sections'];
			
			$query = $this->sql -> sendQuery ("UPDATE sections SET date_time = '$this->date_time', last_author = '$this->username' WHERE id = '$id_section'")
				or die (mysql_error ());
		}
	}
?>
