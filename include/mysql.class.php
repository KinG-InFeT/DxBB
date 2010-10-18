<?php
class MySQL {
	private $result = null;
	private $conn   = null;
	
	public function __construct ($host, $user, $pass, $db) {
		if (!$this -> conn = @mysql_connect ($host, $user, $pass)) {
			die (mysql_error ());
		}
		
		if (!@mysql_select_db ($db, $this -> conn)) {
			die (mysql_error ());
		}
	}
	
	public function sendQuery ($query) {
		if (!$this -> result = @mysql_query ($query, $this -> conn)) {
			die (mysql_error ());
		}
		else {
			return $this -> result;
		}
	}
	
	public function __destruct () {
		@mysql_close ($this -> _conn);
	}
}
?>
