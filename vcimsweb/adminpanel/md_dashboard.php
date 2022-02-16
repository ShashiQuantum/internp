<?php
include_once('../init.php');
include_once('../functions.php');

if(!Session::exists('suser'))
{
	Redirect::to('login_fp.php');
   
}
$_SESSION['umeedqr']='';

if(isset($_POST['view']))
{
  //print_r($_POST);
    	$c=$_POST['rg'];$bth=$_POST['boothid'];$s=$_POST['shft'];$g=$_POST['gn'];$_SESSION['umeedqr']='';$qr='';
   
  	if($c==0 && $bth==0 && $s==0 && $g==0 )
  	{
  		$qr="SELECT  get_term('month_20',`month`) AS Month,  round( avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=0 GROUP BY Month";
  		$qr1="SELECT get_term('hml_20',hml) AS HML, count(`grp_score`) as score FROM `umeed_dashboard` WHERE `month`=1 AND `grp_id`=0 GROUP BY HML";
                $qr2="SELECT get_term('hml_20',hml) AS HML, count(`grp_score`) as score FROM `umeed_dashboard` WHERE `month`=2 AND `grp_id`=0 GROUP BY HML";
                $qr_gp1="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=1 GROUP BY Month";
                $qr_gp2="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=2 GROUP BY Month";
                $qr_gp3="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=3 GROUP BY Month";
                $qr_gp4="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=4 GROUP BY Month";
                $qr_gp5="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=5 GROUP BY Month";
                $_SESSION['umeedqr_gp5']=$qr_gp5;
                $_SESSION['umeedqr_gp4']=$qr_gp4;
                $_SESSION['umeedqr_gp3']=$qr_gp3;
                $_SESSION['umeedqr_gp2']=$qr_gp2;
                $_SESSION['umeedqr_gp1']=$qr_gp1;
                $_SESSION['umeedqr3']=$qr2;
  		$_SESSION['umeedqr2']=$qr1;
  		$_SESSION['umeedqr']=$qr;
  	}
  	else if($c>0 && $bth==0 && $s==0 && $g==0 )
  	{
  		$qr="SELECT  get_term('month_20',`month`) AS Month,  round( avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE centre=$c AND `grp_id`=0 GROUP BY Month";
  		$qr1="SELECT get_term('hml_20',hml) AS HML, count(`grp_score`) as score FROM `umeed_dashboard` WHERE `month`=1 AND centre=$c AND `grp_id`=0 GROUP BY HML";
                $qr2="SELECT get_term('hml_20',hml) AS HML, count(`grp_score`) as score FROM `umeed_dashboard` WHERE `month`=2 AND centre=$c AND `grp_id`=0 GROUP BY HML";
                 $qr_gp1="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=1 AND centre=$c GROUP BY Month";
                $qr_gp2="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=2 AND centre=$c GROUP BY Month";
                $qr_gp3="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=3 AND centre=$c GROUP BY Month";
                $qr_gp4="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=4 AND centre=$c GROUP BY Month";
                $qr_gp5="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=5 AND centre=$c GROUP BY Month";
                $_SESSION['umeedqr_gp5']=$qr_gp5;
                $_SESSION['umeedqr_gp4']=$qr_gp4;
                $_SESSION['umeedqr_gp3']=$qr_gp3;
                $_SESSION['umeedqr_gp2']=$qr_gp2;
                $_SESSION['umeedqr_gp1']=$qr_gp1;
                $_SESSION['umeedqr3']=$qr2;
  		$_SESSION['umeedqr2']=$qr1;
  		$_SESSION['umeedqr']=$qr;
  	}
  	else if($c>0 && $bth==0 && $s>0 && $g==0 )
  	{
  		$qr="SELECT  get_term('month_20',`month`) AS Month,  round( avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE centre=$c AND shift=$s AND `grp_id`=0 GROUP BY Month";
  		$qr1="SELECT get_term('hml_20',hml) AS HML, count(`grp_score`) as score FROM `umeed_dashboard` WHERE `month`=1 AND centre=$c AND shift=$s AND `grp_id`=0 GROUP BY HML";
                $qr2="SELECT get_term('hml_20',hml) AS HML, count(`grp_score`) as score FROM `umeed_dashboard` WHERE `month`=2 AND centre=$c AND shift=$s AND `grp_id`=0 GROUP BY HML";
                $qr_gp1="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=1 AND centre=$c AND shift=$s GROUP BY Month";
                $qr_gp2="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=2 AND centre=$c AND shift=$s GROUP BY Month";
                $qr_gp3="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=3 AND centre=$c AND shift=$s GROUP BY Month";
                $qr_gp4="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=4 AND centre=$c AND shift=$s GROUP BY Month";
                $qr_gp5="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=5 AND centre=$c AND shift=$s GROUP BY Month";
                $_SESSION['umeedqr_gp5']=$qr_gp5;
                $_SESSION['umeedqr_gp4']=$qr_gp4;
                $_SESSION['umeedqr_gp3']=$qr_gp3;
                $_SESSION['umeedqr_gp2']=$qr_gp2;
                $_SESSION['umeedqr_gp1']=$qr_gp1;
                $_SESSION['umeedqr3']=$qr2;
  		$_SESSION['umeedqr2']=$qr1;
  		$_SESSION['umeedqr']=$qr;
  	}
  	else if($c>0 && $bth==0 && $s==0 && $g>0 )
  	{
  		$qr="SELECT  get_term('month_20',`month`) AS Month,  round( avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE centre=$c AND `grp_id`=$g GROUP BY Month";
  		$qr1="SELECT get_term('hml_20',hml) AS HML, count(`grp_score`) as score FROM `umeed_dashboard` WHERE `month`=1 AND centre=$c AND `grp_id`=0 GROUP BY HML";    
                $qr2="SELECT get_term('hml_20',hml) AS HML, count(`grp_score`) as score FROM `umeed_dashboard` WHERE `month`=2 AND centre=$c AND `grp_id`=0 GROUP BY HML";
                $qr_gp1="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=1 AND centre=$c  GROUP BY Month";
                $qr_gp2="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=2 AND centre=$c  GROUP BY Month";
                $qr_gp3="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=3 AND centre=$c  GROUP BY Month";
                $qr_gp4="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=4 AND centre=$c  GROUP BY Month";
                $qr_gp5="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=5 AND centre=$c  GROUP BY Month";
                $_SESSION['umeedqr_gp5']=$qr_gp5;
                $_SESSION['umeedqr_gp4']=$qr_gp4;
                $_SESSION['umeedqr_gp3']=$qr_gp3;
                $_SESSION['umeedqr_gp2']=$qr_gp2;
                $_SESSION['umeedqr_gp1']=$qr_gp1;
                $_SESSION['umeedqr3']=$qr2;
  		$_SESSION['umeedqr2']=$qr1;
  		$_SESSION['umeedqr']=$qr;
  	}
  	else if($c==0 && $bth>0 && $s==0 && $g==0 )
  	{
  		$qr="SELECT  get_term('month_20',`month`) AS Month,  round( avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `booth_id`=$bth AND grp_id=0 GROUP BY Month";
                $qr1="SELECT get_term('hml_20',hml) AS HML, count(`grp_score`) as score FROM `umeed_dashboard` WHERE `month`=1 AND `grp_id`=0 AND booth_id=$bth GROUP BY HML";
                $qr2="SELECT get_term('hml_20',hml) AS HML, count(`grp_score`) as score FROM `umeed_dashboard` WHERE `month`=2 AND `grp_id`=0 AND booth_id=$bth GROUP BY HML";
                 $qr_gp1="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=1 AND booth_id=$bth GROUP BY Month";
                $qr_gp2="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=2 AND booth_id=$bth GROUP BY Month";
                $qr_gp3="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=3 AND booth_id=$bth GROUP BY Month";
                $qr_gp4="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=4 AND booth_id=$bth GROUP BY Month";
                $qr_gp5="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=5 AND booth_id=$bth GROUP BY Month";
                $_SESSION['umeedqr_gp5']=$qr_gp5;
                $_SESSION['umeedqr_gp4']=$qr_gp4;
                $_SESSION['umeedqr_gp3']=$qr_gp3;
                $_SESSION['umeedqr_gp2']=$qr_gp2;
                $_SESSION['umeedqr_gp1']=$qr_gp1;
                $_SESSION['umeedqr3']=$qr2;
                $_SESSION['umeedqr2']=$qr1;
  		$_SESSION['umeedqr']=$qr;
  	}
        else if($c==0 && $bth>0 && $s==0 && $g>0 )
  	{
  		$qr="SELECT  get_term('month_20',`month`) AS Month,  round( avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `booth_id`=$bth AND grp_id=$g GROUP BY Month";
                $qr1="SELECT get_term('hml_20',hml) AS HML, count(`grp_score`) as score FROM `umeed_dashboard` WHERE `month`=1 AND `grp_id`=0 AND booth_id=$bth GROUP BY HML";
                $qr2="SELECT get_term('hml_20',hml) AS HML, count(`grp_score`) as score FROM `umeed_dashboard` WHERE `month`=2 AND `grp_id`=0 AND booth_id=$bth GROUP BY HML";
                $qr_gp1="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=1 AND booth_id=$bth GROUP BY Month";
                $qr_gp2="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=2 AND booth_id=$bth GROUP BY Month";
                $qr_gp3="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=3 AND booth_id=$bth GROUP BY Month";
                $qr_gp4="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=4 AND booth_id=$bth GROUP BY Month";
                $qr_gp5="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=5 AND booth_id=$bth GROUP BY Month";
                $_SESSION['umeedqr_gp5']=$qr_gp5;
                $_SESSION['umeedqr_gp4']=$qr_gp4;
                $_SESSION['umeedqr_gp3']=$qr_gp3;
                $_SESSION['umeedqr_gp2']=$qr_gp2;
                $_SESSION['umeedqr_gp1']=$qr_gp1;

                $_SESSION['umeedqr3']=$qr2;
                $_SESSION['umeedqr2']=$qr1;
  		$_SESSION['umeedqr']=$qr;
  	}
        else if($c==0 && $bth>0 && $s>0 && $g==0 )
  	{
  		$qr="SELECT  get_term('month_20',`month`) AS Month,  round( avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `booth_id`=$bth AND grp_id=0 AND shift=$s GROUP BY Month";
                $qr1="SELECT get_term('hml_20',hml) AS HML, count(`grp_score`) as score FROM `umeed_dashboard` WHERE `month`=1 AND `grp_id`=0 AND booth_id=$bth AND shift=$s GROUP BY HML";
                $qr2="SELECT get_term('hml_20',hml) AS HML, count(`grp_score`) as score FROM `umeed_dashboard` WHERE `month`=2 AND `grp_id`=0 AND booth_id=$bth AND shift=$s GROUP BY HML";
                $qr_gp1="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE  booth_id=$bth AND shift=$s GROUP BY Month";
                $qr_gp2="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE  booth_id=$bth AND shift=$s GROUP BY Month";
                $qr_gp3="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE  booth_id=$bth AND shift=$s GROUP BY Month";
                $qr_gp4="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE  booth_id=$bth AND shift=$s GROUP BY Month";
                $qr_gp5="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE  booth_id=$bth AND shift=$s GROUP BY Month";
                $_SESSION['umeedqr_gp5']=$qr_gp5;
                $_SESSION['umeedqr_gp4']=$qr_gp4;
                $_SESSION['umeedqr_gp3']=$qr_gp3;
                $_SESSION['umeedqr_gp2']=$qr_gp2;
                $_SESSION['umeedqr_gp1']=$qr_gp1;

                $_SESSION['umeedqr3']=$qr2;
                $_SESSION['umeedqr2']=$qr1;
  		$_SESSION['umeedqr']=$qr;
  	}
  	else if($c==0 && $bth==0 && $s==0 && $g>0 )
  	{
  		$qr="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=$g GROUP BY Month";
                $qr_gp1="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=1 GROUP BY Month";
                $qr_gp2="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=2 GROUP BY Month";
                $qr_gp3="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=3 GROUP BY Month";
                $qr_gp4="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=4 GROUP BY Month";
                $qr_gp5="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=5 GROUP BY Month";
                $_SESSION['umeedqr_gp5']=$qr_gp5;
                $_SESSION['umeedqr_gp4']=$qr_gp4;
                $_SESSION['umeedqr_gp3']=$qr_gp3;
                $_SESSION['umeedqr_gp2']=$qr_gp2;
                $_SESSION['umeedqr_gp1']=$qr_gp1;
  		$_SESSION['umeedqr']=$qr;
  	}
  	else if($c==0 && $bth==0 && $s>0 && $g==0 )
  	{
  		$qr="SELECT  get_term('month_20',`month`) AS Month,  round( avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=0 AND shift=$s  GROUP BY Month";
  		$qr1="SELECT get_term('hml_20',hml) AS HML, count(`grp_score`) as score FROM `umeed_dashboard` WHERE `month`=1 AND shift=$s AND `grp_id`=0 GROUP BY HML";
                $qr2="SELECT get_term('hml_20',hml) AS HML, count(`grp_score`) as score FROM `umeed_dashboard` WHERE `month`=2 AND shift=$s AND `grp_id`=0 GROUP BY HML";
                $qr_gp1="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=1 AND shift=$s GROUP BY Month";
                $qr_gp2="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=2 AND shift=$s GROUP BY Month";
                $qr_gp3="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=3 AND shift=$s GROUP BY Month";
                $qr_gp4="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=4 AND shift=$s GROUP BY Month";
                $qr_gp5="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=5 AND shift=$s GROUP BY Month";
                $_SESSION['umeedqr_gp5']=$qr_gp5;
                $_SESSION['umeedqr_gp4']=$qr_gp4;
                $_SESSION['umeedqr_gp3']=$qr_gp3;
                $_SESSION['umeedqr_gp2']=$qr_gp2;
                $_SESSION['umeedqr_gp1']=$qr_gp1;
                $_SESSION['umeedqr3']=$qr2;
  		$_SESSION['umeedqr2']=$qr1;
  		$_SESSION['umeedqr']=$qr;
  	}
  	else if($c==0 && $bth==0 && $s>0 && $g>0 )
  	{
  		$qr="SELECT  get_term('month_20',`month`) AS Month,  round( avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=$g AND shift=$s  GROUP BY Month";
  		$qr1="SELECT get_term('hml_20',hml) AS HML, count(`grp_score`) as score FROM `umeed_dashboard` WHERE `month`=1 AND shift=$s AND  `grp_id`=0 GROUP BY HML";
                $qr2="SELECT get_term('hml_20',hml) AS HML, count(`grp_score`) as score FROM `umeed_dashboard` WHERE `month`=2 AND shift=$s AND  `grp_id`=0 GROUP BY HML";
                $qr_gp1="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=1 AND  shift=$s GROUP BY Month";
                $qr_gp2="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=2 AND  shift=$s GROUP BY Month";
                $qr_gp3="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=3 AND  shift=$s GROUP BY Month";
                $qr_gp4="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=4 AND  shift=$s GROUP BY Month";
                $qr_gp5="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=5 AND  shift=$s GROUP BY Month";
                $_SESSION['umeedqr_gp5']=$qr_gp5;
                $_SESSION['umeedqr_gp4']=$qr_gp4;
                $_SESSION['umeedqr_gp3']=$qr_gp3;
                $_SESSION['umeedqr_gp2']=$qr_gp2;
                $_SESSION['umeedqr_gp1']=$qr_gp1;
                $_SESSION['umeedqr3']=$qr2;
  		$_SESSION['umeedqr2']=$qr1;
  		$_SESSION['umeedqr']=$qr;
  	}
  	else if($c>0 && $bth>0 && $s>0 && $g>0 )
  	{
  		$qr="SELECT  get_term('month_20',`month`) AS Month,  round( avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE centre=$c AND `grp_id`=$g AND booth_id=$bth AND shift=$s  GROUP BY Month";
  		$qr1="SELECT get_term('hml_20',hml) AS HML, count(`grp_score`) as score FROM `umeed_dashboard` WHERE `month`=1 AND centre=$c AND shift=$s AND  `grp_id`=0 GROUP BY HML";
                $qr2="SELECT get_term('hml_20',hml) AS HML, count(`grp_score`) as score FROM `umeed_dashboard` WHERE `month`=2 AND centre=$c AND shift=$s AND  `grp_id`=0 GROUP BY HML";
                $qr_gp1="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=1 AND centre=$c AND shift=$s GROUP BY Month";
                $qr_gp2="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=2 AND centre=$c AND shift=$s GROUP BY Month";
                $qr_gp3="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=3 AND centre=$c AND shift=$s GROUP BY Month";
                $qr_gp4="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=4 AND centre=$c AND shift=$s GROUP BY Month";
                $qr_gp5="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=5 AND centre=$c AND shift=$s GROUP BY Month";
                $_SESSION['umeedqr_gp5']=$qr_gp5;
                $_SESSION['umeedqr_gp4']=$qr_gp4;
                $_SESSION['umeedqr_gp3']=$qr_gp3;
                $_SESSION['umeedqr_gp2']=$qr_gp2;
                $_SESSION['umeedqr_gp1']=$qr_gp1;
                $_SESSION['umeedqr3']=$qr2;
  		$_SESSION['umeedqr2']=$qr1;
  		$_SESSION['umeedqr']=$qr;
  	}
  	else if($c>0 && $bth==0 && $s>0 && $g>0 )
  	{
  		$qr="SELECT  get_term('month_20',`month`) AS Month,  round( avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE centre=$c AND `grp_id`=$g AND shift=$s  GROUP BY Month";
  		$qr1="SELECT get_term('hml_20',hml) AS HML, count(`grp_score`) as score FROM `umeed_dashboard` WHERE `month`=1 AND centre=$c AND shift=$s AND  `grp_id`=0 GROUP BY HML";
                $qr2="SELECT get_term('hml_20',hml) AS HML, count(`grp_score`) as score FROM `umeed_dashboard` WHERE `month`=2 AND centre=$c AND shift=$s AND  `grp_id`=0 GROUP BY HML";
                $qr_gp1="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=1 AND centre=$c AND shift=$s GROUP BY Month";
                $qr_gp2="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=2 AND centre=$c AND shift=$s GROUP BY Month";
                $qr_gp3="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=3 AND centre=$c AND shift=$s GROUP BY Month";
                $qr_gp4="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=4 AND centre=$c AND shift=$s GROUP BY Month";
                $qr_gp5="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=5 AND centre=$c AND shift=$s GROUP BY Month";
                $_SESSION['umeedqr_gp5']=$qr_gp5;
                $_SESSION['umeedqr_gp4']=$qr_gp4;
                $_SESSION['umeedqr_gp3']=$qr_gp3;
                $_SESSION['umeedqr_gp2']=$qr_gp2;
                $_SESSION['umeedqr_gp1']=$qr_gp1;
                $_SESSION['umeedqr3']=$qr2;
  		$_SESSION['umeedqr2']=$qr1;
  		$_SESSION['umeedqr']=$qr;
  	}
  	
  	 //echo $qr;
  	
   	//echo '<script> google.setOnLoadCallback(drawChart); </script>';
}


