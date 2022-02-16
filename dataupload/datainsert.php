<?php
//include_once('../vcimsweb/init.php');
//include 'PHPExcel.php';
$ptable =  $_SESSION['cttable'];
$pid = $_SESSION['ctpid'];

if(isset($_POST['submit']))
{
	$filename = $_FILES['myfile']['name'];
	$fileTmpName = $_FILES['myfile']['tmp_name'];
	$fileExtension = pathinfo($filename,PATHINFO_EXTENSION);
	$allowedType = array('xlsx','xls') ;
	
	// check extension is allowed or not 
	if(!in_array($fileExtension,$allowedType)){
		echo 'Invalid Extension';
	}
	else{
		// connection establish to db
		$connect = mysqli_connect("database-1.c1mggasso0hp.ap-south-1.rds.amazonaws.com","qcsrdsadmin","Pa7du#ah$098","vcims");
		if($connect){
			echo "Data Uploaded Successfully <br>";
			}
			else
			{
				die('connection fail'.mysqli_connect_error());
			}
		include 'PHPExcel.php';
		$excel = PHPExcel_IOFactory::load($fileTmpName);

//set active sheet to first sheet
$excel->setActiveSheetIndex(0);

foreach ($excel->getWorksheetIterator() as $worksheet) {
		  $highestRow = $worksheet->getHighestDataRow();
		  $highestColumn = $worksheet->getHighestColumn();
		  $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
		  
		  for ($row = 2; $row <= $highestRow; $row++)
			{
				$crespid = '';
				// first page insertion
				/*
				for($col = 0; $col < 4; $col++)
				{
					$cell = $worksheet->getCellByColumnAndRow($col, $row);
					$val = $cell->getValue();
					$head = $worksheet->getCellByColumnAndRow($col,1);
					if($head=='Resp_id'){
						$crespid = $val;
						$query = "select * from $ptable where resp_id='".$val."'";
						$check = mysqli_query($connect,$query);
						$exist = mysqli_num_rows($check);
						if($exist==0)
						{
							 $iquery = "insert into $ptable (resp_id,q_id) VALUES (' $val ', $pid)";
							 $hit = mysqli_query($connect,$iquery);
					//echo "<br> $iquery ";

						}
						else{
							$col = 4;
							//continue;
						}

					}
					else
					{
						if($val != ''){
							$uquery = "UPDATE $ptable SET ".$head."='".$val."' WHERE resp_id='".$crespid."'";
							$uhit = mysqli_query($connect,$uquery);
						}
					}
				} //end of for loop
				*/
					$crespid='';$respid=''; $qset=$pid; $rname='';$mobile=''; $centre='';
                                        $cell = $worksheet->getCellByColumnAndRow(1, $row);
                                        $crespid = $respid = $cell->getValue();

                                        $cel3 = $worksheet->getCellByColumnAndRow(3, $row);
                                        $rname = $cel3->getValue();

                                        $cel4 = $worksheet->getCellByColumnAndRow(4, $row);
                                        $mobile = $cel4->getValue();

                                        $cel5 = $worksheet->getCellByColumnAndRow(5, $row);
                                        $centre = $cel5->getValue();

                                                $query = "select * from $ptable where resp_id='".$respid."'";
                                                $check = mysqli_query($connect,$query);
                                                $exist = mysqli_num_rows($check);
                                                if($exist==0)
                                                {
                                                        $iquery = "insert into $ptable (resp_id,q_id,r_name,mobile,centre) VALUES (' $respid ', $pid, '$rname','$mobile','$centre')";
                                                         $hit = mysqli_query($connect,$iquery);
                                        //echo "<br> $iquery ";

                                                }
                                                else{
                                                       // $col = 4;
                                                        continue;
                                                }

				//end first page
				//insert Answer data
				for($acol = 6; $acol < $highestColumnIndex; $acol++){
					$cell = $worksheet->getCellByColumnAndRow($acol, $row);
					$val = $cell->getValue();
					$head = $worksheet->getCellByColumnAndRow($acol,1);
					$bhead = explode("_",$head);
					$headsize = sizeof($bhead);
					
					
					if($headsize >2){
					if($bhead[2] != 't'){
						$qid = $bhead[0];
						$colum = $qid .'_'.$bhead[1];
						// code for checkbox
						if($val != ''){
						$ckiquery = "insert into $ptable (resp_id,q_id,".$colum.") VALUES ('".$crespid."',$pid,'".$val."')";
						$hit = mysqli_query($connect,$ckiquery);
						}
					
						
					}
					else{
						// timestamp insert
						$iquery = "insert into $ptable (resp_id,q_id,".$head.") VALUES ('".$crespid."', $pid ,'".$val."')";
						//$hit = mysqli_query($connect,$iquery);
							//echo "time query =>".$iquery."<br>";
						
						
					}
					}
					else{
						//all other type answer
						if($val != ''){
						$iquery = "insert into $ptable (resp_id,q_id,".$head.") VALUES ('".$crespid."',$pid,'".$val."')";
						$hit = mysqli_query($connect,$iquery);
						}
						
					}
			
				}
				
			}

   
			}
			
		}
}

?>
