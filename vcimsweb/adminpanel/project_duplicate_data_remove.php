<?php
include_once('../init.php');
include_once('../functions.php');

?>

<html>
<body>
 
<center>
<h2>Project Duplicate Data Cleanup</h2>
<table border='1' cellpadding='0' cellspacing='0' style='margin-left:75px'>
<form action="" method=post>
<tr><td>Project Name </td><td> <select name="pid" id="pid"><option value="0">--Select--</option><?php $pj=get_projects_details();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr>
 
<tr><td></td><td><input type=submit name=submit value=DELETE> </td></tr>
</form>

</table>

<?php

if(isset($_POST['submit']))
{
        $pid=$_POST['pid'];
        
        $table=null;

        $ddd1=DB::getInstance()->query("SELECT * FROM `project`  WHERE `project_id`=$pid)");

  if($ddd1->count()>0)
  {  
      
     $table=$ddd1->first()->data_table;
     
  }
 
     
     if($table!=null)
     {
        $r1=DB::getInstance()->query("SELECT distinct `resp_id` FROM  $table WHERE  centre_$pid !=  '' order by resp_id");
	 if($r1->count()>0)
	 {
	   foreach($r1->results() as $ra)
	   {    
	   $rsp=$ra->resp_id;

         $qa="SELECT min(id) as min, max(id) as max,  `resp_id` FROM  $table WHERE resp_id=$rsp AND centre_$pid !=  '' order by id";
          $rs=DB::getInstance()->query($qa);
          if($rs->count() > 0)
          {
              $min=$rs->first()->min; $max=$rs->first()->max;
              if($max > $min)
              {
                 $max--;
                 echo "<br>".$qq="DELETE FROM $table WHERE resp_id=$rsp AND id BETWEEN $min AND $max ;";
                  DB::getInstance()->query($qq);
              }
          }
        }}
        echo "Duplicate data removed successfully";
     }
   
}          

?>

 <script type="text/javascript">
  document.getElementById('pid').value = "<?php echo $_POST['pid'];?>";
   </script> 