<?php
include_once('../public_html/vcimsweb/init.php');

//$qset=$_GET['qset'];
$url="http://wwww.digiadmin.quantumcs.com/test/111.php?qset=$qset";
date_default_timezone_set("Asia/Kolkata");
?>
<html>
    <body>
     <div id=header>
                            <p style=float:right><img src='https://digiadmin.quantumcs.com/public/img/logos/quantum-logo-big.png' height=50 width=150> </p><br><br><br><br>
     </div> 
    <center>
<?php
//$qset=$_GET['qset'];
//$_SESSION['qset']=$qset;
$qset=$_SESSION['qset'];
$_SESSION['sid']=0;
$_SESSION_['pqt'] = 'first';
$pid='';
$table='';
$pnn='';
$sq="SELECT `name`, data_table FROM `project` WHERE `project_id`=(SELECT distinct `project_id` FROM `questionset` WHERE `qset_id`=$qset)";
$qd = DB::getInstance()->query($sq);
if($qd->count()>0)
{
	$pnn=$qd->first()->name;
	$table=$qd->first()->data_table;
	$_SESSION['table'] = $table;
}

$qa=DB::getInstance()->query("SELECT max(sid) as ms FROM `question_sequence` WHERE `qset_id`=$qset");
if($qa->count()>0)
{
       $_SESSION['maxsid'] = $maxsid = $qa->first()->ms;
}
?>
        <h2><font color="red">PROJECT - <?php echo strtoupper($pnn); ?></font></h2>
        <br>
        <table>
        <form action="" method="post">
        <tr style=height:50px;color:lightgray;><td></td><td>Personal Details</td></tr>
        <tr><td>Respondent Name <font color="red">*</font> </td><td><input type="text" name="fname" size="40"></td></tr>
        <tr><td>Respondent Address  </td><td><input type="text" name="address" size="40"></td></tr>
        <tr><td>Respondent Mobile<font color="red">*</font> </td><td><input type="text" size="40" maxlength=10 minlength=10 name="mobile" onkeypress="return isNumber(event)"></td></tr>
        <tr><td>Interviewer Name  </td><td><input type="text" name="iname" size="40"></td></tr>
        <tr><td>Interviewer Mobile<font color="red">*</font> </td><td><input type="text" size="40" maxlength=10 minlength=10 name="imobile" onkeypress="return isNumber(event)"></td></tr>

        <tr><td>Gender <font color="red">*</font> </td><td><select name="gender"><option value=1>Male</option><option value=2>Female</option> </select></td></tr>
        <tr><td>SEC<font color="red">*</font> </td><td><select name="sec"><option value=1>A</option><option value=2>B</option></select></td></tr>
        <tr><td>Age<font color="red">*</font> </td><td><select name="age"><option value=1> 18 - 25 yrs</option><option value=2>26 - 35 yrs</option></select></td></tr>
        <tr><td>Age in year</td><td><input type=text name="age_yrs"> </td></tr>
        <tr><td>Form Number </td><td><input type=text name="refno"> </td></tr>

      <?php 
              $dc1=DB::getInstance()->query("SELECT `centre_id`, `cname`, `address`, `contact_person`, `phone` FROM `centre` WHERE `centre_id` in (SELECT distinct `centre_id` FROM `centre_project_details` WHERE `q_id`=$qset)");
                   
                     
        ?>
        <tr><td>Centre<font color="red">*</font></td><td><select name='centre'><?php if($dc1->count()>0)foreach($dc1->results() as $d){ echo "<option value=$d->centre_id>$d->cname</option>";}?></option></select> </td></tr>
        <tr><td> </td><td><select name=lang hidden><option value='none'>English </option></select> </td></tr>
        <tr style=height:50px;color:lightgray;><td></td><td><input type="submit" name="subinfo" values="Submit" style=background-color:#004c00;color:white;height:30px;></td></tr>

            </form>
        </table>
       
    </body>
</html>


<?php



//$qset=2;
$qset=$_GET['qset'];
$pid='';
$ddd=DB::getInstance()->query("SELECT distinct `project_id` FROM `questionset` WHERE `qset_id`=$qset");

if($ddd->count()>0)
  {  $pid=$ddd->first()->project_id;}

if(isset($_POST['subinfo']))
{
    $qset=$_GET['qset'];
    $fn=$_POST['fname'];
    $add=$_POST['address'];
    $mob=$_POST['mobile'];
    $cn=$_POST['centre'];
    $iname=$_POST['iname'];
    $imobile=$_POST['imobile'];
    $age=$_POST['age'];
     $age_yrs=$_POST['age_yrs'];
    $gen=$_POST['gender'];
    $sec=$_POST['sec'];
    $refno=$_POST['refno'];
    $lang=$_POST['lang'];
        
    if(($fn!='') && ($mob!='') )
    { 
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
			$newURL="https://www.digiadmin.quantumcs.com/test/222.php?next=-1";
                     	header('Location: '.$newURL);
            }
        }
        else {
         	$sql21="INSERT INTO respondent_web ( qset,`r_name`,`mobile`, status) VALUES ($qset,'$fn','$mob',1)";
                $data=DB::getInstance()->query($sql21);
                if($data)
                {   $project_id='';
                    $_SESSION['resp']=$data->last();
                     $resp_id=$_SESSION['resp'];
                     $_SESSION['lang']=$lang;

                	$date = date('Y/m/d H:i:s');
			$sqt = "INSERT INTO $table ( `q_id`,`resp_id`,`r_name`,mobile,i_name, i_mobile,`age`, `gender`, `o_sec`,`age_yrs`,ref_no, st) VALUES ($qset,$resp_id,'$fn','$mob','$iname','$imobile', '$age','$gen','$sec','$age_yrs','$refno',0)";
                	$ds = DB::getInstance()->query($sqt);

                     	$newURL="https://www.digiadmin.quantumcs.com/test/222.php?next=-1";
                    	header('Location: '.$newURL);
                }
                else    echo "<font color='red'>Please re-fill your Name,  Centre and Mobile ,etc to start this survey.</font>";
              } 
    }
    else {
        echo "Please fill your Name, Centre and Mobile to start this survey.";
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


