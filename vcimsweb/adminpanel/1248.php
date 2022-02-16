<?php
include_once('../init.php');
include_once('../functions.php');
// print_r($_POST);
?>

<!DOCTYPE html>
<html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js"></script>
<script>
function forprint(){
if (!window.print){
 
return
}
window.print()
}
</script>

<body>
<a href="javascript:forprint()">Print</a>
<br>
<center>
<br><h3><u>Questionnaire</u> </h3><br><br>

<?php
function getFPName($id){
		$arrtmp=array();
	      $qq="select * from app_first_page where id=$id";
              $pd = DB::getInstance()->query($qq);
              if($pd){
                        foreach($pd->results() as $ppd){
                                $tt=$ppd->title; $tp=$ppd->type;
				$arrtmp['title']=$tt; $arrtmp['type']=$tp;
                      }
              }
		return $arrtmp;
}
function getFPAge($pid){
                $arrtmp=array();
              $qq="select * from project_age_map where qset=$pid order by valuee";
              $pd = DB::getInstance()->query($qq);
              if($pd){ return $pd->results();
                       /* foreach($pd->results() as $ppd){
                                $tt=$ppd->title; $tp=$ppd->type;
                                $arrtmp['title']=$tt; $arrtmp['type']=$tp;
                      } */
              }
                return $arrtmp;
}
function getFPSec($pid){
                $arrtmp=array();
              $qq="select * from project_sec_map where qset=$pid order by valuee";
              $pd = DB::getInstance()->query($qq);
              if($pd){
			return $pd->results();
              }
                return $arrtmp;
}
function getFPProduct($pid){
                $arrtmp=array();
              $qq="select * from project_product_map where qset_id=$pid order by valuee";
              $pd = DB::getInstance()->query($qq);
              if($pd){
                        return $pd->results();
              }
                return $arrtmp;
}
function getFPStore($pid){
                $arrtmp=array();
              $qq="select * from project_store_loc_map where qset_id=$pid order by valuee";
              $pd = DB::getInstance()->query($qq);
              if($pd){
                        return $pd->results();
              }
                return $arrtmp;
}
function getFPCentre($pid){
                $arrtmp=array();
              $qq="select * from centre WHERE centre_id IN (select centre_id from centre_project_details where q_id=$pid);";
              $pd = DB::getInstance()->query($qq);
              if($pd){
                        return $pd->results();
              }
                return $arrtmp;
}
function getFPCarea($pid){
                $arrtmp=array();
              $qq="select * from project_centre_area_map where qset=$pid order by value;";
              $pd = DB::getInstance()->query($qq);
              if($pd){
                        return $pd->results();
              }
                return $arrtmp;
}
function getFPCsubarea($pid){
                $arrtmp=array();
              $qq="select * from project_centre_subarea_map where qset=$pid order by value";
              $pd = DB::getInstance()->query($qq);
              if($pd){
                        return $pd->results();
              }
                return $arrtmp;
}
if(isset($_POST)){
// print_r($_POST);
		$ppn='';
              $qset=$_POST['qset'];
	      $pn=$_POST['pn'];
              $tl=$_POST['tl'];
              
 	      $p1 = DB::getInstance()->query("select * from project where project_id=$pn");
	      if($p1){
			foreach($p1->results() as $pp){
				$ppn=$pp->name;
			}
	      }
              //$sqle = "select a.q_id, a.q_title, a.q_type,a.qno, b.chkflag from question_detail as a LEFT JOIN question_sequence as b on a.q_id=b.qid where b.qset_id=$qset order by b.sid ";
              //$qs = DB::getInstance()->query($sqle);
//print_r($qs);
              //$str1=''; $str2=''; $str3='';
              $str = "<table style='border-collapse: collapse'><tr style='border-bottom: 1px solid #ddd;'><td colspan=3 align='center' style='color:green'>Project - $ppn </td></tr>";
	      $str.="<tr  style='border-bottom: 1px solid #ddd;'><td></td><td style='width:10%;'></td><td></td></tr>";
              $str.="<tr  style='border-bottom: 1px solid #ddd;'><td></td><td>Registration Form</td><td>";

		$sqlfp="select * from project_fp_map WHERE pid=$qset order by fpid";
		$pfp=DB::getInstance()->query($sqlfp);
		if($pfp){
			foreach($pfp->results() as $fp){
				//$tmp=array();
				$fpid=$fp->fpid;
				$fdtls='';
				if($fpid==1) $fdtls=" --------";
				if($fpid==2) $fdtls=" --------";
				if($fpid==3) $fdtls=" --------";
				if($fpid==4) $fdtls=" --------";
				if($fpid==5) $fdtls=" --------";
				if($fpid==6){ $fdtls=" 1. Male , 2. Female";}
				if($fpid==7){ 
					$age_arr=getFPAge($qset);
					foreach($age_arr as $ag){
						$att=$ag->age;
						$acd=$ag->valuee;
						$fdtls.="<li> $acd . $att </li>";
					}
				}
				if($fpid==8) $fdtls=" --------";
                                if($fpid==9 || $fpid == 10){
                                        $sec_arr=getFPSec($qset);
                                        foreach($sec_arr as $ag){
                                                $att=$ag->sec;
                                                $acd=$ag->valuee;
                                                $fdtls.="<li> $acd . $att </li>";
                                        }
                                }
                                if($fpid==11){
                                        $store_arr=getFPStore($qset);
					if(!empty($store_arr)){
                                        foreach($store_arr as $ag){
                                                $att=$ag->store;
                                                $acd=$ag->valuee;
                                                $fdtls.="<li> $acd . $att</li>";
                                        }
					} else $fdtls.="<li> Store details not available. Please do it.<li>";
                                }
                                if($fpid==12){
                                        $prod_arr=getFPProduct($qset);
					if(!empty($prod_arr)){
                                        foreach($prod_arr as $ag){
                                                $att=$ag->product;
                                                $acd=$ag->valuee;
                                                $fdtls.="<li> $acd . $att</li>";
                                        }
					} else $fdtls.="<li> Product details not available. Please do it.<li>";
                                }
                                if($fpid==13){
                                        $cn_arr=getFPCentre($qset);
					if(!empty($cn_arr)){
                                        foreach($cn_arr as $ag){
                                                $att=$ag->centre_id;
						$cn=$ag->cname;
						$stt=$ag->state;
						$ctt=$ag->country;
                                                //$acd=$ag->valuee;
                                                $fdtls.="<li> $att . $cn [ $stt , $ctt ] </li>";
                                        }
					} else $fdtls.="<li> Centre details not available. Please do it.</li>";
                                }
                                if($fpid==14){
                                        $ca_arr=getFPCarea($qset); //print_r($ca_arr);
					if(!empty($ca_arr)){
                                        foreach($ca_arr as $ca){
                                                $caa = $ca->area;
                                                $cav = $ca->value;
						$caid = $ca->cid;
                                                $fdtls .= "<li>  $cav . $caa [ $caid ]</li>";
                                        }
					} else $fdtls.="<li> Centre Area details not available. Please do it. </li>";
                                }
                                if($fpid==15){
                                        $sca_arr=getFPCsubarea($qset);
					if(!empty($sca_arr)){
                                        foreach($sca_arr as $ag){
                                                $att=$ag->suarea;
                                                $acd=$ag->value;
                                                $cid=$ag->cid;
                                                $fdtls.="<li> $acd . $att - $cid </li>";
                                        }
					} else $fdtls.="<li> Centre SubArea details not available. Please do it. </li>";
                                }

				if($fpid==16) $fdtls=" --------";
				if($fpid==17) $fdtls=" --------";

				$tmp=getFPName($fpid); 
				if(!empty($tmp)){
					$fptitle= $tmp['title'];
					$str.="<br><font color=blue> $fptitle : </font> $fdtls ";
				}
			}
		}
		$str.="</td></tr>";
              $str.="<tr  style='border-bottom: 1px solid #ddd;'><td></td><td align=center style='width:10%;'></td><td>---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td></tr>";
              $str.="<tr  style='border-bottom: 1px solid #ddd;'><td></td><td align=center colspan=2> START QUESTIONNAIRE</td></tr>";
              $str.="<tr  style='border-bottom: 1px solid #ddd;'><td></td><td align=center style='width:10%;'></td><td>====================================================================================================================================================</td></tr>";
		echo $str;
              $k=0;
              $sqle = "select a.q_id, a.q_title, a.q_type,a.qno, b.chkflag from question_detail as a LEFT JOIN question_sequence as b on a.q_id=b.qid where b.qset_id=$qset order by b.sid";
              $qs = DB::getInstance()->query($sqle);
              foreach($qs->results() as $p)
              {      $k++; 
                     $str1=''; $str2=''; $str3='';

                     $qid=$p->q_id; $t=$p->q_title; $qt=$p->q_type; $qn=$p->qno; $chkflag = $p->chkflag;
                     $tqt='';  
                     //start translated question details
                     $sql = "select q_title from question_detail where q_id=$qid";
                     if($tl==1) $sql = "select q_title from hindi_question_detail where q_id=$qid";
                     if($tl==2) $sql = "select q_title from kannar_question_detail where q_id=$qid";
                     if($tl==3) $sql = "select q_title from malyalam_question_detail where q_id=$qid";
                     if($tl==4) $sql = "select q_title from tammil_question_detail where q_id=$qid";
                     if($tl==5) $sql = "select q_title from telgu_question_detail where q_id=$qid";
                     if($tl==6) $sql = "select q_title from bengali_question_detail where q_id=$qid";
                     if($tl==7) $sql = "select q_title from odia_question_detail where q_id=$qid";
                     if($tl==8) $sql = "select q_title from gujrati_question_detail where q_id=$qid";
                     if($tl==9) $sql = "select q_title from marathi_question_detail where q_id=$qid";
                     if($tl==10) $sql = "select q_title from asami_question_detail where q_id=$qid";

                     $qsq=DB::getInstance()->query($sql);
                     if($qsq )
                     foreach($qsq->results() as $qs){
                        $tqtt=$qs->q_title; 
			if($tl>=1)$tqt="<p style='font-color:gray;'>[ $tqtt ]</p>";
			if($tl<1) $tqt='';
                     }
                     //end trans question details

                     //To display routine details
                     if($chkflag == 1){
                        $pqid_arr = getPQRoutine($qid); 
				//echo "<br> pqid_arr:";print_r($pqid_arr);
			foreach($pqid_arr as $pqida){
 				//echo "<br>pqids: $pqida ,qid: $qid <br>";
                          $clist=''; $cqid=''; $tlist=''; $tqid='';

                           $arrr = getQRoutine($qid,$pqida);
        			//print_r($arrr);echo "<br>";
			    if(!empty($arrr)){
                          //$arrr = getQRoutine($qid); 
                          $clist=$arrr['c']; $cq=$arrr['cqid']; $tlist=$arrr['t']; $tq=$arrr['tqid'];
                          if($clist!='') $str1 .= "<tr style='border-bottom: 1px solid #ddd;'><td></td><td colspan=2 style='color:blue;'> [CONTINUE to ask question  $qn / $qid    only if any options   $clist is selected at QID $cq ELSE skip it ]  </td></tr>";
                          if($tlist!='') $str1 .= "<tr style='border-bottom: 1px solid #ddd;'><td></td><td colspan=2 style='color:blue;'> [And TERMINATE question  $qn / $qid if any options $tlist is selected at QID $tq ]</td></tr>";

			     } //end of if arrr	
			  } //end of foreach
                     } //end of if chkflag ==1

                      //To display question details
                      echo $str1 .= "<tr style='border-bottom: 1px solid #ddd;'><td> $k </td><td style='color:red;'> $qn / $qid / $qt </td><td>  $t  $tqt </td></tr>";
                      $str .= $str1;
                      
                     if($qt == 'radio' || $qt == 'checkbox') 
                     {  $str2='';
                         $tqop_arr=array();
                     	$sql2 = "select distinct opt_text_value as ttxt from question_option_detail where q_id=$qid order by id";
                     	if($tl==1) $sql2 = "select distinct opt_text_value as ttxt from hindi_question_option_detail where q_id=$qid order by code";
                     	if($tl==2) $sql2 = "select distinct opt_text_value as ttxt from kannar_question_option_detail where q_id=$qid order by code";
                     	if($tl==3) $sql2 = "select distinct opt_text_value as ttxt from malyalam_question_option_detail where q_id=$qid orderby id";
                     	if($tl==4) $sql2 = "select distinct opt_text_value as ttxt from tammil_question_option_detail where q_id=$qid order by id";
                     	if($tl==5) $sql2 = "select distinct opt_text_value as ttxt from telgu_question_option_detail where q_id=$qid order by id";
                     	if($tl==6) $sql2 = "select distinct opt_text_value as ttxt from bengali_question_option_detail where q_id=$qid order by id";
                     	if($tl==7) $sql2 = "select distinct opt_text_value as ttxt from odia_question_option_detail where q_id=$qid order by id";
                     	if($tl==8) $sql2 = "select distinct opt_text_value as ttxt from gujrati_question_option_detail where q_id=$qid order by id";
                     	if($tl==9) $sql2 = "select distinct opt_text_value as ttxt from marathi_question_option_detail where q_id=$qid order by id";
                     	if($tl==10) $sql2 = "select distinct opt_text_value as ttxt from asami_question_option_detail where q_id=$qid order by id";
		      	$rs1x = DB::getInstance()->query($sql2);
                         if($rs1x){ $str2="<tr style='border-bottom: 1px solid #ddd;'><td></td><td></td><td style='color:grey;'>";
                         foreach($rs1x->results() as $tqop)
                         {   $opt='';
                             $opt=$tqop->ttxt;
			     array_push($tqop_arr,$opt);
			 }}
//if($qid == '11436') print_r($rslx->results());

			 $i=0;
			 $rs1 = DB::getInstance()->query("select * from question_option_detail where q_id=$qid");
                         if($rs1){
                         foreach($rs1->results() as $qop)
                         {   $op_ttext='';
                             $op_text=$qop->opt_text_value;
                             $op_value=$qop->value;
                             $term='';
                             $temps='';
				if($tl>0){
					$te=$tqop_arr[$i]; $temps="[ $te ]";
				 }
				if($i == 0)$term=$qop->term;
                                 // $str2 .= "<tr><td></td><td> $op_value : $term </td><td>  $op_text $temps  </td></tr>";
				$str2 .= "<br> $op_value . $op_text $temps ";
                 		$i++;
                         }} $str2.="</td></tr>";
			 echo $str2;
                         $str .= $str2;
                      
                     } //end of radio quest
                     //$str.="</li><br>";

                     if($qt=='rating') 
                     {  $str3='';
                         
                         //$rs2=$this->getPQop($qid); 
			 $rs2 = DB::getInstance()->query("select * from question_option_detail where q_id=$qid");
                         if($rs2)
                         foreach($rs2->results() as $qop2)
                         {
                             $ssv=$qop2->scale_start_value;
                             $sev=$qop2->scale_end_value;
                             $ssl=$qop2->scale_start_label;
                             $sel=$qop2->scale_end_label;
                             //$op_value=$qop2->value;
                             $term=$qop2->term;
                                   $str3.="<tr style='border-bottom: 1px solid #ddd;'><td></td><td></td><td style='color:grey;'> $ssl / $ssv <-------------------->  $sev / $sel </td></tr>";                 
                         }
			echo $str3;
                         $str .= $str3;
                     } //end of rating quest

                    // $str.="</li><br>";
              }
               $str .= '</table>';
               //echo "ff: $str";

} //end of isset
        function  getPQRoutine($qid=null)
    	{
       		$arr=array();
		$sq="select distinct pqid from question_routine_check where qid=$qid ; ";
		$sqd=DB::getInstance()->query($sq);
	        if($sqd->count() > 0 ){
	        	foreach($sqd->results() as $v1){

                          $q = $v1->pqid;
				array_push($arr,$q);
                        }
                }
		return $arr;
	}

        function getQRoutine($qid=null, $pqid=null)
    	{
       		$arr=array(); $str1=''; $str2='';
		$sq="select * from question_routine_check where qid=$qid and pqid = $pqid and flow > 0";
		$sqd=DB::getInstance()->query($sq);
	        if($sqd->count()>0){
                        $i=0; $q1=0;$str1='';
			$arr['tqid']= $pqid;
	        	foreach($sqd->results() as $v1){
                          //$arr['tqid']= $pqid; 
				$opv = $v1->opval;
                           if($i > 0) $str1.=",";
                           $str1 .= $opv;
                           $i++;
                        }
                       //$arr['tqid'] = $q1;
                       $arr['t'] = $str1;
                }
	     /*   else{
                       $arr['tqid'] = '';
                       $arr['t'] = '';
                }
	     */
		$sq2="select * from question_routine_check where qid=$qid  and pqid = $pqid and flow < 1";
		$result2=DB::getInstance()->query($sq2);
	        if($result2->count() > 0){
                        $j=0; $q2=0;$str2='';
			$arr['cqid']= $pqid;
	        	foreach($result2->results() as $v2){
                           //$arr['cqid']=$q2=$v2->pqid; 
				$opv2 = $v2->opval;
                           if($j > 0) $str2 .= ",";
                           $str2 .= $opv2;
                           $j++;
                        }
                       //$arr['cqid'] = $q2;
                       $arr['c'] = $str2;
                }
               /* else{
                       $arr['cqid'] = '';
                       $arr['c'] = '';
                }
		*/
                return $arr;
    	}

?>
