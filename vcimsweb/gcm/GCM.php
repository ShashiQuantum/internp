<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GCM
 *
 * @author Ravi Tamada
 */
class GCM {

    //put your code here
    // constructor
    function __construct() {
        
    }

    /**
     * Sending Push Notification
     */
    public function send_notification($registatoin_ids, $message) {
        // include config
         //include_once './config.php';
   include_once(__DIR__) . '/config.php';

        // Set POST variables
        //$url = 'https://android.googleapis.com/gcm/send';
	$url = 'https://fcm.googleapis.com/fcm/send';

        $fields = array(
            'registration_ids' => $registatoin_ids,'priority' => 'high',
            'data' => $message,
        );

        $headers = array('Authorization: key=' . GOOGLE_API_KEY,'Content-Type: application/json');

	$title='Mangopinion';
	$token=$registatoin_ids;
	$notification = array('title' =>$title , 'text' => $message['price'], 'sound' => 'default', 'badge' => '1');
	$arrayToSend = array('registration_ids' => $token, 'notification' => $notification,'priority'=>'high');
	$json = json_encode($arrayToSend);

	// Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        //curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        //curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);
        //echo $result;
    }

}

?>
