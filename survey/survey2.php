<?php
include "db.php";
?>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<br>
<br>

<!--=========== Select Validtion  ============ -->
   <table>
        <form action="" id="form_validation" method="post">

        <tr style="height:20px;"><td>Gender <font color="red">* </font> </td><td><select name="gender" required><option value=''>SELECT YOUR GENDER</option><option value=1>Male</option><option value=2>Female</option><option value=3>Prefere not to say</option></select></td></tr>
        
		<tr style="height:20px;"><td>Age <font color="red">*</font> </td><td><select name="age" required><option value=''>SELECT YOUR AGE</option><option value=1>Below 18 years</option><option value=2> 18 - 25 years</option><option value=3>26 - 35 yrs</option><option value=4> 36 - 45 yrs</option><option value=5> 46 years and above</option></select></td></tr>
       	
		<tr style="height:20px;"><td>Occupation <font color="red">*</font> </td><td><select name="occ" required><option value=''>SELECT YOUR OCCUPATION</option><option value=1>Working - Full Time</option><option value=2>Working – Part Time</option><option value=3>Student</option><option value=4>Not Working</option><option value=5>Home maker</option></select></td></tr>
		
		<tr style="height:20px;"><td>Highest Education Level <font color="red">*</font> </td><td><select name="edu" required><option value=''>SELECT YOUR HIGHEST EDUCATION</option><option value=1>Schooling upto 12th </option><option value=2>Some college but not graduate </option><option value=3>Graduate / Post graduate (General courses like BA, MA, B.Sc. M.Sc. etc.)</option><option value=4>Grad/Post graduate (Professional courses like B.Tech, M.Tech, MBA etc.) </option></select>
     
		<tr>
		<td>Select City<font color="red">*</font></td>
		<td>
		<select name='centre' onchange="select(this.value)"required>
		<option value=''>SELECT YOUR CITY</option>
		<option value=1>A</option>
		<option value=2>B</option>
		<option value='-1'>Others</option>
		</select></td>
		</tr>
		
        <tr style="display:none" id="oc">
		<td>Other City here <font color="red"> </font> </td>
		<td><input type="text" name="city" size="40" id="ocity" placeholder="Enter your city if not in above list">
		<span class="error"><p id="oc_error"></p></span>
		</td>
		
		</tr>
       
	   <tr>
	   <td><input type="submit" name="subinfo" values="Next" style=background-color:#004c00;color:white;height:30px;></td>
	   </tr>

            </form>
        </table>
<!--===========  // Select Validtion  ============ -->

<br>
<br>
<b>Q1:</b>
<span>MAX SUM SHOULD NOT BE MORE THAN 5</span>
<br>
<br>
<br>

		<div id="myDiv">

		<div class="row">
		<div class="col-75">
		<input type="text" class="txtCalc" id='op_1'>
		</div>
		</div>


		<div class="row">
		<div class="col-75">
		<input type="text" class="txtCalc" id='op_2'>
		</div>
		</div>
		
		<div class="row">
		<div class="col-75">
		<input type="text" class="txtCalc" id='op_3'>
		</div>
		</div>
		
		<div class="row">
		<div class="col-75">
		<input type="text" class="txtCalc" id='op_4'>
		</div>
		</div>
		
		
		<br>
		<br>
		<b>Total Sum:
		<span id="total_sum_value">0</span>
		
		</b> 
		
		<br>
		<span id="msg"></span>
		
		<br>
		<br>
		<input type="submit" value="send" id="btn">

</div>


<script>
////total sum calculation script //////////////////////////////////
$(document).ready(function()
{
$("#myDiv").on('input', '.txtCalc', function () {
       var calculated_total_sum = 0;
     
       $("#myDiv .txtCalc").each(function () {
           var get_textbox_value = $(this).val();
           if ($.isNumeric(get_textbox_value)) {
              calculated_total_sum += parseFloat(get_textbox_value);
              }                  
            });
              $("#total_sum_value").html(calculated_total_sum);
       });

});
/////////////////////////////////////////////////////////////////////
</script>


<script>
var acfs;

$(function() {
  acfs = $('input[type=text][id^=op_]'); //getting all ids
  acfs.on('input propertychange', checkSum);
});

var max = 5;

var checkSum = function(e) {
  this.value = this.value.replace(/\D/g, ''); //only digits
  var sum = 0;
  var fn = function() {
    sum += +this.value || 0; // parse individual text-box value to int
  };
  acfs.each(fn);
  if (max < sum)
  {	  // above limit
    this.value = '0'; //erase input
	alert("Total sum can not be more than 5");
  }
  
  if(max==sum)
  {
	  document.getElementById('btn').disabled = false; 
	   document.getElementById('msg').innerHTML="<span style='color:green'>You can go ahead</span>";
	  
  }
  
  if(max > sum)
  {
	  document.getElementById('btn').disabled = true;
	  document.getElementById('msg').innerHTML="<span style='color:red'>Total sum must be 5</span>";		
  }
};
</script>

<!--== Select Onchange ==-->
<script>
function select(selId)
{
	if(selId=='-1')
	{
		$('#oc').show('fast');
		
	//form validate start
	document.getElementById("form_validation").onsubmit = function () 
	{
    var c = document.forms["form_validation"]["ocity"].value;

    var submit = true;

    if (c == null || c == "")
	{
        cityError = "<span style='color:red;'>*Specify the other city name</span>";
        document.getElementById("oc_error").innerHTML = cityError;
        submit = false;
    }
	
    return submit;
	}
	//validate end
		
	}
	
	else
	{
		$('#oc').hide('fast');
	}
}
</script>
<!--== // Select Onchange ==-->