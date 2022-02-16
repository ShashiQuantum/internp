<title> Add Translated Question Option</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" />   
<link href="<?php echo base_url(); ?>public/css/mslist/bootstrap.css" rel="stylesheet" type="text/css"/>

<div style="width:50%;margin: auto;padding: 10px;border: 3px solid green;">
<h3 style="text-align:center;"><u> Copy Translated Question Option</u></h3>
<a href="sadmlogin">Home</a>
<br><br><centre>
<?php
                                
	$this->load->model('MProject');
        $str=$this->MProject->getcopytqop();

	echo form_open('siteadmin/copytqop');
        echo $str;
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
-->>
<script>

$(document).ready(function(){
$(".chosen-select").chosen({
  no_results_text: "Oops, nothing found!"
})
});

</script>
