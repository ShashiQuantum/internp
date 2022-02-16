<?php
include_once('../init.php');
include_once('../functions.php');

 if(isset($_POST['logout']))
         {
            session_destroy();
		//Cookie::delete($this->_cookieName);
		
		Redirect::to('login_fp.php');
            
         }
         echo "Hi <font color='lightgreen'>".Session::get('suser')."</font>";

?>
<!DOCTYPE html>
<html>
<head><title>Add Project Question</title></head>
<body>
<center>
<br><br><h2>Add Project's Questions</h2><br><br>

<?php
	//create new question
	if(isset($_POST['nq_submit']))
	{
	    //print_r($_POST);
	    $pid=$_POST['pn'];
	    $qset=$_POST['qset'];
	    $qno=$_POST['qno'];
	    $q=$_POST['qtitle'];
	    $qt=$_POST['qt'];
	    $qn = strtolower($qno);
	    $trm2=$qn.'_'.$pid;
            $trm3=$trm2.'_t';
            $qn = strtoupper($qn);
	    $ptable='';
	    
	    $ptq="SELECT `data_table` FROM `project` WHERE `project_id` = $pid";
	    $pqtr=DB::getInstance()->query($ptq);
	    if($pqtr->count()>0)
	            $ptable=$pqtr->first()->data_table;
	
	    else echo 'Project not mapped with Table';
	
	    if($q!='' && $pid!=0 && $qset!=0 && $qn!='' && $qt!='')
	    {   
	        
	        if($qt=='rating' )
	        {
	            $ssv=$_POST['froms'];
	            $esv=$_POST['tos'];
	            $lforms=$_POST['lfroms'];
	            $ltos=$_POST['ltos'];
	            
	          // print_r($_POST);
	            $sq1="INSERT INTO `question_detail`(qset_id, `q_title`, `q_type`,qno) VALUES ($qset,'$q','$qt','$qn')";
	            $qcreate=DB::getInstance()->query($sq1);
	            $qid=$qcreate->last();
	
	            $atq="ALTER TABLE $ptable ADD $trm2 int(2) not null, ADD $trm3 varchar(20)";
	            $ctb1=DB::getInstance()->query($atq);
	
	            $sq2="INSERT INTO `question_option_detail`( `q_id`,`term`,scale_start_value,scale_end_value,scale_start_label,scale_end_label) VALUES ($qid,'$trm2','$ssv','$esv','$lforms','$ltos')";
	            $qop=DB::getInstance()->query($sq2);
	            echo 'Successfully created with Question Id: '.$qid.'--'. $qn; 
	            
	        }
	       
	        if($qt=='instruction' || $qt=='image' || $qt=='imaged' || $qt=='audio' || $qt=='audiod' || $qt=='video' || $qt=='videod')
	        {
	               
	                
	            $sq1="INSERT INTO `question_detail`(qset_id, `q_title`, `q_type`,qno) VALUES ($qset,'$q','$qt','$qn')";
	            $qcreate=DB::getInstance()->query($sq1);
	            $qid=$qcreate->last();
	            //$sq2="INSERT INTO `question_option_detail`( `q_id`,`term`) VALUES ($qid,'$trm')";
	            //$qop=DB::getInstance()->query($sq2);
	            //echo 'Successfully created with Question Id: '.$qid; 
	            /*
	            $file=$_FILES['qfile'];
	            $target_dir = "../uploads/";
	            $target_file = $target_dir . basename($_FILES["qfile"]["name"]);
	            echo $uFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	            if($uFileType=='png' || $uFileType=='jpg')
	            {$target_dir = "../uploads/image/";$target_file = $target_dir .'q'.$qid.'.'.$uFileType;}
	            if($uFileType=='mp3')
	            { $target_dir = "../uploads/audio/";$target_file = $target_dir .'q'.$qid.'.'.$uFileType;}
	            if($uFileType=='mp4')
	            {   $target_dir = "../uploads/video/";$target_file = $target_dir .'q'.$qid.'.'.$uFileType;}
	            
	            //echo '<br>TF:'.$target_file;
	            
	            if (move_uploaded_file($_FILES["qfile"]["tmp_name"], $target_file)) {
	                echo "<br>The file ". basename( $_FILES["qfile"]["name"]). " has been uploaded.";
	                if($uFileType=='png')
	                    $qop1=DB::getInstance()->query("UPDATE `question_detail` SET `image`=$target_file WHERE `q_id`");
	                if($uFileType=='mp3')
	                    $qop1=DB::getInstance()->query("UPDATE `question_detail` SET `audio`=$target_file WHERE `q_id`");
	                if($uFileType=='mp4')    
	                    $qop1=DB::getInstance()->query("UPDATE `question_detail` SET `video`=$target_file WHERE `q_id`");
	            } else 
	            {
	                echo "<br>Sorry, there was an error uploading your file.";
	            }
	            //echo "Return Code: " . $_FILES["qfile"]["error"] . "<br />";
	            */
                   echo 'Successfully created with Question Id: '.$qid.'--'. $qn; 
	        }
	        if($qt=='text' || $qt=='textarea' || $qt == 'dropdown')
	        {
	           $sq1="INSERT INTO `question_detail`(qset_id, `q_title`, `q_type`,qno) VALUES ($qset,'$q','$qt','$qn')";
	            $qcreate=DB::getInstance()->query($sq1);
	            $qid=$qcreate->last();
	
	            if($qt=='dropdown')
	                  $atq="ALTER TABLE $ptable ADD $trm2 int(2) not null, ADD $trm3 varchar(20)";
	            else
	                  $atq="ALTER TABLE $ptable ADD $trm2 varchar(60) not null, ADD $trm3 varchar(20)";
	
	             $ctb1=DB::getInstance()->query($atq);
	
	            $qop=DB::getInstance()->query("INSERT INTO `question_option_detail`( `q_id`,`term`) VALUES ($qid,'$trm2')");
	            echo 'Successfully created with Question Id: '.$qid.'--'. $qn; 
	            
	        }
	        if($qt=='radio' || $qt=='checkbox')
	        {
	            $tt=$_POST['tt'];
	            $tv=$_POST['tv'];
	            $data=substr($tt,0,(strlen($tt)-1));
	            $data2=substr($tv,0,(strlen($tv)-1));
	
	            $arr_opt=  explode(',', $data);  
	            $arr_opv=  explode(',', $data2);
	            $opt_len=count($arr_opt);
	            $opv_len=count($arr_opv);
	            $sq1="INSERT INTO `question_detail`(qset_id, `q_title`, `q_type`,qno) VALUES ($qset,'$q','$qt','$qn')";
	            $qcreate=DB::getInstance()->query($sq1);
	            $qid=$qcreate->last();
	
	            $atq="ALTER TABLE $ptable ADD $trm2 varchar(2) not null, ADD $trm3 varchar(20)";
	            $ctb1=DB::getInstance()->query($atq);
	
	            
	            for($i=0;$i<$opt_len;$i++)
	            {
	            $sq2="INSERT INTO `question_option_detail`( `q_id`, `opt_text_value`, `value`, `term`) VALUES ($qid,'$arr_opt[$i]',$arr_opv[$i],'$trm2')";    
	            $qop=DB::getInstance()->query($sq2);
	            }
	            echo 'Successfully created with Question Id:<font color=red> '.$qid  .'--'. $qn; 
	            
	        }
	        if($qt=='titlewithonerating')
	        {
	             //print_r($_POST);
	            //$txth=$_POST['txthead'];
	            $txtt=$_POST['txtterm'];
	              $t3=$qn.'t_'.$qset;   $t4=$qn.'r_'.$qset;
	             
	            
	            $rh=$_POST['rathead'];
	            $rh2=$_POST['rathead2'];
	            $rt=$_POST['ratterm'];
	            $rt2=$_POST['ratterm2'];
	            
	            $tt=$_POST['tt'];
	            $tt1=$_POST['tt1'];
	            $tt2=$_POST['tt2'];
	            
	            $tv=$_POST['tv'];
	                    $tt=substr($tt,0,(strlen($tt)-1));
	                    $tt1=substr($tt1,0,(strlen($tt1)-1));
	                    $tt2=substr($tt2,0,(strlen($tt2)-1));
	                    
	            $arr_opt=  explode(',', $tt);  
	            $arr_opv=  explode(',', $tv);
	            $arr_opt1=  explode(',', $tt1);
	            $arr_opt2=  explode('=', $tt2);
	            
	            $opt_len=count($arr_opt);
	            $opv_len=count($arr_opv);
	            $sq1="INSERT INTO `question_detail`(qset_id, `q_title`, `q_type`,qno) VALUES ($qset,'$q','$qt','$qn')";
	              $qcreate=DB::getInstance()->query($sq1);
	              $qid=$qcreate->last();
	            $atq="ALTER TABLE $ptable ADD COLUMN $t3 varchar(2) not null, ADD COLUMN $t4 varchar(2) not null";
	             $ctb1=DB::getInstance()->query($atq);
	
	               //$qid=27;
	            for($i=0;$i<$opv_len;$i++)
	            {
	                  $sql="INSERT INTO `question_option_detail`( `q_id`,rating1_title,rating1_value,txt_heading,rating1_heading, text_term, rating_term,  opt_text_value ) VALUES ($qid,'$arr_opt[$i]','$arr_opv[$i]','$arr_opt2[$i]','$rh','$t3','$t4','$arr_opt1[$i]')";
	                  $qop1=DB::getInstance()->query($sql);
	            }
	            
	            echo 'Successfully created with Question Id: '.$qid;
	            
	        }// end of qt titlewithonerating
	        
	    }
	    else
	        echo 'pls type new question you want to add';
	}
