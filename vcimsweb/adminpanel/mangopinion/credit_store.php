<?php
include_once('../../init.php');
include_once('../../functions.php');

?>

 <head><title>Credit Store</title></head>
 <body><center>
 <br><br><h2>Qtap User Details</h2><br>
 <form method="post" action="">
 User Id <input type=text name=uid placeholder="Enter UserID/email/mobile" required> <input type=submit name=submit value=View>
 </form>
 

<?php

   if(isset($_POST['submit']))
   {   
         $urid=$_POST['uid'];
         $uid=0;
         if(is_numeric($urid))
         {
           $qq="SELECT `user_id` FROM `app_user` WHERE `user_id`=$urid or mobil='$urid'";
         }else {$qq="SELECT `user_id` FROM `app_user` WHERE user='$urid' ";}
     
         $qu=DB::getInstance()->query($qq);
         if($qu->count()>0)
         {
            $uid=$qu->first()->user_id;
         }
          
         $qinfo="SELECT a.`user_id`, a.`user`, a.`create_date`, a.`last_login`, a.`status`,a.user_name, b.mobile,b.email,b.address,b.gender_57 FROM `app_user` a JOIN `mangopinion_57` b on a.user_id=b.resp_id WHERE a.`user_id`=$uid and b.email!=''";

   $qir=DB::getInstance()->query($qinfo);
   if($qir->count()>0)
   {
     $uid=$qir->first()->user_id;
     $ulogin=$qir->first()->user;
     $uname=$qir->first()->user_name;
     $rdate=$qir->first()->create_date;
     $ltime=$qir->first()->last_login;
     $st=$qir->first()->status;
     $umob=$qir->first()->mobile;
     $uemail=$qir->first()->email;
     $uadd=$qir->first()->address;
     $ugen=$qir->first()->gender_57;
     
     
     
     echo "<br><b>Personal Details</b><br>";
     echo "<table border=1><tr><td>User Name</td><td>Mobile</td><td>Email</td><td>Address</td><td>Gender</td></tr>";
     echo "<tr><td>$uname</td><td>$umob</td><td>$uemail</td><td>$uadd</td><td>$ugen</td></tr></table>";

     echo "<br><b>Login Details</b><br>";
     echo "<table border=1><tr><td>User ID</td><td>Login ID</td><td>Reg.Date</td><td>Last Login</td><td>Status</td></tr>";
     echo "<tr><td>$uid</td><td>$ulogin</td><td>$rdate</td><td>$ltime</td><td>$st</td></tr></table>";


   
  //user login details
   $cstot=0;
   $qcst="SELECT `id`, `user_id`, `qset_id`, `i_date`, `cr_point`,remarks FROM `credit_store` WHERE `user_id`=$uid";
   $qir=DB::getInstance()->query($qcst);

   echo "<br><b>Credit Store Details</b><br>";
   echo "<table border=1><tr><td>User ID</td><td>QsetID</td><td>Survey Date</td><td>Reward Point</td><td>Remarks</td></tr>";
    
   if($qir->count()>0)
   {
   
     $cstot=0;
     foreach($qir->results() as $rs)
     {
        $uid=$rs->user_id;
        $qset=$rs->qset_id;
        $idt=$rs->i_date;
        $crpt=$rs->cr_point;
        $rmk=$rs->remarks;
         $cstot+=$crpt;
        echo "<tr><td>$uid</td><td>$qset</td><td>$idt</td><td>$crpt</td><td>$rmk</td></tr>";
     }
     echo "<tr><td colspan=3>Grand Total:</td><td colspan=2>$cstot</td></tr>";
        echo "</table>";
   }
   else echo "</table><br><font color=red>No record available for credit store</font>";
 
   //for redeem point details
    

   echo "<br><b>Credit Redeem Details</b><br>";
   echo "<table border=1><tr><td>User ID</td><td>Transaction Mode</td><td>Transaction Date</td><td>Transaction ID</td><td>OrderID</td><td>Redeem Point</td><td>Remarks</td></tr>";
    $csrtot=0;
    $qcrm="SELECT `id`, `user_id`, `rd_date`, `rd_mode`, `ord_id`, `transaction_id`, `rd_point`, `remarks` FROM `credit_redeem` WHERE  user_id=$uid";
   $qirdm=DB::getInstance()->query($qcrm);
     
   if($qirdm->count()>0)
   {
   
     $csrtot=0;
     foreach($qirdm->results() as $rsd)
     {
        $uid=$rsd->user_id;
        $tdate=$rsd->rd_date;
        $tmd=$rsd->rd_mode;
        $ord=$rsd->ord_id;
        $tid=$rsd->transaction_id;
        $rp=$rsd->rd_point;
        $rmk=$rsd->remarks;
         $csrtot+=$rp;
        echo "<tr><td>$uid</td><td>$tmd</td><td>$tdate</td><td>$ord</td><td>$tid</td><td>$rp</td><td>$rmk</td></tr>";
     }
     echo "<tr><td colspan=5>Grand Total:</td><td colspan=2>$csrtot</td></tr>";
        echo "</table>";
   }
   else echo "</table><br><font color=red>No record available for credit redeem</font>";

   //credit store balance details
   $bal=$cstot-$csrtot;
   echo "<br><b>Credit Balance Details</b><br>";
   echo "<table border=1><tr><td>User ID</td><td>Total Credit</td><td>Total Redeem</td><td>Balance Reward Point</td></tr>";
   echo "<tr><td>$uid</td><td>$cstot</td><td>$csrtot</td><td>$bal</td></tr></table>"; 
   

   } 
   else echo "Invalid user ID";


   }

?>