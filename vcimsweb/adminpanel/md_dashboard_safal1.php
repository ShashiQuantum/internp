<?php
include_once('../init.php');
include_once('../functions.php');
/*
if(!Session::exists('user_id'))
{
	Redirect::to('../../index.php');
   
}
*/
date_default_timezone_set("Asia/Kolkata");

//echo "<center><font size=2>Date:".date('d-M-Y')."</font></center>";


if(isset($_POST['view']))
{
    	//*/ print_r($_POST);

        $rg=$_POST['rg'];$m=$_POST['month'];$dt=$_POST['dt'];$sc=$_POST['sc']; $cond='';

        if($rg!='' && $m!='' && $dt!='' && $sc!='')
        { 
               if($rg==0 && $m!='' && $dt!='' && $sc!='')
               {
                     
                     if($dt==0)
                     {
                        $cond=" resp_id in (SELECT `b_id` FROM `safal_list` WHERE `cat_code` in ($sc) ) AND month(i_date_50)=$m ";
                         if($sc==0)  $cond=" resp_id in (SELECT `b_id` FROM `safal_list`  ) AND month(i_date_50)=$m ";
                     }
                     if($dt>0)
                     {
                        $cond=" resp_id in (SELECT `b_id` FROM `safal_list` WHERE `cat_code` in ($sc) ) AND month(i_date_50)=$m AND day(i_date_50)=$dt";
                         if($sc==0) $cond=" resp_id in (SELECT `b_id` FROM `safal_list`) month(i_date_50)=$m AND day(i_date_50)=$dt";
                     }
               }
               if($rg>0 && $m!='' && $dt!='' && $sc!='')
               {
                     if($dt==0)
                     {
                        $cond=" resp_id in (SELECT `b_id` FROM `safal_list` WHERE `cat_code` in ($sc) AND bcentre_id=$rg) AND month(i_date_50)=$m ";
                         if($sc==0) $cond=" resp_id in (SELECT `b_id` FROM `safal_list` WHERE bcentre_id=$rg) AND month(i_date_50)=$m ";
                     }
                     if($dt>0)
                     {
                        $cond=" resp_id in (SELECT `b_id` FROM `safal_list` WHERE `cat_code` in ($sc) AND bcentre_id=$rg) AND month(i_date_50)=$m AND day(i_date_50)=$dt";
                         if($sc==0)  $cond=" resp_id in (SELECT `b_id` FROM `safal_list` WHERE  bcentre_id=$rg) AND month(i_date_50)=$m AND day(i_date_50)=$dt";
                     }
               }
               

             // $_SESSION['cond']=$cond;$qr='';
    	  $SKUs=array("cq1d1_50","cq1d2_50","cq1d3_50","cq1d4_50","cq1d5_50","cq1d6_50","cq1d7_50","cq1d8_50","cq1d9_50","cq1d10_50","cq1d11_50","cq1d12_50","cq1d13_50","cq1d14_50","cq1d15_50","cq1d16_50","cq1d17_50","cq1d18_50","cq1d19_50","cq1d20_50","cq1d21_50","cq1d22_50","cq1d23_50","cq1d24_50","cq1d25_50","cq1d26_50","cq1d27_50","cq1d28_50","cq1d29_50","cq1d30_50","cq1d31_50","cq1d32_50","cq1d33_50","cq1d34_50","cq1d35_50","cq1d36_50","cq1d37_50","cq1d38_50","cq1d39_50","cq1d40_50",);

$POSMs=array("dq1jb1_50","dq1jb2_50","dq1jb3_50","dq1jb4_50","dq1jb5_50","dq1jb6_50","dq1jb7_50","dq1jb8_50","dq1jb9_50","dq1jb10_50");

    	  $arrList=array();
    	  //$cond="month (i_date_50)=$m";
      
          $rp=DB::getInstance()->query("SELECT distinct resp_id FROM  `EMPIRE_50` WHERE $cond order by resp_id");
          if($rp->count()>0)
          {
           foreach($rp->results() as $resp)
           {  $ar=array();
           	$rid=$resp->resp_id; 
           	$rp2=DB::getInstance()->query("SELECT distinct i_date_50 as dtt, resp_id FROM  `EMPIRE_50` WHERE resp_id=$rid AND month(i_date_50)=$m order by resp_id");
              	if($rp2->count()>0)
              	{ $dt=$rp2->first()->dtt; $ar['dt']=$dt;}
           	$ar['resp']=$rid;
              foreach($SKUs as $sk)
              { 
              	$tot=0; 
              	$q="SELECT sum($sk) as cntr FROM `EMPIRE_50` WHERE $sk >0 AND resp_id = $rid";
                $rr=DB::getInstance()->query($q);
     		if($rr->count()>0)
     		{ 
     			$tot=$rr->first()->cntr;
     		} 
     		if($tot==0 ) $tot=0;
               // echo "<br>$sk ,T: $tot ";
                $ar[$sk]=$tot;
              }
              $ar['gap']='-';

              foreach($POSMs as $po)
              {  $final=0;
                 $q="SELECT $po as pp FROM `EMPIRE_50` WHERE $po=1 AND resp_id = $rid";
                $rr=DB::getInstance()->query($q);
     		if($rr->count()>0)
     		{ 
     			$final=$rr->first()->pp;
     		} 
     		if($final==0 ) $final=2; 
                 
                 $ar[$po]=$final;
              } 
              	array_push($arrList,$ar);
             }
            }
            //print_r($arrList);
        //*/
     	
   
  	}
}
?>
<!html>
<head>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    	      
</head>


