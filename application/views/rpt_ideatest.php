<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="VarenisCIMS @ Gurgoan">
    <meta name="author" content="">

    <title>Digiadmin</title>

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
               

	<center> <h4 style="font-weight:600"><u>SAMPLE OUTPUT REPORT</u> </h4></center><br><br> 
       <?php $pt=$prd;
          if($pt==1 || $pt==5)
          {
       ?>
  <center><a class="page-scroll" href="inquiry?pt=<?=$pt;?>" target="_blank"><button>INQUIRE NOW</button></a></center>
        <div class="full_page_section1" style="clear:left;">
                
                    <div class="col-5">
                    <div class="well" style="height:800px;width:700px;">
                        <img src="<?php echo base_url(); ?>public/img/irpt_<?=$pt;?>a.jpg" height=755px width=650px/>
    			
  		    </div>	
                </div>
                <div class="col-5" style="float:left;">
                    <div class="well" style="height:800px;width:700px;">
                        <img src="<?php echo base_url(); ?>public/img/irpt_<?=$pt;?>b.jpg" height=755px width=650px/>
                </div>
                
              </div>
            </div></div>
            <br>   <center><a class="page-scroll" href="inquiry?pt=<?=$pt;?>" target="_blank"><button>INQUIRE NOW</button></a></center> <br><br>
          <?php 
         } 
         else
          {
          ?>
          
            <br> <center><a class="page-scroll" href="inquiry?pt=<?=$pt;?>" target="_blank"><button>INQUIRE NOW</button></a></center><br><br>

          <?php } ?>
</section>

</html>