<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title> <?= $pn ?> | CrossTabulation</title>

</head>

<body style="font-size:8pt;">

<?php
include_once('init.php');
include_once('functions.php');
$pn = $_GET['pn'];

date_default_timezone_set("Asia/Kolkata");
$pstrx='';
$pstrx2='';
//print_r($_POST);

$pid = $_SESSION['ctpid'];
$table = $_SESSION['cttable'];

if($pid == '' || $table == '') die('Please re-login');
$xtu = $alltables = array();
$xtu = $alltables = array($table);

$ttc=1;

    $xtables='';$ytables='';$tables='';$xfields='';$yfiled='';$fields='';$conditions='';$acnt='';
    $tx=array();$f=array();$c=array();$ty=array();$fx=array();$fy=array();
	//$alltables=array();

//$pid=$_GET['ctp'];
//$data= get_project_term($pid);
//print_r($_POST);

//$fpdata= get_project_fp($pid);
//$pqtdata = get_project_question_term($pid);
//$data=array_merge($fpdata,$pqtdata);
$data=$_SESSION['ctdata'];
//print_r($data);

$tdata=array();
if($data)
foreach($data as $dt){
	//print_r($dt);
	$ss=$dt['qop'];
	$trm=$dt['term'];
	$tdata[ $trm ] = $ss;
}

//print_r($tdata);

class TableRows extends RecursiveIteratorIterator 
{ 
     function __construct($it) { 
         parent::__construct($it, self::LEAVES_ONLY); 
     }

     function current() {
         return "<td style='border: 0.1em solid lightgray;'>" . parent::current(). "</td>";
     }

     function beginChildren() { 
         echo "<tr>"; 
     } 

     function endChildren() { 
         echo "</tr>" . "\n";
     } 
}

?>
<!--
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title> <?= $pn ?> | CrossTabulation</title>

</head>

