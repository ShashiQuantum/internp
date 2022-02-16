<?php
//ob_start();
include_once('../init.php');

//session_destroy();
$qset=52; $pid='';$tablen='';$pnn='';

$url="http://wwww.digiadmin.quantumcs.com/vcims/QuestAdmin/fp_10.php?qset=$qset";

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
<?php
      

$ddd1=DB::getInstance()->query("SELECT * FROM `project`  WHERE `project_id`=(SELECT distinct `project_id` FROM `questionset` WHERE `qset_id`=$qset)");

if($ddd1->count()>0)
  {  
     $pid=$ddd1->first()->project_id;
     $pnn=$ddd1->first()->name;
     $tablen=$ddd1->first()->data_table;
      
     $_SESSION['table']=$tablen;
     $_SESSION['qset']=$qset;
  }
  
?>
        <h1><font color="red">PROJECT - <?php echo $pnn; ?></font></h1>
        <br>
        <table>
            <form action="" method="post">
            <tr style=height:50px;color:lightgray;><td></td><td>Personal Details</td></tr>
        <tr><td>Full Name <font color="red">*</font> </td><td><input type="text" name="fname" size="40"></td></tr>
        <tr><td>Age  </td><td><input type="text" name="cmp" size="40"></td></tr>
        <tr><td>Qualification  </td><td><input type="text" name="dsg" size="40"></td></tr>
        <tr><td>eMail<font color="red"></font></td><td><input type="email" name="email" size="40"></td></tr>
        <tr><td>Mobile<font color="red">*</font> </td><td><input type="text" size="40" maxlength=10 minlength=10 name="mobile" onkeypress="return isNumber(event)"></td></tr>
        <tr><td>Salary Slab </td><td><select name=sal><option value='1'>1 to 5 LPA </option><option value='2'>5 to 10 LPA </option><option value='3'>10 to 15 LPA </option><option value='4'>15 to 20 LPA </option><option value='6'>20 LPA & Above </option></select> </td></tr> 
        <tr><td> </td><td><select name=lang hidden><option value='none'>English </option></select> </td></tr>
        <tr style=height:50px;color:lightgray;><td></td><td><input type="submit" name="subinfo" values="Submit" style=background-color:#004c00;color:white;height:30px;></td></tr>

            </form>
        </table>
       
    </body>
</html>


<?php

}




if(isset($_POST['subinfo']))
{
    //$qset=$_GET['qset'];
    $fn=$_POST['fname'];
    $cmp=$_POST['cmp'];
    $email=$_POST['email'];
    $mob=$_POST['mobile'];
    $dsg=$_POST['dsg'];
    $sal=$_POST['sal'];

    $lang=$_POST['lang'];
    
    
    if(($fn!='') && ($mob!='') )
    { 

           $sql11="select d1.respondent_id,  d1.email as email,d1.mobile as mobile ,d2.status as status FROM `demo_respondent` d1 JOIN `respondent_link_map` d2  ON d1.respondent_id = d2.resp_id WHERE d2.qset_id=$qset and d1.full_name='$fn' and d1.`email` ='$email' AND  d1.`mobile` ='$mob'";
        $da=DB::getInstance()->query($sql11);
       
        if($da->count()>0)
        {       
            if($da->first()->status==2)
            {    
                echo '<br><font color="red">Your survey has submitted already successfully</font>';
            }
            else if($da->first()->status==0 || $da->first()->status==1)
            {

                $_SESSION['resp']=$da->first()->respondent_id; 
                $_SESSION['lang']=$lang; $_SESSION['sid']=0;

                //echo '<br><font color="darkgreen"> Record allready exist but survey has not yet submitted</font>';
                 $resp_id=$_SESSION['resp'];

                $newURL="https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/dos2.php";
                     header('Location: '.$newURL);
            }
            
           
        } 
        else {
              $sql21="INSERT INTO `demo_respondent`( qset_id,`full_name`, `address`, `email`, `mobile`, `ref_id`) VALUES ($qset,'$fn','$cmp','$email','$mob','$dsg')";
            
                $data=DB::getInstance()->query($sql21);
                if($data)
                {    
                    $resp_id=$_SESSION['resp']=$data->last();
                      
                     $_SESSION['lang']=$lang; $_SESSION['sid']=0;

                $date = date('Y/m/d H:i:s');
                $sql22="INSERT INTO `respondent_link_map`( `p_id`, `qset_id`, `resp_id`, `url`, `status`, `centre_id`,`start_time`) VALUES ($pid,$qset,$resp_id,'',1,0,'$date')";   
      
                DB::getInstance()->query($sql22);

           echo "INSERT INTO $tablen( `q_id`,`resp_id`,`r_name`,mobile,salary_52,age_52,qualification_52) VALUES ($qset,$resp_id,'$fn','$mob','$sal','$cmp','$dsg')";

                DB::getInstance()->query("INSERT INTO $tablen( `q_id`,`resp_id`,`r_name`,mobile,salary_52,age_52,qualification_52) VALUES ($qset,$resp_id,'$fn','$mob','$sal','$cmp','$dsg')");
                DB::getInstance()->query("INSERT INTO `respondent_ques_details`( `resp_id`, `q_id`) VALUES ($resp_id,$qset)");

               // DB::getInstance()->query("INSERT INTO `respondent_centre_map`( `resp_id`, `centr_id`, `project_id`, `q_id`) VALUES ($resp_id,$cn,$project_id,$qset) ");

                //add only when current project_id does not exist
                $prot_id='';
                $db1=DB::getInstance()->query("SELECT distinct `project_id` FROM `questionset` WHERE `qset_id`=$qset");
                if($db1->count()>0)
                $prot_id=$db1->first()->project_id;
                if($prot_id!=$pid)
                     DB::getInstance()->query("INSERT INTO `questionare_info`(`project_id`, `q_id`) VALUES ($pid,$qset) ");

                    
                     $newURL="https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/dos2.php?";
                      header('Location: '.$newURL);
                }
                else    echo "<font color='red'>Please fill the details to start this survey.</font>";
              }
            
    }
    else {
        echo "Please fill the details to start this survey.";
    }
}
?>

<script type="text/javascript">

   function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            alert("Please enter only Numbers and Letters.");
            return false;
        }

        return true;
    }
</script>