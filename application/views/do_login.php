<?php
	include_once('../public_html/vcims/init.php');
	        
                $uid=$_GET['uid'];
                $pass=$_GET['pass'];

           if($uid!='' && $pass!='')
           {
		$user = new User();
				
		$login = $user->login($uid,$pass, false);
		$vuid=$user->get_userid($uid);

		if($login)
		{  
			 
			//echo $message = "Logging you in!";
			 
                         Session::put('vcims_uid', $vuid);
			 Session::put('vcims_userid', $uid);
                         echo 1;
			 //Redirect::to('mylogin.php?');
                        //header("Location: mylogin.php");
		}
		else
		{
			echo $message = "Oops, incorrect credentials!";	
		}
           }
           else
           {  echo "Incorrect credential";  }

?>