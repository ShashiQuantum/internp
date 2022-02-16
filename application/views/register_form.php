<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>User Registration</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url(); ?>public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/my2.css">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

    <!-- Theme CSS & topbar-->
    <link href="<?php echo base_url(); ?>public/css/agency.min.css" rel="stylesheet">


</head>

<body id="page-top" class="index">

    <!-- Navigation -->
    <nav id="mainNav" class="navbar navbar-default navbar-custom navbar-fixed-top" style="background-color:white; border-bottom: 3px solid #DCEDC8;">
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
            <div class="row col-9">
                <div class="col-12 text-center">  
                    <h5 class="section-heading"> </h5>
                    <h3 class="section-subheading text-muted"></h3>
                </div>
            </div>
            <div class="row">
                 
                    <div>
      
       <font color="red"> <?php echo isset($error)? $error : ''; ?></font>
	<?php echo form_open('home/do_reg');?>

	 
	 
	
      <div class="col-3" style="margin: -100px 0 0 -200px;left: 50%; top:30%;position: absolute;"">
         <a href="#page-top"><img src="<?php echo base_url(); ?>public/img/logos/quantum-logo-big.png" height=80px width=80px/></a>
           
      </div>	

    <div id="wrapper" class="col-6">
 
       <a href="<?php echo base_url(); ?>home/login"><div  style="width:390px;height:250px;padding:15px;margin: -100px 0 0 -200px;left: 50%; top:42%;position: absolute;float: left;width: 190px;height: 6%;  margin-bottom: 20px; border-radius:4px;text-align: left;background-color: #598445;color:white;"> 
       Login
       </div></a>
       <a href="<?php echo base_url(); ?>home/register"><div class="floating-row" style="width:390px;height:250px;padding:15px;margin: -100px 0 0 -200px;left: 65%; top:42%;position: absolute; width: 190px;height: 6%;  margin-bottom: 20px; border-radius:4px;text-align: left;background-color: lightgray;"> 
       Register
       </div></a>
    </div>
      <div class="floating-box1 col-6" style="width:390px;height:150px;padding:15px;margin: -100px 0 0 -200px;left: 50%; top:50%;position: absolute;"> 
             
	<div>
	<div>Email ID: </div>
	<div>
	<input type="email" name="username" required placeholder="Enter Your Email" value="<?php echo set_value('username'); ?>"/>
	 
	</div>
	</div>
	 
	 
	<div>
	<br><input type="submit" value="Register" name="submit_register" style="background-color: #fffff;height:10%;width:350px;">
        <br><span><font color=red><b><?php echo $msg; ?></b></font></span>
	</div>	 
      </div>
<?php echo form_close()?>
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
