<?php

include_once('../../init.php');
include_once('../../functions.php');

echo "<center><h2>Respondent Project Rollback</h2>";


if(isset($_POST['rollback']))
{
    
    if($_POST['pn']!=0)
    {
       $pid=$_POST['pn'];
       $ddd1=DB::getInstance()->query("SELECT distinct `qset_id` FROM `questionset` WHERE  `project_id`=$pid");

       if($ddd1->count()>0)
       {  $qset=$ddd1->first()->qset_id;}

       $qq="UPDATE  `appuser_project_map` SET `status`=1 WHERE `project_id`=$qset and `status`=0";

       DB::getInstance()->query($qq);
       echo "<br> Process done successfully";

    }
     else echo "Please select a project";
}

?>

<form method=post action="">
<table border=1><tr><td>Project Name *</td> </td><td> <select name=pn id=pn><option value=0>--Select--</option>
       <?php  $pj=get_projects_details();
             foreach($pj as $p){ 
        	echo "<option value='";
        	 echo $p->project_id; 
        	echo "'>";
        	 echo $p->name; 
        	echo "</option>";
        	  } ?>
        
    <tr><td> </td><td><input type=submit name=rollback value=Rollback></td></tr>
</form>
</center>

<script type="text/javascript">
document.getElementById('pn').value = "<?php echo $_POST['pn'];?>";
</script>