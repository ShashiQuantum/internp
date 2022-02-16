<?php
include_once('../init.php');
include_once('../functions.php');
?>

<html>
<head><title>Add Project Centre</title></head>
<body>
<center>
<br><br><h2>Add Project's Centre</h2><br><br>

<?php
    //centre project create
	if(isset($_POST['pc_submit']))
	{
	    $pid=$_POST['pn'];
	    $qset=$_POST['qset'];
	    $st=$_POST['centre'];
	    if($pid!='0' && $qset!='0' && $st!='' )
	    {   
	        $pp=DB::getInstance()->query("INSERT INTO `centre_project_details`(`centre_id`, `project_id`, `q_id`) VALUES($st,$pid,$qset)");        
	        echo '<font color=red>Centre for project has created successfully </font>';        
	    }else
	       echo 'pls fill all the details';
	}
?>

	<table cellpadding="2" cellspacing="1" border="1" style="font-size:12px;">
		<form action="" method="post">
                    <tr><td>Project Name</td> </td><td> <select name="pn" id="pn" onchange="displib2();"><option value="0">--Select--</option><?php $pj=get_projects_details();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr><tr><td>QuestionSet ID </td><td><select name="qset" id="qset" onchange="displib4();"><option value="select">--Select--</option> </select> </td></tr>
                    <tr><td> Centre </td><td><select name="centre"><?php $dc1=DB::getInstance()->query("SELECT * FROM `centre`"); foreach($dc1->results() as $cn){ $cid=$cn->centre_id; ?> <option value=<?php echo $cid;?> > <?php echo $cn->cname; ?> </option> <?php }?></select></td></tr>
                <tr><td colspan="2"><center><input type="submit" name="pc_submit" onclick="return confirm('Are you sure?');" value="Submit"></center></td></tr>                
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
