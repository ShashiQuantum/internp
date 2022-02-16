<?php

include_once('../init.php');
include_once('../functions.php');

echo 'rr'.$qset = $_GET['qset'];
$ds=get_tabletkey($qset);
echo "<option value='0'> --Select-- </option>";

foreach($ds as $d)
{ $tid=$d->tab_id;
  $mid=$d->mobile;
 $str='';
       if($tid!=null)
          $str=$tid;
       if($mid!='')
          $str=$mid;

    echo "<option value='$str'> $str </option>";
} 



//to get all tablet/access key details
function get_tabletkey($qset=null)
{
    $q=DB::getInstance()->query("SELECT distinct `tab_id`,`mobile` FROM `tab_project_map` WHERE `project_id`='$qset' order by tab_id, mobile");
    if($q)
        return $q->results();
    else
        return false;
}

?>

