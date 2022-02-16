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
                        <a class="page-scroll" href="#aboutus">About Us</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#workus">Work With Us</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#features">Our Capability</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#wedo">What We Do</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#team">Team</a>
                    </li>
                   <!--  <li>
                        <a class="page-scroll" href="home/products">Product</a>
                    </li> -->
                    <li>
                        <a class="page-scroll" href="#contact">Contact</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="blogs/">Blog</a>
                    </li>
                    <li>
                        <!-- <a class="page-scroll" onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Login</a> -->
                        <a class="page-scroll" href="<?php echo base_url(); ?>home/login">Login</a>
                    </li>
                   <!-- <li>
                        <a class="page-scroll" href="home/startup" target="_blank"><b>Startup & Investor</b></a>
                    </li> -->

                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

       <!-- Header -->


 <!-- Header Section -->
   <!-- Header -->
    <header> 
  <!-- <button style="position:absolute; top:80px; right: 10px; height:70px;width:250px; background-color:white;color:green;font-size:150%;border-radius: 0px;border-color: lightgreen;"> 
  -->

                <div class="intro-heading" id=sb></div>

        <div class="container"> 
            <div class="intro-text"> 
                <div class="intro-lead-in2" style="font-size:50px;font-family: sans-serif;">CONSUMER INTELLIGENCE RENDERED</div>
                  
                
            </div>
        </div>
    </header>



    <!-- about Section -->
   <section id="aboutus" style="color:green;">
		<div class="col-12">
                  <div class="alert alert-success1">
                              <center><u><h3 style="font-weight:600">ABOUT US</h3></u></center><br><br>

 

							  <p style="font-size:18px;padding:5px">Varenia Consumer Insights and Measurement Solutions is a Full Service Market Research Agency striving to develop a better understanding of consumer behaviour for the benefit of our clients.We develop and implement innovative market research techniques for improving the Effectiveness and Efficiency of current market research techniques (both Quantitative or Qualitative research) for consumer facing industries
<br><br>Varenia was started in September 2012 based out of Gurgaon, Delhi NCR, India. Our professionals have years of previous Market Research experience in Market Research agencies, client roles in FMCG Companies, Analytics Firms and Consultancies.<br><br> 
And along with Computer hardware and software professionals and Data analysis experts, our team is uniquely positioned to develop and deliver on the innovative techniques which rethink the way we set out to measure consumer behaviour.
That is what makes many of our Market research tools and techniques as 'Firsts in India' and some of them could even be 'Firsts in the world of Market Research.
							  </p>
                            </div>  
                    <!-- /.panel -->
                </div>
		</section>

    <!-- Why work with us Grid Section -->
    <section id="workus" class="bg-light-gray" style="width: 100%;height: 100%;padding: 5px;background-color: white;color: green;margin: 0px;">
<div id="wrapper">
			<div class="col-12">
				<div class="panel-body">
                <center><u><h3 style="font-weight:600;color:rgb(0, 102, 0);">WHY WORK WITH US?</h3></u></center><br><br> 
<div class="col-4">
                    <div class="well">
                        <img src="/public/img/whywork/1.png" style="float:left;height:60px; width:80px;margin-left:15px;" class="img-responsive"  alt=""">
                        <span style="color:rgb(0, 102, 0);font-size:18px"><em>Innovative Solutions</em></span><br><br><br>
						<p style="font-weight:50px;color:rgb(0, 102, 0)">Our solutions bring our expertise in understanding consumers with technology for better insights.</p>
						
                    </div>
                </div>
				<div class="col-4" style="float: left;">
                    <div class="well">
                        <img src="/public/img/whywork/2.png" style="float:left;height:60px; width:80px;margin-left:15px;" class="img-responsive"  alt=""">
                        <span style="color:rgb(0, 102, 0);font-size:18px"><em>Sharper Insights</em></span><br><br><br>
						<p style="font-weight:50px;color:rgb(0, 102, 0)">We strive to provide our clients with actionable indepth insights beyond what just meets the eye
