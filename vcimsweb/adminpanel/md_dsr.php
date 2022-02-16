<?php
include_once('../init.php');
include_once('../functions.php');

if(!Session::exists('suser'))
{
	Redirect::to('login_fp.php');
}

if(isset($_REQUEST['st']))
{
	$st = $_REQUEST['st'];
}
else
{
	$st = 1;
}   

?>
<html>
<body>

<table cellpadding="10" cellspacing="5">
		<tr>
			<td><a href="md_dsr.php">UMEED2 Daily Audit Report</a></td>
                        <td><a href="md_dsr_map.php">UMEED2 Audit Report with Map</a></td>
			<td><a href="md_dsr_mn.php">UMEED2 Monthly Audit Summary Report</a></td>
			<td><a href="safal_md_dsr_mn.php">SAFAL Monthly Audit Summary Report</a></td>
		</tr></table>
<center>
<h2>Daily Mother Dairy Audit Report</h2>
<table border='1' cellpadding='0' cellspacing='0' style='margin-left:75px'>
<form action="" method=post>
<tr><td>Start Date </td><td><input type=date name=st id=st> </td></tr>

<tr><td>End Date </td><td><input type=date name=et id=et></td></tr>

<tr><td>Tablets </td><td><select name="tab" id="tab" ><option value="0">--All tabs--</option><?php  $pt=get_tabs(); if($pt) foreach($pt as $p){?><option value="<?php echo $p->tab_id; ?>"> <?php echo $p->tab_name;  ?></option> <?php } ?></select></tr>

<tr><td></td><td><input type=submit name=b_report value=View> </td></tr>
</form>

</table>
</center>
<center>
<div id="dashboard_div">
      <!--Divs that will hold each control and chart-->
      <div id="filter_div"></div>
<div id="chart_div" style="width: 800px; height: 400px;"></div>
</div>
<center><br><br>
<?php
 

 if(isset($_POST['b_report']))
  {
        //print_r($_POST);
        $st=$_POST['st'];
        $et=$_POST['et'];
        $tab=$_POST['tab'];

        if($st!='' && $et!='')
        {   
            if($tab==0)
            $qqc="SELECT  substring(`i_date`,1,10) as i_date, count(distinct booth_id) as tot FROM `mdbooth_details` WHERE substring(`i_date`,1,10) BETWEEN '$st' AND '$et' group by substring(`i_date`,1,10)";
            if($tab>0)
            $qqc="SELECT  substring(`i_date`,1,10) as i_date, count(distinct booth_id) as tot FROM `mdbooth_details` WHERE tab_id=$tab AND substring(`i_date`,1,10) BETWEEN '$st' AND '$et' group by substring(`i_date`,1,10)";
            
                ?>


                   <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    	<script type="text/javascript">
      	google.load("visualization", "1", {packages:["corechart"]});
      	
      	//google.load('visualization', '1.0', {'packages':['controls']});
      	google.setOnLoadCallback(drawChart);
      	
      	function drawChart() 
      	{
 		var vv=<?php 
        	$mysqli = new mysqli("localhost", "user1", "vcims@user1", "vcims_12052015");
        	//$mysqli = new mysqli("localhost", "user1", "vcims@user1", "Digiadmin_rfid");
        
     		//$result = $mysqli->query($pstrx);
       		
        
    	if (mysqli_multi_query($mysqli, $qqc)) 
   	{
   	     do 
   	     { $result=mysqli_multi_query($mysqli, $qqc);
       
       		 $results_array = Array(Array());
    		$fillKeys = true;
    		if ($result = mysqli_store_result($mysqli)) 
    		{ 
     			while ($row = $result->fetch_assoc()) 
     			{
        			$temp = Array();
        			foreach ($row as $key => $val)
        			{
            				if ($fillKeys)
            				{
                				$results_array[0][] = $key;
            				}
            				$temp[] = $val;
        			}
        			$results_array[] = $temp;
        			$fillKeys = false;
   		 	}
    		}    if(!mysqli_more_results($mysqli)) break;
    	    } while (mysqli_next_result($mysqli));
      	}
   
    	$jsontable = json_encode($results_array, JSON_NUMERIC_CHECK);
    	//echo $jsontable;
        echo json_encode($jsontable);?> ; 
       	//alert(vv.valueOf());        
          // Create our data table out of JSON data loaded from server.
          
          var data = new google.visualization.arrayToDataTable(JSON.parse(vv));

        var options = {
           
            title: 'Date wise interview count',
            
            pieSliceText: 'value'
            //pieSliceText: 'value-and-percentage'
        };
        
       data.addColumn({type: 'string', role: 'annotation'});

      

 var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options1 = {
        title: "Date wise booth audit count report",
        width: 600,
        height: 400,
        vAxis: {
          title: 'Total Count'
          },
           hAxis: {
          title: 'Booth Audit Date'
          },
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
        
         //var chart = new google.charts.Bar(document.getElementById('chart_div'));
         var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

         google.visualization.events.addListener(chart, 'ready', function () {
      		chart_div.innerHTML = '<img src="' + chart.getImageURI() + '">';
    	});
 
         chart.draw(view, options1);

        var chart1 = new google.visualization.PieChart(document.getElementById('chart_div1'));
	google.visualization.events.addListener(chart1, 'ready', function () {
      		chart_div1.innerHTML = '<img src="' + chart1.getImageURI() + '">';
    	});
        chart1.draw(data, options);
      }
    </script>
    <script type="text/javascript">
  document.getElementById('st').value = "<?php echo $_POST['st'];?>";
  document.getElementById('et').value = "<?php echo $_POST['et'];?>";
  document.getElementById('tab').value = "<?php echo $_POST['tab'];?>"; 
  
   </script> 



<?php

             if($tab==0)
             $qq="SELECT `booth_id`, `tab_id`, `booth_address`, `sm_mob`, `aud_name`, `aud_mob`, `v_shift`, `centre`,  `i_date`,`e_date`, `qset_id`, `status`, `lattitude`, `longitude` FROM `mdbooth_details` WHERE substring(`i_date`,1,10) BETWEEN '$st' AND '$et'";
             if($tab>0)
              $qq="SELECT `booth_id`, `tab_id`, `booth_address`, `sm_mob`, `aud_name`, `aud_mob`, `v_shift`, `centre`,  `i_date`,`e_date`, `qset_id`, `status`, `lattitude`, `longitude` FROM `mdbooth_details` WHERE tab_id=$tab AND substring(`i_date`,1,10) BETWEEN '$st' AND '$et'";

             $dr=DB::getInstance()->query($qq);
             if($dr->count()>0)
             {  echo "<center><h2>Booth Audit Report</h2><table border='1' cellpadding='0' cellspacing='0' style='margin-left:75px'>";
                echo "<tr><td>start_time</td><td>end_time</td><td>booth_id</td><td>booth_address</td><td>booth_mobile</td><td>tab_id</td><td>auditor_name </td><td>auditor_mob</td><td>visit_shift</td><td>status</td></tr>";
                foreach($dr->results() as $r)
                {
                   $long=$r->longitude;
                   $lat=$r->lattitude;
                   $bid=$r->booth_id;

                  echo "<tr><td>$r->i_date</td><td>$r->e_date</td><td> $r->booth_id</td><td>$r->booth_address</td><td>$r->sm_mob</td><td>$r->tab_id</td><td>$r->aud_name </td><td>$r->aud_mob</td><td>$r->v_shift</td><td>$r->status</td><tr>"; 
                 }
              }
         }
  }
 

?>

</body>