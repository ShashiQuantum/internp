<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 
if (isset($_GET["regId"]) && isset($_GET["message"])) {
    $regId = $_GET["regId"];
    $message = $_GET["message"];
    
    include_once './GCM.php';
    
    $gcm = new GCM();

    $registatoin_ids = array($regId);
    $message = array("price" => $message);

    $result = $gcm->send_notification($registatoin_ids, $message);

    echo $result;
}
 */
function notify($regID,$msg)
{
    
    include_once('../../gcm/GCM.php');
     //include_once './GCM.php';
     //echo $regID;
    $gcm = new GCM();

    $registatoin_ids = array($regID);
    $message = array("price" => $msg);

    $result = $gcm->send_notification($registatoin_ids, $message);

    //echo $result;
}

function notifymp($regID,$msg)
{
    
    //include_once('../../gcm/GCM.php');
      include_once 'gcm/GCM.php';
     //echo $regID;
    $gcm = new GCM();

    $registatoin_ids = array($regID);
    $message = array("price" => $msg);

    $result = $gcm->send_notification($registatoin_ids, $message);

    //echo $result;
}
?>
