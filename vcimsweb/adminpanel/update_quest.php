<?php

include_once('../init.php');
include_once('../functions.php');
echo "<div id=header>";
if(isset($_POST['logout']))
         {
            session_destroy();
		//Cookie::delete($this->_cookieName);
		
		Redirect::to('login_fp.php');
            
         }
         echo "Hi <font color='lightgreen'>".Session::get('suser')."</font>"; 
        ?>

                            <form action="" method=post><input type=submit name=logout value=Logout></form>
                            <div style=float:right><img src='../../images/Digiadmin_logo.jpg' height=30 width=130> </div> 
                            <center><h3><font color=red >Update Dictionary Map/Question Admin Panel</font></h3></center>
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
    $msg="Add Dictionary Value";    
}    
if($st==103)
{
    $msg='Update Question Term';   
}



if(isset($_POST['uterm_submit']))
{
    //print_r($_POST);
    $pid=$_POST['pn'];
    $qid=$_POST['qqid'];
    $term=$_POST['qterm'];
    
     $dd=DB::getInstance()->query("select q_type from question_detail WHERE q_id=$qid");
     $qt=$dd->first()->q_type;
     if($qt=='radio' || $qt=='checkbox' || $qt=='text' || $qt=='textarea')
     {
           $sql="UPDATE `question_option_detail` SET `term`='$term' WHERE `q_id`=$qid";
           $dd2=DB::getInstance()->query($sql);
  
         echo "updated successfully of qid: $qid";
         
         $qr=DB::getInstance()->query("SELECT term FROM `project_term_map` WHERE project_id=$pid AND term='$term' ");
         if($qr->count()<1)
         {
             $s1="INSERT INTO `project_term_map`( `project_id`, `term`) VALUES ($pid,'$term')";
             $DB::getInstance()->query($s1);
         }
         //else echo 'record exist in project_term_map table';
     }
      
}

