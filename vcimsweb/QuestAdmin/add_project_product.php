<?php
include_once('../init.php');
include_once('../functions.php');


if(isset($_REQUEST['st']))
{
	$st = $_REQUEST['st'];
}
else
{
	$st = 1;
}   
$msg='';$ptable='';

if($st==1)
{
    $msg='Create New Centre';    
} 
if($st==2)
{
    $msg="Add New Project's Product";    
} 
if($st==3)
{
    $msg="Add New Project's SEC";    
} 
if($st==4)
{
    $msg="Add Project's Age";    
} 
if($st==5)
{
    $msg="Add Project's Store";    
} 

if(isset($_POST['c1_submit']))
{ 
    $cn=$_POST['cname'];

    if($cn!='')
    { 
             $sql="INSERT INTO `centre`(`cname`) VALUES ('$cn')";  
             DB::getInstance()->query($sql);
    }
}
if(isset($_POST['c2_submit']))
{ 
    $p=$_POST['pname'];
    $val=$_POST['val'];
    $qset=$_POST['qset'];

    if($p!='' || $val!='' || $qset!=0)
    { 
             $sql="INSERT INTO `project_product_map`(`qset_id`, `product`, `valuee`) VALUES ($qset,'$p',$val);";  
             DB::getInstance()->query($sql);
    }
}
if(isset($_POST['c3_submit']))
{ 
    $s=$_POST['sec'];
    $val=$_POST['val'];
    $qset=$_POST['qset'];

    if($s!='' || $val!='' || $qset!=0)
    { 
             $sql="INSERT INTO `project_sec_map`(`qset`, `sec`, `valuee`) VALUES ($qset,'$s',$val);";  
             DB::getInstance()->query($sql);
    }
}
if(isset($_POST['c4_submit']))
{ 
    $a=$_POST['age'];
    $val=$_POST['val'];
    $qset=$_POST['qset'];

    if($a!='' || $val!='' || $qset!=0)
    { 
            $sql="INSERT INTO `project_age_map`(`qset`, `age`, `valuee`) VALUES ($qset,'$a',$val);";  
             DB::getInstance()->query($sql);
    }
}
if(isset($_POST['c5_submit']))
{ 
    $ss=$_POST['sname'];
    $val=$_POST['val'];
    $qset=$_POST['qset'];

    if($ss!='' || $val!='' || $qset!=0)
    { 
             $sql="INSERT INTO `project_store_loc_map`(`qset_id`, `store`, `valuee`) VALUES ($qset,'$ss',$val);";  
             DB::getInstance()->query($sql);
    }
}

?>
<html>
	<head>
		<title>Add</title>
	</head>
	
	<body>
        <center>
	<table cellpadding="10" cellspacing="5">
		<tr>
			<td><a href="?st=1">Create Centre</a></td>
			<td><a href="?st=2">Add Project's Product</a></td>
                        <td><a href="?st=3">Add Project's SEC</a></td>
                        <td><a href="?st=4">Add Project's Age</a></td>
			<td><a href="?st=5">Add Project's Store</a></td>
		</tr>
		<tr>
			<td colspan="10"><center><h2><?= $msg ?></h2></center></td>
		</tr>
	</table>
            
            <?php if($st==1) { ?>      
        
        <table cellpadding="2" cellspacing="1" border="1" style="font-size:12px;">
     	<form action="" method="post">
                <tr><td>Centre Name </td><td> <input type="text" name="cname" id="cname"></td></tr>
                <tr><td colspan="2"><center><input type="submit" name="c1_submit" onclick="return confirm('Are you sure?');" value="Create"></center></td></tr>                
                </form>
        </table>
<?php } if($st==2) { ?>
         <table cellpadding="2" cellspacing="1" border="1" style="font-size:12px;">
		<form action="" method="post">
                    <tr><td>Project Name</td> </td><td> <select name="pn" id="pn" onchange="displib2();"><option value="0">--Select--</option><?php $pj=get_projects_details();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr><tr><td>QuestionSet ID </td><td><select name="qset" id="qset" onchange="displib4();"><option value="select">--Select--</option> </select> </td></tr>
                    <tr><td> Product Name </td><td><input type=text name="pname"></td></tr>
                    <tr><td> Code </td><td><input type=text name="val"></td></tr>
                <tr><td colspan="2"><center><input type="submit" name="c2_submit" onclick="return confirm('Are you sure?');" value="Submit"></center></td></tr>                
                </form>
        </table>          
 <?php } if($st==3) { ?>
                     <table cellpadding="2" cellspacing="1" border="1" style="font-size:12px;">
		<form action="" method="post">
                    <tr><td>Project Name</td> </td><td> <select name="pn" id="pn" onchange="displib2();"><option value="0">--Select--</option><?php $pj=get_projects_details();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr><tr><td>QuestionSet ID </td><td><select name="qset" id="qset" onchange="displib4();"><option value="select">--Select--</option> </select> </td></tr>
                    <tr><td> SEC </td><td><input type=text name="sec"></td></tr>
                    <tr><td> Code </td><td><input type=text name="val"></td></tr>
                <tr><td colspan="2"><center><input type="submit" name="c3_submit" onclick="return confirm('Are you sure?');" value="Submit"></center></td></tr>                
                </form>
        </table>
<?php } if($st==4) { ?>
  <table cellpadding="2" cellspacing="1" border="1" style="font-size:12px;">
		<form action="" method="post">
                    <tr><td>Project Name</td> </td><td> <select name="pn" id="pn" onchange="displib2();"><option value="0">--Select--</option><?php $pj=get_projects_details();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr><tr><td>QuestionSet ID </td><td><select name="qset" id="qset" onchange="displib4();"><option value="select">--Select--</option> </select> </td></tr>
                    <tr><td>Resondent AGE range </td><td><input type=text name="age"></td></tr>
                    <tr><td> Code </td><td><input type=text name="val"></td></tr>
                <tr><td colspan="2"><center><input type="submit" name="c4_submit" onclick="return confirm('Are you sure?');" value="Submit"></center></td></tr>                
                </form>
        </table>
<?php } if($st==5) { ?>
<table cellpadding="2" cellspacing="1" border="1" style="font-size:12px;">
		<form action="" method="post">
                    <tr><td>Project Name</td> </td><td> <select name="pn" id="pn" onchange="displib2();"><option value="0">--Select--</option><?php $pj=get_projects_details();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr><tr><td>QuestionSet ID </td><td><select name="qset" id="qset" onchange="displib4();"><option value="select">--Select--</option> </select> </td></tr>
                    <tr><td> Store Name </td><td><input type=text name="sname"></td></tr>
                    <tr><td> Code </td><td><input type=text name="val"></td></tr>
                <tr><td colspan="2"><center><input type="submit" name="c5_submit" onclick="return confirm('Are you sure?');" value="Submit"></center></td></tr>                
                </form>
        </table>
<?php }  ?>


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
