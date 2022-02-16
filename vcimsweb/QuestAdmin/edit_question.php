<?php
include_once('../init.php');
include_once('../functions.php');

 if(isset($_POST['logout']))
         {
            session_destroy();
		//Cookie::delete($this->_cookieName);
		
		Redirect::to('login_fp.php');
            
         }
         echo "Hi <font color='lightgreen'>".Session::get('suser')."</font>";

?>
<!DOCTYPE html>
<html>
<head><title>Edit Question</title></head>
<body>
<center>
<br><br><h2>Edit Project's Questions</h2><br><br>
        <?php
        if(isset($_POST['edit_question']))
	{
	    //print_r($_POST);
	    	$pid=$_POST['pn'];
	    	$qset=$_POST['qset'];
	    	echo "<center><hr><table cellpadding=0 cellspacing=0 border=1 style=font-size:12px;><tr bgcolor=lightgray><td>q_id</td><td>qno</td><td>qset</td><td>q_title</td><td>q_type</td><td width='100px'>Action</td></tr>";
	    	
	    	$qry="Select * from question_detail where qset_id=$qset order by q_id";
	    	$dd=DB::getInstance()->query($qry);
		    if($dd->count()>0)
		    {
		        foreach($dd->results() as $d)
		        { 
				$qid=$d->q_id; $qtitle=$d->q_title; $qtype=$d->q_type; $qno=$d->qno;$qset=$d->qset_id;
				
				echo "<form action='' method=post><tr id=show$qid ><td>$qid</td><td>$qno</td><td>$qset</td><td>$qtitle</td><td>$qtype</td><td><a href=#edit$qid onclick=edit($qid)>edit</a> </td> </tr></form>";
				
				echo "<form action='' method=post><tr id=edit$qid style=display:none><td><input type=hidden name=qset value=$qset><input type=hidden name=qid value=$qid>$qid</td><td><input type=text name=qno STYLE='color: red;width:50px;' value=$qno></td>  <td><input type=text id=qset name=qset size=3 STYLE='color: red; width:50px;'  value=$qset></td><td><input type=text name=qtitle STYLE='color: red;width:1200px;' value='$qtitle'></td><td><input type=text name=qtype STYLE='color: red;width:50px;' value=$qtype></td><td><input type=submit name=save value=Save> <a href=#show$qid onclick=show($qid)>Cancel</a> </td> </tr></form>";
				
				
		        }
		    }
		    echo '</table>';
	}
	
	if(isset($_POST['save']))
	{
		     //print_r($_POST);
		    $qid=$_POST['qid'];
		    $qno=$_POST['qno'];
		    $qtitle=$_POST['qtitle'];
		    $qtype=$_POST['qtype'];
		    $qset=$_POST['qset'];
		    
		    $sql="UPDATE `question_detail` SET  `qno`='$qno' ,q_title='$qtitle',`qset_id`=$qset ,`q_type`='$qtype' WHERE `q_id`=$qid";
		    
		    $d=DB::getInstance()->query($sql);
		
		    echo "<center><hr><table cellpadding=0 cellspacing=0 border=1 style=font-size:12px;><tr bgcolor=lightgray><td>q_id</td><td>qno</td><td>qset</td><td>q_title</td><td>q_type</td><td width='100px'>Action</td></tr>";
		
		    $qry="Select * from question_detail where qset_id=$qset order by q_id";
	    	$dd=DB::getInstance()->query($qry);
		    if($dd->count()>0)
		    {
		        foreach($dd->results() as $d)
		        { 
				$qid=$d->q_id; $qtitle=$d->q_title; $qtype=$d->q_type; $qno=$d->qno;$qset=$d->qset_id;
				
				echo "<form action='' method=post><tr id=show$qid ><td>$qid</td><td>$qno</td><td>$qset</td><td>$qtitle</td><td>$qtype</td><td><a href=#edit$qid onclick=edit($qid)>edit</a> </td> </tr></form>";
				
				echo "<form action='' method=post><tr id=edit$qid style=display:none><td><input type=hidden name=qset value=$qset><input type=hidden name=qid value=$qid>$qid</td><td><input type=text name=qno STYLE='color: red;width:50px;' value=$qno></td>  <td><input type=text id=qset name=qset size=3 STYLE='color: red; width:50px;'  value=$qset></td><td><input type=text name=qtitle STYLE='color: red;width:1200px;' value='$qtitle'></td><td><input type=text name=qtype STYLE='color: red;width:50px;' value=$qtype></td><td><input type=submit name=save value=Save> <a href=#show$qid onclick=show($qid)>Cancel</a> </td> </tr></form>";
				
				
		        }
		    }
		    echo '</table>';
		        
	}

        ?>

<table cellpadding="2" cellspacing="1" border="0" style="font-size:12px;">
               	<form action="" method="post" enctype="multipart/form-data">
               	<!-- <tr><td>Project Name </td><td> <select name="pn" id="pn"><option value="0">--Select--</option><?php $pj=get_projects_details();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr>  -->  
           
                <tr><td>Project Name *</td> </td><td> <select name="pn" id="pn" onclick="displib2();"><option value="0">--Select--</option><?php $pj=get_projects_details();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr>
                <tr><td>QuestionSet ID *</td><td><select name="qset" id="qset" ><option value="select">--Select--</option> </select> </td></tr>
               	<tr><td><input type=submit name=edit_question value=Show></td></tr>
               	</form>
               	</table>

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
