<?php

include_once('../init.php');
include_once('../functions.php');

 $data = $_GET['op'];
$data2 = $_GET['cop'];
//$data_txth = $_GET['txth'];

echo $data=substr($data,0,(strlen($data)-1));
echo $data2=substr($data2,0,(strlen($data2)-1));

$_SESSION['rowopt']=$data;
$_SESSION['rowopv']=$data2;


?>