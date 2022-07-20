<?php
include_once('../../init.php');
//include_once('../../functions.php');


// $ddd1=DB::getInstance()->query("SELECT name, `survey_end_date` FROM project WHERE  `project_id`=$qset");
// 					if($ddd1->count()>0)


$date =date('Y-m-d h:i:s');

$qrr="INSERT INTO `cron_tbl`(`name`,`age`) VALUES ('Rinku','35')";
//echo $qrr;
DB::getInstance()->query($qrr);


?>

