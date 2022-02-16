<?php

include_once('../init.php');
include_once('../functions.php');

if(isset($_REQUEST['st']))
{
	$st = $_REQUEST['st'];
}
else
{
	$st = 2;
}   



if(isset($_POST['submit']))
{
    //print_r($_POST);
    $p=$_POST['project'];
    $t=$_POST['tab'];
    $pr=$_POST['per'];
  
    if($p!=0 && $t!=0)
    {
        $qr="SELECT `id`, `project_id`, `tab_id`, `tab_name`, `status` FROM `tab_project_map` WHERE `project_id`=$p and `tab_id`=$t";
        $rd=DB::getInstance()->query($qr);
        if($rd->count()>0)
        {
                  $q1="UPDATE `tab_project_map` SET  `status`=$pr  WHERE `project_id`=$p and `tab_id`=$t ";
                  $rd=DB::getInstance()->query($q1);
        }
        else
        {
                  $q2="INSERT INTO `tab_project_map`( `project_id`, `tab_id`, `status`) VALUES ($p,$t,$pr)";
                  $rd=DB::getInstance()->query($q2);
        }
        echo "<font color=red> Saved successfully";
    }

}


if(isset($_POST['save']))
{
  //print_r($_POST);
  
  $tc=$_POST['tab_company'];
  $tn=$_POST['tab_name'];
  $te1=$_POST['tab_imei_1'];
  $te2=$_POST['tab_imei_2'];
  $temail=$_POST['tab_email'];
  $tsp=$_POST['tab_sim_p'];
  $ts=$_POST['tab_sim'];
  $tm=$_POST['tab_mob'];
  $tcn=$_POST['tab_charger_name'];
  $tcst=1;
  $tst=1;

  if($tc!='' && $tn!='' && $te1!='' && $temail!='' && $tm!='')
  {
       $qry="INSERT INTO `vcims_tablets`( `tab_name`, `tab_company`, `tab_imei_1`, `tab_imei_2`, `tab_email`, `sim_sp`, `tab_sim_no`, `tab_mobile`, `tab_charger`, `tab_charger_status`, `tab_status`) VALUES ('$tn','$tc','$te1','$te2','$temail','$tsp','$ts','$tm','$tcn',$tcst,$tst)";
       $tb=DB::getInstance()->query($qry);
       if($tb)
         echo "<font color=red>Saved Successfully</font>";
  }
  else
    echo "<font color=red>Please enter all the necessary details</font>";
 
}

if(isset($_POST['ta_save']))
{
   //print_r($_POST);
    $tid=$_POST['tab_id'];
    $iid=$_POST['i_id'];
    $pid=$_POST['p_id'];
    $tl=$_POST['wlocation'];
    $tib=$_POST['tab_issue_by'];
    $tisd=$_POST['tab_issue_date'];
    $tch=$_POST['tab_charger'];
    $st=0;

    if($tid!=0 && $iid!=0 && $tib!='' && $tid!='' && $tch!='')
    {
        $qry="INSERT INTO `tab_allocation`(`tab_id`, `i_id`, `p_id`, `work_location`, `issue_by`, `issue_date`,`issue_with_charger`,  `ta_status`) VALUES ($tid,$iid,$pid,'$tl','$tib','$tisd','$tch',$st)";
        $tb=DB::getInstance()->query($qry);
        if($tb)
           echo "<font color=red>Saved Successfully</font>";
    }
    else
       echo "<font color=red>Please enter all the necessary details</font>";

}


