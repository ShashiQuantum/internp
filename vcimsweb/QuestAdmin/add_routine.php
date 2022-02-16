<?php
include_once('../init.php');
include_once('../functions.php');      



?>
<!DOCTYPE html>
<html>
	<head>
		<title>Question Routine</title>
	</head>
	<body>
        <center>
	<table cellpadding="10" cellspacing="5">
		 
		<tr>
			<td colspan="10"><center><h2>Add Question Routine</h2></center></td>
		</tr>
	</table>

         
                
             <center><form action="" method="post"> <table>
             <tr><td>Project Name</td> </td><td> <select name="pn" id="pn" onclick="displib2();"><option value="0">--Select--</option><?php $pj=get_projects_details();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr>
             <tr><td>QuestionSet ID </td><td><select name="qset" id="qset" onclick="display();display2();"><option value="0">--Select--</option> </select> </td></tr>
             <tr><td>Question ID </td><td> <select name="qid" id="qid"> <option value="0">--Select--</option></select> </td></tr>
             <tr><td>Check for Question ID </td><td> <select name="pqid" id="pqid" onchange="display3();"> <option value="0">--Select--</option></select> </td></tr>
             <tr><td colspan=2><div id=dtt></div></td></tr>
             <tr><td></td><td><input type="submit" name="rsubmit" value="Update"></td></tr></table></form></center>  
 
<?php 


if(isset($_POST['rsubmit']))
{  
       // print_r($_POST);
       $qset=$_POST['qset'];$qid='';$pqid='';$nctr=0;$opval='';$i=0;
    
     foreach($_POST as $key=>$val)
     {
           if($key=='qid')
           {
              $qid=$val; continue;
           }
           if($key=='pqid')
           {
              $pqid=$val; continue;
           }
             

           if($key!='rsubmit')if($key!='qset')if($key!='pn')
 	   {
                 
		$f=0; $i++;
               if(($i%3==0) && ($val==1 ||$val ==2 )) { 
                 
                   //if($opval!=1)
                   //{
                      $qu="UPDATE `question_routine_check` SET `flow`=$val WHERE opval=$opval and qset_id=$qset and qid=$qid and pqid=$pqid";
                      DB::getInstance()->query($qu); 
                   //}

                $nctr=0;
              }


             $ff="chk$val";  

             if($key==$ff){  $opval=$val;  $nctr=1;
                   $qi="INSERT INTO `question_routine_check`(`qset_id`, `qid`, `pqid`, `opval`, `flow`) VALUES ($qset,$qid,$pqid,$val,$f)";
                     
                   DB::getInstance()->query($qi); 
              }
            
              
           }
     }
     echo "<br>Question Id $qid Routine added successfully";
}

?>


</body>
<link rel="stylesheet" href="../../css/siteadmin.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

<script>
function display()
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
	var val=document.getElementById('qset').value;
         //document.write('Hello: '+val);
	pin.onreadystatechange=function()
	{
		if(pin.readyState==4)
		{
			document.getElementById('qid').innerHTML=pin.responseText;
			console.log(pin);
		}
	}
	url="qset_qlist.php?qset="+val;
	pin.open("GET",url,true);
	pin.send();
}

</script>
<script>
function display2()
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
	var val=document.getElementById('qset').value;
         //document.write('Hello: '+val);
	pin.onreadystatechange=function()
	{
		if(pin.readyState==4)
		{
			document.getElementById('pqid').innerHTML=pin.responseText;
			console.log(pin);
		}
	}
	url="qset_q.php?qset="+val;
	pin.open("GET",url,true);
	pin.send();
}

</script>

<script>
function display3()
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
	var val=document.getElementById('pqid').value;
          
	pin.onreadystatechange=function()
	{
		if(pin.readyState==4)
		{
			document.getElementById('dtt').innerHTML=pin.responseText;
			console.log(pin);
		}
	}
	url="qset_qop.php?qid="+val;
	pin.open("GET",url,true);
	pin.send();
}

</script>

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

</script>

<script type="text/javascript">
document.getElementById('pn').value = "<?php echo $_POST['pn'];?>";
</script>
