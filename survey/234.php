<?php
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

<tr style="height:2%;width:100%;background-color:green;"><td style="height:2%;width:100%;">
     <div id=header>
			<span style=float:right;color:#fff; font-size:50;> <?php echo strtoupper($pnn); ?> </span> 
                        <span style=float:left;><img src='http://vareniacims.com/public/img/logos/varenia_logow.png' height=50px width=150px> </span>
     </div>
</td></tr>

<!--
        <h2><font color="red">PROJECT - <?php echo strtoupper($pnn); ?></font></h2>
-->
<!-- </td></tr> -->
<tr style="height:100%;"><td><center>
        <table border="0" cellpadding="5px" style="margin-left:5%;width:80%;height:100%;">
        <form action="" method="post" id="form_validation">
        <tr style=height:10px;color:black;><td></td><td> <p>Greetings. Varenia CIMS is a leading market research agency and is conducting a small survey amongst students like you to understand your career choices. We would now request you to please fill up a survey that follows.</p> </td></tr>
        <tr><td>Name <font color="red">* </font> </td><td><input type=text name="rname" placeholder="Enter your name" required></td></tr>
        <tr><td>Gender <font color="red">* </font> </td><td><select name="gender" id="gender" required><option value=''>SELECT YOUR GENDER</option><option value=1>Male</option><option value=2>Female</option><option value=3>Prefer not to answer</option></select></td></tr>
        <tr><td>DOB <font color="red">* </font> </td><td>
		<select name="dd" placeholder="DD" required>
		<option value=''> DD </option>
		<?php
			for($i=1; $i < 32 ; $i++){
                        	echo "<option> $i </option>";
                        }
		?>
		</select>
                <select name="mm" placeholder="MM" required>
                <option value=''> MM </option>
                <?php
                        for($m = 1; $m < 13; $m++ ){
                                echo "<option> $m </option>";
                        }
                ?>
                </select>
                <select name="yy" placeholder="YYYY" required>
                <option value=''> YYYY </option>
                <?php
                        for($y=1990;$y < 2019;$y++){
                                echo "<option> $y </option>";
                        }
                ?>
                </select>

	</td></tr>
        <tr><td>Age As On Now<font color="red">*</font> </td><td><input type=text name="age" id="age"> </td></tr>
       	<tr style="height:3px;"><td>Current Address <font color="red">*</font> </td><td><input type=text name="cadd" id="cadd" required></td></tr>
      <?php
              $dc1=DB::getInstance()->query("SELECT `centre_id`, `cname`, `address`, `contact_person`, `phone` FROM `centre` WHERE `centre_id` in (SELECT 
distinct `centre_id` FROM `centre_project_details` WHERE `q_id`=$qset)"); 

        ?>
	<tr><td>Select City<font color="red">*</font></td><td><select name='centre' id=="city" onchange="select(this.value);"  required><option value=''>SELECT YOUR CITY</option> <?php if($dc1->count()>0)foreach($dc1->results() as $d){ echo "<option value=$d->centre_id>$d->cname</option>";}?></option> <option value='-1'>Others</option></select> <div style="height:10%;width:100%;display:none;" id="oc"> <input type='text' name='city' size='40' id='ocity' placeholder='Enter your city if not in above list' onkeypress="return isNotNumber(event)"></div><span class='error'><p id='oc_error'></p></span> </td></tr>

	<tr style="height:3px;"><td>Parmanent Address <font color="red">*</font> </td><td><input type=text name="padd" id="padd" required></td></tr>
     <?php
              $dc1=DB::getInstance()->query("SELECT `centre_id`, `cname`, `address`, `contact_person`, `phone` FROM `centre` WHERE `centre_id` in (SELECT
distinct `centre_id` FROM `centre_project_details` WHERE `q_id`=$qset)");

        ?>
	<tr><td>Select City<font color="red">*</font></td><td><select name='centre2' id=="city2" onchange="select2(this.value);"  required><option value=''>SELECT YOUR CITY</option> <?php if($dc1->count()>0)foreach($dc1->results() as $d){ echo "<option value=$d->centre_id>$d->cname</option>";}?></option> <option value='-1'>Others</option></select> <div style="height:10px;width:100%;display:none;" id="oc2"> <input type='text' name='city2' size='40' id='ocity2' placeholder='Enter your city if not in above list' onkeypress="return isNotNumber(event)"></div><span class='error'><p id='oc_error2'></p></span> </td></tr>

       <tr><td>How long have you been living in the current city of residence?  </td><td><select name="duration" required><option value=''>Select duration of current city residence</option> <option value=1>Less than 1 year </option><option value=2> 1 year or more </option></select> </td></tr>

        <tr><td>Mobile <font color="red">*</font> </td><td><input type="text" size="20" maxlength=10 minlength=10 name="mobile" placeholder='Your Mobile Number' onkeypress="return isNumber(event)"></td></tr>
        <tr><td>Email <font color="red">*</font> </td><td><input type=email name="email" id="email" required placeholder='Your email'></td></tr>

 <tr style=height:50px;color:lightgray;><td></td><td><input type="submit" name="subinfo" value="Next" style=background-color:#004c00;color:white;height:30px;></td></tr>

            </form>
        </table>
       

