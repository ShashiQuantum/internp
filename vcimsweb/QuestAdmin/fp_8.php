<?php

include_once('../init.php');


$qset=$_GET['qset'];
$url="http://wwww.digiadmin.quantumcs.com/vcims/QuestAdmin/fp_8.php?qset=$qset";
date_default_timezone_set("Asia/Kolkata");

//echo date('Y-m-d h:i:s');
//$yn=$_GET['yn'];

$yn=0;

  if($yn==1) 
{
    echo "<div id=header>";
                           echo " <p style=float:right><img src='../../images/Digiadmin_logo.jpg' height=50 width=150> </p><br><br><br><br>";
    echo  "</div>";                       
    echo "<center>";

    echo 'Hi, We are going to conduct the survey on xxx product where your feedback is important for the product quality improvement.';
    echo "<br><a href='https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/fp.php?qset=$qset&yn=0'> continue</a>";
    
    echo "</center>";
}
else
{
?>


<html>
    <body>
     <div id=header>
                            <p style=float:right><img src='../../images/Digiadmin_logo.jpg' height=50 width=150> </p><br><br><br><br>
     </div>                       
    <center>
        <h1><font color="red">PROJECT - SUN FLOWER</font></h1>
        <br>
        <table>
            <form action="" method="post">
            <tr style=height:50px;color:lightgray;><td></td><td>Personal Details</td></tr>
        <tr><td>Full Name <font color="red">*</font> </td><td><input type="text" name="fname" size="40"></td></tr>
        <tr><td>Present Address  </td><td><input type="text" name="address" size="40"></td></tr>
        <tr><td>e-Mail<font color="red"></font></td><td><input type="email" name="email" size="40"></td></tr>
        <tr><td>Mobile<font color="red">*</font> </td><td><input type="text" size="40" maxlength=10 minlength=10 name="mobile" onkeypress="return isNumber(event)"></td></tr>
        
        <tr><td>Gender <font color="red">*</font> </td><td><select name="gender"><option value=1>Male</option><option value=2>Female</option> </select></td></tr>
        <tr><td>SEC<font color="red">*</font> </td><td><select name="sec"><option value=1>A</option><option value=2>B</option><option value=3>C</option><option value=4>D</option><option value=5>E</option></select></td></tr>
        <tr><td>Age<font color="red">*</font> </td><td><select name="age"><option value=1> Less than 18 yrs</option><option value=2>18-22 yrs</option><option value=3>23-27 yrs</option><option value=4>Above 27 yrs</option> </select></td></tr>     
       <tr><td>Age in Year </td><td><input type=text name="age_yrs"></td></tr> 
        <tr><td>Interview day<font color="red">*</font> </td><td><select name="category"><option value=1>Monday</option><option value=2>Tuesday</option><option value=3>Wednesday</option><option value=4>Thursday</option><option value=5>Friday</option><option value=6>Saturday</option><option value=7>Sunday</option> </select></td></tr>
         
         
        <tr><td>Respondent Type <font color="red">*</font> </td><td><select name="resp_type"><option value=1>Student </option><option value=2> Working</option></select></td></tr>

        <tr style=height:50px;color:lightgray;><td></td><td>Reference Details</td></tr>
        <tr><td>MAC Email ID <font color="red"></font></td><td><input type="email" name="macemail" size="40"></td></tr>
        <tr><td>Reference ID <font color="red"></font></td><td><input type="text" name="ref" size="40"></td></tr>
        <?php 
              $dc1=DB::getInstance()->query("SELECT `centre_id`, `cname`, `address`, `contact_person`, `phone` FROM `centre` WHERE `centre_id` in (SELECT distinct `centre_id` FROM `centre_project_details` WHERE `q_id`=$qset)");
                   
                     
        ?>
        <tr><td>City/Centre<font color="red">*</font></td><td><select name='centre'><?php if($dc1->count()>0)foreach($dc1->results() as $d){ echo "<option value=$d->centre_id>$d->cname</option>";}?></option></select> </td></tr>
        <tr><td> </td><td><select name=lang hidden><option value='none'>English </option></select> </td></tr>
        <tr style=height:50px;color:lightgray;><td></td><td><input type="submit" name="subinfo" values="Submit" style=background-color:#004c00;color:white;height:30px;></td></tr>

            </form>
        </table>
       
    </body>
</html>


<?php

}

