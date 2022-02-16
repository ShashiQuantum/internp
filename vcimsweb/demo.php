<?php

require_once('init.php');

/*
date_default_timezone_set('Asia/Kolkata'); 
//ini_set('upload_max_filesize', '100M');
//ini_set('post_max_size', '100M');
//ini_set('max_input_time', 500);
ini_set('max_execution_time', 500);

if(isset($_POST['up']))
{
$qset=$_SESSION['qset'];
$rsp=$_SESSION['rsp'];
//$qid=$_SESSION['qid'];
$qid=0;
$dt=date('Y-m-d');
$dt.='_';
$dt.=date('h-i-s');
$fname="vcims_qs$qset";
$fname.="_rsp$rsp";
$fname.="_$dt";
$fname.=".";
                if(isset($_FILES['audior']))
        	{
        	       // print_r($_FILES);
			$tmp = $_FILES['audior']['tmp_name'];
			$filename = $_FILES['audior']['name'];
                        $ext = pathinfo($filename, PATHINFO_EXTENSION);
                        $fname.=$ext;
			echo $fname;
			move_uploaded_file($tmp, '../uploads/audio/'.$fname);

                        echo "<br>Recorded & Saved<br>";
                        ?> <a href="<?php echo '../uploads/audio/'.$fname;?>" download>Download from Web</a> <?php
                 }
}
*/
 

$content = "this is just a test.\n"; 

//file_put_contents($hostname, $content, 0, $stream); 
file_put_contents($_SERVER['DOCUMENT_ROOT']."/uploads/pdf/query.txt", $content,FILE_APPEND | LOCK_EX, null); 


//other testing code below

$timestampz=time();

function generateRandomString($length = 6) {
    //$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


 echo  $tokenparta = generateRandomString(6);
//echo uniqid($tokenparta);

$token = $timestampz*1 . $tokenparta;

//echo '<br>'.$token;

?>
<style>
@media (min-width:768px)
 {body{background-color:red;}}
@media (min-width:1200px)
 {body{background-color:blue;}}
<style>
