<?php
include_once('../init.php');
include_once('../functions.php');      
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Edit Option</title>
	</head>
	


	<body>
        <center>
	<table cellpadding="10" cellspacing="5">
		 
		<tr>
			<td colspan="10"><center><h2>Edit Question Option</h2></center></td>
		</tr>
	</table>

         
                
             <center><form action="" method="post"> <table>
             <tr><td>Project Name</td> </td><td> <select name="pn" id="pn" onchange="displib2();"><option value="0">--Select--</option><?php $pj=get_projects_details();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr>
             <tr><td>QuestionSet ID </td><td><select name="qset" id="qset" onclick="display();display2();"><option value="0">--Select--</option> </select> </td></tr>
             <tr><td> Question ID </td><td> <select name="pqid" id="pqid"> <option value="0">--Select--</option></select> </td></tr>
             <tr><td colspan=2><div id=dtt></div></td></tr>
             <tr><td></td><td><input type="submit" name="rsubmit" value="Show Options"></td></tr></table></form></center>  
 <br><br>
<?php 


if(isset($_POST['rsubmit']))
{  
        //print_r($_POST);
       $qid=$_POST['pqid']; $pqid='';$nctr=0;$opval='';
       
       	$qry="Select * from question_detail where q_id=$qid";
	$dm=DB::getInstance()->query($qry);
	if($dm->count()>0)
	{
	  echo $qt=$dm->first()->q_type;
	   if($qt=='radio' || $qt=='checkbox')
	   {   
       		$qtd="SELECT  * FROM `question_option_detail` WHERE `q_id`=$qid";
	
		$dd=DB::getInstance()->query($qtd);
		if($dd->count() > 0)
		{   echo "<table border=2>";
		    echo "<tr bgcolor=lightgray><td>OP_ID</td><td>Name</td><td>CODE</td><td>TERM</td><td>ACTION</td></tr>";
		    $nctr=0;
		    foreach($dd->results() as $d)
		    {   $nctr++;
		        $qid=$d->q_id;
		        $opid=$d->op_id; 
		        $text=$d->opt_text_value; 
		        $v=$d->value;
		        $term=$d->term;
		        $ssv=$d->scale_start_value;
		        $esv=$d->scale_end_value;	             
		
		 	echo "<form action='' method=post><tr id=show$opid ><td>$opid</td><td>$text</td><td>$v</td><td>$term</td><td><a href=#edit$opid onclick=edit($opid)>edit</a> </td> </tr></form>";
						
			echo "<form action='' method=post><tr id=edit$opid style=display:none><td><input type=hidden name=opid value=$opid><input type=hidden name=qid value=$qid>$opid</td><td><input type=text name=text STYLE='color: red;width:500px;' value='$text'></td>  <td><input type=text id=val name=val STYLE='color: red; width:50px;'  value=$v></td><td><input type=text name=term STYLE='color: red;width:80px;' value='$term'></td><td><input type=submit name=save value=Save> <a href=#show$opid onclick=show($opid)>Cancel</a> </td> </tr></form>";    
		    }
		    
		   echo "</table>";
		   
		}
	    }else echo "--Options Not Available--";
	}
		
}
   

   //to save after edit data
   
   	if(isset($_POST['save']))
	{
		     //print_r($_POST);
		    $qid=$_POST['qid'];
		    $opid=$_POST['opid'];
		    $text=$_POST['text'];
		    $val=$_POST['val'];
		    $term=$_POST['term'];
		    
		    $sql="UPDATE `question_option_detail` SET  `opt_text_value`='$text' , term='$term',`value`=$val WHERE `op_id`=$opid";
		    
		    $d=DB::getInstance()->query($sql);
		    $qtd="SELECT  * FROM `question_option_detail` WHERE `q_id`=$qid";
	
		$dd=DB::getInstance()->query($qtd);
		if($dd->count() > 0)
		{   echo "<table border=2>";
		    echo "<tr bgcolor=lightgray><td>OP_ID</td><td>Name</td><td>CODE</td><td>TERM</td><td>ACTION</td></tr>";
		    $nctr=0;
		    foreach($dd->results() as $d)
		    {   $nctr++;
		        $qid=$d->q_id;
		        $opid=$d->op_id; 
		        $text=$d->opt_text_value; 
		        $v=$d->value;
		        $term=$d->term;
		        $ssv=$d->scale_start_value;
		        $esv=$d->scale_end_value;	             
		
		 	echo "<form action='' method=post><tr id=show$opid ><td>$opid</td><td>$text</td><td>$v</td><td>$term</td><td><a href=#edit$opid onclick=edit($opid)>edit</a> </td> </tr></form>";
						
			echo "<form action='' method=post><tr id=edit$opid style=display:none><td><input type=hidden name=opid value=$opid><input type=hidden name=qid value=$qid>$opid</td><td><input type=text name=text STYLE='color: red;width:500px;' value='$text'></td>  <td><input type=text id=val name=val STYLE='color: red; width:50px;'  value=$v></td><td><input type=text name=term STYLE='color: red;width:80px;' value='$term'></td><td><input type=submit name=save value=Save> <a href=#show$opid onclick=show($opid)>Cancel</a> </td> </tr></form>";    
		    }
		    
		   echo "</table>";
		 }  
		    
	}
?>


</body>
<link rel="stylesheet" href="../../css/siteadmin.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>


<script type="text/javascript">  
	    function edit(i)
	    {
	        var show= 'show'+i;
	        var edit= 'edit'+i;
	        document.getElementById(show).style.display = 'none';
	        document.getElementById(edit).style.display = 'table-row';
	    }
	    function show(i)
	    {
		    var show= 'show'+i;
		    var edit= 'edit'+i;
		    var move= 'move'+i;
		    document.getElementById(show).style.display = 'table-row';
		    document.getElementById(edit).style.display = 'none';
		    document.getElementById(move).style.display = 'none';
	    }
</script> 

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
	url="qset_questions.php?qset="+val;
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
	url="question_options.php?qid="+val;
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
    
