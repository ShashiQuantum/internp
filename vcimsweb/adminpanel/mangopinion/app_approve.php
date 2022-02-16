<?php

include_once('../../init.php');
include_once('../../functions.php');



?>
<center>
<h2>App User Approval Panel</h2>
<br><br>

<form method=post action="">
<table border=1>
     <tr><td><select name=sn><option value=1>All Not Approved User</option><option value=2>All Approved User</option></select></td><td><input type=submit name=view value=View></td></tr>
    
</form></table>
</center>


<?php

if(isset($_POST['view']))
{
    
    if($_POST['sn']==1)
    {
       	
       	echo "<center><table borer=1><tr><td>User ID</td><td>Name</td><td>Email</td><td>Mobile</td><td>Signup Date</td><td>Approve</td></tr>";
       	$ddd1=DB::getInstance()->query("SELECT `user_id`,user_name, `user`, `mobil`,`create_date` FROM `app_user` WHERE status=0");
	if($ddd1->count()>0) 
	{  echo "<form method='post' action=''>";
	   foreach($ddd1->results() as $re)
           {
               $uid=$re->user_id;
               $uname=$re->user_name;
               $uem=$re->user;
               $uml=$re->mobil;
               $cd=$re->create_date;
               echo "<tr><td><a href='resp_brief.php?uid=$uid' target='_blank'>$uid </a></td><td>$uname</td><td>$uem</td><td>$uml</td><td>$cd</td><td><input type=checkbox name=$uid value=$uid></td></tr>";
               
           } 
           echo "<tr><td></td><td></td><td><input type=submit name=submit><td></td></td></tr>";
        }
        else echo "Please select a project";
    }
    if($_POST['sn']==2)
    {
       	
       	echo "<center><table borer=1><tr><td>User ID</td><td>Name</td><td>Email</td><td>Mobile</td><td>Signup Date</td></tr>";
       	$ddd1=DB::getInstance()->query("SELECT `user_id`,user_name, `user`, `mobil`,`create_date` FROM `app_user` WHERE status=1");
	if($ddd1->count()>0) 
	{  echo "<form method='post' action=''>";
	   foreach($ddd1->results() as $re)
           {
               $uid=$re->user_id;
               $uname=$re->user_name;
               $uem=$re->user;
               $uml=$re->mobil;
               $cd=$re->create_date;
               echo "<tr><td><a href='resp_brief.php?uid=$uid' target='_blank'>$uid </a> </td><td>$uname</td><td>$uem</td><td>$uml</td><td>$cd</td></td></tr>";
               
           } 
          // echo "<tr><td></td><td></td><td><input type=reset name=submit2><td></td></td></tr>";
        }
        else echo "Please select an item";
    }
}

if(isset($_POST['submit']))
{
    
    $ctr=0;$uids='';
    foreach($_POST as $key=>$val)
    {   
        if($val!='Submit')
        { $ctr++; if($ctr==1){$uids=$val; }else{ $uids.=','.$val;}}
    }
      $wq="UPDATE `app_user` SET  `status`=1 WHERE `user_id`in ($uids)";
      DB::getInstance()->query($wq);
      if($ctr > 0) echo "<center><font color=red>Successfully approved</font>";
}

//echo App User details';
if(isset($_GET['uid2']))
{    
       echo $ppid=$_GET['uid'];
        if($ppid!=0)
        {
            $data=DB::getInstance()->query("SELECT  `user_id` FROM `respondent_detail` WHERE `user_id`=$ppid");
                if($data->count()>0)
                {
                $data->first()->user_id;
                
                header('Location: '."resp_brief.php?uid=$ppid");

                }
        }
        
}

?>

<script type="text/javascript">
document.getElementById('pn').value = "<?php echo $_POST['pn'];?>";
</script>