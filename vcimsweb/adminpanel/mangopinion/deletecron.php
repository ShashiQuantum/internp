<?php
include_once "dbcon.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Survegeynics</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  
</head>
<body>
<div class="container">
<h3  class="text-primary text-uppercase text-center"> Reminder Message EDIT | DELETE </h3>

<div class ="d-flex justify-content-end"> 
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">  Open modal  </button>
</div>
<h5 class="text-warning"> All Reminder Record  <h5>
    <div class="records_contents "> 

    <!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Modal Heading</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class ="form-group">  
         <label> Project Name : </label>
         <input type="text" id="projectName"  class="form-control">   
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>



    </div>



</div>




  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>












<?php

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
<td><?php echo $rrdata['project_status']; ?></td>    <td> <?php echo $rrdata['hour']; ?> </td>
<td>
<?php
if($rrdata['id']){
?>
<input type='button' value="Delete"  class='idbutton' data-id='<?php echo  $rrdata['id'] ?>' onclick="return confirm('are you sure?')" >
<?php
}
?>

<span style="color:red" id="rData"> </span> </td> </tr>
    
    
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script Type="text/javascript"> 

$(".idbutton").click(function() { 
    var idval = $(this).data("id"); 
    
                    $.ajax({
                type: "POST",
                url: 'cronquery.php',
                data: {idval: idval},
                success: function(data){
                $("#rData").html(data)
                
                },
                error: function(xhr, status, error){
                console.error(xhr);
                }
                });

});    
 </script>
    
    
   