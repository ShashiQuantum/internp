<?php
include_once('../init.php');
include_once('../functions.php');
?>

<html>
<head><title>Delete Project Routine</title></head>
<body>
<center>
<br><br><h2>Delete Project Routine</h2><br><br>

<?php
    
	if(isset($_POST['delete_qr']))
	{
	    $pid=$_POST['pn'];
	    $qset=$_POST['qset'];
	     
	    if($pid!='0' && $qset!='0')
	    {   
	        $pp=DB::getInstance()->query("DELETE FROM `question_routine_check` WHERE `qset_id` = $qset");        
	        echo '<font color=red>Question Routine deleted sucessfully of qsetid: $qset </font>';        
	    }else
	       echo 'pls fill all the details';
	}
?>

	<table cellpadding="2" cellspacing="1" border="1" style="font-size:12px;">
		<form action="" method="post">
                    <tr><td>Project Name</td> </td><td> <select name="pn" id="pn" onchange="displib2();"><option value="0">--Select--</option><?php $pj=get_projects_details();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr>

<tr><td>QuestionSet ID </td><td><select name="qset" id="qset" onchange="displib4();"><option value="select">--Select--</option> </select> </td></tr>
                    <tr><td colspan="2"><center><input type="submit" name="delete_qr" onclick="return confirm('Are you sure?');" value="Delete Routine"></center></td></tr>                
                </form>
        </table>          
        

<script>
    function displib2()
{
        var pin;
	if(window.XMLHttpRequest)
	{
		pin=new XMLHttpRequest();
	}
	else
	{
		pin= new ActiveXobject("Microsoft.XMLHTTP");
	}
	var val=document.getElementById('pn').value;
        //document.write('Hello: '+val);
	pin.onreadystatechange=function()
	{
		if(pin.readyState==4)
		{
			document.getElementById('qset').innerHTML=pin.responseText;
			console.log(pin);
		}
	}
	url="get_qset.php?pid="+val;
	pin.open("GET",url,true);
	pin.send();
}
</script>
