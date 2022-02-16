<?php
include_once('../init.php');
include_once('../functions.php');
date_default_timezone_set("Asia/Kolkata");
$pstrx='';$pstrx2='';
$rv=0;
$mn=0;
$yrs=2017;

  echo "<center>Your Result:<br>";
  if(isset($_POST['show']))
{
   if($_POST['project']==0)
   { 
      echo "<center><font color=red>Please select project from list for cross tab report.</font><br>";
   }
}

class TableRows extends RecursiveIteratorIterator 
    { 
     function __construct($it) { 
         parent::__construct($it, self::LEAVES_ONLY); 
     }

     function current() {
         return "<td style='width: 150px; border: 1px solid black;'>" . parent::current(). "</td>";
     }

     function beginChildren() { 
         echo "<tr>"; 
     } 

     function endChildren() { 
         echo "</tr>" . "\n";
     } 
    }

//###########################################################################################
if(isset($_POST['show']))
{
   //$mn=$_POST['month'];
	$mn=1;
   $pid = $_POST['project'];

   if(!Session::exists('suser'))
  {
	//Redirect::to('login_fp.php');
       die('Please close this page and relogin again');
  }
   if($pid != 0)
   { 
    $xtables='';$ytables='';$tables='';$xfields='';$yfiled='';$fields='';$conditions='';$acnt='';
    
    $tx=array();$f=array();$c=array();$ty=array();$fx=array();$fy=array();$alltables=array();
    
    //$pid=$_POST['project'];
    $m=$_POST['measure'];
    $xaa=$_POST['xv'];
    $yaa=$_POST['yv'];
    $faa=$_POST['fv'];

    $_SESSION['unit']=$m;

    if($_POST['xv']=='')
         $xaa='centre';
    if($_POST['yv']=='')
         $yaa='centre';


//echo $pid;
    //get as string value as within single '' from a string list separated by , of x-axis or y-axis
    //$strx= implode("','",explode(",",$xaa));
    $strx= implode("','",explode(",",$xaa));
    $stry= implode("','",explode(",",$yaa));

	$strx= explode(",",$xaa);
	$stry= explode(",",$yaa);
//print_r($strx);
//print_r($stry); 
//echo '<br>f:'.$stry[0];

    //get the table name and column name as two array like $tx and $fx of X/Y axis
        //list($tx,$fx)=get_table_column($strx);
    	//list($ty,$fy)=get_table_column($stry[0]);
	//$fy=array_unique($fy);
	//$tx='['.$ty[0].','.$xaa.']';
$fx=$strx;
$fy=$stry;
$xfields=$fx[0];
//$yfields=array();
$yfields=$fy;
	//print_r($yfields);
    if(!empty($tx) && is_array($tx) ){
	$xtu=array_unique($tx); 
	if(is_array($tx)) $xtables=implode(",",array_unique($tx));
	if(strlen($tables)>0){
		$tables.=', ';
		$tables.=$xtables;
	}else $tables = $xtables;
    }
    if(!empty($ty) && is_array($ty)){
	$ytu=array_unique($ty);
	$ytables=implode(",",array_unique($ty));
	if(strlen($tables)>0){
		$tables.=', ';
		$tables.=$ytables;
	}else $tables=$ytables;
    }
    if(!empty($fx) && is_array($fx)){
	$fxu=array_unique($fx);
	//$xfields=$fxu;
	//if(count($fxu)>1)
		//$xfields=implode(",",$fx);
	//echo "<br> xfields: $xfields";
    }else {
	$xfields=implode(",",$fx);
	if($xfields == '') $xfields=$xaa;
    }

//echo '<br>xf: '.$tables;
// if(count($fy)==1){ $yfields=$fy[0];}else if(count($fy)>1) { $yfields=implode(",",$fy);}else {$yfields=$stry[0];}
   if($faa){ $x=explode(",",$faa);
    $c=array_unique($x);
    }
	//print_r($yfields);
	//echo "Filter:";print_r($c);
    //echo '<br>fy : '.count($fy);
   // if((!empty($tx)) && (!empty($ty))){ 
	//$tables=implode(",",array_unique(array_merge($tx,$ty)));
    //}else echo 'select x and Y axis';
    
    //echo '<br>Tables : '.$tables;
/*    if(count($tx)!=0 && count($ty)!=0) $alltables=array_unique(array_merge($tx,$ty)); 
            else if(count($tx)!=0 && count($ty)==0)$alltables=$tx;
            else if(count($ty)!=0 && count($tx)==0)$alltables=$ty;
*/

    //echo '<br>Join Tables : '.$tables;
$tables=get_project_table($pid);
//echo '<br> Tables : '.$tables;
$xtu=$alltables=array($tables);
$ttc=count($alltables);
    //echo '<br>len : '.$ttc;
    //start::for filter conditions with AND , OR and get output as $conditions
   $ctr=0;$prev='';$curr='';$v1='';$v2='';$prv1='';$flag=0;$andflag=0;
      //echo '<br>len : '.strlen($faa);
    if(strlen($faa)>2)
    {
        //print_r($faa);
        $x=explode(",",$faa);
        $c=array_unique($x);

        $tx2=array();$fx2=array();
        
        foreach($c as $ff)
        {    
            $crr1='';
            //echo '<br>$ff : '.$ff;
            $curr=substr($ff, 0, 5); //get 1st 5 char from filters array
            $arr=explode("=",$ff);
            $v1=$arr[0]; 
            $v2=$arr[1];
            //list($tx2,$fx2)=get_table_column($v1);
	    //list($tx2,$fx2)=get_table_column($v1);
	    $fx2=$tx2=$tables;
	    //print_r($tx2);
           // $v1='a3.'.$v1;
           

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
                

          /*  if(!array_search($tx2,$alltables))
            {
                //new table found and add them
                $a1=$tx2[0];
                array_push($alltables, $a1);
                //print_r($alltables);
            }
	  */
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
 

            }  
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
            //echo '<br> prv1:'.$prv1;
        
            if(strstr($prv1,'OR') && strstr($prv1,'AND'))
            {
                //echo '<br> msg: OR AND available in :'.$prv1;
            }
            else 
            {
                //echo '<br> msg: OR AND not in :'.$prv1;
                
            }
                //$prv1.=$v1.'='.$v2;
            //$conditions.=$prv1;
            //$conditions.=$v1.'='.$v2;
            $prev=$curr;
            $ctr++;
            //echo '<br>flag:'.$flag;
            //if($flag>0)
              //  $prv1.=' )';

        }
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
                

            //echo '<br> flag:'.$flag .' '.$andflag.'  '.$v1.'='.$v2;
            if($flag==0 && $andflag==1)
            $prv1.=$vv1.'='.$v2;
            if($flag==0 && $andflag==0)
            $prv1.=$vv1.'='.$v2;
           // echo '<br> prv1:'.$prv1;
            
        if($flag>0)
                $prv1.=' )';
        $conditions.=$prv1;
    } 

 //echo '<br>condition : '.$conditions;

    $len=strlen($conditions);
    $alltables=array_unique($alltables);
    $ttc=count($alltables);
    $temp='';$ctr=0;$pr=''; $strvisit1='';$tab='';
  //echo '<br>s:'.$acnt;  
    foreach($alltables as $t)
    {   $ctr++;
        //echo "<br> t: $t , ctr: $ctr, ttc: $ttc , len: $len , acnt: $acnt <br>";
        $tab=$t;
/*        if($t=='respondent_centre_map')$strvisit1='AND a1.q_id=a2.q_id';
        if($t=='respondent_centre_map' && $ttc==2 && $ctr==2)$strvisit1='AND a1.q_id=a2.q_id';
        if($t=='respondent_centre_map' && $ttc==2 && $ctr==3)$strvisit1='AND a1.q_id=a3.q_id';
        if($t=='respondent_centre_map' && $ttc==3 && $ctr==2)$strvisit1='AND a1.q_id=a2.q_id';
        if($t=='respondent_centre_map' && $ttc==3 && $ctr==3)$strvisit1='AND a1.q_id=a3.q_id';
        if($t=='respondent_centre_map' && $ttc==4 && $ctr==2)$strvisit1='AND a1.q_id=a2.q_id';
        if($t=='respondent_centre_map' && $ttc==4 && $ctr==3)$strvisit1='AND a1.q_id=a3.q_id';
        if($t=='respondent_centre_map' && $ttc==4 && $ctr==4)$strvisit1='AND a1.q_id=a4.q_id';
        if($t=='respondent_centre_map' && $ttc==5 && $ctr==2)$strvisit1='AND a1.q_id=a2.q_id';
        if($t=='respondent_centre_map' && $ttc==5 && $ctr==3)$strvisit1='AND a1.q_id=a3.q_id';
        if($t=='respondent_centre_map' && $ttc==5 && $ctr==4)$strvisit1='AND a1.q_id=a4.q_id';
        if($t=='respondent_centre_map' && $ttc==5 && $ctr==5)$strvisit1='AND a1.q_id=a5.q_id';
*/        
        
            
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

        if($ttc==2 && $ctr==1)
        {
            $pr=$t.' as a1';
        }
        if($ttc==2 && $ctr==2 && $len>0 && $acnt<=1)
        { 
           if (strpos($conditions,'AND') !== false) {
           $temp.= $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1 .' JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id'  ;
           } else $temp.= $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1 .' JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id ';
   
        }
        if($ttc==2 && $ctr==2 && $len>0 && $acnt==2)
        {           
           $temp.= $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1 .' JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id JOIN '. $t .' as a5 ON a1.resp_id = a5.resp_id'  ;           
        }
        if($ttc==2 && $ctr==2 && $len>0 && $acnt==3)
        {           
           $temp.= $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1 .' JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id JOIN '. $t .' as a5 ON a1.resp_id = a5.resp_id JOIN '. $t .' as a6 ON a1.resp_id = a6.resp_id'  ;           
        }
        if($ttc==2 && $ctr==2 && $len>0 && $acnt==4)
        {           
           $temp.= $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1 .' JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id JOIN '. $t .' as a5 ON a1.resp_id = a5.resp_id JOIN '. $t .' as a6 ON a1.resp_id = a6.resp_id JOIN '. $t .' as a7 ON a1.resp_id = a7.resp_id'  ;          
        }
        if($ttc==2 && $ctr==2 && $len>0 && $acnt==5)
        {           
           $temp.= $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1 .' JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id JOIN '. $t .' as a5 ON a1.resp_id = a5.resp_id JOIN '. $t .' as a6 ON a1.resp_id = a6.resp_id JOIN '. $t .' as a7 ON a1.resp_id = a7.resp_id JOIN '. $t .' as a8 ON a1.resp_id = a8.resp_id'  ;          
        }
         if($ttc==2 && $ctr==2 && $len>0 && $acnt==6)
        {           
           $temp.= $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1 .' JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id JOIN '. $t .' as a5 ON a1.resp_id = a5.resp_id JOIN '. $t .' as a6 ON a1.resp_id = a6.resp_id JOIN '. $t .' as a7 ON a1.resp_id = a7.resp_id JOIN '. $t .' as a8 ON a1.resp_id = a8.resp_id JOIN '. $t .' as a9 ON a1.resp_id = a9.resp_id'  ;          
        }
        if($ttc==2 && $ctr==2 && $len>0 && $acnt==7)
        {           
           $temp.= $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1 .' JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id JOIN '. $t .' as a5 ON a1.resp_id = a5.resp_id JOIN '. $t .' as a6 ON a1.resp_id = a6.resp_id JOIN '. $t .' as a7 ON a1.resp_id = a7.resp_id JOIN '. $t .' as a8 ON a1.resp_id = a8.resp_id JOIN '. $t .' as a9 ON a1.resp_id = a9.resp_id JOIN '. $t .' as a10 ON a1.resp_id = a10.resp_id'  ;          
        }
        if($ttc==2 && $ctr==2 && $len>0 && $acnt==8)
        {           
           $temp.= $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1 .' JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id JOIN '. $t .' as a5 ON a1.resp_id = a5.resp_id JOIN '. $t .' as a6 ON a1.resp_id = a6.resp_id JOIN '. $t .' as a7 ON a1.resp_id = a7.resp_id JOIN '. $t .' as a8 ON a1.resp_id = a8.resp_id JOIN '. $t .' as a9 ON a1.resp_id = a9.resp_id JOIN '. $t .' as a10 ON a1.resp_id = a10.resp_id JOIN '. $t .' as a11 ON a1.resp_id = a11.resp_id'  ;          
        }
         if($ttc==2 && $ctr==2 && $len>0 && $acnt==9)
        {           
           $temp.= $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1 .' JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id JOIN '. $t .' as a5 ON a1.resp_id = a5.resp_id JOIN '. $t .' as a6 ON a1.resp_id = a6.resp_id JOIN '. $t .' as a7 ON a1.resp_id = a7.resp_id JOIN '. $t .' as a8 ON a1.resp_id = a8.resp_id JOIN '. $t .' as a9 ON a1.resp_id = a9.resp_id JOIN '. $t .' as a10 ON a1.resp_id = a10.resp_id JOIN '. $t .' as a11 ON a1.resp_id = a11.resp_id JOIN '. $t .' as a12 ON a1.resp_id = a12.resp_id'  ;          
        }
        if($ttc==2 && $ctr==2 && $len>0 && $acnt==10)
        {           
           $temp.= $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1 .' JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id JOIN '. $t .' as a5 ON a1.resp_id = a5.resp_id JOIN '. $t .' as a6 ON a1.resp_id = a6.resp_id JOIN '. $t .' as a7 ON a1.resp_id = a7.resp_id JOIN '. $t .' as a8 ON a1.resp_id = a8.resp_id JOIN '. $t .' as a9 ON a1.resp_id = a9.resp_id JOIN '. $t .' as a10 ON a1.resp_id = a10.resp_id JOIN '. $t .' as a11 ON a1.resp_id = a11.resp_id JOIN '. $t .' as a12 ON a1.resp_id = a12.resp_id JOIN '. $t .' as a13 ON a1.resp_id = a13.resp_id'  ;          
        }
        if($ttc==2 && $ctr==2 && $len>0 && $acnt==11)
        {           
           $temp.= $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1 .' JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id JOIN '. $t .' as a5 ON a1.resp_id = a5.resp_id JOIN '. $t .' as a6 ON a1.resp_id = a6.resp_id JOIN '. $t .' as a7 ON a1.resp_id = a7.resp_id JOIN '. $t .' as a8 ON a1.resp_id = a8.resp_id JOIN '. $t .' as a9 ON a1.resp_id = a9.resp_id JOIN '. $t .' as a10 ON a1.resp_id = a10.resp_id JOIN '. $t .' as a11 ON a1.resp_id = a11.resp_id JOIN '. $t .' as a12 ON a1.resp_id = a12.resp_id JOIN '. $t .' as a13 ON a1.resp_id = a13.resp_id JOIN '. $t .' as a13 ON a1.resp_id = a13.resp_id'  ;          
        }


        if($ttc==2 && $ctr==2 && $len<=0 )
        { 
            $temp.= $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1 ;
        }
        if($ttc==2 && $ctr==3)
        {
            $temp.=' JOIN '.$t.' as a3 ON a1.resp_id=a3.resp_id '.$strvisit1 .' JOIN '. $t .' as a3 ON a1.resp_id = a2.resp_id AND 

a1.q_id = a2.q_id AND a2.resp_id=a3.resp_id';
            
        }
        if($ttc==3 && $ctr==1)
        {
            $pr=$t.' as a1';
        }
        if($ttc==3 && $ctr==2)
        {
           $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1;
            
        }
        if($ttc==3 && $ctr==3)
        {
            $temp.=$pr.=' JOIN '.$t.' as a3 ON a1.resp_id=a3.resp_id '.$strvisit1;
            
        }
        if($ttc==4 && $ctr==1)
        {
            $pr=$t.' as a1';
        }
        if($ttc==4 && $ctr==2)
        {
           $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1;
        }
        if($ttc==4 && $ctr==3)
        {
            $pr.=' JOIN '.$t.' as a3 ON a1.resp_id=a3.resp_id '.$strvisit1;
        }
        if($ttc==4 && $ctr==4)
        {
            $temp.=$pr.=' JOIN '.$t.' as a4 ON a1.resp_id=a4.resp_id '.$strvisit1;    
        }
        if($ttc==5 && $ctr==1)
        {
            $pr=$t.' as a1';
        }
        if($ttc==5 && $ctr==2)
        {
           $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1;
        }
        if($ttc==5 && $ctr==3)
        {
            $pr.=' JOIN '.$t.' as a3 ON a1.resp_id=a3.resp_id '.$strvisit1;
        }
        if($ttc==5 && $ctr==4)
        {
            $pr.=' JOIN '.$t.' as a4 ON a1.resp_id=a4.resp_id '.$strvisit1;    
        }
        if($ttc==5 && $ctr==5)
        {
            $temp.=$pr.=' JOIN '.$t.' as a5 ON a1.resp_id=a5.resp_id '.$strvisit1;    
        }
        
        if($tab=='UMEED_20')
                $temp=$pr=$t.' as a1 JOIN '.$t.' as a2 ON a1.resp_id=a2.resp_id AND a1.visit_month_20=a2.visit_month_20';
         if($tab=='UMEED2_40')
                $temp=$pr=$t.' as a1 JOIN '.$t.' as a2 ON a1.resp_id=a2.resp_id AND a1.visit_month_40=a2.visit_month_40';
    }
    //echo '<br>: Tables : '.$tables=$temp;
   $tables=$temp;
    
   //code for multiple yfields iteration 
//print_r($stry);
 foreach($stry as $stryy)   
 {
	$yfields=$stryy;
   // list($ty,$fy)=get_table_column($stryy); $fy=array_unique($fy);
   // if(count($fy)==1){ $yfields=$fy[0];}else if(count($fy)>1) { $yfields=implode(",",$fy);}else {$yfields=$stryy;}

    //begin::make pivot count query, first search all table field from y-axis list   #################################
    $str='';
    if($m=='tot')
    {
            $pstrx="SELECT IFNULL(y1,'Total') as '$yfields'";
	    //$pstrx="SELECT IFNULL(y1,'Total') as '$stryy'";
            $pstrx2="SELECT IFNULL(get_term('$yfields',y1),'Total') as '$yfields'";
            $arrc=array();
            foreach($xtu as $yt)
            {
                //make pivot x list from each column of x
                foreach($fxu as $f)
                {
                  //echo '<br> tc: '.$yt.'='.$f;
                    //echo '<br>: ';
                    $rs=get_dictionary($f,$pid);
                  //print_r($rs);
                    if(count($rs))
                    {
                        foreach($rs as $r)
                        {
                        $pstrx.=", SUM(CASE x1 WHEN $r->value THEN tot ELSE 0 END) as '$r->keyy' ";
                        $pstrx2.=", SUM(CASE x1 WHEN $r->value THEN tot ELSE 0 END) as '$r->keyy' ";
                        //}
                        }
                    }  
                }
            }
            $str='';$stra='';$ss='';
            if($xfields=='s_resp_gen'){$stra="s_resp_gen !='' AND";}
            if($xfields=='child_age'){$stra="child_age !='' AND";}
            if($yfields=='s_resp_gen'){$stra="s_resp_gen !='' AND";}
            if($yfields=='child_age'){$stra="child_age !='' AND";} 
            if($yfields=='prod_cons_last_1_wk_1'){$stra="prod_cons_last_1_wk_1 !='' AND";}
            if($xfields=='prod_cons_last_1_wk_1'){$stra="prod_cons_last_1_wk_1 !='' AND";}
            if($yfields=='prod_aware_last_1_wk_1'){$stra="prod_aware_last_1_wk_1 !='' AND";}
            if($xfields=='prod_aware_last_1_wk_1'){$stra="prod_aware_last_1_wk_1 !='' AND";}
            if($xfields=='prod_pwd_opnn_dark_color'){$stra="prod_pwd_opnn_dark_color !='' AND";}    
            if($yfields=='prod_pwd_opnn_dark_color'){$stra="prod_pwd_opnn_dark_color !='' AND";}    
            
            
            if($xfields==$yfields){$ss="COUNT(distinct a1.resp_id)";}else $ss="SUM(if(a1.$xfields!='',1,0))"; 
            

            if($tab=="UMEED_20")
                  $stra=" MONTH(a1.visit_month_20)=$mn AND ";
            if($tab=="UMEED2_40")
                  $stra=" MONTH(a1.visit_month_40)=$mn AND year(a1.visit_month_40)=$yrs AND ";
            if($tab=="EMPIRE_50")
                  $stra=" MONTH(a1.i_date_50)=$mn AND year(a1.i_date_50)=$yrs AND ";

            if(strlen($conditions)>1){$str=" AND $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}else{$str="WHERE $stra  a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}
                      

            //if(strlen($conditions)>1){$str="AND a1.$xfields IS NOT NULL AND $yfields IS NOT NULL AND a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}else{$str="WHERE a1.$xfields IS NOT NULL AND $yfields IS NOT NULL AND a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid) ";}

            $pstrx.=", SUM(tot) as Total FROM ( SELECT
                a2. $yfields y1,
               a1. $xfields as x1,
                $ss as tot
                        FROM
                        $tables  $conditions  $str AND a2. $yfields!=''  GROUP BY a2. $yfields, a1. $xfields 
                )AS stats GROUP BY y1 desc WITH ROLLUP";
              $pstrx2.=" FROM ( SELECT
                a2. $yfields y1,
                a1. $xfields as x1,
                $ss as tot
                        FROM
                        $tables  $conditions  $str AND a2. $yfields!='' GROUP BY a2. $yfields, a1. $xfields 
                )AS stats GROUP BY y1 desc";

    }// end for pivot count query    ########################################
    
        //begin::make pivot % count query, first search all table field from y-axis list  =================================
     

    $tot_tv=0;
    if($m=='totp')
    {
            
            $str='';$stra='';$ss='';
            if($xfields=='s_resp_gen'){$stra="s_resp_gen !='' AND";}
            if($xfields=='child_age'){$stra="child_age !='' AND";}
            if($yfields=='s_resp_gen'){$stra="s_resp_gen !='' AND";}
            if($yfields=='child_age'){$stra="child_age !='' AND";}
            if($yfields=='prod_cons_last_1_wk_1'){$stra="prod_cons_last_1_wk_1 !='' AND";}
            if($xfields=='prod_cons_last_1_wk_1'){$stra="prod_cons_last_1_wk_1 !='' AND";}
            if($xfields=='prod_pwd_opnn_dark_color'){$stra="prod_pwd_opnn_dark_color !='' AND";}    
            if($yfields=='prod_pwd_opnn_dark_color'){$stra="prod_pwd_opnn_dark_color !='' AND";}    
            if($yfields=='prod_aware_last_1_wk_1'){$stra="prod_aware_last_1_wk_1 !='' AND";}
            if($xfields=='prod_aware_last_1_wk_1'){$stra="prod_aware_last_1_wk_1 !='' AND";}
            
            if($xfields==$yfields){$ss="COUNT(distinct a1.resp_id)";}else $ss="SUM(if(a1.$xfields!='',1,0))"; 
            if(strlen($conditions)>1){$str=" AND $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}else{$str="WHERE $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid) AND a2.$yfields!='' ";}
            
            
            $qtc="SELECT $ss as tot FROM $tables   $conditions $str";
            
            $contrs=DB::getInstance()->query($qtc);
            //echo '<br> cc:'.count($contrs);
            if($contrs->count()>0)
            {
            $tot_tv=$contrs->first()->tot;   
            }
            $pstrx="SELECT IFNULL(y1,'Total %') as $yfields ";
            $pstrx2="SELECT IFNULL(get_term('$yfields',y1),'Total %') as $yfields ";

            $arrc=array();
            foreach($xtu as $yt)
            {
                //make pivot x list from each column of x 
                foreach($fxu as $f)
                {  
                    $p=$f;
                    
                    $rs=get_dictionary($f,$pid);
                    if(count($rs))
                    {
                        foreach($rs as $r)
                        {

                        $pstrx.=",round( SUM(CASE x1 WHEN $r->value THEN tot ELSE 0 END)/$tot_tv *100 ,2) as '$r->keyy %' ";
                        $pstrx2.=",round( SUM(CASE x1 WHEN $r->value THEN tot ELSE 0 END)/$tot_tv *100 ,2) as '$r->keyy %' ";
                        }
                    }  

                }
            }

            $str='';$stra='';
            if($xfields=='s_resp_gen'){$stra="s_resp_gen !='' AND";}
            if($xfields=='child_age'){$stra="child_age !='' AND";}
            if($yfields=='s_resp_gen'){$stra="s_resp_gen !='' AND";}
            if($yfields=='child_age'){$stra="child_age !='' AND";}
            if($yfields=='prod_cons_last_1_wk_1'){$stra="prod_cons_last_1_wk_1 !='' AND";}
            if($xfields=='prod_cons_last_1_wk_1'){$stra="prod_cons_last_1_wk_1 !='' AND";}
            if($xfields=='prod_pwd_opnn_dark_color'){$stra="prod_pwd_opnn_dark_color !='' AND";}    
            if($yfields=='prod_pwd_opnn_dark_color'){$stra="prod_pwd_opnn_dark_color !='' AND";}    
            if($yfields=='prod_aware_last_1_wk_1'){$stra="prod_aware_last_1_wk_1 !='' AND";}
            if($xfields=='prod_aware_last_1_wk_1'){$stra="prod_aware_last_1_wk_1 !='' AND";}
            
            if(strlen($conditions)>1){$str=" AND  $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}else{$str="WHERE $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}
            //if(strlen($conditions)>1){$str=" AND a1.$xfields IS NOT NULL AND $yfields IS NOT NULL AND a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}else{$str="WHERE a1.$xfields IS NOT NULL AND $yfields IS NOT NULL AND a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}
           
                $pstrx.=", round( SUM(tot)/$tot_tv*100 ,2) as 'Total %' FROM ( SELECT
                a2.$yfields y1,
                a1.$xfields as x1,
                $ss as tot
                        FROM
                        $tables $conditions  $str AND a2.$yfields!='' GROUP BY a2.$yfields, a1.$xfields 
                )AS stats GROUP BY y1 desc WITH ROLLUP";

                $pstrx2.=" FROM ( SELECT
               a2. $yfields y1,
               a1. $xfields as x1,
                $ss as tot
                        FROM
                        $tables $conditions  $str AND a2.$yfields!='' GROUP BY a2.$yfields, a1.$xfields 
                )AS stats GROUP BY y1 desc";

       }// end for pivot count % query   ===============================================

             //begin::make pivot row % query, first search all table field from y-axis list  =================================
    if($m=='rowp')
    {
            $dv='';
            $dv=get_dictionary_value($yfields,1);
            $pstrx="SELECT IFNULL(y1,'Row Total %') as $yfields ";
            $pstrx2="SELECT IFNULL(get_term('$yfields',y1),'Total %') as $yfields ";

            $arrc=array();
            foreach($xtu as $yt)
            {
                //make pivot x list from each column of x 
                foreach($fxu as $f)
                {  
                    $p=$f;
                   
                    $rs=get_dictionary($f,$pid);
                   
                    if(count($rs))
                    {
                        foreach($rs as $r)
                        {

                        $pstrx.=",round( SUM(CASE x1 WHEN $r->value THEN tot ELSE 0 END)/sum(tot)*100 ,2) as '$r->keyy %' ";
                        $pstrx2.=",round( SUM(CASE x1 WHEN $r->value THEN tot ELSE 0 END)/sum(tot)*100 ,2) as '$r->keyy %' ";
                        }
                    }  

                }
            }
            
            $str='';$stra='';$ss='';
            if($xfields=='s_resp_gen'){$stra="s_resp_gen !='' AND";}
            if($xfields=='child_age'){$stra="child_age !='' AND";}
            if($yfields=='s_resp_gen'){$stra="s_resp_gen !='' AND";}
            if($yfields=='child_age'){$stra="child_age !=''  AND";}
            if($yfields=='prod_cons_last_1_wk_1'){$stra="prod_cons_last_1_wk_1 !='' AND";}
            if($xfields=='prod_cons_last_1_wk_1'){$stra="prod_cons_last_1_wk_1 !='' AND";}
            if($xfields=='prod_pwd_opnn_dark_color'){$stra="prod_pwd_opnn_dark_color !='' AND";}    
            if($yfields=='prod_pwd_opnn_dark_color'){$stra="prod_pwd_opnn_dark_color !='' AND";}    
            if($yfields=='prod_aware_last_1_wk_1'){$stra="prod_aware_last_1_wk_1 !='' AND";}
            if($xfields=='prod_aware_last_1_wk_1'){$stra="prod_aware_last_1_wk_1 !='' AND";}
            
            if($xfields==$yfields){$ss="COUNT(distinct resp_id)";}else $ss="SUM(if(a1.$xfields!='',1,0))"; 
            if(strlen($conditions)>1){$str=" AND $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}else{$str="WHERE $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}
            $pstrx.=",round( sum(tot)/sum(tot)*100 ,2) as Total  FROM ( SELECT
                a2.$yfields y1,
                a1.$xfields as x1,
                $ss as tot
                        FROM
                        $tables  $conditions $str AND a2.$yfields!=''  GROUP BY a2.$yfields, a1.$xfields 
                )AS stats GROUP BY y1 desc WITH ROLLUP";
                
                $pstrx2.=" FROM ( SELECT
                a2.$yfields y1,
                a1.$xfields as x1,
                $ss as tot
                        FROM
                        $tables  $conditions $str AND a2.$yfields!='' GROUP BY a2.$yfields, a1.$xfields 
                )AS stats GROUP BY y1 desc";

       }// end for pivot row % query   ===============================================

       
             //begin::make pivot row % query, first search all table field from y-axis list  =================================
    if($m=='colp')
    {
        //for table count
                    $pstrx11="SELECT IFNULL(y1,'Total') as '$yfields' ";
                    
            
            $arrc=array();
            foreach($xtu as $yt)
            {
                //make pivot x list from each column of x 
                foreach($fxu as $f)
                {  
                   // echo '<br> tc: '.$yt.'='.$f;
                    //echo '<br>: ';
                    $rs=get_dictionary($f,$pid);
                    //print_r($rs);
                    if(count($rs))
                    {
                        foreach($rs as $r)
                        {
                        $pstrx11.=", SUM(CASE x1 WHEN $r->value THEN tot ELSE 0 END) as '$r->keyy' ";
                        //}
                        }
                    }  

                }
            }
            $str='';$stra='';$ss='';
            if($xfields=='s_resp_gen'){$stra="s_resp_gen !='' AND";}
            if($xfields=='child_age'){$stra="child_age !='' AND";}
            if($yfields=='s_resp_gen'){$stra="s_resp_gen !='' AND";}
            if($yfields=='child_age'){$stra="child_age !='' AND";}
            if($yfields=='prod_cons_last_1_wk_1'){$stra="prod_cons_last_1_wk_1 !='' AND";}
            if($xfields=='prod_cons_last_1_wk_1'){$stra="prod_cons_last_1_wk_1 !='' AND";}
            if($xfields=='prod_pwd_opnn_dark_color'){$stra="prod_pwd_opnn_dark_color !='' AND";}    
            if($yfields=='prod_pwd_opnn_dark_color'){$stra="prod_pwd_opnn_dark_color !='' AND";}    
            if($yfields=='prod_aware_last_1_wk_1'){$stra="prod_aware_last_1_wk_1 !='' AND";}
            if($xfields=='prod_aware_last_1_wk_1'){$stra="prod_aware_last_1_wk_1 !='' AND";}
            
            if($xfields==$yfields){$ss="COUNT(distinct resp_id)";}else $ss="SUM(if(a1.$xfields!='',1,0))"; 
         
            if($tab=='UMEED_20')
                       $stra=" MONTH(a1.visit_month_20)=$mn AND ";
            if($tab=="UMEED2_40")
                  $stra=" MONTH(a1.visit_month_40)=$mn AND year(a1.visit_month_40)=$yrs AND ";
            if($tab=="EMPIRE_50")
                  $stra=" MONTH(a1.i_date_50)=$mn AND year(a1.i_date_50)=$yrs AND ";

            if(strlen($conditions)>1){$str=" AND $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}else{$str="WHERE $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}
            
            //if(strlen($conditions)>1){$str="AND a1.$xfields IS NOT NULL AND $yfields IS NOT NULL AND a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}else{$str="WHERE a1.$xfields IS NOT NULL AND $yfields IS NOT NULL AND a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid) ";}
            $pstrx11.=", SUM(tot) as Total FROM ( SELECT
                a2. $yfields y1,
                a1. $xfields as x1,
                $ss as tot
                        FROM
                        $tables  $conditions $str AND a2. $yfields!=''  GROUP BY a2. $yfields, a1. $xfields 
                )AS stats GROUP BY y1 desc WITH ROLLUP";

      //echo '<br> cc:'.$pstrx11;  
                  //to show the last Column Total value
                  $last=array();
                    $rr=DB::getInstance()->query($pstrx11);
                    if($rr)
                    foreach($rr->results() as $r)
                    {
                        $last=$r;
                    }
                   //print_r($last);
                    //echo $last->Boy;
                    
                        
        //end of table total
        //for column % process
                    $ro=0;$rtot=0;
            $pstrx="SELECT IFNULL(y1,'Total') as $yfields ";
            $pstrx2="SELECT IFNULL(get_term('$yfields',y1),'Total') as $yfields ";
            
            $arrc=array();
            foreach($xtu as $yt)
            {
                //make pivot x list from each column of x 
                foreach($fxu as $f)
                {  
                    $p=$f;
                   
                    $rs=get_dictionary($f,$pid);
                   
                    if(count($rs))
                    {
                        foreach($rs as $r)
                        {
                            $temp='';
                            $temp=$r->keyy;
                            if(!empty($last))
                            {    
                            $ro=$last->$temp;
                            if($ro==0) $ro=1;
                            $rtot=$last->Total;
                                  
                            }
                        $pstrx.=",round( SUM(CASE x1 WHEN $r->value THEN tot ELSE 0 END)/$ro *100 ,2) as '$r->keyy %' ";
                        $pstrx2.=",round( SUM(CASE x1 WHEN $r->value THEN tot ELSE 0 END)/$ro *100 ,2) as '$r->keyy %' ";
                        }
                    }  

                }
            }

            
            $str='';$stra='';
            if($xfields=='s_resp_gen'){$stra="s_resp_gen !='' AND";}
            if($xfields=='child_age'){$stra="child_age !='' AND";}
            if($yfields=='s_resp_gen'){$stra="s_resp_gen !='' AND";}
            if($yfields=='child_age'){$stra="child_age !='' AND";}
            if($yfields=='prod_cons_last_1_wk_1'){$stra="prod_cons_last_1_wk_1 !='' AND";}
            if($xfields=='prod_cons_last_1_wk_1'){$stra="prod_cons_last_1_wk_1 !='' AND";}
            if($xfields=='prod_pwd_opnn_dark_color'){$stra="prod_pwd_opnn_dark_color !='' AND";}    
            if($yfields=='prod_pwd_opnn_dark_color'){$stra="prod_pwd_opnn_dark_color !='' AND";}    
            if($yfields=='prod_aware_last_1_wk_1'){$stra="prod_aware_last_1_wk_1 !='' AND";}
            if($xfields=='prod_aware_last_1_wk_1'){$stra="prod_aware_last_1_wk_1 !='' AND";}

            if($tab=="UMEED_20")
                  $stra=" MONTH(a1.visit_month_20)=$mn AND ";
                 if($tab=="UMEED2_40")
                  $stra=" MONTH(a1.visit_month_40)=$mn AND year(a1.visit_month_40)=$yrs AND ";
                 if($tab=="EMPIRE_50")
                  $stra=" MONTH(a1.i_date_50)=$mn AND year(a1.i_date_50)=$yrs AND ";
                 

            if($xfields==$yfields){$ss="COUNT(distinct a1.resp_id)";}else $ss="SUM(if(a1.$xfields!='',1,0))"; 
            if(strlen($conditions)>1){$str=" AND $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}else{$str="WHERE $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}
            $pstrx.=",round( sum(tot)/$rtot*100 ,2) as 'Column %'  FROM ( SELECT
               a2. $yfields y1,
               a1. $xfields as x1,
                $ss as tot
                        FROM
                        $tables  $conditions $str  AND a2.$yfields!='' GROUP BY a2.$yfields, a1.$xfields 
                )AS stats GROUP BY y1 desc WITH ROLLUP";
              $pstrx2.="  FROM ( SELECT
               a2. $yfields y1,
               a1. $xfields as x1,
                $ss as tot
                        FROM
                        $tables  $conditions $str AND a2.$yfields!=''  GROUP BY a2.$yfields, a1.$xfields 
                )AS stats GROUP BY y1 desc";
       }// end for pivot column % query   ===============================================

 echo "<br> $yfields </br>";   
 //echo '<br>pstrx : '.$pstrx;
     $_SESSION['query']=$pstrx;
     $_SESSION['yfields']=$yfields;
     $_SESSION['xfields']=$xfields;
     $_SESSION['query2']=$pstrx2;
      
         //===========================begin
     

