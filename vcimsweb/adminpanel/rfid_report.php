<?php
require_once('../init.php');
?>

<!DOCTYPE html>

<html>
<head>
    <title>My realtime chart</title>
    
</head>

<body>
<center><h3>RFID Analysis Report</h3> </center>
        <?php
        $arr_brands=array();
        $arr_products=array();
        $arrb=array();$arrp=array();
        // Form Elements
        echo "<form action='' method=post><table><tr height=30><td width=150>Report type</td><td><select name=rt id=rt><option value=1>Discrete Chart</option><option value=2>Cumulative Chart</option></select></td></tr>";
        echo "<tr height=30><td>Brand </td><td>";
        echo "<details> <summary>Click here for Brand</summary>";
       
        $db1=DB::getInstance()->query("SELECT distinct `product_name` FROM Digiadmin_rfid.rfid_info");
        if($db1->count()>0)
            foreach($db1->results() as $r)
            { 
                if($r->product_name!='')
                {
                array_push($arr_brands, $r->product_name);
                echo "<input type=checkbox name=$r->product_name value=$r->product_name > $r->product_name ";
                }
            }
            
        echo "</details>";
        echo "</td></tr><tr height=30><td>Product </td><td>";
        echo "<details> <summary>Click here for Product</summary>";
        // $mysqli = new mysqli("localhost", "rfid_user", "vcims@rfid", "Digiadmin_rfid");
 
        $query = "SELECT distinct `product_sku` FROM Digiadmin_rfid.rfid_info";
 
        //$result = $mysqli->query($query);
        $db1=DB::getInstance()->query($query);
         if($db1->count()>0)
            foreach($db1->results() as $r)
            { 
                if($r->product_sku!=''){
                array_push($arr_brands, $r->product_sku);
                echo "<input type=checkbox name=$r->product_sku value=$r->product_sku > $r->product_sku ";
                }
            }
            
        echo "</details>";
        echo "</td></tr><tr height=30><td>Duration Type </td><td><select name=dt id=dt><option value=1>Day</option><option value=2>Point of time</option><option value=3>Week</option><option value=4>Month</option><option value=5>Year</option></td></tr>";
        echo "</td></tr><tr height=30><td>Date From </td><td><input type=date name=fd id=fd> To  <input type=date name=td id=td></td></tr>";
        echo "<tr height=40><td></td><td><input type=submit name='view' value=View></td></tr></table></form>" ;  
       
        //after view submited
        if(isset($_POST['view']))
        {   
            $rt=$_POST['rt'];
            $fd=$_POST['fd'];
            $td=$_POST['td'];
            $dt=$_POST['dt'];
            
            //print_r($_POST);
            
            $arr_post=array();
            foreach($_POST as $k=>$v)
            {  
        
                if($k=='view' || $k =='rt' || $k=='fd' || $k=='td' || $k=='dt')
                {
                    continue;
                }
                else                       
                            array_push($arr_post,$v);            
            }
            //print_r($arr_post);
            //echo "<br>Brands are:";
            foreach($arr_brands as $b)
            {
                if(in_array($b,$arr_post))
                       array_push($arrb, $b);
            }
             //print_r($arrb);
             //echo "<br>Products are:";
            foreach($arr_products as $p)
            {
                if(in_array($p,$arr_post))
                        array_push($arrp, $p);
            }
            //print_r($arrp);
           if($rt=='1')
           {    
            $dtt='';
            if($dt=='1')
            {
                $dtt='substring(timestamp,1,10)';
            }
            if($dt=='2')
            {
                $dtt='timestamp';
            }
            if($dt=='3')
            {
                $dtt='YEARWEEK(substring(timestamp,1,10))';
            }
            if($dt=='4')
            {
                $dtt='MONTH(substring(timestamp,1,10))';
            }
            if($dt=='5')
            {
                $dtt='Year(substring(timestamp,1,10))';
            }
            
            $countp=count($arrp);
            $countb=count($arrb);$strb='';$strp='';$ctr=0;
            $qr="SELECT $dtt as Date, ";
            if($countb>0)
            {
                foreach($arrb as $b)
                {   if($ctr==0)
                      $strb.="SUM(IF (`product_name` = '$b',1,0)) as $b ";
                    else
                      $strb.=",SUM(IF (`product_name` = '$b',1,0)) as $b ";  
                    $ctr++;
                }
              $qr.=$strb;
            }
            if($countp>0)
            {   
                
                foreach($arrp as $p)
                {   if($ctr==0)
                      $strp.="SUM(IF (`product_sku` = '$p',1,0)) as $p ";
                    else
                      $strp.=",SUM(IF (`product_sku` = '$p',1,0)) as $p ";    
                    $ctr++;
                }          
                $qr.=$strp;
            }
            
            $qr.=" FROM `rfid_info`  WHERE substring(`timestamp`,1,10) BETWEEN '$fd' AND '$td' group by $dtt ;";
          }
          if($rt=='2')
          {
              $dtt='';
            if($dt=='1')
            {
                $dtt='substring(timestamp,1,10)';
            }
            if($dt=='2')
            {
                $dtt='timestamp';
            }
            if($dt=='3')
            {
                $dtt='YEARWEEK(substring(timestamp,1,10))';
            }
            if($dt=='4')
            {
                $dtt='MONTH(substring(timestamp,1,10))';
            }
            if($dt=='5')
            {
                $dtt='Year(substring(timestamp,1,10))';
            }
            
            $countp=count($arrp);
            $countb=count($arrb);$strb='';$strp='';$ctr=0;$strbc='';$strb1='';$strpc='';$strpc1='';$mq='';
            
            $qr=" FROM (SELECT $dtt as Date, ";
            if($countb>0)
            {
                foreach($arrb as $b)
                {   if($ctr==0)
                        {$strb.="COUNT(IF (`product_name` = '$b',1,NULL)) as $b "; $strbc=" SELECT q1.Date, (@$b := @$b + q1.$b) AS $b"; $strbc1="SET @$b := 0;"; }
                    else
                        { $strb.=",COUNT(IF (`product_name` = '$b',1,NULL)) as $b "; $strbc.=",(@$b := @$b + q1.$b) AS $b"; $strbc1.="SET @$b := 0;";}
                    $ctr++;
                }
              $qr.=$strb;
            }
            if($countp>0)
            {   
                
                foreach($arrp as $p)
                {   if($ctr==0)
                        {$strp.="COUNT(IF (`product_sku` = '$p',1,NULL)) as $p "; $strpc=" SELECT q1.Date, (@$p := @$p + q1.$p) AS $p"; $strpc1="SET @$p := 0;";}
                    else
                        {$strp.=",COUNT(IF (`product_sku` = '$p',1,NULL)) as $p "; $strpc.=",(@$p := @$p + q1.$p) AS $p"; $strpc1.="SET @$p := 0;"; }   
                    $ctr++;
                }          
                $qr.=$strp;
            }
            
            $qr.=" FROM `rfid_info`  WHERE substring(`timestamp`,1,10) BETWEEN '$fd' AND '$td' group by $dtt) as q1";
            $mq="$strbc1 $strpc1";
            $mq.="$strbc $strpc";
            $mq.="$qr";
            $qr=$mq;
          }
            //echo '<br>'. $qr;
          
              
        //  $qr="SET @Karbon := 0;SET @Micromax := 0; SELECT q1.date, (@Karbon := @Karbon + q1.Karbon) AS Karbon,(@Micromax := @Micromax + q1.Micromax) AS Micromax FROM (SELECT substring(timestamp,1,10) as date, COUNT(IF (`product_name` = 'Karbon',1,NULL)) as Karbon ,COUNT(IF (`product_name` = 'Micromax',1,NULL)) as Micromax FROM `rfid_info` WHERE substring(`timestamp`,1,10) BETWEEN '2015-06-01' AND '2015-07-29' group by substring(timestamp,1,10)) as q1";
            
            if($fd=='' || $td=='')
                echo "<font color=red><br>Select/Fill the details like brand/product and date properly for report</font>";
            else
            {
            ?>
    
            
    
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script type="text/javascript">
                    // Load the Visualization API and the piechart package.
        google.load('visualization', '1', {'packages':['corechart']});
        //google.load('visualization', '1', {packages: ['corechart', 'line']});
        // Set a callback to run when the Google Visualization API is loaded.
        google.setOnLoadCallback(drawChart);

        function drawChart() { 
          //var jsonData = $.ajax({ url: "chart_data.php", dataType:"json", async: false }).responseText; 
              
        var vv=<?php 
        
        //$mysqli = new mysqli("localhost", "rfid_user", "vcims@rfid", "Digiadmin_rfid");
        $mysqli = new mysqli("localhost", "user1", "vcims@user1", "Digiadmin_rfid");
        
     //$result = $mysqli->query($query);
        
    if (mysqli_multi_query($mysqli, $qr)) 
   {
    do { $result=mysqli_multi_query($mysqli, $qr);
       
        $results_array = Array(Array());
    $fillKeys = true;
    if ($result = mysqli_store_result($mysqli)) 
    { 
     while ($row = $result->fetch_assoc()) 
     {
        $temp = Array();
        foreach ($row as $key => $val)
        {
            if ($fillKeys) {
                $results_array[0][] = $key;
            }
            $temp[] = $val;
        }
        $results_array[] = $temp;
        $fillKeys = false;
    }
    }    if(!mysqli_more_results($mysqli)) break;
    } while (mysqli_next_result($mysqli));
            }
   
    $jsontable = json_encode($results_array, JSON_NUMERIC_CHECK);
    //echo $jsontable;
        echo json_encode($jsontable);?> ; 
              // alert(vv.valueOf());
        
          // Create our data table out of JSON data loaded from server.
          //var data = new google.visualization.arrayToDataTable(JSON.parse(jsonData));
          var data = new google.visualization.arrayToDataTable(JSON.parse(vv));
          var options = {
          title: 'Sales Report [total sales date wise]',
           //hAxis: {title: 'Sales Date', side: 'bottom'},
           vAxis: {
          title: 'Sales Count'
          },
           hAxis: {
          title: 'Sales Date [ Duration ]'
          },
         axes: {
            hAxis: {
              0: { side: 'top', label: 'Percentage'} // Top x-axis.
            }
          },
          //curveType: 'function',
          legend: { position: 'right' }
        };
              // Instantiate and draw our chart, passing in some options.
          var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
          chart.draw(data,options, {width: 900, height: 600,is3D: true});
        }
        </script>  
    <?php
        
       
            }
        }
        ?>

