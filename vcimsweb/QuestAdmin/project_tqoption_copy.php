<?php
include_once('../init.php');
include_once('../functions.php');
?>
<!DOCType html>
<html>
<head>
<title>Copy Translated Options</title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" />   
<link href="http://live.digiadmin.quantumcs.com/public/css/mslist/bootstrap.css" rel="stylesheet" type="text/css"/>

<script type="text/javascript">

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
        var val=document.getElementById('select-country').value;
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
                        document.getElementById('select-country').innerHTML=pin.responseText;
			document.getElementById('fqid').innerHTML=pin.responseText;
                        console.log(pin);
                }
        }
        url="qset_qlist.php?qset="+val;
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
</script>
</head>
<body>
<center><h3>Copy Translated Q.Options To Multiple Question</h3>
<div style="width:50%;margin: auto;padding: 10px;border: 3px solid green;">

		<form action="" method="post">
		<table border=1>
                <tr><td>Project Name *</td><td> <select name="pn" id="pn" onclick="displib2();"><option value="0">--Select--</option><?php $pj=get_projects_details();
foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr>
                <tr><td>QuestionSet ID *</td><td><select name="qset" id="qset" onclick="showpquests();"><option value="select">--Select--</option> </select> </td></tr>
                <tr><td>Translate Language</td><td> <select name="lang" id="lang" onchange="displib1();"><option value="0">--Select--</option>
<option value="1">Hindi</option> </td></tr>
                <tr><td>From Question </td><td>  <select name="fqid" id="fqid"><option value="0">--Select--</option> </select></td></tr>
                <tr><td>Copy To Questions</td><td><select name="qqid[]" id='select-country' multiple='multiple' class='form-control selectpicker' data-live-search='true'></select></td></tr>
		<tr><td></td><td><input type="submit" name="tqop" value="Copy Selected Options"></td></tr>
		</table>
		</form>
</div>
<?php
if(isset($_POST['tqop'])){

	print_r($_POST);
}
?>
