<?php
ob_start();
// error_reporting(0);
// ini_set('display_errors', 'Off');
// ini_set('display_errors', 0);
include_once('../vcimsweb/init.php');
include_once('../vcimsweb/functions.php');

date_default_timezone_set("Asia/Kolkata");
$qset = $_GET['q'];
?>
<html>

<style>
.mtbl{
	background-color:#f2f2f2;
	border:none;
	border-collapse:collapse;
	border-spacing:0;
	width:100%;

}
.tbl_1{
	border:none;
	border-collapse:collapse;
	border-spacing:0;
	max-width:700px;
	width:100%
}
.tbl_1_td{
	background-color: #094041;
	color: #fff;
	text-align: left;
	padding: 5px;

}
.tbl2_td{
	background-color: #094041;
	color: #fff;
	height: 30px;
	text-align: left;
	padding: 2px;
}
.tbl_dcolor{
	background-color: #094041;
	color: #fff; padding: 5px;
}
.tbl_lcolor{
	background-color: #e5e5e5;
	padding: 5px;
}
</style>

    <body>
	
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mtbl" bgcolor="#f2f2f2"><tbody><tr><td align="center">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tbl_1">

<tr><td class="tbl_1_td" align="center">

<table border="0" >
<tr><td class="tbl2_td" align="center">
<span style="padding: 15px;">
<!--<img src="https://vareniacims.com/siteadmin/public/img/logos/varenia_logo2.png" style="height:100px; width:160px;padding: 15px; ">-->
<img src="http://localhost/quantumdigiadmin/public/img/logos/quantum-logo-big.png" width="80px" height="80px">
</span>
</td><td class="tbl2_td" align="center">
<span style="padding: 15px;">
<h2>Greetings from Quantum</h2>

</span>
</td></tr></table>

</td></tr>

<tr><td style="background-color: #fff; color: #094041; padding: 15px;" align="center"> <h1>Share your feedback! </h1></td></tr>
<tr><td style="background-color: #fff; color: #094041;" align="center"> Your inputs are invaluable and will help us to improve products and services. We truly appreciate your time and feedback. </td></tr>
<tr><td style="background-color: #fff; color: #094041; padding: 15px;" align="center"> <br></td></tr>

<?php

$_SESSION['qset']=$qset;
$_SESSION['sid']=0;
$_SESSION_['pqt'] = 'first';
$_SESSION['pqstack']=array();
$maxsid=0;
$pid='';
$table='';
$pnn='';
$dt = date('Y/m/d H:i:s');
$sq="SELECT project_id,`name`, data_table, survey_start_date, survey_end_date FROM `project` WHERE `project_id`=(SELECT distinct `project_id` FROM `questionset` WHERE `qset_id` = $qset)";
$qd = DB::getInstance()->query($sq);


if($qd->count()>0)
{
	$pnn=$qd->first()->name;
	$table=$qd->first()->data_table;
	$sdt=$qd->first()->survey_start_date;
	$edt=$qd->first()->survey_end_date;
	$pid = $qd->first()->project_id;
	$_SESSION['table'] = $table;
	$_SESSION['pn'] = $pnn;
}

			$qa=DB::getInstance()->query("SELECT max(sid) as ms FROM `question_sequence` WHERE `qset_id`=$qset");
			if($qa->count()>0)
			{
				 $maxsid=$qa->first()->ms;
				 $_SESSION['maxsid']=$maxsid;
			} 

$fpdata= get_survey_fp($pid);

//print_r($fpdata);

?>
<!--
<tr style="height:2%;width:100%;background-color:green;position:top;"><td style="height:2%;width:100%;">
     <div id=header>
			<span style=float:right;color:#fff; font-size:50;> <?php echo strtoupper($pnn); ?> </span>
                        <span style=float:left;><img src='https://www.vareniacims.com/siteadmin/public/img/logos/varenia_logo2.png' height=50px width=150px> </span>
     </div>
</td></tr>


        <h2><font color="red">PROJECT - <?php echo strtoupper($pnn); ?></font></h2>
