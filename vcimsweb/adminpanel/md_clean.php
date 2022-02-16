<?php
include_once('../init.php');
include_once('../functions.php');

?>

<html>
<body>
 
<center>
<h2>Daily MotherDairy Data Cleanup</h2>
<table border='1' cellpadding='0' cellspacing='0' style='margin-left:75px'>
<form action="" method=post>

<tr><td>Month </td><td><select name="mn" id="mn" ><option value="0">--Select--</option><option value=4>Apr 2017</option><option value=5>May 2017</option><option value=6>Jun 2017</option><option value=7>July 2017</option><option value=8>Aug 2017</option><option value=9>Sep 2017</option><option value=10>Oct 2017</option><option value=11>Nov 2017</option><option value=12>Dec 2017</option></select></tr>
<tr><td>Booth</td><td><input type=text name=bid id=bid placeholder='Booth ID'> </td></tr>
<tr><td><input type=text name=frid id=frid placeholder='From ID'></td><td><input type=text name=toid id=toid placeholder='To ID'> </td></tr>
<tr><td>Remove Duplicate Data for All Booth </td><td><input type=checkbox name=all id=all value=1> </td></tr>
<tr><td></td><td><input type=submit name=submit value=DELETE> </td></tr>
</form>

</table>

<?php

if(isset($_POST['submit']))
{
        
        $mn=$_POST['mn'];
        $bid=$_POST['bid'];
        $f=$_POST['frid'];
        $t=$_POST['toid'];
        $a=0;
        $yrs=2017;

        if(isset($_POST['all'])) $a=$_POST['all'];
 
echo $a;
     
     if($a==1)
     {
        $r1=DB::getInstance()->query("SELECT distinct `resp_id` FROM  `UMEED2_40` WHERE  month(`visit_month_40`) =  $mn  AND year(`visit_month_40`) =  $yrs  AND `centre_40` !=  '' and resp_id!=111 order by resp_id");
	 if($r1->count()>0)
	 {
	   foreach($r1->results() as $ra)
	   {    
	     $rsp=$ra->resp_id;

          $qa="SELECT min(id) as min, max(id) as max,  `resp_id` FROM  `UMEED2_40` WHERE  month(`visit_month_40`) =  $mn AND year(`visit_month_40`) =  $yrs  AND resp_id=$rsp AND  `centre_40` !=  '' order by id";
          $rs=DB::getInstance()->query($qa);
          if($rs->count() > 0)
          {
              $min=$rs->first()->min; $max=$rs->first()->max;
              if($max > $min)
              {
                 $max--;
                 echo "<br>".$qq="DELETE FROM UMEED2_40 WHERE resp_id=$rsp AND month(`visit_month_40`)=$mn AND year(`visit_month_40`) =  $yrs  AND id BETWEEN $min AND $max ;";
                  DB::getInstance()->query($qq);
              }
          }
        }}
        echo "Duplicate data removed successfully for month=$mn AND year = $yrs";
     }
     else if($a=='')
     {
        if($mn!=0 && $bid!='' && $f!='' && $t!='')
        {   
            
             $qd="DELETE FROM UMEED2_40 WHERE resp_id=$bid AND month(`visit_month_40`)=$mn AND year(`visit_month_40`) = $yrs  AND id BETWEEN $f AND $t";
             DB::getInstance()->query($qd);
             echo "<br><br>Done successfully for booth=$bid AND month=$mn AND year = $yrs AND id BETWEEN $f AND $t";
        } 
        else echo "Something is missing!! Enter all details";
     }
}          

?>

 <script type="text/javascript">
  document.getElementById('mn').value = "<?php echo $_POST['mn'];?>";
  document.getElementById('bid').value = "<?php echo $_POST['bid'];?>";
  document.getElementById('frid').value = "<?php echo $_POST['frid'];?>"; 
  document.getElementById('toid').value = "<?php echo $_POST['toid'];?>";
   
   </script> 