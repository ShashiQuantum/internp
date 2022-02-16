<?php
include_once('../init.php');
include_once('../functions.php');
date_default_timezone_set('asia/calcutta');

?>
<center><h2>Umeed Booth wise Monthly Score</h2>
<br><br>
<form method=post action="">
<center>
<table cellpadding="2" cellspacing="1" border="0" style="font-size:12px;">
<tr><td>Month : </td><td><select name=mn id=mn><option value=0>--Select-- </option><option value=1>Jan</option><option value=2>Feb</option><option value=3>Mar</option><option value=4>Apr</option><option value=5>May</option><option value=6>Jun</option><option value=7>Jul</option><option value=8>Aug</option><option value=9>Sep</option><option value=10>Oct</option><option value=11>Nov </option><option value=12>Dec</option> </select></td></tr>
<tr><td>Year : </td><td><select name=yrs id=yrs><option value=2016>2016</option><option value=2017>2017</option><option value=2018>2018</option></select></td></tr>
<tr><td></td><td><input type=submit name=submit value="View"></td></tr>

</table>
</center>
</form>

<?php
if(isset($_POST['submit']))
{
     
    
   $mn=$_POST['mn'];
   $yrs=$_POST['yrs'];

   if($mn!=0)
   {
          echo "<br><center><font color=red> Project: Umeed month=$mn Attributes Score</font></center><br><br><br>";

                
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

		$dtt=DB::getInstance()->query($qr);
		
		if($dtt->count()>0)
		{
			foreach($dtt->results() as $dc)
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
        $rrp=DB::getInstance()->query($qr1);		
        if($rrp->count()>0)
        { $cnt=0;
	foreach($rrp->results() as $rp)
        {	
             	$rsp=$rp->resp_id; $cnt++;
		//to display one respondent's data details
		$rdata=array();$strr='';
              if($yrs==2016)
              {
		if($mn >= 8)
                    $rdata= rscore_detail($rsp,40,'UMEED2_40',$colms,1,$mn,$yrs);
                else
		   $rdata= rscore_detail($rsp,20,'UMEED_20',$colms,1,$mn,$yrs);
              }
              if($yrs>2016)
              {
                   $rdata= rscore_detail($rsp,40,'UMEED2_40',$colms,1,$mn,$yrs);
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
		
	 }	
		
	}	
		
		
          
   }   
         
}

?>
</body>
</html>

<script type="text/javascript">
  document.getElementById('mn').value = "<?php echo $_POST['mn'];?>"; 
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

<script type="text/javascript">
  document.getElementById('mn').value = "<?php echo $_POST['mn'];?>";
  document.getElementById('yrs').value = "<?php echo $_POST['yrs'];?>";
</script>