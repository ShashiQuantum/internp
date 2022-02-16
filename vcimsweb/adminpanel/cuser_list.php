<link rel="stylesheet" href="../../css/siteadmin.css">
<body id=pg>
    <div id=header>
    <?php
    	include_once('../init.php');
        if(isset($_POST['logout']))
         {
            session_destroy();
		//Cookie::delete($this->_cookieName);
		
		Redirect::to('login_fp.php');
            
         }
         echo "Hi <font color='lightgreen'>".Session::get('suser')."</font>"; 
        ?>

                            <form action="" method=post><input type=submit name=logout value=Logout><div style=float:right><img src='../../images/Digiadmin_logo.jpg' height=50 width=150> </div> <center><h3><font color=red >User List Panel</font></h3></center>
    </div>
    
<?php
include_once ('../init.php');

	if(!Session::exists('suser'))
{
	Redirect::to('login_fp.php');
}

            $ppid=$_GET['cid'];
            echo "<center> <h4>USER LIST</h4>";
            
            echo "<center><table>";
        
            echo "<tr bgcolor=lightgray><td>User ID</td><td>User Login </td>  <td> Status </td><td>Project List</td><td>Add Project</td><td>Remove Project</td> </tr>";
           
                $data=DB::getInstance()->query("SELECT `user_id`, `user`, `status` FROM `admin_user` WHERE user_id in (SELECT `uid` FROM `user_client_map` WHERE cid=$ppid)");
                if($data->count()>0)
                foreach($data->results() as $d)
                {    $str='';
                    $uid=$d->user_id;$un=$d->user;$ust=$d->status;
                    
                    if($ust==0)$str='not active'; else if($ust==1) $str='active';
                    echo "<tr><td>$uid</td><td><b>$un </b> </td><td><i><font size=1>$str </font></i></td><td><a href='?uid=$uid&a=1'>project list</a></td><td><a href='?uid=$uid&a=2'>Add</a></td><td><a href='?uid=$uid&a=3'>Remove</a></td></tr>";
                }
           
            echo "</table></center> ";
            
       
?>

<?php
//echo 'project details';
if(isset($_GET['uid']))
{     $a=$_GET['a'];
        $ppid=$_GET['uid'];
        if($a==1)
        {
            
                header('Location: '."cuser_project_list.php?uid=$ppid");
        }
        if($a==2)
        {
            
                header('Location: '."add_project_user.php?uid=$ppid");
        }
        if($a==3)
        {
            
                header('Location: '."remove_project_user.php?uid=$ppid");
        }
}

?>