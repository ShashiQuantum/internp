<?php

class MTablet extends CI_Model
{


    public function getDataBySql($sql)
    { 
        
        $query=$this->db->query($sql);
        return $query->result();
    }
    public function doSqlDML($sql)
    { 
        
        $query=$this->db->query($sql);
        return $query;
    }
    public function get_qop_count($qid=null)
    {
              if($qid!=null)
              {
                $this->db->select('count(*) as cnt');
	        $query=$this->db->get_where('question_option_detail',array('q_id' => $qid));
	        $result=$query->row();
	        if($result)
	        	return $result->cnt;
	        else
	        	return false;
             } else return false;
    }
    public function getTabIssueDetails()
    { 
        
        $query=$this->db->query("SELECT `id`, `tab_id`, `i_id`, `p_id`, `work_location`, `issue_by`, `received_by`, `issue_with_charger`, `receive_with_charger`, `issue_date`, `receive_date`, `ta_status`  FROM tab_allocation order by issue_date desc limit 100");
        return $query->result();
    }
    public function getReportTabPermission($pid)
    { 
        
        $query=$this->db->get_where('tab_project_map',array('project_id' => $pid));
        return $query->result();
    }
    public function rgtrResp($tdata)
    {        
        $res=$this->db->insert('tab_project_map',$tdata);
        
        if($res)
          return true;
        else
          return false;
    }
    public function isProjectTabPermission($pid,$tab)
    { 
        $this->db->select('status');
        $query=$this->db->get_where('tab_project_map',array("project_id" => $pid,"tab_id" => $tab));
        $result = $query->row();
                if($result)
                        return true;
                else
			return false;
    }
    public function isProjectMobPermission($pid,$mob)
    { 
        
        $query=$this->db->get_where('tab_project_map',array("project_id" => $pid,"mobile" => $mob));
        return $query->row();
    }
    public function updateRgtrResp($updata,$pid, $tab)
    {        
         $this->db->set($updata);
        $this->db->where( array('project_id'=> $pid ,'tab_id'=>$tab) );
        $res = $this->db->update('tab_project_map');
        if($res)
          return true;
        else
          return false;
        
    }

    public function getTabToIssue()
    { 
        
        $query=$this->db->query("SELECT `tab_id`, `tab_name`, `tab_company`,`tab_status` FROM `vcims_tablets` WHERE `tab_status`=1 AND `tab_id` not in (SELECT `tab_id` FROM tab_allocation WHERE ta_status=0)");
        return $query->result();
    }
    public function get_project_name($pid=null)
    {
       		
       		$this->db->select('name');
	        $query=$this->db->get_where('project',array('project_id' => $pid));
	        $result=$query->row();
	        if($result)
	        	return $result->name;
	        else
	        	return false;
    }
    public function get_tablet_receiver($i_id=null)
    {
       		 
       		$this->db->select('i_name');
	        $query=$this->db->get_where('interviewer_detail',array('i_id' => $i_id));
	        $result=$query->row();
	        if($result)
	        	return $result->i_name;
	        else
	        	return false;
    }
    public function getTabNotReceived()
    { 
        
        $query=$this->db->query("SELECT `id`, `tab_id`, `i_id`, `p_id`, `work_location`, `issue_by`, `received_by`, `issue_with_charger`, `receive_with_charger`, `issue_date`, `receive_date`, `ta_status` FROM tab_allocation WHERE ta_status=0");
        return $query->result();
    }

    public function getProjects()
    { 
        
        $query=$this->db->query('select * from project order by project_id desc');
        return $query->result();
    }

    public function getTab($tid)
    { 
        
        $query=$this->db->get_where('vcims_tablets',array('tab_id' => $tid));
        return $query->row();
    }
    public function getTabs()
    { 
        
        $query=$this->db->get('vcims_tablets');
        return $query->result();
    }
    public function getInterviewer($iid)
    { 
        
        $query=$this->db->get_where('interviewer_detail',array('i_id' => $iid));
        return $query->row();
    }
    public function getInterviewerDetails()
    { 
        
        $query=$this->db->get_where('interviewer_detail');
        return $query->result();
    }
    
    public function isTab($email)
    { 
        
        $query=$this->db->get_where('vcims_tablets',array('tab_email' => $email));
        $res=$query->result();
        if($res)
          return true;
        else
          return false;
    }
    public function isTabIssuedOnce($tid)
    { 
        
        $query=$this->db->get_where('tab_allocation',array('tab_id' => $tid));
        $res=$query->result();
        if($res)
          return true;
        else
          return false;
    }
    public function isTabIssued($tid)
    { 
        
        $query=$this->db->get_where('tab_allocation',array('tab_id' => $tid,'ta_status' => '0'));
        $res=$query->result();
        if($res)
          return true;
        else
          return false;
    }

    public function isTabReceived($tid)
    { 
        
        $query=$this->db->get_where('tab_allocation',array('tab_id' => $tid,'ta_status' => '1'));
        $res=$query->result();
        if($res)
          return true;
        else
          return false;
    }    
    public function addTab($tdata)
    {        
        $res=$this->db->insert('vcims_tablets',$tdata);
        
        if($res)
          return true;
        else
          return false;
    }
    public function issueTab($udata)
    {        
        $res=$this->db->insert('tab_allocation',$udata);
      
        if($res)
          return true;
        else
          return false;
    }
    public function updateIssueTab($tid,$uarr)
    {        
        
        $this->db->set($uarr);
        $this->db->where('tab_id', $tid);
        $res = $this->db->update('tab_allocation');
        if($res)
          return true;
        else
          return false;
    }
    
