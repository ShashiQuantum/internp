

<html>
<head>
</head>

<body>	
        <table border="1" cellpadding="0" cellspacing="0">
	<form method="post" action="" enctype="multipart/form-data" >
		
            <tr><td> </td> <td> <h5>Add Project Data</h5></td></tr>
                
		<tr>
			<td> Upload File  </td>
			<td>
				<input type="file" name="fup" />
			</td>
		</tr>
                <tr> <td colspan="2"> <center><input type="submit" name="add" value="Upload" ></center></td></tr>
	
	</form>	
        </table>
</body>
</html>

<?php
	include_once('../init.php');
	
        
	if(isset($_POST['add']))
	{
		if(isset($_FILES['fup']))
        	{
        	       // print_r($_FILES);
			$tmp = $_FILES['fup']['tmp_name'];
			$fname = $_FILES['fup']['name'];
			
			move_uploaded_file($tmp, '../uploads/'.$fname);

                        $handle = fopen('../uploads/'.$fname, "r");

                        $i=0;$ch='n';$ch2='y';
                        /*
                        while(($fv = fgetcsv($handle, 10000, ",")) !== false)
                        {
                            if($i==0) 
                            { 
                                    $i++;  
                            }
                            else if($ch=='y')
                            {
                              $f1=$fv[0];$f2=$fv[1];$f3=$fv[2];

                              $q3=DB::getInstance()->query($qr);
                             
                              $ch='n';
                              continue;
                            }
                        }
                         
                         */
                            
                        while(($fv = fgetcsv($handle, 1000, ",")) !== false)
                        {
                         
                            if($ch2=='y')
                                {
                                    
                               $vv=$fv[0];     
                               
                             echo '<br>'. $qq03="INSERT INTO Digiadmin_rfid.rfid_info (`tagid`) VALUES ( '$vv')";
                              $q03=DB::getInstance()->query($qq03);    
                                        

                      }
                        }
                        
                        echo "<br>Data Added to the database table.";
                }

                else
                {
                        echo '<br>Upload CSV file.';
                }
        }
	
?>

