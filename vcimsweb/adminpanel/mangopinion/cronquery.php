<?php
include_once "dbcon.php";

$cronID = $_POST['idval'];
if($cronID !=''){

$delqry = "delete from cron_job where id = $cronID ";
$result = $mysqli->query($delqry);
if($result)
{
 echo "Reminder deleted successfully";   
}else{

    echo "Not deleted some technical problem exist";
}


}






?>