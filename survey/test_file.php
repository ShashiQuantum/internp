

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>


<br>
<br>
<b>Q1:</b>
<span>ANY QUESTION</span>
<br>
<br>
<table border=1>
<form method="post">

<tr>
<td>
<input type="radio" value=1 id="r1" name="r" disabled required>A
<br>
<input type="radio" value=2 id="r2" name="r" disabled required>B
<br>
<input type="radio" value=3 id="r3" name="r" disabled required>C
<br>
<input type="radio" value=4 id="r4" name="r" disabled required>D
</td>


<td>
<input type="checkbox" value=1 id="c1" name="c[]" onchange="changeThis(this)">A
<br>
<input type="checkbox" value=2 id="c2" name="c[]" onchange="changeThis(this)">B
<br>
<input type="checkbox" value=3 id="c3" name="c[]" onchange="changeThis(this)">C
<br>
<input type="checkbox" value=4 id="c4" name="c[]" onchange="changeThis(this)">D
</td>

</tr>

<tr>
<td colspan=2><center><input type="submit" id="buttoncheck" name="submit"></td>
</tr>
</form>
</table>

<script>
function changeThis(sender) 
{
	
  if(document.getElementById('c1').checked)
  {
    document.getElementById("r1").disabled=false;
  }
  
  else
  {
    document.getElementById("r1").disabled = true;
	document.getElementById('r1').checked = false;
  }
  
  if(document.getElementById('c2').checked)
  {
    document.getElementById("r2").disabled=false;
  }
  
  else
  {
    document.getElementById("r2").disabled = true;
	document.getElementById('r2').checked = false;
  }
  
   if(document.getElementById('c3').checked)
  {
    document.getElementById("r3").disabled=false;
  }
  
  else
  {
    document.getElementById("r3").disabled = true;
	document.getElementById('r3').checked = false;
  }
  
   if(document.getElementById('c4').checked)
  {
    document.getElementById("r4").disabled=false;
  }
  
  else
  {
    document.getElementById("r4").disabled = true;
	document.getElementById('r4').checked = false;
  }
  
}
</script>