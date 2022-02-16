
<html>
<head>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<!--link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" -->
<!-- Bootstrap -->
<link rel="stylesheet" type="text/css"  href="<?php echo base_url(); ?>public/css/bootstrap.css">
<link rel="stylesheet" type="text/css"  href="<?php echo base_url(); ?>public/css/bootstrap.min.css">

<script src="<?php echo base_url(); ?>public/js/jquery-2.1.1.min.js"></script>
<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

</head>
<body>
<div class="container">
<h2 class="text-center">Varenia CIMS Pvt Ltd </h2>

				<h4 class="text-muted text-center">All Employee List</h4>
<?php
$ctr = 0;
$img_url = 0;
//print_r($alldata);

if(!empty($alldata))
foreach($alldata as $emp)
{
	$ctr++;
	$emp_uid = $emp->id;
	$emp_name = $emp->name;
	$emp_des = $emp->designation;
	$emp_doj = $emp->doj;
	$img_url = $emp->img_url;
	//echo count($alldata);
	$nos=4+1;
	if($ctr == 1 || $ctr == $nos )
		echo "<div class='row'>";

?>

				
				<div class='col-lg-3' >
					<div class="card" style="width: 250px; margin:5px;  padding : 10px; box-shadow: 0.5px 0.5px 0.5px 0.5px gray;">
					<?php 
					if($img_url == '0')
					{
						echo "<center> <i class='fas fa-portrait' style='font-size:98px;color:red;'></i></center>";
					}
					else
					{
					?>
						<center> <img src='<?=$img_url;?>' width='150px' height='100px'/></center>
					<?php }
					?>
					  <!-- center> <i class='fas fa-portrait' style='font-size:98px;color:red;'></i></center -->
					  <div class="card-body text-center">
						<h4 class="card-title"> <?=$emp_name;?></h4>
						<p class="card-text">[ <?=$emp_des;?> ]</p>
						<?php if($type == 'report'){ ?>
						<a href="viewempdetail/<?=$emp_uid?>" class="btn btn-primary">Full Details</a>
						<?php }
                                                if($type == 'edit'){ ?>
                                                <a href="editempdetail/<?=$emp_uid?>" class="btn btn-primary">Update Details</a>
                                                <?php } ?>

					  </div>
					</div>
				</div>


<?php
$len = count($alldata);
	if( $ctr == ($nos-1) )
        { 
		echo "</div>";
		$ctr=0;
	}
 } 

?>

</body>
</html>
