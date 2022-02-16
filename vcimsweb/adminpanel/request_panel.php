<?php
    	include_once('../init.php');
    	if(!Session::exists('suser'))
	{
		Redirect::to('login_fp.php');
	}
       if(isset($_POST['logout']))
         {
            session_destroy();
		//Cookie::delete($this->_cookieName);
		Redirect::to('login_fp.php');
            
         }
          echo "Hi <font color='lightgreen'>".Session::get('suser')."</font>"; 
?>

                              <form action="" method=post><input type=submit name=logout value=Logout><div style=float:right><img src='../../images/Digiadmin_logo.jpg' height=50 width=150> </div> <center><h3><font color=red >Order Request Details</font></h3></center>
    </div>
    
    

<div id="ctext">
    
<a href="#nreq">New Request</a> <a href="#pq">Price Quotas</a> <a href="#puposal">Purposal</a> <a href="#hod">Hold for Discussion</a> <a href="#paidord">Paid Order</a>

<?php
//ob_flush();
include_once('../init.php');
include_once('../functions.php');
?>
</div>

<div id="nreq">
<h6>New Request</h6>
<table border=1>
<tr bgcolor=lightgray><td>Req#</td><td>Req. Date</td><td>User ID</td><td>Description</td><td>Sample Size</td><td>No Of Centres</td><td>Expected Budget</td><td>Action</td></tr>
<?php
 $rr=DB::getInstance()->query("SELECT `req_id`, `user_id`, `rdate`, `cname`, `cmobile`, `email`, `ssize`, `ncentre`, `cbudget`, `desc`, `pay_st`, `status` FROM `vcims_user_request` WHERE `status`=1");
   
    if($rr->count()>0)
    foreach($rr->results() as $r)
    { $rid=$r->req_id; $uid=$r->user_id;$rdate=$r->rdate;$desc=$r->desc;$ssize=$r->ssize;$ncentre=$r->ncentre;$ebudget=$r->cbudget;
?>
   <tr><td><?= $rid;?></td><td><?= $uid; ?></td><td><?= $rdate; ?></td><td><?= $desc;?></td><td><?= $ssize; ?></td><td><?= $ncentre;?></td><td><?= $cbudget; ?></td><td>Send Cost</td></tr>

<?php                   
    }
?>
</table>
</div>

<div id="pq">
<h6>Request List of Price Quotas</h6>
<table border=1>
<tr bgcolor=lightgray><td>Req#</td><td>Req. Date</td><td>User ID</td><td>Description</td><td>Sample Size</td><td>No Of Centres</td><td>Expected Budget</td><td>Action</td></tr>
<?php
 $rr=DB::getInstance()->query("SELECT `req_id`, `user_id`, `rdate`, `cname`, `cmobile`, `email`, `ssize`, `ncentre`, `cbudget`, `desc`, `pay_st`, `status` FROM `vcims_user_request` WHERE `status`=2");
   
    if($rr->count()>0)
    foreach($rr->results() as $r)
    { $rid=$r->req_id; $uid=$r->user_id;$rdate=$r->rdate;$desc=$r->desc;$ssize=$r->ssize;$ncentre=$r->ncentre;$ebudget=$r->cbudget;
?>
   <tr><td><?= $rid;?></td><td><?= $uid; ?></td><td><?= $rdate; ?></td><td><?= $desc;?></td><td><?= $ssize; ?></td><td><?= $ncentre;?></td><td><?= $cbudget; ?></td><td>Send Cost</td></tr>

<?php                   
    }
?>
</table>
</div>

<div id="puosal">
<h6>Purposal</h6>
 <table border=1><tr bgcolor=lightgray><td >Req#</td><td>Req. Date</td><td>User ID</td><td>Description</td><td>Sample Size</td><td>No Of Centres</td><td>Expected Budget</td><td>Action</td></tr>
<?php
 $rr=DB::getInstance()->query("SELECT `req_id`, `user_id`, `rdate`, `cname`, `cmobile`, `email`, `ssize`, `ncentre`, `cbudget`, `desc`, `pay_st`, `status` FROM `vcims_user_request` WHERE `status`=2");
   
    if($rr->count()>0)
    foreach($rr->results() as $r)
    { $rid=$r->req_id; $uid=$r->user_id;$rdate=$r->rdate;$desc=$r->desc;$ssize=$r->ssize;$ncentre=$r->ncentre;$ebudget=$r->cbudget;
?>
   <tr><td><?= $rid;?></td><td><?= $uid; ?></td><td><?= $rdate; ?></td><td><?= $desc;?></td><td><?= $ssize; ?></td><td><?= $ncentre;?></td><td><?= $cbudget; ?></td><td>Send Cost</td></tr>

<?php                   
    }
?>
</table>
</div>

<div id="hod">
<h6>Request hold fordiscussion</h6>
<table border=1><tr bgcolor=lightgray><td>Req#</td><td>Req. Date</td><td>User ID</td><td>Description</td><td>Sample Size</td><td>No Of Centres</td><td>Expected Budget</td><td>Action</td></tr>
<?php
 $rr=DB::getInstance()->query("SELECT `req_id`, `user_id`, `rdate`, `cname`, `cmobile`, `email`, `ssize`, `ncentre`, `cbudget`, `desc`, `pay_st`, `status` FROM `vcims_user_request` WHERE `status`=2");
   
    if($rr->count()>0)
    foreach($rr->results() as $r)
    { $rid=$r->req_id; $uid=$r->user_id;$rdate=$r->rdate;$desc=$r->desc;$ssize=$r->ssize;$ncentre=$r->ncentre;$ebudget=$r->cbudget;
?>
   <tr><td><?= $rid;?></td><td><?= $uid; ?></td><td><?= $rdate; ?></td><td><?= $desc;?></td><td><?= $ssize; ?></td><td><?= $ncentre;?></td><td><?= $cbudget; ?></td><td>Send Cost</td></tr>

<?php                   
    }
?>
</table>
</div>

<div id="paidord">
<h6>Paid Orders</h6>
<table border=1><tr bgcolor=lightgray><td>Order#</td><td>Transaction#</td><td>Req#</td><td>Pay Date</td><td>User ID</td><td>Name</td><td>Email</td><td>Phone</td><td>Product Info</td><td>Amount</td><td>Status</td><td>Remarks</td><td>Action</td></tr>
<?php
 $rr=DB::getInstance()->query("SELECT `ord_id`, `req_id`, `user_id`, `cname`, `email`, `phone`, `productinfo`, `amount`, `mode`, `txnid`, `time`, `remarks`, `status` FROM `vcims_user_order_pay` WHERE `time`!=''  order by time desc");
   
    if($rr->count()>0)
    foreach($rr->results() as $r)
    { $ord_id=$r->ord_id;$rid=$r->req_id; $uid=$r->user_id;$cname=$r->cname;$email=$r->email;$phone=$r->phone;$prdinfo=$r->productinfo;$amount=$r->amount;$txnid=$r->txnid;$time=$r->time;$remarks=$r->remarks;$status=$r->status;
?>
   <tr><td><?= $ord_id; ?></td><td><?= $txnid; ?><td><?= $rid;?></td><td><?= $time; ?><td><?= $uid; ?></td><td><?= $cname; ?></td><td><?= $email;?></td><td><?= $phone; ?></td><td><?= $prdinfo;?></td><td><?= $amount; ?><td><?= $status; ?></td><td><?= $remarks; ?></td><td></td></tr>

<?php                   
    }
?>
</table>
</div>

