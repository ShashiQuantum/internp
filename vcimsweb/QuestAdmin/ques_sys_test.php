<?php

include_once('../init.php');
include_once('../functions.php');


if(isset($_REQUEST['st']))
{
	$st = $_REQUEST['st'];
}
else
{
	$st = 2;
}   
$msg='';
if($st==-98)
{
    $msg='Create New QuestionSet';    
} 
if($st==-99)
{
    $msg='Create New  Project';    
} 
if($st==-97)
{
    $msg='Add New QuestionSet';    
} 
if($st==-96)
{
    $msg='Add Project Center';    
} 
if($st==2)
{
    $msg='Create New Question';    
}    
if($st==4)
{
    $msg="Add Routine Flow";    
}
if($st==3)
{
    $msg='View/Edit Routine Flow';    
}
if($st==5)
{
    $msg='Add Question Sequence Flow';    
}


if(isset($_POST['ar_submit']))
{
    //print_r($_POST);
    //ar_submit
    $pid=$_POST['pn'];
    $qset=$_POST['qset'];
    $qid=$_POST['qid'];
    $sec=$_POST['sec'];

    if($qid==0 || $qid==-1)
    {
             $r=$_POST['routine'];
             $nq=$_POST['nsqid'];
             $sql="INSERT INTO vcimstest.`question_routine_detail`(`qset_id`, `q_id`, `next_qid`,`qsec`, `routine`) VALUES ($qset,$qid,$nq,$sec,'$r')";  
             DB::getInstance()->query($sql);
    }
    else
    {
   echo $qtd="SELECT  `q_type` FROM vcimstest.`question_detail` WHERE `q_id`=$qid";
    $qtd1=DB::getInstance()->query($qtd);
    $qt=$qtd1->first()->q_type;
    
    if($qt=='radio' || $qt=='checkbox' || $qt=='rating')
    {
        $j=0;$t1='';$t2='';$t3='';$t4='';
        foreach($_POST as $k=>$v)
        {  
           if($k!='pn') if($k!='qset')if($k!='qid') if( $k!='sec') if($k!='ar_submit')
           { 
               //echo '<br>'.$k.'='.$v;
               $j++;
               if($j==1) $t1=$v;
               if($j==2) $t2=$v;
               if($j==3) $t3=$v;
               if($j==4)
               {
                   $t4=$v; 
                 echo '<br>'.  $sql="INSERT INTO vcimstest.`question_routine_detail`(`qset_id`, `q_id`, `next_qid`, `op_value`, `qsec`, `routine`) VALUES ($qset,$qid,$t4,'$t2',$sec,'$t3')"; $j=0; 
                  // DB::getInstance()->query($sql);
               }
           }
        }
    }// end of radio type
    if($qt=='instruction' || $qt=='text' || $qt=='textarea' || $qt=='textrating' || $qt=='title2rating' || $qt=='dropdown')
    {
        $r=$_POST['routine'];
        $nq=$_POST['nsqid'];
             $sql="INSERT INTO vcimstest.`question_routine_detail`(`qset_id`, `q_id`, `next_qid`,`qsec`, `routine`) VALUES ($qset,$qid,$nq,$sec,'$r')";  
             DB::getInstance()->query($sql);
    }
    if($qt=='calculated')
    {
        $ctr=0;
        if($_POST['join0']!='none' && $_POST['join1']!='none')
        {
            $ctr=3;
        }
        else if($_POST['join0']!='none' && $_POST['join1']=='none')  
        {
            $ctr=2;
        }
        else 
        {
            $ctr=1;
        }        
        for($i=0;$i<$ctr;$i++)
        {    
            $nq=$_POST["nsqid$i"];
            $tot=$_POST["wt$i"];
            $comp=$_POST["comp$i"];
            $r=$_POST["routine$i"];
            $jn=$_POST["join$i"];
            
        echo '<br>'.$sql="INSERT INTO vcimstest.`question_routine_detail`(`qset_id`, `q_id`, `next_qid`, `op_value`, `qsec`, `routine`,compare_sign,join_with) VALUES ($qset,$qid,$nq,'$tot',$sec,'$r','$comp','$jn')";
        DB::getInstance()->query($sql);
        }
    }
    if($qt=='sec')
    {
        $length  = count( array_keys( $_POST, "yes" ));
        $ctr=$length+1;      
        for($i=0;$i<$ctr;$i++)
        {    
            $nq=$_POST["nsqid$i"];
            //$tot=$_POST["wt$i"];
            $comp=$_POST["comp$i"];
            $r=$_POST["routine$i"];
            $jn=$_POST["join$i"];      
        echo '<br>'.$sql="INSERT INTO vcimstest.`question_routine_detail`(`qset_id`, `q_id`, `next_qid`, `op_value`, `qsec`, `routine`) VALUES ($qset,$qid,$nq,'$comp',$sec,'$r')";
        DB::getInstance()->query($sql);
        }
    }
    }
     echo '<font color=red>routine added successfully</font>';
}
//centre project create
if(isset($_POST['pc_submit']))
{
    $pid=$_POST['pn'];
    $qset=$_POST['qset'];
   echo $st=$_POST['centre'];
    if($pid!='0' && $qset!='0' && $st!='' )
    {   
        $pp=DB::getInstance()->query("INSERT INTO vcimstest.`centre_project_details`(`centre_id`, `project_id`, `q_id`) VALUES($st,$pid,$qset)");        
        echo '<font color=red>Centre for project has created successfully </font>';        
    }else
       echo 'pls fill all the details';
}

