<?php

include_once('../init.php');
include_once('../functions.php');
echo "<div id=header>";
/*
if(isset($_POST['logout']))
         {
            session_destroy();
		//Cookie::delete($this->_cookieName);
		
		Redirect::to('login_fp.php');
            
         }
         echo "Hi <font color='lightgreen'>".Session::get('suser')."</font>";
*/ 
        ?>
                            <form action="" method=post><input type=submit name=logout value=Logout></form>
                          <!--  <div style=float:right><img src='../../images/Digiadmin_logo.jpg' height=30 width=130> </div> --> 
                            <center><h3><font color=red >View/Edit Question Admin Panel</font></h3></center>
    </div>

<?php
if(isset($_REQUEST['st']))
{
	$st = $_REQUEST['st'];
}
else
{
	$st = 103;
}   
$msg='';


if($st==103)
{
    $msg="View/Edit Question";    
}    
if($st==104)
{
    $msg="View/Edit Question's Options";    
}
if(isset($_POST['dqop_submit']))
{
     //print_r($_POST);
    $qid=$_POST['qqid'];
    $lang=$_POST['lang'];

       	if($lang=='1')
       	{
           	$sql="DELETE FROM `hindi_question_option_detail` WHERE q_id = $qid ;";
		$dd2=DB::getInstance()->query($sql);
		echo "All hindi translated options has deleted sucessfully for qid: $qid";
	}
        if($lang=='2')
        {
                $sql="DELETE FROM `kannar_question_option_detail` WHERE q_id = $qid ;";
                $dd2=DB::getInstance()->query($sql);
                echo "All kannar translated options has deleted sucessfully for qid: $qid";
        }
        if($lang=='3')
        {
                $sql="DELETE FROM `malyalam_question_option_detail` WHERE q_id = $qid ;";
                $dd2=DB::getInstance()->query($sql);
                echo "All malyalam translated options has deleted sucessfully for qid: $qid";
        }
        if($lang=='4')
        {
                $sql="DELETE FROM `tammil_question_option_detail` WHERE q_id = $qid ;";
                $dd2=DB::getInstance()->query($sql);
                echo "All tammil translated options has deleted sucessfully for qid: $qid";
        }
        if($lang=='5')
        {
                $sql="DELETE FROM `telgu_question_option_detail` WHERE q_id = $qid ;";
                $dd2=DB::getInstance()->query($sql);
                echo "All telgu translated options has deleted sucessfully for qid: $qid";
        }
        if($lang=='6')
        {
                $sql="DELETE FROM `bengali_question_option_detail` WHERE q_id = $qid ;";
                $dd2=DB::getInstance()->query($sql);
                echo "All bangla translated options has deleted sucessfully for qid: $qid";
        }
        if($lang=='7')
        {
                $sql="DELETE FROM `odia_question_option_detail` WHERE q_id = $qid ;";
                $dd2=DB::getInstance()->query($sql);
                echo "All odia translated options has deleted sucessfully for qid: $qid";
        }
        if($lang=='8')
        {
                $sql="DELETE FROM `gujrati_question_option_detail` WHERE q_id = $qid ;";
                $dd2=DB::getInstance()->query($sql);
                echo "All gujrati translated options has deleted sucessfully for qid: $qid";
        }
        if($lang=='9')
        {
                $sql="DELETE FROM `marathi_question_option_detail` WHERE q_id = $qid ;";
                $dd2=DB::getInstance()->query($sql);
                echo "All marathi translated options has deleted sucessfully for qid: $qid";
        }
        if($lang=='10')
        {
                $sql="DELETE FROM `asami_question_option_detail` WHERE q_id = $qid ;";
                $dd2=DB::getInstance()->query($sql);
                echo "All asami translated options has deleted sucessfully for qid: $qid";
        }
}