-->
<!-- </td></tr> -->

<tr><td style="background-color: #fff; color: #094041; padding: 15px;" align="center">
        <table border="0" cellpadding="1" cellspacing="1">
        
        
        
        
        <form method="POST" action="">
                

<?php
//echo "<br> qset: $qset";

	if($fpdata){
               // var_dump($fpdata);
	foreach($fpdata as $fp){
		//print_r($fp);
		$fpid = $fp['fpid'];
?>
<?php
	if($fpid == 1){
?>
        <tr > <td class="tbl_dcolor" style="width: 50%;">Respondent Name <font color="red">*</font> </td><td class="tbl_lcolor"><input type="text" name="fname" placeholder="Enter your name here" size="40" required></td></tr>

<?php
	}
        if($fpid == 2){
?>
        <tr><td class="tbl_dcolor">Respondent Address  </td><td class="tbl_lcolor"><input type="text" name="address" size="40"></td></tr>
<?php
        }
        if($fpid == 3){
?>
        <tr><td class="tbl_dcolor">Respondent Mobile<font color="red" required>*</font> </td><td class="tbl_lcolor"><input type="text" size="40" maxlength=10 minlength=10 name="mobile" onkeypress="return isNumber(event)" required></td></tr>
<?php
        }
        if($fpid == 4){
?>
        <tr><td class="tbl_dcolor">Interviewer Name  </td><td class="tbl_lcolor"><input type="text" name="iname" size="40" required></td></tr>
<?php
        }
        if($fpid == 5){
?>
        <tr><td>Interviewer Mobile<font color="red">*</font> </td><td><input type="text" size="40" maxlength=10 minlength=10 name="imobile" onkeypress="return isNumber(event)" required></td></tr>
<?php
        }
        if($fpid == 6){
?>
        <tr><td class="tbl_dcolor">Gender <font color="red">*</font> </td><td class="tbl_lcolor"><select name="gender" required><option value=''>Select Gender</option> <option value=1>Male</option> <option value=2>Female</option> </select></td></tr>
<?php
        }
        if($fpid == 9 || $fpid ==10){
?>
        <tr><td class="tbl_dcolor">SEC<font color="red">*</font> </td>
        <td class="tbl_lcolor"><select name="sec" required><option value=''>Select SEC</option>
<?php
                                $sql7="SELECT * from project_sec_map WHERE qset=$pid ;";
                                $dq7=DB::getInstance()->query($sql7);
                                if($dq7->count()>0)
                                foreach($dq7->results() as $r7){
                                        $at=$r7->sec;
                                        $av=$r7->valuee;
                                       echo "<option value= $av > $at </option>";
                                }
		echo "</select></td></tr>";
        }
        if($fpid == 7){
?>
        <tr><td class="tbl_dcolor">Age<font color="red">*</font> </td><td class="tbl_lcolor"><select name="age" requireed><option value=''>Select Age Range</option>
<?php
                                $sql7="SELECT * from project_age_map WHERE qset=$pid ;";
                                $dq7=DB::getInstance()->query($sql7);
                                if($dq7->count()>0)
                                foreach($dq7->results() as $r7){
                                        $at=$r7->age;
                                        $av=$r7->valuee;
                                       echo "<option value= $av > $at </option>";
                                }
                echo "</select></td></tr>";

        }
        if($fpid == 8){
?>
        <tr><td class="tbl_dcolor">Age in year</td><td class="tbl_lcolor"> <input type=text name="age_yrs" required> </td></tr>
<?php
        }
        if($fpid == 17){
?>
        <tr><td class="tbl_dcolor">Form Number </td><td class="tbl_lcolor"><input type=text name="refno" required> </td></tr>
<?php
        }
        if($fpid == 11){
?>
	<tr><td class="tbl_dcolor">Store<font color="red">*</font> </td>
        <td class="tbl_lcolor"><select name="store" required><option value=''>Select Store</option>

<?php
                                $sql7="SELECT * from project_store_loc_map WHERE qset_id=$pid ;";
                                $dq7=DB::getInstance()->query($sql7);
                                if($dq7->count()>0)
                                foreach($dq7->results() as $r7){
                                        $at=$r7->store;
                                        $av=$r7->valuee;
                                       echo "<option value= $av > $at </option>";
                                }
                echo "</select></td></tr>";

        }
        if($fpid == 12){
?>
        <tr><td class="tbl_dcolor">Product<font color="red">*</font> </td><td class="tbl_lcolor"><select name="product" required><option value=''>Select Product</option>
<?php
                                $sql7="SELECT * from project_product_map WHERE qset_id=$pid ;";
                                $dq7=DB::getInstance()->query($sql7);
                                if($dq7->count()>0)
                                foreach($dq7->results() as $r7){
                                        $at=$r7->product;
                                        $av=$r7->valuee;
                                       echo "<option value= $av > $at </option>";
                                }
                echo "</select></td></tr>";

        }
        if($fpid == 13){
              $dc1=DB::getInstance()->query("SELECT `centre_id`, `cname`, `address`, `contact_person`, `phone` FROM `centre` WHERE `centre_id` in (SELECT distinct `centre_id` FROM `centre_project_details` WHERE `q_id`=$qset)");
        ?>
        <tr><td class="tbl_dcolor">Centre<font color="red">*</font></td><td class="tbl_lcolor"><select name='centre' required><option value=''>Select Centre</option><?php if($dc1->count()>0)foreach($dc1->results() as $d){ echo "<option value=$d->centre_id>$d->cname</option>";}?></option></select> </td></tr>
<?php
        }
        if($fpid == 14){
?>
        <tr><td class="tbl_dcolor">Area of Centre <font color="red">*</font> </td><td class="tbl_lcolor"><select name="carea"><option value=1>1</option></select></td></tr>";
<?php
        }
        if($fpid == 15){
?>
        <tr><td class="tbl_dcolor">Sub-Area of Centre <font color="red">*</font> </td><td class="tbl_lcolor"><select name="csubarea"><option value=1>1</option></select></td></tr>";

<?php
	}
 } //end of foreach

?>
	<!-- -->
        <tr><td class="tbl_dcolor">Preferred Language </td><td class="tbl_lcolor"><select name=lang ><option value='none'>English Only</option>
	<!-- option value=1>Hindi-English</option -->
	</select> </td></tr>
	<!-- -->
        <tr><td></td><td><br>
        <input type="submit" name="subinfo" value="Start Survey " style="background-color:#004c00;color:white;height:30px;"></td></tr>

 </form> 


        </table>
<br><br><br><br><br><br><br><br><br><br><br><br><br>
</td>
</tr>
<?php
// end of if $fpdata
}
$dty = date('Y');

