<!DOCTYPE html>
<html lang="en">

<head>
 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Quantum Digiadmin</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url(); ?>public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/my2.css">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url(); ?>public/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
 <!--
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>
 -->

    <!-- Theme CSS & topbar-->
    <link href="<?php echo base_url(); ?>public/css/agency.min.css" rel="stylesheet">


</head>

<body id="page-top" class="index">

    <!-- Navigation -->
    <nav id="mainNav" class="navbar navbar-default navbar-custom navbar-fixed-top" style="background-color:white; border-bottom: 3px solid #DCEDC8;"><img src="<?php echo base_url(); ?>public/img/logos/quantum-logo-big.png" height=80px width=80px style="margin-left:55px;"/>
<div style="margin-left: 20px;float:left;position: relative;width:75px;"></div>
        <div class="container"> 
            <!-- Brand and toggle get grouped for better mobile display -->
            
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <!-- Header -->
   
    <!-- About Section -->
    <section id="about">
        <div class="container">
            <br><br>
            <div class="row">
                 
       <div class="floating-box1 text-center col-4">
	<?php echo form_open('siteadmin/sadmlogin');?>

	 
	<?php echo $login_failed=validation_errors(); ?>
	<span><b><?php echo $login_failed; ?></b></span>

     
	<div class="text-center bg-primary text-white"> 
       		<br>DIGIADMIN MEMBER LOGIN<br>
	 </div>

	<br><input type="text" class="form-control" name="username" placeholder="Login as email" value="<?php echo set_value('username'); ?>"/>
	 <br>
	<input type="password" class="form-control" name="password" placeholder="Password" /><br/>
        	<font color="red"> <?php echo isset($error)? $error : ''; ?></font> 
	<div class="text-center">
		<br><input type="submit" class="btn btn-primary" value="Login" name="submit_login">
	</div>	 
        <div>
	<a style="font-size:12px; float:right; color:blue" href="<?php echo site_url('siteadmin/forgetpassword')?>">Forget Password?</a>
       </div>

<?php echo form_close()?>
</div>
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
