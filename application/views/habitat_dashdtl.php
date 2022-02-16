<html>
 <meta http-equiv="refresh" content="">
 <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/vendor/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

<nav id="mainNav" class="navbar navbar-default navbar-custom navbar-fixed-top" style="background-color:white; border-bottom: 3px solid #DCEDC8;">
 <div style="margin-left: 10px;float:left;position: relative;width:75px;"></div>
  <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
	 <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>public/img/logos/quantum-logo-big.png" style="height:45px; width:100px:float:left"/></a>
 	<a href="<?php echo base_url(); ?>/habitat"><img src="<?php echo base_url(); ?>public/img/logos/habitat.png" style="height:45px; width:250px;float:right;"/></a>
   </div>
  </div>
</nav>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
	function forprint(){
		if (!window.print){ 
			return
		}
			window.print()
	}

function close_window() {
  if (confirm("Close Window?")) {
    close();
  }
}

</script>
<body>
<div tooltip="Print Report">
<a href="javascript:forprint()" style="float:right;margin-right:50px;font-size:20px;"> 
	<i class="fa fa-print"></i>
</a>
</div>
<div tooltip="Close Tab">
<a href="javascript:close_window();" style="float:right;margin-right:45px;font-size:20px;color:red">
	<i class="far fa-window-close"></i>
</a>
</div>
<center><h3><u>Overall Report</u></h3> </center>

<?php
	$qset=$this->session->userdata('qset_id'); //current qset_id
if($qset!='')
{
$table=$this->MHabitat->getPTable($qset);
$sqlq="SELECT qid from question_sequence WHERE qset_id = $qset ORDER BY sid asc;";
$qdata=$this->MHabitat->getDataBySql($sqlq);
if($qdata)
foreach($qdata as $qd)
{
	$qid=$qd->qid;
	$qtype=$this->MHabitat->get_qtype($qid);
	if($qtype == 'instruction' || $qtype == 'text' || $qtype == 'textarea') continue;
	 
	$term=$this->MHabitat->get_ctermid($qid); //current question id
	$qt=$this->MHabitat->get_cqt($qid); //current question title
	$qno=$this->MHabitat->get_qno($qid);
	echo "<p style='clear: left';><font color=blue> $qno . $qt </font></p>";
//                echo "<br>qid: $qid , qtype: $qtype , term: $term <br>";

	$qopt= $MHabitat=$this->MHabitat->get_optxt($qid);
	$total=0;
	$str1='<table border=1 cellspacing=0 style="height:5%;"><tr>';
	$str2='<tr>';
        $strp1='<table border=1 cellspacing=0 style="height:5%;"><tr>';
        $strp2='<tr>';
	if($qopt)
        foreach($qopt as $q)
        {
                $ot=$q->opt_text_value;
                $value=$q->value;
                $term=$q->term;
		//$total=$total+$value
                $vopt=$this->MHabitat->get_cod($table,$term, $value);
		$total = $this->MHabitat->get_cod_ov($table,$term);
		$str1.="<td>$ot</td>";
		$str2.="<td>$vopt</td>";
		$tp=($vopt * 100 / $total);
		$tp=round($tp,2);
                $strp1.="<td>$ot</td>";
                $strp2.="<td>$tp %</td>";
	}
	$str1.="</tr>";
	$str2.="</tr></table>";

        $strp1.="</tr>";
        $strp2.="</tr></table>";

	//echo "$str1 $str2 ";

?>
<!------------------------------------------------------- GRAPH CHART --------------------------------------------------------------->
  <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {

      var data = google.visualization.arrayToDataTable([

        ["Element", "", { role: "style" } ],
			    <?php 
				$i=0;$ab='';$abn='';
				$ntermc = 0;
				$nqid=0;
				$nsid=0;$nqtype='';$ntrm=''; 
	$optxt= $MHabitat=$this->MHabitat->get_optxt($qid); //current term option text
	//to display only the current sid data chart
	if($optxt){
	foreach($optxt as $d)
	{
		$i++;
		$options=$d->opt_text_value;
		$value=$d->value;
		$term=$d->term;
		$count_opt=$this->MHabitat->get_cod($table,$term, $value); //counting current term options as per value
		$cov=$this->MHabitat->get_cod_ov($table,$term); //counting overall current term
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

		?>
        ["<?php echo "$options"; ?>", <?php echo $count_opt?>, "<?php echo $ab;?>"], //current term questions and options
         <?php 
			} //end of for loop
			 	//$_SESSION['sid'] = ++$csid;
			} //end of if
		  ?>
		]);


      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
	title: "Report (in count)",
        vAxis: {
	  textPosition: 'none',
    	  gridlines: {
        	color: 'transparent'
    	             }
        },
        width: 500,
        height: 250,
        bar: {groupWidth: "40%"},
        legend: { position: "none" },
      };

	var cdiv="c<?php echo $qid; ?>";
	var pdiv="p<?php echo $qid; ?>";	
      var chart = new google.visualization.ColumnChart(document.getElementById(cdiv));
      chart.draw(view, options);

     // var options2 = {'title':'RESULT IN %', 'width':500, 'height':400,is3D: true};
var options2 = {title: 'Report (in %)',slices: {0: { color: '#B82E2E' },1: { color: '#3366CC' },2: { color: '#FF9900' },3: { color: '#3CB371' },4: { color: '#DD4477' },5: { color: '#F5FABD' },6: { color: '#66AA00' },7: { color: '#DC3912' },9: { color: '#0099C6' },9: { color: '#990099' }}, 'width':400, 'height':250,is3D: true};

  // Display the chart inside the <div> element with id="piechart"
  var chart2 = new google.visualization.PieChart(document.getElementById(pdiv));
  chart2.draw(data, options2);
  }
</script>

<div style="margin:auto; width:100%;">
<div style="width: 55%; height: 65%; padding: 5px;float: left; margin-left: 3px; border-style: groove;">

<div id="c<?php echo $qid; ?>" style="height:300px; width:510px;"></div>
<?php
 echo "$str1 $str2 ";
?>
</div>
<!------------------------------------------------------- END OF GRAPH CHART --------------------------------------------------------------->

<!------------------------------------------------------- PIE CHART --------------------------------------------------------------->

<div style="width: 40%; height: 65%; padding: 5px;float: left; margin-left: 3px; border-style: groove;">

<div id="p<?php echo $qid; ?>" style=" height:300px; width:410px;"></div>
<?php
 echo "$strp1 $strp2 ";
?>
</div>

</div>
<br>
<?php
	//echo "<hr color=gray style='clear:left;'>";
} //end of foreach sid

} //end of if qset
else echo "Session Expired. Please Sign In Again.";
?>