?>

<tr><td style="background-color: #e5e5e5; color: gray; padding: 15px;" align="center">
<span class="copyright" style="font-size:12px;"> &copy; <?= date('Y');?> Quantum CS Limited. All Rights Reserved.</span>
</td></tr></table>
</table>
    </body>
</html>


<?php

if(isset($_POST['subinfo']))
{

    $fn='';$add='';$mob='';$cn='';$iname='';$imobile='';$age='';$age_yrs='';$gen='';$sec='';$product='';$store='';$refno='';$lang='';
	$arr_t=array(); $arr_v=array();
	$fpt='';$fpv='';
	//print_r($fpdata);
    if($fpdata){
     foreach($fpdata as $fp){
        $fpid = $fp['fpid'];
        if($fpid == 1){ $fn=$_POST['fname']; $fpt = $fp['term']; array_push($arr_t,$fpt);array_push($arr_v,$fn);}
    	if($fpid == 2){ $add=$_POST['address'];$fpt = $fp['term']; array_push($arr_t,$fpt);array_push($arr_v,$add);}
    	if($fpid == 3){$mob=$_POST['mobile']; $fpt = $fp['term']; array_push($arr_t,$fpt);array_push($arr_v,$mob);}
    	if($fpid == 13){$cn=$_POST['centre'];$fpt = $fp['term']; array_push($arr_t,$fpt);array_push($arr_v,$cn);}
    	if($fpid == 4){$iname=$_POST['iname']; $fpt = $fp['term']; array_push($arr_t,$fpt);array_push($arr_v,$iname);}
    	if($fpid == 5){$imobile=$_POST['imobile'];$fpt = $fp['term']; array_push($arr_t,$fpt);array_push($arr_v,$imobile);}
    	if($fpid == 7){$age=$_POST['age'];$fpt = $fp['term']; array_push($arr_t,$fpt);array_push($arr_v,$age);}
    	if($fpid == 8){$age_yrs=$_POST['age_yrs'];$fpt = $fp['term']; array_push($arr_t,$fpt);array_push($arr_v,$age_yrs);}
    	if($fpid == 6){ $gen=$_POST['gender']; $fpt = $fp['term']; array_push($arr_t,$fpt);array_push($arr_v,$gen);}
    	if($fpid == 9 || $fpid == 10){$sec=$_POST['sec']; $fpt = $fp['term']; array_push($arr_t,$fpt);array_push($arr_v,$sec);}
    	if($fpid == 11){$product=$_POST['product']; $fpt = $fp['term']; array_push($arr_t,$fpt);array_push($arr_v,$product);}
    	if($fpid == 12){$store=$_POST['store']; $fpt = $fp['term']; array_push($arr_t,$fpt);array_push($arr_v,$store);}
    	if($fpid == 17){$refno=$_POST['refno']; $fpt = $fp['term']; array_push($arr_t,$fpt);array_push($arr_v,$refno);}
      }
    }
	//print_r($arr_v);
	$fpt= implode(', ',$arr_t);
	$fpv= implode("', '",$arr_v);
   // $lang='none';
    $lang=$_POST['lang'];
    if( $fn!='' )
    {
	/* 
        $sql="select resp_id, mobile FROM respondent_web WHERE qset = $qset and r_name = '$fn' AND  `mobile` = '$mob'";
        $da=DB::getInstance()->query($sql);
        if($da->count()>0)
        {
            if($da->first()->status==2)
            {
                echo '<br><font color="red">Your survey has submitted once successfully, So you could not participated again</font>';
            }
            else if($da->first()->status==0 || $da->first()->status==1)
            {
                 $_SESSION['resp']=$da->first()->resp_id;
                 $_SESSION['lang']=$lang;
                 echo $resp_id=$_SESSION['resp'];
			$newURL="https://www.vareniacims.com/survey/fpn.php";
			if($qset == 234) $newURL="https://www.vareniacims.com/survey/fpn_234.php";
                     	header('Location: '.$newURL);
            }
        }
        else {
        */
		$dt = date('Y/m/d H:i:s');
	 	$sql21="INSERT INTO respondent_web ( qset,`r_name`,`mobile`,starttime, status) VALUES ($qset,'$fn','$mob', '$dt', 1)";
                $data=DB::getInstance()->query($sql21);
                if($data)
                {   

			$project_id='';
                    	$_SESSION['resp']=$data->last();
                     	$resp_id=$_SESSION['resp'];
                     	$_SESSION['lang']=$lang;
						

                	$date = date('Y/m/d H:i:s');
			$sqt = "INSERT INTO $table ( `q_id`,`resp_id`, st , $fpt ) VALUES ($qset,$resp_id,0, '$fpv')";
                        
                	$ds = DB::getInstance()->query($sqt);
                       
                     	$newURL="http://localhost/quantumdigiadmin/survey/fpn.php?resp=$resp_id&lang=$lang&qset=$qset&sid=0&table=$table&maxsid=$maxsid";
			if($qset == 234) $newURL="http://localhost/quantumdigiadmin/survey/fpn_234.php";

                    	header('Location: '.$newURL);
                }
                //else    echo "<font color='red'>Please re-fill your Name,  Centre and Mobile ,etc to start this survey.</font>";
              //} 
    }
    else {
        echo "Please fill your details to start this survey.";
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
</script>



