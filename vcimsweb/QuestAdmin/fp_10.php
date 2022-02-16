<?php
include_once('../init.php');

$qset=$_GET['qset'];
$url="http://wwww.digiadmin.quantumcs.com/vcims/QuestAdmin/fp_10.php?qset=$qset";
date_default_timezone_set("Asia/Kolkata");

//echo date('Y-m-d h:i:s');
//$yn=$_GET['yn'];

$yn=0;

if($yn==1) 
{
    echo "<div id=header>";
    echo "<p style=float:right><img src='../../images/Digiadmin_logo.jpg' height=50 width=150></p><br><br><br><br>";
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
        <tr><td>Full Name <font color="red">*</font> </td><td><input type="text" name="fname" size="40"></td></tr>
        <!-- <tr><td>Present Address  </td><td><input type="text" name="address" size="40"></td></tr> -->
        <tr><td>e-Mail<font color="red"></font></td><td><input type="email" name="email" size="40"></td></tr>
        <tr><td>Mobile<font color="red">*</font> </td><td><input type="text" size="40" maxlength=10 minlength=10 name="mobile" onkeypress="return isNumber(event)"></td></tr>
        
        <tr><td>Gender <font color="red">*</font> </td><td><select name="gender"><option value=1>Male</option><option value=2>Female</option> </select></td></tr>
       <!-- <tr><td>SEC<font color="red">*</font> </td><td><select name="sec"><option value=1>A</option><option value=2>B</option><option value=3>C</option><option value=4>D</option><option value=5>E</option></select></td></tr>
        <tr><td>Age<font color="red">*</font> </td><td><select name="age"><option value=1> Less than 18 yrs</option><option value=2>18-22 yrs</option><option value=3>23-27 yrs</option><option value=4>Above 27 yrs</option> </select></td></tr> -->
        <tr><td>Age in year</td><td><input type=text name="age_yrs"> </td></tr>
        <tr><td>Time of the day<font color="red">*</font> </td><td><select name="dt"><option value=1>09AM-12PM </option><option value=2>12PM-3PM</option><option value=3>03PM-06PM</option><option value=4>06PM-09PM</option></select></td></tr>
         <tr><td>Total no. of items purchased : <font color="red">*</font> </td><td><select name="nip"><option value=1>1</option><option value=2>2</option><option value=3>3</option><option value=4>4</option><option value=5>5</option<option value=6>6</option><option value=7>7</option><option value=8>8</option><option value=9>9</option><option value=10>10</option></select></td></tr>
         <tr><td>Order placed for no. of people : <font color="red">*</font> </td><td><select name="nop"><option value=1>1</option><option value=2>2</option><option value=3>3</option><option value=4>4</option><option value=5>5</option<option value=6>6</option><option value=7>7</option><option value=8>8</option><option value=9>9</option><option value=10>10</option></select></td></tr>
         <tr><td>Bill amount pay for current purchase of any food/baverage : Rs</td><td><input type=text name="bamt" placeholder=""> </td></tr>
         <tr><td>Frequency of consumption from canteen : <font color="red">*</font> </td><td><select name="nop"><option value=1>I buy from canteen on a daily basis</option><option value=2>I buy from canteen once a week</option><option value=3>I buy from canteen 2-3 times in a week</option><option value=4>I buy from canteen less often</option></select></td></tr>

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
    $ord_prod=$_POST['product_ordered_07'];
    $store=$_POST['store'];
    $age=$_POST['age'];
     $age_yrs=$_POST['age_yrs'];
    $gen=$_POST['gender'];
    $sec=$_POST['sec'];
    $cat=$_POST['category'];
    $lang=$_POST['lang'];
    
    if(($fn!='') && ($mob!='') )
    { 

           $sql11="select d1.respondent_id,  d1.email as email,d1.mobile as mobile ,d2.status as status FROM `demo_respondent` d1 JOIN `respondent_link_map` d2  ON d1.respondent_id = d2.resp_id WHERE d2.qset_id=$qset and d1.full_name='$fn' and `email` ='$email' AND  `mobile` ='$mob'";
        $da=DB::getInstance()->query($sql11);
       
        if($da->count()>0)
        {       
            if($da->first()->status==2)
            {    
                echo '<br><font color="red">Your Record already exist in our database and survey has submitted once, So you could not participated again</font>';
            }
            else if($da->first()->status==0 || $da->first()->status==1)
            {
                $_SESSION['resp']=$da->first()->respondent_id; $_SESSION['lang']=$lang;
                echo '<br><font color="darkgreen"> Record allready exist but survey has not yet submitted</font>';
                 $resp_id=$_SESSION['resp'];
                 
                // DB::getInstance()->query("INSERT INTO `peacock_9`( `q_id`,`resp_id`,`r_name_9`,mobile_9,`r_age_9`, `r_gen_9`, `r_sec_9`, `weekday_9`,`store_9`, `product_9`,`r_age_yrs_9`) VALUES ($qset,$resp_id,'$fn','$mob','$age','$gen','$sec','$cat','$store','$ord_prod','$age_yrs')");

                //echo "<br>Please click on <a href='https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/PreDemoCSS.php?qset=$qset&next=-1&rsp=$resp_id'>start</a> to continue survey";

                $newURL="https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/survey_v1.php?qset=$qset&next=-1&rsp=$resp_id";
             //   header('Location: '.$newURL);
            }
            
           
        } 
        else {
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
                     
                DB::getInstance()->query("INSERT INTO `peacock_9`( `q_id`,`resp_id`,`r_name_9`,mobile_9,`r_age_9`, `r_gen_9`, `r_sec_9`, `weekday_9`,`store_9`, `product_9`,`r_age_yrs_9`) VALUES ($qset,$resp_id,'$fn','$mob','$age','$gen','$sec','$cat','$store','$ord_prod','$age_yrs')");
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
                     $newURL="https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/survey_v1.php?qset=$qset&next=-1&rsp=$resp_id";
                 //   header('Location: '.$newURL);
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
