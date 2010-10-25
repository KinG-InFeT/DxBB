<?php

	/******************************************************************************
	 *	Greetz to _mRkZ_ for the class' name choice, f4t4l for the system's idea  *
	 *	and me for programming of the source xD									  *
	 ******************************************************************************/
	
	class MarkAsNewPost
	{
		public function __construct ()
		{
			include ("config.php");
			include_once ("mysql.class.php");
			include_once ("security.php");
			$this->sql = new MySQL ($date["db_host"], $date["db_user"], $date["db_pass"], $date["db_name"]);
		}
		
		public function SetNewPost ($post_time)
		{
			if ($post_time > @$_COOKIE['TimeSession'])
			{
				return TRUE;
			}
			return FALSE;
		}
		
		public function UnsetNewPost ($id, $date_time)
		{
			@$clickUp = unserialize ($_COOKIE['clickUp']);
			if (@$clickUp[$id] > @$date_time)
			{
				return TRUE;
			}
			return FALSE;
		}
		
		public function SetClickUp ($id_post, $date_time)
		{
			@$id      = intval ($_COOKIE['id']);
			@$clickUp = unserialize ($_COOKIE['clickUp']);
			$clickUp[$id_post] = $date_time + 0.1;
			$clickUp = serialize ($clickUp);
			
			setcookie ("clickUp", $clickUp, time () + (3600 * 24), "/");
			$this->sql->sendQuery ("UPDATE ".__PREFIX__."user SET clickup = '".$clickUp."' WHERE id = '".$id."'");
		}
	}
?>
