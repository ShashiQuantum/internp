<?php
include_once('../vcimsweb/init.php');

$qset=$_GET['q'];
date_default_timezone_set("Asia/Kolkata");
?>
<html>
    <body style="font-family: 'Source Sans Pro', sans-serif;font-size: 1.375em;">
	<table border="0" style="width:100%;height:100%;">
<?php

$_SESSION['qset']=$qset;
$_SESSION['sid']=0;
$_SESSION_['pqt'] = 'first';
$_SESSION['pqstack']=array();
$pid='';
$table='';
$pnn='';
$dt = date('Y/m/d H:i:s');
$sq="SELECT `name`, data_table, survey_start_date, survey_end_date FROM `project` WHERE `project_id`=(SELECT distinct `project_id` FROM `questionset` WHERE `qset_id`=$qset)";
$qd = DB::getInstance()->query($sq);
if($qd->count()>0)
{
	$pnn=$qd->first()->name;
	$table=$qd->first()->data_table;
	$sdt=$qd->first()->survey_start_date;
	$edt=$qd->first()->survey_end_date;
	$_SESSION['table'] = $table;
	$_SESSION['pn'] = $pnn;
}
			$qa=DB::getInstance()->query("SELECT max(sid) as ms FROM `question_sequence` WHERE `qset_id`=$qset");
			if($qa->count()>0)
			{
				 $maxsid=$qa->first()->ms;
				 $_SESSION['maxsid']=$maxsid;
			} 
?>
 
<tr style="height:2%;width:100%;background-color:green;"><td style="height:2%;width:100%;">
     <div id=header>
			<span style=float:right;color:#fff; font-size:50;> 
				<?php 
					//echo strtoupper($pnn); 
				?> 
			</span> 
                        <span style=float:left;><img src='https://vareniacims.com/public/img/logos/varenia_logow.png' height=50px width=150px> </span>
     </div>
</td></tr>
 
<!--
        <h2><font color="red">PROJECT - <?php echo strtoupper($pnn); ?></font></h2>
-->
<!-- </td></tr> -->
<tr style="height:10%;"><td><center>
        <table border="0" cellpadding="3px" style="margin-left:5%;width:80%;height:100%;">
        <form action="" method="post" id="form_validation">
        <tr style=height:50px;color:black;><td></td><td>Greetings. Varenia CIMS is a leading market research agency and is conducting a small survey amongst students like you to understand your career choices. We would now request you to please fill up a survey that follows.</td></tr>
        <tr><td style="width:100px;">Name <font color="red">* </font> </td><td><input type=text name=rname onkeypress="return isNotNumber(event);" placeholder="Enter your name" required></td></tr>
        <tr><td style="width:100px;">Gender <font color="red">* </font> </td><td><select name="gender" id="gender" required><option value=''>SELECT YOUR GENDER</option><option value=1>Male</option><option value=2>Female</option></select></td></tr>
 <tr style='height:50px;color:lightgray;'><td></td><td><input type="submit" name="subinfo" value="Next" style=background-color:#004c00;color:white;height:30px;></td></tr>

            </form>
        </table>
       

</tr>

 
<tr style="height:5%; background-color:gray;color:white;text-align:center;"><td>
<span class="copyright" style="font-size:11px;"> &copy; 2018 VareniaCIMS Private Limited. All Rights Reserved.</span>
</td></tr>
 
</table>

    </body>
</html>


<?php



//$qset=2;
//$qset=$_GET['qset'];
$pid='';
$ddd=DB::getInstance()->query("SELECT distinct `project_id` FROM `questionset` WHERE `qset_id`=$qset");

if($ddd->count()>0)
  {  $pid=$ddd->first()->project_id;}

if(isset($_POST['subinfo']))
{
     
    $fn=$_POST['rname'];
    $gen=$_POST['gender'];
    
    /*
    $centre=$_POST['centre'];
    $city=$_POST['city'];
    $age=$_POST['age'];
    $occ=$_POST['occ'];
    $edu=$_POST['edu']; 
    */
    //$lang=$_POST['lang'];
        $lang='none';

    if(($fn != '') &&($gen!= '')  )
    {
echo "Survey Expired! No more such survey is active.";
/*
         	$sql21="INSERT INTO respondent_web ( qset,r_name,status,starttime) VALUES ($qset,'$fn',1,'$dt')";
                $data=DB::getInstance()->query($sql21);
                if($data)
                {   $project_id='';
                    $_SESSION['resp']=$data->last();
                     $resp_id=$_SESSION['resp'];
                     $_SESSION['lang']=$lang;

                	$date = date('Y/m/d H:i:s');
			$sqt = "INSERT INTO $table ( `q_id`,`resp_id`,r_name, `gender`, st) VALUES 
			($qset,$resp_id,'$fn',$gen,0)";
                	$ds = DB::getInstance()->query($sqt);
			
			//$newURL="https://www.vareniacims.com/survey/fpn.php";
                     	//if($qset==234) $newURL="https://www.vareniacims.com/survey/fpn_234.php";
                        //if($qset==237) $newURL="https://www.vareniacims.com/survey/fpn_237.php";
                    	//header('Location: '.$newURL);
                }
                else    echo "<tr style='text-color:red;'><td>Please fill all details * to start this survey.</td></tr>";
*/
    }
    else {
        //echo "<font color=red>Please fill all detail * to start this survey.</font>";
	//echo "<script type='text/javascript'>alert('Please select all details like Gender, Age, Eucation, Occupation, & City to start survey!')</script>";
    }
}
?>

<script type="text/javascript">

   function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            //alert("Please enter only Numbers.");
            return false;
        }

        return true;
    }

   function isNotNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return true;
        }

        return false;
    }
</script>


<script>
function select(selId)
{
	if(selId=='-1')
	{
		//$('#oc').show('fast');
   var x = document.getElementById('oc');
    if (x.style.display === 'none') {
        x.style.display = 'block';
    } else {
        //x.style.display = 'none';
    }
		
	//form validate start
	document.getElementById("form_validation").onsubmit = function () 
	{
    var c = document.forms["form_validation"]["ocity"].value;

    var submit = true;

    if (c == null || c == "")
	{
        cityError = "<span style='color:red;'>*Specify the other city name</span>";
        document.getElementById("oc_error").innerHTML = cityError;
        submit = false;
    }
	
    return submit;
	}
	//validate end
		
	}
	
	else
	{
		//$('#oc').hide('fast');
	var x = document.getElementById('oc');
    if (x.style.display === 'none') {
        //x.style.display = 'block';
    } else {
        x.style.display = 'none';
    }
	document.getElementById("form_validation").onsubmit = function () 
            {
                        
                                    return true;
            }

	}
}
</script>

