<?php
include_once('../vcimsweb/init.php');
include_once('../vcimsweb/functions.php');

$pn = $_GET['pn'];
$pid=$_GET['ctp'];
$_SESSION['ctpid']=$pid;
$_SESSION['ctpn']=$pn;

$table = get_project_table($pid);
$table = $table . '_dummy';
$_SESSION['cttable'] = $table;

?>
<html>
<head>
<title>Upload Data</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<div class = 'container'>
<form action = 'datainsert.php' method = 'POST' enctype = 'multipart/form-data'>
<h3 class = 'text-center'>
Upload Excel Data for Project: <?=$_GET['pn']?>
</h3><hr>
<div class = 'row'>
	<div class = 'col-md-6'>
		<div class = 'form-group'>
			<input type = 'file' name = 'myfile' class = 'form-control'>
		</div>
	</div>
</div>
<div class = 'row'>
	<div class = 'col-md-6'>
		<div class = 'form-group'>
			<input type = 'submit' name = 'submit' class = 'btn btn-info'>
		</div>
	</div>
</div>
</form>
</div>
</body>
</html>