//echo $pstrx;
    try {  $columns=array();
     $conn = new PDO("mysql:host=database-1.c1mggasso0hp.ap-south-1.rds.amazonaws.com;dbname=vcims", 'qcsrdsadmin', 'Pa7du#ah$098');
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     //$conn->query("SET wait_timeout=180;");
     $stmt = $conn->prepare($pstrx); 
     
     $stmt->execute();

     // set the resulting array to associative
     $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
     $head='';
     //to display column heading
     echo "<table border=1 cellpadding=0 cellspacing=0>";
    
     for ($i = 0; $i < $stmt->columnCount(); $i++) {
    $col = $stmt->getColumnMeta($i);
    $columns[] = $col['name'];
    }
     //print_r($columns);
     $strth="<tr bgcolor=lightgray>";
     if(count($columns))
     foreach($columns as $t)
     {  
         if($t==$yfields)
         {
             $tm=get_dictionary_title_only($yfields);
             
             $strth.="<th> $tm</th>";$head.=$tm;
         }   
         else
         {$strth.="<th>$t</th>";$head.=$t;}
     }
     echo $strth.='</tr>';
     $qst=new RecursiveArrayIterator($stmt->fetchAll());
     //display y-axis term as their value
     $ctr=0;
      //$line='';
     foreach($qst as $ar)
     {
         $tt=$ar[$yfields];
         
         if(is_numeric($tt))
         {
         	$qst[$ctr][$yfields]=get_dictionary_value($yfields,$tt);
         }
         
         $ctr++;
     } 
     //echo $qst[0][$yfields];
     //print_r($aa);
     //var_dump($qst);
     foreach(new TableRows($qst) as $k=>$v) { 
          echo $v;  
     }
    }
    catch(PDOException $e) {
         echo "Error: " . $e->getMessage();
    }
    $conn = null;
    echo "</table>";
         //==============================end
 
}} }