.</p>
						
                    </div>
                </div>
				<div class="col-4"  style="float: left;">
                    <div class="well" >
                        <img src="/public/img/whywork/3.png" style="float:left;height:60px; width:80px;margin-left:15px;" class="img-responsive"  alt=""">
                        <span style="color:rgb(0, 102, 0);font-size:18px"><em>Quicker Turnaround</em></span><br><br><br>
						<p style="font-weight:50px;color:rgb(0, 102, 0)">Our processes are optimised to ensure efficiencies in data collection to reporting .</p>
						
                    </div>
                </div>
				<div class="col-4">
                    <div class="well">
                        <img src="/public/img/whywork/4.png" style="float:left;height:50px; width:80px;margin-left:15px;" class="img-responsive"  alt=""">
                        <span style="color:rgb(0, 102, 0);font-size:18px"><em>Cost Effective</em></span><br><br>
						<p style="float:left;font-weight:50px;color:rgb(0, 102, 0)">We pass on the benefits of cost efficiencies due to process optimisations and innovations thus reducing the cost of each study as compared to other companies
.</p>
						
                    </div>
                </div>
				<div class="col-4"  style="float: left;">
                    <div class="well">
                        <img src="/public/img/whywork/6.png" style="float:left;height:50px; width:80px;margin-left:15px;" class="img-responsive"  alt=""">
                        <span style="color:rgb(0, 102, 0);font-size:18px"><em>Simple Solutions
</em></span><br><br>
						<p style="float:left;font-weight:50px;color:rgb(0, 102, 0)">Our solutions simplify the entire marketing research process ensuring to the point actionable insights for even the most novice marketer
.</p>
						
                    </div>
                </div>
				<div class="col-4"  style="float: left;">
                    <div class="well">
                        <img src="/public/img/whywork/mobile.png" style="float:left;height:60px; width:80px;margin-left:15px;" class="img-responsive"  alt=""" width="50px" height="50px">
                        <span style="color:rgb(0, 102, 0);font-size:18px"><em>Web/App Based Survey
</em></span><br><br><br>
						<p style="float:left;font-weight:50px;color:rgb(0, 102, 0)">We have online web based survey and mobile/tablet based survey solutions for quicker results/insights.</p>
						
                    </div>
                </div>
				
			
                </div>
			</div>
		</div>
    </section>

    <!-- Our Capability Section -->
    <section id="features" style="width: 100%;height: 100%;padding: 5px;background-color: white;color: green;">
       
            
