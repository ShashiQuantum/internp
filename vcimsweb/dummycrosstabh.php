<?php
include_once('init.php');
include_once('functions.php');
$pn = $_GET['pn'];
$pid=$_GET['ctp'];
$_SESSION['ctpid']=$pid;
$_SESSION['ctpn']=$pn;

$table = get_project_table($pid);
$table = $table.'_dummy';
$_SESSION['cttable'] = $table;

//echo $table;

$fpdata= get_project_fp($pid);
$pqtdata = get_project_question_term($pid);

$data=array_merge($fpdata,$pqtdata);
//print_r($fpdata);
$_SESSION['ctdata']=$data;

//$dtv = '2003/03/12';
//$tmv = '10:30';
//$dtv.=$tmv;
//$date = date_create($dtv);
//$date=date_create("2013-03-15 10:30");
//echo date_format($date,"Y/m/d H:i");
/*
$data= get_project_term($pid);
$arr_pqs=array();
$pqs=get_project_questions($pid);
if($pqs)
foreach($pqs as $pq){
	$qid=$pq->q_id;
	$qt=$pq->q_type;
	$qn=$pq->qno;
	if($qt == 'radio' || $qt == 'checkbox' || $qt == 'rating'){
		$qtt=$qid.'_'.$pid;
		$arr_pqs[ $qtt ] = $qn;
	}
} //end of getting qno of term
*/

//print_r($arr_pqs);
?>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Digiadmin CrossTab | <?=$pn?> </title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">


</head>
<body>
<div style="width:100%;height:auto;padding-left:30px;">
<img src="https://www.digiadmin.quantumcs.com/public/img/logos/Digiadmin_logow.png" style="float:left;height:30px;width:90px;">
<span style="float:right;color: red;margin-right:80px;"> <?=$pn; ?> </span>
</div>
<form NAME="tFORM" method="post" action="https://digiadmin.quantumcs.com/vcimsweb/crosstabr.php?pn=<?=$pn?>" target="_blank">
<table border=0 style="width:95%;height:10%;background-color:#719e62; margin-left: 30px; padding-right: 20px;">
<tr style="height:3px;"><td> </td><td><td></td><td></td>
<td> 
<!--
<div tooltipe="Show All">
        <button type=submit name=ctva style="float:right;">
        	<i class="fas fa-book-reader"></i>
        </button>
</div>

<div tooltipe="Export All">
	<button type=submit name=ctea >
	<i class="fas fa-file-download"></i>
	</button>
</div>
-->
</td></tr>
<tr>
<td>Scale: <select name='scale' style="display: inline-block; height: 30px;"><option value='tot'>Count</option><option value="totp">Table %</option><option value="rowp">Row %</option><option value="colp">Column %</option> </select></td>
<td style="height:3px;">X-Axis: 
<select id="xa" name="xa"  style="display: inline-block; height: 30px;">
<?php
	    $nctr=0;
         if($data) 
            foreach($data as $dd)
            { 
//print_r($dd); break;
                    $nctr++;
                    $tt=$dd['q_title'];
		    //$tt=$dd->title;
                    $term=$dd['term'];
                    $tx=$term.'x';  
                    $ty=$term.'y';
                    $nx=$term.'x';

		    //$ttt=$arr_pqs[$term];
		    $ttt=$dd['qno'];

		    if (strlen($tt) > 50)
   			$tt = substr($tt, 0, 40) . '...';
		    if($term == 'centre') echo "<option value='$term' selected> $tt </option>";
		    else	echo "<option value='$term'> $ttt - $tt </option>";
	    } //end of foreach
?>
</select>
</td>

<td>Y-Axis:
<select id="ya" name="ya[]" class="chosen-select"  multiple>
<?php
	    $nctr=0;
            if($data)
            foreach($data as $dd)
            {
                    $nctr++;
		    $tt=$dd['q_title'];
                    //$tt=$dd->title;
                    $term=$dd['term'];
                    $tx=$term.'x';
                    $ty=$term.'y';
                    $nx=$term.'x';

		    //$ttt=$arr_pqs[$term];
		    $ttt=$dd['qno'];

	                if (strlen($tt) > 50)
                        $tt = substr($tt, 0, 40) . '...';

                        echo "<option value='$term'> $ttt - $tt </option>";
            } //end of foreach

?>
</select></td>

<td>Filter:
<select id="fa" name="fa[]" class="chosen-select"  multiple>
<?php
		//$nctr=0;
               if($data) 
               foreach($data as $d)
               {
			//print_r($d);break;
			//$nctr++;
                        $term = $d['term'];
			$t = $d['q_title'];
                       	//$t= $d->title;
	                if (strlen($t) > 50)
                        	$t = substr($t, 0, 40) . '...';
			$ttt = $d['qno'];
			//$ttt=$arr_pqs[$term];

                    //$pftt=get_dictionary($term,$pid); //print_r($pftt)
			$pftt = $d['qop'];
			//print_r($pftt);break;

                    if($pftt)
                    foreach($pftt as $p)
                    {
			/*
			//$k=$p->keyy;
			//$v=$term.'='.$p->value;
			//$code=$p->value;
                        //if (!empty($_POST[$k])){ $str=" checked='checked'";}
			*/
			$k = $p['opt_text_value'];
			$code = $p['value'];
			$v=$term.'='.$code;
                        if (strlen($k) > 10)
                        	$k = substr($k, 0, 15) . '...';

                        if($ttt != '') echo "<option value='$v'> $ttt / $code - $k </option>";
			else echo "<option value='$v'> $term / $code - $k </option>";
                    }
                 //echo "</details>";
                 }
?>
</select></td>
<td><input type=submit name=ctv value='Show Report' style="display: inline-block; height: 30px; margin-bottom: -17px;"></td>
</tr>
</table>




<script>

$(document).ready(function(){
$(".chosen-select").chosen({
  no_results_text: "Oops, nothing found!"
})
});

</script>


<?php
if(isset($_POST['cv'])){
	print_r($_POST);
} //end to show
if(isset($_POST['cva'])){
        print_r($_POST);
} //end to show all

if(isset($_POST['cea'])){
        print_r($_POST);
} //end to export all


?>
