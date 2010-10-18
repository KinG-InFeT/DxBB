<?php
	class Engine
	{
		public function assign ($template, $variable, $exchange)
		{
			$this->template = file_get_contents($template);
			$this->template = str_replace ("<!- $variable -!>", $exchange, $this->template);
			return $this->template;
		}
		
		public function stampTMP ($tmp)
		{
			return file_get_contents ($tmp);
		}
	}
?>