//to display tabular report
//print_r($_POST);

if(isset($_POST['show1']))
{
    
   $pstrx=$_SESSION['query'];
   $yfields=$_SESSION['yfields'];

    echo "</center><br><form method=post action=''> Action: <select name=rv id=rv ><option value=0>---Select---</option><option value=2>Graphical View</option>     </select> <input type=submit value=Go name=go></form> <br>";
echo "<br><form method=post action=''> <input type=submit value='Export To Excel' name=export></form> <br>";
    //echo 'r:'.$pstrx.'<br>';
    $filename = "VCIMS_Report_" . date('YmdHms') . ".xls";


    class TableRows extends RecursiveIteratorIterator 
    { 
     function __construct($it) { 
         parent::__construct($it, self::LEAVES_ONLY); 
     }

     function current() {
         return "<td style='width: 150px; border: 1px solid black;'>" . parent::current(). "</td>";
     }

     function beginChildren() { 
         echo "<tr>"; 
     } 

     function endChildren() { 
         echo "</tr>" . "\n";
     } 
    } 

//echo $pstrx;
    try {
     $conn = new PDO("mysql:host=database-1.c1mggasso0hp.ap-south-1.rds.amazonaws.com;dbname=vcims", 'qcsrdsadmin', 'Pa7du#ah$098');
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     //$conn->query("SET wait_timeout=180;");
     $stmt = $conn->prepare($pstrx); 
     
     $stmt->execute();

     // set the resulting array to associative
     $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
     $head='';
     //to display column heading
     echo "<table border=1 cellpadding=0 cellspacing=0>";
     
     for ($i = 0; $i < $stmt->columnCount(); $i++) {
    $col = $stmt->getColumnMeta($i);
    $columns[] = $col['name'];
    }
    //print_r($columns);
     $strth="<tr bgcolor=lightgray>";
     if(count($columns))
     foreach($columns as $t)
     {  
         if($t==$yfields)
         {
             $tm=get_dictionary_title_only($yfields);
             
             $strth.="<th> $tm</th>";$head.=$tm;
         }   
         else
         {$strth.="<th>$t</th>";$head.=$t;}
     }
     echo $strth.='</tr>';
     $qst=new RecursiveArrayIterator($stmt->fetchAll());
     //display y-axis term as their value
     $ctr=0;
      //$line='';
     foreach($qst as $ar)
     {
         $tt=$ar[$yfields];
         
         if(is_numeric($tt))
         {
         	$qst[$ctr][$yfields]=get_dictionary_value($yfields,$tt);
         }
         
         $ctr++;
     } 
     //echo $qst[0][$yfields];
     //print_r($aa);
     //var_dump($qst);
     foreach(new TableRows($qst) as $k=>$v) { 
          echo $v;  
     }
    }
    catch(PDOException $e) {
         echo "Error: " . $e->getMessage();
    }
    $conn = null;
    echo "</table>";
}

