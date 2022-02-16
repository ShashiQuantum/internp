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

                            <form action="" method=post><input type=submit name=logout value=Logout><div style=float:right><img src='../../images/Digiadmin_logo.jpg' height=50 width=150> </div> <center><h3><font color=red >Project List Panel</font></h3></center>
    </div>
    
<?php
include_once ('../init.php');

	if(!Session::exists('suser'))
{
	Redirect::to('login_fp.php');
}

            $uid=$_GET['uid'];
            echo "<center> <h4>PROJECT LIST</h4>";
            
            echo "<center><table>";
        
            echo "<tr bgcolor=lightgray><td>Project ID</td><td>Project Name </td>  <td> Status </td> </tr>";
           
                $data=DB::getInstance()->query("SELECT `project_id`, `name`, `company_name`, `brand`, `background`, `sample_size`, `research_type`, `tot_visit`, `survey_start_date`, `survey_end_date`, `status` FROM `project` WHERE  project_id in (SELECT `project_id` FROM `project_user_map` WHERE `uid`=(SELECT `uid`  FROM `user_client_map` WHERE `uid`=$uid AND `status`=1))");
                if($data->count()>0)
                foreach($data->results() as $d)
                {    $str='';
                    $pid=$d->project_id;$pn=$d->name;$pst=$d->status;
                    
                    if($pst==0)$str='Ended'; else if($pst==1) $str='active';
                    echo "<tr><td>$pid</td><td><b>$pn</b> </td><td><i>$str</i></td></tr>";
                }
           
            echo "</table></center> ";
            
       
?>