?>

<html>

  <head>
    
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    	<script type="text/javascript">
      	google.load("visualization", "1", {packages:["corechart"]});
      	
      	//google.load('visualization', '1.0', {'packages':['controls']});
      	google.setOnLoadCallback(drawChart);
      	
      	function drawChart() 
      	{
      		var vv=<?php 
        	

        	$mysqli = new mysqli("localhost", "user1", "vcims@user1", "vcims_12052015");
        	//$mysqli = new mysqli("localhost", "user1", "vcims@user1", "Digiadmin_rfid");
        
     		//$result = $mysqli->query($pstrx);
                 
       		$qr="SELECT  get_term('month_20',`month`) AS Month, round( avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=0 GROUP BY Month";
                //$qr1="SELECT get_term('hml_20',hml) AS HML, count(`grp_score`) as score FROM `umeed_dashboard` WHERE `grp_id`=0 GROUP BY HML";
       		
                if( $_SESSION['umeedqr']!='')
       			$qr=$_SESSION['umeedqr'];

        
    	if (mysqli_multi_query($mysqli, $qr)) 
   	{
   	     do 
   	     { $result=mysqli_multi_query($mysqli, $qr);
       
       		 $results_array = Array(Array());
    		$fillKeys = true;
    		if ($result = mysqli_store_result($mysqli)) 
    		{ 
     			while ($row = $result->fetch_assoc()) 
     			{
        			$temp = Array();
        			foreach ($row as $key => $val)
        			{
            				if ($fillKeys)
            				{
                				$results_array[0][] = $key;
            				}
            				$temp[] = $val;
        			}
        			$results_array[] = $temp;
        			$fillKeys = false;
   		 	}
    		}    if(!mysqli_more_results($mysqli)) break;
    	    } while (mysqli_next_result($mysqli));
      	}
              
               
              
  		//$data2 = array(array('Date', 'Sales'));
		//array_push($data2, array('JAN', 14.6));


    	//$jsontable = json_encode($da, JSON_NUMERIC_CHECK);
    	$jsontable = json_encode($results_array, JSON_NUMERIC_CHECK); 
        echo json_encode($jsontable);  ?> ; 
      		
 		var vv2=<?php 
        	

        	$mysqli = new mysqli("localhost", "user1", "vcims@user1", "vcims_12052015");
        	//$mysqli = new mysqli("localhost", "user1", "vcims@user1", "Digiadmin_rfid");
        
     		//$result = $mysqli->query($pstrx);
                 
       		//$qr="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=0 GROUP BY Month";
                $qr1="SELECT get_term('hml_20',hml) AS HML, count(`grp_score`) as score FROM `umeed_dashboard` WHERE `month`=1 AND `grp_id`=0 GROUP BY HML";
       		
                if( $_SESSION['umeedqr']!='')
       			$qr1=$_SESSION['umeedqr2'];

          
             //for pi chart
             if (mysqli_multi_query($mysqli, $qr1)) 
   	{
   	     do 
   	     { $result=mysqli_multi_query($mysqli, $qr1);
       
       		 $results_array2 = Array(Array());
    		$fillKeys = true;
    		if ($result = mysqli_store_result($mysqli)) 
    		{ 
     			while ($row = $result->fetch_assoc()) 
     			{
        			$temp = Array();
        			foreach ($row as $key => $val)
        			{
            				if ($fillKeys)
            				{
                				$results_array2[0][] = $key;
            				}
            				$temp[] = $val;
        			}
        			$results_array2[] = $temp;
        			$fillKeys = false;
   		 	}
    		}    if(!mysqli_more_results($mysqli)) break;
    	    } while (mysqli_next_result($mysqli));
      	}
               
              
  		//$data2 = array(array('Date', 'Sales'));
		//array_push($data2, array('JAN', 14.6));


    	//$jsontable = json_encode($da, JSON_NUMERIC_CHECK); 
    	$jsontable2 = json_encode($results_array2, JSON_NUMERIC_CHECK);
         
        echo json_encode($jsontable2); ?> ; 

//for feb
         var vv3=<?php 
        	

        	$mysqli = new mysqli("localhost", "user1", "vcims@user1", "vcims_12052015");
        	//$mysqli = new mysqli("localhost", "user1", "vcims@user1", "Digiadmin_rfid");
        
     		//$result = $mysqli->query($pstrx);
                 
       		//$qr="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),0) as score FROM  `umeed_dashboard` WHERE `grp_id`=0 GROUP BY Month";
                $qr1="SELECT get_term('hml_20',hml) AS HML, count(`grp_score`) as score FROM `umeed_dashboard` WHERE `month`=2 AND `grp_id`=0 GROUP BY HML";
       		
                if( $_SESSION['umeedqr']!='')
       			$qr1=$_SESSION['umeedqr3'];

          
             //for pi chart
             if (mysqli_multi_query($mysqli, $qr1)) 
   	{
   	     do 
   	     { $result=mysqli_multi_query($mysqli, $qr1);
       
       		 $results_array2 = Array(Array());
    		$fillKeys = true;
    		if ($result = mysqli_store_result($mysqli)) 
    		{ 
     			while ($row = $result->fetch_assoc()) 
     			{
        			$temp = Array();
        			foreach ($row as $key => $val)
        			{
            				if ($fillKeys)
            				{
                				$results_array2[0][] = $key;
            				}
            				$temp[] = $val;
        			}
        			$results_array2[] = $temp;
        			$fillKeys = false;
   		 	}
    		}    if(!mysqli_more_results($mysqli)) break;
    	    } while (mysqli_next_result($mysqli));
      	}
               
              


    	//$jsontable = json_encode($da, JSON_NUMERIC_CHECK); 
    	$jsontable2 = json_encode($results_array2, JSON_NUMERIC_CHECK);
         
        echo json_encode($jsontable2); ?> ; 

        //for gp1
         var vv_gp1=<?php 
        	

        	$mysqli = new mysqli("localhost", "user1", "vcims@user1", "vcims_12052015");
        	//$mysqli = new mysqli("localhost", "user1", "vcims@user1", "Digiadmin_rfid");
        
     		//$result = $mysqli->query($pstrx);
                 
       		$qr="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=1 GROUP BY Month";
                
       		
                if( $_SESSION['umeedqr']!='')
       			$qr=$_SESSION['umeedqr_gp1'];

          
             //for pi chart
             if (mysqli_multi_query($mysqli, $qr)) 
   	{
   	     do 
   	     { $result=mysqli_multi_query($mysqli, $qr);
       
       		 $results_array2 = Array(Array());
    		$fillKeys = true;
    		if ($result = mysqli_store_result($mysqli)) 
    		{ 
     			while ($row = $result->fetch_assoc()) 
     			{
        			$temp = Array();
        			foreach ($row as $key => $val)
        			{
            				if ($fillKeys)
            				{
                				$results_array2[0][] = $key;
            				}
            				$temp[] = $val;
        			}
        			$results_array2[] = $temp;
        			$fillKeys = false;
   		 	}
    		}    if(!mysqli_more_results($mysqli)) break;
    	    } while (mysqli_next_result($mysqli));
      	}
               
              


    	//$jsontable = json_encode($da, JSON_NUMERIC_CHECK); 
    	$jsontable2 = json_encode($results_array2, JSON_NUMERIC_CHECK);
         
        echo json_encode($jsontable2); ?> ; 


    //for gp2
         var vv_gp2=<?php 
        	

        	$mysqli = new mysqli("localhost", "user1", "vcims@user1", "vcims_12052015");
        	//$mysqli = new mysqli("localhost", "user1", "vcims@user1", "Digiadmin_rfid");
        
     		//$result = $mysqli->query($pstrx);
                 
       		$qr="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=2 GROUP BY Month";
                
       		
                if( $_SESSION['umeedqr']!='')
       			$qr=$_SESSION['umeedqr_gp2'];

          
             //for pi chart
             if (mysqli_multi_query($mysqli, $qr)) 
   	{
   	     do 
   	     { $result=mysqli_multi_query($mysqli, $qr);
       
       		 $results_array2 = Array(Array());
    		$fillKeys = true;
    		if ($result = mysqli_store_result($mysqli)) 
    		{ 
     			while ($row = $result->fetch_assoc()) 
     			{
        			$temp = Array();
        			foreach ($row as $key => $val)
        			{
            				if ($fillKeys)
            				{
                				$results_array2[0][] = $key;
            				}
            				$temp[] = $val;
        			}
        			$results_array2[] = $temp;
        			$fillKeys = false;
   		 	}
    		}    if(!mysqli_more_results($mysqli)) break;
    	    } while (mysqli_next_result($mysqli));
      	}
               
              


    	//$jsontable = json_encode($da, JSON_NUMERIC_CHECK); 
    	$jsontable2 = json_encode($results_array2, JSON_NUMERIC_CHECK);
         
        echo json_encode($jsontable2); ?> ; 

   //for gp3
         var vv_gp3=<?php 
        	

        	$mysqli = new mysqli("localhost", "user1", "vcims@user1", "vcims_12052015");
        	//$mysqli = new mysqli("localhost", "user1", "vcims@user1", "Digiadmin_rfid");
        
     		//$result = $mysqli->query($pstrx);
                 
       		$qr="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=3 GROUP BY Month";
                
       		
                if( $_SESSION['umeedqr']!='')
       			$qr=$_SESSION['umeedqr_gp3'];

          
             //for pi chart
             if (mysqli_multi_query($mysqli, $qr)) 
   	{
   	     do 
   	     { $result=mysqli_multi_query($mysqli, $qr);
       
       		 $results_array2 = Array(Array());
    		$fillKeys = true;
    		if ($result = mysqli_store_result($mysqli)) 
    		{ 
     			while ($row = $result->fetch_assoc()) 
     			{
        			$temp = Array();
        			foreach ($row as $key => $val)
        			{
            				if ($fillKeys)
            				{
                				$results_array2[0][] = $key;
            				}
            				$temp[] = $val;
        			}
        			$results_array2[] = $temp;
        			$fillKeys = false;
   		 	}
    		}    if(!mysqli_more_results($mysqli)) break;
    	    } while (mysqli_next_result($mysqli));
      	}
               
              


    	//$jsontable = json_encode($da, JSON_NUMERIC_CHECK); 
    	$jsontable2 = json_encode($results_array2, JSON_NUMERIC_CHECK);
         
        echo json_encode($jsontable2); ?> ; 

//for gp4
         var vv_gp4=<?php 
        	

        	$mysqli = new mysqli("localhost", "user1", "vcims@user1", "vcims_12052015");
        	//$mysqli = new mysqli("localhost", "user1", "vcims@user1", "Digiadmin_rfid");
        
     		//$result = $mysqli->query($pstrx);
                 
       		$qr="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=4 GROUP BY Month";
                
       		
                if( $_SESSION['umeedqr']!='')
       			$qr=$_SESSION['umeedqr_gp4'];

          
             //for pi chart
             if (mysqli_multi_query($mysqli, $qr)) 
   	{
   	     do 
   	     { $result=mysqli_multi_query($mysqli, $qr);
       
       		 $results_array2 = Array(Array());
    		$fillKeys = true;
    		if ($result = mysqli_store_result($mysqli)) 
    		{ 
     			while ($row = $result->fetch_assoc()) 
     			{
        			$temp = Array();
        			foreach ($row as $key => $val)
        			{
            				if ($fillKeys)
            				{
                				$results_array2[0][] = $key;
            				}
            				$temp[] = $val;
        			}
        			$results_array2[] = $temp;
        			$fillKeys = false;
   		 	}
    		}    if(!mysqli_more_results($mysqli)) break;
    	    } while (mysqli_next_result($mysqli));
      	}
               
              


    	//$jsontable = json_encode($da, JSON_NUMERIC_CHECK); 
    	$jsontable2 = json_encode($results_array2, JSON_NUMERIC_CHECK);
         
        echo json_encode($jsontable2); ?> ; 
       
         //for gp5
         var vv_gp5=<?php 
        	

        	$mysqli = new mysqli("localhost", "user1", "vcims@user1", "vcims_12052015");
        	//$mysqli = new mysqli("localhost", "user1", "vcims@user1", "Digiadmin_rfid");
        
     		//$result = $mysqli->query($pstrx);
                 
       		$qr="SELECT  get_term('month_20',`month`) AS Month,  round(avg(`grp_score`),2) as score FROM  `umeed_dashboard` WHERE `grp_id`=5 GROUP BY Month";
                
       		
                if( $_SESSION['umeedqr']!='')
       			$qr=$_SESSION['umeedqr_gp5'];

          
             //for pi chart
             if (mysqli_multi_query($mysqli, $qr)) 
   	{
   	     do 
   	     { $result=mysqli_multi_query($mysqli, $qr);
       
       		 $results_array2 = Array(Array());
    		$fillKeys = true;
    		if ($result = mysqli_store_result($mysqli)) 
    		{ 
     			while ($row = $result->fetch_assoc()) 
     			{
        			$temp = Array();
        			foreach ($row as $key => $val)
        			{
            				if ($fillKeys)
            				{
                				$results_array2[0][] = $key;
            				}
            				$temp[] = $val;
        			}
        			$results_array2[] = $temp;
        			$fillKeys = false;
   		 	}
    		}    if(!mysqli_more_results($mysqli)) break;
    	    } while (mysqli_next_result($mysqli));
      	}
               
              


    	//$jsontable = json_encode($da, JSON_NUMERIC_CHECK); 
    	$jsontable2 = json_encode($results_array2, JSON_NUMERIC_CHECK);
         
        echo json_encode($jsontable2); ?> ;
    
        //for at1
         var vv_at1=<?php 
        	
        	$mysqli = new mysqli("localhost", "user1", "vcims@user1", "vcims_12052015");
        	//$mysqli = new mysqli("localhost", "user1", "vcims@user1", "Digiadmin_rfid");
        
     		//$result = $mysqli->query($pstrx);
                 
       		$qrat1="SELECT y1 , SUM(CASE x1 WHEN 1 THEN s ELSE 0 END) as 'JAN' , SUM(CASE x1 WHEN 2 THEN s ELSE 0 END) as 'FEB',SUM(CASE x1 WHEN 3 THEN s ELSE 0 END) as 'MAR' FROM ( SELECT b.a_title y1, a.`month` as x1,  round( a.attr_score,1) as s FROM `umeed_dashboard_attribute` as a JOIN `md_umeed_attribute` as b  on a.term =b.q_term  WHERE a.grp_id=1 GROUP BY a.term, a.`month` )AS stats GROUP BY y1 desc";
                
       		
                //if( $_SESSION['umeedqr']!='')
       			//$qr=$_SESSION['umeedqr_gp5'];

          
             //for pi chart
             if (mysqli_multi_query($mysqli, $qrat1)) 
   	{
   	     do 
   	     { $result=mysqli_multi_query($mysqli, $qrat1);
       
       		 $results_array2 = Array(Array());
    		$fillKeys = true;
    		if ($result = mysqli_store_result($mysqli)) 
    		{ 
     			while ($row = $result->fetch_assoc()) 
     			{
        			$temp = Array();
        			foreach ($row as $key => $val)
        			{
            				if ($fillKeys)
            				{
                				$results_array2[0][] = $key;
            				}
            				$temp[] = $val;
        			}
        			$results_array2[] = $temp;
        			$fillKeys = false;
   		 	}
    		}    if(!mysqli_more_results($mysqli)) break;
    	    } while (mysqli_next_result($mysqli));
      	}
                            
    	//$jsontable = json_encode($da, JSON_NUMERIC_CHECK); 
    	$jsontable2 = json_encode($results_array2, JSON_NUMERIC_CHECK);
         
        echo json_encode($jsontable2); ?> ; 

        //for at2
         var vv_at2=<?php 
        	
        	$mysqli = new mysqli("localhost", "user1", "vcims@user1", "vcims_12052015");
        	//$mysqli = new mysqli("localhost", "user1", "vcims@user1", "Digiadmin_rfid");
        
     		//$result = $mysqli->query($pstrx);
                 
       		$qrat1="SELECT y1 , SUM(CASE x1 WHEN 1 THEN s ELSE 0 END) as 'JAN' , SUM(CASE x1 WHEN 2 THEN s ELSE 0 END) as 'FEB',SUM(CASE x1 WHEN 3 THEN s ELSE 0 END) as 'MAR' FROM ( SELECT b.a_title y1, a.`month` as x1,  round( a.attr_score,1) as s FROM `umeed_dashboard_attribute` as a JOIN `md_umeed_attribute` as b  on a.term =b.q_term  WHERE a.grp_id=2 GROUP BY a.term, a.`month` )AS stats GROUP BY y1 desc";
                
       		
                //if( $_SESSION['umeedqr']!='')
       			//$qr=$_SESSION['umeedqr_gp5'];

          
             //for pi chart
             if (mysqli_multi_query($mysqli, $qrat1)) 
   	{
   	     do 
   	     { $result=mysqli_multi_query($mysqli, $qrat1);
       
       		 $results_array2 = Array(Array());
    		$fillKeys = true;
    		if ($result = mysqli_store_result($mysqli)) 
    		{ 
     			while ($row = $result->fetch_assoc()) 
     			{
        			$temp = Array();
        			foreach ($row as $key => $val)
        			{
            				if ($fillKeys)
            				{
                				$results_array2[0][] = $key;
            				}
            				$temp[] = $val;
        			}
        			$results_array2[] = $temp;
        			$fillKeys = false;
   		 	}
    		}    if(!mysqli_more_results($mysqli)) break;
    	    } while (mysqli_next_result($mysqli));
      	}
                             
    	//$jsontable = json_encode($da, JSON_NUMERIC_CHECK); 
    	$jsontable2 = json_encode($results_array2, JSON_NUMERIC_CHECK);
         
        echo json_encode($jsontable2); ?> ; 

        //for at3
         var vv_at3=<?php 
        	
        	$mysqli = new mysqli("localhost", "user1", "vcims@user1", "vcims_12052015");
        	//$mysqli = new mysqli("localhost", "user1", "vcims@user1", "Digiadmin_rfid");
        
     		//$result = $mysqli->query($pstrx);
                 
       		$qrat1="SELECT y1 , SUM(CASE x1 WHEN 1 THEN s ELSE 0 END) as 'JAN' , SUM(CASE x1 WHEN 2 THEN s ELSE 0 END) as 'FEB',SUM(CASE x1 WHEN 3 THEN s ELSE 0 END) as 'MAR' FROM ( SELECT b.a_title y1, a.`month` as x1,  round( a.attr_score,1) as s FROM `umeed_dashboard_attribute` as a JOIN `md_umeed_attribute` as b  on a.term =b.q_term  WHERE a.grp_id=3 GROUP BY a.term, a.`month` )AS stats GROUP BY y1 desc";
                
       		
                //if( $_SESSION['umeedqr']!='')
       			//$qr=$_SESSION['umeedqr_gp5'];

          
             //for pi chart
             if (mysqli_multi_query($mysqli, $qrat1)) 
   	{
   	     do 
   	     { $result=mysqli_multi_query($mysqli, $qrat1);
       
       		 $results_array2 = Array(Array());
    		$fillKeys = true;
    		if ($result = mysqli_store_result($mysqli)) 
    		{ 
     			while ($row = $result->fetch_assoc()) 
     			{
        			$temp = Array();
        			foreach ($row as $key => $val)
        			{
            				if ($fillKeys)
            				{
                				$results_array2[0][] = $key;
            				}
            				$temp[] = $val;
        			}
        			$results_array2[] = $temp;
        			$fillKeys = false;
   		 	}
    		}    if(!mysqli_more_results($mysqli)) break;
    	    } while (mysqli_next_result($mysqli));
      	}
               
              


    	//$jsontable = json_encode($da, JSON_NUMERIC_CHECK); 
    	$jsontable2 = json_encode($results_array2, JSON_NUMERIC_CHECK);
         
        echo json_encode($jsontable2); ?> ; 

        //for at4
         var vv_at4=<?php 
        	
        	$mysqli = new mysqli("localhost", "user1", "vcims@user1", "vcims_12052015");
        	//$mysqli = new mysqli("localhost", "user1", "vcims@user1", "Digiadmin_rfid");
        
     		//$result = $mysqli->query($pstrx);
                 
       		$qrat1="SELECT y1 , SUM(CASE x1 WHEN 1 THEN s ELSE 0 END) as 'JAN' , SUM(CASE x1 WHEN 2 THEN s ELSE 0 END) as 'FEB',SUM(CASE x1 WHEN 3 THEN s ELSE 0 END) as 'MAR' FROM ( SELECT b.a_title y1, a.`month` as x1,  round( a.attr_score,1) as s FROM `umeed_dashboard_attribute` as a JOIN `md_umeed_attribute` as b  on a.term =b.q_term  WHERE a.grp_id=4 GROUP BY a.term, a.`month` )AS stats GROUP BY y1 desc";
                
       		
                //if( $_SESSION['umeedqr']!='')
       			//$qr=$_SESSION['umeedqr_gp5'];

          
             //for pi chart
             if (mysqli_multi_query($mysqli, $qrat1)) 
   	{
   	     do 
   	     { $result=mysqli_multi_query($mysqli, $qrat1);
       
       		 $results_array2 = Array(Array());
    		$fillKeys = true;
    		if ($result = mysqli_store_result($mysqli)) 
    		{ 
     			while ($row = $result->fetch_assoc()) 
     			{
        			$temp = Array();
        			foreach ($row as $key => $val)
        			{
            				if ($fillKeys)
            				{
                				$results_array2[0][] = $key;
            				}
            				$temp[] = $val;
        			}
        			$results_array2[] = $temp;
        			$fillKeys = false;
   		 	}
    		}    if(!mysqli_more_results($mysqli)) break;
    	    } while (mysqli_next_result($mysqli));
      	}
        //$jsontable = json_encode($da, JSON_NUMERIC_CHECK); 
    	$jsontable2 = json_encode($results_array2, JSON_NUMERIC_CHECK);
         
        echo json_encode($jsontable2); ?> ; 

         //for at5
         var vv_at5=<?php 
        	
        	$mysqli = new mysqli("localhost", "user1", "vcims@user1", "vcims_12052015");
        	//$mysqli = new mysqli("localhost", "user1", "vcims@user1", "Digiadmin_rfid");
        
     		//$result = $mysqli->query($pstrx);
                 
       		$qrat1="SELECT y1 , SUM(CASE x1 WHEN 1 THEN s ELSE 0 END) as 'JAN' , SUM(CASE x1 WHEN 2 THEN s ELSE 0 END) as 'FEB',SUM(CASE x1 WHEN 3 THEN s ELSE 0 END) as 'MAR' FROM ( SELECT b.a_title y1, a.`month` as x1,  round( a.attr_score,1) as s FROM `umeed_dashboard_attribute` as a JOIN `md_umeed_attribute` as b  on a.term =b.q_term  WHERE a.grp_id=5 GROUP BY a.term, a.`month` )AS stats GROUP BY y1 desc";
                
       		
                //if( $_SESSION['umeedqr']!='')
       			//$qr=$_SESSION['umeedqr_gp5'];

          
             //for pi chart
             if (mysqli_multi_query($mysqli, $qrat1)) 
   	{
   	     do 
   	     { $result=mysqli_multi_query($mysqli, $qrat1);
       
       		 $results_array2 = Array(Array());
    		$fillKeys = true;
    		if ($result = mysqli_store_result($mysqli)) 
    		{ 
     			while ($row = $result->fetch_assoc()) 
     			{
        			$temp = Array();
        			foreach ($row as $key => $val)
        			{
            				if ($fillKeys)
            				{
                				$results_array2[0][] = $key;
            				}
            				$temp[] = $val;
        			}
        			$results_array2[] = $temp;
        			$fillKeys = false;
   		 	}
    		}    if(!mysqli_more_results($mysqli)) break;
    	    } while (mysqli_next_result($mysqli));
      	}
               
              


    	//$jsontable = json_encode($da, JSON_NUMERIC_CHECK); 
    	$jsontable2 = json_encode($results_array2, JSON_NUMERIC_CHECK);
         
        echo json_encode($jsontable2); ?> ; 


       	 //alert(vv.valueOf());        
          // Create our data table out of JSON data loaded from server.
          
           var data = new google.visualization.arrayToDataTable(JSON.parse(vv));
           var data2 = new google.visualization.arrayToDataTable(JSON.parse(vv2));
           var data3 = new google.visualization.arrayToDataTable(JSON.parse(vv3));

           var data_gp1 = new google.visualization.arrayToDataTable(JSON.parse(vv_gp1));
           var data_gp2 = new google.visualization.arrayToDataTable(JSON.parse(vv_gp2));
           var data_gp3 = new google.visualization.arrayToDataTable(JSON.parse(vv_gp3));
           var data_gp4 = new google.visualization.arrayToDataTable(JSON.parse(vv_gp4));
           var data_gp5 = new google.visualization.arrayToDataTable(JSON.parse(vv_gp5));

           var data_at1 = new google.visualization.arrayToDataTable(JSON.parse(vv_at1));
           var data_at2 = new google.visualization.arrayToDataTable(JSON.parse(vv_at2));
           var data_at3 = new google.visualization.arrayToDataTable(JSON.parse(vv_at3));
           var data_at4 = new google.visualization.arrayToDataTable(JSON.parse(vv_at4));
           var data_at5 = new google.visualization.arrayToDataTable(JSON.parse(vv_at5));

//alert(vv_at1.valueOf());

           var options_gp1 = {title: "Aesthetic Group Score", vAxis: { viewWindowMode:'explicit',viewWindow:{max:30,min:0.0}},width: 250,height: 350,bar: {groupWidth: "25%"},colors: ['green', '#f6c7b6', '#ec8f6e', '#f3b49f', '#f6c7b6'],legend: { position: "none" },};
           var options_gp2 = {title: "Behaviour Group Score" , vAxis: { viewWindowMode:'explicit',viewWindow:{max:30,min:0.0}},width: 250,height: 350,bar: {groupWidth: "25%"},legend: { position: "none" },};
           var options_gp3 = {title: "Convenience Group Score" , vAxis: { viewWindowMode:'explicit',viewWindow:{max:30,min:0.0}},width: 250,height: 350,bar: {groupWidth: "25%"},colors: ['olive', '#e6693e', '#ec8f6e', '#f3b49f', '#f6c7b6'],legend: { position: "none" },};
           var options_gp4 = {title: "Hygiene Group Score" , vAxis: { viewWindowMode:'explicit',viewWindow:{max:30,min:0.0}},width: 250,height: 350,bar: {groupWidth: "25%"},colors: ['red', '#e6693e', '#ec8f6e', '#f3b49f', '#f6c7b6'],legend: { position: "none" },};
           var options_gp5 = {title: "Product Avaiblity Group Score" , vAxis: { viewWindowMode:'explicit',viewWindow:{max:30,min:0.0}},width: 250,height: 350,bar: {groupWidth: "25%"},colors: ['#e0440e', '#e6693e', '#ec8f6e', '#f3b49f', '#f6c7b6'],legend: { position: "none" },};
           var options_at1 = {title: "Aesthetic Group Attributes Score" , vAxis: { viewWindowMode:'explicit',viewWindow:{max:2,min:0.0}},width: 2600,height: 650,legend: { position: "top" },bar: {groupWidth: "80%"},annotations: {textStyle: {fontSize: 8}}};
           var options_at2 = {title: "Behaviour Group Attributes Score",width: 850,height: 850,bar: {groupWidth: "55%"},};
           var options_at3 = {title: "Convenience Group Attributes Score",width: 350,height: 850,bar: {groupWidth: "25%"},};
           var options_at4 = {title: "Hygiene Group Attributes Score",width: 750,height: 850,bar: {groupWidth: "55%"},};
           var options_at5 = {title: "Product Avaiblity Attributes Score",width: 450,height: 850,bar: {groupWidth: "10%"},};

        var options = {
           
            title: 'JAN HML',
            
            //pieSliceText: 'value'
            //pieSliceText: 'value-and-percentage'
        };
        
       data.addColumn({type: 'string', role: 'annotation'});
       data_gp1.addColumn({type: 'string', role: 'annotation'});
       data_gp2.addColumn({type: 'string', role: 'annotation'});
       data_gp3.addColumn({type: 'string', role: 'annotation'});
       data_gp4.addColumn({type: 'string', role: 'annotation'}); 
       data_gp5.addColumn({type: 'string', role: 'annotation'}); 

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" },2]);
      var view_gp1 = new google.visualization.DataView(data_gp1);
      view_gp1.setColumns([0, 1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" },2]);
      var view_gp2 = new google.visualization.DataView(data_gp2);
      view_gp2.setColumns([0, 1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" },2]);
      var view_gp3 = new google.visualization.DataView(data_gp3);
      view_gp3.setColumns([0, 1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" },2]);
      var view_gp4 = new google.visualization.DataView(data_gp4);
      view_gp4.setColumns([0, 1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" },2]);
      var view_gp5 = new google.visualization.DataView(data_gp5);
      view_gp5.setColumns([0, 1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" },2]);
      var view_at1 = new google.visualization.DataView(data_at1);    
      view_at1.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" },2,{ calc: "stringify",sourceColumn: 2,type: "string",role: "annotation" },3,{ calc: "stringify",sourceColumn: 3,type: "string",role: "annotation" }]);
      var view_at2 = new google.visualization.DataView(data_at2);
      view_at2.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" },2,{ calc: "stringify",sourceColumn: 2,type: "string",role: "annotation" },3,{ calc: "stringify",sourceColumn: 3,type: "string",role: "annotation" }]);
      var view_at3 = new google.visualization.DataView(data_at3);
      view_at3.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" },2,{ calc: "stringify",sourceColumn: 2,type: "string",role: "annotation" },3,{ calc: "stringify",sourceColumn: 3,type: "string",role: "annotation" }]);
      var view_at4 = new google.visualization.DataView(data_at4);
      view_at4.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" },2,{ calc: "stringify",sourceColumn: 2,type: "string",role: "annotation" },3,{ calc: "stringify",sourceColumn: 3,type: "string",role: "annotation" }]);
      var view_at5 = new google.visualization.DataView(data_at5);
      view_at5.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" },2,{ calc: "stringify",sourceColumn: 2,type: "string",role: "annotation" },3,{ calc: "stringify",sourceColumn: 3,type: "string",role: "annotation" }]);

      var options1 = {
        title: "",
        width: 900,
        height: 250,
        bar: {groupWidth: "45%"},
        legend: { position: "none" }, vAxis: { viewWindowMode:'explicit',viewWindow:{max:100,min:20}}
      };
        var options2 = {
           
            title: 'FEB HML',
            
            //pieSliceText: 'value'
            //pieSliceText: 'value-and-percentage'
        };
         //var chart = new google.charts.Bar(document.getElementById('chart_div'));
         var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

         google.visualization.events.addListener(chart, 'ready', function () {
      		chart_div.innerHTML = '<img src="' + chart.getImageURI() + '">';
    	});
 
         chart.draw(view, options1);

        var chart1 = new google.visualization.PieChart(document.getElementById('chart_div1'));
	google.visualization.events.addListener(chart1, 'ready', function () {
      		//chart_div1.innerHTML = '<img src="' + chart1.getImageURI() + '">';
    	});
        chart1.draw(data2, options);

       var chart2 = new google.visualization.PieChart(document.getElementById('chart_div2'));
	google.visualization.events.addListener(chart2, 'ready', function () {
      		//chart_div2.innerHTML = '<img src="' + chart2.getImageURI() + '">';
    	});
        chart2.draw(data3, options2);

        
         var chart_gp1 = new google.visualization.ColumnChart(document.getElementById('chart_div_gp1'));
	google.visualization.events.addListener(chart_gp1, 'ready', function () {
      		//chart_div2.innerHTML = '<img src="' + chart2.getImageURI() + '">';
    	});
        chart_gp1.draw(view_gp1, options_gp1);
        
        var chart_gp2 = new google.visualization.ColumnChart(document.getElementById('chart_div_gp2'));
	google.visualization.events.addListener(chart_gp2, 'ready', function () {
      		//chart_div2.innerHTML = '<img src="' + chart2.getImageURI() + '">';
    	});
        chart_gp2.draw(view_gp2, options_gp2);

        var chart_gp3 = new google.visualization.ColumnChart(document.getElementById('chart_div_gp3'));
	google.visualization.events.addListener(chart_gp3, 'ready', function () {
      		//chart_div2.innerHTML = '<img src="' + chart2.getImageURI() + '">';
    	});
        chart_gp3.draw(view_gp3, options_gp3);

        var chart_gp4 = new google.visualization.ColumnChart(document.getElementById('chart_div_gp4'));
	google.visualization.events.addListener(chart_gp4, 'ready', function () {
      		//chart_div2.innerHTML = '<img src="' + chart2.getImageURI() + '">';
    	});
        chart_gp4.draw(view_gp4, options_gp4);

        var chart_gp5 = new google.visualization.ColumnChart(document.getElementById('chart_div_gp5'));
	google.visualization.events.addListener(chart_gp5, 'ready', function () {
      		//chart_div2.innerHTML = '<img src="' + chart2.getImageURI() + '">';
    	});
        chart_gp5.draw(view_gp5, options_gp5);

       var chart_at1 = new google.visualization.ColumnChart(document.getElementById('chart_div_at1'));
	google.visualization.events.addListener(chart_at1, 'ready', function () {
      		//chart_div_att1.innerHTML = '<img src="' + chart2.getImageURI() + '">';
    	});
        chart_at1.draw(view_at1, options_at1);
        
        var chart_at2 = new google.visualization.BarChart(document.getElementById('chart_div_at2'));
	google.visualization.events.addListener(chart_at2, 'ready', function () {
      		//chart_div_att1.innerHTML = '<img src="' + chart2.getImageURI() + '">';
    	});
        chart_at2.draw(view_at2, options_at2);
        //chart_at2.draw(data_at2, options_at2);

        var chart_at3 = new google.visualization.BarChart(document.getElementById('chart_div_at3'));
	google.visualization.events.addListener(chart_at3, 'ready', function () {
      		//chart_div_att1.innerHTML = '<img src="' + chart2.getImageURI() + '">';
    	});
        chart_at3.draw(view_at3, options_at3);

        var chart_at4 = new google.visualization.BarChart(document.getElementById('chart_div_at4'));
	google.visualization.events.addListener(chart_at4, 'ready', function () {
      		//chart_div_att1.innerHTML = '<img src="' + chart2.getImageURI() + '">';
    	});
        chart_at4.draw(view_at4, options_at4);

        var chart_at5 = new google.visualization.BarChart(document.getElementById('chart_div_at5'));
	google.visualization.events.addListener(chart_at5, 'ready', function () {
      		//chart_div_att1.innerHTML = '<img src="' + chart2.getImageURI() + '">';
    	});
        chart_at5.draw(view_at5, options_at5);

      }
    </script>
    
<style>
submit{	width: 40px;height: 32px;border: none;cursor: pointer;float: right;background-color:#dddddd;padding:2px 6px;}
</style>


  </head>


<body>
<table border=0 style="width:100%; height:100%">
<tr style="width:100%; height:2%"> <td bgcolor=white style="width:5%; height:1%"><img src="../../images/mdlogo.png" height=40px width=80px> </td><td style="width:20%; height:1%"> <font size=4 color=blue><b><center> DASHBOARD REPORT - UMEED</b></font></center></td>
<td style="width:20%; height:10%"><img src="../../images/Digiadmin_logo.jpg" style="float:right;" height=40px width=160px></td></tr>

<form action='' method=post>
<tr style="width:100%; height:8%"> <td colspan=3 bgcolor=skyblue><center>
Region <select name=rg id=rg><option value=0>--all-- </option><option value=1>Delhi</option><option value=2>Gurgoan</option><option value=3>Noida</option><option value=4>Faridabad</option><option value=5>Gaziabad</option></select> 
Booth <select name=boothid id=boothid><option value=0>--all--</option><?php $rr=DB::getInstance()->query("select distinct b_id from `mdbooth` order by b_id"); foreach($rr->results() as $r){ $bth=$r->b_id; echo "<option value=$bth>$bth</option>";}?></select> 
Shift <select name=shft id=shft><option value=0>--all-- </option><option value=1>Morning</option><option value=2>Evening</option></select>
Group  <select name=gn id=gn><option value=0>--all--</option> <option value=1>Aesthetics </option><option value=2>Behaviour </option><option value=3>Convenience </option><option value=4>Hygiene </option><option value=5>Product Avaiblity </option></select>
<input type=submit name=view value=View style="color:white;width: 50px;height: 30px;border: solid;border-color:lightblue;cursor: pointer;background-color:#01A9DB;padding:2px 6px;"> 
<input type=reset name=reset value=Reset style="color:white;width: 60px;height: 30px;border: solid;border-color:lightblue;cursor: pointer;background-color:#01A9DB;padding:2px 6px;"> 
</form>
<!--
<form method=post action='export_umeed_mscore.php'>
<input type=submit name=export1 value="Export Mean Scores" style="color:white;width: 140px;height: 30px;border: solid;border-color:lightblue;cursor: pointer;background-color:#01A9DB;padding:2px 6px;">
</form>
-->
</center></td></tr>
<tr><td colspan=3><hr><b>Cumulative Mean Score</b></td></tr>  
<tr style="width:100%; height:10%" > <td style="width:5%; height:5%" > </td>
    <td style="width:90%; height:10%" > 
        <div id='png'></div>
            <div id="chart_div" style="width: 900px; height: 250px;"></div> 
           
   </td></tr>
<tr><td colspan=3><hr><b>Month wise HML Score</b></td></tr>
<tr style="width:100%; height:5%" > <td style="width:5%; height:5%" ></td><td style="width:85%; height:10%" > 
            <table><tr><td style="width:15%; height:10%"><div id="chart_div1" style="width: 500px; height: 250px;"></div></td>
            <td style="width:15%; height:10%"><div id="chart_div2" style="width: 500px; height: 250px;"></div></td></tr>
            </table>
 </td> 
     
</td></tr>


<tr><td colspan=3><hr><b>Month wise Category Score</b></td></tr>

<tr style="width:100%; height:20%" > <td style="width:5%; height:10%" ></td><td style="width:90%; height:10%" > 
        
           <table><tr>
<td style="width:5%; "></td>
<td style="width:20%; height:10%"><div id="chart_div_gp1" style="width: 150px; height: 250px;"></div> </td> <td></td>
<td style="width:20%; height:10%"><div id="chart_div_gp2" style="width: 150px; height: 250px;"></div> </td><td></td>
<td style="width:20%; height:10%"><div id="chart_div_gp3" style="width: 150px; height: 250px;"></div> </td><td></td>
<td style="width:20%; height:10%"><div id="chart_div_gp4" style="width: 150px; height: 250px;"></div> </td><td></td>
<td style="width:20%; height:10%"><div id="chart_div_gp5" style="width: 150px; height: 250px;"></div> </td><td></td>
</tr>
<tr>
<td style="width:5%; ">.</td>
<td style="width:20%; height:10%">.</td></tr>
<tr>
<td style="width:5%; ">.</td>
<td style="width:20%; height:10%">.</td></tr>
<tr>
<td style="width:5%; ">.</td>
<td style="width:20%; height:10%">.</td></tr>
<tr>
<td style="width:5%; ">.</td>
<td style="width:20%; height:10%">.</td></tr>
</table>
           
 </td> </tr>
<tr><td colspan=3><hr><b>Month wise Attribute Score</b></td></tr>
<tr style="width:100%; height:1%" > 
<td style="width:5%; height:1%" ></td>
<td style="width:90%; height:1%">
</td></tr>
<tr><td></td><td>
 <table><tr><td><div id="chart_div_at1" style="width: 1200px; height: 1850px;"></div> </td><td> </td><td> </td><td> </td><td> </td></tr></table>
</td></tr></table>
<table>
<tr><td> </td><td><div id="chart_div_at2" style="width: 750px; height: 250px;"></div> </td><td><div id="chart_div_at3" style="width: 450px; height: 250px;"></div> </td><td></td><td></td> </tr>
</table>
<table>
<tr><td> </td><td><div id="chart_div_at4" style="width: 450px; height: 250px;"></div> </td><td><div id="chart_div_at5" style="width: 450px; height: 250px;"></div> </td></tr>
</table>
</td></tr>
</table>

</body>
<script type="text/javascript">
  document.getElementById('rg').value = "<?php echo $_POST['rg'];?>";
  document.getElementById('boothid').value = "<?php echo $_POST['boothid'];?>";
  document.getElementById('shft').value = "<?php echo $_POST['shft'];?>";
  document.getElementById('gn').value = "<?php echo $_POST['gn'];?>"; 
  
</script>


</html>