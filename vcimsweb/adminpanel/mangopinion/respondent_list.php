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
  
  $pid=0;

   if(isset($_POST['get_resp']))
   {    $condition='';
       $conditions="SELECT distinct resp_id,r_name,age_yrs, mobile,email,q16_57 FROM `mangopinion_57`  WHERE email!='' AND ";
	$curr='';$prev='';$orflag=0;$andflag=0;$pstr='';$ctr=0;
	$pid=$_POST['pn'];
        $_SESSION['pid']=$pid;
        $ddd1=DB::getInstance()->query("SELECT distinct `qset_id` FROM `questionset` WHERE  `project_id`=$pid");
                if($ddd1->count()>0)
                {$qset=$ddd1->first()->qset_id;}

    foreach($_POST as $key=>$val)
    {
    	if($val!='')
    	{       
    	 	
    		//echo "<br>".$key."=>".$val;
    		
    		if($key!='pn'  )
    		if($key!='qset'  )
    		if($key!='fr'  )
    		if($key !='to' )
    		{
    		if($val!='View')
    		{   
    		        $ctr++;
    			$str='';
    			$dlist=array();
    			$dlist=explode('=',$val);
    			$a=$dlist[0];
    			$b=$dlist[1];
    			$curr=$a;
    			$str=$a."=".$b;
    			
    			//echo '<br>'.$ctr.'-'.$prev.'=:'.$curr;
    			
    			if($curr==$prev)
    			{   
    				$orflag++;
    				if($orflag==1)
    				{    		
    						$orflag++;	
    						if($ctr==1)		
    							$condition.=' ( '.$pstr .' OR '.$str;  
    						if($ctr>1)		
    						{	
    							$condition=chop($condition,$pstr);
    							$condition.='  ( '.$pstr .' OR '.$str;
    						}						
    				}
    				else if($orflag>1)
    				{
    					$condition.=' OR '.$str;
    				}
    				
    				//echo "<br>rcondition=".$condition;
    			}
    			else
    			{
    				$andflag++;
    				if($orflag>1)
    				{
    					$orflag=0;  
    					$condition.=' ) '; 
    				}
    				if($ctr==1 && $orflag==0)
    					$condition.=$str;	
    				else if($ctr>1 && $orflag==0)
    					$condition.=' AND '.$str;
    			       //echo "<br>acondition=".$condition;
    			}
    			
    			//$condition.=$str;
    			//array_push($dlist,$clist);
    			//echo "<br>fcondition=".$condition;
    			
    			$prev=$curr;
    			$pstr=$str;
    			
    			
    		}
    		}
    	}
    	
    }

    if($orflag > 1)
    {
        $condition.=' )';
    }

   	  
    if($_POST['fr']!='' && $_POST['to']!='')
    {
        $f=$_POST['fr'];
        $t=$_POST['to'];

        if($orflag>0 || $andflag>0)
    	 $condition.=" AND age_yrs BETWEEN $f AND $t ";
        if($orflag<1 && $andflag<1)
    	 $condition.=" age_yrs BETWEEN $f AND $t ";
    }
    $condition.=" AND resp_id NOT IN (SELECT `appuser_id` FROM `appuser_project_map`
 WHERE project_id=$qset AND status=0) ";
    //echo "<br>fcondition=".$condition;

    $conditions.=$condition;


   echo "<table border=0>";
   echo "<form name=frm method=post action=''>";
  		echo "<input type=hidden name=qset value=$qset>";
                echo "<tr><td>Enter Reward Point</td><td><input type=text name=rpnt></td><td colspan=2 align=right><input type=submit name=send value=Deploy></td></tr>";
        	echo "<tr><td></td><td colspan=2></td></tr>";
        	 
    $ct=0;
   $pcondition="SELECT count(*) as cnt FROM `mangopinion_57`  WHERE email!='' AND ".$condition;
    $dcnt=DB::getInstance()->query($pcondition);
   if($dcnt->count()>0)
   {
     $ct=$dcnt->first()->cnt;
      
   } 
   	echo "<br><center><font color=red>($ct) records are found!</center></font><br>";

//echo $conditions;

   $data=DB::getInstance()->query($conditions);
   if($data->count()>0)
   {
          
            
         //show list
         echo "<tr bgcolor=lightgray><td><input type=checkbox id='checkAll' value='Select All'>Select All</td><td>UserId</td><td>Name</td><td>Mobile</td><td>Email</td><td>Age</td></tr>";
   	foreach($data->results() as $rr)
   	{
   		echo "<tr><td><input type=checkbox name=$rr->resp_id value=$rr->resp_id class='uid'></td><td>$rr->resp_id</td><td>$rr->r_name</td><td>$rr->mobile</td><td>$rr->email</td><td>$rr->age_yrs</td></tr>";
   	}
   	echo "</form>";
   }
   else
   {
   	echo "No record is found matching with this filter condition";
   	
   }

   }
  
  
   if(isset($_POST['send']))
   {
   	   	 //print_r($_POST);
   	   	$pid=$_SESSION['pid'];
                $rpnt=$_POST['rpnt'];
   	   	$qset=0;$pnn='';$ped='';
                $ddd1=DB::getInstance()->query("SELECT distinct `qset_id` FROM `questionset` WHERE  `project_id`=$pid");
                if($ddd1->count()>0)
                {$qset=$ddd1->first()->qset_id;}
                
                $ddd1=DB::getInstance()->query("SELECT name, `survey_end_date` FROM project WHERE  `project_id`=$qset");
                if($ddd1->count()>0)
                {$pnn=$ddd1->first()->name;$ped=$ddd1->first()->survey_end_date; }

   
   	   	$nctr=0;

        foreach($_POST as $key=>$val)
    	{
	    	if($val!='')
	    	{      	if($key!='rpnt'  )    		
	    		if($key!='pn'  )
	    		if($key !='qset' )
	    		{
	    		if($key!='send')
	    		{   
	    		   $nctr++;
	    		   //echo "<br>".$key."=>".$val;
	    		    $qrr="INSERT INTO `appuser_project_map`(`project_id`,`appuser_id`,  `status`) VALUES ($qset,$val,0)";
	    		    DB::getInstance()->query($qrr);
                     
	    		    DB::getInstance()->query("UPDATE `appuser_project_map` SET  `cr_point`=$rpnt ,`exp_date`='$ped'  WHERE `appuser_id`=$val AND `project_id`=$qset AND `status`=0");
  

	         		 $rq2="SELECT a.user_id, a.user_name as name, a.user as user  FROM app_user as a join  `mangopinion_57` as b on a.user_id=b.resp_id WHERE a.user_id=$val and b.email!=''";
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
    	}
    	echo "<br> Total ($nctr) link has sent  ";
   	   	
   }

//function for ola notification base sending survey
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

<script type="text/javascript>
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