<?php 
include_once('../vcimsweb/init.php');
include_once('../vcimsweb/survey-function.php');
//print_r($_SESSION);
    	$table='';$sid='';$qset='';$resp_id='';$pqt='';
    	$resp_id=0;$qset=0;$currq=0;$next_qstack=array();
	$qlist = array();

	if(Session::exists('resp'))
	{ 	$resp_id=$_SESSION['resp']; }
	if(Session::exists('pid'))
	{	 $qset=$_SESSION['pid'];}
	if(Session::exists('isdate'))
	{	$isdate=$_SESSION['isdate'];}

	//$_SESSION['lang']='none';
	//$lang='hindi';
	if(Session::exists('lang'))
	{	 $lang=$_SESSION['lang'];}	 
    	if(Session::exists('qstack'))
   	{	$next_qstack=$_SESSION['qstack']; }
	if(Session::exists('table'))
	{	 $table=$_SESSION['table'];}
	if(Session::exists('sid'))
    	{    $sid=$_SESSION['sid']; }         
    	if(Session::exists('pqstack'))
    	{	$tarr=$_SESSION['pqstack'];
    	}
    	if(Session::exists('pqt'))
    	{
		$pqt=$_SESSION_['pqt'];
    	}

//echo " pid: $qset ,resp: $resp_id  , table: $table , sid: $sid";
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
  background: #f1f1f1;
}
/* The device with borders */
.tablet {
  position: relative;
  width: 100%;
  height: 92%;
  margin: auto;
  border: 13px black solid;
  border-top-width: 60px;
  border-bottom-width: 60px;
  border-radius: 36px;
}
/* The horizontal line on the top of the device */
.tablet:before {
  content: '';
  display: block;
  width: 5%;
  height: 5px;
  position: absolute;
  top: -30px;
  left: 50%;
  transform: translate(-50%, -50%);
  background: #333;
  border-radius: 10px;
}
/* The circle on the bottom of the device */
.tablet:after {
  content: '';
  display: block;
  width: 0%;
  height: 0%;
  position: absolute;
  left: 50%;
  bottom: -65px;
  transform: translate(-50%, -70%);
  /* background: #333;
   border-radius: 50%; */
	border-top: 15% solid transparent;
	border-left: 30% solid #555;
	border-bottom: 15% solid transparent;
}

/* The screen (or content) of the device */
.tablet .content {
  width: 100%;
  height: 92%;
  background: white;
  margin: -1px;
}

