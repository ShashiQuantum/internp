<?php
include_once('../init.php');
include_once('../functions.php');      
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Add CrossTab</title>
	</head>	
	<body>
        <center>
	<table cellpadding="10" cellspacing="5">		
		<tr>
			<td colspan="10"><center><h2>Add  CrossTab for a Project</h2></center></td>
		</tr>
	</table>

    <center><form action="" method="post"> <table><tr><td>Project Name</td> </td><td> <select name="pn" id="pn" onchange="displib2();"><option value="0">--Select--</option><?php $pj=get_projects_details();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td><td>QuestionSet ID </td><td><select name="qset" id="qset"><option value="select">--Select--</option> </select> </td><td><input type="submit" name="add_crosstab" value="Add CrossTab "></td></tr></table></form></center>

<?php 

if(isset($_POST['add_crosstab']))
{  
                 //print_r($_POST);
       $qset=$_POST['qset'];
       $pid=$_POST['pn'];

           if($qset!=0 )
           {                     
                  $qtd="SELECT q_id,`q_type`,qno, q_title FROM `question_detail` WHERE `qset_id`=$qset";
                  $qtd1=DB::getInstance()->query($qtd);
                 foreach($qtd1->results() as $val)
                 {
                  $qt=$val->q_type;
                  $qid=$val->q_id;
                  $qno=$val->qno;
                  $qtitle=$val->q_title;
                  
                  //to add into crosstab -------------------------------------------------
		          if($qt=='radio' || $qt=='checkbox')
		          {
		              $qr="SELECT  `opt_text_value`, `term` ,`value`  FROM `question_option_detail` WHERE `q_id`=$qid";
		              $dta=DB::getInstance()->query($qr);
		
		             if($dta->count()>0)
		             {
		               $term=$dta->first()->term; 
                               if(!is_project_term_exist($term))
                               {  $dta=DB::getInstance()->query($qr);
		                foreach($dta->results() as $d)
		                {
		                   $val=$d->value;$tv=$d->opt_text_value;
		                   $qrd="INSERT INTO `dictionary`( `title`, `term`, `keyy`, `value`) VALUES ('$qtitle','$term','$tv',$val);";
		                   $dta=DB::getInstance()->query($qrd);
		                }        
		                   $qrt="INSERT INTO `project_term_map`( `project_id`, `term`) VALUES ($pid,'$term')";
		                   $dta=DB::getInstance()->query($qrt);    
                               } //end if project term exist
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
                                  if(!is_project_term_exist($term))
                                 {      $qta=DB::getInstance()->query($qrr);
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
		                  }
		                 } //end of rating  crosstab---------------------------
		
                       } //end foreach
     		echo "Project CrossTab added successfully";
     		}
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