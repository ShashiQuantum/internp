<?php
include_once('../init.php');
include_once('../functions.php');
?>

<html>
<head><title>Add Project</title></head>
<body>
<center>
<br><br><h2>Add Project's Questionset</h2><br><br>

<?php
	//create a new questionset
	if(isset($_POST['qs_submit']))
	{
	    $pid=$_POST['pn'];
	    $v=$_POST['visit']; $dtn='';
	    if($pid!='select' && $v!='' || $v!=0 )
	    {      $dtn='';
	            $pp=DB::getInstance()->query("INSERT INTO `questionset`(`project_id`,visit_no) VALUES ($pid,$v)"); 
	           
	         echo 'QuestionSet Id: <font color=red>'.$pp->last().'</font> has created successfully';        
	    }else
	       echo 'pls fill all the details';
	}
?>

	<table cellpadding="2" cellspacing="1" border="1" style="font-size:12px;">
		<form action="" method="post"><tr><td>Project Name </td><td> <select name="pn" id="pn"><option value="select">--Select--</option><?php $pj=get_projects_details();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr>
                <tr><td>Survey Round</td><td><select name="visit" id="visit"><option value="1">1</option></select></td></tr>
                <tr><td colspan="2"><center><input type="submit" name="qs_submit" onclick="return confirm('Are you sure?');" value="Create QuestionSet"></center></td></tr>                
                </form>
        </table>