//when submit button is clicked for new question
if(isset($_POST['nq_submit']))
{
    //print_r($_POST);
    $q=$_POST['qtitle'];
    $qt=$_POST['qt'];
    $file=$_FILES['qfile'];
    $trm=$_POST['term'];
    
    if($q!='')
    {   
         if($qt=='sec' || $qt=='calculated')
        {
            $sq1="INSERT INTO vcimstest.`question_detail`(`q_title`, `q_type`) VALUES ('$q','$qt')";
            $qcreate=DB::getInstance()->query($sq1);
            $qid=$qcreate->last();
             
            $qop=DB::getInstance()->query("INSERT INTO vcimstest.`question_option_detail`( `q_id`,`term`) VALUES ($qid,'$trm')");
            echo 'Successfully created with Question Id: '.$qid; 
            
        }
        if($qt=='radiomedia' || $qt=='checkboxmedia')
        {   echo 'post:<br>';
            print_r($_POST);echo 'files:<br>';
            // $_FILES['f1'];
            print_r($_FILES);
            
        }
        if($qt=='rating' )
        {
            $ssv=$_POST['froms'];
            $esv=$_POST['tos'];
            $lforms=$_POST['lfroms'];
            $ltos=$_POST['ltos'];
            
          // print_r($_POST);
            $sq1="INSERT INTO vcimstest.`question_detail`(`q_title`, `q_type`) VALUES ('$q','$qt')";
            $qcreate=DB::getInstance()->query($sq1);
            $qid=$qcreate->last();
            
            $sq2="INSERT INTO vcimstest.`question_option_detail`( `q_id`,`term`,scale_start_value,scale_end_value,scale_start_label,scale_end_label) VALUES ($qid,'$trm','$ssv','$esv','$lforms','$ltos')";
            $qop=DB::getInstance()->query($sq2);
            echo 'Successfully created with Question Id: '.$qid; 
            
        }
        if($qt=='top3rankcompany')
        {
            $qcreate=DB::getInstance()->query("INSERT INTO vcimstest.`question_detail`(`q_title`, `q_type`) VALUES ('$q','$qt')");
            $qid=$qcreate->last();
            $qop=DB::getInstance()->query("INSERT INTO vcimstest.`question_option_detail`( `q_id`,`term`) VALUES ($qid,'$trm')");
            echo 'Successfully created with Question Id: '.$qid; 
            
        }
        if($qt=='instruction')
        {
                $file=$_FILES['qfile'];
                
            $sq1="INSERT INTO vcimstest.`question_detail`(`q_title`, `q_type`) VALUES ('$q','$qt')";
            $qcreate=DB::getInstance()->query($sq1);
            $qid=$qcreate->last();
            //$sq2="INSERT INTO vcimstest.`question_option_detail`( `q_id`,`term`) VALUES ($qid,'$trm')";
            //$qop=DB::getInstance()->query($sq2);
            echo 'Successfully created with Question Id: '.$qid; 
            
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
                    $qop1=DB::getInstance()->query("UPDATE vcimstest.`question_detail` SET `image`=$target_file WHERE `q_id`");
                if($uFileType=='mp3')
                    $qop1=DB::getInstance()->query("UPDATE vcimstest.`question_detail` SET `audio`=$target_file WHERE `q_id`");
                if($uFileType=='mp4')    
                    $qop1=DB::getInstance()->query("UPDATE vcimstest.`question_detail` SET `video`=$target_file WHERE `q_id`");
            } else 
            {
                //echo "<br>Sorry, there was an error uploading your file.";
            }
            //echo "Return Code: " . $_FILES["qfile"]["error"] . "<br />";
            
        }
        if($qt=='text' || $qt=='textarea' || $qt == 'dropdown')
        {  
               
            $qcreate=DB::getInstance()->query("INSERT INTO vcimstest.`question_detail`(`q_title`, `q_type`) VALUES ('$q','$qt') ");
            $qid=$qcreate->last();
            $qop=DB::getInstance()->query("INSERT INTO vcimstest.`question_option_detail`( `q_id`,`term`) VALUES ($qid,'$trm')");
            echo 'Successfully created with Question Id: '.$qid; 
            
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
            $sq1="INSERT INTO vcimstest.`question_detail`(`q_title`, `q_type`) VALUES ('$q','$qt')";
            $qcreate=DB::getInstance()->query($sq1);
            $qid=$qcreate->last();
            for($i=0;$i<$opt_len;$i++)
            {
            $sq2="INSERT INTO vcimstest.`question_option_detail`( `q_id`, `opt_text_value`, `value`, `term`) VALUES ($qid,'$arr_opt[$i]',$arr_opv[$i],'$trm')";    
            $qop=DB::getInstance()->query($sq2);
            }
            echo 'Successfully created with Question Id:<font color=red> '.$qid; 
            
        }
        if($qt=='textrating')
        {
            
            $txth=$_POST['txthead'];
            $txtt=$_POST['txtterm'];
            $ntxt=$_POST['ntxt'];
            $rh=$_POST['rathead'];
            $rt=$_POST['ratterm'];
            $tt=$_POST['tt'];
            $tv=$_POST['tv'];
                    $tt=substr($tt,0,(strlen($tt)-1));
            
            $arr_opt=  explode(',', $tt);  
            $arr_opv=  explode(',', $tv);
            $opt_len=count($arr_opt);
            $opv_len=count($arr_opv);
            print_r($arr_opt);
            print_r($arr_opv);
            $qcreate=DB::getInstance()->query("INSERT INTO vcimstest.`question_detail`(`q_title`, `q_type`) VALUES ('$q','$qt')");
            $qid=$qcreate->last();
            for($i=0;$i<$opt_len;$i++)
            {
                echo '<br>'.$sql="INSERT INTO vcimstest.`question_option_detail`( `q_id`,rating1_title,rating1_value,txt_heading,rating1_heading,text_term,rating_term,textbox_count ) VALUES ($qid,'$arr_opt[$i]','$arr_opv[$i]','$txth','$rh','$txtt','$rt',$ntxt)";
                $qop=DB::getInstance()->query($sql);
            }
            
            echo 'Successfully created with Question Id: '.$qid;
        }
        if($qt=='title2rating')
        {
            print_r($_POST);
           // $txth=$_POST['txthead'];
            $txtt=$_POST['txtterm'];
            
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
           
            $qcreate=DB::getInstance()->query("INSERT INTO vcimstest.`question_detail`(`q_title`, `q_type`) VALUES ('$q','$qt')");
            $qid=$qcreate->last();
            //$qid=27;
            for($i=0;$i<$opt_len;$i++)
            {
                echo '<br>'.$sql="INSERT INTO vcimstest.`question_option_detail`( `q_id`,rating1_title,rating1_value,txt_heading,rating1_heading,rating2_heading, text_term, rating_term, rating2_term, opt_text_value ) VALUES ($qid,'$arr_opt[$i]','$arr_opv[$i]','$arr_opt2[$i]','$rh','$rh2','$txtt','$rt','$rt2','$arr_opt1[$i]')";
                $qop1=DB::getInstance()->query($sql);
            }
            
            echo 'Successfully created with Question Id: '.$qid;
            
        }
        
    }
    else
        echo 'pls type new question you want to add';
}
//create a new project
if(isset($_POST['cp_submit']))
{
    $pn=$_POST['pname'];
    $b=$_POST['brand'];
    $ccn=$_POST['ccn'];
    $v=$_POST['visit'];
    $rt=$_POST['rt'];
    
    if($pn!='' && $b!='' && $ccn!=''&& $v!='' && $rt!='select')
    {   
        $ss=DB::getInstance()->query("select name from vcimstest.project where name='$pn'");
        if($ss->count()>0)
            echo '<font color=red>Project Name you have entered is already exist. Pls enter unique project name</font>';
        else {
        $pp=DB::getInstance()->query("INSERT INTO vcimstest.`project`(`name`, `company_name`, `brand`, `research_type`,tot_visit) VALUES ('$pn','$ccn','$b','$rt',$v)");
        
        echo 'Project Id: <font color=red>'.$pp->last().'</font> has created successfully';
        }
    }else
       echo 'pls fill all the project details';
}

