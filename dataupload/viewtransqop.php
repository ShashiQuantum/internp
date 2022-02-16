<?php
        $pn = $_GET['pn'];
$connect = mysqli_connect("database-1.c1mggasso0hp.ap-south-1.rds.amazonaws.com","qcsrdsadmin","Pa7du#ah$098","vcims");
if(!$connect){
	echo 'unsuccess'.mysqli_error;
}
else{
	// $qset=$_SESSION['qset'];	
	$qset = $_GET['ctp'];
	$pn = $_GET['pn'];
	$sql = "select * from question_detail where q_id IN (SELECT qid FROM question_sequence WHERE qset_id=$qset ORDER BY sid)ORDER BY q_id ";
	$hit = mysqli_query($connect,$sql);	
	//echo $sql_o = "select * from question_option_detail where qset_id = $qset order by q_id,value";
	//$hit_o = mysqli_query($connect,$sql_o);
}

?>
<html>
<head>
<title><?=$pn?> | View Template</title>
<script>
function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}

</script>
</head>
<body>
<table id="tblData" border='1px'>
    <tr>
        <th>qid</th>
		<th>question/option</th>
        <th>Original Text</th>
		<th>q_sno/opt_value</th>
		<th>Hindi</th>
		<th>Kannad</th>
		<th>Malyalam</th>
		<th>Tammil</th>
		<th>Telgu</th>
		<th>Bangla</th>
		<th>Odia</th>
		<th>Gujrati</th>
		<th>Marathi</th>
		<th>Asami</th>
    </tr>
	
	<?php
	
	while($row = mysqli_fetch_assoc($hit)){ $qtype = $row['q_type']; ?>
		 <tr>
        <td><?php echo $qid = $row['q_id'];?></td>
		<td><?php echo 'q';?></td>
        <td><?php echo $row['q_title'];?></td>
        <td><?php echo $row['qno'];?></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		</tr>
	
	<?php 
		//} 

	?>
	<?php
	$sql_o = "select * from question_option_detail where q_id = $qid order by value asc";
        $hit_o = mysqli_query($connect,$sql_o);
	if($qtype == 'instruction' || $qtype == 'text' || $qtype == 'textarea' || $qtype == 'rating') continue;
	while($row1 = mysqli_fetch_assoc($hit_o)){?>
		 <tr>
        <td><?php echo $row1['q_id'];?></td>
		<td><?php echo 'o';?></td>
        <td><?php echo $row1['opt_text_value'];?></td>
        <td><?php echo $row1['value'];?></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		</tr>
	
	<?php }} ?>
</table>
<button onclick="exportTableToExcel('tblData', '<?=$pn?>')">Export Table Data To Excel File</button>
</body>
</html>
