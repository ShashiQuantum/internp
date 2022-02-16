<?php

include_once('../public_html/vcims/init.php');
//echo "Hello";

   $t='contact.vcims@gmail.com';
   $fem=$_REQUEST['email'];
   $s="Varenia website query  -- ".$_REQUEST['email'];
   $m=$_REQUEST['message'];
   $info="<br><br><Query Sender:-<br>Name : ".$_REQUEST['name']."<br>Email : ".$_REQUEST['email']."<br>Phone : ".$_REQUEST['phone']."<br>Message: ".$_REQUEST['message']."<br><br> From, <br>Digiadmin Website";
   $msg.='<br><u> Hi, <br><br> Query Sender Details:</u><br>'.$info;   
   $email=$_REQUEST['email'];
//echo "$email : $info";
 //  if( $email!='' && $m!='')
 //  {
      
      $headers  = 'MIME-Version: 1.0' . "\r\n";
      $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
      $headers .= "From: info@localhost" . "\r\n" .'Reply-To: contact.vcims@gmail.com' . "\r\n" .'X-Mailer: PHP/' . phpversion();

      mail($t, $s, nl2br($msg), $headers);
      
      //echo 'your query sent successfully.';
      
      //Redirect::to('contactus.php');
  // }
  
   	
  ?>
  
  