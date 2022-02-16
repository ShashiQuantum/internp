<html>

<body>
<h2> Images List</h2>
<?php
//$directory = "__DIR__/uploads/image/camera";


/*
$directory = "https://digiadmin.quantumcs.com/vcimsweb/uploads/image";

echo "DIR : $directory <br>";
$images = glob($directory . "/*.jpg");

foreach($images as $image)
{
  echo $image;
}


/*


//$dir = "https://digiadmin.quantumcs.com/vcimsweb/uploads/image";
$dir = "/var/www/html/vcimsweb/uploads/image/camera";
echo "DIR : $dir<br>";

$dh  = opendir($dir);
while (false !== ($filename = readdir($dh))) {
    $files[] = $filename;
}
$images=preg_grep ('/\.jpg$/i', $files);
print_r($images);
?>