if(isset($_POST['go']) && $_POST['rv']==1)
{ 
   $pstrx=$_SESSION['query'];
   $yfields=$_SESSION['yfields'];

    echo "</center><br><form method=post action=''> Action: <select name=rv id=rv><option value=0>---Select---</option><option value=2>Graphical View</option></select> <input type=submit value=Go name=go></form> <br>";

echo "</center><br><form method=post action=''> <input type=submit value='Export To Excel' name=export></form> <br>";

    //echo 'r:'.$pstrx.'<br>';
    $filename = "VCIMS_Report_" . date('YmdHms') . ".xls";


    class TableRows extends RecursiveIteratorIterator 
    { 
     function __construct($it) { 
         parent::__construct($it, self::LEAVES_ONLY); 
     }

     function current() {
         return "<td style='width: 150px; border: 1px solid black;'>" . parent::current(). "</td>";
     }

     function beginChildren() { 
         echo "<tr>"; 
     } 

     function endChildren() { 
         echo "</tr>" . "\n";
     } 
    } 

//echo $pstrx;
    try {
     $conn = new PDO("mysql:host=database-1.c1mggasso0hp.ap-south-1.rds.amazonaws.com;dbname=vcims", 'qcsrdsadmin', 'Pa7du#ah$098');
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     //$conn->query("SET wait_timeout=120;");
     $stmt = $conn->prepare($pstrx); 
     
     $stmt->execute();

     // set the resulting array to associative
     $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
     $head='';
     //to display column heading
     echo "<table border=1 cellpadding=0 cellspacing=0>";
     
     for ($i = 0; $i < $stmt->columnCount(); $i++) {
    $col = $stmt->getColumnMeta($i);
    $columns[] = $col['name'];
    }
    //print_r($columns);
     $strth="<tr bgcolor=lightgray>";
     if(count($columns))
     foreach($columns as $t)
     {  
         if($t==$yfields)
         {
             $tm=get_dictionary_title_only($yfields);
             
             $strth.="<th> $tm</th>";$head.=$tm;
         }   
         else
         {$strth.="<th>$t</th>";$head.=$t;}
     }
     echo $strth.='</tr>';
     $qst=new RecursiveArrayIterator($stmt->fetchAll());
     //display y-axis term as their value
     $ctr=0;
      //$line='';
     foreach($qst as $ar)
     {
         $tt=$ar[$yfields];
         
         if(is_numeric($tt))
         {
         	$qst[$ctr][$yfields]=get_dictionary_value($yfields,$tt);
         }
         
         $ctr++;
     } 
     //echo $qst[0][$yfields];
     //print_r($aa);
     //var_dump($qst);
     foreach(new TableRows($qst) as $k=>$v) { 
          echo $v;  
     }
    }
    catch(PDOException $e) {
         echo "Error: " . $e->getMessage();
    }
    $conn = null;
    echo "</table>";

}

//to download the tangular report
if(isset($_POST['export']))
{ 
   $pstrx=$_SESSION['query'];
   $yfields=$_SESSION['yfields'];

   //echo "</center><br><form method=post action=''> Action: <select name=rv id=rv><option value=0>---Select---</option><option value=1>Tabullar View</option><option value=2>Graphical View</option></select> <input type=submit value=Go name=go></form> <br>";
   
$filename = "Crosstab_Report_" . date('YmdHms') . ".xls";


header('Content-type: application/octet-stream');

header("Content-Disposition: attachment; filename=$filename");

header("Pragma: no-cache");
header("Expires: 0");

    class TableRows extends RecursiveIteratorIterator 
    { 
     function __construct($it) { 
         parent::__construct($it, self::LEAVES_ONLY); 
     }

     function current() {
         return "<td style='width: 150px; border: 1px solid black;'>" . parent::current(). "</td>";
     }

     function beginChildren() { 
         echo "<tr>"; 
     } 

     function endChildren() { 
         echo "</tr>" . "\n";
     } 
    } 

//echo $pstrx;
    try {
     $conn = new PDO("mysql:host=database-1.c1mggasso0hp.ap-south-1.rds.amazonaws.com;dbname=vcims", 'qcsrdsadmin', 'Pa7du#ah$098');
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     //$conn->query("SET wait_timeout=120;");
     $stmt = $conn->prepare($pstrx); 
     
     $stmt->execute();

     // set the resulting array to associative
     $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
     $head='';
     //to display column heading
     echo "<table border=1 cellpadding=0 cellspacing=0>";
     
     for ($i = 0; $i < $stmt->columnCount(); $i++) {
    $col = $stmt->getColumnMeta($i);
    $columns[] = $col['name'];
    }
    //print_r($columns);
     $strth="<tr bgcolor=lightgray>";
     if(count($columns))
     foreach($columns as $t)
     {  
         if($t==$yfields)
         {
             $tm=get_dictionary_title_only($yfields);
             
             $strth.="<th> $tm</th>";$head.=$tm;
         }   
         else
         {$strth.="<th>$t</th>";$head.=$t;}
     }
     echo $strth.='</tr>';
     $qst=new RecursiveArrayIterator($stmt->fetchAll());
     //display y-axis term as their value
     $ctr=0;
      //$line='';
     foreach($qst as $ar)
     {
         $tt=$ar[$yfields];
         
         if(is_numeric($tt))
         {
         	$qst[$ctr][$yfields]=get_dictionary_value($yfields,$tt);
         }
         
         $ctr++;
     } 
     foreach(new TableRows($qst) as $k=>$v) { 
          echo $v;  
     }
    }
    catch(PDOException $e) {
         echo "Error: " . $e->getMessage();
    }
    $conn = null;
    echo "</table>";

}


