<?php
//print_r($_SESSION);
  $isSALogin= $this->session->userdata('isSALogin');
    if($isSALogin=='')
    { 
            //Redirect::to('index.php');
             $this->load->view('sadm_login_form');
    }
?>
<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>QuantumCS | Digiadmin</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="author" content="Digiadmin" />
	<link rel="shortcut icon" href="<?php echo base_url(); ?>public/img/logos/quantum-logo-big.png">
	<!-- food icons -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/menu/css/organicfoodicons.css" />
	 <!-- demo styles -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/menu/css/demo.css" />
	<!-- menu styles -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/menu/css/component.css" />
	<script src="<?php echo base_url(); ?>public/menu/js/modernizr-custom.js"></script>
</head>

<body  style="background:#fff">
	<!-- Main container -->
	<div class="container" style="">

		<!-- Blueprint header -->
		<header class="bp-header cf">
			<div class="dummy-logo">
				<!-- <div class="dummy-icon foodicon foodicon--coconut"></div> -->
				<h2 class="dummy-heading"> <img src="<?php echo base_url(); ?>public/img/logos/quantum-logo-big.png" width=80px height=80px></h2>
			</div>
		<!-- -->
				<div class="bp-header__main">
				<span class="bp-header__present" style="color:green;"> <a href="<?php echo base_url(); ?>siteadmin/salogout" style="color:green;"> Logout </a>|  DIGIADMIN <span class="bp-tooltip bp-icon bp-icon--about" data-content="The SiteAdmin is a collection of basic tools to administrate Varenia's operational tasks."></span></span>
		<!--		<h1 class="bp-header__title">Multi-Level Menu</h1>
				<nav class="bp-nav">
					<a class="bp-nav__item bp-icon bp-icon--prev" href="http://tympanus.net/Blueprints/PageStackNavigation/" data-info="previous Blueprint"><span>Previous Blueprint</span></a>
		-->			<!--a class="bp-nav__item bp-icon bp-icon--next" href="" data-info="next Blueprint"><span>Next Blueprint</span></a-->
		<!--			<a class="bp-nav__item bp-icon bp-icon--drop" href="http://tympanus.net/codrops/?p=25521" data-info="back to the Codrops article"><span>back to the Codrops article</span></a>
					<a class="bp-nav__item bp-icon bp-icon--archive" href="http://tympanus.net/codrops/category/blueprints/" data-info="Blueprints archive"><span>Go to the archive</span></a>
				</nav>
			</div>
		-->
		</header>
		<button class="action action--open" aria-label="Open Menu"><span class="icon icon--menu"></span></button>
		<nav id="ml-menu" class="menu">
			<button class="action action--close" aria-label="Close Menu" style="background:black;"><span class="icon icon--cross"></span></button>
			<div class="menu__wrap">
              <?php 
			$role=$this->session->userdata('sauseridrole');
			$permission=$_SESSION['permission'];
              if(empty($permission))
                              echo 'You have no access permissions. Please contact to Admin.';
              else
              {
		?>
				<ul data-menu="main" class="menu__level" tabindex="-1" role="menu" aria-label="All">
					<?php 
					if(in_array('1',$permission) || in_array('2',$permission) || in_array('3',$permission)){ ?>
					<li class="menu__item" role="menuitem"><a class="menu__link" data-submenu="submenu-1" aria-owns="submenu-1" href="#">Admin User</a></li>
					<?php } if(in_array('20',$permission) ) { ?>
					<li class="menu__item" role="menuitem"><a class="menu__link" data-submenu="submenu-hr" aria-owns="submenu-hr" href="#">HR </a></li>
					<?php } ?>
                                        <?php
                                        if(in_array('4',$permission) || in_array('5',$permission) || in_array('6',$permission)  || in_array('7',$permission)){ ?>
					<li class="menu__item" role="menuitem"><a class="menu__link" data-submenu="submenu-2" aria-owns="submenu-2" href="#">Questionnaire</a></li>
					<?php }
                                        if(in_array('11',$permission) || in_array('12',$permission)){ ?>
					<li class="menu__item" role="menuitem"><a class="menu__link" data-submenu="submenu-3" aria-owns="submenu-3" href="#">Device </a></li>
                                        <?php }
                                        if(in_array('13',$permission) || in_array('14',$permission) ){ ?>
					<li class="menu__item" role="menuitem"><a class="menu__link" data-submenu="submenu-4" aria-owns="submenu-4" href="#">Serveygenics</a></li>
					<?php } ?>
					<li class="menu__item" role="menuitem"><a class="menu__link" data-submenu="submenu-5" aria-owns="submenu-5" href="#">More Tools </a></li>
					<li class="menu__item" role="menuitem"><a class="menu__link" data-submenu="submenu-6" aria-owns="submenu-6" href="#">Report </a></li>

				</ul>
		<?php } ?>
                                <!-- Submenu hr -->
                                <ul data-menu="submenu-hr" id="submenu-hr" class="menu__level" tabindex="-1" role="menu" aria-label="HR">
                                        <li class="menu__item" role="menuitem"><a class="menu__link" href="#">HR Action</a></li>
                                        <li class="menu__item" role="menuitem"><a class="menu__link" href="#">HR Report</a></li>
                                </ul>

				<!-- Submenu 1 -->
				<ul data-menu="submenu-1" id="submenu-1" class="menu__level" tabindex="-1" role="menu" aria-label="Admin User">
					<li class="menu__item" role="menuitem"><a class="menu__link" href="#">User</a></li>
					<li class="menu__item" role="menuitem"><a class="menu__link" href="#">Permission</a></li>
				</ul>


				<!-- Submenu 2 -->
