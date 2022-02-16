<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="VarenisCIMS @ Gurgoan">
    <meta name="author" content="">

    <title>Inquiry-Digiadmin</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/vendor/bootstrap/css/bootstrap.min.css" >
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/my2.css">
    <!-- Custom Fonts -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/vendor/font-awesome/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

    <!-- Theme CSS & topbar-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/agency2.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/agency2.min.css" >

    

<style>
/* Extra styles for the cancel button */
.cancelbtn {
    width: auto;
    padding: 10px 18px;
    background-color: #f44336;
}

/* Center the image and position the close button */
.imgcontainer {
    text-align: center;
    margin: 24px 0 12px 0;
    position: relative;
}

img.avatar {
    width: 40%;
    border-radius: 50%;
}

.containerl {
    padding: 16px;
}

span.psw {
    float: right;
    padding-top: 16px;
}
.button2 {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
}
/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; 
    height: 100%; 
    overflow: auto; 
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    padding-top: 60px;
}

/* Modal Content/Box */
.modal-content {
    color:black;
    background-color: #fefefe;
    margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
    border: 1px solid #888;
    width: 350px; /* Could be more or less, depending on screen size */
}

/* The Close Button (x) */
.close {
    position: absolute;
    right: 25px;
    top: 0;
    color: #000;
    font-size: 35px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: red;
    cursor: pointer;
}

/* Add Zoom Animation */
.animate {
    -webkit-animation: animatezoom 0.6s;
    animation: animatezoom 0.6s
}

@-webkit-keyframes animatezoom {
    from {-webkit-transform: scale(0)} 
    to {-webkit-transform: scale(1)}
}
    
@keyframes animatezoom {
    from {transform: scale(0)} 
    to {transform: scale(1)}
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
    span.psw {
       display: block;
       float: none;
    }
    .cancelbtn {
       width: 100%;
    }
}

#contactContent1 { max-width:700px;
width: 100%;
float: left; margin-right:40px;
}
#contactContent2	{ float:left; width:100%; max-width:315px;}

@media only screen and (max-width : 768px) {  #contactContent1,#contactContent2	{ width:100%;}  }

@media only screen and (max-width : 480px) {
	/*contact us page*/
	#contactContent1,#contactContent2	{ width:90%; margin:0 auto; float:none;}
	#contactContent1 textarea{ max-width:185px;}
	#contactContent1 select{ max-width:200px;}

}

#sb div {
    width: 300px;
    height: 100px;
    background-color: yellow;
    box-shadow: 10px 10px 5px #888888;
}
</style>

</head>

<body id="page-top" class="index" style="color:white;">

    <!-- Navigation -->
    <nav id="mainNav" class="navbar navbar-default navbar-custom navbar-fixed-top" style="background-color:white;">
<div style="margin-left: 20px;float:left;position: relative;width:75px;"><a href="#page-top"><img src="<?php echo base_url(); ?>public/img/logos/quantum-logo-big.png" height=80px width=80px/></a></div>
       <!-- <div class="container"> 
            -->
    </nav>





    <!-- about Section -->
   <section id="aboutus" style="color:green;">
		
                              <center> <h4 style="font-weight:600">FOR STARTUP & INVESTORS</h4></center>
                 
		</section>

    
<!-- What do we do Section -->
 
    <section id="wedo" style="width: 100%;height: 100%;padding: 5px;background-color: white; margin: 0px;color: green;">
        <div id="wrapper">
			<div class="col-12">
				<div class="panel-body ">
               

	<center> <h4 style="font-weight:600"><u>Fill up the your detail below for more detail:</u> </h4></center><br><br>
        <center>
        <div class="full_page_section1" style="clear:left;">
                 
                    <div class="col-9"> 
                     <?php echo form_open('welcome/do_inquiry');?> 
         <input type="hidden" name="pt" value="<?php echo $prd; ?>"/>
        <div>Name: </div>
	<div>
	<input type="text" name="name" required placeholder="Enter Your Name" value="<?php echo set_value('name'); ?>" style="background-color: #fffff;height:10%;width:550px;"/>
	 </div>
        <div>Mobile: </div>
	<div>
	<input type="text" name="mobile" required placeholder="Enter Your Mobile" value="<?php echo set_value('mobile'); ?>" style="background-color: #fffff;height:10%;width:550px;"/>
	 </div>
	</div>
        <div>Email ID: </div>
	<div>
	<input type="email" name="email" required placeholder="Enter Your Email" value="<?php echo set_value('email'); ?>" style="background-color: #fffff;height:10%;width:550px;"/>
	 
	</div>
        <div>Working Type: </div>
	<div>
	<input type="text" name="wt" required placeholder="Enter Your Company Name/as Student" value="<?php echo set_value('wt'); ?>" style="background-color: #fffff;height:10%;width:550px;"/>
	 </div><div> 

   <font color=red> <?php echo $msg; ?> </font> </div><div>

                      <input type="submit" value="Send" name="submit_inq" style="background-color: #fffff;height:10%;width:350px;">

                     <?php echo form_close()?>	
                </div>
                
              </div>
            </div></div>
             
          
</section>

</html>