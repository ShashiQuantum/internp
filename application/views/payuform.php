<?php

if(!$this->session->userdata('isLogin') == TRUE)
{  $tempu= base_url(uri_string());  
   $this->session->set_tempdata('temp',$tempu);
   
   echo "Not Allowed";  redirect("https://digiadmin.quantumcs.com/v/welcome/login/");
}
else
{
                 $tot=$this->input->post("amount");;                  
                //$udata['amount']=$tot;
                 $uid=$this->session->userdata('vwebuserid');

// Merchant key here as provided by Payu--done
// LIVE MERCHANT_KEY = "cgkn6x";
// TEST MERCHANT_KEY = "gtKFFx";
$MERCHANT_KEY = "gtKFFx"; //Please change this value with live key for production
   $hash_string = '';
// Merchant Salt as provided by Payu --done
// LIVE SALT = "7JsucUBF";
// TEST SALT = "eCwWELxi";
$SALT = "eCwWELxi"; //Please change this value with live salt for production

// End point - change to https://secure.payu.in for LIVE mode and https://test.payu.in for TEST MODE
$PAYU_BASE_URL = "https://test.payu.in";

//-----Get VCIMS UserInfo --------




//-----End of user info ------

$action = '';

$posted = array();
if(!empty($_POST)) {
    //print_r($_POST);
  foreach($_POST as $key => $value) {    
    $posted[$key] = $value; 
	
  }
}

$formError = 0;

if(empty($posted['txnid'])) {
   // Generate random transaction id
  $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
} else {
  $txnid = $posted['txnid'];
}
$hash = '';
// Hash Sequence
$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
if(empty($posted['hash']) && sizeof($posted) > 0) {
  if(
          empty($posted['key'])
          || empty($posted['txnid'])
          || empty($posted['amount'])
          || empty($posted['firstname'])
          || empty($posted['email'])
          || empty($posted['phone'])
          || empty($posted['productinfo'])
         
  ) {
    $formError = 1;
  } else {
    
	$hashVarsSeq = explode('|', $hashSequence);
 
	foreach($hashVarsSeq as $hash_var) {
      $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
      $hash_string .= '|';
    }

    $hash_string .= $SALT;


    $hash = strtolower(hash('sha512', $hash_string));
    $action = $PAYU_BASE_URL . '/_payment';
  }
} elseif(!empty($posted['hash'])) {
  $hash = $posted['hash'];
  $action = $PAYU_BASE_URL . '/_payment';
}
?>
<html>
  <head>
  <script>
    var hash = '<?php echo $hash ?>';
    function submitPayuForm() {
      if(hash == '') {
        return;
      }
      var payuForm = document.forms.payuForm;
      payuForm.submit();
    }
  </script>
  </head>
  <body onload="submitPayuForm()">
   <!-- <h2>PayU Form</h2> -->
    <br/>
    <?php if($formError) { ?>
     <!-- <span style="color:red">Please fill all mandatory fields.</span> -->
      <br/>
      <br/>
    <?php } ?>
    <form action="<?php echo $action; ?>" method="post" name="payuForm" >
      <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
      <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
      <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
       
	 
	    <input type="hidden" name="surl" value="https://www.digiadmin.quantumcs.com/v/welcome/payresponse" />   <!--Please change this parameter value with your success page absolute url like http://mywebsite.com/response.php. -->
		 <input type="hidden" name="furl" value="www.digiadmin.quantumcs.com/v/welcome/fpayresponse" /><!--Please change this parameter value with your failure page absolute url like http://mywebsite.com/response.php. -->
	  
	
	  
	   
	   
      <table>
        <tr>
         <!-- <td><b>Mandatory Parameters</b></td> -->
        </tr>
        <tr>
         <!-- <td>Amount: </td> -->
          <td><input type="hidden" name="amount" value="<?php echo (empty($_SESSION['amount'])) ? '' : $_SESSION['amount'] ?>" /></td>
         <!-- <td>First Name: </td> -->
          <td><input type="hidden" name="firstname" id="firstname" value="<?php echo (empty($name)) ? '' : $name; ?>" /></td>
        </tr>
        <tr>
         <!-- <td>Email: </td> -->
          <td><input type="hidden"  name="email" id="email" value="<?php echo (empty($email)) ? '' : $email; ?>" /></td>
         <!-- <td>Phone: </td> -->
          <td><input type="hidden" name="phone" value="<?php echo (empty($mobile1)) ? '' : $mobile1; ?>" /></td>
        </tr>
        <tr>
        <!--  <td>Product Info: </td> -->
          <td colspan="3"><input type="hidden" name="productinfo" value="<?php echo (empty($posted['productinfo'])) ? '' : $posted['productinfo'] ?>" /> </td>
        </tr>
        

        

        <tr>
         <!-- <td><b>Optional Parameters</b></td> -->
        </tr>
        <tr>
         <!-- <td>Last Name: </td> -->
          <td><input type="hidden" name="lastname" id="lastname" value="<?php echo (empty($posted['lastname'])) ? '' : $posted['lastname']; ?>" /></td>
         <!-- <td>Cancel URI: </td> -->
          <td><input type="hidden" type="hidden" name="curl" value="" /></td>
        </tr>
        <tr>
         <!-- <td>Address1: </td> -->
          <td><input type="hidden" name="address1" value="<?php echo (empty($posted['address1'])) ? '' : $posted['address1']; ?>" /></td>
         <!-- <td>Address2: </td> -->
          <td><input type="hidden" name="address2" value="<?php echo (empty($posted['address2'])) ? '' : $posted['address2']; ?>" /></td>
        </tr>
        <tr>
        <!--  <td>City: </td> -->
          <td><input type="hidden" name="city" value="<?php echo (empty($posted['city'])) ? '' : $posted['city']; ?>" /></td>
         <!-- <td>State: </td> -->
          <td><input type="hidden" name="state" value="<?php echo (empty($posted['state'])) ? '' : $posted['state']; ?>" /></td>
        </tr>
        <tr>
         <!-- <td>Country: </td> -->
          <td><input type="hidden" name="country" value="<?php echo (empty($posted['country'])) ? '' : $posted['country']; ?>" /></td>
         <!-- <td>Zipcode: </td> -->
          <td><input type="hidden" name="zipcode" value="<?php echo (empty($posted['zipcode'])) ? '' : $posted['zipcode']; ?>" /></td>
        </tr>
        <tr>
          <!-- <td>UDF1: </td> -->
          <td><input type="hidden" name="udf1" value="<?php echo $uid ?>" /></td>
          <!-- <td>UDF2: </td> -->
          <td><input type="hidden" name="udf2" value="<?php echo (empty($posted['udf2'])) ? '' : $posted['udf2']; ?>" /></td>
        </tr>
        <tr>
         <!-- <td>UDF3: </td> -->
          <td><input type="hidden" name="udf3" value="<?php echo (empty($posted['udf3'])) ? '' : $posted['udf3']; ?>" /></td>
         <!-- <td>UDF4: </td> -->
          <td><input type="hidden" name="udf4" value="<?php echo (empty($posted['udf4'])) ? '' : $posted['udf4']; ?>" /></td>
        </tr>
        <tr>
         <!-- <td>UDF5: </td> -->
          <td><input type="hidden" name="udf5" value="<?php echo (empty($posted['udf5'])) ? '' : $posted['udf5']; ?>" /></td>
         <!-- <td>PG: </td> -->
          <td><input type="hidden" name="pg" value="<?php echo (empty($posted['pg'])) ? '' : $posted['pg']; ?>" /></td>
        </tr>
        <tr>
          <?php if(!$hash) { ?>
           <!-- <td colspan="4"><input type="submit" value="Submit" /></td> -->
          <?php } ?>
        </tr>
      </table>
    </form>
  </body>
<script>
			document.payuForm.submit();
			</script>

</html>
<?php } ?>