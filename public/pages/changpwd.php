<?php
include_once('../../public_html/vcims/init.php');
include_once('../../vcims/functions.php');
include_once('../../vcims/classes/User.php');


if(!Session::exists('vcims_userid'))
    { 
            Redirect::to('../index.php');
    }
    else
    {
            $vuid=Session::get('vcims_userid');         
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

    <title>Change Password</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
<link href="/css/userpass.css" rel="stylesheet" type="text/css">
<link href="/css/style-passwd.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="/css/normalize.css">

    <!-- Theme CSS & topbar-->
    <link href="../css/agency.min.css" rel="stylesheet">
<link href="../css/sb-admin-2.css" rel="stylesheet">
<link href="../css/sb-admin-2.min.css" rel="stylesheet">
<link href="../css/sb-admin-2.js">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    

</head>


<body id="page-top" class="index" style="background-color:#dff0d8;">

       <!-- Navigation -->
    <nav id="mainNav" class="navbar navbar-default navbar-custom navbar-fixed-top" style="background-color:white; border-bottom: 3px solid #DCEDC8;">
<div style="margin-left: 20px;float:left;position: relative;width:75px;"><a href="#page-top"><img src="/vcimsgo/img/logos/quantum-logo-big.png" height=80px width=80px/></a></div>
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
                        <a href="../logout.php"><i class="fa fa-user" style="color:green;"></i> Sign Out</a>
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
                            <a href="../logout.php"><i class="fa fa-sign-out fa-fw"></i> Sign Out</a>
                        </li>

                        
                        
                      </ul>
                 </div>
</div>

   <br><br>

<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h5 class="page-header">Change Password for  <?php print_r($_SESSION['vcims_userid']); ?></h6>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
           <form name="frmChange" action="" method="post">
     <label class="lebel02">Current Password</label>
     <input type="password" name="cpass" id="cpass" value="" placeholder="Enter Your Current Password" required><br>
     
     <label class="lebel02">New Password</label>
     <input type="password" name="npass" id="npass" value="" placeholder="Enter Your New Password" required><br>
     
     <label class="lebel02">Repeat Password</label>
     <input type="password" name="npassrepeat" id="npassrepeat" value="" placeholder="Repeat Your New Password" required><br>
     
     <label id="msg" style="color:red;"></label><br>
     <input type="button" value="Update" id="chngp" name="submit"  onclick="return validatePassword();">
   </form>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
<!-- /#page-wrapper -->
 

    

    <footer style="background: green;>
        <div class="container">
           
                <div class="col-md-4">
                    <span class="copyright"> &copy; 2017 Digiadmin Private Limited. All Rights Reserved.</span>
                </div>
                <div class="col-md-4">
                    <ul class="list-inline social-buttons">
                       
                        <li><a href="https://www.facebook.com/Digiadmin/" target="_blank"><i class="fa fa-facebook"></i></a>
                        </li>
                         
                        <li><a href="https://in.linkedin.com/in/varenia-cims-aab337b6" target="_blank"><i class="fa fa-linkedin"></i></a>
                        </li>
                    </ul>
                </div>
                
            </div>
        
    </footer>

    

    <script type="text/javascript"> 
            $("#abtus").click(function(){ 
                $("#page-wrapper").load("pages/aboutus.html"); 
            });
            $("#whatdo").click(function(){ 
                $("#page-wrapper").load("pages/whatdo.html"); 
            });
            $("#workus").click(function(){ 
                $("#page-wrapper").load("pages/workus.html"); 
            });
            $("#features").click(function(){
                $("#page-wrapper").load("pages/features.html"); 
            });
            $("#team").click(function(){
                $("#page-wrapper").load("pages/team.html"); 
            });
            $("#chngp").click(function(){
                $("#page-wrapper").load("pages/chngpwd.html"); 
            });
             
</script> 

<script type="text/javascript">
$(document).ready(function() {

    $('#chngp').click(function(){ 
   
    var cpass=document.getElementById('cpass').value;
    var npass=document.getElementById('npass').value;
    var npassrepeat=document.getElementById('npassrepeat').value;
    $('#msg').html('<img src="../img/LoaderIcon.gif" />');
    $.ajax({
    type : "POST",
    data:{cpass : cpass , npass : npass, npassrepeat: npassrepeat},
    url : "./chngpwd.php",
    success : function(data){ 
        
        $("#msg").html(data);

    }

    });
    });
});

</script>

<script type="text/javascript">
function validatePassword() { 
var currentPassword,newPassword,confirmPassword,output = true;

currentPassword = document.frmChange.cpass;
newPassword = document.frmChange.npass;
confirmPassword = document.frmChange.npassrepeat;

if(!currentPassword.value) {
	currentPassword.focus();
	document.getElementById("cpass").innerHTML = "required";
	output = false;
}
else if(!newPassword.value) {
	newPassword.focus();
	document.getElementById("npass").innerHTML = "required";
	output = false;
}
else if(!confirmPassword.value) {
	confirmPassword.focus();
	document.getElementById("npassrepeat").innerHTML = "required";
	output = false;
}
if(newPassword.value != confirmPassword.value) {
	newPassword.value="";
	confirmPassword.value="";
	newPassword.focus();
	document.getElementById("confirmPassword").innerHTML = "not same";
	output = false;
} 	
return output;
}
</script>

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

    <!-- Contact Form JavaScript -->
    <script src="../js/jqBootstrapValidation.js"></script>
    <script src="../js/contact_me.js"></script>

<script src="../js/sb-admin-2.js"> </script>
<script src="../js/sb-admin-2.min.js"> </script>

<!-- Metis Menu Plugin JavaScript -->
    <script src="../metismenu/metisMenu.min.js"></script>

    <!-- Theme JavaScript -->
    <script src="../js/agency.min.js"></script>

</body>

</html>
