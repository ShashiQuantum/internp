<?php

//require_once('init.php');

if(isset($_POST['up']))
{
                if(isset($_FILES['audior']))
        	{
        	       // print_r($_FILES);
			$tmp = $_FILES['audior']['tmp_name'];
			echo $fname = $_FILES['audior']['name'];
			
			move_uploaded_file($tmp, '../uploads/audio/'.$fname);

                        echo "<br>Recorded & Saved<br>";
                        ?> <a href="<?php echo '../uploads/audio/'.$fname;?>" download>Download from Web</a> <?php
                 }
}

?>