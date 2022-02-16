
<html>
	<head>
		<title>Branch Registration</title>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
		<!-- Latest compiled JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
				
		<script type='text/javascript'>
		   $(document).ready(function() {
				$('#day1').change(function(){
					var selectedOption = $(this).children("option:selected").val();
					document.getElementById("day2").options[selectedOption].disabled = true;
				});
					$(window).keyup(function(e){
						  if(e.keyCode == 44){
							//alert('You are not Permitted to take Screenshot');
							//window.close();//$("body").hide();
							//return false;
							var response = confirm("You are not permitted to take screenshot \nPress Ok to continue \nElse I close this window");
								   if( response == false ) {
										window.close();
								   } else {
									  
								   }
						  }

						});
						/*$("body").bind("keydown", function(e) {
								if (e.keyCode == 44) {
								//return false;
								$("body").hide();
								//my_window.close ();

								}
								});*/
	});
		</script>
	</head>
	<body>
		<div class="container">
			<div class='row'>
				<div class="col-lg-4">
				</div>
				<div class="col-lg-4">
					<div class="card">
					  <div class="card-body">
						<h2 class="card-title text-center">Varenia CIMS Pvt Ltd </h2>
						<h4 class="card-subtitle mb-2 text-muted text-center">Branch Registration</h4>
							<form style='margin-top:50px;' action='<?=base_url();?>hr/doaddbranch' method='post'>
								<div class='form-group'>
									<label class='control-label'>Company</label>
									<select class='form-control' required=''>
										<option value=''>Select Company</option>
										<option value='1'>Varenia CIMS</option>
									</select>
								</div>
								<div class='form-group'>
									<label class='control-label'>Branch Address</label>
									<textarea class='form-control' placeholder='Branch Address' required=''></textarea>
								</div>
								<div class='form-group'>
									<label class='control-label'>Lattitude</label>
									<input type='number' class='form-control' placeholder='Lattitude' required=''/>
								</div>
								<div class='form-group'>
									<label class='control-label'>Longitude</label>
									<input type='number' class='form-control' placeholder='Longitude' required=''/>
								</div>
								<div class='form-group'>
									<label class='control-label'>Radius</label>
									<input type='number' class='form-control' placeholder='Radius' required=''/>
								</div>
								<div class='form-group'>
									<label class='control-label'>Select Leave Day 1</label>
									<select class='form-control leaves' id='day1' name="day1" required=''>
										<option>Select Day 1</option>
										<option value='1'>Monday</option>
										<option value='2'>Tuesday</option>
										<option value='3'>Wednesday</option>
										<option value='4'>Thrusday</option>
										<option value='5'>Friday</option>
										<option value='6'>Saturday</option>
										<option value='7'>Sunday</option>
									</select>
								</div>
								<div class='form-group'>
									<label class='control-label'>Select Leave Day 2</label>
									<select class='form-control leaves' id='day2' name="day2" required=''>
										<option>Select Day 2</option>
										<option value='1'>Monday</option>
										<option value='2'>Tuesday</option>
										<option value='3'>Wednesday</option>
										<option value='4'>Thrusday</option>
										<option value='5'>Friday</option>
										<option value='6'>Saturday</option>
										<option value='7'>Sunday</option>
									</select>
								</div>
								<div class='form-group'>
									<label class='control-label'>GMT</label>
									<input type='number' class='form-control' placeholder='GMT' required=''/>
								</div>
								<center><button class='btn btn-primary'>Register</button></center>
							</form>
					  </div>
					</div>
				</div>
			</div>
		</div>
		
	</body>
</html>
