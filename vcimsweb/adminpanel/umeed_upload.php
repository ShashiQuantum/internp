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
                       $i=0;
                            
                        while(($fv = fgetcsv($handle, 1000, ",")) !== false)
                        {
                         
                            if($ch2=='y')
                                {
                                    if($i>0)
                                    {
                              // $vv=$fv[0];     
                $f1=$fv[1];$f2=$fv[2];$f3=$fv[3];$f4=$fv[4];$f5=$fv[5];$f6=$fv[6];$f7=$fv[7];$f8=$fv[8];$f9=$fv[9];$f10=$fv[10];
		$f11=$fv[11];$f12=$fv[12];$f13=$fv[13];$f14=$fv[14];$f15=$fv[15];$f16=$fv[16];$f17=$fv[17];$f18=$fv[18];$f19=$fv[19];$f20=$fv[20];
		$f21=$fv[21];$f22=$fv[22];$f23=$fv[23];$f24=$fv[24];$f25=$fv[25];$f26=$fv[26];$f27=$fv[27];$f28=$fv[28];$f29=$fv[29];$f30=$fv[30];
		$f31=$fv[31];$f32=$fv[32];$f33=$fv[33];$f34=$fv[34];$f35=$fv[35];$f36=$fv[36];$f37=$fv[37];$f38=$fv[38];$f39=$fv[39];$f40=$fv[40];      
		$f41=$fv[41];$f42=$fv[42];$f43=$fv[43];$f44=$fv[44];$f45=$fv[45];$f46=$fv[46];$f47=$fv[47];$f48=$fv[48];$f49=$fv[49];$f50=$fv[50];
		$f51=$fv[51];$f52=$fv[52];$f53=$fv[53];$f54=$fv[54];$f55=$fv[55];$f56=$fv[56];$f57=$fv[57];$f58=$fv[58];$f59=$fv[59];$f60=$fv[60];
		$f61=$fv[61];$f62=$fv[62];$f63=$fv[63];$f64=$fv[64];$f65=$fv[65];$f66=$fv[66];$f67=$fv[67];$f68=$fv[68];$f69=$fv[69];$f70=$fv[70];
		$f71=$fv[71];$f72=$fv[72];$f73=$fv[73];$f74=$fv[74];$f75=$fv[75];$f76=$fv[76];$f77=$fv[77];$f78=$fv[78];$f79=$fv[79];$f80=$fv[80];
		$f81=$fv[81];$f82=$fv[82];$f83=$fv[83];$f84=$fv[84];$f85=$fv[85];$f86=$fv[86];$f87=$fv[87];$f88=$fv[88];$f89=$fv[89];$f90=$fv[90];
		$f91=$fv[91];$f92=$fv[92];$f93=$fv[93];$f94=$fv[94];$f95=$fv[95];$f96=$fv[96];$f97=$fv[97];$f98=$fv[98];$f99=$fv[99];$f100=$fv[100];
		$f101=$fv[101];$f102=$fv[102];$f103=$fv[103];$f104=$fv[104];$f105=$fv[105];$f106=$fv[106];$f107=$fv[107];$f108=$fv[10];$f109=$fv[109];$f110=$fv[110];
		$f111=$fv[111];$f112=$fv[112];$f113=$fv[113];$f114=$fv[114];$f115=$fv[115];$f116=$fv[116];$f117=$fv[117];$f118=$fv[118];$f119=$fv[119];$f120=$fv[120];
		$f121=$fv[121];$f122=$fv[122];$f123=$fv[123];$f124=$fv[124];$f125=$fv[125];$f126=$fv[126];$f127=$fv[127];$f128=$fv[128];$f129=$fv[129];$f130=$fv[130];	
		$f131=$fv[131];$f132=$fv[132];$f133=$fv[133];$f134=$fv[134];$f135=$fv[135];$f136=$fv[136];$f137=$fv[137];$f138=$fv[138];$f139=$fv[139];$f140=$fv[140];
		$f141=$fv[141];$f142=$fv[142];$f143=$fv[143];

$dr='';
if($f31==2) $dr=3;
else if($f31==3) $dr=4;
else continue;
        echo '<br>'.$rr="UPDATE `UMEED_20` SET `eq3_20`='$dr'  WHERE  `eq3_20` !=  ''  AND resp_id=$f1";
         DB::getInstance()->query($rr);
       
       
/*
   ////echo $qqq1="INSERT INTO `m//DBooth_details`(`booth_id`,`aud_name`, `aud_mob`, `v_shift`, `centre`, `i_date`, `qset_id`, `status`) VALUES($f1,'$f2','$f3','$f5','$f6','$f4',20,1)";
      ////DB::getInstance()->query($qqq1);
   //echo '<br><br>:'.$f1;     
 //echo '<br>'. $qq03="INSERT INTO `UMEED_20`( q_id,`resp_id`, `visit_month_20`,`visit_shift_20`,centre_20,aq1_20,aq1a_20,aq2_20,aq4_20,bq0_20,bq1a_20,bq2_20,bq3_20,bq4_20,bq5_0_20,bq5_20,bq6_20,bq7_20,bq8_20,bq9_20,bq10_20,cq1_20,cq2_20,cq3_20,dq1_20, eq1_20,eq2_1_20,eq2_2_20,eq2_3_20,eq3_20) VALUES 
(20,$f1,'$f4','$f5','$f6','$f7','$f8','$f9','$f10','$f11','$f12','$f13','$f14','$f15','$f16','$f17','$f18','$f19','$f20','$f21','$f22','$f23','$f24','$f25','$f26','$f27','$f28','$f29','$f30','$f31')";
		 //DB::getInstance()->query($qq03);
*/
                if($f33==1)
                {            
			//echo '<br>'. $qq04="INSERT INTO `UMEED_20`( q_id,`resp_id`, `visit_month_20`, eq4_20) VALUES(20,$f1,'$f4','$f33')";
			//DB::getInstance()->query($qq04);
                }if($f34==2)
		{            
			//echo '<br>'. $qq05="INSERT INTO `UMEED_20`( q_id,`resp_id`,`visit_month_20`, eq4_20) VALUES(20,$f1,'$f4','$f34')";
			//DB::getInstance()->query($qq05);
		}if($f35==3)
		{	  
			//echo '<br>'. $qq06="INSERT INTO `UMEED_20`( q_id,`resp_id`,`visit_month_20`, eq4_20) VALUES(20,$f1,'$f4','$f35')";
			//DB::getInstance()->query($qq06);
		}if($f36==4)
		{	    
			//echo '<br>'. $qq07="INSERT INTO `UMEED_20`( q_id,`resp_id`,`visit_month_20`, eq4_20) VALUES(20,$f1,'$f4','$f36')";
			//DB::getInstance()->query($qq07);
		}if($f37==5)
		{	    
			//echo '<br>'. $qq08="INSERT INTO `UMEED_20`( q_id,`resp_id`,`visit_month_20`, eq4_20) VALUES(20,$f1,'$f4','$f37')";
			//DB::getInstance()->query($qq08);
		}if($f38==6)
		{	   
			//echo '<br>'. $qq09="INSERT INTO `UMEED_20`( q_id,`resp_id`,`visit_month_20`, eq4_20) VALUES(20,$f1,'$f4','$f38')";
			//DB::getInstance()->query($qq09);	
                }
                                
		//echo '<br>'. $qq1="INSERT INTO `UMEED_20`( q_id,`resp_id`,`visit_month_20`, eq5_20,eq6_20) VALUES(20,$f1,'$f4','$f39','$f40')";
		//DB::getInstance()->query($qq1);


		//echo '<br>'. $qq2="INSERT INTO `UMEED_20`( q_id,`resp_id`,`visit_month_20`, eq7_20) VALUES(20,$f1,'$f4','$f41')";
		//DB::getInstance()->query($qq2);

		//echo '<br>'. $qq3="INSERT INTO `UMEED_20`( q_id,`resp_id`,`visit_month_20`, fq1_20) VALUES(20,$f1,'$f4','$f42')";
		//DB::getInstance()->query($qq3);

		if($f44==1)
                {            
			//echo '<br>'. $qq04="INSERT INTO `UMEED_20`( q_id,`resp_id`,`visit_month_20`, fq2_20) VALUES(20,$f1,'$f4','$f44')";
			//DB::getInstance()->query($qq04);
                }if($f45==2)
		{            
			//echo '<br>'. $qq05="INSERT INTO `UMEED_20`( q_id,`resp_id`,`visit_month_20`, fq2_20) VALUES(20,$f1,'$f4','$f45')";
			//DB::getInstance()->query($qq05);
		}if($f46==3)
		{	  
			//echo '<br>'. $qq06="INSERT INTO `UMEED_20`( q_id,`resp_id`,`visit_month_20`, fq2_20) VALUES(20,$f1,'$f4','$f46')";
			//DB::getInstance()->query($qq06);
		}if($f47==4)
		{	    
			//echo '<br>'. $qq07="INSERT INTO `UMEED_20`( q_id,`resp_id`,`visit_month_20`, fq2_20) VALUES(20,$f1,'$f4','$f47')";
			//DB::getInstance()->query($qq07);
		}
		
		//echo '<br>'. $qq4="INSERT INTO `UMEED_20`( q_id,`resp_id`, `visit_month_20`,fq3_20,fq4_20,fq5_20) VALUES(20,$f1,'$f4','$f48','$f49','$f50')";
		//DB::getInstance()->query($qq4);
		
		if($f52==1)
                {            
			//echo '<br>'. $qq04="INSERT INTO `UMEED_20`( q_id,`resp_id`, `visit_month_20`,fq6_20) VALUES(20,$f1,'$f4','$f52')";
			//DB::getInstance()->query($qq04);
                }if($f53==2)
		{            
			//echo '<br>'. $qq05="INSERT INTO `UMEED_20`( q_id,`resp_id`,`visit_month_20`, fq6_20) VALUES(20,$f1,'$f4','$f53')";
			//DB::getInstance()->query($qq05);
		}if($f53==4)
		{	  
			//echo '<br>'. $qq06="INSERT INTO `UMEED_20`( q_id,`resp_id`,`visit_month_20`, fq6_20) VALUES(20,$f1,'$f4','$f54')";
			//DB::getInstance()->query($qq06);
		}

		//echo '<br>'. $qq07="INSERT INTO `UMEED_20`( q_id,`resp_id`,`visit_month_20`, fq7_20,fq8_20,fq8a_20) VALUES(20,$f1,'$f4','$f55','$f56','$f57')";
			//DB::getInstance()->query($qq07);
		
		if($f59==1)
                {            
			//echo '<br>'. $qq04="INSERT INTO `UMEED_20`( q_id,`resp_id`,`visit_month_20`, fq9_20) VALUES(20,$f1,'$f4','$f59')";
			//DB::getInstance()->query($qq04);
                }if($f60==2)
		{            
			//echo '<br>'. $qq05="INSERT INTO `UMEED_20`( q_id,`resp_id`,`visit_month_20`, fq9_20) VALUES(20,$f1,'$f4','$f60')";
			//DB::getInstance()->query($qq05);
		}if($f61==3)
		{	  
			//echo '<br>'. $qq06="INSERT INTO `UMEED_20`( q_id,`resp_id`,`visit_month_20`, fq9_20) VALUES(20,$f1,'$f4','$f61')";
			//DB::getInstance()->query($qq06);
		}if($f62==4)
		{	    
			//echo '<br>'. $qq07="INSERT INTO `UMEED_20`( q_id,`resp_id`,`visit_month_20`, fq9_20) VALUES(20,$f1,'$f4','$f62')";
			//DB::getInstance()->query($qq07);
		}
		
                //echo '<br>'. $qq08="INSERT INTO `UMEED_20`( q_id,`resp_id`,`visit_month_20`, fq10_20,fq11_20,fq11a_20) VALUES(20,$f1,'$f4','$f63','$f64','$f65')";
			//DB::getInstance()->query($qq08);
		if($f67==1)
                {            
			//echo '<br>'. $qq04="INSERT INTO `UMEED_20`( q_id,`resp_id`,`visit_month_20`, fq12_20) VALUES(20,$f1,'$f4','$f67')";
			//DB::getInstance()->query($qq04);
                }if($f68==2)
		{            
			//echo '<br>'. $qq05="INSERT INTO `UMEED_20`( q_id,`resp_id`,`visit_month_20`, fq12_20) VALUES(20,$f1,'$f4','$f68')";
			//DB::getInstance()->query($qq05);
		}if($f69==3)
		{	  
			//echo '<br>'. $qq06="INSERT INTO `UMEED_20`( q_id,`resp_id`,`visit_month_20`, fq12_20) VALUES(20,$f1,'$f4','$f69')";
			//DB::getInstance()->query($qq06);
		}if($f70==4)
		{	    
			//echo '<br>'. $qq07="INSERT INTO `UMEED_20`( q_id,`resp_id`,`visit_month_20`, fq12_20) VALUES(20,$f1,'$f4','$f70')";
			//DB::getInstance()->query($qq07);
		}

		//echo '<br>'. $qq08="INSERT INTO `UMEED_20`( q_id,`resp_id`,`visit_month_20`, fq13_20,fq14_20,fq15_20) VALUES(20,$f1,'$f4','$f71','$f72','$f73')";
			//DB::getInstance()->query($qq08);
		if($f75==1)
                {            
			//echo '<br>'. $qq04="INSERT INTO `UMEED_20`( q_id,`resp_id`, `visit_month_20`,fq16_20) VALUES(20,$f1,'$f4','$f75')";
			//DB::getInstance()->query($qq04);
                }if($f76==2)
		{            
			//echo '<br>'. $qq05="INSERT INTO `UMEED_20`( q_id,`resp_id`,`visit_month_20`, fq16_20) VALUES(20,$f1,'$f4','$f76')";
			//DB::getInstance()->query($qq05);
		}if($f77==3)
		{	  
			//echo '<br>'. $qq06="INSERT INTO `UMEED_20`( q_id,`resp_id`,`visit_month_20`, fq16_20) VALUES(20,$f1,'$f4','$f77')";
			//DB::getInstance()->query($qq06);
		}
		
		//echo '<br>'. $qq08="INSERT INTO `UMEED_20`( q_id,`resp_id`, `visit_month_20`,fq17_20,fq18_20,fq19_20,fq20_20) VALUES(20,$f1,'$f4','$f78','$f79','$f80','$f81')";
			//DB::getInstance()->query($qq08);		
		if($f83==1)
                {            
			//echo '<br>'. $qq04="INSERT INTO `UMEED_20`( q_id,`resp_id`, `visit_month_20`,fq21_20) VALUES(20,$f1,'$f4','$f83')";
			//DB::getInstance()->query($qq04);
                }if($f84==2)
		{            
			//echo '<br>'. $qq05="INSERT INTO `UMEED_20`( q_id,`resp_id`,`visit_month_20`, fq21_20) VALUES(20,$f1,'$f4','$f84')";
			//DB::getInstance()->query($qq05);
		}if($f85==3)
		{	  
			//echo '<br>'. $qq06="INSERT INTO `UMEED_20`( q_id,`resp_id`,`visit_month_20`, fq21_20) VALUES(20,$f1,'$f4','$f85')";
			//DB::getInstance()->query($qq06);
		}

		//echo '<br>'. $qq08="INSERT INTO `UMEED_20`( q_id,`resp_id`, `visit_month_20`,fq22_20,fq23_20,fq24_20,fq25_20,fq26_20,fq27_20,fq28_20,fq29_1_20,fq29_2_20,fq29_3_20,fq29_4_20,fq29_5_20,fq30_1_20,fq30_2_20,fq30_3_20,fq30_4_20,fq30_5_20,fq31_20,fq32_20) VALUES(20,$f1,'$f4','$f86','$f87','$f88','$f89','$f90','$f91','$f92','$f93','$f94','$f95','$f96','$f97','$f98','$f99','$f100','$f101','$f102','$f103','$f104')";
			//DB::getInstance()->query($qq08);

		if($f106==1)
                {            
			//echo '<br>'. $qq04="INSERT INTO `UMEED_20`( q_id,`resp_id`,`visit_month_20`, fq33_20) VALUES(20,$f1,'$f4','$f106')";
			//DB::getInstance()->query($qq04);
                }if($f107==2)
		{            
			//echo '<br>'. $qq05="INSERT INTO `UMEED_20`( q_id,`resp_id`, `visit_month_20`,fq33_20) VALUES(20,$f1,'$f4','$f107')";
			//DB::getInstance()->query($qq05);
		}if($f108==3)
		{	  
			//echo '<br>'. $qq06="INSERT INTO `UMEED_20`( q_id,`resp_id`,`visit_month_20`, fq33_20) VALUES(20,$f1,'$f4','$f108')";
			//DB::getInstance()->query($qq06);
		}

		/*	//echo '<br>'. $qq09="INSERT INTO `UMEED_20`( q_id,`resp_id`, `visit_month_20`,fq34_20,fq35_1_20,fq36_1_20,fq37_1_20,fq38_1_20,fq39_1_20,fq40_1_20,fq42_1_20,fq35_2_20,fq36_2_20,fq37_2_20,fq38_2_20,fq39_2_20,fq40_2_20,fq42_2_20,fq35_3_20,fq36_3_20,fq37_3_20,fq38_3_20,fq39_3_20,fq40_3_20,fq41_3_20,fq35_4_20,fq37_4_20,fq38_4_20,fq40_4_20,fq44_4_20,fq35_5_20,fq36_5_20,fq37_5_20,fq38_5_20,fq39_5_20,fq40_5_20,fq41_5_20,fq42_5_20) VALUES(20,$f1,'$f4','$f109','$f110','$f111','$f112','$f113','$f114','$f115','$f116','$f117','$f118','$f119','$f120','$f121','$f122','$f123','$f124','$f125','$f126','$f127','$f128','$f129','$f130','$f131','$f132','$f133','$f134','$f135','$f136','$f137','$f138','$f139','$f140','$f141','$f142','$f143')";
			//DB::getInstance()->query($qq09);
 */
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