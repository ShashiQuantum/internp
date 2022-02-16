<?php
include_once('../init.php');
$qt=0;
$text='';
//ini_set("memory_limit",'956M');
?>
<html><head><title>VCIMS Query Editor</title></head>

<?php

if(isset($_POST['query']))
{
  	//print_r($_POST);
  	$qt=$_POST['qt'];
  	$text=$_POST['qtext'];
  	
  	if($qt==1 && $text!='')
  	{
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
		     $conn = new PDO("mysql:host=database-1.c1mggasso0hp.ap-south-1.rds.amazonaws.com;dbname=vcims", 'qcsrdsadmin', 'Pa7du#ah$098');
		     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
                     $conn->query("SET wait_timeout=180;"); ini_set('memory_limit', '896M');

		     $stmt = $conn->prepare($text); 
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
  	if($qt==2 && $text!='')
  	{
  		$ustr=DB::getInstance()->query($text);
  		if($ustr)
  		  	echo "Updated successfully";
  		
  	}
  	if($qt==3 && $text!='')
  	{
  		$istr=DB::getInstance()->query($text);
  		if($istr)
  		  	echo "Inserted successfully";
  		
  	}
  	if($qt==4 && $text!='')
  	{
  		$dstr=DB::getInstance()->query($text);
  		if($dstr)
  		  	echo "Deleted successfully";
  		
  	}	
  	if($qt=='' || $text=='') echo "Please specify the require detail properly!";
}

?>
<center>
<form method=post action="">
<br><br>Query Type <select name=qt id=qtt>
<option value=1>SELECT Query</option>
<option value=2>UPDATE Query</option>
<!--
<option value=3>INSERT Query</option><option value=4>DELETE Query</option -->
</select> <br><br>
<textarea name=qtext id=qtextt rows=6 cols=80 placeholder="Type your SQL query here"></textarea><br><br>
<input type=submit name=query value="Execute Query"> <input type=reset name=re value=Reset><br>
</form>
</center> 

<script type="text/javascript">
  document.getElementById('qtt').value = "<?php echo $qt; ?>"; 
  document.getElementById('qtextt').value = "<?php echo $text; ?>"; 
</script>