?>

	<table cellpadding="2" cellspacing="1" border="0" style="font-size:12px;">
               <form name="qfrm" action="" method="post" enctype="multipart/form-data">
               <!-- <tr><td>Project Name </td><td> <select name="pn" id="pn"><option value="0">Select</option><?php $pj=get_projects_details();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr>  -->  
           
                <tr><td>Project Name *</td> </td><td> <select name="pn" id="pn" onclick="displib2(); "><option value="0">--Select--</option><?php $pj=get_projects_details();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr>
                <tr><td>QuestionSet ID *</td><td><select name="qset" id="qset" onchange="displib4();"><option value="0">--Select--</option> </select> </td></tr>                
                <tr><td>Question Type * </td><td> <select name="qt" id="qt"><option value=0>Select</option> <option value="text">Open Ended [Text]</option><option value="textarea">Open Ended MultipleLine [TextArea]</option><option value="radio">Single Choice [Radio]</option><option value="checkbox">Multiple Choice [CheckBox]</option><option value="instruction">Instruction</option><option value="dropdown">Num Dropdown List(0-30)</option><option value="rating">Rating </option><option value="image">Image Capture</option><option value="audio">Audio Capture</option><option value="image">Video Capture</option><option value="imaged">Display Instruction with Image</option><option value='audiod'>Play Audio with Instruction</option> <option value="videod">Play Video with Instruction</option><option value="titlewithonerating">Title with one rating</option></select> </td></tr>
                <tr><td>Question S.No *</td><td> <input type="text" name="qno" id="qno" placeholder="question serial no" onkeypress="return IsAlphaNumber(event)" ondrop="return false;" onpaste="return false;"> <span id="error" style="color: Red; display: none">* Special Characters not allowed </td></tr>
                <tr><td>Question Title *</td><td> <textarea rows="5" cols="30" name="qtitle" id="qtitle" placeholder="type new question here" onpaste="return IsNotAlphaNumber2(event)"></textarea> <span id="qerror" style="color: Red; display: none">* Special Characters not allowed , retype it again</td></tr>