//create a new questionset
if(isset($_POST['qs_submit']))
{
     $pid=$_POST['pn'];
    $v=$_POST['visit'];
    if($pid!='select' && $v!='' || $v!=0 )
    {   
        $pp=DB::getInstance()->query("INSERT INTO vcimstest.`questionset`(`project_id`,visit_no) VALUES ($pid,$v)");        
        echo 'QuestionSet Id: <font color=red>'.$pp->last().'</font> has created successfully';        
    }else
       echo 'pls fill all the details';
}

//create a new question section
if(isset($_POST['qsec_submit']))
{
     $pid=$_POST['pn'];
    $qset=$_POST['qset'];
    $st=$_POST['stitle'];
    if($pid!='0' && $qset!='0' && $st!='' )
    {   
        $pp=DB::getInstance()->query("INSERT INTO vcimstest.`question_sec`( `sec_title`, `qset_id`) VALUES ('$st',$qset)");        
        echo 'Section Id: <font color=red>'.$pp->last().'</font> has created successfully';        
    }else
       echo 'pls fill all the details';
}

if(isset($_POST['qrf_submit']))
{
    $pid=$_POST['pn'];
    $qset=$_POST['qset'];
    $qid=$_POST['qid'];
    $rov=$_POST['rov'];
    $r=$_POST['routine'];
    $nq=$_POST['nsqid'];
    $sec=$_POST['sec'];
    $pp=DB::getInstance()->query("INSERT INTO vcimstest.`question_routine_detail`(`qset_id`, `q_id`, `next_qid`, `op_value`, `qsec`, `routine`) VALUES ($qset,$qid,$nq,'$rov',$sec,'$r')");
    echo 'Submitted';
}
?>
<html>
	<head>
		<title>Rent Request Panel</title>
	</head>
	
	<body>
        <center>
	<table cellpadding="10" cellspacing="5">
		<tr>
			<td><a href="?st=-99">Add Project</a></td>
			<td><a href="?st=-98">Add Question Set/Visit</a></td>
                        <td><a href="?st=-97">Add Question Section</a></td>
                        <td><a href="?st=-96">Add Project Centre</a></td>
			<td><a href="?st=2">Add Question</a></td>
			<td><a href="?st=3">View/Edit Routine</a></td>
			<td><a href="?st=4">Add Routine Flow</a></td>
                        <td><a href="?st=5">Add Question Sequence Flow</a></td>
		</tr>
		<tr>
			<td colspan="10"><center><h2><?= $msg ?></h2></center></td>
		</tr>
	</table>
            
            <?php if($st==-99) { ?>      
        
        <table cellpadding="2" cellspacing="1" border="1" style="font-size:12px;">
     	<form action="" method="post">
                <tr><td>Project Name </td><td> <input type="text" name="pname" id="pname"></td></tr>
                <tr><td>Brand</td><td><input type="text" name="brand" id="brand"></td></tr>
                <tr><td>Client Company Name</td><td><input type="text" name="ccn" id="ccn"></td></tr>
                <tr><td>Visit Count</td><td><input type="number" name="visit" id="visit"></td></tr>                
                <tr><td>Research Type</td><td><select name="rt" id="rt"><option value="select">--Select--</option><option>Product Testing</option><option>Mystery Shopping</option></select></td></tr>                
                <tr><td colspan="2"><center><input type="submit" name="cp_submit" onclick="return confirm('Are you sure?');" value="Create Project"></center></td></tr>                
                </form>
        </table>
<?php } if($st==-98) { ?>
         <table>
             
            <table cellpadding="2" cellspacing="1" border="1" style="font-size:12px;">
		<form action="" method="post"><tr><td>Project Name </td><td> <select name="pn" id="pn"><option value="select">--Select--</option><?php $pj=get_projects_details_test();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr>
                <tr><td>Current Visit</td><td><input type="number" name="visit" id="visit"></td></tr>
                <tr><td colspan="2"><center><input type="submit" name="qs_submit" onclick="return confirm('Are you sure?');" value="Create QuestionSet"></center></td></tr>                
                </form>
        </table>
<?php } if($st==-97) { ?>
         <table>
            
            <table cellpadding="2" cellspacing="1" border="1" style="font-size:12px;">
		<form action="" method="post">

<tr><td>Project Name</td> </td><td> <select name="pn" id="pn" onchange="displib2();"><option value="0">--Select--</option><?php $pj=get_projects_details_test();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr><tr><td>QuestionSet ID </td><td><select name="qset" id="qset" onchange="displib4();"><option value="select">--Select--</option> </select> </td></tr>


                   
                <tr><td>Section Title</td><td><input type="text" name="stitle" id="stitle"></td></tr>
                <tr><td colspan="2"><center><input type="submit" name="qsec_submit" onclick="return confirm('Are you sure?');" value="Add Question Section"></center></td></tr>                
                </form>
        </table>
<?php } if($st==-96) { ?>
         <table>             
            <table cellpadding="2" cellspacing="1" border="1" style="font-size:12px;">
		<form action="" method="post">
                    <tr><td>Project Name</td> </td><td> <select name="pn" id="pn" onchange="displib2();"><option value="0">--Select--</option><?php $pj=get_projects_details_test();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr><tr><td>QuestionSet ID </td><td><select name="qset" id="qset" onchange="displib4();"><option value="select">--Select--</option> </select> </td></tr>

                    <tr><td> Centre </td><td><select name="centre"><?php $dc1=DB::getInstance()->query("SELECT * FROM `centre`"); foreach($dc1->results() as $cn){ $cid=$cn->centre_id; ?> <option value=<?php echo $cid;?> > <?php echo $cn->cname; ?> </option> <?php }?></select></td></tr>
                <tr><td colspan="2"><center><input type="submit" name="pc_submit" onclick="return confirm('Are you sure?');" value="Submit"></center></td></tr>                
                </form>
        </table>          
<?php } if($st==2) { ?>	
	<table cellpadding="2" cellspacing="1" border="0" style="font-size:12px;">
               <form action="" method="post" enctype="multipart/form-data">
               <!-- <tr><td>Project Name </td><td> <select name="pn" id="pn"><option value="0">--Select--</option><?php $pj=get_projects_details_test();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr>  -->                  
                <tr><td>Question Type </td><td> <select name="qt" id="qt"><option value="text">Text</option><option value="textarea">TextArea</option><option value="radio">Radio</option><option value="checkbox">CheckBox</option><option value="radiogrid">Radio Grid</option><option value="radiomedia">RadioMedia</option> <option value="checkboxmedia">CheckBoxMedia</option><option value="instruction">Instruction</option><option value="textrating">Textbox with Rating</option><option value="dropdown">DropdownList</option><option value="title2rating">Title with Double Rating</option><option value="calculated">Calculated</option><option value="top3rankcompany">Top3RankCompany</option><option value="rating">Rating</option><option value='sec'>SEC</option> </select> </td></tr>
                <tr><td>Question Title</td><td> <textarea rows="5" cols="30" name="qtitle" id="qtitle" placeholder="type new question here"></textarea></td></tr>
                <tr><td>Question Image/Video/Audio</td><td> <input type="file" name="qfile" id="qfile" placeholder="type new question here"></td></tr>
                <tr><td>Question Term</td><td><select name='term' id='term'><option value='select'>--Select--</option><option value='NA'>Not Applicable</option><?php $pj=get_terms();foreach($pj as $p){ $cn=$p->COLUMN_NAME;$tn=$p->TABLE_NAME;?><option value='<?php echo $cn;?>'><?php echo $tn.'-- '.$cn;?></option><?php }?></select> <a href="create_table_column_test.php" target="_blank">New Term</a> </td></tr>
                <!-- for textrating question type -->
                
                <tr><td></td><td><div id="media" style="display:none">
                            <font color="red"> How many option's you want to add : </font> <input type="number" name="coln" id="coln" min="1" onchange="displib5();"> 
                </div></td></tr>
                
                <tr><td></td><td><div id="main_textrating" style='display:none'> 
                <fieldset style='width:200px'>
                <legend><font color=blue>Specify TextBox Setting:</font></legend>
                Heading: <input type="text" name="txthead" placeholder="Heading for All TextBox"><br>
                Term: <select name='term1' id='term1'><option value="select">--Select--</option><?php $pj=get_terms();foreach($pj as $p){?><option value="<?php echo $p->COLUMN_NAME;?>"><?php echo $p->COLUMN_NAME;?></option><?php }?></select><br>
                No of TextBox: <input type="number" name="ntxt" placeholder="Total TextBox you want"><br>
                </fieldset> 
                <fieldset style='width:200px'>
                <legend><font color=blue>Specify Rating Setting:</font></legend>
                Heading: <input type="text" name="rathead" placeholder="Heading for All Ratings"><br>
                Term: <select name='term2' id='term2'><option value="select">--Select--</option><?php $pj=get_terms();foreach($pj as $p){?><option value="<?php echo $p->COLUMN_NAME;?>"><?php echo $p->COLUMN_NAME;?></option><?php }?></select><br>
                 <p>Add Ratings</p>
                <div id="ar"></div>
                </fieldset>
                </div> </td></tr>
                
                <!-- for title2rating question type -->
                <tr><td></td><td><div id="main_textrating2" style='display:none'> 
                <fieldset style='width:200px'>
                <legend><font color=blue>Specify TitleOption Setting:</font></legend>
               <!-- Heading: <input type="text" name="txthead" placeholder="Heading for All TextBox"><br> -->
                Term: <select name='term3' id='term3'><option value="select">--Select--</option><?php $pj=get_terms();foreach($pj as $p){?><option value="<?php echo $p->COLUMN_NAME;?>"><?php echo $p->COLUMN_NAME;?></option><?php }?></select><br>
                <p>Added Title</p>
                
                <div id="ar2"></div>
                </fieldset> 
                <fieldset style='width:200px'>
                <legend><font color=blue>Specify Rating Setting:</font></legend>
                Heading 1: <input type="text" name="rathead" placeholder="Heading for Ratings"><br>
                Term 1: <select name4='term4' id='term4'><option value="select">--Select--</option><?php $pj=get_terms();foreach($pj as $p){?><option value="<?php echo $p->COLUMN_NAME;?>"><?php echo $p->COLUMN_NAME;?></option><?php }?></select><br>
                Heading 2: <input type="text" name="rathead2" placeholder="Heading 2 for Ratings"><br>
                Term 2: <select name='term4' id='term4'><option value="select">--Select--</option><?php $pj=get_terms();foreach($pj as $p){?><option value="<?php echo $p->COLUMN_NAME;?>"><?php echo $p->COLUMN_NAME;?></option><?php }?></select><br>
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
                
<?php } if($st==3) { ?>        
                
             <center><form action="" method="post"> <table><tr><td>Project Name</td> </td><td> <select name="pn" id="pn" onchange="displib2();"><option value="0">--Select--</option><?php $pj=get_projects_details_test();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td><td>QuestionSet ID </td><td><select name="qset" id="qset" onchange="displib4();"><option value="select">--Select--</option> </select> </td><td><input type="submit" name="view" value="View"></td></tr></table></form></center>
             
            
<?php } if($st==4){ ?>
            
            <form action="" method="post">
             <table cellpadding="2" cellspacing="1" border="0" style="font-size:12px;">
		
                <tr><td>Project Name </td><td> <select name="pn" id="pn" onchange="displib2();"><option value="0">--Select--</option><?php $pj=get_projects_details_test();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr>
                <tr><td>QuestionSet ID </td><td><select name="qset" id="qset" onchange="displib();"><option value="select">--Select--</option> </select> </td></tr>
                <tr><td>Question ID </td><td> <select name="qid" id="qid" onchange="displib3();"> <option value="0">--Select--</option></select> </td></tr>
                 <tr><td>Section ID </td><td> <select name="sec" id="sec"> <option value="0">--Select--</option></option> <?php $ds=get_sections();foreach($ds as $d){ $qid=$d->qsec_id;?> <option value="<?= $qid ?>"><?php echo $qid; ?></option> <?php } ?></select> </td></tr>                            
                 <tr><td></td><td><div id="qo"></div></td></tr>
                    <tr><td></td><td><input type="submit" name="ar_submit" value="Submit" onclick="return confirm('Are you sure?');"></td></tr>
            </table>
             </form>   
<?php } if($st==5) { ?>        
                
             <center><form action="" method="post"> <table><tr><td>Project Name</td> </td><td> <select name="pn" id="pn" onchange="displib2();"><option value="0">--Select--</option><?php $pj=get_projects_details_test();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr><tr><td>QuestionSet ID </td><td><select name="qset" id="qset" onchange="displib6();"><option value="select">--Select--</option> </select> </td></tr>
             <tr><td>Section ID </td><td> <select name="sec" id="sec" onchange="displib7();"> <option value="0">--Select--</option></option> <?php $ds=get_sections();foreach($ds as $d){ $qid=$d->qsec_id;?> <option value="<?= $qid ?>"><?php echo $qid; ?></option> <?php } ?></select> </td></tr>
             <tr><td>Question ID </td><td> <select name="qid" id="qid" > <option value="0">--Select--</option></select> </td></tr>
             <tr><td>Question Sequence within a Section </td><td> <input type=number name="qsequence" id="qsequence" min=1 max=100> </td></tr>
             <tr><td></td><td><input type="submit" name="qsnc_update" value="Update"></td></tr></table></form></center>  
<?php } ?>



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
        
        </body>