/* For mobile phones: */
[class*="col-"] {
    // width: 100%;
   margin-left:0%;
}
@media only screen and (min-width: 768px) {
    /* For desktop: */
    .col-1 {width: 8.33%;}
    .col-2 {width: 16.66%;}
    .col-3 {width: 25%;}
    .col-4 {width: 33.33%;}
    .col-5 {width: 41.66%;}
    .col-6 {width: 50%;}
    .col-7 {width: 58.33%;}
    .col-8 {width: 66.66%;}
    .col-9 {width: 75%;}
    .col-10 {width: 83.33%;}
    .col-11 {width: 91.66%;}
    .col-12 {width: 100%;}
}
@media (min-width:768px)
 {body{background-color:#ffff;}}


</style>
<style>
	.w3-light-gray,.w3-hover-light-gray:hover{color:#000!important;background-color:#f1f1f1!important}
	.w3-green,.w3-hover-green:hover{color:#fff!important;background-color:#4CAF50!important}
	.w3-center .w3-bar-item{text-align:center}.w3-block{display:block;width:50%}
	.w3-center .w3-bar{display:inline-block;width:auto}
	.w3-center{text-align:center!important}
</style>
</head>
<body class="">

<div class="col-12 tablet">
  <div class="col-12">
<!-- begin of body -->

<form method="post" action="">
	<?php
	if(isset($_POST['submit']))
	{
                    date_default_timezone_set('asia/calcutta');
                    $date = date('Y/m/d H:i:s');
                    $newURL='';
                    $qqq="UPDATE `respondent_web` SET `status`=2 WHERE resp_id = $resp_id AND qset = $qset";
                    DB::getInstance()->query($qqq);
                    //session_destroy();
                    echo $newURL="http://www.vareniacims.com/testsurvey";
                    header('Location: '.$newURL);
	}

if(isset($_POST['next']) || $sid==0)
{
			date_default_timezone_set('asia/calcutta');        
			$date = date('Y/m/d H:i:s');
			$cq=0;
			$maxsid=0;
			$qtype='';
//echo "( sid: $sid >= 0 && sid: $sid <= max: $maxsid)";			
			if($sid > 0)
			{
				$cq=$_POST['qid'];
				//problem in not in save response if instruction type comes afert radio/checkbox,text
				//	if($pqt == 'instruction')
				if($pqt != 'instruction' || $pqt != 'first'){
						save_result($_POST,$table,$qset,$resp_id);
						//array_push($qlist,$cq);
				}

				if(Session::exists('wqstack'))
             	{	
					$tarr=$_SESSION['wqstack'];
					array_push($tarr,$cq);
					$_SESSION['wqstack']=$tarr;
             	}
				else 
				{ 
					$arrr=array();
					array_push($arrr,$cq);
					$_SESSION['wqstack']=$arrr;
				}
			}
			if(Session::exists('maxsid'))
				$maxsid = $_SESSION['maxsid'];

			if(Session::exists('sid'))
				$sid=$_SESSION['sid'];

			if($sid>$maxsid) $sid=0;
			//$qlist=array();

			$prc=($sid * 100)/$maxsid ;
			$prc=round($prc);
			echo "<div class='w3-light-grey col-10'> <div class='w3-container w3-green w3-center' style='width:$prc %;'>$prc %</div></div><br>";

		if($sid >= 0 && $sid <= $maxsid)
		{
				if($sid==0)
				{
						$cqid=first_question($qset);
				}
				else
				{  
					$cqid=next_s_question($qset,$sid,$table,$resp_id,$maxsid);
					if(Session::exists('pqstack'))
					{	
						$tarr=$_SESSION['pqstack']; 
							$pqid=end($tarr);
						if($cqid!=$pqid)
						{ 
							$arr=$_SESSION['qstack'];
							$end=end($arr); 
							array_push($arr, $end);  
							$_SESSION['pqstack']=$arr;
						}
					}
				}
				
				//for go to submit form
				if($cqid==-1)
				{
							save_result($_POST,$table,$qset,$resp_id);
							//termination code
							echo "<br><center><font size=5 color='red'>Thanks for your participation in the survey. <br>Please click on submit button to complete the survey.</font></center>";
							echo "<br><br><center> <input type='submit' name='submit' value='Submit Survey' style=background-color:#004c00;color:white;height:50px;></center>";
							//end termination
				}
				else
				{
						$sid=$_SESSION['sid'];
						$next_qstack=array();  
						$arr=array();
						if($sid==1){ 
							$arr1=array();
							$_SESSION['qstack']=$arr1;
							array_push($arr1, $cqid);
							$_SESSION['pqstack']='';
							$_SESSION['pqstack']=$arr1; 
						}
						if(Session::exists('qstack'))
						$next_qstack=$_SESSION['qstack'];
						array_push($next_qstack, $cqid); 
						$_SESSION['qstack']=$next_qstack;

						$ques=DB::getInstance()->query("SELECT `q_id`,q_title,q_type,qno FROM `question_detail` WHERE `q_id`=$cqid");
						if($ques->count()>0)
						{ 
									 $qid=$ques->first()->q_id; $qtitle=$ques->first()->q_title;$qtype=$ques->first()->q_type;$qno=$ques->first()->qno;
									 $error=$qid.'e';
									 $_SESSION_['pqt']=$qtype;

									//to check find replace rule for question title
									$fcqid='';
									$fop='';
									$qqr="SELECT qset, cqid, op_val, fstr, rstr, rqid FROM vcims.question_word_findreplace where qset= $qset and rqid=$cqid limit 1";
									$qfd=DB::getInstance()->query($qqr);
									if($qfd->count()>0){
										//$fw=$qfd->first()->fstr;
										//$rw=$qfd->first()->rstr;
										$fcqid=$qfd->first()->cqid;
										$tt=$fcqid.'_'.$qset;
										$qqr2="select $tt as vv from $table WHERE resp_id = $resp_id AND $tt !='' limit 1;";
													$qfd2=DB::getInstance()->query($qqr2);
																	if($qfd2->count()>0){
											 $fop=$qfd2->first()->vv;
											 $qqr3="SELECT * FROM vcims.question_word_findreplace where qset = $qset AND rqid=$cqid AND cqid=$fcqid AND op_val = $fop;";
											 $qfd3=DB::getInstance()->query($qqr3);
																			if($qfd3->count()>0){
																				$fw=$qfd3->first()->fstr;
																				$rw=$qfd3->first()->rstr;
												$qtitle = str_replace($fw,$rw,$qtitle);
											}
										}
									}
									//end of find replace rule

                                                      echo "<div style='padding:20px;'>";
						      if($lang == 'none'){
							 echo "<p style='font-size:8px;'>$qid / $qno</p><p>$qtitle</p><font color=red><span id='$error'></span></font></div>";
						      }
						      else if($lang == '1'){
                                            			$rs22=DB::getInstance()->query("select * FROM `hindi_question_detail` WHERE q_id =$qid");
                                            			if($rs22->count()>0)
                                            			{
                                                			$qtitle_1=$rs22->first()->q_title;
									echo "<p style='font-size:7px;'>$qid / $qno</p><p> $qtitle <br>[ $qtitle_1 ]</p><font color=red><span id='$error'></span></font></div>";
						      		}
								else echo "<p style='font-size:8px;'>$qid / $qno</p><p>$qtitle</p><font color=red><span id='$error'></span></font></div>";
						      }

								if($qtype=='radio')
								{
									$qterm='';$strval='';
							//for language options
							$lfag=0;$larr=array();
							$qlop=DB::getInstance()->query("select opt_text_value, code from hindi_question_option_detail where q_id=$qid order by code;");
							if($qlop->count()>0)
							{
								$lflag=1;
								foreach($qlop->results() as $op){
									$code=$op->code; $opt=$op->opt_text_value;
									$larr["$code"]=$opt;
								}

							}
							// end for language option
									$qrs=DB::getInstance()->query("SELECT distinct `term` FROM `question_option_detail` WHERE q_id=$qid");
									if($qrs->count()>0)
									{      $qterm=$qrs->first()->term;}
									$sql="SELECT  $qterm FROM $table WHERE q_id=$qset AND resp_id=$resp_id AND $qterm!=''";
									$rss2=DB::getInstance()->query($sql);
									if($rss2->count()>0) 
									{ $strval=$rss2->first()->$qterm;}
									else $strval="";

									  $qop=DB::getInstance()->query("SELECT `opt_text_value`,`term`,`value`,`scale_start_label`,`scale_end_label`, `scale_start_value`,`scale_end_value` FROM `question_option_detail` WHERE `q_id`=$cqid");
									  if($qop->count()>0)
									  {  echo "<table> <input type=hidden name='qid' value=$qid>";
										  foreach($qop->results() as $ov)
										  {   $str=''; 
											  $opt=$ov->opt_text_value; $term=$ov->term; $value=$ov->value; $sl=$ov->scale_start_label;$el=$ov->scale_end_label;
											  $slv=$ov->scale_start_value; $elv=$ov->scale_end_value;
											  if($strval==$value) $str=" checked='checked'";

											//for word find and replace rule
											$qrq="SELECT * FROM vcims.question_word_findreplace where qset = $qset AND rqid=$cqid AND cqid=$fcqid AND op_val = $fop;";
											$qrfd=DB::getInstance()->query($qrq);
											if($qrfd->count()>0){
												foreach($qrfd->results() as $dr){
																							$fwop=$dr->fstr;
																							$rwop=$dr->rstr;
													if (strpos($opt, $fwop) !== false) {
																								$opt = str_replace($fwop,$rwop,$opt);
													}
												}
											}
											//end of rule
									if($lang == 'none'){
										echo "<tr height=30><td></td><td width=2%><input type='$qtype' class='big' id=q$qid name=q$qid $str value='$value'></td><td> $opt</td></tr>";
									}
									else if($lang == '1'){
										if (!empty($larr)) 
											echo "<tr height=30><td></td><td width=2%><input type='$qtype' class='big' id=q$qid name=q$qid $str value='$value'></td><td> $opt [ $larr[$value]  ]</td></tr>";
										else
											echo "<tr height=30><td></td><td width=2%><input type='$qtype' class='big' id=q$qid name=q$qid $str value='$value'></td><td> $opt </td></tr>";

									}
										  }
										 echo "</table>";
									  } 
							   }
							   
								if($qtype=='checkbox')
								{    
									$qterm='';$arr_temp=array();
							//for language options
							$lfag=0;$larr=array();
							$qlop=DB::getInstance()->query("select opt_text_value, code from hindi_question_option_detail where q_id=$qid order by code;");
							if($qlop->count()>0)
							{
								$lflag=1;
								foreach($qlop->results() as $op){
									$code=$op->code; $opt=$op->opt_text_value;
									$larr["$code"]=$opt;
								}

							}
							// end for language option

									$qrs=DB::getInstance()->query("SELECT distinct `term` FROM `question_option_detail` WHERE q_id=$qid");
									if($qrs->count()>0){      
										$qterm=$qrs->first()->term;
									}
									$sql="SELECT  $qterm FROM $table WHERE q_id=$qset AND resp_id=$resp_id AND $qterm!=''";
									$rss2=DB::getInstance()->query($sql);
									if($rss2->count()>0) 
									{ 
										foreach($rss2->results() as $r)
										{
											$strval=$r->$qterm;
											array_push($arr_temp, $strval);
										}
									}
									$qop=DB::getInstance()->query("SELECT `opt_text_value`,`term`,`value`,`scale_start_label`,`scale_end_label`, `scale_start_value`,`scale_end_value` FROM `question_option_detail` WHERE `q_id`=$cqid");
									if($qop->count()>0)
									{  	echo "<table><input type=hidden name=qid value=$qid>";
										foreach($qop->results() as $ov)
										{     
											  $str = '';
											  $opt = $ov->opt_text_value; $term=$ov->term; $value=$ov->value; $sl=$ov->scale_start_label;$el=$ov->scale_end_label;
											  $slv = $ov->scale_start_value; $elv=$ov->scale_end_value;
											  if(in_array($value,$arr_temp))
											  { 
													$str = "checked='checked'";
											  }
									if($lang == 'none'){
									 	echo "<tr height=40><td></td><td width=2%><input type='$qtype' class='big' id=q$qid name='$value' $str value='$value'></td><td> $opt</td></tr>";
									}
									else if($lang == '1'){
										if (!empty($larr)){
									  echo "<tr height=40><td></td><td width=2%><input type='$qtype' class='big' id=q$qid name='$value' $str value='$value'></td><td> $opt [ $larr[$value]  ]</td></tr>";
										}
										else{
									  echo "<tr height=40><td></td><td width=2%><input type='$qtype' class='big' id=q$qid name='$value' $str value='$value'></td><td> $opt</td></tr>";
										}
									}

										}
										echo "</table>";
									} 
								}							   
								if($qtype=='rating')
								{    
									$qop=DB::getInstance()->query("SELECT `opt_text_value`,`term`,`value`,`scale_start_label`,`scale_end_label`, `scale_start_value`,`scale_end_value` FROM `question_option_detail` WHERE `q_id`=$cqid");
									if($qop->count()>0)
									{  
											echo "<table><input type=hidden name=qid value=$qid>";
										foreach($qop->results() as $ov)
										{
											  $opt=$ov->opt_text_value; $term=$ov->term; $value=$ov->value; $sl=$ov->scale_start_label;$el=$ov->scale_end_label;
											  $sv=$ov->scale_start_value; $ev=$ov->scale_end_value;
											  $arr_temp=array();$str='';$strval='';
											  
											$sql="SELECT  $term FROM $table WHERE q_id=$qset AND resp_id=$resp_id AND $term!=''";
											$rss2=DB::getInstance()->query($sql);
											if($rss2->count()>0) 
											{ 
												$strval=$rss2->first()->$term;
											}
											else $strval="";
									
											if($sv==0)
											{
												echo "<table style=border:none><tr><td> </td>";
												for($s=$sv+1;$s<=$ev;$s++)
												{
													echo "<td> $s </td>";
												}
												echo "<td> </td><td>NA</td></tr><tr><td> $sl </td>";
												for($s=$sv+1;$s<=$ev;$s++)
												{   
													if($strval==$s)
													{ 
														$str="checked='checked'";
													}else $str='';
													echo "<td><input type=radio name=r$qid $str value=$s> </td>";
												}
												echo "<td> $el </td><td><input type=radio class=big id=q$qid name=q$qid value=$s></td></tr></table>";                                
											}else if($sv==1)
											{
												echo "<table><tr><td> </td>";
												for($s=$sv;$s<=$ev;$s++)
												{
													echo "<td> $s </td>";
												}
												echo "<td> </td></tr><tr><td> $sl </td>";
												for($s=$sv;$s<=$ev;$s++)
												{   
													if($strval==$s)
													{ 
														$str="checked='checked'";
													}else $str='';
													echo "<td><input type=radio class=big id=q$qid name=q$qid $str value=$s> </td>";
												}
												echo "<td> $el </td></td></tr></table>"; 
											}
										} //end of foreach
										 echo "</table>";
									} //end of if 
							   }
							   if($qtype=='text')
							   { 
									$qterm='';$str='';
									$qrs=DB::getInstance()->query("SELECT distinct `term` FROM `question_option_detail` WHERE q_id=$qid");
									if($qrs->count()>0)
									{      $qterm=$qrs->first()->term;
									}
									$sql="SELECT  $qterm FROM $table WHERE q_id=$qset AND resp_id=$resp_id AND $qterm!=''";
									$rss2=DB::getInstance()->query($sql);
									if($rss2->count()>0) 
									{ $str=$rss2->first()->$qterm;}
									else $str="..";

									echo "<table><input type=hidden name=qid value=$qid>";
									echo "<tr><td><input type=text name=text$qid id=q$qid value=$str> </td></tr></table>";
							   }
							   if($qtype=='textarea')
							   { 
									$qterm='';$str='';
									$qrs=DB::getInstance()->query("SELECT distinct `term` FROM `question_option_detail` WHERE q_id=$qid");
									if($qrs->count()>0)
									{      $qterm=$qrs->first()->term;}
									$sql="SELECT  $qterm FROM $table WHERE q_id=$qset AND resp_id=$resp_id AND $qterm!=''";
									$rss2=DB::getInstance()->query($sql);
									if($rss2->count()>0) 
									{ $str=$rss2->first()->$qterm;}
									else $str="..";
									echo "<table><input type=hidden name=qid value=$qid>";
									echo "<tr><td><textarea id=q$qid name=text$qid cols=50 rows=5 >$str</textarea>  </td></tr></table>";
							   }
						}
						if($qtype=='text' || $qtype=='textarea' || $qtype=='radio' || $qtype=='checkbox' || $qtype=='rating' || $qtype=='dropdown') 
						{    
							  array_push($qlist,$qid);
							  //save_result($_POST,$table,$qset,$resp_id);
						}
				}// end of else
        }
        else
        {
            //termination Survey             
                    echo "<br><center><font size=5 color='red'>Thanks for your participation in the survey. <br></font></center>";                      
                    echo "<br><br><center> <input type='submit' name='submit' value='Submit Survey' style=background-color:#004c00;color:white;height:50px;></center>";
             //end termination Survey
        }
} //END OF NEXT BUTTON

	if($cqid!=-1)
	{
	?>
			<br><br><font size=2 color=red><div id=err></div></font>       
			<?php $arr=$_SESSION['qstack']; if( $arr[0]!=$qid){  ?>
			<!-- <input type='submit' name='back' value="&#8249; Back" class="previous round" style="padding: 8px 16px;display: inline-block;" > -->
			<?php } ?>
			<input type='submit' name='next' value="Next &#8250;" class="next" onclick="return Validate();" style='background-color:#004c00;color:white;height:35px;position:absolute; left:50%; float:right; padding: 8px 16px;display: inline-block;'> 
		<?php } ?>
			</center>
			<br><br><br>
			</div>
			<input type='hidden' id='temp'>

</form>
<!-- end of body -->
  </div>
</div>

</body>
	  <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
	  <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

	<script type="text/javascript">
	
	function Validate() 
	{
	var jArray= <?php echo json_encode($qlist ); ?>;
	var error=0;
		alert('inside 222.php');
	    for(var j=0;j<jArray.length;j++)
	    {   var flag=0;
	        var ctr=0;
	        var elm=jArray[j];
	        var qq='q'+elm; var nm='text'+elm;
	        var radios = document.getElementsByName(qq); 
	      
	        var et=document.getElementById(qq).type;
	        // alert(qq);
	        // alert(et);

	    if(et=='radio' )
	    {   //alert('len:'+radios.length);
	        //val=document.getElementById(qq).checked;
	        for (var i = 0; i < radios.length; i++) 
	        { 
	           if (radios[i].checked) 
	           { 
	                ctr++;  
	                elm+='e';       
	                document.getElementById(elm).innerHTML = '';         
	           }
	       }
	       if(ctr==0)
	       {
	       flag++;
	       elm+='e';
	       error++;
	       document.getElementById(elm).innerHTML = ' [ Error! Please select options below to proceed!! ]';
	       document.getElementById('err').innerHTML = 'Error! Please refill the above left blank responses to proceed...';
	       }
	     }
	
		if(et=='checkbox')
	    	{   
		         //val=document.getElementById(qq).checked;
		        var oRadio = document.forms[0].elements[qq]; 
		         var nm=document.getElementById(qq).name; var ln=nm.length; var res = nm.substring(0,ln-1);
		
		        for (var i = 1; i <= oRadio.length; i++) 
		        {  
		                var vstr=res+i; 
		                //alert(vstr);
		                 var radi = document.getElementsByName(vstr);
		                if (radi[0].checked) 
		                { 
			                ctr++;              
			                elm+='e';       
			                document.getElementById(elm).innerHTML = ''; 
		                }           
	       		} 
		       if(ctr==0)
		       {
		       flag++;
		       elm+='e';
		       error++;
		       document.getElementById(elm).innerHTML = ' [ Error! Please select options below to proceed!! ]'; 
		       document.getElementById('err').innerHTML = 'Error! Please refill the above left blank responses to proceed...';
		       }
	     	}
	        if (et == 'text' || et=='textarea') 
	        {    
	              if(document.getElementById(qq).value=='')  
	              {
	              elm+='e';
	              error++; flag=1; 
	              document.getElementById(elm).innerHTML = ' [ Error! Please type your response!! ]';
	              document.getElementById('err').innerHTML = 'Error! Please refill the above left blank responses to proceed...';     
	              } 
	              else
	              {
	                elm+='e';       
	                document.getElementById(elm).innerHTML = '';
	              } 
	         }  
	    }
	    
	    if(error==0 && flag==0)
	      { return true;}
	    if(error>0 || flag>=1)
	      { flag=0; window.stop();return false;}
	}
	
	</script>

	<style>
	.big{ width: 2em; height: 2em; }
	
	    body {
	    font-family: 'Source Sans Pro', sans-serif;
	    margin: 0;
	    padding: 0;
	    text-align: justify;
	    text-justify: inter-word;
	    text-decoration: none;
	    font-size: 100%;
	    background-color: #F9FCF8; 
	    margin-top: 25px;
	    margin-bottom: 5px;
	    margin-right: 75px;
	    margin-left: 75px;
	    }
	
	   div#header
	   {
	            height: 35px;
	            top:0px;
		    right:0px;
		    left:0px;
		    position:fixed;
		    //background: #00e500;
	            background: #fff;
		    border:1px solid #ccc;
		    padding: 0 10px 0 20px;
	   }
	
	   div#footer
	   {
	            height: 7%;
	            right:0px;
		    left:0px;
	            bottom:0px;
		    background: #1F5F04;
	            //background: #fff;
		    border:1px solid #ccc;
		    padding: 0 10px 0 20px;
	   }
	submit{line-height:25px;height:25px;}
	table{ border-style:hidden; border: none;}
	
</style>
</html>

