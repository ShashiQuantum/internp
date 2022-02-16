<?php
include_once('../../init.php');
include_once('../../functions.php');

if(!Session::exists('suser'))
{
	Redirect::to('../login_fp.php');
}
?>

<center>
<h2>Referral Summary Report</h2>
<table border='1' cellpadding='0' cellspacing='0' style='margin-left:75px'>
<form action="" method=post>
<tr><td>Month : </td><td><select name=mn id=mn><option value=0>All</option><option value=1>Jan </option><option value=2>Feb </option><option value=3>Mar </option><option value=4>Apr </option><option value=5>May </option><option value=6>Jun </option><option value=7>Jul </option><option value=8>Aug </option><option value=9>Sep </option><option value=10>Oct </option><option value=11>Nov </option><option value=12>Dec </option> </select>
 </td><td><input type=submit name=sreport value=View> </td></tr>
</form>

</table>


<?php
if(isset($_POST['sreport']))
{
     $m=$_POST['mn'];
     $tcnt=0;$icnt=0; $picnt=0;$nicnt=0;
   
   	if($m==0)
   	{
   	     $av=DB::getInstance()->query("SELECT count(distinct `user_id`) as tcnt FROM `app_user`  order by user_id");
	     if($av->count()>0)
	     {        $tcnt=$av->first()->tcnt;
	              //echo "<br><b>Report : <font color=red>$cnt</font> for month: <font color=red> $m </font></b><br><br>";
	     }
		//Grand Total of Registered User
	     $iav2=DB::getInstance()->query("SELECT COUNT(DISTINCT resp_id) as cnt FROM  `mangopinion_57` WHERE  `ref` REGEXP  '^[0-9]+$' AND ref>0 AND resp_id in (SELECT `user_id` FROM `app_user`)");
	     if($iav2->count()>0)
	     {        $icnt=$iav2->first()->cnt;
	              //echo "<br><b>Report : <font color=red>$cnt</font> for month: <font color=red> $m </font></b><br><br>";
	     }
	     //total register with updated profile
	     //Total registerd user of a month
	     $iav3=DB::getInstance()->query("SELECT COUNT(DISTINCT resp_id) as cnt FROM  `mangopinion_57` WHERE  `ref` REGEXP  '^[0-9]+$' AND ref>0 AND resp_id in (SELECT distinct `resp_id` FROM  `mangopinion_57` WHERE  `i_date_57`!='' order by resp_id)");
	     if($iav3->count()>0)
	     {        $picnt=$iav3->first()->cnt;
	              //echo "<br><b>Report : <font color=red>$cnt</font> for month: <font color=red> $m </font></b><br><br>";
	     }
	     $nicnt=$icnt-$picnt;
   	}
   	if($m > 0)
   	{
	     $av=DB::getInstance()->query("SELECT count(`user_id`) as tcnt FROM `app_user` WHERE month(`create_date`)=$m order by user_id");
	     if($av->count()>0)
	     {        $tcnt=$av->first()->tcnt;
	              //echo "<br><b>Report : <font color=red>$cnt</font> for month: <font color=red> $m </font></b><br><br>";
	     }
		//Total registerd user of a month
	     $iav2=DB::getInstance()->query("SELECT COUNT(DISTINCT resp_id) as cnt FROM  `mangopinion_57` WHERE  `ref` REGEXP  '^[0-9]+$' AND ref>0 AND resp_id in (SELECT `user_id` FROM `app_user` WHERE month(`create_date`)=$m order by user_id)");
	     if($iav2->count()>0)
	     {        $icnt=$iav2->first()->cnt;
	              //echo "<br><b>Report : <font color=red>$cnt</font> for month: <font color=red> $m </font></b><br><br>";
	     }
	     
	     //total register with updated profile
	     //Total registerd user of a month
	     $iav3=DB::getInstance()->query("SELECT COUNT(DISTINCT resp_id) as cnt FROM  `mangopinion_57` WHERE  `ref` REGEXP  '^[0-9]+$' AND ref>0 AND resp_id in (SELECT distinct `resp_id` FROM  `mangopinion_57` WHERE MONTH(  `i_date_57` ) =$m order by resp_id)");
	     if($iav3->count()>0)
	     {        $picnt=$iav3->first()->cnt;
	              //echo "<br><b>Report : <font color=red>$cnt</font> for month: <font color=red> $m </font></b><br><br>";
	     }
	      $nicnt=$icnt-$picnt;
	}
	

     	//echo "<br><b>Total User : <font color=red>$tcnt</font></b><br><b>Total User Registered by interviewer : <font color=red>$icnt</font></b><br><br>";
     
     	echo "<br><table border=1>";
     	echo "<tr bgcolor=lightgray><td>S.N.</td><td>Total Users</td><td>Total by Interviewer</td><td>Total Profile Update [Pending by Interviewer]</td><td>Total Profile Update [Pending by Non-Interviewer]</td></tr>";
	echo "<tr><td>1.</td><td>$tcnt</td><td>$icnt</td><td>$picnt</td><td>$nicnt</td></tr>";
}

?>
