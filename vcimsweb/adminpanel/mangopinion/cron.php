<?php

///////////////////////////////DATABASE CONNECTION ///////////////////
        $dbhost = 'localhost';
         $dbuser = 'root';
         $dbpass = '';
		 $dbname = 'vcims';

		 $con = mysqli_connect($dbhost,$dbuser ,$dbpass,$dbname);

    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
         
//////////////////////////////END DATA BASE CONNECTION ////////////////////

//$date =date('Y-m-d h:i:s');

$qrr="INSERT INTO `cron_tbl`(`name`,`age`) VALUES ('Rinku','35')";



$result=  mysqli_query($con,$qrr);
if($result)
{echo "inserted successfully";}


?>

