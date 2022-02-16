<?php
//ob_start();
include_once('init.php');

date_default_timezone_set("Asia/Kolkata");

?>

<h2> OCR Processed Images from Database</h2>

<?php
        $sql = "SELECT * FROM vcimsweb.camera_image_ocr";
        $da=DB::getInstance()->query($sql);

        if($da->count()>0)
        {
                echo "<table border=1> <tr> <td> MODE</td> <td>IMAGE NAME</td> <td> OCR DATA</td> <td> ALL DATA</td> </tr>";
                foreach($da->results() as $d)
                {
                        $img = $d->image;
                        $mode = $d->mode;
                        $ocr = $d->ocr_data;
			$all = $d->all_data;

                        echo "<tr> <td> $mode </td> <td> $img </td> <td> $ocr </td> <td>$all </td> </tr>";

                }
                echo "</table>";
        }
        else echo "No any record found!";

?>