if(isset($_POST['tr_save']))
{
   //print_r($_POST);
    $tid=$_POST['tab_id'];
    $iid=$_POST['i_id'];
    $pid=$_POST['p_id'];
    $trb=$_POST['tab_receive_by'];
    $trd=$_POST['tab_receive_date'];
    $tch=$_POST['tab_charger'];
    $st=1;

    if($tid!=0 && $iid!=0 && $trb!='' && $trd!='' && $tch!='')
    {
        $qry="UPDATE `tab_allocation` SET  `received_by`='$trb',  `receive_with_charger`='$tch', `receive_date`='$trd', `ta_status`=$st WHERE `tab_id`=$tid AND `i_id`=$iid AND `p_id`=$pid";
        $tb=DB::getInstance()->query($qry);
        if($tb)
            echo "<font color=red>Saved Successfully</font>";
    }
    else
       echo "<font color=red>Please enter all the necessary details</font>";


}
if(isset($_POST['inr_save']))
{
  
  $in=$_POST['in'];
  $im1=$_POST['im1'];
  $im2=$_POST['im2'];
  $ie=$_POST['ie'];
  $ia=$_POST['ia'];

  
  if($in!='' && $im1!='')
  {
       $qry1="INSERT INTO `interviewer_detail`( `i_name`, `i_mobile`, `i_mobile2`, `i_email`, `i_address`, `i_status`) VALUES ('$in','$im1','$im2','$ie','$ia',1)";
       $tb=DB::getInstance()->query($qry1);
       if($tb)
         echo "<font color=red>Saved Successfully</font>";
  }
  else
    echo "<font color=red>Please enter the necessary details</font>";
}
?>

<html>

<body>
  		<table cellpadding="10" cellspacing="5">
		<tr>
			<td><a href="?st=1">Register Tablet</a></td>
                        <td><a href="?st=2">Register Interviewer</a></td>
			<td><a href="?st=3">Allocate Tablet</a></td>
                        <td><a href="?st=4">Receive Tablet</a></td>
                        <td><a href="?st=8">Tablet Allocation Report </a></td>
                        <td><a href="?st=5">Tablet-Permission</a></td>
                        <td><a href="?st=6">View Tablet Permission Report</a></td>
                        <td><a href="?st=7">Respondent Registration</a></td>
			
		</tr></table>

