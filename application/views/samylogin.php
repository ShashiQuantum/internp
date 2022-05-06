<?php
//print_r($_SESSION);
  $isSALogin= $this->session->userdata('isSALogin');
    if(!$isSALogin)
    { 
            //Redirect::to('index.php');
             //$this->load->view('sadm_login_form');
    }
    else
    {
	if(!isset($_SESSION['sauserid'])) Redirect::to('https://digiadmin.quantumcs.com/digiamin-web');
            $vuid=$_SESSION['sauserid'];
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>QuantumCS | MyAccount</title>

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

<script>
 $(".parent ul li ul").css("display", "none");
 $(".parent li").click(function (e) {
     e.stopPropagation();
     $(this).children('ul').toggle();
 });
</script>

<style>
.w3-hide{display:none!important}.w3-show-block,.w3-show{display:block!important}.w3-show-inline-block{display:inline-block!important}
</style>

<style>
.multiselect {
  width: 200px;
}

.selectBox {
  position: relative;
}

.selectBox select {
  width: 100%;
  font-weight: bold;
}

.overSelect {
  position: absolute;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
}

#fp {
  display: none;
  border: 1px #dadada solid;
}

#fp label {
  display: block;
}

#fp label:hover {
  background-color: #1e90ff;
}
</style>