if(isset($_POST['d_submit']))
{
     
   $pid=$_POST['pn'];
   $qset=$_POST['qset'];
   $rid=$_POST['rid'];
    $title=$_POST['title'];
    $qid=$_POST['qqid'];

   if($qset!=0){
   echo "<br><center><font color=red>CrossTab Dictionary Mapping By QID: $pid  </font></center><br><br><br>";
      
         // $dt=DB::getInstance()->query("SELECT  `data_table`  FROM `project` WHERE `project_id`=$pid");
      
         

   if($dt->count()>0)
    {    
        echo "</center><br><form method=post action=''> <input type=submit value='Export To Excel' name=export></form> <br>";

            $qr="SELECT  `opt_text_value`, `term` ,`value`  FROM `question_option_detail` WHERE `q_id`=352";

        
           // $qr="SELECT * FROM $datatable WHERE q_id=$qset AND resp_id=$rid ";

    }
}

  if(isset($_POST['dic_submit']))
  { 
     //print_r($_POST);

     //to store all values
       $arr_post=array();
       foreach($_POST as $k=>$v)
       {  
            if($k=='title' || $k=='term' || $k=='dic_submit')
               continue;
           
              if($v!='')
                  array_push($arr_post,$v);
          
       }
      $tot=count($arr_post); 


    $title=$_POST['title'];
    $term=$_POST['term'];
    $key=$_POST['key1'];
    $val=$_POST['val1'];
    $qtype='';
    
    if($title!='' || $term!='' || $key !='' || $val != '')
    {   $rf=0;
           for($i=0;$i<$tot;$i+=2)
           { 
              $v1=$arr_post[$i]; $v2=$arr_post[$i+1];
              $qq="SELECT * FROM `dictionary` WHERE term='$term' and keyy='$v1'";
              $dq=DB::getInstance()->query($qq);
              if($dq->count()>0)
               { echo 'Record already exist, Please check it';$rf=1;break;}
           }
           if($rf==0)   
           for($i=0;$i<$tot;$i+=2)
           { 
              $v1=$arr_post[$i]; $v2=$arr_post[$i+1];
              echo '<br>'.$sq1="INSERT INTO `dictionary`( `title`, `term`, `keyy`, `value`) VALUES ('$title','$term','$v1','$v2')";
              //$qcreate=DB::getInstance()->query($sq1);
              //$id=$qcreate->last();
           } 
            //echo 'Successfully submitted with Id: '.$id; 
        
    }
    else
        echo 'Please fill all the details';
  }

?>
<html>
	<head>
		<title>Update Question Panel</title>
		<link rel="stylesheet" href="../../css/siteadmin.css">
			
	</head>
	
	<body id=pg>
	
        <center>
	<table cellpadding="10" cellspacing="5">
		<tr>
			<td><a href="?st=101">Add Dictionary Value</a></td>
                        <td><a href="?st=102">Map Dictionary & Term by QID</a></td>
			<td><a href="?st=103">Update Question Term</a></td>
                
			
		</tr>
		<tr>
			<td colspan="10"><center><h2><?= $msg ?></h2></center></td>
		</tr>
	</table>
            </center>
            <?php if($st==101) { ?>      
        
        <table cellpadding="2" cellspacing="1" border="0" style="font-size:12px;">
     	<form action="" method="post"> 
                <tr><td>Title </td><td><input type=text name=title></td></tr>
                <tr><td>Term</td><td><input type=text name=term></td></tr>
                <tr><td>Key</td><td><input type=text name="key1"></td></tr>
                <tr><td>Value</td><td><input type=text name="val1"></td></tr>
                <tr><td>Key</td><td><input type=text name="key2"></td></tr>
                <tr><td>Value</td><td><input type=text name="val2"></td></tr>
                <tr><td>Key</td><td><input type=text name="key3"></td></tr>
                <tr><td>Value</td><td><input type=text name="val3"></td></tr>
                <tr><td>Key</td><td><input type=text name="key4"></td></tr>
                <tr><td>Value</td><td><input type=text name="val4"></td></tr>
                <tr><td>Key</td><td><input type=text name="key5"></td></tr>
                <tr><td>Value</td><td><input type=text name="val5"></td></tr>   
   <tr><td><div id=tt></div></td></tr>
                <tr><td colspan="2"><center><input type="submit" name="dic_submit" onclick="return confirm('Are you sure?');" value="Submit"></center></td></tr>                
                
                </form>
        </table>
            
<?php } if($st==103){ ?>
            <form action="" method="post">
                <form action="" method="post">
		<table cellpadding="2" cellspacing="1" border="0" style="font-size:12px;">
                <tr><td>Project Name </td><td> <select name="pn" id="pn"><option value="0">--Select--</option><?php $pj=get_projects_details();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr> 
		<tr><td>Question Id </td><td><select name="qqid" id="qqid" onchange="dispcount();"><option value="00">--Select--</option><?php $pj=get_questions();foreach($pj as $p){?><option value="<?php echo $p->q_id;?>"><?php echo $p->q_id.' - '.$p->q_title;?></option><?php }?> </select></td></tr>
                                          
                 <tr><td>Term</td><td><div id="qo"></div></td></tr>
                    <tr><td></td><td><input type="submit" name="uterm_submit" value="Update" onclick="return confirm('Are you sure?');"></td></tr>
            </table>
             </form>   
<?php } if($st==102){ ?>
        
            <body>
            <form action="" method="post">
            <center>
            <br><br>
            <table cellpadding="2" cellspacing="1" border="0" style="font-size:12px;">

            <tr><td>Project Name </td><td> <select name="pn" id="pn"  onchange="displib2();"><option value="0">--Select--</option><?php                         $pj=get_projects_details();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr>
            <tr><td>QuestionSet ID </td><td><select name="qset" id="qset"><option value="select">--Select--</option> </select> </td></tr>
            <tr><td>Question Id </td><td><select name="qqid" id="qqid"><option value="0">--Select--</option><?php $pj=get_questions();foreach($pj as $p){?><option value="<?php echo $p->q_id;?>"><?php echo $p->q_id.' - '.$p->q_title;?></option><?php }?> </select></td></tr>

            <tr><td>Dictionary Title </td><td><textarea name="title"></textarea></td></tr>
            <tr><td></td><td><input type=submit name=d_submit value="View"></td></tr>

            </table>
            </center>
            </form>
            </body>
            </html>


<?php } >
        
        </body>
</html>
  


<script type="text/javascript">
function dispcount()
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
	url="dispcount.php?qid="+val;
	pin.open("GET",url,true);
	pin.send();
}

    
</script>



<script type="text/javascript">

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

