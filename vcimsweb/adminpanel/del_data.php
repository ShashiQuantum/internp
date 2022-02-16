
<?php
   include_once ('../init.php');
   include_once('../functions.php');
?>





<body>
<center>
<h2>Remove Duplicate Data</h2>
<table>
<form action="" method="post">
<tr><td>Project Name </td><td> <select name="pn" id="pn"  onchange="displib2();"><option value="0">--Select--</option><?php                         $pj=get_projects_details();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr>
            <tr><td>QuestionSet ID </td><td><select name="qset" id="qset"><option value="select">--Select--</option> </select> </td></tr> 
		

<tr><td>Term/Column Name:</td><td> <input type=text name=term></td></tr>

<tr><td>If Value is equal to :</td><td> <input type=text name=vall></td></tr>


<tr><td>  </td><td> <input type=submit name=show value=View>  <input type=submit name=submit value="Delete Duplicate Data"></td></tr>
</form>
</table>
</body>




<?php
   if(isset($_POST['show']))
   {
      $pid=$_POST['pn'];
      $qset=$_POST['qset'];
      $t=$_POST['term'];
      $v=$_POST['vall'];
      $dt="";
      
     $pd=DB::getInstance()->query("SELECT `data_table` FROM `project` WHERE `project_id`=$pid");
     if($pd->count()>0)
       $dt=$pd->first()->data_table;

      $qr="SELECT * FROM $dt WHERE q_id=$qset and $t!='' and $t=$v order by resp_id";
     $rr=DB::getInstance()->query($qr);
     if($rr->count()>0)
     {
       $dctr=0;$ctr=0;$pr='';$cr='';
       foreach($rr->results() as $r)
       {
          if($ctr==0)
            $pr=$cr=$r->resp_id;
          if($ctr>0)
          { $pr=$cr; $cr=$r->resp_id; }
      
          if($pr==$cr && $ctr!=0)   
          { $dctr++; echo '<br><font color=red>'.$r->id.' - '.$r->resp_id.' - '.$r->q_id.' - '.$r->mq24_18.'</font>';}
          
          else echo '<br>'.$r->id.' - '.$r->resp_id.' - '.$r->q_id.' - '.$r->mq24_18;
          $ctr++;
       }
     }
   echo '<br><b> <font color=red>Total Duplicate Count : '.$dctr.'</font>';

    }
    
    
    
     if(isset($_POST['submit']))
   {
      $pid=$_POST['pn'];
      $qset=$_POST['qset'];
      $t=$_POST['term'];
      $v=$_POST['vall'];
      $dt="";
      
     $pd=DB::getInstance()->query("SELECT `data_table` FROM `project` WHERE `project_id`=$pid");
     if($pd->count()>0)
       $dt=$pd->first()->data_table;

     $qr="SELECT * FROM $dt WHERE q_id=$qset and $t!='' and $t=$v order by resp_id";
     $rr=DB::getInstance()->query($qr);
     if($rr->count()>0)
     {
       $dctr=0;$ctr=0;$pr='';$cr='';
       foreach($rr->results() as $r)
       {
          if($ctr==0)
            $pr=$cr=$r->resp_id;
          if($ctr>0)
          { $pr=$cr; $cr=$r->resp_id; }
          //if duplicate value found
          if($pr==$cr && $ctr!=0)   
          { $dctr++; echo '<br><font color=red>'.$r->id.' - '.$r->resp_id.' - '.$r->q_id.' - '.$r->mq24_18.'</font>'; 
          
            $dlt=DB::getInstance()->query( "DELETE FROM $dt WHERE q_id=$qset and id=$r->id");
          
          }
          
          else echo '<br>'.$r->id.' - '.$r->resp_id.' - '.$r->q_id.' - '.$r->mq24_18;
          $ctr++;
       }
     }
   echo '<br><b> <font color=red>Total Duplicate Deleted : '.$dctr.'</font>';
     }
    
?>






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