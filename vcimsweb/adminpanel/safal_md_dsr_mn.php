<?php
include_once('../init.php');
include_once('../functions.php');

if(!Session::exists('suser'))
{
	Redirect::to('login_fp.php');
}
?>

<center>
<h2>Safal Montly Audit Summary Report</h2>
<table border='1' cellpadding='0' cellspacing='0' style='margin-left:75px'>
<form action="" method=post>
<tr><td>Month : </td><td><select name=mn id=mn><option value=1>Jan </option><option value=2>Feb </option><option value=3>Mar </option><option value=4>Apr </option><option value=5>May </option><option value=6>Jun </option><option value=7>Jul </option><option value=8>Aug </option><option value=9>Sep </option><option value=10>Oct </option><option value=11>Nov </option><option value=12>Dec </option> </select>
 </td><td><input type=submit name=sreport value=View> </td></tr>
</form>

</table>


<?php
if(isset($_POST['sreport']))
{
     $m=$_POST['mn'];

     $iav=DB::getInstance()->query("SELECT count(distinct `resp_id`) as cnt FROM  `EMPIRE_50` WHERE  month(`i_date_50`) = $m AND `shift_50` !=''");
     if($iav->count()>0)
     {        $cnt=$iav->first()->cnt;
              echo "<br><b>Total Booth Audit Done : <font color=red>$cnt</font> for month: <font color=red> $m </font></b><br><br>";
     }
     //$qr="SELECT distinct `resp_id`,`centre_50`,`shift_50` FROM  `EMPIRE_50` WHERE  month(`i_date_50`) =  $m AND  `centre_50` !=  '' order by resp_id";
     $dc=DB::getInstance()->query("SELECT distinct `resp_id`,`centre_50`,`shift_50` FROM  `EMPIRE_50` WHERE  month(`i_date_50`) =  $m AND  `shift_50` !='' order by resp_id");
     if($dc->count()>0)
     {        
              
              echo "<table border='1' cellpadding='0' cellspacing='0'><tr bgcolor=lightgray><td>Booth</td><td>Centre</td><td>Shift</td></tr>";
              foreach($dc->results() as $d)
              {
                    $rid=$d->resp_id; $c=$d->centre_50; $s=$d->shift_50;
                    $cn='';$sh='';
                    if($c==1)
                        $cn="Delhi";
                    if($c==2)
                        $cn="Gurgoan";
                    if($c==3)
                        $cn="Noida";
                    if($c==4)
                        $cn="Faridabad";
                    if($c==5)
                        $cn="Gaziabad";
   
                    if($s==1)
                        $sh="<font color=red>Morning</font>";
                    if($s==2)
                        $sh="Evening";
                    
                    echo "<tr><td>$rid</td><td>$cn</td><td>$sh</td></tr>";

              }
              echo "</table>";
 
     }

}