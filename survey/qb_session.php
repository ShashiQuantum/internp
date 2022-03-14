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
				echo 'Token='.$token.'<br>';
				 
				// User Sign /Registartion curl ops

				$post_body = http_build_query(array(
					"type" => "3",
					"name" => "Web Test Room",
					"occupants_ids" => ["31404, 31408"],
						));
						//print_r($post_body);
						
				// **** Dialog Creation using curl *********// 
				$url = $quickbox_api_url . "/chat/Dialog.json";

				$curl2 = curl_init();
				curl_setopt($curl2, CURLOPT_URL, $url); // Full path is - https://api.quickblox.com/session.json
				curl_setopt($curl2, CURLOPT_POST, true); // Use POST
				curl_setopt($curl2, CURLOPT_POSTFIELDS, $post_body); // Setup post body
				curl_setopt($curl2, CURLOPT_HTTPHEADER, array('QB-Token: ' . $token));
				curl_setopt($curl2, CURLOPT_SSL_VERIFYHOST, FALSE);
				curl_setopt($curl2, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($curl2, CURLOPT_RETURNTRANSFER, 1);
				// Execute request and read response
				$response_reg = curl_exec($curl2);

				curl_close($curl2);

				$response_grp = json_decode($response_reg, TRUE);
				
				print_r($response_grp);
				
				$roomId = $response_grp['_id'];
?>