//to display graph report
if(isset($_POST['go']) && $_POST['rv']==2)
{
   
    $pstrx=$_SESSION['query2'];

 
    $yfields=$_SESSION['yfields'];
    
echo "</center><br><form method=post action=''> Action: <select name=rv id=rv><option value=2>Graphical View</option><option value=1>Tabullar View</option></select> Chart Type: <select name=ct id=ct><option value='none'>--Select Chart--</option><option value='ColumnChart'>Column Chart</option><option value='PieChart'>Pie Chart</option><option value='BarChart'>Bar Chart</option><option value='LineChart'>Line Chart</option><option value='AreaChart'>Area Chart</option></select> <input type=submit value=Go name=go></form> <br>";

$filename = "VCIMS_Report_" . date('YmdHms') . ".xlsx";

            ?>
    
            
    
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script type="text/javascript">
                    // Load the Visualization API and the piechart package.
        google.load('visualization', '1', {'packages':['corechart']});
        //google.load('visualization', '1', {packages: ['corechart', 'line']});
        // Set a callback to run when the Google Visualization API is loaded.
        google.setOnLoadCallback(drawChart);

        function drawChart() { 
          //var jsonData = $.ajax({ url: "chart_data.php", dataType:"json", async: false }).responseText; 
        var yaxis=<?php echo json_encode(get_dictionary_title_only($_SESSION['yfields']));?>; 
        var xaxis=<?php echo json_encode(get_dictionary_title_only($_SESSION['xfields']));?>; 
          
        var un=<?php echo json_encode($_SESSION['unit']);?>;
        var unit;
        if(un=='tot')
          unit='Total [count]';
        if(un=='totp')
          unit='Table %';
        if(un=='rowp')
          unit='Row %';
        if(un=='colp')
          unit='Column %';

        var vv=<?php 
        
        $mysqli = new mysqli("database-1.c1mggasso0hp.ap-south-1.rds.amazonaws.com", "qcsrdsadmin", "Pa7du#ah$098","vcims");
        //$mysqli = new mysqli("localhost", "user1", "vcims@user1", "Digiadmin_rfid");
        
     //$result = $mysqli->query($pstrx);
        
    if (mysqli_multi_query($mysqli, $pstrx)) 
   {
    do { $result=mysqli_multi_query($mysqli, $pstrx);
       
        $results_array = Array(Array());
    $fillKeys = true;
    if ($result = mysqli_store_result($mysqli)) 
    { 
     while ($row = $result->fetch_assoc()) 
     {
        $temp = Array();
        foreach ($row as $key => $val)
        {
            if ($fillKeys) {
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
   
    $jsontable = json_encode($results_array, JSON_NUMERIC_CHECK);
    //echo $jsontable;
        echo json_encode($jsontable);?> ; 
               //alert(vv.valueOf());
        
          // Create our data table out of JSON data loaded from server.
          //var data = new google.visualization.arrayToDataTable(JSON.parse(jsonData));
          var data = new google.visualization.arrayToDataTable(JSON.parse(vv));
          
          var options = {
          title: xaxis+' / '+ yaxis + ' Report',
          pieSliceText: 'value',
         
           vAxis: {
          title: unit 
          },
           hAxis: {
          title: yaxis+' Values'
          },
         axes: {
            hAxis: {
              0: { side: 'top', label: 'Percentage'} // Top x-axis.
            }
          },
          //curveType: 'function',
          legend: { position: 'right' }
        };
              // Instantiate and draw our chart, passing in some options.
          //alert(<?php echo json_encode($_POST['ct']);?>);
          var charttype=<?php echo json_encode($_POST['ct']);?>;
         //var charttype="ColumnChart";
          //alert(charttype.valueOf()); 
          
          ;
          if(charttype=="ColumnChart")
          var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
          if(charttype=="PieChart")
          var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
          if(charttype=="LineChart")
          var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
          if(charttype=="BarChart")
          var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
          if(charttype=="AreaChart")
          var chart = new google.visualization.AreaChart(document.getElementById('chart_div')); 
          
             google.visualization.events.addListener(chart, 'ready', function () {
        chart_div.innerHTML = '<img src="' + chart.getImageURI() + '">';
        console.log(chart_div.innerHTML);  });

//data.addColumn({type: 'string', role: 'annotation'});
var view = new google.visualization.DataView(data);
//view.setColumns([0,1,{calc: "stringify", sourceColumn: 1, type: "string" , role: "annotation"  },2]);
//view.setColumns([0,1,{calc: "stringify", sourceColumn: 2, type: "string" , role: "annotation" },2]);

          chart.draw(data,options, {width: 800, height: 600,is3D: true });

       //document.getElementById('png').outerHTML = '<a href="' + chart.getImageURI() + '">Printable version</a>';

       document.getElementById('png').outerHTML = '<a href="' + chart.getImageURI() + '" download>Download Chart</a>';

        }
        </script>  

        <div id='png'></div>
           <center> <div id="chart_div" style="width: 800px; height: 400px;"></div></center>
   


</body>

</html>
<?php





}  

 ?>

<?php
//to show all reports 

if(isset($_POST['exportall']))
{
  

   if(!Session::exists('suser'))
  {
	//Redirect::to('login_fp.php');
       die('You are logout. Please close this page and relogin again');
  }
   if($_POST['project']!=0)
   { 

$faa='';

$pid = $_POST['project'];
$ppn=DB::getInstance()->query("SELECT `name` FROM `project` WHERE `project_id`=$pid");
$pname=$ppn->first()->name;

$filename = "crosstab_".$pname."_" . date('YmdHms') . ".xls";

header('Content-type: application/octet-stream');
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Expires: 0");

    $pid = $_POST['project'];
    $m = $_POST['measure'];
echo "Project: $pname <br>";

$dq1=DB::getInstance()->query("SELECT * FROM `project_term_map` WHERE `project_id`=$pid ;");
if($dq1->count()>0)
foreach($dq1->results() as $qd)
{     
    $xtables='';$ytables='';$tables='';$xfields='';$yfields='';$fields='';$conditions='';
    
    $tx=array();$f=array();$c=array();$ty=array();$fx=array();$fy=array();$alltables=array();
    
   if($_POST['xv']!='')
     $xaa=$_POST['xv'];
   else
     $xaa='centre';

    //$yaa=$_POST['yv'];
    $faa=$_POST['fv'];
   
    $_SESSION['unit']=$m;
    $yaa = $qd->term;

   if($yaa=='centre') continue;
   //echo $yaa;
    //get as string value as within single '' from a string list separated by , of x-axis or y-axis
    $strx= implode("','",explode(",",$xaa));
    $stry= implode("','",explode(",",$yaa));

	//$strx= explode(",",$xaa);
	//$stry= explode(",",$yaa);
	$strx = array($xaa);
	$stry = array($yaa);

	$fx=$strx;
	$fy=$stry;
	$xfields=$fx[0];
	$yfields=$yaa;
    if(!empty($tx) && is_array($tx)){
		$xtu=array_unique($tx); 
    }
    if(!empty($ty) && is_array($ty)){
	$ytu=array_unique($ty);
    }
    if(!empty($fx) && is_array($fx)){
	$fxu=array_unique($fx); 
    }
    else
    {
	$xfields=implode(",",$fx);
    }

    if($faa){
	$x=explode(",",$faa);
    	$c=array_unique($x);
    }

	$tables=get_project_table($pid);
	$xtu = $alltables = array($tables);
	$ttc=count($alltables);

    //start::for filter conditions with AND , OR and get output as $conditions
   $ctr=0;$prev='';$curr='';$v1='';$v2='';$prv1='';$flag=0;$andflag=0;
	$acnt=0;
     //echo '<br>len : '.strlen($faa);
    if(strlen($faa)>2)
    {
        //print_r($faa);
        $x=explode(",",$faa);
        $c=array_unique($x);
        $tx2=array();$fx2=array();
 
        foreach($c as $ff)
        {    
            $crr1='';
            //echo '<br>$ff : '.$ff;
            $curr=substr($ff, 0, 8); //get 1st 5 char from filters array
            $arr=explode("=",$ff);
            $v1=$arr[0]; 
            $v2=$arr[1];
            //list($tx2,$fx2)=get_table_column($v1);
		$fx2=$tx2=$tables;
           // $v1='a3.'.$v1;

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
 

            }  
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
            //echo '<br> prv1:'.$prv1;
        /*
            if(strstr($prv1,'OR') && strstr($prv1,'AND'))
            {
                //echo '<br> msg: OR AND available in :'.$prv1;
            }
            else 
            {
                //echo '<br> msg: OR AND not in :'.$prv1;
                
            }
       */
            $prev=$curr;
            $ctr++;
        }
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
                

            //echo '<br> flag:'.$flag .' '.$andflag.'  '.$v1.'='.$v2;
            if($flag==0 && $andflag==1)
            $prv1.=$vv1.'='.$v2;
            if($flag==0 && $andflag==0)
            $prv1.=$vv1.'='.$v2;
           // echo '<br> prv1:'.$prv1;
            
        if($flag>0)
                $prv1.=' )';
        $conditions.=$prv1;
    } 
   //echo '<br>condition : '.$conditions;
   $len=strlen($conditions);
    $alltables=array_unique($alltables);
    $ttc=count($alltables);
    $temp='';$ctr=0;$pr=''; $strvisit1='';
  //echo '<br>s:'.$acnt;  
    foreach($alltables as $t)
    {   $ctr++;
        //echo '<br> t:'.$t;
        if($t=='respondent_centre_map')$strvisit1='AND a1.q_id=a2.q_id';
        if($t=='respondent_centre_map' && $ttc==2 && $ctr==2)$strvisit1='AND a1.q_id=a2.q_id';
        if($t=='respondent_centre_map' && $ttc==2 && $ctr==3)$strvisit1='AND a1.q_id=a3.q_id';
        if($t=='respondent_centre_map' && $ttc==3 && $ctr==2)$strvisit1='AND a1.q_id=a2.q_id';
        if($t=='respondent_centre_map' && $ttc==3 && $ctr==3)$strvisit1='AND a1.q_id=a3.q_id';
        if($t=='respondent_centre_map' && $ttc==4 && $ctr==2)$strvisit1='AND a1.q_id=a2.q_id';
        if($t=='respondent_centre_map' && $ttc==4 && $ctr==3)$strvisit1='AND a1.q_id=a3.q_id';
        if($t=='respondent_centre_map' && $ttc==4 && $ctr==4)$strvisit1='AND a1.q_id=a4.q_id';
        if($t=='respondent_centre_map' && $ttc==5 && $ctr==2)$strvisit1='AND a1.q_id=a2.q_id';
        if($t=='respondent_centre_map' && $ttc==5 && $ctr==3)$strvisit1='AND a1.q_id=a3.q_id';
        if($t=='respondent_centre_map' && $ttc==5 && $ctr==4)$strvisit1='AND a1.q_id=a4.q_id';
        if($t=='respondent_centre_map' && $ttc==5 && $ctr==5)$strvisit1='AND a1.q_id=a5.q_id';
        
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

        if($ttc==2 && $ctr==1)
        {
            $pr=$t.' as a1';
        }
        if($ttc==2 && $ctr==2 && $len>0 && $acnt<=1)
        { 
           if (strpos($conditions,'AND') !== false) {
           $temp.= $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1 .' JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id'  ;
           } else $temp.= $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1 .' JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id ';
   
        }
        if($ttc==2 && $ctr==2 && $len>0 && $acnt==2)
        {           
           $temp.= $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1 .' JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id JOIN '. $t .' as a5 ON a1.resp_id = a5.resp_id'  ;           
        }
        if($ttc==2 && $ctr==2 && $len>0 && $acnt==3)
        {           
           $temp.= $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1 .' JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id JOIN '. $t .' as a5 ON a1.resp_id = a5.resp_id JOIN '. $t .' as a6 ON a1.resp_id = a6.resp_id'  ;           
        }
        if($ttc==2 && $ctr==2 && $len>0 && $acnt==4)
        {           
           $temp.= $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1 .' JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id JOIN '. $t .' as a5 ON a1.resp_id = a5.resp_id JOIN '. $t .' as a6 ON a1.resp_id = a6.resp_id JOIN '. $t .' as a7 ON a1.resp_id = a7.resp_id'  ;          
        }
        if($ttc==2 && $ctr==2 && $len>0 && $acnt==5)
        {           
           $temp.= $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1 .' JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id JOIN '. $t .' as a5 ON a1.resp_id = a5.resp_id JOIN '. $t .' as a6 ON a1.resp_id = a6.resp_id JOIN '. $t .' as a7 ON a1.resp_id = a7.resp_id JOIN '. $t .' as a8 ON a1.resp_id = a8.resp_id'  ;          
        }
         if($ttc==2 && $ctr==2 && $len>0 && $acnt==6)
        {           
           $temp.= $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1 .' JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id JOIN '. $t .' as a5 ON a1.resp_id = a5.resp_id JOIN '. $t .' as a6 ON a1.resp_id = a6.resp_id JOIN '. $t .' as a7 ON a1.resp_id = a7.resp_id JOIN '. $t .' as a8 ON a1.resp_id = a8.resp_id JOIN '. $t .' as a9 ON a1.resp_id = a9.resp_id'  ;          
        }
        if($ttc==2 && $ctr==2 && $len>0 && $acnt==7)
        {           
           $temp.= $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1 .' JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id JOIN '. $t .' as a5 ON a1.resp_id = a5.resp_id JOIN '. $t .' as a6 ON a1.resp_id = a6.resp_id JOIN '. $t .' as a7 ON a1.resp_id = a7.resp_id JOIN '. $t .' as a8 ON a1.resp_id = a8.resp_id JOIN '. $t .' as a9 ON a1.resp_id = a9.resp_id JOIN '. $t .' as a10 ON a1.resp_id = a10.resp_id'  ;          
        }
        if($ttc==2 && $ctr==2 && $len>0 && $acnt==8)
        {           
           $temp.= $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1 .' JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id JOIN '. $t .' as a5 ON a1.resp_id = a5.resp_id JOIN '. $t .' as a6 ON a1.resp_id = a6.resp_id JOIN '. $t .' as a7 ON a1.resp_id = a7.resp_id JOIN '. $t .' as a8 ON a1.resp_id = a8.resp_id JOIN '. $t .' as a9 ON a1.resp_id = a9.resp_id JOIN '. $t .' as a10 ON a1.resp_id = a10.resp_id JOIN '. $t .' as a11 ON a1.resp_id = a11.resp_id'  ;          
        }
         if($ttc==2 && $ctr==2 && $len>0 && $acnt==9)
        {           
           $temp.= $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1 .' JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id JOIN '. $t .' as a5 ON a1.resp_id = a5.resp_id JOIN '. $t .' as a6 ON a1.resp_id = a6.resp_id JOIN '. $t .' as a7 ON a1.resp_id = a7.resp_id JOIN '. $t .' as a8 ON a1.resp_id = a8.resp_id JOIN '. $t .' as a9 ON a1.resp_id = a9.resp_id JOIN '. $t .' as a10 ON a1.resp_id = a10.resp_id JOIN '. $t .' as a11 ON a1.resp_id = a11.resp_id JOIN '. $t .' as a12 ON a1.resp_id = a12.resp_id'  ;          
        }
        if($ttc==2 && $ctr==2 && $len>0 && $acnt==10)
        {           
           $temp.= $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1 .' JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id JOIN '. $t .' as a5 ON a1.resp_id = a5.resp_id JOIN '. $t .' as a6 ON a1.resp_id = a6.resp_id JOIN '. $t .' as a7 ON a1.resp_id = a7.resp_id JOIN '. $t .' as a8 ON a1.resp_id = a8.resp_id JOIN '. $t .' as a9 ON a1.resp_id = a9.resp_id JOIN '. $t .' as a10 ON a1.resp_id = a10.resp_id JOIN '. $t .' as a11 ON a1.resp_id = a11.resp_id JOIN '. $t .' as a12 ON a1.resp_id = a12.resp_id JOIN '. $t .' as a13 ON a1.resp_id = a13.resp_id'  ;          
        }
        if($ttc==2 && $ctr==2 && $len>0 && $acnt==11)
        {           
           $temp.= $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1 .' JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id JOIN '. $t .' as a5 ON a1.resp_id = a5.resp_id JOIN '. $t .' as a6 ON a1.resp_id = a6.resp_id JOIN '. $t .' as a7 ON a1.resp_id = a7.resp_id JOIN '. $t .' as a8 ON a1.resp_id = a8.resp_id JOIN '. $t .' as a9 ON a1.resp_id = a9.resp_id JOIN '. $t .' as a10 ON a1.resp_id = a10.resp_id JOIN '. $t .' as a11 ON a1.resp_id = a11.resp_id JOIN '. $t .' as a12 ON a1.resp_id = a12.resp_id JOIN '. $t .' as a13 ON a1.resp_id = a13.resp_id JOIN '. $t .' as a13 ON a1.resp_id = a13.resp_id'  ;          
        }


        if($ttc==2 && $ctr==2 && $len<=0 )
        { 
            $temp.= $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1 ;
        }
        if($ttc==2 && $ctr==3)
        {
            $temp.=' JOIN '.$t.' as a3 ON a1.resp_id=a3.resp_id '.$strvisit1 .' JOIN '. $t .' as a3 ON a1.resp_id = a2.resp_id AND 

a1.q_id = a2.q_id AND a2.resp_id=a3.resp_id';
            
        }
        if($ttc==3 && $ctr==1)
        {
            $pr=$t.' as a1';
        }
        if($ttc==3 && $ctr==2)
        {
           $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1;
            
        }
        if($ttc==3 && $ctr==3)
        {
            $temp.=$pr.=' JOIN '.$t.' as a3 ON a1.resp_id=a3.resp_id '.$strvisit1;
            
        }
        if($ttc==4 && $ctr==1)
        {
            $pr=$t.' as a1';
        }
        if($ttc==4 && $ctr==2)
        {
           $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1;
        }
        if($ttc==4 && $ctr==3)
        {
            $pr.=' JOIN '.$t.' as a3 ON a1.resp_id=a3.resp_id '.$strvisit1;
        }
        if($ttc==4 && $ctr==4)
        {
            $temp.=$pr.=' JOIN '.$t.' as a4 ON a1.resp_id=a4.resp_id '.$strvisit1;    
        }
        if($ttc==5 && $ctr==1)
        {
            $pr=$t.' as a1';
        }
        if($ttc==5 && $ctr==2)
        {
           $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1;
        }
        if($ttc==5 && $ctr==3)
        {
            $pr.=' JOIN '.$t.' as a3 ON a1.resp_id=a3.resp_id '.$strvisit1;
        }
        if($ttc==5 && $ctr==4)
        {
            $pr.=' JOIN '.$t.' as a4 ON a1.resp_id=a4.resp_id '.$strvisit1;    
        }
        if($ttc==5 && $ctr==5)
        {
            $temp.=$pr.=' JOIN '.$t.' as a5 ON a1.resp_id=a5.resp_id '.$strvisit1;    
        }
        
        
    }
    //echo '<br>: Tables : '.$tables=$temp;
    $tables=$temp;
    

   
    //begin::make pivot count query, first search all table field from y-axis list   #################################
    $str='';
	//$yfields=$stry;
    if($m=='tot')
    {		$yfields=$yaa;
            $pstrx="SELECT IFNULL(y1,'Total') as '$yfields'";
            $pstrx2="SELECT IFNULL(get_term('$yfields',y1),'Total') as '$yfields'";
            $arrc=array();
		//foreach($xtu as $yt)
            foreach($xtu as $yt)
            {
                //make pivot x list from each column of x 
                foreach($fxu as $f)
                {  
                   // echo '<br> tc: '.$yt.'='.$f;
                    //echo '<br>: ';
                    $rs=get_dictionary($f,$pid);
                    //print_r($rs);
                    if(count($rs))
                    {
                        foreach($rs as $r)
                        {
                        $pstrx.=", SUM(CASE x1 WHEN $r->value THEN tot ELSE 0 END) as '$r->keyy' ";
                        $pstrx2.=", SUM(CASE x1 WHEN $r->value THEN tot ELSE 0 END) as '$r->keyy' ";
                        //}
                        }
                    }  
                }
            }
            $str='';$stra='';$ss='';
                        
            
            if($xfields==$yfields){$ss="COUNT(distinct a1.resp_id)";}else $ss="SUM(if(a1.$xfields!='',1,0))"; 
            
            if(strlen($conditions)>1){$str=" AND $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}else{$str="WHERE $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}
            
            //if(strlen($conditions)>1){$str="AND a1.$xfields IS NOT NULL AND $yfields IS NOT NULL AND a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}else{$str="WHERE a1.$xfields IS NOT NULL AND $yfields IS NOT NULL AND a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid) ";}
            $pstrx.=", SUM(tot) as Total FROM ( SELECT
                a2. $yfields y1,
               a1. $xfields as x1,
                $ss as tot
                        FROM
                        $tables  $conditions  $str AND a2. $yfields!=''  GROUP BY a2. $yfields, a1. $xfields 
                )AS stats GROUP BY y1 desc WITH ROLLUP";
              $pstrx2.=" FROM ( SELECT
                a2. $yfields y1,
                a1. $xfields as x1,
                $ss as tot
                        FROM
                        $tables  $conditions  $str AND a2. $yfields!=''  GROUP BY a2. $yfields, a1. $xfields 
                )AS stats GROUP BY y1 desc";

    }// end for pivot count query    ########################################
    
        //begin::make pivot % count query, first search all table field from y-axis list  =================================
    $tot_tv=0;
    if($m=='totp')
    {
            
            $str='';$stra='';$ss='';
            
            if($xfields==$yfields){$ss="COUNT(distinct a1.resp_id)";}else $ss="SUM(if(a1.$xfields!='',1,0))"; 
            if(strlen($conditions)>1){$str=" AND $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}else{$str="WHERE $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid) AND a2.$yfields!='' ";}
            
            
            $qtc="SELECT $ss as tot FROM $tables   $conditions $str";
            
            $contrs=DB::getInstance()->query($qtc);
            //echo '<br> cc:'.count($contrs);
            if($contrs->count()>0)
            {
            $tot_tv=$contrs->first()->tot;   
            }
            $pstrx="SELECT IFNULL(y1,'Total %') as $yfields ";
            $pstrx2="SELECT IFNULL(get_term('$yfields',y1),'Total %') as $yfields ";

            $arrc=array();
            foreach($xtu as $yt)
            {
                //make pivot x list from each column of x 
                foreach($fxu as $f)
                {  
                    $p=$f;
                    
                    $rs=get_dictionary($f,$pid);
                    if(count($rs))
                    {
                        foreach($rs as $r)
                        {

                        $pstrx.=",round( SUM(CASE x1 WHEN $r->value THEN tot ELSE 0 END)/$tot_tv *100 ,2) as '$r->keyy %' ";
                        $pstrx2.=",round( SUM(CASE x1 WHEN $r->value THEN tot ELSE 0 END)/$tot_tv *100 ,2) as '$r->keyy %' ";
                        }
                    }  

                }
            }

            $str='';$stra='';
          
            if(strlen($conditions)>1){$str=" AND  $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}else{$str="WHERE $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}
            //if(strlen($conditions)>1){$str=" AND a1.$xfields IS NOT NULL AND $yfields IS NOT NULL AND a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}else{$str="WHERE a1.$xfields IS NOT NULL AND $yfields IS NOT NULL AND a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}
           
                $pstrx.=", round( SUM(tot)/$tot_tv*100 ,2) as 'Total %' FROM ( SELECT
                a2.$yfields y1,
                a1.$xfields as x1,
                $ss as tot
                        FROM
                        $tables $conditions  $str AND a2.$yfields!='' GROUP BY a2.$yfields, a1.$xfields 
                )AS stats GROUP BY y1 desc WITH ROLLUP";

                $pstrx2.=" FROM ( SELECT
               a2. $yfields y1,
               a1. $xfields as x1,
                $ss as tot
                        FROM
                        $tables $conditions  $str AND a2.$yfields!='' GROUP BY a2.$yfields, a1.$xfields 
                )AS stats GROUP BY y1 desc";

       }// end for pivot count % query   ===============================================

             //begin::make pivot row % query, first search all table field from y-axis list  =================================
    if($m=='rowp')
    {
            $dv='';
            $dv=get_dictionary_value($yfields,1);
            $pstrx="SELECT IFNULL(y1,'Row Total %') as $yfields ";
            $pstrx2="SELECT IFNULL(get_term('$yfields',y1),'Total %') as $yfields ";

            $arrc=array();
            foreach($xtu as $yt)
            {
                //make pivot x list from each column of x 
                foreach($fxu as $f)
                {  
                    $p=$f;
                   
                    $rs=get_dictionary($f,$pid);
                   
                    if(count($rs))
                    {
                        foreach($rs as $r)
                        {

                        $pstrx.=",round( SUM(CASE x1 WHEN $r->value THEN tot ELSE 0 END)/sum(tot)*100 ,2) as '$r->keyy %' ";
                        $pstrx2.=",round( SUM(CASE x1 WHEN $r->value THEN tot ELSE 0 END)/sum(tot)*100 ,2) as '$r->keyy %' ";
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
                        $tables  $conditions $str AND a2.$yfields!=''  GROUP BY a2.$yfields, a1.$xfields 
                )AS stats GROUP BY y1 desc WITH ROLLUP";
                
                $pstrx2.=" FROM ( SELECT
                a2.$yfields y1,
                a1.$xfields as x1,
                $ss as tot
                        FROM
                        $tables  $conditions $str AND a2.$yfields!='' GROUP BY a2.$yfields, a1.$xfields 
                )AS stats GROUP BY y1 desc";

       }// end for pivot row % query   ===============================================

       
             //begin::make pivot row % query, first search all table field from y-axis list  =================================
    if($m=='colp')
    {
        //for table count
                    $pstrx11="SELECT IFNULL(y1,'Total') as '$yfields' ";
                    
            
            $arrc=array();
            foreach($xtu as $yt)
            {
                //make pivot x list from each column of x 
                foreach($fxu as $f)
                {  
                   // echo '<br> tc: '.$yt.'='.$f;
                    //echo '<br>: ';
                    $rs=get_dictionary($f,$pid);
                    //print_r($rs);
                    if(count($rs))
                    {
                        foreach($rs as $r)
                        {
                        $pstrx11.=", SUM(CASE x1 WHEN $r->value THEN tot ELSE 0 END) as '$r->keyy' ";
                        //}
                        }
                    }  

                }
            }
            $str='';$stra='';$ss='';
       
            if($xfields==$yfields){$ss="COUNT(distinct resp_id)";}else $ss="SUM(if(a1.$xfields!='',1,0))"; 
            if(strlen($conditions)>1){$str=" AND $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}else{$str="WHERE $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}
            
            //if(strlen($conditions)>1){$str="AND a1.$xfields IS NOT NULL AND $yfields IS NOT NULL AND a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}else{$str="WHERE a1.$xfields IS NOT NULL AND $yfields IS NOT NULL AND a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid) ";}
            $pstrx11.=", SUM(tot) as Total FROM ( SELECT
                a2. $yfields y1,
                a1. $xfields as x1,
                $ss as tot
                        FROM
                        $tables  $conditions $str AND a2. $yfields!=''  GROUP BY a2. $yfields, a1. $xfields 
                )AS stats GROUP BY y1 desc WITH ROLLUP";

      //echo '<br> cc:'.$pstrx11;  
                  //to show the last Column Total value
                  $last=array();
                    $rr=DB::getInstance()->query($pstrx11);
                    if($rr)
                    foreach($rr->results() as $r)
                    {
                        $last=$r;
                    }
                   //print_r($last);
                    //echo $last->Boy;
                    
                        
        //end of table total
        //for column % process
                    $ro=0;$rtot=0;
            $pstrx="SELECT IFNULL(y1,'Total') as $yfields ";
            $pstrx2="SELECT IFNULL(get_term('$yfields',y1),'Total') as $yfields ";
            
            $arrc=array();
            foreach($xtu as $yt)
            {
                //make pivot x list from each column of x 
                foreach($fxu as $f)
                {  
                    $p=$f;
                   
                    $rs=get_dictionary($f,$pid);
                   
                    if(count($rs))
                    {
                        foreach($rs as $r)
                        {
                            $temp='';
                            $temp=$r->keyy;
                            if(!empty($last))
                            {    
                            $ro=$last->$temp;
                            if($ro==0) $ro=1;
                            $rtot=$last->Total;
                                  
                            }
                        $pstrx.=",round( SUM(CASE x1 WHEN $r->value THEN tot ELSE 0 END)/$ro *100 ,2) as '$r->keyy %' ";
                        $pstrx2.=",round( SUM(CASE x1 WHEN $r->value THEN tot ELSE 0 END)/$ro *100 ,2) as '$r->keyy %' ";
                        }
                    }  

                }
            }

            
            $str='';$stra='';
            
            if($xfields==$yfields){$ss="COUNT(distinct a1.resp_id)";}else $ss="SUM(if(a1.$xfields!='',1,0))"; 
            if(strlen($conditions)>1){$str=" AND $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}else{$str="WHERE $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}
            $pstrx.=",round( sum(tot)/$rtot*100 ,2) as 'Column %'  FROM ( SELECT
               a2. $yfields y1,
               a1. $xfields as x1,
                $ss as tot
                        FROM
                        $tables  $conditions $str  AND a2.$yfields!='' GROUP BY a2.$yfields, a1.$xfields 
                )AS stats GROUP BY y1 desc WITH ROLLUP";
              $pstrx2.="  FROM ( SELECT
               a2. $yfields y1,
               a1. $xfields as x1,
                $ss as tot
                        FROM
                        $tables  $conditions $str AND a2.$yfields!=''  GROUP BY a2.$yfields, a1.$xfields 
                )AS stats GROUP BY y1 desc";
       }// end for pivot column % query   ===============================================
 
    //   echo '<br>pstrx : '.$pstrx;
    // $_SESSION['query']=$pstrx;
    // $_SESSION['yfields']=$yfields;
    // $_SESSION['xfields']=$xfields;
    // $_SESSION['query2']=$pstrx2;



	$columns = array(); $col='';$strth='';
echo "<br><br> $yaa ";
	//echo $pstrx;

    try {
     $conn = new PDO("mysql:host=database-1.c1mggasso0hp.ap-south-1.rds.amazonaws.com;dbname=vcims", 'qcsrdsadmin', 'Pa7du#ah$098');
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     //$conn->query("SET wait_timeout=120;");
     $stmt = $conn->prepare($pstrx); 
     
     $stmt->execute();

     // set the resulting array to associative
     $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
     $head='';
     //to display column heading
     echo "<table border=1 cellpadding=0 cellspacing=0>";
     
     for ($i = 0; $i < $stmt->columnCount(); $i++) {
    $col = $stmt->getColumnMeta($i);
    $columns[] = $col['name'];
    }
    //print_r($columns);
     $strth="<tr bgcolor=lightgray>";
     if(count($columns))
     foreach($columns as $t)
     {  
         if($t==$yfields)
         {
             $tm=get_dictionary_title_only($yfields);
             
             $strth.="<th> $tm</th>";$head.=$tm;
         }   
         else
         {$strth.="<th>$t</th>";$head.=$t;}
     }
     echo $strth.='</tr>';
     $qst=new RecursiveArrayIterator($stmt->fetchAll());
     //display y-axis term as their value
     $ctr=0;
      //$line='';
     foreach($qst as $ar)
     {
         $tt=$ar[$yfields];
         
         if(is_numeric($tt))
         {
         	$qst[$ctr][$yfields]=get_dictionary_value($yfields,$tt);
         }
         
         $ctr++;
     } 
     
     foreach(new TableRows($qst) as $k=>$v) { 
          echo $v;  
     }
    }
    catch(PDOException $e) {
         echo "Error: " . $e->getMessage();
    }
    $conn = null;
    echo "</table>";
  }
}
}