</html>
  
<?php 
if(isset($_POST['qsnc_update']))
{

      $pn=$_POST['pn'];
      $qst=$_POST['qset'];
      $qsc=$_POST['sec'];
      $qid=$_POST['qid'];
      $qsval=$_POST['qsequence'];
      
      $qr="UPDATE vcimstest.`question_routine_detail` SET `qsequence`=$qsval WHERE `qsec`=$qsc and `q_id`=$qid and `qset_id`=$qst";
      $dd=DB::getInstance()->query($qr);
      if($dd)
         echo "<font color=red>updated successful of qid: $qid </font>";
      else
         echo "<font color=red>error... not updated of qid: $qid </font>";
}

if(isset($_POST['view']))
{
    //print_r($_POST);
    $pn=$_POST['pn'];
    $qs=$_POST['qset'];
    echo "<center><hr><table cellpadding=0 cellspacing=0 border=1 style=font-size:12px;><tr bgcolor=lightgray><td>Current Question</td><td>Option Value</td><td>Compare With</td><td>Routine Flow</td><td>Next Question </td><td>Section ID</td><td>Action</td></tr>";

    $qtd="SELECT  id,`q_id`, `next_qid`, `op_value`, `qsec`, `routine`, `compare_sign` FROM vcimstest.`question_routine_detail` WHERE `qset_id`=$qs";
    $dd=DB::getInstance()->query($qtd);
    if($dd->count()>0)
    {
        foreach($dd->results() as $d)
        { 
            //echo "<form action='' method=post>";
            //echo "<input type=hidden name=qid value=$d->q_id> <input type=hidden name=cs value=$d->compare_sign> <input type=hidden name=rt value=$d->routine><input type=hidden name=nqid value=$d->next_qid><input type=hidden name=qsec value=$d->qsec>";
            echo "<form action='' method=post><tr id=show$d->id ><td>$d->q_id</td><td>$d->op_value</td><td>$d->compare_sign</td><td>$d->routine</td><td>$d->next_qid </td><td>$d->qsec </td><td><a href=#edit$d->id onclick=edit($d->id)>edit</a> </td> </tr></form>";
            echo "<form action='' method=post><tr id=edit$d->id style=display:none><td><input type=hidden name=qs value=$qs><input type=hidden name=id value=$d->id><input type=text name=qid STYLE='color: red;'  value=$d->q_id></td><td><input type=text name=opv STYLE='color: red;' value=$d->op_value></td><td><input type=text name=cs STYLE='color: red;' value=$d->compare_sign></td><td><input type=text name=rt STYLE='color: red;' value=$d->routine></td><td><input type=text name=nqid STYLE='color: red;' value=$d->next_qid></td><td><input type=text name=qsec STYLE='color: red;' value=$d->qsec></td><td><input type=submit name=submit value=Save><br><a href=#show$d->id onclick=show($d->id)>Cancel</a> </td> </tr></form>";
            
        }
    }
        echo '</table>';
        
}
if(isset($_POST['submit']))
{
    //print_r($_POST);
    $qid=$_POST['qid'];
    $opv=$_POST['opv'];
    $nqid=$_POST['nqid'];
    $qsec=$_POST['qsec'];
    $r=$_POST['rt'];
    $c=$_POST['cs'];
    $qs=$_POST['qs'];
    $id=$_POST['id'];
    $sql="UPDATE vcimstest.`question_routine_detail` SET `q_id`=$qid ,`op_value`='$opv' ,next_qid=$nqid,`qsec`=$qsec ,`routine`='$r' ,`compare_sign`='$c' WHERE id=$id";
    
    $d=DB::getInstance()->query($sql);

       echo "<center><hr><table cellpadding=0 cellspacing=0 border=1 style=font-size:12px;><tr bgcolor=lightgray><td>Current Question</td><td>Option Value</td><td>Compare With</td><td>Routine Flow</td><td>Next Question </td><td>Section ID</td><td>Action</td></tr>";

    $qtd="SELECT  id, `q_id`, `next_qid`, `op_value`, `qsec`, `routine`, `compare_sign` FROM vcimstest.`question_routine_detail` WHERE `qset_id`=$qs";
    $dd=DB::getInstance()->query($qtd);
    if($dd->count()>0)
    {
        foreach($dd->results() as $d)
        { 
              echo "<form action='' method=post><tr id=show$d->id ><td>$d->q_id</td><td>$d->op_value</td><td>$d->compare_sign</td><td>$d->routine</td><td>$d->next_qid </td><td>$d->qsec </td><td><a href=#edit$d->id onclick=edit($d->id)>edit</a> </td> </tr></form>";
              echo "<form action='' method=post><tr id=edit$d->id style=display:none><td><input type=hidden name=qs value=$qs><input type=hidden name=id value=$d->id><input type=text name=qid STYLE='color: red;'  value=$d->q_id></td><td><input type=text name=opv STYLE='color: red;' value=$d->op_value></td><td><input type=text name=cs STYLE='color: red;' value=$d->compare_sign></td><td><input type=text name=rt STYLE='color: red;' value=$d->routine></td><td><input type=text name=nqid STYLE='color: red;' value=$d->next_qid></td><td><input type=text name=qsec STYLE='color: red;' value=$d->qsec></td><td><input type=submit name=submit value=Save><br><a href=#show$d->id onclick=show($d->id)>Cancel</a> </td> </tr></form>";
             }
    }
        echo '</table>';
        
}
?>