<body>
<table border=0 style="width: 1333px; height: 167px;"
>
<tr style="width:100%; height:2%"> <td bgcolor=white style="width:5%; height:1%"><img src="../../images/mdlogo.png" height=40px width=80px> </td><td style="width:20%; height:1%"> <font size=4 color=blue><b><center>SAFAL AUDIT DASHBOARD REPORT - EMPIRE</b></font><br><?php echo "<center><font size=2>Date:".date('d-M-Y')."</font></center>"; ?></center></td>
<td style="width:20%; height:10%"><img src="../../images/Digiadmin_logo_final.png" style="float:right;" height=40px width=160px></td></tr>


<tr> <td colspan=4 bgcolor=skyblue style="padding-left: 160px;"><form action='' method=post>
Zone <select name=rg id=rg onclick="disp_booth();"><option value=0>--all-- </option><option value=1>Delhi</option><option value=2>Gurgoan</option><option value=3>Noida</option><option value=4>Faridabad</option><option value=5>Gaziabad</option></select> 
Month <select name=month id=month><option value=1>Jan</option><option value=2>Feb</option><option value=3>Mar</option><option value=4>Apr</option><option value=5>May</option><option value=6>Jun</option><option value=7>Jul</option><option value=8>Aug</option><option value=9>Sep</option><option value=10>Oct</option><option value=11>Nov</option><option value=12>Dec</option></select> 
Date: <select name=dt id=dt><option value=0>--all-- </option><option value=1>1</option><option value=2>2</option><option value=3>3</option><option value=4>4</option><option value=5>5</option><option value=6>6</option><option value=7>7</option><option value=8>8</option><option value=9>9</option><option value=10>10</option><option value=11>11</option><option value=12>12</option><option value=13>13</option><option value=14>14</option><option value=15>15</option><option value=16>16</option><option value=17>17</option><option value=18>18</option><option value=19>19</option><option value=20>20</option><option value=21>21</option><option value=22>22</option><option value=23>23</option><option value=24>24</option><option value=25>25</option><option value=26>26</option><option value=27>27</option><option value=28>28</option><option value=29>29</option><option value=30>30</option><option value=31>31</option></select>
Sales Category  <select name=sc id=sc><option value=0>--All--</option><option value=1>0-1499</option><option value=2>10000-27000</option><option value=3>1500-6999</option><option value=4>7000-9999</option></select>
<input type=submit name=view value=View style="color:white;width: 50px;height: 30px;border: solid;border-color:lightblue;cursor: pointer;background-color:#01A9DB;padding:2px 6px;"> 
<input type=reset name=reset value=Reset style="color:white;width: 60px;height: 30px;border: solid;border-color:lightblue;cursor: pointer;background-color:#01A9DB;padding:2px 6px;"> 
</form>

