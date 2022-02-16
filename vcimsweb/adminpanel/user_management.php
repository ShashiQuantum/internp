<?php
include_once ('../init.php');
include_once('../functions.php');

if(!Session::exists('suser'))
{
	Redirect::to('login_fp.php');
}

$qs='';
$pn=0;

if(isset($_REQUEST['st']))
{
	$st = $_REQUEST['st'];
}
else
{
	$st = 1;
}   
$msg='';
if($st==1)
{
    $msg='STEP-1 Create New User';    
} 
if($st==2)
{
    $msg='STEP-2 Activate/Deactivate User';    
} 
if($st==3)
{
    $msg='Change Password';    
} 
if($st==4)
{
    $msg='User Project Map';    
} 

if($st==6)
{
	$msg="New Client";
}
if($st==7)
{
	$msg="STEP-4 Project-Client Map";
}
if($st==8)
{
	$msg="STEP-3 User-Client Map";
}


?>

<html>
	<head>
		<title>Question Admin Panel</title>
   <link rel="stylesheet" href="../../css/siteadmin.css">
	</head>
	
	  <body id=pg>
    <div id=header>
    <?php
    	//include_once('../init.php');
        if(isset($_POST['logout']))
         {
            session_destroy();
		//Cookie::delete($this->_cookieName);
		
		Redirect::to('login_fp.php');
            
         }
         echo "Hi <font color='lightgreen'>".Session::get('suser')."</font>"; 
        ?>

                            <form action="" method=post><input type=submit name=logout value=Logout><div style=float:right><img src='../../images/Digiadmin_logo.jpg' height=50 width=150> </div> <center><h3><font color=red >User Admin Panel</font></h3></center>
    </div>
    
        <center>
	<table cellpadding="10" cellspacing="5">
		<tr>
                        <td><a href="?st=1">STEP-1 New User</a></td>			
                        <td><a href="?st=2">STEP-2 Activate/Deactivate Users</a></td>
                        <td><a href="?st=8">STEP-3 User-Client Map</a></td>
                        <td><a href="?st=7">STEP-4 Project-Client Map</a></td>
			<td><a href="?st=3">Change Password</a></td>
                        <td><a href="?st=4">User Project Map</a></td>
                        <td><a href="?st=6">New Client</a></td>
                        
                        
                        
                        
		</tr>
		<tr>
			<td colspan="10"><center><h2><?= $msg ?></h2></center></td>
		</tr>
	</table>
            
            <?php if($st==1) { ?>      

        <table cellpadding="2" cellspacing="1" border="0" style="font-size:12px;">
		<form action="" method="post">
                <tr><td>User Id </td><td> <input type="text" name="email" placeholder="Enter your email"></td></tr>
                <tr><td>Password </td><td><input type="password" name="pwd" placeholder="Enter your password"></td></tr>                
                <tr><td>Role</td><td><select name="role"><option value="0">--Select--</option><option value="1">Admin</option><option value="2">Digiadmin User</option><option value="3">Client User Admin</option><option value="4">Client User</option> </select></td></tr               
                <tr><td></td><td><input type="submit" name="nu_submit"></td></tr>
                </form>
        </table>
<?php 
if(isset($_POST['nu_submit']))
{
    //print_r($_POST);
    $email=$_POST['email'];
    $pwd=$_POST['pwd'];
    $r=$_POST['role'];
    if($email !='' && $pwd!='' && $r!='0')
    {   
    	
    		$user = new User($email);
		$salt=Crypt::getToken(32);
      		$pwd=Hash::make(Input::get('pwd'),$salt);
      		if(!$user->exists())
      		{	
      			$update=DB::getInstance()->query("INSERT INTO `admin_user`( `user`, `pass`, `salt`, `role`, `status`) values ('$email','$pwd','$salt',$r,0)");
      			$status = "success";
      			$message = "Successfully registered!";
      			//Redirect::to('user_management.php');
      		}	 
		 else
		 {
	 		$status = "error";
			$message = "<br>Oops, You are already registered!";
			//Redirect::to('user_management.php');
	 	 }
				echo $message;
				
        //$pp=DB::getInstance()->query("INSERT INTO `questionset`(`project_id`,visit_no) VALUES ($pid,$v)");        
        //echo 'QuestionSet Id: <font color=red>'.$pp->last().'</font> has created successfully';        
    }else
       echo 'pls fill all the details';
}


 } if($st==2) { ?>
      <table>
       	<form action="" method="post">
                <tr><td>User Id </td><td> <input type=text name="cid" ></td></tr>   
                <tr><td>User Status </td><td> <select name="st"><option value="0">Deactivate</option><option value="1">Activate</option>/select></td></tr>               
                <tr><td></td><td><input type="submit" name="adu_submit"></td></tr>
                </form>
        </table>
         
<?php
  if(isset($_POST['adu_submit']))
  {
      $email=$_POST['cid'];
      $status=$_POST['st'];
      if($email!='')
      {
       $stat="UPDATE `admin_user` SET  `status`= $status WHERE   `user`='$email'";
      $rs=DB::getInstance()->query($stat);
      if($rs)
          echo 'User Status Changed Successfully';
      }
      else 'Please enter the details';
  }
 } if($st==6) { ?>      
        
        
        <table cellpadding="2" cellspacing="1" border="0" style="font-size:12px;">
		<form action="" method="post">
                <tr><td>Client Name </td><td> <input type="text" name="cname" placeholder="Enter Client name"></td></tr>
                <tr><td>Address </td><td><input type="text" name="address" placeholder="Enter Client address"></td></tr>                
                <tr><td>Phone </td><td> <input type=text name="ph" placeholder="Enter Client Mob/Phone number"></td></tr>               
                <tr><td></td><td><input type="submit" name="nc_submit"></td></tr>
                </form>
        </table>
<?php 
if(isset($_POST['nc_submit']))
{
    //print_r($_POST);
    $cname=$_POST['cname'];
    $caddress=$_POST['address'];
    $ph=$_POST['ph'];
    if($cname !='' && ($caddress!='' || $ph!=''))
    {   
    			$sq="INSERT INTO `client_info`( `cname`, `address`, `phone`) VALUES ('$cname','$caddress','$ph')";
      			$update=DB::getInstance()->query($sq);
                if($update)
      		{
      			$status = "success";
      			$message = "Successfully registered!";
      			//Redirect::to('user_management.php');
      		}	 
		 else
		 {
	 		$status = "error";
			$message = "<br>Oops, You are already registered!";
			//Redirect::to('user_management.php');
	 	}
				echo $message;
				   
    }
  } 

 }if($st==7) { ?>      
        
        
        <table cellpadding="2" cellspacing="1" border="0" style="font-size:12px;">
		<form action="" method="post">
                <tr><td>Client Id </td><td> <select name="cid"><?php foreach($ss=get_clients() as $rs){ $cid=$rs->cid;$cn=$rs->cname; echo "<option value=$cid > $cn - $cid</option>"; }?> </select></td></tr> 
                <tr><td>Project Id</td><td><input type="text" name="pid" placeholder="Enter Project ID"></td></tr>                
                             
                <tr><td></td><td><input type="submit" name="pcm_submit" value=Map></td></tr>
                </form>
        </table>
<?php 
if(isset($_POST['pcm_submit']))
{
    //print_r($_POST);
    $cid=$_POST['cid'];
    $pid=$_POST['pid'];
    
    if($cid !='' && ($pid !=''))
    {   
    			$sq="INSERT INTO `project_client_map`( `project_id`, `client_id`) VALUES ('$pid','$cid')";
      			$update=DB::getInstance()->query($sq);
                if($update)
      		{
      			$status = "success";
      			$message = "Mapping Successfully registered!";
      			//Redirect::to('user_management.php');
      		}	 
		 else
		 {
	 		$status = "error";
			$message = "<br>Oops, There is an error while registering!";
			//Redirect::to('user_management.php');
	 	}
				echo $message;
				   
    }
  } 


}if($st==4) { ?>      
        
        
        <table cellpadding="2" cellspacing="1" border="0" style="font-size:12px;">
		<form action="" method="post">
                <tr><td>User Id </td><td> <select name="cid"><?php foreach($ss=get_client_users() as $rs){ $uid=$rs->user_id;$usr=$rs->user; echo "<option value=$uid > $uid -- $usr</option>"; }?> </select></td></tr> 
                <tr><td>Project Id</td><td><select name="pid"><?php foreach($ss=get_projects_details() as $p){ $pid=$p->project_id;$pn=$p->name; echo "<option value=$pid > $pid -- $pn</option>"; }?> </select></td></tr>                
                             
                <tr><td></td><td><input type="submit" name="upm_submit" value=Map></td></tr>
                </form>
        </table>
<?php 
if(isset($_POST['upm_submit']))
{
    //print_r($_POST);
    $uid=$_POST['cid'];
    $pid=$_POST['pid'];
    
    if($cid !='' && ($pid !=''))
    {   
    			$sq="INSERT INTO `project_user_map`( `project_id`, `uid`) VALUES ('$pid','$uid')";
      			$update=DB::getInstance()->query($sq);
                if($update)
      		{
      			$status = "success";
      			$message = "Mapping Successfully registered!";
      			//Redirect::to('user_management.php');
      		}	 
		 else
		 {
	 		$status = "error";
			$message = "<br>Oops, There is an error while registering!";
			//Redirect::to('user_management.php');
	 	}
				echo $message;
				   
    }
  } 


}if($st==8) { ?>      
        
        
        <table cellpadding="2" cellspacing="1" border="0" style="font-size:12px;">
		<form action="" method="post">
                <tr><td>Client Id </td><td> <select name="cid"><?php foreach($ss=get_clients() as $rs){ $cid=$rs->cid;$cn=$rs->cname; echo "<option value=$cid > $cn - $cid</option>"; }?> </select></td></tr> 
                <tr><td>User Id</td><td><input type="text" name="uid" placeholder="Enter User ID"></td></tr>                
                             
                <tr><td></td><td><input type="submit" name="ucm_submit" value=Map></td></tr>
                </form>
        </table>
<?php 
if(isset($_POST['ucm_submit']))
{
    //print_r($_POST);
    $cid=$_POST['cid'];
    $uid=$_POST['uid'];
    
    if($cid !='' && ($uid !=''))
    {   
    			$sq="INSERT INTO `user_client_map`(`cid`, `uid`) VALUES ('$cid','$uid')";
      			$update=DB::getInstance()->query($sq);
                if($update)
      		{
      			$status = "success";
      			$message = "Mapping Successfully registered!";
      			//Redirect::to('user_management.php');
      		}	 
		 else
		 {
	 		$status = "error";
			$message = "<br>Oops, There is an error while registering!";
			//Redirect::to('user_management.php');
	 	}
				echo $message;
				   
    }
  } 
 }if($st==3) { ?>
      <table>
       	<form action="" method="post">
                <tr><td>User Id </td><td> <input type="text" name="email" placeholder="Enter your email"></td></tr>   
                <tr><td>New Password </td><td> <input type="password" name="npass" placeholder="Enter new password"></td></tr>
                <tr><td>Repeat Password </td><td> <input type="password" name="npassrepeat" placeholder="Repeat new password"></td></tr>               
                <tr><td></td><td><input type="submit" name="upc_submit"></td></tr>
                </form>
        </table>

<?php
  if(isset($_POST['upc_submit']))
  {
  	$rs=0;
  	$obj=new User();
      $user=$_POST['email'];
      $npass=$_POST['npass'];
      $rpass=$_POST['npassrepeat'];
      if($user!='' && ($npass == $rpass))
      {
      		$rs = $obj->reset_newpassword($user);
	  	if($rs)
			$msg="Successfully Changed Your Password";
		else
			$msg="Password Not Changed! Try again.";
       }
       else echo "Repeated password does not match";
  }

  }

  

	?>




        