//$qset=2;
$qset=$_GET['qset'];
$pid='';
$ddd=DB::getInstance()->query("SELECT distinct `project_id`, `visit_no` FROM `questionset` WHERE `qset_id`=$qset");

if($ddd->count()>0)
  {  $pid=$ddd->first()->project_id;}

if(isset($_POST['subinfo']))
{
    $qset=$_GET['qset'];
    $fn=$_POST['fname'];
    $add=$_POST['address'];
    $email=$_POST['email'];
    $mob=$_POST['mobile'];
    $mac_email=$_POST['macemail'];
    $ref=$_POST['ref'];
    $cn=$_POST['centre'];
    $cat=$_POST['category'];
    $age=$_POST['age'];
    $gen=$_POST['gender'];
    $sec=$_POST['sec'];
    $resp_t=$_POST['resp_type'];
    $lang=$_POST['lang'];
    $age_yrs=$_POST['age_yrs'];
    
    if(($fn!='') && ($mob!='') )
    {
        
       
          $sql21="INSERT INTO `demo_respondent`( `full_name`, `address`, `email`, `mobile`, `mac_email`, `ref_id`, `cntr_id`) VALUES ('$fn','$add','$email','$mob','$mac_email','$ref','$cn')";
            
                $data=DB::getInstance()->query($sql21);
                if($data)
                {   $project_id='';
                    $_SESSION['resp']=$data->last();
                     $resp_id=$_SESSION['resp'];
                     $_SESSION['lang']=$lang;
                $db1=DB::getInstance()->query("SELECT `project_id` FROM `questionset` WHERE `qset_id`=$qset");
                if($db1->count()>0)
                $project_id=$db1->first()->project_id;

                 $sql22="INSERT INTO `respondent_link_map`( `p_id`, `qset_id`, `resp_id`, `url`, `status`, `centre_id`) VALUES ($pid,$qset,$resp_id,'$url',1,$cn)";     
                DB::getInstance()->query($sql22);
      echo "INSERT INTO `sunflower`(`q_id`,`resp_id`,r_name_8,`r_age_8`, `r_gen_8`, `r_sec_8`, `weekday_8`,`resp_type_8`) VALUES ($qset,$resp_id,'$fn','$age','$gen','$sec','$cat','$resp_t')";
                 DB::getInstance()->query("INSERT INTO `sunflower`(`q_id`,`resp_id`,`r_age_8`, `r_gen_8`, `r_sec_8`, `weekday_8`,`resp_type_8`, `r_age_yrs_8`) VALUES ($qset,$resp_id,'$age','$gen','$sec','$cat','$resp_t','$age_yrs')");
                 DB::getInstance()->query("INSERT INTO `respondent_ques_details`( `resp_id`, `q_id`) VALUES ($resp_id,$qset)");
                 DB::getInstance()->query("INSERT INTO `respondent_centre_map`( `resp_id`, `centr_id`, `project_id`, `q_id`) VALUES ($resp_id,$cn,$project_id,$qset) ");

                //add only when current project_id does not exist
                $prot_id='';
                $db1=DB::getInstance()->query("SELECT `project_id` FROM `questionare_info` WHERE `qset_id`=$qset");
                if($db1->count()>0)
                $prot_id=$db1->first()->project_id;
                if($prot_id!=$project_id)
                     DB::getInstance()->query("INSERT INTO `questionare_info`(`project_id`, `q_id`) VALUES ($project_id,$qset) ");

                    //echo "Please click on <a href='https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/PreDemoCSS.php?qset=$qset&next=-1&rsp=$resp_id'>start</a> to continue survey";
                     $newURL="https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/sunflower_survey.php?qset=$qset&next=-1&rsp=$resp_id";
                    // header('Location: '.$newURL);
                }
                else    echo "<font color='red'>Please re-fill your Name, City/Centre and Mobile Number to start this survey.</font>";

            
    }
    else {
        echo "Please fill your Name, City/Centre and Mobile Number to start this survey.";
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
