<?php
///////////////////////////////DATABASE CONNECTION ///////////////////
        $dbhost = 'localhost';
         $dbuser = 'root';
         $dbpass = '';
		 $dbname = 'vcims';
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $mysqli = new mysqli($dbhost,  $dbuser,  $dbpass,  $dbname);
//////////////////////////////END DATA BASE CONNECTION ////////////////////
 


$gcmID = array();
$qrr="SELECT * from cron_job";
$result = $mysqli->query($qrr);

if($result->num_rows > 0){  ///////  FIRST QUERY FROM THE CRON JOB TABLE
$today = date('Y-m-d');
$serverDate = date('Y-m-d H:i');
   
    $prows = $result->fetch_all(MYSQLI_ASSOC);
    foreach($prows as $result){   //////////////// FIRST FOREACH START

    $projID      =    $result['project_id'];
    $projStatus  =    $result['project_status'];
    $projminutes =    $result['minutes'];
    $projhour    =    $result['hour'];
    $projmessage =    $result['message'];
    $projtzlist  =    $result['tzlist'];

    $loDate = $today.' '.$projhour.':'.$projminutes;

     $dateTime =$loDate; 
     $newDateTime = new DateTime($dateTime, new DateTimeZone($projtzlist)); 
     $newDateTime->setTimezone(new DateTimeZone("UTC")); 
     $dateTimeUTC = $newDateTime->format("Y-m-d H:i");
     
           
            $serveTime=  strtotime($serverDate); 
            $givenTime=  strtotime($dateTimeUTC); 

            
            if($serveTime == $givenTime){///////GIVEN TIME IS MATCH START
   
    if($projStatus == 0){
        $qrr2="SELECT appuser_project_map.appuser_id,gcm_users.gcm_regid FROM appuser_project_map inner join gcm_users on appuser_project_map.appuser_id= gcm_users.user_id WHERE appuser_project_map.project_id = $projID and appuser_project_map.status = 0 and appuser_project_map.exp_date >= '$today' and appuser_project_map.start_date <= '$today' ";
    }else{
        $qrr2="SELECT appuser_project_map.appuser_id,gcm_users.gcm_regid FROM appuser_project_map inner join gcm_users on appuser_project_map.appuser_id= gcm_users.user_id WHERE appuser_project_map.project_id = $projID and appuser_project_map.status > 0 and appuser_project_map.exp_date >= '$today' and appuser_project_map.start_date <= '$today' ";   
    }               
     
    $resultQR = $mysqli->query($qrr2);
    if($resultQR->num_rows > 0){   /// START  $resultQR STATEMENT 

        
        $Resrows = $resultQR->fetch_all(MYSQLI_ASSOC);

        foreach($Resrows as $GCMresult){ 
           
            $gcmID[]= $GCMresult['gcm_regid']; 
           
        }

    }///// END $resultQR STATEMENT 
      
     $succ  =	sendFCMnotification($gcmID, $projmessage); 
     $qrr="INSERT INTO `cron_result` ( `project_id`, `runtime`, `result`) VALUES ($projID, '$loDate', '$succ');";
     $result = $mysqli->query($qrr);

      }/////////////////GIVEN TIME MATCH IS END HERE

        } //////END THE FIRST FOREACH STATEMENT
    } /////////////////////////END QUERY FROM THE CRON JOB TABLE
 


function sendFCMnotification($gcmId, $nofifyMsg ){
	
    $url ='https://fcm.googleapis.com/fcm/send';
    $apikey ='AAAAu5kGXG0:APA91bG43dL7c2SAU4jZGoZLGI0Sw9d4RK03jo2nIUJaGhYlP274U8Xql7ikj9sg-pwgANz7JAI3lU64hN0uluvVVuIOIHhAApqHHgyv-u3TXSIilyuJWGazA54wHnuWBCCtc0Eoekiw';

$header =array(
    'Authorization:key='.$apikey,
    'Content-Type:application/json'
      );
      
      $nofifyData =[
      'title'=>'Surveygenics Reminder !',
       'body'=>$nofifyMsg,
       'click_action'=> 'activity.notifyHandler'
     
      ];
     
    $data = array
    (
      'message'    => 'This message from Servegenics App',
       'title'     => 'This is Servegenics Title',
       'vibrate'   => 1,
       'sound'     => 1,
       
    );

        $nofifyBody = [
            
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

?>