if(isset($_POST['showall']))
{

   if(!Session::exists('suser'))
  {
	//Redirect::to('login_fp.php');
       die('You are logout. Please close this page and relogin again');
  }
   if($_POST['project']!=0)
   { 
	$faa='';

    $pid=$_POST['project'];
    $m=$_POST['measure'];

$dq1=DB::getInstance()->query("SELECT * FROM `project_term_map` WHERE `project_id`=$pid ;");
if($dq1->count()>0)
foreach($dq1->results() as $qd)
{     
    $xtables='';$ytables='';$tables='';$xfields='';$yfiled='';$fields='';$conditions='';
    
    $tx=array();$f=array();$c=array();$ty=array();$fx=array();$fy=array();$alltables=array();
    
 
    $xaa=$_POST['xv'];
    //$yaa=$_POST['yv'];
    $faa=$_POST['fv'];
   
    $_SESSION['unit']=$m;
   //$xaa='centr_id';
    $yaa=$qd->term;
   
    if($yaa=='centre') continue;
      //echo $yaa;
    
    if($_POST['xv']=='')
         $xaa='centre';
   

    
    //get as string value as within single '' from a string list separated by , of x-axis or y-axis
    $strx= implode("','",explode(",",$xaa));
    $stry= implode("','",explode(",",$yaa));

	$strx= explode(",",$xaa);
	$stry= explode(",",$yaa);
//echo "<br>Hi";
//print_r($strx);
//print_r($stry);

$fx=$strx;
$fy=$stry;
$xfields=$fx[0];
$yfields=$yaa;

    //get the table name and column name as two array like $tx and $fx of X/Y axis
    //list($tx,$fx)=get_table_column($strx);
    //list($ty,$fy)=get_table_column($stry); $fy=array_unique($fy);

    if(!empty($tx) && is_array($tx)){$xtu=array_unique($tx); $xtables=implode(",",array_unique($tx));if(strlen($tables)>0){$tables.=', ';$tables.=$xtables; }else{$tables=$xtables;}}
    if(!empty($ty) && is_array($ty)){
	$ytu=array_unique($ty); 
	//$ytables=implode(",",array_unique($ty));
	if(strlen($tables)>0){
		$tables.=', ';$tables.=$ytables; 
	}else{$tables=$ytables;}
    }
    if(!empty($fx) && is_array($fx)){
	$fxu=array_unique($fx); 
	//$xfields=implode(",",array_unique($fx));
}else { $xfields=implode(",",$fx);}
    //echo '<br>xf: '.$xfields;
    //if(count($fy)==1){ $yfields=$fy[0];}else if(count($fy)>1) { $yfields=implode(",",$fy);}else {$yfields=$stry;}
 

   
    $x=explode(",",$faa);
    $c=array_unique($x);
    
    //echo '<br>fy : '.count($fy);
    //if((!empty($tx)) && (!empty($ty))){ $tables=implode(",",array_unique(array_merge($tx,$ty)));}else echo 'select x and Y axis';
    
    //echo '<br>Tables : '.$tables;
    /*if(count($tx)!=0 && count($ty)!=0) $alltables=array_unique(array_merge($tx,$ty)); 
            else if(count($tx)!=0 && count($ty)==0)$alltables=$tx;
            else if(count($ty)!=0 && count($tx)==0)$alltables=$ty;
    */ 
    //echo '<br>Join Tables : '.$tables;
$tables=get_project_table($pid);
$xtu = $alltables = array($tables);
$ttc=count($alltables);
    
    //start::for filter conditions with AND , OR and get output as $conditions
   $ctr=0;$prev='';$curr='';$v1='';$v2='';$prv1='';$flag=0;$andflag=0;$tab='';
     //echo '<br>len : '.strlen($faa);
    if(strlen($faa)>2)
    {
        //print_r($faa);
        $x=explode(",",$faa);
        $c=array_unique($x);
        $tx2=array();$fx2=array();
        
        foreach($c as $ff)
        {    
            $crr1='';
            //echo '<br>$ff : '.$ff;
            $curr=substr($ff, 0, 8); //get 1st 5 char from filters array
            $arr=explode("=",$ff);
            $v1=$arr[0]; 
            $v2=$arr[1];
            //list($tx2,$fx2)=get_table_column($v1);
	    $fx2=$tx2=$tables;
           // $v1='a3.'.$v1;
           

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
                

           /* if(!array_search($tx2,$alltables))
            {
                //new table found and add them
                $a1=$tx2[0];
                array_push($alltables, $a1);
                //print_r($alltables);
            }
	   */
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
 

            }  
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
            //echo '<br> prv1:'.$prv1;
        
            if(strstr($prv1,'OR') && strstr($prv1,'AND'))
            {
                //echo '<br> msg: OR AND available in :'.$prv1;
            }
            else 
            {
                //echo '<br> msg: OR AND not in :'.$prv1;
                
            }
                //$prv1.=$v1.'='.$v2;
            //$conditions.=$prv1;
            //$conditions.=$v1.'='.$v2;
            $prev=$curr;
            $ctr++;
            //echo '<br>flag:'.$flag;
            //if($flag>0)
              //  $prv1.=' )';

        }
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
                

            //echo '<br> flag:'.$flag .' '.$andflag.'  '.$v1.'='.$v2;
            if($flag==0 && $andflag==1)
            $prv1.=$vv1.'='.$v2;
            if($flag==0 && $andflag==0)
            $prv1.=$vv1.'='.$v2;
           // echo '<br> prv1:'.$prv1;
            
        if($flag>0)
                $prv1.=' )';
        $conditions.=$prv1;
    } 
   //echo '<br>condition : '.$conditions;
   $len=strlen($conditions);
    $alltables=array_unique($alltables);
    $ttc=count($alltables);
    $temp='';$ctr=0;$pr=''; $strvisit1='';
  //echo '<br>s:'.$acnt;  
    $acnt=substr_count($prv1, 'AND'); 
    
    foreach($alltables as $t)
    {   $ctr++;
        //echo '<br> t:'.$t;
          $tab=$t;
        if($t=='respondent_centre_map')$strvisit1='AND a1.q_id=a2.q_id';
        if($t=='respondent_centre_map' && $ttc==2 && $ctr==2)$strvisit1='AND a1.q_id=a2.q_id';
        if($t=='respondent_centre_map' && $ttc==2 && $ctr==3)$strvisit1='AND a1.q_id=a3.q_id';
        if($t=='respondent_centre_map' && $ttc==3 && $ctr==2)$strvisit1='AND a1.q_id=a2.q_id';
        if($t=='respondent_centre_map' && $ttc==3 && $ctr==3)$strvisit1='AND a1.q_id=a3.q_id';
        if($t=='respondent_centre_map' && $ttc==4 && $ctr==2)$strvisit1='AND a1.q_id=a2.q_id';
        if($t=='respondent_centre_map' && $ttc==4 && $ctr==3)$strvisit1='AND a1.q_id=a3.q_id';
        if($t=='respondent_centre_map' && $ttc==4 && $ctr==4)$strvisit1='AND a1.q_id=a4.q_id';
        if($t=='respondent_centre_map' && $ttc==5 && $ctr==2)$strvisit1='AND a1.q_id=a2.q_id';
        if($t=='respondent_centre_map' && $ttc==5 && $ctr==3)$strvisit1='AND a1.q_id=a3.q_id';
        if($t=='respondent_centre_map' && $ttc==5 && $ctr==4)$strvisit1='AND a1.q_id=a4.q_id';
        if($t=='respondent_centre_map' && $ttc==5 && $ctr==5)$strvisit1='AND a1.q_id=a5.q_id';
        
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

        if($ttc==2 && $ctr==1)
        {
            $pr=$t.' as a1';
        }
        if($ttc==2 && $ctr==2 && $len>0 && $acnt<=1)
        { 
           if (strpos($conditions,'AND') !== false) {
           $temp.= $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1 .' JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id'  ;
           } else $temp.= $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1 .' JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id ';
   
        }
        if($ttc==2 && $ctr==2 && $len>0 && $acnt==2)
        {           
           $temp.= $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1 .' JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id JOIN '. $t .' as a5 ON a1.resp_id = a5.resp_id'  ;           
        }
        if($ttc==2 && $ctr==2 && $len>0 && $acnt==3)
        {           
           $temp.= $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1 .' JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id JOIN '. $t .' as a5 ON a1.resp_id = a5.resp_id JOIN '. $t .' as a6 ON a1.resp_id = a6.resp_id'  ;           
        }
        if($ttc==2 && $ctr==2 && $len>0 && $acnt==4)
        {           
           $temp.= $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1 .' JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id JOIN '. $t .' as a5 ON a1.resp_id = a5.resp_id JOIN '. $t .' as a6 ON a1.resp_id = a6.resp_id JOIN '. $t .' as a7 ON a1.resp_id = a7.resp_id'  ;          
        }
        if($ttc==2 && $ctr==2 && $len>0 && $acnt==5)
        {           
           $temp.= $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1 .' JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id JOIN '. $t .' as a5 ON a1.resp_id = a5.resp_id JOIN '. $t .' as a6 ON a1.resp_id = a6.resp_id JOIN '. $t .' as a7 ON a1.resp_id = a7.resp_id JOIN '. $t .' as a8 ON a1.resp_id = a8.resp_id'  ;          
        }
         if($ttc==2 && $ctr==2 && $len>0 && $acnt==6)
        {           
           $temp.= $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1 .' JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id JOIN '. $t .' as a5 ON a1.resp_id = a5.resp_id JOIN '. $t .' as a6 ON a1.resp_id = a6.resp_id JOIN '. $t .' as a7 ON a1.resp_id = a7.resp_id JOIN '. $t .' as a8 ON a1.resp_id = a8.resp_id JOIN '. $t .' as a9 ON a1.resp_id = a9.resp_id'  ;          
        }
        if($ttc==2 && $ctr==2 && $len>0 && $acnt==7)
        {           
           $temp.= $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1 .' JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id JOIN '. $t .' as a5 ON a1.resp_id = a5.resp_id JOIN '. $t .' as a6 ON a1.resp_id = a6.resp_id JOIN '. $t .' as a7 ON a1.resp_id = a7.resp_id JOIN '. $t .' as a8 ON a1.resp_id = a8.resp_id JOIN '. $t .' as a9 ON a1.resp_id = a9.resp_id JOIN '. $t .' as a10 ON a1.resp_id = a10.resp_id'  ;          
        }
        if($ttc==2 && $ctr==2 && $len>0 && $acnt==8)
        {           
           $temp.= $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1 .' JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id JOIN '. $t .' as a5 ON a1.resp_id = a5.resp_id JOIN '. $t .' as a6 ON a1.resp_id = a6.resp_id JOIN '. $t .' as a7 ON a1.resp_id = a7.resp_id JOIN '. $t .' as a8 ON a1.resp_id = a8.resp_id JOIN '. $t .' as a9 ON a1.resp_id = a9.resp_id JOIN '. $t .' as a10 ON a1.resp_id = a10.resp_id JOIN '. $t .' as a11 ON a1.resp_id = a11.resp_id'  ;          
        }
         if($ttc==2 && $ctr==2 && $len>0 && $acnt==9)
        {           
           $temp.= $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1 .' JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id JOIN '. $t .' as a5 ON a1.resp_id = a5.resp_id JOIN '. $t .' as a6 ON a1.resp_id = a6.resp_id JOIN '. $t .' as a7 ON a1.resp_id = a7.resp_id JOIN '. $t .' as a8 ON a1.resp_id = a8.resp_id JOIN '. $t .' as a9 ON a1.resp_id = a9.resp_id JOIN '. $t .' as a10 ON a1.resp_id = a10.resp_id JOIN '. $t .' as a11 ON a1.resp_id = a11.resp_id JOIN '. $t .' as a12 ON a1.resp_id = a12.resp_id'  ;          
        }
        if($ttc==2 && $ctr==2 && $len>0 && $acnt==10)
        {           
           $temp.= $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1 .' JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id JOIN '. $t .' as a5 ON a1.resp_id = a5.resp_id JOIN '. $t .' as a6 ON a1.resp_id = a6.resp_id JOIN '. $t .' as a7 ON a1.resp_id = a7.resp_id JOIN '. $t .' as a8 ON a1.resp_id = a8.resp_id JOIN '. $t .' as a9 ON a1.resp_id = a9.resp_id JOIN '. $t .' as a10 ON a1.resp_id = a10.resp_id JOIN '. $t .' as a11 ON a1.resp_id = a11.resp_id JOIN '. $t .' as a12 ON a1.resp_id = a12.resp_id JOIN '. $t .' as a13 ON a1.resp_id = a13.resp_id'  ;          
        }
        if($ttc==2 && $ctr==2 && $len>0 && $acnt==11)
        {           
           $temp.= $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1 .' JOIN '. $t .' as a3 ON a1.resp_id = a3.resp_id JOIN '. $t .' as a4 ON a1.resp_id = a4.resp_id JOIN '. $t .' as a5 ON a1.resp_id = a5.resp_id JOIN '. $t .' as a6 ON a1.resp_id = a6.resp_id JOIN '. $t .' as a7 ON a1.resp_id = a7.resp_id JOIN '. $t .' as a8 ON a1.resp_id = a8.resp_id JOIN '. $t .' as a9 ON a1.resp_id = a9.resp_id JOIN '. $t .' as a10 ON a1.resp_id = a10.resp_id JOIN '. $t .' as a11 ON a1.resp_id = a11.resp_id JOIN '. $t .' as a12 ON a1.resp_id = a12.resp_id JOIN '. $t .' as a13 ON a1.resp_id = a13.resp_id JOIN '. $t .' as a13 ON a1.resp_id = a13.resp_id'  ;          
        }


        if($ttc==2 && $ctr==2 && $len<=0 )
        { 
            $temp.= $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1 ;
        }
        if($ttc==2 && $ctr==3)
        {
            $temp.=' JOIN '.$t.' as a3 ON a1.resp_id=a3.resp_id '.$strvisit1 .' JOIN '. $t .' as a3 ON a1.resp_id = a2.resp_id AND 

a1.q_id = a2.q_id AND a2.resp_id=a3.resp_id';
            
        }
        if($ttc==3 && $ctr==1)
        {
            $pr=$t.' as a1';
        }
        if($ttc==3 && $ctr==2)
        {
           $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1;
            
        }
        if($ttc==3 && $ctr==3)
        {
            $temp.=$pr.=' JOIN '.$t.' as a3 ON a1.resp_id=a3.resp_id '.$strvisit1;
            
        }
        if($ttc==4 && $ctr==1)
        {
            $pr=$t.' as a1';
        }
        if($ttc==4 && $ctr==2)
        {
           $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1;
        }
        if($ttc==4 && $ctr==3)
        {
            $pr.=' JOIN '.$t.' as a3 ON a1.resp_id=a3.resp_id '.$strvisit1;
        }
        if($ttc==4 && $ctr==4)
        {
            $temp.=$pr.=' JOIN '.$t.' as a4 ON a1.resp_id=a4.resp_id '.$strvisit1;    
        }
        if($ttc==5 && $ctr==1)
        {
            $pr=$t.' as a1';
        }
        if($ttc==5 && $ctr==2)
        {
           $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1;
        }
        if($ttc==5 && $ctr==3)
        {
            $pr.=' JOIN '.$t.' as a3 ON a1.resp_id=a3.resp_id '.$strvisit1;
        }
        if($ttc==5 && $ctr==4)
        {
            $pr.=' JOIN '.$t.' as a4 ON a1.resp_id=a4.resp_id '.$strvisit1;    
        }
        if($ttc==5 && $ctr==5)
        {
            $temp.=$pr.=' JOIN '.$t.' as a5 ON a1.resp_id=a5.resp_id '.$strvisit1;    
        }
        
        if($tab =='UMEED_20')
             $temp=$pr=$t.' as a1 JOIN '.$t.' as a2 ON a1.resp_id=a2.resp_id AND a1.visit_month_20=a2.visit_month_20';
        
        if($tab =='UMEED2_40')
             $temp=$pr=$t.' as a1 JOIN '.$t.' as a2 ON a1.resp_id=a2.resp_id AND a1.visit_month_40=a2.visit_month_40';
        
    }
    //echo '<br>: Tables : '.$tables=$temp;
    $tables=$temp;
    
   
    //begin::make pivot count query, first search all table field from y-axis list   #################################
    $str='';
    if($m=='tot')
    {
            $pstrx="SELECT IFNULL(y1,'Total') as '$yfields'";
            $pstrx2="SELECT IFNULL(get_term('$yfields',y1),'Total') as '$yfields'";
            $arrc=array();
            foreach($xtu as $yt)
            {
                //make pivot x list from each column of x 
                foreach($fxu as $f)
                {  
                   // echo '<br> tc: '.$yt.'='.$f;
                    //echo '<br>: ';
                    $rs=get_dictionary($f,$pid);
                    //print_r($rs);
                    if(count($rs))
                    {
                        foreach($rs as $r)
                        {
                        $pstrx.=", SUM(CASE x1 WHEN $r->value THEN tot ELSE 0 END) as '$r->keyy' ";
                        $pstrx2.=", SUM(CASE x1 WHEN $r->value THEN tot ELSE 0 END) as '$r->keyy' ";
                        //}
                        }
                    }  
                }
            }
            $str='';$stra='';$ss='';
       
            if($tab =='UMEED_20') $stra=" MONTH(a1.visit_month_20)=$mn AND ";
             if($tab=="UMEED2_40")
                  $stra=" MONTH(a1.visit_month_40)=$mn AND year(a1.visit_month_40)=$yrs AND ";
            if($tab=="EMPIRE_50")
                  $stra=" MONTH(a1.i_date_50)=$mn AND year(a1.i_date_50)=$yrs AND ";

            if($xfields==$yfields){$ss="COUNT(distinct a1.resp_id)";}else $ss="SUM(if(a1.$xfields!='',1,0))"; 
            
            if(strlen($conditions)>1){$str=" AND $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}else{$str="WHERE $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}
            
            //if(strlen($conditions)>1){$str="AND a1.$xfields IS NOT NULL AND $yfields IS NOT NULL AND a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}else{$str="WHERE a1.$xfields IS NOT NULL AND $yfields IS NOT NULL AND a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid) ";}
            $pstrx.=", SUM(tot) as Total FROM ( SELECT
                a2. $yfields y1,
               a1. $xfields as x1,
                $ss as tot
                        FROM
                        $tables  $conditions  $str AND a2. $yfields!=''  GROUP BY a2. $yfields, a1. $xfields 
                )AS stats GROUP BY y1 desc WITH ROLLUP";
              $pstrx2.=" FROM ( SELECT
                a2. $yfields y1,
                a1. $xfields as x1,
                $ss as tot
                        FROM
                        $tables  $conditions  $str AND a2. $yfields!='' GROUP BY a2. $yfields, a1. $xfields 
                )AS stats GROUP BY y1 desc";

    }// end for pivot count query    ########################################
    
        //begin::make pivot % count query, first search all table field from y-axis list  =================================
    $tot_tv=0;
    if($m=='totp')
    {
            
            $str='';$stra='';$ss='';
           
            
            if($xfields==$yfields){$ss="COUNT(distinct a1.resp_id)";}else $ss="SUM(if(a1.$xfields!='',1,0))"; 
            if(strlen($conditions)>1){$str=" AND $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}else{$str="WHERE $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid) AND a2.$yfields!='' ";}
            
            
            $qtc="SELECT $ss as tot FROM $tables   $conditions $str";
            
            $contrs=DB::getInstance()->query($qtc);
            //echo '<br> cc:'.count($contrs);
            if($contrs->count()>0)
            {
            $tot_tv=$contrs->first()->tot;   
            }
            $pstrx="SELECT IFNULL(y1,'Total %') as $yfields ";
            $pstrx2="SELECT IFNULL(get_term('$yfields',y1),'Total %') as $yfields ";

            $arrc=array();
            foreach($xtu as $yt)
            {
                //make pivot x list from each column of x 
                foreach($fxu as $f)
                {  
                    $p=$f;
                    
                    $rs=get_dictionary($f,$pid);
                    if(count($rs))
                    {
                        foreach($rs as $r)
                        {

                        $pstrx.=",round( SUM(CASE x1 WHEN $r->value THEN tot ELSE 0 END)/$tot_tv *100 ,2) as '$r->keyy %' ";
                        $pstrx2.=",round( SUM(CASE x1 WHEN $r->value THEN tot ELSE 0 END)/$tot_tv *100 ,2) as '$r->keyy %' ";
                        }
                    }  

                }
            }

            $str='';$stra='';
            
            
            if(strlen($conditions)>1){$str=" AND  $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}else{$str="WHERE $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}
            //if(strlen($conditions)>1){$str=" AND a1.$xfields IS NOT NULL AND $yfields IS NOT NULL AND a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}else{$str="WHERE a1.$xfields IS NOT NULL AND $yfields IS NOT NULL AND a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}
           
                $pstrx.=", round( SUM(tot)/$tot_tv*100 ,2) as 'Total %' FROM ( SELECT
                a2.$yfields y1,
                a1.$xfields as x1,
                $ss as tot
                        FROM
                        $tables $conditions  $str AND a2.$yfields!='' GROUP BY a2.$yfields, a1.$xfields 
                )AS stats GROUP BY y1 desc WITH ROLLUP";

                $pstrx2.=" FROM ( SELECT
               a2. $yfields y1,
               a1. $xfields as x1,
                $ss as tot
                        FROM
                        $tables $conditions  $str AND a2.$yfields!='' GROUP BY a2.$yfields, a1.$xfields 
                )AS stats GROUP BY y1 desc";

       }// end for pivot count % query   ===============================================

             //begin::make pivot row % query, first search all table field from y-axis list  =================================
    if($m=='rowp')
    {
            $dv='';
            $dv=get_dictionary_value($yfields,1);
            $pstrx="SELECT IFNULL(y1,'Row Total %') as $yfields ";
            $pstrx2="SELECT IFNULL(get_term('$yfields',y1),'Total %') as $yfields ";

            $arrc=array();
            foreach($xtu as $yt)
            {
                //make pivot x list from each column of x 
                foreach($fxu as $f)
                {  
                    $p=$f;
                   
                    $rs=get_dictionary($f,$pid);
                   
                    if(count($rs))
                    {
                        foreach($rs as $r)
                        {

                        $pstrx.=",round( SUM(CASE x1 WHEN $r->value THEN tot ELSE 0 END)/sum(tot)*100 ,2) as '$r->keyy %' ";
                        $pstrx2.=",round( SUM(CASE x1 WHEN $r->value THEN tot ELSE 0 END)/sum(tot)*100 ,2) as '$r->keyy %' ";
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
                        $tables  $conditions $str AND a2.$yfields!=''  GROUP BY a2.$yfields, a1.$xfields 
                )AS stats GROUP BY y1 desc WITH ROLLUP";
                
                $pstrx2.=" FROM ( SELECT
                a2.$yfields y1,
                a1.$xfields as x1,
                $ss as tot
                        FROM
                        $tables  $conditions $str AND a2.$yfields!='' GROUP BY a2.$yfields, a1.$xfields 
                )AS stats GROUP BY y1 desc";

       }// end for pivot row % query   ===============================================

       
             //begin::make pivot row % query, first search all table field from y-axis list  =================================
    if($m=='colp')
    {
        //for table count
                    $pstrx11="SELECT IFNULL(y1,'Total') as '$yfields' ";
                    
            
            $arrc=array();
            foreach($xtu as $yt)
            {
                //make pivot x list from each column of x 
                foreach($fxu as $f)
                {  
                   // echo '<br> tc: '.$yt.'='.$f;
                    //echo '<br>: ';
                    $rs=get_dictionary($f,$pid);
                    //print_r($rs);
                    if(count($rs))
                    {
                        foreach($rs as $r)
                        {
                        $pstrx11.=", SUM(CASE x1 WHEN $r->value THEN tot ELSE 0 END) as '$r->keyy' ";
                        //}
                        }
                    }  

                }
            }
            $str='';$stra='';$ss='';
            
            
              if($tab=='UMEED_20') $stra=" MONTH(a1.visit_month_20)=$mn AND ";
               
              if($tab=="UMEED2_40")
                  $stra=" MONTH(a1.visit_month_40)=$mn AND year(a1.visit_month_40)=$yrs AND ";
            if($tab=="EMPIRE_50")
                  $stra=" MONTH(a1.i_date_50)=$mn AND year(a1.i_date_50)=$yrs AND ";

            if($xfields==$yfields){$ss="COUNT(distinct resp_id)";}else $ss="SUM(if(a1.$xfields!='',1,0))"; 
            if(strlen($conditions)>1){$str=" AND $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}else{$str="WHERE $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}
            
            //if(strlen($conditions)>1){$str="AND a1.$xfields IS NOT NULL AND $yfields IS NOT NULL AND a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}else{$str="WHERE a1.$xfields IS NOT NULL AND $yfields IS NOT NULL AND a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid) ";}
            $pstrx11.=", SUM(tot) as Total FROM ( SELECT
                a2. $yfields y1,
                a1. $xfields as x1,
                $ss as tot
                        FROM
                        $tables  $conditions $str AND a2. $yfields!=''  GROUP BY a2. $yfields, a1. $xfields 
                )AS stats GROUP BY y1 desc WITH ROLLUP";

      //echo '<br> cc:'.$pstrx11;  
                  //to show the last Column Total value
                  $last=array();
                    $rr=DB::getInstance()->query($pstrx11);
                    if($rr)
                    foreach($rr->results() as $r)
                    {
                        $last=$r;
                    }
                   //print_r($last);
                    //echo $last->Boy;
                    
                        
        //end of table total
        //for column % process
                    $ro=0;$rtot=0;
            $pstrx="SELECT IFNULL(y1,'Total') as $yfields ";
            $pstrx2="SELECT IFNULL(get_term('$yfields',y1),'Total') as $yfields ";
            
            $arrc=array();
            foreach($xtu as $yt)
            {
                //make pivot x list from each column of x 
                foreach($fxu as $f)
                {  
                    $p=$f;
                   
                    $rs=get_dictionary($f,$pid);
                   
                    if(count($rs))
                    {
                        foreach($rs as $r)
                        {
                            $temp='';
                            $temp=$r->keyy;
                            if(!empty($last))
                            {    
                            $ro=$last->$temp;
                            if($ro==0) $ro=1;
                            $rtot=$last->Total;
                                  
                            }
                        $pstrx.=",round( SUM(CASE x1 WHEN $r->value THEN tot ELSE 0 END)/$ro *100 ,2) as '$r->keyy %' ";
                        $pstrx2.=",round( SUM(CASE x1 WHEN $r->value THEN tot ELSE 0 END)/$ro *100 ,2) as '$r->keyy %' ";
                        }
                    }  

                }
            }

            
            $str='';$stra='';
            

                   if($tab == 'UMEED_20') $stra=" MONTH(a1.visit_month_20)=$mn AND ";
                   if($tab=="UMEED2_40")
                  $stra=" MONTH(a1.visit_month_40)=$mn AND year(a1.visit_month_40)=$yrs AND ";
            if($tab=="EMPIRE_50")
                  $stra=" MONTH(a1.i_date_50)=$mn AND year(a1.i_date_50)=$yrs AND ";

            if($xfields==$yfields){$ss="COUNT(distinct a1.resp_id)";}else $ss="SUM(if(a1.$xfields!='',1,0))"; 
            if(strlen($conditions)>1){$str=" AND $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}else{$str="WHERE $stra a1.q_id IN (SELECT `qset_id` FROM `questionset` WHERE `project_id`=$pid)";}
            $pstrx.=",round( sum(tot)/$rtot*100 ,2) as 'Column %'  FROM ( SELECT
               a2. $yfields y1,
               a1. $xfields as x1,
                $ss as tot
                        FROM
                        $tables  $conditions $str  AND a2.$yfields!='' GROUP BY a2.$yfields, a1.$xfields 
                )AS stats GROUP BY y1 desc WITH ROLLUP";
              $pstrx2.="  FROM ( SELECT
               a2. $yfields y1,
               a1. $xfields as x1,
                $ss as tot
                        FROM
                        $tables  $conditions $str AND a2.$yfields!=''  GROUP BY a2.$yfields, a1.$xfields 
                )AS stats GROUP BY y1 desc";
       }// end for pivot column % query   ===============================================
    
    //   echo '<br>pstrx : '.$pstrx;
    // $_SESSION['query']=$pstrx;
    // $_SESSION['yfields']=$yfields;
    // $_SESSION['xfields']=$xfields;
    // $_SESSION['query2']=$pstrx2;



