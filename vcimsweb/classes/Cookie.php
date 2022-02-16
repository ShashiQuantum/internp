<?php

	class Cookie
	{
		public static function exists($cookie)
		{
			return (isset($_COOKIE[$cookie]))? true:false;
		}
	
		public static function get($cookie)
		{
			return $_COOKIE[$cookie];
		}

		public static function put($cookie,$value,$expiry)
		{
			if(setcookie($cookie, $value, time()+$expiry,'/'))
				return true;
			return false;
		}

		public static function delete($cookie)
		{
			self::put($cookie,'',time()-1);
		}
	}
?>