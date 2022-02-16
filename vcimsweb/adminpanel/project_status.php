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

                            <form action="" method=post><input type=submit name=logout value=Logout><div style=float:right><img src='../../images/Digiadmin_logo.jpg' height=50 width=150> </div> <center><h3><font color=red >Project Status Panel</font></h3></center>
    </div>
    
<?php
include_once ('../init.php');

	if(!Session::exists('suser'))
{
	Redirect::to('login_fp.php');
}

            $ppid=$_GET['pid'];
            echo "<center> <h4>PROJECT DETAILS</h4>";
            
            echo "<center><table>";
        
            echo "<tr bgcolor=lightgray><td>Project ID</td><td>Project </td>  <td> Client Name </td>  <td> Brand </td><td>Total Visit</td><td> Study Type </td><td>Sample Size</td><td> Survey Start Date </td><td> Survey End Date </td><td>Status</td></tr>";
            
                $data=DB::getInstance()->query("SELECT `project_id`, `name`, `company_name`,sample_size, `brand`, `tot_visit`, `research_type`, `survey_start_date`, `survey_end_date`, `status` FROM `project` where project_id=$ppid order by `project_id`desc");
                if($data->count()>0)
                foreach($data->results() as $d)
                {    $str='';
                    $pid=$d->project_id;$pn=$d->name;$cn=$d->company_name;$b=$d->brand;$v=$d->tot_visit;$rt=$d->research_type;
                    $sd=$d->survey_start_date;
                    $ed=$d->survey_end_date;
                    $st=$d->status;
                    $ss=$d->sample_size;
                    if($st==0)$str='close'; else if($st==1)$str='active';
                    echo "<tr><td><a href='?pid=$pid'>$pid</a></td><td>$pn</td><td>$cn</td><td>$b</td><td>$v</td><td>$rt</td><td>$ss</td><td>$sd</td><td>$ed</td><td>$str</td></tr>";
                }
           
            echo "</table></center> ";
            
        echo "<center> <h4>FIELD WORK DETAILS</h4>";
        echo "<table>";
        $sql1="SELECT distinct `centre_id`, `project_id`, `q_id` FROM `centre_project_details` WHERE `project_id`=$ppid";
        $data1=DB::getInstance()->query($sql1);
            if($data1->count()>0)
            {    echo "<tr bgcolor=lightgray><td>Centre Id</td><td>Centre Name</td><td>QuestionSet Id</td><td>#Link Sent</td><td>#Not Survey Started</td><td>#Survey Started</td> <td>#Survey Completed</td><td>#Survey Not Completed</td></</tr>";
                foreach($data1->results() as $d1)
                {
                     $dc1=DB::getInstance()->query("SELECT `cname` FROM `centre` WHERE `centre_id`= $d1->centre_id");
                     $cn=$dc1->first()->cname;$cid=$d1->centre_id;$qset_id=$d1->q_id;
                     $dc21=DB::getInstance()->query("SELECT count(url) as cnt FROM `respondent_link_map` WHERE `status`=0 AND centre_id=$cid and p_id=$ppid");
                     if($dc21->count()>0)
                         $nstd=$dc21->first()->cnt;
                     $dc2=DB::getInstance()->query("SELECT count(url) as cnt FROM `respondent_link_map` WHERE `status`=1 AND centre_id=$cid and p_id=$ppid");
                     if($dc2->count()>0)
                         $std=$dc2->first()->cnt;
                     $dc3=DB::getInstance()->query("SELECT count(url) as cnt FROM `respondent_link_map` WHERE `status`=2 AND centre_id=$cid and p_id=$ppid");
                     if($dc3->count()>0)
                         $ctd=$dc3->first()->cnt;  
                     $dc4=DB::getInstance()->query("SELECT count(url) as cnt FROM `respondent_link_map` WHERE  centre_id=$cid and p_id=$ppid");
                     if($dc4->count()>0)
                         $ls=$dc4->first()->cnt;  
                     $nc=$ls-$ctd;
                     
                     echo "<tr><td>$cid</td><td>$cn</td><td>$qset_id</td><td>$ls</td><td>$nstd</td><td>$std</td><td>$ctd</td><td>$nc</td> </tr>";
                }
            }
            else
                echo '<font color=red>No record found</font>';
        echo "</table></center>";  
               
        echo "<center> <h4>CENTER DETAILS</h4>";
        echo "<table>";
        $sql1="SELECT distinct `centre_id`, `project_id`, `q_id` FROM `centre_project_details` WHERE `project_id`=$ppid";
        $data1=DB::getInstance()->query($sql1);
            if($data1->count()>0)
            {    echo "<tr bgcolor=lightgray><td>Cenntre Id</td><td>Centre Name</td><td>QuestionSet Id</td></tr>";
                foreach($data1->results() as $d1)
                {
                     $dc1=DB::getInstance()->query("SELECT `cname` FROM `centre` WHERE `centre_id`= $d1->centre_id");
                     $cn=$dc1->first()->cname;
                     echo "<tr><td>$d1->centre_id</td><td>$cn</td><td>$d1->q_id</td>";
                }
            }
            else
                echo '<font color=red>No record found</font>';
        echo "</center>";

?>
