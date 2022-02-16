<?php
include_once('../../init.php');
include_once('../../functions.php');

?>

<head><title>Referral Generator</title></head>
<body>
<br><br>
<center>
<h3><font color=red><u>Generate Referal Code</u></font></h3>
<form name="tFORM" method=post action="">
 Centre : <select name="centre"><option value='0'>Select--</option><?php $dc1=DB::getInstance()->query("SELECT * FROM `centre`"); foreach($dc1->results() as $cn){ $cid=$cn->centre_id; ?> <option value=<?php echo $cid;?> > <?php echo $cn->cname; ?> </option> <?php }?></select>
 Remarks: <input type=text name="rmk"> 
 <input type="submit" name="create" value="Generate Code" onclick="return confirm('Are you sure?');">
 <input type="submit" name="view" value="View">
</form>


<?php

    	if(isset($_POST['create']))
   	{
   		  $cid=$_POST['centre'];
                  $rmk=$_POST['rmk'];

              if($cid!=0 && $rmk!='')
              {
                  $tokenparta = generateRandomString(4);
                   $iqr="INSERT INTO `mangop_interviewer_referral_detail`( `remarks`, `centre`, `irefcode`) VALUES ('$rmk',$cid,$tokenparta)";
                   DB::getInstance()->query($iqr);
                   echo "Code generated successfully with remarks : $rmk";
              }   
                
        }
        if(isset($_POST['view']))
   	{
   		  $cid=$_POST['centre'];
                  $rmk=$_POST['rmk'];
               echo "<h3>Registered Interviewer Referral Code List</h3>";
              if($cid!=0)
              {
                  
                   $lqr="SELECT  `intvr_id`, `remarks`, `centre`, `irefcode` FROM `mangop_interviewer_referral_detail` WHERE centre=$cid";
                   $lc=DB::getInstance()->query($lqr);
                   if($lc->count()>0)
                   {
                        $cnt=0;
                        echo "<table border=1><tr><td>S.N.</td><td>Interviewer ID</td><td>Centre</td><td>Referral Code</td><td>Remarks</td></tr>";
                        foreach($lc->results() as $c)
                        {
                            $cnt++; $cid=$c->centre; $rc=$c->irefcode;$invr=$c->intvr_id;$rmk=$c->remarks; $cn=get_centre_name($cid);
                            echo "<tr><td>$cnt</td><td>$invr</td><td>$cn</td><td>$rc</td><td>$rmk</td></tr>";
                        }
                        echo "</table>";
                       
                   }else echo "No record found";
              
              } else echo "Plz select a valid centre name";  
                
        }
               function generateRandomString($length = 6) 
               {
                      //$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                      $characters = '0123456789';
                      $charactersLength = strlen($characters);
                      $randomString = '';
                      for ($i = 0; $i < $length; $i++) {
                      $randomString .= $characters[rand(0, $charactersLength - 1)];
                      }
                     return $randomString;
                }
        

?>