<link rel="stylesheet" href="../../css/siteadmin.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript">  
    function edit(i){
        var show= 'show'+i;
        var edit= 'edit'+i;
        document.getElementById(show).style.display = 'none';
        document.getElementById(edit).style.display = 'table-row';
    }
    function show(i){
    var show= 'show'+i;
    var edit= 'edit'+i;
    var move= 'move'+i;
    document.getElementById(show).style.display = 'table-row';
    document.getElementById(edit).style.display = 'none';
    document.getElementById(move).style.display = 'none';
    }

</script>    


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
     
<script type="text/javascript">

function displib()
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
			document.getElementById('qid').innerHTML=pin.responseText;
                        //document.getElementById('qid2').innerHTML=pin.responseText;
                        //document.getElementById('qid3').innerHTML=pin.responseText;
			console.log(pin);
                        
		}
	}
	url="get_ques_not_qest.php?qset="+val;
	pin.open("GET",url,true);
	pin.send();
}

</script>
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
	url="get_qset_test.php?pid="+val;
	pin.open("GET",url,true);
	pin.send();
}
</script>
<script>
    function displib3()
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
	var val=document.getElementById('qid').value;
        //document.write('Hello: '+val);
	pin.onreadystatechange=function()
	{
		if(pin.readyState==4)
		{
			document.getElementById('qo').innerHTML=pin.responseText;
			console.log(pin);
		}
	}
	url="get_qoption_list.php?qid="+val;
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
function displib6()
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
        
	pin.onreadystatechange=function()
	{
		if(pin.readyState==4)
		{
			document.getElementById('sec').innerHTML=pin.responseText;
			console.log(pin);
		}
	}
	url="get_sec.php?qset="+val;
	pin.open("GET",url,true);
	pin.send();
}

