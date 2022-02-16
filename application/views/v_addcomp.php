
<html>
<head>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
	<div class='row'>
		<div class="col-lg-4">
		</div>
		<div class="col-lg-4">
			<div class="card">
			  <div class="card-body text-center">
				<h2 class="card-title">Varenia CIMS Pvt Ltd </h2>
				<h4 class="card-subtitle mb-2 text-muted">Company Registration</h4>
					<form action='<?=base_url();?>hr/doaddcomp' method='post' >
						<div class='form-group'>
							<label class='control-label'>Company Name</label>
							<input type='text' class='form-control' placeholder='Company Name' required=''/>
						</div>
						<div class='form-group'>
							<label class='control-label'>Company Address</label>
							<textarea class='form-control' placeholder='Company Address' required=''></textarea>
						</div>
						<button class='btn btn-primary'>Register</button>
					</form>
			  </div>
			</div>
		</div>
		<div class="col-lg-4">
		</div>
	</div>
</div>
</body>
</html>
