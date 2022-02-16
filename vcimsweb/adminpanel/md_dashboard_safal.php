<?php
include_once('../init.php');
include_once('../functions.php');

if(!Session::exists('user_id'))
{
	//Redirect::to('login_fp.php');
   
}
date_default_timezone_set("Asia/Kolkata");


if(isset($_POST['view']))
{
    	$rg=$_POST['rg'];$m=$_POST['month'];$dt=$_POST['dt'];$sc=$_POST['sc']; $cond=" resp_id in (SELECT `b_id` FROM `safal_list`) AND month(i_date_50)=1 ";

        if($rg!='' && $m!='' && $dt!='' && $sc!='')
        { 
               if($rg==0 && $m!='' && $dt!='' && $sc!='')
               {
                     
                     if($dt==0)
                     {
                         $cond=" resp_id in (SELECT `b_id` FROM `safal_list` WHERE `cat_code` in ($sc) ) AND month(i_date_50)=$m ";
                        if($sc==0) $cond=" resp_id in (SELECT `b_id` FROM `safal_list` WHERE  month(i_date_50)=$m ";
                     }
                     if($dt>0)
                     {
                        $cond=" resp_id in (SELECT `b_id` FROM `safal_list` WHERE `cat_code` in ($sc) ) AND month(i_date_50)=$m AND day(i_date_50)=$dt";
                        if($sc==0) $cond=" resp_id in (SELECT `b_id` FROM `safal_list` WHERE month(i_date_50)=$m AND day(i_date_50)=$dt";
                     }
               }
               if($rg>0 && $m!='' && $dt!='' && $sc!='')
               {
                     if($dt==0)
                     {
                        $cond=" resp_id in (SELECT `b_id` FROM `safal_list` WHERE `cat_code` in ($sc) AND bcentre_id=$rg) AND month(i_date_50)=$m ";
                        if($sc==0)$cond=" resp_id in (SELECT `b_id` FROM `safal_list` WHERE  bcentre_id=$rg) AND month(i_date_50)=$m ";
                     }
                     if($dt>0)
                     {
                        $cond=" resp_id in (SELECT `b_id` FROM `safal_list` WHERE `cat_code` in ($sc) AND bcentre_id=$rg) AND month(i_date_50)=$m AND day(i_date_50)=$dt";
                        if($sc==0) $cond=" resp_id in (SELECT `b_id` FROM `safal_list` WHERE bcentre_id=$rg) AND month(i_date_50)=$m AND day(i_date_50)=$dt";
                     }
               }

              $_SESSION['fcond']=$cond;

              $SKUs=array("cq1d1_50","cq1d2_50","cq1d3_50","cq1d4_50","cq1d5_50","cq1d6_50","cq1d7_50","cq1d8_50","cq1d9_50","cq1d10_50","cq1d11_50","cq1d12_50","cq1d13_50","cq1d14_50","cq1d15_50","cq1d16_50","cq1d17_50","cq1d18_50","cq1d19_50","cq1d20_50","cq1d21_50","cq1d22_50","cq1d23_50","cq1d24_50","cq1d25_50","cq1d26_50","cq1d27_50","cq1d28_50","cq1d29_50","cq1d30_50","cq1d31_50","cq1d32_50","cq1d33_50","cq1d34_50","cq1d35_50","cq1d36_50","cq1d37_50","cq1d38_50","cq1d39_50","cq1d40_50",);

              foreach($SKUs as $sk)
              { $yct=0;$nct=0;$tct=0; 
                //echo "<br>SELECT  count($sk) as cntr FROM  `EMPIRE_50` WHERE $sk >0 AND resp_id in (SELECT  distinct resp_id FROM  `EMPIRE_50` WHERE $sk !='' order by resp_id)";
                  // echo "<br>SELECT  count($sk) as cntr FROM  `EMPIRE_50` WHERE $sk >0 AND $cond";
                $rr=DB::getInstance()->query("SELECT  count($sk) as cntr FROM  `EMPIRE_50` WHERE $sk >0 AND $cond");
     		if($rr->count()>0)
     		{ 
     			$yct=$rr->first()->cntr;
     		}  
                //"SELECT  count(distinct resp_id) as cntr FROM  `EMPIRE_50` WHERE shift_50 is not null "
     		$rr1=DB::getInstance()->query("SELECT  count(distinct resp_id) as cntr FROM  `EMPIRE_50` WHERE shift_50 is not null AND $cond ");
     		if($rr1->count()>0)
     		{ 
     			$tct=$rr1->first()->cntr; 
     		}
     		$nct=$tct-$yct;

     		//echo "<br>T:$tct , Y: $yct , N:$nct <br>";
              }
          }
}
?>
<!html>
<head>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    	<script type="text/javascript">
      	google.load("visualization", "1", {packages:["corechart"]});
      	
      	//google.load('visualization', '1.0', {'packages':['controls']});
      	google.setOnLoadCallback(drawChart);
      	
      	function drawChart() 
      	{
      		
 		var vv1=[];<?php    
     	        	
       		if(!isset($_POST['view']))
                {
                    $cond=" resp_id in (SELECT `b_id` FROM `safal_list`) AND month(i_date_50)=1 ";
                }else if(isset($_POST['view'])){ $cond=$_SESSION['fcond'];}
   $SKUs=array("cq1d1_50","cq1d2_50","cq1d3_50","cq1d4_50","cq1d5_50","cq1d6_50","cq1d7_50","cq1d8_50","cq1d9_50","cq1d10_50","cq1d11_50","cq1d12_50","cq1d13_50","cq1d14_50","cq1d15_50","cq1d16_50","cq1d17_50","cq1d18_50","cq1d19_50","cq1d20_50","cq1d21_50","cq1d22_50","cq1d23_50","cq1d24_50","cq1d25_50","cq1d26_50","cq1d27_50","cq1d28_50","cq1d29_50","cq1d30_50","cq1d31_50","cq1d32_50","cq1d33_50","cq1d34_50","cq1d35_50","cq1d36_50","cq1d37_50","cq1d38_50","cq1d39_50","cq1d40_50",);

              foreach($SKUs as $sk)
              { $yct=0;$nct=0;$tct=0; 
                //"SELECT  count($sk) as cntr FROM  `EMPIRE_50` WHERE $sk >0 AND resp_id in (SELECT  distinct resp_id FROM  `EMPIRE_50` WHERE $sk !='' order by resp_id)";
                $rr=DB::getInstance()->query("SELECT  count($sk) as cntr FROM  `EMPIRE_50` WHERE $sk >0 AND $cond");
     		if($rr->count()>0)
     		{ 
     			$yct=$rr->first()->cntr;
                            if($yct==null)
                            {   
                               $yct= 0;    
                            }
     		}  
                //"SELECT  count(distinct resp_id) as cntr FROM  `EMPIRE_50` WHERE shift_50 is not null";
     		$rr1=DB::getInstance()->query("SELECT  count(distinct resp_id) as cntr FROM  `EMPIRE_50` WHERE shift_50 is not null AND $cond");
     		if($rr1->count()>0)
     		{ 
     			$tct=$rr1->first()->cntr; 
                        if($tct==null)
                            {   
                               $tct= 0;    
                            }
     		}
     		$nct=$tct-$yct;

     		//echo "<br>T:$tct , Y: $yct , N:$nct <br>";
     		$arr=array(array('Y','N'),array('Yes',$yct),array('No',$nct));
     		$out = array_values($arr);
		//echo json_encode($out, JSON_NUMERIC_CHECK);
                
                $tmp=json_encode($out, JSON_NUMERIC_CHECK);
                ?>

                vv1.push(<?php echo $tmp; ?>); <?php
                 
             }
                ?>  
                

               //for total of sku
                
               var vvt1=[];<?php    
     	        	
       		if(!isset($_POST['view']))
                {
                    $cond=" resp_id in (SELECT `b_id` FROM `safal_list`) AND month(i_date_50)=1 ";
                }else if(isset($_POST['view'])){ $cond=$_SESSION['fcond'];}
   $SKUs=array("cq1d1_50","cq1d2_50","cq1d3_50","cq1d4_50","cq1d5_50","cq1d6_50","cq1d7_50","cq1d8_50","cq1d9_50","cq1d10_50","cq1d11_50","cq1d12_50","cq1d13_50","cq1d14_50","cq1d15_50","cq1d16_50","cq1d17_50","cq1d18_50","cq1d19_50","cq1d20_50","cq1d21_50","cq1d22_50","cq1d23_50","cq1d24_50","cq1d25_50","cq1d26_50","cq1d27_50","cq1d28_50","cq1d29_50","cq1d30_50","cq1d31_50","cq1d32_50","cq1d33_50","cq1d34_50","cq1d35_50","cq1d36_50","cq1d37_50","cq1d38_50","cq1d39_50","cq1d40_50",);

              foreach($SKUs as $sk)
              { $tcount=0;$acount=0;
                
                $rr=DB::getInstance()->query("SELECT  sum($sk) as cntr ,  round(avg($sk),2) as ag FROM  `EMPIRE_50` WHERE $sk!=''  AND $cond");
     		if($rr->count()>0)
     		{ 
     			$tcount=$rr->first()->cntr; $acount=$rr->first()->ag; 
                         if($tcount==null)
                            {   $acount= 0; $tcount= 0;
                                   
                            }
     		}

     		
     		//$arr=array(array('Y','N'),array('Yes',$yct),array('No',$nct));
                $arr=array(array('Total','Tot'),array('Total',$tcount));
                //$arr=array(array('Average','AVG'),array('Average',$acount));
     		$out = array_values($arr);
		//echo json_encode($out, JSON_NUMERIC_CHECK);
                
                $tmp=json_encode($out, JSON_NUMERIC_CHECK);
                ?>

                vvt1.push(<?php echo $tmp; ?>); <?php
                 
             }
                ?>  
                
               //for average of sku
                var vva1=[];
               <?php    
     	        	
       		if(!isset($_POST['view']))
                {
                    $cond=" resp_id in (SELECT `b_id` FROM `safal_list`) AND month(i_date_50)=1 ";
                }else if(isset($_POST['view'])){ $cond=$_SESSION['fcond'];}
   $SKUs=array("cq1d1_50","cq1d2_50","cq1d3_50","cq1d4_50","cq1d5_50","cq1d6_50","cq1d7_50","cq1d8_50","cq1d9_50","cq1d10_50","cq1d11_50","cq1d12_50","cq1d13_50","cq1d14_50","cq1d15_50","cq1d16_50","cq1d17_50","cq1d18_50","cq1d19_50","cq1d20_50","cq1d21_50","cq1d22_50","cq1d23_50","cq1d24_50","cq1d25_50","cq1d26_50","cq1d27_50","cq1d28_50","cq1d29_50","cq1d30_50","cq1d31_50","cq1d32_50","cq1d33_50","cq1d34_50","cq1d35_50","cq1d36_50","cq1d37_50","cq1d38_50","cq1d39_50","cq1d40_50",);

              foreach($SKUs as $sk)
              { $tcount=0;$acount=0;
                
                $rr=DB::getInstance()->query("SELECT  sum($sk) as cntr ,  round(avg($sk),2) as ag FROM  `EMPIRE_50` WHERE $sk!=''  AND $cond");
     		if($rr->count()>0)
     		{ 
     			$tcount=$rr->first()->cntr; $acount=$rr->first()->ag; 
                          
                            if($acount==null)
                            {   $acount= 0; $tcount= 0;
                                   
                            }
     		}

     		
     		//$arr=array(array('Y','N'),array('Yes',$yct),array('No',$nct));
                //$arr=array(array('Total','Tot'),array('Total',$tcount));
                $arr=array(array('Average','AVG'),array('Average',$acount));
     		$out = array_values($arr);
		//echo json_encode($out, JSON_NUMERIC_CHECK);
                
                $tmp=json_encode($out, JSON_NUMERIC_CHECK);
                ?>

                vva1.push(<?php echo $tmp; ?>); 
               <?php
                 
              }
                ?>  
                

                
                //for vv2 posm
                var vv2=[];<?php         	        	
       		
       		
                if(!isset($_POST['view']))
                {
                    $cond=" resp_id in (SELECT `b_id` FROM `safal_list`) AND month(i_date_50)=1 ";
                }
                else if(isset($_POST['view']))
                    { $cond=$_SESSION['fcond'];
                    }
   

                   $POSMs=array("dq1jb1_50","dq1jb2_50","dq1jb3_50","dq1jb4_50","dq1jb5_50","dq1jb6_50","dq1jb7_50","dq1jb8_50","dq1jb9_50","dq1jb10_50");

              foreach($POSMs as $skk)
              { $pyct=0;$pnct=0;$ptct=0;

                //"SELECT  count($skk) as cntr FROM  `EMPIRE_50` WHERE $skk =1 AND resp_id in (SELECT  distinct resp_id FROM  `EMPIRE_50` WHERE shift_50 is not null order by resp_id)";

                $rr=DB::getInstance()->query("SELECT count($skk) as cntr FROM  `EMPIRE_50` WHERE $skk =1 AND  $cond");
     		if($rr->count()>0)
     		{ 
     			$pyct=$rr->first()->cntr;
                        if($pyct==null)
                            {   
                               $pyct= 0;    
                            }
     		} 
                //"SELECT  count($skk) as cntr FROM  `EMPIRE_50` WHERE $skk =2 AND resp_id in (SELECT  distinct resp_id FROM  `EMPIRE_50` WHERE shift_50 is not null order by resp_id)";

     		$rr3=DB::getInstance()->query("SELECT  count($skk) as cntr FROM  `EMPIRE_50` WHERE $skk =2 AND $cond");
     		if($rr3->count()>0)
     		{ 
     			$pnct=$rr3->first()->cntr;
                           if($pnct==null)
                            {   
                               $pnct= 0;    
                            }
     		} 
     		//"SELECT  count(distinct resp_id) as cntr FROM  `EMPIRE_50` WHERE shift_50 is not null";
     		$rr1=DB::getInstance()->query("SELECT  count(distinct resp_id) as cntr FROM  `EMPIRE_50` WHERE  $cond");
     		if($rr1->count()>0)
     		{ 
     			$ptct=$rr1->first()->cntr; 
                         if($ptct==null)
                            {   
                               $ptct= 0;    
                            }
     		}
                   
     		
     		//$pnct=$ptct-$pyct;

     		//echo "<br>T:$tct , Y: $yct , N:$nct <br>"; 
     		$arr1=array(array('Y','N'),array('Yes',$pyct),array('No',$pnct));
     		$out = array_values($arr1);
		//echo json_encode($out, JSON_NUMERIC_CHECK);
                
                $tmp=json_encode($out, JSON_NUMERIC_CHECK);
                ?>

                vv2.push(<?php echo $tmp; ?>); <?php
                 
             }
                ?>  
                
                 //for vv3 for grievances
                var vv3=[];<?php         	        	
       		//$yct=0;$nct=0;$tct=0;

                if(!isset($_POST['view']))
                {
                    $cond=" resp_id in (SELECT `b_id` FROM `safal_list`) AND month(i_date_50)=1 ";
                }else if(isset($_POST['view'])){ $cond=$_SESSION['fcond'];}
   
       		
                   $gs=array(1,2,3,4,5,6,7);

              foreach($gs as $gskk)
              { $gpyct=0;$gpnct=0;$gptct=0;
                //"SELECT  count(fq1_50) as cntr FROM  `EMPIRE_50` WHERE fq1_50 =$gskk AND resp_id in (SELECT  distinct resp_id FROM  `EMPIRE_50` WHERE shift_50 is not null order by resp_id)";
                $rr=DB::getInstance()->query("SELECT  count(fq1_50) as cntr FROM  `EMPIRE_50` WHERE fq1_50 =$gskk AND shift_50 is not null AND $cond");
     		if($rr->count()>0)
     		{ 
     			$gpyct=$rr->first()->cntr;
                        if($gpyct==null)
                            {   
                               $gpyct= 0;    
                            }
     		} 
     		
     		//"SELECT  count(distinct resp_id) as cntr FROM  `EMPIRE_50` WHERE shift_50 is not null"
     		$rr1=DB::getInstance()->query("SELECT  count(distinct resp_id) as cntr FROM  `EMPIRE_50` WHERE shift_50 is not null AND $cond");
     		if($rr1->count()>0)
     		{ 
     			$gptct=$rr1->first()->cntr; 
                        if($gptct==null)
                            {   
                               $gptct= 0;    
                            }
     		}
     		
     		$gpnct=$gptct-$gpyct;

     		//echo "<br>T:$tct , Y: $yct , N:$nct <br>";
     		$arr1=array(array('Y','N'),array('Yes',$gpyct),array('No',$gpnct));
     		$out = array_values($arr1);
		//echo json_encode($out, JSON_NUMERIC_CHECK);
                
                $tmp=json_encode($out, JSON_NUMERIC_CHECK);
                ?>

                vv3.push(<?php echo $tmp; ?>); <?php
                 
             }
                ?>  
                
        
           //alert( vv2);
        	//var data = new google.visualization.arrayToDataTable(JSON.parse(vv));
        	var options = {pieSliceText: 'percentage',width: 500,height: 250,is3D: true,colors: ['lime', 'red']};
        	var options1 = {title: "Bachat poster",is3D: true, vAxis: { viewWindowMode:'explicit',viewWindow:{max:2,min:0.0}},width: 400,height: 250,bar: {groupWidth: "45%"},colors: ['lime', 'red']};
                var options2 = {title: "Scheme poster", is3D: true,vAxis: { viewWindowMode:'explicit',viewWindow:{max:2,min:0.0}},width: 400,height: 250,bar: {groupWidth: "45%"},colors: ['lime', 'red']};
           	var options3 = {title: "Honey Banner", is3D: true,vAxis: { viewWindowMode:'explicit',viewWindow:{max:2,min:0.0}},width: 400,height: 250,bar: {groupWidth: "45%"},colors: ['lime', 'red']};
      		var options4 = {title: "Honey Dispenser",is3D: true, vAxis: { viewWindowMode:'explicit',viewWindow:{max:2,min:0.0}},width: 400,height: 250,bar: {groupWidth: "45%"},colors: ['lime', 'red']};
      		var options5 = {title: "Pulses Banner",is3D: true, vAxis: { viewWindowMode:'explicit',viewWindow:{max:2,min:0.0}},width: 400,height: 250,bar: {groupWidth: "45%"},colors: ['lime', 'red']};
      		var options6 = {title: "Hara Bhara Veg Kabab Banner",is3D: true, vAxis: { viewWindowMode:'explicit',viewWindow:{max:2,min:0.0}},width: 400,height: 250,bar: {groupWidth: "45%"},colors: ['lime', 'red']};
      		var options7 = {title: "Frozen banner",is3D: true, vAxis: { viewWindowMode:'explicit',viewWindow:{max:2,min:0.0}},width: 400,height: 250,bar: {groupWidth: "45%"},colors: ['lime', 'red']};
      		var options8 = {title: "Hara Bhara Veg Kabab Poster",is3D: true, vAxis: { viewWindowMode:'explicit',viewWindow:{max:2,min:0.0}},width: 400,height: 250,bar: {groupWidth: "45%"},colors: ['lime', 'red']};
      		var options9 = {title: "Hara Bhara Veg Kabab Dangler",is3D: true, vAxis: { viewWindowMode:'explicit',viewWindow:{max:2,min:0.0}},width: 400,height: 250,bar: {groupWidth: "45%"},colors: ['lime', 'red']};
      		var options10 = {title: "Peas/Corn flanges",is3D: true, vAxis: { viewWindowMode:'explicit',viewWindow:{max:2,min:0.0}},width: 400,height: 250,bar: {groupWidth: "45%"},colors: ['lime', 'red']};
      		
      		var optionsg1 = {title: "Untimely Supply - Supply did not come on time",pieHole: 0.4, vAxis: { maxValue:100,minValue:0},width: 400,height: 250,bar: {groupWidth: "45%"},colors: ['lime', 'red']};
                var optionsg2 = {title: "Short supply - Received less than ordered ",pieHole: 0.4, vAxis: { viewWindowMode:'explicit',viewWindow:{ maxValue:100,minValue:0}},width: 400,height: 250,bar: {groupWidth: "25%"},colors: ['lime', 'red']};
           	var optionsg3 = {title: "Excess supply - Received more than ordered ", pieHole: 0.4,vAxis: { viewWindowMode:'explicit',viewWindow:{ maxValue:100,minValue:0}},width: 400,height: 250,bar: {groupWidth: "45%"},colors: ['lime', 'red']};
      		var optionsg4 = {title: "Incorrect supply - Did not receive what I ordered",pieHole: 0.4, vAxis: { viewWindowMode:'explicit',viewWindow:{ maxValue:100,minValue:0}},width: 400,height: 250,bar: {groupWidth: "45%"},colors: ['lime', 'red']};
      		var optionsg5 = {title: "Damaged supply - Order received was damaged", pieHole: 0.4, vAxis: { viewWindowMode:'explicit',viewWindow:{ maxValue:100,minValue:0}},width: 400,height: 250,bar: {groupWidth: "45%"},colors: ['lime', 'red']};
      		var optionsg6 = {title: "Unavailability - Order placed was refused due to unavailability",pieHole: 0.4, vAxis: { viewWindowMode:'explicit',viewWindow:{ maxValue:100,minValue:0}},width: 400,height: 250,bar: {groupWidth: "45%"},colors: ['lime', 'red']};
      		var optionsg7 = {title: "Any Others",pieHole: 0.4, vAxis: { viewWindowMode:'explicit',viewWindow:{ maxValue:100,minValue:0}},width: 400,height: 250,bar: {groupWidth: "45%"},colors: ['lime', 'red']};

             var optionst1 = {title: "Total of SKU", vAxis: { viewWindowMode:'explicit',viewWindow:{ maxValue:12000,minValue:0}},width: 300,height: 250,bar: {groupWidth: "25%"},colors: ['orange', 'red'],annotations: {textStyle: {fontSize: 12}} };
      		
             var optionsa1 = {title: "Average of SKU", vAxis: { viewWindowMode:'explicit',viewWindow:{ maxValue:100,minValue:0}},width: 300,height: 250,bar: {groupWidth: "25%"},colors: ['violet', 'red']};
           
        	var arrdata=[];
        	for (i = 0; i < 40; i++) 
        	{
           		arrdata[i] = new google.visualization.arrayToDataTable(vv1[i]);
          	}
                  var arrtdata=[];
        	for (i = 0; i < 40; i++) 
        	{
           		arrtdata[i] = new google.visualization.arrayToDataTable(vvt1[i]);
          	}
                   var arradata=[];
        	for (i = 0; i < 40; i++) 
        	{
           		arradata[i] = new google.visualization.arrayToDataTable(vva1[i]);
          	}

          	var arrdata2=[];
        	for (j = 0; j < 10; j++) 
        	{
           		arrdata2[j] = new google.visualization.arrayToDataTable(vv2[j]);
          	}
          	var arrdata3=[];
        	for (j = 0; j < 7; j++) 
        	{
           		arrdata3[j] = new google.visualization.arrayToDataTable(vv3[j]);
          	}
       		
           	 //var data3 = google.visualization.arrayToDataTable([["yn","cnt"],["No",69],["Yes",55]]);
           	         	
        	 	var chart1 = new google.visualization.PieChart(document.getElementById('chart_div1'));chart1.draw(arrdata[0], options);	         	
	                var chart2 = new google.visualization.PieChart(document.getElementById('chart_div2'));chart2.draw(arrdata[1], options);	         	
	                var chart3 = new google.visualization.PieChart(document.getElementById('chart_div3'));chart3.draw(arrdata[2], options);	         	
	         	var chart4 = new google.visualization.PieChart(document.getElementById('chart_div4'));chart4.draw(arrdata[3], options);	         	
	         	var chart5 = new google.visualization.PieChart(document.getElementById('chart_div5'));chart5.draw(arrdata[4], options);	         	
	         	var chart6 = new google.visualization.PieChart(document.getElementById('chart_div6'));chart6.draw(arrdata[5], options);	         	
	         	var chart7 = new google.visualization.PieChart(document.getElementById('chart_div7'));chart7.draw(arrdata[6], options);	         	
	         	var chart8 = new google.visualization.PieChart(document.getElementById('chart_div8'));chart8.draw(arrdata[7], options);	         	
	         	var chart9 = new google.visualization.PieChart(document.getElementById('chart_div9'));chart9.draw(arrdata[8], options);	         	
	         	var chart10 = new google.visualization.PieChart(document.getElementById('chart_div10'));chart10.draw(arrdata[9], options);	         	
	         	var chart11 = new google.visualization.PieChart(document.getElementById('chart_div11'));chart11.draw(arrdata[10], options);	         	
	         	var chart12 = new google.visualization.PieChart(document.getElementById('chart_div12'));chart12.draw(arrdata[11], options);	         	
	         	var chart13 = new google.visualization.PieChart(document.getElementById('chart_div13'));chart13.draw(arrdata[12], options);	         	
	         	var chart14 = new google.visualization.PieChart(document.getElementById('chart_div14'));chart14.draw(arrdata[13], options);	         	
	         	var chart15 = new google.visualization.PieChart(document.getElementById('chart_div15'));chart15.draw(arrdata[14], options);	         	
	         	var chart16 = new google.visualization.PieChart(document.getElementById('chart_div16'));chart16.draw(arrdata[15], options);	         	
	             	var chart17 = new google.visualization.PieChart(document.getElementById('chart_div17'));chart17.draw(arrdata[16], options);	         	
	                var chart18 = new google.visualization.PieChart(document.getElementById('chart_div18'));chart18.draw(arrdata[17], options);	         	
	                var chart19 = new google.visualization.PieChart(document.getElementById('chart_div19'));chart19.draw(arrdata[18], options);	         	
	         	var chart20 = new google.visualization.PieChart(document.getElementById('chart_div20'));chart20.draw(arrdata[19], options);	         	
	         	var chart21 = new google.visualization.PieChart(document.getElementById('chart_div21'));chart21.draw(arrdata[20], options);	         	
	         	var chart22 = new google.visualization.PieChart(document.getElementById('chart_div22'));chart22.draw(arrdata[21], options);	         	
	         	var chart23 = new google.visualization.PieChart(document.getElementById('chart_div23'));chart23.draw(arrdata[22], options);	         	
	         	var chart24 = new google.visualization.PieChart(document.getElementById('chart_div24'));chart24.draw(arrdata[23], options);	         	
	         	var chart25 = new google.visualization.PieChart(document.getElementById('chart_div25'));chart25.draw(arrdata[24], options);	         	
	         	var chart26 = new google.visualization.PieChart(document.getElementById('chart_div26'));chart26.draw(arrdata[25], options);	         	
	         	var chart27 = new google.visualization.PieChart(document.getElementById('chart_div27'));chart27.draw(arrdata[26], options);	         	
	         	var chart28 = new google.visualization.PieChart(document.getElementById('chart_div28'));chart28.draw(arrdata[27], options);	         	
	         	var chart29 = new google.visualization.PieChart(document.getElementById('chart_div29'));chart29.draw(arrdata[28], options);	         	
	         	var chart30 = new google.visualization.PieChart(document.getElementById('chart_div30'));chart30.draw(arrdata[29], options);	         	
	         	var chart31 = new google.visualization.PieChart(document.getElementById('chart_div31'));chart31.draw(arrdata[30], options);	         	
	         	var chart32 = new google.visualization.PieChart(document.getElementById('chart_div32'));chart32.draw(arrdata[31], options);	         	
	         	var chart33 = new google.visualization.PieChart(document.getElementById('chart_div33'));chart33.draw(arrdata[32], options);	         	
	                var chart34 = new google.visualization.PieChart(document.getElementById('chart_div34'));chart34.draw(arrdata[33], options);	         	
	                var chart35 = new google.visualization.PieChart(document.getElementById('chart_div35'));chart35.draw(arrdata[34], options);	         	
	         	var chart36 = new google.visualization.PieChart(document.getElementById('chart_div36'));chart36.draw(arrdata[35], options);	         	
	         	var chart37 = new google.visualization.PieChart(document.getElementById('chart_div37'));chart37.draw(arrdata[36], options);	         	
	         	var chart38 = new google.visualization.PieChart(document.getElementById('chart_div38'));chart38.draw(arrdata[37], options);	         	
	         	var chart39 = new google.visualization.PieChart(document.getElementById('chart_div39'));chart39.draw(arrdata[38], options);	         	
	         	var chart40 = new google.visualization.PieChart(document.getElementById('chart_div40'));chart40.draw(arrdata[39], options);	     
	         	
	         	var pchart1 = new google.visualization.PieChart(document.getElementById('pchart_div1'));pchart1.draw(arrdata2[0], options1);	         	
	                var pchart2 = new google.visualization.PieChart(document.getElementById('pchart_div2'));pchart2.draw(arrdata2[1], options2);	         	
	                var pchart3 = new google.visualization.PieChart(document.getElementById('pchart_div3'));pchart3.draw(arrdata2[2], options3);	         	
	         	var pchart4 = new google.visualization.PieChart(document.getElementById('pchart_div4'));pchart4.draw(arrdata2[3], options4);	         	
	         	var pchart5 = new google.visualization.PieChart(document.getElementById('pchart_div5'));pchart5.draw(arrdata2[4], options5);	         	
	         	var pchart6 = new google.visualization.PieChart(document.getElementById('pchart_div6'));pchart6.draw(arrdata2[5], options6);	         	
	         	var pchart7 = new google.visualization.PieChart(document.getElementById('pchart_div7'));pchart7.draw(arrdata2[6], options7);	         	
	         	var pchart8 = new google.visualization.PieChart(document.getElementById('pchart_div8'));pchart8.draw(arrdata2[7], options8);	         	
	         	var pchart9 = new google.visualization.PieChart(document.getElementById('pchart_div9'));pchart9.draw(arrdata2[8], options9);	         	
	         	var pchart10 = new google.visualization.PieChart(document.getElementById('pchart_div10'));pchart10.draw(arrdata2[9], options10);
	         	    	
	         var gchart1 = new google.visualization.PieChart(document.getElementById('gchart_div1'));gchart1.draw(arrdata3[0], optionsg1);	         	
	         var gchart2 = new google.visualization.PieChart(document.getElementById('gchart_div2'));gchart2.draw(arrdata3[1], optionsg2);	         	
	         var gchart3 = new google.visualization.PieChart(document.getElementById('gchart_div3'));gchart3.draw(arrdata3[2], optionsg3);	         	
	         var gchart4 = new google.visualization.PieChart(document.getElementById('gchart_div4'));gchart4.draw(arrdata3[3], optionsg4);	         	
	         var gchart5 = new google.visualization.PieChart(document.getElementById('gchart_div5'));gchart5.draw(arrdata3[4], optionsg5);	         	
	         var gchart6 = new google.visualization.PieChart(document.getElementById('gchart_div6'));gchart6.draw(arrdata3[5], optionsg6);	         	
	         var gchart7 = new google.visualization.PieChart(document.getElementById('gchart_div7'));gchart7.draw(arrdata3[6], optionsg7);
        	
         var vt1 = new google.visualization.DataView(arrtdata[0]); vt1.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var tchart1 = new google.visualization.BarChart(document.getElementById('tchart_div1'));tchart1.draw(vt1, optionst1);
         var vt2 = new google.visualization.DataView(arrtdata[1]); vt2.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var tchart2 = new google.visualization.BarChart(document.getElementById('tchart_div2'));tchart2.draw(vt2, optionst1);
         var vt3 = new google.visualization.DataView(arrtdata[2]); vt3.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var tchart3 = new google.visualization.BarChart(document.getElementById('tchart_div3'));tchart3.draw(vt3, optionst1);
         var vt4 = new google.visualization.DataView(arrtdata[3]); vt4.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var tchart4 = new google.visualization.BarChart(document.getElementById('tchart_div4'));tchart4.draw(vt4, optionst1);
         var vt5 = new google.visualization.DataView(arrtdata[4]); vt5.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var tchart5 = new google.visualization.BarChart(document.getElementById('tchart_div5'));tchart5.draw(vt5, optionst1);
         var vt6 = new google.visualization.DataView(arrtdata[5]); vt6.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var tchart6 = new google.visualization.BarChart(document.getElementById('tchart_div6'));tchart6.draw(vt6, optionst1);
         var vt7 = new google.visualization.DataView(arrtdata[6]); vt7.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var tchart7 = new google.visualization.BarChart(document.getElementById('tchart_div7'));tchart7.draw(vt7, optionst1);
         var vt8 = new google.visualization.DataView(arrtdata[7]); vt8.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var tchart8 = new google.visualization.BarChart(document.getElementById('tchart_div8'));tchart8.draw(vt8, optionst1);
         var vt9 = new google.visualization.DataView(arrtdata[8]); vt9.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var tchart9 = new google.visualization.BarChart(document.getElementById('tchart_div9'));tchart9.draw(vt9, optionst1);
         var vt10 = new google.visualization.DataView(arrtdata[9]); vt10.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var tchart10 = new google.visualization.BarChart(document.getElementById('tchart_div10'));tchart10.draw(vt10, optionst1);
         var vt11 = new google.visualization.DataView(arrtdata[10]); vt11.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var tchart11 = new google.visualization.BarChart(document.getElementById('tchart_div11'));tchart11.draw(vt11, optionst1);
         var vt12 = new google.visualization.DataView(arrtdata[11]); vt12.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var tchart12 = new google.visualization.BarChart(document.getElementById('tchart_div12'));tchart12.draw(vt12, optionst1);
         var vt13 = new google.visualization.DataView(arrtdata[12]); vt13.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var tchart13 = new google.visualization.BarChart(document.getElementById('tchart_div13'));tchart13.draw(vt13, optionst1);
         var vt14 = new google.visualization.DataView(arrtdata[13]); vt14.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var tchart14 = new google.visualization.BarChart(document.getElementById('tchart_div14'));tchart14.draw(vt14, optionst1);
         var vt15 = new google.visualization.DataView(arrtdata[14]); vt15.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var tchart15 = new google.visualization.BarChart(document.getElementById('tchart_div15'));tchart15.draw(vt15, optionst1);
         var vt16 = new google.visualization.DataView(arrtdata[15]); vt16.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var tchart16 = new google.visualization.BarChart(document.getElementById('tchart_div16'));tchart16.draw(vt16, optionst1);
         var vt17 = new google.visualization.DataView(arrtdata[16]); vt17.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var tchart17 = new google.visualization.BarChart(document.getElementById('tchart_div17'));tchart17.draw(vt17, optionst1);
         var vt18 = new google.visualization.DataView(arrtdata[17]); vt18.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var tchart18 = new google.visualization.BarChart(document.getElementById('tchart_div18'));tchart18.draw(vt18, optionst1);
         var vt19 = new google.visualization.DataView(arrtdata[18]); vt19.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var tchart19 = new google.visualization.BarChart(document.getElementById('tchart_div19'));tchart19.draw(vt19, optionst1);
         var vt20 = new google.visualization.DataView(arrtdata[19]); vt20.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var tchart20 = new google.visualization.BarChart(document.getElementById('tchart_div20'));tchart20.draw(vt20, optionst1);
         var vt21 = new google.visualization.DataView(arrtdata[20]); vt21.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var tchart21 = new google.visualization.BarChart(document.getElementById('tchart_div21'));tchart21.draw(vt21, optionst1);
         var vt22 = new google.visualization.DataView(arrtdata[21]); vt22.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var tchart22 = new google.visualization.BarChart(document.getElementById('tchart_div22'));tchart22.draw(vt22, optionst1);
         var vt23 = new google.visualization.DataView(arrtdata[22]); vt23.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var tchart23 = new google.visualization.BarChart(document.getElementById('tchart_div23'));tchart23.draw(vt23, optionst1);
         var vt24 = new google.visualization.DataView(arrtdata[23]); vt24.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var tchart24 = new google.visualization.BarChart(document.getElementById('tchart_div24'));tchart24.draw(vt24, optionst1);
         var vt25 = new google.visualization.DataView(arrtdata[24]); vt25.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var tchart25 = new google.visualization.BarChart(document.getElementById('tchart_div25'));tchart25.draw(vt25, optionst1);
         var vt26 = new google.visualization.DataView(arrtdata[25]); vt26.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var tchart26 = new google.visualization.BarChart(document.getElementById('tchart_div26'));tchart26.draw(vt26, optionst1);
         var vt27 = new google.visualization.DataView(arrtdata[26]); vt27.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var tchart27 = new google.visualization.BarChart(document.getElementById('tchart_div27'));tchart27.draw(vt27, optionst1);
         var vt28 = new google.visualization.DataView(arrtdata[27]); vt28.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var tchart28 = new google.visualization.BarChart(document.getElementById('tchart_div28'));tchart28.draw(vt28, optionst1);
         var vt29 = new google.visualization.DataView(arrtdata[28]); vt29.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var tchart29 = new google.visualization.BarChart(document.getElementById('tchart_div29'));tchart29.draw(vt29, optionst1);
         var vt30 = new google.visualization.DataView(arrtdata[29]); vt30.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var tchart30 = new google.visualization.BarChart(document.getElementById('tchart_div30'));tchart30.draw(vt30, optionst1);
         var vt31 = new google.visualization.DataView(arrtdata[30]); vt31.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var tchart31 = new google.visualization.BarChart(document.getElementById('tchart_div31'));tchart31.draw(vt31, optionst1);
         var vt32 = new google.visualization.DataView(arrtdata[31]); vt32.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var tchart32 = new google.visualization.BarChart(document.getElementById('tchart_div32'));tchart32.draw(vt32, optionst1);
         var vt33 = new google.visualization.DataView(arrtdata[32]); vt33.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var tchart33 = new google.visualization.BarChart(document.getElementById('tchart_div33'));tchart33.draw(vt33, optionst1);
         var vt34 = new google.visualization.DataView(arrtdata[33]); vt34.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var tchart34 = new google.visualization.BarChart(document.getElementById('tchart_div34'));tchart34.draw(vt34, optionst1);
         var vt35 = new google.visualization.DataView(arrtdata[34]); vt35.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var tchart35 = new google.visualization.BarChart(document.getElementById('tchart_div35'));tchart35.draw(vt35, optionst1);
         var vt36 = new google.visualization.DataView(arrtdata[35]); vt36.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var tchart36 = new google.visualization.BarChart(document.getElementById('tchart_div36'));tchart36.draw(vt36, optionst1);
         var vt37 = new google.visualization.DataView(arrtdata[36]); vt37.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var tchart37 = new google.visualization.BarChart(document.getElementById('tchart_div37'));tchart37.draw(vt37, optionst1);
         var vt38 = new google.visualization.DataView(arrtdata[37]); vt38.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var tchart38 = new google.visualization.BarChart(document.getElementById('tchart_div38'));tchart38.draw(vt38, optionst1);
         var vt39 = new google.visualization.DataView(arrtdata[38]); vt39.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var tchart39 = new google.visualization.BarChart(document.getElementById('tchart_div39'));tchart39.draw(vt39, optionst1);
         var vt40 = new google.visualization.DataView(arrtdata[39]); vt40.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var tchart40 = new google.visualization.BarChart(document.getElementById('tchart_div40'));tchart40.draw(vt40, optionst1);

           //---for sku avg
                   var at1 = new google.visualization.DataView(arradata[0]); at1.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var achart1 = new google.visualization.BarChart(document.getElementById('achart_div1'));achart1.draw(at1, optionsa1);
         var at2 = new google.visualization.DataView(arradata[1]); at2.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var achart2 = new google.visualization.BarChart(document.getElementById('achart_div2'));achart2.draw(at2, optionsa1);
         var at3 = new google.visualization.DataView(arradata[2]); at3.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var achart3 = new google.visualization.BarChart(document.getElementById('achart_div3'));achart3.draw(at3, optionsa1);
         var at4 = new google.visualization.DataView(arradata[3]); at4.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var achart4 = new google.visualization.BarChart(document.getElementById('achart_div4'));achart4.draw(at4, optionsa1);
         var at5 = new google.visualization.DataView(arradata[4]); at5.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var achart5 = new google.visualization.BarChart(document.getElementById('achart_div5'));achart5.draw(at5, optionsa1);
         var at6 = new google.visualization.DataView(arradata[5]); at6.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var achart6 = new google.visualization.BarChart(document.getElementById('achart_div6'));achart6.draw(at6, optionsa1);
         var at7 = new google.visualization.DataView(arradata[6]); at7.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var achart7 = new google.visualization.BarChart(document.getElementById('achart_div7'));achart7.draw(at7, optionsa1);
         var at8 = new google.visualization.DataView(arradata[7]); at8.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var achart8 = new google.visualization.BarChart(document.getElementById('achart_div8'));achart8.draw(at8, optionsa1);
         var at9 = new google.visualization.DataView(arradata[8]); at9.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var achart9 = new google.visualization.BarChart(document.getElementById('achart_div9'));achart9.draw(at9, optionsa1);
         var at10 = new google.visualization.DataView(arradata[9]); at10.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var achart10 = new google.visualization.BarChart(document.getElementById('achart_div10'));achart10.draw(at10, optionsa1);
         var at11 = new google.visualization.DataView(arradata[10]); at11.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var achart11 = new google.visualization.BarChart(document.getElementById('achart_div11'));achart11.draw(at11, optionsa1);
         var at12 = new google.visualization.DataView(arradata[11]); at12.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var achart12 = new google.visualization.BarChart(document.getElementById('achart_div12'));achart12.draw(at12, optionsa1);
         var at13 = new google.visualization.DataView(arradata[12]); at13.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var achart13 = new google.visualization.BarChart(document.getElementById('achart_div13'));achart13.draw(at13, optionsa1);
         var at14 = new google.visualization.DataView(arradata[13]); at14.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var achart14 = new google.visualization.BarChart(document.getElementById('achart_div14'));achart14.draw(at14, optionsa1);
         var at15 = new google.visualization.DataView(arradata[14]); at15.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var achart15 = new google.visualization.BarChart(document.getElementById('achart_div15'));achart15.draw(at15, optionsa1);
         var at16 = new google.visualization.DataView(arradata[15]); at16.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var achart16 = new google.visualization.BarChart(document.getElementById('achart_div16'));achart16.draw(at16, optionsa1);
         var at17 = new google.visualization.DataView(arradata[16]); at17.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var achart17 = new google.visualization.BarChart(document.getElementById('achart_div17'));achart17.draw(at17, optionsa1);
         var at18 = new google.visualization.DataView(arradata[17]); at18.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var achart18 = new google.visualization.BarChart(document.getElementById('achart_div18'));achart18.draw(at18, optionsa1);
         var at19 = new google.visualization.DataView(arradata[18]); at19.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var achart19 = new google.visualization.BarChart(document.getElementById('achart_div19'));achart19.draw(at19, optionsa1);
         var at20 = new google.visualization.DataView(arradata[19]); at20.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var achart20 = new google.visualization.BarChart(document.getElementById('achart_div20'));achart20.draw(at20, optionsa1);
         var at21 = new google.visualization.DataView(arradata[20]); at21.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var achart21 = new google.visualization.BarChart(document.getElementById('achart_div21'));achart21.draw(at21, optionsa1);
         var at22 = new google.visualization.DataView(arradata[21]); at22.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var achart22 = new google.visualization.BarChart(document.getElementById('achart_div22'));achart22.draw(at22, optionsa1);
         var at23 = new google.visualization.DataView(arradata[22]); at23.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var achart23 = new google.visualization.BarChart(document.getElementById('achart_div23'));achart23.draw(at23, optionsa1);
         var at24 = new google.visualization.DataView(arradata[23]); at24.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var achart24 = new google.visualization.BarChart(document.getElementById('achart_div24'));achart24.draw(at24, optionsa1);
         var at25 = new google.visualization.DataView(arradata[24]); at25.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var achart25 = new google.visualization.BarChart(document.getElementById('achart_div25'));achart25.draw(at25, optionsa1);
         var at26 = new google.visualization.DataView(arradata[25]); at26.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var achart26 = new google.visualization.BarChart(document.getElementById('achart_div26'));achart26.draw(at26, optionsa1);
         var at27 = new google.visualization.DataView(arradata[26]); at27.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var achart27 = new google.visualization.BarChart(document.getElementById('achart_div27'));achart27.draw(at27, optionsa1);
         var at28 = new google.visualization.DataView(arradata[27]); at28.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var achart28 = new google.visualization.BarChart(document.getElementById('achart_div28'));achart28.draw(at28, optionsa1);
         var at29 = new google.visualization.DataView(arradata[28]); at29.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var achart29 = new google.visualization.BarChart(document.getElementById('achart_div29'));achart29.draw(at29, optionsa1);
         var at30 = new google.visualization.DataView(arradata[29]); at30.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var achart30 = new google.visualization.BarChart(document.getElementById('achart_div30'));achart30.draw(at30, optionsa1);
         var at31 = new google.visualization.DataView(arradata[30]); at31.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var achart31 = new google.visualization.BarChart(document.getElementById('achart_div31'));achart31.draw(at31, optionsa1);
         var at32 = new google.visualization.DataView(arradata[31]); at32.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var achart32 = new google.visualization.BarChart(document.getElementById('achart_div32'));achart32.draw(at32, optionsa1);
         var at33 = new google.visualization.DataView(arradata[32]); at33.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var achart33 = new google.visualization.BarChart(document.getElementById('achart_div33'));achart33.draw(at33, optionsa1);
         var at34 = new google.visualization.DataView(arradata[33]); at34.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var achart34 = new google.visualization.BarChart(document.getElementById('achart_div34'));achart34.draw(at34, optionsa1);
         var at35 = new google.visualization.DataView(arradata[34]); at35.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var achart35 = new google.visualization.BarChart(document.getElementById('achart_div35'));achart35.draw(at35, optionsa1);
         var at36 = new google.visualization.DataView(arradata[35]); at36.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var achart36 = new google.visualization.BarChart(document.getElementById('achart_div36'));achart36.draw(at36, optionsa1);
         var at37 = new google.visualization.DataView(arradata[36]); at37.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var achart37 = new google.visualization.BarChart(document.getElementById('achart_div37'));achart37.draw(at37, optionsa1);
         var at38 = new google.visualization.DataView(arradata[37]); at38.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var achart38 = new google.visualization.BarChart(document.getElementById('achart_div38'));achart38.draw(at38, optionsa1);
         var at39 = new google.visualization.DataView(arradata[38]); at39.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var achart39 = new google.visualization.BarChart(document.getElementById('achart_div39'));achart39.draw(at39, optionsa1);
         var at40 = new google.visualization.DataView(arradata[39]); at40.setColumns([0,1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" }]);
         var achart40 = new google.visualization.BarChart(document.getElementById('achart_div40'));achart40.draw(at40, optionsa1);

	     }    
         </script>
</head>


<body>
<table border=0 style="width: 1303px; height: 267px;"
>
<tr style="width:100%; height:2%"> <td bgcolor=white style="width:5%; height:1%"><img src="../../images/mdlogo.png" height=40px width=80px> </td><td style="width:20%; height:1%"> <font size=4 color=blue><b><center>SAFAL AUDIT DASHBOARD REPORT - EMPIRE</b></font><br><?php echo "<center><font size=2>Date:".date('d-M-Y')."</font></center>"; ?></center></td>
<td style="width:20%; height:10%"><img src="../../images/Digiadmin_logo_final.png" style="float:right;" height=50px width=160px></td></tr>

<tr style="width: 100%; height: 2%;">
<td style="width: 20%; height: 1%;" colspan="2">&nbsp;</td>
<td style="width: 20%; height: 1%;">&nbsp;</td>
</tr>

<form action='' method=post>
<tr style="width:100%; height:8%"> <td colspan=5 bgcolor=skyblue><center>
Zone <select name=rg id=rg onclick="disp_booth();"><option value=0>--all-- </option><option value=1>Delhi</option><option value=2>Gurgoan</option><option value=3>Noida</option><option value=4>Faridabad</option><option value=5>Gaziabad</option></select> 
Month <select name=month id=month><option value=1>Jan</option><option value=2>Feb</option><option value=3>Mar</option><option value=4>Apr</option><option value=5>May</option><option value=6>Jun</option><option value=7>Jul</option><option value=8>Aug</option><option value=9>Sep</option><option value=10>Oct</option><option value=11>Nov</option><option value=12>Dec</option></select> 
Date: <select name=dt id=dt><option value=0>--all-- </option><option value=1>1</option><option value=2>2</option><option value=3>3</option><option value=4>4</option><option value=5>5</option><option value=6>6</option><option value=7>7</option><option value=8>8</option><option value=9>9</option><option value=10>10</option><option value=11>11</option><option value=12>12</option><option value=13>13</option><option value=14>14</option><option value=15>15</option><option value=16>16</option><option value=17>17</option><option value=18>18</option><option value=19>19</option><option value=20>20</option><option value=21>21</option><option value=22>22</option><option value=23>23</option><option value=24>24</option><option value=25>25</option><option value=26>26</option><option value=27>27</option><option value=28>28</option><option value=29>29</option><option value=30>30</option><option value=31>31</option></select>
Sales Category  <select name=sc id=sc><option value=0>All</option><option value=1>0-1499</option><option value=2>10000-27000</option><option value=3>1500-6999</option><option value=4>7000-9999</option></select>
<input type=submit name=view value=View style="color:white;width: 50px;height: 30px;border: solid;border-color:lightblue;cursor: pointer;background-color:#01A9DB;padding:2px 6px;"> 
<input type=reset name=reset value=Reset style="color:white;width: 60px;height: 30px;border: solid;border-color:lightblue;cursor: pointer;background-color:#01A9DB;padding:2px 6px;"> 
</form>

</center></td></tr>
<tr style="width: 100%; height: 2%;">
<td style="width: 20%; height: 1%;" colspan="2"><a href="#posm">POSM & GRIEVANCES</a>&nbsp;&nbsp;<a href="md_dashboard_safal1.php" target="_blank">SKU REMARKS</a></td>
<td style="width: 20%; height: 10%;">&nbsp;</td>
</tr>
<tr><td colspan=6><hr><b>SKU Details</b></td></tr> 
<tr>
<td colspan="4"><div id="sku"></div>
<table border=1 cellpadding=0 cellspacing=0 style="height: 2058px;padding-left: 60px;" width="943">
<tbody>
<tr bgcolor=lightgray>
<td> SKUs                    
   </td>
   <td> SKU Yes/No in %
   </td>
   <td>  Total SKUs        
   </td>
   <td>  Average SKUs 
   </td>
</tr>

<tr>


<?php
	$SKUs=array("cq1d1_50","cq1d2_50","cq1d3_50","cq1d4_50","cq1d5_50","cq1d6_50","cq1d7_50","cq1d8_50","cq1d9_50","cq1d10_50","cq1d11_50","cq1d12_50","cq1d13_50","cq1d14_50","cq1d15_50","cq1d16_50","cq1d17_50","cq1d18_50","cq1d19_50","cq1d20_50","cq1d21_50","cq1d22_50","cq1d23_50","cq1d24_50","cq1d25_50","cq1d26_50","cq1d27_50","cq1d28_50","cq1d29_50","cq1d30_50","cq1d31_50","cq1d32_50","cq1d33_50","cq1d34_50","cq1d35_50","cq1d36_50","cq1d37_50","cq1d38_50","cq1d39_50","cq1d40_50",);
     $r1=DB::getInstance()->query("SELECT  `opt_text_value` ,  `term` ,  `value` FROM  `question_option_detail` WHERE  `q_id` =2785");
     if($r1->count()>0)
     {  $i=0;
        foreach($r1->results() as $r)
	{   
		$cntr=0;$ag=0;
            	$title=$r->opt_text_value; $term=$r->term; $code=$r->value;
            	$sku=$SKUs[$i];
            	
		$rr=DB::getInstance()->query("SELECT  sum($sku) as cntr ,  round(avg($sku),2) as ag FROM  `EMPIRE_50` WHERE $sku !='' ");
     		if($rr->count()>0)
     		{ 
     			$cntr=$rr->first()->cntr; $ag=$rr->first()->ag; 
     		}
     		$i++;
?> 
    <td align=center> <?php echo "<font size=2> $code. $title </font>";?>
                    
   </td>
   <td> 
          <?php echo " <div id='chart_div$i' style='width: 500px; height: 250px;'></div>"; ?>
   </td>
   <td><?php  echo " <div id='tchart_div$i' style='width: 300px; height: 250px;'></div>";?>
        
   </td>
   <td> <?php echo " <div id='achart_div$i' style='width: 300px; height: 250px;'></div>";?> 
   </td>
</tr>

<?php
}
}
?>

</tr>
</tbody>
</table>
</td>
</tr>


<tr><td colspan=6><hr><b>POSM & GRIEVANCE Details</b></td></tr> 
<tr>
<td colspan="4"><div id="posm"></div>  <div id="g"></div>
<table border=1 cellpadding=0 cellspacing=0 style="height: 58px;padding-left: 60px;" width="943">
<tbody>
<tr bgcolor=lightgray><td>POSM with Yes/No in % </td><td>GRIEVANCE with Yes/No in % </td></tr>
<tr>
<?php
	$POSMs=array("dq1jb1_50","dq1jb2_50","dq1jb3_50","dq1jb4_50","dq1jb5_50","dq1jb6_50","dq1jb7_50","dq1jb8_50","dq1jb9_50","dq1jb10_50");
	$posm_list=array("Bachat poster","Scheme poster","Honey banner","Honey dispenser","Pulses banner","Hara Bhara Veg Kabab Banner","Frozen banner","Hara Bhara Veg Kabab Poster","Hara Bhara Veg Kabab Dangler","Peas/Corn flanges");
	$g_list=array("Untimely Supply- Supply did not come on time","Short supply- Received less than ordered ","Excess supply - Received more than ordered","Incorrect supply - Did not receive what I ordered","Damaged supply - Order received was damaged","Unavailability - Order placed was refused due to unavailability","Any Other");
	
     $pi=0;
        foreach($posm_list as $r)
	{      	$pi++;
		
?>

   <td> 
          <?php echo " <div id='pchart_div$pi' style='width: 300px; height: 250px;'></div>"; ?>
   </td>
  
   <td> <?php echo " <div id='gchart_div$pi' style='width: 300px; height: 250px;'></div>"; ?> 
   </td>

</tr>
 <?php
}

?>
</tbody>
</table><center><a href="#sku">Top</a>&nbsp;&nbsp;
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