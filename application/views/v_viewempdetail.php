<html>
<head>
<!-- Latest compiled and minified CSS -->
<!-- link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css" -->

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

<style>
.form-control{display:block;width:100%;height:34px;padding:6px 12px;font-size:14px;line-height:1.42857143;color:#555;background-color:#fff;background-image:none;border:1px solid #ccc;border-radius:4px;-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075);box-shadow:inset 0 1px 1px rgba(0,0,0,.075);-webkit-transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s;-o-transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s;-webkit-transition:border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;transition:border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s;transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s,-webkit-box-shadow ease-in-out .15s}.form-control:focus{border-color:#66afe9;outline:0;-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgba(102,175,233,.6);box-shadow:inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgba(102,175,233,.6)}.form-control::-moz-placeholder{color:#999;opacity:1}.form-control:-ms-input-placeholder{color:#999}.form-control::-webkit-input-placeholder{color:#999}.form-control::-ms-expand{background-color:transparent;border:0}.form-control[disabled],.form-control[readonly],fieldset[disabled] .form-control{background-color:#eee;opacity:1}.form-control[disabled],fieldset[disabled] .form-control{cursor:not-allowed}textarea.form-control{height:auto}@media screen and (-webkit-min-device-pixel-ratio:0){input[type=date].form-control,input[type=datetime-local].form-control,input[type=month].form-control,input[type=time].form-control{line-height:34px}.input-group-sm input[type=date],.input-group-sm input[type=datetime-local],.input-group-sm input[type=month],.input-group-sm input[type=time],input[type=date].input-sm,input[type=datetime-local].input-sm,input[type=month].input-sm,input[type=time].input-sm{line-height:30px}.input-group-lg input[type=date],.input-group-lg input[type=datetime-local],.input-group-lg input[type=month],.input-group-lg input[type=time],input[type=date].input-lg,input[type=datetime-local].input-lg,input[type=month].input-lg,input[type=time].input-lg{line-height:46px}}

</style>

</head>
<body>
<center>
<div class="card">
  <div class="card-body">

<?php
if($type == 'edit')
{
//print_r($empdata);
?>
<br>  <h4 class="card-subtitle mb-2 text-muted">Edit Employee Details</h4>

<form method="post" action="<?=base_url();?>hr/doeditemp" style='margin-top:50px;'>

<table> 
<tbody>

<?php

if(!empty($empdata))
foreach($empdata as $e)
{
	$uid = $e->id;
	$emp_id =$e->emp_id;

	$ddob = $e->dob;
	$ddobc = $e->dobc;
	if($ddobc == '') $ddobc=$ddob;
	$ddoj = $e->doj;

	$role = $e->role;

        $ts = $e->timeslot_id;

	$cid = $e->company_id;
	$bid = $e->branch_id;
	$st = $e->status;

	$statuss = array("1"=>"Active","0"=>"Blocked");
	$roles = array("1"=>"HR","2"=>"Manager","3"=>"Employee");
	$slotes = $this->MHr->getDataBySql("SELECT * FROM vpms.vamps_timeslot");
	$branches = $this->MHr->getDataBySql("SELECT * FROM vpms.vams_branch WHERE company_id=$cid ; ");
	
//print_r($slotes);

?>

<tr>
<td><label class='control-label'>Emp ID *</label></td><input type=hidden name=uid value='<?=$uid;?>' >
<td><input class='form-control' type="text" name="empid" id="empid" value=<?=$e->emp_id;?> > </td>
</tr> 
<tr>
<td><label class='control-label'>Employee Full Name *</label></td>
<td><input class='form-control' type="text" name="empname" id="empname" value='<?=$e->name;?>' ></td>
</tr>
<tr>
<td><label class='control-label'>Email *</label></td>
<td><input class='form-control' type="email" name="empemail" id="empemail" value='<?=$e->email;?>' ></td>
</tr>
<tr>
<td><label class='control-label'>Mobile as Login *</label></td>
<td><input class='form-control' type="number" name="empmobile" id="empmobile" value='<?=$e->mobile;?>' disabled> </td>
</tr>
<tr>
<td><label class='control-label'>Designation *</label></td>
<td><input class='form-control' type="text" name="empdesg" id="empdesg" value='<?=$e->designation;?>' > </td>
</tr>
<tr>
<td><label class='control-label'>Role *</label></td>
<td>
<!-- input type='text' value='<?=$role_str;?>' class='form-control' name="emprole" id="emprole" required -->
<select class='form-control' name="emprole" id="emprole" required>
<?php
foreach($roles as $kr=>$vr)
{
        $str_r="";
        if($role == $kr) $str_r=" selected";

?>
<option value= '<?=$kr;?>' <?=$str_r;?> > <?=$vr;?> </option>

<?php } ?>

</select>
</td>
</tr>
<tr>
<td><label class='control-label'>Employee DOJ *</label></td>
<td><input class='form-control' type="date" name="empdoj" id="empdoj" value='<?=date("Y-m-d",($ddoj/1000));?>' disabled> </td>
</tr>
<tr>
<td><label class='control-label'>Employee DOB *</label></td>
<td><input class='form-control' type="date" name="empdob" id="empdob" value='<?php echo date("Y-m-d",($ddob/1000));?>' disabled></td>
</tr>
<tr>
<td><label class='control-label'>Employee DOB Celebration *</label></td>
<td><input class='form-control' type="date" name="empdobc" id="empdobc" value='<?=date("Y-m-d",($ddobc/1000));?>' ></td>
</tr>
<tr>
<td><label class='control-label'>Shift Time Slot *</label></td>
<td>
<!-- input type=text value='<?=$ts_str;?>' class='form-control' name="empshift" id="empshift" required -->
<select class='form-control' name="empshift" id="empshift" required>

<?php
foreach($slotes as $vss)
{
	$tid = $vss->timeslot_id;
	$itm = $vss->in_time;
	$otm = $vss->out_time;

        $str_ss="";
        if($ts == $tid) $str_ss=" selected";

?>
<option value= '<?=$tid ;?>' <?=$str_ss;?> > <?php echo " $itm AM - $otm PM ";?> </option>

<?php } ?>

</select>
</td>
</tr>
<tr>
<td><label class='control-label'>Company *</label></td>
<td><select class='form-control' name="empcomp" id="empcomp" required>
<option value="1" selected>Varenia CIMS Pvt Ltd</option> 
</select>
</td>
</tr>
<tr>
<td><label class='control-label'>Branch ID *</label></td>
<td>
<select class='form-control' name="empbranch" id="empbranch" required>
<?php
foreach($branches as $bs)
{
        $sbid = $bs->branch_id;
        $add = $bs->address;
        $day1 = $bs->day1;
	$day2 = $bs->day2;

        $str_bs="";
        if($bid == $sbid) $str_bs=" selected";

?>
<option value= '<?=$sbid ;?>' <?=$str_bs;?> > <?php echo " $add [Weekly Off Day: $day1 & $day2] ";?> </option>

<?php } ?>

</select>
</td>
</tr>

<tr>
<td><label class='control-label'>Status *</label></td>
<td>
<select class='form-control' name="empstatus" id="empstaus" >
<?php
foreach($statuss as $ks=>$vs)
{
	$str_s="";
	if($st == $ks) $str_s=" selected";

?>
<option value= '<?=$ks;?>' <?=$str_s;?> > <?=$vs;?> </option>

<?php } ?>
</select>
</td>
</tr>

<?php } ?>
</tbody>
</table>
<div class='form-group'>
<br/>
<input class='btn btn-primary' type="submit" name="submit" value="SUBMIT">
</div>
</form>

<?php } ?>

<?php
if($type == 'report')
{
?>
    <h4 class="card-subtitle mb-2 text-muted">View Employee Details</h4>
<table> 
<tbody>

<?php

if(!empty($empdata))
foreach($empdata as $e)
{
	$ddob = $e->dob;
	$ddobc = $e->dobc;
	if($ddobc == '') $ddobc=$ddob;
	$ddoj = $e->doj;

	$role = $e->role;
	$role_str = 'HR';
	if($role == '2') $role_str='Manager';
	if($role == '3') $role_str='Employee';

        $ts = $e->timeslot_id;
        $ts_str = '08:00 AM - 05:00 PM';
        if($ts == '2') $ts_str='09:00 AM - 06:00 PM';
        if($ts == '3') $ts_str='10:00 AM - 07:00 PM';

	$cid = $e->company_id;
	$bid = $e->branch_id;

	
?>

<tr>
<td><label class='control-label'>Emp ID *</label></td>
<td><input class='form-control' type="text" name="empid" id="empid" value=<?=$e->emp_id;?> disabled> </td>
</tr> 
<tr>
<td><label class='control-label'>Employee Full Name *</label></td>
<td><input class='form-control' type="text" name="empname" id="empname" value='<?=$e->name;?>' disabled></td>
</tr>
<tr>
<td><label class='control-label'>Email *</label></td>
<td><input class='form-control' type="email" name="empemail" id="empemail" value='<?=$e->email;?>' ></td>
</tr>
<tr>
<td><label class='control-label'>Mobile as Login *</label></td>
<td><input class='form-control' type="number" name="empmobile" id="empmobile" value='<?=$e->mobile;?>' disabled> </td>
</tr>
<tr>
<td><label class='control-label'>Designation *</label></td>
<td><input class='form-control' type="text" name="empdesg" id="empdesg" value='<?=$e->designation;?>' disabled> </td>
</tr>
<tr>
<td><label class='control-label'>Role *</label></td>
<td>
<input type='text' value='<?=$role_str;?>' class='form-control' name="emprole" id="emprole" required>
<!-- select class='form-control' name="emprole" id="emprole" required>
<option disabled>Select Role</option>
<option value="1" disabled>HR</option>
<option value="2" disabled>MANAGER</option>
<option value="3" disabled>EMPLOYEE</option -->
</select>
</td>
</tr>
<tr>
<td><label class='control-label'>Employee DOJ *</label></td>
<td><input class='form-control' type="date" name="empdoj" id="empdoj" value='<?=date("Y-m-d",($ddoj/1000));?>' disabled> </td>
</tr>
<tr>
<td><label class='control-label'>Employee DOB *</label></td>
<td><input class='form-control' type="date" name="empdob" id="empdob" value='<?php echo date("Y-m-d",($ddob/1000));?>' disabled></td>
</tr>
<tr>
<td><label class='control-label'>Employee DOBC *</label></td>
<td><input class='form-control' type="date" name="empdobc" id="empdobc" value='<?=date("Y-m-d",($ddobc/1000));?>' disabled></td>
</tr>
<tr>
<td><label class='control-label'>Shift Time Slot *</label></td>
<td>
<input type=text value='<?=$ts_str;?>' class='form-control' name="empshift" id="empshift" required>
<!-- select class='form-control' name="empshift" id="empshift" required>
<option disabled>Select Shift</option>
<option value="1" disabled>08:00 AM - 05:00 PM</option>
<option value="2" disabled>09:00 AM - 06:00 PM</option> 
<option value="3" disabled>10:00 AM - 07:00 PM</option> 
</select -->
</td>
</tr>
<tr>
<td><label class='control-label'>Company *</label></td>
<td><select class='form-control' name="empcomp" id="empcomp" required>
<option value="1" selected>Varenia CIMS Pvt Ltd</option> 
</select>
</td>
</tr>
<tr>
<td><label class='control-label'>Branch ID *</label></td>
<td>
<select class='form-control' name="empbranch" id="empbranch" required>
<option value="1" selected>Gurugram, Hariyana, India</option>
<option value="2" disabled>Delhi, India</option> 
<option value="3" disabled>Bengaluru, India</option>
<option value="4" disabled>Mumbai, India</option> 
</select>
</td>
</tr>
<!-- tr>
<td><label class='control-label'>Total Leave Alloted *</label></td>
<td><input class='form-control' type="number" name="empleave" min="0" max="22" disabled>
</td>
</tr>
<tr>
<td><label class='control-label'>Leave Alloted From *</label></td>
<td><input class='form-control' type="date" name="empleavefrom" disabled></td>
</tr>
<tr>
<td><label class='control-label'>Leave Alloted Till *</label></td>
<td><input class='form-control' type="date" name="empleavetill" disabled></td>
</tr -->
<?php } ?>
</tbody>
</table>

<?php } ?>

  </div>
</div>
</center>
</body>
</html>
