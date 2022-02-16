<html>
<head>

 <meta http-equiv="refresh" content=""> 
<title>HABITAT | DASHBOARD </title>
    <link rel="shortcut icon" href="<?php echo base_url();?>public/img/logos/habitat.png" type="image/x-icon"> <!-- Theme CSS & topbar-->

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/agency2.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/agency2.min.css" >
    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/vendor/bootstrap/css/bootstrap.min.css" >
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/my2.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

<style>
</style>

<script>
function refresh()
{
	window.location.reload();
}
function close_window() {
  if (confirm("Close Window?")) {
    window.top.close();
  }
}
  </script>
  <style>
  label {
    display: inline-block;
  }
  </style>
</head>
<body style="overflow: hidden;">
<?php
	$csid;
        $arr=$_SESSION['arr_sid'];
        $ptr=$_SESSION['ptr'];
        $cqset_id=$this->session->userdata('qset_id'); //current qset_id
        $table=$this->MHabitat->getPTable($cqset_id);
        $cqid=$this->MHabitat->get_cqid($cqset_id, $csid); //current question id
        $qtype=$this->MHabitat->get_qtype($cqid);
        $cqno=$this->MHabitat->get_qno($cqid);
        if($qtype=='instruction' || $qtype == 'text' || $qtype == 'textarea'){
            while($qtype!='radio' || $qtype!='checkbox'){
                ++$csid;
                $_SESSION['sid']=$csid;
                $this->session->set_userdata('sid', $csid);
                $csid= $this->session->userdata('sid');
                $cqid=$this->MHabitat->get_cqid($cqset_id, $csid);
                $qtype=$this->MHabitat->get_qtype($cqid);
                if($qtype == 'instruction' || $qtype == 'text' || $qtype == 'textarea') continue;
                else break;
           }
        }
        $_SESSION['sid']=$csid;
        $cterm=$this->MHabitat->get_ctermid($cqid); //current question id
        $cqt=$this->MHabitat->get_cqt($cqid); //current question title
	//$mxsid = $_SESSION['mxsid'];
	$mxsid=end($arr);
	$mxptr=count($arr);
	$ctremc=0;
	if($csid <= $mxsid)
	$ctermc = $this->MHabitat->get_cod_ov($table,$cterm);

?>

<table border="0" style="height:100%; width:100%;">
<tr style="height:10%;">
<td>
    <nav id="mainNav" class="navbar navbar-default navbar-custom navbar-fixed-top" style="background-color:white; border-bottom: 3px solid #DCEDC8;">
<div style="margin-left: 10px;float:left;position: relative;width:75px;"></div>
        <div class="container3" style="margin-left:0px; margin-right:0px;">
            <!-- Brand and toggle get grouped for better mobile display -->
 <a><img src="<?php echo base_url(); ?>public/img/logos/quantum-logo-big.png" style="height:45px; width:100px:float:left"/></a>
 <a><img src="<?php echo base_url(); ?>public/img/logos/habitat.png" style="height:45px; width:250px;float:right;"/></a>
</div>
</div>
</nav>
</td>
</tr>
<tr style="height:2%;"><td>
<?php

$ptr=$_SESSION['ptr'];
//$pctr=count($arr);


if($csid <= $mxsid && $ptr < $mxptr && $ctermc > 0){
?>
	<div style="float:left;margin-left:20px;">
	Total respondends who answered is <font size=5pt><?= $ctermc;?></font>
	</div>
<?php 
}
if($csid <= $mxsid && $ptr < $mxptr ){ 
?>
	<div tooltipe="Refresh">
	<a class="fas fa-sync" href="<?php echo base_url(); ?>habitat/dshb/<?php echo $npt=$_SESSION['sid']; ?>/r" id="refresh" title="Refresh" style="float:right;margin-right:60px; font-size:20px;">
	</a>
	</div>
<?php
}
?>

<div tooltip="All Report">
 	<a href="<?php echo base_url(); ?>/habitat/dashboarddtl" title="View Reports" target="_blank" style="float:right;margin-right:50px;font-size:20px;">
	<i class="fa fa-list-alt"></i> 
 	</a>
</div>
</td>
</tr>

