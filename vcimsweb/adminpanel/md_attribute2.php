<?php
require_once("../init.php");
require_once("../functions.php");
?>
<center><h2><u>New Booth Score - <i>August onwards</i></u></h2>
<form method=post action="">
Booth Id : <select name=booth id=booth><?php $rr=DB::getInstance()->query("select distinct resp_id from UMEED2_40 order by resp_id"); foreach($rr->results() as $r){ $bth=$r->resp_id; echo "<option value=$bth>$bth</option>";}?></select> 

Month : <select name=mn id=mn><option value=1>Jan </option><option value=2>Feb </option><option value=3>Mar </option><option value=4>Apr </option><option value=5>May </option><option value=6>Jun </option><option value=7>Jul </option><option value=8>Aug </option><option value=9>Sep </option><option value=10>Oct </option><option value=11>Nov </option><option value=12>Dec </option> </select>
Year : <select name=yrs id=yrs><option value=2016>2016 </option><option value=2017>2017</option><option value=2018>2018</option></select>
Group : <select name=gn id=gn><option value=0>--All--</option> <option value=1>Aesthetics </option><option value=4>Hygiene</option><option value=3>Convenience </option></select>
<br><a href="md_clean.php">Clear Dublicate Umeed2 Data</a>
<br><br><input type=submit name=view value="View Booth Score">&nbsp;&nbsp; <input type=submit name=mattr value="View Month Attribute Score"> &nbsp;&nbsp;<input type=submit name=vrank value="View Rank">
<br><br><input type=submit name=update value="Update Monthly Booth Scores"> &nbsp;&nbsp;<input type=submit name=attupdate value="Update Monthly Attribute Scores">
&nbsp;&nbsp;<input type=submit name=urank value="Update Rank">
</form>
</center>


<?php

if(isset($_POST['upad']))
{
     $m=$_POST['mn'];

     $iav=DB::getInstance()->query("SELECT * FROM `umeed_dashboard_attribute` WHERE `month`=$m and grp_id=6");
     if($iav->count()>0)
     {
              echo "Data already available in database";
     }
     else
     {
              $sqq="SELECT * FROM `umeed_dashboard_attribute` WHERE `term` in ('aq10_40','aq12_40','aq13_40','aq14_40','aq15_40','aq16_40','aq17_40','aq18_40','aq19_40','aq20_40','aq21_40','aq22_40','aq23_40','aq26_40','aq27_40','aq28_40','aq29_40','aq30_40','aq31_40','aq32_40','aq33_40','aq4_40','aq5_40','aq6_40','aq7_40','aq8_40') and `month`=$m";
              $gr=DB::getInstance()->query($sqq);
              if($gr->count()>0)
              {
                  foreach($gr->results() as $rr)
                  {
                        $trm=$rr->term; 
                        $as=$rr->attr_score; 
                        $gp=$rr->grp_id; 
                        $mn=$rr->month;
                        
                        echo $qqr="INSERT INTO `umeed_dashboard_attribute`(`term`, `attr_score`, `grp_id`, `month`) VALUES ('$trm',$as,6,$mn);"; 
                        DB::getInstance()->query($qqr);
                        echo "<br>";

                  }      echo "Done ";   
              }
              
     }
}

