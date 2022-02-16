<html>

<body>

<script>
function validateForm() {
    var x = document.forms["login"]["email"].value;
    var y = document.forms["login"]["pass"].value;
   
    if (x == null || x == "") {	
        alert("pls enter your login email address ");
        
        return false;
    }
    if (y == null || y == "") {
        alert("pls enter your correct password");
        return false;
    }
    
}
</script>

<center><h1>SiteAdmin Gateway </h1> <tr style="border-bottom:1px solid #000;">
    	<td align="right">
        	<img src="../images/Digiadmin_logo.jpg" height="50" width="200" alt="DigiadminCIMS" />
        </td>
    </tr>
    <br><br><br><br><br>

<form id="login" method="post" action="do_login.php" onsubmit="return validateForm()">
User Login &nbsp;&nbsp;<input type="email" name="email" placeholder="Enter your email"><br><br>
Password  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="password" name="pass" placeholder="Enter your password"><br><br>
<input type= "submit" value="Log In"> 

</form></center>
</body>
</html>
