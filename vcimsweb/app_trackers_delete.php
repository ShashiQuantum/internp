<?php
include_once('init.php');

?>
<head>
<title>App Trackers</title>
</head>
<body>
<a href="https://www.digiadmin.quantumcs.com/vcimsweb/app_trackers.php">Back</a>
<?php
if(isset($_POST['dsys'])){
        echo "Deleted System App All Data";
        $dsql="TRUNCATE TABLE vcims.app_tracker_system;";
        $qd1 = DB::getInstance()->query($dsq1);
}
if(isset($_POST['dman'])){
        echo 'Deleted Manual App All Data';
        $dsql2="TRUNCATE TABLE vcims.app_tracker_manual;";
        $qd1 = DB::getInstance()->query($dsq12);
}

if(isset($_POST['dcam'])){
        echo 'Deleted Camera App All Data';
        echo $dsql3 = "TRUNCATE TABLE vcims.app_tracker_camera ";
        echo $qd1 = DB::getInstance()->query( $dsq13 );
}

if(isset($_POST['dscr'])){
        echo 'Deleted Screen App All Data';
        $dsql4="TRUNCATE TABLE vcims.app_tracker_screen;";
        $qd1 = DB::getInstance()->query($dsq14);
}

?>
