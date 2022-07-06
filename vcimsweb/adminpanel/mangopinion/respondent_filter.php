<?php
include_once('../../init.php');
include_once('../../functions.php');



if(isset($_POST['pDeploy'])){
  
  //if($_POST['rewardPoint'] != ''){ $rewadp=$_POST['rewardPoint'];} else {$rewadp=0;}
  if($_POST['projectId'] != '') $projectId=$_POST['projectId'];
  
  $projEndDate=  get_project_infoforDepy($projectId);
  foreach($projEndDate as $edatad)
  {

   $surveyTypes      =     $edatad->survey_types;
   $surveyOccurance  =     $edatad->survey_occurance;
   $surveyFrequency  =     $edatad->survey_frequency;
   $projStartDate    =     $edatad->survey_start_date; 
	 $projEndDate      =     $edatad->survey_end_date; 
  
  }
  if($surveyTypes==0){
    $statusVal = 1;
    $surveyTypes =0;
    $surveyOcc =0;
    $surveyFreq =0;

  }

  if($surveyTypes==1){
    $surveyOcc =$surveyOccurance;
    $surveyFreq =$surveyFrequency;

    $strtDate =strtotime($projStartDate);
    $endDate = strtotime($projEndDate);
    $dadiff = $endDate - $strtDate;
    $noOfDay= round($dadiff / (60 * 60 * 24));
    $statusVal = $noOfDay * $surveyFrequency;
   


  }
 
  
 
  $pdata=	$_POST['userIds'];
  foreach($pdata as $userID) {
	  //echo $userID;

    $arrayData = explode('**', $userID);
    $usersId =$arrayData['0'];
    $gcmIdInArray[] =$arrayData['1'];
 
	  $assignPro="INSERT INTO `appuser_project_map`(`appuser_id`,`project_id`,`survey_type`,`survey_occurance`,`survey_frequency`,`status`,`start_date`,`exp_date`) VALUES ('$usersId','$projectId','$surveyTypes','$surveyOcc','$surveyFreq','$statusVal','$projStartDate','$projEndDate')";
		  $succ=	DB::getInstance()->query($assignPro);

 }
 //$depMsg ="New Survegeynics Project Has been assign Please fill Survey";
 //$succNoti  =	sendFCMnotification( $gcmIdInArray , $depMsg);  
 //$resultarray = json_decode($succNoti);  
 
 //if($succ->count()>0  &&  $resultarray->success > 0)
 if($succ->count() > 0 )
 {
   echo "<br><center><font color=green> <b> PROJECT IS DEPLOYED AND NOTIFICATION HAS BEEN SEND TO USERS SUCCESSFULLY </b></center></font><br>";
 }
}
///////////////////////////////////////////////SHASHI START PROFILE FILTER/////////////////////////////////////////////////////////////////////////
?>

<head><title>Filter Users </title></head>
<body>
<br><br>
<center>
<h3><font color=red><u>Filter user </u></font></h3>
<form name="filterUsers" method=post action="respondent_list.php" >
  <?php
//SEARCH PROFILERS TABLE NAME
$data=DB::getInstance()->query("SELECT data_table , project_id from project where response_type = 1");

     if($data->count()>0) 
     {    
          foreach($data->results() as $d)
          { //FIRST FOREACH
            $profilerTable = $d->data_table;
            $qSetId = $d->project_id;
           
                  // FIND THE DETAILS QUESTION FROM QUESTION DETAILS TABLE
                  $data2=DB::getInstance()->query("select qset_id , q_id , q_type , q_title from question_detail where qset_id= $qSetId");
                  if($data2->count()>0){//2nd IF START
                    
                    foreach($data2->results() as $d2)
                    { //2nd foreach start
                     $qsetId = $d2->qset_id;
                     $qustId = $d2->q_id;
                     $qType = $d2->q_type;
                     $questdetail = $d2->q_title;
                      if($qType == 'radio' || $qType == 'checkbox' ){    // RADIOT CHECKBOX START
                        ?>
                        <input type="checkbox" name="<?php  echo $qustId.'_'.$qsetId ?>" value="<?php echo $qustId.'_'.$qSetId ?>" />
                        <?php
                        echo $questdetail; echo '[';

                      $data3=DB::getInstance()->query("select opt_text_value,value from question_option_detail where q_id= $qustId");
                      if($data3->count()>0){//3rd IF START

                        foreach($data3->results() as $d3)
                        { //OPTION  foreach start


                         $optionDetails=  $d3->opt_text_value;
                         $optionVal=  $d3->value;

                         if($qType == 'radio'){
                            ?>
                   <input type="radio" name="<?php echo $qustId.'_'.$qsetId ?>" value="<?php echo $optionVal ?>" />
                        <?php  echo $optionDetails; 
                             }

                        elseif($qType == 'checkbox'){
                          ?>
                          <input type="checkbox" name="<?php echo $qustId.'_'.$qsetId ?>" value="<?php echo $optionVal ?>" />
                               <?php  echo $optionDetails; 

                        }



                        }//OPTION FOREACH END  
                          echo ']';  echo"<br/>";
                      }//3rd  IF END

                      }//RADIO CHECKBOX END

                    } //2nd foreach end
                   
                  } // END 2nd IF

            
         } //END FOREACH 


     } //FIRST IF END 
?>
     <input type=submit name="respondendFilter" id ="respondendFilter" value="View Respondent for project deployment">
</form>
<?php


///////////////////////////////////////////////////// END PROFILE FILTER //////////////////////////////////////////////////////////////////
?>