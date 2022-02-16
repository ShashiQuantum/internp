<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

</head>


<body>
<input type="checkbox" id="checkAll">Check All
<hr />
<input type="checkbox" id="checkItem">Item 1
<input type="checkbox" id="checkItem">Item 2
<input type="checkbox" id="checkItem">Item3
<body>

<script type="text/javascript">
$(document).ready(function(){ 
    
 $("#checkAll").click(function () {
     $('input:checkbox').not(this).prop('checked', this.checked);
 });
});
</script>
