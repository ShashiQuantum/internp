<?php
include_once('../init.php');
include_once('../functions.php');
date_default_timezone_set('asia/calcutta');

?>
<br><br>
<form method=post action="">
<center>
<table cellpadding="2" cellspacing="1" border="0" style="font-size:12px;">

<tr><td>Project Name </td><td> <select name="pn" id="pn"  onclick="displib2();"><option value="0">--Select--</option><?php $pj=get_projects_details();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr>
<tr><td>QuestionSet ID </td><td><select name="qset" id="qset"><option value="select">--Select--</option> </select> </td></tr>
<tr><td>Is Date Filter </td><td><input type=checkbox name="isd" id="isd"> </td></tr>
<tr><td>Date Range </td><td><input type=date name="sdt" id="sdt"> To <input type=date name="edt" id="edt"></td></tr>
<tr><td></td><td><input type=submit name=submit value="View"></td></tr>

</table>
</center>
</form>

<?php
if(isset($_POST['submit']))
{
     
   $pid=$_POST['pn'];
   $qset=$_POST['qset'];
   $yrs=0;
   $isd=0;
   if(isset($_POST['isd']))
   	$isd=1;
  // $edt=$_POST['edt'];
   $sm=0;$em=0;
   if(isset($_POST['sdt']))
   {     
       $sm=(int)date("m",strtotime($_POST['sdt'])); 
       $yrs=(int)date("Y",strtotime($_POST['sdt']));
   }
    if(isset($_POST['edt']))
    {
         $em=(int)date("m",strtotime($_POST['edt'])); 
    }
    //echo $yrs;

   if($qset!=0)
   {
          echo "<br><center><font color=red>Survey Data of Project ID: $pid </font></center><br><br><br>";

          $dt=DB::getInstance()->query("SELECT  `data_table`  FROM `project` WHERE `project_id`=$pid");
          if($dt->count()>0)
          {
              echo	"<center>".$dtable=$dt->first()->data_table;
              /*
	       	if($rid=='all' || $rid=='All' || $rid=='ALL')
	            $qr="SELECT * FROM $dtable WHERE q_id=$qset ORDER BY resp_id";
	       	else if($rid!='all' || $rid=='All' || $rid=='ALL'|| $rid !='')
	            $qr="SELECT * FROM $dtable WHERE q_id=$qset AND resp_id in ($rid )";
	       	//$_SESSION['query']=$qr;
	       	*/
		$colmsqno=array(); $colms=array();$rdata=array();$mcolms=array();$mcolms2=array();
		$tbcq="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'vcims' AND TABLE_NAME = '$dtable'";
		$dtt=DB::getInstance()->query($tbcq);
		if($dtt->count()>0)
		{
			foreach($dtt->results() as $dc)
			{
			   	$cn=$dc->COLUMN_NAME;
                                $qtr=get_qtype($cn);
			    if(!empty($qtr)){
                                $qt=$qtr[0]->q_type;
				$qt_id=$qtr[0]->q_id;
				$qno=$qtr[0]->qno;
//echo "<br> $qt_id : $qt : $qno";
                                if($qt=='checkbox')
                                {
				     array_push($mcolms,$cn);

					 //for display qno for each qid
				     $qnnn=$qno;
				     //array_push($colmsqno,$qnnn);

                                    $opc=get_qop_count($qt_id);
                                     //$mcolms[$cn]=$opc ;
                                    //echo $cn,$qt_id,$opc;
                                    for($i=1;$i<=$opc;$i++)
                                    {
                                        $cn1=$cn.'_'.$i; 
					$dd=substr($cn1, strrpos($cn1, '_') + 1); //echo "<br> $dd=".strlen($dd);
                                        array_push($colms,$cn1);

					 //for display qno for each qid
					$qqnn="$qno - $i";
					array_push($colmsqno,$qqnn);
                                    }
                                }
                                else
				{
                                         array_push($colms,$cn);
				     //for display qno for each qid
				    if($qno!=''){
                                     $qnnn="$qno";
                                     array_push($colmsqno,$qnnn);
				    } //end of if 
				}
			     } //end of if
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
//print_r($colmsqno);
                $strhqn= "<tr align=center bgcolor=lightgray><td></td><td></td><td></td>";
                foreach($colmsqno as $cno)
                {
                       $strhqn.="<td>$cno</td>";
                }
                echo $strhqn.="</tr>";


		if($isd==0)	
			$qr="SELECT distinct resp_id FROM $dtable WHERE q_id=$qset order by resp_id";
		if($isd==1)
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
	
		// echo $qr;
        $rrp=DB::getInstance()->query($qr);		
        if($rrp->count()>0)
        { $cnt=0;
	foreach($rrp->results() as $rp)
        {	
             	$rsp=$rp->resp_id; $cnt++;
		//to display one respondent's data details
		$rdata=array();$strr='';
		
		$rdata= r_detailm($rsp,$qset,$dtable,$colms,$isd,$sm,$em,$yrs,$mcolms);
		//print_r($rdata);
		$strr= "<tr align=center><td>$cnt</td><td>$rsp</td><td>$qset</td>";
		foreach($rdata as $rd)
	        {    
	               $strr.="<td>$rd</td>";
	        }
		$strr.="</tr>";
		echo $strr;
		//---end of one respondent data details
		
	 }	
		
	}	
		
		
          }
   }   
         
}

?>
</body>
</html>

<script type="text/javascript">
  document.getElementById('pn').value = "<?php echo $_POST['pn'];?>"; 
  document.getElementById('sdt').value = "<?php echo $_POST['sdt'];?>"; 
  document.getElementById('edt').value = "<?php echo $_POST['edt'];?>";
  document.getElementById('isd').value = "<?php echo $_POST['isd'];?>";
</script>

<script type="text/javascript">

    function displib2()
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
	var val=document.getElementById('pn').value;
        //document.write('Hello: '+val);
	pin.onreadystatechange=function()
	{
		if(pin.readyState==4)
		{
			document.getElementById('qset').innerHTML=pin.responseText;
			console.log(pin);
		}
	}
	url="get_qset.php?pid="+val;
	pin.open("GET",url,true);
	pin.send();
}
</script>
