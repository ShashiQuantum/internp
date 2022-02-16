<?php

include_once('../init.php');
include_once('../functions.php');

header( 'Content-Type: text/html; charset=utf-8' ); 

echo "<div id=header>";
if(isset($_POST['logout']))
         {
            session_destroy();
		//Cookie::delete($this->_cookieName);
		
		Redirect::to('login_fp.php');
            
         }
        // echo "Hi <font color='lightgreen'>".Session::get('suser')."</font>";
 
        ?>

                            <form action="" method=post><input type=submit name=logout value=Logout></form>
                            <div style=float:right><img src='../../images/Digiadmin_logo.jpg' height=30 width=130> </div> 
                            <center><h3><font color=red >Translated Question Admin Panel</font></h3></center>
    </div>

<?php
if(isset($_REQUEST['st']))
{
	$st = $_REQUEST['st'];
}
else
{
	$st = 101;
}   
$msg='';


if($st==101)
{
    $msg='Add Translated Question';    
}    
if($st==102)
{
    $msg="Add Translated Question Options";    
}

if(isset($_POST['ar_submit']))
{
   //print_r($_POST);
    $qid=$_POST['qqid'];
    $lang=$_POST['lang'];
    $_SESSION['langop']=$lang;
      //to store all values
       $arr_post=array();
       foreach($_POST as $k=>$v)
       {  
            if($k == 'pn' || $k == 'qset' || $k=='save' || $k=='lang' || $k=='qqid'|| $k=='ar_submit')
               continue;           
              if($v!='')if($v!='select')
                  array_push($arr_post,$v);          
       }
      $tot=count($arr_post);
      
      $dd=DB::getInstance()->query("select q_type from question_detail WHERE q_id=$qid");
      if($dd->count()>0)
      {
        $qt=$dd->first()->q_type;

        if($qt=='radio' || $qt=='checkbox')
        {
            $size=$tot/3;
         
       if($lang=='1')
       {
       for($i=0;$i<$tot;$i+=3)
       { 
         $v1=$arr_post[$i]; $v2=$arr_post[$i+1]; $v3=$arr_post[$i+2];
         $sql="INSERT into `hindi_question_option_detail` (`q_id`, `opt_text_value`,code) VALUES ($qid,'$v2',$v3);";
         $dd2=DB::getInstance()->query($sql);
        echo "<br> $sql ";

       }
       }
       if($lang=='6')
       {
       for($i=0;$i<$tot;$i+=3)
       { 
         $v1=$arr_post[$i]; $v2=$arr_post[$i+1]; $v3=$arr_post[$i+2];
         $sql="INSERT into `bengali_question_option_detail` (`q_id`, `opt_text_value`,code) VALUES ($qid,'$v2',$v3);";
         $dd2=DB::getInstance()->query($sql);
        echo "<br> $sql ";

       }
       }

       if($lang=='2')
       {
       for($i=0;$i<$tot;$i+=3)
       { 
         $v1=$arr_post[$i]; $v2=$arr_post[$i+1]; $v3=$arr_post[$i+2];
         $sql="INSERT into `kannar_question_option_detail` (`q_id`, `opt_text_value`,code) VALUES ($qid,'$v2',$v3);";
         $dd2=DB::getInstance()->query($sql);
        echo "<br> $sql ";
       }
       }
       if($lang=='4')
       {
       for($i=0;$i<$tot;$i+=3)
       { 
         $v1=$arr_post[$i]; $v2=$arr_post[$i+1]; $v3=$arr_post[$i+2];
         $sql="INSERT into `tammil_question_option_detail` (`q_id`, `opt_text_value`,code) VALUES ($qid,'$v2',$v3);";
         $dd2=DB::getInstance()->query($sql);
        echo "<br> $sql ";

       }
       }

       if($lang=='5')
       {
       for($i=0;$i<$tot;$i+=3)
       { 
         $v1=$arr_post[$i]; $v2=$arr_post[$i+1]; $v3=$arr_post[$i+2];
         $sql="INSERT into `telgu_question_option_detail` (`q_id`, `opt_text_value`,code) VALUES ($qid,'$v2',$v3);";
         $dd2=DB::getInstance()->query($sql);
        echo "<br> $sql ";
       }
       }
       if($lang=='3')
       {
       for($i=0;$i<$tot;$i+=3)
       { 
         $v1=$arr_post[$i]; $v2=$arr_post[$i+1]; $v3=$arr_post[$i+2];
         $sql="INSERT into `malyalam_question_option_detail` (`q_id`, `opt_text_value`,code) VALUES ($qid,'$v2',$v4)";
         $dd2=DB::getInstance()->query($sql);
        
       }
       }
       if($lang=='7')
       {
       for($i=0;$i<$tot;$i+=3)
       { 
         $v1=$arr_post[$i]; $v2=$arr_post[$i+1]; $v3=$arr_post[$i+2];
         $sql="INSERT into `odia_question_option_detail` (`q_id`, `opt_text_value`,code) VALUES ($qid,'$v2',$v3)";
          $dd2=DB::getInstance()->query($sql);
       }
       }

       if($lang=='8')
       {
       for($i=0;$i<$tot;$i+=3)
       { 
         $v1=$arr_post[$i]; $v2=$arr_post[$i+1]; $v3=$arr_post[$i+2];
         $sql="INSERT into `gujrati_question_option_detail` (`q_id`, `opt_text_value`,code) VALUES ($qid,'$v2',$v3)";
          $dd2=DB::getInstance()->query($sql);
       }
       }
       if($lang=='9')
       {
       for($i=0;$i<$tot;$i+=3)
       { 
         $v1=$arr_post[$i]; $v2=$arr_post[$i+1]; $v3=$arr_post[$i+2];
         $sql="INSERT into `marathi_question_option_detail` (`q_id`, `opt_text_value`,code) VALUES ($qid,'$v2',$v3)";
          $dd2=DB::getInstance()->query($sql);
       }
       }

       if($lang=='10')
       {
       for($i=0;$i<$tot;$i+=3)
       { 
         $v1=$arr_post[$i]; $v2=$arr_post[$i+1]; $v3=$arr_post[$i+2];
         $sql="INSERT into `asami_question_option_detail` (`q_id`, `opt_text_value`,code) VALUES ($qid,'$v2',$v3)";
          $dd2=DB::getInstance()->query($sql);
       }
       }

        echo "Translation added successfully for qid : $qid";
      }
    }                                         
     
}

  if(isset($_POST['tq_submit']))
  { 
    header( 'Content-Type: text/html; charset=utf-8' ); 
    print_r($_POST);
    $qqid = $_POST['qqid'];
    $lang = $_POST['lang'];
    $tq = $_POST['tq'];
    //$qtype=$_POST['qt'];
    $qtype='';
    
    if($qqid!='00')
    {   
         if($lang=='1')
         {
       
            echo $sq1="INSERT INTO `hindi_question_detail`(`q_id`, `q_title`) VALUES ($qqid,'$tq')";
            $qcreate=DB::getInstance()->query($sq1);
            $qid=$qcreate->last();
         }
         if($lang=='6')
         {
       
            $sq1="INSERT INTO `bengali_question_detail`(`q_id`, `q_title`) VALUES ($qqid,'$tq')";
            $qcreate=DB::getInstance()->query($sq1);
            $qid=$qcreate->last();
         }
         if($lang=='2')
         {
       
            $sq1="INSERT INTO `kannar_question_detail`(`q_id`, `q_title`) VALUES ($qqid,'$tq')";
            $qcreate=DB::getInstance()->query($sq1);
            $qid=$qcreate->last();
         }
         if($lang=='4')
         {
       
            echo $sq1="INSERT INTO `tammil_question_detail`(`q_id`, `q_title`) VALUES ($qqid,'$tq')";
            $qcreate=DB::getInstance()->query($sq1);
            $qid=$qcreate->last();
         }
         if($lang=='5')
         {
       
            $sq1="INSERT INTO `telgu_question_detail`(`q_id`, `q_title`) VALUES ($qqid,'$tq')";
            $qcreate=DB::getInstance()->query($sq1);
            $qid=$qcreate->last();
         }
         if($lang=='3')
         {
       
            $sq1="INSERT INTO `malyalam_question_detail`(`q_id`, `q_title`) VALUES ($qqid,'$tq')";
            $qcreate=DB::getInstance()->query($sq1);
            $qid=$qcreate->last();
         }
       if($lang=='7')
       {
          	//$sql="INSERT into `odia_question_detail` (`q_id`, `q_title`) VALUES ($qqid,'$tq')";
            echo $sq1="INSERT INTO `odia_question_detail`(`q_id`, `q_title`) VALUES ($qqid,'$tq')";
            $qcreate=DB::getInstance()->query($sq1);
            $qid=$qcreate->last();

       }

       if($lang=='8')
       {
        	//echo $sql="INSERT into `gujrati_question_detail` (`q_id`, `q_title`) VALUES ($qqid,'$tq');";
            echo $sq1="INSERT INTO `gujrati_question_detail`(`q_id`, `q_title`) VALUES ($qqid,'$tq')";
            $qcreate=DB::getInstance()->query($sq1);
            $qid=$qcreate->last();
       }
       if($lang=='9')
       {
         	//$sql="INSERT into `marathi_question_detail` (`q_id`, `q_title`) VALUES ($qqid,'$tq')";
            echo $sq1="INSERT INTO `marathi_question_detail`(`q_id`, `q_title`) VALUES ($qqid,'$tq')";
            $qcreate=DB::getInstance()->query($sq1);
            $qid=$qcreate->last();

       }

       if($lang=='10')
       {
         	//$sql="INSERT into `asami_question_detail` (`q_id`, `q_title`) VALUES ($qid,'$tq')";
            echo $sq1="INSERT INTO `asami_question_detail`(`q_id`, `q_title`) VALUES ($qqid,'$tq')";
            $qcreate=DB::getInstance()->query($sq1);
            $qid=$qcreate->last();

       }

            echo 'Successfully submitted with Question Id: '.$qqid; 
    }
    else
        echo 'Please select a question from list';
  }

