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
<br><br><h3> SHOW CARD</h3><br><br>

<?php
if(isset($_POST['sc_view'])){
// print_r($_POST);
		$ppn='';
              $qset=$_POST['qset'];
	      $pn=$_POST['pn'];
              $tl=$_POST['tl'];
              $cqid=$_POST['qid'];

 	      $p1 = DB::getInstance()->query("select * from project where project_id=$pn");
	      if($p1){
			foreach($p1->results() as $pp){
				$ppn=$pp->name;
			}
	      }
              $sqle = "select q_id, q_title, q_type,qno from question_detail where q_id=$cqid ";
              $qs = DB::getInstance()->query($sqle);
//print_r($qs);
              //$str1=''; $str2=''; $str3='';
              echo $str = "<table border=1 cellspacing=0 cellpadding=0><tr><td colspan=3 align='center' style='color:green'>Project - $ppn </td> </tr> <tr><td>QNO/QID</td><td>DETAILS</td></tr>";
              $k=0;
              foreach($qs->results() as $p)
              {	     $k++;
                     $str1=''; $str2=''; $str3='';
                     //$str1 ="<tr><td>SN</td><td>QNO/QID</td><td>DETAILS</td></tr>";
                     $qid=$p->q_id; $t=$p->q_title; $qt=$p->q_type; $qn=$p->qno; 
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
                        $tqtt=$qs->q_title; $tqt="<p style='font-family:mangal;'>[ $tqtt ]</p>";
                     }

                     //end trans question details

                      //To display question details
                      echo $str1 .= "<tr><td style='color:red;'> $qn / $qid / $qt </td><td>  $t  $tqt </td></tr>";
                      $str .= $str1;
                      
                     if($qt == 'radio' || $qt == 'checkbox') 
                     {  $str2='';
                         $tqop_arr=array();
                     	
                     	if($tl==1) $sql2 = "select distinct opt_text_value as ttxt from hindi_question_option_detail where q_id=$qid order by id";
                     	if($tl==2) $sql2 = "select distinct opt_text_value as ttxt from kannar_question_option_detail where q_id=$qid order by id";
                     	if($tl==3) $sql2 = "select distinct opt_text_value as ttxt from malyalam_question_option_detail where q_id=$qid orderby id";
                     	if($tl==4) $sql2 = "select distinct opt_text_value as ttxt from tammil_question_option_detail where q_id=$qid order by id";
                     	if($tl==5) $sql2 = "select distinct opt_text_value as ttxt from telgu_question_option_detail where q_id=$qid order by id";
                     	if($tl==6) $sql2 = "select distinct opt_text_value as ttxt from bengali_question_option_detail where q_id=$qid order by id";
                     	if($tl==7) $sql2 = "select distinct opt_text_value as ttxt from odia_question_option_detail where q_id=$qid order by id";
                     	if($tl==8) $sql2 = "select distinct opt_text_value as ttxt from gujrati_question_option_detail where q_id=$qid order by id";
                     	if($tl==9) $sql2 = "select distinct opt_text_value as ttxt from marathi_question_option_detail where q_id=$qid order by id";
                     	if($tl==10) $sql2 = "select distinct opt_text_value as ttxt from asami_question_option_detail where q_id=$qid order by id";
		      	$rs1x = DB::getInstance()->query($sql2);
                         if($rs1x){ $str2="<tr><td></td><td>";
                         foreach($rs1x->results() as $tqop)
                         {   $opt='';
                             $opt=$tqop->ttxt;
			     array_push($tqop_arr,$opt);
			 }}

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
				$str2 .= "<br> $op_value :   $op_text $temps ";
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
                                   $str3.="<tr><td></td><td> $ssl / $ssv <-------------------->  $sev / $sel  -- $term </td></tr>";                 
                         }
			echo $str3;
                         $str .= $str3;
                     } //end of rating quest
                    // $str.="</li><br>";
              }
               $str .= '</table>';
               //echo "ff: $str";

} //end of isset

        function getQRoutine($qid=null)
    	{
       		$arr=array(); $str1=''; $str2='';
		$sq="select * from question_routine_check where qid=$qid and flow != 0";
		$sqd=DB::getInstance()->query($sq);
	        if($sqd){
                        $i=0; $q1=0;
	        	foreach($sqd->results() as $v1){
                          $arr['tqid']= $ql = $v1->pqid; $opv = $v1->opval;
                           if($i > 0) $str1.=",";
                           $str1 .= $opv;
                           $i++;
                        }
                       //$arr['tqid'] = $q1;
                       $arr['t'] = $str1;
                }
	        else{
                       $arr['tqid'] = '';
                       $arr['t'] = '';
                }

		$sq2="select * from question_routine_check where qid=$qid and flow != 0";
		$result2=DB::getInstance()->query($sq2);
	        if($result2){
                        $j=0; $q2=0;
	        	foreach($result2->results() as $v2){
                           $q2=$v2->pqid; $opv2 = $v2->opval;
                           if($j > 0) $str2 .= ",";
                           $str2 .= $opv2;
                           $j++;
                        }
                       $arr['cqid'] = $q2;
                       $arr['c'] = $str2;
                }
                else{
                       $arr['cqid'] = '';
                       $arr['c'] = '';
                }
                return $arr;
    	}

?>

</div>
</body>
