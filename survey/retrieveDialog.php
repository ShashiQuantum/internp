			<?php

				///// CREDENTIAL
				$APPLICATION_ID = "4";
				$AUTH_KEY = "YZYp8CDgrFmH7Px";
				$AUTH_SECRET = "Ljnjw8ZRFMMwmLO";

				// GO TO account you found creditial
				$USER_LOGIN = "1111111131"; //qb user login
				$USER_PASSWORD = "12345678"; // qb user pass
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
				//echo 'Token='.$token.'<br>';
				
// ======================================== Retrieve Chat Dialogs ===============================//

				$curl = curl_init();

				  curl_setopt_array($curl, array(
				  CURLOPT_URL => "https://apikenante.quickblox.com/chat/Dialog.json",
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 30,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => "GET",
				  CURLOPT_HTTPHEADER => array(
					"Postman-Token: 17a9d7a2-6ac0-40b5-afed-2cd08d1e64a8",
					"QB-Token: $token",
					"cache-control: no-cache"
				  ),
				));

				$response = curl_exec($curl);
				
				$responseData = json_decode($response, TRUE);
							
				$err = curl_error($curl);

				curl_close($curl);

				if ($err) 
				{
				  echo "cURL Error #:" . $err;
				} 
				
				else 
				{
				  $items = $responseData['items'];
				  
				}
				
// ======================================== //Retrieve Chat Dialogs ===============================//

		// =======================================================//
		//print_r($items);
		foreach($items as $key => $val)
		{
			//$myarray = array_search(['31403', '31408'], array_column($items, 'occupants_ids', '_id'));
			if($val['type']!=2)
			{
				$did = $val['_id']; //dialog id
				$occupants_ids = $val['occupants_ids']; //dialog id
				
				$occupants = implode($occupants_ids, "-");	
			
				// ============= Getting Messages ============= //
				
				$curl = curl_init();

				curl_setopt_array($curl, array(
				  CURLOPT_URL => "https://apikenante.quickblox.com/chat/Message.json?chat_dialog_id=$did",
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 30,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => "GET",
				  CURLOPT_HTTPHEADER => array(
					"Postman-Token: 9f7129c5-ad58-4380-8365-79e1b52a8d7f",
					"QB-Token: $token",
					"cache-control: no-cache"
				  ),
				));

				$response = curl_exec($curl);
				
				$responseDataforMsgs = json_decode($response, TRUE);
				
				$err = curl_error($curl);

				curl_close($curl);

				if ($err) 
				{
				  echo "cURL Error #:" . $err;
				}

				else 
				{
				  $msgDialogItems = $responseDataforMsgs['items']; //print_r this item
				}
				
				print_r($msgDialogItems);
				
				foreach($msgDialogItems as $msgKey => $msgVal)
				{
					$msgs = $msgVal['message'];
					$sender = $msgVal['sender_id'];
					$receivedTo = $msgVal['recipient_id'];
					$attachments = $msgVal['attachments'];
					
					if(count($msgs>0))
					{						
						echo "<span style=color:red>$sender</span> - " . $msgs . '<br>';
						echo "<br><b>$did ($occupants)</b><br>";
					}
					
					else
					{
						echo "No Chat";
					}
					
					foreach($attachments as $att)
					{
						$img = $att['url'];
						echo "<img src=$img style=width:250px; height:200px <br><br><br>";
					}
				}
				
				// ============= End of Getting Messages ============= //
			
			}
		}
		
		// if($myarray)
		// {			
			// echo $myarray;
		// }
		
		// else
		// {
			// echo "No Chat yet..";
		// }

		
		// ======================= // ================================//
				


?>
