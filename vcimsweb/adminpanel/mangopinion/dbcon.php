<?php
///////////////////////////////DATABASE CONNECTION ///////////////////
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'vcims';
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $mysqli = new mysqli($dbhost,  $dbuser,  $dbpass,  $dbname);
//////////////////////////////END DATA BASE CONNECTION ////////////////////

?>