<?php

include_once('../init.php');
include_once('../functions.php');

echo 'rr'.$pid = $_GET['pid'];
$ds=get_questionset($pid);
echo "<option value='0'> --Select-- </option>";

foreach($ds as $d)
{ $qid=$d->qset_id;
    echo "<option value='$qid'> $qid </option>";
} 


?>