<div id="wrapper">
		<div class="col-12">  
				<div class="panel-body alert alert-success1" style="border:none;">
				  <center><u><h3 style="font-weight:600">Our Capability</h3></u></center><br><br>
            <div class="full_page_section1">
                <div class="col-3" style="float:left;">
                    <div class="floating-box1" style="width:290px;height:250px;padding:15px;">
    			
    			 <h5><img src="/public/img/features/5.png" style="height:60px; width:80px;" class="img-responsive" alt=""> <br>Quantitative Interviews</h5>
                         <p style="clear:left; padding: 0px;">We have strong team of researchers experienced in quantitative research techniques to suit them as per your requirements</p>
  			
                    </div>
                </div>
              
                <div class="col-3" style="float:left;">
                   <div class="floating-box1" style="width:290px;height:250px;padding:15px;">
    			
    			<h5> <img src="/public/img/features/221.png" style="height:60px; width:80px;" class="img-responsive" alt=""><br>Focus Group Discussions</h5>
                        <p style="clear:left; padding: 0px;">We have a specialized team of experienced researchers whose expertise is in conducting and analyzing FGDs in the most robust way</p>
  			
                    </div>
                </div>
                <div class="col-3" style="float:left;">
                    <div class="floating-box1" style="width:290px;height:250px;padding:15px;">
    			
    			<h5> <img src="/public/img/features/7.png" style="height:60px; width:80px;" class="img-responsive" alt=""><br>Mobile/Tablet interviews</h5>
                        <p style="clear:left; padding: 0px;">Our most of the quantitative interviews are done through app based modules on smartphones/ tablets, as well as online researches</p>
                    </div>
                </div>
                <div class="col-3" style="float:left;">
                    <div class="floating-box1" style="width:290px;height:250px;padding:15px;">
    		
    			<h5> <img src="/public/img/features/9.png" style="height:60px; width:80px;" class="img-responsive" alt=""><br>Analytics</h5>
                        <p style="clear:left; padding: 0px;">Our analytics division is equipped with the capability to mine the data in the most useful way possible</p>
  			
                    </div>
                </div>
                <div class="col-3" style="float:left;">
                    <div class="floating-box1" style="width:290px;height:250px;padding:15px;">
                          
    			<h5> <img src="/public/img/features/10.png" style="height:45px; width:80px;" class="img-responsive" alt=""><br>Telephonic interviews</h5>
                        <p style="clear:left; padding: 0px;">We also conduct many of our projects through telephonic interviews with respondents</p>
  			
                    </div>
                </div>
                <div class="col-3" style="float:left;">
                    <div  class="floating-box1" style="width:290px;height:250px;padding:15px;">
    		
    			<h5><img src="/public/img/features/11.png" style="height:45px; width:80px;" class="img-responsive" alt=""> <br>Ethnographies</h5>
                        <p style="clear:left; padding: 0px;">We have experienced designated ethnographers with years of experience who are specialized in conducting varied types of ethnographies</p>
  			
                    </div>
                </div> 
                <div class="col-3" style="float:left;">
                    <div  class="floating-box1" style="width:290px;height:250px;padding:15px;">
    			
    			<h5><img src="/public/img/features/12.png" style="height:40px; width:75px;" class="img-responsive" alt=""> <br>Face-to-Face Sessions</h5>
                        <p style="clear:left; padding: 0px;">Team of researchers on board equipped to execute depth-interviews, consumer immersions, life journeys, decision making journey in depth</p>
  			
                    </div>
                </div> 
                <div class="col-3" style="float:left;">
                    <div  class="floating-box1" style="width:290px;height:250px;padding:15px;">
    			
    			<h5> <img src="/public/img/features/13.png" style="height:45px; width:80px;" class="img-responsive" alt=""><br>Consumer Panels</h5>
                        <p style="clear:left; padding: 0px;">We have a panel of respondents using various categories to answer your research queries in the shortest time possible</p>
  			
                    </div>
                </div> 
               </div>
    </div>
    </section>
