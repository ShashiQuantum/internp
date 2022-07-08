<?php
include_once('../../init.php');
include_once('../../functions.php');
?>

<head><title>Filter Count</title></head>
<body>
<br><br>
<center>
<h2><u>Respondent Filter</u></h2>
<br><br>
</center>
<form name="tFORM" method=post action="respondent_filter_count.php">



<?php
///////////   SHASHI  NEW CODE FOR FILTER REPORT START FROM HERE////////////////////////////////////////
$query1 ="SELECT DISTINCT(appuser_project_map.project_id),project.name from appuser_project_map INNER JOIN project on appuser_project_map.project_id = project.project_id order by appuser_project_map.project_id DESC";
   
echo "<br><table><tr><td> Project </td> </td><td> <select name=pn id=pn required ><option value=0>--Select Project--</option>";
$data=DB::getInstance()->query($query1);
     if($data->count()>0) 
     {  
          foreach($data->results() as $dR)
          {
            
             
             echo "<option value='";
             echo $dR->project_id; 
            echo "'>";
             echo $dR->name; 
            echo "</option>";
           

          }

     }   

    
      
      







