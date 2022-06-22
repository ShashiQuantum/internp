<?php
include_once('../../init.php');
include_once('../../functions.php');



if(isset($_POST['pDeploy'])){
  
  
  if($_POST['rewardPoint'] != ''){ $rewadp=$_POST['rewardPoint'];} else {$rewadp=0;}
  if($_POST['projectId'] != '') $projectId=$_POST['projectId'];
  
  $projEndDate=  get_project_endDate($projectId);
  foreach($projEndDate as $edatad)
  {
	 
	$projEndDate=  $edatad->survey_end_date; 
	
  }
  
 
  
 
  $pdata=	$_POST['userIds'];
  foreach($pdata as $userID) {
	  //echo $userID;

    $arrayData = explode('**', $userID);
    $usersId =$arrayData['0'];
    $gcmIdInArray[] =$arrayData['1'];
 
	  $assignPro="INSERT INTO `appuser_project_map`(`appuser_id`,`project_id`,`status`,`cr_point`,`exp_date`) VALUES ($usersId,$projectId,0,$rewadp,'$projEndDate')";
		  $succ=	DB::getInstance()->query($assignPro);

 }
 $depMsg ="New Survegeynics Project Has been assign Please fill Survey";
 $succNoti  =	sendFCMnotification( $gcmIdInArray , $depMsg);  
 $resultarray = json_decode($succNoti);  
 
 if($succ->count()>0  &&  $resultarray->success > 0)
 {
   echo "<br><center><font color=green> <b> PROJECT IS DEPLOYED AND NOTIFICATION HAS BEEN SEND TO USERS SUCCESSFULLY </b></center></font><br>";
 }
}


?>
<head><title>Project Deployement </title></head>
<body>
<br><br>
<center>
<h3><font color=red><u>Project Deployement</u></font></h3>
<form name="tFORM" method=post action="respondent_list.php" >

<!--<input type=submit name="get_resp" value="View"><br> -->
<!--   NEW CODE FOR PROJECT DEPLOYEMENT     --> 
<?php
echo "<br><table><tr><td> Project </td> </td><td> <select name=pn id=pn required ><option value=0>--Select Project--</option>";
$pj=get_projects_details_serveygenics();
   foreach($pj as $p){ 
echo "<option value='";
 echo $p->project_id; 
echo "'>";
 echo $p->name; 
echo "</option>";
  } 
 
  echo "\r\n";  
?>

<input type=submit name="get_project" id ="get_project" value="View Respondent for project deployment">
</form>


<?php  


function sendFCMnotification($gcmId, $nofifyMsg ){
	
  $url ='https://fcm.googleapis.com/fcm/send';
  $apikey ='AAAAu5kGXG0:APA91bG43dL7c2SAU4jZGoZLGI0Sw9d4RK03jo2nIUJaGhYlP274U8Xql7ikj9sg-pwgANz7JAI3lU64hN0uluvVVuIOIHhAApqHHgyv-u3TXSIilyuJWGazA54wHnuWBCCtc0Eoekiw';

$header =array(
  'Authorization:key='.$apikey,
  'Content-Type:application/json'
    );
    
    $nofifyData =[
    'title'=>'Servegeygenics Message for New Survey',
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
  


  $data = array
  (
    'message'    => 'This message from Servegenics App',
     'title'     => 'This is Servegenics Title',
     'vibrate'   => 1,
     'sound'     => 1,
     
  );


    // CREATING NEW API BODY 

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













//// OLD CODE COMMENTED //////////////////
/*
echo "<br><table><tr><td> Project </td> </td><td> <select name=pn id=pn ><option value=0>--Select--</option>";
          $pj=get_projects_details();
             foreach($pj as $p){ 
        	echo "<option value='";
        	 echo $p->project_id; 
        	echo "'>";
        	 echo $p->name; 
        	echo "</option>";
        	  } 
       	  
        	//echo "<tr><td>.</td></tr>";
			*/
?>
<!--</table><br></center><br>Age Between </td><td> <input type=num minsize=5 maxsize=80 name=fr size=1 placeholder="min age"> & <input type=num min=5 max=80 name=to size=1 placeholder="max age"><br><br> --> 


<?php 
/*
   $str1=''; $str2='';
   $data=DB::getInstance()->query("SELECT distinct title,term FROM `dictionary` where term in ('nresp_gender','q3_57','q4_57','nresp_educ','nresp_working_st','q16_57','q9_57','q10_57','q1_57') order by id");
     if($data->count()>0) 
     {    $nctr=0;
          foreach($data->results() as $d)
          { 
                         $term=$d->term; $nctr++;
                       $t= $d->title;
                //echo "<tr><td><details style='margin-left:25px'> <summary> $t</summary> <p style='margin-left:25px'></td></tr>";
                ?>

                <dt onmouseover="javascript:montre('<?php echo "smenu$nctr";?>');"><?php echo $t; ?></dt> <dd id='<?php echo "smenu$nctr";?>' onmouseover="javascript:montre('<?php echo "smenu$nctr";?>');" onmouseout="javascript:montre();"> <ul>

               <?php
                $ptt=get_dictionary($term,null); 
                if($ptt) 
                  foreach($ptt as $p)
                      {            if($term=='nresp_gender'){ $term='gender_57'; }
                               
                             $k=$p->keyy;$v=$term.'='.$p->value;$str='';
                              if (!empty($_POST[$k]))
                                  { $str=" checked='checked'";}
                   //echo     "<tr><td><input type='checkbox' name='$k' value='$v' id=x>$k</td></tr>"; 
                           echo     "<li><input type='checkbox' name='$k' value='$v' id=x>$k</li>";          
                      }
                //echo "</details>";
                echo "</ul></dd><br>";
            }
     }
*/

?>

<!--</form> -->




<script type="text/javascript">
 /*
  document.getElementById('x').value = "<?php  //echo $_POST['xv'];?>";
  document.getElementById('y').value = "<?php //echo $_POST['yv'];?>";
  document.getElementById('fr').value = "<?php //echo $_POST['fr'];?>";
  document.getElementById('to').value = "<?php //echo $_POST['to'];?>";
</script>



<script>
	/*
dl, dt, dd, ul, li {
margin: 0;
padding: 0;
list-style-type: none;
}
#menu {
position: absolute;
top: 1em;
left: 1em;
width: 10em;
}

#menu dt {
cursor: pointer;
background: #A9BFCB;
height: 20px;
line-height: 20px;
margin: 2px 0;
border: 1px solid gray;
text-align: center;
font-weight: bold;
}

#menu dd {
position: absolute;
z-index: 100;
left: 8em;
margin-top: -1.4em;
width: 10em;
background: #A9BFCB;
border: 1px solid gray;
}

#menu ul {
padding: 2px;
}
#menu li {
text-align: center;
font-size: 85%;
height: 18px;
line-height: 18px;
}
#menu li a, #menu dt a {
color: #000;
text-decoration: none;
display: block;
}

#menu li a:hover {
text-decoration: underline;
}

#mentions {
font-family: verdana, arial, sans-serif;
position: absolute;
bottom : 200px;
left : 10px;
color: #000;
background-color: #ddd;
}
#mentions a {text-decoration: none;
color: #222;
}
#mentions a:hover{text-decoration: underline;
}
*/
</script>

<script type="text/javascript">
/*
window.onload=montre;
function montre(id) {
var d = document.getElementById(id);
for (var i = 1; i<=50; i++) {
if (document.getElementById('smenu'+i)) {document.getElementById('smenu'+i).style.display='none';}
}
if (d) {d.style.display='block';}
}
//-->  */
</script>