if(isset($_POST['urank']))
{
	
  	$m=$_POST['mn'];
        
     $iav=DB::getInstance()->query("SELECT `id`, `booth_id`, `booth_score`, `rank`, `a_month` FROM `umeed_dashboard_rank` WHERE `a_month`=$m");
     if($iav->count()>0)
     {
              echo "Data already available in database";
     }
     else
     {
        $vr=DB::getInstance()->query("SELECT booth_id, round(grp_score,1) as score, CASE
    WHEN @prev_value = round(grp_score,1) THEN @rank_count
    WHEN @prev_value := round(grp_score,1) THEN @rank_count := @rank_count + 1
END AS rank
FROM `umeed_dashboard` d, (SELECT @rank_count :=0, @prev_value := NULL) r WHERE `grp_id`=0 and month=$m order by `grp_score` desc;");
  	if($vr->count()>0)
        echo "<table border=1> <tr><td>BOOTH_ID</td><td>BOOTH SCORE</td><td>RANK</td> </tr>";
     	foreach($vr->results() as $r)
        { 
           $bid=$r->booth_id; $bs=$r->score; $rank=$r->rank;
           echo " <tr><td>$bid</td><td>$bs</td><td>$rank</td> </tr>";

           DB::getInstance()->query("INSERT INTO `umeed_dashboard_rank`( `booth_id`, `booth_score`, `rank`, `a_month`) VALUES ($bid,$bs,$rank,$m)");
            
        }
       echo "</table>Booth Rank updated for the month:$m";
    }
}
if(isset($_POST['vrank']))
{
	 
  	$m=$_POST['mn'];

 	$vr=DB::getInstance()->query("SELECT booth_id, round(grp_score,1) as score, CASE
    WHEN @prev_value = round(grp_score,1) THEN @rank_count
    WHEN @prev_value := round(grp_score,1) THEN @rank_count := @rank_count + 1
END AS rank
FROM `umeed_dashboard` d, (SELECT @rank_count :=0, @prev_value := NULL) r WHERE `grp_id`=0 and month=$m order by `grp_score` desc;");
  	if($vr->count()>0)
        echo "<table border=1> <tr><td>BOOTH_ID</td><td>BOOTH SCORE</td><td>RANK</td> </tr>";
     	foreach($vr->results() as $r)
        { 
           $bid=$r->booth_id; $bs=$r->score; $rank=$r->rank;
           echo " <tr><td>$bid</td><td>$bs</td><td>$rank</td> </tr>";
            
        }
     echo "</table>";

}

if(isset($_POST['attupdate']))
{
	//$b=$_POST['booth'];
  	$m=$_POST['mn'];
 	$g=$_POST['gn'];
        $booth_score=0;$sum=0;$avg=0;$cnt=0;$b_id='';
        $mrctr=0; $mavg=0.0;         
        
        $attr_s=array();
     $iav=DB::getInstance()->query("SELECT `id`, `term`, `attr_score`, `grp_id`, `month` FROM `umeed_dashboard_attribute` WHERE `month`=$m");
     if($iav->count()>0)
     {
              echo "Data already available in our database";
     }
     else
     {
        
        $rx=DB::getInstance()->query("SELECT distinct `q_term` FROM `monthly_umeed2_attribute WHERE month=$m`");
  	if($rx->count()>0)
     	foreach($rx->results() as $r)
        {
                 $tnm=$r->q_term; $attr_s[$tnm]=0;
        }

 //echo "<table border=1> <tr><td>BOOTH_ID</td><td>BOOTH SCORE</td> </tr>";
 $b_all=DB::getInstance()->query("select distinct resp_id from UMEED2_40 WHERE MONTH(`visit_month_40`) =$m order by resp_id"); 
 foreach($b_all->results() as $ba)
 {      $mrctr++;
        $booth_score=0;  $b_id=$ba->resp_id;$stra=''; $strb='';$ascore='';
   		 
        // echo '<br>bid:'.$b_id;	  
   	$strb='';$stra='';$t='';$c='';$s='';
    
	if($g == 0) {$stra=' WHERE month=$m'; $strb='';}
        else if($g > 0){ $stra="WHERE group_id=$g AND month=$m";  $strb=" ";}
        
  	$booth_score=0;$actr=-1;

        
  	 $r0=DB::getInstance()->query("SELECT distinct `group_id` FROM `monthly_umeed2_attribute` $stra ");
  	if($r0->count()>0)
     	foreach($r0->results() as $r)
     	{        
     		 $booth_g_score=0;
    		 $grp=$r->group_id;

                 
   		 $qqr1="SELECT distinct `q_term` FROM `monthly_umeed2_attribute`  WHERE group_id=$grp and month=$m";
  		$r1=DB::getInstance()->query($qqr1);
  		if($r1->count()>0)
  		{
     			foreach($r1->results() as $ra)
     			{      $actr++;
       				$t=$ra->q_term; $aw='';$opr='';
       
       				$r2=DB::getInstance()->query("SELECT distinct $t FROM  `UMEED2_40` WHERE MONTH(`visit_month_40`) =$m AND  $t !='' and resp_id=$b_id");
       				if($r2->count()>0)
       				{   
       					$rdata=$r2->first()->$t;
       					$r22=DB::getInstance()->query("SELECT  centre_40,visit_shift_40 FROM  `UMEED2_40` WHERE MONTH(`visit_month_40`) =$m AND  centre_40 !='' and resp_id=$b_id");
       					if($r22->count()>0)
       					$c=$r22->first()->centre_40; $s=$r22->first()->visit_shift_40;
          
       					$r3=DB::getInstance()->query("SELECT a1.`q_term`, a1.`group_id`,a1.`op`, a1.`op_rate`, b1.`grp_wt`, b1.`attr_wt`, b1.`month` FROM `md_umeed2_attribute` as a1 JOIN `monthly_umeed2_attribute` as b1 on a1.q_term=b1.q_term WHERE a1.q_term='$t' AND b1.month=$m a1.op=$rdata");
  					if($r3->count()>0)
  					{
       					$gp=$r3->first()->group_id; $gw=$r3->first()->grp_wt; $aw=$r3->first()->attr_wt; $op=$r3->first()->op; $opr=$r3->first()->op_rate;
  					} 
  	 
  					$ascore=$opr*$aw;
			  		$booth_score=$ascore+$booth_score;
			  		$booth_g_score=$booth_g_score+$ascore;
			  		 //echo '<br> term:'.$t.',resp val:'.$rdata.' , a rate:'.$aw  .' , attr op rate :'.$opr.' , attr score='.$ascore;
                                           //echo '<br> actr: '.$actr.'<br>';
                                        // $attr_s[$actr]=$attr_s[$actr]+$ascore;
                                         $attr_s[$t]=$attr_s[$t]+$ascore;

			  	}
			}  //end of foreach

			//echo "<br>booth group score of id : $b_id =".$booth_g_score;
        
			//echo "<br>c:$c s:$s $iq";
			
		  } //end of r1
  	//echo "<br>booth score of id : $b_id =".$booth_score;
  	}
	//echo "<br>inserted sucessful, booth score of id : $b_id =".$booth_score;
       
	//echo "<br>c:$c s:$s $iq1";
     }
//print_r($attr_s);
echo '<br> mrctr: '.$mrctr; 

   echo "<table border=1 cellpadding='0' cellspacing='0'>";
     $rw1=DB::getInstance()->query("SELECT distinct `q_term` FROM `monthly_umeed2_attribute` where month=$m");
    echo "<tr><td>Q.N.</td><td>Attribute term</td><td>Month Score</td><td>Sum</td></tr>";
      $ctr=-1;$tots=0;
      foreach($rw1->results() as $att)
      {  
          $ctr++; $qt='';$gp='';
          //$av=$attr_s[$ctr]/$mrctr;
          
          
          $tm=$att->q_term;
           $arvl=$attr_s[$tm];
          $av=$arvl/$mrctr;
          $tots=$tots+$av;
         $ggpp=DB::getInstance()->query("SELECT distinct `group_id` FROM `md_umeed2_attribute` WHERE `q_term`='$tm' ");
         if($ggpp->count()>0) $gp=$ggpp->first()->group_id;

          $qd="SELECT `q_title` FROM `question_detail` WHERE `q_id` = (SELECT distinct `q_id` FROM `question_option_detail` WHERE `term`='$tm')";
          $rw1=DB::getInstance()->query($qd);
          if($rw1->count()>0)
                  $qt=$rw1->first()->q_title;
         $aav=round($av,2);
          echo '<br>'.$rtt="INSERT INTO `umeed_dashboard_attribute`(`term`, `attr_score`, `grp_id`, `month`) VALUES ('$tm',$aav,'$gp','$m')";
           $rr=DB::getInstance()->query($rtt);
          echo "<tr><td>$tm</td><td>$qt </td><td> $aav </td><td>$arvl</td></tr>";
      }
   $tots=round($tots,2);
   echo "<tr><td></td><td>Total</td><td> $tots </td><td></td></tr>";
  echo "</table>";
  }

}

if(isset($_POST['mattr']))
{
	//$b=$_POST['booth'];
  	$m=$_POST['mn'];
 	$g=$_POST['gn'];
        $booth_score=0;$sum=0;$avg=0;$cnt=0;$b_id='';
        $mrctr=0; $mavg=0.0;         
        
        $attr_s=array();
 
 //echo "<table border=1> <tr><td>BOOTH_ID</td><td>BOOTH SCORE</td> </tr>";
 $b_all=DB::getInstance()->query("select distinct resp_id from UMEED2_40 WHERE MONTH(`visit_month_40`) =$m order by resp_id"); 
 foreach($b_all->results() as $ba)
 {      $mrctr++;
        $booth_score=0;  $b_id=$ba->resp_id;$stra=''; $strb='';$ascore='';
   		 
        // echo '<br>bid:'.$b_id;	  
   	$strb='';$stra='';$t='';$c='';$s='';
    
	if($g == 0) {$stra=' WHERE month=$m order by group_id'; $strb='';}
        else if($g > 0){ $stra="WHERE `group_id`=$g ";  $strb='';}
        
  	$booth_score=0;$actr=-1;

//echo  "<br>SELECT distinct `group_id` FROM `md_umeed2_attribute` $stra ";

  	 $r0=DB::getInstance()->query("SELECT distinct `group_id` FROM `monthly_umeed2_attribute` $stra ");
  	if($r0->count()>0)
     	foreach($r0->results() as $r)
     	{        
     		 $booth_g_score=0;
    		 $grp=$r->group_id;

                // if($grp==6)
                  //       $grp=1;
   		$qqr1="SELECT distinct `q_term` FROM `monthly_umeed2_attribute`  WHERE `group_id`=$grp and month=$m";
  		$r1=DB::getInstance()->query($qqr1);
  		if($r1->count()>0)
  		{
     			foreach($r1->results() as $ra)
     			{      $actr++;
       				$t=$ra->q_term; $aw='';$opr='';

       				$r2=DB::getInstance()->query("SELECT distinct $t FROM  `UMEED2_40` WHERE MONTH(`visit_month_40`) =$m AND  $t !='' and resp_id=$b_id");
       				if($r2->count()>0)
       				{ 
       					$rdata=$r2->first()->$t;
       					$r22=DB::getInstance()->query("SELECT  centre_40,visit_shift_40 FROM  `UMEED2_40` WHERE MONTH(`visit_month_40`) =$m AND  centre_40 !='' and resp_id=$b_id");
       					if($r22->count()>0)
       					$c=$r22->first()->centre_40; $s=$r22->first()->visit_shift_40;
        
       					$r3=DB::getInstance()->query("SELECT a1.`q_term`, a1.`group_id`,a1.`op`, a1.`op_rate`, b1.`grp_wt`, b1.`attr_wt`, b1.`month` FROM `md_umeed2_attribute` as a1 JOIN `monthly_umeed2_attribute` as b1 on a1.q_term=b1.q_term WHERE a1.q_term='$t' AND b1.month=$m a1.op=$rdata");
  					if($r3->count()>0)
  					{
       					$gp=$r3->first()->group_id; $gw=$r3->first()->grp_wt; $aw=$r3->first()->attr_wt; $op=$r3->first()->op; $opr=$r3->first()->op_rate;
  					} 
  	 
  					$ascore=$opr*$aw;
			  		$booth_score=$ascore+$booth_score;
			  		$booth_g_score=$booth_g_score+$ascore;
			  		  //echo '<br> term:'.$t.',resp val:'.$rdata.' , a rate:'.$aw  .' , attr op rate :'.$opr.' , attr score='.$ascore;
                                           //echo '<br> actr: '.$actr.'<br>';
                                        // $attr_s[$actr]=$attr_s[$actr]+$ascore;
                                         $attr_s[$t]=$attr_s[$t]+$ascore;

			  	}
			}  //end of foreach

			//echo "<br>booth group score of id : $b_id =".$booth_g_score;
        
			//echo "<br>c:$c s:$s $iq";
			
		  } //end of r1
  	//echo "<br>booth score of id : $b_id =".$booth_score;
  	}
	//echo "<br>inserted successful, booth score of id : $b_id =".$booth_score;
       
	//echo "<br>c:$c s:$s $iq1";
     }
//print_r($attr_s);
echo '<br> mrctr: '.$mrctr; 

   echo "<table border=1 cellpadding='0' cellspacing='0'>";
     $rw1=DB::getInstance()->query("SELECT distinct `q_term` FROM `md_umeed2_attribute`");
    echo "<tr><td>Q.N.</td><td>Attribute term</td><td>Month Score</td><td>Sum</td></tr>";
      $ctr=-1;$tots=0;
      foreach($rw1->results() as $att)
      {  
          $ctr++; $qt='';
          //$av=$attr_s[$ctr]/$mrctr;
          
          
          $tm=$att->q_term;
           $arvl=$attr_s[$tm];
          $av=$arvl/$mrctr;
          $tots=$tots+$av;

          $qd="SELECT `q_title` FROM `question_detail` WHERE `q_id` = (SELECT distinct `q_id` FROM `question_option_detail` WHERE `term` ='$tm')";
          $rw1=DB::getInstance()->query($qd);
          if($rw1->count()>0)
                  $qt=$rw1->first()->q_title;
         $aav=round($av,2);
         
          echo "<tr><td>$tm</td><td>$qt </td><td> $aav </td><td>$arvl</td></tr>";
      }
   $tots=round($tots,2);
   echo "<tr><td></td><td>Total</td><td> $tots </td><td></td></tr>";
  echo "</table>";
}
if(isset($_POST['update']))
{
	$b=$_POST['booth'];
  	$m=$_POST['mn'];
 	$g=$_POST['gn'];
   $booth_score=0;$sum=0;$avg=0;$cnt=0;$b_id='';

    $iav=DB::getInstance()->query("SELECT * FROM `umeed_dashboard` WHERE `month`=$m ");
     if($iav->count()>0)
     {
              echo "Data already available in database";
     }
     else
     {
  
 //echo "<table border=1> <tr><td>BOOTH_ID</td><td>BOOTH SCORE</td> </tr>";
 $b_all=DB::getInstance()->query("select distinct resp_id from UMEED2_40 WHERE MONTH(`visit_month_40`) =$m order by resp_id"); 
 foreach($b_all->results() as $ba)
 {    
  $booth_score=0;  $b_id=$ba->resp_id;$stra=''; $strb='';$ascore='';
   		 
       // echo '<br>bid:'.$b_id;	  
   	$strb='';$stra='';$t='';$c='';$s='';
    
	if($g == 0) {$stra="WHERE group_id not in (6,7) and month=$m order by group_id"; $strb='';}
        else if($g > 0){ $stra="WHERE group_id=$g and month=$m";  $strb='';}
        
  	$booth_score=0;
  	 $r0=DB::getInstance()->query("SELECT distinct `group_id` FROM `monthly_umeed2_attribute` $stra ");
  	if($r0->count()>0)
     	foreach($r0->results() as $r)
     	{ 
     		 $booth_g_score=0;
    		 $grp=$r->group_id;
   
   		 $qqr1="SELECT distinct `q_term` FROM `monthly_umeed2_attribute`  WHERE group_id=$grp and month=$m";
  		$r1=DB::getInstance()->query($qqr1);
  		if($r1->count()>0)
  		{
     			foreach($r1->results() as $ra)
     			{    
       				$t=$ra->q_term; $aw='';$opr='';
       
       				$r2=DB::getInstance()->query("SELECT distinct $t FROM  `UMEED2_40` WHERE MONTH(`visit_month_40`) =$m AND  $t !=''  and resp_id=$b_id");
       				if($r2->count()>0)
       				{ 
       					$rdata=$r2->first()->$t;
       					$r22=DB::getInstance()->query("SELECT  centre_40,visit_shift_40 FROM  `UMEED2_40` WHERE MONTH(`visit_month_40`) =$m AND  centre_40 !='' and resp_id=$b_id");
       					if($r22->count()>0)
       					$c=$r22->first()->centre_40; $s=$r22->first()->visit_shift_40;
         
       					$r3=DB::getInstance()->query("SELECT a1.`q_term`, a1.`group_id`,a1.`op`, a1.`op_rate`, b1.`grp_wt`, b1.`attr_wt`, b1.`month` FROM `md_umeed2_attribute` as a1 JOIN `monthly_umeed2_attribute` as b1 on a1.q_term=b1.q_term WHERE a1.q_term='$t' AND b1.month=$m a1.op=$rdata");
  					if($r3->count()>0)
  					{
       					$gp=$r3->first()->group_id; $gw=$r3->first()->grp_wt; $aw=$r3->first()->attr_wt; $op=$r3->first()->op; $opr=$r3->first()->op_rate;
  					} 
  	 
  					$ascore=$opr*$aw;
			  		$booth_score=$ascore+$booth_score;
			  		$booth_g_score=$booth_g_score+$ascore;
			  		// echo '<br> term:'.$t.',resp val:'.$rdata.' , a rate:'.$aw  .' , attr op rate :'.$opr.' , attr score='.$ascore;
                                        if($rdata==2)
                { 
                if($t=='aq9_40' ||  $t=='aq11_40' || $t=='aq26_40' || $t == 'aq31_40' || $t == 'aq16_40' || $t == 'aq22_40' || $t == 'aq34_40')
                {   $arr=  array();
                    $arr1=  array('aq27_40','aq28_40','aq29_40','aq30_40');     
                    $arr2=  array('aq32_40','aq33_40','aq31a_40','aq31b_40','aq31c_40');     
                    $arr3=  array('aq34a_40','aq34b_40');
                     
                    if($t=='aq26_40')
                        $arr=$arr1;
                    if($t=='aq31_40')
                        $arr=$arr2;
                    if($t=='aq34_40')
                        $arr=$arr3;
                    if($t=='aq9_40')
                        $arr=array('aq10_40');
                    if($t=='aq11_40')
                        $arr=array('aq12_40');
                    if($t=='aq16_40')
                        $arr=array('aq17_40');

                    foreach($arr as $key=>$val)
                    {
                        $r3=DB::getInstance()->query("SELECT a1.`q_term`, a1.`group_id`,a1.`op`, a1.`op_rate`, b1.`grp_wt`, b1.`attr_wt`, b1.`month` FROM `md_umeed2_attribute` as a1 JOIN `monthly_umeed2_attribute` as b1 on a1.q_term=b1.q_term WHERE a1.q_term='$val' AND b1.month=$m ");
                        if($r3->count()>0)
                        {
                                $gp=$r3->first()->group_id; $gw=$r3->first()->grp_wt; $aw=$r3->first()->attr_wt; $op=''; $opr=1;
                        

                        $ascore=$opr*$aw;
                        $booth_score=$ascore+$booth_score;
                        $booth_g_score=$booth_g_score+$ascore;
                          //echo '<br>a term:'.$val.',resp val:'.$rdata.' , a rate:'.$aw  .' , attr op rate :'.$opr.' , attr score='.$ascore;
                       }
                    }  
                }
                }           
			  	}
			}  //end of foreach

			//echo "<br>booth group score of id : $b_id =".$booth_g_score;
        

		  echo	'<br>'. $iq="INSERT INTO `umeed_dashboard`( `booth_id`, `month`, `centre`, `shift`,grp_id, `grp_score`) VALUES ($b_id,$m,$c,$s,$grp,$booth_g_score);";
			  DB::getInstance()->query($iq);
			         //echo "<br>c:$c s:$s $iq";
			
		  } //end of r1
  	//echo "<br>booth score of id : $b_id =".$booth_score;
  	}
	//echo "<br>inserted successful, booth score of id : $b_id =".$booth_score;
        $bhml='';
        if($booth_score > 65)
        { $bhml=1;}
        else if($booth_score >54 && $booth_score <66)
        { $bhml=2;}
        else if($booth_score < 55)
        { $bhml=3;}

         echo	'<br>'.  $iq1="INSERT INTO `umeed_dashboard`( `booth_id`, `month`, `centre`, `shift`, grp_id,`grp_score`,hml) VALUES ($b_id,$m,$c,$s,0,$booth_score,$bhml);";
   // echo	'<br>'. $iq2="UPDATE `umeed_dashboard` SET hml=$bhml WHERE booth_id=$b_id and `month`=2 and grp_id=0";
	 DB::getInstance()->query($iq1);
	     //echo "<br>c:$c s:$s $iq1";
   }
  }
}
if(isset($_POST['view']))
{
 //print_r($_POST);
  	$b_id=$_POST['booth'];
  	$m=$_POST['mn'];
 	$g=$_POST['gn'];
        $yrs=$_POST['yrs'];

   	$strb='';$stra='';$t='';$c='';$s='';
    
	if($g == 0) {$stra="WHERE month=$m AND yrs=$yrs"; $strb='';}
        else if($g > 0){ $stra="WHERE group_id=$g and month=$m  AND yrs=$yrs";  $strb=" AND group_id=$g and month=$m  AND yrs=$yrs";}

        
  	$booth_score=0;
  	 $r0=DB::getInstance()->query("SELECT distinct `group_id` FROM `monthly_umeed2_attribute` $stra ");
  	if($r0->count()>0)
     foreach($r0->results() as $r)
     { 
     	$booth_g_score=0;
    echo '<br>grp:'.$grp=$r->group_id;
   
   $qqr1="SELECT distinct `q_term` FROM `monthly_umeed2_attribute`  WHERE group_id=$grp and month=$m AND yrs=$yrs";
  $r1=DB::getInstance()->query($qqr1);
  if($r1->count()>0)
  {
     foreach($r1->results() as $ra)
     {    
        $t=$ra->q_term; $aw='';$opr='';
                       if($yrs==2016)
                       {
		        if($m>7)
                            $eer="SELECT distinct $t FROM  `UMEED2_40` WHERE MONTH(`visit_month_40`) =$m AND year(`visit_month_40`) =$yrs AND $t !='' and resp_id=$b_id";
                        else
                             $eer="SELECT distinct $t FROM  `UMEED_20` WHERE MONTH(`visit_month_20`) =$m AND year(`visit_month_20`) =$yrs AND $t !='' and resp_id=$b_id";
                       }
                       if($yrs>2016)
                       {
                            $eer="SELECT distinct $t FROM  `UMEED2_40` WHERE MONTH(`visit_month_40`) =$m AND year(`visit_month_40`) =$yrs AND $t !='' and resp_id=$b_id";
                       }


       	$r2=DB::getInstance()->query($eer);
       	if($r2->count()>0)
       	{ 
       		$rdata=$r2->first()->$t;
                       if($yrs==2016)
                       {
		        if($m>7)
                            $er="SELECT distinct $t FROM  `UMEED2_40` WHERE MONTH(`visit_month_40`) =$m AND year(`visit_month_40`) =$yrs AND $t !='' and resp_id=$b_id";
                        else
                             $er="SELECT distinct $t FROM  `UMEED_20` WHERE MONTH(`visit_month_20`) =$m AND year(`visit_month_20`) =$yrs AND $t !='' and resp_id=$b_id";
                       }
                       if($yrs>2016)
                       {
                            $er="SELECT distinct $t FROM  `UMEED2_40` WHERE MONTH(`visit_month_40`) =$m AND year(`visit_month_40`) =$yrs AND $t !='' and resp_id=$b_id";
                       }
// echo "<br>$er";
       		$r22=DB::getInstance()->query($er);
       		if($r22->count()>0)
       			$c=$r22->first()->centre_40; $s=$r22->first()->visit_shift_40;
         
       		$r3=DB::getInstance()->query("SELECT a1.`q_term`, a1.`group_id`,a1.`op`, a1.`op_rate`, b1.`grp_wt`, b1.`attr_wt`, b1.`month`, b1.yrs FROM `md_umeed2_attribute` as a1 JOIN `monthly_umeed2_attribute` as b1 on a1.q_term=b1.q_term WHERE a1.q_term='$t' AND b1.month=$m AND b1.yrs=$yrs AND a1.op=$rdata");
  		if($r3->count()>0)
  		{
       			$gp=$r3->first()->group_id; $gw=$r3->first()->grp_wt; $aw=$r3->first()->attr_wt; $op=$r3->first()->op; $opr=$r3->first()->op_rate;
  		} 
 
  		$ascore=$opr*$aw;
  		$booth_score=$ascore+$booth_score;
  		$booth_g_score=$booth_g_score+$ascore;
  		  echo '<br> term:'.$t.',resp val:'.$rdata.' , a rate:'.$aw  .' , attr op rate :'.$opr.' , attr score='.$ascore;
                if($rdata==2)
                {  
                if($t=='aq9_40' ||  $t=='aq11_40' || $t=='aq26_40' || $t == 'aq31_40' || $t == 'aq16_40' || $t == 'aq22_40' || $t == 'aq34_40' || $t == 'aq34c_40')
                {   $arr=  array();
                    $arr1=  array('aq27_40','aq28_40','aq29_40','aq30_40','aq30a_40','aq30b_40');     
                    $arr2=  array('aq32_40','aq33_40','aq31a1_40','aq31b_40','aq31c_40');     
                    $arr3=  array('aq34a_40','aq34b_40');
                     
                    if($t=='aq26_40')
                        $arr=$arr1;
                    if($t=='aq31_40')
                        $arr=$arr2;
                    if($t=='aq34_40')
                        $arr=$arr3;
                    if($t=='aq9_40')
                        $arr=array('aq10_40');
                    if($t=='aq11_40')
                        $arr=array('aq12_40');
                    if($t=='aq16_40')
                        $arr=array('aq17_40');
                    if($t=='aq34c_40')
                        $arr=array('aq34d_40');  

                    foreach($arr as $key=>$val)
                    {
                       
                        $r3=DB::getInstance()->query("SELECT a1.`q_term`, a1.`group_id`,a1.`op`, a1.`op_rate`, b1.`grp_wt`, b1.`attr_wt`, b1.`month`,b1.yrs FROM `md_umeed2_attribute` as a1 JOIN `monthly_umeed2_attribute` as b1 on a1.q_term=b1.q_term WHERE a1.q_term='$val' AND b1.month=$m AND b1.yrs=$yrs AND a1.op=$rdata ");
                        if($r3->count()>0)
                        {
                                $gp=$r3->first()->group_id; $gw=$r3->first()->grp_wt; $aw=$r3->first()->attr_wt; $op=''; $opr=1;
                        

                        $ascore=$opr*$aw;
                        $booth_score=$ascore+$booth_score;
                        $booth_g_score=$booth_g_score+$ascore;
                          echo '<br>a term:'.$val.',resp val:'.$rdata.' , a rate:'.$aw  .' , attr op rate :'.$opr.' , attr score='.$ascore;
                       }
                    }  
                }
                }           
  	}
        
      }  //end of foreach

	echo "<br>booth group score of id : $b =".$booth_g_score;
	//echo "<br>c:$c s:$s";
        //echo '<br>'. $iq="INSERT INTO `umeed_dashboard`( `booth_id`, `month`, `centre`, `shift`,grp_id, `grp_score`) VALUES ($b,$m,$c,$s,$grp,$booth_g_score);";
	
  } //end of r1
  	//echo "<br>booth score of id : $b =".$booth_score;
  }
   echo "<br>booth score of id : $b =".$booth_score;
  //echo "<br>c:$c s:$s";
  //echo '<br>'. $iq="INSERT INTO `umeed_dashboard`( `booth_id`, `month`, `centre`, `shift`,grp_id, `grp_score`) VALUES ($b,$m,$c,$s,0,$booth_score);";
   // /*
  	$booth_score=0;
         $sum=0;$avg=0;$cnt=0;

     	echo "<table border=1> <tr><td>BOOTH_ID</td><td>BOOTH SCORE</td> </tr>";
     	
     	               if($yrs==2016)
                       {
		        if($m>7)
                            $qa="SELECT distinct resp_id FROM  `UMEED2_40` WHERE MONTH(`visit_month_40`) =$m AND year(`visit_month_40`) =$yrs";
                        else
                             $qa="SELECT distinct resp_id FROM  `UMEED_20` WHERE MONTH(`visit_month_20`) =$m AND year(`visit_month_20`) =$yrs";
                       }
                       if($yrs>2016)
                       {
                            $qa="SELECT distinct resp_id FROM  `UMEED2_40` WHERE MONTH(`visit_month_40`) =$m AND year(`visit_month_40`) =$yrs";
                       }
     		
     	$b_all=DB::getInstance()->query($qa); 
     	foreach($b_all->results() as $ba)
     	{    $booth_score=0;
   		$b_id=$ba->resp_id;$stra="WHERE group_id not in (6,7) and month=$m AND yrs=$yrs order by group_id"; $strb='';$ascore='';
   		if($g==0) {$stra="WHERE month=$m AND yrs=$yrs order by group_id"; $strb='';}
        	if($g>0){ $stra=" WHERE group_id=$g and month=$m AND yrs=$yrs "; $strb=" ";}
        
		  $r1=DB::getInstance()->query("SELECT distinct `q_term` FROM `monthly_umeed2_attribute` $stra ");
		  if($r1->count()>0)
		  {
		     foreach($r1->results() as $ra)
		     {    
		       	$t=$ra->q_term;$aw='';$opr='';
                       if($yrs==2016)
                       {
		        if($m>7)
                            $eee="SELECT distinct $t FROM  `UMEED2_40` WHERE MONTH(`visit_month_40`) =$m AND year(`visit_month_40`) =$yrs AND $t !='' and resp_id=$b_id";
                        else
                             $eee="SELECT distinct $t FROM  `UMEED_20` WHERE MONTH(`visit_month_20`) =$m AND year(`visit_month_20`) =$yrs AND $t !='' and resp_id=$b_id";
                       }
                       if($yrs>2016)
                       {
                            $eee="SELECT distinct $t FROM  `UMEED2_40` WHERE MONTH(`visit_month_40`) =$m AND year(`visit_month_40`) =$yrs AND $t !='' and resp_id=$b_id";
                       }
                       

		       	$r2=DB::getInstance()->query($eee);
		       	if($r2->count()>0)
		       	{ 
		       		 $rdata=$r2->first()->$t;
		                 $qqr1="SELECT a1.`q_term`, a1.`group_id`,a1.`op`, a1.`op_rate`, b1.`grp_wt`, b1.`attr_wt`, b1.`month`, b1.yrs FROM `md_umeed2_attribute` as a1 JOIN `monthly_umeed2_attribute` as b1 on a1.q_term=b1.q_term WHERE a1.q_term='$t' AND b1.month=$m AND b1.yrs=$yrs AND a1.op=$rdata";
		       		$r3=DB::getInstance()->query($qqr1);
		  		if($r3->count()>0)
		  		{
		       			$gp=$r3->first()->group_id; $gw=$r3->first()->grp_wt; $aw=$r3->first()->attr_wt; $op=$r3->first()->op; $opr=$r3->first()->op_rate;
		  		} 
		  	
		  	//else { echo "no audit data available for booth_id: $b for $m month"; break;}
		
		 	 //echo '<br> '.$t.'<br>'.$rdata.'<br>a rate:'.$aw  .'<br>attr score:'.$opr;
		  		$ascore=$opr*$aw;
		  	 	$booth_score=$ascore+$booth_score;

		  	  	if($rdata==2)
                { 
                if($t=='aq9_40' ||  $t=='aq11_40' || $t=='aq26_40' || $t == 'aq31_40' || $t == 'aq16_40' || $t == 'aq22_40' || $t == 'aq34_40' || $t == 'aq34c_40')
                {   $arr=  array();
                    $arr1=  array('aq27_40','aq28_40','aq29_40','aq30_40','aq30a_40','aq30b_40');     
                    $arr2=  array('aq32_40','aq33_40','aq31a1_40','aq31b_40','aq31c_40');     
                    $arr3=  array('aq34a_40','aq34b_40');
                     
                    if($t=='aq26_40')
                        $arr=$arr1;
                    if($t=='aq31_40')
                        $arr=$arr2;
                    if($t=='aq34_40')
                        $arr=$arr3;
                    if($t=='aq9_40')
                        $arr=array('aq10_40');
                    if($t=='aq11_40')
                        $arr=array('aq12_40');
                    if($t=='aq16_40')
                        $arr=array('aq17_40');
                    if($t=='aq34c_40')
                        $arr=array('aq34d_40');

                    foreach($arr as $key=>$val)
                    {
                        $r3=DB::getInstance()->query("SELECT a1.`q_term`, a1.`group_id`,a1.`op`, a1.`op_rate`, b1.`grp_wt`, b1.`attr_wt`, b1.`month`, b1.yrs FROM `md_umeed2_attribute` as a1 JOIN `monthly_umeed2_attribute` as b1 on a1.q_term=b1.q_term WHERE a1.q_term='$val' AND b1.month=$m AND b1.yrs=$yrs  AND a1.op=$rdata ");
                        if($r3->count()>0)
                        {
                                $gp=$r3->first()->group_id; $gw=$r3->first()->grp_wt; $aw=$r3->first()->attr_wt; $op=''; $opr=1;
                        

                        $ascore=$opr*$aw;
                        $booth_score=$ascore+$booth_score;
                         
                          //echo '<br>a term:'.$val.',resp val:'.$rdata.' , a rate:'.$aw  .' , attr op rate :'.$opr.' , attr score='.$ascore;
                       }
                    }  
                }
                } 

		  	}
		     }  //end of foreach
		
			//echo '<br>booth score:'.$booth_score;
			
		  } //end of r2
                  $sum=$sum+$booth_score;
		  $cnt++;
   		
		echo "<tr><td>$b_id</td><td>$booth_score</td></tr>";
     	} //end of foreach
     	echo "<br> booth SUM=$sum/$cnt";
          echo '<br> booth avg='.$sum/$cnt;
          
         // */
          
}

?>

<script type="text/javascript">
  document.getElementById('mn').value = "<?php echo $_POST['mn'];?>";
  document.getElementById('yrs').value = "<?php echo $_POST['yrs'];?>";
  document.getElementById('gn').value = "<?php echo $_POST['gn'];?>";
  document.getElementById('booth').value = "<?php echo $_POST['booth'];?>"; 
</script>