    //to display project all data row wise per respondent--first call function
    public function getProjectData($pid,$qset=null,$isd=null,$sdt=null,$edt=null)
    {     
                       date_default_timezone_set("Asia/Kolkata");
                       $d=date("d-m-Y H:i:s");
                       
                        
                       //if($isd)
                      // {
                            $sm=(int)date("m",strtotime($sdt)); 
                            $yrs=(int)date("Y",strtotime($sdt));
                            $em=(int)date("m",strtotime($edt));
                      // }
?>
<a href="<?php echo base_url(); ?>welcome/salogout"><i class="fa fa-user"></i> Sign Out</a>
<?php
         if($qset!=0)
         {          
                            echo "<br><center><font color=red>Survey Data of Project ID: $pid </font></center><br><br><br>";

                            $sql1="SELECT  `data_table`  FROM `project` WHERE `project_id`=$pid";
                            $rs1=$this->getDataBySql($sql1);
                            if($rs1)
                            {
                                    foreach($rs1 as $r1)
                                    {
                                       $dtable=$r1->data_table;
                                    }  
                                    //echo $dtable;  
                            }
                 $colms=array();$rdata=array();$mcolms=array();$mcolms2=array();
                 $sql2="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'vcims_12052015' AND TABLE_NAME = '$dtable'";
                 $rs2=$this->getDataBySql($sql2);
                 if($rs2)
                 {
                     foreach($rs2 as $r2)
                     {
                         $cn=$r2->COLUMN_NAME;
                         $qt=$this->getQType($cn);  
                         $qtype=$qt['q_type'];  $qt_id=$qt['q_id'];
                         if($qtype=='checkbox')
                         {
                               array_push($mcolms,$cn);
                               $opc=$this->get_qop_count($qt_id);
                                    for($i=1;$i<=$opc;$i++)
                                    {  
                                        $cn1=$cn.'_'.$i; $dd=substr($cn1, strrpos($cn1, '_') + 1); //echo "<br> $dd=".strlen($dd);
                                        array_push($colms,$cn1);
                                    }
                         }
                         else
			 {   array_push($colms,$cn); }
                          
                     }                         
                 }
                 
                 $colm=array_shift($colms);array_shift($colms);array_shift($colms);
		// print_r($mcolms);
		
		//to display data heading
		$strh= "<center><table border=1 cellpadding='0' cellspacing='0'><tr align=center bgcolor=lightgray><td>S.NO.</td><td>Resp_id</td><td>qset</td>";
		foreach($colms as $cn)
	        {    
	               $strh.="<td>$cn</td>";
	        }
		$strh.="</tr>";
		echo $strh;
	
		 	
			$qr="SELECT distinct resp_id FROM $dtable WHERE q_id=$qset order by resp_id";
		if($isd=='on')
		{	 
                    if($yrs==2016)
                    {
			if($qset==20)
				
                                $qr="SELECT distinct resp_id FROM $dtable WHERE month(visit_month_$qset)=$sm  AND year(visit_month_$qset)=$yrs and resp_id > 727 order by resp_id";
                        if($qset==40)
				$qr="SELECT distinct resp_id FROM $dtable WHERE q_id=$qset and month(visit_month_$qset)=$sm  AND year(visit_month_$qset)=$yrs order by resp_id";
                                
			else
				$qr="SELECT distinct resp_id FROM $dtable WHERE q_id=$qset and month(i_date_$qset)=$sm  AND year(visit_month_$qset)=$yrs order by resp_id";
                    }
                    if($yrs>2016)
                    {
                          $qr="SELECT distinct resp_id FROM $dtable WHERE q_id=$qset AND month(i_date_$qset)=$sm  AND year(i_date_$qset)=$yrs order by resp_id";
                           if($qset==40)
                                $qr="SELECT distinct resp_id FROM $dtable WHERE q_id=$qset AND month(visit_month_$qset)=$sm  AND year(visit_month_$qset)=$yrs order by resp_id"; 
                    }
			
		}
	
		   echo $qr;
                 $rs3=$this->getDataBySql($qr);
                 if($rs3)
                 {   $cnt=0; //print_r($rs3);
                     foreach($rs3 as $rp)
                     {
                          $cnt++;
                          $rsp=$rp->resp_id;
                          //to display one respondent's data details
				$rdata=array();$strr='';
				
				$rdata= $this->get_r_detailm($rsp,$qset,$dtable,$colms,$isd,$sm,$em,$yrs,$mcolms);
				//print_r($rdata);
				$strr= "<tr align=center><td>$cnt</td><td>$rsp</td><td>$qset</td>";
				foreach($rdata as $rd)
			        {    
			               $strr.="<td>$rd</td>";
			        }
				$strr.="</tr>";
				echo $strr;				
                     }
                 }

         }// end of qset check
    }
    public function get_r_detailm($resp=null,$qset=null,$dtable=null,$colmn,$isd=null,$sm=null,$em=null,$yrs=null,$mcolmn)
    {
       		 
	        $rrdata=array();
	                foreach($colmn as $cn)
	                {    $dd='';
                             $dnm=substr($cn, strrpos($cn, '_') + 1); $dlen=strlen($dnm);$dlen=$dlen+1; $dtlen=strlen($cn); 
                             $difflen=$dtlen-$dlen; $cnn=substr($cn,0,$difflen);
 
	                     if($isd==0)
	                     {   $qrr="SELECT $cn as cc FROM $dtable WHERE q_id=$qset AND resp_id =$resp and $cn!=''";
                                 if(in_array($cnn,$mcolmn)) 
                                 {
	                           $qrr="SELECT $cnn as cc FROM $dtable WHERE q_id=$qset AND resp_id =$resp and $cnn!='' AND $cnn='$dnm'";
                                 }
                             }
                             if($isd==1)
                             {
                                    $qrr="SELECT $cn as cc FROM $dtable WHERE q_id=$qset AND resp_id =$resp and $cn!='' and month(i_date_$qset) between $sm and $em";
                                      if($qset!=20 || $qset!=40)
                                      {
                                           if(in_array($cnn,$mcolmn)) 
                                            {
	                                       $qrr="SELECT $cnn as cc FROM $dtable WHERE q_id=$qset AND resp_id =$resp and $cnn!='' AND $cnn='$dnm' and month(visit_month_40) = $sm AND year(visit_month_40)=$yrs";
                                            }
                                      }
                                   if($qset==20 || $qset==40)
                                   {   
                                      if($yrs==2016)
		                      {
                                      	if($sm > 4)
                                        { 	$qrr="SELECT $cn as cc FROM $dtable WHERE resp_id =$resp and $cn!='' and month(visit_month_$qset) = $sm AND year(visit_month_$qset)=$yrs ";
                                        }
                                    	else
                                    	{	$qrr="SELECT $cn as cc FROM vcimstest.$dtable WHERE resp_id =$resp and $cn!='' and month(visit_month_$qset) = $sm AND year(visit_month_$qset)=$yrs ";
                                        }
                                      }
                                      if($yrs>2016)
                                      {
                                      		$qrr="SELECT $cn as cc FROM $dtable WHERE resp_id =$resp and $cn!='' and month(visit_month_40) = $sm AND year(visit_month_40)=$yrs ";
                                            
                                            if(in_array($cnn,$mcolmn)) 
                                            {
	                                       $qrr="SELECT $cnn as cc FROM $dtable WHERE resp_id =$resp and $cnn!='' AND $cnn='$dnm' and month(visit_month_40) = $sm AND year(visit_month_40)=$yrs";
                                            }

                                      }
                                 }
                                 if( $qset==50)
                                 {  $qrr="SELECT $cn as cc FROM $dtable WHERE resp_id =$resp and $cn!='' and month(i_date_50) = $sm AND year(i_date_50)=$yrs ";
                                     if(in_array($cnn,$mcolmn)) 
                                            {
	                                       $qrr="SELECT $cnn as cc FROM $dtable WHERE resp_id =$resp and $cnn!='' AND $cnn='$dnm' and month(i_date_50) = $sm AND year(i_date_50)=$yrs";
                                            }
                                 }    
                             }

                              $rs1=$this->getDataBySql($qrr);
                             if($rs1)
                             {
                                 foreach($rs1 as $r1)
                                 {
	                    
	                            $dd=$r1->cc;
                                 }
			     }
	                     array_push($rrdata,$dd);
	                }
	                return $rrdata;
			
    }
    public function getQType($cn=null)
    {
       		 
	        $query=$this->db->query("SELECT q_id,q_type FROM question_detail where q_id in (SELECT distinct `q_id`  FROM  `question_option_detail` WHERE  `term` =  '$cn')");
	        $results=$query->row();
	        if($results)
	        {	
	        	$qt=$results->q_type; $qn=$results->q_id; $arr=array("q_id"=>$qn,"q_type"=>$qt);
	        	return $arr;
	        	
	        }
	        else
	        	return false;
    }
    public function mdusreport($m=null)
    {
       		 
	        
                       $sql="SELECT count(distinct `resp_id`) as cnt FROM  `UMEED2_40` WHERE  month(`visit_month_40`) = $m AND `centre_40`!=''";
                       $d1=$this->getDataBySql($sql);
                       foreach($d1 as $dd)
                       {  
                          $cnt=$dd->cnt;
                          $sdata="<br><b>Total Booth Audit Done : <font color=red>$cnt</font> for month: <font color=red> $m, 2017</font></b><br><br><table border=1>";
                       }
                       $sql2="SELECT distinct `resp_id`,`centre_40`,`visit_shift_40` FROM  `UMEED2_40` WHERE  month(`visit_month_40`) =  $m AND year(`visit_month_40`) =  2017 AND  `centre_40` !=  '' order by resp_id";
                       $d2=$this->getDataBySql($sql2);
                       foreach($d2 as $d)
                       {  
                          $rid=$d->resp_id; $c=$d->centre_40; $s=$d->visit_shift_40;
                          $cn='';$sh='';
                          if($c==1)$cn="Delhi";
                          if($c==2)$cn="Gurgoan";
                          if($c==3)$cn="Noida";
                          if($c==4)$cn="Faridabad";
                          if($c==5)$cn="Gaziabad";
   
                          if($s==1)$sh="<font color=red>Morning</font>";
                          if($s==2)$sh="Evening";
                    
                         $sdata.="<tr><td>$rid</td><td>$cn</td><td>$sh</td></tr>";
                         
                       }
                       $sdata.="</table>";
                       return $sdata;
    }
    public function mdssreport($m=null)
    {
       		 
	        
                       $sql="SELECT count(distinct `resp_id`) as cnt FROM  `EMPIRE_50` WHERE  month(`i_date_50`) = $m AND `shift_50` !=''";
                       $d1=$this->getDataBySql($sql);
                       foreach($d1 as $dd)
                       {  
                          $cnt=$dd->cnt;
                          $sdata="<br><b>Total Safal Booth Audit Done is: <font color=red>$cnt</font> for month: <font color=red> $m, 2017</font></b><br><br><table border=1>";
                       }
                       $sql2="SELECT distinct `resp_id`,`centre_50`,`shift_50` FROM  `EMPIRE_50` WHERE  month(`i_date_50`) =  $m AND  `shift_50` !='' order by resp_id";
                       $d2=$this->getDataBySql($sql2);
                       foreach($d2 as $d)
                       {  
                          $rid=$d->resp_id; $c=$d->centre_50; $s=$d->shift_50;
                          $cn='';$sh='';
                          if($c==1)$cn="Delhi";
                          if($c==2)$cn="Gurgoan";
                          if($c==3)$cn="Noida";
                          if($c==4)$cn="Faridabad";
                          if($c==5)$cn="Gaziabad";
   
                          if($s==1)$sh="<font color=red>Morning</font>";
                          if($s==2)$sh="Evening";
                    
                         $sdata.="<tr><td>$rid</td><td>$cn</td><td>$sh</td></tr>";
                         
                       }
                       $sdata.="</table>";
                       return $sdata;
    }

