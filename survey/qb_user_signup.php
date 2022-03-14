<?php
// =============================================== QB CURL FOR USER REG ============================ //
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

				$signature_string = "application_id=" . $APPLICATION_ID . "&auth_key=" . $AUTH_KEY . "&nonce=" . $nonce . "&timestamp=" . $timestamps;

				$signature =hash_hmac('sha1', $signature_string, $AUTH_SECRET);

				$post_body = http_build_query(array(
					'application_id' => $APPLICATION_ID,
					'auth_key' => $AUTH_KEY,
					'timestamp' => $timestamps,
					'nonce' => $nonce,
					'signature' => $signature,
				 
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
				//echo $token;
				 
				// User Sign /Registartion curl ops

				$post_body = http_build_query(array(
					"user[login]" => "777777777",
					"user[password]" => "12345678",
					"user[email]" => "shi8@gmail.com",
					"user[external_user_id]" => "",
					"user[facebook_id]" => "",
					"user[twitter_id]" => "",
					"user[full_name]" => "Testing Person",
					"user[phone]" => "",
					"user[website]" => "",
					//"user[tag_list]" => "$roomName",
					));
						
						
				// **** User Registartion using curl *********// 
				$url = $quickbox_api_url . "/users.json";

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

				$response_qbid = json_decode($response_reg, TRUE);
				$quickblock_id = $response_qbid['user']['id'];
				
				echo $quickblock_id;
 ?>