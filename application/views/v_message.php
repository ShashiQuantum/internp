<?php
ob_clean();

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
</head>

<body>
<center>
<div class="setpass">
 <div class="reset">
 <h3>Reset your password</h3>
 <div class="formpass">
 <font color="red"> <?php echo isset($msg)? $msg : ''; ?></font>

 </div>
 </div>
<div class="clear"></div>
</div>

</body>
</html>
