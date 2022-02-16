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
<head><title>View Question</title></head>
<body>
<center>
<br><br><h2>View Project's Questions</h2><br><br>

<?php
	//create new question
	if(isset($_POST['question_view']))
	{
	    //print_r($_POST);
	    	$pid=$_POST['pn'];
	    	$qset=$_POST['qset'];
	    	$qry="Select * from question_detail where qset_id=$qset order by q_id";
	    	
	    	class TableRows extends RecursiveIteratorIterator 
		{ 
		     function __construct($it) { 
		         parent::__construct($it, self::LEAVES_ONLY); 
		     }
		
		     function current() {
		         return "<td style='width: 150px; border: 1px solid black;'>" . parent::current(). "</td>";
		     }
		
		     function beginChildren() { 
		         echo "<tr>"; 
		     } 
		
		     function endChildren() { 
		         echo "</tr>" . "\n";
		     } 
		 } 
		    
		    try { 
		     $conn = new PDO("mysql:host=localhost;dbname=vcims_12052015", 'user1', 'vcims@user1');
		     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		     $stmt = $conn->prepare($qry); 
		     $stmt->execute();
		
		     // set the resulting array to associative
		     $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		     $stmt->columnCount();
		     //to display column heading
		     echo "<center><table border='1' cellpadding='0' cellspacing='0' style='margin-left:75px'>";
		     
		     for ($i = 0; $i < $stmt->columnCount(); $i++) {
		    $col = $stmt->getColumnMeta($i);
		    $columns[] = $col['name'];
		    }
		    //print_r($columns);
		     $strth="<tr bgcolor=lightgray>";
		     if(count($columns))
		     foreach($columns as $t)
		     {  
		         
		         $strth.="<th>$t</th>";
		     }
		     echo $strth.='</tr>';
		     
		     $qst=new RecursiveArrayIterator($stmt->fetchAll());
		 
		     foreach(new TableRows($qst) as $k=>$v) { 
		          echo $v;  
		     }
		    }
		    catch(PDOException $e) {
		         echo "Error: " . $e->getMessage();
		    }
		    $conn = null;
		    echo "</table> </center>";
	    
	}

?>

		<table cellpadding="2" cellspacing="1" border="0" style="font-size:12px;">
               	<form action="" method="post" enctype="multipart/form-data">
               	<!-- <tr><td>Project Name </td><td> <select name="pn" id="pn"><option value="0">--Select--</option><?php $pj=get_projects_details();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr>  -->  
           
                <tr><td>Project Name *</td> </td><td> <select name="pn" id="pn" onclick="displib2();"><option value="0">--Select--</option><?php $pj=get_projects_details();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr>
                <tr><td>QuestionSet ID *</td><td><select name="qset" id="qset" ><option value="select">--Select--</option> </select> </td></tr>
               	<tr><td><input type=submit name=question_view value=View></td></tr>
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
