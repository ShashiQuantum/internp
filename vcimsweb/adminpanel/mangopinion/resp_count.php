<?php
include_once('../../init.php');
include_once('../../functions.php');
?>

<head><title>Filter Count</title></head>
<body>
<br><br>
<center>
<h2><u>Respondent Filter</u></h2>
<br><br>
</center>
<form name="tFORM" method=post action="respondent_filter_count.php">
<center><input type=submit name="get_resp" value="View"></center>
 
<br><br>Age Between </td><td> <input type=num minsize=5 maxsize=80 name=fr size=4 placeholder="min age"> & <input type=num min=5 max=80 name=to size=4 placeholder="max age"><br><br>


<?php
   $str1=''; $str2='';
   $data=DB::getInstance()->query("SELECT distinct title,term FROM `dictionary` where term in ('nresp_gender','q3_57','q4_57','nresp_educ','nresp_working_st','q16_57','q9_57','q10_57','q1_57')");
     if($data->count()>0) 
     {  $nctr=0;
          foreach($data->results() as $d)
          { 
                         $term=$d->term; $nctr++;
                       $t= $d->title;
                //echo "<tr><td><details style='margin-left:25px'> <summary> $t</summary> <p style='margin-left:25px'></td></tr>";
                ?>

                <dt onmouseover="javascript:montre('<?php echo "smenu$nctr";?>');"><?php echo $t; ?></dt> <dd id='<?php echo "smenu$nctr";?>' onmouseover="javascript:montre('<?php echo "smenu$nctr";?>');" onmouseout="javascript:montre();"> <ul>

               <?php
                $ptt=get_dictionary($term,null); 
                if($ptt) 
                  foreach($ptt as $p)
                  {           $tv=$p->value; if($term=='nresp_gender'){ $term='gender_57'; }
                               
                              $k=$p->keyy;$v=$term.'='.$tv;$str='';
                              if (!empty($_POST[$k]))
                                  { $str=" checked='checked'";}
                    
                            echo "<li><input type='checkbox' name='$k' value='$v' id=x>$k</li>"; 
                  }
                  echo "</ul></dd><br>";
                   //echo "</details>";
            }
     }


?>
 
</form>

</center>

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
<script type="text/javascript">
 
  document.getElementById('x').value = "<?php echo $_POST['xv'];?>";
  document.getElementById('y').value = "<?php echo $_POST['yv'];?>";
  document.getElementById('fr').value = "<?php echo $_POST['fr'];?>";
  document.getElementById('to').value = "<?php echo $_POST['to'];?>";
</script>



<script>
dl, dt, dd, ul, li {
margin: 0;
padding: 0;
list-style-type: none;
}
#menu {
position: absolute;
top: 1em;
left: 1em;
width: 10em;
}

#menu dt {
cursor: pointer;
background: #A9BFCB;
height: 20px;
line-height: 20px;
margin: 2px 0;
border: 1px solid gray;
text-align: center;
font-weight: bold;
}

#menu dd {
position: absolute;
z-index: 100;
left: 8em;
margin-top: -1.4em;
width: 10em;
background: #A9BFCB;
border: 1px solid gray;
}

#menu ul {
padding: 2px;
}
#menu li {
text-align: center;
font-size: 85%;
height: 18px;
line-height: 18px;
}
#menu li a, #menu dt a {
color: #000;
text-decoration: none;
display: block;
}

#menu li a:hover {
text-decoration: underline;
}

#mentions {
font-family: verdana, arial, sans-serif;
position: absolute;
bottom : 200px;
left : 10px;
color: #000;
background-color: #ddd;
}
#mentions a {text-decoration: none;
color: #222;
}
#mentions a:hover{text-decoration: underline;
}
</script>

<script type="text/javascript">
<!--
window.onload=montre;
function montre(id) {
var d = document.getElementById(id);
for (var i = 1; i<=50; i++) {
if (document.getElementById('smenu'+i)) {document.getElementById('smenu'+i).style.display='none';}
}
if (d) {d.style.display='block';}
}
//-->
</script>