<!-- What do we do Section -->
 
    <section id="wedo" style="width: 100%;height: 100%;padding: 5px;background-color: white; margin: 0px;color: green;">
        <div id="wrapper">
			<div class="col-12">
				<div class="panel-body ">
               

	<center><u><h3 style="font-weight:600;color:rgb(0, 102, 0)">WHAT WE DO?</h3></u></center>
	<div class="panel-body col-12">
            
                <div class="floating-box1 col-12" style="clear:left;height: 110px;border-top: 3px solid #DCEDC8;border:none;">
                        <div class="ccontainerh">
    			 <h4><img src="/public/img/whatdo/14.png" style="height:60px; width:80px;float:left; margin-right:5px;" class="img-responsive" alt=""><br>Evaluation</h4>
                        <p style="clear: left;padding: 5px;">Evaluate your brands positioning, product, packs, price, etc. before launching it in the market.</p><br>
                        </div>
  		</div>	
         </div>
               <div class="col-3">
                    <div class="well" style="height:250px;">
                    
    			 <h5><img src="/public/img/whatdo/17.png" style="height:60px; width:80px;float:left;margin:5px;" class="img-responsive" alt="">Concept Evaluator</h5>
                        <p style="clear:left;padding: 15px;">Evaluate your brand positioning concepts with your target group by Varenia’s quick and robust Concept Testing solution</p>
  		    </div>
                </div>
                <div class="col-3" style="float:left;">
                    <div class="well" style="height:250px;">
                
    			<h5> <img src="/public/img/whatdo/18.png" style="height:60px; width:80px;float:left;margin-left:5px;" class="img-responsive" alt=""><br>Product Evaluator</h5>
                        <p style="clear:left;padding: 15px;">Varenia's Product Evaluator suite of products are designed to enable you to place the best product in the market or to optimise your existing product for cost or scale efficiencies</p>
  	            </div>
                </div> 
                <div class="col-3" style="float:left;">
                    <div class="well" style="height:250px;">
    			<h5><img src="/public/img/whatdo/23.png" style="height:60px; width:80px;float:left;margin-left:5px;" class="img-responsive" alt=""> <br>Pack Evaluator</h5>
                        <p style="clear:left;padding: 15px;">Varenia’s packaging evaluation tools enables you to get the best packaging option out to win the battle at the store shelf</p>
  		    </div>	
                </div> 
                <div class="col-3" style="float:left;">
                    <div class="well" style="height:250px;">
    			<h5><img src="/public/img/whatdo/24.png" style="height:60px; width:80px;float:left;margin-left:5px;" class="img-responsive" alt=""><br>Advertisement Evaluator</h5>
                        <p style="clear:left;padding: 15px;">Get a comprehensive evaluation of advertisements, narramatics, scripts, etc. for more effective communication</p>
  		    </div>
                </div> 
                <div class="col-3" style="float:left;">
                    <div class="well" style="height:250px;">
    			<h5><img src="/public/img/whatdo/25.png" style="height:60px; width:80px;float:left;margin-left:5px;" class="img-responsive" alt=""><br>Activity Evaluator</h5>
                        <p style="clear:left;padding: 15px;">Evaluate the effectiveness of the various events, sampling and other activities you do for your brand</p>
  		    </div>	
                </div> 
                <div class="col-3" style="float:left;">
                    <div class="well" style="height:250px;">
                    
    			<h5><img src="/public/img/whatdo/31.png" style="height:60px; width:80px;float:left;margin-left:5px;" class="img-responsive" alt=""><br>Price Evaluator</h5>
                        <p style="clear:left;padding: 15px;">The right pricing for your product can make or break your product in the market. Get confidence on your pricing with Varenia’s pricing evaluator tool for the most optimal pricing for your product</p>
  			</div>
                </div>
                <div class="col-3" style="float:left;">
                    <div class="well" style="height:250px;">
                        
    			<h5><img src="/public/img/whatdo/33.png" style="height:60px; width:80px;float:left;margin-left:5px;" class="img-responsive" alt=""><br>App/ Website Evaluator</h5>
                        <p style="clear:left;padding: 15px;">Get a comprehensive evaluation of advertisements, narramatics, scripts, etc. for more effective communication</p>
  			</div>
                </div>
                <div class="col-3" style="float:left;">
                    <div class="well" style="height:250px;">
    			<h5><img src="/public/img/whatdo/34.png" style="height:60px; width:80px;float:left;margin-left:5px;" class="img-responsive" alt=""><br>Shop Elements Evaluator</h5>
                        <p style="clear:left;padding: 15px;">Test out your POS Materials, danglers etc. to maximise visibility and comprehension</p>
  			
                </div>    
            </div>
                
                 <div class="floating-box1 col-12" style="clear:left;height: 130px;border-top: 3px solid #DCEDC8;border:none;">                  
                        <div class="ccontainerh">
    			<h4> <img src="/public/img/whatdo/exploration.png" style="height:60px; width:60px;float:left;margin-right:15px;" class="img-responsive" alt=""><br>Exploration</h4><br>
                        <p style="clear: left;padding: 5px;margin-left:1px;">Explore potential opportunities, ideas, bottleneck to sales for your brand, issues or hypotheses around the performance of your brand.</p>
  			</div>      
                  </div>

                <div class="full_page_section1" style="clear:left;">
                <div class="col-4">
                    <div class="well" style="height:250px;">
                    
    			<h5><img src="/public/img/whatdo/19.png" style="height:60px; width:80px;float:left;margin-left: 5px;" class="img-responsive" alt=""> <br>Usage Exploration</h5>
                        <p style="clear:left; padding: 15px;">Explore the current and potential users of your products, their profiles, usage and purchase behaviour, etc.</p>
  		    </div>	
                </div>
                <div class="col-4" style="float:left;">
                    <div class="well" style="height:250px;">
                    
    			<h5><img src="/public/img/whatdo/20.png" style="height:60px; width:80px;float:left;margin-left: 5px;" class="img-responsive" alt=""> <br>Shopper Exploration</h5>
                        <p style="clear:left;padding: 15px;">Find out who is the person buying your product, what he/she prioritises and his/her decision making process</p>
  		 </div>	
                </div>
                <div class="col-4" style="float:left;">
                    <div class="well" style="height:250px;">
    			<h5><img src="/public/img/whatdo/26.png" style="height:60px; width:80px;float:left;margin-left: 5px;" class="img-responsive" alt=""> <br>Brand Equity</h5>
                        <p style="clear:left;padding: 15px;">Understand how strong is your brand among your current and potential consumers vis-à-vis your competing brands</p>
  			</div>
                </div>
               <div class="col-4" style="float:left;">
                    <div class="well" style="height:250px;">
    			<h5><img src="/public/img/whatdo/27.png" style="height:60px; width:80px;float:left;margin-left: 5px;" class="img-responsive" alt=""> <br>Bottleneck identification</h5>
                        <p style="clear:left;padding: 15px;">Get to know what factors are limiting the performance of your brand in the market and how to mitigate those factors</p>
  		</div>	
                </div>
                <div class="col-4" style="float:left;">
                    <div class="well" style="height:250px;">
    			<h5><img src="/public/img/whatdo/35.png" style="height:60px; width:80px;float:left;margin-left: 5px;" class="img-responsive" alt=""> <br>Quick Queries</h5>
                        <p style="clear:left;padding: 15px;">Have a few simple questions to quickly check and get information from your TG in the shortest time possible? Our Quick Queries tool has been tailor made for these requirements</p>
  		    </div>
                </div>
                 <div class="col-4" style="float:left;">
                    <div class="well" style="height:250px;">
    			<h5><img src="/public/img/whatdo/36.png" style="height:60px; width:80px;float:left;margin-left: 5px;" class="img-responsive" alt=""> <br>Quick Hypotheses testing</h5>
                        <p style="clear:left;padding: 15px;">You have an hypotheses for why a certain consumer base is behaving in a certain way, and you want to test it out in the shortest time possible. Our Quick Hypotheses testing tool is the right solution for these scenarios</p>
  			</div>
                </div>
                   
                <div class="floating-box1 col-12" style="clear:left;height: 110px;border-top: 3px solid #DCEDC8;border:none;">
                   
                        <div class="ccontainerh">
    			<h4><img src="/public/img/whatdo/16.png" style="height:60px; width:80px;float:left;margin-right: 5px;" class="img-responsive" alt=""/><br>Estimation</h4><br>
                        <p style="clear: left;padding: 15px;">Estimate the potential of your ideas, concepts, products with your target consumers for better launch preparedness.<br></p><br>
  		</div>
                </div>  
               <div class="full_page_section1" style="clear:left;">
               <div class="col-4">
                    <div class="well" style="height:256px;">
                    
    			<h5><img src="/public/img/whatdo/21.png" style="height:60px; width:90px;float:left;margin: 2px;" class="img-responsive" alt=""> <br>Market Sizing</h5>
                        <p style="clear:left;padding: 5px;">Estimate the potential volumes/ value which can be generated by your product before launch for making more efficient launch plans</p>
  			</div>
                </div>
               <div class="col-4" style="float:left;">
                    <div class="well"  style="height:256px;">
    			<h5><img src="/public/img/whatdo/22.png" style="height:60px; width:80px;float:left;margin: 2px;" class="img-responsive" alt=""> <br>Special Segments Sizing</h5>
                        <p style="clear:left;padding: 3px;">Is there a special segment that your product is catering to, and you want to estimate the size of the segment in the market? Our special segment sizing tool is the perfect tool for you to measure the size of this segment, profile and current usage of products</p>
  			</div>
                </div>
               <div class="col-4" style="float:left;">
                    <div class="well"  style="height:256px;">
    			<h5><img src="/public/img/whatdo/28.png" style="height:60px; width:80px;float:left;margin: 2px;" class="img-responsive" alt=""> <br>Idea potential</h5>
                        <p style="clear:left;padding: 5px;">When you have many ideas or versions of them and want to do a quick estimation of the potential of the ideas to decide on which idea to pursue</p>
  		</div>	
                </div> 
                <div class="col-4" style="float:left;">
                    <div class="well"  style="height:250px;">
    			<h5><img src="/public/img/whatdo/29.png" style="height:60px; width:80px;float:left;margin: 5px;" class="img-responsive" alt=""> <br>Concept potential</h5>
                        <p style="clear:left;padding: 15px;">From the ideas when you have crystallised them into a concept which you want to check the market potential before selecting which concept to go ahead with</p>
  		 </div>	
                </div>
                <div class="col-4" style="float:left;">
                    <div class="well"  style="height:250px;">
    			<h5><img src="/public/img/whatdo/30.png" style="height:55px; width:80px;float:left;margin-left: 5px;" class="img-responsive" alt=""> <br>Promo potential</h5>
                        <p style="clear:left;padding: 15px;">Estimate the potential volumes/ value uptick rom the promotional offers you are planning to run on your brand</p>
  		 </div>	
                </div>
                
               </div>
               </div></div>
