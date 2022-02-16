<?php
ob_start();
include_once ('../../vcims/init.php');
$ppid=0;

if(!Session::exists('suser'))
{
	Redirect::to('login_fp.php');
}

?>
<html>
	<head>
    <title>
        VCIMS Project Status
    </title> 
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

                            <form action="" method=post><input type=submit name=logout value=Logout><div style=float:right><img src='../../images/Digiadmin_logo.jpg' height=50 width=150> </div> <center><h3><font color=red >Project Info Panel</font></h3></center>
    </div>
        
        <center>
            <h2>Project Details</h2>
        <table>
            <tr bgcolor="lightgray"><td>Project ID</td><td>Project </td>  <td> Client Name </td>  <td> Brand </td><td>Total Visit</td><td> Study Type </td><td>Sample Size</td><td> Survey Start Date </td><td> Survey End Date </td><td>Status</td></tr>
            <?php 
                $data=DB::getInstance()->query("SELECT `project_id`, `name`, `company_name`,sample_size, `brand`, `tot_visit`, `research_type`, `survey_start_date`, `survey_end_date`, `status` FROM `project` order by `project_id`desc");
                if($data->count()>0)
                foreach($data->results() as $d)
                {    $str='';
                    $pid=$d->project_id;$pn=$d->name;$cn=$d->company_name;$b=$d->brand;$v=$d->tot_visit;$rt=$d->research_type;
                    $sd=$d->survey_start_date;
                    $ed=$d->survey_end_date;
                    $st=$d->status;
                    $ss=$d->sample_size;
                    if($st==0)$str='close'; 
                    else if($st=='1')$str='active';
                    echo "<tr><td><a href='?pid=$pid'>$pid</a></td><td><a href='?pid=$pid'>$pn</a></td><td>$cn</td><td>$b</td><td>$v</td><td>$rt</td><td>$ss</td><td>$sd</td><td>$ed</td><td>$str</td></tr>";
                }
           ?>
        </table>
        </center>    
    </body>
</html>

<?php
//echo 'project details';
if(isset($_GET['pid']))
{    
        $ppid=$_GET['pid'];
        if($ppid!=0)
        {
            $data=DB::getInstance()->query("SELECT `project_id`, `name`, `company_name`, `brand`, `tot_visit`, `research_type`, `survey_start_date`, `survey_end_date`, `status` FROM `project` where project_id=$ppid");
                if($data->count()>0)
            echo $data->first()->name;
                header('Location: '."project_status.php?pid=$ppid");;
        }
        

}

?>
