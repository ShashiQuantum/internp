<?php
include_once ('../init.php');
include_once('../functions.php');

if(!Session::exists('suser'))
{
	Redirect::to('login_fp.php');
}

$qs='';
$pn=0;



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

                            <form action="" method=post><input type=submit name=logout value=Logout><div style=float:right><img src='../../images/Digiadmin_logo.jpg' height=50 width=150> </div> <center><h3><font color=red >User Permission Admin Panel</font></h3></center>
    </div>
    
        <center>
	


      <table>
       	<form action="" method="post">
                <tr><td>Select User Id </td><td> <select name="role"><option value="6">Client User6</option></select></td></tr>   
                <!-- <tr><td>Project</td><td> <select name="proj"><option value="0">--Select--</option><?php $ptt=get_projects_details();if($ptt) foreach($ptt as $p){?><option value="<?php echo $p->project_id; ?>"> <?php echo $p->name;  ?></option> <?php } ?></select></td></tr> -->  

                <tr><td>Project ID </td><td> <select name="proj"> <option value="14">--Select--14</option><?php $ccid=$_GET['cid']; $ptt=DB::getInstance()->query("SELECT project_id, name FROM `project` WHERE  project_id in (SELECT `project_id` FROM `project_client_map` WHERE  `client_id` =  (SELECT cid   FROM `user_client_map` WHERE `cid`=$ccid AND `status`=1))");if($ptt->count()>0) foreach($ptt->results() as $p){?><option value="<?php echo $p->project_id; ?>"> <?php echo $p->name;  ?></option> <?php } ?>   </select></td></tr>            
                <tr><td></td><td><input type="submit" name="userp_submit" value="View"></td></tr>
         </form>
        </table>

<?php 

  if(isset($_POST['userp_submit']))
  {     
        $str1="";$str2="";
        $pid=$_POST['proj'];
        $_SESSION['ppid']=$pid;
  	$data= get_project_term($pid);
            echo "<br><br><form method=post action=''><table>";
            echo " <tr bgcolor='lightgrey'><td>Terms</td> <td>Client User Permission</td></tr>";
            $ss="";
  	    if($data) 
            foreach($data as $dd)
            {       
                    $tt=$dd->title;
                    $term=$dd->term;
                    $sv=2; $str1="";
                    $dd2=DB::getInstance()->query("SELECT distinct title,term FROM `dictionary` where term in (select term from project_term_map where project_id=$pid and client_usr_perm=1 and term='$term')");
                    if ($dd2->count()>0)
                    {
                        $str1="checked='checked'";$sv=1;$ss.="'".$term."',";
                    }   
                    
                   echo " <tr><td>$tt</td> <td><input type='checkbox'  value='$term'  name='$term' $str1></td></tr>";
            } 
             echo " <tr><td></td> <td><input type='submit'  value='Submit' name='perm_chng'></td></tr>"; 
 //$slen=strlen($ss);
 //$ss1=substr($ss,0,$slen-1);
 //$_SESSION['ss1']= $ss1; 
             echo "</table></form><br><br>";
            
            
  }
   
  if(isset($_POST['perm_chng']))
  {
     
     $ss="";
     foreach($_POST as $key)
     {
           
           $ss.="'".$key."',";
     }
     
    $slen=strlen($ss);
    $ss1=substr($ss,0,$slen-1);
 
     $pid=$_SESSION['ppid']; 
   //  echo $str="SELECT distinct title,term FROM `dictionary` where term in (select term from project_term_map where project_id=$pid and client_usr_perm=1 and term in ( $ss1 ))";
    $str="UPDATE `project_term_map` SET `client_usr_perm`=1 where project_id=$pid and term in ( $ss1 )";
    $dd2=DB::getInstance()->query($str);
    $str2="UPDATE `project_term_map` SET `client_usr_perm`=0 where project_id=$pid and term not in ( $ss1 )";
    $dd2=DB::getInstance()->query($str2);
   
     echo "<font color=red>Updated successfully</font>";
  }

  

	?>




        
