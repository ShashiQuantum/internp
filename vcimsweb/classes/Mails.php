<?php
include_once ( __DIR__ . '/../functions/mail.php');

class Mails
{
	private $_db, $dict, $base, $image, $logo, $bk, $disc, $address, $usercls, $ord;

	public function __construct($user=null)
	{
		$this->_db = DB::getInstance();
		$this->dict = new Dictionary();
		$this->bk = new Book();
		$this->disc = new Discount();
		$this->address = new Address();
		$this->usercls = new User();
		$this->ord = new Order();
		
		$this->instatus = $this->dict->get_key('library_book_status', 'inside');
		$this->base = Config::get('url/base');
		$this->image = Config::get('url/image');
		$this->logo = $this->base.'/images/logo.png';
	}
	
	// Signup Verification Mail
	public function verification($email, $hash)
	{
		$subject = 'Welcome On-Board ! Verify your email and Start Reading Books.';
					
		$message = '<html>
			<body bgcolor="#ffffff">
			<a href="'.$this->base.'" title="IndiaReads.com" target="_blank"><img alt="IndiaReads.com" src="'.$this->logo.'"></a>
			
			<b>Welcome to IndiaReads.com!</b>
			
			Reading Just got Bigger and Better. Now Books are affordable like never before. IndiaReads lets you rent books and return them after reading.
			
			So Let&#39;s get you started !

			To complete your registration, please click on the link below:
			Link : '.$this->base.'/verify.php?h='.$hash.'
			
			If the above link doesn&#39;t work, please copy and paste the link in your web browser address bar.
			
			If you are still having problem in signing up, please contact:
			<a href="customercare@indiareads.dcom" target="_blank"> customercare@IndiaReads.com </a>
			Toll Free: 1800-103-7323
			Alternate No: 0120-2424233
			
			Here is how we make renting so easy for you.
			<ol>
			<li>Just Login, Browse Books and Add them to your Bookshelf.</li>
			<li>Select the Books you want to rent and checkout through our Rental Cart.</li>
			<li>Make the Initial Payment via Store Credit, Online Payments, COD or internet wallets.</li>
			<li>Books are Delivered at your Address.</li>
			<li>Done Reading ? Request to return the books.</li>
			<li>Rent is Charged and Refund is made to Store Credit and Bank Account. Bonus Store Credits for refund in Store Credit.</li>
			</ol>
			
			<b>Enjoy Reading!
			Team, IndiaReads.com</b>
			
			<font size="2px"><center><b>IndiaReads.com</b>
			Toll Free: 1800-103-7323, Alternate No: 0120-2424233 Email: customercare@indiareads.com</center></font>
			</body>
			</html>';

		sendMail($email,$subject,nl2br($message));
	}
	
	// Forgot Password Mail
	public function forgot_password($email, $hash)
	{
		$subject = 'IndiaReads.com - Password Change Request';
					
		$message = '<html>
			<body bgcolor="#ffffff">
			<a href="'.$this->base.'" title="IndiaReads.com" target="_blank"><img alt="IndiaReads.com" src="'.$this->logo.'"></a>
			
			<b>Hi,</b>
			
			We have received a password change request for your IndiaReads account: '.$email.'
			
			If you made this request, then please click on the link below:
			Link : '.$this->base.'/forgot.php?h='.$hash.'
			
			If the above link doesn&#39;t work, please copy and paste the link in your web browser address bar.
			
			This link will work for 2 hours or until you reset your password.
			
			If you did not ask to change your password, then please ignore this email. No changes will be made to your account.
			
			Please remember not to share your password with anyone.

			We hope to see you at IndiaReads.com
			
			<b>Enjoy Reading!
			Team, IndiaReads.com</b>
			
			<font size="2px"><center><b>IndiaReads.com</b>
			Toll Free: 1800-103-7323, Alternate No: 0120-2424233 Email: customercare@indiareads.com</center></font>
			</body>
			</html>';

		sendMail($email,$subject,nl2br($message));
	}
	
