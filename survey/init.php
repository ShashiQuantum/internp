<?php
   //@ob_start();  
	ini_set('session.cookie_domain', '.vareniacims.com' );
		
	if(!isset($_SESSION))
	{
                
		$some_name = session_name("vareniacims");
		session_set_cookie_params(0, '/', '.vareniacims.com');
                
	}
//        session_start();
	
	 
	$no_pdo=mysqli_connect("localhost","root","","vcims") or die("Mysql Couldn't connect");

	//define("APP_ROOT", dirname(__FILE__));
	
	$GLOBALS['config']=array(										//Globals array to store standard constant values
		'mysql' => 		array(		'host' => 'localhost',
							'user'=>'root',
							'pass'=>'',
							'db'=>'vcims'
					     ),
			
		'remember' => array(
			'cookie_name' => 'hash',
			'cookie_expiry' => 604800),

		'session' => 	array(	'session_name'=>'user',
					'token_name' =>'token'
							),

		'url' => array( 'base' => 'http://localhost/digiamin-web',
				'blog' => 'http://blog.vareniacims.com/',
				'image' => 'http://www.vareniacims.com/images' ),
		
		'param' => array( 'ship_limit' => 350,
				  'shipping' => 50,
				  'cod' => 10)
		);
		
	
	
	spl_autoload_register(function($class){							//Used to autoload classes without the need for including on every page
	//require_once(APP_ROOT.'/classes/'.$class.'.php');  //Usage - ClassName::function($something) (autoload class & access the function)
});
	
	//require_once('sanitize.php');

	if(Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name')))
	{
		$hash = Cookie::get(Config::get('remember/cookie_name'));
		$check = DB::getInstance()->get('session',array('hash','=',$hash));

		if ($check->count()) {
			
			$user = new User($check->first()->user_id);
			$user->login();
			echo 'We remember you, you have logged in';
		}
		
	}

?>
