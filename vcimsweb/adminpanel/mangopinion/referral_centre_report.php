<?php
include_once('../../init.php');
include_once('../../functions.php');

?>

<head><title>Centre Referral</title></head>
<body>
<br><br>
<center>
<h3><font color=red><u>Centre Referal Code</u></font></h3>
<form name="tFORM" method=post action="">
 Centre : <select name="centre"><option value='0'>Select--</option><?php $dc1=DB::getInstance()->query("SELECT * FROM `centre`"); foreach($dc1->results() as $cn){ $cid=$cn->centre_id; ?> <option value=<?php echo $cid;?> > <?php echo $cn->cname; ?> </option> <?php }?></select>

 <input type="submit" name="view" value="View">
</form>

<?php

    	if(isset($_POST['view']))
   	{
   		$cn=$_POST['centre']; $cnt=0;
   		
   		echo "<font color=red> <h3>Referred User List by Referral Code: <font color=green> $rcode </h3> </font>";
   		
   		$rdata=DB::getInstance()->query("SELECT `intvr_id`, `remarks`, `centre`, `irefcode` FROM `mangop_interviewer_referral_detail` WHERE `irefcode` in (SELECT `irefcode` FROM `mangop_interviewer_referral_detail` WHERE `centre` ='$cn')");
   		if($rdata->count()>0) 
    		{   
    			echo "<table border=1> <tr bgcolor=lightgray><td>S.No.</td><td>Intr. Ref.</td><td>User ID</td><td>Name</td><td>Mobile</td><td>Email</td><td>Reg. Date</td><td>Profile_Update_Date</td></tr>";
			
	  		 foreach($rdata->results() as $c)
			 {	                 
	   			$uid=$c->intvr_id; $ircode=$c->irefcode;
	   			 
		   		$fdata=DB::getInstance()->query("SELECT `user_id`, refcode, `intvr_id`, `dtime`,centre FROM `mangop_interviewer_app_user_ref` WHERE `intvr_id`=$uid order by user_id");
		     		if($fdata->count()>0) 
		    		{    	 
		    			
				         foreach($fdata->results() as $d)
				         { 
						$tuid=$d->user_id; 
						
						$rd=DB::getInstance()->query("SELECT a.`resp_id`, a.`r_name`, a.`nresp_dob`, a.`mobile`, a.`i_date_57`, a.`sec_57`, a.`gender_57`, a.`email`, a.`nresp_educ`, a.`age_yrs`, a.`age_57`, a.`address`, a.`nresp_working_st`, a.`state`, a.`city`, a.`ref`, a.`imei`, a.`oprator_name`, a.`network_circlr_location`, a.`phone_type`,b.create_date FROM `mangopinion_57` a JOIN app_user b ON a.resp_id=b.user_id WHERE   a.resp_id=$tuid AND  a.`imei` !=''");
						if($rd->count()>0) 
		    				{   	$cnt++;
		    					$name=$rd->first()->r_name; $resp_id=$rd->first()->resp_id; $mobile=$rd->first()->mobile;$email=$rd->first()->email;$city=$rd->first()->city;
		    					$reg_dt=$rd->first()->create_date; $profile_dt=get_mangopinion_dt($resp_id); 
		    					
		    					echo "<tr><td>$cnt</td><td>$ircode</td><td>$resp_id</td><td>$name</td><td>$mobile</td><td>$email</td><td>$reg_dt</td><td>$profile_dt</td></tr>";
		    				}
						
				         }
				         //echo "</table>";
		     		}
		     	}
		     		
		} else echo "No record found";
     	}	
?>

