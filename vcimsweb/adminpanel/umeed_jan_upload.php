<html>
<head>
</head>

<body>	
        <table border="1" cellpadding="0" cellspacing="0">
	<form method="post" action="" enctype="multipart/form-data" >
		
            <tr><td> </td> <td> <h5>Add Ummeed JAN Data</h5></td></tr>
                
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
                       $i=0;
                            
                        while(($fv = fgetcsv($handle, 1000, ",")) !== false)
                        {
                         
                            if($ch2=='y')
                                {
                                    if($i>0)
                                    {
                               $vv=$fv[0];     
                $f1=$fv[1];$f2=$fv[2];$f3=$fv[3];$f4=$fv[4];$f5=$fv[5];$f6=$fv[6];$f7=$fv[7];$f8=$fv[8];$f9=$fv[9];$f10=$fv[10];
		$f11=$fv[11];$f12=$fv[12];$f13=$fv[13];$f14=$fv[14];$f15=$fv[15];$f16=$fv[16];$f17=$fv[17];$f18=$fv[18];$f19=$fv[19];$f20=$fv[20];
		$f21=$fv[21];$f22=$fv[22];$f23=$fv[23];$f24=$fv[24];$f25=$fv[25];$f26=$fv[26];$f27=$fv[27];$f28=$fv[28];$f29=$fv[29];$f30=$fv[30];
		$f31=$fv[31];$f32=$fv[32];$f33=$fv[33];$f34=$fv[34];$f35=$fv[35];$f36=$fv[36];$f37=$fv[37];$f38=$fv[38];$f39=$fv[39];$f40=$fv[40];      
		$f41=$fv[41];$f42=$fv[42];$f43=$fv[43];$f44=$fv[44];$f45=$fv[45];$f46=$fv[46];$f47=$fv[47];$f48=$fv[48];$f49=$fv[49];$f50=$fv[50];
		$f51=$fv[51];$f52=$fv[52];$f53=$fv[53];
		
       
       
///*
   
   echo '<br><br>booth_id:'.$vv;     
  //echo '<br>'. $qq03="iiINSERT INTO `safal_list`(`b_id`, `address`, `city`, `bcentre_id`) VALUES ('$vv','$f1','$f2','$f3');";
              echo '<br>'.   $qwr= "UPDATE `safal_list` SET `sales_cat`='$f1' ,`cat_code`='$f2'  WHERE `b_id`=$vv";
		  //DB::getInstance()->query($qwr);
//*/
                
		
                }
                              $i++;

                      }
                        }
                        
                        //echo "<br>Data Added to the database table.";
                }

                else
                {
                        //echo '<br>Upload CSV file.';
                }
        }



	
?>