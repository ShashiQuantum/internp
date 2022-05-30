<?php
include_once('../../init.php');
include_once('../../functions.php');


if(isset($_POST['pDeploy'])){
   if($_POST['rewardPoint'] != ''){ $rewadp=$_POST['rewardPoint'];} else {$rewadp=0;}
   if($_POST['projectId'] != '') $projectId=$_POST['projectId'];
	
   
	
$pdata=	$_POST['userIds'];
	foreach($pdata as $userID) {
		//echo $userID;
		$assignPro="INSERT INTO `appuser_project_map`(`appuser_id`,`project_id`,`status`,`cr_point`) VALUES ($userID,$projectId,0,$rewadp)";
					$succ=	DB::getInstance()->query($assignPro);
		
	}
	if($succ->count()>0)
	{
		echo "<br><center><font color=green> PROJECT IS DEPLOYED SUCCESSFULLY</center></font><br>";
	}
}


?>
<head><title>Project Deployement </title></head>
<body>
<br><br>
<center>
<h3><font color=red><u>Project Deployement</u></font></h3>
<form name="tFORM" method=post action="respondent_list.php" >
 
<?php
echo "<br><table><tr><td> Project </td> </td><td> <select name=pn id=pn required ><option value=0>--Select Project--</option>";
          $pj=get_projects_details_serveygenics();
             foreach($pj as $p){ 
        	echo "<option value='";
        	 echo $p->project_id; 
        	echo "'>";
        	 echo $p->name; 
        	echo "</option>";
        	  } 
       	  
            echo "\r\n";       
?>

<input type=submit name="get_project" id ="get_project" value="View Respondent for project deployment">
</form>