	// Order received mail
	public function order_rcv($poid)
	{
		$porder = $this->ord->fetch_order_details(null, $poid);
		$addr = $this->address->get_address($porder->order_address_id);
		$email = $this->usercls->get_user_email($porder->user_id);
		
		$subject = 'IndiaReads.com - Your Rental Order ID ['.$poid.'] Details';
					
		$message = '<html>
			<body bgcolor="#ffffff">
			<a href="'.$this->base.'" title="IndiaReads.com" target="_blank"><img alt="IndiaReads.com" src="'.$this->logo.'"></a>
			
			<b>Hi '.$addr->fullname.',</b>
			
			Thank you for placing your order with us !
			
			This email confirms that we have received the order. We will send you another email once the books are dispatched.
			
			Your order has been divided into sub-orders.
			
			<table cellpadding="5" style="width:60%;">
			';
		
		$totalipay = 0;
		$orders = $this->ord->get_suborders($poid);
		foreach($orders as $order)
		{
			$isbn = $order->ISBN;
			$bimg = $this->bk->get_book_image($isbn);
			$blink = $this->bk->book_link($isbn);
			$bname = $this->bk->get_book_name($isbn);
			$info = $this->bk->get_product_details($isbn);
			
			$price = round($info->price);
			if(!($price > 0))
				$price = 289;
			
			if($info->contributor_name1)
				$author = $info->contributor_name1;
			else if($info->contributor_name2)
				$author = $info->contributor_name2;
			else if($info->contributor_name3)
				$author = $info->contributor_name3;
				
			
			$ipay = $order->init_pay;
			$totalipay += $ipay;
			
			$rent4 = round($this->disc->fetch_rent_price($this->disc->get_rent(360), $price, $ipay));
			$rent3 = round($this->disc->fetch_rent_price($this->disc->get_rent(180), $price, $ipay));
			$rent2 = round($this->disc->fetch_rent_price($this->disc->get_rent(90), $price, $ipay));
			$rent1 = round($this->disc->fetch_rent_price($this->disc->get_rent(30), $price, $ipay));
			
			$message .= '<tr><td style="width:149px; padding:20px"> <a href="'.$this->base.'/'.$blink.'"><img src="'.$bimg.'" width="88px" height="139px" alt="'.$bname.'" /><a/> </td><td> Sub-Order ID :- '.$order->bookshelf_order_id.'
				Placed On :- '.$porder->order_date.'
				
				<h3>'.$bname.'</h3>by '.$author.'
				    
						Initial Payable : Rs. '.$ipay.'
						
						<b>Rental Structure :</b>
						360 days - Rs. '.$rent4.'
						180 days - Rs. '.$rent3.'
						 90 days - Rs. '.$rent2.'
						 30 days - Rs. '.$rent1.'<hr/></td></tr>';
		}
				
		$message .= '<tr><td colspan="2">Total Price : Rs. '.$porder->price.'<br/>
							Total Initial Payable : Rs. '.$totalipay.'
							Shippig Charges : Rs. '.$porder->shipping_charge.'
							COD Charges : Rs. '.$porder->cod_charge.'
							Coupon Discount : Rs. '.$porder->coupon_discount.' ('.$porder->coupon_code.')
							Store Credits : Rs. '.$porder->store_discount.'
							Bonus Credits : Rs. '.$porder->bonus_discount.'
							
							Net Pay : Rs. '.$porder->net_pay.'</td><hr/></tr><tr><td colspan="2">
			<b>The delivery Address will be :</b>
			
			'.$addr->fullname.' ('.$addr->phone.')
			'.$addr->address_line1.', '.$addr->address_line2.'
			'.$addr->city.', '.$addr->state.' - '.$addr->pincode.'</td></tr></table>

			We hope to see you renting on IndiaReads again.
			
			<b>Enjoy Reading!
			Team, IndiaReads.com</b>
			
			<font size="2px"><center><b>IndiaReads.com</b>
			Toll Free: 1800-103-7323, Alternate No: 0120-2424233 Email: customercare@indiareads.com</center></font>
			</body>
			</html>';

		sendMail($email,$subject,nl2br($message));
	}
	
