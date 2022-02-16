<?php

include_once('../init.php');


$qset=$_GET['qset'];
$url="http://wwww.digiadmin.quantumcs.com/vcims/QuestAdmin/fp_10.php?qset=$qset";
date_default_timezone_set("Asia/Kolkata");
//date_default_timezone_set('asia/calcutta');
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
        <tr><td>Booth ID/No <font color="red">*</font></td><td><input type="text" name="bid" size="40" maxlength=4 minlength=3 onkeypress="return isNumber(event)"></td></tr>
        <tr><td>Booth Address </td><td><input type="text" name="address" size="40"></td></tr>
        <tr><td>Auditor Name <font color="red">*</font> </td><td><input type="text" name="aname" size="40"></td></tr>
        <tr><td>Auditor Mobile<font color="red">*</font> </td><td><input type="text" size="40" maxlength=10 minlength=10 name="amobile" onkeypress="return isNumber(event)"></td></tr>
        <tr><td>Store Manager Mobile</td><td><input type="text" size="40" maxlength=10 minlength=10 name="smmobile" onkeypress="return isNumber(event)"></td></tr>
         <tr><td>Visit Shift <font color="red">*</font> </td><td><select name="vs"><option value=1>Morning</option><option value=2>Evening</option></select></td></tr>
         
        
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
    $aname=$_POST['aname'];
    $add=$_POST['address'];
    $amob=$_POST['amobile'];
    $mac_email=$_POST['macemail'];
    $ref=$_POST['ref'];
    $cn=$_POST['centre'];
    $bid=$_POST['bid'];
     $smm=$_POST['smmobile'];
    $vs=$_POST['vs'];
    
    
    $lang=$_POST['lang'];
    
    if(($bid!='') && ($amob!='') )
    { 

        echo   $sql11="select  * FROM mdbooth_details WHERE qset_id=$qset and booth_id =$bid";
        $da=DB::getInstance()->query($sql11);
       
        if($da->count()>0)
        {       
            if($da->first()->status==2)
            {    
                echo '<br><font color="red">Your Record already exist in our database and survey has submitted once, So you could not participated again</font>';
            }
            else if($da->first()->status==0 || $da->first()->status==1)
            {
                $_SESSION['resp']=$da->first()->booth_id; $_SESSION['lang']=$lang;
                echo '<br><font color="darkgreen"> Record allready exist but survey has not yet submitted</font>';
                 $bid=$_SESSION['resp'];

                $newURL="https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/survey_v2.php?qset=$qset&next=-1&rsp=$bid";
                header('Location: '.$newURL);
            }                   
        } 
        else 
        {
       
            $date = date('Y/m/d H:i:s');
         
          // $sql21="INSERT INTO `demo_respondent`( `full_name`, `address`, `email`, `mobile`, `mac_email`, `ref_id`, `cntr_id`) VALUES ('$fn','$add','$email','$mob','$mac_email','$ref','$cn')";
               $date = date('Y/m/d H:i:s');

              $sql21="INSERT INTO `mdbooth_details`( `booth_id`, `booth_address`, `sm_mob`, `aud_name`, `aud_mob`, `v_shift`, `centre`, `ref_id`, `i_date`) VALUES ($bid,'$add','$smm','$aname','$amob',$vs,$cn,'$ref','$date')";
            
                $data=DB::getInstance()->query($sql21);
                if($data)
                {   $project_id='';
                 //   $_SESSION['resp']=$data->last();
                    // $resp_id=$_SESSION['resp'];
                     
                $db1=DB::getInstance()->query("SELECT distinct `project_id` FROM `questionset` WHERE `qset_id`=$qset");
                if($db1->count()>0)
                $project_id=$db1->first()->project_id;

                 
                $sql22="INSERT INTO `respondent_link_map`( `p_id`, `qset_id`, `resp_id`, `url`, `status`, `centre_id`,`start_time`) VALUES ($pid,$qset,$bid,'$url',1,$cn,'$date')";     
                DB::getInstance()->query($sql22);
                     
                DB::getInstance()->query("INSERT INTO `UMEED_20`( `resp_id`, `q_id`, `aud_name`, `aud_mobile`, `sm_mobile_20`, `visit_shift_20`,  `centre_20`) VALUES ($bid,$qset,'$aname','$amob','$smm','$vs',$cn)");

                DB::getInstance()->query("INSERT INTO `respondent_ques_details`( `resp_id`, `q_id`) VALUES ($bid,$qset)");
                DB::getInstance()->query("INSERT INTO `respondent_centre_map`( `resp_id`, `centr_id`, `project_id`, `q_id`) VALUES ($bid,$cn,$project_id,$qset) ");

                //add only when current project_id does not exist
                $prot_id='';
                $db1=DB::getInstance()->query("SELECT distinct `project_id` FROM `questionset` WHERE `qset_id`=$qset");
                if($db1->count()>0)
                $prot_id=$db1->first()->project_id;
                if($prot_id!=$project_id)
                     DB::getInstance()->query("INSERT INTO `questionare_info`(`project_id`, `q_id`) VALUES ($project_id,$qset) ");

                    //echo "Please click on <a href='https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/PreDemoCSS.php?qset=$qset&next=-1&rsp=$resp_id'>start</a> to continue survey";
                     $newURL="https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/survey_v2.php?qset=$qset&next=-1&rsp=$bid";
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