<!--
                <tr><td>Question Image/Video/Audio</td><td> <input type="file" name="qfile" id="qfile" placeholder="type new question here"></td></tr>

                <tr><td>Question Term *</td><td><select name='term' id='term'><option value='select'>--Select--</option><option value='NA'>Not Applicable</option><?php $pj=get_terms();foreach($pj as $p){ $cn=$p->COLUMN_NAME;$tn=$p->TABLE_NAME;?><option value='<?php echo $cn;?>'><?php echo $cn.'-- '.$tn;?></option><?php }?></select> <a href="create_table_column.php" target="_blank">New Term</a> </td></tr>
-->
                <!-- for textrating question type -->
                
                <tr><td></td><td><div id="media" style="display:none">
                            <font color="red"> How many option's you want to add : </font> <input type="number" name="coln" id="coln" min="1" onchange="displib5();"> 
                </div></td></tr>
                
                <tr><td></td><td><div id="main_textrating" style='display:none'> 
                <fieldset style='width:200px'>
                <legend><font color=blue>Specify TextBox Setting:</font></legend>
                Heading: <input type="text" name="txthead" placeholder="Heading for All TextBox"><br>
                Term: <input type=text name='term1' id='term1'><br>
                No of TextBox: <input type="number" name="ntxt" placeholder="Total TextBox you want"><br>
                </fieldset> 
                <fieldset style='width:200px'>
                <legend><font color=blue>Specify Rating Setting:</font></legend>
                Heading: <input type="text" name="rathead" placeholder="Heading for All Ratings"><br>
                Term: <input type=text name='term2' id='term2'><br>
                 <p>Add Ratings</p>
                <div id="ar"></div>
                </fieldset>
                </div> </td></tr>
                
                <!-- for title2rating question type -->
                <tr><td></td><td><div id="main_textrating2" style='display:none'> 
                <fieldset style='width:200px'>
                <legend><font color=blue>Specify TitleOption Setting:</font></legend>
               <!-- Heading: <input type="text" name="txthead" placeholder="Heading for All TextBox"><br> -->
                  <input type=hidden name='term3' id='term3'><br>
                <p>Added Title</p>
                
                <div id="ar2"></div>
                </fieldset> 
                <fieldset style='width:200px'>
                <legend><font color=blue>Specify Rating Setting:</font></legend>
                Heading 1: <input type="text" name="rathead" placeholder="Heading for Ratings"><br>
                  <input type=hidden name4='term4' id='term4'><br>
                  <input type="hidden" name="rathead2" placeholder="Heading 2 for Ratings"><br>
                  <input type=hidden name='term5' id='term5'><br>
                 <p>Added Rating</p>
                <div id="ar1"></div>
                </fieldset>
                </div> </td></tr>
                
                <tr><td></td><td><div id="main5" style='display:none'>
                <hr> <p>Specify Rating Option's List</p>
                Scale : From <input type="number" name="froms" min="0" max="1"> To <input type="number" min="1" max="10" name="tos"><br>
                Start Rating :<input type="text" name="lfroms" placeholder="Rating Start Label"><br>
                End Rating : <input type="text" name="ltos" placeholder="Rating End Label"><br>
                        </div></td></tr>
                
                <tr><td></td><td><input type="hidden" id="tt" name="tt"><input type="hidden" id="tt1" name="tt1"><input type="hidden" id="tt2" name="tt2"><input type="hidden" id="tv" name="tv"></td></tr>
                
                <tr><td colspan="2"><center><input type="submit" name="nq_submit" onclick="return confirm('Are you sure?');" value="Submit"></center></td></tr>
                </form>
        </table>
        <div id="main" style='display:none'>
                <hr> <p>Option's List</p>
                <input type="image" id="btAdd" class="bt" src="../uploads/image/add.png" alt="Add More" width="38" height="38">       
                <input type="image" id="btRemove" class="bt" src="../uploads/image/remove.png" alt="Remove" width="38" height="38">       
       <!-- <input type="button" id="btRemoveAll" value="Remove All" class="bt" /><br /> -->
        </div>
        <div id="main2" style='display:none'>
                <hr> <p>Column Option's List</p>
                <input type="image" id="btAdd2" class="bt2" src="../uploads/image/add.png" alt="Add More" width="38" height="38">       
                <input type="image" id="btRemove2" class="bt2" src="../uploads/image/remove.png" alt="Remove" width="38" height="38">       
        </div>
        <div id="main3" style='display:none'>
                <hr> <p>Option's List</p>
                <input type="image" id="btAdd3" class="bt" src="../uploads/image/add.png" alt="Add More" width="38" height="38">       
                <input type="image" id="btRemove3" class="bt" src="../uploads/image/remove.png" alt="Remove" width="38" height="38">       
       <!-- <input type="button" id="btRemoveAll" value="Remove All" class="bt" /><br /> -->
        </div>    
        <div id="main4" style='display:none'>
                <hr> <p>Add Rating's Option List</p>
                <input type="image" id="btAdd4" class="bt" src="../uploads/image/add.png" alt="Add More" width="38" height="38">       
                <input type="image" id="btRemove4" class="bt" src="../uploads/image/remove.png" alt="Remove" width="38" height="38">       
                <p>Add Title's Option List</p>
                <input type="image" id="btAdd5" class="bt" src="../uploads/image/add.png" alt="Add More" width="38" height="38">       
                <input type="image" id="btRemove5" class="bt" src="../uploads/image/remove.png" alt="Remove" width="38" height="38">   
        </div>  
        
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

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
	
	function displib4()
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
		var val=document.getElementById('qset').value;
	        //document.write('Hello: '+val);
		pin.onreadystatechange=function()
		{
			if(pin.readyState==4)
			{
				document.getElementById('da').innerHTML=pin.responseText;
				console.log(pin);
			}
		}
		url="routine_list.php?qset="+val;
		pin.open("GET",url,true);
		pin.send();
	}
	
	