    public function mdureport($st,$et,$tab)
    {
       		 
	        
                     if($tab==0)
             $qq="SELECT `booth_id`, `tab_id`, `booth_address`, `sm_mob`, `aud_name`, `aud_mob`, `v_shift`, `centre`,  `i_date`,`e_date`, `qset_id`, `status`, `lattitude`, `longitude` FROM `mdbooth_details` WHERE substring(`i_date`,1,10) BETWEEN '$st' AND '$et'";
             if($tab>0)
              $qq="SELECT `booth_id`, `tab_id`, `booth_address`, `sm_mob`, `aud_name`, `aud_mob`, `v_shift`, `centre`,  `i_date`,`e_date`, `qset_id`, `status`, `lattitude`, `longitude` FROM `mdbooth_details` WHERE tab_id=$tab AND substring(`i_date`,1,10) BETWEEN '$st' AND '$et'";
                     
                      $sdata="<center><h2>Booth Audit Report</h2><table border='1' cellpadding='0' cellspacing='0' style='margin-left:75px'> <tr><td>start_time</td><td>end_time</td><td>booth_id</td><td>booth_address</td><td>booth_mobile</td><td>tab_id</td><td>auditor_name </td><td>auditor_mob</td><td>visit_shift</td><td>status</td></tr>";
                      
                       $d2=$this->getDataBySql($qq);
                       foreach($d2 as $r)
                       {  $sh='';$st='';
                          $long=$r->longitude;
                          $lat=$r->lattitude;
                          $bid=$r->booth_id; $ss=$r->v_shift; if($ss==1)$sh='Morning';if($ss==2)$sh='Evening';
                          $stt=$r->status; if($stt==1)$st='Completed';if($stt==0)$st='Not Completed';
                         $sdata.="<tr><td>$r->i_date</td><td>$r->e_date</td><td> $r->booth_id</td><td>$r->booth_address</td><td>$r->sm_mob</td><td>$r->tab_id</td><td>$r->aud_name </td><td>$r->aud_mob</td><td>$sh</td><td>$st</td><tr>";
                         
                       }
                       $sdata.="</table>";
                       return $sdata;
    }
    