$columns = array(); $col='';$strth='';
echo "<br><br>";
//echo $pstrx;
    try {
     $conn = new PDO("mysql:host=database-1.c1mggasso0hp.ap-south-1.rds.amazonaws.com;dbname=vcims", 'qcsrdsadmin', 'Pa7du#ah$098');
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     //$conn->query("SET wait_timeout=120;");
     $stmt = $conn->prepare($pstrx); 
     
     $stmt->execute();

     // set the resulting array to associative
     $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
     $head='';
     //to display column heading
     echo "<table border=1 cellpadding=0 cellspacing=0>";
     
     for ($i = 0; $i < $stmt->columnCount(); $i++) {
    $col = $stmt->getColumnMeta($i);
    $columns[] = $col['name'];
    }
    //print_r($columns);
     $strth="<tr bgcolor=lightgray>";
     if(count($columns))
     foreach($columns as $t)
     {  
         if($t==$yfields)
         {
             $tm=get_dictionary_title_only($yfields);
             
             $strth.="<th> $tm</th>";$head.=$tm;
         }   
         else
         {$strth.="<th>$t</th>";$head.=$t;}
     }
     echo $strth.='</tr>';
     $qst=new RecursiveArrayIterator($stmt->fetchAll());
     //display y-axis term as their value
     $ctr=0;
      //$line='';
     foreach($qst as $ar)
     {
         $tt=$ar[$yfields];
         
         if(is_numeric($tt))
         {
         	$qst[$ctr][$yfields]=get_dictionary_value($yfields,$tt);
         }
         
         $ctr++;
     } 
     
     foreach(new TableRows($qst) as $k=>$v) { 
          echo $v;  
     }
    }
    catch(PDOException $e) {
         echo "Error: " . $e->getMessage();
    }
    $conn = null;
    echo "</table>";
  }
}
}

?>

<div id=view></div>
<center><div id="chart_div" style="width: 500px; height: 400px;"></div></center>

<script type="text/javascript">

function dispView()
{
var pin;
	if(window.XMLHttpRequest)
	{
		pin=new XMLHttpRequest();
	}
	else
	{
		pin= new ActiveXobject("Microsoft.XMLHTTP");
	}
	var val=document.getElementById('rv').value;

	pin.onreadystatechange=function()
	{
		if(pin.readyState==4)
		{
			document.getElementById('view').innerHTML=pin.responseText;
			console.log(pin);
		}
	}

	url="dispview.php?rv="+val;
	pin.open("GET",url,true);
	pin.send();
}


</script>



<style>
td {
    
    text-align: center;
}
</style>
