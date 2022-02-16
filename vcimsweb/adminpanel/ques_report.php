<?php

include_once('../init.php');
include_once('../functions.php');

if(isset($_POST['show']))
{
    $sql1='';$sql2='';$qid=1;
    $pid=$_POST['project'];
    $msr=$_POST['msr']; ?>
            <h2><font color="green">Result Data</font></h2>
            <table width="40%" border="1" cellpadding="0" cellspacing="0" bordercolor="green">
<?php
    if(isset($_POST['resp']))
    {   $rt=$_POST['resp']; 
        if($msr=='1'){
            $sql1="select c.name as Centre, count(p.s_resp_type) as Respondent from centre c join ques_respondent p where c.centre_id in (select centre_id from quest_centre_detail where q_id in (select q_id from project where project_id=$pid and q_id=$qid)) and p.s_resp_type='$rt'";
            
            $dd=DB::getInstance()->query($sql1);
            if($dd->count()){
            ?>
                <tr bgcolor="gray"> <th>Centre</th><th>Total Respondent</th></tr>
             <?php   

            foreach($dd->results() as $d)
            {
                ?> <tr><td><?php echo $d->Centre; ?></td><td> <?php echo $d->Respondent; ?></td></tr> <?php
            } 
            }else echo "<font color='red'><br>Data Not Available</font>";
            ?>
        <?php }
        if($msr=='2'){
            $sql2="select c.name as Centre, (count(p.s_resp_type)/(select count(*) from ques_respondent)*100 )as 'RespTypeP' from centre c join ques_respondent p where c.centre_id in (select centre_id from quest_centre_detail where q_id in (select q_id from project where project_id=$pid and q_id=$qid)) and p.s_resp_type='$rt'";
            
            $dd=DB::getInstance()->query($sql2);
            if($dd->count()){
            ?>
                <tr bgcolor="gray"> <th>Centre</th><th>Respondent Type %</th></tr>
             <?php   

            foreach($dd->results() as $d)
            {
                ?> <tr><td><?php echo $d->Centre; ?></td><td> <?php echo $d->RespTypeP; ?></td></tr> <?php
            } 
            }else echo "<font color='red'><br>Data Not Available</font>";
            ?>
        <?php    }
        
    }
    if(isset ($_POST['rage']))
    {   $age=$_POST['rage'];
        if($msr=='1'){
            $sql1="select c.name as Centre, count(p.s_resp_age) as 'AgeT' from centre c join ques_respondent p where c.centre_id in (select centre_id from quest_centre_detail where q_id in (select q_id from project where project_id=$pid and q_id=$pid)) and p.s_resp_age='$age'";
            
            $dd=DB::getInstance()->query($sql1);
            if($dd->count()){
            ?>
                <tr bgcolor="gray"> <th>Centre</th><th>Total Age</th></tr>
             <?php   

            foreach($dd->results() as $d)
            {
                ?> <tr><td><?php echo $d->Centre; ?></td><td> <?php echo $d->AgeT; ?></td></tr> <?php
            } 
            }else echo "<font color='red'><br>Data Not Available</font>";
            ?>
        <?php }
        if($msr=='2'){
            $sql2="select c.name as Centre, (count(p.s_resp_age)/(select count(*) from ques_respondent )*100 )as 'AgeP' from centre c join ques_respondent p where c.centre_id in (select centre_id from quest_centre_detail where q_id in (select q_id from project where project_id=$pid and q_id=$qid)) and p.s_resp_age='$age' ";
            
            $dd=DB::getInstance()->query($sql2);
            if($dd->count()){
            ?>
                <tr bgcolor="gray"> <th>Centre</th><th>Age %</th></tr>
             <?php   

            foreach($dd->results() as $d)
            {
                ?> <tr><td><?php echo $d->Centre; ?></td><td> <?php echo $d->AgeP; ?></td></tr> <?php
            } 
            }else echo "<font color='red'><br>Data Not Available</font>";
            ?>
            <?php    }
        
    }
    if(isset ($_POST['gen']))
    {   $gen=$_POST['gen'];
        if($msr=='1'){
            $sql1="select c.name as Centre, count(p.s_resp_gen) as 'GenT' from centre c join ques_respondent p where c.centre_id in (select centre_id from quest_centre_detail where q_id in (select q_id from project where project_id=$pid and q_id=$qid)) and p.s_resp_gen='$gen'";
            
            $dd=DB::getInstance()->query($sql1);
            if($dd->count()){
            ?>
                <tr bgcolor="gray"> <th>Centre</th><th>Total Gender</th></tr>
             <?php   

            foreach($dd->results() as $d)
            {
                ?> <tr><td><?php echo $d->Centre; ?></td><td> <?php echo $d->GenT; ?></td></tr> <?php
            } 
            }else echo "<font color='red'><br>Data Not Available</font>";
            ?>
        <?php }
        
        if($msr=='2'){
            $sql2="select c.name as Centre, (count(p.s_resp_gen)/(select count(*) from ques_respondent )*100 )as 'GenP' from centre c join ques_respondent p where c.centre_id in (select centre_id from quest_centre_detail where q_id in (select q_id from project where project_id=$pid and q_id=$qid)) and p.s_resp_gen='$gen'";
            
            $dd=DB::getInstance()->query($sql2);
            if($dd->count()){
            ?>
                <tr bgcolor="gray"> <th>Centre</th><th>Gender %</th></tr>
             <?php   

            foreach($dd->results() as $d)
            {
                ?> <tr><td><?php echo $d->Centre; ?></td><td> <?php echo $d->GenP; ?></td></tr> <?php
            } 
            }else echo "<font color='red'><br>Data Not Available</font>";
            ?>
            <?php    }
        
        
        }
    if(isset($_POST['cons']))
    {   $cons=$_POST['cons'];
        if($msr=='1'){
        $sql1="select c.name as Centre, count(p.prod_post_pack_status) as ConsT from centre c join ques_prod_post_consume  p where c.centre_id in (select 
centre_id from quest_centre_detail where q_id in (select q_id from project where project_id=1 and q_id=1)) and 
p.prod_post_pack_status='1'";
            
            $dd=DB::getInstance()->query($sql1);
            if($dd->count()){
            ?>
                <tr bgcolor="gray"> <th>Centre</th><th>Total Consumption</th></tr>
             <?php   

            foreach($dd->results() as $d)
            {
                ?> <tr><td><?php echo $d->Centre; ?></td><td> <?php echo $d->ConsT; ?></td></tr> <?php
            } 
            }else echo "<font color='red'><br>Data Not Available</font>";
            ?>
        <?php }
        if($msr=='2'){
        $sql2="select c.name as Centre, (count(p.prod_post_pack_status)/(select count(*) from ques_prod_post_consume)*100 )as 'ConsP' from centre c join ques_prod_post_consume  p where c.centre_id in (select 
centre_id from quest_centre_detail where q_id in (select q_id from project where project_id=1 and q_id=1)) and 
p.prod_post_pack_status='1'";
            
            $dd=DB::getInstance()->query($sql2);
            if($dd->count()){
            ?>
                <tr bgcolor="gray"> <th>Centre</th><th>Consumption %</th></tr>
             <?php   

            foreach($dd->results() as $d)
            {
                ?> <tr><td><?php echo $d->Centre; ?></td><td> <?php echo $d->ConsP; ?></td></tr> <?php
            } 
            }else echo "<font color='red'><br>Data Not Available</font>";
            ?>
            <?php    }
        
    }
    ?>
            </table> <font color="red">
            <?php    
}