if(isset($_POST['ar_submit']))
{
     //print_r($_POST);
    $qid=$_POST['qqid'];
    $lang=$_POST['lang'];

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
      //print_r($arr_post);
      $dd=DB::getInstance()->query("select q_type from question_detail WHERE q_id=$qid");
      if($dd->count()>0)
      {
        $qt=$dd->first()->q_type;

        if($qt=='radio' || $qt=='checkbox')
        {
            $size=$tot/3;
            $arr_opid=array();

           //to add op_id in an array $arr_opid
           for($i=0;$i<$tot;$i+=3)
           {
              array_push($arr_opid,$arr_post[$i]);
        
           } 
    
       if($lang=='english')
       {  $i=0;
        //for($i=0;$i<$tot;$i+=3)
        foreach($arr_opid as $opid)
        { 
          $v1=$arr_post[$i]; $v2=$arr_post[$i+1]; $v3=$arr_post[$i+2];
          $sql="UPDATE `question_option_detail` SET `opt_text_value`='$v2' WHERE op_id=$opid ;";
          $dd2=DB::getInstance()->query($sql);
        $i+=3;
        }
       }
  
       if($lang=='1')
       {  $i=0;
           //$sqld="DELETE FROM `hindi_question_option_detail`  WHERE `q_id`=$qid;";
          //$dd2d=DB::getInstance()->query($sqld);
        foreach($arr_opid as $opid)
        { 
          $v1=$arr_post[$i]; $v2=$arr_post[$i+1]; $v3=$arr_post[$i+2];
           $sql="UPDATE `hindi_question_option_detail` SET `opt_text_value`= '$v2' WHERE id = $opid;";
	//$sql="INSERT INTO `hindi_question_option_detail` (`q_id`,`opt_text_value`) VALUES ($qid,'$v2')";
          $dd2=DB::getInstance()->query($sql);
		//echo "<br> $sql";
        $i+=3;
        }
       }

       if($lang=='4')
       {  $i=0;
        //for($i=0;$i<$tot;$i+=3)
        foreach($arr_opid as $opid)
        { 
          $v1=$arr_post[$i]; $v2=$arr_post[$i+1]; $v3=$arr_post[$i+2];
          $sql="UPDATE `tammil_question_option_detail` SET `opt_text_value`='$v2' WHERE id=$opid";
          $dd2=DB::getInstance()->query($sql);
        $i+=3;
        }
       }
   
       if($lang=='6')
       {  $i=0;
        //for($i=0;$i<$tot;$i+=3)
        foreach($arr_opid as $opid)
        {
          $v1=$arr_post[$i]; $v2=$arr_post[$i+1]; $v3=$arr_post[$i+2];
          $sql="UPDATE `bengali_question_option_detail` SET `opt_text_value`='$v2' WHERE id=$opid";
          $dd2=DB::getInstance()->query($sql);
        $i+=3;
        }
       }

       if($lang=='7')
       {  $i=0;
        //for($i=0;$i<$tot;$i+=3)
        foreach($arr_opid as $opid)
        { 
          $v1=$arr_post[$i]; $v2=$arr_post[$i+1]; $v3=$arr_post[$i+2];
          $sql="UPDATE `odia_question_option_detail` SET `opt_text_value`='$v2' WHERE id=$opid";
          $dd2=DB::getInstance()->query($sql);
        $i+=3;
        }
       }
   
       if($lang=='8')
       {  $i=0;
        //for($i=0;$i<$tot;$i+=3)
        foreach($arr_opid as $opid)
        { 
          $v1=$arr_post[$i]; $v2=$arr_post[$i+1]; $v3=$arr_post[$i+2];
          $sql="UPDATE `gujrati_question_option_detail` SET `opt_text_value`='$v2' WHERE id=$opid";
          $dd2=DB::getInstance()->query($sql);
        $i+=3;
        }
       }
   
       if($lang=='9')
       {  $i=0;
        //for($i=0;$i<$tot;$i+=3)
        foreach($arr_opid as $opid)
        { 
          $v1=$arr_post[$i]; $v2=$arr_post[$i+1]; $v3=$arr_post[$i+2];
          $sql="UPDATE `marathi_question_option_detail` SET `opt_text_value`='$v2' WHERE id=$opid";
          $dd2=DB::getInstance()->query($sql);
        $i+=3;
        }
       }

       if($lang=='5')
       {  $i=0;
        //for($i=0;$i<$tot;$i+=3)
        foreach($arr_opid as $opid)
        { 
          $v1=$arr_post[$i]; $v2=$arr_post[$i+1]; $v3=$arr_post[$i+2];
          $sql="UPDATE `telgu_question_option_detail` SET `opt_text_value`='$v2' WHERE id=$opid";
          $dd2=DB::getInstance()->query($sql);
        $i+=3;
        }
       }
       if($lang=='3')
       {  $i=0;
        //for($i=0;$i<$tot;$i+=3)
        foreach($arr_opid as $opid)
        { 
          $v1=$arr_post[$i]; $v2=$arr_post[$i+1]; $v3=$arr_post[$i+2];
          $sql="UPDATE `malyalam_question_option_detail` SET `opt_text_value`='$v2' WHERE id=$opid ";
          $dd2=DB::getInstance()->query($sql);
        $i+=3;
        }
       }
       if($lang=='10')
       {  $i=0;
        //for($i=0;$i<$tot;$i+=3)
        foreach($arr_opid as $opid)
        { 
          $v1=$arr_post[$i]; $v2=$arr_post[$i+1]; $v3=$arr_post[$i+2];
          $sql="UPDATE `asami_question_option_detail` SET `opt_text_value`='$v2' WHERE id=$opid";
          $dd2=DB::getInstance()->query($sql);
        $i+=3;
        }
       }
       if($lang=='2')
       {  $i=0;
        //for($i=0;$i<$tot;$i+=3)
        foreach($arr_opid as $opid)
        { 
          $v1=$arr_post[$i]; $v2=$arr_post[$i+1]; $v3=$arr_post[$i+2];
          $sql="UPDATE `kannar_question_option_detail` SET `opt_text_value`='$v2' WHERE id=$opid";
          $dd2=DB::getInstance()->query($sql);
        $i+=3;
        }
       }
        echo "saved successfully";
      }
    }

}

  if(isset($_POST['tq_submit']))
  { 
    //print_r($_POST);
    $qqid=$_POST['qqid'];
    $lang=$_POST['lang'];
    $tq=$_POST['tq'];
    //$qtype=$_POST['qt'];
    $qtype='';
    
    if($qqid!='00' && $lang=='1')
    {   
       
            $sq1="UPDATE `hindi_question_detail` SET `q_title`='$tq' WHERE `q_id`=$qqid";
            $qcreate=DB::getInstance()->query($sq1);
            $qid=$qcreate->last();
            
            echo 'Successfully submitted with Question Id: '.$qqid; 
        
    }
    else if($qqid!='00' && $lang=='english')
    {   
       
            $sq1="UPDATE `question_detail` SET `q_title`='$tq' WHERE `q_id`=$qqid";
            $qcreate=DB::getInstance()->query($sq1);
            $qid=$qcreate->last();
            
            echo 'Successfully submitted with Question Id: '.$qqid; 
        
    }
     else if($qqid!='00' && $lang=='4')
    {   
       
            $sq1="UPDATE `tammil_question_detail` SET `q_title`='$tq' WHERE `q_id`=$qqid";
            $qcreate=DB::getInstance()->query($sq1);
            $qid=$qcreate->last();
            
            echo 'Successfully submitted with Question Id: '.$qqid; 
        
    }
    else if($qqid!='00' && $lang=='2')
    {   
       
            $sq1="UPDATE `kannar_question_detail` SET `q_title`='$tq' WHERE `q_id`=$qqid";
            $qcreate=DB::getInstance()->query($sq1);
            $qid=$qcreate->last();
            
            echo 'Successfully submitted with Question Id: '.$qqid;         
    }
    else if($qqid!='00' && $lang=='7')
    {   
       
            $sq1="UPDATE `odia_question_detail` SET `q_title`='$tq' WHERE `q_id`=$qqid";
            $qcreate=DB::getInstance()->query($sq1);
            $qid=$qcreate->last();
            
            echo 'Successfully submitted with Question Id: '.$qqid;        
    }
    else if($qqid!='00' && $lang=='8')
    {   
       
            $sq1="UPDATE `gujrati_question_detail` SET `q_title`='$tq' WHERE `q_id`=$qqid";
            $qcreate=DB::getInstance()->query($sq1);
            $qid=$qcreate->last();
            
            echo 'Successfully submitted with Question Id: '.$qqid; 
        
    }
    else if($qqid!='00' && $lang=='9')
    {   
       
            $sq1="UPDATE `marathi_question_detail` SET `q_title`='$tq' WHERE `q_id`=$qqid";
            $qcreate=DB::getInstance()->query($sq1);
            $qid=$qcreate->last();
            
            echo 'Successfully submitted with Question Id: '.$qqid; 
        
    }
    else if($qqid!='00' && $lang=='5')
    {   
       
            $sq1="UPDATE `telgu_question_detail` SET `q_title`='$tq' WHERE `q_id`=$qqid";
            $qcreate=DB::getInstance()->query($sq1);
            $qid=$qcreate->last();
            
            echo 'Successfully submitted with Question Id: '.$qqid; 
        
    }
    else if($qqid!='00' && $lang=='3')
    {   
       
            $sq1="UPDATE `malyalam_question_detail` SET `q_title`='$tq' WHERE `q_id`=$qqid";
            $qcreate=DB::getInstance()->query($sq1);
            $qid=$qcreate->last();
            
            echo 'Successfully submitted with Question Id: '.$qqid; 
        
    }
    else if($qqid!='00' && $lang=='10')
    {   
       
            $sq1="UPDATE `asami_question_detail` SET `q_title`='$tq' WHERE `q_id`=$qqid";
            $qcreate=DB::getInstance()->query($sq1);
            $qid=$qcreate->last();
            
            echo 'Successfully submitted with Question Id: '.$qqid; 
        
    }
    else
        echo 'Please select a question from list';
  }


