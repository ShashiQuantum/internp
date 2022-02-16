<?php
require_once('../init.php');
require_once('../functions.php');


?>


<html>
<body>
<form action="" method="post">
<center>
 <br><br>
<table cellpadding="2" cellspacing="1" border="0" style="font-size:12px;">

<tr><td>Project Name </td><td> <select name="pn" id="pn"  onchange="displib2();"><option value="0">--Select--</option><?php $pj=get_projects_details();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr>
<tr><td>QuestionSet ID </td><td><select name="qset" id="qset"><option value="select">--Select--</option> </select> </td></tr>
<tr><td>Respondent ID </td><td><input type=text name="rid" value="all" onkeypress="return isNumber(event)"></td></tr>
<tr><td></td><td><input type=submit name=submit value="View"></td></tr>

</table>
</center>
</form>
</body>
</html>


<script type="text/javascript">

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


<?php
if(isset($_POST['submit']))
{
     
   $pid=$_POST['pn'];
   $qset=$_POST['qset'];
   $rid=$_POST['rid'];
    
   if($qset!=0){
   echo "<br><center><font color=red>Survey Data of Project ID: $pid & Respondent ID :$rid  </font></center><br><br><br>";
      
      
          $dt=DB::getInstance()->query("SELECT  `data_table`  FROM `project` WHERE `project_id`=$pid");
      
         

   if($dt->count()>0)
    {    
        echo "</center><br><form method=post action='export.php'> <input type=submit value='Export To Excel' name=export></form> <br>";

       $datatable=$dt->first()->data_table;
       if($rid=='all' || $rid=='All' || $rid=='ALL')
            $qr="SELECT * FROM $datatable WHERE q_id=$qset ORDER BY resp_id";
       else if($rid!='all' || $rid=='All' || $rid=='ALL'|| $rid !='')
            $qr="SELECT * FROM $datatable WHERE q_id=$qset AND resp_id=$rid ";
    $_SESSION['query']=$qr;


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
     $stmt = $conn->prepare($qr); 
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
    echo "</table> <br><br><br></center>";
    }
   

} 
}

if(isset($_POST['export']))
{ 


$filename = "VCIMS_Report_" . date('YmdHms') . ".xls";
//$filename = "VCIMS_Report.xls";
header('Content-type: application/octet-stream');
//header("Content-Type: application/xls");  
header("Content-Disposition: attachment; filename=$filename");
 //header("Content-Type: application/vnd.ms-excel");
header("Pragma: no-cache");
header("Expires: 0");


  $qr=$_SESSION['query'];
    
  
  
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
     $stmt = $conn->prepare($qr); 
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
    echo "</table> <br><br><br></center>";

     
}
?>

<script type="text/javascript">

   function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            alert("Please enter only Numbers.");
            return false;
        }

        return true;
    }
</script>