<?php
include_once('../../init.php');
include_once('../../functions.php');
include_once('../../gcm/send_message.php');
include_once('../../gcm/GCM.php');
include_once('../../gcm/config.php');


?>

<!DOCTYPE html>
<head><title>Filter List</title>
<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>


<script type="text/javascript">
$(document).ready(function(){ 
    
   $("#checkAll").change(function () {  
   $('input:checkbox').prop('checked', this.checked); 
});

});
</script>
</head><body>

<?php 	
   //print_r($_POST);
  

   if(isset($_POST['get_project']))
   {    
	     $pid=$_POST['pn'];
        $_SESSION['pid']=$pid;
		$pid=$_SESSION['pid'];

    }
  
   echo "<table border=0>";
   echo "<form name='projectDeploy' method='post' action='respondent_filter.php'>";
  // echo "<tr><td>Enter Reward Point</td><td><input type='text'  name='rewardPoint'></td><td colspan=2 align=right><input type=submit name='pDeploy' value=Deploy></td></tr>";
   echo "<input type='hidden'  name='rewardPoint' value='0'>"; 
  echo "<tr ><td colspan=2 align=center ><input type=submit name='pDeploy'  value=Deploy></td></tr>"; 
   echo "<tr><td></td><td colspan=2></td></tr>";
   echo "<tr><td></td><td colspan=2></td></tr>";

 echo  "<input type='hidden' name='projectId' value='$pid'>";
        	 
    
  
   

//echo $conditions;
  // $querydata ="select user_id, mobile from app_user where status =1";
 // $querydata ="SELECT user_id,mobile FROM app_user where user_id not in (SELECT appuser_id FROM appuser_project_map where project_id =$pid) and status = 1";
 $querydata ="SELECT app_user.user_id,app_user.mobile ,gcm_users.gcm_regid FROM app_user INNER JOIN gcm_users on app_user.user_id = gcm_users.user_id where app_user.user_id not in (SELECT appuser_id FROM appuser_project_map where project_id =25) and app_user.status = 1";
   $data=DB::getInstance()->query($querydata);
   if($data->count()>0)
   {
          
            
         //show list
 echo "<tr bgcolor=lightgray><td><input type=checkbox id='checkAll' value='Select All'>Select All</td><td>Mobile No</td></tr>";
   	foreach($data->results() as $rr)
   	{
		$useIdGCMid=	$rr->user_id.'**'.$rr->gcm_regid;
		echo "<tr> <td><input type=checkbox name=userIds[] value=$useIdGCMid class='uid'></td> <td>$rr->mobile</td></tr>";
   	}
   	echo "</form>";
   }
   else
   {
   	echo "No record is found matching with this filter condition";
   	
   }

   
  
  	function do_survey($qset,$resp,$rpnt)
	{
		if($qset!='' || $resp!='')
		{
					$pid=$_SESSION['pid'];
					$rpnt=$_POST['rpnt'];
			        $pnn='';$ped='';
					
					$ddd1=DB::getInstance()->query("SELECT name, `survey_end_date` FROM project WHERE  `project_id`=$qset");
					if($ddd1->count()>0)
					{$pnn=$ddd1->first()->name;$ped=$ddd1->first()->survey_end_date; }
			        $qr="select * from `appuser_project_map`  WHERE `appuser_id`=$resp AND `project_id`=$qset AND `status`=0";
					$dsa=DB::getInstance()->query($qr);
						
					if($dsa->count()>0)
					{   
						
						$qrr="INSERT INTO `appuser_project_map`(`project_id`,`appuser_id`,  `status`) VALUES ($qset,$resp,0)";
						DB::getInstance()->query($qrr);
						 
						DB::getInstance()->query("UPDATE `appuser_project_map` SET  `cr_point`=$rpnt ,`exp_date`=''  WHERE `appuser_id`=$resp AND `project_id`=$qset AND `status`=0");
	  
						$rq2="SELECT a.user_id, a.user_name as name, a.user as user  FROM app_user as a join  `mangopinion_57` as b on a.user_id=b.resp_id WHERE a.user_id=$resp  and b.email!=''";
						$rr2=DB::getInstance()->query($rq2);
						if($rr2->count()>0)
						{       $cuid=$rr2->first()->user_id;
							$usern=$rr2->first()->name;
							 $user=$rr2->first()->user;
							
							//code for send GCM Notification to user
										$msg="Hi $usern , A new contest named : $pnn , is added for you in your Mangopinion App";
										
										$rq2="SELECT `user_id`, `gcm_regid`, `name`, `email`, `mob`, `created_at` FROM `gcm_users` WHERE `user_id`=$cuid";
							$rr2=DB::getInstance()->query($rq2);
							if($rr2->count()>0)
							{ 
												//$nctr++;
								echo '<br>'.$usern=$rr2->first()->name;
								$user_id=$rr2->first()->user_id; 
												$gcmid=$rr2->first()->gcm_regid;		    			
								notify($gcmid, $msg);  
							}
		
											//code for send email
												$to=$user;
							$headers  = 'MIME-Version: 1.0' . "\r\n";
							$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
							$headers .= 'From: Mangopinion<contact@mangopinion.com>'. "\r\n" .'Reply-To: contact@mangopinion.com' ;
							$m='Dear '.$usern.', <br><br><br> Thanks for using Mangopinion App! One more contest is added for you. <br> Please go to Mangopinion App to share your valuable opinion.  <br><br><br> Thanks,<br>Admin<br><img  src=www.digiadmin.quantumcs.com/images/mangopinion_full_logo.png height=50 width=100><br>';
							$s="A Contest is added to your Mangopinion account ";
							$fs= mail($to, $s, nl2br($m), $headers);
					
						}
					}
					
		}
	}
	

?>
</body>
<script>
    function displib2()
{
        var pin;
	if(window.XMLHttpRequest)
	{
		pin=new XMLHttpRequest();
	}
	else
	{
		pin= new ActiveXobject("Microsoft.XMLHTTP");
	}
	var val=document.getElementById('pn').value;
        //document.write('Hello: '+val);
	pin.onreadystatechange=function()
	{
		if(pin.readyState==4)
		{
			document.getElementById('qset').innerHTML=pin.responseText;
			console.log(pin);
		}
	}
	url="get_qset.php?pid="+val;
	pin.open("GET",url,true);
	pin.send();
}
</script>

<script type="text/javascript">
     $(document).ready(function(){ 
    $("#uall").change(function(){
      $(".uid").prop('checked', $(this).prop("checked"));
      });
});
</script>

<script type="text/javascript">
$(document).ready(function() {
    $('#uall').click(function(event) {  //on click 
        if(this.checked) { // check select status
            $('.uid').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"               
            });
        }else{
            $('.uid').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                       
            });         
        }
    });
    
});
</script>