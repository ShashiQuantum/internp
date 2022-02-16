<?php
//session_start();
include_once('../init.php');
//include_once('../functions.php');
 
 $qid = $_GET['qid'];

//echo "<table cellpadding=0 cellspacing=0 border=1 style=font-size:12px;><tr bgcolor=lightgray><td>Current Question</td><td>Option Value</td><td>Compare With</td><td>Routine Flow</td><td>Next Question </td><td>Section ID</td> </tr>";

//$dd=DB::getInstance()->query("");    

$qtd="SELECT  op_id, `q_id`,  `opt_text_value`, `opt_column_value`, `opt_image_value`, `opt_video_value`, `opt_audio_value`, `term`, `value`, `column_value`, `grid_value`, `txt_heading`, `rating1_heading`, `rating2_heading`, `rating1_value`, `rating2_value`, `rating1_title`, `rating2_title`, `textbox_count`, `text_term`, `rating_term`, `rating2_term`, `scale_start_value`, `scale_end_value`, `scale_start_label`, `scale_end_label` FROM `question_option_detail` WHERE `q_id`=$qid";

$dd=DB::getInstance()->query($qtd);
if($dd->count() > 0)
{   echo "<table border=2>";
    echo "<tr bgcolor=lightgray><td>OP_ID</td><td>Name</td><td>CODE</td><td>TERM</td><td>ACTION</td></tr>";
    $nctr=0;
    foreach($dd->results() as $d)
    {   $nctr++;
        $qid=$d->q_id;
        $opid=$d->op_id; 
        $text=$d->opt_text_value; 
        $v=$d->value;
        $term=$d->term;
        $ssv=$d->scale_start_value;
        $esv=$d->scale_end_value;
        
        //echo "<tr><td>$nctr</td><td>$text</td><td><input type=hidden name=opid value=$opid> $v</td><td>$term</td><td>#edit$opid onclick=edit($opid)>edit</a></td></tr>";       

 	echo "<form action='' method=post><tr id=show$opid ><td>$opid</td><td>$text</td><td>$v</td><td>$term</td><td><a href=#edit$opid onclick=edit($opid)>edit</a> </td> </tr></form>";
				
	echo "<form action='' method=post><tr id=edit$opid style=display:none><td><input type=hidden name=opid value=$opid><input type=hidden name=qid value=$qid>$opid</td><td><input type=text name=text STYLE='color: red;width:50px;' value='$text'></td>  <td><input type=text id=val name=val size=3 STYLE='color: red; width:50px;'  value=$val></td><td><input type=text name=term STYLE='color: red;width:1200px;' value='$term'></td><td><input type=submit name=save value=Save> <a href=#show$opid onclick=show($opid)>Cancel</a> </td> </tr></form>";
				
        
    }
   echo "</table>";
}else echo "--Options Not Available--";


    
?>

<script type="text/javascript">  
	    function edit(i)
	    {
	        var show= 'show'+i;
	        var edit= 'edit'+i;
	        document.getElementById(show).style.display = 'none';
	        document.getElementById(edit).style.display = 'table-row';
	    }
	    function show(i)
	    {
		    var show= 'show'+i;
		    var edit= 'edit'+i;
		    var move= 'move'+i;
		    document.getElementById(show).style.display = 'table-row';
		    document.getElementById(edit).style.display = 'none';
		    document.getElementById(move).style.display = 'none';
	    }
</script> 
