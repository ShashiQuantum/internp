<?php

include_once('../init.php');
include_once('../functions.php');


if(isset($_POST['submit']))
{
    //print_r($_POST);
    $p=$_POST['project'];
    $t=$_POST['tab'];
    $pr=$_POST['per'];
  
    if($p!=0 && $t!=0)
    {
        $qr="SELECT `id`, `project_id`, `tab_id`, `tab_name`, `status` FROM `tab_project_map` WHERE `project_id`=$p and `tab_id`=$t";
        $rd=DB::getInstance()->query($qr);
        if($rd->count()>0)
        {
                  $q1="UPDATE `tab_project_map` SET  `status`=$pr  WHERE `project_id`=$p and `tab_id`=$t ";
                  $rd=DB::getInstance()->query($q1);
        }
        else
        {
                  $q2="INSERT INTO `tab_project_map`( `project_id`, `tab_id`, `status`) VALUES ($p,$t,$pr)";
                  $rd=DB::getInstance()->query($q2);
        }
        echo "<font color=red> Saved successfully";
    }

}

?>


<body>
<center>
<table>

<h2>Tab-Project Map</h2>
<form action="" method=post>
<tr><td>Project </td><td><select name="project" id="pid"><option value="0">--Select--</option><?php $ptt=get_projects_details();if($ptt) foreach($ptt as $p){?><option value="<?php echo $p->project_id; ?>"> <?php echo $p->name;  ?></option> <?php } ?></select></tr>

<tr><td>Tablets </td><td><select name="tab" id="tab" ><option value="0">--Select--</option><?php  $pt=get_tabs(); if($pt) foreach($pt as $p){?><option value="<?php echo $p->tab_id; ?>"> <?php echo $p->tab_name;  ?></option> <?php } ?></select></tr>

<tr><td>Permission </td><td><select name=per><option value="0">--Select--</option><option value=1>Allow</option><option value=0>Not allow</option></select></td></tr>

<tr><td></td><td><input type=submit name=submit value=Save> </td></tr>
</form>

</table>
</center>
</body>



