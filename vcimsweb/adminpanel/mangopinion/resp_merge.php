<?php
require_once('../../init.php');

if(isset($_POST['submit2']))
{
      $qqr="select distinct q_id from ques_respondent";
      $dd1=DB::getInstance()->query($qqr);
      $qset_list='';$nctr=0;
        foreach($dd1->results() as $p)
        {
        	if($nctr==0) $qset_list=$p->q_id;
        	else
        		$qset_list.=','.$p->q_id;
        	$nctr++;
        }
         
   	 $ddd1=DB::getInstance()->query("SELECT `name`, project_id FROM `project` WHERE `project_id`=(SELECT distinct `project_id` FROM `questionset` WHERE `qset_id`in ($qset_list))");

	if($ddd1->count()>0)
  	{  $pnn=$ddd1->first()->name;$pid=$ddd1->first()->project_id;}
  
    $db=DB::getInstance()->query("select a.resp_id,b.q_id,a.name,a.age,a.address,a.mob,b.res_fm_profession_1,b.ch_ag_6_14_age_1,b.ch_ag_6_14_gen_1,b.p_high_fm_expd_occup,b.p_high_fm_expd_educ,b.sec_grid from respondent a join ques_respondent b on a.resp_id=b.resp_id");
       if($db->count()>0)
       {
           foreach($db->results() as $r)
           {
              $a1=$r->resp_id;$a2=$r->q_id;$a3=$r->name;$a4=$r->address;$a5=$r->mob;$a6=$r->age;$a7=$r->ch_ag_6_14_age_1;
              $a8=$r->ch_ag_6_14_gen_1;$a9=$r->p_high_fm_expd_occup;$a10=$r->p_high_fm_expd_educ;$a11=$r->sec_grid;
              
		 //$qr1="INSERT INTO `respondent_detail`(`resp_id`, `pid`, `name`, `mobile`, `address`, `age_yrs`, `educ`, `occup`, `sec`, `gender`, `source`, `hfd_consume`, `m_status`,  `kid1_age`, `family_details`, `last_update`) VALUES ($a1,$pid,'$a3','$a5','$a4',$a6,$a10,$a9,$a11,2,3,2,4,$a7,3,'2014-11-14')";
		//$qr2="INSERT INTO `respondent_project`( `resp_id`, `p_id`, `dates`, `r_mode`) VALUES ($a1,$pid,'2014-11-14',3)";
echo "<br>". $qr1="UPDATE respondent_detail SET address='$a4' WHERE resp_id=$a1";		
               //echo "<br>$a1 = $a2 = $a3 = $a4 = $a5 =  $a8 = $a9 = $a10 = $a11";
               //DB::getInstance()->query($qr1);
               //DB::getInstance()->query($qr2);
               
           }
          echo "<br>Saved sucessfully";
       }
}



if(isset($_POST['submit']))
{
      $qqr="select distinct q_id from ques_respondent";
      $dd1=DB::getInstance()->query($qqr);
      $qset_list='';$nctr=0;
        foreach($dd1->results() as $p)
        {
        	if($nctr==0) $qset_list=$p->q_id;
        	else
        		$qset_list.=','.$p->q_id;
        	$nctr++;
        }
         
   	 $ddd1=DB::getInstance()->query("SELECT `name`, project_id FROM `project` WHERE `project_id`=(SELECT distinct `project_id` FROM `questionset` WHERE `qset_id`in ($qset_list))");

	if($ddd1->count()>0)
  	{  $pnn=$ddd1->first()->name;$pid=$ddd1->first()->project_id;}
  
    $db=DB::getInstance()->query("select a.resp_id,b.q_id,a.name,a.age,a.address,a.mob,b.res_fm_profession_1,b.ch_ag_6_14_age_1,b.ch_ag_6_14_gen_1,b.p_high_fm_expd_occup,b.p_high_fm_expd_educ,b.sec_grid from respondent a join ques_respondent b on a.resp_id=b.resp_id");
       if($db->count()>0)
       {
           foreach($db->results() as $r)
           {
              $a1=$r->resp_id;$a2=$r->q_id;$a3=$r->name;$a4=$r->address;$a5=$r->mob;$a6=$r->age;$a7=$r->ch_ag_6_14_age_1;
              $a8=$r->ch_ag_6_14_gen_1;$a9=$r->p_high_fm_expd_occup;$a10=$r->p_high_fm_expd_educ;$a11=$r->sec_grid;
              
		 //$qr1="INSERT INTO `respondent_detail`(`resp_id`, `pid`, `name`, `mobile`, `address`, `age_yrs`, `educ`, `occup`, `sec`, `gender`, `source`, `hfd_consume`, `m_status`,  `kid1_age`, `family_details`, `last_update`) VALUES ($a1,$pid,'$a3','$a5','$a4',$a6,$a10,$a9,$a11,2,3,2,4,$a7,3,'2014-11-14')";
		//$qr2="INSERT INTO `respondent_project`( `resp_id`, `p_id`, `dates`, `r_mode`) VALUES ($a1,$pid,'2014-11-14',3)";
echo "<br>". $qr1="UPDATE respondent_detail SET address='$a4' WHERE resp_id=$a1";		
               //echo "<br>$a1 = $a2 = $a3 = $a4 = $a5 =  $a8 = $a9 = $a10 = $a11";
               //DB::getInstance()->query($qr1);
               //DB::getInstance()->query($qr2);
               
           }
          echo "<br>Saved sucessfully";
       }
}
	
?>

<form action='' method='post'>
<input type=submit name=submit value="GSK">
</form>