<?php

    if($_SESSION['vwebuser']=='')
    { 
            //Redirect::to('index.php');
             $this->load->view('_login_form');
    }
    else
    {
            $vuid=$_SESSION['vwebuser'];         
    } 

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Digiadmin-MyAccount</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/my2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/vendor/font-awesome/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

    <!-- Theme CSS & topbar-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/agency2.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/agency2.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/sb-admin-2.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/sb-admin-2.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
 
 <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

<style>
.validation-error {color:#FF0000;}
</style>

</head>


<body id="page-top" class="index" style="background-color:#dff0d8;">

    <!-- Navigation -->
    <nav id="mainNav" class="navbar navbar-default navbar-custom navbar-fixed-top" style="background-color:white; border-bottom: 3px solid #DCEDC8;">
<div style="margin-left: 20px;float:left;position: relative;width:75px;"><a href="#page-top"><img src="<?php echo base_url(); ?>public/img/logos/quantum-logo-big.png" height=80px width=80px/></a></div>
        <div class="container"> 
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll"> 
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
                </button>
            <a class="navbar-brand page-scroll" href="#page-top"> </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                 
                    <li>
                        <a href="<?php echo base_url(); ?>welcome/logout"><i class="fa fa-user"></i> Sign Out</a>
                    </li>
                    
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>


<div class="navbar-default sidebar" role="navigation" style="background-color: #dff0d8;">
                <div class="sidebar-nav navbar-collapse2">
                    <ul class="nav" id="side-menu">
                        <li style="margin-top:30px;">
                              <i class="fa"></i>
                        </li>
                   	<li>
                            <a  href="#"><i class="fa fa-sign-out fa-fw"></i>My Order<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">

                                <li>
                                    <a  href="<?php echo base_url(); ?>welcome/neworder" > Place New Order </a>
                                </li>
                                <li>
                                    <a  href="<?php echo base_url(); ?>welcome/vieworderlist" > View Order List </a>
                                </li>
                             </ul>
                        </li>
                         
                         
                        
                       
                       
                 </div>
</div>

   <br><br>
<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row" id="pdtls">
                    <div class="col-lg-12">
                        <h5 class="page-header">New Order </h5>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                        
                       <div class="w3-container">

<div class="w3-container"><div class="w3-panel w3-center">
<p class="w3-xxlarge w3-serif w3-text-green">
<b> Fill Your Requirements Here! </b>
</p>
</div></div>
<div class="w3-container">

<?php echo form_open('welcome/requestprocess');?>

<div class="container  w3-margin-left col-12">
<p>
		 <label class="w3-large w3-serif w3-text-green"><b><i>Target Group Specification <span class="prop-validation validation-error"></span></i></b></label><br>
      <textarea class="w3-input" rows="3" cols="40" id="prop" name="prop" onblur="validate()" placeholder="TG like male only, age >18, etc. Details"></textarea>
     </p>
</div>

<div class="container  w3-margin-left col-12">	 
 <p>
		 <label class="w3-large w3-serif w3-text-green"><b><i>Expected Sample Size<span class="size-validation validation-error"></span></i></b></label><br>
      <input class="w3-input" type="number" id="size" name="size" onblur="validate()" placeholder="e.g. 500">
     </p>
	 <p>
		 <label class="w3-large w3-serif w3-text-green"><b><i>Centres<span class="centre-validation validation-error"></span></i></b></label><br>
                 <input class='w3-input2' type='checkbox'  name=centre1 value=1> Delhi <br>
                 <input class='w3-input2' type='checkbox'  name=centre2 value=2> Chennai <br>
                 <input class='w3-input2' type='checkbox'  name=centre3 value=3> Kolkata <br>
                 <input class='w3-input2' type='checkbox'  name=centre5 value=5> Banglore <br>
                 <input class='w3-input2' type='checkbox'  name=centre6 value=6> Mumbai <br>
                 <input class='w3-input2' type='checkbox'  name=centre9 value=9> Hyderabad <br>
                 <input class='w3-input2' type='checkbox'  name=centre28 value=28> Lucknow <br>

      <!-- <input class="w3-input" type="number"id="centre" name="centre" onblur="validate()" placeholder="e.g. 4"> -->
              <?php
                  
              /*    $cds=$pm->getCentres();
                  foreach($cds as $c)
                  {   $cid=$c->centre_id; $cn=$c->cname;
              echo " <input class='w3-input2' type='checkbox'  name=centre$cid value=$cid> $cn <br>";
                  }
             */
              echo " <input class='w3-input2' type='checkbox' id='ot' name='ot' value=500 onchange='getother();'> Others <div id=oth style='display:none;'><input class='w3-input2' type='text' id='others' name='others' placeholder='Enter your centre list separated by comma' style='width:500px;'> </div><br>";
             ?>
     </p>
	<!-- <p>
		 <label class="w3-large w3-serif w3-text-green"><b><i>Estimated Budget(Range)<span class="budget-validation validation-error"></span></i></b></label><br>
      <input class="w3-input " type="text"id="budget" name="budget" onblur="validate()" placeholder="e.g. Rs5.6 to 7.0 Lakh">
     </p>
</div>
<div class="container  w3-margin-left w3-margin-right col-12" style="float:left"> 
	 
	 
	 <p>
		 <label class="w3-large w3-serif w3-text-green"><b><i>Contact Person Name<span class="name-validation validation-error"></span></i></b></label><br>
      <input class="w3-input" type="text" id="name" name="name" onblur="validate()" placeholder="Write Your Name Here">
     </p>
     <p>
		 <label class="w3-large w3-serif w3-text-green"><b><i>Email<span class="email-validation validation-error"></span></i></b></label><br>
      <input class="w3-input" type="text" id="email" name="email" onblur="validate()" placeholder="Write Your eMail Here">
     </p>
          <p>
		 <label class="w3-large w3-serif w3-text-green"><b><i>Contact No.<span class="contact-validation validation-error"></span></i></b></label><br>
      <input class="w3-input" type="number" id="contact" name="contact" onblur="validate()" placeholder="Write Your Mobile Here">
     </p>
	--> 
	  

<button id="submit" name="submit" type="submit" class="w3-btn w3-round-xlarge w3-green " disabled="disabled">Send Request</button><br><br>
</div>
</form>

</div>

                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>

     
        
      

<!-- /#page-wrapper -->
    

    <footer style="background-color:white; border-top: 1px solid #DCEDC8;">
        <div class="container">
               
                <div style="float:center;">
                    <div class="col-md-4">
                    <span class="copyright"> &copy; 2017 Digiadmin Private Limited. All Rights Reserved.</span>
                </div>
                    <ul class="list-inline social-buttons">
                        
                        <li><a href="https://www.facebook.com/Digiadmin/" target="_blank"><i class="fa fa-facebook"></i></a>
                        </li>
                         
                        <li><a href="https://in.linkedin.com/in/varenia-cims-aab337b6" target="_blank"><i class="fa fa-linkedin"></i></a>
                        </li>
                    </ul>
                    
                </div>
            
        </div>
    </footer>

    

    

    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>public/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url(); ?>public/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

    <!-- Contact Form JavaScript -->
    <script src="<?php echo base_url(); ?>public/js/jqBootstrapValidation.js"></script>
    <script src="<?php echo base_url(); ?>public/js/contact_me.js"></script>

    <!-- Theme JavaScript -->
    <script src="<?php echo base_url(); ?>public/js/agency.min.js"></script>
    
<script src="<?php echo base_url(); ?>public/js/sb-admin-2.js"> </script>
<script src="<?php echo base_url(); ?>public/js/sb-admin-2.min.js"> </script>

<!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url(); ?>public/metismenu/metisMenu.min.js"></script>

<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script>
function validate(){
var valid=true;
var valid1 = checkEmpty($("#prop"));
var valid2 = checkEmpty($("#budget"));
var valid3 = checkEmpty($("#name"));
var valid4 = checkEmpty($("#size"));
var valid5 = checkEmpty($("#centre"));
var valid6 = checkEmpty($("#contact"));
var valid7 = checkEmpty($("#email"))

valid = valid1 && valid2 && valid3 && valid4 && valid5 && valid6 && checkContact($("#email"));

$("#submit").attr("disabled",true);
	if(valid) {
		$("#submit").attr("disabled",false);
	}
}
function checkEmpty(obj) {
	var name = $(obj).attr("name");
	$("."+name+"-validation").html("");
	$(obj).css("border","");
	if($(obj).val() == "") {
		$(obj).css("border","#FF0000 1px solid");
		$("."+name+"-validation").html("Required");
		return false;
	}

	return true;
}
function checkContact(obj) {
	var result = true;

	var name = $(obj).attr("name");
	$("."+name+"-validation").html("");
	$(obj).css("border","");

	result = checkEmpty(obj);

	if(!result) {
		$(obj).css("border","#FF0000 1px solid");
		$("."+name+"-validation").html("Required");
		return false;
	}
 return result;
}
function getother()
{       var ot = document.getElementById('ot');  
       var elem = document.getElementById('oth'); 
       //var elem1 = document.getElementById('others'); 
      
      if($("#ot").is(':checked'))
      { elem.style.display = 'inline';  
      }
      else { elem.style.display = 'none';  }
}	
</script>

