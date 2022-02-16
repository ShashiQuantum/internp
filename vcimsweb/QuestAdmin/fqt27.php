<?php
ob_start();
include_once('../init.php');


$qset=$_GET['qset'];
$url="http://wwww.digiadmin.quantumcs.com/vcims/QuestAdmin/fqt27.php?qset=$qset";
date_default_timezone_set('asia/calcutta');
        
$date = date('Y/m/d H:i:s');

$_SESSION['isdate']=$date;

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
<?php
      $qset=$_GET['qset'];
$pid='';
$ddd1=DB::getInstance()->query("SELECT `name` FROM `project` WHERE `project_id`=(SELECT distinct `project_id` FROM `questionset` WHERE `qset_id`=$qset)");

if($ddd1->count()>0)
  {  $pnn=$ddd1->first()->name;}
?>
        <h1><font color="red">PROJECT - <?php echo $pnn; ?></font></h1>
        <br>
        <table>
            <form action="" method="post">
            <tr style=height:50px;color:lightgray;><td></td><td>Personal Details</td></tr>
        <tr><td>Mom Full Name <font color="red">*</font> </td><td><input type="text" name="fname" size="40"></td></tr>
        <tr><td>Child Full Name <font color="red">*</font> </td><td><input type="text" name="fcname" size="40"></td></tr>
        <tr><td>Child's School Name <font color="red">*</font> </td><td><input type="text" name="sch_name" size="40"></td></tr>
        <tr><td>City  <font color="red">*</font> </td><td><select name="citycode"><option value=1>Kolkata</option> </select></td></tr>
        <tr><td>Mom Mobile<font color="red">*</font> </td><td><input type="text" size="40" maxlength=10 minlength=10 name="mobile" onkeypress="return isNumber(event)"></td></tr>
        
        <tr><td>Child's Gender <font color="red">*</font> </td><td><select name="gender"><option value=1>Male</option><option value=2>Female</option> </select></td></tr>
        <tr><td>SEC<font color="red">*</font> </td><td><select name="sec"><option value=1>A</option><option value=2>B</option><option value=3>C</option><option value=4>D</option><option value=5>E</option></select></td></tr>
        <tr><td>Mother's Age<font color="red">*</font> </td><td><select name="age"><option value=1> Below 25 yrs</option><option value=2>25-35 yrs</option><option value=3>36-40 yrs</option><option value=4>41-45 yrs</option><option value=5>Above 45 yrs</option> </select></td></tr>
        <tr><td>Child's Age<font color="red">*</font></td><td><input type=text name="age_yrs"> </td></tr>
        <tr><td>Interview day<font color="red">*</font> </td><td><select name="category"><option value=1>Monday</option><option value=2>Tuesday</option><option value=3>Wednesday</option><option value=4>Thursday</option><option value=5>Friday</option><option value=6>Saturday</option><option value=7>Sunday</option> </select></td></tr>
        
        

        <tr style=height:50px;color:lightgray;><td></td><td>Reference Details</td></tr>
        <tr><td>MAC Email ID <font color="red"></font></td><td><input type="email" name="macemail" size="40"></td></tr>
        <tr><td>Interviewer Name <font color="red">*</font></td><td><input type="text" name="ref" size="40"></td></tr>
        <?php 
              $dc1=DB::getInstance()->query("SELECT `centre_id`, `cname`, `address`, `contact_person`, `phone` FROM `centre` WHERE `centre_id` in (SELECT distinct `centre_id` FROM `centre_project_details` WHERE `q_id`=$qset)");
                   
                     
        ?>
        <tr><td>State/Centre<font color="red">*</font></td><td><select name='centre'><?php if($dc1->count()>0)foreach($dc1->results() as $d){ echo "<option value=$d->centre_id>$d->cname</option>";}?></option></select> </td></tr>
        <tr><td> </td><td><select name=lang hidden><option value='none'>English </option></select> </td></tr>
        <tr style=height:50px;color:lightgray;><td></td><td><input type="submit" name="subinfo" values="Submit" style=background-color:#004c00;color:white;height:30px;></td></tr>

            </form>
        </table>
       
    </body>
</html>


<?php

}

date_default_timezone_set('asia/calcutta');
        
$date = date('Y/m/d H:i:s');