<body style="font-size:8pt;">
-->
<?php
//begin for show button
if(isset($_POST['ctv'])){

	$xa = $ya = $fa = array();
	$fx = $fy = $fxu = array();

	$m = $_POST['scale'];
	$xa = $_POST['xa'];
	$ya = $_POST['ya'];
	if(isset($_POST['fa']))$fa = $_POST['fa'];

	//print_r($ya);
   	$ctr=0;$prev='';$curr='';$v1='';$v2='';$prv1='';$flag=0;$andflag=0;

	$fx = explode(",",$xa);
	$fy = $ya;
	$xfields = $fx[0];
	$yfields = $fy;
	$fxu=array_unique($fx);

	//print_r($fa);echo count($fa);
    if(count($fa)>0)
    {
        //print_r($faa);
        $c=array_unique($fa);
        $tx2=array();$fx2=array();

        foreach($c as $ff)
        {
            $crr1='';
            //echo '<br>ff : '.$ff;
            $curr=substr($ff, 0, 5); //get 1st 5 char from filters array
            $arr=explode("=",$ff);
            $v1=$arr[0]; 
            $v2=$arr[1];
			$fx2=$tx2=$table;

    		$acnt=substr_count($prv1, 'AND');
                           if($acnt==0)
                              $vv1='a3.'.$v1;
                           if($acnt==1)
                              $vv1='a4.'.$v1;
                           if($acnt==2)
                              $vv1='a5.'.$v1;
                           if($acnt==3)
                              $vv1='a6.'.$v1;
                           if($acnt==4)
                              $vv1='a7.'.$v1;
                           if($acnt==5)
                              $vv1='a8.'.$v1;
                           if($acnt==6)
                              $vv1='a9.'.$v1;
                           if($acnt==7)
                              $vv1='a10.'.$v1;
                           if($acnt==8)
                              $vv1='a11.'.$v1;
                           if($acnt==9)
                              $vv1='a12.'.$v1;
                           if($acnt==10)
                              $vv1='a13.'.$v1;
                           if($acnt==11)
                              $vv1='a14.'.$v1;

			if($ctr==0){$conditions=" WHERE  "; }
            else
            {  
                if($curr==$prev)
                {
                    // echo '<br> cuur if v1 : '.$vv1.'='.$v2; 
                        $flag++;
                        if($flag==1)
                        {   
                               $prv1.='('.$pp1.' OR '.$vv1.'='.$v2;
                        }
                        else
                        {   
                            $prv1.=' OR '.$vv1.'='.$v2;
                        }
                            $andflag=0;
                }
                else
                { 
                    if($flag>0)
                        $prv1.=') AND ';
                    else
                        $prv1.=$pp1.' AND ';
                    //$conditions.=' AND ';      
                    $flag=0; $andflag=1;
                }   

            } //end of else if( $ctr ==0)  

				$acnt=substr_count($prv1, 'AND'); 
              
                           if($acnt==0)
                              $vv1='a3.'.$v1;
                           if($acnt==1)
                              $vv1='a4.'.$v1;
                           if($acnt==2)
                              $vv1='a5.'.$v1;
                           if($acnt==3)
                              $vv1='a6.'.$v1;
                           if($acnt==4)
                              $vv1='a7.'.$v1;
                           if($acnt==5)
                              $vv1='a8.'.$v1;
                           if($acnt==6)
                              $vv1='a9.'.$v1;
                           if($acnt==7)
                              $vv1='a10.'.$v1;
                           if($acnt==8)
                              $vv1='a11.'.$v1;
                           if($acnt==9)
                              $vv1='a12.'.$v1;
                           if($acnt==10)
                              $vv1='a13.'.$v1;
                           if($acnt==11)
                              $vv1='a14.'.$v1;

				if($flag==0)
					$pp1=$vv1.'='.$v2;
				if($flag==0 && $andflag==1)
				$prev=$curr;
				$ctr++;
        } //end of foreach
		
				$acnt=substr_count($prv1, 'AND'); 
                           if($acnt==0)
                              $vv1='a3.'.$v1;
                           if($acnt==1)
                              $vv1='a4.'.$v1;
                           if($acnt==2)
                              $vv1='a5.'.$v1;
                           if($acnt==3)
                              $vv1='a6.'.$v1;
                           if($acnt==4)
                              $vv1='a7.'.$v1;
                           if($acnt==5)
                              $vv1='a8.'.$v1;
                           if($acnt==6)
                              $vv1='a9.'.$v1;
                           if($acnt==7)
                              $vv1='a10.'.$v1;
                           if($acnt==8)
                              $vv1='a11.'.$v1;
                           if($acnt==9)
                              $vv1='a12.'.$v1;
                           if($acnt==10)
                              $vv1='a13.'.$v1;
                           if($acnt==11)
                              $vv1='a14.'.$v1;

				if($flag==0 && $andflag==1)
				$prv1.=$vv1.'='.$v2;
				if($flag==0 && $andflag==0)
				$prv1.=$vv1.'='.$v2;

				if($flag>0)
					$prv1.=' )';
				$conditions.=$prv1;
    } // end of if(count($fa)>2)

 	//echo '<br>condition : '.$conditions;

    $len=strlen($conditions);
    	$temp=''; $ctr=0; $pr=''; $strvisit1=''; $tab='';
    foreach($alltables as $t)
    {   $ctr++;
        $tab=$t;
	//echo "<br>Hello t: $t";
        if($ttc==1 && $ctr==1 && $len==0 && $acnt<1 )
        {
            $temp=$pr=$t.' as a1 JOIN '.$t.' as a2 ON a1.resp_id=a2.resp_id';
        }

         if($ttc==1 && $ctr==1 && $len >1 && $acnt==0 )
        {
            $temp=$pr=$t.' as a1 JOIN '.$t.' as a2 ON a1.resp_id=a2.resp_id JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id ';
        }
        if($ttc==1 && $ctr==1 && $len >1 && $acnt==1 )
        {
            $temp=$pr=$t.' as a1 JOIN '.$t.' as a2 ON a1.resp_id=a2.resp_id JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id';
        }
        if($ttc==1 && $ctr==1 && $len >1 && $acnt==2 )
        {
            $temp=$pr=$t.' as a1 JOIN '.$t.' as a2 ON a1.resp_id=a2.resp_id JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id JOIN '. $t .' as a5 ON a1.resp_id = a5.resp_id';
        }
        if($ttc==1 && $ctr==1 && $len >1 && $acnt==3 )
        {
            $temp=$pr=$t.' as a1 JOIN '.$t.' as a2 ON a1.resp_id=a2.resp_id JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id JOIN '. $t .' as a5 ON a1.resp_id = a5.resp_id JOIN '. $t .' as a6 ON a1.resp_id = a6.resp_id';
        }
        if($ttc==1 && $ctr==1 && $len >1 && $acnt==4 )
        {
            $temp=$pr=$t.' as a1 JOIN '.$t.' as a2 ON a1.resp_id=a2.resp_id JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id JOIN '. $t .' as a5 ON a1.resp_id = a5.resp_id JOIN '. $t .' as a6 ON a1.resp_id = a6.resp_id JOIN '. $t .' as a7 ON a1.resp_id = a7.resp_id';
        }
         if($ttc==1 && $ctr==1 && $len >1 && $acnt==5)
        {
            $temp=$pr=$t.' as a1 JOIN '.$t.' as a2 ON a1.resp_id=a2.resp_id JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id JOIN '. $t .' as a5 ON a1.resp_id = a5.resp_id JOIN '. $t .' as a6 ON a1.resp_id = a6.resp_id JOIN '. $t .' as a7 ON a1.resp_id = a7.resp_id JOIN '. $t .' as a8 ON a1.resp_id = a8.resp_id';
        }
        if($ttc==1 && $ctr==1 && $len >1 && $acnt==6)
        {
            $temp=$pr=$t.' as a1 JOIN '.$t.' as a2 ON a1.resp_id=a2.resp_id JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id JOIN '. $t .' as a5 ON a1.resp_id = a5.resp_id JOIN '. $t .' as a6 ON a1.resp_id = a6.resp_id JOIN '. $t .' as a7 ON a1.resp_id = a7.resp_id JOIN '. $t .' as a8 ON a1.resp_id = a8.resp_id JOIN '. $t .' as a9 ON a1.resp_id = a9.resp_id';
        }
        if($ttc==1 && $ctr==1 && $len >1 && $acnt==7)
        {
            $temp=$pr=$t.' as a1 JOIN '.$t.' as a2 ON a1.resp_id=a2.resp_id JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id JOIN '. $t .' as a5 ON a1.resp_id = a5.resp_id JOIN '. $t .' as a6 ON a1.resp_id = a6.resp_id JOIN '. $t .' as a7 ON a1.resp_id = a7.resp_id JOIN '. $t .' as a8 ON a1.resp_id = a8.resp_id JOIN '. $t .' as a9 ON a1.resp_id = a9.resp_id JOIN '. $t .' as a10 ON a1.resp_id = a10.resp_id';
        }
        if($ttc==1 && $ctr==1 && $len >1 && $acnt==8)
        {
            $temp=$pr=$t.' as a1 JOIN '.$t.' as a2 ON a1.resp_id=a2.resp_id JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id JOIN '. $t .' as a5 ON a1.resp_id = a5.resp_id JOIN '. $t .' as a6 ON a1.resp_id = a6.resp_id JOIN '. $t .' as a7 ON a1.resp_id = a7.resp_id JOIN '. $t .' as a8 ON a1.resp_id = a8.resp_id JOIN '. $t .' as a9 ON a1.resp_id = a9.resp_id JOIN '. $t .' as a10 ON a1.resp_id = a10.resp_id JOIN '. $t .' as a11 ON a1.resp_id = a11.resp_id';
        }
         if($ttc==1 && $ctr==1 && $len >1 && $acnt==9)
        {
            $temp=$pr=$t.' as a1 JOIN '.$t.' as a2 ON a1.resp_id=a2.resp_id JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id JOIN '. $t .' as a5 ON a1.resp_id = a5.resp_id JOIN '. $t .' as a6 ON a1.resp_id = a6.resp_id JOIN '. $t .' as a7 ON a1.resp_id = a7.resp_id JOIN '. $t .' as a8 ON a1.resp_id = a8.resp_id JOIN '. $t .' as a9 ON a1.resp_id = a9.resp_id JOIN '. $t .' as a10 ON a1.resp_id = a10.resp_id JOIN '. $t .' as a11 ON a1.resp_id = a11.resp_id JOIN '. $t .' as a12 ON a1.resp_id = a12.resp_id';
        }
           if($ttc==1 && $ctr==1 && $len >1 && $acnt==10)
        {
            $temp=$pr=$t.' as a1 JOIN '.$t.' as a2 ON a1.resp_id=a2.resp_id JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id JOIN '. $t .' as a5 ON a1.resp_id = a5.resp_id JOIN '. $t .' as a6 ON a1.resp_id = a6.resp_id JOIN '. $t .' as a7 ON a1.resp_id = a7.resp_id JOIN '. $t .' as a8 ON a1.resp_id = a8.resp_id JOIN '. $t .' as a9 ON a1.resp_id = a9.resp_id JOIN '. $t .' as a10 ON a1.resp_id = a10.resp_id JOIN '. $t .' as a11 ON a1.resp_id = a11.resp_id JOIN '. $t .' as a12 ON a1.resp_id = a12.resp_id JOIN '. $t .' as a13 ON a1.resp_id = a13.resp_id';
        }
        if($ttc==1 && $ctr==1 && $len >1 && $acnt==11)
        {
            $temp=$pr=$t.' as a1 JOIN '.$t.' as a2 ON a1.resp_id=a2.resp_id JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id JOIN '. $t .' as a5 ON a1.resp_id = a5.resp_id JOIN '. $t .' as a6 ON a1.resp_id = a6.resp_id JOIN '. $t .' as a7 ON a1.resp_id = a7.resp_id JOIN '. $t .' as a8 ON a1.resp_id = a8.resp_id JOIN '. $t .' as a9 ON a1.resp_id = a9.resp_id JOIN '. $t .' as a10 ON a1.resp_id = a10.resp_id JOIN '. $t .' as a11 ON a1.resp_id = a11.resp_id JOIN '. $t .' as a12 ON a1.resp_id = a12.resp_id JOIN '. $t .' as a13 ON a1.resp_id = a13.resp_id JOIN '. $t .' as a14 ON a1.resp_id = a14.resp_id';
        }
        if($ttc==1 && $ctr==1 && $len >1 && $acnt==12)
        {
            $temp=$pr=$t.' as a1 JOIN '.$t.' as a2 ON a1.resp_id=a2.resp_id JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id JOIN '. $t .' as a5 ON a1.resp_id = a5.resp_id JOIN '. $t .' as a6 ON a1.resp_id = a6.resp_id JOIN '. $t .' as a7 ON a1.resp_id = a7.resp_id JOIN '. $t .' as a8 ON a1.resp_id = a8.resp_id JOIN '. $t .' as a9 ON a1.resp_id = a9.resp_id JOIN '. $t .' as a10 ON a1.resp_id = a10.resp_id JOIN '. $t .' as a11 ON a1.resp_id = a11.resp_id JOIN '. $t .' as a12 ON a1.resp_id = a12.resp_id JOIN '. $t .' as a13 ON a1.resp_id = a13.resp_id JOIN '. $t .' as a14 ON a1.resp_id = a14.resp_id JOIN '. $t .' as a15 ON a1.resp_id = a15.resp_id';
        }
    }
   	$table=$temp;
	foreach($ya as $stryy)   
	{
		$yfields=$stryy;
 
		//begin::make pivot count query, first search all table field from y-axis list   #################################
		$str='';
	  if($m == 'tot')
	  {
            	$pstrx = "SELECT IFNULL(y1,'Total') as '$yfields'";
		//$pstrx="SELECT IFNULL(y1,'Total') as '$stryy'";
            	//$pstrx2="SELECT IFNULL(get_term('$yfields',y1),'Total') as '$yfields'";
            	$pstrx2 = "SELECT IFNULL( y1,'Total') as '$yfields'";
            	$arrc=array();
            	foreach($xtu as $yt)
            	{
                	//make pivot x list from each column of x
                	foreach($fxu as $f)
                	{
                    		//$rs=get_dictionary($f,$pid);
		    		$rs2=$tdata[ $f ] ;
                    		if(count($rs2)>0)
                    		{
                        	   foreach($rs2 as $r)
                        	   {
					$rv = $r['value'];
					$rt = $r['opt_text_value'];
                        		$pstrx .= ", SUM(CASE x1 WHEN $rv THEN tot ELSE 0 END) as '$rt' ";
                        		$pstrx2 .= ", SUM(CASE x1 WHEN $rv THEN tot ELSE 0 END) as '$rt' ";
					//$pstrx.=", SUM(CASE x1 WHEN $r->value THEN tot ELSE 0 END) as '$r->keyy' ";
                        		//$pstrx2.=", SUM(CASE x1 WHEN $r->value THEN tot ELSE 0 END) as '$r->keyy' ";
                           	    }
                    		} //end of if 
                	}
            	}
            	$str='';$stra='';$ss='';

            	if($xfields == $yfields){$ss="COUNT(distinct a1.resp_id)";}else $ss="SUM(if(a1.$xfields!='',1,0))"; 
 
            	if(strlen($conditions)>1){
			$str=" AND $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";
            	}
   	        else
	        {
		 	$str="WHERE $stra  a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";
	        }

             $pstrx .= ", SUM(tot) as Total FROM ( SELECT
                a2. $yfields y1,
               a1. $xfields as x1,
                $ss as tot
                        FROM
                        $table  $conditions  $str AND a2. $yfields!=''  GROUP BY a2. $yfields, a1. $xfields 
                )AS stats GROUP BY y1 desc WITH ROLLUP";
              $pstrx2 .= " FROM ( SELECT
                a2. $yfields y1,
                a1. $xfields as x1,
                $ss as tot
                        FROM
                        $table  $conditions  $str AND a2. $yfields!='' GROUP BY a2. $yfields, a1. $xfields 
                )AS stats GROUP BY y1 desc";

		}// end for pivot count query    ########################################
    
        //begin::make pivot % count query, first search all table field from y-axis list  =================================
     
		$tot_tv=0;
		if($m=='totp')
		{
            
            $str='';$stra='';$ss='';
            
            if($xfields==$yfields){$ss="COUNT(distinct a1.resp_id)";}else $ss="SUM(if(a1.$xfields!='',1,0))"; 
            if(strlen($conditions)>1){
				$str=" AND $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}else{$str="WHERE $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid) AND a2.$yfields!='' ";
			}
            
            $qtc="SELECT $ss as tot FROM $table   $conditions $str";
            $contrs=DB::getInstance()->query($qtc);
            if($contrs->count()>0)
            {
            	$tot_tv=$contrs->first()->tot;   
            }
            $pstrx="SELECT IFNULL(y1,'Total %') as $yfields ";
            $pstrx2="SELECT IFNULL(y1,'Total %') as $yfields ";

            $arrc=array();
            foreach($xtu as $yt)
            {
                //make pivot x list from each column of x 
                foreach($fxu as $f)
                {  
                    $p=$f;
                    
                    //$rs=get_dictionary($f,$pid);
		    $rs = $tdata[ $f ] ;
                    if(count($rs))
                    {
                        foreach($rs as $r)
                        {

                                $rv=$r['value'];
                                $rt=$r['opt_text_value'];
                        $pstrx.=",round( SUM(CASE x1 WHEN $rv THEN tot ELSE 0 END)/$tot_tv *100 ,2) as '$rt %' ";
                        $pstrx2.=",round( SUM(CASE x1 WHEN $rv THEN tot ELSE 0 END)/$tot_tv *100 ,2) as '$rt %' ";
                        //$pstrx.=",round( SUM(CASE x1 WHEN $r->value THEN tot ELSE 0 END)/$tot_tv *100 ,2) as '$r->keyy %' ";
                        //$pstrx2.=",round( SUM(CASE x1 WHEN $r->value THEN tot ELSE 0 END)/$tot_tv *100 ,2) as '$r->keyy %' ";
                        }
                    }  

                }
            }

            $str='';$stra='';
             
            if(strlen($conditions)>1){$str=" AND  $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}else{$str="WHERE $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}
             
                $pstrx.=", round( SUM(tot)/$tot_tv*100 ,2) as 'Total %' FROM ( SELECT
                a2.$yfields y1,
                a1.$xfields as x1,
                $ss as tot
                        FROM
                        $table $conditions  $str AND a2.$yfields!='' GROUP BY a2.$yfields, a1.$xfields 
                )AS stats GROUP BY y1 desc WITH ROLLUP";

                $pstrx2.=" FROM ( SELECT
               a2. $yfields y1,
               a1. $xfields as x1,
                $ss as tot
                        FROM
                        $table $conditions  $str AND a2.$yfields!='' GROUP BY a2.$yfields, a1.$xfields 
                )AS stats GROUP BY y1 desc";

	   }// end for pivot count % query   ===============================================

             //begin::make pivot row % query, first search all table field from y-axis list  =================================
	  if($m=='rowp')
	  {
            $dv='';
            //$dv=get_dictionary_value($yfields,1);
            $pstrx="SELECT IFNULL(y1,'Row Total %') as $yfields ";
            $pstrx2="SELECT IFNULL(y1,'Total %') as $yfields ";

            $arrc=array();
            foreach($xtu as $yt)
            {
                //make pivot x list from each column of x 
                foreach($fxu as $f)
                {  
                    $p=$f;
                   
                    //$rs=get_dictionary($f,$pid);
                    $rs=$tdata[ $f ] ;
                    if(count($rs))
                    {
                        foreach($rs as $r)
                        {

                                $rv=$r['value'];
                                $rt=$r['opt_text_value'];
                        $pstrx.=",round( SUM(CASE x1 WHEN $rv THEN tot ELSE 0 END)/ sum(tot) *100 ,2) as '$rt %' ";
                        $pstrx2.=",round( SUM(CASE x1 WHEN $rv THEN tot ELSE 0 END)/sum(tot) *100 ,2) as '$rt %' ";
                        //$pstrx.=",round( SUM(CASE x1 WHEN $r->value THEN tot ELSE 0 END)/sum(tot)*100 ,2) as '$r->keyy %' ";
                        //$pstrx2.=",round( SUM(CASE x1 WHEN $r->value THEN tot ELSE 0 END)/sum(tot)*100 ,2) as '$r->keyy %' ";
                        }
                    }  

                }
            }
            
            $str='';$stra='';$ss='';
            
            if($xfields==$yfields){$ss="COUNT(distinct resp_id)";}else $ss="SUM(if(a1.$xfields!='',1,0))"; 
            if(strlen($conditions)>1){$str=" AND $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}else{$str="WHERE $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}
            $pstrx.=",round( sum(tot)/sum(tot)*100 ,2) as Total  FROM ( SELECT
                a2.$yfields y1,
                a1.$xfields as x1,
                $ss as tot
                        FROM
                        $table  $conditions $str AND a2.$yfields!=''  GROUP BY a2.$yfields, a1.$xfields 
                )AS stats GROUP BY y1 desc WITH ROLLUP";
                
                $pstrx2.=" FROM ( SELECT
                a2.$yfields y1,
                a1.$xfields as x1,
                $ss as tot
                        FROM
                        $table  $conditions $str AND a2.$yfields!='' GROUP BY a2.$yfields, a1.$xfields 
                )AS stats GROUP BY y1 desc";

		}// end for pivot row % query   ===============================================
       
             //begin::make pivot row % query, first search all table field from y-axis list  =================================
		if($m=='colp')
		{
            $pstrx11="SELECT IFNULL(y1,'Total') as '$yfields' ";
            $arrc=array();
            foreach($xtu as $yt)
            {
                //make pivot x list from each column of x 
                foreach($fxu as $f)
                {
                    //$rs=get_dictionary($f,$pid);
		    $rs=$tdata[ $f ] ;
                    if(count($rs))
                    {
                        foreach($rs as $r)
                        {

                                $rv=$r['value'];
                                $rt=$r['opt_text_value'];
                        	//$pstrx.=",round( SUM(CASE x1 WHEN $rv THEN tot ELSE 0 END)/$tot_tv *100 ,2) as '$rt %' ";
                        	$pstrx11.=", SUM(CASE x1 WHEN $rv THEN tot ELSE 0 END) as '$rt' ";
                        }
                    }
                }
            }
            $str='';$stra='';$ss='';

            if($xfields==$yfields){$ss="COUNT(distinct resp_id)";}else $ss="SUM(if(a1.$xfields!='',1,0))"; 

            if(strlen($conditions)>1){$str=" AND $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}else{$str="WHERE $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}

            $pstrx11.=", SUM(tot) as Total FROM ( SELECT
                a2. $yfields y1,
                a1. $xfields as x1,
                $ss as tot
                        FROM
                        $table  $conditions $str AND a2. $yfields!=''  GROUP BY a2. $yfields, a1. $xfields 
                )AS stats GROUP BY y1 desc WITH ROLLUP";

                  //to show the last Column Total value
                  $last=array();
                    $rr=DB::getInstance()->query($pstrx11);
                    if($rr)
                    foreach($rr->results() as $r)
                    {
                        $last=$r;
                    }

                    $ro=0;$rtot=0;
            $pstrx="SELECT IFNULL(y1,'Total') as $yfields ";
            $pstrx2="SELECT IFNULL(y1,'Total') as $yfields ";

            $arrc=array();
            foreach($xtu as $yt)
            {
                //make pivot x list from each column of x 
                foreach($fxu as $f)
                {
                    $p=$f;
                    //$rs=get_dictionary($f,$pid);
		   $rs=$tdata[ $f ] ; 
                   if(count($rs))
                    {
                        foreach($rs as $r)
                        {
                                $rv=$r['value'];
                                $rt=$r['opt_text_value'];
                            $temp='';
                            $temp=$rt;
                            if(!empty($last))
                            {
                            	$ro=$last->$temp;
                            	if($ro==0) $ro=1;
                            	$rtot=$last->Total;
                            }
                        	$pstrx.=",round( SUM(CASE x1 WHEN $rv THEN tot ELSE 0 END)/$ro *100 ,2) as '$rt %' ";
                        	$pstrx2.=",round( SUM(CASE x1 WHEN $rv THEN tot ELSE 0 END)/$ro *100 ,2) as '$rt %' ";
                        	//$pstrx.=",round( SUM(CASE x1 WHEN $r->value THEN tot ELSE 0 END)/$ro *100 ,2) as '$r->keyy %' ";
                        	//$pstrx2.=",round( SUM(CASE x1 WHEN $r->value THEN tot ELSE 0 END)/$ro *100 ,2) as '$r->keyy %' ";
                        }
                    }

                } //end of foreach fxu
            } //end of foreach xtu

            $str='';$stra='';
            if($xfields==$yfields){$ss="COUNT(distinct a1.resp_id)";}else $ss="SUM(if(a1.$xfields!='',1,0))"; 
            if(strlen($conditions)>1){$str=" AND $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}else{$str="WHERE $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}
            $pstrx.=",round( sum(tot)/$rtot*100 ,2) as 'Column %'  FROM ( SELECT
               a2. $yfields y1,
               a1. $xfields as x1,
                $ss as tot
                        FROM
                        $table  $conditions $str  AND a2.$yfields!='' GROUP BY a2.$yfields, a1.$xfields 
                )AS stats GROUP BY y1 desc WITH ROLLUP";
              $pstrx2.="  FROM ( SELECT
               a2. $yfields y1,
               a1. $xfields as x1,
                $ss as tot
                        FROM
                        $table  $conditions $str AND a2.$yfields!=''  GROUP BY a2.$yfields, a1.$xfields 
                )AS stats GROUP BY y1 desc";
		}// end for pivot column % query   ===============================================

			echo "<br> $yfields </br>";   
			//echo '<br>pstrx : '.$pstrx;

			 $_SESSION['query']=$pstrx;
			 $_SESSION['yfields']=$yfields;
			 $_SESSION['xfields']=$xfields;
			 $_SESSION['query2']=$pstrx2;
				 //===========================begin
			try {
			$columns=array();
			 $conn = new PDO("mysql:host=database-1.c1mggasso0hp.ap-south-1.rds.amazonaws.com;dbname=vcims", 'qcsrdsadmin', 'Pa7du#ah$098');
			 $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			 $stmt = $conn->prepare($pstrx); 
			 $stmt->execute();
			 // set the resulting array to associative
			 $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
			 $head='';
			 //to display column heading
			 echo "<table border=1 cellpadding=0 cellspacing=0 style='border : 0.15px solid gray; font-size:10pt;'>";
			 for ($i = 0; $i < $stmt->columnCount(); $i++) {
			$col = $stmt->getColumnMeta($i);
			$columns[] = $col['name'];
			}
			 $strth="<tr bgcolor=#fff  style='border : 0.15px solid white;'>";
			 $ccnt=0;
			 //print_r($data);
			 if(count($columns))
			 foreach($columns as $t)
			 {
				 if($t==$yfields)
				 {
					$tm='';
					 //$tm=get_dictionary_title_only($yfields);
					foreach($data as $tdd){
						if($yfields == $tdd['term']){
							$tm = $tdd['q_title'] ;
							break;
						}
					}
					 $tm = strtoupper($tm);
					 $strth.="<th style='width:40%; font-size:7pt;'> $tm </th>";$head.=$tm;
				 }
				 else
				 {
					$t = strtoupper($t);
					$strth.="<th style='width:40%; font-size:7pt;'> $t </th>";$head.=$t;
				 }
				$ccnt++;
			 }
			 echo $strth.='</tr>';
			 $qst=new RecursiveArrayIterator($stmt->fetchAll());
			 //display y-axis term as their value
			 $ctr=0;
			 foreach($qst as $ar)
			 {
				 $tt=$ar[$yfields];
				 if(is_numeric($tt))
				 {
					//$tm = $tdata[ $f ]['opt_text_value'] ;
					$tm=$tdata[ $yfields ];
					$tz='';
					foreach($tm as $tx){
						$tv=$tx['value'];
						if($tv == $tt){
							$tz=$tx['opt_text_value']; break;
						}
					}

					$qst[$ctr][$yfields]=$tz;
					//$qst[$ctr][$yfields]=get_dictionary_value($yfields,$tt);
				 }
				 $ctr++;
			 }
			 foreach(new TableRows($qst) as $k=>$v) { 
				  echo $v;  
			 }
			} //end of try
			catch(PDOException $e) {
				 echo "Error: " . $e->getMessage();
			}
			$conn = null;
			echo "</table>";
	} //end of foreach for each y-axis 
	
} //end of show if
//end of show button

//begin for show all button
if(isset($_POST['ctva'])){
	print_r($_POST);

}

//end of show all button

//begin for export all button
if(isset($_POST['ctea'])){
	print_r($_POST);

}
//end of export all button

?>
</body>
</html>
