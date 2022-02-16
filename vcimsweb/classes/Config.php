<?php

	/*	Used to access the global variables stored in init.php 
		UsAGE - Config::get('mysql/host') ->gets the value stored for host in mysql array
	*/
	class Config 													
	{																
		public static function get($path=null)						
		{
			if($path)
			{
				$config=$GLOBALS['config'];
				$path=explode('/',$path);

				foreach ($path as $val) {
					if(isset($config[$val]))
					{
						$config=$config[$val];
					}
				}
				return $config;
			}

			return false;

		}
	}