</script>

<script>
  $(document).ready(function() 
  {

        var iCnt = 0;
        var iCnt1 = 0;
        var iCnt2 = 0;
        //if($(this).val()=='radio')
       $('#qt').click(function() { 
           
        if($(this).val()=='rating')
        {
        $('#main').hide();
        $('#main2').hide();
        $('#main3').hide();
        $('#main4').hide();
        $('#main5').show();
        }
        
        
        if($(this).val()=='radiomedia' || $(this).val()=='checkboxmedia')
        {
            $('#media').show();
            $('#main').hide();
            $('#main2').hide();
            $('#main3').hide();
            $('#main4').hide();
            $('#main5').hide();
            $('#main_textrating2').hide();
            
        }
         
           
        if($(this).val()=='radio' || $(this).val()=='checkbox')
        {
        $('#main').show();
        $('#main2').hide();
        
           // alert($(this).val());
    
        // CREATE A "DIV" ELEMENT AND DESIGN IT USING JQUERY ".css()" CLASS.
        var container = $(document.createElement('div')).css({
            padding: '5px', margin: '20px', width: '210px', border: '1px dashed',
            borderTopColor: '#999', borderBottomColor: '#999',
            borderLeftColor: '#999', borderRightColor: '#999'
        });

        $('#btAdd').click(function() {
            if (iCnt <= 49) {

                iCnt = iCnt + 1;

                // ADD TEXTBOX.
                
                $(container).append('<input type=text class=vv style=width:25px value='+iCnt+' id=stb' + iCnt +'><input type=text class="input" id=tb' + iCnt + ' ' +
                            ' placeholder="Text Element ' + iCnt + '" />');

                if (iCnt == 1) {        // SHOW SUBMIT BUTTON IF ATLEAST "1" ELEMENT HAS BEEN CREATED.

                    var divSubmit = $(document.createElement('div'));
                    $(divSubmit).append('<input type=button class="bt" onclick="GetTextValue()"' + 
                            'id=btSubmit value=Done />');

                }

                $('#main').after(container, divSubmit);   // ADD BOTH THE DIV ELEMENTS TO THE "main" CONTAINER.
            }
            else {      // AFTER REACHING THE SPECIFIED LIMIT, DISABLE THE "ADD" BUTTON. (20 IS THE LIMIT WE HAVE SET)
                
                $(container).append('<label>Reached the limit</label>'); 
                $('#btAdd').attr('class', 'bt-disable'); 
                $('#btAdd').attr('disabled', 'disabled');

            }
        });

        $('#btRemove').click(function() {   // REMOVE ELEMENTS ONE PER CLICK.
            if (iCnt != 0) { $('#tb' + iCnt).remove();$('#stb' + iCnt).remove(); iCnt = iCnt - 1; }
        
                if (iCnt == 0) { $(container).empty(); 
        
                $(container).remove(); 
                $('#btSubmit').remove(); 
                $('#btAdd').removeAttr('disabled'); 
                $('#btAdd').attr('class', 'bt') 

            }
        });

        $('#btRemoveAll').click(function() {    // REMOVE ALL THE ELEMENTS IN THE CONTAINER.
        
            $(container).empty(); 
            $(container).remove(); 
            $('#btSubmit').remove(); iCnt = 0; 
            $('#btAdd').removeAttr('disabled'); 
            $('#btAdd').attr('class', 'bt');

        });
    }
    
        if($(this).val()=='radiogrid')
        {
        $('#main').show();
        $('#main2').show();
            //alert($(this).val());
            // CREATE A "DIV" ELEMENT AND DESIGN IT USING JQUERY ".css()" CLASS.
      
        // CREATE A "DIV" ELEMENT AND DESIGN IT USING JQUERY ".css()" CLASS.
            var container1 = $(document.createElement('div')).css({
            padding: '5px', margin: '20px', width: '285px', border: '1px dashed',
            borderTopColor: '#999', borderBottomColor: '#999',
            borderLeftColor: '#999', borderRightColor: '#999'
        });
        
            var container2 = $(document.createElement('div')).css({
            padding: '5px', margin: '20px', width: '285px', border: '1px dashed',
            borderTopColor: '#999', borderBottomColor: '#999',
            borderLeftColor: '#999', borderRightColor: '#999'
        });
        $('#btAdd').click(function() {
            if (iCnt1 <= 49) {

                iCnt1 = iCnt1 + 1;

                // ADD TEXTBOX.
                $(container1).append('<input type=text class=vv style=width:25px value='+iCnt1+' id=stb' + iCnt1 +'><input type=text class="input" id=tb' + iCnt1 + ' ' +
                            ' placeholder="Text Element ' + iCnt1 + '" />');

                if (iCnt1 == 1) {        // SHOW SUBMIT BUTTON IF ATLEAST "1" ELEMENT HAS BEEN CREATED.

                    var divSubmit = $(document.createElement('div'));
                    $(divSubmit).append('<input type=button class="bt" onclick="GetTextValue()"' + 
                            'id=btSubmit value=Done />');

                }

                $('#main').after(container1, divSubmit);   // ADD BOTH THE DIV ELEMENTS TO THE "main" CONTAINER.
            }
            else {      // AFTER REACHING THE SPECIFIED LIMIT, DISABLE THE "ADD" BUTTON. (20 IS THE LIMIT WE HAVE SET)
                
                $(container1).append('<label>Reached the limit</label>'); 
                $('#btAdd').attr('class', 'bt-disable'); 
                $('#btAdd').attr('disabled', 'disabled');

            }
        });

        $('#btRemove').click(function() {   // REMOVE ELEMENTS ONE PER CLICK.
            if (iCnt1 != 0) { $('#tb' + iCnt1).remove();$('#stb' + iCnt1).remove(); iCnt1 = iCnt1 - 1; }
        
                if (iCnt1 == 0) { $(container1).empty(); 
        
                $(container1).remove(); 
                $('#btSubmit').remove(); 
                $('#btAdd').removeAttr('disabled'); 
                $('#btAdd').attr('class', 'bt') 

            }
        });

        $('#btAdd2').click(function() {
            if (iCnt2 <= 49) {

                iCnt2 = iCnt2 + 1;

                // ADD TEXTBOX.
                $(container2).append('<input type=text style=width:25px value='+iCnt2+' id=stb' + iCnt2 +'><input type=text class="input2" id=tb' + iCnt2 + ' ' +
                            ' placeholder="Text Element ' + iCnt2 + '" />');

                if (iCnt2 == 1) {        // SHOW SUBMIT BUTTON IF ATLEAST "1" ELEMENT HAS BEEN CREATED.

                    var divSubmit2 = $(document.createElement('div'));
                    $(divSubmit2).append('<input type=button class="bt2"  onclick="GetTextValue2()"' + 
                            'id=btSubmit value=Done />');

                }

                $('#main2').after(container2, divSubmit2);   // ADD BOTH THE DIV ELEMENTS TO THE "main" CONTAINER.
            }
            else {      // AFTER REACHING THE SPECIFIED LIMIT, DISABLE THE "ADD" BUTTON. (20 IS THE LIMIT WE HAVE SET)
                
                $(container2).append('<label>Reached the limit</label>'); 
                $('#btAdd2').attr('class', 'bt-disable'); 
                $('#btAdd2').attr('disabled', 'disabled');

            }
        });

        $('#btRemove2').click(function() {   // REMOVE ELEMENTS ONE PER CLICK.
            if (iCnt2 != 0) { $('#tb' + iCnt2).remove();$('#stb' + iCnt2).remove(); iCnt2 = iCnt2 - 1; }
        
                if (iCnt2 == 0) { $(container2).empty(); 
        
                $(container2).remove(); 
                $('#btSubmit').remove(); 
                $('#btAdd2').removeAttr('disabled'); 
                $('#btAdd2').attr('class', 'bt2') 

            }
        });
    }
    
        if($(this).val()=='textrating')
        {
        $('#main').hide();
        $('#main2').hide();
        $('#main_textrating').show();
        $('#main3').show();
        
            //alert($(this).val());
    
        // CREATE A "DIV" ELEMENT AND DESIGN IT USING JQUERY ".css()" CLASS.
        var container = $(document.createElement('div')).css({
            padding: '5px', margin: '2px', width: '285px', border: '1px dashed',
            borderTopColor: '#999', borderBottomColor: '#999',
            borderLeftColor: '#999', borderRightColor: '#999'
        });

        $('#btAdd3').click(function() {
            
            if (iCnt <= 49) {

                iCnt = iCnt + 1;
                $(container).append('<input type=text class=vv style=width:25px value='+iCnt+' id=stb' + iCnt +'><input type=text class="input" id=tb' + iCnt + ' ' +
                            ' placeholder="Rating Text ' + iCnt + '" />');

                if (iCnt == 1) {        // SHOW SUBMIT BUTTON IF ATLEAST "1" ELEMENT HAS BEEN CREATED.

                    var divSubmit = $(document.createElement('div'));
                    $(divSubmit).append('<input type=button class="bt" onclick="GetTextValue3()"' + 
                            'id=btSubmit value=Save />');

                }

                $('#ar').after(container, divSubmit);   // ADD BOTH THE DIV ELEMENTS TO THE "main" CONTAINER.
            }
            else {      // AFTER REACHING THE SPECIFIED LIMIT, DISABLE THE "ADD" BUTTON. (20 IS THE LIMIT WE HAVE SET)
                
                $(container).append('<label>Reached the limit</label>'); 
                $('#btAdd3').attr('class', 'bt-disable'); 
                $('#btAdd3').attr('disabled', 'disabled');

            }
        });

        $('#btRemove3').click(function() {   // REMOVE ELEMENTS ONE PER CLICK.
            if (iCnt != 0) { $('#tb' + iCnt).remove();$('#stb' + iCnt).remove(); iCnt = iCnt - 1; }
        
                if (iCnt == 0) { $(container).empty(); 
        
                $(container).remove(); 
                $('#btSubmit').remove(); 
                $('#btAdd3').removeAttr('disabled'); 
                $('#btAdd3').attr('class', 'bt') 

            }
        });
    }
    
         if($(this).val()=='titlewithonerating')
        {
        $('#main').hide();
        $('#main2').hide();
        $('#main_textrating').hide();
        $('#main3').hide();
        $('#main4').show();
        $('#main_textrating2').show();
        
            //alert($(this).val());
    
        // CREATE A "DIV" ELEMENT AND DESIGN IT USING JQUERY ".css()" CLASS.
        var container = $(document.createElement('div')).css({
            padding: '5px', margin: '2px', width: '285px', border: '1px dashed',
            borderTopColor: '#999', borderBottomColor: '#999',
            borderLeftColor: '#999', borderRightColor: '#999'
        });
        var container2 = $(document.createElement('div')).css({
            padding: '5px', margin: '20px', width: '285px', border: '1px dashed',
            borderTopColor: '#999', borderBottomColor: '#999',
            borderLeftColor: '#999', borderRightColor: '#999'
        });
        
        $('#btAdd4').click(function() {
            
            if (iCnt <= 49) {

                iCnt = iCnt + 1;
                $(container).append('<input type=text class=vv style=width:25px value='+iCnt+' id=stb' + iCnt +'><input type=text class="input" id=tb' + iCnt + ' ' +
                            ' placeholder="Rating Text ' + iCnt + '" />');

                if (iCnt == 1) {        // SHOW SUBMIT BUTTON IF ATLEAST "1" ELEMENT HAS BEEN CREATED.

                    var divSubmit = $(document.createElement('div'));
                    $(divSubmit).append('<input type=button class="bt" onclick="GetTextValue3()"' + 
                            'id=btSubmit value=Save />');

                }

                $('#ar1').after(container, divSubmit);   // ADD BOTH THE DIV ELEMENTS TO THE "main" CONTAINER.
            }
            else {      // AFTER REACHING THE SPECIFIED LIMIT, DISABLE THE "ADD" BUTTON. (20 IS THE LIMIT WE HAVE SET)
                
                $(container).append('<label>Reached the limit</label>'); 
                $('#btAdd4').attr('class', 'bt-disable'); 
                $('#btAdd4').attr('disabled', 'disabled');

            }
        });

        $('#btRemove4').click(function() {   // REMOVE ELEMENTS ONE PER CLICK.
            if (iCnt != 0) { $('#tb' + iCnt).remove();$('#stb' + iCnt).remove(); iCnt = iCnt - 1; }
        
                if (iCnt == 0) { $(container).empty(); 
        
                $(container).remove(); 
                $('#btSubmit').remove(); 
                $('#btAdd4').removeAttr('disabled'); 
                $('#btAdd4').attr('class', 'bt') 

            }
        });
        
        $('#btAdd5').click(function() {
            if (iCnt2 <= 49) {

                iCnt2 = iCnt2 + 1;

                // ADD TEXTBOX.
                $(container2).append('<input type=text style=width:175px class=vv1 placeholder="Heading '+iCnt2+'" id=sstb' + iCnt2 +'><input type=text class="input5" id=tb' + iCnt2 + ' ' +
                            ' placeholder="Title Option ' + iCnt2 + '" />');

                if (iCnt2 == 1) {        // SHOW SUBMIT BUTTON IF ATLEAST "1" ELEMENT HAS BEEN CREATED.

                    var divSubmit2 = $(document.createElement('div'));
                    $(divSubmit2).append('<input type=button class="bt2"  onclick="GetTextValue4()"' + 
                            'id=btSubmit value=Save />');

                }

                $('#ar2').after(container2, divSubmit2);   // ADD BOTH THE DIV ELEMENTS TO THE "main" CONTAINER.
            }
            else {      // AFTER REACHING THE SPECIFIED LIMIT, DISABLE THE "ADD" BUTTON. (20 IS THE LIMIT WE HAVE SET)
                
                $(container2).append('<label>Reached the limit</label>'); 
                $('#btAdd5').attr('class', 'bt-disable'); 
                $('#btAdd5').attr('disabled', 'disabled');

            }
        });

        $('#btRemove5').click(function() {   // REMOVE ELEMENTS ONE PER CLICK.
            if (iCnt2 != 0) { $('#tb' + iCnt2).remove();$('#stb' + iCnt2).remove(); iCnt2 = iCnt2 - 1; }
        
                if (iCnt2 == 0) { $(container2).empty(); 
        
                $(container2).remove(); 
                $('#btSubmit').remove(); 
                $('#btAdd5').removeAttr('disabled'); 
                $('#btAdd5').attr('class', 'bt2') 

            }
        });
        }
        
    });
    });
    // PICK THE VALUES FROM EACH TEXTBOX WHEN "SUBMIT" BUTTON IS CLICKED.
    var divValue, values = '', rval='';
    var divValue2, values2 = '',rval2='';
    
    function GetTextValue() {

        $(divValue).empty(); 
        $(divValue).remove(); values = '';

        $('.input').each(function() {
            divValue = $(document.createElement('div')).css({
                padding:'5px', width:'285px'
            });
            values += this.value + ','
        });
        $('.vv').each(function() {
            rval += this.value + ','
        });        
        $(divValue).append('<p><b>Your selected values</b></p>' + values);
        $('body').append(divValue);
        
        $(divValue).load('get_option.php?op='+values+'&cop='+rval);
        $('#tt').val(values);
        $('#tv').val(rval);
    }
    
    function GetTextValue2() {

        $(divValue2).empty(); 
        $(divValue2).remove(); values2 = '';

        $('.input2').each(function() {
            divValue2 = $(document.createElement('div')).css({
                padding:'5px', width:'200px'
            });
            values2 += this.value + '<br>';
            
        });
        $(divValue2).append('<p><b>Your selected values</b></p>' + values2);
        $('body').append(divValue2);
        
        
       // $(divValue2).load('get_option.php?op='+values);
    }
   
    function GetTextValue3() {
        
        $(divValue).empty(); 
        $(divValue).remove(); values = '';

        $('.input').each(function() {
            divValue = $(document.createElement('div')).css({
                padding:'5px', width:'200px'
            });
            values += this.value + ','
        });
        $('.vv').each(function() {
            rval += this.value + ','
        });        
        
        $(divValue).append('<p><b>Your selected values</b></p>' + values);
        $('body').append(divValue);
        $('#tt').val(values);
        $('#tv').val(rval);
        
    }
    function GetTextValue4() {
        
        $(divValue2).empty(); 
        $(divValue2).remove(); values2 = '';

        $('.input5').each(function() {
            divValue2 = $(document.createElement('div')).css({
                padding:'5px', width:'200px'
            });
            values2 += this.value + ','
        });
        $('.vv1').each(function() {
            rval2 += this.value + '='
        });     
        
        $(divValue2).append('<p><b>Your selected values</b></p>' + values2);
        $('body').append(divValue2);
        $('#tt1').val(values2);
       $('#tt2').val(rval2);
        
    }
    
