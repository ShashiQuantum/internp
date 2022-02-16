<?php
include_once ('../../init.php');

	if(!Session::exists('suser'))
{
	Redirect::to('login_fp.php');
}

            $ppid=$_GET['uid'];
            echo "<center> <h4>APP USER RESPONDENT DETAILS</h4>";
            
            echo "<center><table>";
        
            echo "<tr bgcolor=lightgray><td>User ID</td><td>Name </td>  <td> Mobile </td>  <td> Email </td><td>Address</td><td> City </td><td>Age</td><td> SEC </td><td> Gender </td><td>Source</td><td>Income</td><td>HFD User</td><td>Registration Date</td><td>Last Update</td><td>Working Status</td></tr>";
               $qq="SELECT  `resp_id`, `user_id`, `pid`, `name`, `mobile`, `email`, `address`, `city`, `nresp_age_yrs`, `nresp_dob`, `nresp_sec_educ`, `nresp_sec_occup`, `nresp_educ`, `nresp_sec`, `nresp_gender`, `nresp_source`, `nresp_hfd_consume`, `resp_milk_consume`,  `nresp_m_status`, `nresp_tot_kids`, `nresp_kid1_age`, `nresp_kid2_age`, `nresp_family_size`, `nresp_income`, `nresp_reg_dt`, `nresp_last_update`, `nresp_hfd`, `nresp_hfd_frequency`, `nresp_fourwheeler`, `nresp_twowheeler`,  `nresp_working_st`, `nresp_hh_mob_user_cnt`, `plang` FROM `respondent_detail` WHERE `user_id` = $ppid order by id";
                $d=DB::getInstance()->query($qq);
                if($d->count()>0)
                {    $str='';
                    $uid=$d->first()->user_id;$rn=$d->first()->name;$mb=$d->first()->mobile;$em=$d->first()->email;$add=$d->first()->address;$city=$d->first()->city;
                    $age=$d->first()->nresp_age_yrs;$sec=$d->first()->nresp_sec;$gen=$d->first()->nresp_gender;$ss=$d->first()->nresp_source;$incom=$d->first()->nresp_income;$rgdt=$d->first()->nresp_reg_dt;
                    $lastupdt=$d->first()->nresp_last_update;$hfd=$d->first()->nresp_hfd;$wst=$d->first()->nresp_working_st;
    
                    echo "<tr><td><a href='?uid=$uid'>$uid</a></td><td>$rn</td><td>$mb</td><td>$em</td><td>$add</td><td>$city</td><td>$age</td><td>$sec</td><td>$gen</td><td>$ss</td><td>$incom</td><td>$hfd</td><td>$rgdt</td><td>$lastupdt</td><td>$wst</td></tr>";
                }
           
            echo "</table></center> ";

               
        echo "<center> <h4>PROJECT ATTENDED LIST</h4>";
        echo "<table>";
        $sql1="SELECT distinct `project_id`,status,exp_date FROM `appuser_project_map` WHERE `appuser_id` = $ppid";
        $data1=DB::getInstance()->query($sql1);
            if($data1->count()>0)
            {    echo "<tr bgcolor=lightgray><td>Project Id</td><td>Name</td><td>Status</td><td>Survey Date</td></tr>";
                foreach($data1->results() as $d1)
                {
                     $dc1=DB::getInstance()->query("SELECT `name` FROM `project` WHERE `project_id`= $d1->project_id");
                     $cn=$dc1->first()->name;
                     echo "<tr><td>$d1->project_id</td><td>$cn</td><td>$d1->status</td><td>$d1->exp_date</td></tr>";
                }
            }
            else
                echo '<font color=red>No record found</font>';
        echo "</center>";

        

?>
