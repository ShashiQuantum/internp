<?php
 require_once('../init.php');
require_once('../functions.php');

 $qr=$_SESSION['query'];

if( $_SESSION['umeedqr2']!='')
       			$qr=$_SESSION['umeedqr2'];

$filename = "vcims_report_" . date('YmdHms') . ".csv";

 header( 'Content-Type: text/csv' );
 //header('Content-type: application/octet-stream');
       //header("Content-Type: application/xls");  
header("Content-Disposition: attachment; filename=$filename");
       //header("Content-Type: application/vnd.ms-excel");
header("Pragma: no-cache");
header("Expires: 0");

//ini_set("memory_limit",-1);

 // $qr=$_SESSION['query'];
    
  
  
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
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); $conn->query("SET wait_timeout=180;");  ini_set('memory_limit', '896M');
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

 
?>