</section>

<section id="team" style="width: 100%;height: 100%;padding: 5px;background-color: white;color: green;margin: 0px;">
       <div id="wrapper">
	<div class="col-12">
	<div class="panel-body alert alert-success1">
	<center><u><h3 style="font-weight:600">OUR TEAM</h3></u></center><br>
			<div class="alert alert-success col-5 text-center" style="margin:20px;float:left;background-color:#fbffff;">
                             <h4><b><u>MRIGANKA SHOME</u></b></h4> 
				<h5>CEO & DIRECTOR</h5>
				<ul class="list-inline social-buttons" >
                        <li><a href="https://in.linkedin.com/in/mriganka-shome-2230b610" target="_blank"> <i class="fa fa-linkedin"></i></a>
                        </li>
                    	</ul>
                        </div>
			<div class="alert alert-success col-5 text-center" style="margin:20px;float:left;background-color:#fbffff;">
			      <h4><b><u>SHAKTI BANERJEE</u></b></h4>
				<h5>CLIENT ENGAGEMENT DIRECTOR</h5>
                                <ul class="list-inline social-buttons">
            			<li><a href="#" target="_blank" > <i class="fa fa-linkedin"></i></a>
                                  </li>
                           </ul>
                        </div>
			<div class="alert alert-success col-5 text-center" style="margin:20px;float:left;background-color:#fbffff;">
			    <h4><b><u>PRIYA NEVTIA</u></b></h4>
                            <h5>INSIGHT MANAGER</h5> 
			    <h6>QUALITATIVE DEPT.</h6>
                         <ul class="list-inline social-buttons">
                        <li><a href="https://in.linkedin.com/in/priya-nevtia-a952591b" target="_blank"> <i class="fa fa-linkedin"></i></a>
                        </li>
                    	</ul>
                       </div>
                        <div class="alert alert-success col-5 text-center" style="margin:20px;float:left;background-color:#fbffff;">
                            <h4><b><u>RAHUL DHAR</u></b></h4>
                            <h5>RESEARCH DIRECTOR</h5>
                            <h6>QUANTITATIVE DEPT.</h6>
                         <ul class="list-inline social-buttons">
                        <li><a href="https://in.linkedin.com/in" target="_blank"> <i class="fa fa-linkedin"></i></a>
                        </li>
                        </ul>
                       </div>
                        <div class="alert alert-success col-5 text-center" style="margin:20px;float:left;background-color:#fbffff;">
                            <h4><b><u>NALINI SINGH</u></b></h4>
                            <h5>INSIGHT MANAGER</h5>
                            <h6>QUALITATIVE DEPT.</h6>
                         <ul class="list-inline social-buttons">
                        <li><a href="https://in.linkedin.com/in/" target="_blank"> <i class="fa fa-linkedin"></i></a>
                        </li>
                        </ul>
                       </div>

			<div class="col-8" style="float:right;">
                                <p> <i>  Many more Varenians...and growing</i></p>
                        </div> 				
	
	</div>
	</div>
	</div>


        <div id="wrapper">
		
            <div class="full_page_section_team col-12" style="height:380px;">
                
             <div class="row">
                <div class="col-12 text-center">
                    <h4 class="section-heading"><br>Some of Our Clients</h4><br><br>
                    <h4 class="section-subheading text-muted"></h4>
                </div>
            </div>
           <div class="col-6" style="float:left;">
                  <img src="/public/img/logos/left.png" class="img-responsive img-centered" alt="" style="float: left;width:1250px;height:250px;padding: 15px;float:right;">
           </div>
           <div class="col-6" style="float:left;">
                  <img src="/public/img/logos/right.png" class="img-responsive img-centered" alt="" style="float: left;width:1250px;height:220px;padding: 15px;float:right;">
           </div>
           
 
             </div>
             </div></div>
