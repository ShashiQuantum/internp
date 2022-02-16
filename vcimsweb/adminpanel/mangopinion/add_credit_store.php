<?php
include_once('../../init.php');
include_once('../../functions.php');
date_default_timezone_set('asia/calcutta');
?>
<head><title>Add Reward</title></head>
<body>
<br><br>
<center>
<h3><font color=red><u>Add Reward Point</u></font></h3>
<form name="tFORM" method=post action="" >
<table>
<?php

  echo "<tr><td>Project </td> </td><td> <select name=pn id=pn ><option value=0>--Select--</option>";
          $pj=get_projects_details();
             foreach($pj as $p){ 
        	echo "<option value='";
        	 echo $p->project_id; 
        	echo "'>";
        	 echo $p->name; 
        	echo "</option>";
        	  } 
       	      echo "</select></td></tr>";
 

   $qcst="SELECT `user_id`, `user_name`, `user`, `mobil` FROM `app_user`";
   $qir=DB::getInstance()->query($qcst);

   echo "<tr><td>User </td> </td><td> <select name=auid id=auid ><option value=0>--Select--</option>";
    
   if($qir->count()>0)
   {
   
     
     foreach($qir->results() as $rs)
     {
        $uid=$rs->user_id;
        $name=$rs->user_name;
        $mb=$rs->mobil;
         
        echo "<option value=$uid >";
        	 
        	 echo "$uid - $name - $mb"; 
        	echo "</option>";
     }
     echo "</select></td></tr>";
   }
   else echo "</table><br><font color=red>Incorrect User ID</font>";
   echo "<tr><td>Reward Point </td> </td><td> <input type=text name=pv placeholder='Enter Reward Point' required></td></tr>";
   echo "<tr><td>Remarks </td> </td><td> <input type=text name=rm placeholder='Enter Remarks' required></td></tr>";     	 
?>
<tr><td></td><td><input type=submit name="add" value="Add"> &nbsp;&nbsp;<input type=submit name="delete" value="Deduct"></td></tr></table>
</form>

<?php
if(isset($_POST['add']))
{
   //print_r($_POST);
   $pid=$_POST['pn'];
   $uid=$_POST['auid'];
   $rp=$_POST['pv'];
   $rm=$_POST['rm'];
   $dt = date('Y-m-d H:i:s');
   if($uid!=0 && $rm!='' && $rp!='')
   {
        $we="INSERT INTO `credit_store`(`user_id`, `qset_id`, `i_date`, `cr_point`, `remarks`) VALUES ($uid,$pid,'$dt',$rp,'$rm')";
        DB::getInstance()->query($we);
   }
}

if(isset($_POST['delete']))
{
   //print_r($_POST);
   $pid=$_POST['pn'];
   $uid=$_POST['auid'];
   $rp=$_POST['pv'];
   $rm=$_POST['rm'];
   $dt = date('Y-m-d H:i:s');
   if($uid!=0 && $rm!='' && $rp!='')
   {    $rp=-$rp;
         $dq="INSERT INTO `credit_store`(`user_id`, `qset_id`, `i_date`, `cr_point`, `remarks`) VALUES ($uid,$pid,'$dt','$rp','$rm')";
        DB::getInstance()->query($dq);
   }
}

?>
