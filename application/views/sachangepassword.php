<?php
if(!$uid)
{
    echo 'Invalid Request';
}
else
{
 
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="VarenisCIMS @ Gurgoan">
    <meta name="author" content="">

    <title>Digiadmin</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/vendor/bootstrap/css/bootstrap.min.css" >
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/my2.css">
    <!-- Custom Fonts -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/vendor/font-awesome/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

    <!-- Theme CSS & topbar-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/agency2.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/agency2.min.css" >

    


<title>Change Password - digiadmin.quantumcs.com</title>
	 


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

</head>

<body id="page-top" class="index">

    <!-- Navigation -->
    <nav id="mainNav" class="navbar navbar-default navbar-custom navbar-fixed-top" style="background-color:white;">
<div style="margin-left: 20px;float:left;position: relative;width:75px;"><a href="#page-top"><img src="<?php echo base_url(); ?>public/img/logos/quantum-logo-big.png" height=80px width=80px/></a></div>
       <!-- <div class="container"> 
            -->
    </nav>



<body>
<center>
<div class="setpass">
 <div class="reset">
 <h3>Set your password</h3>
 <div class="formpass">
 <font color="red"> <?php echo isset($msg)? $msg : ''; ?></font>
 <?php $data = array('onsubmit' => "validateForm(this)"); ?>
	<?php echo form_open('siteadmin/saresetpass',$data);?>
	
 <input type="hidden" name="type" value="<?=$type;?>"> 
 <input type="hidden" name="uid" value="<?=$uid;?>">
 
 <div class="label">Password *:</div>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="password" name="npass" placeholder="New Password" required style="width:600px;"><br>
 <div class="label">Re-type password *:</div> <input type="password" name="npassrepeat" placeholder="Retype New Password" required style="width:600px;"><br>
 
<!-- <div><?php if($page == 'verify') echo $msg; ?></div> -->

 <input type="submit" value="Set Password" name="btn_setpass" class="spaces" onclick=validateForm();>
 <span class="spaces"><b><?php echo $msg; ?></b></span>
<?php echo form_close()?>
 </div>
 </div>
<div class="clear"></div>
</div>

</body>
</html>
<?php } ?>
