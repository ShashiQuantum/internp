<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Products-- Varenia</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url(); ?>public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/my2.css">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

    <!-- Theme CSS & topbar-->
    <link href="<?php echo base_url(); ?>public/css/agency.min.css" rel="stylesheet">
<style>
.txt-heading{padding: 5px 10px;font-size:1.1em;font-weight:bold;color:#999;}
a.btnRemoveAction{color:#D60202;border:0;padding:2px 10px;font-size:0.9em;}
a.btnRemoveAction:visited{color:#D60202;border:0;padding:2px 10px;font-size:0.9em;}
#btnEmpty{background-color:#D60202;border:0;padding:1px 10px;color:#FFF; font-size:0.8em;font-weight:normal;float:right;text-decoration:none;}
#btnContinue{background-color:green;border:0;padding:1px 10px;color:#FFF; font-size:0.8em;font-weight:normal;float:right;text-decoration:none;}

.btnAddAction{background-color:#79b946;border:0;padding:3px 10px;color:#FFF;margin-left:1px;width:90px;}
.btnAdded{background-color:#CCC;border:0;padding:3px 10px;color:#FFF;margin-left:1px;width:80px;}
#shopping-cart {border-top: #79b946 2px solid;margin-bottom:30px;}
#shopping-cart .txt-heading{background-color: #D3F5B8;}
.cart-item {border-bottom: #79b946 1px dotted;padding: 10px;}
#product-grid {border-top: #F08426 2px solid;margin-bottom:30px;}
#product-grid .txt-heading{background-color: #FFD0A6;}
.product-item {	float:left;	background:#F0F0F0;	margin:15px;	padding:5px;}
.product-item div{text-align:center;	margin:10px;}
.product-price {color:#F08426;}
.product-image {height:50px;background-color:#FFF;}
.clear-float{clear:both;margin-bottom:40px;}
.cart-action{cursor:pointer;}
</style>

</head>

<body id="page-top" class="index">

    <!-- Navigation -->
    <nav id="mainNav" class="navbar navbar-default navbar-custom navbar-fixed-top" style="background-color:white; border-bottom: 3px solid #DCEDC8;"> <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>public/img/logos/quantum-logo-big.png" height=80px width=80px/></a>
<div style="margin-left: 20px;float:left;position: relative;width:75px;"></div>
        <div class="container"> 
            <!-- Brand and toggle get grouped for better mobile display -->
            
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <!-- Header -->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script>
function showEditBox(editobj,id) {
	$('#frmAdd').hide();
	$(editobj).prop('disabled','true');
	var currentMessage = $("#message_" + id + " .message-content").html();
	var editMarkUp = '<textarea rows="5" cols="80" id="txtmessage_'+id+'">'+currentMessage+'</textarea><button name="ok" onClick="callCrudAction(\'edit\','+id+')">Save</button><button name="cancel" onClick="cancelEdit(\''+currentMessage+'\','+id+')">Cancel</button>';
	$("#message_" + id + " .message-content").html(editMarkUp);
}
function cancelEdit(message,id) {
	$("#message_" + id + " .message-content").html(message);
	$('#frmAdd').show();
}
function cartAction(action,product_code) {  
	var queryString = "";
	if(action != "") {
		switch(action) {
			case "add":
				queryString = 'action='+action+'&code='+ product_code+'&quantity='+$("#qty_"+product_code).val();
			break;
			case "remove":
				queryString = 'action='+action+'&code='+ product_code;
			break;
			case "empty":
				queryString = 'action='+action;
			break;
		}	 
	}
	jQuery.ajax({
	 url:'<?php echo base_url("welcome/filter_product/action/"); ?>'+action,
    //url:'digiadmin.quantumcs.com/v/welcome/filter_product/action'+action,
	data:queryString,
	type: "POST",
	success:function(data){
		$("#cart-item").html(data);
		if(action != "") {
			switch(action) {
				case "add":  
					$("#add_"+product_code).hide();
					$("#added_"+product_code).show();
				break;
				case "remove":
					$("#add_"+product_code).show();
					$("#added_"+product_code).hide();
				break;
				case "empty":
					$(".btnAddAction").show();
					$(".btnAdded").hide();
				break;
			}	 
		}
	},
	error:function (){}
	});
}
</script>
</HEAD>
<BODY>
<br><br><br><br>
<div id="product-grid">
	<div class="txt-heading">Products</div>
	<?php
	//print_r($prd_data);
	 
	if (!empty($prd_data)) { 
	        
		foreach($prd_data as $v){  
		 $code=$v->code; 
		 $img=$v->image; 
                 $desc=$v->desc; 
		 $name=$v->name; 
		 $price=$v->price; 
	?>
		<div class="product-item">
			<form id="frmCart">
			<div class="product-image"><img src=""></div>
			<div><strong><?php echo $name; ?></strong></div>
                        <div class="product-price"><?php echo "INR ".$price; ?>/Respondent</div>
                        <div style="border-top: #79b946 1px dotted;border-bottom: #79b946 1px dotted;padding: 10px;height:150px;text-align:left;"> <?php echo wordwrap($desc,30,'<br>');  ?> </div>
			
			<div><input type="number" id="qty_<?php echo $code; ?>" name="quantity" value="1" size="4" />
			<?php
				$in_session = "0";
				if(!empty($_SESSION["cart_item"])) {
					$session_code_array = array_keys($_SESSION["cart_item"]);
				    if(in_array($v->code ,$session_code_array)) {
						$in_session = "1";
				    }
				}
			?>
			<input type="button" id="add_<?php echo $code; ?>" value="Add to cart" class="btnAddAction cart-action" onClick = "cartAction('add','<?php echo $code; ?>')" <?php if($in_session != "0") { ?>style="display:none" <?php } ?> />
			<input type="button" id="added_<?php echo $code; ?>" value="Added" class="btnAdded" <?php if($in_session != "1") { ?>style="display:none" <?php } ?> />
			</div>
			</form>
		</div>
	<?php
			}
	}
	?>
</div>
<div class="clear-float"></div>
<div id="shopping-cart"> 
<div class="txt-heading">Shopping Cart  <a href="checkout"  id="btnContinue">Continue to Pay</a> <a id="btnEmpty" class="cart-action" onClick="cartAction('empty','');">Empty Cart</a></div>
<div id="cart-item"></div>
</div>
<script>
$(document).ready(function () {
	cartAction('','');
})
</script>


   

     

    

    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>public/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url(); ?>public/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

     

    <!-- Theme JavaScript -->
    <script src="<?php echo base_url(); ?>public/js/agency.min.js"></script>

</body>

</html>