<?php
if($st==1){
?>			
<center>
<h2>Add New Tablet </h2>
<table>
<form action='' method=post>
  <tr><td>Tab Company</td><td> <input type=text name=tab_company> </td></tr>
  <tr><td>Tab Name</td><td> <input type=text name=tab_name> </td></tr>
  <tr><td>Tab IMEI-1</td><td> <input type=text name=tab_imei_1> </td></tr>
  <tr><td>Tab IMEI-2</td><td> <input type=text name=tab_imei_2> </td></tr>
  <tr><td>Tab Email</td><td> <input type=email name=tab_email> </td></tr>
  <tr><td>Tab SIM Provider</td><td> <input type=text name=tab_sim_p> </td></tr>
  <tr><td>Tab SIM No</td><td> <input type=text name=tab_sim> </td></tr>
  <tr><td>Tab Mobile</td><td> <input type=text name=tab_mob maxlength=10> </td></tr>
  <tr><td>Tab charger Name</td><td> <input type=text name=tab_charger_name> </td></tr>


  <tr><td></td><td colspan=2><input type=submit name="save" value=Save></td></tr>

</form>
</tablet>
</center>
<?php
} if($st==3){
?>
<center>
<h2>Allocate Tablet </h2>
<table>
<form action='' method=post>
  <tr><td>Tablet Name</td><td> <select name=tab_id><option value=0>--Select--</option><?php $r=DB::getInstance()->query("SELECT `tab_id`,tab_name  FROM `vcims_tablets`"); if($r->count()>0) foreach($r->results() as $rd){ ?><option value=<?php echo $rd->tab_id; ?>><?php echo $rd->tab_name; ?></option><?php } ?> </select> </td></tr>
  <tr><td>Interviewer </td><td> <select name=i_id><option value=0>--Select--</option><?php $r=DB::getInstance()->query("SELECT i_id, `i_name`, `i_mobile`, `i_mobile2`, `i_email`, `i_address`, `i_status` FROM `interviewer_detail`"); if($r->count()>0) foreach($r->results() as $rd){ ?><option value=<?php echo $rd->i_id; ?>><?php echo $rd->i_name .' - '.$rd->i_mobile; ?></option><?php } ?> </select> </td></tr>
  <tr><td>Project Name</td><td> <select name=p_id> <option value=0>--Select--</option><?php $r=DB::getInstance()->query("SELECT *  FROM `project`"); if($r->count()>0) foreach($r->results() as $rd){ ?><option value=<?php echo $rd->project_id; ?>><?php echo $rd->name; ?></option><?php } ?> </select> </td></tr>
  <tr><td>Survey Location/Area</td><td> <input type=text name=wlocation> </td></tr>
  <tr><td>Tab Issue By</td><td> <input type=text name=tab_issue_by> </td></tr>
  <tr><td>Tab Issue Date</td><td> <input type=date name=tab_issue_date> </td></tr>
  <tr><td>Tab With Charger</td><td><select name=tab_charger> <option value=yes>Yes</option><option value=no>No</option></select> </td></tr>


  <tr><td></td><td colspan=2><input type=submit name="ta_save" value=Save></td></tr>

</form>
</tablet>
</center>
<?php
} if($st==4){
?>
<center>
<h2>Receive Tablet </h2>
<table>
<form action='' method=post>
  <tr><td>Tablet Name</td><td> <select name=tab_id><option value=0>--Select--</option><?php $r=DB::getInstance()->query("SELECT `tab_id`,tab_name  FROM `vcims_tablets`"); if($r->count()>0) foreach($r->results() as $rd){ ?><option value=<?php echo $rd->tab_id; ?>><?php echo $rd->tab_name; ?></option><?php } ?> </select> </td></tr>
  <tr><td>Interviewer </td><td> <select name=i_id><option value=0>--Select--</option>
  
  <?php $r=DB::getInstance()->query("SELECT i_id, `i_name`, `i_mobile`, `i_mobile2`, `i_email`, `i_address`, `i_status` FROM `interviewer_detail`"); if($r->count()>0) foreach($r->results() as $rd){ ?>
  <option value=<?php echo $rd->i_id; ?>><?php echo $rd->i_name .' - '.$rd->i_mobile; ?></option>
<?php } ?> 
</select> </td></tr>
  <tr><td>Project Name</td><td> <select name=p_id> <option value=0>--Select--</option><?php $r=DB::getInstance()->query("SELECT *  FROM `project`"); if($r->count()>0) foreach($r->results() as $rd){ ?><option value=<?php echo $rd->project_id; ?>><?php echo $rd->name; ?></option><?php } ?> </select> </td></tr>
  <tr><td>Tab Received By</td><td> <input type=text name=tab_receive_by> </td></tr>
  <tr><td>Tab Receive Date</td><td> <input type=date name=tab_receive_date> </td></tr>
  <tr><td>Tab With Charger</td><td><select name=tab_charger> <option value=yes>Yes</option><option value=no>No</option></select> </td></tr>


  <tr><td></td><td colspan=2><input type=submit name="tr_save" value=Save></td></tr>

</form>
</tablet>
</center>
<?php
} if($st==8){
?>
<center>
<h2>Tablet Allocation Report</h2>
<table border=0>
<form action="" method=post>
<tr><td>Report Type </td><td><select name="trp" id="trp"><option value="0">--Select--</option><option value="1"> All </option><option value="2"> Not Received </option><option value="3"> Available to Allocate </option></select></tr>
<tr><td></td><td><input type="submit" name="trp_report" value=View> </td></tr>
</form>

</table>
</center>
<?php
 

 if(isset($_POST['trp_report']))
  {
        
        $rt=$_POST['trp'];
        

        if($rt!=0)
        {
	     if($rt==1)
	     {
	             $qq="SELECT `id`, `tab_id`, `i_id`, `p_id`, `work_location`, `issue_by`, `received_by`, `issue_with_charger`, `receive_with_charger`, `issue_date`, `receive_date`, `ta_status`  FROM tab_allocation order by issue_date desc limit 60";
	             $dr=DB::getInstance()->query($qq);
	             if($dr->count()>0)
	             {
	                  
	                echo "<center><h5>Tablet Allocation Report</h5><table border=1>";
	                echo "<tr><td>Tab_Id</td><td> Project</td><td>Allocated To</td><td>Issue Data</td><td>Charger Allocated</td><td>Location</td><td>Receive Date</td><td>Received with Charger</td><td>Received By</td><td>Status</td></tr>";
	                foreach($dr->results() as $r)
	                {
	                   $tab=$r->tab_id;
	                   $i_id=$r->i_id;
	                   $pid=$r->p_id;
	                   $wl=$r->work_location;
	                   $iby=$r->issue_by;
	                   $icby=$r->issue_with_charger;
	                   $idt=$r->issue_date;
	                   $rdt=$r->receive_date;
	                   $rby=$r->received_by;
	                   $rcby=$r->receive_with_charger;
	                   $s=$r->ta_status;
	                   
	                   $str="Not Received"; if($s==1)$str="Received";
	                   $icbyn="No";if($icby==1)$icbyn="Yes";
	                   $rcbyn="No";if($icby==1)$rcbyn="Yes";
	                   
	                   $pn=get_project_name($pid);
	                   $ipn=get_tablet_receiver($i_id);
	
	                  echo "<tr><td>$tab</td><td> $pn</td><td>$ipn</td><td>$idt</td><td>$icbyn</td><td>$wl</td><td>$rdt</td><td>$rcbyn</td><td>$rby</td><td>$str </td></tr>"; 
	                 }
	              }
	              else echo "<br><center><font color=red>No any details available</font></center>";
             } //END  of if==1
             
	     if($rt==2)
	     {
	             $qq="SELECT `id`, `tab_id`, `i_id`, `p_id`, `work_location`, `issue_by`, `received_by`, `issue_with_charger`, `receive_with_charger`, `issue_date`, `receive_date`, `ta_status` FROM tab_allocation WHERE ta_status=0";
	             $dr=DB::getInstance()->query($qq);
	             if($dr->count()>0)
	             {
	                  
	                echo "<center><h5>Tablet Not Received</h5><table border=1>";
	                echo "<tr><td>Tab_Id</td><td> Project</td><td>Allocated To</td><td>Issue Data</td><td>Charger Allocated</td><td>Location</td><td>Receive Date</td><td>Received with Charger</td><td>Received By</td><td>Status</td></tr>";
	                foreach($dr->results() as $r)
	                {
	                   $tab=$r->tab_id;
	                   $i_id=$r->i_id;
	                   $pid=$r->p_id;
	                   $wl=$r->work_location;
	                   $iby=$r->issue_by;
	                   $icby=$r->issue_with_charger;
	                   $idt=$r->issue_date;
	                   $rdt=$r->receive_date;
	                   $rby=$r->received_by;
	                   $rcby=$r->receive_with_charger;
	                   $s=$r->ta_status;
	                   
	                   $str="Not Received"; if($s==1)$str="Received";
	                   $icbyn="No";if($icby==1)$icbyn="Yes";
	                   $rcbyn="No";if($icby==1)$rcbyn="Yes";
	                   
	                   $pn=get_project_name($pid);
	                   $ipn=get_tablet_receiver($i_id);
	
	                  echo "<tr><td>$tab</td><td> $pn</td><td>$ipn</td><td>$idt</td><td>$icbyn</td><td>$wl</td><td>$rdt</td><td>$rcbyn</td><td>$rby</td><td>$str </td></tr>"; 
	                 }
	              }
	              else echo "<br><center><font color=red>No any details available</font></center>";
             } //END  of if==2
             
	     if($rt==3)
	     {
	        
	             $qq="SELECT `tab_id`, `tab_name`, `tab_company`,`tab_status` FROM `vcims_tablets` WHERE `tab_status`=1 AND `tab_id` not in (SELECT `tab_id` FROM tab_allocation WHERE ta_status=0)";
	             $dr=DB::getInstance()->query($qq);
	             if($dr->count()>0)
	             {
	                  $i=0;
	                echo "<center><h5>Tablet Availabilty To Allocation</h5><table border=1>";
	                echo "<tr><td>S.N.</td><td>Tab_Id</td><td> Tab Name</td><td>Tab Brand</td><td>Tablet Status</td></tr>";
	                foreach($dr->results() as $r)
	                {  $i++;
	                   $tab=$r->tab_id;
	                   $tn=$r->tab_name;
	                   $tcmp=$r->tab_company;
	                   
	                   $ts=$r->tab_status;
	                   
	                   $str="Not Usable"; if($ts==1)$str="Usable";if($ts==2)$str="Damaged";
	                    
	
	                  echo "<tr><td>$i</td><td>$tab</td><td> $tn</td><td>$tcmp</td><td>$str</td></tr>"; 
	                 }
	              }
	              else echo "<br><center><font color=red>No any details available for this project</font></center>";
             } //END  of if==3
             
       }
  
  }
 
} if($st==2){
?>
<center>
<h2>Register Interviewer </h2>
<table>
<form action='' method=post>
  <tr><td>Interviewer Name</td><td> <input type=text name=in> </td></tr>
  <tr><td>Mobile 1</td><td> <input type=text name=im1 maxlength=10> </td></tr>
  <tr><td>Mobile 2</td><td> <input type=text name=im2 maxlength=10> </td></tr>
  <tr><td>Email</td><td> <input type=text name=ie> </td></tr>
  <tr><td>Address</td><td> <input type=text name=ia> </td></tr>
  
  <tr><td></td><td colspan=2><input type=submit name="inr_save" value=Save></td></tr>

</form>
</tablet>
</center>

<?php
} if($st==5){
?>
<center>
<table>

<h2>Tab-Permission</h2>
<form action="" method=post>
<tr><td>Project </td><td><select name="project" id="pid"><option value="0">--Select--</option><?php $ptt=get_projects_details();if($ptt) foreach($ptt as $p){?><option value="<?php echo $p->project_id; ?>"> <?php echo $p->name;  ?></option> <?php } ?></select></tr>

<tr><td>Tablets </td><td><select name="tab" id="tab" ><option value="0">--Select--</option><?php  $pt=get_tabs(); if($pt) foreach($pt as $p){?><option value="<?php echo $p->tab_id; ?>"> <?php echo $p->tab_name;  ?></option> <?php } ?></select></tr>

<tr><td>Permission </td><td><select name=per><option value="0">--Select--</option><option value=1>Allow</option><option value=0>Not allow</option></select></td></tr>

<tr><td></td><td><input type=submit name=submit value=Save> </td></tr>
</form>

</table>
</center>

<?php
} if($st==6){
?>
<center>
<h2>Tablet Permission Report</h2>
<table border=0>
<form action="" method=post>
<tr><td>Project </td><td><select name="pid" id="pid"><option value="0">--Select--</option><?php $ptt=get_projects_details();if($ptt) foreach($ptt as $p){?><option value="<?php echo $p->project_id; ?>"> <?php echo $p->name;  ?></option> <?php } ?></select></tr>
<tr><td></td><td><input type=submit name=ta_report value=View> </td></tr>
</form>

</table>
</center>
<?php
} 

 if(isset($_POST['ta_report']))
  {
        
        $pid=$_POST['pid'];
        

        if($pid!=0)
        {
             $qq="SELECT `project_id`,`tab_id`,mobile,`status` FROM `tab_project_map` where `project_id`=$pid";
             $dr=DB::getInstance()->query($qq);
             if($dr->count()>0)
             {
                  
                echo "<center><h2>Tablet Allocation Report</h2><table border=1>";
                echo "<tr><td> Project</td><td>Tab_Id</td><td>Key</td><td>Status</td></tr>";
                foreach($dr->results() as $r)
                {
                   $tab=$r->tab_id;
                   $pid=$r->project_id;
                   $m=$r->mobile;
                   $s=$r->status;
                   $str="Not Allowed"; if($s==1)$str="Allowed";

                  echo "<tr><td> $pid</td><td>$tab</td><td>$m</td><td>$str </td></tr>"; 
                 }
              }
              else echo "<br><center><font color=red>No any details available for this project</font></center>";
       }
  }
?>
<?php
 if($st==7){
?>
<center>
<h2>Register Inertviewer</h2>
<table border=0>
<form action="" method=post>
<tr><td>Project </td><td><select name="pid" id="pid"><option value="0">--Select--</option><?php $ptt=get_projects_details();if($ptt) foreach($ptt as $p){?><option value="<?php echo $p->project_id; ?>"> <?php echo $p->name;  ?></option> <?php } ?></select></tr>
<tr><td></td><td><input type=text name=mob placeholder="Enter 10 digit number"> </td></tr>
<tr><td></td><td><input type=submit name=pr_mob value=Submit> </td></tr>
</form>

</table>
</center>
<?php
} 

 if(isset($_POST['pr_mob']))
  {
        
        $pid=$_POST['pid'];
        $mb=$_POST['mob'];

        if($pid!=0 && $mb!='')
        {
             $qq="INSERT INTO `tab_project_map`(`project_id`,  `mobile`, `status`) VALUES ($pid,'$mb',1)";
             $dr=DB::getInstance()->query($qq);
             
              
       }else echo "<br><center><font color=red>Enter 10 digit number and select a project</font></center>";
  }
?>


</body>
</html>