	// Dispatch Mail
	public function dispatch_mail($poid)
	{
		$porder = $this->ord->fetch_order_details(null, $poid);
		$addr = $this->address->get_address($porder->order_address_id);
		$email = $this->usercls->get_user_email($porder->user_id);
		
		$subject = 'IndiaReads.com - Shipment Details for Order ID ['.$poid.'] Details';
					
		$message = '<html>
			<body bgcolor="#ffffff">
			<a href="'.$this->base.'" title="IndiaReads.com" target="_blank"><img alt="IndiaReads.com" src="'.$this->logo.'"></a>
			
			<b>Hi '.$addr->fullname.',</b>
			
			We are pleased to inform you that your books have been shipped.
			
			<table cellpadding="5" style="width:60%;">
			';
		
		$totalipay = 0;
		$orders = $this->ord->get_suborders($poid);
		foreach($orders as $order)
		{
			$isbn = $order->ISBN;
			$bimg = $this->bk->get_book_image($isbn);
			$blink = $this->bk->book_link($isbn);
			$bname = $this->bk->get_book_name($isbn);
			$info = $this->bk->get_product_details($isbn);
			
			$price = round($info->price);
			if(!($price > 0))
				$price = 289;
			
			if($info->contributor_name1)
				$author = $info->contributor_name1;
			else if($info->contributor_name2)
				$author = $info->contributor_name2;
			else if($info->contributor_name3)
				$author = $info->contributor_name3;
				
			
			$ipay = $order->init_pay;
			$totalipay += $ipay;
			
			$rent4 = round($this->disc->fetch_rent_price($this->disc->get_rent(360), $price, $ipay));
			$rent3 = round($this->disc->fetch_rent_price($this->disc->get_rent(180), $price, $ipay));
			$rent2 = round($this->disc->fetch_rent_price($this->disc->get_rent(90), $price, $ipay));
			$rent1 = round($this->disc->fetch_rent_price($this->disc->get_rent(30), $price, $ipay));
			
			$message .= '<tr><td style="width:149px; padding:20px"> <a href="'.$this->base.'/'.$blink.'"><img src="'.$bimg.'" width="88px" height="139px" alt="'.$bname.'" /><a/> </td><td> Sub-Order ID :- '.$order->bookshelf_order_id.'
				Placed On :- '.$porder->order_date.'
				
				<h3>'.$bname.'</h3>by '.$author.'
				    
						Initial Payable : Rs. '.$ipay.'
						
						<b>Rental Structure :</b>
						360 days - Rs. '.$rent4.'
						180 days - Rs. '.$rent3.'
						 90 days - Rs. '.$rent2.'
						 30 days - Rs. '.$rent1.'<hr/>
						 
						The shipment was sent through <a href="'.$order->carrier_link.'">'.$order->carrier.'
						Tracking id : '.$order->d_track_id.'</td></tr>
						
						Tracking id might take 24 hours to get activated.';
		}
				
		$message .= '<tr><td colspan="2">Total Price : Rs. '.$porder->price.'<br/>
							Total Initial Payable : Rs. '.$totalipay.'
							Shippig Charges : Rs. '.$porder->shipping_charge.'
							COD Charges : Rs. '.$porder->cod_charge.'
							Coupon Discount : Rs. '.$porder->coupon_discount.' ('.$porder->coupon_code.')
							Store Credits : Rs. '.$porder->store_discount.'
							Bonus Credits : Rs. '.$porder->bonus_discount.'
							
							Net Pay : Rs. '.$porder->net_pay.'</td><hr/></tr><tr><td colspan="2">
			<b>The delivery Address will be :</b>
			
			'.$addr->fullname.' ('.$addr->phone.')
			'.$addr->address_line1.', '.$addr->address_line2.'
			'.$addr->city.', '.$addr->state.' - '.$addr->pincode.'</td></tr></table>

			We hope to see you renting on IndiaReads again.
			
			<b>Enjoy Reading!
			Team, IndiaReads.com</b>
			
			<font size="2px"><center><b>IndiaReads.com</b>
			Toll Free: 1800-103-7323, Alternate No: 0120-2424233 Email: customercare@indiareads.com</center></font>
			</body>
			</html>';

		sendMail($email,$subject,nl2br($message));
	}
	
