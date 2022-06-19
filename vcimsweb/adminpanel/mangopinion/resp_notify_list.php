<?php
include_once('../../init.php');
include_once('../../gcm/send_message.php');
include_once('../../gcm/GCM.php');
include_once('../../gcm/config.php');

if(isset($_POST['sendNotify']))
   {  
  
$notifyMSG = $_POST['nofificationMSG'];
$pdata=	$_POST['userIds'];
//echo $pdata; die;
  foreach($pdata as $fcmid) {
	  
	$fcmToken = $fcmid;
	//$fcmToken=	array_push($fcmToken, $fcmid);
	//   $assignPro="INSERT INTO `appuser_project_map`(`appuser_id`,`project_id`,`status`,`cr_point`,`exp_date`) VALUES ($userID,$projectId,0,$rewadp,'$projEndDate')";
	// 			  $succ=	DB::getInstance()->query($assignPro);

	//$succ  =	sendFCMnotification($fcmToken, $notifyMSG);

 }
//  echo "message is: $notifyMSG";echo "</br>";
//  print_r($fcmToken);die;

 $succ  =	sendFCMnotification($fcmToken, $notifyMSG);
 print_r($succ);die;
 if($succ)
 {
   echo "<br><center><font color=green> Notification Successfully Send</center></font><br>";
 }


   }
?>
<!DOCTYPE html>
<head><title>Filter List for Notification</title>
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

   if(isset($_POST['get_resp']))
   {  

	$projId = $_POST['pn'];
	$survyStatus = $_POST['surveyStatus'];

	

				echo "<table border=0>";
				echo "<form name=frm method=post action='resp_notify_list.php'>";
					   //echo "<input type=hidden name=qset value=$qset>";
							 echo "<tr><td>Enter Message </td>";
							 echo "<td><textarea rows=4 cols=50 name='nofificationMSG' placeholder='Type your message here' required></textarea></td>";
							 echo "<td colspan=2 align=right><input type=submit name=sendNotify value=Send Notification></td></tr>";
						 echo "<tr><td></td><td colspan=2></td></tr>";

						 echo "<tr bgcolor=lightgray><td><input type=checkbox id='checkAll' value='Select All'>Select All</td><td>Mobile</td></tr>";
						// $ddd1=DB::getInstance()->query("select appuser_project_map.appuser_id, app_user.mobile, app_user.fcm_token from appuser_project_map inner join app_user on appuser_project_map.appuser_id =app_user.user_id where appuser_project_map.project_id =$projId AND appuser_project_map.status=$survyStatus");
						 $ddd1=DB::getInstance()->query("SELECT appuser_project_map.appuser_id,gcm_users.gcm_regid,app_user.mobile from appuser_project_map INNER JOIN gcm_users on appuser_project_map.appuser_id = gcm_users.user_id INNER JOIN app_user on appuser_project_map.appuser_id = app_user.user_id WHERE appuser_project_map.project_id =$projId and appuser_project_map.status =$survyStatus");
							
        
                 if($ddd1->count()>0){
						 foreach($ddd1->results() as $rr)
						 {
							
							echo "<tr><td><input type=checkbox name=userIds[] value=$rr->gcm_regid class='uid'></td><td>$rr->mobile</td></tr>";
						 }
						 echo "</form>";
					 }
					 else
							{
								echo "No record is found matching with this filter condition";
								
							}
				  
					 }


					 function sendFCMnotification($gcmId, $nofifyMsg ){
	
						$url ='https://fcm.googleapis.com/fcm/send';
						$apikey ='AAAAu5kGXG0:APA91bG43dL7c2SAU4jZGoZLGI0Sw9d4RK03jo2nIUJaGhYlP274U8Xql7ikj9sg-pwgANz7JAI3lU64hN0uluvVVuIOIHhAApqHHgyv-u3TXSIilyuJWGazA54wHnuWBCCtc0Eoekiw';
					
					$header =array(
						'Authorization:key='.$apikey,
						'Content-Type:application/json'
						  );
						  //Notification content
						  $nofifyData =[
						  'title'=>'Servegeygenics Message for you',
						   'body'=>$nofifyMsg,
						   'click_action'=> 'activity.notifyHandler'
						  // 'image'=> 'image URL'
						  ];
						  //OPTIONAL
					// $dataPayload =[
					//  'to' =>'Notification from Surveygenics',
					//  'date' =>'22-06-14',
					//  'other_data' =>'any oher information'
					
					// ];	  
						
					// CREATING API BODY	
						//   $nofifyBody =[
						//    'token'=> $fcmtoken,
						//   'notification'=>$notifyData,
						//   //THIS IS OPTIONAL
						//   //'data' =>$datapayload,
						//   // THIS IS OPTIONAL
						//   'time_to_live' =>86400
						  
						//   ];

						$data = array
						(
						  'message'    => 'This message from Servegenics',
						   'title'     => 'Servegenics app message',
						   'vibrate'   => 1,
						   'sound'     => 1,
						   
						);


							// CREATING NEW API BODY 

							$nofifyBody = [
								// if we want to send notification for single user use to 
								//'to'=>'token or registered id ',
								// if we want to send notification to the multiple user use registration_ids
								'registration_ids' => $gcmId,
								'notification'=> $nofifyData,
								'data'=> $data,
								'time_to_live'=> 3600
								
								];



						  
					$ch =curl_init();
					curl_setopt($ch,CURLOPT_URL,$url);	  
					curl_setopt($ch,CURLOPT_POST,true);	  
					curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
					curl_setopt($ch,CURLOPT_RETURNTRANSFER, true );
                    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false );	  
					curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($nofifyBody));
					$result = curl_exec($ch);
					   
					if ($result === FALSE) {
						die('Error in sending notification: ' . curl_error($ch));
					} 
					curl_close($ch);
					return $result;
					
					}
				












