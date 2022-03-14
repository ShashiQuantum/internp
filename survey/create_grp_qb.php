<?php
// ************************************* QB CURL TO CREATE DIALOG **************************** //
			///// CREDENTIAL
				$APPLICATION_ID = "4";
				$AUTH_KEY = "YZYp8CDgrFmH7Px";
				$AUTH_SECRET = "Ljnjw8ZRFMMwmLO";

				// GO TO account you found creditial
				$USER_LOGIN = "VareniaCIMS";
				$USER_PASSWORD = "Varenia425";
				$quickbox_api_url = "https://apikenante.quickblox.com";
				////// END CREDENTIAL
				/// RETRIVE TOKEN
				$nonce = rand();
				$timestamps = time();

				$signature_string = "application_id=" . $APPLICATION_ID . "&auth_key=" . $AUTH_KEY . "&nonce=" . $nonce . "&timestamp=" . $timestamps ."&user[login]=" . $USER_LOGIN . "&user[password]=" . $USER_PASSWORD;
				$signature =hash_hmac('sha1', $signature_string, $AUTH_SECRET);

				$post_body = http_build_query(array(
					'application_id' => $APPLICATION_ID,
					'auth_key' => $AUTH_KEY,
					'timestamp' => $timestamps,
					'nonce' => $nonce,
					'signature' => $signature,
					'user[login]' => $USER_LOGIN,
					'user[password]' => $USER_PASSWORD
				 
						));
								
				$url = $quickbox_api_url . "/session.json";

				// **********to generate the token************ //
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, $url); // Full path is - https://api.quickblox.com/session.json
				curl_setopt($curl, CURLOPT_POST, true); // Use POST
				curl_setopt($curl, CURLOPT_POSTFIELDS, $post_body); // Setup post body
				curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				// **********to generate the token************ //
				// Execute request and read response
				$response1 = curl_exec($curl);

				$response = json_decode($response1, TRUE);

				$token = $response['session']['token'];
				//echo 'Token='.$token.'<br>'; exit();
				 
				$curl = curl_init();
				$qb_ids = "29410,29412";
				
			  curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://apikenante.quickblox.com/chat/Dialog.json",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => '{"type": "2", "name": "Final Room44", "occupants_ids": "'.$qb_ids.'"}',
			  CURLOPT_HTTPHEADER => array(
				"Content-Type: application/json",
				"Postman-Token: 46a81b6d-095e-4037-9887-3b51e635d128",
				"QB-Token: 9e93e73e6122bf5539fa9b3154e2d87bdb000004",
				"cache-control: no-cache"
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);
			
			$response_grp = json_decode($response, TRUE);

			if ($err) {
			  echo "cURL Error #:" . $err;
			} else {
			  //echo $response;
			  $roomId = $response_grp['_id'];
				echo $roomId;
			}
				
				
				// **** User Registartion using curl *********//
				
// ******************************** END OF QB CURL TO CREATE USER *********************** //
?>