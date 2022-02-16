<html>
<head>
<title>Sign Up</title>
<script type="text/javascript">
function validateForm() {
    var x = document.forms["signup"]["email"].value;
    var p = document.forms["signup"]["pwd"].value;
    var r = document.forms["signup"]["role"].value;
    var i = document.forms["signup"]["invid"].value;
    
    if (x == null || x == "") {	
        alert("Pls enter your login email address "); 
        return false;
        if (p == null || p == "") {	
        alert("Pls enter your Password"); 
        return false;
        if (r == null || r == "") {	
        alert("pls enter your role"); 
        return false;
        if (i == null || i == "") {	
        alert("pls enter your Inventory id "); 
        return false;
    }
    
}
</script>

</head>
<body>

<center><h1>SiteAdmin New User </h1> <tr style="border-bottom:1px solid #000;">
    	<td align="right">
        	<img src="../../images/Digiadmin_logo.jpg" height="50" width="200" alt="" />
        </td>
    </tr>
    <br><br><br>
<table><tr height=40> 
<form name="signup" method="post" action="do_signup.php" onsubmit="return validateForm()">
<td>Enter your email </td><td><input type="email" name="email" placeholder="Enter your email as "> </td></tr>
<tr height=40><td>
Password  </td><td><input type="password" name="pwd" placeholder="Enter your password "> </td></tr>
<tr height=40><td>
Enter your role Id </td><td><input type="text" name="role" placeholder="Enter your role id"> </td></tr><tr height=40><td>

</td><td><input type="submit" name="btn1" value="Sign Up"></td></tr>

</form> </center>
</body>
</html>