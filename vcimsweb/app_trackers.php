<?php
include_once('init.php');
?>
<head>
<title>App Trackers</title>
</head>

<body>
<center>
<h3>APP TRACKER</h3>
<form action='' method=post>
Tracker : <select name=tt><option value=1>System</option><option value=2>Manual</option><option value=3>Screen</option><option value=4>Camera</option> <option value=5>SMS </option> </select>
<input type="submit" name="submit" value="View">
</form>
<table border=1 cellpadding=0 cellpadding=0>
<?php
if(isset($_POST['dsys'])){
	echo 'Deleted System App All Data';
	$dsql1 = "TRUNCATE TABLE vcims.app_tracker_system ";
	$qd11 = DB::getInstance()->query($dsql1);
}
if(isset($_POST['dman'])){
        echo 'Deleted Manual App All Data';
        $dsql2 = "TRUNCATE TABLE vcims.app_tracker_manual;";
        $qd12 = DB::getInstance()->query($dsql2);
}

if(isset($_POST['dcam'])){
        echo 'Deleted Camera App All Data';
        $dsql3 = "TRUNCATE TABLE vcims.app_tracker_camera ";
        $qd13 = DB::getInstance()->query( $dsql3 );
}

if(isset($_POST['dscr'])){
        echo 'Deleted Screen App All Data';
        $dsql4 = "TRUNCATE TABLE vcims.app_tracker_screen ";
        $qd14 = DB::getInstance()->query($dsql4);
}
if(isset($_POST['dsms'])){
        echo 'Deleted SMS App All Data';
        $dsql5 = "TRUNCATE TABLE vcims.app_tracker_sms ";
        $qd15 = DB::getInstance()->query($dsql5);
}

if(isset($_POST['submit'])){
	//print_r($_POST);

	if($_POST['tt']==1){
                echo "SYSTEM TRACKER<br>";
		echo "<form action='' method=post> <input type=submit name='dsys' value='Delete All System Tracker Data'> </form> <br>";
		$sq1 = "SELECT * FROM vcims.app_tracker_system;";
		$qd1 = DB::getInstance()->query($sq1);
		if($qd1->count()>0)
		{
			echo "<tr style='background:lightgray;'> <td> ID </td> <td>UID </td> <td>APP </td> <td>TOTAL TIME </td>  <td>FIRST TIMESTAMP </td> <td>LAST TIMSTAMP </td> <td> LAST USED TIME</td> <td>DURATION TYPE </td> <td>TIMESTAMP </td> </tr>";
			foreach($qd1->results() as $r1){
				$id=$r1->id; $uid=$r1->uid;$app=$r1->app;$tt=$r1->total_time;
				$tf=$r1->timestamp_first;$tl=$r1->timestamp_last;$lut=$r1->last_used_time;$dt=$r1->duration_type;$t=$r1->timestamp;
				echo "<tr><td> $id </td> <td> $uid </td> <td> $app </td> <td> $tt </td> <td> $tf </td><td> $tl </td><td> $lut </td><td> $dt </td><td> $t </td> </tr>";
			}
		}
	}
        if($_POST['tt']==2){
                echo "MANUAL TRACKER";
                echo "<form action='' method=post> <input type=submit name='dman' value='Delete All Manual Tracker Data'> </form> <br>";
                $sq1 = "SELECT * FROM vcims.app_tracker_manual;";
                $qd1 = DB::getInstance()->query($sq1);
                if($qd1->count()>0)
                {
                        echo "<tr style='background:lightgray;'> <td> ID </td> <td>UID </td> <td>APP </td> <td>START TIME </td> <td>END TIME</td> <td>DURATION</td><td>LATT</td><td>LANG</td><td>TIMESTAMP</td></tr>";
                        foreach($qd1->results() as $r1){
                                $id=$r1->id; $uid=$r1->uid;$app=$r1->app;$et=$r1->end_time;
                                $st=$r1->start_time;$d=$r1->duration;$lat=$r1->latt;$lan=$r1->lang;$t=$r1->timestamp;
                                echo "<tr><td> $id </td> <td> $uid </td> <td> $app </td> <td> $st </td> <td> $et </td> <td> $d </td><td> $lat </td><td> $lan </td><td> $t </td></tr>";
                        }
                }

        }
        if($_POST['tt']==3){
		echo "SCREEN TRACKER";
		echo "<form action='' method=post> <input type=submit name=dscr value='Delete All Screen Tracker Data'> </form> <br>";
                $sq1 = "SELECT * FROM vcims.app_tracker_screen;";
                $qd1 = DB::getInstance()->query($sq1);
                if($qd1->count()>0)
                {
                        echo "<tr style='background:lightgray;'> <td> ID </td> <td>UID </td> <td>SCID </td> <td> TEXT </td><td>OBJECT</td> <td>TIMESTAMP </td> </tr>";
                        foreach($qd1->results() as $r1){
                                $id=$r1->id; $uid=$r1->uid;$scid=$r1->scid;$txt=$r1->text;
                                $ob=$r1->object;$t=$r1->timestamp;
                                echo "<tr><td> $id </td> <td> $uid </td> <td> $scid </td> <td> $txt </td> <td> $ob </td> <td> $t </td></tr>";
                        }
                }

        }
        if($_POST['tt']==4){
                echo "CAMERA TRACKER";
                $sq1 = "SELECT * FROM vcims.app_tracker_camera;";
	                echo "<form action='' method=post> <input type=submit name=dcam value='Delete All Camera Tracker Data'> </form> <br>";
                $qd1 = DB::getInstance()->query($sq1);
                if($qd1->count()>0)
                {
                        echo "<tr style='background:lightgray;'> <td> ID </td> <td>UID </td> <td>CCID </td> <td> DATA </td> <td>TIMESTAMP </td> </tr>";
                        foreach($qd1->results() as $r1){
                                $id=$r1->id; $uid=$r1->uid; $ccid=$r1->ccid; $txt=$r1->data;
                                 $t=$r1->timestamp;
                                echo "<tr><td> $id </td> <td> $uid </td> <td> $ccid </td> <td> $txt </td> <td> $t </td></tr>";
                        }
                }

        }
        if($_POST['tt']==5){
                echo "SMS TRACKER";
                echo "<form action='' method=post> <input type=submit name='dsms' value='Delete All SMS Tracker Data'> </form> <br>";
                $sq1 = "SELECT * FROM vcims.app_tracker_sms;";
                $qd1 = DB::getInstance()->query($sq1);
                if($qd1->count()>0)
                {
                        echo "<tr style='background:lightgray;'> <td> ID </td> <td>UID </td> <td>BODY </td> <td>ADDRESS </td> <td>TIMESTAMP</td> </tr>";
                        foreach($qd1->results() as $r1){
                                $id=$r1->id; $uid = $r1->uid; $address = $r1->address; $body = $r1->body; $tm = $r1->timestamp;
                                echo "<tr><td> $id </td> <td> $uid </td> <td> $body </td> <td> $address </td> <td> $tm </td> </tr>";
                        }
                }

        }


}
?>

</body>

