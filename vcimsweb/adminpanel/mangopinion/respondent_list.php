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
	//print_r($_POST);die;
	$searchFlag =0;
	$originData = $_POST;
	$pid=$_POST['pn'];
	$usrOnSurvyStatus=  $_POST['userOnSurveyType'];
	$arraySize = count($originData);
	$dayByActiveUsr = array();
	$userIdArray = array();
	
	
	
	///////////////////////////// IF PROFILERS SECTION CHOOSE//////////////////////////////////
	if($arraySize > 3)
	{   //  IF PROFILER IS SELECTED OR OPTED START
		$searchFlag =1;
		array_pop($originData);
		array_pop($originData);
		array_pop($originData);
		
	  $arrayInQry = array(); $projectarray = array(); $datatableID =array();  
		

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
			foreach($originData as $ikey => $ivar)
			{ //TERM AND THEIR VALUES FOR ONE PROFILER TABLE // START

				$tremName =	explode("_",$ikey);
		        $projId= $tremName['1'];
				if($projId==$mpval)
				{
					$OneProfArry[$ikey] = $ivar;
				}

			}//TERM AND THEIR VALUES FOR ONE PROFILER TABLE// END
			
	$QryTrem = array(); $QryGCanct =array();  $QryAndOr=array();
			
		
	    
		
    foreach($OneProfArry as $termKey => $termVal)
	{   //MAKING FINAL QUERY FOR ONE PROFILERS //START
				
			$QryTrem[] = "$termKey";
			$QryGCanct[] = " GROUP_CONCAT( $termKey ) as $termKey  ";    
								
							
					if(is_array($termVal))
					{	
						$ttLoop =1;
						$ttLen= count($termVal);
						$qryORstring ='';
						foreach($termVal as $termValRep)
						{
						   if($ttLen == 1)
								{ 
									$QryAndOr[]	="  FIND_IN_SET($termValRep,$termKey) "; 
								}
							if($ttLen > 1)
							{    
								
								 if($ttLoop == 1)
								 {
									
									$qryORstring ="( FIND_IN_SET($termValRep,$termKey) ";
								 }
								 if($ttLoop > 1  && $ttLoop < $ttLen )
								 {
									
									$qryORstring .=" OR FIND_IN_SET($termValRep,$termKey) ";
								 }

								 if($ttLoop > 1  && $ttLoop == $ttLen )
								 {
									
									$qryORstring .=" OR FIND_IN_SET($termValRep,$termKey)  ) ";
								 }


							}	
							

							$ttLoop++;

						} ///// FOREACH END
						if($qryORstring != ''){
					$QryAndOr[]	=" $qryORstring ";
						}
					}  //////  ISARRAY END ////
					else
					{
						$QryAndOr[]	="  FIND_IN_SET($termVal,$termKey) ";
					}   
	   
    } //MAKING FINAL QUERY FOR ONE PROFILERS //END

			


					///////////////////////////////////MAKING QUERY ////////////////////////////////
					
					
					$FinalQry ="  SELECT resp_id";

					foreach($QryTrem as  $Qkey => $QTerm)
					{
						$FinalQry .=", $QTerm  ";
					}
					$FinalQry .=" from  (SELECT resp_id  ";

					foreach($QryGCanct as $QryGCanctVal)
					{   
						$FinalQry .=" , $QryGCanctVal ";

					}
					$FinalQry .=" FROM $TableName GROUP BY resp_id) as T WHERE ";   

					
					
					$AOarryLen = count($QryAndOr);
					$looPcont = 1;

					foreach($QryAndOr as $QandOr)
					{   
						if($AOarryLen == 1  OR $looPcont == 1)
						{
							$FinalQry .="  $QandOr ";
						}

						if($AOarryLen > 1  &&  $looPcont != 1 )
						{
							$FinalQry .=" AND  $QandOr ";
						}
						$looPcont++;
					
					}
		

		/////////////////////////////////////// MAKING QUERY END//////////////	
			$arrayInQry[] =$FinalQry;
		} // HOW MANY TABLE IS USED //END
		

        $userIdArray = array();
		foreach($arrayInQry as $resltKey => $resultVal)
		{ //////////  fetching ids start////////////
			
			$dataRESIDS=DB::getInstance()->query($resultVal);
			 if($dataRESIDS->count()>0)
		              {
					 foreach($dataRESIDS->results() as $RstIDS)
					 {
						$userIdArray[]=	 $RstIDS->resp_id;
					}	}
		} ////////////////////////////////  fetching ids end/////////////
				
		    $userIdArray = array_unique($userIdArray);
			$userIdArray = array_values($userIdArray);
			 $List = implode(', ', $userIdArray);
			 $profilerResultArrayCnt = count($userIdArray);
	} // IF PROFILER IS ON OR SELECTED SECTION END


		
        $_SESSION['pid']=$pid;
		$pid=$_SESSION['pid'];
		
		
		////////////////////////////////// FIND USERS ON BASIS OF SURVEY SUBMISSION START /////////////////////////////
		if($usrOnSurvyStatus == 'submiN30day'  ||  $usrOnSurvyStatus == 'submiN90day') {
			
			if($usrOnSurvyStatus == 'submiN30day' )  
			{
			$qry30 ="select appuser_id from appuser_project_map where survey_submit > current_date - interval 30 day GROUP by appuser_id";
			$Udata30D=DB::getInstance()->query($qry30);
			 if($Udata30D->count()>0){
				foreach($Udata30D->results() as $UResult30D){
					$dayByActiveUsr[] = $UResult30D->appuser_id;
				}
				}
			}
			
			if($usrOnSurvyStatus == 'submiN90day' )  
			{
				$qry30 ="select appuser_id from appuser_project_map where survey_submit > current_date - interval 90 day GROUP by appuser_id";
				$Udata30D=DB::getInstance()->query($qry30);
				 if($Udata30D->count()>0){
					foreach($Udata30D->results() as $UResult30D){
						$dayByActiveUsr[] = $UResult30D->appuser_id;
					}
					}
				}
				$ActiveSurveyIdOnly  = 	count($dayByActiveUsr);	
			
			
			
			
			
			
			
			
			if($searchFlag ==1  && $profilerResultArrayCnt > 1)
			{
				

			if($ActiveSurveyIdOnly > 0 ){
				$BothArrayReslt = array_intersect($userIdArray, $dayByActiveUsr);
				$List = implode(', ', $BothArrayReslt);
			}


		} // IF PROFILERS IS SELECTED AND USER IS FOUND
		elseif($searchFlag ==1  && $profilerResultArrayCnt == 0 && ($ActiveSurveyIdOnly > 0 || $ActiveSurveyIdOnly ==0) ){
			$List = '';

		}
		elseif($searchFlag ==0  && $ActiveSurveyIdOnly > 0  ){
			$searchFlag = 1;
			$List = implode(', ', $dayByActiveUsr);
		
		}


	}	// IF DAY VALIDATION SELECTED  END
			
	
	
	
			
			


		
//$result = array_intersect($array1, $array2);
			
     
			
		


//print_r($List); die;





		
////////////////////////////////// FIND USERS ON BASIS OF SURVEY SUBMISSION END /////////////////////////////




    } ///// IF $POST IS SUBMITED
  
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