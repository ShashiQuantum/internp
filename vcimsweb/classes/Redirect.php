<?php
ini_set('display_errors',1);
       error_reporting(-1);
	class Redirect
	{
		public static function to($location=null)
		{
			if($location)
			{
				if(is_numeric($location))
				{
					switch($location)
					{
						case 404:
							header('location:/final/404.php');
							exit();
						break;
					}
				}
			header('Location:'.$location);
			exit();
			}	
		}
	}
?>