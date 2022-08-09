<?php
include_once 'PHPExcel.php';
include_once 'PHPExcel/IOFactory.php';
//include_once('../../vcimsweb/init.php');

if(isset($_POST['submit']))
{
	 
        
        $sflag = 0 ;
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
		$connect = mysqli_connect("localhost","root","","vcims");
		if($connect){
			//echo "success";
		}
		else
		{
				die('connection fail'.mysqli_connect_error());
		}
		//include_once 'PHPExcel.php';
               
		$excel = PHPExcel_IOFactory::load($fileTmpName);
                

        

//set active sheet to first sheet 
		  $excel->setActiveSheetIndex(0); 
	foreach ($excel->getWorksheetIterator() as $worksheet) {

                
		  $highestRow = $worksheet->getHighestDataRow();
		  $highestColumn = $worksheet->getHighestColumn();
		  $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
                //////////////correct//////
		
		for ($row = 2; $row <= $highestRow; $row++)
		{
				$crespid = '';
				// first page insertion
				for($col = 0; $col < $highestColumnIndex; $col++)
				{
					$cell = $worksheet->getCellByColumnAndRow($col, $row);
					$val = $cell->getValue();
					
					$head = $worksheet->getCellByColumnAndRow($col,1);
					if($head=='Hindi' && $val != ''){
                                                
						$qid = $worksheet->getCellByColumnAndRow(0,$row);
						$type = $worksheet->getCellByColumnAndRow(1,$row);
						$translation = $worksheet->getCellByColumnAndRow($col,$row);
						if($type == 'q'){
							$query = "select * from hindi_question_detail where q_id='".$qid."'";
							$check = mysqli_query($connect,$query);
							$exist = mysqli_num_rows($check);
							if($exist==0)
							{
							$tqquery = "insert into hindi_question_detail (q_id,q_title) VALUES ('$qid','$translation')";
							//echo 'hindi =>'.$tqquery.'<br>';
							$hit = mysqli_query($connect,$tqquery);
							$sflag=1;
							}
							else{ $sflag = 2;
								continue ;
							}
						}
						else {
							$val = $worksheet->getCellByColumnAndRow(3,$row);
							$query = "select * from hindi_question_option_detail where q_id=$qid AND code = $val ;";
                                                        $check = mysqli_query($connect,$query);
                                                        $exist = mysqli_num_rows($check);

							if($exist == 0)
							{
							$val = $worksheet->getCellByColumnAndRow(3,$row);
							$toquery = "insert into hindi_question_option_detail (q_id,opt_text_value,code) VALUES ($qid,'$translation','$val')";
							$sflag =1;
							$hit = mysqli_query($connect,$toquery);
							}
							else{	$sflag=2;
								continue ;
							}
						}
					}

					if($head=='Kannad' && $val != ''){
								$qid = $worksheet->getCellByColumnAndRow(0,$row);
						$type = $worksheet->getCellByColumnAndRow(1,$row);
						$translation = $worksheet->getCellByColumnAndRow($col,$row);
						if($type == 'q'){
							$query = "select * from kannar_question_detail where q_id='".$qid."'";
							$check = mysqli_query($connect,$query);
							$exist = mysqli_num_rows($check);
							if($exist==0)
							{
							$tqquery = "insert into kannar_question_detail (q_id,q_title) VALUES ($qid,'$translation')";
							$sflag=1;
							$hit = mysqli_query($connect,$tqquery);
							}
							else{ 	$sflag=2;
								continue ;
							}
						}
						else {
							$val = $worksheet->getCellByColumnAndRow(3,$row);
							$query = "select * from kannar_question_option_detail where q_id=$qid  AND code = $val ;";
							$check = mysqli_query($connect,$query);
							$exist = mysqli_num_rows($check);
							if($exist==0)
							{
							$val = $worksheet->getCellByColumnAndRow(3,$row);
							$toquery = "insert into kannar_question_option_detail (q_id,opt_text_value,code) VALUES ('$qid','$translation','$val')";
							$sflag = 1;
							$hit = mysqli_query($connect,$toquery);
							}
							else{	$sflag =2;
								continue ;
							}
						} //end of else
					} //end if of kannar
                                        if($head=='Malyalam' && $val != ''){
                                                $qid = $worksheet->getCellByColumnAndRow(0,$row);
                                                $type = $worksheet->getCellByColumnAndRow(1,$row);
                                                $translation = $worksheet->getCellByColumnAndRow($col,$row);
                                                if($type == 'q'){
                                                        $query = "select * from malyalam_question_detail where q_id='".$qid."'";
                                                        $check = mysqli_query($connect,$query);
                                                        $exist = mysqli_num_rows($check);
                                                        if($exist==0)
                                                        {
                                                        	$tqquery = "insert into malyalam_question_detail (q_id,q_title) VALUES ($qid,'$translation')";
                                                        	$sflag = 1;
                                                        	$hit = mysqli_query($connect,$tqquery);
                                                        }
                                                        else{	 
								$sflag = 2;
                                                                continue ;
                                                        }

                                                }
                                                else {
                                                        $val = $worksheet->getCellByColumnAndRow(3,$row);
                                                        $query = "select * from malyalam_question_option_detail where q_id= $qid  AND code = $val ;";
                                                        $check = mysqli_query($connect,$query);
                                                        $exist = mysqli_num_rows($check);
                                                        if($exist==0)
                                                        {
                                                        $val = $worksheet->getCellByColumnAndRow(3,$row);
                                                        $toquery = "insert into malyalam_question_option_detail (q_id,opt_text_value,code) VALUES ($qid,'$translation','$val')";
                                                        $sflag = 1;
                                                        $hit = mysqli_query($connect,$toquery);
                                                        }
                                                        else{	 $sflag = 2;
                                                                continue ;
                                                        }
                                                } //end of else
                                        } //end if of Malyalam

                                        if($head=='Tammil' && $val != ''){
                                                $qid = $worksheet->getCellByColumnAndRow(0,$row);
                                                $type = $worksheet->getCellByColumnAndRow(1,$row);
                                                $translation = $worksheet->getCellByColumnAndRow($col,$row);
                                                if($type == 'q'){
                                                        $query = "select * from tammil_question_detail where q_id='".$qid."'";
                                                        $check = mysqli_query($connect,$query);
                                                        $exist = mysqli_num_rows($check);
                                                        if($exist==0)
                                                        {
                                                        	$tqquery = "insert into tammil_question_detail (q_id,q_title) VALUES ($qid,'$translation')";
                                                        	$sflag = 1;
                                                        	$hit = mysqli_query($connect,$tqquery);
                                                        }
                                                        else{	 
								$sflag = 2;
                                                                continue ;
                                                        }

                                                }
                                                else {
                                                        $val = $worksheet->getCellByColumnAndRow(3,$row);
                                                        $query = "select * from tammil_question_option_detail where q_id= $qid  AND code = $val ;";
                                                        $check = mysqli_query($connect,$query);
                                                        $exist = mysqli_num_rows($check);
                                                        if($exist==0)
                                                        {
                                                        $val = $worksheet->getCellByColumnAndRow(3,$row);
                                                        $toquery = "insert into tammil_question_option_detail (q_id,opt_text_value,code) VALUES ($qid,'$translation','$val')";
                                                        $sflag = 1;
                                                        $hit = mysqli_query($connect,$toquery);
                                                        }
                                                        else{	 $sflag = 2;
                                                                continue ;
                                                        }
                                                } //end of else
                                        } //end if of Tammil

                                        if($head=='Telgu' && $val != ''){
                                                $qid = $worksheet->getCellByColumnAndRow(0,$row);
                                                $type = $worksheet->getCellByColumnAndRow(1,$row);
                                                $translation = $worksheet->getCellByColumnAndRow($col,$row);
                                                if($type == 'q'){
                                                        $query = "select * from telgu_question_detail where q_id='".$qid."'";
                                                        $check = mysqli_query($connect,$query);
                                                        $exist = mysqli_num_rows($check);
                                                        if($exist==0)
                                                        {
                                                        	$tqquery = "insert into telgu_question_detail (q_id,q_title) VALUES ($qid,'$translation')";
                                                        	$sflag = 1;
                                                        	$hit = mysqli_query($connect,$tqquery);
                                                        }
                                                        else{	 
								$sflag = 2;
                                                                continue ;
                                                        }

                                                }
                                                else {
                                                        $val = $worksheet->getCellByColumnAndRow(3,$row);
                                                        $query = "select * from telgu_question_option_detail where q_id= $qid  AND code = $val ;";
                                                        $check = mysqli_query($connect,$query);
                                                        $exist = mysqli_num_rows($check);
                                                        if($exist==0)
                                                        {
                                                        $val = $worksheet->getCellByColumnAndRow(3,$row);
                                                        $toquery = "insert into telgu_question_option_detail (q_id,opt_text_value,code) VALUES ($qid,'$translation','$val')";
                                                        $sflag = 1;
                                                        $hit = mysqli_query($connect,$toquery);
                                                        }
                                                        else{	 $sflag = 2;
                                                                continue ;
                                                        }
                                                } //end of else
                                        } //end if of Telgu
                                        if($head=='Bangla' && $val != ''){
                                                $qid = $worksheet->getCellByColumnAndRow(0,$row);
                                                $type = $worksheet->getCellByColumnAndRow(1,$row);
                                                $translation = $worksheet->getCellByColumnAndRow($col,$row);
                                                if($type == 'q'){
                                                        $query = "select * from bengali_question_detail where q_id='".$qid."'";
                                                        $check = mysqli_query($connect,$query);
                                                        $exist = mysqli_num_rows($check);
                                                        if($exist==0)
                                                        {
                                                        	$tqquery = "insert into bengali_question_detail (q_id,q_title) VALUES ($qid,'$translation')";
                                                        	$sflag = 1;
                                                        	$hit = mysqli_query($connect,$tqquery);
                                                        }
                                                        else{	 
								$sflag = 2;
                                                                continue ;
                                                        }

                                                }
                                                else {
                                                        $val = $worksheet->getCellByColumnAndRow(3,$row);
                                                        $query = "select * from bengali_question_option_detail where q_id= $qid  AND code = $val ;";
                                                        $check = mysqli_query($connect,$query);
                                                        $exist = mysqli_num_rows($check);
                                                        if($exist==0)
                                                        {
                                                        $val = $worksheet->getCellByColumnAndRow(3,$row);
                                                        $toquery = "insert into bengali_question_option_detail (q_id,opt_text_value,code) VALUES ($qid,'$translation','$val')";
                                                        $sflag = 1;
                                                        $hit = mysqli_query($connect,$toquery);
                                                        }
                                                        else{	 
								$sflag = 2;
                                                                continue ;
                                                        }
                                                } //end of else
                                        } //end if of Bangla
                                        if($head=='Odia' && $val != ''){
                                                $qid = $worksheet->getCellByColumnAndRow(0,$row);
                                                $type = $worksheet->getCellByColumnAndRow(1,$row);
                                                $translation = $worksheet->getCellByColumnAndRow($col,$row);
                                                if($type == 'q'){
                                                        $query = "select * from odia_question_detail where q_id='".$qid."'";
                                                        $check = mysqli_query($connect,$query);
                                                        $exist = mysqli_num_rows($check);
                                                        if($exist==0)
                                                        {
                                                        	$tqquery = "insert into odia_question_detail (q_id,q_title) VALUES ($qid,'$translation')";
                                                        	$sflag = 1;
                                                        	$hit = mysqli_query($connect,$tqquery);
                                                        }
                                                        else{	 
								$sflag = 2;
                                                                continue ;
                                                        }

                                                }
                                                else {
                                                        $val = $worksheet->getCellByColumnAndRow(3,$row);
                                                        $query = "select * from odia_question_option_detail where q_id= $qid  AND code = $val ;";
                                                        $check = mysqli_query($connect,$query);
                                                        $exist = mysqli_num_rows($check);
                                                        if($exist==0)
                                                        {
                                                        $val = $worksheet->getCellByColumnAndRow(3,$row);
                                                        $toquery = "insert into odia_question_option_detail (q_id,opt_text_value,code) VALUES ($qid,'$translation','$val')";
                                                        $sflag = 1;
                                                        $hit = mysqli_query($connect,$toquery);
                                                        }
                                                        else{	 
								$sflag = 2;
                                                                continue ;
                                                        }
                                                } //end of else
                                        } //end if of Odia
                                        if($head=='Gujrati' && $val != ''){
                                                $qid = $worksheet->getCellByColumnAndRow(0,$row);
                                                $type = $worksheet->getCellByColumnAndRow(1,$row);
                                                $translation = $worksheet->getCellByColumnAndRow($col,$row);
                                                if($type == 'q'){
                                                        $query = "select * from gujrati_question_detail where q_id='".$qid."'";
                                                        $check = mysqli_query($connect,$query);
                                                        $exist = mysqli_num_rows($check);
                                                        if($exist==0)
                                                        {
                                                        	$tqquery = "insert into gujrati_question_detail (q_id,q_title) VALUES ($qid,'$translation')";
                                                        	$sflag = 1;
                                                        	$hit = mysqli_query($connect,$tqquery);
                                                        }
                                                        else{	 
								$sflag = 2;
                                                                continue ;
                                                        }
                                                }
                                                else {
                                                        $val = $worksheet->getCellByColumnAndRow(3,$row);
                                                        $query = "select * from gujrati_question_option_detail where q_id= $qid  AND code = $val ;";
                                                        $check = mysqli_query($connect,$query);
                                                        $exist = mysqli_num_rows($check);
                                                        if($exist==0)
                                                        {
                                                        $val = $worksheet->getCellByColumnAndRow(3,$row);
                                                        $toquery = "insert into gujrati_question_option_detail (q_id,opt_text_value,code) VALUES ($qid,'$translation','$val')";
                                                        $sflag = 1;
                                                        $hit = mysqli_query($connect,$toquery);
                                                        }
                                                        else{	 
								$sflag = 2;
                                                                continue ;
                                                        }
                                                } //end of else
                                        } //end if of Gujrati
                                        if($head=='Marathi' && $val != ''){
                                                $qid = $worksheet->getCellByColumnAndRow(0,$row);
                                                $type = $worksheet->getCellByColumnAndRow(1,$row);
                                                $translation = $worksheet->getCellByColumnAndRow($col,$row);
                                                if($type == 'q'){
                                                        $query = "select * from marathi_question_detail where q_id='".$qid."'";
                                                        $check = mysqli_query($connect,$query);
                                                        $exist = mysqli_num_rows($check);
                                                        if($exist==0)
                                                        {
                                                        	$tqquery = "insert into marathi_question_detail (q_id,q_title) VALUES ($qid,'$translation')";
                                                        	$sflag = 1;
                                                        	$hit = mysqli_query($connect,$tqquery);
                                                        }
                                                        else{	 
								$sflag = 2;
                                                                continue ;
                                                        }
                                                }
                                                else {
                                                        $val = $worksheet->getCellByColumnAndRow(3,$row);
                                                        $query = "select * from marathi_question_option_detail where q_id= $qid  AND code = $val ;";
                                                        $check = mysqli_query($connect,$query);
                                                        $exist = mysqli_num_rows($check);
                                                        if($exist==0)
                                                        {
                                                        $val = $worksheet->getCellByColumnAndRow(3,$row);
                                                        $toquery = "insert into marathi_question_option_detail (q_id,opt_text_value,code) VALUES ($qid,'$translation','$val')";
                                                        $sflag = 1;
                                                        $hit = mysqli_query($connect,$toquery);
                                                        }
                                                        else{	 
								$sflag = 2;
                                                                continue ;
                                                        }
                                                } //end of else
                                        } //end if of Marathi
                                        if($head=='Asami' && $val != ''){
                                                $qid = $worksheet->getCellByColumnAndRow(0,$row);
                                                $type = $worksheet->getCellByColumnAndRow(1,$row);
                                                $translation = $worksheet->getCellByColumnAndRow($col,$row);
                                                if($type == 'q'){
                                                        $query = "select * from asami_question_detail where q_id='".$qid."'";
                                                        $check = mysqli_query($connect,$query);
                                                        $exist = mysqli_num_rows($check);
                                                        if($exist==0)
                                                        {
                                                        	$tqquery = "insert into asami_question_detail (q_id,q_title) VALUES ($qid,'$translation')";
                                                        	$sflag = 1;
                                                        	$hit = mysqli_query($connect,$tqquery);
                                                        }
                                                        else{	 
								$sflag = 2;
                                                                continue ;
                                                        }
                                                }
                                                else {
                                                        $val = $worksheet->getCellByColumnAndRow(3,$row);
                                                        $query = "select * from asami_question_option_detail where q_id= $qid  AND code = $val ;";
                                                        $check = mysqli_query($connect,$query);
                                                        $exist = mysqli_num_rows($check);
                                                        if($exist==0)
                                                        {
                                                        $val = $worksheet->getCellByColumnAndRow(3,$row);
                                                        $toquery = "insert into asami_question_option_detail (q_id,opt_text_value,code) VALUES ($qid,'$translation','$val'')";
                                                        $sflag = 1;
                                                        $hit = mysqli_query($connect,$toquery);
                                                        }
                                                        else{	 
								$sflag = 2;
                                                                continue ;
                                                        }
                                                } //end of else
                                        } //end if of Asami


				} //end of loop col
			} //end of loop row
			} //end of loop
		} //end of else
	//print status
	if($sflag == 0) echo "Error! Not uploaded, Please check format correctly";
        if($sflag == 1) echo "Uploaded Translation Sucessfully";
        if($sflag == 2) echo "Uploaded Translation of some question options  already available in database"; 
} //end of submit

?>
