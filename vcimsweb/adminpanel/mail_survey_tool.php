<?php
require_once("../init.php");
require_once("../functions.php");
$str='';$m='';


if(!Session::exists('suser'))
{
	Redirect::to('login_fp.php');
}

if(isset($_POST['fe']))
{
   //print_r($_POST);   
                        $str='';
                        $tmp = $_FILES['ff']['tmp_name'];
			$fname = $_FILES['ff']['name'];
			
			move_uploaded_file($tmp, '../../uploads/'.$fname);

                        $handle = fopen('../../uploads/'.$fname, "r");
                        while(($fv = fgetcsv($handle, 1000, ",")) !== false)
                        {

                            //echo '<br>'.$fv[0];
                             $str.=$fv[0].',';
                        }
}

if(isset($_POST['sendmail']))
{
	print_r($_POST);
   $t=$_POST['to'];
   $s=$_POST['sub'];
   $msg=$_POST['msg'];
   $urllink=$_POST['ul'];
   $url=$_POST['url'];
   $pn=$_POST['pn'];
   $qset=$_POST['qset'];
   $cn=$_POST['cn'];

   $m.=$msg.'<br><a href='.$_POST['url'].'>Start Survey</a><br><br><br> With Regards,<br>Admin<br><img  src=www.digiadmin.quantumcs.com/images/Digiadmin_logo.jpg height=50 width=100><br>';
   if($t!='' && $s!='' && $s!='')
   {
      //echo $t="piyushr.ranjan47@gmail.com,piyush_ranjan47@yahoo.co.in,";
      $headers  = 'MIME-Version: 1.0' . "\r\n";
      $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
      $headers .= 'From: admin@digiadmin.quantumcs.com' . "\r\n" .'Reply-To: admin@digiadmin.quantumcs.com' . "\r\n" .'X-Mailer: PHP/' . phpversion();

      $ar=explode(",",$t);
       echo 'l:'.$urllink;

       if($urllink=="no")
       {  echo $m;
             foreach($ar as $aa)
             {
                 mail($aa, $s, nl2br($m), $headers);
                 echo '<br>mail sent'.$aa;
             }
       }
       if($urllink=="yes")
       {
             foreach($ar as $aa)
             {  
                $m='';$resp_id=19;
               /* $data=DB::getInstance()->query("INSERT INTO `demo_respondent`(`email`) VALUES ('$aa')");
                if($data)
                { 
                     $_SESSION['respid']=$data->last();
                     $resp_id=$_SESSION['respid'];
                }
                */
               echo $m.=$msg."<br><a href=$url&rsp=$resp_id>Start Survey</a><br><br><br> With Regards,<br>Admin<br><img  src=www.digiadmin.quantumcs.com/images/Digiadmin_logo.jpg height=50 width=100><br>";
                //$data2=DB::getInstance()->query("INSERT INTO `respondent_link_map`(`p_id`, `qset_id`, `resp_id`, `url`, `status`, `centre_id`) VALUES ($pn,$qset,$resp_id,'$url',0,$cn)");
                
              mail($aa, $s, nl2br($m), $headers);
               echo '<br>mail sent successfully to '.$aa;
             }
       }
   }
   else
       echo 'To email list,Subject and Message cannot be left empty. Please enter all the details.';
}



  if(isset($_POST['prev']))
  {
        //echo "<br>".$_POST['msg'];
        $m=$_POST['msg'];
        echo $m.'<br>'.$_POST['url'].'<br> With Regards,<br>Admin<br>DigiadminCIMS';
        echo substr_count($t, ',');
  }

	$dc1=DB::getInstance()->query("SELECT centre_id, `cname` FROM `centre`");
                     $cn=$dc1->results();
                     
?>

<html>
<head><title>Mail Survey Link</title>
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
         echo "Hi <font color='lightgreen'>".Session::get('suser')."</font>"; 
        ?>

                            <form action="" method=post><input type=submit name=logout value=Logout><div style=float:right><img src='../../images/Digiadmin_logo.jpg' height=50 width=150> </div> <center><h3><font color=red >Mail Link Admin Panel</font></h3></center>
    </div>
    

<center> <h1>Bulk eMail Sending(Unique Survey Link)</h1> 
<table border="0" cellpadding="0" cellspacing="0">
<form name=fe action="" enctype="multipart/form-data" method=post>
<tr><td>Emails from file(.csv):</td><td><input type=file name=ff>  <input type=submit name=fe value=Import></td></tr>
</form>
<form name=sm action="" method=post>
<tr><td>To:</td><td><textarea name=to class=tat rows=8 cols=100 placeholder='Enter emails separated by , (comma only)'><?php echo $str;?></textarea></td></tr>

<tr><td>Subject:</td><td><textarea class=tat name=sub rows=1 cols=100 placeholder='type subject here'></textarea></td></tr>
<tr><td>Project Details</td><td> Project: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <select name="pn" id="pn" onchange="displib2();"><option value="0">--select project--</option><?php $pj=get_projects_details();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select> <br> QuestionSet:  <select name="qset" id="qset" onchange="displib4();"><option value="select">--select qset--</option></select><br> Centre: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <select name="cn" id="cn"><option value="0">--select centre--</option><?php foreach($cn as $c){?><option value="<?php echo $c->centre_id;?>"><?php echo $c->cname;?></option><?php }?></select></td> </tr>
<tr><td>Include Link URL in Message</td><td><textarea class=tat name=url rows=2 cols=100 placeholder="https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/PreDemoCSS.php?qset=2&next=-1"></textarea></td></tr>
<tr><td>Generate Unique Respondent Link</td><td><input type=radio name=ul value=yes>Yes <input type=radio name=ul value=no checked>No</td></tr>
<tr><td>Message:</td><td><textarea class=tat name=msg rows=20 cols=100 placeholder='Type your massege here'></textarea></td></tr>
<tr><td>.</td><td> .</td></tr>
<tr><td> </td><td><input type=submit name=sendmail value="Send Mail"> <input type=submit name=prev value="Preview Message"></td> </tr>
</form>

</table>
</center>
</body>
</html>


<script>
    function displib2()
{
        var pin;
	if(window.XMLHttpRequest)
	{
		pin=new XMLHttpRequest();
	}
	else
	{
		pin= new ActiveXobject("Microsoft.XMLHTTP");
	}
	var val=document.getElementById('pn').value;
        //document.write('Hello: '+val);
	pin.onreadystatechange=function()
	{
		if(pin.readyState==4)
		{
			document.getElementById('qset').innerHTML=pin.responseText;
			console.log(pin);
		}
	}
	url="get_qset.php?pid="+val;
	pin.open("GET",url,true);
	pin.send();
}

function displib4()
{
        var pin;
	if(window.XMLHttpRequest)
	{
		pin=new XMLHttpRequest();
	}
	else
	{
		pin= new ActiveXobject("Microsoft.XMLHTTP");
	}
	var val=document.getElementById('qset').value;
        //document.write('Hello: '+val);
	pin.onreadystatechange=function()
	{
		if(pin.readyState==4)
		{
			document.getElementById('da').innerHTML=pin.responseText;
			console.log(pin);
		}
	}
	url="routine_list.php?qset="+val;
	pin.open("GET",url,true);
	pin.send();
}
</script>