    public function rscore_detail($resp=null,$qset=null,$dtable=null,$colmn,$isd=null,$sm=null,$yrs=null)
    {
    		$rrdata=array(); $r=0; $r2=0; $ascore32=0; $ascore33=0; $ascore31a=0; $ascore31b=0; $ascore31c=0; $ascore17=0;
	                foreach($colmn as $cn)
	                {    $dd='';$ascore=0;
                           
                             //if($cn=='aq31a_40' || $cn=='aq31b_40' || $cn=='aq32_40' || $cn=='aq33_40' )
                                    //continue;
	                     if($isd==0)
	                        $qrr="SELECT $cn as cc FROM $dtable WHERE q_id=$qset AND resp_id =$resp and $cn!=''";
                             if($isd==1)
                             {
                               if($yrs==2016)
                               {
                                  if($qset==20)
                                  {  if($sm > 4)
                                    $qrr="SELECT $cn as cc FROM $dtable WHERE resp_id =$resp and $cn!='' and month(visit_month_$qset) = $sm AND year(visit_month_$qset) = $yrs";
                                    else
                                    $qrr="SELECT $cn as cc FROM vcimstest.$dtable WHERE resp_id =$resp and $cn!='' and month(visit_month_$qset) = $sm AND year(visit_month_$qset) = $yrs";                                    
                                  }
                                 
                                 if($qset==40)
                                 {  if($sm > 7)
                                    $qrr="SELECT $cn as cc FROM $dtable WHERE resp_id =$resp and $cn!='' and month(visit_month_$qset) = $sm AND year(visit_month_$qset) = $yrs"; 
                                 }
                               }
                               if($yrs>2016)
                               {
                                    $qrr="SELECT $cn as cc FROM $dtable WHERE resp_id =$resp and $cn!='' and month(visit_month_$qset) = $sm AND year(visit_month_$qset) = $yrs";
                               }
                             }
     //echo "<br>".$qrr;
	                     $dtr=$this->getDataBySql($qrr);		
			     if($dtr)
			     {   $i=1;
			     	foreach($dtr as $dr)
			     	{   if($i==1)
	                            {  $dd=$dr->cc;
	                               $i++;
	                            }
	                           break;
	                        }
			     }
				  $gp=null;$gw=null;$aw=null;$opr=null;$ascore=0; //echo "resp: $resp<br>dd:". $dd;
				  if($qset==40)
				  {
				     //$rq="SELECT `id`, `q_term`, `group_id`, `grp_wt`, `attr_wt`, `op`, `op_rate` FROM `md_umeed2_attribute` WHERE op=$dd AND q_term='$cn' ";
                                     if($dd!='')
				     $rq="SELECT a1.`q_term`, a1.`group_id`,a1.`op`, a1.`op_rate`, b1.`grp_wt`, b1.`attr_wt`, b1.`month` FROM `md_umeed2_attribute` as a1 JOIN `monthly_umeed2_attribute` as b1 on a1.q_term=b1.q_term WHERE a1.q_term='$cn' AND b1.month=$sm AND b1.yrs=$yrs AND a1.op=$dd";
                                     else
                                         				     $rq="SELECT a1.`q_term`, a1.`group_id`,a1.`op`, a1.`op_rate`, b1.`grp_wt`, b1.`attr_wt`, b1.`month` FROM `md_umeed2_attribute` as a1 JOIN `monthly_umeed2_attribute` as b1 on a1.q_term=b1.q_term WHERE a1.q_term='$cn' AND b1.month=$sm AND b1.yrs=$yrs ";

				  }
				  else $rq="SELECT `id`, `q_term`, `group_id`, `grp_wt`, `attr_wt`, `op`, `op_rate` FROM `md_umeed_attribute` WHERE op=$dd AND q_term='$cn' ";
			  	$re3=$this->getDataBySql($rq);
		  		if($re3)
		  		{
		  			foreach($re3 as $r3)
			     		{
		       				$gp=$r3->group_id; $gw=$r3->grp_wt; $aw=$r3->attr_wt; $op=$r3->op; $opr=$r3->op_rate;
		       			}
		  		} 
		           
		  		$ascore=$opr*$aw;

                          // echo '<br>pushed booth: '.$resp .' term:'.$cn.',resp val:'.$op.' , a rate:'.$aw  .' , attr op rate :'.$opr.' , attr score='.$ascore;    
	                        
                                
                               array_push($rrdata,$ascore); 
	                        if($dd==2 && $cn=='aq31_40')
                                 {        $r=1;   }
                                if($dd==2 && $cn=='aq26_40')
                                 {        $r2=1;   }
                                                 //($cn=='aq32_40' || $cn=='aq33_40' || $cn=='aq31a_40' || $cn=='aq31b_40' || $cn=='aq31c_40')

                                 if($r==1 && ( $cn=='aq32_40' || $cn=='aq33_40' || $cn=='aq31a_40' || $cn=='aq31b_40' || $cn=='aq31c_40' || $cn=='aq17_40'))
                                 {  array_pop($rrdata);
                                    //echo "<br>poped cn: $cn: $ascore ";
                                 } 
                                 if($r2==1 && ( $cn=='aq27_40' || $cn=='aq28_40' || $cn=='aq29_40' || $cn=='aq30_40'))
                                 {  array_pop($rrdata);
                                    //echo "<br>poped cn: $cn: $ascore ";
                                 } 

                               //echo "<br>r==: $r dd==: $dd";
                                 if($r==1 )
                                 { //echo "<br>in.. cnd: $cn: $ascore ";   
                                      
                                     if($cn=='aq31a_40')
                                     {    array_push($rrdata,$ascore31b);  }
                                     if($cn=='aq31b_40')
                                     {    array_push($rrdata,$ascore31b);  }
                                     if($cn=='aq31c_40')
                                      {   array_push($rrdata,$ascore31c);  }
                                     if($cn=='aq17_40')
                                     {    array_push($rrdata,$ascore17);  }
                                 }

	                     if($dd==2)
		             {  
		                if($cn=='aq9_40' ||  $cn=='aq11_40' || $cn=='aq26_40' || $cn == 'aq31_40' || $cn == 'aq16_40' || $cn == 'aq22_40' || $cn == 'aq34_40')
		                {   $arr=  array();
		                    $arr1=  array('aq27_40','aq28_40','aq29_40','aq30_40');     
		                    $arr2=  array('aq32_40','aq33_40','aq31a_40','aq31b_40','aq31c_40');     
		                    $arr3=  array('aq34a_40','aq34b_40');
		                     
		                    if($cn=='aq26_40')
		                        $arr=$arr1;
		                    if($cn=='aq31_40')
		                        $arr=$arr2;
		                    if($cn=='aq34_40')
		                        $arr=$arr3;
		                    if($cn=='aq9_40')
		                        $arr=array('aq10_40');
		                    if($cn=='aq11_40')
		                        $arr=array('aq12_40');
		                    if($cn=='aq16_40')
		                        $arr=array('aq17_40');
		                      
		
		                    foreach($arr as $key=>$val)
		                    { $ascore=0;
		                       
		                        $rsa3=$this->getDataBySql("SELECT a1.`q_term`, a1.`group_id`,a1.`op`, a1.`op_rate`, b1.`grp_wt`, b1.`attr_wt`, b1.`month` FROM `md_umeed2_attribute` as a1 JOIN `monthly_umeed2_attribute` as b1 on a1.q_term=b1.q_term WHERE a1.q_term='$val' AND b1.month=$sm AND b1.yrs=$yrs AND a1.op=$dd ");
		                        if($rsa3)
		                        {
		                        	foreach($rsa3 as $r3)
			     			{
		                                	$gp=$r3->group_id; $gw=$r3->grp_wt; $aw=$r3->attr_wt; $op=''; $opr=1;
		                        	}
		
		                          $ascore=$opr*$aw;
                                          if($val=='aq17_40' || $val=='aq32_40' ||  $val=='aq33_40' || $val=='aq31a_40' || $val == 'aq34b_40' || $val == 'aq31c_40' || $val == 'aq31b_40')
                                          {    //echo "<br>found resp:$resp , $val = $ascore";
                                             
		                                if($val=='aq32_40')
                                                 {    $ascore32=$ascore; array_push($rrdata,$ascore32); }
                                                if($val=='aq33_40')
                                                 {    $ascore33=$ascore; array_push($rrdata,$ascore33); }
                                                if($val=='aq31a_40')
                                                {     $ascore31a==$ascore; }
                                                if($val=='aq31b_40')
                                                 {    $ascore31b=$ascore; }
                                                if($val=='aq31c_40')
                                                 {    $ascore31c=$ascore; }
                                                if($val=='aq17_40')
                                                {     $ascore17=$ascore;  }

                                             //echo '<br>rbooth: '.$resp .' term:'.$val.',resp val:'.$op.' , a rate:'.$aw  .' , attr op rate :'.$opr.' , attr score='.$ascore;
	                    
                                          }
                                          else if($cn!='aq16_40' || $cn!='aq31_40')
                                          { array_push($rrdata,$ascore); 
                                             //echo '<br>pushed erbooth: '.$resp .' term:'.$val.',resp val:'.$op.' , a rate:'.$aw  .' , attr op rate :'.$opr.' , attr score='.$ascore;
                                          }

		                         }
		                    } //enf foreach  
		                }
		                }
                            /*  if($cn!='aq32_40') if($cn!='aq33_40') if($cn!='aq17_40')
                              {
                              //echo "<br>nresp:$resp , $cn = $ascore";
                              
                              array_push($rrdata,$ascore);
                              //echo '<br>e booth: '.$resp .' term:'.$cn.',resp val:'.$op.' , a rate:'.$aw  .' , attr op rate :'.$opr.' , attr score='.$ascore;    
	                    
                              }
                            */

	                } //end of foreach
	                return $rrdata;
    }
    
