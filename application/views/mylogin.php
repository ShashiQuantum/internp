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
                            <a href="#"><i class="fa fa-comment fa-fw"></i> Project Details<span class="fa arrow"></span></a>
                         <?php $vuid=$_SESSION['vwebuser'];   $arr_upl=$projects;
                         // $arr_upl=get_project_list($vuid); 
                           
                        if(!empty($arr_upl))
                        {
                         foreach($arr_upl as $ap)
                         { 
                            $pn=$ap->name;
                            $pid=$ap->project_id;
                            $pbrand=$ap->brand;
                            $psdt=$ap->survey_start_date;
                            $pedt=$ap->survey_end_date;
                            $ptable=$ap->data_table;
                            $pst=$ap->status; $p_st=($pst==1)?'Running':'Closed';
                            $pcn=$ap->company_name;
                        ?>
                            <ul class="nav nav-second-level">

                                <li>
                                    <a href="#"> <?=$pn; ?> </a>
                                </li>
                                
                            </ul>
                            <?php }}  ?>
                            <!-- /.nav-second-level -->

                        </li>

                          <li>
                            <a href="#"><i class="fa fa-dashboard fa-fw"></i> Dashboard <span class="fa arrow"></span></a>
                             <?php $vuid=$_SESSION['vwebuser']; $arr_upl=$projects;
                           //$arr_upl=get_project_list($vuid); 

                        if(!empty($arr_upl))
                        {
                         foreach($arr_upl as $ap)
                         { 
                            $pn=$ap->name;
                            $pid=$ap->project_id;
                            $pbrand=$ap->brand;
                            $psdt=$ap->survey_start_date;
                            $pedt=$ap->survey_end_date;
                            $ptable=$ap->data_table;
                            $pst=$ap->status; $p_st=($pst==1)?'Running':'Closed';
                            $pcn=$ap->company_name;
                        ?>
                            <ul class="nav nav-second-level">
                            <?php 
                            if($pid==50)
                            {
                            ?>
                                <li><a href="https://digiadmin.quantumcs.com/vcims/adminpanel/md_dashboard_safal.php" title="Google Me" target="_blank"><?=$pn; ?></a>
                                     
                                </li>
                            <?php 
                            }
                            else
                            {
                            ?> 
                            
                                <li>
                                    <a href="#"><?=$pn; ?></a>
                                </li>
                            <?php 
                            }
                                                       
                            ?>  </ul>   
                            <?php }}  ?>
                            <!-- /.nav-second-level -->
                        </li>
                   	<li>
                            <a  href="#"><i class="fa fa-sign-out fa-fw"></i>My Order<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">

                                <li>
                                    <a id="myo2" href="<?php echo base_url(); ?>welcome/neworder" > Place New Order </a>
                                </li>
                                 <li>
                                    <a id="myo2" href="<?php echo base_url(); ?>welcome/vieworderlist" > View Order List</a>
                                </li>
                             </ul>
                        </li>
                         
                        <li>
                            <a  href="#"><i class="fa fa-sign-out fa-fw"></i>Payment<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">

                                <li>
                                    <a id="myo2" href="<?php echo base_url(); ?>welcome/newpayment" > Make Payment </a>
                                </li>
                                 <li>
                                    <a id="myo2" href="<?php echo base_url(); ?>welcome/viewpayment" > View Payment Details</a>
                                </li>
                             </ul>
                        </li>

                        <li>
                            <a href="<?php echo base_url(); ?>welcome/changepass"><i class="fa fa-edit fa-fw"></i> Change Password</a>
                        </li>
                        
                       
                       
                 </div>
</div>

   <br><br>
<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
             <?php  if($rqpost=='')  { ?>

                <div class="row" id="pdtls">
                    <div class="col-lg-12">
                        <h5 class="page-header">Project Details </h5>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                        <?php $vuid=$_SESSION['vwebuser'];	 $arr_upl=$projects;
                          // $arr_upl=get_project_list($vuid); 

                        if(!empty($arr_upl))
                        {
                         foreach($arr_upl as $ap)
                         { 
                            $pn=$ap->name;
                            $pid=$ap->project_id;
                            $pbrand=$ap->brand;
                            $psdt=$ap->survey_start_date;
                            $pedt=$ap->survey_end_date;
                            $ptable=$ap->data_table;
                            $pst=$ap->status; $p_st=($pst==1)?'Running':'Closed';
                            $pcn=$ap->company_name;
                        ?>
                <div class="col-12" style="height:380px;border: 1px solid #d6e9c6;">
                     <div class="col-10" style="height:40px;background-color:#fffff;border-bottom: 1px solid #d6e9c6;float:left;margin:20px;"> Project: <span style="color:green;margin-left:120px;"> <?= strtoupper($pn); ?></span></div>
                     <div class="col-10" style="height:40px;background-color:#fffff;border-bottom: 1px solid #d6e9c6;float:left;margin:20px;">Brand: <span style="color:green;margin-left:125px;"> <?= strtoupper($pbrand).' ('.$pcn.')'; ?></span></div>
                     <div class="col-10" style="height:40px;background-color:#fffff;border-bottom: 1px solid #d6e9c6;float:left;margin:20px;">Project Start Date: <span style="color:green;margin-left:50px;"> <?= $psdt; ?></span></div>
                     <div class="col-10" style="height:40px;background-color:#fffff;border-bottom: 1px solid #d6e9c6;float:left;margin:20px;">Project End Date: <span style="color:green;margin-left:55px;"> <?= $pedt; ?> </span></div>
                     <div class="col-10" style="height:40px;background-color:#fffff;float:left;margin:20px;">Project Status:<span style="color:green;margin-left:75px;"> <?= $p_st; ?> </span></div>
                </div>
                       <?php }}else echo "No Record Available"; ?>

                <!-- /.row -->
            </div>
         <?php } if($rqpost!='') { ?>
                  <div class="row" id="pdtls">
                    <div class="col-lg-12">
                        <h5 class="page-header">Your Order Request Sent Successfully. </h5>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
               <div class="col-12" style="height:400px;">
           <?php echo "<font color=red size=2> $rqpost </font>"; }  ?>  
              
            <!-- /.container-fluid -->
        </div>

     </div>
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