?>
<html>
	<head>
		<title>Translated Question Panel</title>
		<link rel="stylesheet" href="../../css/siteadmin.css">
			
	</head>
	
	<body id=pg>
	
        <center>
	<table cellpadding="10" cellspacing="5">
		<tr>
			<td><a href="?st=101">Add Translated Question</a></td>
			<td><a href="?st=102">Add Translated Questions Option</a></td>
			
		</tr>
		<tr>
			<td colspan="10"><center><h2><?= $msg ?></h2></center></td>
		</tr>
	</table>
            <center>
            <?php if($st==101) { ?>      
        
        <table cellpadding="2" cellspacing="1" border="0" style="font-size:12px;">
     	<form action="" method="post"> 
                <tr><td>Project Name *</td> </td><td> <select name="pn" id="pn" onclick="displib2();"><option value="0">--Select--</option><?php $pj=get_projects_details();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr>
                <tr><td>QuestionSet ID *</td><td><select name="qset" id="qset" onclick="showpquests();"><option value="select">--Select--</option> </select> </td></tr>
                <tr><td>Question Id </td><td>  <select name="qqid" id="qqid" style="max-width:30%;"><option value="0">--Select--</option> </select></td></tr>
                <tr><td>Translate Language</td><td> <select name="lang" id="lang" onchange="displib1();"><option value="0">--Select--</option>
<option value="1">Hindi</option><option value="2">Kannad</option><option value="3">Malyalam</option><option value="4">Tammil</option><option value="5">Telgu</option>
<option value="6">Bangla</option><option value=7>Odia</option><option value=8>Gujrati</option><option value=9>Marathi</option><option value="10">Asami</option>
</select></td></tr>
                <tr><td>Translated Question</td><td><textarea name="tq" id="tq" cols=70 rows=7></textarea></td></tr>
                    
                <tr><td></td><td><input type="submit" name="tq_submit" onclick="return confirm('Are you sure?');" value="Submit"></td></tr>                
                </form>
        </table>
            
<?php } if($st==102){ ?>
            <form action="" method="post">
                <form action="" method="post">
		<table cellpadding="2" cellspacing="1" border="0" style="font-size:12px;">
                <tr><td>Project Name *</td> </td><td> <select name="pn" id="pn" onclick="displib2();"><option value="0">--Select--</option><?php $pj=get_projects_details();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr>
                <tr><td>QuestionSet ID *</td><td><select name="qset" id="qset" onclick="showpquests();"><option value="select">--Select--</option> </select> </td></tr>
		<tr><td>Question Id </td><td><select name="qqid" id="qqid" onchange="displib3();" style="max-width:30%;" ><option value="0">--Select--</option> </select></td></tr>
                <tr><td>Translate Language</td> <td> <select name="lang" id="lang" onchange="displib1();"><option value="0">--Select--</option><option value="1">Hindi</option><option value="2">Kannad</option><option value="3">Malyalam</option><option value="4">Tammil</option><option value="5">Telgu</option><option value="6">Bangla</option><option value=7>Odia</option><option value=8>Gujrati</option><option value=9>Marathi</option><option value="10">Asami</option></select></td></tr>
                <tr><td>option</td><td><div id="qo"></div></td></tr>
                    <tr><td></td><td><input type="submit" name="ar_submit" value="Submit" onclick="return confirm('Are you sure?');"></td></tr>
            </table>
             </form>
<?php } ?>

        </body>
</html>
  


<script type="text/javascript">

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
	var val=document.getElementById('qqid').value;
        //document.write('Hello: '+val);
	pin.onreadystatechange=function()
	{
		if(pin.readyState==4)
		{
			document.getElementById('qo').innerHTML=pin.responseText;
			console.log(pin);
		}
	}
	url="get_q_opt.php?qid="+val;
	pin.open("GET",url,true);
	pin.send();
}

function displib1()
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
	var val=document.getElementById('qqid').value;
        var lang=document.getElementById('lang').value;
        //document.write('Hello: '+val);
	pin.onreadystatechange=function()
	{
		if(pin.readyState==4)
		{
			document.getElementById('tq').innerHTML=pin.responseText;
			console.log(pin);
		}
	}
	url="get_lang_q.php?qid="+val +"&lang="+lang ;
	pin.open("GET",url,true);
	pin.send();
}


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

function showpquests()
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
			document.getElementById('qqid').innerHTML=pin.responseText;
			console.log(pin);
		}
	}
	url="qset_qlist.php?qset="+val;
	pin.open("GET",url,true);
	pin.send();
}
</script>
