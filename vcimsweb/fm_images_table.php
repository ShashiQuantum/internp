<?php
//ob_start();
include_once('init.php');

date_default_timezone_set("Asia/Kolkata");

?>

<h2> Images from Database</h2>

<?php
	$sql = "SELECT * FROM vcimsweb.camera_image";
	$da=DB::getInstance()->query($sql);

	if($da->count()>0)
	{
		echo "<table border=1> <tr> <td> DID</td> <td>IMAGE NAME</td> <td> CREATED AT</td> </tr>";
		foreach($da->results() as $d)
		{
		 	$img = $d->image;
			$did = $d->did;
			$cdt = $d->created_at;
			echo "<tr> <td> $did </td> <td> $img </td> <td> $cdt </td> </tr>";

		}
		echo "</table>";
	}
	else echo "No any record found!";

?>