<?php
	$csid;
	$mxsid = $_SESSION['mxsid'];
 		$i=0;$ab='';$abn='';

	$ctermc=0;
	if($csid >= $mxsid){
		?>
			<!-- <tr style="height:5%;"><td><div tooltip="Close Tab"><a href="javascript:close_window();" style="float:right;margin-right:45px;font-size:20px;color:red"><i class="far fa-window-close"></i></a></div></td></tr>
			-->
		<?php	
		 echo "<tr style='height:80%;'><td><center><h2 style='color:green;margin-top:0%;'>Thank You </h2></center> </td></tr>";
	?>
<!--		<div tooltip="All Report">
		 <a href="<?php echo base_url(); ?>/habitat/dashboarddtl" title="View Reports" target="_blank" style="float:right;margin-right:50px;font-size:20px;">
        	<i class="fa fa-list-alt"></i>
 		</a>
		</div>
-->
	<?php
		//return;
	}
	else {
			if($csid <= $mxsid)
			{
				$ctermc = $this->MHabitat->get_cod_ov($table,$cterm);
        			$cqno=$this->MHabitat->get_qno($cqid);
				echo "<tr style='height:10%;'><td><div style='margin-left: 90px; color: blue;clear: left; font-size:14pt;'> $cqno . $cqt </div></td></tr>";
			} 

			if($ctermc > 0)
			{


?>
			<!------------------------------------------------------- GRAPH CHART --------------------------------------------------------------->
			<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  			<script type="text/javascript">
    			google.charts.load("current", {packages:['corechart']});
    			google.charts.setOnLoadCallback(drawChart);
    			function drawChart() {
      			var data = google.visualization.arrayToDataTable([
        		["Element", "", { role: "style" } ],
			    <?php 

				$optxt= $MHabitat=$this->MHabitat->get_optxt($cqid); //current term option text
				$ab='';$i=0;
				//to display only the current sid data chart
				if( $ctermc > 0){
				foreach($optxt as $d)
				{
					$i++;
					$options=$d->opt_text_value;
					$value=$d->value;
					$cterm=$d->term;
					$count_opt=$this->MHabitat->get_cod($table,$cterm, $value); //counting current term options as per value
					$cov=$this->MHabitat->get_cod_ov($table,$cterm); //counting overall current term
					if($i==1)
						$ab="#B82E2E";
					if($i==2)
						$ab="#3366CC";
					if($i==3)
						$ab="#FF9900";
					if($i==4)
						$ab="#3CB371";
					if($i==5)
						$ab="#DD4477";
					if($i==6)
						$ab="#F5FABD";
					if($i==7)
						$ab="#66AA00";
					if($i==8)
						$ab="#DC3912";
					if($i==9)
						$ab="#0099C6";
					if($i==10)
						$ab="#990099";

					///////////////// checking overall data of current term and next term////////////
				?>
		        		["<?php echo "$options"; ?>", <?php echo $count_opt?>, "<?php echo $ab;?>"], //current term questions and options
	         		<?php 
					} //end of for loop
			 	
				     } //end of if
		  		?>

		]);


      		var view = new google.visualization.DataView(data);
      		view.setColumns([0,1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);
                       
		var options = {
			title: 'Report (in Count )',
			annotations: {
				alwaysOutside: false,
				textStyle: {
			    		fontSize: 20,
			    		auraColor: 'none'
				   }
			},
			hAxis: {titleTextStyle: {color:'#cc00cc'}},
			vAxis: {
			  	textPosition: 'none',
				gridlines: {
					color: 'transparent'
				}
			},
			width: 600,
			height: 350,
			bar: {groupWidth: "40%"},
			legend: { position: "none" }
			};

      			var chart = new google.visualization.ColumnChart(document.getElementById("columnchart"));
      			chart.draw(view, options);

			var option2 = {title: 'Report (in %)',slices: {0: { color: '#B82E2E' },1: { color: '#3366CC' },2: { color: '#FF9900' },3: { color: '#3CB371' },4: { color: '#DD4477' },5: { color: '#F5FABD' },6: { color: '#66AA00' },7: { color: '#DC3912' },9: { color: '#0099C6' },9: { color: '#990099' }}, 'width':420, 'height':360, is3D: true};
  			var chart2 = new google.visualization.PieChart(document.getElementById('piechart'));
  			chart2.draw(data, option2);
		}
			  </script>
			<tr style="height:62%;"><td>
			<div style="margin:auto; width:100%;">
			<div style="width: 60%; height: 18%; padding: 5px;float: left; margin-left: 3px; border-style: groove;">
				<center><div id="columnchart" style="height:360px; width:650px;"></div> </center>

			</div>
			<script>
			   function getValueAt(column, dataTable, row) {
				return dataTable.getFormattedValue(row, column);
			      }
			</script>
			<!------------------------------------------------------- END OF GRAPH CHART --------------------------------------------------------------->

			<!------------------------------------------------------- PIE CHART --------------------------------------------------------------->
			<div style="width: 38%; height: 18%; padding: 5px;float: left; margin-left: 3px; border-style: groove;">
			<div id="piechart" style="height: 360px; width:420px;"></div>

			</div>
			</td>
			</tr>
<?php 

			}	//else echo "Wait..";
			else{

			 	echo "<tr style='height:50%;'><td><center><h1 color=green> Please wait...</h1></center>";
				echo "<center><img src='http://www.animatedimages.org/data/media/137/animated-clock-image-0179.gif' height=100px width=100px'> </center> </td></tr>";
			}
	}
 ?>

<tr style="height:9%;"><td>
<?php
if($ptr < $mxptr){
?>
<!-- //for prev next button -->
<div style="position:fix;">
        <a href="<?php echo base_url(); ?>habitat/dshb/<?php $ptr=$_SESSION['ptr'];
        if($ptr > 1) $ptr=$ptr-1;
                echo $psid=$arr[$ptr];
        ?>/p" style="float:left;margin-left:45%;font-size:16px;">
           <i class="fa fa-arrow-circle-left"></i>
        </a>

        <a href="<?php echo base_url(); ?>habitat/dshb/<?php $nptr=$_SESSION['ptr'];$acnt=count($arr); 
	if($nptr < $acnt)$nptr = $nptr+1; 
		echo $nsid=$arr["$nptr"];
		?>/n" style="float:right;margin-right:45%;font-size:16px;">
                <i class="fa fa-arrow-circle-right"></i>
        </a>
</div>
<?php 
}
?>
</td></tr>
<tr style="height:8%; background-color:black;">
<td>
    <footer style="bottom:0;height:10%;width:100%;color:green;text-align:center;position: fixed;>
        <div class="container" style="color:green;">
               <div class="col-md-4">
                    <span class="copyright"> &copy; 2018 QuantumCS Private Limited. All Rights Reserved.</span>
                </div>
        </div>
    </footer>
</td>
</tr>
</table>

<script type = "text/javascript" >
function disableBackButton()
{
window.history.forward();
}
setTimeout("disableBackButton()", 0);
</script>
