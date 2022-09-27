<?php
include_once('../../init.php');
include_once('../../functions.php');

if (isset($_POST['pDeploy'])) {

	if ($_POST['projectId'] != '') $projectId = $_POST['projectId'];

	$projEndDate =  get_project_infoforDepy($projectId);

	foreach ($projEndDate as $edatad) {
		$surveyTypes      =     $edatad->survey_types;
		$surveyOccurance  =     $edatad->survey_occurance;
		$surveyFrequency  =     $edatad->survey_frequency;
		$projStartDate    =     $edatad->survey_start_date;
		$projEndDate      =     $edatad->survey_end_date;
	}

	if ($surveyTypes == 0) {
		$statusVal = 1;
		$surveyTypes = 0;
		$surveyOcc = 0;
		$surveyFreq = 0;
	}

	if ($surveyTypes == 1) {
		$surveyOcc = $surveyOccurance;
		$surveyFreq = $surveyFrequency;

		$strtDate = strtotime($projStartDate);
		$endDate = strtotime($projEndDate);
		$dadiff = $endDate - $strtDate;
		$noOfDay = round($dadiff / (60 * 60 * 24));
		$statusVal = $noOfDay * $surveyFrequency;
	}

	$pdata =  $_POST['userIds'];

	foreach ($pdata as $userID) {
		$arrayData = explode('**', $userID);
		$usersId = $arrayData['0'];
		$gcmIdInArray[] = $arrayData['1'];
		$assignPro = "INSERT INTO `appuser_project_map`(`appuser_id`,
																									`project_id`,
																									`survey_type`,
																									`survey_occurance`,
																									`survey_frequency`,
																									`status`,
																									`start_date`,
																									`exp_date`)
								VALUES('$usersId',
								'$projectId',
								'$surveyTypes',
								'$surveyOcc',
								'$surveyFreq',
								'$statusVal',
								'$projStartDate',
								'$projEndDate')";
		$succ =  DB::getInstance()->query($assignPro);
	}

	//$depMsg ="New Survegeynics Project Has been assign Please fill Survey";
	//$succNoti  =	sendFCMnotification( $gcmIdInArray , $depMsg);  
	//$resultarray = json_decode($succNoti);  

	//if($succ->count()>0  &&  $resultarray->success > 0)

	if ($succ->count() > 0) {
		echo "<br><center><font color=green> <b> PROJECT IS DEPLOYED AND NOTIFICATION HAS BEEN SEND TO USERS SUCCESSFULLY </b></center></font><br>";
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Project Deployement</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">-->
	<style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
			font-family: sans-serif;
		}

		body {
			margin: 0;
			margin-left: 300px;
			padding: 10px;
			display: flex;
			height: 100%;
			justify-content: center;
			align-items: center;
			background: linear-gradient(to right, #71b7e6, #4070f4);
		}

		.container {
			display: grid;
			max-width: 800px;
			width: 100%;
			background: #fff;
			padding: 25px 30px;
			border: #bdbdbd solid 1px;
			border-radius: 5px;
		}

		.container .title {
			display: flex;
			justify-content: center;
			align-items: center;
			font-size: 30px;
			font-weight: 500;
			padding: 16px 20px;
			background: -webkit-linear-gradient(135deg, #71b7e6, #4070f4);
			-webkit-background-clip: text;
			-webkit-text-fill-color: transparent;
		}

		.text-prim {
			font-size: 18px;
			font-weight: 500;
			background: -webkit-linear-gradient(135deg, #71b7e6, #4070f4);
			-webkit-background-clip: text;
			-webkit-text-fill-color: transparent;
		}

		.navigation {
			display: flex;
			position: fixed;
			top: 0;
			bottom: 0;
			left: 0;
			height: 100%;
			width: 300px;
			background: rgb(28, 29, 34);
			justify-content: center;
			align-items: center;
			overflow: hidden;
			overflow-y: scroll;
		}

		.nav-link {
			font-size: 15px;
			font-weight: 550;
			position: relative;
			display: block;
			padding: 1em 2.5em 1em 1.5em;
			color: #bdbdbd;
			-webkit-transition: color 0.1s;
			transition: color 0.1s;
		}

		.form-check {
			margin: 5px;
		}

		.input-group-2 {
			margin: 5px 10px;
		}

		.profiler-questions {
			margin-left: 5px;
		}

		.reset-button,
		.apply-button {
			display: flex;
			justify-content: center;
			align-items: center;
			padding-top: 15px;
			font-size: 20px;
			font-weight: 500;
		}
	</style>
	<!--background: linear-gradient(135deg, #71b7e6, #4070f4);-->
	<!--ADD ABOVE TO BODY <STYLE> PART IF YOU NEED SPECIAL BACKGROUND COLOR-->
</head>

<body>

	<div class="container">
		<div class="title">PROJECT DEPLOYMENT</div>
		<form class="form" name="tFORM" method=post action="respondent_list.php">












			<!--NAVIGATION BAR STARTS-->
			<div class="d-flex align-items-start">
				<div class="navigation">

					<div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
						<?php

						$profiersArray = array();
						$data = DB::getInstance()->query("SELECT data_table , project_id from project where response_type = 1");
						if ($data->count() > 0) {
							foreach ($data->results() as $d) { //FIRST FOREACH STARTS
								$profilerTable = $d->data_table;
								$qSetId = $d->project_id;
								$profiersArray[] = $profilerTable;
							}
						}

						for ($pi = 0; $pi < count($profiersArray); $pi++) {
						?>
							<button class="nav-link" 
									id="v-pills-home-tab" 
									data-bs-toggle="pill" 
									data-bs-target="<?php echo '#' . $profiersArray[$pi]; ?>" 
									type="button" 
									role="tab" 
									aria-controls="v-pills-home">
										<?php echo  $profiersArray[$pi]; ?>
									</button>
						<?php  } ?>
					</div>
				</div>














				<div class="tab-content" id="v-pills-tabContent">
					<div class="text-prim">USERS ON BASIS OF THEIR PROFILER</div>









					<?php
					//////////////////////////////////// NEW CODE FOR PROFILERS////////////////////////////
					$profiersArray1 = array();
					$data = DB::getInstance()->query("SELECT data_table , project_id from project where response_type = 1");
					if ($data->count() > 0) {

						foreach ($data->results() as $d) { //FIRST FOREACH STARTS
							$profilerTable = $d->data_table;
							$qSetId = $d->project_id;
							$profiersArray1[] = $profilerTable;
						//} //FIRST FOREACH ENDS
					//} //IF ENDS
						echo "profiler array: ";
						print_r($profiersArray1);
						echo "</br>";
						echo "count of profiler array: ";
						echo count($profiersArray1);
						echo "</br>";
						echo "profiler table outside foreach: ";
						echo $profilerTable;
						//for ($count = 0; $count < count($profiersArray); $count++) {
						//echo $profiersArray[$count];
						//foreach($profiersArray1 as $pt){
					?>

							<div class="tab-pane fade" id="<?php echo $profilerTable; ?>" role="tabpanel" aria-labelledby="v-pills-home-tab">
								<div class="profiler-questions">

									<?php

									//echo $profilerTable;

									// FIND THE DETAILS QUESTION FROM QUESTION DETAILS TABLE
									$data2 = DB::getInstance()->query("select qset_id , q_id , q_type , q_title from question_detail where qset_id= $qSetId");

									if ($data2->count() > 0) { //SECOND IF STARTS
										foreach ($data2->results() as $d2) { //SECOND FOREACH STARTS
											$qsetId = $d2->qset_id;
											$qustId = $d2->q_id;
											$qType = $d2->q_type;
											$questdetail = $d2->q_title;

											if ($qType == 'radio' || $qType == 'checkbox') { // RADIO/CHECKBOX STARTS
												echo "<b> Q: </b>" . $questdetail . "<b> ? </b>" . "<br>"; //PRINTS QUESTIONS
												$data3 = DB::getInstance()->query("select opt_text_value,value from question_option_detail where q_id= $qustId");

												if ($data3->count() > 0) { //THIRD IF STARTS
													foreach ($data3->results() as $d3) { //OPTION FOREACH STARTS
														$optionDetails =  $d3->opt_text_value;
														$optionVal =  $d3->value;

														if ($qType == 'radio') {
									?>
															<div class="form-check">
																<input class="form-check-input" type="radio" name="<?php echo $qustId . '_' . $qsetId ?>" value="<?php echo $optionVal ?>" />
																<label class="form-check-label" for="flexRadioDefault1">
																	<?php echo $optionDetails; //PRINTS RADIO OPTIONS
																	?>
																</label>
															</div>
														<?php
														} elseif ($qType == 'checkbox') {
														?>
															<div class="form-check">
																<input class="form-check-input" type="checkbox" name="<?php echo $qustId . '_' . $qsetId ?>[]" value="<?php echo $optionVal ?>" />
																<label class="form-check-label" for="flexCheckChecked">
																	<?php echo $optionDetails; //PRINTS CHECKBOX OPTIONS
																	?>
																</label>
															</div>
							<?php
														}
													} //OPTION FOREACH ENDS  
												} //THIRD IF ENDS
											} //RADIO CHECKBOX ENDS
										} //SECOND FOREACH ENDS
									} //SECOND IF ENDS

								} //FIRST FOREACH ENDS
							} //FIRST IF ENDS
							//////////////////////////////////// PROFILERS CODE ENDED HERE ///////////////////////////
							?>



								</div>
								<!--PROFILER QUESTION DIV ENDS-->
							</div>
							<!--TAB 1 ENDS-->
				</div>
				<!--TAB CONTENT ENDS HERE-->
			</div>
			<!--class="d-flex align-items-start" ENDS HERE-->









			<div class="survey-submit-div" id="survey-submit-div">
				<?php
				//////////////////////////FILTER USERS ON THE BASIS OF SURVEY SUBMIT STARTS////////////////
				?>
				<div class="text-prim">
					USERS ON BASIS OF SURVEY SUBMITTED/NOT SUBMITTED
				</div>
				<div class="survey-submit-radio">
					<div class="form-check">
						<input class="form-check-input" type="radio" name="userOnSurveyType" value="allRegUser" id="userOnSurveyType" checked>
						All
						</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="radio" name="userOnSurveyType" value="submiN30day" id="userOnSurveyType">
						<label class="form-check-label" for="flexRadioDefault2">
							Survey Submit within 30 days
						</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="radio" name="userOnSurveyType" value="submiN90day" id="userOnSurveyType">
						<label class="form-check-label" for="flexRadioDefault2">
							Survey Submit within 90 days
						</label>
					</div>
				</div>
				<?php
				/////////////////////////FILTER USERS ON THE BASIS OF SURVEY SUBMIT ENDS/////////////////
				?>
			</div>

			<!--NEW CODE FOR PROJECT DEPLOYEMENT-->
			<div classs="project-selection" id="project-selection">
				<div class="text-prim">
					PROJECT
				</div>
				<div class="input-group-2">
					<select class="form-select" name=pn id=pn aria-label="Example select with button addon" required>
						<option selected>--Select Project--</option>
						<?php
						$pj = get_projects_details_serveygenics();
						foreach ($pj as $p) {
							echo "<option value='";
							echo $p->project_id;
							echo "'>";
							echo $p->name;
							echo "</option>";
						}
						echo "\r\n";
						?>
					</select>
				</div>
			</div>

			<!--APPLY FILTERS BUTTON-->
			<div class="apply-button" id="apply-button">
				<button class="btn btn-outline-secondary" type="submit" name="get_project" id="get_project" value="View Respondent for project deployment">
					APPLY FILTERS
				</button>
			</div>

			<!--RESET BUTTON-->
			<div class="reset-button" id="reset-button">
				<button type="reset" value="Reset" name="reset" class="btn btn-primary">RESET</button>
			</div>
		</form>
		<!--FORM ENDS-->
	</div>
	<!--CONTAINER DIV ENDS HERE-->

	<!-- ELEMENTS END HERE-->
	</script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>


<?php
function sendFCMnotification($gcmId, $nofifyMsg)
{

	$url = 'https://fcm.googleapis.com/fcm/send';
	$apikey = 'AAAAu5kGXG0:APA91bG43dL7c2SAU4jZGoZLGI0Sw9d4RK03jo2nIUJaGhYlP274U8Xql7ikj9sg-pwgANz7JAI3lU64hN0uluvVVuIOIHhAApqHHgyv-u3TXSIilyuJWGazA54wHnuWBCCtc0Eoekiw';

	$header = array(
		'Authorization:key=' . $apikey,
		'Content-Type:application/json'
	);

	$nofifyData = [
		'title' => 'Servegeygenics Message for New Survey',
		'body' => $nofifyMsg,
		'click_action' => 'WRITE HERE CLICK ACTION WHERE IT GO AFTER CLICKING'
		// 'image'=> 'image URL'
	];

	$data = array(
		'message'    => 'This message from Servegenics App',
		'title'     => 'This is Servegenics Title',
		'vibrate'   => 1,
		'sound'     => 1,

	);

	$nofifyBody = [

		'registration_ids' => $gcmId,
		'notification' => $nofifyData,
		'data' => $data,
		'time_to_live' => 3600

	];

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($nofifyBody));
	$result = curl_exec($ch);

	if ($result === FALSE) {
		die('Error in sending notification: ' . curl_error($ch));
	}
	curl_close($ch);
	return $result;
}

?>