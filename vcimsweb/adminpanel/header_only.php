<?php
include_once('../init.php');
include_once __DIR__ .'/../classes/DB.php';
include_once __DIR__ .'/../classes/Config.php';
include_once __DIR__ .'/../classes/Input.php';
include_once __DIR__ .'/../classes/Hash.php';
include_once __DIR__ .'/../classes/Session.php';

if(!Session::exists('suser'))
{
	//Redirect::to('login_fp.php');
       die('<font color=red>Please close this page and relogin again</font>');
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>VCIMS Admin Panel</title>
  <!--   <link rel="stylesheet" href="../../css/siteadmin.css">
-->
    </head>
    <body id=pg>
    <div id=header>
    <?php
    	//include_once('../init.php');
        if(isset($_POST['logout']))
         {
            session_destroy();
		//Cookie::delete($this->_cookieName);
	   die('<font color=red>You are logout. Please close this tab and try again</font>');
		Redirect::to('login_fp.php');
            
         }
         echo "Hi <font color='lightgreen'>".Session::get('suser')."</font>"; 
        ?>

                            

<a href="/logout.php" target="_top">Logout</a><div style=float:right><img src='https://digiadmin.quantumcs.com/public/img/logos/Digiadmin_logow.png' height=40 width=130> </div> <center><h3><font color=red >CrossTab Reporting Tool</font></h3></center>
    </div>
    <br>
    <center>


<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
