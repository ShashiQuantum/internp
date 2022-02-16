<?php


if(!$uid)
{
    echo 'Invalid Request';
}
else
{
 
?>

<!doctype html>
<html><head>
<meta charset="utf-8">
<title>digiadmin.quantumcs.com - Verify Password</title>
	 
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

        <!-- Bootstrap Core CSS -->
        <link href="<?php echo base_url(); ?>public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/my2.css">

        <!-- Custom Fonts -->
        <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

	<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700' rel='stylesheet' type='text/css'>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!--[if IE]>
		<link rel="stylesheet" type="text/css" href="all-ie-only.css" />
	<![endif]-->

        <!--[if lte IE 9]>
            <style>
                .fbblock{
                     width:370px !important;
                     }
            </style>
        <![endif]-->

<script type="text/javascript">
function validateForm(verify) {
    var x = document.forms["verify"]["npass"].value;
    var y = document.forms["verify"]["npassrepeat"].value;
   //var re=/^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{3,20}$/;
    if (x == null || x == "") {
        alert("Please enter your password");
        
        return false;
    }
    if (y == null || y == "") {
        alert("Please enter your repeat password");
        return false;
    }
    if (x !=y) {
        alert("Your repeat password does not match!");
        return false;
    }
    /* if(!re.test(x)) {
      alert("Error: password must have atleast three characters & contain atleast one degit & a special character!");
      return false;
    }
    */
}
</script>
</head>

<body>

<div class="setpass">
 <div class="reset">
 <h3>Set your password</h3>
 <div class="formpass">
 <font color="red"> <?php echo isset($msg)? $msg : ''; ?></font>
 <?php $data = array('onsubmit' => "validateForm(this)"); ?>
	<?php echo form_open('welcome/setpass',$data);?>
	
  
 <input type="hidden" name="user" value="<?=$uid?>">

 <div class="label">Name * :</div> <input type="text" name="name" placeholder="Your Full Name"><br>
 <div class="label">Mobile 1 *:</div><input type="text" name="mobile1" placeholder="1st Mobile No"><br>
 <div class="label">Mobile 2 *:</div> <input type="text" name="mobile2" placeholder="2nd Mobile No"><br>



 <div class="label">Password *:</div> <input type="password" name="npass" placeholder="New Password"><br>
 <div class="label">Re-type password *:</div><input type="password" name="npassrepeat" placeholder="Retype New Password"><br>
 
<!-- <div><?php if($page == 'verify') echo $msg; ?></div> -->
 <input type="submit" value="Set Password" name="btn_setpass" class="spaces">
 <span class="spaces"><b><?php echo $msg; ?></b></span>
<?php echo form_close()?>
 </div>
 </div>
<div class="clear"></div>
</div>

</body>
</html>
<?php } ?>