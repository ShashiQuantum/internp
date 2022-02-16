<html>
<head>
 <meta http-equiv="refresh" content="">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/vendor/font-awesome/css/font-awesome.min.css">
    <!-- Theme CSS & topbar-->
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
  </script>
  <style>
  label {
    display: inline-block;
  }
  </style>
</head>
<body style="overflow: hidden;">
    <nav id="mainNav" class="navbar navbar-default navbar-custom navbar-fixed-top" style="background-color:white; border-bottom: 3px solid #DCEDC8;">
<div style="margin-left: 10px;float:left;position: relative;width:75px;"></div>
        <div class="container3" style="margin-left:0px; margin-right:0px;">
            <!-- Brand and toggle get grouped for better mobile display -->
 <a><img src="<?php echo base_url(); ?>public/img/logos/quantum-logo-big.png" style="height:45px; width:100px:float:left"/></a>
 <a><img src="<?php echo base_url(); ?>public/img/logos/habitat.png" style="height:45px; width:250px;float:right;"/></a>
</div>
</div>
</nav>
<br><br><br><br>

<div tooltipe="Refresh">
<a href="#" OnClick="refresh()" id="refresh" title="Refresh" style="float:right;margin-right:60px; font-size:26px;">
      <i class="fas fa-sync"></i></span>
</a>
</div>

<div tooltip="All Report">
 <a href="<?php echo base_url(); ?>/habitat/dashboarddtl" title="View Reports" target="_blank" style="float:right;margin-right:50px;font-size:26px;">
	<i class="fa fa-list-alt"></i> 
 </a>
</div>
<?php
	$cqset_id=$this->session->userdata('qset_id'); //current qset_id
	$csid=$this->session->userdata('sid'); //current sid
	$csid=$_SESSION['sid'];
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
//		echo "<br> sid: $csid ,qid: $cqid , qtype: $qtype <br>";
		if($qtype == 'instruction' || $qtype == 'text' || $qtype == 'textarea') continue;
		else break;
	   }
	}
                //echo "<br>s sid: $csid ,qid: $cqid , qtype: $qtype <br>";

	$cterm=$this->MHabitat->get_ctermid($cqid); //current question id
	$cqt=$this->MHabitat->get_cqt($cqid); //current question title
	$mxsid=$this->MHabitat->get_mxsid($cqset_id); //getting all question and sequence
	$total_q=$mxsid; //total questions for a project
//                echo "<br>s sid: $csid / $mxsid ,qid: $cqid , qtype: $qtype , term: $cterm <br>";
 		$i=0;$ab='';$abn='';
                $ntermc = 0;
                $nqid=0;$nqt='';$nqno='';
                $nsid=0;$nqtype='';$ntrm='';
        $total=0;
        $str1='<table border=1 cellspacing=0><tr><td>*</td>';
        $str2='<tr><td>Value (In Count)</td>';
        $strp1='<table border=1 cellspacing=0><tr><td>*</td>';
        $strp2='<tr><td>Value (In %)</td>';
	//echo " csid: $csid / $mxsid , cqid = $cqid - $cqno <br>";
 	//$ctermc = $this->MHabitat->get_cod_ov($table,$cterm);
	$ctermc=0;
	if($csid == $mxsid){
		 echo "<center><h2 style='color:green;margin-top:10%;'>Thank You </h2></center>";
		return;
	}
	else {
			if($csid <= $mxsid)
			{
				$ctermc = $this->MHabitat->get_cod_ov($table,$cterm);
				$nsid=$csid;
				//if($nsid != $mxsid) 
					$nsid = $csid + 1;	//next sid
				$nqid=$this->MHabitat->get_cqid($cqset_id, $nsid); //next question id
				//$nterm= $MHabitat=$this->MHabitat->get_optxt($nqid); //next term details
				$nqtype = $this->MHabitat->get_qtype($nqid);
//echo "<br> nsid: $nsid / $nqid ";
			        if($nqtype == 'instruction' || $nqtype == 'text' || $nqtype == 'textarea'){
                                	if($nsid < $mxsid)
			            while($nqtype != 'radio' || $nqtype != 'checkbox'){
			                ++$nsid;
			                $nqid = $this->MHabitat->get_cqid($cqset_id, $nsid);
			                $nqtype=$this->MHabitat->get_qtype($nqid);
//echo "<br>w nsid: $nsid / $nqid ";
			                if($nqtype == 'instruction' || $nqtype == 'text' || $nqtype == 'textarea') continue;
			                else break;
           			     }
        			}
//echo "<br>a nsid: $nsid / $nqid ";
				//if($nqtype != 'instruction' || $nqtype != 'text' || $nqtype != 'textarea'){
				//echo "<br> nqid: $nqid / $cqid : $nsid / $csid ";
                                $nqt=$this->MHabitat->get_cqt($nqid); //next question title
                                $nqno=$this->MHabitat->get_qno($nqid);
                                $nqtype = $this->MHabitat->get_qtype($nqid);
				$ntermc=0;
				if($nqtype == 'radio' || $nqtype == 'checkbox'){
                                	$ntermop= $MHabitat=$this->MHabitat->get_optxt($nqid); //next term details
					//$ntrm='ss';
					foreach($ntermop as $nt)
					{
					$noptions = $nt->opt_text_value;
					$nvalue = $nt->value;
					$ntrm = $nt->term;
					//$ntrm='10975_194';
					$ntermc = $this->MHabitat->get_cod_ov($table,$ntrm); //count nxt term overall
					}
					//$ntermc = $this->MHabitat->get_cod_ov($table,$ntrm);
                                        //$ntermc=$this->MHabitat->get_cod_ov($table,$ntrm); //count nxt term overall
				}
			} 
		//end of nqt 
if($ntermc == 0 && $ctermc > 0){
//echo  " csid-1: $csid , cqid = $cqid / $cqno<br>";
			echo "<div style='margin-left: 90px; color: blue;clear: left; font-size:16pt;'><br> $cqno . $cqt <br></div>";
        $qopt= $MHabitat=$this->MHabitat->get_optxt($cqid);
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
		$tp=0;
                //$tp=($vopt * 100 / $total);
                $tp=round($tp,2);
                $strp1.="<td>$ot</td>";
                $strp2.="<td>$tp </td>";
        }
        $str1.="</tr>";
        $str2.="</tr></table>";

        $strp1.="</tr>";
        $strp2.="</tr></table>";
		}
		else if($ntermc > 0){
//echo " nsid: $nsid , nqid = $nqid / $nqno<br>";
			echo "<div style='margin-left: 90px; color:blue;clear:left; font-size:16pt;'><br> $nqno . $nqt <br></div>";;
			
        $qopt= $MHabitat=$this->MHabitat->get_optxt($nqid);
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
		$tp=0;
                //$tp=($vopt * 100 / $total);
                $tp=round($tp,2);
                $strp1.="<td>$ot</td>";
                $strp2.="<td>$tp </td>";
        }
        $str1.="</tr>";
        $str2.="</tr></table>";

        $strp1.="</tr>";
        $strp2.="</tr></table>";
		}
	}
