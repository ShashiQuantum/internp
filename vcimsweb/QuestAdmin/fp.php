<?php
ob_start();
include_once('../init.php');


$qset=$_GET['qset'];
$url="http://wwww.digiadmin.quantumcs.com/vcims/QuestAdmin/fp_10.php?qset=$qset";
//date_default_timezone_set("Asia/Kolkata");

date_default_timezone_set('asia/calcutta');
        
$date = date('Y/m/d H:i:s');

$_SESSION['isdate']=$date;
$yn=0;

  if($yn==1) 
{
    echo "<div id=header>";
                           echo " <p style=float:right><img src='../../images/Digiadmin_logo.jpg' height=50 width=150> </p><br><br><br><br>";
    echo  "</div>";                       
    echo "<center>";

    echo 'Hi, We are going to conduct the survey on xxx product where your feedback is important for the product quality improvement.';
    echo "<br><a href='https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/fq97.php?qset=$qset&yn=0'> continue</a>";
    
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
$ddd1=DB::getInstance()->query("SELECT `name`, data_table FROM `project` WHERE `project_id`=(SELECT distinct `project_id` FROM `questionset` WHERE `qset_id`=$qset)");

if($ddd1->count()>0)
  {  $pnn=$ddd1->first()->name;$table=$ddd1->first()->data_table;}
?>
        <h2><font color="red">PROJECT - <?php echo $pnn; ?></font></h2>
        <br>
        <table>
            <form action="" method="post">
            <tr style=height:50px;color:lightgray;><td></td><td>Personal Details</td></tr>
        <tr><td>Full Name <font color="red"></font> </td><td><input type="text" name="fname" size="40"></td></tr>
        
        <tr><td>Mobile<font color="red">*</font> </td><td><input type="text" size="40" maxlength=10 minlength=10 name="mobile" onkeypress="return isNumber(event)"></td></tr>


      <!--
        <tr><td>City  </td><td><input type="text" name="address" size="40"></td></tr>
        <tr><td>Gender <font color="red"></font> </td><td><select name="gender"><option value=1>Male</option><option value=2>Female</option> </select></td></tr>
        
        <tr><td>Age </td><td><select name="age"><option value="0">Select---</option><option value="1">18-25 years</option><option value="2">26-30 years</option><option value="3">31-35 years</option><option value="4">36-40 years</option><option value="5">41-45 years</option><option value="6">46-50 years</option><option value="7">51-55 years</option><option value="8">Above 55 years</option> </select> </td></tr>
        -->


       <tr><td>Centre </td><td><select name="centre"><option value="0">Select---</option><option value="1">Delhi</option><option value="2">Mumbai </option><option value="3">Bangalore</option><option value="4">Chennai</option><option value="5">Hyderabad</option><option value="6">Kolkata </option> </select> </td></tr>

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
$_SESSION='';

    $qset=$_GET['qset'];
    $fn=$_POST['fname'];
    //$add=$_POST['address'];
    //$email=$_POST['email'];
    $mob=$_POST['mobile'];

    /* $mac_email=$_POST['macemail'];
    $ref=$_POST['ref'];
    $cn=$_POST['centre'];
    $ord_prod=$_POST['product_ordered'];
    //$store=$_POST['store'];
    //$age=$_POST['age'];
   $sec=$_POST['sec'];
    $cat=$_POST['category'];
     */
     //$age_yrs=$_POST['age_yrs'];
    //$gen=$_POST['gender'];
   
    $lang=$_POST['lang'];
    
    $_SESSION['qset']=$qset; $_SESSION['table']=$table;

    if(($mob!='') )
    { 

           $sql11="select d1.respondent_id,  d1.email as email,d1.mobile as mobile ,d2.status as status FROM `demo_respondent` d1 JOIN `respondent_link_map` d2  ON d1.respondent_id = d2.resp_id WHERE d2.qset_id=$qset and d1.full_name='$fn' and `email` ='$email' AND  `mobile` ='$mob'";
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

                $newURL="https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/websurvey.php?qset=$qset&next=-1&rsp=$resp_id";
                     header('Location: '.$newURL);
            }
            
           
        } 
        else {
           $sql21="INSERT INTO `demo_respondent`( qset_id,`full_name`, `address`, `email`, `mobile`, `mac_email`, `ref_id`, `cntr_id`) VALUES ($qset,'$fn','$add','$email','$mob','$mac_email','$ref','$cn')";
            
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
                     
                DB::getInstance()->query("INSERT INTO $table ( `q_id`,`resp_id`,`r_name`,mobile, centre_$qset) VALUES ($qset,$resp_id,'$fn','$mob','$cn')");
                DB::getInstance()->query("INSERT INTO `respondent_ques_details`( `resp_id`, `q_id`) VALUES ($resp_id,$qset)");
                //DB::getInstance()->query("INSERT INTO `respondent_centre_map`( `resp_id`, `centr_id`, `project_id`, `q_id`) VALUES ($resp_id,$cn,$project_id,$qset) ");

                //add only when current project_id does not exist
                $prot_id='';
                $db1=DB::getInstance()->query("SELECT distinct `project_id` FROM `questionset` WHERE `qset_id`=$qset");
                if($db1->count()>0)
                $prot_id=$db1->first()->project_id;
                if($prot_id!=$project_id)
                     DB::getInstance()->query("INSERT INTO `questionare_info`(`project_id`, `q_id`) VALUES ($project_id,$qset) ");

                    
                     $newURL="https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/websurvey.php?qset=$qset&next=-1&rsp=$resp_id";
                    header('Location: '.$newURL);
                }
                else    echo "<font color='red'>Please re-fill all required details to start this survey.</font>";
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