/*  OLD CODE COMMENTED
	
	$condition='';
       $conditions="SELECT resp_id,r_name,age_yrs, mobile,email,q16_57 FROM `mangopinion_57`  WHERE email!='' AND ";
	$curr='';$prev='';$orflag=0;$andflag=0;$pstr='';$ctr=0;
	$pid=$_POST['pn'];
        $_SESSION['pid']=$pid;
        
       
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
    
    //echo "<br>fcondition=".$condition;
//echo "<br>len:".strlen($condition);
        if($pid > 0)
        {
                $ddd1=DB::getInstance()->query("SELECT distinct `qset_id` FROM `questionset` WHERE  `project_id`=$pid");
                if($ddd1->count()>0)
                {$qset=$ddd1->first()->qset_id;}
                if(strlen($condition) > 5)
                {
                   $condition.=" AND user_id IN (SELECT `appuser_id` FROM `appuser_project_map` WHERE project_id=$qset AND status=0) ";
                }
                else { $condition.=" user_id IN (SELECT `appuser_id` FROM `appuser_project_map` WHERE project_id=$qset AND status=0) ";}
        }

    $conditions.=$condition;

   echo "<table border=0>";
   echo "<form name=frm method=post action=''>";
  		echo "<input type=hidden name=qset value=$qset>";
                echo "<tr><td>Enter Message </td>";
                echo "<td><textarea rows=4 cols=50 name='rpnt' placeholder='Type your message here' required></textarea></td>";
                echo "<td colspan=2 align=right><input type=submit name=send value=Send></td></tr>";
        	echo "<tr><td></td><td colspan=2></td></tr>";
        	 
    $ct=0;
    $pcondition="SELECT count(*) as cnt FROM `mangopinion_57`  WHERE ".$condition;
    $dcnt=DB::getInstance()->query($pcondition);
   if($dcnt->count()>0)
   {
     $ct=$dcnt->first()->cnt;
      
   } 
   	echo "<br><center><font color=red>($ct) records are found!</center></font><br>";

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
                $msg=$_POST['rpnt'];
   	   	$qset=0;
                $ddd1=DB::getInstance()->query("SELECT distinct `qset_id` FROM `questionset` WHERE  `project_id`=$pid");
                if($ddd1->count()>0)
                {$qset=$ddd1->first()->qset_id;}
                   
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
	    		    //echo "<br>".$key."=>".$val;	    		     
	         		$rq2="SELECT `user_id`, `gcm_regid`, `name`, `email`, `mob`, `created_at` FROM `gcm_users` WHERE `user_id`=$val";
		    		$rr2=DB::getInstance()->query($rq2);
		    		if($rr2->count()>0)
		    		{ 
                                        $nctr++;
		    			$usern=$rr2->first()->name;
		    			$user_id=$rr2->first()->user_id; 
                                        $gcmid=$rr2->first()->gcm_regid;
		    			
				        notify($gcmid, $msg);
			       }
	    		}
	    		}
	    	}
    	}
        if($nctr>0)
    	echo "<br> Total ($nctr) Notification Message has sent  ";
        else echo "<br> No respondent is selected";
        	
   }  */
?>
</body>





<script>
 $("#checkAll2").click(function () {
     $('input:checkbox').not(this).prop('checked', this.checked);
 });

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