<style>
.parent {display: block;position: relative;float: left;line-height: 30px;background-color: #FFF;border-right:#CCC 1px solid;}
.parent a{margin: 10px;color: #FFFFFF;text-decoration: none;}
.parent:hover > ul {display:block;position:absolute;}

.child {display: none;}
.child li {background-color: #E4EFF7;line-height: 30px;border-bottom:#CCC 1px solid;border-right:#CCC 1px solid; width:100%;}
.child li a{color: #000000;}
ul{list-style: none;margin: 0;padding: 0px; min-width:15em;}
ul ul ul{left: 100%;top: 0;margin-left:1px;}
li:hover {background-color: #95B4CA;}
.parent li:hover {background-color: #F0F0F0;}
.expand{font-size:12px;float:right;margin-right:5px;}
</style>


<script type="text/javascript">
    var expanded = false;

	function showCheckboxes() {
	  var checkboxes = document.getElementById("fp");
	  if (!expanded) {
	    checkboxes.style.display = "block";
	    expanded = true;
	  } else {
	    checkboxes.style.display = "none";
	    expanded = false;
	  }
}
</script>


</head>


<body id="page-top" class="index" style="background-color:#dff0d8;">

    <!-- Navigation -->
    <nav id="mainNav" class="navbar navbar-default navbar-custom navbar-fixed-top" style="background-color:white; border-bottom: 3px solid #DCEDC8;">
<div style="margin-left: 20px;float:left;position: relative;width:55px;"><a href="#page-top"><img src="<?php echo base_url(); ?>public/img/logos/quantum-logo-big.png" height=80px width=80px/></a></div>
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
<!-- begin -->
                         <?php  
                          
                         //print_r($_SESSION);
			  $role=$this->session->userdata('sauseridrole');
                     		//     $role=$_SESSION['sauseridrole']; 
				$permission=$_SESSION['permission'];
               if(empty($permission))
                              echo 'You have no access permissions';
              else
              {
                         /* if(in_array('1',$permission))
                              echo 'Found'.in_array('2',$permission);
                          else
                              echo 'Not found';
                           */
                           
                        if($role==1 || $role==2)
                        {
                          
                        ?>
	<li class="parent"><a href="#">Admin</a>
	<ul class="child">
		<li class="parent"><a href="#">User <span class="expand">&raquo;</span></a>
			<ul class="child">
			<li><a onClick = "userAction('usradd','');">New User</a></li>
			<li><a href="#">View User</a></li>
			<li><a href="#">Delete User</a></li>
			</ul>
		</li>
		<li class="parent"><a href="#">Permission <span class="expand">&raquo;</span></a>
			<ul class="child">
			<li><a href="#">New Permission</a></li>
			<li><a href="#">Assign To User</a></li>
			<li><a href="#">View UserPermission</a></li>
			<li><a href="#">Revoke UPermission</a></li>
			</ul>
		</li>
	</ul>
	</li>

<?php
	}

?>

	<li class="parent"><a href="#">Questionnaire</a>
	<ul class="child">
                                 <?php if(in_array('4',$permission)) { ?>
		<li class="parent"><a href="#">Create<span class="expand">&raquo;</span></a>
			<ul class="child">
			<li><a onClick = "userAction('createproject','');">Project</a></li>
			<li><a onClick = "userAction('createqset','');">QuestionSet</a></li>
			<li><a onClick = "userAction('createquestion','');">Question</a></li>
			<li><a onClick = "userAction('createsequence','');">Sequence</a></li>
			<li><a onClick = "userAction('createroutine','');">Routine</a></li>
			</ul>
		</li>
                                 <?php } if(in_array('4',$permission)) { ?>
		<li class="parent"><a href="#">Add<span class="expand">&raquo;</span></a>
			<ul class="child">
			<li><a onClick = "userAction('addqbquest','');">Question of QBank</a></li>
			<li><a href="https://digiadmin.quantumcs.com/vcimsweb/adminpanel/question_trans.php?st=101" target="_blank">Translated Question</a></li>
			<li><a onClick = "userAction('addqbquest','');">Question to QB</a></li>
			<li><a onClick = "userAction('addmedia','');">Question Media</a></li>
			<li><a onClick = "userAction('addqop','');">Question Option</a></li>
			<li><a onClick = "userAction('addsequence','');">Sequence</a></li>
			<li><a href="viewaddpcentre">Project Centre</a></li>
			<li><a onClick = "userAction('addpproduct','');">Project Product</a></li>
			<li><a onClick = "userAction('addpstore','');">Project Store</a></li>
			<li><a onClick = "userAction('addpage','');">Project Age</a></li>
			<li><a onClick = "userAction('addpsec','');">Project SEC</a></li>
			<li><a onClick = "userAction('addarea','');">Area of Centre</a></li>
			<li><a onClick = "userAction('addsubarea','');">Subarea of Centre</a></li>
			<li><a onClick = "userAction('addcentre','');">New Centre</a></li>
			<li><a onClick = "userAction('addrule','');">Rule</a></li>
			</ul>
		</li>
                                 <?php } if(in_array('5',$permission)) { ?>
		<li class="parent"><a href="#">Edit<span class="expand">&raquo;</span></a>
			<ul class="child">
			<li><a onClick = "userAction('editproject','');">Project</a></li>
			<li><a onClick = "userAction('editquestion','');">Question</a></li>
			<li><a onClick = "userAction('editquestionop','');">Question Option</a></li>
			<li><a onClick = "userAction('editsequence','');">Sequence</a></li>
			<li><a onClick = "userAction('editroutine','');">Routine</a></li>
			<li><a onClick = "userAction('updatesequence','');">Update Sequence</a></li>
			<li><a onClick = "userAction('editpcentre','');">Centre/Age/Product/SEC</a></li>
			<li><a onClick = "userAction('editpfp','');">Project First Page</a></li>
			<li><a href="https://digiadmin.quantumcs.com/vcimsweb/adminpanel/modify_quest.php?st=103" target="_blank">Translated Question</a></li>
			<li><a onClick = "userAction('editrule','');">Rule</a></li>
			</ul>
		</li>
                                 <?php } if(in_array('6',$permission)) { ?>
		<li class="parent"><a href="#">View<span class="expand">&raquo;</span></a>
			<ul class="child">
			<li><a onClick = "userAction('viewproject','');">Project</a></li>
			<li><a href="https://digiadmin.quantumcs.com/vcimsweb/adminpanel/project_showcard.php" target="_blank">Project Showcard</a></li>
			<li><a onClick = "userAction('viewqb','');">QuestionBank</a></li>
			<li><a onClick = "userAction('viewqnre','');">Questionnaire</a></li>
			<li><a onClick = "userAction('viewquestion','');">Question</a></li>
			<li><a onClick = "userAction('viewquestionop','');">Question Options</a></li>
			<li><a onClick = "userAction('viewsequence','');">Sequence</a></li>
			<li><a onClick = "userAction('viewroutine','');">Routine</a></li>
			<li><a onClick = "userAction('viewpcentre','');">Centre/Age/Product/SEC</a></li>
			<li><a onClick = "userAction('viewprule','');">Rule</a></li>
			</ul>
		</li>
                                 <?php } if(in_array('6',$permission)) { ?>
		<li class="parent"><a href="#">Copy<span class="expand">&raquo;</span></a>
			<ul class="child">
			<li><a onClick = "userAction('copyqbquest','');">Question of QBank</a></li>
			<li><a href="https://digiadmin.quantumcs.com/vcimsweb/QuestAdmin/project_questions_copy.php" target="_blank">Project All Questions</a></li>
			<li><a onClick = "userAction('copyquestionop','');">QuestionOption</a></li>
			<li><a href="copytquestionop" target="_blank">Translated Option</a></li>
			<li><a onClick = "userAction('copyproutine','');">Routine</a></li>
			</ul>
		</li>
                                 <?php } if(in_array('7',$permission)) { ?>
		<li class="parent"><a href="#">Delete<span class="expand">&raquo;</span></a>
			<ul class="child">
			<li><a onClick = "userAction('deleteproject','');">Project</a></li>
			<li><a onClick = "userAction('deletequestion','');">Question</a></li>
			<li><a onClick = "userAction('deletequestionop','');">Question Options</a></li>
			<li><a onClick = "userAction('deletesequence','');">Sequence</a></li>
			<li><a onClick = "userAction('deleteroutine','');">Routine</a></li>
			</ul>
		</li>
                                 <?php } ?>
	</ul>
	</li>
	<li class="parent"><a href="#">Data Report</a>
	<ul class="child">
                                 <?php if(in_array('15',$permission)) { ?>
		<li><a onClick = "userAction('projectdata','');">CAPI Projects</a></li>
			<?php } ?>
			<?php if(in_array('18',$permission)) { ?>
		<li><a onClick = "userAction('viewpcrosstab','');">CossTab</a></li>
	                                 <?php } ?>
	</ul>
	</li>


	<li class="parent"><a href="#">Tablet</a>
	<ul class="child">
                                 <?php if(in_array('11',$permission)) { ?>
		<li class="parent"><a href="#">Tablet Issue <span class="expand">&raquo;</span></a>
			<?php if(in_array('11',$permission)){ ?>
			<ul class="child">
			<li><a onClick = "userAction('addtab','');">New Tablet</a></li>
			<li><a onClick = "userAction('issuetab','');">Issue Tablet</a></li>
			<li><a onClick = "userAction('receivetab','');">Receive Tablet</a></li>
			<li><a onClick = "userAction('addinterv','');">Add Interviewer</a></li>
			<li><a onClick = "userAction('tabreport','');">Report - Tablet Issue </a></li>
			</ul>
			<?php } ?>
		</li>
                                 <?php } if(in_array('12',$permission)) { ?>
		<li class="parent"><a href="#">Tablet Permission<span class="expand">&raquo;</span></a>
			<?php if(in_array('12',$permission)){ ?>
			<ul class="child">
			<li><a onClick = "userAction('tabprm','');">Tablet Permission</a></li>
			<li><a onClick = "userAction('rgtrresp','');">Register Respondent</a></li>
			<li><a onClick = "userAction('reporttabpermission','');">Report - Tablet Permission</a></li>
			</ul>
			<?php } ?>
		</li>
		<?php } ?>
	</ul>
	</li>

	<li class="parent"><a href="#">More Tools</a>
	<ul class="child">
		<li class="parent"><a href="#">Action <span class="expand">&raquo;</span></a>
			<ul class="child">
			<li><a href="<?php echo base_url(); ?>index.php/sachangepass">Change Password</a></li>
                                 <?php if(in_array('13',$permission)) { ?>
			<li><a href="#">Mangopinion Panel</a></li>
				 <?php } ?>
			<li><a onClick = "userAction('createqbcat','');">Create QuestionBank</a></li>
                                 <?php if(in_array('4',$permission)) { ?>
			<li><a onClick = "userAction('createemptytable','');">Create Dummy Table</a></li>
                        <li><a  onClick = "userAction('transdataupload','');">Trans Ques Upload</a></li>
			<li><a  onClick = "userAction('dummydataupload','');">Dummy Data Upload</a></li>
			<li><a onClick = "userAction('setpquota','');">SET QUOTA</a></li>
				<?php } ?>
			</ul>
		</li>
		<li class="parent"><a href="#">View <span class="expand">&raquo;</span></a>
			<ul class="child">
                        <li><a  onClick = "userAction('viewtransdataupload','');">Translation Template</a></li>
			<li><a href='https://digiadmin.quantumcs.com/crosstab' target='_blank'>Client CrossTab</a></li>
			<li><a href='https://digiadmin.quantumcs.com/quota' target='_blank'>VField WebLink</a></li>
			<li><a href='https://digiadmin.quantumcs.com/survey/fp.php?q=243' target='_blank'>Centre Quota</a></li>
			</ul>
		</li>
	</ul>
	</li>

        <li class="parent"><a href="<?php echo base_url(); ?>/salogout"><i class="fa fa-user"></i> Sign Out</a>
        </li>

<?php } ?>

<!-- End -->
<!--
                    <li>
                        <a href="<?php echo base_url(); ?>siteadmin/salogout"><i class="fa fa-user"></i> Sign Out</a>
                    </li>
--> 
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
                      
                       
                         
<!-- begin -->
<!-- END -->


                         <?php  
                          
                         //print_r($_SESSION);
			  $role=$this->session->userdata('sauseridrole');
                     		//     $role=$_SESSION['sauseridrole']; 
				$permission=$_SESSION['permission'];
               if(empty($permission))
                              echo 'You have no access permissions';
              else
              {
                         /* if(in_array('1',$permission))
                              echo 'Found'.in_array('2',$permission);
                          else
                              echo 'Not found';
                           */
                           
                        if($role==1 || $role==2)
                        {
                          
                        ?>
                         <li>
                            <a href='<?php base_url(); ?>samylogin'><i class="fa fa-comment fa-fw"></i> Action <span class="fa arrow"></span></a>

                            <ul class="nav nav-second-level">

                                <li>
                                    <a href="samylogin"> <i class="fa fa-comment fa-fw"></i>User <span class="fa arrow"></span></a>
                                
                                     <ul class="nav nav-third-level">

                                    <li>
                                    <a   onClick = "userAction('usradd','');">Add </a>
                                    </li>
                                    <li>
                                    <a   onClick = "userAction('usredit','');">Edit </a>
                                    </li>
                                    <li>
                                    <a   onClick = "userAction('usrview','');">View </a>
                                    </li>
                                  <?php if($role==1) { ?>
                                    <li>
                                    <a onClick = "userAction('usrremove','');"> Remove </a>
                                    </li>
                                  <?php } ?>
                                   </ul>
                                </li>
                                <li>
                                    <a href="#"> <i class="fa fa-comment fa-fw"></i>Permission <span class="fa arrow"></span></a>
                                
                                     <ul class="nav nav-third-level">

                                    <li>
                                    <a onClick = "userAction('prmadd','');">New </a>
                                    </li>
                                    <li>
                                    <a onClick = "userAction('prmassign','');">Assign  </a>
                                    </li>
                                    <li>
                                    <a onClick = "userAction('prmview','');">View </a>
                                    </li>
                                     <?php if($role==1 ) { ?>
                                    <li>
                                    <a onClick = "userAction('prmrevoke','');"> Revoke </a>
                                    </li>
                                     <?php } ?>
                                   </ul>
                                </li>
				</ul>

                    
                         
                             
                            <!-- /.nav-second-level -->

                        </li>
               <?php } ?>  <!-- End or Role for Action Menu -->
 
                         <li>
                            <a href="#"><i class="fa fa-dashboard fa-fw"></i> Questionnaire <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                 <?php if(in_array('4',$permission)) { ?>
                                <li>
                                    <a href="#"> <i class="fa fa-dashboard fa-fw"></i>Create <span class="fa arrow"></span></a>                                
                                     <ul class="nav nav-third-level">                                    
                                     		    <li>
		                                    <a onClick = "userAction('createqbcat','');">QBCategory </a>
		                                    </li>
		                                    <li>
		                                    <a onClick = "userAction('createproject','');">Project </a>
		                                    </li>
		                                    <li>
		                                    <a onClick = "userAction('createqset','');">QuestionSet </a>
		                                    </li>
		                                    <li>
		                                    <a onClick = "userAction('createquestion','');">Question </a>
		                                    </li>
		                                     <li>
		                                    <a onClick = "userAction('createsequence','');">Sequence </a>
		                                    </li>
		                                     <li>
		                                    <a onClick = "userAction('createroutine','');">Routine </a>
		                                    </li>		                                
                                   </ul>
                                  </li>
                                  <?php } ?>
                                  <?php if(in_array('5',$permission)) { ?>
                                   <li>
                                   <a href="#"> <i class="fa fa-dashboard fa-fw"></i>Edit <span class="fa arrow"></span></a>                                
                                     <ul class="nav nav-third-level">
                                    <li>                                     		
		                                    <li>
		                                    <a onClick = "userAction('editproject','');">Project </a>
		                                    </li>
		                                    <li>
		                                    <a onClick = "userAction('editquestion','');">Question </a>
		                                    </li>
		                                    <li>
		                                    <a onClick = "userAction('editquestionop','');">Question Option </a>
		                                    </li>
		                                     <li>
		                                    <a onClick = "userAction('editsequence','');">Sequence </a>
		                                    </li>
		                                     <li>
		                                    <a onClick = "userAction('editroutine','');">Routine </a>
		                                    </li>
		                                    <li>
		                                    <a onClick = "userAction('updatesequence','');">Update Sequence </a>
		                                    </li>
		                                    <li>
		                                    <a onClick = "userAction('editpcentre','');">Centre/Product/Store/SEC </a>
		                                    </li>
						    <li>
                                                    <a onClick = "userAction('editpfp','');">Project First Page </a>
                                                    </li>
                                                    <li>
		                                    <a onClick = "userAction('editrule','');">Rule </a>
		                                    </li>
                                                    <li>
                                                    <a href = "https://digiadmin.quantumcs.com/vcimsweb/adminpanel/modify_quest.php?st=103" target="_blank"> Translated Question </a>
                                                    </li>
                                         </li>
                                   </ul>
                                  </li>
                                  <?php } ?>
                                  <?php if(in_array('4',$permission)) { ?>
                                  <li>
                                   <a href="#"> <i class="fa fa-dashboard fa-fw"></i>Add <span class="fa arrow"></span></a>                                
                                     <ul class="nav nav-third-level">
                                    <li>
                                     		    <li>
		                                    <a onClick = "userAction('addqbquest','');">QuestionBank Question </a>
		                                    </li>
		                                    <li>
		                                    <a onClick = "userAction('addqop','');">Question Option </a>
		                                    </li>
		                                     <li>
		                                    <a onClick = "userAction('addsequence','');">Sequence </a>
		                                    </li>
		                                    <li>
		                                   <!-- <a onClick = "userAction('addpcentre','');">Project Centre </a> -->
							<a href = "viewaddpcentre">Project Centre </a>

		                                    </li>
                                                    <li>
		                                    <a onClick = "userAction('addpproduct','');">Project Product </a>
		                                    </li>
                                                    <li>
		                                    <a onClick = "userAction('addpstore','');">Project Store </a>
		                                    </li>
                                                    <li>
		                                    <a onClick = "userAction('addpsec','');">Project SEC </a>
		                                    </li>
                                                    <li>
		                                    <a onClick = "userAction('addpage','');">Project Age </a>
		                                    </li>
                                                    <li>
		                                    <a onClick = "userAction('addmedia','');">Project Question Media </a>
		                                    </li>
                                                    <li>
		                                    <a onClick = "userAction('addpcrosstab','');">Project CrossTab </a>
		                                    </li>
                                                    <li>
		                                    <a href = "https://digiadmin.quantumcs.com/vcimsweb/adminpanel/question_trans.php?st=101" target="_blank">Translated Question</a>
		                                    </li>
                                                    <li>
		                                    <a href = "https://digiadmin.quantumcs.com/vcimsweb/adminpanel/question_trans.php?st=102" target="_blank">Translated Q. Option</a>
		                                    </li>
		                                    <li>
		                                    <a onClick = "userAction('addcentre','');">New Centre </a>
		                                    </li>
                                                    <li>
		                                    <a onClick = "userAction('addrule','');">Rule </a>
		                                    </li>
                                                    <li>
		                                    <a onClick = "userAction('addarea','');">Area of Centre </a>
		                                    </li>
                                                    <li>
		                                    <a onClick = "userAction('addsubarea','');">Sub Area of Centre</a>
		                                    </li>
                                                    
		                      </li>         
                                   </ul>
                                  </li>
                                  <?php } ?>
                                  <?php if(in_array('6',$permission)) { ?>
                                  <li>
                                   <a href="#"> <i class="fa fa-dashboard fa-fw"></i>Copy <span class="fa arrow"></span></a>                                
                                     <ul class="nav nav-third-level">
                                     	            <li>
		                                    <a onClick = "userAction('copyqbquest','');">Question From QBank  </a>
		                                    </li>
		                                    <li>
		                                    <a href = "https://digiadmin.quantumcs.com/vcimsweb/QuestAdmin/project_questions_copy.php" target="_blank">Project All Questions </a>
                                                    <li>
		                                    <a onClick = "userAction('copyquestionop','');">Question with Option</a>
		                                    </li>
                                                    <li>
							<a href = "copytquestionop" target="_blank">Translated Option</a>
                                                    <li>
		                                     <li>
		                                    <a onClick = "userAction('copypsequence','');">Sequence </a>
		                                    </li>
		                                     <li>
		                                    <a onClick = "userAction('copyproutine','');">Routine </a>
		                                    </li>
		                                    <li>
		                                    <a onClick = "userAction('copypcentre','');">Project Centre </a>
		                                    </li>
                                                    <li>
		                                    <a onClick = "userAction('copypproduct','');">Project Product </a>
		                                    </li>
                                   </ul>
                                   </li>
                                   <?php } ?>
                                  <?php if(in_array('6',$permission)) { ?>
                                  <li>
                                   <a href="#"> <i class="fa fa-dashboard fa-fw"></i>View <span class="fa arrow"></span></a>                                
                                     <ul class="nav nav-third-level">
                                     	
		                                    <li>
		                                    <a onClick = "userAction('viewproject','');">Project </a>
		                                    </li>
						    <li>
						    <a href = "https://digiadmin.quantumcs.com/vcimsweb/adminpanel/project_showcard.php" target="_blank">Showcard Questions</a>
						    </li>
		                                    <li>
		                                    <a onClick = "userAction('viewqb','');">QuestionBank </a>
		                                    </li>
						    <li>
		                                    <a onClick = "userAction('viewqnre','');">Questionnaire </a>
		                                    </li>
		                                    <li>
		                                    <a onClick = "userAction('viewquestion','');">Question </a>
		                                    </li>
                                                    <li>
		                                    <a onClick = "userAction('viewquestionop','');">Question Option</a>
		                                    </li>
		                                     <li>
		                                    <a onClick = "userAction('viewsequence','');">Sequence </a>
		                                    </li>
		                                     <li>
		                                    <a onClick = "userAction('viewroutine','');">Routine </a>
		                                    </li>
		                                    <li>
		                                    <a onClick = "userAction('viewpcentre','');">Product/Centre/Store/SEC </a>
		                                    </li>
                                                    <li>
                                                    <a onClick = "userAction('viewprule','');">Rule</a>
                                                    </li>

                                   </ul>
                                   </li>
                                   <?php } ?>
                                   <?php if(in_array('7',$permission)) { ?>
                                  <li>
                                  <a href="#"> <i class="fa fa-dashboard fa-fw"></i>Delete <span class="fa arrow"></span></a>                                
                                     <ul class="nav nav-third-level">
                                    <li>                                     		
		                                    <li>
		                                    <a onClick = "userAction('deletequestion','');">Question </a>
		                                    </li>
		                                    <li>
		                                    <a onClick = "userAction('deletequestionop','');">Question Option </a>
		                                    </li>
		                                     <li>
		                                    <a onClick = "userAction('deletesequence','');">Sequence </a>
		                                    </li>
		                                     <li>
		                                    <a onClick = "userAction('deleteroutine','');">Routine </a>
		                                    </li>
		                                    <li>
		                                    <a onClick = "userAction('deletecentre','');">Project Centre </a>
		                                    </li>
                                                    <li>
		                                    <a onClick = "userAction('deleteproduct','');">Project Product </a>
		                                    </li>
                                                    
                                        </li>		                               
                                   </ul>
                                </li>
                                <?php } ?>
                            </ul>

                    
                         
                             
                            <!-- /.nav-second-level -->

                        </li>
                 <!-- End of Questionnaire Menu -->
                             <li>
                            <a href="#"><i class="fa fa-sign-out fa-fw"></i> Report <span class="fa arrow"></span></a>

                            <ul class="nav nav-second-level">
                               <?php if(in_array('15',$permission)){ ?>
                                    <li>
                                    <a   onClick = "userAction('projectdata','');"><i class="fa fa-sign-out fa-fw"></i> Project Survey Data </a>
                                    </li>

                               <?php } if(in_array('17',$permission)){ ?>
                                <li style='display:none'>
                                    <a href="#"> <i class="fa fa-edit fa-fw"></i>MD Field <span class="fa arrow"></span></a>
                                
                                     <ul class="nav nav-third-level">
                                                    <li>
		                                    <a   onClick = "userAction('mdureport','');">Umeed2 </a>
		                                    </li>
                                                   <li>
		                                    <a   onClick = "userAction('mdusreport','');">Umeed2 Daily Summary</a>
		                                    </li>
		                                    <li>
		                                    <a   onClick = "userAction('mdssreport','');">Safal Sammary</a>
		                                    </li>
                                                    <li>
		                                    <a   onClick = "userAction('mdmbreport','');">Umeed2 Booth Atrribute Score</a>
		                                    </li>
		                                    <li>
		                                    <a   onClick = "userAction('mdbsreport','');">Umeed2 Booth Score</a>
		                                    </li>
                                                    <li>
		                                    <a   onClick = "userAction('mdudclean','');">Remove Umeed2 Duplicate</a>
		                                    </li>
                                    </ul>
                                </li>
                               <!--
                                <?php } if(in_array('18',$permission)){ ?>
                               <li>
          <a href="https://digiadmin.quantumcs.com/vcimsweb/adminpanel/crosstab_tool.php" target="_blank"> CROSSTAB REPORT </a>
                                </li>
                                <?php } ?>
				-->
                                                    <li>
                                                    <a onClick = "userAction('viewpcrosstab','');"> <i class="fa fa-sign-out fa-fw"></i> PROJECT CROSSTAB </a>
                                                    </li>
                                                <li>
                                                <a href='https://digiadmin.quantumcs.com/quota' target='_blank'><i class="fa fa-sign-out fa-fw"></i>Project Qouta Details</a>
                                                </li>


                            </ul>
  
                            <!-- /.nav-second-level -->

                        </li>
   
			<li>
                            <a href='<?php base_url(); ?>siteadmin/samylogin'><i class="fa fa-comment fa-fw"></i> KENANTE <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="siteadmin/samylogin"> <i class="fa fa-comment fa-fw"></i>New User <span class="fa arrow"></span></a>                                
                                    <ul class="nav nav-third-level">
                                    <li>
                                    <a onClick = "userAction('vrusradd','');">Add </a>
                                    </li>
                                    <li>
                                    <a onClick = "userAction('vrusredit','');">Edit </a>
                                    </li>
                                    <li>
                                    <a onClick = "userAction('vrusrview','');">View </a>
                                    </li>
				   </ul>
				</li>
			    
                                <li>
                                    <a href="siteadmin/samylogin"> <i class="fa fa-comment fa-fw"></i>New Room <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                    <li>
                                    <a onClick = "userAction('vrradd','');">Add </a>
                                    </li>
                                    <li>
                                    <a onClick = "userAction('vrredit','');">Edit </a>
                                    </li>
                                    <li>
                                    <a onClick = "userAction('vrrview','');">View </a>
                                    </li>
                                   </ul>
                                </li>
                                <li>
                                    <a href="https://admin.quickblox.com/signin" target="_blank"> <i class="fa fa-comment fa-fw"></i>Add User To QuickBlox <span class="fa arrow"></span></a>
				</li>
                                <li>
                                    <a href="siteadmin/samylogin"> <i class="fa fa-comment fa-fw"></i>Add User To Room <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                    <li>
                                    <a onClick = "userAction('vrrusradd','');">Add </a>
                                    </li>
                                    <li>
                                    <a onClick = "userAction('vrrusredit','');">Edit </a>
                                    </li>
                                    <li>
                                    <a onClick = "userAction('vrrusrview','');">View </a>
                                    </li>
                                   </ul>
                                </li>
                            </ul>
                         </li>

                         <li>
                            <a href="#"><i class="fa fa-edit fa-fw"></i> Mangopinion <span class="fa arrow"></span></a>

                            <ul class="nav nav-second-level">

                                <li>
                                    <a href="#"> <i class="fa fa-edit fa-fw"></i>Action <span class="fa arrow"></span></a>
                                
                                     <ul class="nav nav-third-level">

                                    	            <?php if(in_array('13',$permission)){ ?>
		                                    <li>
		                                    <a href = "https://digiadmin.quantumcs.com/vcimsweb/adminpanel/mangopinion/resp_home.php" target="_blank">Panel </a>
		                                    </li>
                                                    <?php } ?>
                                   </ul>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                <!-- End or Mangopinion for Edit Menu -->
                         <li>
                            <a href="#"><i class="fa fa-edit fa-fw"></i> More Tools <span class="fa arrow"></span></a>
				<?php if(in_array('4',$permission)){ ?>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#"> <i class="fa fa-edit fa-fw"></i>Action <span class="fa arrow"></span></a>
                                     <ul class="nav nav-third-level">

                                                    <li>
                                                    <a onClick = "userAction('createemptytable','');"> <i class="fa fa-sign-out fa-fw"></i>Create Dummy Table </a>
                                                    </li>
                                                    <li>
                                                    <a onClick = "userAction('transdataupload','');"> <i class="fa fa-sign-out fa-fw"></i> Translated Q Upload </a>
                                                    </li>
                                                    <li>
                                                    <a onClick = "userAction('dummydataupload','');"> <i class="fa fa-sign-out fa-fw"></i> DATA UPLOAD </a>
                                                    </li>

                                                    <li>
                                                    <a onClick = "userAction('setpquota','');"> <i class="fa fa-sign-out fa-fw"></i> SET PROJECT QUOTA </a>
                                                    </li>

                                                  <!--  <li>
                                                    <a onClick = "userAction('viewpdummycrosstab','');"> <i class="fa fa-sign-out fa-fw"></i> PROJECT CROSSTAB </a>
                                                    </li>
						-->
					</ul>
				     </ul>
                            		<ul class="nav nav-second-level">
					<li>
                                    	<a href="#"> <i class="fa fa-edit fa-fw"></i>View <span class="fa arrow"></span></a>
                                     	     <ul class="nav nav-third-level">
                                                <li>
                                                <a onClick = "userAction('viewtransdataupload','');"><i class="fa fa-sign-out fa-fw"></i>Translation Template </a>
                                                </li>

						<li>
						<a href='https://digiadmin.quantumcs.com/crosstab' target='_blank'><i class="fa fa-sign-out fa-fw"></i>Client CrossTab </a>
						</li>
                                                <li>
                                                <a href='https://digiadmin.quantumcs.com/quota' target='_blank'><i class="fa fa-sign-out fa-fw"></i>Centre Quota </a>
                                                </li>
                                                <li>
                                                <a href='https://digiadmin.quantumcs.com/survey/fp.php?q=243' target='_blank'><i class="fa fa-sign-out fa-fw"></i>VField Web Link </a>
                                                </li>
                            		     </ul>
					</li>
                            	<!-- /.nav-second-level -->
                        	</li>
			    </ul>
			<?php } ?>
			</li>
                <!-- End orCrossTab Menu -->

                  
                                <?php 
					//$vuid=$_SESSION['sauserid']; 
                       
   
                        if($role==1 || $role==2 || $role==3 || $role ==4)
                        {
                          
                        ?>
                         <li>
                            <a href="#"><i class="fa fa-sign-out fa-fw"></i> Tablet Management <span class="fa arrow"></span></a>

                            <ul class="nav nav-second-level">
                               <?php if(in_array('11',$permission)){ ?>
                                <li>
                                    <a href="#"> <i class="fa fa-comment fa-fw"></i>Tablet Allocation <span class="fa arrow"></span></a>
                                
                                     <ul class="nav nav-third-level">

                                    <li>
                                    <a onClick = "userAction('addtab','');">New Tablet </a>
                                    </li>
                                    <li>
                                    <a onClick = "userAction('issuetab','');">Issue Tablet </a>
                                    </li>
                                    <li>
                                    <a onClick = "userAction('receivetab','');">Receive Tablet </a>
                                    </li>
                                    <li>
                                    <a   onClick = "userAction('addinterv','');">Add Interviewer</a>
                                    </li>
                                    <li>
                                    <a   onClick = "userAction('tabreport','');">Report- Tablet Issue </a>
                                    </li>
                                    
                                    </ul>
                                </li>
                               <?php } if(in_array('12',$permission)){ ?>
                                <li>
                                    <a href="#"> <i class="fa fa-comment fa-fw"></i>Tablet Permission <span class="fa arrow"></span></a>
                                
                                     <ul class="nav nav-third-level">

                                    
                                    <li>
                                    <a   onClick = "userAction('tabprm','');">Tablet Permission </a>
                                    </li>
                                    <li>
                                    <a   onClick = "userAction('rgtrresp','');">Register Respondent </a>
                                    </li>
                                    
                                    <li>
                                    <a   onClick = "userAction('reporttabpermission','');">Report- Tablet Permission </a>
                                    </li>
                                    </ul>
                                </li>
                               <?php } ?>
                            
                                
                            </ul>

                    
                         
                             
                            <!-- /.nav-second-level -->

                        </li>
               <?php } ?>  <!-- End or Tablet for View Menu -->
                        

                        <li>
                            <a href="<?php echo base_url(); ?>index.php/siteadmin/sachangepass"><i class="fa fa-edit fa-fw"></i> Change Password</a>
                        </li>
                 <?php } ?>       
                       
                       
                 </div>
</div>

   <br><br>
<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
             <?php  if($rqpost=='')  { ?>

                <div class="row" id="pdtls">
                    <div class="col-lg-12">
                        <h5 class="page-header">Hi </h5>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
               
               <div id="p-item" style="min-height:500px;">
                
                    <?php 
                      //$vuid=$_SESSION['sauserid']; 
                      	$_REQUEST=''; 
                       $tempu= base_url(uri_string()); 
                       $ptempuri=$this->session->tempdata('ptemp');
                     if($tempu!=$ptempuri)
                    
                       echo $msg;
                    ?>
                      
               </div>
                        <?php $vuid=$_SESSION['sauserid']; //echo $msg;	$_REQUEST=''; //print_r($_SESSION);echo "<br><br>";print_r($_REQUEST); 
                                 //print_r($role); echo "<br><br>"; print_r($permission);
                        
               
                  ?>

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
       

<!-- End of page-wrapper -->
    

    <footer style="background-color:white; border-top: 1px solid #DCEDC8;">
        <div class="container">
               
                <div style="float:center;">
                    <div class="col-md-4">
                    <span class="copyright"> &copy; 2018 QuantumCS Private Limited. All Rights Reserved.</span>
                </div>
                    <ul class="list-inline social-buttons">
                        
                        <li><a href="https://www.facebook.com/QuantumCS/" target="_blank"><i class="fa fa-facebook"></i></a>
                        </li>
                         
                        <li><a href="https://in.linkedin.com/in/varenia-cims-aab337b6" target="_blank"><i class="fa fa-linkedin"></i></a>
                        </li>
                    </ul>
                    
                </div>
            
        </div>
    </footer>

     <!-- Header -->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script>

function userAction(action,product_code) {  
	var queryString = "";
	if(action != "") {
		switch(action) {
                        case "vrusradd":
                                queryString = 'action='+action;
                        break;
                        case "vrusredit":
                                queryString = 'action='+action;
                        break;
                        case "vrusrview":
                                queryString = 'action='+action;
                        break;
                        case "vrradd":
                                queryString = 'action='+action;
                        break;
                        case "vrredit":
                                queryString = 'action='+action;
                        break;
                        case "vrrview":
                                queryString = 'action='+action;
                        break;
                        case "vrrusradd":
                                queryString = 'action='+action;
                        break;
                        case "vrrusredit":
                                queryString = 'action='+action;
                        break;
                        case "vrrusrview":
                                queryString = 'action='+action;
                        break;
                        case "setpquota":
                                queryString = 'action='+action;
                        break;

			case "usradd":
				queryString = 'action='+action;
			break;
                      
			case "usredit":
				queryString = 'action='+action;
			break;
                        case "usrview":
				queryString = 'action='+action;
			break;
                        case "usrremove":
				queryString = 'action='+action;
			break;
			case "clear":
				queryString = 'action='+action;
			break;
                        case "prmassign":
				queryString = 'action='+action;
			break;
                        case "prmadd":
				queryString = 'action='+action;
			break;
                        case "prmview":
				queryString = 'action='+action;
			break;
                        case "prmrevoke":
				queryString = 'action='+action;
			break;
                        case "addtab":
				queryString = 'action='+action;
			break;   
                        case "issuetab":
				queryString = 'action='+action;
			break;
                        case "receivetab":
				queryString = 'action='+action;
			break;
                        case "tabreport":
				queryString = 'action='+action;
			break;
                        case "addinterv":
				queryString = 'action='+action;
			break;


                        case "tabprm":
				queryString = 'action='+action;
			break;
                        case "rgtrresp":
				queryString = 'action='+action;
			break;
                        case "reporttabpermission":
				queryString = 'action='+action;
			break;

                        case "issuetab":
				queryString = 'action='+action;
			break;
                        case "projectdata":
				queryString = 'action='+action;
			break;
                      
                        case "getpqset":
				queryString = 'action='+action;
			break;
                        case "mdureport":
				queryString = 'action='+action;
			break;
                        case "mdusreport":
				queryString = 'action='+action;
			break;
                        case "mdssreport":
				queryString = 'action='+action;
			break;
                        case "mdmbreport":
				queryString = 'action='+action;
			break;
                        case "mdbsreport":
				queryString = 'action='+action;
			break;
                        case "mdudclean":
				queryString = 'action='+action;
			break;
                        case "viewpcrosstab":
				queryString = 'action='+action;
			break;
                        case "viewpdummycrosstab":
                                queryString = 'action='+action;
                        break;
			case "createemptytable":
				queryString = 'action='+action;
			break;
			case "dummydataupload":
				queryString = 'action='+action;
			break;

                        case "transdataupload":
                                queryString = 'action='+action;
                        break;
                        case "viewtransdataupload":
                                queryString = 'action='+action;
                        break;

                        case "viewproject":
				queryString = 'action='+action;
			break;
                        case "viewqb":
				queryString = 'action='+action;
			break;
                        case "viewqnre":
				queryString = 'action='+action;
			break;
                        case "viewquestion":
				queryString = 'action='+action;
			break;
                        case "viewquestionop":
				queryString = 'action='+action;
			break;
                        case "viewsequence":
				queryString = 'action='+action;
			break;
                        case "viewroutine":
				queryString = 'action='+action;
			break;
                        case "viewpcentre":
				queryString = 'action='+action;
			break;
                        case "editpcentre":
                                queryString = 'action='+action;
                        break;
                        case "editpfp":
                                queryString = 'action='+action;
                        break;
                        case "viewprule":
                                queryString = 'action='+action;
                        break;
			
			case "editproject":
				queryString = 'action='+action;
			break;
                        case "editquestion":
				queryString = 'action='+action;
			break;
                        case "editquestionop":
				queryString = 'action='+action;
			break;
                        case "editsequence":
				queryString = 'action='+action;
			break;
			case "editroutine":
				queryString = 'action='+action;
			break;
			case "updatesequence":
				queryString = 'action='+action;
			break;

                        case "createproject":
				queryString = 'action='+action;
			break;
                        case "createqset":
				queryString = 'action='+action;
			break;
                        case "createquestion":
				queryString = 'action='+action;
			break;
                        case "createsequence":
				queryString = 'action='+action;
			break;
                        case "createroutine":
				queryString = 'action='+action;
			break;
                        case "createqbcat":
				queryString = 'action='+action;
			break;

                        case "addqbquest":
				queryString = 'action='+action;
			break;
                        case "addqop":
				queryString = 'action='+action;
			break;
                        case "addsequence":
				queryString = 'action='+action;
			break;
                        case "addpcentre":
				queryString = 'action='+action;
			break;
                        case "addcentre":
				queryString = 'action='+action;
			break;
                        case "addpproduct":
				queryString = 'action='+action;
			break;
                        case "addpstore":
				queryString = 'action='+action;
			break;
                        case "addpsec":
				queryString = 'action='+action;
			break;
                        case "addarea":
				queryString = 'action='+action;
			break;
                        case "addsubarea":
				queryString = 'action='+action;
			break;
                        case "addpage":
				queryString = 'action='+action;
			break;
                        case "addtransq":
				queryString = 'action='+action;
			break;
                        case "addtransqop":
				queryString = 'action='+action;
			break;
                        case "addpcrosstab":
				queryString = 'action='+action;
			break;
                        case "addrule":
				queryString = 'action='+action;
			break;
                        case "addmedia":
				queryString = 'action='+action;
			break;
                        case "copyqbquest":
				queryString = 'action='+action;
			break;
                        case "copyquestionop":
				queryString = 'action='+action;
			break;
                        case "copytquestionop":
                                queryString = 'action='+action;
                        break;
                        case "deletesequence":
				queryString = 'action='+action;
			break;
                        case "deleteroutine":
				queryString = 'action='+action;
			break;
                        case "deletequestion":
				queryString = 'action='+action;
			break;
                        case "deletequestionop":
				queryString = 'action='+action;
			break;
                        case "editrule":
				queryString = 'action='+action;
			break;
		}	 
	}
	jQuery.ajax({
	 url:'<?php echo base_url("siteadmin/user_action/action/"); ?>'+action,
    //url:'http://160.153.17.79/v/welcome/filter_product/action'+action,
	data:queryString,
	type: "POST",
	success:function(data){  
		$("#p-item").html(data);
		if(action != "") {
			switch(action) {
				case "getpqset":  
					$("#qset").html(81);
					$("#added_"+product_code).show();
				break;
				
                                case "prmassign":  
					$("#add_"+product_code).hide();
					$("#added_"+product_code).show();
				break;
			}	 
		}
	},
	 error: function (request, status, error) {//alert(error);
        $("#page-wrapper").html(request.responseText );
    }	

	});
}

function getpqset()
{
    var queryString ='';
   var pid = document.getElementById('pn').value;
   
   queryString = 'pn='+pid;
 
  jQuery.ajax({
	 url:'<?php echo base_url("index.php/siteadmin/getpqset/pn"); ?>',
     
	data:queryString,
	type: "POST",
	success:function(data){   
		$("#qset").html(data);
	},
	error:function (){}
	});
}
function getpqs()
{
    var queryString ='';
   var pid = document.getElementById('qset').value;
   
   queryString = 'pn='+pid;
 
  jQuery.ajax({
	 url:'<?php echo base_url("index.php/siteadmin/getpqs/pn"); ?>',
     
	data:queryString,
	type: "POST",
	success:function(data){  
		$("#pqid").html(data);
		$("#qs").html(data);
	},
	error:function (){}
	});
}
function getpqsf()
{
    var queryString ='';
   var pid = document.getElementById('qset').value;

   queryString = 'pn='+pid;

  jQuery.ajax({
         url:'<?php echo base_url("index.php/siteadmin/getpqsf/pn"); ?>',

        data:queryString,
        type: "POST",
        success:function(data){
                //$("#pqid").html(data);
                $("#qid").html(data);
        },
        error:function (){}
        });
}
function getqop()
{
   var queryString ='';
   var pqid = document.getElementById('qs').value;
   queryString = 'qs='+pqid;
   jQuery.ajax({
         url:'<?php echo base_url("index.php/siteadmin/getqop/qs"); ?>',

        data:queryString,
        type: "POST",
        success:function(data){
                $("#oplist").html(data);
        },
        error:function (){}
        });
}

function getpqop()
{
   var queryString ='';
   var pqid = document.getElementById('pqid').value;   
   queryString = 'pqid='+pqid;
   jQuery.ajax({
	 url:'<?php echo base_url("index.php/siteadmin/getpqop/pqid"); ?>',
     
	data:queryString,
	type: "POST",
	success:function(data){  
		$("#oplist").html(data);
	},
	error:function (){}
	});
}
function gettqop()
{
   var queryString ='';
   var qid = document.getElementById('qs').value;   
   queryString = 'qid='+qid;
   jQuery.ajax({
	 url:'<?php echo base_url("index.php/siteadmin/gettqop/pqid"); ?>',
     
	data:queryString,
	type: "POST",
	success:function(data){  
		$("#qop").html(data);
	},
	error:function (){}
	});
}
function getpqt()
{      var qt = document.getElementById('qt').value;   
       var elem = document.getElementById('oplist'); 
       var elem1 = document.getElementById('pqid'); 
       var elem2 = document.getElementById('rat');
      if(qt=='radio' || qt=='checkbox')
      {           
            elem.style.display = 'inline'; 
            elem1.style.display = 'inline';
            elem2.style.display = 'none';
      }
      if(qt=='rating')
      {
          elem.style.display = 'none';
          elem1.style.display = 'none';
          elem2.style.display = 'inline';
      }
      else
      {    //var elem1 = document.getElementById('pqid'); 
           //elem1.style.display = 'none';
           //var elem = document.getElementById('oplist');
          // elem.style.display = 'none';
           //elem2.style.display = 'none';
      }
             
}
function getrule()
{      var rt = document.getElementById('rt').value;
       var elem = document.getElementById('oplist');
       var elem1 = document.getElementById('list');
      if(rt=='1' || rt=='2' || rt=='3' || rt=='4' || rt=='5' || rt=='6' || rt == '7' || rt == '8' || rt == '9' || rt == '10' || rt == '11' || rt == '12' || rt == '13')
            elem.style.display = 'inline';
}
function editrule()
{      var rt = document.getElementById('rt').value;
       var qset = document.getElementById('qset').value;
       var elem = document.getElementById('list');
       var queryString ='';
      if(rt=='1' || rt=='2' || rt=='3' || rt =='4' || rt=='5' || rt == '6' || rt == '7' || rt== '8' || rt== '9' || rt == '10' || rt == '11' || rt == '12' || rt == '13')
            elem.style.display = 'inline';
        queryString = 'qset='+qset+'&rt='+rt;
        jQuery.ajax({
	url:'<?php echo base_url("siteadmin/editdrule"); ?>',
	data:queryString,
	type: "GET",
	success:function(data){
		$("#list").html(data);
	},
	error:function (){}
	});   
}

function getvrut()
{
    var queryString ='';
   var uid = document.getElementById('uid').value;
   queryString = 'uid='+uid;
  jQuery.ajax({
         url:'<?php echo base_url("siteadmin/getvrutype/"); ?>'+'/'+uid,
        data:queryString,
        type: "POST",
        success:function(data){
                //$("#pqid").html(data);
                $("#ut").html(data);
        },
        error:function (){}
        });
}
function getvrun()
{
    var queryString ='';
   var uid = document.getElementById('uid').value;
   queryString = 'uid='+uid;
  jQuery.ajax({
         url:'<?php echo base_url("siteadmin/getvruname/"); ?>'+'/'+uid,
        data:queryString,
        type: "POST",
        success:function(data){
                //$("#pqid").html(data);
                $("#un").html(data);
        },
        error:function (){}
        });
}
function getvrmob()
{
    var queryString ='';
   var uid = document.getElementById('uid').value;
   queryString = 'uid='+uid;
  jQuery.ajax({
         url:'<?php echo base_url("index.php/siteadmin/getvrumobile/"); ?>'+'/'+uid,
        data:queryString,
        type: "POST",
        success:function(data){
                //$("#pqid").html(data);
                $("#mobile").html(data);
        },
        error:function (){}
        });
}
function copyrulefindrepalcefirst()
{

        var st = document.getElementById('fwd1').value;
        var tb = document.getElementById('rwd1').value;
        var fl = document.getElementById('cqid1').value;
        var rw = document.getElementById('op1').value;
        var rq = document.getElementById('rqid1').value;

        var ctr = document.getElementById('cnt').value;
	for (i = 2; i <= ctr; i++) {
		var ii = i - 1;	
		var rwn = parseInt(rw) + ii;
		var stx = document.getElementById('fwd'+i).value = st;
        	var tbx = document.getElementById('rwd'+i).value=tb;
        	var flx = document.getElementById('cqid'+i).value=fl;
        	var rwx = document.getElementById('op'+i).value=rwn;
        	var rqx = document.getElementById('rqid'+i).value=rq;

	}
}
function copyrulegridfirst()
{
        var st = document.getElementById('stb1').value;
        var tb = document.getElementById('tb1').value;
        var fl = document.getElementById('flag1').value;
        var rw = document.getElementById('rw1').value;

        var ctr = document.getElementById('cnt').value;
	for (i = 2; i <= ctr; i++) {
		var ii = i - 1;	
		var stn = parseInt(st) + ii;
		var stx = document.getElementById('stb'+i).value = stn;
        	var tbx = document.getElementById('tb'+i).value = tb;
        	var flx = document.getElementById('flag'+i).value = fl;
        	var rwx = document.getElementById('rw'+i).value = rw;
	}
}

function generaterule() {
        var a = parseInt(document.getElementById("cnt").value);  
	document.getElementById("list").innerHTML = "";
        var ch = document.getElementById("list");
        var rt = document.getElementById('rt').value;
        if(rt=='1')
        { 
           for (i = 1; i <= a; i++) {            
                var panel=document.createElement("div");
                panel.style.width="485px"; panel.style.padding="0px";panel.style.align="left";                
                var ch1 = document.createElement("input");
                ch1.style.width="105px";
                var tmp1='stb'+i; var tm=''+i+'';
                ch1.setAttribute("type", "text");
                ch1.setAttribute("value",  tm );
                ch1.setAttribute("id", tmp1);
                ch1.setAttribute("name", tmp1);
                ch1.required= true;
                panel.appendChild(ch1);
                var ch2 = document.createElement("input");
                ch2.style.width="150px";
                var tmp2='tb'+i;
                ch2.setAttribute("type", "text");
                ch2.setAttribute("placeholder", "QID "+i+"");
                ch2.setAttribute("id", tmp2);
                ch2.setAttribute("name", tmp2);
                ch2.required= true;
                panel.appendChild(ch2);
                 var ch3 = document.createElement("input");
                ch3.style.width="90px";
                var tmp3='grp'+i;
                ch3.setAttribute("type", "text");
                ch3.setAttribute("placeholder", "grp no "+i+"");
                ch3.setAttribute("id", tmp3);
                ch3.setAttribute("name", tmp3);
                ch3.required= true;
                panel.appendChild(ch3);
                ch.appendChild(panel);
           }   
        }
        if(rt=='2')
        { 
           for (i = 1; i <= a; i++) {            
                var panel=document.createElement("div");
                panel.style.width="485px"; panel.style.padding="0px";panel.style.align="left";                
                var ch1 = document.createElement("input");
                ch1.style.width="105px";
                var tmp='stb'+i; var tm=''+i+'';
                ch1.setAttribute("type", "text");
                //ch1.setAttribute("value",  tm );
                ch1.setAttribute("placeholder", "Tab ID "+i+"");
                ch1.setAttribute("id", tmp);
                ch1.setAttribute("name", tmp);
                ch1.required= true;
                panel.appendChild(ch1);
                var ch2 = document.createElement("input");
                ch2.style.width="150px";
                var tmp2='qid'+i;
                ch2.setAttribute("type", "text");
                ch2.setAttribute("placeholder", "QID "+i+"");
                ch2.setAttribute("id", tmp2);
                ch2.setAttribute("name", tmp2);
                ch2.required= true;
                panel.appendChild(ch2);
                 var ch3 = document.createElement("input");
                ch3.style.width="90px";
                var tmp3='op'+i;
                ch3.setAttribute("type", "text");
                ch3.setAttribute("placeholder", "OP Value "+i+"");
                ch3.setAttribute("id", tmp3);
                ch3.setAttribute("name", tmp3);
                ch3.required= true;
                panel.appendChild(ch3);
                var ch4 = document.createElement("input");
                ch4.style.width="105px";
                var tmp4='q'+i;
                ch4.setAttribute("type", "text");
                ch4.setAttribute("placeholder", "Quata Limit "+i+"");
                ch4.setAttribute("id", tmp4);
                ch4.setAttribute("name", tmp4);
                ch4.required= true;
                panel.appendChild(ch4);
                ch.appendChild(panel);
           }   
        }
        if(rt=='3')
        { 
           for (i = 1; i <= a; i++) {            
                var panel=document.createElement("div");
                panel.style.width="485px"; panel.style.padding="0px";panel.style.align="left";                
                var ch1 = document.createElement("input");
                ch1.style.width="115px";
                var tmp='stb'+i; var tm=''+i+'';
                ch1.setAttribute("type", "text");
                //ch1.setAttribute("value",  tm );
                ch1.setAttribute("placeholder", "PQID "+i+"");
                ch1.setAttribute("id", tmp);
                ch1.setAttribute("name", tmp);
                ch1.required= true;
                panel.appendChild(ch1);

                var ch3 = document.createElement("input");
                ch3.style.width="90px";
                var tmp2='tb'+i;
                ch3.setAttribute("type", "text");
                ch3.setAttribute("placeholder", "grp no "+i+"");
                ch3.setAttribute("id", tmp2);
                ch3.setAttribute("name", tmp2);
                ch3.required= true;
                panel.appendChild(ch3);

                var ch2 = document.createElement("input");
                ch2.style.width="50px";
                var tmp2='flag'+i;
                ch2.setAttribute("type", "text");
                ch2.setAttribute("placeholder", "FLAG "+i+"");
                ch2.setAttribute("id", tmp2);
                ch2.setAttribute("name", tmp2);
                ch2.setAttribute("value", 1);
                ch2.required= true;
                panel.appendChild(ch2);

                ch.appendChild(panel);
           }   
        } 	
        if(rt=='4')
        { 
           for (i = 1; i <= a; i++) {            
                var panel=document.createElement("div");
                panel.style.width="485px"; panel.style.padding="0px";panel.style.align="left";                
                var ch1 = document.createElement("input");
                ch1.style.width="115px";
                var tmp='stb'+i; var tm=''+i+'';
                ch1.setAttribute("type", "text");
                //ch1.setAttribute("value",  tm );
                ch1.setAttribute("placeholder", "PQID "+i+"");
                ch1.setAttribute("id", tmp);
                ch1.setAttribute("name", tmp);
                ch1.required= true;
                panel.appendChild(ch1);
                var ch3 = document.createElement("input");
                ch3.style.width="90px";
                var tmp2='tb'+i;
                ch3.setAttribute("type", "text");
                ch3.setAttribute("placeholder", "CQID");
                ch3.setAttribute("id", tmp2);
                ch3.setAttribute("name", tmp2);
                ch3.required= true; 
               panel.appendChild(ch3);
                var ch4 = document.createElement("input");
                ch4.style.width="105px";
                var tmp4='flag'+i;
                ch4.setAttribute("type", "text");
                ch4.setAttribute("placeholder", "Flag"+i+"");
                ch4.setAttribute("id", tmp4);
                ch4.setAttribute("name", tmp4);
                ch4.required= true;
                panel.appendChild(ch4);

                ch.appendChild(panel);
           }   
        }
        if(rt=='5')
        { 
           for (i = 1; i <= a; i++) {            
                var panel=document.createElement("div");
                panel.style.width="485px"; panel.style.padding="0px";panel.style.align="left";                
                var ch1 = document.createElement("input");
                ch1.style.width="115px";
                var tmp='stb'+i; var tm=''+i+'';
                ch1.setAttribute("type", "text");
                //ch1.setAttribute("value",  tm );
                ch1.setAttribute("placeholder", "PQID "+i+"");
                ch1.setAttribute("id", tmp);
                ch1.setAttribute("name", tmp);
                ch1.required= true;
                panel.appendChild(ch1);
                var ch3 = document.createElement("input");
                ch3.style.width="90px";
                var tmp2='tb'+i;
                ch3.setAttribute("type", "text");
                ch3.setAttribute("placeholder", "CQID");
                ch3.setAttribute("id", tmp2);
                ch3.setAttribute("name", tmp2);
                ch3.required= true; 
               panel.appendChild(ch3);
                ch.appendChild(panel);
           }   
        }
        if(rt=='6')
        { 
           for (i = 1; i <= a; i++) {            
                var panel=document.createElement("div");
                panel.style.width="485px"; panel.style.padding="0px";panel.style.align="left";                
                var ch1 = document.createElement("input");
                ch1.style.width="115px";
                var tmp='stb'+i; var tm=''+i+'';
                ch1.setAttribute("type", "text");
                //ch1.setAttribute("value",  tm );
                ch1.setAttribute("placeholder", "PQID "+i+"");
                ch1.setAttribute("id", tmp);
                ch1.setAttribute("name", tmp);
                ch1.required= true;
                panel.appendChild(ch1);
                var ch3 = document.createElement("input");
                ch3.style.width="90px";
                var tmp2='tb'+i;
                ch3.setAttribute("type", "text");
                ch3.setAttribute("placeholder", "CQID");
                ch3.setAttribute("id", tmp2);
                ch3.setAttribute("name", tmp2);
                ch3.required= true;
                panel.appendChild(ch3);
                ch.appendChild(panel);
           }   
        }
        if(rt=='7')
        {
           for (i = 1; i <= a; i++) {
                var panel=document.createElement("div");
                panel.style.width="885px"; panel.style.padding="0px";panel.style.align="left";
                var ch1 = document.createElement("input");
                ch1.style.width="205px";
                var tmp='fwd'+i; var tm=''+i+'';
                ch1.setAttribute("type", "text");
                ch1.setAttribute("placeholder", "Find Word"+i+"");
                ch1.setAttribute("id", tmp);
                ch1.setAttribute("name", tmp);
                ch1.required= true;
                panel.appendChild(ch1);
                var chr = document.createElement("input");
                chr.style.width="305px";
                var tmp='rwd'+i; var tm=''+i+'';
                chr.setAttribute("type", "text");
                chr.setAttribute("placeholder", "Replace Word"+i+"");
                chr.setAttribute("id", tmp);
                chr.setAttribute("name", tmp);
                chr.required= true;
                panel.appendChild(chr);
                var ch2 = document.createElement("input");
                ch2.style.width="105px";
                var tmp2='cqid'+i;
                ch2.setAttribute("type", "text");
                ch2.setAttribute("placeholder", "CQID "+i+"");
                ch2.setAttribute("id", tmp2);
                ch2.setAttribute("name", tmp2);
                ch2.required= true;
                panel.appendChild(ch2);
                 var ch3 = document.createElement("input");
                ch3.style.width="90px";
                var tmp3='op'+i;
                ch3.setAttribute("type", "text");
                ch3.setAttribute("placeholder", "OP Value "+i+"");
                ch3.setAttribute("id", tmp3);
                ch3.setAttribute("name", tmp3);
                ch3.required= true;
                panel.appendChild(ch3);
                var ch4 = document.createElement("input");
                ch4.style.width="105px";
                var tmp4='rqid'+i;
                ch4.setAttribute("type", "text");
                ch4.setAttribute("placeholder", "To QID "+i+"");
                ch4.setAttribute("id", tmp4);
                ch4.setAttribute("name", tmp4);
                ch4.required= true;
                panel.appendChild(ch4);
                ch.appendChild(panel);
           }
        }
        if(rt=='8')
        {
           for (i = 1; i <= a; i++) {
                var panel=document.createElement("div");
                panel.style.width="885px"; panel.style.padding="0px";panel.style.align="left";
                var ch1 = document.createElement("input");
                ch1.style.width="205px";
                var tmp1='cqid'+i; var tm=''+i+'';
                ch1.setAttribute("type", "text");
                ch1.setAttribute("placeholder", "CQID"+i+"");
                ch1.setAttribute("id", tmp1);
                ch1.setAttribute("name", tmp1);
                ch1.required= true;
                panel.appendChild(ch1);
                var chr = document.createElement("input");
                chr.style.width="305px";
                var tmp='opv'+i; var tm=''+i+'';
                chr.setAttribute("type", "text");
                chr.setAttribute("placeholder", "OP Value"+i+"");
                chr.setAttribute("id", tmp);
                chr.setAttribute("name", tmp);
                chr.required= true;
                panel.appendChild(chr);
                var ch2 = document.createElement("input");
                ch2.style.width="105px";
                var tmp2='pqid'+i;
                ch2.setAttribute("type", "text");
                ch2.setAttribute("placeholder", "PQID "+i+"");
                ch2.setAttribute("id", tmp2);
                ch2.setAttribute("name", tmp2);
                ch2.required= true;
                panel.appendChild(ch2);
                 var ch3 = document.createElement("input");
                ch3.style.width="90px";
                var tmp3='sval'+i;
                ch3.setAttribute("type", "text");
                ch3.setAttribute("placeholder", "Start Value "+i+"");
                ch3.setAttribute("id", tmp3);
                ch3.setAttribute("name", tmp3);
                ch3.required= true;
                panel.appendChild(ch3);
                var ch4 = document.createElement("input");
                ch4.style.width="105px";
                var tmp4='eval'+i;
                ch4.setAttribute("type", "text");
                ch4.setAttribute("placeholder", "End Value "+i+"");
                ch4.setAttribute("id", tmp4);
                ch4.setAttribute("name", tmp4);
                ch4.required= true;
                panel.appendChild(ch4);

                ch.appendChild(panel);
           }
        }
        if(rt=='9')
        {
           for (i = 1; i <= a; i++) {
                var panel=document.createElement("div");
                panel.style.width="885px"; panel.style.padding="0px";panel.style.align="left";
                var ch1 = document.createElement("input");
                ch1.style.width="205px";
                var tmp1='cqid'+i; var tm=''+i+'';
                ch1.setAttribute("type", "text");
                ch1.setAttribute("placeholder", "CQID"+i+"");
                ch1.setAttribute("id", tmp1);
                ch1.setAttribute("name", tmp1);
                ch1.required= true;
                panel.appendChild(ch1);

                var ch2 = document.createElement("input");
                ch2.style.width="50px";
                var tmp2='opcode'+i;
                ch2.setAttribute("type", "text");
                ch2.setAttribute("placeholder", "OPCODE "+i+"");
                ch2.setAttribute("id", tmp2);
                ch2.setAttribute("name", tmp2);
                ch2.required= false;
                panel.appendChild(ch2);

                 var ch3 = document.createElement("input");
                ch3.style.width="90px";
                var tmp3='sval'+i;
                ch3.setAttribute("type", "text");
                ch3.setAttribute("placeholder", "Start Value "+i+"");
                ch3.setAttribute("id", tmp3);
                ch3.setAttribute("name", tmp3);
                ch3.required= true;
                panel.appendChild(ch3);
                var ch4 = document.createElement("input");
                ch4.style.width="105px";
                var tmp4='eval'+i;
                ch4.setAttribute("type", "text");
                ch4.setAttribute("placeholder", "End Value "+i+"");
                ch4.setAttribute("id", tmp4);
                ch4.setAttribute("name", tmp4);
                ch4.required= true;
                panel.appendChild(ch4);

                ch.appendChild(panel);
           }
        }

        if(rt=='10')
        {
           for (i = 1; i <= a; i++) {
                var panel=document.createElement("div");
                panel.style.width="485px"; panel.style.padding="0px";panel.style.align="left";
                var ch2 = document.createElement("input");
                ch2.style.width="150px";
                var tmp2='qid'+i;
                ch2.setAttribute("type", "text");
                ch2.setAttribute("placeholder", "QID "+i+"");
                ch2.setAttribute("id", tmp2);
                ch2.setAttribute("name", tmp2);
                ch2.required= true;
                panel.appendChild(ch2);
		ch.appendChild(panel);
           }
        }
        if(rt=='12')
        {
           for (i = 1; i <= a; i++) {
                var panel=document.createElement("div");
                panel.style.width="585px"; panel.style.padding="0px";panel.style.align="left";

                var ch1 = document.createElement("input");
                ch1.style.width="100px";
                var tmp1='cqid'+i;
                ch1.setAttribute("type", "text");
                ch1.setAttribute("placeholder", "CQID"+i+"");
                ch1.setAttribute("id", tmp1);
                ch1.setAttribute("name", tmp1);
                ch1.required= true;
                panel.appendChild(ch1);

                var ch2 = document.createElement("input");
                ch2.style.width="100px";
                var tmp2='cqopfr'+i;
                ch2.setAttribute("type", "text");
                ch2.setAttribute("placeholder", "CQ OP FR"+i+"");
                ch2.setAttribute("id", tmp2);
                ch2.setAttribute("name", tmp2);
                ch2.required= true;
                panel.appendChild(ch2);

                var ch3 = document.createElement("input");
                ch3.style.width="100px";
                var tmp3='cqopto'+i;
                ch3.setAttribute("type", "text");
                ch3.setAttribute("placeholder", "CQID OP TO"+i+"");
                ch3.setAttribute("id", tmp3);
                ch3.setAttribute("name", tmp3);
                ch3.required= true;
                panel.appendChild(ch3);

                var ch4 = document.createElement("input");
                ch4.style.width="100px";
                var tmp4='pqid'+i;
                ch4.setAttribute("type", "text");
                ch4.setAttribute("placeholder", "PQID"+i+"");
                ch4.setAttribute("id", tmp4);
                ch4.setAttribute("name", tmp4);
                ch4.required= true;
                panel.appendChild(ch4);

                var ch5 = document.createElement("input");
                ch5.style.width="100px";
                var tmp5='pqop'+i;
                ch5.setAttribute("type", "text");
                ch5.setAttribute("placeholder", "PQID OP"+i+"");
                ch5.setAttribute("id", tmp5);
                ch5.setAttribute("name", tmp5);
                ch5.required= true;
                panel.appendChild(ch5);

                ch.appendChild(panel);
           }
	}

        if(rt=='11')
        {
           for (i = 1; i <= a; i++) {
                var panel=document.createElement("div");
                panel.style.width="585px"; panel.style.padding="0px";panel.style.align="left";

                var ch1 = document.createElement("input");
                ch1.style.width="100px";
                var tmp1='cqid'+i;
                ch1.setAttribute("type", "text");
                ch1.setAttribute("placeholder", "CQID "+i+"");
                ch1.setAttribute("id", tmp1);
                ch1.setAttribute("name", tmp1);
                ch1.required= true;
                panel.appendChild(ch1);

                var ch2 = document.createElement("input");
                ch2.style.width="100px";
                var tmp2='pqid'+i;
                ch2.setAttribute("type", "text");
                ch2.setAttribute("placeholder", "PQID "+i+"");
                ch2.setAttribute("id", tmp2);
                ch2.setAttribute("name", tmp2);
                ch2.required= true;
                panel.appendChild(ch2);
                ch.appendChild(panel);

                var ch3 = document.createElement("input");
                ch3.style.width="100px";
                var tmp3='copv'+i;
                ch3.setAttribute("type", "text");
                ch3.setAttribute("placeholder", "CQID OP Value "+i+"");
                ch3.setAttribute("id", tmp3);
                ch3.setAttribute("name", tmp3);
                ch3.required= true;
                panel.appendChild(ch3);

                var ch4 = document.createElement("input");
                ch4.style.width="100px";
                var tmp4='val'+i;
                ch4.setAttribute("type", "text");
                ch4.setAttribute("placeholder", "Fix Value "+i+"");
                ch4.setAttribute("id", tmp4);
                ch4.setAttribute("name", tmp4);
                ch4.required= true;
                panel.appendChild(ch4);

                ch.appendChild(panel);

		} //end for loop
        } //end for  11
        if(rt=='13')
        {
           for (i = 1; i <= a; i++) {
                var panel=document.createElement("div");
                panel.style.width="585px"; panel.style.padding="0px";panel.style.align="left";

                var ch1 = document.createElement("input");
                ch1.style.width="100px";
                var tmp1='cqid'+i;
                ch1.setAttribute("type", "text");
                ch1.setAttribute("placeholder", "CQID"+i+"");
                ch1.setAttribute("id", tmp1);
                ch1.setAttribute("name", tmp1);
                ch1.required= true;
                panel.appendChild(ch1);

                var ch2 = document.createElement("input");
                ch2.style.width="100px";
                var tmp2='pqid'+i;
                ch2.setAttribute("type", "text");
                ch2.setAttribute("placeholder", "PQID"+i+"");
                ch2.setAttribute("id", tmp2);
                ch2.setAttribute("name", tmp2);
                ch2.required= true;
                panel.appendChild(ch2);

                var ch3 = document.createElement("input");
                ch3.style.width="100px";
                var tmp3='pqop'+i;
                ch3.setAttribute("type", "text");
                ch3.setAttribute("placeholder", "PQID OP"+i+"");
                ch3.setAttribute("id", tmp3);
                ch3.setAttribute("name", tmp3);
                ch3.required= true;
                panel.appendChild(ch3);

                var ch5 = document.createElement("input");
                ch5.style.width="100px";
                var tmp5='group'+i;
                ch5.setAttribute("type", "text");
                ch5.setAttribute("placeholder", "GROUP"+i+"");
                ch5.setAttribute("id", tmp5);
                ch5.setAttribute("name", tmp5);
                ch5.required= true;
                panel.appendChild(ch5);

                var ch4 = document.createElement("input");
                ch4.style.width="100px";
                var tmp4='flag'+i;
                ch4.setAttribute("type", "text");
                ch4.setAttribute("placeholder", "FLAG"+i+"");
                ch4.setAttribute("id", tmp4);
                ch4.setAttribute("name", tmp4);
                ch4.required= true;
                panel.appendChild(ch4);

                ch.appendChild(panel);
           }
	} //end of rt==13 grid qop showhide


}
function generate() {
        var a = parseInt(document.getElementById("cnt").value);
        var ch = document.getElementById("pqid");
        for (i = 1; i <= a; i++) {
            
            //var input = document.createElement("input");
            //var tmp='op'+i;
            //input.setAttribute("type", "text");
            //input.setAttribute("id", tmp);
            //input.setAttribute("name", tmp);
            //ch.appendChild(input);
                var panel=document.createElement("div");
                panel.style.width="485px"; panel.style.padding="0px";panel.style.align="left";
                
                
                var ch1 = document.createElement("input");
                ch1.style.width="85px";
                var tmp='stb'+i; var tm=''+i+'';
                ch1.setAttribute("type", "text");
                ch1.setAttribute("value",  tm );
                ch1.setAttribute("id", tmp);
                ch1.setAttribute("name", tmp);
                panel.appendChild(ch1);

                var ch2 = document.createElement("input");
                ch2.style.width="350px";
                var tmp2='tb'+i;
                ch2.setAttribute("type", "text");
                ch2.setAttribute("placeholder", "Text Element "+i+"");
                ch2.setAttribute("id", tmp2);
                ch2.setAttribute("name", tmp2);
                panel.appendChild(ch2);

                var ch3 = document.createElement("input");
                ch3.style.width="50px";
                var tmp3='flag'+i;
                ch3.setAttribute("type", "text");
                ch3.setAttribute("placeholder", "FLAG "+i+"");
                ch3.setAttribute("id", tmp3);
                ch3.setAttribute("name", tmp3);
                ch3.setAttribute("value", 0);
                panel.appendChild(ch3);

                ch.appendChild(panel);
        }

}
function update(action,item)
{
    var queryString =''; var ms='';
   if(action != "") {
		switch(action) {
			case "project":

                            var pid = document.getElementById('pn').value;
                            var pnn = document.getElementById('pnn').value;
                            var sdt = document.getElementById('sdt').value;
                            var edt = document.getElementById('edt').value;
                            var cn = document.getElementById('cn').value;
                            var v = document.getElementById('v').value;
                            var b = document.getElementById('b').value;
                            var rt = document.getElementById('rt').value;
                            var rp = document.getElementById('rp').value;
                            var ss = document.getElementById('ss').value;
                            var bk = document.getElementById('bk').value;
                            var st = document.getElementById('st').value;

                             queryString = 'pid='+pid+'&pn='+pnn+'&sdt='+sdt+'&edt='+edt+'&cn='+cn+'&v='+v+'&b='+b+'&rt='+rt+'&rp='+rp+'&ss='+ss+'&bk='+bk+'&st='+st;
                             ms='#'+pid;
			break;
                        case "question":
			 	 q1='qid'+item;q2='qno'+item;q3='title'+item;q4='qt'+item;
                            var qid = document.getElementById(q1).value;
                            var qn = document.getElementById(q2).value;
                            var title = document.getElementById(q3).value;
                            var qt = document.getElementById(q4).value;

                           queryString = 'qid='+qid+'&qno='+qn+'&title='+title+'&qt='+qt;
                            //queryString = 'qid='+qid+'qno='+qn+'title='+title+'qt='+qt;
			    ms='#'+qid;
			break;
                        case "questionop":
			 	 q='id'+item;q1='qid'+item;q2='txt'+item;q3='value'+item; q4='term'+item; q5='flag'+item;
                            var qid = document.getElementById(q1).value;
                            var txt = document.getElementById(q2).value;
                            var val = document.getElementById(q3).value;
                            var term = document.getElementById(q4).value;
                            var flag = document.getElementById(q5).value;
                            var id = document.getElementById(q).value;

                            queryString = 'id='+id+'&qid='+qid+'&txt='+txt+'&val='+val+'&term='+term+'&flag='+flag;
                             ms='#'+id;
			break;
                        case "sequence":
			 	q='id'+item; q1='qid'+item;q2='sid'+item;q3='flag'+item;q0='qset'+item;
                            var qid = document.getElementById(q1).value;
                            var sid = document.getElementById(q2).value;
                            var flag= document.getElementById(q3).value;
                            var qset = document.getElementById(q0).value;
                            var id = document.getElementById(q).value;

                            queryString = 'qid='+qid+'&qset='+qset+'&sid='+sid+'&flag='+flag+'&id='+id;
                             ms='#'+id;
			break;
                        case "sequenced":
                                q='id'+item; q1='qid'+item;q2='sid'+item;q3='flag'+item;q0='qset'+item;
                            var qid = document.getElementById(q1).value;
                            var sid = document.getElementById(q2).value;
                            var flag= document.getElementById(q3).value;
                            var qset = document.getElementById(q0).value;
                            var id = document.getElementById(q).value;

                            queryString = 'qid='+qid+'&qset='+qset+'&sid='+sid+'&flag='+flag+'&id='+id;
                             ms='#'+id;
                        break;
                        case "routine":
			 	q0='id'+item; q1='qid'+item;q2='pqid'+item;q3='opval'+item;q4='flow'+item;
                            var qid = document.getElementById(q1).value;
                            var pqid = document.getElementById(q2).value;
                            var opval = document.getElementById(q3).value;
                            var flow = document.getElementById(q4).value;
                            var id = document.getElementById(q0).value;
                            queryString = 'id='+id+'&qid='+qid+'&pqid='+pqid+'&opval='+opval+'&flow='+flow;
                             ms='#'+id;
			break;
                        case "routined":
                                q0='id'+item; q1='qid'+item;q2='pqid'+item;q3='opval'+item;q4='flow'+item;
                            var qid = document.getElementById(q1).value;
                            var pqid = document.getElementById(q2).value;
                            var opval = document.getElementById(q3).value;
                            var flow = document.getElementById(q4).value;
                            var id = document.getElementById(q0).value;
                            queryString = 'id='+id+'&qid='+qid+'&pqid='+pqid+'&opval='+opval+'&flow='+flow;
                             ms='#'+id;
                        break;
                        case "updatesequence": 
			 	 	 q1='qset';q2='ssid';q3='esid';
                            var qset = document.getElementById(q1).value;
                            var ssid = document.getElementById(q2).value;
                            var esid= document.getElementById(q3).value;

                            queryString = 'qset='+qset+'&ssid='+ssid+'&esid='+esid;
                             ms='#msg';
			break;
                        case "pcentre":
			 	 q1='qid'+item;q2='qno'+item;q3='title'+item;q4='qt'+item;
                            var qid = document.getElementById(q1).value;
                            var qn = document.getElementById(q2).value;
                            var title = document.getElementById(q3).value;
                            var qt = document.getElementById(q4).value;

                            queryString = 'qid='+qid+'&qno='+qn+'&title='+title+'&qt='+qt;
                             ms='#'+qid;
			break;
                        case "rule1":
			 	 q1='qid'+item;q2='sn'+item;q3='gc'+item;q4='id'+item;
                            var qid = document.getElementById(q1).value;
                            var sn = document.getElementById(q2).value;
                            var gc = document.getElementById(q3).value;
                            var id = document.getElementById(q4).value;

                            queryString = 'qid='+qid+'&sn='+sn+'&gc='+gc+'&id='+id;
                             ms='#'+id;
			break;
                        case "rule2":
			 	 q1='qid'+item;q2='tab'+item;q3='q'+item;q4='id'+item;q5='op'+item;
                            var qid = document.getElementById(q1).value;
                            var tab = document.getElementById(q2).value;
                            var q = document.getElementById(q3).value;
                            var id = document.getElementById(q4).value;
                            var op = document.getElementById(q5).value;

                            queryString = 'qid='+qid+'&tab='+tab+'&op='+op+'&q='+q+'&id='+id;
                             ms='#'+id;
			break;
                        case "rule3":
			 	 q1='qid'+item; q2='flag'+item; q3='gc'+item;q4='id'+item;
                            var qid = document.getElementById(q1).value;
                            var f = document.getElementById(q2).value;
                            var gc = document.getElementById(q3).value;
                            var id = document.getElementById(q4).value;

                            queryString = 'qid='+qid+'&gc='+gc+'&flag='+f+'&id='+id;
                             ms='#'+id;
			break;
                         case "rule1d":
			 	 q1='qid'+item;q2='sn'+item;q3='gc'+item;q4='id'+item;
                            var qid = document.getElementById(q1).value;
                            var sn = document.getElementById(q2).value;
                            var gc = document.getElementById(q3).value;
                            var id = document.getElementById(q4).value;

                            queryString = 'qid='+qid+'&sn='+sn+'&gc='+gc+'&id='+id;
                             ms='#'+id;
			break;
                        case "rule2d":
			 	 q1='qid'+item;q2='tab'+item;q3='q'+item;q4='id'+item;q5='op'+item;
                            var qid = document.getElementById(q1).value;
                            var tab = document.getElementById(q2).value;
                            var q = document.getElementById(q3).value;
                            var id = document.getElementById(q4).value;
                            var op = document.getElementById(q5).value;

                            queryString = 'qid='+qid+'&tab='+tab+'&op='+op+'&q='+q+'&id='+id;
                             ms='#'+id;
			break;
                        case "rule3d":
			 	 q1='qid'+item;q3='gc'+item;q4='id'+item;
                            var qid = document.getElementById(q1).value;
                            var gc = document.getElementById(q3).value;
                            var id = document.getElementById(q4).value;

                            queryString = 'qid='+qid+'&gc='+gc+'&id='+id;
                             ms='#'+id;
			break;
                        case "ruleand":
			 	 q1='qid'+item;q2='flag'+item; q3='gc'+item;q4='id'+item;
                            var qid = document.getElementById(q1).value;
                            var f = document.getElementById(q2).value;
                            var gc = document.getElementById(q3).value;
                            var id = document.getElementById(q4).value;

                            queryString = 'qid='+qid+'&cqid='+gc+'&flag='+f+'&id='+id;
                             ms='#'+id;
			break;
                        case "ruleandd":
			 	 q1='qid'+item;q3='gc'+item;q4='id'+item;
                            var qid = document.getElementById(q1).value;
                            var gc = document.getElementById(q3).value;
                            var id = document.getElementById(q4).value;

                            queryString = 'qid='+qid+'&cqid='+gc+'&id='+id;
                             ms='#'+id;
			break;
                        case "ruleshow":
			 	 q1='qid'+item;q3='gc'+item;q4='id'+item;
                            var qid = document.getElementById(q1).value;
                            var gc = document.getElementById(q3).value;
                            var id = document.getElementById(q4).value;

                            queryString = 'qid='+qid+'&cqid='+gc+'&id='+id;
                             ms='#'+id;
			break;
                        case "ruleshowd":
			 	 q1='qid'+item;q3='gc'+item;q4='id'+item;
                            var qid = document.getElementById(q1).value;
                            var gc = document.getElementById(q3).value;
                            var id = document.getElementById(q4).value;

                            queryString = 'qid='+qid+'&cqid='+gc+'&id='+id;
                             ms='#'+id;
			break;
                        case "rulehide":
			 	 q1='qid'+item;q3='gc'+item;q4='id'+item;
                            var qid = document.getElementById(q1).value;
                            var gc = document.getElementById(q3).value;
                            var id = document.getElementById(q4).value;

                            queryString = 'qid='+qid+'&cqid='+gc+'&id='+id;
                             ms='#'+id;
			break;
                        case "rulehided":
			 	 q1='qid'+item;q3='gc'+item;q4='id'+item;
                            var qid = document.getElementById(q1).value;
                            var gc = document.getElementById(q3).value;
                            var id = document.getElementById(q4).value;

                            queryString = 'qid='+qid+'&cqid='+gc+'&id='+id;
                             ms='#'+id;
			break;
                        case "rulefindreplace":
                                 q1='pqid'+item; q2='cqid'+item; q3='opv'+item; q4='fstr'+item;q5='rstr'+item;  idd='id'+item;
                            var pqid = document.getElementById(q1).value;
                            var cqid = document.getElementById(q2).value;
                            var opv = document.getElementById(q3).value;
                            var fstr = document.getElementById(q4).value
                            var rstr = document.getElementById(q5).value;

                            var id = document.getElementById(idd).value;

                            queryString = 'rqid='+pqid+'&cqid='+cqid+'&opv='+opv+'&fstr='+fstr+'&rstr='+rstr+'&id='+id;
                             ms='#'+id;
                        break;
                        case "rulefindreplaced":
                                 q1='pqid'+item; q2='cqid'+item; q3='opv'+item; q4='fstr'+item;q5='rstr'+item;  idd='id'+item;
                            var pqid = document.getElementById(q1).value;
                            var cqid = document.getElementById(q2).value;
                            var opv = document.getElementById(q3).value;
                            var fstr = document.getElementById(q4).value
                            var rstr = document.getElementById(q5).value;

                            var id = document.getElementById(idd).value;

                            queryString = 'rqid='+pqid+'&cqid='+cqid+'&opv='+opv+'&fstr='+fstr+'&rstr='+rstr+'&id='+id;
                             ms='#'+id;
                        break;
                        case "ruleautoselect":
                                 q1='pqid'+item; q2='cqid'+item; q3='opv'+item; q4='fstr'+item;q5='rstr'+item;  idd='id'+item;
                            var pqid = document.getElementById(q1).value;
                            var cqid = document.getElementById(q2).value;
                            var opv = document.getElementById(q3).value;
                            var fstr = document.getElementById(q4).value
                            var rstr = document.getElementById(q5).value;

                            var id = document.getElementById(idd).value;

                            queryString = 'pqid='+pqid+'&cqid='+cqid+'&opv='+opv+'&fstr='+fstr+'&rstr='+rstr+'&id='+id;
                             ms='#'+id;
                        break;
                        case "ruleautoselectd":
                                 q1='pqid'+item; q2='cqid'+item; q3='opv'+item; q4='fstr'+item;q5='rstr'+item;  idd='id'+item;
                            var pqid = document.getElementById(q1).value;
                            var cqid = document.getElementById(q2).value;
                            var opv = document.getElementById(q3).value;
                            var fstr = document.getElementById(q4).value
                            var rstr = document.getElementById(q5).value;

                            var id = document.getElementById(idd).value;

                            queryString = 'pqid='+pqid+'&cqid='+cqid+'&opv='+opv+'&fstr='+fstr+'&rstr='+rstr+'&id='+id;
                             ms='#'+id;
                        break;

                        case "rulenumlimit":
                                  q2='cqid'+item;q3='opcode'+item; q4='fstr'+item; q5='rstr'+item; idd='id'+item;
                            var cqid = document.getElementById(q2).value;
                            var opv = document.getElementById(q3).value;
                            var fstr = document.getElementById(q4).value
                            var rstr = document.getElementById(q5).value;
                            var id = document.getElementById(idd).value;

                            queryString = 'cqid='+cqid+'&opcode='+opv+'&fstr='+fstr+'&rstr='+rstr+'&id='+id;
                             ms='#'+id;
                        break;
                        case "rulenumlimitd":
                                  q2='cqid'+item; q3='opcode'+item;q4='fstr'+item; q5='rstr'+item; idd='id'+item;
                            var cqid = document.getElementById(q2).value;
                            var opv = document.getElementById(q3).value;
                            var fstr = document.getElementById(q4).value
                            var rstr = document.getElementById(q5).value;
                            var id = document.getElementById(idd).value;

                            queryString = 'cqid='+cqid+'&opcode='+opv+'&fstr='+fstr+'&rstr='+rstr+'&id='+id;
                             ms='#'+id;
                        break;

                        case "ruleqoprange":
                                  q1='cqid'+item;q2='cqopfr'+item; q3='cqopto'+item; q4='pqid'+item; q5='pqop'+item; idd='id'+item;
                            var cqid = document.getElementById(q1).value;
                            var cqopfr = document.getElementById(q2).value;
                            var cqopto = document.getElementById(q3).value;
                            var pqid = document.getElementById(q4).value
                            var pqop = document.getElementById(q5).value;
                            var id = document.getElementById(idd).value;

                            queryString = 'cqid='+cqid+'&cqopfr='+cqopfr+'&cqopto='+cqopto+'&pqid='+pqid+'&pqop='+pqop+'&id='+id;
                             ms='#'+id;
                        break;

                        case "ruleqopranged":
                                  q1='cqid'+item;q2='cqopfr'+item; q3='cqopto'+item; q4='pqid'+item; q5='pqop'+item; idd='id'+item;
                            var cqid = document.getElementById(q1).value;
                            var cqopfr = document.getElementById(q2).value;
                            var cqopto = document.getElementById(q3).value;
                            var pqid = document.getElementById(q4).value
                            var pqop = document.getElementById(q5).value;
                            var id = document.getElementById(idd).value;

                            queryString = 'cqid='+cqid+'&cqopfr='+cqopfr+'&cqopto='+cqopto+'&pqid='+pqid+'&pqop='+pqop+'&id='+id;
                             ms='#'+id;
                        break;


                        case "rulerecording":
                                  q2='qid'+item; idd='id'+item;
                            var cqid = document.getElementById(q2).value;
                            var id = document.getElementById(idd).value;

                            queryString = 'qid='+cqid+'&id='+id;
                             ms='#'+id;
                        break;
                        case "rulerecordingd":
                                  q2='qid'+item; idd='id'+item;
                            var cqid = document.getElementById(q2).value;
                            var id = document.getElementById(idd).value;

                            queryString = 'qid='+cqid+'&id='+id;
                             ms='#'+id;
                        break;
                        case "ruleautofixcode":
                                 q1='cqid'+item; q2='pqid'+item; q3='copv'+item; q4='val'+item; idd='id'+item;
                            var cqid = document.getElementById(q1).value;
                            var pqid = document.getElementById(q2).value;
                            var copv = document.getElementById(q3).value
                            var val = document.getElementById(q4).value;
                            var id = document.getElementById(idd).value;

                            queryString = 'cqid='+cqid+'&pqid='+pqid+'&copv='+copv+'&val='+val+'&id='+id;

                             ms='#'+id;
                        break;
                        case "ruleautofixcoded":
                                 q1='cqid'+item; q2='pqid'+item; q3='copv'+item; q4='val'+item; idd='id'+item;
                            var cqid = document.getElementById(q1).value;
                            var pqid = document.getElementById(q2).value;
                            var copv = document.getElementById(q3).value
                            var val = document.getElementById(q4).value;
                            var id = document.getElementById(idd).value;

                            queryString = 'cqid='+cqid+'&pqid='+pqid+'&copv='+copv+'&val='+val+'&id='+id;
                             ms='#'+id;
                        break;
                        case "rulegridqopshowhide":
                                 q1='cqid'+item; q2='pqid'+item; q3='pqop'+item; q4='flag'+item; q5 = 'group'+item; idd='id'+item;
                            var cqid = document.getElementById(q1).value;
                            var pqid = document.getElementById(q2).value;
                            var pqopv = document.getElementById(q3).value
                            var val = document.getElementById(q4).value;
                            var grp = document.getElementById(q5).value;
                            var id = document.getElementById(idd).value;
                            queryString = 'cqid='+cqid+'&pqid='+pqid+'&pqop='+pqopv+'&group='+grp+'&flag='+val+'&id='+id;
                             ms='#'+id;
                        break;
                        case "rulegridqopshowhided":
                                 q1='cqid'+item; q2='pqid'+item; q3='pqop'+item; q4='flag'+item;q5 = 'group'+item; idd='id'+item;
                            var cqid = document.getElementById(q1).value;
                            var pqid = document.getElementById(q2).value;
                            var pqopv = document.getElementById(q3).value
                            var val = document.getElementById(q4).value;
                            var grp = document.getElementById(q5).value;
                            var id = document.getElementById(idd).value;
                            queryString = 'cqid='+cqid+'&pqid='+pqid+'&pqop='+pqopv+'&group='+grp+'&flag='+val+'&id='+id;
                             ms='#'+id;
                        break;


                        case "rule7e":
                            q1='cqid'+item;q2='rqid'+item;q3='fwd'+item;q4='rwd'+item;q5='op'+item;q6='id'+item;
                            var cqid = document.getElementById(q1).value;
                            var rqid = document.getElementById(q2).value;
                            var fwd = document.getElementById(q3).value;
                            var rwd = document.getElementById(q4).value;
                            var op = document.getElementById(q5).value;
                            var id = document.getElementById(q6).value;

                            queryString = 'cqid='+cqid+'&rqid='+rqid+'&op='+op+'&fwd='+fwd+'&rwd='+rwd+'&id='+id;
                             ms='#'+id;
                        break;
                        case "rule7d":
                            q1='cqid'+item;q2='rqid'+item;q3='fwd'+item;q4='rwd'+item;q5='op'+item;q6='id'+item;
                            var cqid = document.getElementById(q1).value;
                            var rqid = document.getElementById(q2).value;
                            var fwd = document.getElementById(q3).value;
                            var rwd = document.getElementById(q4).value;
                            var op = document.getElementById(q5).value;
                            var id = document.getElementById(q6).value;

                            queryString = 'cqid='+cqid+'&rqid='+rqid+'&op='+op+'&fwd='+fwd+'&rwd='+rwd+'&id='+id;
                             ms='#'+id;
                        break;
                        case "centre":
                            q1='id'+item;q2='pid'+item;q3='c'+item;
                            var id = document.getElementById(q1).value;
                            var pid = document.getElementById(q2).value;
                            var code = document.getElementById(q3).value;
                            // var qt = document.getElementById(q4).value;
                            queryString = 'id='+id+'&project_id='+pid+'&centre_id='+code;
                            ms='#'+id;
                        break;
                        case "store":
                            q1='id'+item;q2='pid'+item;q3='c'+item;q4='s'+item;
                            var id = document.getElementById(q1).value;
                            var pid = document.getElementById(q2).value;
                            var code = document.getElementById(q3).value;
                            var nm = document.getElementById(q4).value;
                            queryString = 'id='+id+'&qset_id='+pid+'&valuee='+code+'&store='+nm;
                            ms='#'+id;
                        break;
                        case "stored":
                            q1='id'+item;q2='pid'+item;q3='c'+item;q4='s'+item;
                            var id = document.getElementById(q1).value;
                            var pid = document.getElementById(q2).value;
                            var code = document.getElementById(q3).value;
                            var nm = document.getElementById(q4).value;
                            queryString = 'id='+id+'&qset_id='+pid+'&valuee='+code+'&store='+nm;
                            ms='#'+id;
                        break;
                        case "product":
                            q1='id'+item;q2='pid'+item;q3='c'+item;q4='s'+item;
                            var id = document.getElementById(q1).value;
                            var pid = document.getElementById(q2).value;
                            var code = document.getElementById(q3).value;
                            var nm = document.getElementById(q4).value;
                            queryString = 'id='+id+'&qset_id='+pid+'&valuee='+code+'&product='+nm;
                            ms='#'+id;
                        break;
                        case "productd":
                            q1='id'+item;q2='pid'+item;q3='c'+item;q4='s'+item;
                            var id = document.getElementById(q1).value;
                            var pid = document.getElementById(q2).value;
                            var code = document.getElementById(q3).value;
                            var nm = document.getElementById(q4).value;
                            queryString = 'id='+id+'&qset_id='+pid+'&valuee='+code+'&product='+nm;
                            ms='#'+id;
                        break;

                        case "sec":
                            q1='id'+item;q2='pid'+item;q3='c'+item;q4='s'+item;
                            var id = document.getElementById(q1).value;
                            var pid = document.getElementById(q2).value;
                            var code = document.getElementById(q3).value;
                            var nm = document.getElementById(q4).value;
                            queryString = 'id='+id+'&qset='+pid+'&valuee='+code+'&sec='+nm;
                            ms='#'+id;
                        break;
                        case "secd":
                            q1='id'+item;q2='pid'+item;q3='c'+item;q4='s'+item;
                            var id = document.getElementById(q1).value;
                            var pid = document.getElementById(q2).value;
                            var code = document.getElementById(q3).value;
                            var nm = document.getElementById(q4).value;
                            queryString = 'id='+id+'&qset='+pid+'&valuee='+code+'&sec='+nm;
                            ms='#'+id;
                        break;

                        case "age":
                            q1='id'+item;q2='pid'+item;q3='c'+item;q4='a'+item;
                            var id = document.getElementById(q1).value;
                            var pid = document.getElementById(q2).value;
                            var code = document.getElementById(q3).value;
                            var nm = document.getElementById(q4).value;
                            queryString = 'id='+id+'&qset='+pid+'&valuee='+code+'&age='+nm;
                            ms='#'+id;
                        break;
                        case "aged":
                            q1='id'+item;q2='pid'+item;q3='c'+item;q4='a'+item;
                            var id = document.getElementById(q1).value;
                            var pid = document.getElementById(q2).value;
                            var code = document.getElementById(q3).value;
                            var nm = document.getElementById(q4).value;
                            queryString = 'id='+id+'&qset='+pid+'&valuee='+code+'&age='+nm;
                            ms='#'+id;
                        break;

                        case "addfp":
                            q1='id'+item;q2='pid'+item;
                            var id = document.getElementById(q1).value;
                            var pid = document.getElementById(q2).value;
                            queryString = 'id='+id+'&qset='+pid;
                            ms='#'+id;
                        break;
                        case "deletefp":
                            q1='id'+item;q2='pid'+item;
                            var id = document.getElementById(q1).value;
                            var pid = document.getElementById(q2).value;
                            queryString = 'id='+id+'&qset='+pid;
                            ms='#'+id;
                        break;

		}
    }
 
// alert('Updating...'+item);
  jQuery.ajax({ 
	 url:'<?php echo base_url("siteadmin/updateproject/"); ?>'+action,
	data:queryString,
	type: "GET",
	success:function(data){   
		$(ms).html(data);
	},
	error:function (er){ $(ms).html(er); }
	});
}

function cat(action,item)
{     
    var queryString =''; var ms='';  
   if(action != "") {
		switch(action) {			
                        case "catn":
                            var cnn = document.getElementById('catname').value;
                            queryString = 'catname='+cnn;
                             ms='#msg';
			break;
                        case "catv":
                            var cnn = document.getElementById('catname').value;
                            queryString = 'catname='+cnn;
                             ms='#msg';
			break;
		}
    }
  jQuery.ajax({
	 url:'<?php echo base_url("index.php/siteadmin/createqbcat/action/"); ?>'+action,
     
	data:queryString,
	type: "GET",
	success:function(data){  
		$(ms).html(data);
	},
	error:function (){}
	});
}
function qcat(action,item)
{     
    var queryString =''; var ms=''; 
   if(action != "") {
		switch(action) {	
                        case "qbycat":
                             var cn = document.getElementById('cat').value;
                             queryString = 'cat='+cn;
                             ms='#qlist';
			break;
                        case "qbykey":
                            var cnn = document.getElementById('skey').value;
                            queryString = 'key='+cnn;
                            ms='#qlist';
			break;
                        case "qbyp":
                            var cnn = document.getElementById('fpn').value;
                            queryString = 'fpn='+cnn;
                            ms='#qlist';
			break;
                        case "qbykeyp":
                            var k = document.getElementById('skey').value; 
                            var fpn = document.getElementById('fpn').value; 
                            queryString = 'key='+k+' &fpn='+fpn;
                            ms='#qlist';
			break;
		}
    }
  jQuery.ajax({
	 url:'<?php echo base_url("index.php/siteadmin/copyqbcat/action/"); ?>'+action,     
	data:queryString,
	type: "GET",
	success:function(data){  
		$(ms).html(data);
	},
	error:function (){}
	});
}
</script>
<script>
function showhideqop(id) {
    var x = document.getElementById(id);
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else { 
        x.className = x.className.replace(" w3-show", "");
    }
}
</script>

<script type="text/javascript">
        var specialKeys = new Array();
        specialKeys.push(8); //Backspace
        specialKeys.push(9); //Tab
        specialKeys.push(46); //Delete
        specialKeys.push(36); //Home
        specialKeys.push(35); //End
        specialKeys.push(37); //Left
        specialKeys.push(39); //Right

        function IsAlphaNumber(e) { 
		//alert('New Project');
            var keyCode = e.keyCode == 0 ? e.charCode : e.keyCode;
//            var ret = ((keyCode >= 48 && keyCode <= 57) || (keyCode >= 65 && keyCode <= 90) || (keyCode >= 97 && keyCode <= 122) || 
//(specialKeys.indexOf(e.keyCode) != -1 && e.charCode != e.keyCode));
//            document.getElementById("error").style.display = ret ? "none" : "inline";
//            return ret;
		if((keyCode >= 48 && keyCode <= 57) || (keyCode >= 65 && keyCode <= 90) || (keyCode >= 97 && keyCode <= 122)){
			document.getElementById("error").style.display = "none" ;
			return true;
		}
		else{
			document.getElementById("error").style.display =  "inline";
			return false;
		}
        }
        function IsNotAlphaNumber(e) {
              	var keyCode = e.keyCode == 0 ? e.charCode : e.keyCode;
         	var address = document.getElementById('qtitle').value;
  		if(JSON.parse(address))
  		{
    			alert('One or more illegal characters were found, the first being character ' + ( result.index + 1 ) + ' "' + result +'".\\Please edit your input.');
  		}
        }
</script>

    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>public/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url(); ?>public/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>


    <!-- Theme JavaScript -->
    <script src="<?php echo base_url(); ?>public/js/agency.min.js"></script>
    
<script src="<?php echo base_url(); ?>public/js/sb-admin-2.js"> </script>
<script src="<?php echo base_url(); ?>public/js/sb-admin-2.min.js"> </script>

<!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url(); ?>public/metismenu/metisMenu.min.js"></script>
<!-- check for submit button confirmation -->
<script type="text/javascript">
function validate()
{
     var r=confirm("Do you want to continue this?")
    if (r==true)
      return true;
    else
      return false;
}


</script>

<script type="text/javascript">

   function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            alert("Please enter only Numbers.");
            return false;
        }

        return true;
    }
</script>
<!-- Apply dropdown check list to the selected items  -->

<?php } ?>


