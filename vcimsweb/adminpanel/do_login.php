<?php
	include_once('../init.php');
	//require_once __DIR__ .'../../init.php';
	//require_once __DIR__ . '../classes/User.php';

	if(Input::exists())
	{
		$user = new User();
		$remember = (Input::get('remember')==='on') ? true :false;
		
		$login = $user->login(Input::get('email'),Input::get('pwd'), $remember);
		
		if($login)
		{
			$status = "success";
			$message = "Logging you in!";
			$_SESSION['suser']='admin@digiadmin.quantumcs.com';
			Session::put('suser',Input::get('email'));
			Redirect::to('index.php');
		}
		else
		{
			$status = "error";
			$message = "Oops! incorrect credentials!";
			
		}
		echo $message;
		$data = array(
			'status' => $status,
			'message' => $message
			);
	}
?>