$_SESSION['isdate']=$date;

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
    $city=$_POST['citycode'];
    $chname=$_POST['fcname'];
    $mob=$_POST['mobile'];
    $mac_email=$_POST['macemail'];
    $ref=$_POST['ref'];
    $cn=$_POST['centre'];
    //$ord_prod=$_POST['product_ordered'];
    //$store=$_POST['store'];
    $age=$_POST['age'];
     $age_yrs=$_POST['age_yrs'];
    $gen=$_POST['gender'];
    $sec=$_POST['sec'];
    $cat=$_POST['category'];
    $lang=$_POST['lang'];
    $school=$_POST['sch_name'];
    
    if( $fn!=''  &&  $mob!=''  )
    { 

           $sql11="select d1.respondent_id,  d1.email as email,d1.mobile as mobile ,d2.status as status FROM `demo_respondent` d1 JOIN `respondent_link_map` d2  ON d1.respondent_id = d2.resp_id WHERE d2.qset_id=$qset and d1.full_name='$fn'  AND  `mobile` ='$mob'";
        $da=DB::getInstance()->query($sql11);
       
        if($da->count()>0)
        {       
            if($da->first()->status==2)
            {    
                echo '<br><font color="red">Your survey has submitted once successfully, So you could not participated again</font>';
            }
            else if($da->first()->status==0 || $da->first()->status==1)
            {

                $_SESSION['resp']=$da->first()->respondent_id; 
                $_SESSION['lang']=$lang;

                //echo '<br><font color="darkgreen"> Record allready exist but survey has not yet submitted</font>';
                 $resp_id=$_SESSION['resp'];

                $newURL="https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/survey_v3.php?qset=$qset&next=-1&rsp=$resp_id";
                     header('Location: '.$newURL);
            }
            
           
        } 
        else {
           $sql21="INSERT INTO `demo_respondent`( qset_id,`full_name`, `address`,  `mobile`, `mac_email`, `ref_id`, `cntr_id`) VALUES ($qset,'$fn','$chname','$mob','$mac_email','$ref','$cn')";
            
                $data=DB::getInstance()->query($sql21);
                if($data)
                {   $project_id='';
                    $_SESSION['resp']=$data->last();
                     $resp_id=$_SESSION['resp'];
                     $_SESSION['lang']=$lang;
                $db1=DB::getInstance()->query("SELECT `project_id` FROM `questionset` WHERE `qset_id`=$qset");
                if($db1->count()>0)
                $project_id=$db1->first()->project_id;

                $date = date('Y/m/d H:i:s');
                $sql22="INSERT INTO `respondent_link_map`( `p_id`, `qset_id`, `resp_id`, `url`, `status`, `centre_id`,`start_time`) VALUES ($pid,$qset,$resp_id,'$url',1,$cn,'$date')";         
                DB::getInstance()->query($sql22);

            if($qset==27)
            {    DB::getInstance()->query("INSERT INTO `PLATINUM_27`( `q_id`,`resp_id`,`r_name`, ch_name, mobile,`age_27`, `gender_27`, `sec_27`, `week_day_27`, age_yrs_27 ,centre_27,i_date_27,school_27, city_27, month_27) VALUES ($qset,$resp_id,'$fn','$chname','$mob','$age','$gen','$sec','$cat','$age_yrs','$cn','$date','$school' ,'$city','4')");
            }
            if($qset==31)
            {   
                 DB::getInstance()->query("INSERT INTO `PLATINUMCPM_31`( `q_id`,`resp_id`,`r_name`, ch_name, mobile,`age_31`, `gender_31`, `sec_31`, `week_day_31`, age_yrs_31 ,centre_31,i_date_31,school_31, city_31) VALUES ($qset,$resp_id,'$fn','$chname','$mob','$age','$gen','$sec','$cat','$age_yrs','$cn','$date','$school' ,'$city')");
            }
                 DB::getInstance()->query("INSERT INTO `respondent_ques_details`( `resp_id`, `q_id`) VALUES ($resp_id,$qset)");
                 DB::getInstance()->query("INSERT INTO `respondent_centre_map`( `resp_id`, `centr_id`, `project_id`, `q_id`) VALUES ($resp_id,$cn,$project_id,$qset) ");

                //add only when current project_id does not exist
                $prot_id='';
                $db1=DB::getInstance()->query("SELECT distinct `project_id` FROM `questionset` WHERE `qset_id`=$qset");
                if($db1->count()>0)
                $prot_id=$db1->first()->project_id;
                if($prot_id!=$project_id)
                     DB::getInstance()->query("INSERT INTO `questionare_info`(`project_id`, `q_id`) VALUES ($project_id,$qset) ");

                    
                     $newURL="https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/survey_v3.php?qset=$qset&next=-1&rsp=$resp_id";
                    header('Location: '.$newURL);
                }
                else    echo "<font color='red'>Please re-fill your Name, City/Centre and Mobile Number to start this survey.</font>";
              }
            
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