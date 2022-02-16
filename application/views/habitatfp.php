<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>HABITAT | VARENIA</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url(); ?>public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/my2.css">

    <!-- Custom Fonts 
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/vendor/font-awesome/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

    <!-- Theme CSS & topbar-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/agency2.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/agency2.min.css" >
 <style>
p {
	margin-left: 50px;
    	color: red;
}
</style>

</head>

<body id="page-top" class="index" style="overflow: hidden;">
<img src="<?php echo base_url();?>public/img/habitatlogin.png" style="height:550px; width:100%;">
    <!-- Navigation -->
    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top" style="background-color:white; border-bottom: 3px solid #DCEDC8;">
        <div class="container3" style="margin-left: 0;margin-right: 0;">
            <!-- Brand and toggle get grouped for better mobile display -->
 <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>public/img/logos/quantum-logo-big.png" style="height:45px; width:200px; float:left;"/></a>
 <a href="<?php echo base_url(); ?>/habitat"><img src="<?php echo base_url(); ?>public/img/logos/habitat.png" style="height:50px; width:250px; float:right;"/></a>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <!-- Header -->

    <!-- About Section -->
            <div class="row">
                    <div> 
      <div class="floating-box1 col-6" style="width:300px;height:190px; padding:15px;margin: -100px 0 0 -200px;left: 80%; top:40%;position: absolute;">
        <div>
	<center><h2 style="color:white;">HABITAT</h2> <center><br>
	<?php echo form_open('habitat/godashboard');?>
	<?php echo $login_failed=validation_errors(); ?>
        <input type=text name="key" id="key" style="width:120px;" placeholder="Enter Code here" onkeypress='return event.charCode >= 48 && event.charCode <= 57' maxlength="5" minlength="3" required> 
	<input type="submit" value="GO" name="submit_login" style="background-color: #fffff;">
        <p> <?php echo isset($error)? $error : ''; ?> </p>
	<?php echo form_close()?>
        </div>
        <br>

</div>
                </center>
            </div>
        </div>

    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>public/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url(); ?>public/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

    <!-- Theme JavaScript -->
    <script src="<?php echo base_url(); ?>public/js/agency.min.js"></script>


    <footer style="bottom:0;height:50px;width:100%;color:green;text-align:center;>
        <div class="container" style="color:green;">
               <div class="col-md-4">
                    <span class="copyright"> &copy; 2018 Digiadmin Private Limited. All Rights Reserved.</span>
                </div>
     <!--           <div class="col-md-4">                  
                    <ul class="list-inline social-buttons">                        
                        <li><a href="https://www.facebook.com/Digiadmin/" target="_blank"><i class="fa fa-facebook"></i></a>
                        </li>                         
                        <li><a href="https://in.linkedin.com/in/varenia-cims-aab337b6" target="_blank"><i class="fa fa-linkedin"></i></a>
                        </li>
                    </ul>
                </div>
     -->
        </div>
    </footer>