?>

<?php
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
			/*	$i=0;$ab='';$abn='';
				$ntermc = 0;
				$nqid=0;
				$nsid=0;$nqtype='';$ntrm='';
				////////For Current Term
			if($csid <= $mxsid)
			{
				$nsid=$csid;
				if($nsid != $mxsid) $nsid = $csid + 1;	//next sid
				$nqid=$this->MHabitat->get_cqid($cqset_id, $nsid); //next question id
				$nqt=$this->MHabitat->get_cqt($nqid); //next question title
				//$nterm= $MHabitat=$this->MHabitat->get_optxt($nqid); //next term details
				$nqtype = $this->MHabitat->get_qtype($nqid);

			        if($nqtype == 'instruction' || $nqtype == 'text' || $nqtype == 'textarea'){
			            while($nqtype != 'radio' || $nqtype != 'checkbox'){
			                ++$nsid;
			                $nqid=$this->MHabitat->get_cqid($cqset_id, $nsid);
			                $nqtype=$this->MHabitat->get_qtype($nqid);
			                if($nqtype == 'instruction' || $nqtype == 'text' || $nqtype == 'textarea') continue;
			                else break;
           			     }
        			}
				//if($nqtype != 'instruction' || $nqtype != 'text' || $nqtype != 'textarea'){
                                $nqtype = $this->MHabitat->get_qtype($nqid);
				if($nqtype == 'radio' || $nqtype == 'checkbox'){
                                	$ntermop= $MHabitat=$this->MHabitat->get_optxt($nqid); //next term details
					//$ntrm='ss';
					foreach($ntermop as $nt)
					{
					$noptions = $nt->opt_text_value;
					$nvalue = $nt->value;
					$ntrm = $nt->term;
					//$ntrm='10975_194';
					$ntermc = $this->MHabitat->get_cod_ov($table,$ntrm); //count nxt term overall
					}
					$ntermc = $this->MHabitat->get_cod_ov($table,$ntrm);
                                        //$ntermc=$this->MHabitat->get_cod_ov($table,$ntrm); //count nxt term overall
				}
			}
		*/
	$optxt= $MHabitat=$this->MHabitat->get_optxt($cqid); //current term option text
