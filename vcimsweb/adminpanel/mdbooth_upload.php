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
                       $i=0;$ctr=0;
                            
                        while(($fv = fgetcsv($handle, 1000, ",")) !== false)
                        {
                         
                            if($ch2=='y')
                                {
                                    if($i>0)
                                    {
                                         $ctr++;
                               //$vv=$fv[0];     
                                $f2=$fv[0];$f3=$fv[1];$f4=$fv[2];$f5=$fv[3];$f6=$fv[4];$f7=$fv[5];$f8=$fv[6];$f9=$fv[7];$f10=$fv[8];$f11=$fv[9];
                             echo '<br>'. $qq01="INSERT INTO `umeed_dashboard`(`id`, `booth_id`, `month`, `centre`, `shift`, `grp_id`, `grp_score`, `hml`) VALUES ( $ctr,$f2,1,$f4,$f3,1 ,$f7,$f11)";
                            $q03=DB::getInstance()->query($qq01);
                            $ctr++;
                            echo '<br>'. $qq02="INSERT INTO `umeed_dashboard`(`id`, `booth_id`, `month`, `centre`, `shift`, `grp_id`, `grp_score`, `hml`) VALUES ( $ctr,$f2,1,$f4,$f3,2 ,$f6,$f11)";
                            $q03=DB::getInstance()->query($qq02);
                            $ctr++;
                            echo '<br>'. $qq03="INSERT INTO `umeed_dashboard`(`id`, `booth_id`, `month`, `centre`, `shift`, `grp_id`, `grp_score`, `hml`) VALUES ( $ctr,$f2,1,$f4,$f3,3 ,$f9,$f11)";
                            $q03=DB::getInstance()->query($qq03);
                            $ctr++;
                            echo '<br>'. $qq04="INSERT INTO `umeed_dashboard`(`id`, `booth_id`, `month`, `centre`, `shift`, `grp_id`, `grp_score`, `hml`) VALUES ( $ctr,$f2,1,$f4,$f3,4 ,$f8,$f11)";
                            $q03=DB::getInstance()->query($qq04);
                            $ctr++;
                            echo '<br>'. $qq05="INSERT INTO `umeed_dashboard`(`id`, `booth_id`, `month`, `centre`, `shift`, `grp_id`, `grp_score`, `hml`) VALUES ( $ctr,$f2,1,$f4,$f3,5 ,$f10,$f11)";
                            $q03=DB::getInstance()->query($qq05);
                            $ctr++;
                            echo '<br>'. $qq06="INSERT INTO `umeed_dashboard`(`id`, `booth_id`, `month`, `centre`, `shift`, `grp_id`, `grp_score`, `hml`) VALUES ( $ctr,$f2,1,$f4,$f3,0 ,$f5,$f11)";
                              $q03=DB::getInstance()->query($qq06);    
                                }
                              $i++;

                      }
                        }
                        
                        echo "<br>Data Added to the database table.";
                }

                else
                {
                        echo '<br>Upload CSV file.';
                }
        }


    /*    
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
                       
                            
                        while(($fv = fgetcsv($handle, 1000, ",")) !== false)
                        {
                         
                            if($ch2=='y')
                                {
                                    
                               $vv=$fv[0];     
                                $f1=$fv[0];$f2=$fv[1];$f3=$fv[2];$f4=$fv[3];$f5=$fv[4];$f6=$fv[5];$f7=$fv[6];
                             echo '<br>'. $qq03="INSERT INTO `mdbooth`(`b_id`, `address`, `city`, `post`, `mobile`, `area`, `zone`) VALUES ('$f1','$f2','$f3',$f4,'$f5','$f6','$f7')";
                             $q03=DB::getInstance()->query($qq03);    
                                       // echo "<br> values ($f1,$f2,$f3,$f4,$f5,$f6,$f7)";

                      }
                        }
                        
                        echo "<br>Data Added to the database table.";
                }

                else
                {
                        echo '<br>Upload CSV file.';
                }
        }
*/


	
?>