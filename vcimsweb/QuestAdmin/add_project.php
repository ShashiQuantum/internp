<?php
include_once('../init.php');
include_once('../functions.php');
?>

<html>
<head><title>Add Project</title></head>
<body>
<center>
<br><br><h2>Add Project</h2><br><br>

<?php
if(isset($_POST['cp_submit']))
{  //print_r($_POST);
    $pnn=$_POST['pname'];
    $b=$_POST['brand'];
    $ccn=$_POST['ccn'];
    $v=$_POST['visit'];
    $rt=$_POST['rt'];
    $bd=$_POST['bd'];
    $ss=$_POST['ss'];
    $ssdt=$_POST['ssdt'];
    $esdt=$_POST['esdt'];
    $pcat=$_POST['pcat'];
    $pname = strtoupper($pnn);
    $pid='';$pn=strtolower($pnn);

    if($pn!='' && $b!='' && $ccn!=''&& $v!='' && $rt!='select')
    {    
        $ssd=DB::getInstance()->query("select name from project where name='$pn'");
        if($ssd->count()>0)
        {    echo '<font color=red>Project Name you have entered is already exist. Pls enter unique project name</font>';}
        else 
        {  

            $pp=DB::getInstance()->query("INSERT INTO `project`(`name`, `company_name`, `brand`, `research_type`,tot_visit, `background`, `sample_size`, `survey_start_date`, `survey_end_date`, `category`) VALUES ('$pname','$ccn','$b','$rt',$v,'$bd',$ss,'$ssdt','$esdt','$pcat')"); 
            $pid=$pp->last();
            echo 'Project Id: <font color=red>'.$pp->last().'</font> has created successfully';

            $ppn=DB::getInstance()->query("SELECT `name` FROM `project` WHERE `project_id`=$pid");
            if($ppn->count()>0)
            {    $dtn=$ppn->first()->name; $dtn=strtolower($dtn);
                 $dtn.='_'.$pid;
                 //$ctb=DB::getInstance()->query("CREATE TABLE IF NOT EXISTS $dtn  (id int(5) primary key AUTO_INCREMENT,resp_id bigint(20) not null, q_id int(5) not null, r_name varchar(30) not null, mobile varchar(11) not null, centre_$pid varchar(2), i_date_$pid datetime, e_date_$pid datetime, latt varchar(30) null, lang varchar(30) null, sec_$pid varchar(1) not null, gender_$pid varchar(1) not null, week_day_$pid char(1) not null, age_$pid varchar(2) not null,st_$pid varchar(2) not null, age_yrs_$pid varchar(2) not null, store_$pid varchar(1) not null, product_$pid varchar(1) not null)ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci ");
		$ctb=DB::getInstance()->query("CREATE TABLE IF NOT EXISTS $dtn (id int(5) primary key AUTO_INCREMENT, resp_id bigint(20) not null, q_id int(5) not null, r_name varchar(30) not null, mobile varchar(11) not null, centre varchar(2), c_area varchar(4) not null, c_sub_area varchar(4) not null,  i_name varchar(30) not null, i_mobile varchar(11) not null, i_date_$pid datetime, e_date_$pid datetime, o_sec varchar(1) not null, n_sec varchar(1) not null, gender varchar(1) not null, week_day_$pid char(1) not null, age varchar(2) not null, st_$pid varchar(2) not null, age_yrs varchar(2) not null, store varchar(2) not null, product varchar(2) not null, ref_no varchar(15) not null, latt varchar(30) null, lang varchar(30) null)ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci");
                 $cindx=DB::getInstance()->query("ALTER TABLE $dtn ADD index rsp$pid (resp_id)");
                 $pnn=DB::getInstance()->query("UPDATE `project` SET  `data_table`='$dtn' ,`status`=1 WHERE `project_id`=$pid");
            }
              
        }
    }else
       echo 'pls fill all the project details';
}

?>


<table cellpadding="2" cellspacing="1" border="1" style="font-size:12px;">
     	<form action="" method="post">
                <tr><td>Project Name *</td><td> <input type="text" name="pname" id="pname" onkeypress="return IsAlphaNumber(event)" ondrop="return false;" onpaste="return false;"></td></tr> <span id="error" style="color: Red; display: none">* Special Characters not allowed 
                <tr><td>Brand * </td><td><input type="text" name="brand" id="brand"></td></tr>
                <tr><td>Client Company Name * </td><td><input type="text" name="ccn" id="ccn"></td></tr>
                <tr><td>Project Background * </td><td><input type="text" name="bd" id="bd"></td></tr>
                <tr><td>Survey Sample Size * </td><td><input type="number" name="ss" id="ss"></td></tr>
                <tr><td>Total Survey Round * </td><td><input type="number" name="visit" id="visit"></td></tr> 
                <tr><td>Start Survey Date * </td><td><input type="date" name="ssdt" id="ssdt"></td></tr>
                <tr><td>End Survey Date * </td><td><input type="date" name="esdt" id="esdt"></td></tr>  
                <tr><td>Project Category * </td><td><select name="pcat" id="pcat"><option value="0">--Select--</option><option value=1>HFD Consumer</option><option value=2>Milk Product Consumer</option><option value=3>Wine Consumer</option><option value=4>KFC Product Consumer</option><option value=5>Electronic Product Consumer</option><option value=6>Ola</option><option value=7>Others</option></select></td></tr>
                <tr><td>Research/First Page Type * </td><td><select name=rt id=rt><option value=0>--Select--</option><option value=1>Name,Mobile,Address,Gender,Age Yrs,Age Range,SEC[Edu,Occ],Product,Store,Centre</option><option value=2>Name,Mobile,Address,Interviewer Name,Interviewer Mobile,SEC[Edu,Occ],Centre</option><option value=3>Name,Mobile,Address,Gender,Age Yrs,Age Range,SEC[Edu,Occ],Product,Store,Centre</option><option value=4>Name,Mobile,Address,Interviewer Name,SEC[Edu,Occ],Centre</option></select></td></tr>  
                <tr><td colspan="2"><center><input type="submit" name="cp_submit" onclick="return confirm('Are you sure?');" value="Create Project"></center></td></tr>                
        </form>
</table>


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
            var keyCode = e.keyCode == 0 ? e.charCode : e.keyCode;
            var ret = ((keyCode >= 48 && keyCode <= 57) || (keyCode >= 65 && keyCode <= 90) || (keyCode >= 97 && keyCode <= 122) || (specialKeys.indexOf(e.keyCode) != -1 && e.charCode != e.keyCode));
            document.getElementById("error").style.display = ret ? "none" : "inline";
            return ret;
        }
    </script>