<?php if(in_array('4',$permission) || in_array('5',$permission) || in_array('6',$permission) || in_array('7',$permission) ) { ?>
				<ul data-menu="submenu-2" id="submenu-2" class="menu__level" tabindex="-1" role="menu" aria-label="Questionnaire">
<?php if(in_array('4',$permission)) { ?>
					<li class="menu__item" role="menuitem"><a class="menu__link" href="#">Create</a></li>
<?php }if(in_array('6',$permission)) { ?>
					<li class="menu__item" role="menuitem"><a class="menu__link" href="#">View</a></li>
<?php }if(in_array('7',$permission)) { ?>
					<li class="menu__item" role="menuitem"><a class="menu__link" href="#">Delete</a></li>
<?php }if(in_array('7',$permission)) { ?>
					<li class="menu__item" role="menuitem"><a class="menu__link" href="#">Add</a></li>
<?php }if(in_array('7',$permission)) { ?>
					<li class="menu__item" role="menuitem"><a class="menu__link" href="#">Edit</a></li>
<?php }if(in_array('4',$permission)) { ?>
					<li class="menu__item" role="menuitem"><a class="menu__link" href="#">Copy</a></li>
<?php } ?>
				</ul>
<?php } ?>
				<!-- Submenu 3 -->
				<ul data-menu="submenu-3" id="submenu-3" class="menu__level" tabindex="-1" role="menu" aria-label="Device">
					<li class="menu__item" role="menuitem"><a class="menu__link" data-submenu="submenu-3-1" aria-owns="submenu-3-1"  href="#">Allocation</a></li>
					<li class="menu__item" role="menuitem"><a class="menu__link" data-submenu="submenu-3-2" aria-owns="submenu-3-2" href="#">Permission</a></li>
				</ul>
				<!-- Submenu 3-1 -->
                                        <?php 
                                        if(in_array('11',$permission)){ ?>
				<ul data-menu="submenu-3-1" id="submenu-3-1" class="menu__level" tabindex="-1" role="menu" aria-label="Allocation">
					<li class="menu__item" role="menuitem"><a class="menu__link" href="#">Allocation Action</a></li>
                                        <li class="menu__item" role="menuitem"><a class="menu__link" href="#">Allocation Report</a></li>
				</ul>
                                <!-- Submenu 3-2 -->
                                        <?php }
                                        if(in_array('12',$permission)){ ?>
                                <ul data-menu="submenu-3-2" id="submenu-3-2" class="menu__level" tabindex="-1" role="menu" aria-label="Permission">
                                        <li class="menu__item" role="menuitem"><a class="menu__link" href="#">Permission Action</a></li>
                                        <li class="menu__item" role="menuitem"><a class="menu__link" href="#">Permission Report</a></li>
                                </ul>
					<?php } ?>
				<!-- Submenu 4 -->
                                        <?php
                                        if(in_array('13',$permission) || in_array('14',$permission) ){ ?>

				<ul data-menu="submenu-4" id="submenu-4" class="menu__level" tabindex="-1" role="menu" aria-label="Mangopinion">
					<li class="menu__item" role="menuitem"><a class="menu__link" href="#">Panel</a></li>
				</ul>
				<?php } ?>
				<!-- Submenu 5 -->
				<ul data-menu="submenu-5" id="submenu-5" class="menu__level" tabindex="-1" role="menu" aria-label="More Tools">
                                <?php
                                        if(in_array('15',$permission) || in_array('9',$permission) || in_array('4',$permission)  || in_array('6',$permission) ){ ?>
					<li class="menu__item" role="menuitem"><a class="menu__link" href="#">More Action</a></li>
					<?php } ?>
					<li class="menu__item" role="menuitem"><a class="menu__link" href="#">More Report</a></li>
				</ul>
				<!-- Submenu 6 -->
				<?php
                                        if(in_array('15',$permission) || in_array('9',$permission) ){ ?>
				<ul data-menu="submenu-6" id="submenu-6" class="menu__level" tabindex="-1" role="menu" aria-label="Report">
					<li class="menu__item" role="menuitem"><a class="menu__link" href="#">Project Report</a></li>
				</ul>
					<?php } ?>

			</div>
		</nav>
		<div class="content" style="background:white;">
			<p class="info">Welcome to Digiadmin</p>
			<!-- Ajax loaded content here -->
		</div>
	</div>
	<!-- /view -->
	<script src="<?php echo base_url(); ?>public/menu/js/classie.js"></script>
	<script src="<?php echo base_url(); ?>public/menu/js/dummydata.js"></script>
	<script src="<?php echo base_url(); ?>public/menu/js/main.js"></script>
	<script>
	(function() {
		var menuEl = document.getElementById('ml-menu'),
			mlmenu = new MLMenu(menuEl, {
				// breadcrumbsCtrl : true, // show breadcrumbs
				// initialBreadcrumb : 'all', // initial breadcrumb text
				backCtrl : false, // show back button
				// itemsDelayInterval : 60, // delay between each menu item sliding animation
				onItemClick: loadDummyData // callback: item that doesn????t have a submenu gets clicked - onItemClick([event], [inner HTML of the clicked item])
			});

		// mobile menu toggle
		var openMenuCtrl = document.querySelector('.action--open'),
			closeMenuCtrl = document.querySelector('.action--close');

		openMenuCtrl.addEventListener('click', openMenu);
		closeMenuCtrl.addEventListener('click', closeMenu);

		function openMenu() {
			classie.add(menuEl, 'menu--open');
			closeMenuCtrl.focus();
		}

		function closeMenu() {
			classie.remove(menuEl, 'menu--open');
			openMenuCtrl.focus();
		}

		// simulate grid content loading
		var gridWrapper = document.querySelector('.content');

		function loadDummyData(ev, itemName) {
			ev.preventDefault();

			closeMenu();
			gridWrapper.innerHTML = '';
			classie.add(gridWrapper, 'content--loading');
			setTimeout(function() {
				classie.remove(gridWrapper, 'content--loading');
				gridWrapper.innerHTML = '<ul class="products">' + dummyData[itemName] + '<ul>';
			}, 700);
		}
	})();
	</script>
</body>

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
</script>
<script>
function getpqset()
{
    var queryString ='';
   var pid = document.getElementById('pn').value;
   
   queryString = 'pn='+pid;
 
  jQuery.ajax({
	 url:'<?php echo base_url("siteadmin/getpqset/pn"); ?>',
     
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


</html>