</div>
</section>

    <!-- Contact Section -->
    <section id="contact" style="background-color: white;">
                  
                 <div id="wrapper">
			<div class="col-12">
				<div class="panel-body" style="color:green;">
	<center><u><h3 style="font-weight:600;color:rgb(0, 102, 0)">Contact Us</h3></u></center><br><br>
       
	<div class="floating-box_team col-5" style="margin-right:90px;">
                    <form name="sentMessage" id="contactForm" novalidate>
                        <div class="row">
                           
                            <div class="col-md-6">
                                <div class="form-group">
                                    <h6>Name:</h6><input type="text" class="form-control" placeholder="Your Name *" id="name" required data-validation-required-message="Please enter your name." style="height:40px">
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="form-group">
                                    <h6>Email:</h6><input type="email" class="form-control" placeholder="Your Email *" id="email" required data-validation-required-message="Please enter your email address." style="height:40px">
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="form-group">
                                    <h6>Mobile:</h6><input type="tel" class="form-control" placeholder="Your Phone *" id="phone" required data-validation-required-message="Please enter your phone number." style="height:40px">
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                   <h6>Your Message:</h6> <textarea class="form-control" placeholder="Your Message *" id="message" required data-validation-required-message="Please enter a message." style="height:140px;"></textarea>
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-12 text-center">
                                <div id="success"></div>
                                <button type="submit" class="btn" style="background-color:lightgreen;" onClick = "getcontact();">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>

               <div class="floating-box_team col-6" >
	         <b><h4 style="font-weight:600;color:rgb(0, 102, 0)">OUR OFFICE ADDRESS</h4><b>

                 <p style="color:rgb(0, 102, 0)"> 308, 3th Floor, ABW Tower, MG Road, IFFCO Chowk,<br> Gurgaon, Haryana- 122002<br>

                  Phone: +91-1244055205<br>

                  Email : contact.vcims@gmail.com</p><br>
                  
                  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
                    <div style="overflow:hidden;height:300px;width:350px;"><div id="gmap_canvas" style="height:300px;width:380px;"></div>
              
                    <style>#gmap_canvas img{max-width:none!important;background:none!important}</style>
                    <a class="google-map-code" href="https://www.digiadmin.quantumcs.com" id="get-map-data">Digiadmin Pvt. Ltd.</a>
                    </div>
                  <script type="text/javascript"> function init_map()
                  {
                   var myOptions = {zoom:15,center:new google.maps.LatLng(28.478534,77.071581),mapTypeId:google.maps.MapTypeId.ROADMAP};
                   map = new google.maps.Map(document.getElementById("gmap_canvas"), myOptions);
                   marker = new google.maps.Marker({map: map,position: new google.maps.LatLng(28.478726, 77.071549)});
                   infowindow = new google.maps.InfoWindow({content:"<b>Digiadmin Pvt. Ltd.</b><br/>308, ABW Tower, IFFCO Chowk, Gurgoan " });
                   google.maps.event.addListener(marker, "click", function() 
                   {
                         infowindow.open(map,marker);});infowindow.open(map,marker);
                   }
                   google.maps.event.addDomListener(window, 'load', init_map);
                  </script>
                          <div class="clear"></div>
                    </div>


	       </div>    
            

        </div>
    </section>

