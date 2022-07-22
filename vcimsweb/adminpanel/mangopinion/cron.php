<?php
///////////////////////////////DATABASE CONNECTION ///////////////////
        $dbhost = 'localhost';
         $dbuser = 'root';
         $dbpass = '';
		 $dbname = 'vcims';
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $mysqli = new mysqli($dbhost,  $dbuser,  $dbpass,  $dbname);
//////////////////////////////END DATA BASE CONNECTION ////////////////////


/////////////////////INSERT DATA INTO CRON JOB TABLE///////////////////////
if(isset($_POST['createCronJob'])){ 
$bankFlag0 =0;$bankFlag1 =0;$bankFlag5 =0;$bankFlag6 =0;$bankFlag7 =0;$bankFlag4 =0;
   if(isset($_POST['projectId'])){ $projId= $_POST['projectId'];} else{$bankFlag0 =1;}
   if(isset($_POST['projectStatus'])){ $projStatus= $_POST['projectStatus'];}else{$bankFlag1 =1;}
   if(isset($_POST['cronHour'])){$cronHour= $_POST['cronHour'];}else{$bankFlag5 =1;}
   if(isset($_POST['cronMinuts'])){$cronminute= $_POST['cronMinuts'];}else{$bankFlag6 =1;}
   if(isset($_POST['cronMessage'])){$cronMessge= $_POST['cronMessage'];}else{$bankFlag7 =1;}
   if(isset($_POST['timeZone'])){$timeZone= $_POST['timeZone'];}else{$bankFlag4 =1;}
if($bankFlag0 ==1 || $bankFlag1 ==1 ||  $bankFlag5 ==1 || $bankFlag6 ==1  || $bankFlag7 ==1 || $bankFlag4 ==1 )
{
    echo "<center><font color=red><h4>Please fill complete information to set the CRON Job</h4></font>";

}else{
    $qrr="INSERT INTO `cron_job` ( `project_id`, `project_status`, `hour`, `minutes`, `message`, `tzlist`) VALUES 
    ($projId, $projStatus, $cronHour, $cronminute,  '$cronMessge','$timeZone')";
    $result = $mysqli->query($qrr);
    if($result){
        echo "<center><font color=green><h4>CRON Job is Successfully Created !</h4></font>";
    }else{
        echo "<center><font color=red><h4>Some Technical problem CRON job not created!</h4></font>"; 
    }
}
}



////////////////////END THE INSERT SECTION IN THE TABLE////////////////////



echo "<center><font color=red><h2>CRON JOB SEDULING FOR NOTIFICATION</h2></font>"; 
$qrr="SELECT appuser_project_map.project_id,project.name FROM appuser_project_map INNER JOIN project on appuser_project_map.project_id = project.project_id GROUP by appuser_project_map.project_id";
$result = $mysqli->query($qrr);
$prows = $result->fetch_all(MYSQLI_ASSOC);

?>

<form method=post action="cron.php"">
<table border=1; bgcolor="#e8eef3"; style="width:60%">

<tr> <td>Write Message *</td>
<td><textarea rows=3 cols=40 name="cronMessage" id="cronMessage" placeholder='Type your message here' required></textarea></td>
        </tr>

<tr> <td>Select Project *</td>   <td> <select name=projectId id=projectId required><option value=''>-Select Project-</option>
    
<?php   foreach($prows as $rdata){
         echo "<option value='";
         echo $rdata['project_id']; 
         echo "'>";
         echo $rdata['name']; 
         echo "</option>";
        	  } ?>  
        </td> </tr>
            


            <tr> <td>Whom Send Message *</td>   <td> <select name=projectStatus id=projectStatus required><option value=''>-Select Users types-</option>
            <option value="0">Who Submit The SUrvey</option>
            <option value="1">Who Not Submited Survey</option>
            </td> </tr>



            <tr> <td>Select Hours *</td>   <td> <select name=cronHour id=cronHour><option value='555' required>Every Hours</option>
            <option value="1">1:AM</option>
            <option value="2">2:AM</option>
            <option value="3">3:AM</option>
            <option value="4">4:AM</option>
            <option value="5">5:AM</option>
            <option value="6">6:AM</option>
            <option value="7">7:AM</option>
            <option value="8">8:AM</option>
            <option value="9">9:AM</option>
            <option value="10">10:AM</option>
            <option value="11">11:AM</option>
            <option value="12">12:AM</option>
            <option value="13">1:PM</option>
            <option value="14">2:PM</option>
            <option value="15">3:PM</option>
            <option value="16">4:PM</option>
            <option value="17">5:PM</option>
            <option value="18">6:PM</option>
            <option value="19">7:PM</option>
            <option value="20">8:PM</option>
            <option value="21">9:PM</option>
            <option value="22">10:PM</option>
            <option value="23">11:PM</option>
            <option value="24">12:PM</option>
            </td> </tr>



            <tr> <td>Select Minutes *</td>   <td> <select name=cronMinuts id=cronMinuts required><option value='' >Select Minutes</option>
            <option value="00">00</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="30">30</option>
            <option value="40">40</option>
            <option value="50">50</option>
            </td> </tr>



            <tr> <td>Select Your Time Zone *</td>   <td> <select name=timeZone id=timeZone required><option value='' > Select Time Zone </option>
       <?php
           
            $tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
            foreach($tzlist as $value)
            {
            echo "<option value=". $value .">". $value ."</option>";
            }
            echo "<select>";
            ?>
            </td> </tr>





            <tr align="center"><td colspan ="2"><input type=submit name=createCronJob value="Create Cron"  onclick="return confirm('Are you sure want to create this CRON?')"></td></tr>
</form>
</center>
  
  


<?php
///////////////////////////////////////TAKING  INPUT FROM USERS/////////////////







////////////////////////////////////END TO TAKING INPUT////////////////////////

// foreach($prows as $rdata){

// echo $rdata['project_id'];
// echo $rdata['name'];


// }


// $qrr="SELECT appuser_project_map.project_id,project.name FROM appuser_project_map INNER JOIN project on appuser_project_map.project_id = project.project_id GROUP by appuser_project_map.project_id";

//  $result=  mysqli_query($con,$qrr);
//  print_r($result);



// $qrr="INSERT INTO `cron_tbl`(`name`,`age`) VALUES ('Rinku','35')";

// $result=  mysqli_query($con,$qrr);
// if($result)
// {echo "inserted successfully";}

echo "<br/>";
$dateTime =date('Y-m-d h:i');
$tz_from = date_default_timezone_get();
$newDateTime = new DateTime($dateTime, new DateTimeZone($tz_from)); 
$newDateTime->setTimezone(new DateTimeZone("UTC")); 
$dateTimeUTC = $newDateTime->format("Y-m-d H:i");
//433echo "in UTC Time format :  $dateTimeUTC ";







?>

