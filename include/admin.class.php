<?php

	class Admin
	{

		public function __construct ()
		{
			include ("config.php");
			include_once ("mysql.class.php");
			include_once ("security.php");
			
			$this->sql = new MySQL ($date["db_host"], $date["db_user"], $date["db_pass"], $date["db_name"]);
		}
		
		public function is_admin ()
		{
			
			$this->username = protectVar ($_COOKIE['username']);
			$this->password = protectVar ($_COOKIE['password']);
			
			$query = $this->sql -> sendQuery ("SELECT * FROM user WHERE username='$this->username'")
					or die (mysql_error ());
			
			while ($ris = mysql_fetch_array ($query))
			{
				if ($this->username == $ris['username'] && $this->password == $ris['password'] &&
					$ris['class'] == "admin")
				{
					return true;
				}
				else
				{
					return false;
				}
			}
		}
		
		public function newSection ($name, $description)
		{			
			$this->name = protectVar ($name);
			$this->description = protectVar ($description);
			
			$query = $this->sql -> sendQuery ("INSERT INTO sections (name, description) VALUES ('$this->name', '$this->description')")
					or die (mysql_error ());
		}
		
		public function editSection ($id, $name, $description)
		{
			$this->id = protectVar ($id);
			$this->name = protectVar ($name);
			$this->description = protectVar ($description);
			
			$query = $this->sql -> sendQuery ("UPDATE sections SET name = '$this->name', description = '$this->description' WHERE id = '$this->id';")
					or die (mysql_error ());
		}
		
		public function deleteSection ($id)
		{
			$this->id = protectVar ($id);
			
			$query = $this->sql -> sendQuery ("DELETE FROM sections WHERE id = '$id';")
					or die (mysql_error ());
		}
		
		public function deleteTopic ($id)
		{
			$this->id = protectVar ($id);
			
			$query = $this->sql -> sendQuery ("DELETE FROM topics WHERE id = '$id';")
					or die (mysql_error ());
		}
		
		public function editTopic ($id, $name, $text)
		{
			$this->id = protectVar ($id);
			$this->name = protectVar ($name);
			$this->text = protectVar ($text);

			$query = $this->sql -> sendQuery ("UPDATE topics SET name = '$this->name', text = '$this->text' WHERE id = '$this->id';")
					or die (mysql_error ());
		}
		
		public function setMenu ()
		{
			$menu = '
					<a class="link" href="admin.php?action=1">New Section</a> |
					<a class="link" href="admin.php?action=2">Edit Section</a> |
					<a class="link" href="admin.php?action=3">Delete Section</a> <br /><br />';
			return $menu;
		}
	}
/*	
	$boh = new Admin ();
	$boh->is_admin ();
*/
?>