<!-- for login form below are code-->

    <div id="id01" class="modal">
  
  <form  class="modal-content animate"  novalidate>
    <div class="imgcontainer">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="User Login">&times;</span>

    </div>
   <center><h4>User Login</h4></center>
    <div class="containerl">
      <label><b>Username</b></label>
      <input type="text" placeholder="Enter Username" id="uid" name="uid" required>

      <label><b>Password</b></label>
      <input type="password" placeholder="Enter Password" id="pass" name="pass" required>
         <div id="lst" style="color:red;"> </div>
      <button type="button" id="lbtn" name="btnn_login" class="button2">Login</button>
      <!-- <input type="checkbox" checked="checked"> Remember me -->
       
    </div>

    <div class="containerl" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn5">Cancel</button>
      <span class="psw">Forgot <a href="#">password?</a></span>
    </div>
  </form>

</div>

    <footer >
        <div class="container" style="color:green;">
               <div class="col-md-4">
                    <span class="copyright"> &copy; 2019 Digiadmin Private Limited. All Rights Reserved.</span> | <a href="/v/welcome/termpolicy"style="color:gray;"> Term & Policy</a>
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


    <!-- jQuery -->
    <script src="public/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="public/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

    <!-- Contact Form JavaScript -->
    <script src="public/js/jqBootstrapValidation.js"></script>
    <script src="public/js/contact_me.js"></script>
 

    <!-- Theme JavaScript -->
    <script src="public/js/agency.min.js"></script>


