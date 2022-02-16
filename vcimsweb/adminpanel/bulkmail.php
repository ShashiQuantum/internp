<?php
// require_once("../init.php");
 require_once("../../dataupload/PHPExcel.php");

$str='';$m='';
$email_ids = '';
/*
if(!Session::exists('suser'))
{
	Redirect::to('login_fp.php');
}
*/
if(isset($_POST['fe']))
{
	$filename = $_FILES['myfile']['name'];
	$fileTmpName = $_FILES['myfile']['tmp_name'];
	$fileExtension = pathinfo($filename,PATHINFO_EXTENSION);
	$allowedType = array('xlsx','xls') ;
	//$email_ids = '';
	
	// check extension is allowed or not 
	if(!in_array($fileExtension,$allowedType)){
		echo 'Invalid Extension';
	}
	else
	{
		//include 'PHPExcel.php';
		$excel = PHPExcel_IOFactory::load($fileTmpName);
		//set active sheet to first sheet
		$excel->setActiveSheetIndex(0);

foreach ($excel->getWorksheetIterator() as $worksheet) 
		{
			  $highestRow = $worksheet->getHighestDataRow();
			  $highestColumn = $worksheet->getHighestColumn();
			  $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
			  
			  for ($row = 2; $row <= $highestRow; $row++)
				{
					$cell = $worksheet->getCellByColumnAndRow('A', $row);
						$val = $cell->getValue();	
						$email_ids = $val.';'.$email_ids;
				}
		}
	}
}

if(isset($_POST['sendmail']))
{
   echo $t=$_POST['to'];
   $s=$_POST['sub'];
   $m=$_POST['msg'];
   $msg=nl2br($m);
   if($t!='' && $s!='' && $s!='')
   {
      //echo $t="piyushr.ranjan47@gmail.com,piyush_ranjan47@yahoo.co.in,";

         $headers  = 'MIME-Version: 1.0' . "\r\n";
         $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
         $headers .= "From: noreply@digiadmin.quantumcs.com" . "\r\n" .'Reply-To: contact.vcims@gmail.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion();

	$list=explode(';',$t);
	foreach($list as $lt){
		
	      mail($lt, $s, $msg, $headers);
	}
      echo 'mail sent sucessfully.';

   }
   else
       echo 'To email list,Subject and Message cannot be left empty. Please enter all the details.';
}

  if(isset($_POST['prev']))
          echo "<br>".$_POST['msg'];

?>

<html>
<head><title>Bulk Mail</title>
<link rel="stylesheet" href="../../css/siteadmin.css">
</head>
<body id=pg>
    <div id=header>
    <?php
    	//include_once('../init.php');
        if(isset($_POST['logout']))
         {
            session_destroy();
		//Cookie::delete($this->_cookieName);
		
		Redirect::to('login_fp.php');
            
         }
        //  echo " <font color='lightgreen'>".Session::get('suser')."</font>"; 
        ?>

<!--                            <form action="" method=post><input type=submit name=logout value=Logout><div style=float:right><img src='https://www.digiadmin.quantumcs.com/siteadmin/public/img/logos/Digiadmin_logo2.png' height=50 width=150> </div> <center><h3><font color=red >Simple Mail Admin Panel</font></h3></center>
-->
    </div>

<center> <h1>Bulk eMail Sending(General)</h1> 
<table border="0" cellpadding="0" cellspacing="0">
<form name=fe action="" enctype="multipart/form-data" method=post>
<tr><td>Emails from file(.csv):</td><td><input type=file name=myfile>  <input type=submit name=fe value=Import></td></tr>
</form>
<form name=sm action="" method=post>
<tr><td>To:</td><td><textarea name=to rows=6 cols=100 placeholder='Enter emails separated by ; (semicolon only)'><?php echo $email_ids;?></textarea></td></tr>

<tr><td>Subject:</td><td><textarea name=sub rows=1 cols=100 placeholder='type subject here'></textarea></td></tr>

<tr><td>Message:</td><td><textarea name=msg rows=20 cols=100 placeholder='Type your massege here'></textarea></td></tr>
<tr><td>.</td><td> .</td></tr>
<tr><td> </td><td><input type=submit name=sendmail value="Send Mail"> <input type=submit name=prev value="Preview Message"></td> </tr>
</form>

</table>
</center>
</body>
</html>


<?php

?>