</tr>


<tr style="height:15%; background-color:gray;color:white;text-align:center;"><td>
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
     $centre=$_POST['centre'];
     $centre2=$_POST['centre2'];

    $fn=$_POST['rname'];
    $city=$_POST['city'];
    $cadd=$_POST['cadd'];
    $padd=$_POST['padd'];
    $gen=$_POST['gender'];
    $dd = $_POST['dd'];
    $mm = $_POST['mm'];
    $yy = $_POST['yy'];

    $pcity = $_POST['city2'];
    $du = $_POST['duration'];
    $mb = $_POST['mobile'];
    $em = $_POST['email'];

$date = new DateTime($yy.'-'.$mm.'-'.$dd);
$dob = $date->format('Y-m-d');
//echo $today=date("Y-m-d");
//$today=date_create('2018-10-25');
$yrs = (date('Y') - date('Y',strtotime($dob)));

//echo "<br>$diff : yrs : $yrs";
//echo $yrs->format("Total number of days: %a.");
    //$lang=$_POST['lang'];
        $lang='none';

    if(($gen != '') && ($centre != '') )
    {
	if( ($centre == '-1') && ($city == '') ){
		echo "<script type='text/javascript'>alert('Please Specify Other City Name to start survey!')</script>";
	}
	else{
		if($city=='') $city='NA';
		if($pcity=='') $pcity='NA';
         	$sql21="INSERT INTO respondent_web ( qset,r_name,mobile,status,starttime) VALUES ($qset,'$fn','$mb',1,'$dt')";
                $data=DB::getInstance()->query($sql21);
                if($data)
                {   $project_id='';
                    $_SESSION['resp']=$data->last();
                     $resp_id=$_SESSION['resp'];
                     $_SESSION['lang']=$lang;

                	$date = date('Y/m/d H:i:s');
			echo $sqt = "INSERT INTO $table ( `q_id`,`resp_id`,r_name,mobile,`gender`, address, padd, centre,centre2, city,pcity,dob,age_yrs,email,duration, st) VALUES 
			($qset,$resp_id,'$fn','$mb',$gen,'$cadd', '$padd',$centre,$centre2,'$city','$pcity','$dob',$yrs,'$em',$du,0)";
                	$ds = DB::getInstance()->query($sqt);

                     	$newURL="http://localhost/digiamin-web/test/2.php";
                    	//header('Location: '.$newURL);
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

function select2(selId)
{
        if(selId=='-1')
        {
                //$('#oc').show('fast');
   var x = document.getElementById('oc2');
    if (x.style.display === 'none') {
        x.style.display = 'block';
    } else {
        //x.style.display = 'none';
    }

        //form validate start
        document.getElementById("form_validation").onsubmit = function ()
        {
    var c = document.forms["form_validation"]["ocity2"].value;
    var submit = true;
        if (c == null || c == "")
        {
                cityError = "<span style='color:red;'>*Specify the other city name</span>";
                document.getElementById("oc_error2").innerHTML = cityError;
                submit = false;
        }
        return submit;
        }
        //validate end
        }
        else
        {
                //$('#oc').hide('fast');
        var x = document.getElementById('oc2');
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

