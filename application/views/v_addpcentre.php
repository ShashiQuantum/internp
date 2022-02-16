<title> Add Project Centre</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.3/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" />   
<link href="<?php echo base_url(); ?>public/css/mslist/bootstrap.css" rel="stylesheet" type="text/css"/>

<div style="width:50%;margin: auto;padding: 10px;border: 3px solid green;">
<h3 style="text-align:center;"><u> Add Project Centre</u></h3>
<a href="sadmlogin">Home</a>
<br><br><centre>
<?php
                                
					//			$this->load->model('MProject');
					//			$str=$this->MProject->getaddpcentre();
					//			echo form_open('siteadmin/addpcentre'); 
					//			echo $str;
					//			echo form_close(); 

?>

</div>

<script>
function getpqset()
{
    var queryString ='';
   var pid = document.getElementById('pn').value;
   
   queryString = 'pn='+pid;
 
  jQuery.ajax({
	url:'<?php echo base_url("index.php/siteadmin/getpqset/pn"); ?>',     
	data:queryString,
	type: "POST",
	success:function(data){   
		$("#qset").html(data);
	},
	error:function (){}
	});
}
</script>