</center></td></tr>
<tr style="width: 100%; height: 2%;">
<td style="width: 20%; height: 1%;" colspan="0">&nbsp;</td>
<td style="width: 20%; height: 10%;">&nbsp;</td>
</tr>
<?php if($m!='')
{
?>
<tr><td colspan=4><hr><b>SKU Remarks Details</b></td></tr> 
<tr>
<td colspan="4"><div id="sku"></div>
<table border=1 cellpadding=0 cellspacing=0 style="padding-left: 1px;">
<tbody>
<tr align=center><td colspan=43 bgcolor=lightblue><center>SKU</center></td><td bgcolor=gray></td><td colspan=10 bgcolor=gold><center>POSM</center></td></tr>
<tr bgcolor=lightgray align=center>
<td>S.N.</td><td>AuditDate</td><td>Booth</td> <td>Frozen-Green Peas-1Kg</td><td>Frozen-Green Peas-600/500/ 500gm free HBVK 80gm</td><td>Frozen-Green Peas-200 gm</td><td>Frozen-Sweet Corn-1Kg (R)</td><td>Frozen-Sweet Corn-500 gm</td><td>Frozen-Sweet Corn-200 gm</td><td>Frozen-Mixed Vegetables-500 gm</td><td>Frozen-Mixed Vegetables-200 gm</td><td>Frozen-Aloo Tikki / Navratra Tikki-400 gm</td><td>Frozen-Hara Bhara Kebab-200/(200 & 40) gm</td><td>Pulses-Arhar Dal-1 kg</td><td>Pulses-Chana Dal-1kg</td><td>Pulses-Masoor Dhuli (Malka)-1 kg</td><td>Pulses-Kabuli Chana -1 kg</td><td>Pulses-Moong Dhuli-1 kg</td><td>Pulses-Kala Chana-1 kg</td><td>Pulses-Rajma Chitra-1 kg</td><td> Ambient-Mango Drink-500 ml</td><td>Ambient-Mango Drink-250 ml</td><td>Ambient-Litchi Drink-1 Ltr(Tetra)</td><td>Ambient-Apple Juice-1 Ltr</td><td>Ambient-Tomato Puree-200 gm (Slim Pack)</td><td>Ambient-Mix Fruit drink-1 Ltr.(Tetra Pack)</td><td>Dairy Products-ESL Paneer-200 gm</td><td>Dairy Products-Curd-1 kg</td><td>Dairy Products-Curd polypack-400gm</td><td>Dairy Products-MD Ghee 1L Ceka Pack</td><td>Dairy Products-MD Ghee 1/2L Ceka Pack</td><td> Dairy Products-Cow Ghee 1Ltr.PP</td><td>Dairy Products-Cow Ghee 500ml PP</td><td>Dairy Products-Tadka Chach 400ml</td><td>Dairy Products-Plain Chach 450ml</td><td>Dairy Products-Misti Doi 85gm</td><td>Dairy Products-Butter 100 gm</td><td>Dhara Products-Dhara RSBO 1L PP</td><td>Dhara Products-Dhara RSFO 1L PP</td><td>Outsourced Products-Rajdhani-Besan-500gm</td><td>Outsourced Products-Rajdhani-Poha-500gm</td><td>Outsourced Products-Uttam-Double Refine w/o Sulphur Sugar-1kg</td><td>New Products-Honey-250gm</td><td bgcolor=gray>_</td><td>Bachat Poster</td><td>Scheme Poster</td><td>Honey Banner</td><td>Honey Dispenser</td><td>Pulses Banner</td><td>Hara Bhara Veg Kabab Banner</td><td>Frozen Banner</td><td>Hara Bhara Veg Kabab Poster</td><td>Hara Bhara Veg Kabab Dangler</td><td>Peas/Corn Flanges</td>
</tr>


<?php }
	$i=0;
	if($m!='')
        foreach($arrList as $booth)
	{   
	   // foreach($booth as $key=>$val)
	    //{
	    	$i++;
     		$d1=$booth['dt']; $d=date("d-M-Y", strtotime($d1));
      $r=$booth['resp'];$d1=$booth['cq1d1_50'];$d2=$booth['cq1d2_50'];$d3=$booth['cq1d3_50'];$d4=$booth['cq1d4_50'];$d5=$booth['cq1d5_50'];	
     		$d6=$booth['cq1d6_50'];$d7=$booth['cq1d7_50'];$d8=$booth['cq1d8_50'];$d9=$booth['cq1d9_50'];$d10=$booth['cq1d10_50'];$d11=$booth['cq1d11_50'];
     		$d12=$booth['cq1d12_50'];$d13=$booth['cq1d13_50'];$d14=$booth['cq1d14_50'];$d15=$booth['cq1d15_50'];$d16=$booth['cq1d16_50'];$d17=$booth['cq1d17_50'];
     		$d18=$booth['cq1d18_50'];$d19=$booth['cq1d19_50'];$d20=$booth['cq1d20_50'];$d21=$booth['cq1d21_50'];$d22=$booth['cq1d22_50'];$d23=$booth['cq1d23_50'];
     		$d24=$booth['cq1d24_50'];$d25=$booth['cq1d25_50'];$d26=$booth['cq1d26_50'];$d27=$booth['cq1d27_50'];$d28=$booth['cq1d28_50'];$d29=$booth['cq1d29_50'];
     		$d30=$booth['cq1d30_50'];$d31=$booth['cq1d31_50'];$d32=$booth['cq1d32_50'];$d33=$booth['cq1d33_50'];$d34=$booth['cq1d34_50'];$d35=$booth['cq1d35_50'];
     		$d36=$booth['cq1d36_50'];$d37=$booth['cq1d37_50'];$d38=$booth['cq1d38_50'];$d39=$booth['cq1d39_50'];$d40=$booth['cq1d40_50'];

             $p1=$booth['dq1jb1_50'];$p2=$booth['dq1jb2_50'];$p3=$booth['dq1jb3_50'];$p4=$booth['dq1jb4_50'];$p5=$booth['dq1jb5_50'];
             $p6=$booth['dq1jb6_50'];$p7=$booth['dq1jb7_50'];$p8=$booth['dq1jb8_50'];$p9=$booth['dq1jb9_50'];$p10=$booth['dq1jb10_50'];
?> 

  <tr style="height:10px" align=center>   
          <?php echo "<td>$i</td><td><font color=orange>$d</font></td><td><font color=blue>$r</font></td> <td>$d1</td><td>$d2</td><td>$d3</td><td>$d4</td><td>$d5</td><td>$d6</td><td>$d7</td><td>$d8</td><td>$d9</td><td>$d10</td><td>$d11</td><td>$d12</td><td>$d13</td><td>$d14</td><td>$d15</td><td>$d16</td><td>$d17</td><td>$d18</td><td>$d19</td><td>$d20</td><td>$d21</td><td>$d22</td><td>$d23</td><td>$d24</td><td>$d25</td><td>$d26</td><td>$d27</td><td>$d28</td><td>$d29</td><td>$d30</td><td>$d31</td><td>$d32</td><td>$d33</td><td>$d34</td><td>$d35</td><td>$d36</td><td>$d37</td><td>$d38</td><td>$d39</td><td>$d40</td><td bgcolor=gray>-</td>";
if($p1==1) echo "<td bgcolor=lime>Yes</td>"; else echo "<td bgcolor=red>No</td>";
if($p2==1) echo "<td bgcolor=lime>Yes</td>"; else echo "<td bgcolor=red>No</td>";
if($p3==1) echo "<td bgcolor=lime>Yes</td>"; else echo "<td bgcolor=red>No</td>";
if($p4==1) echo "<td bgcolor=lime>Yes</td>"; else echo "<td bgcolor=red>No</td>";
if($p5==1) echo "<td bgcolor=lime>Yes</td>"; else echo "<td bgcolor=red>No</td>";
if($p6==1) echo "<td bgcolor=lime>Yes</td>"; else echo "<td bgcolor=red>No</td>";
if($p7==1) echo "<td bgcolor=lime>Yes</td>"; else echo "<td bgcolor=red>No</td>";
if($p8==1) echo "<td bgcolor=lime>Yes</td>"; else echo "<td bgcolor=red>No</td>";
if($p9==1) echo "<td bgcolor=lime>Yes</td>"; else echo "<td bgcolor=red>No</td>";
if($p10==1) echo "<td bgcolor=lime>Yes</td>"; else echo "<td bgcolor=red>No</td>";



//<td>$p1</td><td>$p2</td><td>$p3</td><td>$p4</td><td>$p5</td><td>$p6</td><td>$p7</td><td>$p8</td><td>$p9</td>$p10<td></td>"; 

?>
   
</tr>

<?php
//}
}
?>

</tbody>
</table>
</td>
</tr>




<script type="text/javascript">
  document.getElementById('rg').value = "<?php echo $_POST['rg'];?>"; 
  document.getElementById('month').value = "<?php echo $_POST['month'];?>";
  document.getElementById('dt').value = "<?php echo $_POST['dt'];?>";
  document.getElementById('sc').value = "<?php echo $_POST['sc'];?>";
</script>

<style>
submit{	width: 40px;height: 32px;border: none;cursor: pointer;float: right;background-color:#dddddd;padding:2px 6px;}

</style>

</html>