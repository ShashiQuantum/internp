<?php

include_once('../init.php');
include_once('../functions.php');

if(isset($_POST['tn_submit']))
{
  //print_r($_POST);
  $pn=$_POST['pn'];
  $qset=$_POST['qset'];

  
   if($pn!=0)
   {
   $pnn=DB::getInstance()->query("SELECT * FROM vcimstest.`project` WHERE `project_id`=$pn");
   $tn=$pnn->first()->name;

  $str=$tn."_".$qset;

  $ctb=DB::getInstance()->query("CREATE TABLE IF NOT EXISTS vcimstest.$str  (id int(5) primary key AUTO_INCREMENT,resp_id int(5) not null, q_id int(5) not null, r_name varchar(30) not null, mobile varchar(11) not null,sec_$qset varchar(1) not null, gender_$qset varchar(1) not null, week_day_$qset char(1) not null, age_$qset varchar(2) not null, age_yrs_$qset varchar(2) not null, store_$qset varchar(1) not null, product_$qset varchar(1) not null)");

   $pnn=DB::getInstance()->query("UPDATE vcimstest.`project` SET  `data_table`='$str' ,`status`=1 WHERE `project_id`=$pn");

  echo "<font color=red>Table created successfully</font>";
  }else echo "Please select a project";
}

if(isset($_POST['trn_submit']))
{
  //print_r($_POST);
  $trn=$_POST['trn'];
  $tbl=$_POST['table'];  
  $dtype=$_POST['dtype'];
  $dsize=$_POST['dsize']; 

  $ctb1=DB::getInstance()->query("ALTER TABLE vcimstest.$tbl ADD $trn $dtype($dsize) not null");
  echo "<font color=red>$trn added term successfully</font>";
}
?>

<table>
<body>

<?php
    

if(isset($_REQUEST['st']))
{
	$st = $_REQUEST['st'];
}
else
{
	$st = 2;
} 

 echo "<br><center><a href=?&st=1>Create New Table</a> &nbsp;&nbsp;<a href=create_table_column_test.php?&st=2>Create New Term</a></center><br>";

if($st==1)
{
?>
<form name="tablen" action="" method="post">

<table><tr><td>Project Name</td> </td><td> <select name="pn" id="pn" onchange="displib2();"><option value="0">--Select--</option><?php $pj=get_projects_details_test();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr><tr><td>QuestionSet ID </td><td><select name="qset" id="qset" onchange="displib4();"><option value="select">--Select--</option> </select> </td></tr>

<tr><td></td><td>&nbsp;&nbsp;<input type=submit name="tn_submit" value="Create Table"></td></tr></table>
</form>
<?php

}
if($st==2)
{
?>

<form name="termn" action="" method="post">
<table><tr>
<td>Table</td><td> <select name="table">
<?php 
$q=DB::getInstance()->query("SELECT distinct TABLE_NAME FROM INFORMATION_SCHEMA.COLUMNS  where table_name not in ( 'TABLES','TRIGGERS', 'USER_PRIVILEGES','VIEWS','CHARACTER_SETS','COLLATIONS','admin_user','COLUMNS','COLLATION_CHARACTER_SET_APPLICABILITY','centre','centre_project_details','client_info','COLUMN_PRIVILEGES','company_list','demo_respondent', 'ENGINES','EVENTS','FILES','INNODB_BUFFER_PAGE','INNODB_BUFFER_PAGE_LRU','INNODB_BUFFER_POOL_STATS','INNODB_TRX','KEY_COLUMN_USAGE','PARAMETERS','PARTITIONS','INNODB_CMP','INNODB_CMPMEM','INNODB_CMPMEM_RESET','INNODB_CMP_RESET','INNODB_LOCKS','INNODB_LOCK_WAITS','PLUGINS','PROCESSLIST','PROFILING','ROUTINES','REFERENTIAL_CONSTRAINTS','SCHEMATA','SCHEMA_PRIVILEGES','SESSION_STATUS','SESSION_VARIABLES','STATISTICS','TABLESPACES','TABLE_CONSTRAINTS','TABLE_PRIVILEGES','GLOBAL_STATUS','GLOBAL_VARIABLES','user_client_map','question_detail','question_option_detail','project_term_map','ques_brand','ques_prod_consume','ques_prod_post_consume','ques_prod_uses','ques_respondent','quota','respondent','respondent_centre_map','respondent_link_map','rfid_info','rfid_installed_info','hindi_question_detail','hindi_question_option_detail','questionare_info','questionset','question_routine_detail','question_sec','question_set','ques_prod_pre_consume','respondent_ques_details','rfid_info_backup','session','project_user_map','project_client_map','project') order by table_name");
 echo "<option value=0>--Select--</option>";

    if($q->count()>0)
     foreach($q->results() as $rr)
       echo "<option value=$rr->TABLE_NAME>$rr->TABLE_NAME</option>";
?>
</select></td></tr>
 <tr><td>Term/Field Name </td><td> <input type=text name=trn placeholder="Enter term/field name"> </td></tr><tr><td> Data Type</td><td><select name=dtype><option value=varchar>Character</option><option value=int>Integer</option></select></td></tr><tr><td> Size </td><td><input type=number name=dsize min=1> </td></tr> <tr><td></td><td><input type=submit name="trn_submit" value="Create Term"></td></tr></table>
</form>
<?php } ?>
</body>
</table>

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
	url="get_qset_test.php?pid="+val;
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
