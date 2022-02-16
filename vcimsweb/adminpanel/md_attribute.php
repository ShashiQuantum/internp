<?php
require_once("../init.php");
require_once("../functions.php");

?>
<form method=post action="">
Booth Id : <select name=booth id=booth><?php $rr=DB::getInstance()->query("select distinct resp_id from UMEED_20 order by resp_id"); foreach($rr->results() as $r){ $bth=$r->resp_id; echo "<option value=$bth>$bth</option>";}?></select> 

Month : <select name=mn id=mn><option value=1>Jan </option><option value=2>Feb </option><option value=3>Mar </option><option value=4>Apr </option><option value=5>May </option><option value=6>Jun </option><option value=7>Jul </option><option value=8>Aug </option><option value=9>Sep </option><option value=10>Oct </option><option value=11>Nov </option><option value=12>Dec </option> </select>
Group : <select name=gn id=gn><option value=0>--All--</option> <option value=1>Aesthetics </option><option value=2>Behaviour </option><option value=3>Convenience </option><option value=4>Hygiene </option><option value=5>Product Avaiblity </option><option value=6>Advertisement </option><option value=7>Hording Advertisement </option><option value=8>Base Poster Advertisement </option><option value=9>Dangler Advertisement </option><option value=10>Wall Poster Advertisement </option></select>

<input type=submit name=view value=View> <input type=submit name=update value="Update Monthly Booth Scores"> <input type=submit name=attupdate value="Update Monthly Attribute Scores"><input type=submit name=mattr value="View Month Attribute Score">
<input type=submit name=vrank value="View Rank"><input type=submit name=urank value="Update Rank">
<input type=submit name=upad value="Adv Update">
<br><input type=submit name=view2 value=View2>
</form>


