<div id=header>
  <?php
    	include_once('../init.php');
    	if(!Session::exists('suser'))
	{
		Redirect::to('login_fp.php');
	}
       if(isset($_POST['logout']))
         {
            session_destroy();
		//Cookie::delete($this->_cookieName);
		Redirect::to('login_fp.php');
            
         }
          echo "Hi <font color='lightgreen'>".Session::get('suser')."</font>"; 
        ?>
                               <form action="" method=post><input type=submit name=logout value=Logout><div style=float:right><img src='../../images/Digiadmin_logo.jpg' height=50 width=150> </div> <center><h3><font color=red >CrossTab Project Report</font></h3></center>
    </div>
    
    

<div id="ctext">
    Your Result:<br>
<?php
//ob_flush();
include_once('../init.php');
include_once('../functions.php');


//###########################################################################################
if(isset($_POST['show']))
{
    $xtables='';$ytables='';$tables='';$xfields='';$yfiled='';$fields='';$conditions='';
    
    $tx=array();$f=array();$c=array();$ty=array();$fx=array();$fy=array();$alltables=array();
    
    $pid=$_POST['project'];
    $m=$_POST['measure'];
    $xaa=$_POST['xv'];
    $yaa=$_POST['yv'];
    $faa=$_POST['fv'];
    //get as string value as within single '' from a string list separated by , of x-axis or y-axis
    $strx= implode("','",explode(",",$xaa));
    $stry= implode("','",explode(",",$yaa));
    //get the table name and column name as two array like $tx and $fx of X/Y axis
    list($tx,$fx)=get_table_column($strx);
    list($ty,$fy)=get_table_column($stry);

    if(!empty($tx)){$xtu=array_unique($tx); $xtables=implode(",",array_unique($tx));if(strlen($tables)>0){$tables.=', ';$tables.=$xtables; }else{$tables=$xtables;}}
    if(!empty($ty)){$ytu=array_unique($ty); $ytables=implode(",",array_unique($ty));if(strlen($tables)>0){$tables.=', ';$tables.=$ytables; }else{$tables=$ytables;}}
    if(!empty($fx)){$fxu=array_unique($fx); $xfields=implode(",",array_unique($fx));}else { $xfields=implode(",",$fx);}
    //echo '<br>xf: '.$xfields;
    if(count($fy)==1){ $yfields=$fy[0];}else if(count($fy)>1) { $yfields=implode(",",$fy);}else {$yfields=$stry;}
    
    $x=explode(",",$faa);
    $c=array_unique($x);
    
    //echo '<br>fy : '.count($fy);
    if((!empty($tx)) && (!empty($ty))){ $tables=implode(",",array_unique(array_merge($tx,$ty)));}else echo 'select x and Y axis';
    
    //echo '<br>Tables : '.$tables;
    if(count($tx)!=0 && count($ty)!=0) $alltables=array_unique(array_merge($tx,$ty)); 
            else if(count($tx)!=0 && count($ty)==0)$alltables=$tx;
            else if(count($ty)!=0 && count($tx)==0)$alltables=$ty;
            
    //echo '<br>Join Tables : '.$tables;
    
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
            $curr=substr($ff, 0, 8); //get 1st 5 char from filters array
            $arr=explode("=",$ff);
            $v1=$arr[0];
            $v2=$arr[1];
            list($tx2,$fx2)=get_table_column($v1);
            if(!array_search($tx2,$alltables))
            {
                //new table found and add them
                $a1=$tx2[0];
                array_push($alltables, $a1);
                //print_r($alltables);
            }
            if($ctr==0){$conditions=" WHERE  "; } 
            else
            {  
                if($curr==$prev)
                {
                    //echo '<br> cuur if v1 : '.$v1.'='.$v2;
                        $flag++;
                        if($flag==1)
                        {
                            $prv1.='('.$pp1.' OR '.$v1.'='.$v2;
                        }
                        else
                            $prv1.=' OR '.$v1.'='.$v2;

                            $andflag=0;
                            //$conditions.=' OR ';
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
            if($flag==0)
               $pp1=$v1.'='.$v2;
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
        
            //echo '<br> flag:'.$flag .' '.$andflag.'  '.$v1.'='.$v2;
            if($flag==0 && $andflag==1)
            $prv1.=$v1.'='.$v2;
            if($flag==0 && $andflag==0)
            $prv1.=$v1.'='.$v2;
           // echo '<br> prv1:'.$prv1;
            
        if($flag>0)
                $prv1.=' )';
        $conditions.=$prv1;
    } else echo '<br><font color=red>filters not applied</font>';
   // echo '<br>condition : '.$conditions;
    $alltables=array_unique($alltables);
    $ttc=count($alltables);
    $temp='';$ctr=0;$pr=''; $strvisit1='';
    
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
        
        if($ttc==1 && $ctr==1)
        {
            $temp=$pr=$t.' as a1';
        }
        if($ttc==2 && $ctr==1)
        {
            $pr=$t.' as a1';
        }
        if($ttc==2 && $ctr==2)
        {
           $temp.= $pr.=' JOIN  '.$t.' as a2 ON a1.resp_id=a2.resp_id '.$strvisit1;
            
        }
        if($ttc==2 && $ctr==3)
        {
            $temp.=' JOIN '.$t.' as a3 ON a1.resp_id=a3.resp_id '.$strvisit1;
            
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
    

   // print_r($xtu);
   
    //begin::make pivot count query, first search all table field from y-axis list   #################################
    $str='';
    if($m=='tot')
    {
            $pstrx="SELECT IFNULL(y1,'Total') as '$yfields'";
            
            $arrc=array();
            foreach($xtu as $yt)
            {
                //make pivot x list from each column of x 
                foreach($fxu as $f)
                {  
                   // echo '<br> tc: '.$yt.'='.$f;
                    //echo '<br>: ';
                    $rs=get_dictionary($f);
                    //print_r($rs);
                    if(count($rs))
                    {
                        foreach($rs as $r)
                        {
                        $pstrx.=", SUM(CASE x1 WHEN $r->value THEN tot ELSE 0 END) as '$r->keyy' ";
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
            
            
            if($xfields==$yfields){$ss="COUNT(distinct a1.resp_id)";}else $ss="COUNT(*)"; 
            
            if(strlen($conditions)>1){$str=" AND $stra a1.q_id IN (select q_id FROM questionare_info WHERE project_id=$pid)";}else{$str="WHERE $stra a1.q_id IN (select q_id FROM questionare_info WHERE project_id=$pid)";}
            
            //if(strlen($conditions)>1){$str="AND a1.$xfields IS NOT NULL AND $yfields IS NOT NULL AND a1.q_id IN (select q_id FROM questionare_info WHERE project_id=$pid)";}else{$str="WHERE a1.$xfields IS NOT NULL AND $yfields IS NOT NULL AND a1.q_id IN (select q_id FROM questionare_info WHERE project_id=$pid) ";}
            $pstrx.=", SUM(tot) as Total FROM ( SELECT
                $yfields y1,
                $xfields as x1,
                $ss as tot
                        FROM
                        $tables  $conditions  $str AND $yfields!='' AND $xfields!='' GROUP BY $yfields, $xfields 
                )AS stats GROUP BY y1 WITH ROLLUP";

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
            
            if($xfields==$yfields){$ss="COUNT(distinct resp_id)";}else $ss="COUNT(*)"; 
            if(strlen($conditions)>1){$str=" AND $stra a1.q_id IN (select q_id FROM questionare_info WHERE project_id=$pid)";}else{$str="WHERE $stra a1.q_id IN (select q_id FROM questionare_info WHERE project_id=$pid) AND $yfields!='' AND $xfields!='' ";}
            
            //echo '<br> cc:'. $qtc="SELECT count(*) as tot FROM $tables  $str $conditions AND a1.$xfields IS NOT NULL AND $yfields IS NOT NULL AND a1.q_id IN (select q_id FROM questionare_info WHERE project_id=$pid)";
             $qtc="SELECT $ss as tot FROM $tables  $str $conditions ";
            
            $contrs=DB::getInstance()->query($qtc);
            //echo '<br> cc:'.count($contrs);
            if($contrs->count()>0)
            {
            $tot_tv=$contrs->first()->tot;   
            }
            $pstrx="SELECT IFNULL(y1,'Total %') as $yfields ";
            $arrc=array();
            foreach($xtu as $yt)
            {
                //make pivot x list from each column of x 
                foreach($fxu as $f)
                {  
                    $p=$f;
                    
                    $rs=get_dictionary($f);
                    if(count($rs))
                    {
                        foreach($rs as $r)
                        {

                        $pstrx.=",round( SUM(CASE x1 WHEN $r->value THEN tot ELSE 0 END)/$tot_tv *100 ,2) as '$r->keyy %' ";
                        
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
            
            if(strlen($conditions)>1){$str=" AND  $stra a1.q_id IN (select q_id FROM questionare_info WHERE project_id=$pid)";}else{$str="WHERE $stra a1.q_id IN (select q_id FROM questionare_info WHERE project_id=$pid)";}
            //if(strlen($conditions)>1){$str=" AND a1.$xfields IS NOT NULL AND $yfields IS NOT NULL AND a1.q_id IN (select q_id FROM questionare_info WHERE project_id=$pid)";}else{$str="WHERE a1.$xfields IS NOT NULL AND $yfields IS NOT NULL AND a1.q_id IN (select q_id FROM questionare_info WHERE project_id=$pid)";}
           
                $pstrx.=", round( SUM(tot)/$tot_tv*100 ,2) as 'Total %' FROM ( SELECT
                $yfields y1,
                $xfields as x1,
                COUNT(*) as tot
                        FROM
                        $tables $conditions  $str AND $yfields!='' AND $xfields!='' GROUP BY $yfields, $xfields 
                )AS stats GROUP BY y1 WITH ROLLUP";

       }// end for pivot count % query   ===============================================

             //begin::make pivot row % query, first search all table field from y-axis list  =================================
    if($m=='rowp')
    {
            $dv='';
            $dv=get_dictionary_value($yfields,1);
            $pstrx="SELECT IFNULL(y1,'Row Total %') as $yfields ";
            $arrc=array();
            foreach($xtu as $yt)
            {
                //make pivot x list from each column of x 
                foreach($fxu as $f)
                {  
                    $p=$f;
                   
                    $rs=get_dictionary($f);
                   
                    if(count($rs))
                    {
                        foreach($rs as $r)
                        {

                        $pstrx.=",round( SUM(CASE x1 WHEN $r->value THEN tot ELSE 0 END)/sum(tot)*100 ,2) as '$r->keyy %' ";
                        
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
            
            if($xfields==$yfields){$ss="COUNT(distinct resp_id)";}else $ss="COUNT(*)"; 
            if(strlen($conditions)>1){$str=" AND $stra a1.q_id IN (select q_id FROM questionare_info WHERE project_id=$pid)";}else{$str="WHERE $stra a1.q_id IN (select q_id FROM questionare_info WHERE project_id=$pid)";}
            $pstrx.=",round( sum(tot)/sum(tot)*100 ,2) as Total  FROM ( SELECT
                $yfields y1,
                $xfields as x1,
                $ss as tot
                        FROM
                        $tables  $conditions $str AND $yfields!='' AND $xfields!='' GROUP BY $yfields, $xfields 
                )AS stats GROUP BY y1 WITH ROLLUP";

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
                    $rs=get_dictionary($f);
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
            
            if($xfields==$yfields){$ss="COUNT(distinct resp_id)";}else $ss="COUNT(*)"; 
            if(strlen($conditions)>1){$str=" AND $stra a1.q_id IN (select q_id FROM questionare_info WHERE project_id=$pid)";}else{$str="WHERE $stra a1.q_id IN (select q_id FROM questionare_info WHERE project_id=$pid)";}
            
            //if(strlen($conditions)>1){$str="AND a1.$xfields IS NOT NULL AND $yfields IS NOT NULL AND a1.q_id IN (select q_id FROM questionare_info WHERE project_id=$pid)";}else{$str="WHERE a1.$xfields IS NOT NULL AND $yfields IS NOT NULL AND a1.q_id IN (select q_id FROM questionare_info WHERE project_id=$pid) ";}
            $pstrx11.=", SUM(tot) as Total FROM ( SELECT
                $yfields y1,
                $xfields as x1,
                $ss as tot
                        FROM
                        $tables  $conditions $str AND $yfields!='' AND $xfields!='' GROUP BY $yfields, $xfields 
                )AS stats GROUP BY y1 WITH ROLLUP";

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
            $arrc=array();
            foreach($xtu as $yt)
            {
                //make pivot x list from each column of x 
                foreach($fxu as $f)
                {  
                    $p=$f;
                   
                    $rs=get_dictionary($f);
                   
                    if(count($rs))
                    {
                        foreach($rs as $r)
                        {
                            $temp='';
                            $temp=$r->keyy;
                            if(!empty($last))
                            {    
                            $ro=$last->$temp;$rtot=$last->Total;
                            }
                        $pstrx.=",round( SUM(CASE x1 WHEN $r->value THEN tot ELSE 0 END)/$ro *100 ,2) as '$r->keyy %' ";
                        
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
            
            if(strlen($conditions)>1){$str=" AND $stra a1.q_id IN (select q_id FROM questionare_info WHERE project_id=$pid)";}else{$str="WHERE $stra a1.q_id IN (select q_id FROM questionare_info WHERE project_id=$pid)";}
            $pstrx.=",round( sum(tot)/$rtot*100 ,2) as 'Column %'  FROM ( SELECT
                $yfields y1,
                $xfields as x1,
                COUNT(*) as tot
                        FROM
                        $tables  $conditions $str AND $yfields!='' AND $xfields!='' GROUP BY $yfields, $xfields 
                )AS stats GROUP BY y1 WITH ROLLUP";
       }// end for pivot column % query   ===============================================

       
      // echo '<br>pstrx : '.$pstrx;

    //display query value in table grid
    
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
   
    try {
     $conn = new PDO("mysql:host=localhost;dbname=vcims_12052015", 'user1', 'vcims@user1');
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     $stmt = $conn->prepare($pstrx); 
     $stmt->execute();

     // set the resulting array to associative
     $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
     
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
             
             $strth.="<th> $tm</th>";
         }   
         else
         $strth.="<th>$t</th>";
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
?>
</div>
    
    
    
<!DOCTYPE html>
<html>

<head>
<style>
    

        </style>
          <link rel="stylesheet" href="../../css/siteadmin.css">

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>
            
            var arr1 = [];
            var arr2 = [];
            var arr3 = [];
        $(document).ready(function(){
        
        $(".xa").click(function () { 
                 if(this.checked)
                 arr1.push($(this).val());
                 else 
                 {arr1.splice($.inArray($(this).val(), arr1),1); }
            //alert(arr1.join(",")+document.getElementById("x").innerHTML);
            $("#x").val(arr1.join(","));
        //$("#txtAge").toggle(this.checked);
        });
        
        $(".ya").click(function () {
                 if(this.checked)
                 arr2.push($(this).val());
                 else 
                 {arr2.splice($.inArray($(this).val(), arr2),1); }
            //alert(arr2.join(",")+document.getElementById("y").innerHTML);
            $("#y").val(arr2.join(","));
        //$("#txtAge").toggle(this.checked);
        });
        
        $(".fa").click(function () {
                 if(this.checked)
                 arr3.push($(this).val());
                 else 
                 {arr3.splice($.inArray($(this).val(), arr3),1); }
            //alert(arr3.join(",")+document.getElementById("f").innerHTML);
            $("#f").val(arr3.join(","));
        //$("#txtAge").toggle(this.checked);
        });
        //to reset the x-axis checkboxes
        $("#bxa").click(function () {
                 $(".xa").each(function() { 
                   this.checked = false; }); 
               $("#x").val("");
               arr1.length=0;
        });
        //to reset the y-axis checkboxes
        $("#bya").click(function () {
                 $(".ya").each(function() { 
                   this.checked = false; }); 
               $("#y").val("");
               arr2.length=0;
        });
          //to reset the all filters checkboxes
        $("#bfa").click(function () {
                 $(".fa").each(function() { 
                   this.checked = false; }); 
               $("#f").val("");
               arr3.length=0;
        });
        
    });
    
        </script>

    </head>
    
    <script type="text/javascript">
        var arr1 = [];
            var arr2 = [];
            var arr3 = [];
            $(".xa").click(function () { 
                 if(this.checked){
                 arr1.push($(this).val());alert('checked 1');}
                 else 
                 {arr1.splice($.inArray($(this).val(), arr1),1); }
            $("#x").val(arr1.join(","));
        });
    function enableTextBoxx()
    {
            arr1.length=0;
     
        $("input:checkbox[class=xa]").each(function () {
            
            if($(this).is(":checked"))
            arr1.push($(this).val());
           
            //alert("Id: " + $(this).attr("id") + " Value: " + $(this).val() + " Checked: " + $(this).is(":checked"));
        });    
        $("#x").val(arr1.join(","));
    }
    function enableTextBoxy()
    {
            arr2.length=0;
     
        $("input:checkbox[class=ya]").each(function () {
            
            if($(this).is(":checked"))
            arr2.push($(this).val());
           
            //alert("Id: " + $(this).attr("id") + " Value: " + $(this).val() + " Checked: " + $(this).is(":checked"));
        });    
        $("#y").val(arr2.join(","));
    }
    function enableTextBoxf()
    {
            arr3.length=0;
     
        $("input:checkbox[class=fa]").each(function () {
            
            if($(this).is(":checked"))
            arr3.push($(this).val());
           
            //alert("Id: " + $(this).attr("id") + " Value: " + $(this).val() + " Checked: " + $(this).is(":checked"));
        });    
        $("#f").val(arr3.join(","));
    }
    
    
    </script>    

    <body id=pg>
        
            <center><h2><font color=red>Report Filter</font></h2></center>
            
            <form method="post" action="">
            <table cellpadding="0" cellspacing="0">
            <tr><td>Project </td><td><select name="project" id="project" onclick="displib()"><option value="0">--Select--</option><?php $ptt=get_projects_details();if($ptt) foreach($ptt as $p){?><option value="<?php echo $p->project_id; ?>"> <?php echo $p->name;  ?></option> <?php } ?></select> <input type="reset" value="Reset All"> <input type="submit" name="show" value="Show Report"></td></tr>
            <tr><td>Measure By </td><td><select name='measure' id="measure"><option value="tot">Total Count</option><option value="totp">Table %</option><option value="rowp">Row %</option><option value="colp">Column %</option></select> </td></tr>
            <tr><td>Selected X-Axis </td><td><textarea rows="4" cols="50" name="xv" id="x" readonly>   </textarea> <input type="button" id="bxa" value="Reset X"></td></tr>
            <tr><td>Selected Y-Axis  </td><td><textarea rows="4" cols="50" name="yv"  id="y" readonly>  </textarea> <input type="button" id="bya" value="Reset Y"></td></tr>
            <tr><td>Selected Filter </td><td><textarea rows="4" cols="50"name="fv" id="f" readonly>  </textarea> <input type="button" id="bfa" value="Reset Filter"></td></tr>
              
            </table>
            <!--<button>Hide/Show</button> Grid Parameters<br><br> -->
            
                
             <div id="d1" name="d1"> 
                 <font color=red><i>Select project for CrossTab options</i></font>

            </div>

            <center><input type="submit" name="show" value="Show Report"></center>
        </form>
            
    
</html>
    
<script type="text/javascript">
  document.getElementById('project').value = "<?php echo $_POST['project'];?>";
  document.getElementById('measure').value = "<?php echo $_POST['measure'];?>";
  document.getElementById('x').value = "<?php echo $_POST['xv'];?>";
  document.getElementById('y').value = "<?php echo $_POST['yv'];?>";
  document.getElementById('f').value = "<?php echo $_POST['fv'];?>";
  
</script>


<script type="text/javascript">

function displib()
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
	var val=document.getElementById('project').value;

	pin.onreadystatechange=function()
	{
		if(pin.readyState==4)
		{
			document.getElementById('d1').innerHTML=pin.responseText;
			console.log(pin);
		}
	}

	url="tst.php?inv="+val;
	pin.open("GET",url,true);
	pin.send();
}


</script>