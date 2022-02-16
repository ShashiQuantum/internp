<?php

include_once('../../public_html/vcims/init.php');
if(!Session::exists('vcims_userid'))
    { 
            echo 'Re-login yourself.';
    }
    else
    {
            $user=Session::get('vcims_userid');         
    } 
$user=Session::get('vcims_userid');
$obj = new User();

 

	  if($_POST['cpass']!='' && $_POST['npass']!='' &&  $_POST['npassrepeat'] !='' )
	  { 
               if($_POST['npass'] ==  $_POST['npassrepeat'] )
	       {
                 	$rs = $obj->reset_password($user);
	  	      if($rs)
			echo $msg="Your Password Changed Successfully";
		      else
			echo $msg="Current Password is incorrect!";
               }
               else
                   echo "New & Confirm Password mismatch";

	  }
	  else
		echo 'Please fill all fields properly';
	

?>