<?php
//$string="132abc";
//echo intval(preg_replace('/[^0-9]+/', '', $string), 10);
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
              $sqq="SELECT * FROM `umeed_dashboard_attribute` WHERE `term` in ( 'fq35_1_20','fq35_2_20','fq35_3_20','fq35_5_20','fq38_1_20','fq38_2_20','fq38_3_20','fq38_5_20','fq39_1_20','fq39_2_20','fq39_3_20','fq39_5_20','fq40_1_20','fq40_2_20','fq40_3_20','fq40_5_20','fq41_1_20','fq41_2c_20','fq41_3_20','fq41_5_20','fq42_5_20') and `month`=$m";
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
        
        $rx=DB::getInstance()->query("SELECT distinct `q_term` FROM `md_umeed_attribute`");
  	if($rx->count()>0)
     	foreach($rx->results() as $r)
        {
                 $tnm=$r->q_term; $attr_s[$tnm]=0;
        }

 //echo "<table border=1> <tr><td>BOOTH_ID</td><td>BOOTH SCORE</td> </tr>";
 $b_all=DB::getInstance()->query("select distinct resp_id from UMEED_20 WHERE MONTH(`visit_month_20`) =$m order by resp_id"); 
 foreach($b_all->results() as $ba)
 {      $mrctr++;
        $booth_score=0;  $b_id=$ba->resp_id;$stra=''; $strb='';$ascore='';
   		 
        // echo '<br>bid:'.$b_id;	  
   	$strb='';$stra='';$t='';$c='';$s='';
    
	if($g == 0) {$stra=''; $strb='';}
        else if($g > 0){ $stra="WHERE group_id=$g";  $strb=" AND group_id=$g";}
        
  	$booth_score=0;$actr=-1;

        
  	 $r0=DB::getInstance()->query("SELECT distinct `group_id` FROM `md_umeed_attribute` $stra ");
  	if($r0->count()>0)
     	foreach($r0->results() as $r)
     	{        
     		 $booth_g_score=0;
    		 $grp=$r->group_id;

                 
   		 $qqr1="SELECT distinct `q_term` FROM `md_umeed_attribute`  WHERE group_id=$grp";
  		$r1=DB::getInstance()->query($qqr1);
  		if($r1->count()>0)
  		{
     			foreach($r1->results() as $ra)
     			{      $actr++;
       				$t=$ra->q_term; $aw='';$opr='';
       
       				$r2=DB::getInstance()->query("SELECT distinct $t FROM  `UMEED_20` WHERE MONTH(`visit_month_20`) =$m AND  $t !='' and resp_id=$b_id");
       				if($r2->count()>0)
       				{ 
       					$rdata=$r2->first()->$t;
       					$r22=DB::getInstance()->query("SELECT  centre_20,visit_shift_20 FROM  `UMEED_20` WHERE MONTH(`visit_month_20`) =$m AND  centre_20 !='' and resp_id=$b_id");
       					if($r22->count()>0)
       					$c=$r22->first()->centre_20; $s=$r22->first()->visit_shift_20;
         
       					$r3=DB::getInstance()->query("SELECT `id`, `q_term`, `group_id`, `grp_wt`, `attr_wt`, `op`, `op_rate` FROM `md_umeed_attribute` WHERE op=$rdata AND q_term='$t' $strb ");
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
     $rw1=DB::getInstance()->query("SELECT distinct `q_term` FROM `md_umeed_attribute`");
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
         $ggpp=DB::getInstance()->query("SELECT distinct `group_id` FROM `md_umeed_attribute` WHERE `q_term`='$tm' ");
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
 if($m>5)
 $b_all=DB::getInstance()->query("select distinct resp_id from UMEED_20 WHERE MONTH(`visit_month_20`) =$m order by resp_id"); 
 else
 $b_all=DB::getInstance()->query("select distinct resp_id from vcimstest.UMEED_20 WHERE MONTH(`visit_month_20`) =$m order by resp_id"); 
 
 foreach($b_all->results() as $ba)
 {      $mrctr++;
        $booth_score=0;  $b_id=$ba->resp_id;$stra=''; $strb='';$ascore='';
   		 
        // echo '<br>bid:'.$b_id;	  
   	$strb='';$stra='';$t='';$c='';$s='';
    
	if($g == 0) {$stra=''; $strb='';}
        else if($g > 0){ $stra="WHERE `grp_id`=$g";  $strb=" AND `group_id`=$g";}
        
  	$booth_score=0;$actr=-1;

        //echo  "<br>SELECT distinct `grp_id` FROM `md_umeed_attribute` $stra ";

  	 $r0=DB::getInstance()->query("SELECT distinct `grp_id` FROM `umeed_dashboard_attribute` $stra ");
  	if($r0->count()>0)
     	foreach($r0->results() as $r)
     	{        
     		 $booth_g_score=0;
    		 $grp=$r->grp_id;

                // if($grp==6)
                  //       $grp=1;
   		$qqr1="SELECT distinct `q_term` FROM `md_umeed_attribute`  WHERE `group_id`=$grp";
  		$r1=DB::getInstance()->query($qqr1);
  		if($r1->count()>0)
  		{
     			foreach($r1->results() as $ra)
     			{      $actr++;
       				$t=$ra->q_term; $aw='';$opr='';

                   		if($m>5)
       					$r2=DB::getInstance()->query("SELECT distinct $t FROM  `UMEED_20` WHERE MONTH(`visit_month_20`) =$m AND  $t !='' and resp_id=$b_id");
       				else
       					$r2=DB::getInstance()->query("SELECT distinct $t FROM  vcimstest.`UMEED_20` WHERE MONTH(`visit_month_20`) =$m AND  $t !='' and resp_id=$b_id");
       				
       				if($r2->count()>0)
       				{ 
       					$rdata=$r2->first()->$t;
       					if($m>5)
       						$tr="SELECT  centre_20,visit_shift_20 FROM  `UMEED_20` WHERE MONTH(`visit_month_20`) =$m AND  centre_20 !='' and resp_id=$b_id";
       					else
       						$tr="SELECT  centre_20,visit_shift_20 FROM  `UMEED_20` WHERE MONTH(`visit_month_20`) =$m AND  centre_20 !='' and resp_id=$b_id";
       					$r22=DB::getInstance()->query($tr);
       					if($r22->count()>0)
       					$c=$r22->first()->centre_20; $s=$r22->first()->visit_shift_20;
        // echo "<br>SELECT `id`, `q_term`, `group_id`, `grp_wt`, `attr_wt`, `op`, `op_rate` FROM `md_umeed_attribute` WHERE op=$rdata AND q_term='$t' $strb ";
       					$r3=DB::getInstance()->query("SELECT `id`, `q_term`, `group_id`, `grp_wt`, `attr_wt`, `op`, `op_rate` FROM `md_umeed_attribute` WHERE op=$rdata AND q_term='$t' $strb ");
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
     $rw1=DB::getInstance()->query("SELECT distinct `q_term` FROM `md_umeed_attribute`");
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
 $b_all=DB::getInstance()->query("select distinct resp_id from UMEED_20 WHERE MONTH(`visit_month_20`) =$m order by resp_id"); 
 foreach($b_all->results() as $ba)
 {    
  $booth_score=0;  $b_id=$ba->resp_id;$stra=''; $strb='';$ascore='';
   		 
       // echo '<br>bid:'.$b_id;	  
   	$strb='';$stra='';$t='';$c='';$s='';
    
	if($g == 0) {$stra='WHERE group_id not in (6,7,8,9,10)'; $strb='';}
        else if($g > 0){ $stra="WHERE group_id=$g";  $strb=" AND group_id=$g";}
        
  	$booth_score=0;
  	 $r0=DB::getInstance()->query("SELECT distinct `group_id` FROM `md_umeed_attribute` $stra ");
  	if($r0->count()>0)
     	foreach($r0->results() as $r)
     	{ 
     		 $booth_g_score=0;
    		 $grp=$r->group_id;
   
   		 $qqr1="SELECT distinct `q_term` FROM `md_umeed_attribute`  WHERE group_id=$grp AND q_term not in('fq15_20','cq2_20')";
  		$r1=DB::getInstance()->query($qqr1);
  		if($r1->count()>0)
  		{
     			foreach($r1->results() as $ra)
     			{    
       				$t=$ra->q_term; $aw='';$opr='';
       
       				$r2=DB::getInstance()->query("SELECT distinct $t FROM  `UMEED_20` WHERE MONTH(`visit_month_20`) =$m AND  $t !=''  and resp_id=$b_id");
       				if($r2->count()>0)
       				{ 
       					$rdata=$r2->first()->$t;
       					$r22=DB::getInstance()->query("SELECT  centre_20,visit_shift_20 FROM  `UMEED_20` WHERE MONTH(`visit_month_20`) =$m AND  centre_20 !='' and resp_id=$b_id");
       					if($r22->count()>0)
       					$c=$r22->first()->centre_20; $s=$r22->first()->visit_shift_20;
         
       					$r3=DB::getInstance()->query("SELECT `id`, `q_term`, `group_id`, `grp_wt`, `attr_wt`, `op`, `op_rate` FROM `md_umeed_attribute` WHERE op=$rdata AND q_term='$t' $strb ");
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
                if($t=='fq35_1_20' ||  $t=='fq35_3_20' || $t=='fq35_5_20' || $t=='fq17_20')
                {   $arr=  array();
                    $arr1=  array('fq38_1_20','fq39_1_20','fq40_1_20');     
                    $arr2=  array('fq38_2_20','fq39_2_20','fq40_2_20');     
                    $arr3=  array('fq38_3_20','fq39_3_20','fq40_3_20','fq41_3_20');     
                    $arr4=  array('fq38_5_20','fq39_5_20','fq40_5_20','fq41_5_20','fq42_5_20');     
                
                    if($t=='fq35_1_20')
                        $arr=$arr1;
                    //if($t=='fq35_2_20')
                       //$arr=$arr2;
                    if($t=='fq35_3_20')
                        $arr=$arr3;
                    if($t=='fq35_5_20')
                        $arr=$arr4;
                    if($t=='fq19_20')
                        $arr=array('fq19_20');

                    foreach($arr as $key=>$val)
                    {
                        $r3=DB::getInstance()->query("SELECT `id`, `q_term`, `group_id`, `grp_wt`, `attr_wt`, `op`, `op_rate` FROM `md_umeed_attribute` WHERE q_term='$val' $strb ");
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
	//echo "<br>inserted sucessful, booth score of id : $b_id =".$booth_score;
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
  	$b=$_POST['booth'];
  	$m=$_POST['mn'];
 	$g=$_POST['gn'];
  
   	$strb='';$stra='';$t='';$c='';$s='';
    
	if($g == 0) {$stra='WHERE group_id not in (6,7,8,9,10)'; $strb='';}
        else if($g > 0){ $stra="WHERE group_id=$g";  $strb=" AND group_id=$g";}
        
  	$booth_score=0;
  	 $r0=DB::getInstance()->query("SELECT distinct `group_id` FROM `md_umeed_attribute` $stra ");
  	if($r0->count()>0)
     foreach($r0->results() as $r)
     { 
     	$booth_g_score=0;
    echo '<br>grp:'.$grp=$r->group_id;
   
   $qqr1="SELECT distinct `q_term` FROM `md_umeed_attribute`  WHERE group_id=$grp and q_term not in('fq15_20','cq2_20')";
  $r1=DB::getInstance()->query($qqr1);
  if($r1->count()>0)
  {
     foreach($r1->results() as $ra)
     {    
        $t=$ra->q_term; $aw='';$opr='';
       if($m>5)
         $eer="SELECT distinct $t FROM  `UMEED_20` WHERE MONTH(`visit_month_20`) =$m AND  $t !=''  and resp_id=$b";
       else
         $eer="SELECT distinct $t FROM  vcimstest.`UMEED_20` WHERE MONTH(`visit_month_20`) =$m AND  $t !='' and resp_id=$b";
 
       	$r2=DB::getInstance()->query($eer);
       	if($r2->count()>0)
       	{ 
       		$rdata=$r2->first()->$t;
               if($m>5)
                   $er="SELECT  centre_20,visit_shift_20 FROM  `UMEED_20` WHERE MONTH(`visit_month_20`) =$m AND  centre_20 !='' and resp_id=$b";
               else
                   $er="SELECT  centre_20,visit_shift_20 FROM  vcimstest.`UMEED_20` WHERE MONTH(`visit_month_20`) =$m AND  centre_20 !='' and resp_id=$b";
  
       		$r22=DB::getInstance()->query($er);
       		if($r22->count()>0)
       			$c=$r22->first()->centre_20; $s=$r22->first()->visit_shift_20;
         
       		$r3=DB::getInstance()->query("SELECT `id`, `q_term`, `group_id`, `grp_wt`, `attr_wt`, `op`, `op_rate` FROM `md_umeed_attribute` WHERE op=$rdata AND q_term='$t' $strb ");
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
                if($t=='fq35_1_20' ||  $t=='fq35_3_20' || $t=='fq35_5_20' || $t == '$fq17_20')
                {   $arr=  array();
                    $arr1=  array('fq38_1_20','fq39_1_20','fq40_1_20');     
                    $arr2=  array('fq38_2_20','fq39_2_20','fq40_2_20');     
                    $arr3=  array('fq38_3_20','fq39_3_20','fq40_3_20','fq41_3_20');     
                    $arr4=  array('fq38_5_20','fq39_5_20','fq40_5_20','fq41_5_20','fq42_5_20');     
                
                    if($t=='fq35_1_20')
                        $arr=$arr1;
                    //if($t=='fq35_2_20')
                        //$arr=$arr2;
                    if($t=='fq35_3_20')
                        $arr=$arr3;
                    if($t=='fq35_5_20')
                        $arr=$arr4;
                     if($t=='fq19_20')
                        $arr=array('fq19_20');

                    foreach($arr as $key=>$val)
                    {
                        $r3=DB::getInstance()->query("SELECT `id`, `q_term`, `group_id`, `grp_wt`, `attr_wt`, `op`, `op_rate` FROM `md_umeed_attribute` WHERE q_term='$val' $strb ");
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
     	
     	if($m>5)
     		$qa="select distinct resp_id from UMEED_20 WHERE MONTH(`visit_month_20`) =$m order by resp_id";
     	else
     		$qa="select distinct resp_id from vcimstest.UMEED_20 WHERE MONTH(`visit_month_20`) =$m order by resp_id";
     		
     	$b_all=DB::getInstance()->query($qa); 
     	foreach($b_all->results() as $ba)
     	{    $booth_score=0;
   		$b_id=$ba->resp_id;$stra='WHERE group_id not in (6,7,8,9,10)'; $strb='';$ascore='';
   		if($g==0) {$stra="WHERE q_term not in('fq15_20','cq2_20') "; $strb='';}
        	if($g>0){ $stra=" WHERE group_id=$g "; $strb=" AND group_id=$g";}
        
		  $r1=DB::getInstance()->query("SELECT distinct `q_term` FROM `md_umeed_attribute` $stra ");
		  if($r1->count()>0)
		  {
		     foreach($r1->results() as $ra)
		     {    
		       	$t=$ra->q_term;$aw='';$opr='';
		        if($m>5)
                            $eee="SELECT distinct $t FROM  `UMEED_20` WHERE MONTH(`visit_month_20`) =$m AND  $t !='' and resp_id=$b_id";
                        else
                             $eee="SELECT distinct $t FROM  vcimstest.`UMEED_20` WHERE MONTH(`visit_month_20`) =$m AND  $t !='' and resp_id=$b_id";

		       	$r2=DB::getInstance()->query($eee);
		       	if($r2->count()>0)
		       	{ 
		       		 $rdata=$r2->first()->$t;
		                 $qqr1="SELECT  `q_term`, `group_id`, `grp_wt`, `attr_wt`, `op`, `op_rate` FROM `md_umeed_attribute` WHERE op=$rdata AND q_term='$t' $strb ";
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
                if($t=='fq35_1_20' ||  $t=='fq35_3_20' || $t=='fq35_5_20' || $t=='fq17_20')
                {   $arr=  array();
                    $arr1=  array('fq38_1_20','fq39_1_20','fq40_1_20');     
                    $arr2=  array('fq38_2_20','fq39_2_20','fq40_2_20');     
                    $arr3=  array('fq38_3_20','fq39_3_20','fq40_3_20','fq41_3_20');     
                    $arr4=  array('fq38_5_20','fq39_5_20','fq40_5_20','fq41_5_20','fq42_5_20');     
                
                    if($t=='fq35_1_20')
                        $arr=$arr1;
                    //if($t=='fq35_2_20')
                        //$arr=$arr2;
                    if($t=='fq35_3_20')
                        $arr=$arr3;
                    if($t=='fq35_5_20')
                        $arr=$arr4;
                    if($t=='fq19_20')
                        $arr=array('fq19_20'); 

                    foreach($arr as $key=>$val)
                    {
                        $r3=DB::getInstance()->query("SELECT `id`, `q_term`, `group_id`, `grp_wt`, `attr_wt`, `op`, `op_rate` FROM `md_umeed_attribute` WHERE q_term='$val' $strb ");
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

//=================
if(isset($_POST['view2']))
{
 //print_r($_POST);
  	$b=$_POST['booth'];
  	$m=$_POST['mn'];
 	$g=$_POST['gn'];
  
   	$strb='';$stra='';$t='';$c='';$s='';
    
	 if($g == 0) {$stra='WHERE group_id not in (2,5,6,7,8,9,10)'; $strb='';}
         else if($g > 0){ $stra="WHERE group_id=$g";  $strb=" AND group_id=$g";}
        
  	$booth_score=0;
  	$r0=DB::getInstance()->query("SELECT distinct `group_id` FROM `md_umeed_attribute` $stra ");
  	if($r0->count()>0)
        {
            foreach($r0->results() as $r)
            { 
                $booth_g_score=0;
                echo '<br>grp:'.$grp=$r->group_id;
    
                if($grp==0)
                   $qqr1="SELECT distinct `q_term` FROM `md_umeed_attribute`  WHERE  q_term  in('fq14_20','fq23_20','fq31_20','fq32_20','fq34_20','fq35_1_20','fq35_3_20','fq35_5_20','fq38_1_20','fq38_3_20','fq38_5_20','fq39_1_20','fq39_3_20','fq39_5_20','fq3_20','fq40_1_20','fq40_3_20','fq40_5_20','fq41_3_20','fq41_5_20','fq42_5_20','fq4_20','fq5_20','fq25_20','fq28_n_20','fq29_n_20','cq2_20','cq3_20','fq19_20','fq1_20','fq20_20','fq27_20' )";
                if($grp==1)
                   $qqr1="SELECT distinct `q_term` FROM `md_umeed_attribute`  WHERE  q_term  in('fq14_20','fq23_20','fq31_20','fq32_20','fq34_20','fq35_1_20','fq35_3_20','fq35_5_20','fq38_1_20','fq38_3_20','fq38_5_20','fq39_1_20','fq39_3_20','fq39_5_20','fq3_20','fq40_1_20','fq40_3_20','fq40_5_20','fq41_3_20','fq41_5_20','fq42_5_20','fq4_20','fq5_20')";
                if($grp==3)
                   $qqr1="SELECT distinct `q_term` FROM `md_umeed_attribute`  WHERE  q_term  in('fq25_20','fq28_n_20','fq29_n_20')";
                if($grp==4)
                   $qqr1="SELECT distinct `q_term` FROM `md_umeed_attribute`  WHERE  q_term  in('cq2_20','cq3_20','fq19_20','fq1_20','fq20_20','fq27_20')";
                
                //if($grp>=5)
                    //$qqr1="SELECT distinct `q_term` FROM `md_umeed_attribute`  WHERE group_id=$grp";

                $r1=DB::getInstance()->query($qqr1);
                if($r1->count()>0)
                {
                        foreach($r1->results() as $ra)
                        {    
                           $t=$ra->q_term; $aw='';$opr='';
                          if($m>5)
                            $eer="SELECT distinct $t FROM  `UMEED_20` WHERE MONTH(`visit_month_20`) =$m AND  $t !=''  and resp_id=$b";
                          else
                            $eer="SELECT distinct $t FROM  vcimstest.`UMEED_20` WHERE MONTH(`visit_month_20`) =$m AND  $t !='' and resp_id=$b";

                           $r2=DB::getInstance()->query($eer);
                           if($r2->count()>0)
                           { 
                                   $rdata=$r2->first()->$t;
                                  if($m>5)
                                      $er="SELECT  centre_20,visit_shift_20 FROM  `UMEED_20` WHERE MONTH(`visit_month_20`) =$m AND  centre_20 !='' and resp_id=$b";
                                  else
                                      $er="SELECT  centre_20,visit_shift_20 FROM  vcimstest.`UMEED_20` WHERE MONTH(`visit_month_20`) =$m AND  centre_20 !='' and resp_id=$b";
                                    // echo "gg<br>".$er;
                                   $r22=DB::getInstance()->query($er);
                                   if($r22->count()>0)
                                   {	$c=$r22->first()->centre_20; $s=$r22->first()->visit_shift_20;}

                                   $r3=DB::getInstance()->query("SELECT `id`, `q_term`, `group_id`, `grp_wt`, `attr_wt`, `op`, `op_rate` FROM `md_umeed_attribute` WHERE op=$rdata AND q_term='$t' $strb ");
                                   if($r3->count()>0)
                                   {
                                           $gp=$r3->first()->group_id; $gw=$r3->first()->grp_wt; $aw=$r3->first()->attr_wt; $op=$r3->first()->op; $opr=$r3->first()->op_rate;
                                   } 

                                   $ascore=$opr*$aw;
                                   $booth_score=$ascore+$booth_score;
                                   $booth_g_score=$booth_g_score+$ascore;
                                     echo '<br> term:'.$t.',resp val:'.$rdata.' , a rate:'.$aw  .' , attr op rate :'.$opr.' , attr score='.$ascore;
                                   if($rdata==1 && $t=='fq28_n_20')
                                   { 
                                   if($t=='fq28_n_20')
                                   {   $arr=  array();
                                       $arr1=  array('fq29_n_20');   

                                       if($t=='fq28_n_20')
                                           $arr=$arr1;
                                       

                                       foreach($arr as $key=>$val)
                                       {
                                           $r3=DB::getInstance()->query("SELECT `id`, `q_term`, `group_id`, `grp_wt`, `attr_wt`, `op`, `op_rate` FROM `md_umeed_attribute` WHERE q_term='$val' $strb ");
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
                                   }// 

                                   if($rdata==2)
                                   { 
                                   if($t=='fq35_1_20' ||  $t=='fq35_3_20' || $t=='fq35_5_20' || $t == '$fq17_20' )
                                   {   $arr=  array();
                                       $arr1=  array('fq38_1_20','fq39_1_20','fq40_1_20');     
                                       $arr2=  array('fq38_2_20','fq39_2_20','fq40_2_20');     
                                       $arr3=  array('fq38_3_20','fq39_3_20','fq40_3_20','fq41_3_20');     
                                       $arr4=  array('fq38_5_20','fq39_5_20','fq40_5_20','fq41_5_20','fq42_5_20'); 
                                           

                                       if($t=='fq35_1_20')
                                           $arr=$arr1;
                                       //if($t=='fq35_2_20')
                                           //$arr=$arr2;
                                       if($t=='fq35_3_20')
                                           $arr=$arr3;
                                       if($t=='fq35_5_20')
                                           $arr=$arr4;
                                        if($t=='fq19_20')
                                           $arr=array('fq19_20');
                                        if($t=='fq29_n_20')
                                           $arr=array('fq29_n_20');

                                       foreach($arr as $key=>$val)
                                       {
                                           $r3=DB::getInstance()->query("SELECT `id`, `q_term`, `group_id`, `grp_wt`, `attr_wt`, `op`, `op_rate` FROM `md_umeed_attribute` WHERE q_term='$val' $strb ");
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
                                   }//           
                           }

                         }  //end of foreach

                        echo "<br>booth group score of id : $b =".$booth_g_score;
	
                } //end of indivisual booth score
                    //echo "<br>booth score of id : $b =".$booth_score;
            } //end of foreach of each group id
            echo "<br>booth score of id : $b =".$booth_score;
            //echo "<br>c:$c s:$s";
            //echo '<br>'. $iq="INSERT INTO `umeed_dashboard`( `booth_id`, `month`, `centre`, `shift`,grp_id, `grp_score`) VALUES ($b,$m,$c,$s,0,$booth_score);";
      // /*
  	$booth_score=0;
        $sum=0;$avg=0;$cnt=0;

     	echo "<table border=1> <tr><td>BOOTH_ID</td><td>BOOTH SCORE</td> </tr>";
     	
     	if($m>5)
     		$qa="select distinct resp_id from UMEED_20 WHERE MONTH(`visit_month_20`) =$m order by resp_id";
     	else
     		$qa="select distinct resp_id from vcimstest.UMEED_20 WHERE MONTH(`visit_month_20`) =$m order by resp_id";
     		
     	$b_all=DB::getInstance()->query($qa); 
     	foreach($b_all->results() as $ba)
     	{       
                $booth_score=0;
   		$b_id=$ba->resp_id;     //$stra='WHERE group_id not in (2,5,6,7,8,9,10)'; 
   		
   		//if($g == 0) {$stra='WHERE group_id in (2,5,6,7,8,9,10)'; $strb='';}
                //else if($g > 0){ $stra="WHERE group_id=$g";  $strb=" AND group_id=$g";}
         
                $strb='';$ascore='';
   		//if($g==0) {$stra="WHERE q_term  in('fq14_20','fq23_20','fq31_20','fq32_20','fq34_20','fq35_1_20','fq35_3_20','fq35_5_20','fq38_1_20','fq38_3_20','fq38_5_20','fq39_1_20','fq39_3_20','fq39_5_20','fq3_20','fq40_1_20','fq40_3_20','fq40_5_20','fq41_3_20','fq41_5_20','fq42_5_20','fq4_20','fq5_20','fq25_20','fq28_n_20','fq29_n_20','cq2_20','cq3_20','fq19_20','fq1_20','fq20_20','fq27_20') "; $strb='';}  		
   		//if($g==1) {$stra="WHERE  q_term  in('fq14_20','fq23_20','fq31_20','fq32_20','fq34_20','fq35_1_20','fq35_3_20','fq35_5_20','fq38_1_20','fq38_3_20','fq38_5_20','fq39_1_20','fq39_3_20','fq39_5_20','fq3_20','fq40_1_20','fq40_3_20','fq40_5_20','fq41_3_20','fq41_5_20','fq42_5_20','fq4_20','fq5_20')";$strb='';}
        	//if($g>1){ $stra= " WHERE group_id=$g"; $strb=" AND group_id=$g";}
         
                if($g==0)
                {   $stra=" WHERE  q_term  in('fq14_20','fq23_20','fq31_20','fq32_20','fq34_20','fq35_1_20','fq35_3_20','fq35_5_20','fq38_1_20','fq38_3_20','fq38_5_20','fq39_1_20','fq39_3_20','fq39_5_20','fq3_20','fq40_1_20','fq40_3_20','fq40_5_20','fq41_3_20','fq41_5_20','fq42_5_20','fq4_20','fq5_20','fq25_20','fq28_n_20','fq29_n_20','cq2_20','cq3_20','fq19_20','fq1_20','fq20_20','fq27_20' )"; $strb='';}
                if($g==1)
                {   $stra=" WHERE  q_term  in('fq14_20','fq23_20','fq31_20','fq32_20','fq34_20','fq35_1_20','fq35_3_20','fq35_5_20','fq38_1_20','fq38_3_20','fq38_5_20','fq39_1_20','fq39_3_20','fq39_5_20','fq3_20','fq40_1_20','fq40_3_20','fq40_5_20','fq41_3_20','fq41_5_20','fq42_5_20','fq4_20','fq5_20')"; $strb='';}
                if($g==3)
                {   $stra=" WHERE  q_term  in('fq25_20','fq28_n_20','fq29_n_20')"; $strb='';}
                if($g==4)
                {   $stra=" WHERE  q_term  in('cq2_20','cq3_20','fq19_20','fq1_20','fq20_20','fq27_20')"; $strb='';}
                
                
                //echo "SELECT distinct `q_term` FROM `md_umeed_attribute` $stra";
		$r1=DB::getInstance()->query("SELECT distinct `q_term` FROM `md_umeed_attribute` $stra");
		if($r1->count()>0)
		{
		    foreach($r1->results() as $ra)
		    {    
		       	$t=$ra->q_term;$aw='';$opr='';
		        if($m>5)
                            $eee="SELECT distinct $t FROM  `UMEED_20` WHERE MONTH(`visit_month_20`) =$m AND  $t !='' and resp_id=$b_id";
                        else
                            $eee="SELECT distinct $t FROM  vcimstest.`UMEED_20` WHERE MONTH(`visit_month_20`) =$m AND  $t !='' and resp_id=$b_id";

		       	$r2=DB::getInstance()->query($eee);
		       	if($r2->count()>0)
		       	{ 
		       		$rdata=$r2->first()->$t;
		                $qqr1="SELECT  `q_term`, `group_id`, `grp_wt`, `attr_wt`, `op`, `op_rate` FROM `md_umeed_attribute` WHERE op=$rdata AND q_term='$t' $strb ";
		       		$r3=DB::getInstance()->query($qqr1);
		  		if($r3->count()>0)
		  		{
		       			$gp=$r3->first()->group_id; $gw=$r3->first()->grp_wt; $aw=$r3->first()->attr_wt; $op=$r3->first()->op; $opr=$r3->first()->op_rate;
		  		} 
		  	
        		  	//else { echo "no audit data available for booth_id: $b for $m month"; break;}
		  		$ascore=$opr*$aw;
		  	 	$booth_score=$ascore+$booth_score;
                                //if($b_id==1)  echo '<br> '.$t.','.$rdata.' , a rate:'.$aw  .' ,op score:'.$opr.',a score:'.$ascore.' b score:'. $booth_score;
                            if($rdata==1 && $t=='fq28_n_20')
                                   { 
                                   if($t=='fq28_n_20')
                                   {   $arr=  array();
                                       $arr1=  array('fq29_n_20');   

                                       if($t=='fq28_n_20')
                                           $arr=$arr1;
                                       

                                       foreach($arr as $key=>$val)
                                       {
                                           $r3=DB::getInstance()->query("SELECT `id`, `q_term`, `group_id`, `grp_wt`, `attr_wt`, `op`, `op_rate` FROM `md_umeed_attribute` WHERE q_term='$val' $strb ");
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
                                   }// 

                            if($rdata==2)
                            { 
                            if($t=='fq35_1_20' ||  $t=='fq35_3_20' || $t=='fq35_5_20' || $t=='fq17_20')
                            {   $arr=  array();
                                $arr1=  array('fq38_1_20','fq39_1_20','fq40_1_20');     
                                $arr2=  array('fq38_2_20','fq39_2_20','fq40_2_20');     
                                $arr3=  array('fq38_3_20','fq39_3_20','fq40_3_20','fq41_3_20');     
                                $arr4=  array('fq38_5_20','fq39_5_20','fq40_5_20','fq41_5_20','fq42_5_20');     

                                if($t=='fq35_1_20')
                                    $arr=$arr1;
                                //if($t=='fq35_2_20')
                                    //$arr=$arr2;
                                if($t=='fq35_3_20')
                                    $arr=$arr3;
                                if($t=='fq35_5_20')
                                    $arr=$arr4;
                                if($t=='fq19_20')
                                    $arr=array('fq19_20'); 

                                foreach($arr as $key=>$val)
                                {  
                                    $r3=DB::getInstance()->query("SELECT `id`, `q_term`, `group_id`, `grp_wt`, `attr_wt`, `op`, `op_rate` FROM `md_umeed_attribute` WHERE q_term='$val' $strb ");
                                    if($r3->count()>0)
                                    {
                                            $gp=$r3->first()->group_id; $gw=$r3->first()->grp_wt; $aw=$r3->first()->attr_wt; $op=''; $opr=1;                        
                                            $ascore=$opr*$aw;
                                            $booth_score=$ascore+$booth_score;

                                            //if($b_id==1)  echo '<br> '.$t.','.$rdata.' , a rate:'.$aw  .' ,op score:'.$opr.',a score:'.$ascore.' b score:'. $booth_score;
                                    }
                                }  
                            } //end of if for o
                            } //end of if

		  	} //end of if of distinct t value
		    }  //end of foreach
		
			//echo '<br>booth score:'.$booth_score;
			
		} //end of if each term attribute score
                $sum=$sum+$booth_score;
		$cnt++;
   		
		echo "<tr><td>$b_id</td><td>$booth_score</td></tr>";
     	} //end of foreach
     	echo "<br> booth SUM=$sum/$cnt";
          echo '<br> booth avg='.$sum/$cnt;
          
         // */
          
}
}

?>

<script type="text/javascript">
  document.getElementById('mn').value = "<?php echo $_POST['mn'];?>";
  document.getElementById('gn').value = "<?php echo $_POST['gn'];?>";
  document.getElementById('booth').value = "<?php echo $_POST['booth'];?>"; 
  
</script>
