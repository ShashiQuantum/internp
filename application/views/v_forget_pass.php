<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>RESET PASSWORD</title>
	<style>
#main{
width:960px;
margin:50px auto;
font-family:raleway;
}

span{
color:red;
}

h2{
background-color: #FEFFED;
text-align:center;
border-radius: 10px 10px 0 0;
margin: -10px -40px;
padding: 30px;
}

#login{

width:300px;
float: left;
border-radius: 10px;
font-family:raleway;
border: 2px solid #ccc;
padding: 10px 40px 25px;
margin-top: 70px;
}

input[type=text],input[type=password], input[type=email]{
width:99.5%;
padding: 10px;
margin-top: 8px;
border: 1px solid #ccc;
padding-left: 5px;
font-size: 16px;
font-family:raleway;
}

input[type=submit]{
width: 100%;
background-color:#049D8D;
color: white;
border: 2px solid #FFCB00;
padding: 10px;
font-size:20px;
cursor:pointer;
border-radius: 5px;
margin-bottom: 15px;
}

#profile{
padding:50px;
border:1px dashed grey;
font-size:20px;
background-color:#DCE6F7;
}

#logout{
float:right;
padding:5px;
border:dashed 1px gray;
margin-top: -168px;
}

a{
text-decoration:none;
color: cornflowerblue;
}

i{
color: cornflowerblue;
}

.error_msg{
color:red;
font-size: 16px;
}

.message{
position: absolute;
font-weight: bold;
font-size: 28px;
color: #6495ED;
left: 262px;
width: 500px;
text-align: center;
}
</style>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/style.css">
<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro|Open+Sans+Condensed:300|Raleway' rel='stylesheet' type='text/css'>
</head>
<body>
   
    <form action="<?php echo base_url('siteadmin/req_forget_pass')?>" method="post">
	<div id="main">
	<div id="login">
	<h3><center style="color:orange">Forget Password</center></h3>
<hr/>

<label style="font-size:11px; color:maroon">Enter Your Register Email* :</label>
<input type="email" name="email" placeholder="Email" required />
<br /><?=$msg;?><br />
<input type="submit" value="Submit" name="submit"/><br />
<a style="font-size:12px; float:right; color:blue" href="<?php echo site_url('siteadmin')?>">Back</a>
	<?php 
        echo $this->session->flashdata('flash_data');
	?>
</div>
</div>
    </form>
</body>
</html>