	// Pickup Request Mail
	public function pickup_mail($poid)
	{
		$porder = $this->ord->fetch_order_details(null, $poid);
		$addr = $this->address->get_address($porder->pick_address_id);
		$email = $this->usercls->get_user_email($porder->user_id);
		
		$subject = 'IndiaReads.com - Pick Up Requested for Book Name and '.$cnt.' more';
					
		$message = '<html>
			<body bgcolor="#ffffff">
			<a href="'.$this->base.'" title="IndiaReads.com" target="_blank"><img alt="IndiaReads.com" src="'.$this->logo.'"></a>
			
			<b>Hi '.$addr->fullname.',</b>
			
			Thank you for requesting a pick up !
			
			This email confirms that we have received your pick up request for the books:
			
			<table cellpadding="5" style="width:60%;">
			';
		
		$totalipay = 0;
		$orders = $this->ord->get_suborders($poid);
		foreach($orders as $order)
		{
			$isbn = $order->ISBN;
			$bimg = $this->bk->get_book_image($isbn);
			$blink = $this->bk->book_link($isbn);
			$bname = $this->bk->get_book_name($isbn);
			$info = $this->bk->get_product_details($isbn);
			
			$price = round($info->price);
			if(!($price > 0))
				$price = 289;
			
			if($info->contributor_name1)
				$author = $info->contributor_name1;
			else if($info->contributor_name2)
				$author = $info->contributor_name2;
			else if($info->contributor_name3)
				$author = $info->contributor_name3;
				
			
			$ipay = $order->init_pay;
			$dpay = $order->disc_pay;
			$totalipay += $ipay;
			
			$rent4 = round($this->disc->fetch_rent_price($this->disc->get_rent(360), $price, $ipay));
			$rent3 = round($this->disc->fetch_rent_price($this->disc->get_rent(180), $price, $ipay));
			$rent2 = round($this->disc->fetch_rent_price($this->disc->get_rent(90), $price, $ipay));
			$rent1 = round($this->disc->fetch_rent_price($this->disc->get_rent(30), $price, $ipay));
			
			$message .= '<tr><td style="width:149px; padding:20px"> <a href="'.$this->base.'/'.$blink.'"><img src="'.$bimg.'" width="88px" height="139px" alt="'.$bname.'" /><a/> </td><td> Sub-Order ID :- '.$order->bookshelf_order_id.'
				Placed On :- '.$porder->order_date.'
				
				<h3>'.$bname.'</h3>by '.$author.'
				    
						Initial Price Paid : Rs. '.($ipay-$dpay).'
						 
						Rent Charged : Rs. '.$order->cost.'
						Refund Amount : Rs. '.$order->refund.'<hr/></td></tr>
						
						Tracking id might take 24 hours to get activated.';
		}
				
		$message .= '<tr><td><b>The delivery Address will be :</b>
			
			'.$addr->fullname.' ('.$addr->phone.')
			'.$addr->address_line1.', '.$addr->address_line2.'
			'.$addr->city.', '.$addr->state.' - '.$addr->pincode.'</td></tr></table>

			We will arrange for the pick up and inform you about the details. We request you to kindly pack the Book in the extra packet provided to you during delivery. The refund will be initiated as soon as the book returns to us.
			
			We hope the book was an awesome read for you. Now that you have finished reading the book, it will be amazing to have your views on the book so kindly take some time out from your busy schedule to write a quick Review of the book for us. For every review accepted by IndiaReads.com, you shall be given 5 Bonus Store Credits.
			
			We hope to see you at IndiaReads.com
			
			<b>Enjoy Reading!
			Team, IndiaReads.com</b>
			
			<font size="2px"><center><b>IndiaReads.com</b>
			Toll Free: 1800-103-7323, Alternate No: 0120-2424233 Email: customercare@indiareads.com</center></font>
			</body>
			</html>';

		sendMail($email,$subject,nl2br($message));
	}
	
