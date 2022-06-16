<?php
include_once('../../init.php');
include_once('../../functions.php');

?>
<head><title>Filter 4 Notification</title></head>
<body>
<br><br>
<center>
<h3><font color=red><u>Filter Respondent for Send Notification</u></font></h3>
<form name="tFORM" method=post action="resp_notify_list.php" >
 
<?php
echo "<br><br>Select Project Name   <select name=pn id=pn required ><option value=0>--Select Project Name--</option>";
          $pj=get_deploy_details();
             foreach($pj as $p){ 
        	echo "<option value='";
        	 echo $p->project_id; 
        	echo "'>";
        	 echo $p->name; 
        	echo "</option>";
        	  }        	  
        	 
?>
</select>
<br> <br>

Survey status <select name="surveyStatus" id="surveyStatus" required>
        <option value="">--Select Survey status--</option>
        <option value="0">Survey Not submited</option>
        <option value="2">Survey successfully submited</option>
        
      </select>
      <br> <br> <br><input type=submit name="get_resp" value="View User list"> 


</center>


<!--
<br>Age Between   <input type=num minsize=5 maxsize=80 name=fr size=1 placeholder="min age"> & <input type=num min=5 max=80 name=to size=1 placeholder="max age"><br><br>
          -->

<?php
/*
   $str1=''; $str2='';
   $data=DB::getInstance()->query("SELECT distinct title,term FROM `dictionary` where term in ('nresp_gender','q3_57','q4_57','nresp_educ','nresp_working_st','q16_57','q9_57','q10_57','q1_57') order by id");
     if($data->count()>0) 
     {    $nctr=0;
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
                      {  if($term=='nresp_gender'){ $term='gender_57'; } $k=$p->keyy;$v=$term.'='.$p->value;$str='';
                              if (!empty($_POST[$k]))
                                  { $str=" checked='checked'";}
                   //echo     "<tr><td><input type='checkbox' name='$k' value='$v' id=x>$k</td></tr>"; 
                           echo     "<li><input type='checkbox' name='$k' value='$v' id=x>$k</li>";          
                      }
                //echo "</details>";
                echo "</ul></dd><br>";
            }
     }
*/

?>
<!--
</form>
    -->



<script type="text/javascript">
  /*
 
  document.getElementById('x').value = "<?php // echo $_POST['xv'];?>";
  document.getElementById('y').value = "<?php  //echo $_POST['yv'];?>";
  document.getElementById('fr').value = "<?php  //echo $_POST['fr'];?>";
  document.getElementById('to').value = "<?php // echo $_POST['to'];?>";
  */
</script>

<script>
  /*
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
*/
</script>

<script type="text/javascript">
<!--
/*
window.onload=montre;
function montre(id) {
var d = document.getElementById(id);
for (var i = 1; i<=50; i++) {
if (document.getElementById('smenu'+i)) {document.getElementById('smenu'+i).style.display='none';}
}
if (d) {d.style.display='block';}
}
//-->
*/
</script>
