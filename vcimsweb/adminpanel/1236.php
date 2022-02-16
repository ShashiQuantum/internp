<?php
include_once('../init.php');
include_once('../functions.php');

?>
<!DOCTYPE html>
<html>
<br><br><center>
	<h3>Translated Questionnare View</h3><br<br>	
               	<form action="1248.php" method="post" enctype="multipart/form-data" target="_blank">
               	<table cellpadding="2" cellspacing="1" border="0" style="font-size:12px;">
                <tr><td>Project Name *</td> <td> <select name="pn" id="pn" onclick="displib2();"><option value="0">--Select--</option><?php $pj=get_projects_details();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr>
                <tr><td>QuestionSet ID *</td><td><select name="qset" id="qset" ><option value="select">--Select--</option> </select> </td></tr>
		<tr><td>Translated Language:</td><td> <select name=tl id=tl><option value=0> English </option> <option value=1> Hindi </option> <option value=2> Kannad </option> <option value=3> Malyalam </option><option value=4>Tammil</option><option value=5>Telgu</option><option value=6>Bangla</option><option value=7>Odia</option><option value=8>Gujrati</option><option value=9>Marathi</option><option value=10>Asami</option> </select> </td></tr>
               	<tr><td></td><td><input type=submit name=routine_view value="View Questionnaire"></td></tr>
                </table>
               	</form>
               	

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

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