    public function mdmbreport($mn,$yrs)
    {
         ?>
         <a href="<?php echo base_url(); ?>welcome/salogout"><i class="fa fa-user"></i> Sign Out</a> 
        <?php
           if($mn!=0 && $yrs!=0)
	   {
	             $sdata='';$qset=40;
	          echo "<br><center><font color=red> Project: Umeed2 month=$mn Year=$yrs Booth Attributes Score</font></center><br><br><br>";
	
	                
		      $colms=array();$rdata=array();
	              if($yrs==2016)
	              {
			if($mn >= 8)
	                   $qr="SELECT distinct `q_term` FROM `monthly_umeed2_attribute`  WHERE month=$mn AND yrs=$yrs";
	                      
	                else
			$qr="SELECT distinct `q_term` FROM `md_umeed_attribute`";
		      }
	              if($yrs>2016)
	              {
	                  $qr="SELECT distinct `q_term` FROM `monthly_umeed2_attribute`  WHERE month=$mn AND yrs=$yrs";
	              }
	
			$dtt=$this->getDataBySql($qr);
			
			if($dtt)
			{
				foreach($dtt as $dc)
				{
				   	$cn=$dc->q_term;
					array_push($colms,$cn);
				}
			} 
	
			//print_r($colms);
			
			//to display data heading
			$strh= "<center><table border=1 cellpadding='0' cellspacing='0'><tr align=center bgcolor=lightgray><td>S.NO.</td><td>Resp_id</td><td>qset</td>";
			foreach($colms as $cn)
		        {    
		               $strh.="<td>$cn</td>";
		        }
			$strh.="</tr>";
			echo $strh;
		
			      if($yrs==2016)
	                      {
				if($mn > 4 && $mn < 8)
	                                $qr1="SELECT distinct resp_id FROM UMEED_20 WHERE month(visit_month_20)=$mn  AND year(visit_month_20)=$yrs order by resp_id";
	                        if($mn >= 8)
	                                $qr1="SELECT distinct resp_id FROM UMEED2_40 WHERE month(visit_month_40)=$mn  AND year(visit_month_40)=$yrs order by resp_id";
				if($mn <= 4)
					$qr1="SELECT distinct resp_id FROM vcimstest.UMEED_20 WHERE month(visit_month_20)=$mn  AND year(visit_month_20)=$yrs order by resp_id";
			     }
	                     if($yrs>2016)
	                     {
	                         $qr1="SELECT distinct resp_id FROM UMEED2_40 WHERE month(visit_month_40)=$mn  AND year(visit_month_40)=$yrs order by resp_id";
	                     }
		 	//echo "<br> $qr1";
	        $rrp=$this->getDataBySql($qr1);		
	        if($rrp)
	        { 	$cnt=0;
			foreach($rrp as $rp)
		        {	
		             	$rsp=$rp->resp_id; $cnt++;
				//to display one respondent's data details
				$rdata=array();$strr='';
		              if($yrs==2016)
		              {
				if($mn >= 8)
		                    $rdata= $this->rscore_detail($rsp,40,'UMEED2_40',$colms,1,$mn,$yrs);
		                else
				   $rdata= $this->rscore_detail($rsp,20,'UMEED_20',$colms,1,$mn,$yrs);
		              }
		              if($yrs>2016)
		              {
		                   $rdata= $this->rscore_detail($rsp,40,'UMEED2_40',$colms,1,$mn,$yrs);
		              }		
				 //print_r($rdata);
				$strr= "<tr align=center><td>$cnt</td><td>$rsp</td><td>$qset</td>";
				foreach($rdata as $rd)
			        {    
			               $strr.="<td>$rd</td>";
			        }
				$strr.="</tr>";
				echo $strr;
				//---end of one respondent data details	
			 } //end of foreach
			 //return $sdata;				
		} // end if	
        
	   }   // enf if
    }
    public function mdbsreport($m,$yrs,$g,$b_id)
    {
   	$strb='';$stra='';$t='';$c='';$s='';$b=$b_id;$sdata=''; $sdata1='';
    
	if($g == 0) {$stra="WHERE month=$m AND yrs=$yrs"; $strb='';}
        else if($g > 0){ $stra="WHERE group_id=$g and month=$m  AND yrs=$yrs";  $strb=" AND group_id=$g and month=$m  AND yrs=$yrs";}
  	$booth_score=0;
  	$r0=$this->getDataBySql("SELECT distinct `group_id` FROM `monthly_umeed2_attribute` $stra ");
  	if($r0)
	     foreach($r0 as $r)
	     { 
	     	$booth_g_score=0;
	        $grp=$r->group_id;
                //echo '<br>grp:'.$grp;
	   
	   $qqr1="SELECT distinct `q_term` FROM `monthly_umeed2_attribute`  WHERE group_id=$grp and month=$m AND yrs=$yrs";
	  $r1=$this->getDataBySql($qqr1);
	  if($r1)
	  {
	     foreach($r1 as $ra)
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
	
	
	       	$r2=$this->getDataBySql($eer);
	       	if($r2)
	       	{ 	foreach($r2 as $sa)
	       	        {
	       			$rdata=$sa->$t;
	       		}
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
	 //echo "<br>$er";
	       		$r22=$this->getDataBySql($er);
	       		if($r22 && ($t=='centre_40' || $t=='visit_shift_40'))
	       		     foreach($r22 as $r222)
	       		     {
	       			$c=$r222->centre_40; $s=$r222->visit_shift_40;
	       		     }
	         
	       		$r3=$this->getDataBySql("SELECT a1.`q_term`, a1.`group_id`,a1.`op`, a1.`op_rate`, b1.`grp_wt`, b1.`attr_wt`, b1.`month`, b1.yrs FROM `md_umeed2_attribute` as a1 JOIN `monthly_umeed2_attribute` as b1 on a1.q_term=b1.q_term WHERE a1.q_term='$t' AND b1.month=$m AND b1.yrs=$yrs AND a1.op=$rdata");
	  		if($r3)
	  		{
	  			foreach($r3 as $r)
	  			{
	       			   $gp=$r->group_id; $gw=$r->grp_wt; $aw=$r->attr_wt; $op=$r->op; $opr=$r->op_rate;
	       			}
	  		} 
	 
	  		$ascore=$opr*$aw;
	  		$booth_score=$ascore+$booth_score;
	  		$booth_g_score=$booth_g_score+$ascore;
	  		  $ee= '<br> term:'.$t.',resp val:'.$rdata.' , a rate:'.$aw  .' , attr op rate :'.$opr.' , attr score='.$ascore;
	  		  $sdata1.=$ee;
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
	                       
	                        $r3=$this->getDataBySql("SELECT a1.`q_term`, a1.`group_id`,a1.`op`, a1.`op_rate`, b1.`grp_wt`, b1.`attr_wt`, b1.`month`,b1.yrs FROM `md_umeed2_attribute` as a1 JOIN `monthly_umeed2_attribute` as b1 on a1.q_term=b1.q_term WHERE a1.q_term='$val' AND b1.month=$m AND b1.yrs=$yrs AND a1.op=$rdata ");
	                        if($r3)
	                        {
	                        	foreach($r3 as $r30)
	                        	{
	                                	$gp=$r30->group_id; $gw=$r30->grp_wt; $aw=$r30->attr_wt; $op=''; $opr=1;
	                        	}
	
	                        $ascore=$opr*$aw;
	                        $booth_score=$ascore+$booth_score;
	                        $booth_g_score=$booth_g_score+$ascore;
	                          $sdata1.='<br>a term:'.$val.',resp val:'.$rdata.' , a rate:'.$aw  .' , attr op rate :'.$opr.' , attr score='.$ascore;
	                       }
	                    }  
	                }
	                }           
	  	}
	        
	      }  //end of foreach
	
		//$sdata.="<br>booth group score of id : $b =$booth_g_score";
		
	  } //end of r1
	  	
	  } $sdata.=$sdata1; 
	   $sdata.="<br>booth score of id : $b =".$booth_score;
	  //echo "<br>c:$c s:$s";
	  //echo '<br>'. $iq="INSERT INTO `umeed_dashboard`( `booth_id`, `month`, `centre`, `shift`,grp_id, `grp_score`) VALUES ($b,$m,$c,$s,0,$booth_score);";
	   // /*
	  	$booth_score=0;
	         $sum=0;$avg=0;$cnt=0;
	
	     	$sdata.="<table border=1> <tr><td>BOOTH_ID</td><td>BOOTH SCORE</td> </tr>";
	     	
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
	     		
	     	$b_all=$this->getDataBySql($qa); 
	     	foreach($b_all as $ba)
	     	{    $booth_score=0;
	   		$b_id=$ba->resp_id;$stra="WHERE group_id not in (6,7) and month=$m AND yrs=$yrs order by group_id"; $strb='';$ascore='';
	   		if($g==0) {$stra="WHERE month=$m AND yrs=$yrs order by group_id"; $strb='';}
	        	if($g>0){ $stra=" WHERE group_id=$g and month=$m AND yrs=$yrs "; $strb=" ";}
	        
			  $r1=$this->getDataBySql("SELECT distinct `q_term` FROM `monthly_umeed2_attribute` $stra ");
			  if($r1)
			  {
			     foreach($r1 as $ra)
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
	                       
	
			       	$r2=$this->getDataBySql($eee);
			       	if($r2)
			       	{ 
			       		foreach($r2 as $r20)
			       		{
			       		 $rdata=$r20->$t;
			       		 }
			                 $qqr1="SELECT a1.`q_term`, a1.`group_id`,a1.`op`, a1.`op_rate`, b1.`grp_wt`, b1.`attr_wt`, b1.`month`, b1.yrs FROM `md_umeed2_attribute` as a1 JOIN `monthly_umeed2_attribute` as b1 on a1.q_term=b1.q_term WHERE a1.q_term='$t' AND b1.month=$m AND b1.yrs=$yrs AND a1.op=$rdata";
			                 
			       		$r3=$this->getDataBySql($qqr1);
			  		if($r3)
			  		{
			  			foreach($r3 as $r30)
			  			{
			       			$gp=$r30->group_id; $gw=$r30->grp_wt; $aw=$r30->attr_wt; $op=$r30->op; $opr=$r30->op_rate;
			       			}
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
	                        $r33=$this->getDataBySql("SELECT a1.`q_term`, a1.`group_id`,a1.`op`, a1.`op_rate`, b1.`grp_wt`, b1.`attr_wt`, b1.`month`, b1.yrs FROM `md_umeed2_attribute` as a1 JOIN `monthly_umeed2_attribute` as b1 on a1.q_term=b1.q_term WHERE a1.q_term='$val' AND b1.month=$m AND b1.yrs=$yrs  AND a1.op=$rdata ");
	                        if($r33)
	                        {
	                        	foreach($r33 as $r3x)
	                        	{
	                                $gp=$r3x->group_id; $gw=$r3x->grp_wt; $aw=$r3x->attr_wt; $op=''; $opr=1;
	                               	}
	
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
	   		
			$sdata.="<tr><td>$b_id</td><td>$booth_score</td></tr>";
	     	} //end of foreach
	     	  $sdata.="<br> booth SUM=$sum/$cnt";
	          $sdata.='<br> booth avg='.$sum/$cnt;
	          return $sdata;
	         // */
	          
     }
    public function mdudclean($mn,$bid,$frid,$toid)
    {
        $f=$frid;$t=$toid;
        $a=0;
        $yrs=2017;
        $sdata='';
        if(isset($_POST['all'])) $a=$_POST['all'];

        //echo $a;
     
		     if($a==1)
		     {
		        $r1=$this->getDataBySql("SELECT distinct `resp_id` FROM  `UMEED2_40` WHERE  month(`visit_month_40`) =  $mn  AND year(`visit_month_40`) =  $yrs  AND `centre_40` !=  '' and resp_id!=111 order by resp_id");
			 if($r1)
			 {
			   foreach($r1 as $ra)
			   {    
			     $rsp=$ra->resp_id;
		
		          $qa="SELECT min(id) as min, max(id) as max,  `resp_id` FROM  `UMEED2_40` WHERE  month(`visit_month_40`) =  $mn AND year(`visit_month_40`) =  $yrs  AND resp_id=$rsp AND  `centre_40` !=  '' order by id";
		          $rzs=$this->getDataBySql($qa);
		          if($rzs)
		          {
		              foreach($rzs as $rs)
			      { 
		                $min=$rs->min; $max=$rs->max;
		              }
		
		              if($max > $min)
		              {
		                 $max--;
		 
		                  $qq="DELETE FROM UMEED2_40 WHERE resp_id=$rsp AND month(`visit_month_40`)=$mn AND year(`visit_month_40`) =  $yrs  AND id BETWEEN $min AND $max ;";
		                  $sdata.="<br> $qq";
		                  $this->doSqlDML($qq);
		              }
		          }
		        }}
		        $sdata.="Duplicate data removed successfully for month=$mn AND year = $yrs";
		     }
		     else if($a=='')
		     {
		        if($mn!=0 && $bid!='' && $f!='' && $t!='')
		        {   
		            
		             $qd="DELETE FROM UMEED2_40 WHERE resp_id=$bid AND month(`visit_month_40`)=$mn AND year(`visit_month_40`) = $yrs  AND id BETWEEN $f AND $t";
		             $this->doSqlDML($qd);
		             $sdata.="<br><br>Done successfully for booth=$bid AND month=$mn AND year = $yrs AND id BETWEEN $f AND $t";
		        } 
		        else echo "Something is missing!! Enter all details";
		     }
		     return $sdata;
	} // end of function mdudclean
	
        public function crosstab()
        {

        }	
        public function getviewproject()
        {
              $projects=$this->getProjects();
              
              $str="Project <select name='pid' id='pid' <option value='0'>--Select--</option>";
              foreach($projects as $p)
              {       $pid=$p->project_id; $pn=$p->name;
                     $str.="<option value=$pid > $pn </option>";
              }
              $str.="</select> <input type=submit value=View>";
              return $str;
        }    

}




