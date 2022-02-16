<?php
require_once('../init.php');

if(isset($_POST['submit']))
{
     //print_r($_POST);
     $c=$_POST['client'];
     $tag=$_POST['tag'];
     $b=$_POST['brand'];
     $p=$_POST['model'];
     $mrp=$_POST['mrp'];
     $location=$_POST['location'];
     
     if($tag !='' && $b != '' && $p != '' && $location != '')
     {
       $db=DB::getInstance()->query("SELECT * FROM Digiadmin_rfid.rfid_installed_info WHERE `tag_id` = '$tag'");
       if($db->count()>0)
       {
           echo "<font color=red>Tag Id already exist</font>";
       }
       else
       {
          $sql="INSERT INTO Digiadmin_rfid.rfid_installed_info( `tag_id`, `brand_name`, `model_name`, `inst_location`, `mrp`, `client_id`) VALUES ('$tag','$b','$p','$location',$mrp,$c)";
          DB::getInstance()->query($sql);
          echo "<font color=red>Tag Id saved successfully : </font>$tag";
       }
     }
     else echo 'Please fill the details like tag_id, brand, model and location';
}

?>

<center>
<br><br><h2>RFID TAG Entry Panel</h2>
<table>
<form action='' method='post'>
<tr><td>Client ID </td><td> <select name=client><option value=0>Demo1</option><option value=1>Demo2</option><option value=2>Others</option></select></td></tr>
<tr><td>Tag ID </td><td><input type=text name=tag value="E2002076990D022"></td></tr>
<tr><td>Brand Name </td><td><input type=text name=brand placeholder="Enter brand name here"></td></tr>
<tr><td>Product Model Name </td><td><input type=text name=model placeholder="Enter model name here"></td></tr>
<tr><td>MRP(in INR) </td><td><input type=text name=mrp placeholder="Enter MRP here"></td></tr>
<tr><td>Store Location </td><td><input type=text name=location placeholder="Enter store location here"></td></tr>
<tr><td></td><td><input type=submit name=submit value=Submit>
</form>
</table>
</center>