</body>
<script>
function getcontact()
{   
    var queryString ='';
   var name = document.getElementById('name').value;
   var email = document.getElementById('email').value;
   var ph = document.getElementById('phone').value;
   var msg = document.getElementById('message').value;

   queryString = 'name='+name+'&email='+email+'&phone='+ph+'&msg='+msg;
 
jQuery.ajax({
	 url:'<?php echo base_url("siteadmin/sendmemail"); ?>',     
	data:queryString,
	type: "GET",
	success:function(data){  
                $('#success').html("<div class='alert alert-success'>");
                    $('#success > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
                        .append("</button>");
                 
                   $('#success > .alert-success') 
                        .append(data); 
                   
                    $('#success > .alert-success')
                        .append('</div>');
                    //clear all fields
                    $('#contactForm').trigger("reset");
	},
	error:function (){}
	});

}
</script>

<script type="text/javascript">
$(document).ready(function() {

    $('#lbtn').click(function(){
   alert("<?php echo base_url(); ?>application/views/do_login.php");

    var uid=document.getElementById('uid').value;
    var pass=document.getElementById('pass').value;
    $('#lst').html('<img src="img/LoaderIcon.gif" />');
    $.ajax({
    type : "GET",
    data:{uid : uid , pass : pass},
    url : "<?php echo base_url(); ?>application/views/do_login.php",
    success : function(data){
       if (data == 1) {
                    //alert("You will now be redirected.");
                    window.location = "<?php echo base_url(); ?>application/views/mylogin.php";
       }
       else{
    $('#lst').html(data);
        $( "#lst" ).dialog(); }
    }

    });
    });
});

</script>

</html>

