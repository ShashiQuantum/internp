<?php

include_once('../init.php');
//https://digiadmin.quantumcs.com/QuestAdmin/fp.php?qset=1

$qset=$_GET['qset'];
$url="http://wwww.digiadmin.quantumcs.com/vcims/QuestAdmin/FirstPage.php?qset=$qset";
//date_default_timezone_set("Asia/Kolkata");
//echo date('Y-m-d h:i:s');
$yn=$_GET['yn'];

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
        <h1><font color="red">WELCOME TO ONLINE SURVEY</font></h1>
        <br>
        <table>
            <form action="" method="post">
            <tr style=height:50px;color:lightgray;><td></td><td>Personal Details</td></tr>
        <tr><td>Full Name <font color="red">*</font> </td><td><input type="text" name="fname" size="40"></td></tr>
        <tr><td>Present Address  </td><td><input type="text" name="address" size="40"></td></tr>
        <tr><td>e-Mail<font color="red"></font></td><td><input type="email" name="email" size="40"></td></tr>
        <tr><td>Mobile<font color="red">*</font> </td><td><input type="text" size="40" maxlength=10 name="mobile"></td></tr>
        
        <tr><td>Gender <font color="red">*</font> </td><td><select name="gender"><option value=1>Male</option><option value=2>Female</option> </select></td></tr>
        <tr><td>SEC<font color="red">*</font> </td><td><select name="sec"><option value=1>A1</option><option value=2>A2</option><option value=3>B1</option><option value=4>B2</option> </select></td></tr>
        <tr><td>Age<font color="red">*</font> </td><td><select name="age"><option value=2>15-20 yrs</option><option value=3>21-25 yrs</option><option value=4>26-30 yrs</option><option value=5>31-35 yrs</option><option value=6>36-40 yrs</option><option value=7>41-45 yrs</option><option value=8>46-50 yrs</option><option value=9>51-55 yrs</option><option value=10>56-60 yrs</option> </select></td></tr>
        <tr><td>Category<font color="red">*</font> </td><td><select name="category"><option value=1>Young</option><option value=2>Housewife</option><option value=3>Old</option> </select></td></tr>

        <tr style=height:50px;color:lightgray;><td></td><td>Reference Details</td></tr>
        <tr><td>MAC Email ID <font color="red"></font></td><td><input type="email" name="macemail" size="40"></td></tr>
        <tr><td>Reference ID <font color="red"></font></td><td><input type="text" name="ref" size="40"></td></tr>
        <?php 
              $dc1=DB::getInstance()->query("SELECT `centre_id`, `cname`, `address`, `contact_person`, `phone` FROM `centre` WHERE `centre_id` in (SELECT distinct `centre_id` FROM `centre_project_details` WHERE `q_id`=$qset)");
                   
                     
        ?>
        <tr><td>City/Centre<font color="red">*</font></td><td><select name='centre'><?php if($dc1->count()>0)foreach($dc1->results() as $d){ echo "<option value=$d->centre_id>$d->cname</option>";}?></option></select> </td></tr>
        <tr><td>Prefered Language </td><td><select name=lang><option value='none'>English </option><option value='hindi'>English - Hindi </option><option value='kannar'>English - Kannar </option><option value='telgu'>English - Telgu </option><option value='bengali'>English - Bengali </option> </td></tr>
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

    $age=$_POST['age'];
    $gen=$_POST['gender'];
    $sec=$_POST['sec'];
    $cat=$_POST['category'];
    $lang=$_POST['lang'];
    
    if(($fn!='') && ($mob!='') )
    {
        echo $sql11="select d1.respondent_id,  d1.email as email,d1.mobile as mobile ,d2.status as status FROM `demo_respondent` d1,`respondent_link_map` d2  WHERE d2.qset_id=$qset and d1.full_name='$fn' and `email` ='$email' AND  `mobile` ='$mob'";
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
                //echo "<br>Please click on <a href='https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/PreDemoCSS.php?qset=$qset&next=-1&rsp=$resp_id'>start</a> to continue survey";
                $newURL="https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/PreDemoCSS.php?qset=$qset&next=-1&rsp=$resp_id";
                header('Location: '.$newURL);
            }
            
           
        } 
        else
            {   $sql21="INSERT INTO `demo_respondent`( `full_name`, `address`, `email`, `mobile`, `mac_email`, `ref_id`, `cntr_id`) VALUES ('$fn','$add','$email','$mob','$mac_email','$ref',$cn)";
            
                $data=DB::getInstance()->query($sql21);
                if($data)
                { 
                    $_SESSION['resp']=$data->last();
                     $resp_id=$_SESSION['resp'];
                     $_SESSION['lang']=$lang;
                echo $sql22="INSERT INTO `respondent_link_map`( `p_id`, `qset_id`, `resp_id`, `url`, `status`, `centre_id`) VALUES ($pid,$qset,$resp_id,'$url',1,$cn)";     
                DB::getInstance()->query($sql22);
                     
                DB::getInstance()->query("INSERT INTO `demosurvey2`( `q_id`,`resp_id`,`r_age`, `r_gender`, `r_sec`,r_category) VALUES ($qset,$resp_id,'$age','$gen','$sec','$cat')");
                
                    //echo "Please click on <a href='https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/PreDemoCSS.php?qset=$qset&next=-1&rsp=$resp_id'>start</a> to continue survey";
                     $newURL="https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/PrevDemoCSS.php?qset=$qset&next=-1&rsp=$resp_id";
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