?>
<html>
    <title>
        
    </title>    
    <body>
        <h2>Filter Report</h2>
        
    <table width="40%" border="1" cellpadding="0" cellspacing="0">

        <form method="post" action="">
            <tr bgcolor="gray"><td>Filter Title</td><td>Select Option</td></tr>
            <tr><td>Project</td><td> <select name="project"><?php $ptt=get_projects_details();if($ptt) foreach($ptt as $p){?><option value="<?php echo $p->project_id; ?>"> <?php echo $p->name;  ?></option> <?php } ?></select></td></tr>
            <tr><td>Respondent Type</td><td><input type="radio" name="resp" value="mom"> Mom<br> <input type="radio" name="resp" value="child"> Child</td></tr>
            <tr><td>Respondent Age</td><td><input type="radio" name="rage" value="1"> Below 25 yrs<br> <input type="radio" name="rage" value="2"> 25-30 yrs <br><input type="radio" name="rage" value="3"> 31-35 yrs<br> <input type="radio" name="rage" value="4"> 36-40 yrs <br><input type="radio" name="rage" value="5"> 41-45 yrs<br> <input type="radio" name="rage" value="6"> Above 45 yrs </td></tr>
            <tr><td>Gender</td><td> <input type="radio" name="gen" value="1"> Male <br><input type="radio" name="gen" value="2"> Female <br><input type="radio" name="gen" value="3"> All</td></tr>
            <tr><td>Consumption</td><td><input type="radio" name="cons" value="1">Not Consumed<br> <input type="radio" name="cons" value="2"> Consumed Less Than Half<br><input type="radio" name="cons" value="3"> Consumed Half<br><input type="radio" name="cons" value="4"> Consumed More Than Half<br><input type="radio" name="cons" value="5"> Consumed Completely<br><input type="radio" name="cons" value="6">Refuse to show the pack</td></tr>
            <tr><td>Measures</td><td> <select name="msr"><option value="1">Centre Wise Row Total</option><option value="2">Centre Wise Row % </option><option value="3">Centre Wise Coll Total </option> <option value="4">Centre Wise Coll % </option></select></td></tr>

            <tr><td></td><td><input type="submit" name="show" value="Show"></td></tr>
            
        </form>
        </table>
    </body>
</html