?>
<html>
	<head>
		<title>Translated Question Panel</title>
		<!-- <link rel="stylesheet" href="../../css/siteadmin.css"> -->
			
	</head>
	
	<body id=pg>
	
        <center>
	<table cellpadding="10" cellspacing="5">
		<tr>
			<td><a href="?st=103">View/Edit Question </a></td>
			<td><a href="?st=104">View/Edit Question's Options</a></td>
			
		</tr>
		<tr>
			<td colspan="10"><center><h2><?= $msg ?></h2></center></td>
		</tr>
	</table>
            </center>
            <?php if($st==103) { ?>      
        
        <table cellpadding="2" cellspacing="1" border="0" style="font-size:12px;">
     	<form action="" method="post"> 
                <tr><td>Project Name *</td> </td><td> <select name="pn" id="pn" onclick="displib2();" required><option value="">--Select--</option><?php $pj=get_projects_details();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr>
                <tr><td>QuestionSet ID *</td><td><select name="qset" id="qset" onclick="showpquests();" required><option value="">--Select--</option> </select> </td></tr>
                <tr><td>Question Id </td><td>  <select name="qqid" id="qqid" onchange="displib1();" style="max-width:30%;" required><option value="">--Select--</option><?php $pj=get_questions();foreach($pj as $p){?><option value="<?php echo $p->q_id;?>"><?php echo $p->q_id.' - '.$p->q_title;?></option><?php }?> </select></td></tr>
                <tr><td>Translate Language</td><td> <select name="lang" id="lang" onchange="displib1();" required><option value="">--Select--</option>
<option value="1">Hindi</option><option value="2">Kannad</option><option value="3">Malyalam</option><option value="4">Tammil</option><option value="5">Telgu</option>
<option value="6">Bangla</option><option value=7>Odia</option><option value=8>Gujrati</option><option value=9>Marathi</option><option value="10">Asami</option></select></td></tr>
                <tr><td>Translated Question</td><td><textarea name="tq" id="tq" cols=120 rows=10 ></textarea></td></tr>
                    
                <tr><td colspan="2"><input type="submit" name="tq_submit" onclick="return confirm('Are you sure?');" value="Update"></td><td><input type="submit" name="tqop_submit" onclick="return confirm('Are you sure?');" value="Delete All Translated Options"></td></tr>                
                </form>
        </table>
            
<?php } if($st==104){ ?>
            <form action="" method="post">
                <form action="" method="post">
		<table cellpadding="2" cellspacing="1" border="0" style="font-size:12px;">
                <tr><td>Project Name *</td> </td><td> <select name="pn" id="pn" onclick="displib2();" required><option value="">--Select--</option><?php $pj=get_projects_details();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr>
                <tr><td>QuestionSet ID *</td><td><select name="qset" id="qset" onclick="showpquests();" required><option value="">--Select--</option> </select> </td></tr>
		<tr><td>Question Id </td><td><select name="qqid" id="qqid" onchange="displib();" style="max-width:30%;" required><option value="">--Select--</option><?php $pj=get_questions();foreach($pj as $p){?><option value="<?php echo $p->q_id;?>"><?php echo $p->q_id.' - '.$p->q_title;?></option><?php }?> </select></td></tr>
                <tr><td>Translate Language</td><td> <select name="lang" id="lang"onchange="displib();" required><option value="">--Select--</option>
<option value="1">Hindi</option><option value="2">Kannad</option><option value="3">Malyalam</option><option value="4">Tammil</option><option value="5">Telgu</option>
<option value="6">Bangla</option><option value=7>Odia</option><option value=8>Gujrati</option><option value=9>Marathi</option><option value="10">Asami</option>
</select></td></tr>
                 <tr><td>option</td><td><div id="qo"></div></td></tr>
                    <tr><td></td><td><input type="submit" name="ar_submit" value="Update" onclick="return confirm('Are you sure?');"></td></tr>
            </table>
             </form>   
<?php } ?>
        
        
        </body>
</html>
  


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
	var val=document.getElementById('qqid').value;
        var lang=document.getElementById('lang').value;
        //document.write('Hello: '+val);
	pin.onreadystatechange=function()
	{
		if(pin.readyState==4)
		{
			document.getElementById('qo').innerHTML=pin.responseText;
			console.log(pin);
		}
	}
	url="get_q_opt.php?qid="+val+"&lang="+lang ;
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
