
<div id="site_content">
	<?php // include 'sidebar_applog.php' 
	?>
	<div id="content">
		<h3>Search for:  </h3>
		<!-- insert the page content here -->
		<p><table border=1>
		<tr><td colspan=8> </td><td colspan=29>Event-1</td><td colspan=29>Event-2</td><td colspan=29>Event-3</td><td colspan=29>Event-4</td><td colspan=29>Event-5</td></tr>
		<tr>
		<td colspan=4>Respondent </td><td colspan=2>App </td><td colspan=2>App Installed</td>

		<td colspan=2>Travel</td><td colspan=2>App-1</td><td colspan=2>App-2</td><td colspan=2>App-3</td><td colspan=2>App-Used</td><td colspan=5>App-Survey Data</td><td colspan=7>Ola Reason</td><td colspan=7>Uber Reason</td>
		<td colspan=2>Travel</td><td colspan=2>App-1</td><td colspan=2>App-2</td><td colspan=2>App-3</td><td colspan=2>App-Used</td><td colspan=5>App-Survey Data</td><td colspan=7>Ola Reason</td><td colspan=7>Uber Reason</td>
		<td colspan=2>Travel</td><td colspan=2>App-1</td><td colspan=2>App-2</td><td colspan=2>App-3</td><td colspan=2>App-Used</td><td colspan=5>App-Survey Data</td><td colspan=7>Ola Reason</td><td colspan=7>Uber Reason</td>

		<td colspan=2>Travel</td><td colspan=2>App-1</td><td colspan=2>App-2</td><td colspan=2>App-3</td><td colspan=2>App-Used</td><td colspan=5>App-Survey Data</td><td colspan=7>Ola Reason</td><td colspan=7>Uber Reason</td>

		<td colspan=2>Travel</td><td colspan=2>App-1</td><td colspan=2>App-2</td><td colspan=2>App-3</td><td colspan=2>App-Used</td><td colspan=5>App-Survey Data</td><td colspan=7>Ola Reason</td><td colspan=7>Uber Reason</td>

		</tr>
		<tr><td>Resp ID</td><td>Gender</td><td>Age</td><td>State</td><td>Start Time</td><td>No Of Event</td><td>Ola Inst</td><td>Uber Inst</td>
		<td>Travel</td><td>Travel Time</td><td>Name</td><td>Duration</td><td>Name</td><td>Duration</td><td>Name</td><td>Duration</td><td>Name</td><td>Total Duration</td><td>Count of App Switches</td><td>Resp. Travel</td><td>Ola/Uber</td><td>Mode</td><td>Occassion</td><td>Habit/Usually Take this</td><td>Cheaper/Economical/Affordable Options</td><td>Was Available Quickly</td><td>Bigger Car/Boot space</td><td>Coupon Code/offer/discount</td><td>Entertainment Option</td><td>Others</td><td>Habit/Usually Take this</td><td>Cheaper/Economical/Affordable Options</td><td>Was Available Quickly</td><td>Bigger Car/Boot space</td><td>Coupon Code/offer/discount</td><td>Entertainment Option</td><td>Others</td>
		<td>Travel</td><td>Travel Time</td><td>Name</td><td>Duration</td><td>Name</td><td>Duration</td><td>Name</td><td>Duration</td><td>Name</td><td>Total Duration</td><td>Count of App Switches</td><td>Resp. Travel</td><td>Ola/Uber</td><td>Mode</td><td>Occassion</td><td>Habit/Usually Take this</td><td>Cheaper/Economical/Affordable Options</td><td>Was Available Quickly</td><td>Bigger Car/Boot space</td><td>Coupon Code/offer/discount</td><td>Entertainment Option</td><td>Others</td><td>Habit/Usually Take this</td><td>Cheaper/Economical/Affordable Options</td><td>Was Available Quickly</td><td>Bigger Car/Boot space</td><td>Coupon Code/offer/discount</td><td>Entertainment Option</td><td>Others</td>
		<td>Travel</td><td>Travel Time</td><td>Name</td><td>Duration</td><td>Name</td><td>Duration</td><td>Name</td><td>Duration</td><td>Name</td><td>Total Duration</td><td>Count of App Switches</td><td>Resp. Travel</td><td>Ola/Uber</td><td>Mode</td><td>Occassion</td><td>Habit/Usually Take this</td><td>Cheaper/Economical/Affordable Options</td><td>Was Available Quickly</td><td>Bigger Car/Boot space</td><td>Coupon Code/offer/discount</td><td>Entertainment Option</td><td>Others</td><td>Habit/Usually Take this</td><td>Cheaper/Economical/Affordable Options</td><td>Was Available Quickly</td><td>Bigger Car/Boot space</td><td>Coupon Code/offer/discount</td><td>Entertainment Option</td><td>Others</td>
		<td>Travel</td><td>Travel Time</td><td>Name</td><td>Duration</td><td>Name</td><td>Duration</td><td>Name</td><td>Duration</td><td>Name</td><td>Total Duration</td><td>Count of App Switches</td><td>Resp. Travel</td><td>Ola/Uber</td><td>Mode</td><td>Occassion</td><td>Habit/Usually Take this</td><td>Cheaper/Economical/Affordable Options</td><td>Was Available Quickly</td><td>Bigger Car/Boot space</td><td>Coupon Code/offer/discount</td><td>Entertainment Option</td><td>Others</td><td>Habit/Usually Take this</td><td>Cheaper/Economical/Affordable Options</td><td>Was Available Quickly</td><td>Bigger Car/Boot space</td><td>Coupon Code/offer/discount</td><td>Entertainment Option</td><td>Others</td>
		<td>Travel</td><td>Travel Time</td><td>Name</td><td>Duration</td><td>Name</td><td>Duration</td><td>Name</td><td>Duration</td><td>Name</td><td>Total Duration</td><td>Count of App Switches</td><td>Resp. Travel</td><td>Ola/Uber</td><td>Mode</td><td>Occassion</td><td>Habit/Usually Take this</td><td>Cheaper/Economical/Affordable Options</td><td>Was Available Quickly</td><td>Bigger Car/Boot space</td><td>Coupon Code/offer/discount</td><td>Entertainment Option</td><td>Others</td><td>Habit/Usually Take this</td><td>Cheaper/Economical/Affordable Options</td><td>Was Available Quickly</td><td>Bigger Car/Boot space</td><td>Coupon Code/offer/discount</td><td>Entertainment Option</td><td>Others</td>		
		</tr> 
		
		<?php   if($posts);foreach ($posts as $p) { ?>
		
			<?php   
			$resp=$p->resp_id; $st=$p->start_time;
			$gen=0;$age=0;$stat=0;
			$ab1=0;$ab2=0;$ab3=0;
			$a1=0;$a2=0;$a3=0;$a4=0;$a5=0;$a6=0;$a7=0;$a8=0;$a9=0;$a10=0;$a11=0;$a12=0;$a13=0;$a14=0;$a15=0;$a16=0;$a17=0;$a18=0;$a19=0;$a20=0;$a21=0;$a22=0;$a23=0;$a24=0;$a25=0;$a26=0;$a27=0;$a28=0;$a29=0;
			$b1=0;$b2=0;$b3=0;$b4=0;$b5=0;$b6=0;$b7=0;$b8=0;$b9=0;$b10=0;$b11=0;$b12=0;$b13=0;$b14=0;$b15=0;$b16=0;$b17=0;$b18=0;$b19=0;$b20=0;$b21=0;$b22=0;$b23=0;$b24=0;$b25=0;$b26=0;$b27=0;$b28=0;$b29=0;
			$c1=0;$c2=0;$c3=0;$c4=0;$c5=0;$c6=0;$c7=0;$c8=0;$c9=0;$c10=0;$c11=0;$c12=0;$c13=0;$c14=0;$c15=0;$c16=0;$c17=0;$c18=0;$c19=0;$c20=0;$c21=0;$c22=0;$c23=0;$c24=0;$c25=0;$c26=0;$c27=0;$c28=0;$c29=0;
			$d1=0;$d2=0;$d3=0;$d4=0;$d5=0;$d6=0;$d7=0;$d8=0;$d9=0;$d10=0;$d11=0;$d12=0;$d13=0;$d14=0;$d15=0;$d16=0;$d17=0;$d18=0;$d19=0;$d20=0;$d21=0;$d22=0;$d23=0;$d24=0;$d25=0;$d26=0;$d27=0;$d28=0;$d29=0;
			$e1=0;$e2=0;$e3=0;$e4=0;$e5=0;$e6=0;$e7=0;$e8=0;$e9=0;$e10=0;$e11=0;$e12=0;$e13=0;$e14=0;$e15=0;$e16=0;$e17=0;$e18=0;$e19=0;$e20=0;$e21=0;$e22=0;$e23=0;$e24=0;$e25=0;$e26=0;$e27=0;$e28=0;$e29=0;
			
			
			// working for each resp_id and per day date basis if data found
				$this->load->model('MStartlist');
				$rspbasic = $this->MStartlist->get_basic($resp);
				if($rspbasic)
				foreach($rspbasic as $rb)
				{
				  $gen=$rb->rq1; $age=$rb->rq2;$stat=$rb->rq3;
				}
				
			$evt=1;
				$evr1 = $this->MStartlist->get_appevent($resp,$st,$evt);
				if($evr1)
				foreach($evr1 as $r)
				{
					$ab1=$r->ab1; $ab2=$r->ab2;$ab3=$r->ab3;
					$a1=$r->aa1; $a2=$r->aa2;$a3=$r->aa3;$a4=$r->aa4;$a5=$r->aa5;$a6=$r->aa6;$a7=$r->aa7;$a8=$r->aa8;$a9=$r->aa9;$a10=$r->aa10;
					$a11=$r->aa11; $a12=$r->aa12;$a13=$r->aa13;$a14=$r->aa14;$a15=$r->aa15;$a16=$r->aa16;$a17=$r->aa17;$a18=$r->aa18;$a19=$r->aa19;$a20=$r->aa20;
					$a21=$r->aa21; $a22=$r->aa22;$a23=$r->aa23;$a24=$r->aa24;$a25=$r->aa25;$a26=$r->aa26;$a27=$r->aa27;$a8=$r->aa8;$a29=$r->aa29;
					
				}
				
			$evt=2;
				$evr1 = $this->MStartlist->get_appevent($resp,$st,$evt);
				if($evr1)
				foreach($evr1 as $r)
				{
					
					$b1=$r->aa1; $b2=$r->aa2;$b3=$r->aa3;$b4=$r->aa4;$b5=$r->aa5;$b6=$r->aa6;$b7=$r->aa7;$b8=$r->aa8;$b9=$r->aa9;$b10=$r->aa10;
					$b11=$r->aa11; $b12=$r->aa12;$b13=$r->aa13;$b14=$r->aa14;$b15=$r->aa15;$b16=$r->aa16;$b17=$r->aa17;$b18=$r->aa18;$b19=$r->aa19;$b20=$r->aa20;
					$b21=$r->aa21; $b22=$r->aa22;$b23=$r->aa23;$b24=$r->aa24;$b25=$r->aa25;$b26=$r->aa26;$b27=$r->aa27;$b8=$r->aa8;$b29=$r->aa29;
									
				}
			$evt=3;
				$evr1 = $this->MStartlist->get_appevent($resp,$st,$evt);
				if($evr1)
				foreach($evr1 as $r)
				{
					
					$c1=$r->aa1; $c2=$r->aa2;$c3=$r->aa3;$c4=$r->aa4;$c5=$r->aa5;$c6=$r->aa6;$c7=$r->aa7;$c8=$r->aa8;$c9=$r->aa9;$c10=$r->aa10;
					$c11=$r->aa11; $c12=$r->aa12;$c13=$r->aa13;$c14=$r->aa14;$c15=$r->aa15;$c16=$r->aa16;$c17=$r->aa17;$c18=$r->aa18;$c19=$r->aa19;$c20=$r->aa20;
					$c21=$r->aa21; $c22=$r->aa22;$c23=$r->aa23;$c24=$r->aa24;$c25=$r->aa25;$c26=$r->aa26;$c27=$r->aa27;$c8=$r->aa8;$c29=$r->aa29;
								
				}
			$evt=4;
				$evr1 = $this->MStartlist->get_appevent($resp,$st,$evt);
				if($evr1)
				foreach($evr1 as $r)
				{
					$d1=$r->aa1; $d2=$r->aa2;$d3=$r->aa3;$d4=$r->aa4;$d5=$r->aa5;$d6=$r->aa6;$d7=$r->aa7;$d8=$r->aa8;$d9=$r->aa9;$d10=$r->aa10;
					$d11=$r->aa11; $d12=$r->aa12;$d13=$r->aa13;$d14=$r->aa14;$d15=$r->aa15;$d16=$r->aa16;$d17=$r->aa17;$d18=$r->aa18;$d19=$r->aa19;$d20=$r->aa20;
					$d21=$r->aa21; $d22=$r->aa22;$d23=$r->aa23;$d24=$r->aa24;$d25=$r->aa25;$d26=$r->aa26;$d27=$r->aa27;$d8=$r->aa8;$d29=$r->aa29;								
				}
			$evt=5;
				$evr1 = $this->MStartlist->get_appevent($resp,$st,$evt);
				if($evr1)
				foreach($evr1 as $r)
				{
					$e1=$r->aa1; $e2=$r->aa2;$e3=$r->aa3;$e4=$r->aa4;$e5=$r->aa5;$e6=$r->aa6;$e7=$r->aa7;$e8=$r->aa8;$e9=$r->aa9;$e10=$r->aa10;
					$e11=$r->aa11; $e12=$r->aa12;$e13=$r->aa13;$e14=$r->aa14;$e15=$r->aa15;$e16=$r->aa16;$e17=$r->aa17;$e18=$r->aa18;$e19=$r->aa19;$e20=$r->aa20;
					$e21=$r->aa21; $e22=$r->aa22;$e23=$r->aa23;$e24=$r->aa24;$e25=$r->aa25;$e26=$r->aa26;$e27=$r->aa27;$e8=$r->aa8;$e29=$r->aa29;
								
				}
		
			?>
			<tr>
			<td><?= $resp ?></td><td><?= $gen ?></td><td><?= $age ?></td><td><?= $stat ?></td><td><?= $st ?></td>			
			<td><?= $ab1 ?></td><td><?= $ab2 ?></td><td><?= $ab3 ?></td>
			
			<td><?= $a1 ?></td><td><?= $a2 ?></td><td><?= $a3 ?></td><td><?= $a4 ?></td><td><?= $a5 ?></td><td><?= $a6 ?></td><td><?= $a7 ?></td><td><?= $a8 ?></td><td><?= $a9 ?></td><td><?= $a10 ?></td>
			<td><?= $a11 ?></td><td><?= $a12 ?></td><td><?= $a13 ?></td><td><?= $a14 ?></td><td><?= $a15 ?></td><td><?= $a16 ?></td><td><?= $a17 ?></td><td><?= $a18 ?></td><td><?= $a19 ?></td><td><?= $a20 ?></td>
			<td><?= $a21 ?></td><td><?= $a22 ?></td><td><?= $a23 ?></td><td><?= $a24 ?></td><td><?= $a25 ?></td><td><?= $a26 ?></td><td><?= $a27 ?></td><td><?= $a28 ?></td><td><?= $a29 ?></td>
			
			<td><?= $b1 ?></td><td><?= $b2 ?></td><td><?= $b3 ?></td><td><?= $b4 ?></td><td><?= $b5 ?></td><td><?= $b6 ?></td><td><?= $b7 ?></td><td><?= $b8 ?></td><td><?= $b9 ?></td><td><?= $b10 ?></td>
			<td><?= $b11 ?></td><td><?= $b12 ?></td><td><?= $b13 ?></td><td><?= $b14 ?></td><td><?= $b15 ?></td><td><?= $b16 ?></td><td><?= $b17 ?></td><td><?= $b18 ?></td><td><?= $b19 ?></td><td><?= $b20 ?></td>
			<td><?= $b21 ?></td><td><?= $b22 ?></td><td><?= $b23 ?></td><td><?= $b24 ?></td><td><?= $b25 ?></td><td><?= $b26 ?></td><td><?= $b27 ?></td><td><?= $b28 ?></td><td><?= $b29 ?></td>
			
			<td><?= $c1 ?></td><td><?= $c2 ?></td><td><?= $c3 ?></td><td><?= $c4 ?></td><td><?= $c5 ?></td><td><?= $c6 ?></td><td><?= $c7 ?></td><td><?= $c8 ?></td><td><?= $c9 ?></td><td><?= $c10 ?></td>
			<td><?= $c11 ?></td><td><?= $c12 ?></td><td><?= $c13 ?></td><td><?= $c14 ?></td><td><?= $c15 ?></td><td><?= $c16 ?></td><td><?= $c17 ?></td><td><?= $c18 ?></td><td><?= $c19 ?></td><td><?= $c20 ?></td>
			<td><?= $c21 ?></td><td><?= $c22 ?></td><td><?= $c23 ?></td><td><?= $c24 ?></td><td><?= $c25 ?></td><td><?= $c26 ?></td><td><?= $c27 ?></td><td><?= $c28 ?></td><td><?= $c29 ?></td>
			
			<td><?= $d1 ?></td><td><?= $d2 ?></td><td><?= $d3 ?></td><td><?= $d4 ?></td><td><?= $d5 ?></td><td><?= $d6 ?></td><td><?= $d7 ?></td><td><?= $d8 ?></td><td><?= $d9 ?></td><td><?= $d10 ?></td>
			<td><?= $d11 ?></td><td><?= $d12 ?></td><td><?= $d13 ?></td><td><?= $d14 ?></td><td><?= $d15 ?></td><td><?= $d16 ?></td><td><?= $d17 ?></td><td><?= $d18 ?></td><td><?= $d19 ?></td><td><?= $d20 ?></td>
			<td><?= $d21 ?></td><td><?= $d22 ?></td><td><?= $d23 ?></td><td><?= $d24 ?></td><td><?= $d25 ?></td><td><?= $d26 ?></td><td><?= $d27 ?></td><td><?= $d28 ?></td><td><?= $d29 ?></td>
			
			<td><?= $e1 ?></td><td><?= $e2 ?></td><td><?= $e3 ?></td><td><?= $e4 ?></td><td><?= $e5 ?></td><td><?= $e6 ?></td><td><?= $e7 ?></td><td><?= $e8 ?></td><td><?= $e9 ?></td><td><?= $e10 ?></td>
			<td><?= $e11 ?></td><td><?= $e12 ?></td><td><?= $e13 ?></td><td><?= $e14 ?></td><td><?= $e15 ?></td><td><?= $e16 ?></td><td><?= $e17 ?></td><td><?= $e18 ?></td><td><?= $e19 ?></td><td><?= $e20 ?></td>
			<td><?= $e21 ?></td><td><?= $e22 ?></td><td><?= $e23 ?></td><td><?= $e24 ?></td><td><?= $e25 ?></td><td><?= $e26 ?></td><td><?= $e27 ?></td><td><?= $e28 ?></td><td><?= $e29 ?></td>
			
			
			</tr> 
			 
			<?php
		} ?> 
		</table></p>
	</div>
</div>



