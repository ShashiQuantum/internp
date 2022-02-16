<?php
//ob_start();
//include_once('../vcimsweb/init.php');

date_default_timezone_set("Asia/Kolkata");


/*

			$qa=DB::getInstance()->query("SELECT max(sid) as ms FROM `question_sequence` WHERE `qset_id`=$qset");
			if($qa->count()>0)
			{
				 $maxsid=$qa->first()->ms;
				 $_SESSION['maxsid']=$maxsid;
			} 
*/

?>

<html>
<head><title> FM Demo Data</title> </head>

<body>

<br><br>
<h2>Tasks:</h2>
<ul>
	<li><a href="https://digiadmin.quantumcs.com/vcimsweb/fm_images.php" target='_blank'> Uploaded Saved Image List</a> </li>
        <li><a href="https://digiadmin.quantumcs.com/vcimsweb/fm_images_table.php" target='_blank'> Uploaded Table Image List</a> </li>
        <li><a href="https://digiadmin.quantumcs.com/vcimsweb/fm_images_ocr_table.php" target='_blank'> Uploaded Table OCR Image Data List</a> </li>
</ul>

</body>
</html>