</script>

<script type="text/javascript">
document.getElementById('pn').value = "<?php echo $_POST['pn'];?>";
</script>

<script type="text/javascript">
        var specialKeys = new Array();
        specialKeys.push(8); //Backspace
        specialKeys.push(9); //Tab
        specialKeys.push(46); //Delete
        specialKeys.push(36); //Home
        specialKeys.push(35); //End
        specialKeys.push(37); //Left
        specialKeys.push(39); //Right
        function IsAlphaNumber(e) {
            var keyCode = e.keyCode == 0 ? e.charCode : e.keyCode;
            var ret = ((keyCode >= 48 && keyCode <= 57) || (keyCode >= 65 && keyCode <= 90) || (keyCode >= 97 && keyCode <= 122) || (specialKeys.indexOf(e.keyCode) != -1 && e.charCode != e.keyCode));
            document.getElementById("error").style.display = ret ? "none" : "inline";
            return ret;
        }

        function IsNotAlphaNumber(e) {
              var keyCode = e.keyCode == 0 ? e.charCode : e.keyCode;
             //var ret = ((keyCode >= 48 && keyCode <= 57) || (keyCode >= 65 && keyCode <= 90) || (keyCode >= 97 && keyCode <= 122) || (specialKeys.indexOf(e.keyCode) != -1 && e.charCode != e.keyCode));

         var address = document.getElementById('qtitle').value;
          
            //var ret= (/[^a-zA-Z0-9\-\/]/.test(address));
            //document.getElementById("qerror").style.display = ret ? "none" : "inline";
            //return ret;

             //if(/[d-z]/.test(address)) 
              //{ alert('Not allowed'); return false;}
             
          
  if(JSON.parse(address))
  {
    alert('One or more illegal characters were found, the first being character ' + ( result.index + 1 ) + ' "' + result +'".\
\
Please edit your input.');
  }



        }

</script>
