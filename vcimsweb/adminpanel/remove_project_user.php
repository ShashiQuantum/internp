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
	$st = 9;
}   
$msg='';



if($st==9)
{
	$msg="Remove User-Project Map";
}





//to add new user


//manage user permission
if(isset($_POST['up_submit']))
{
    //print_r($_POST);
    
}
//view users
if(isset($_POST['ul_submit']))
{
    
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

                            <form action="" method=post><input type=submit name=logout value=Logout><div style=float:right><img src='../../images/Digiadmin_logo.jpg' height=50 width=150> </div> <center><h3><font color=red >Remove Project User Panel</font></h3></center>
    </div>
    
        <center>
	<table cellpadding="10" cellspacing="5">
		<tr>
                        
                        
                        <td><a href="?st=9">Remove User-Project Map</a></td>
                        
		</tr>
		<tr>
			<td colspan="10"><center><h2><?= $msg ?></h2></center></td>
		</tr>
	</table>
            
            
 <?php if($st==9) { $uuid=$_GET['uid'];?>      
        
        
        <table cellpadding="2" cellspacing="1" border="0" style="font-size:12px;">
		<form action="" method="post">
                <!-- <tr><td>Project ID </td><td> <input type="text" name="pid" placeholder="Enter Client ID"></td></tr> -->

                <tr><td>Project ID </td><td> <select name="pid"> <option value="0">--Select--</option><?php $ptt=DB::getInstance()->query("SELECT project_id, name FROM `project` WHERE  project_id in (SELECT `project_id` FROM `project_client_map` WHERE  `client_id` =  (SELECT cid   FROM `user_client_map` WHERE `uid`=$uuid AND `status`=1))");if($ptt->count()>0) foreach($ptt->results() as $p){?><option value="<?php echo $p->project_id; ?>"> <?php echo $p->name;  ?></option> <?php } ?>   </select></td></tr>

                <tr><td>User Id</td><td><input type="text" name="uid" value=<?php echo $uuid; ?> readonly></td></tr>                
                             
                <tr><td></td><td><input type="submit" name="pcm_submit" value="Delete Map"></td></tr>
                </form>
        </table>
<?php 
if(isset($_POST['pcm_submit']))
{
    //print_r($_POST);
    $pid=$_POST['pid'];
    $uid=$_POST['uid'];
    
    if($pid !='' && ($uid !=''))
    {   
    			$sq="DELETE FROM `project_user_map` WHERE project_id='$pid' AND `uid`='$uid'";
      			$update=DB::getInstance()->query($sq);
                if($update)
      		{
      			$status = "success";
      			$message = "Mapping removed Successfully registered!";
      			//Redirect::to('user_management.php');
      		}	 
		 else
		 {
	 		$status = "error";
			$message = "<br>Oops, There is an error while registering!";
			
	 	}
				echo $message;
				   
    }
  } 
 }  


	?>




        
