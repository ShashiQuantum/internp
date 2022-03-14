<?php
ob_start();
include_once('../vcimsweb/init.php');

$qset=$_GET['q'];
$url="http://wwww.vareniacims.com/test/123.php?qset=$qset";
date_default_timezone_set("Asia/Kolkata");
?>
<html>
    <body>
	<table border="0" style="width:100%;height:100%;">
<!--
<tr><td style="width:100%;">
<td></td></tr>
<tr style="height:50%;width:100%"> 
-->
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
<!--
<tr style="height:2%;width:100%;background-color:green;"><td style="height:2%;width:100%;">
     <div id=header>
			<span style=float:right;color:#fff; font-size:50;> <?php echo strtoupper($pnn); ?> </span> 
                        <span style=float:left;><img src='http://vareniacims.com/public/img/logos/varenia_logow.png' height=50px width=150px> </span>
     </div>
</td></tr>
-->
<!--
        <h2><font color="red">PROJECT - <?php echo strtoupper($pnn); ?></font></h2>
-->
<!-- </td></tr> -->
<tr style="height:50%;"><td><center>
        <table border="0" cellpadding="20px" style="width:100%;height:100%;">
        <form action="" method="post" id="form_validation">
        <tr style=height:50px;color:black;><td></td><td>We would now be asking you some questions on your experience about food delivery apps. We would request your valuable time for the same.</td></tr>

        <tr style="height:10px;"><td>Gender <font color="red">* </font> </td><td><select name="gender" id="gender" required><option value=''>SELECT YOUR GENDER</option><option value=1>Male</option><option value=2>Female</option><option value=3>Prefer not to answer</option></select></td></tr>
        <tr style="height:10px;"><td>Age <font color="red">*</font> </td><td><select name="age" id="age" required><option value=''>SELECT YOUR AGE</option><option value=1>Below 18 years</option><option value=2> 18 - 25 years</option><option value=3>26 - 35 yrs</option><option value=4> 36 - 45 yrs</option><option value=5> 46 years or above</option><option value=6>Prefer not to answer</option></select></td></tr>
       	<tr style="height:10px;"><td>Occupation <font color="red">*</font> </td><td><select name="occ" id="occ" required><option value=''>SELECT YOUR OCCUPATION</option><option value=1>Working - Full Time</option><option value=2>Working - Part Time</option><option value=3>Student</option><option value=4>Not Working</option><option value=5>Home maker</option></select></td></tr>
	<tr style="height:10px;"><td>Highest Education Level <font color="red">*</font> </td><td><select name="edu" id="edu" required><option value=''>SELECT YOUR HIGHEST EDUCATION</option><option value=1>Schooling upto 12th </option><option value=2>Some college but not graduate </option><option value=3>Graduate / Post graduate (General courses like BA, MA, B.Sc. M.Sc. etc.)</option><option value=4>Grad/Post graduate (Professional courses like B.Tech, M.Tech, MBA etc.) </option></select>
      <?php 
              $dc1=DB::getInstance()->query("SELECT `centre_id`, `cname`, `address`, `contact_person`, `phone` FROM `centre` WHERE `centre_id` in (SELECT distinct `centre_id` FROM `centre_project_details` WHERE `q_id`=$qset)");
        ?>
	<tr><td>Select City<font color="red">*</font></td><td><select name='centre' id=="city" onchange="select(this.value);"  required><option value=''>SELECT YOUR CITY</option> <?php if($dc1->count()>0)foreach($dc1->results() as $d){ echo "<option value=$d->centre_id>$d->cname</option>";}?></option> <option value='-1'>Others</option></select> <div style="height:10px;width:100%;display:none;" id="oc"> <input type='text' name='city' size='40' id='ocity' placeholder='Enter your city if not in above list' onkeypress="return isNotNumber(event)"></div><span class='error'><p id='oc_error'></p></span> </td></tr>
       <!-- <tr  style="height:10px;width:100%;display:none;" id="oc"><td>Other City here <font color="red"> * </font> </td><td><input type="text" name="city" id="ocity" size="40" placeholder="Enter your city name" onkeypress="return isNumber(event)"> <span class="error"><p id="oc_error"></p></span></td></tr>
-->
      <!-- <tr><td>Language  </td><td><select name=lang disabled><option value='none' selected>English Only</option><option value=1>English-Hindi</option></select> </td></tr>
-->       
 <tr style=height:50px;color:lightgray;><td></td><td><input type="submit" name="subinfo" value="Next" style=background-color:#004c00;color:white;height:30px;></td></tr>

            </form>
        </table>
       

</tr>

<!--
<tr style="height:5%; background-color:gray;color:white;text-align:center;"><td>
<span class="copyright" style="font-size:11px;"> &copy; 2018 VareniaCIMS Private Limited. All Rights Reserved.</span>
</td></tr>
-->
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
     $centre=$_POST['centre'];
    //$fn=$_POST['fname'];
    $city=$_POST['city'];
    $age=$_POST['age'];
    $gen=$_POST['gender'];
    $occ=$_POST['occ'];
    $edu=$_POST['edu']; 
    //$lang=$_POST['lang'];
        $lang='none';

    if(($gen != '') &&($age!= '') && ($centre != '') && ($occ != '')  && ($edu!='') )
    {
	if( ($centre == '-1') && ($city == '') ){
		echo "<script type='text/javascript'>alert('Please Specify Other City Name to start survey!')</script>";
	}
	else{
		if($city=='') $city='NA';
         	$sql21="INSERT INTO respondent_web ( qset,status,starttime) VALUES ($qset,1,'$dt')";
                $data=DB::getInstance()->query($sql21);
                if($data)
                {   $project_id='';
                    $_SESSION['resp']=$data->last();
                     $resp_id=$_SESSION['resp'];
                     $_SESSION['lang']=$lang;

                	$date = date('Y/m/d H:i:s');
			$sqt = "INSERT INTO $table ( `q_id`,`resp_id`,`age`,`gender`, edu, occup, centre, city, st) VALUES 
			($qset,$resp_id,$age,$gen,$edu, $occ,$centre,'$city',0)";
                	$ds = DB::getInstance()->query($sqt);

                     	$newURL="http://www.vareniacims.com/test/2.php";
                    	header('Location: '.$newURL);
                }
                else    echo "<tr style='text-color:red;'><td>Please fill all details * to start this survey.</td></tr>";
       }

    }
    else {
        //echo "<font color=red>Please fill all detail * to start this survey.</font>";
echo "<script type='text/javascript'>alert('Please select all details like Gender, Age, Eucation, Occupation, & City to start survey!')</script>";
    }
}
?>

<script type="text/javascript">

   function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            alert("Please enter only Numbers.");
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
