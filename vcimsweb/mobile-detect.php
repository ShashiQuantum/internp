<?php

class Mobile
{

function isMobileDevice()
{    $aMobileUA = array('/iphone/i' => 'iPhone', '/ipod/i' => 'iPod', '/ipad/i' => 'iPad','/android/i' => 'Android',    '/blackberry/i' => 'BlackBerry', '/webos/i' => 'Mobile');

    //Return true if Mobile User Agent is detected
    foreach($aMobileUA as $sMobileKey => $sMobileOS){
        if(preg_match($sMobileKey, $_SERVER['HTTP_USER_AGENT'])){
            return true;
        }
    }
    //Otherwise return false..  
    return false;
}

}

/*
$obj=new Mobile();

if($obj->isMobileDevice())
{
   echo "Mobile browser requesting<br>";
}
else
{
   echo "Desktop browser requesting<br>";
}
*/


?>