function displib7()
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
	var val=document.getElementById('sec').value;
        
	pin.onreadystatechange=function()
	{
		if(pin.readyState==4)
		{
			document.getElementById('qid').innerHTML=pin.responseText;
			console.log(pin);
		}
	}
	url="get_sec_qlist.php?qsec="+val;
	pin.open("GET",url,true);
	pin.send();
}
function displib5()
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
	var val=document.getElementById('coln').value;
        //document.write('Hello: '+val);
	pin.onreadystatechange=function()
	{
		if(pin.readyState==4)
		{
			document.getElementById('media').innerHTML=pin.responseText;
                        //document.getElementById('qid2').innerHTML=pin.responseText;
                        //document.getElementById('qid3').innerHTML=pin.responseText;
			console.log(pin);
                        
		}
	}
	url="add_media.php?data="+val;
	pin.open("GET",url,true);
	pin.send();
}

</script>

<script>
  $(document).ready(function() {

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
        
            //alert($(this).val());
    
        // CREATE A "DIV" ELEMENT AND DESIGN IT USING JQUERY ".css()" CLASS.
        var container = $(document.createElement('div')).css({
            padding: '5px', margin: '20px', width: '285px', border: '1px dashed',
            borderTopColor: '#999', borderBottomColor: '#999',
            borderLeftColor: '#999', borderRightColor: '#999'
        });

        $('#btAdd').click(function() {
            if (iCnt <= 39) {

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
            if (iCnt1 <= 39) {

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
            if (iCnt2 <= 39) {

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
            
            if (iCnt <= 39) {

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
    
         if($(this).val()=='title2rating')
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
            
            if (iCnt <= 39) {

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
            if (iCnt2 <= 39) {

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

 
    