<?php
 	include_once ('../init.php');
	require_once ('../classes/User.php');	
	

 		$email = Input::get('email');
 		$r= Input::get('role');
 		$pass=Input::get('pwd');
 		
if($email!='' &&  $pass!='')
{
    $user = new User($email);
		$salt=Crypt::getToken(32);
      		$pwd=Hash::make(Input::get('pwd'),$salt);
      		if(!$user->exists())
      		{
      			$update=DB::getInstance()->query("INSERT INTO `admin_user`( `user`, `pass`, `salt`, `role`, `status`) values ('$email','$pwd','$salt',$r,0)");
      			$status = "success";
      			$message = "Successfull, You are registered!";
      			//Redirect::to('login_fp.php');
      		}	 
		 else
		 {
	 		$status = "error";
			$message = "<br>Oops, You are already registered!";
			Redirect::to('login_fp.php');
	 	}
				echo $message;
	 			$data = array(
				'status' => $status,
				'message' => $message); 
				
}else echo 'Pls fill all the details';	
	
?>