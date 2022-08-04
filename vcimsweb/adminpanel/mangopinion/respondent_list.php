<?php
include_once('../../init.php');
include_once('../../functions.php');
include_once('../../gcm/send_message.php');
include_once('../../gcm/GCM.php');
include_once('../../gcm/config.php');

?>

<!DOCTYPE html>
<head><title>Filter List</title>
<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>


<script type="text/javascript">
$(document).ready(function(){ 
    
   $("#checkAll").change(function () {  
   $('input:checkbox').prop('checked', this.checked); 
});

});
</script>
</head><body>

<?php 	
   
   if(isset($_POST['get_project']))
   {    
	
	$searchFlag =0;
	$originData = $_POST;
	$arraySize = count($originData);
	
	
	///////////////////////////// IF PROFILERS SECTION CHOOSE//////////////////////////////////
	if($arraySize > 2)
	{   //  IF PROFILER IS SELECTED OR OPTED START
		 $searchFlag =1;
		array_pop($originData);
		array_pop($originData);
		
		$surveyId  =0; $projectarray = array(); $datatableID =array(); $userID = array();
		

		foreach($originData as $key => $var1)
		{
			$tremName =	explode("_",$key);
		    $projId= $tremName['1'];
			$projectarray[] = $projId;
		}
		$datatableID= array_unique($projectarray);
		$datatableID = array_values($datatableID);
		


		
		foreach($datatableID as $mkey =>$mpval){ // HOW MANY TABLE IS USED //START
			$data=DB::getInstance()->query("select data_table from project where project_id = $mpval");
			if($data->count()>0)
			foreach($data->results() as $dtName)
			{
			 $TableName= $dtName->data_table;	
			}



			$OneProfArry = array();	
			foreach($datafilter as $ikey => $ivar)
			{ //TERM AND THEIR VALUES FRO ONE PROFILER TABLE // START

				$tremName =	explode("_",$ikey);
		        $projId= $tremName['1'];
				if($projId==$mpval)
				{
					$OneProfArry[$ikey] = $ivar;
				}

			}//TERM AND THEIR VALUES FRO ONE PROFILER TABLE// END
			
			$QryTrem = array(); $QryGCanct =array(); $QryFindInOr =array(); $QryFindInAnd=array();
			
		
			$ProfSize = count($OneProfArry); 
			$lopCunt = 1;
			 
			
			
			 foreach($OneProfArry as $termKey => $termVal){   //MAKING FINAL QUERY //START
				
				$QryTrem[] = "$termKey";
				$QryGCanct[] = " GROUP_CONCAT( $termKey ) as $termKey  ";    
				

/////////////////////////////////////////CREATE IF ARRAY SIZE IS ONLY ONE ////////////////////////////////

				if($lopCunt ==1 &&  $ProfSize > 1){  ////////start first statement
					$termLopCunt =1;
					if(is_array($termVal))
					{	
						$TermValLen = count($termVal);

						foreach($termVal as $termValRep){
							if( $TermValLen == 1 )
							{
							$QryFindInOr[] =" FIND_IN_SET($termValRep,$termKey)  ";	
							}
							if($TermValLen > 1 && $termLopCunt == 1 )
							{
								$QryFindInOr[]	="  FIND_IN_SET($termValRep,$termKey) OR ";
							}
							if($TermValLen > 1 && $termLopCunt > 1 && $termLopCunt < $TermValLen  )
							{
								$QryFindInOr[]	="  FIND_IN_SET($termValRep,$termKey)  OR ";
							}
							if($TermValLen > 1 && $termLopCunt > 1 && $termLopCunt == $TermValLen  )
							{
								$QryFindInOr[]	="  FIND_IN_SET($termValRep,$termKey)  ";
							}
						$termLopCunt++;
		
						}
						
					} else{
					
						$QryFindInAnd[]	="  FIND_IN_SET($termVal,$termKey) AND  ";	 
						
					}   
				}//////end first statement


				if($lopCunt <  $ProfSize  && $lopCunt  > 1){  ////////start middle  statement
					$termLopCunt =1;
					if(is_array($termVal))
					{	
						$TermValLen = count($termVal);

						foreach($termVal as $termValRep){
							if( $TermValLen == 1 )
							{
							$QryFindInOr[] =" FIND_IN_SET($termValRep,$termKey)  ";	
							}
							if($TermValLen > 1 && $termLopCunt == 1 )
							{
								$QryFindInOr[]	="  FIND_IN_SET($termValRep,$termKey) OR ";
							}
							if($TermValLen > 1 && $termLopCunt > 1 && $termLopCunt < $TermValLen  )
							{
								$QryFindInOr[]	="  FIND_IN_SET($termValRep,$termKey)  OR ";
							}
							if($TermValLen > 1 && $termLopCunt > 1 && $termLopCunt == $TermValLen  )
							{
								$QryFindInOr[]	="  FIND_IN_SET($termValRep,$termKey)  ";
							}
						$termLopCunt++;
		
						}
						
					} else{
					
						$QryFindInAnd[]	="  FIND_IN_SET($termVal,$termKey) AND  ";	 
						
					}   
				}//////end middle statement


				if($lopCunt ==  $ProfSize){  ////////start Last  statement
					$termLopCunt =1;
					if(is_array($termVal))
					{	
						$TermValLen = count($termVal);

						foreach($termVal as $termValRep){
							if( $TermValLen == 1 )
							{
							$QryFindInOr[] =" FIND_IN_SET($termValRep,$termKey)  ";	
							}
							if($TermValLen > 1 && $termLopCunt == 1 )
							{
								$QryFindInOr[]	="  FIND_IN_SET($termValRep,$termKey) OR ";
							}
							if($TermValLen > 1 && $termLopCunt > 1 && $termLopCunt < $TermValLen  )
							{
								$QryFindInOr[]	="  FIND_IN_SET($termValRep,$termKey)  OR ";
							}
							if($TermValLen > 1 && $termLopCunt > 1 && $termLopCunt == $TermValLen  )
							{
								$QryFindInOr[]	="  FIND_IN_SET($termValRep,$termKey)  ";
							}
						$termLopCunt++;
		
						}
						
					} else{
					
						$QryFindInAnd[]	="  FIND_IN_SET($termVal,$termKey)   ";	 
						
					}   
				}//////end last statement

				$lopCunt++;

			} //MAKING FINAL QUERY //END

					///////////////////////////////////MAKING QUERY ////////////////////////////////
					$profQry ="  SELECT resp_id";
					foreach($dyArray as  $askey => $asaskeyValues)
					{
						$profQry .=", $askey  ";
					}
					$profQry .=" from  (SELECT resp_id  ";

					foreach($arrGCT as $arrGCTval)
					{   
						$profQry .=" , $arrGCTval ";

					}
					$profQry .=" FROM $TableName GROUP BY resp_id) as T WHERE ";

					$arrlen =count($arrFIS);
					$ltt= 1;
					foreach($arrFIS as $arrFISval)
					{
						if($ltt  < $arrlen ) $profQry .=" $arrFISval  ";
						
						if($ltt  ==  $arrlen ) $profQry .=" $arrFISval ";

						$ltt++;

					}

		/////////////////////////////////////// MAKING QUERY END//////////////			
				
				
				
			

			 

			$arrayInQry[] =$profQry;

			
		} // HOW MANY TABLE IS USED //END
		








		foreach($arrayInQry as $resltKey => $resultVal){ //////////  fetching ids start////////////

			

			$dataRESIDS=DB::getInstance()->query($resultVal);
			 if($dataRESIDS->count()>0)
		              {
					 foreach($dataRESIDS->results() as $RstIDS)
					 {
						$userIdArray[]=	 $RstIDS->resp_id;
						
						
									}
						}


		} ////////////////////////////////  fetching ids end/////////////
		
		
		    $userIdArray = array_unique($userIdArray);
			$userIdArray = array_values($userIdArray);

			 $List = implode(', ', $userIdArray);

		

		













	// 	foreach($datafilter as $key => $var1){  ///////////////////FIRST--PRIFILERS---FOREACH--START///////////

    //     ///////////////////////////////////// FIND DATA TABLE ///////////////////////////////////
	// 	$tremName =	explode("_",$key);
	// 	$projId= $tremName['1'];

	// 	 if($projId != $surveyId)
	// 	{ //IF TABLE IS DIFFERENT CONDITION START
	// 		$sQuery[]=	$profQry;
			

	// 		$surveyId = $projId;
		

	// 	$profQry ="select resp_id from ";
	// 	$data=DB::getInstance()->query("select data_table from project where project_id = $projId");
	// 	if($data->count()>0)
	// 	foreach($data->results() as $dtName)
	// 	{
	// 	 $dataTable= $dtName->data_table;
	// 	 $profQry .=" $dataTable";
		 
	// 	}
	// 	//////////////////////////////////// FIND DATA TABLE ENDED////////////////////////////
		
	// 	$profQry .=" where  $key = ";
		  
	// 	 $tt =1;
	// 	if(is_array($var1))
	// 	{	
	// 		$arrLen = count($var1);
	// 		foreach($var1 as $temval){
	// 			if( $tt < $arrLen ){
	// 			$profQry .="  $temval or $key = ";	
	// 			}if($tt == $arrLen ){
	// 				$profQry .="  $temval ";
	// 			}
				
	// 			$tt++;	
	// 		}
	// 	} else{
		
	// 	$profQry .=" $var1";	 
			
			
	// 	}   
		
	//  } // IF TABLE IS DIFFERENT CONDITION  END	

	//  else{          //  one term end now new term start;
		
	// 	$profQry .="  AND $key = ";
	  
	//  $tt =1;
	// if(is_array($var1))
	// {	
	// 	$arrLen = count($var1);
	// 	foreach($var1 as $temval){
	// 		if( $tt < $arrLen ){
	// 		$profQry .="  $temval or $key = ";	
	// 		}if($tt == $arrLen ){
	// 			$profQry .="  $temval ";
	// 		}
			
	// 		$tt++;	
	// 	}
	// } else{
	
	// $profQry .=" $var1";	
		
		
	// }

	
	// }



		
		
	// 	/////////////////////////////////////////////////////////////////////////////////////////////////
	// 	// $iddata=DB::getInstance()->query($profQry);
	// 	// if($iddata->count()>0)
	// 	// foreach($iddata->results() as $userIDs)
	// 	// {
	// 	// $userID[] = $userIDs->resp_id;
		 
	// 	// }
			
			

	// 	////////////////////////////////////////////////////////////////////////////////////////////
		
	// 	//  print_r($profQry);	
	// 	//  echo "<br/>";


	// 	//$sQuery[]=	$profQry;

	// 	//print_r($sQuery);
	// 	} // FIRST--PRIFILERS---FOREACH-- END
		
	// 	//print_r($userID);
		
	// 	print_r($sQuery);
		
	// 	die;
	// 	//print_r($datafilter); die;
	// 	////////// select data table ///////////////
	// 	$data=DB::getInstance()->query("SELECT data_table , project_id from project where response_type = 1");

    //  if($data->count()>0) 
    //  {    
    //       foreach($data->results() as $d)
    //       { 
    //         $profilerTable = $d->data_table;
          
	// 	  }
	// }	  
	// 	////////////end data table selection ////////////////


	// 	$userqry ="select DISTINCT(resp_id) from $profilerTable where ";
	// 		$QFlag =0;
	// 	foreach($datafilter as $key => $value)
	// 	      {
	// 			if($QFlag ==0){
	// 				$userqry .=" $key = $value ";
	// 				$QFlag =1;
	// 			}else{
	//        $userqry .=" or  $key = $value ";
	// 			     }
    //              }
				 
	// 			/////////////// FINDING FILTER USER ID //////////////////////
	// 								$dataRes=DB::getInstance()->query($userqry);
	// 										if($dataRes->count()>0)
	// 									{
	// 												foreach($dataRes->results() as $rr)
	// 												{
	// 									$userIdArray[]=	 $rr->resp_id;	
	// 												}
	// 									}
	// 			/////////////////END FINDINIG FILTER USER ID ////////////

			//	$List = implode(', ', $userIdArray);
				
	} // IF PROFILER IS ON OR SELECTED SECTION END




		$pid=$_POST['pn'];
        $_SESSION['pid']=$pid;
		$pid=$_SESSION['pid'];

    }
  
   echo "<table border=0>";
   echo "<form name='projectDeploy' method='post' action='respondent_filter.php'>";
  // echo "<tr><td>Enter Reward Point</td><td><input type='text'  name='rewardPoint'></td><td colspan=2 align=right><input type=submit name='pDeploy' value=Deploy></td></tr>";
   echo "<input type='hidden'  name='rewardPoint' value='0'>"; 
  echo "<tr ><td colspan=2 align=center ><input type=submit name='pDeploy'  value=Deploy></td></tr>"; 
   echo "<tr><td></td><td colspan=2></td></tr>";
   echo "<tr><td></td><td colspan=2></td></tr>";

 echo  "<input type='hidden' name='projectId' value='$pid'>";
    
 if($searchFlag == 0){
 // $querydata ="SELECT user_id,mobile FROM app_user where user_id not in (SELECT appuser_id FROM appuser_project_map where project_id =$pid) and status = 1";
 $querydata ="SELECT app_user.user_id,app_user.mobile ,gcm_users.gcm_regid FROM app_user INNER JOIN gcm_users on app_user.user_id = gcm_users.user_id where app_user.user_id not in (SELECT appuser_id FROM appuser_project_map where project_id =$pid) and app_user.status = 1";
                }

 if($searchFlag ==1) 
 {
	$querydata ="SELECT app_user.user_id,app_user.mobile ,gcm_users.gcm_regid FROM app_user INNER JOIN gcm_users on app_user.user_id = gcm_users.user_id where app_user.user_id not in (SELECT appuser_id FROM appuser_project_map where project_id =$pid) and app_user.user_id in ($List) and app_user.status = 1";
  


 }
   
 $data=DB::getInstance()->query($querydata);
   if($data->count()>0)
   {
          
            
         //show list
 echo "<tr bgcolor=lightgray><td><input type=checkbox id='checkAll' value='Select All'>Select All</td><td>Mobile No</td></tr>";
   	foreach($data->results() as $rr)
   	{
		$useIdGCMid=	$rr->user_id.'**'.$rr->gcm_regid;
		echo "<tr> <td><input type=checkbox name=userIds[] value=$useIdGCMid class='uid'></td> <td>$rr->mobile</td></tr>";
   	}
   	echo "</form>";
   }
   else
   {
   	echo "No record is found matching with this filter condition";
   	
   }

	

?>
</body>
<script>
    function displib2()
{
        var pin;
	if(window.XMLHttpRequest)
	{
		pin=new XMLHttpRequest();
	}
	else
	{
		pin= new ActiveXobject("Microsoft.XMLHTTP");
	}
	var val=document.getElementById('pn').value;
        //document.write('Hello: '+val);
	pin.onreadystatechange=function()
	{
		if(pin.readyState==4)
		{
			document.getElementById('qset').innerHTML=pin.responseText;
			console.log(pin);
		}
	}
	url="get_qset.php?pid="+val;
	pin.open("GET",url,true);
	pin.send();
}
</script>

<script type="text/javascript">
     $(document).ready(function(){ 
    $("#uall").change(function(){
      $(".uid").prop('checked', $(this).prop("checked"));
      });
});
</script>

<script type="text/javascript">
$(document).ready(function() {
    $('#uall').click(function(event) {  //on click 
        if(this.checked) { // check select status
            $('.uid').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"               
            });
        }else{
            $('.uid').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                       
            });         
        }
    });
    
});
</script>