<center><div id="chart_div" style="width: 1300px; height: 500px;"></div></center>
</body>

</html>
<?php
 // echo $qr;
    if($rt==1)
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
     $conn = new PDO("mysql:host=localhost;dbname=Digiadmin_rfid", 'rfid_user', 'vcims@rfid');
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
    echo "</table> <br>Sales Count Descrete Chart Data<br><br></center>";
    }
    
    
    if($rt==2)
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
    
    $mysqli = new mysqli("localhost", "rfid_user", "vcims@rfid", "Digiadmin_rfid");
  if (mysqli_multi_query($mysqli, $qr)) 
   {
            do { $result=mysqli_multi_query($mysqli, $qr);

                $results_array = Array(Array());
            $fillKeys = true;
            if ($result = mysqli_store_result($mysqli)) { 
             while ($row = $result->fetch_assoc()) 
            {
                $temp = Array();
                foreach ($row as $key => $val)
                {
                    if ($fillKeys) {
                        $results_array[0][] = $key;
                    }
                    $temp[] = $val;
                }
                $results_array[] = $temp;
                $fillKeys = false;
            }
            } 
              if(!mysqli_more_results($mysqli)) break;   
            } while (mysqli_next_result($mysqli));
   }
    echo "<center><table border='1' cellpadding='0' cellspacing='0' style='margin-left:75px'>";

    
     $qst=new RecursiveArrayIterator($results_array);
 
     foreach(new TableRows($qst) as $k=>$v) 
     { 
          echo $v;  
     }
   
    
    echo "</table> <br>Sales Count Cumulative Chart Data<br><br></center>";
    }
?>

<script type="text/javascript">
  document.getElementById('rt').value = "<?php echo $_POST['rt'];?>";
  document.getElementById('dt').value = "<?php echo $_POST['dt'];?>";
  document.getElementById('fd').value = "<?php echo $_POST['fd'];?>";
  document.getElementById('td').value = "<?php echo $_POST['td'];?>";
  
  
  </script>