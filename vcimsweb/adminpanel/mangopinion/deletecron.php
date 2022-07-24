<?php
include_once "dbcon.php";


/////////////////////INSERT DATA INTO CRON JOB TABLE///////////////////////

if(isset($_POST['createCronJob'])){ 

    $bankFlag0 =0;
       if(isset($_POST['projectId'])){ $projId= $_POST['projectId'];} else{$bankFlag0 =1;}
       
    if($bankFlag0 ==1 )
    {
        echo "<center><font color=red><h4>Please fill complete information to set the CRON Job</h4></font>";
    
    }else{

        echo "<center><font color=red><h4>Delete Reminder</h4></font>";
        $rrqrr="select cron_job.id,cron_job.project_id,cron_job.hour,cron_job.project_status,project.name from cron_job inner join project on cron_job.project_id = project.project_id";
        $result = $mysqli->query($rrqrr);
        if($result){   
            $k=1;
        
          ?>
            
<table border=1; bgcolor="#e8eef3"; style="width:60%">
<tr>
    <th>Sl No</th>
    <th>Survey Name</th>
    <th>Survey Id</th>
    <th>Survey status</th>
    <th>Survey hours</th>
    <th>Action</th>
    
  </tr>
<?php   
 foreach($result as $rrdata){   ?>
<tr> <td><?php echo $k; ?></td> <td><?php echo $rrdata['name']; ?></td> <td><?php echo $rrdata['project_id']; ?></td> 
<td><?php echo $rrdata['project_status']; ?></td>    <td> <?php echo $rrdata['hour']; ?> </td><td> Delete </td>  </tr>
            
    
<?php 
$k++;

}
        }else{
            echo "<center><font color=red><h4>Some Technical problem CRON job not created!</h4></font>"; 
        }
    }
    }
    else{
    
    ////////////////////END THE INSERT SECTION IN THE TABLE////////////////////
    
    
    
    echo "<center><font color=red><h2>Delete Reminder</h2></font>"; 
    $qrr="select cron_job.project_id,project.name from cron_job inner join project on cron_job.project_id = project.project_id";
    $result = $mysqli->query($qrr);
    $prows = $result->fetch_all(MYSQLI_ASSOC);
    
    ?>
    
    <form method=post action="deletecron.php"">
    <table border=1; bgcolor="#e8eef3"; style="width:60%">
    
    
    
    <tr> <td>Select Survey *</td>   <td> <select name=projectId id=projectId required><option value=''>-Select Survey-</option>
        
    <?php   foreach($prows as $rdata){
             echo "<option value='";
             echo $rdata['project_id']; 
             echo "'>";
             echo $rdata['name']; 
             echo "</option>";
                  } ?>  
            </td> </tr>
                
    
                <tr align="center"><td colspan ="2"><input type=submit name=createCronJob value="View All Reminder"></td></tr>
    </form>
    </center>
      
      
    
    
    <?php
    
    
    
    
   
    }
    
    ?>
    
    
   