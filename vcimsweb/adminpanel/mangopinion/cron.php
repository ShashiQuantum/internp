<?php

///////////////////////////////DATABASE CONNECTION ///////////////////
        $dbhost = 'localhost';
         $dbuser = 'root';
         $dbpass = '';
		 $dbname = 'vcims';

		//  $con = mysqli_connect($dbhost,$dbuser ,$dbpass,$dbname);

        //     if (mysqli_connect_errno())
        //     {
        //         echo "Failed to connect to MySQL: " . mysqli_connect_error();
        //     }


        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $mysqli = new mysqli($dbhost,  $dbuser,  $dbpass,  $dbname);




    echo "<center><font color=red><h2>CRON JOB SEDULING FOR NOTIFICATION</h2></font>";    
//////////////////////////////END DATA BASE CONNECTION ////////////////////

$qrr="SELECT appuser_project_map.project_id,project.name FROM appuser_project_map INNER JOIN project on appuser_project_map.project_id = project.project_id GROUP by appuser_project_map.project_id";
$result = $mysqli->query($qrr);
$prows = $result->fetch_all(MYSQLI_ASSOC);

?>

<form method=post action="" onsubmit="return submitForm(this);">
<table border=1; bgcolor="#e8eef3"; style="width:60%">>

<tr> <td>Select Project *</td>   <td> <select name=monthName id=monthName><option value=''>-Select Project-</option>
   <?php 
   foreach($prows as $rdata){
         echo "<option value='";
        	 echo $rdata['project_id']; 
        	echo "'>";
        	 echo $rdata['name']; 
        	echo "</option>";
        	  } ?>
        
            </td> </tr>


<tr> <td>Select Month *</td>   <td> <select name=monthName id=monthName><option value='*'>Every Month</option>
   <?php for ($ii = 1; $ii <= 12; $ii++) {
         echo "<option value='";
        	 echo $ii; 
        	echo "'>";
        	 echo $ii; 
        	echo "</option>";
        	  } ?>
        
            </td> </tr>


            <tr> <td>Select  Month Date *</td>   <td> <select name=monthDate id=monthDate><option value=*>Every date</option>
   <?php for ($iii = 1; $iii <= 31; $iii++) {
         echo "<option value='";
        	 echo $iii; 
        	echo "'>";
        	 echo $iii; 
        	echo "</option>";
        	  } ?>
        
            </td> </tr>


            <tr> <td>Select Date of Week *</td>   <td> <select name=dayOfWeek id=dayOfWeek><option value=*>Every Day of Week</option>
            <option value="0">Sunday</option>
            <option value="1">Monday</option>
            <option value="2">Tuesday</option>
            <option value="3">Wednesday</option>
            <option value="4">Thrusday</option>
            <option value="5">Friday</option>
            <option value="6">Saturday</option>
            </td> </tr>


            <tr> <td>Select Hours *</td>   <td> <select name=monthDate id=monthDate><option value=*>Select Hours</option>
     <?php for ($j = 1; $j <= 23; $j++) {
         echo "<option value='";
        	 echo $j; 
        	echo "'>";
        	 echo $j; 
        	echo "</option>";
        	  } ?>
        
            </td> </tr>


            <tr> <td>Select Minutes *</td>   <td> <select name=dayOfWeek id=dayOfWeek><option value=0>Select Minutes</option>
            <option value="0">00</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="30">30</option>
            <option value="40">40</option>
            <option value="50">50</option>
            </td> </tr>



          
        
        
        
        
        
            <tr align="center"><td colspan ="2"><input type=submit name=rollback value="Create Cron" ></td></tr>
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

