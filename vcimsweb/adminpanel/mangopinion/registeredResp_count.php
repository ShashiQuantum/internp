<?php
include_once('../../init.php');
include_once('../../functions.php');


if(isset($_POST['RegUsers']))
{
   
 $searchDay=   $_POST['sdt'];
 $searcAll=   $_POST['RegUsers'];
 
 ?>
<center>
<h3><font color=red><u> Registered Users Details </u></font></h3>
 <?php

 
   echo "<table border=0>";
   echo "<tr bgcolor=lightgray><td>SL. No.</td><td>User Id</td><td>Mobile No</td><td>Reg. Date</td><td>Status</td></tr>";
   $reQry = "SELECT `user_id`,`mobile`,DATE_FORMAT(create_date,'%Y-%m-%d') as RegDate,`status` from app_user";
 if($searchDay != ''){
    $reQry = "SELECT `user_id`,`mobile`,DATE_FORMAT(create_date,'%Y-%m-%d') as RegDate,`status` from app_user where DATE_FORMAT(create_date,'%Y-%m-%d') = '$searchDay'";
}
   
  // $reQry = "";    
   $reDataQ=DB::getInstance()->query($reQry);
     $jj=1;
    // print_r($reDataQ);die;
   if($reDataQ->count()>0){ //FIRST DATA IF START

     foreach($reDataQ->results() as $fDa)
     {
       // print_r($reDataQ->results());die; 
        // print_r($fDa->appuser_id);die;
           echo "<tr bgcolor=lightgray><td>$jj </td><td> $fDa->user_id </td> <td> $fDa->mobile </td>";
           
            echo  "<td> $fDa->RegDate </td><td>";
             
            if($fDa->status == 1){echo 'Active';}
            else{echo 'Not Active';}
             
            echo  "</td></tr>";
   
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

<head><title>user Report</title></head>
<body>
<br><br>
<center>
<h2><u>Registered Respondent Report Details</u></h2>
<br><br>

<form name="RegistUsr" method=post action="registeredResp_count.php">

<div class='col-lg-4 col-xl-4 col-sm-4 col-md-4'>
Date <input type=date name="sdt" class="form-control" id="sdt">
					</div> <br/>


                    

<input type=submit name="RegUsers" id ="RegUsers" value="View Respondent details">
</form>
  </center>    
      

<?php
}
?>

