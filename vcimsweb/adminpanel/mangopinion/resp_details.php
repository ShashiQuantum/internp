<?php
include_once('../../init.php');
include_once('../../functions.php');     

//SELECT * FROM demo_respondent WHERE respondent_id in(  SELECT resp_id FROM `sunflower` WHERE `q_id`=8 )
?>

	<body>
	<form action="" method="post">
	<center>
	 <br><br>
	<table cellpadding="2" cellspacing="1" border="0" style="font-size:12px;">
	
	<tr><td>Project Name </td><td> <select name="pn" id="pn"  onchange="displib2();"><option value="0">--Select--</option><?php $pj=get_projects_details();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr>
	<tr><td>QuestionSet ID </td><td><select name="qset" id="qset"><option value="select">--Select--</option> </select> </td></tr>
	<tr><td>Report Type </td><td><select name="rt" id="rt"><option value="1">Web Based</option><option value="2">App Based</option> </select> </td></tr>
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
	   $rt=$_POST['rt'];
	   
	    
	   if($qset!=0){
	   echo "<br><center><font color=red>Respondent Details of Project ID: $pid & Respondent ID :$rid  </font></center><br><br><br>";
          
	  $dt=DB::getInstance()->query("SELECT  `data_table`  FROM `project` WHERE `project_id`=$pid");
	      
	  if($dt->count()>0)
    	  {    
        

       		$datatable=$dt->first()->data_table;
       		if($rid=='all' || $rid=='All' || $rid=='ALL')
            	{ 
            	    if($rt==1)            	
            		$qr="SELECT a.`respondent_id`,a.`full_name`,a.`address`,a.`email`,a.`mobile`,b.`centre_id`,b.`start_time`, b.`end_time` ,b.qset_id ,b.status FROM demo_respondent a JOIN `respondent_link_map` b on a.respondent_id=b.resp_id WHERE a.respondent_id  in(  SELECT resp_id FROM $datatable WHERE `q_id`=$qset ) ORDER BY respondent_id";
            	    if($rt==2)            	
            		$qr="SELECT  `qset_id`, `resp_id`, `full_name`, `address`, `email`, `mobile`, `start_time`, `end_time`, `latt`, `lang`, `tab_id`, `i_name`, `i_mobile`, `cntr_id`, `status` FROM `app_respondent` WHERE qset_id=$qset  ORDER BY resp_id";
            		
            	}
       		else if($rid!='all' || $rid=='All' || $rid=='ALL'|| $rid !='')
       		{
       		    if($rt==1)
            		$qr="SELECT * FROM demo_respondent WHERE respondent_id in(  SELECT resp_id FROM $datatable WHERE `q_id`=$qset AND resp_id in ($rid)) ORDER BY respondent_id";
                    if($rt==2)
                    	$qr="SELECT * FROM app_respondent WHERE resp_id in(  SELECT resp_id FROM $datatable WHERE `q_id`=$qset AND resp_id in ($rid)) ORDER BY resp_id";
            	}
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

    
    try 
    {
    
	     $conn = new PDO("mysql:host=localhost;dbname=vcims_12052015", 'user1', 'vcims@user1');
	     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	     $stmt = $conn->prepare($qr); 
	     $stmt->execute();
	
	     // set the resulting array to associative
	     $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
	     $stmt->columnCount();
	     //to display column heading
	     echo "<center><table border='1' cellpadding='0' cellspacing='0' style='margin-left:75px'>";
     
		     for ($i = 0; $i < $stmt->columnCount(); $i++) 
		     {
			    $col = $stmt->getColumnMeta($i);
			    $columns[] = $col['name'];
		     }
    
	     $strth="<tr bgcolor=lightgray>";
	     if(count($columns))
	     foreach($columns as $t)
	     {  
	         
	         $strth.="<th>$t</th>";
	     }
	     echo $strth.='</tr>';
	     
	     $qst=new RecursiveArrayIterator($stmt->fetchAll());
	 
	     foreach(new TableRows($qst) as $k=>$v) 
	     { 
	          echo $v;  
	     }
    }
    catch(PDOException $e) 
    {
         echo "Error: " . $e->getMessage();
    }
    
    $conn = null;
    echo "</table> <br><br><br></center>";
    }
   

} 
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