$ab='';$i=0;
	//to display only the current sid data chart
	if($ntermc == 0 && $ctermc > 0){
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
			 	//$_SESSION['sid'] = ++$csid;
			} //end of if
		  ?>
		  ///////////// For Next Term Data Chart//////////
		  	<?php
			$in=0;
			//if($csid<=$mxsid)
                        if($ntermc > 0)
			{
				
				//$nsid = $csid + 1;	//next sid
				$nqid = $this->MHabitat->get_cqid($cqset_id, $nsid); //next question id
				$nterm= $MHabitat=$this->MHabitat->get_optxt($nqid); //next term details
				foreach($nterm as $nt)
				{
					$in++;
					$noptions=$nt->opt_text_value;
					$nvalue=$nt->value;
					$nterm=$nt->term;
					$ncount_opt=$this->MHabitat->get_cod($table,$nterm, $nvalue); //counting next term options as per value
					if($in==1)
					$abn="#B82E2E";
					if($in==2)
					$abn="#3366CC";
					if($in==3)
					$abn="#FF9900";
					if($in==4)
					$abn="#3CB371";
					if($in==5)
					$abn="#DD4477";
					if($in==6)
					$abn="#F5FABD";
					if($in==7)
					$abn="#66AA00";
					if($in==8)
					$abn="#DC3912";
					if($in==9)
					$abn="#0099C6";
					if($in==10)
					$abn="#990099";
					//$ntermc=$this->MHabitat->get_cod_ov($table,$nterm); //count nxt term overall
				?>
				 ["<?php echo $noptions?>", <?php echo $ncount_opt?>, "<?php echo $abn;?>"], //next term questions and options
				 <?php
					} //end of loop
						//if($nsid != $mxsid) 
							$_SESSION['sid'] = $nsid;
                                                $this->session->set_userdata('sid', $nsid);

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
///// Current Question

///////////////// Questions /////////////////////
      var options = {
		 <?php 

	if(@$cov>=0 AND @$ntermc==0)
	{
		?>
 	title: 'Report (Total Count  # <?= $cc=$ntermc > 0 ? $ntermc: $ctermc;?>)',
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
		 <?php }?>
		<?php
		if(@$ntermc>0)
		{
		?>
 	title: 'Report (Total Count # <?= $cc=$ntermc > 0 ? $ntermc: $ctermc;?>)',
    annotations: {
        alwaysOutside: false,
        textStyle: {
            fontSize: 20,
            auraColor: 'none'
        }
    },
	hAxis: {
			titleTextStyle: {color:'#cc00cc'},
		},
        vAxis: {
		textPosition: 'none',
    gridlines: {
        color: 'transparent'
    }
        },
		<?php }?>
        width: 600,
        height: 400,
	bar: {groupWidth: "40%"},
        legend: { position: "none" },
      };


      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart"));
      chart.draw(view, options);

var options2 = {'title':'Report (in %)',slices: {0: { color: '#B82E2E' },1: { color: '#3366CC' },2: { color: '#FF9900' },3: { color: '#3CB371' },4: { color: '#DD4477' },5: { color: '#F5FABD' },6: { color: '#66AA00' },7: { color: '#DC3912' },9: { color: '#0099C6' },9: { color: '#990099' }}, 'width':490, 'height':400, is3D: true};

  // Display the chart inside the <div> element with id="piechart"
  var chart2 = new google.visualization.PieChart(document.getElementById('piechart'));
  chart2.draw(data, options2);
  }
  </script>
<div style="margin:auto; width:100%;">

<div style="width: 62%; height: 65%; padding: 5px;float: left; margin-left: 3px; border-style: groove;">
	<center><div id="columnchart" style="height:410px; width:700px;"></div> </center>
<?php
 //echo "<br>$str1 $str2 ";
?>

</div>
<script>
   function getValueAt(column, dataTable, row) {
        return dataTable.getFormattedValue(row, column);
      }
</script>
<!------------------------------------------------------- END OF GRAPH CHART --------------------------------------------------------------->

<!------------------------------------------------------- PIE CHART --------------------------------------------------------------->
<div style="width: 37%; height: 65%; padding: 5px;float: left; margin-left: 3px; border-style: groove;">
<div id="piechart" style="height: 410px; width:490px;"></div>
<?php
 //echo "<br> $strp1 $strp2 ";
?>

</div>

<?php 

}
else{

	 echo "<center><h1 color=green> Please wait...</h1></center>";
	echo "<center><img src='http://www.animatedimages.org/data/media/137/animated-clock-image-0179.gif' height=100px width=100px'> </center>";
}
 ?>


<!-- //for prev next button -->
<!--
<div style="bottom:3;position:fix;">
<a href='#' style="float:left;margin-left:40%;font-size:46px;">
<i class="fa fa-arrow-circle-left"></i>
</a>

<a href='#' style="float:right;margin-right:40%;font-size:46px;">
	<i class="fa fa-arrow-circle-right"></i>
</a>
</div>
-->
    <footer style="bottom:0;height:10%;width:100%;color:green;text-align:center;position: fixed;>
        <div class="container" style="color:green;">
               <div class="col-md-4">
                    <span class="copyright"> &copy; 2022 QuantumCS Private Limited. All Rights Reserved.</span>
                </div>
<!--                <div class="col-md-4">
                    <ul class="list-inline social-buttons">
                        <li><a href="https://www.facebook.com/QuantumCS/" target="_blank"><i class="fa fa-facebook"></i></a>
                        </li>
                        <li><a href="https://in.linkedin.com/in/varenia-cims-aab337b6" target="_blank"><i class="fa fa-linkedin"></i></a>
                        </li>
                    </ul>
                </div>
-->
        </div>
    </footer>
