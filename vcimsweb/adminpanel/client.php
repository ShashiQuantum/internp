<?php
include_once('../init.php');
include_once __DIR__ .'/../classes/DB.php';
include_once __DIR__ .'/../classes/Config.php';
include_once __DIR__ .'/../classes/Input.php';
include_once __DIR__ .'/../classes/Hash.php';
include_once __DIR__ .'/../classes/Session.php';

if(!Session::exists('suser'))
{
	Redirect::to('login_fp.php');
}
?>


            

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>VCIMS Admin Panel</title>
     <link rel="stylesheet" href="../../css/siteadmin.css">
    </head>
    <body id=pg>
    <div id=header>
    <?php
    	//include_once('../init.php');
        if(isset($_POST['logout']))
         {
            session_destroy();
		//Cookie::delete($this->_cookieName);
		
		Redirect::to('login_fp.php');
            
         }
         echo "Hi <font color='lightgreen'>".Session::get('suser')."</font>"; 
        ?>

                            <form action="" method=post><input type=submit name=logout value=Logout><div style=float:right><img src='../../images/Digiadmin_logo.jpg' height=50 width=150> </div> <center><h3><font color=red >Client User Admin Panel</font></h3></center>
    </div>
    <br><br>
    <center>
        
  
            <table border="0" cellpadding="0" cellspacing="0">
             
            <tr bgcolor=gray height=30><th >C.ID.</th><th width=30%> Client Name </th><th> User List </th><th>&nbsp;&nbsp; Manage User</th><th> &nbsp;&nbsp; Manage Permission</th> </tr>
            <?php
            $de=DB::getInstance()->query("SELECT * FROM  `client_info`");
            if($de->count()>0) 
            foreach($de->results() as $d)
            {
            
            echo "<tr height=30><td>$d->cid</td><td><b> $d->cname </b></td><td><a href='?cid=$d->cid'> view user list </a></td><td> <center> <a href='user_management.php'>manage user</a></td><td><a href='permission_management.php?cid=$d->cid'>manage permission</a></center> </td> </tr>";
          
             } ?>
            
            </table></center>
            </body>
</html>

<?php
//echo 'project details';
if(isset($_GET['cid']))
{    
        $ppid=$_GET['cid'];
        if($ppid!=0)
        {
            $data=DB::getInstance()->query("SELECT `user_id`, `user`, `status` FROM `admin_user` WHERE user_id in (SELECT `uid` FROM `user_client_map` WHERE cid=$ppid");
                if($data->count()>0)
            echo $data->first()->name;
                header('Location: '."cuser_list.php?cid=$ppid");
        }
        

}

?>