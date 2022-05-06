<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login to Digiadmin</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url(); ?>public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/my2.css">

    <!-- Custom Fonts 
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

    <!-- Theme CSS & topbar-->
    <link href="<?php echo base_url(); ?>public/css/agency.min.css" rel="stylesheet">
<script language="javascript">

function SelectRedirect(){
	switch(document.getElementById('domain').value)
	{
		case "1":
			window.location="http://www.localhost/digiamin-web";
		break;
		case "2":
			window.location="http://www.localhost/vpms";
		break;
		case "3":
			window.location="http://www.localhost/habitat";
		break;
	}// end of switch 
}

</script>

</head>

<body id="page-top" class="index">

    <!-- Navigation -->
    <nav id="mainNav" class="navbar navbar-default navbar-custom navbar-fixed-top" style="background-color:white; border-bottom: 3px solid #DCEDC8;">
<div style="margin-left: 20px;float:left;position: relative;width:75px;"></div>
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
         <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>public/img/logos/quantum-logo-big.png" height=45px width=150px/></a>

            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <!-- Header -->

    <!-- About Section -->
    <section id="about">
        <div class="container">
            <br><br>
            <div class="row col-9">
                <div class="col-12 text-center">
                    <h5 class="section-heading"> </h5>
                    <h3 class="section-subheading text-muted"></h3>
                </div>
            </div>
            <div class="row">
                    <div>
	  
      <div class="col-3" style="margin: -100px 0 0 -200px;left: 50%; top:30%;position: absolute;"">

      </div>
 
       <div class="col-6" style="width:390px;height:250px;padding:15px;margin: -100px 0 0 -200px;left: 50%; top:50%;position: absolute;"> 

        <div>
        <div>Domain: 
        <select name="domain" id="domain" onChange="SelectRedirect();"><option value=0>Select here </option><option value=1>SITE ADMIN</option><option value=2>VPMS</option><option value=3>HABITAT</option> </select><br/>
        <font color="red"> <?php echo isset($error)? $error : ''; ?></font>
        </div>
        </div>

</div>
                </center>
            </div>
        </div>
    </section>

    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>public/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url(); ?>public/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

    <!-- Theme JavaScript -->
    <script src="<?php echo base_url(); ?>public/js/agency.min.js"></script>

</body>

</html>

