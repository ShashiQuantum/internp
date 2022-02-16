<?php

include_once('../../init.php');
include_once('../../functions.php');



?>
<center>
<h2>Project Running Status</h2>
<br><br>

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
        
    <tr><td> </td><td><input type=submit name=view value=View></td></tr>
</form></table>
</center>


<?php

if(isset($_POST['view']))
{
    
    if($_POST['pn']!=0)
    {
       	$pid=$_POST['pn']; $tot=0;$tlp=0;$tlc=0;$tld=0;
       	
       	$ddd1=DB::getInstance()->query(" SELECT distinct `qset_id` FROM `questionset` WHERE  `project_id`=$pid");
	if($ddd1->count()>0) {$qset=$ddd1->first()->qset_id;}
	
		 $qq0="SELECT count(*) as cnt FROM `appuser_project_map` WHERE `project_id`= $qset";
	         $dr0=DB::getInstance()->query($qq0);
	         if($dr0->count()>0) {$tot=$dr0->first()->cnt;}
	         
	         $qq1="SELECT count(*) as cnt FROM `appuser_project_map` WHERE `project_id`= $qset and `status`=0";
	         $dr1=DB::getInstance()->query($qq1);
	         if($dr1->count()>0) {$tlp=$dr1->first()->cnt;}
	         
	         $qq2="SELECT count(*) as cnt FROM `appuser_project_map` WHERE `project_id`= $qset and `status`=1";
	         $dr2=DB::getInstance()->query($qq2);
	         if($dr2->count()>0) {$tlc=$dr2->first()->cnt;}
	
	         $qq3="SELECT count(*) as cnt FROM `appuser_project_map` WHERE `project_id`= $qset and `status`=2";
	         $dr3=DB::getInstance()->query($qq3);
		 if($dr3->count()>0) {$tld=$dr3->first()->cnt;}
		 
		if($tot>0)
		{
	       		echo "<br><br><br><center> <table border=1><tr bgcolor=lightgray><td>Total Link Send</td><td>Total Link Exported</td><td>Total Link Pending</td><td>Total Link Cancelled</td></tr>";
	       		echo "<tr><td>$tot</td><td>$tld</td><td>$tlp</td><td>$tlc</td></tr></table>";
		}
		else echo "<center><font color=red>No record found</font>";
      }
      else echo "Please select a project";
}

?>

<script type="text/javascript">
document.getElementById('pn').value = "<?php echo $_POST['pn'];?>";
</script>