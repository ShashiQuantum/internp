<?php
include_once('../init.php');
include_once('../functions.php');
if(!Session::exists('suser'))
{
	//Redirect::to('login_fp.php');
       die('Please close this page and relogin again');
}
?>
<!--  <!DOCTYPE html>
<html><head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cross Tab</title>
-->
<link href="http://live.digiadmin.quantumcs.com/vcimsweb/css/style-passwd.css" rel="stylesheet" type="text/css">
<link rel="icon" href="images/icon.jpg" type="image/jpg">
<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="http://live.digiadmin.quantumcs.com/vcimsweb/css/index.css">
<link rel="stylesheet" href="http://live.digiadmin.quantumcs.com/vcimsweb/css/newstylesheet.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
 

<head>

        <script>
            
            var arr1 = [];
            var arr2 = [];
            var arr3 = [];
        $(document).ready(function(){
        
        $(".xa").change(function () { 
                 if(this.checked)
                 {arr1.push($(this).val()); }
                 else 
                 {arr1.splice($.inArray($(this).val(), arr1),1); }
            //alert(arr1.join(",")+document.getElementById("x").innerHTML);
            $("#x").val(arr1.join(","));
        //$("#txtAge").toggle(this.checked);
        });
        
        $(".ya").click(function () {
                 if(this.checked)
                 arr2.push($(this).val());
                 else 
                 {arr2.splice($.inArray($(this).val(), arr2),1); }
            //alert(arr2.join(",")+document.getElementById("y").innerHTML);
            $("#y").val(arr2.join(","));
        //$("#txtAge").toggle(this.checked);
        });
        
        $(".fa").click(function () {
                 if(this.checked)
                 arr3.push($(this).val());
                 else 
                 {arr3.splice($.inArray($(this).val(), arr3),1); }
            //alert(arr3.join(",")+document.getElementById("f").innerHTML);
            $("#f").val(arr3.join(","));
        //$("#txtAge").toggle(this.checked);
        });
        //to reset the x-axis checkboxes
        $("#bxa").click(function () {
                 $(".xa").each(function() { 
                   this.checked = false; }); 
               $("#x").val("");
               arr1.length=0;
        });
        //to reset the y-axis checkboxes
        $("#bya").click(function () {
                 $(".ya").each(function() { 
                   this.checked = false; }); 
               $("#y").val("");
               arr2.length=0;
        });
          //to reset the all filters checkboxes
        $("#bfa").click(function () {
                 $(".fa").each(function() { 
                   this.checked = false; }); 
               $("#f").val("");
               arr3.length=0;
        });
        
    });
    
        </script>

    </head>
    
    <script type="text/javascript">
        var arr1 = [];
            var arr2 = [];
            var arr3 = [];
            $(".xa").click(function () { 
                 if(this.checked){
                 arr1.push($(this).val());alert('checked 1');}
                 else 
                 {arr1.splice($.inArray($(this).val(), arr1),1); }
            $("#x").val(arr1.join(","));
        });
    function enableTextBoxx()
    {
            arr1.length=0;
                //$("input:checkbox[class=xa]").each(function () {

        $("input:radio[class=xa]").each(function () {
            
            if($(this).is(":checked"))
            arr1.push($(this).val());
           
            //alert("Id: " + $(this).attr("id") + " Value: " + $(this).val() + " Checked: " + $(this).is(":checked"));
        });    
        $("#x").val(arr1.join(","));
    }

    function enableTextBoxy()
    {
            arr2.length=0;
             $("input:checkbox[class=ya]").each(function () {
        //$("input:radio[class=ya]").each(function () {
            
            if($(this).is(":checked"))
            arr2.push($(this).val());
           
            //alert("Id: " + $(this).attr("id") + " Value: " + $(this).val() + " Checked: " + $(this).is(":checked"));
        });    
        $("#y").val(arr2.join(","));
    }

     function enableTextBoxf()
    {
            arr3.length=0;
     
        $("input:checkbox[class=fa]").each(function () {
            
            if($(this).is(":checked"))
            arr3.push($(this).val());
           
            //alert("Id: " + $(this).attr("id") + " Value: " + $(this).val() + " Checked: " + $(this).is(":checked"));
        });    
        $("#f").val(arr3.join(","));
    }
    
    
    </script>    

    <body id=pg>
        
            <center><br><br><h2><font color=red>VCIMS CrossTab</font></h2></center>
            <center>
            <form NAME="tFORM" method="post" action="crosstab_tool_result.php" onSubmit="document.tFORM.target = 'f2';return true;" >
            <table cellpadding="0" cellspacing="0">
