<?php
include_once('../init.php');
include_once('../functions.php');      


?>
<!DOCTYPE html>
<html>
	<head>
		<title>Question Sequence</title>
	</head>
	


	<body>
        <center>
	<table cellpadding="10" cellspacing="5">
		
		<tr>
			<td colspan="10"><center><h2>Add Question Sequence</h2></center></td>
		</tr>
	</table>


    <center><form action="" method="post"> <table><tr><td>Project Name</td> </td><td> <select name="pn" id="pn" onchange="displib2();"><option value="0">--Select--</option><?php $pj=get_projects_details();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td><td>QuestionSet ID </td><td><select name="qset" id="qset" onchange="displib4();"><option value="select">--Select--</option> </select> </td><td><input type="submit" name="qs" value="Show "></td></tr></table></form></center>


<?php 
if(isset($_POST['qs']))
{
               // print_r($_POST);
     $qset=$_POST['qset'];
     $qr="SELECT q_id, `qset_id`, `q_title`, `q_type`, `qno` FROM `question_detail` WHERE `qset_id`=$qset";
     $qt=DB::getInstance()->query($qr);
     if($qt->count()>0)
     {   $ctr=0;
         echo "<form method=post action=''><table><tr><td>QNO<input type=hidden name=qset value=$qset></td><td>QID</td><td>TITLE</td><td>SEQUENCE VALUE</td><td>CHECK FLAG</td></tr>";
         foreach($qt->results() as $d)
         {   $ctr++;
             $qn=$d->qno; $qid=$d->q_id; $q=$d->q_title;
             echo "<tr><td>$qn</td><td>$qid</td><td>$q</td><td><input type=number name=$qid value=$ctr></td><td><input type=checkbox name=flag$qid value=$qid></td></tr>";
         }
         echo "<tr><td colspan=3><input type=submit name='ssubmit'</td></tr></table></form";
     }else echo "No question list is available in database";
}

if(isset($_POST['ssubmit']))
{  
                // print_r($_POST);
       $qset=$_POST['qset'];
     foreach($_POST as $key=>$val)
     {
           if($key!='ssubmit')if($key!='qset')
           { $f=0; 
              //echo "$key => $val <br>"; 
             $ff="flag$val";
             if($key==$ff){$qu= "UPDATE `question_sequence` SET `chkflag`=1 WHERE `qset_id`=$qset AND `qid`=$val"; DB::getInstance()->query($qu); }
             else 
             { 
                  $qi="INSERT INTO `question_sequence`(`qset_id`, `qid`, `sid`, `chkflag`) VALUES ($qset,$key,$val,$f)";
                  DB::getInstance()->query($qi); 
               /* to add for crosstable     
                  $qtd="SELECT `q_type` FROM `question_detail` WHERE `q_id`=$qid";
                  $qtd1=DB::getInstance()->query($qtd);
                  $qt=$qtd1->first()->q_type;
                  
                  //to add into crosstab -------------------------------------------------
		          if($qt=='radio' || $qt=='checkbox')
		          {
		             $qr="SELECT  `opt_text_value`, `term` ,`value`  FROM `question_option_detail` WHERE `q_id`=$qid";
		             $dta=DB::getInstance()->query($qr);
		
		             if($dta->count()>0)
		             {
		               $term=$dta->first()->term; 
		               foreach($dta->results() as $d)
		               {
		                 $val=$d->value;$tv=$d->opt_text_value;
		                 $qrd="INSERT INTO `dictionary`( `title`, `term`, `keyy`, `value`) VALUES ('$qtitle','$term','$tv',$val);";
		                 $dta=DB::getInstance()->query($qrd);
		               }        
		                 $qrt="INSERT INTO `project_term_map`( `project_id`, `term`) VALUES ($pid,'$term')";
		                 $dta=DB::getInstance()->query($qrt);            
		             }
		
		          } //end of radio
		              if($qt=='rating')
		              {      
		                  $qrr="SELECT  `term` ,  `scale_start_value` ,  `scale_end_value` ,  `scale_start_label` ,  `scale_end_label` 
		FROM  `question_option_detail` WHERE  `q_id` =$qid";
		                  $qta=DB::getInstance()->query($qrr);
		                  if($qta->count()>0)
		                  { 
		                        $term=$qta->first()->term;
		                        $sv=$qta->first()->scale_start_value;
		                        $lv=$qta->first()->scale_end_value;
		                        $ssl=$qta->first()->scale_start_label;
		                        $sel=$qta->first()->scale_end_label;
		                        
		                     if($sv==1)   
		                     {
		                        for($i=$sv;$i<=$lv;$i++)
		                        {   $str='rating-'.$i;
		                             if($i==$sv)
		                                $str=$ssl;
		                             if($i==$lv)
		                                $str=$sel;
		
		                            $qrd1="INSERT INTO `dictionary`( `title`, `term`, `keyy`, `value`) VALUES ('$qtitle','$term','$str',$i);";
		                            $dta1=DB::getInstance()->query($qrd1);   
		                              
		                        }
		                        
		                      }else  if($sv==0)
		                      {   
		                        for($i=1;$i<=$lv;$i++)
		                        {   $str='rating-'.$i;
		                             if($i==$sv)
		                                $str=$ssl;
		                             if($i==$lv)
		                                $str=$sel;
		
		                            $qrd2="INSERT INTO `dictionary`( `title`, `term`, `keyy`, `value`) VALUES ('$qtitle','$term','$str',$i);";
		                            $dta2=DB::getInstance()->query($qrd2);   
		                            if($i==$lv)
		                            {
		                               $qrrd3="INSERT INTO `dictionary`( `title`, `term`, `keyy`, `value`) VALUES ('$qtitle','$term','NA/DK/CS',$i+1);";
		                               $dtaa3=DB::getInstance()->query($qrrd3);
		                            }  
		                        }
		                      }  
		                        
		                       $qrt4="INSERT INTO `project_term_map`( `project_id`, `term`) VALUES ($pid,'$term')";
		                       $dta4=DB::getInstance()->query($qrt4);   
		                  }
		                 } //end of rating  crosstab---------------------------
		*/ 
             }
              
           }
     }
     echo "Question sequence added successfully";
}


?>


</body>
<link rel="stylesheet" href="../../css/siteadmin.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

<script>
function display()
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
			console.log(pin);
		}
	}
	url="qset_qlist.php?qset="+val;
	pin.open("GET",url,true);
	pin.send();
}

</script>
<script>
function display2()
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
			document.getElementById('pqid').innerHTML=pin.responseText;
			console.log(pin);
		}
	}
	url="qset_q.php?qset="+val;
	pin.open("GET",url,true);
	pin.send();
}

</script>

<script>
function display3()
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
	var val=document.getElementById('pqid').value;
          
	pin.onreadystatechange=function()
	{
		if(pin.readyState==4)
		{
			document.getElementById('dtt').innerHTML=pin.responseText;
			console.log(pin);
		}
	}
	url="qset_qop.php?qid="+val;
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
	url="get_qset.php?pid="+val;
	pin.open("GET",url,true);
	pin.send();
}
</script>