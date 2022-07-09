<?php
include_once('../../init.php');
include_once('../../functions.php');


if(isset($_POST['filterUsr']))
{
 $proJNo= $_POST['pn'];
 $DataRelt=  get_project_infoforDepy($proJNo);
  foreach($DataRelt as $edatad)
  {

   $surveyTypes      =     $edatad->survey_types;
   $surveyOccurance  =     $edatad->survey_occurance;
   $surveyFrequency  =     $edatad->survey_frequency;
   $projStartDate    =     $edatad->survey_start_date; 
   $projEndDate      =     $edatad->survey_end_date; 
      
  }
  if($surveyTypes==0){
    $statusVal = 1;
//     $surveyTypes =0;
//     $surveyOcc =0;
//     $surveyFreq =0;
     $SurvTypes = 'Single Survey';

  }

  if($surveyTypes==1){
   // $surveyOcc =$surveyOccurance;
    $surveyFreq =$surveyFrequency;

    $strtDate =strtotime($projStartDate);
    $endDate = strtotime($projEndDate);
    $dadiff = $endDate - $strtDate;
    $noOfDay= round($dadiff / (60 * 60 * 24));
    $noOfDay = $noOfDay+1;
    $statusVal = $noOfDay * $surveyFrequency;
    $SurvTypes = 'Mutiple Survey';


  }
 
 ?>
<center>
<h3><font color=red><u>Survey Deployement Report</u></font></h3>
 <?php
   echo "<table border=0>";
   echo "<tr bgcolor=lightgray><td>SL. No.</td><td>User Id</td><td>Mobile No</td><td>Status</td><td>Submit times</td><td>Survey Types</td><td>Deployed Date</td><td>Survey Start Date</td><td>Survey End Date</td></tr>";
   $reQry = "select DISTINCT(appuser_project_map.appuser_id),app_user.mobile,appuser_project_map.status,DATE_FORMAT(updated_at,'%Y-%m-%d') as DeployDate from appuser_project_map INNER join app_user on appuser_project_map.appuser_id =app_user.user_id where appuser_project_map.project_id =$proJNo";    
   $reDataQ=DB::getInstance()->query($reQry);
     $jj=1;
   if($reDataQ->count()>0){ //FIRST DATA IF START
     foreach($reDataQ->results() as $fDa)
     {
         // print_r($fDa->appuser_id);die;
           echo "<tr bgcolor=lightgray><td>$jj </td><td> $fDa->appuser_id </td> <td> $fDa->mobile </td><td>";
           
           
            if($fDa->status > 0){echo 'Not Completed';}
           else {echo 'Completed';}
           echo "</td> <td>";
            echo  ($statusVal) - ($fDa->status);
            echo  "</td><td> $SurvTypes </td><td> $fDa->DeployDate</td><td> $projStartDate</td><td> $projEndDate</td></tr>";
   
            $jj++;

     }
                         }  //FIRST DATA IF END
                         else{
                              echo "<b>Data Not Found<b/>";

                         }

  


?>
</center>
<?php 
}








else
{

?>

<head><title>Filter Count</title></head>
<body>
<br><br>
<center>
<h2><u>Respondent Report Details</u></h2>
<br><br>

<form name="filterUsr" method=post action="resp_count.php">



<?php

///////////   SHASHI  NEW CODE FOR FILTER REPORT START FROM HERE////////////////////////////////////////
$query1 ="SELECT DISTINCT(appuser_project_map.project_id),project.name from appuser_project_map INNER JOIN project on appuser_project_map.project_id = project.project_id order by appuser_project_map.project_id DESC";
  
echo "<br><table><tr><td> Project </td> </td><td> <select name=pn id=pn required ><option value=0>--Select Project--</option>";
$data=DB::getInstance()->query($query1);
     if($data->count()>0) 
     {  
          foreach($data->results() as $dR)
          {
            
             
             echo "<option value='";
             echo $dR->project_id; 
            echo "'>";
             echo $dR->name; 
            echo "</option>";
           

          }

     }   

    
  ?>

<input type=submit name="filterUsr" id ="filterUsr" value="View Respondent details">
</form>
  </center>    
      

<?php
}
?>





