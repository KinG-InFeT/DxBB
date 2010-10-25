<?php
	function protectVar ($content)
	{
		if (is_array ($content)) {
			foreach ($content as $key => $val){
				$content[$key] = mysql_real_escape_string (htmlentities (stripslashes ($content[$key])));
			}
		}else{
			$content = mysql_real_escape_string (htmlentities ($content));
		}
		
		return (get_magic_quotes_gpc () ? stripslashes ($content) : $content);
	}
	
	function _crypt ($content) {
		return sha1 (md5 ($content));
	}
?>