<tr><td></td><td><input type="reset" value="Reset All">  <input type="submit" name="exportall" value="Export All-Y"> <input type="submit" name="showall" value="Show All-Y"></td></tr>
           <!-- <tr><td>Month</td><td> <select name=month id=month><option value=0>--Select--</option><option value=1>JAN</option><option value=2>FEB</option><option value=3>MAR</option><option value=4>APR</option><option value=5>MAY</option><option value=6>JUN</option><option value=7>JUL</option><option value=8>AUG</option><option value=9>SEP</option><option value=10>OCT</option><option value=11>NOV</option><option value=12>DEC</option></</td></tr>
-->
            <tr><td>Project <font color=red> * </font></td><td><select name="project" id="project" onclick="displib()"><option value="0">--Select--</option><?php $ptt=get_projects_details();if($ptt) foreach($ptt as $p){?><option value="<?php echo $p->project_id; ?>"> <?php echo $p->name;  ?></option> <?php } ?></select></tr>
            <tr><td>Scale <font color=red> * </font></td><td><select name="measure" id="measure"><option value="tot" selected>Total Count</option><option value="totp">Table %</option><option value="rowp">Row %</option><option value="colp">Column %</option></select> </td></tr>

            <tr><td><font color=red> * </font> <div style="vertical-align: top;text-align: center;display: table-cell;" >X-Axis</div> </td><td><textarea rows="2" cols="30" name="xv" id="x" readonly>   </textarea></td><td> <div style="vertical-align: top;text-align: center;display: table-cell;" > <input type="button" id="bxa" value="Reset X"> </div> </td></tr>

            <tr><td> <font color=red> * </font> <div style="vertical-align: top;text-align: center;display: table-cell;" >Y-Axis </div> </td><td><textarea rows="2" cols="30" name="yv"  id="y" readonly>  </textarea></td><td><div style="vertical-align: top;text-align: center;display: table-cell;" > <input type="button" id="bya" value="Reset Y"></div></td></tr>
            <tr><td> <div style="vertical-align: top;text-align: center;display: table-cell;" >Filter </div></td><td><textarea rows="2" cols="30"name="fv" id="f" readonly>  </textarea></td><td><div style="vertical-align: top;text-align: center;display: table-cell;" > <input type="button" id="bfa" value="Reset Filter"> </div> </td></tr>
              
              <tr><td></td><td><input type="submit" name="show" value="Show" color="green" style="background-color:lightgreen"></td></tr>
            </table>
            <!--<button>Hide/Show</button> Grid Parameters<br><br> -->
            </center>
              <br><br>  
             <div id="d1" name="d1"> 
                 <font color=red><i>Select project for CrossTab options</i></font>
            </div>

            <center><br><br><input type="submit" name="show" value="Show" style="background-color:lightgreen"></center><br><br>
        </form>
            
    
</html>
    
<script type="text/javascript">
  document.getElementById('project').value = "<?php echo $_POST['project'];?>";
  document.getElementById('measure').value = "<?php echo $_POST['measure'];?>";
  document.getElementById('x').value = "<?php echo $_POST['xv'];?>";
  document.getElementById('y').value = "<?php echo $_POST['yv'];?>";
  document.getElementById('f').value = "<?php echo $_POST['fv'];?>";
 <!-- document.getElementById('month').value = "<?php echo $_POST['month'];?>"; -->
</script>


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
	var val=document.getElementById('project').value;

	pin.onreadystatechange=function()
	{
		if(pin.readyState==4)
		{
			document.getElementById('d1').innerHTML=pin.responseText;
			console.log(pin);
		}
	}

	url="tst.php?inv="+val;
	pin.open("GET",url,true);
	pin.send();
}


</script>