	// Book Retuned Mail
	public function returned_mail($poid)
	{
		$porder = $this->ord->fetch_order_details(null, $poid);
		$addr = $this->address->get_address($porder->pick_address_id);
		$email = $this->usercls->get_user_email($porder->user_id);
		
		$subject = 'IndiaReads.com Book Received and Refund Initiated';
					
		$message = '<html>
			<body bgcolor="#ffffff">
			<a href="'.$this->base.'" title="IndiaReads.com" target="_blank"><img alt="IndiaReads.com" src="'.$this->logo.'"></a>
			
			<b>Hi '.$addr->fullname.',</b>
			
			Thank you for returning the books !

			This email confirms that we have received the following books back with us:
			
			<table cellpadding="5" style="width:60%;">
			';
		
		$totalipay = 0;
		$orders = $this->ord->get_suborders($poid);
		foreach($orders as $order)
		{
			$isbn = $order->ISBN;
			$bimg = $this->bk->get_book_image($isbn);
			$blink = $this->bk->book_link($isbn);
			$bname = $this->bk->get_book_name($isbn);
			$info = $this->bk->get_product_details($isbn);
			
			$price = round($info->price);
			if(!($price > 0))
				$price = 289;
			
			if($info->contributor_name1)
				$author = $info->contributor_name1;
			else if($info->contributor_name2)
				$author = $info->contributor_name2;
			else if($info->contributor_name3)
				$author = $info->contributor_name3;
				
			
			$ipay = $order->init_pay;
			$dpay = $order->disc_pay;
			$totalipay += $ipay;
			
			$rent4 = round($this->disc->fetch_rent_price($this->disc->get_rent(360), $price, $ipay));
			$rent3 = round($this->disc->fetch_rent_price($this->disc->get_rent(180), $price, $ipay));
			$rent2 = round($this->disc->fetch_rent_price($this->disc->get_rent(90), $price, $ipay));
			$rent1 = round($this->disc->fetch_rent_price($this->disc->get_rent(30), $price, $ipay));
			
			$message .= '<tr><td style="width:149px; padding:20px"> <a href="'.$this->base.'/'.$blink.'"><img src="'.$bimg.'" width="88px" height="139px" alt="'.$bname.'" /><a/> </td><td> Sub-Order ID :- '.$order->bookshelf_order_id.'
				Placed On :- '.$porder->order_date.'
				
				<h3>'.$bname.'</h3>by '.$author.'
				    
						Initial Price Paid : Rs. '.($ipay-$dpay).'
						 
						Rent Charged : Rs. '.$order->cost.'
						Refund Amount : Rs. '.$order->refund.'<hr/></td></tr>
						
						Tracking id might take 24 hours to get activated.';
		}
				
		$message .= '</table>Your refund has been initiated and you will receive the amount in 5 to 7 working days.

			We hope you enjoyed reading the book. It will be amazing to have your views on the book so kindly take some time out from your busy schedule to write a quick Review of the book for us. For every review accepted by IndiaReads.com, you shall be given 2 Bonus Store Credits. If you have already written a review, we thank you for that.
			
			We hope to see you at IndiaReads.com
			
			<b>Enjoy Reading!
			Team, IndiaReads.com</b>
			
			<font size="2px"><center><b>IndiaReads.com</b>
			Toll Free: 1800-103-7323, Alternate No: 0120-2424233 Email: customercare@indiareads.com</center></font>
			</body>
			</html>';

		sendMail($email,$subject,nl2br($message));
	}
}
?>