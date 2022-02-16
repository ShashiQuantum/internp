<title> Add Translated Question Option</title>

<div style="width:50%;margin: auto;padding: 10px;border: 3px solid green;">
<h3 style="text-align:center;"><u> Copy Translated Question Option</u></h3>
<a href="sadmlogin">Home</a>
<br><br><centre>
<?php
                                
	$this->load->model('MProject');
        $pqs=$this->MProject->getPQs($qset);

	echo form_open('siteadmin/docopytqop');
        echo "<input type=hidden name=lang value= $lang ><br> Copy Questions's Options From: <select name=fqid>";
        foreach($pqs as $pq){
                $qid=$pq->q_id;
                //$qtitle=$pq->q_title;
                $qtype=$pq->q_type;
                $qno=$pq->qno;
                echo "<option value= $qid > $qno / $qid / $qtype";
        }

	echo "</select><br><br> Copy Question's Options To: <select name=tqid[] class='chosen-select'  multiple>";
        foreach($pqs as $pq){
		$qid=$pq->q_id;
		//$qtitle=$pq->q_title;
		$qtype=$pq->q_type;
		$qno=$pq->qno;
		echo "<option value= $qid > $qno / $qid / $qtype";
	}
	echo "</select><br><br><input type=submit name=copy value=Copy>";
?>
	
<?php
	echo form_close();

?>

</div>

<script>
function getpqset()
{
    var queryString ='';
   var pid = document.getElementById('pn').value;
   
   queryString = 'pn='+pid;
 
  jQuery.ajax({
	 url:'<?php echo base_url("siteadmin/getpqset/pn"); ?>',
     
	data:queryString,
	type: "POST",
	success:function(data){   
		$("#qset").html(data);
	},
	error:function (){}
	});
}

function getpqs()
{
    var queryString ='';
   var pid = document.getElementById('qset').value;
   
   queryString = 'pn='+pid;
 
  jQuery.ajax({
	 url:'<?php echo base_url("index.php/siteadmin/getpqs/pn"); ?>',
     
	data:queryString,
	type: "POST",
	success:function(data){  
		$("#pqid").html(data);
		$("#qs").html(data);
	},
	error:function (){}
	});
}

</script>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
<!--
<form action="http://httpbin.org/post" method="post">
  <select data-placeholder="Begin typing a name to filter..." multiple class="chosen-select" name="test">
    <option value=""></option>
    <option>American Black Bear</option>
    <option>Asiatic Black Bear</option>
    <option>Brown Bear</option>
    <option>Giant Panda</option>
    <option>Sloth Bear</option>
    <option>Sun Bear</option>
    <option>Polar Bear</option>
    <option>Spectacled Bear</option>
  </select>
  <input type="submit">
</form>
-->
<script>

$(document).ready(function(){
$(".chosen-select").chosen({
  no_results_text: "Oops, nothing found!"
})
});

</script>
