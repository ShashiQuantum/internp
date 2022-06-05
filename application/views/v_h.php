<!DOCTYPE HTML>
<html>

<head>
    	<title>Quantum | Digiadmin</title>
        <meta name="description" content="" />
        <title>Quantum | Digiadmin</title>
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <meta name="author" content="Digiadmin Quantum" />
        <link rel="shortcut icon" href="<?php echo base_url(); ?>public/img/logos/varenia_logo2.png">

    <meta http-equiv="content-type" content="text/html; charset=windows-1252" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Tangerine&amp;v1" />
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz" />
   	<link rel="stylesheet" type="text/css" href="<?= base_url()?>public/css/style.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/css/bootstrap-theme.min.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/css/bootstrap.min.css" />
	
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/vendor/font-awesome/css/font-awesome.min.css">
     <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/css/agency2.css">
     <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/css/agency2.min.css" >
 
</head>
<style>
.page-scroll { 
font-size : 13px;
}
</style>

<style>
            tr.myDragClass td {
                /*position: fixed;*/
                color: yellow;
                text-shadow: 0 0 10px black, 0 0 10px black, 0 0 8px black, 0 0 6px black, 0 0 6px black;
                background-color: #999;
                -webkit-box-shadow: 0 12px 14px -12px #111 inset, 0 -2px 2px -1px #333 inset;
            }
            tr.myDragClass td:first-child {
                -webkit-box-shadow: 0 12px 14px -12px #111 inset, 12px 0 14px -12px #111 inset, 0 -2px 2px -1px #333 inset;
            }
            tr.myDragClass td:last-child {
                -webkit-box-shadow: 0 12px 14px -12px #111 inset, -12px 0 14px -12px #111 inset, 0 -2px 2px -1px #333 inset;
            }
  </style>

  <script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
 
 <script src="<?= base_url()?>public/js/tablednd.js" ></script>
  <script src="<?= base_url()?>public/js/tablednd.min.js" ></script>


<script>

function userAction(action,product_code) {  
	var queryString = "";
	if(action != "") {
		switch(action) {
                        case "vrusradd":
                                queryString = 'action='+action;
                        break;
                        case "vrusredit":
                                queryString = 'action='+action;
                        break;
                        case "vrusrview":
                                queryString = 'action='+action;
                        break;
                        case "vrradd":
                                queryString = 'action='+action;
                        break;
                        case "vrredit":
                                queryString = 'action='+action;
                        break;
                        case "vrrview":
                                queryString = 'action='+action;
                        break;
                        case "vrrusradd":
                                queryString = 'action='+action;
                        break;
                        case "vrrusredit":
                                queryString = 'action='+action;
                        break;
                        case "vrrusrview":
                                queryString = 'action='+action;
                        break;
                        case "setpquota":
                                queryString = 'action='+action;
                        break;

			case "usradd":
				queryString = 'action='+action;
			break;
                      
			case "usredit":
				queryString = 'action='+action;
			break;
                        case "usrview":
				queryString = 'action='+action;
			break;
                        case "usrremove":
				queryString = 'action='+action;
			break;
			case "clear":
				queryString = 'action='+action;
			break;
                        case "prmassign":
				queryString = 'action='+action;
			break;
                        case "prmadd":
				queryString = 'action='+action;
			break;
                        case "prmview":
				queryString = 'action='+action;
			break;
                        case "prmrevoke":
				queryString = 'action='+action;
			break;
                        case "addtab":
				queryString = 'action='+action;
			break;   
                        case "issuetab":
				queryString = 'action='+action;
			break;
                        case "receivetab":
				queryString = 'action='+action;
			break;
                        case "tabreport":
				queryString = 'action='+action;
			break;
                        case "addinterv":
				queryString = 'action='+action;
			break;


                        case "tabprm":
				queryString = 'action='+action;
			break;
                        case "rgtrresp":
				queryString = 'action='+action;
			break;
                        case "reporttabpermission":
				queryString = 'action='+action;
			break;

                        case "issuetab":
				queryString = 'action='+action;
			break;
                        case "projectdata":
				queryString = 'action='+action;
			break;
                      
                        case "getpqset":
				queryString = 'action='+action;
			break;
                        case "mdureport":
				queryString = 'action='+action;
			break;
                        case "mdusreport":
				queryString = 'action='+action;
			break;
                        case "mdssreport":
				queryString = 'action='+action;
			break;
                        case "mdmbreport":
				queryString = 'action='+action;
			break;
                        case "mdbsreport":
				queryString = 'action='+action;
			break;
                        case "mdudclean":
				queryString = 'action='+action;
			break;
                        case "viewpcrosstab":
				queryString = 'action='+action;
			break;
                        case "viewpdummycrosstab":
                                queryString = 'action='+action;
                        break;
			case "createemptytable":
				queryString = 'action='+action;
			break;
			case "dummydataupload":
				queryString = 'action='+action;
			break;

                        case "transdataupload":
                                queryString = 'action='+action;
                        break;
                        case "viewtransdataupload":
                                queryString = 'action='+action;
                        break;

                        case "viewproject":
				queryString = 'action='+action;
			break;
                        case "viewqb":
				queryString = 'action='+action;
			break;
                        case "viewqnre":
				queryString = 'action='+action;
			break;
                        case "viewquestion":
				queryString = 'action='+action;
			break;
                        case "viewquestionop":
				queryString = 'action='+action;
			break;
                        case "viewsequence":
				queryString = 'action='+action;
			break;
                        case "viewroutine":
				queryString = 'action='+action;
			break;
                        case "viewpcentre":
				queryString = 'action='+action;
			break;
                        case "editpcentre":
                                queryString = 'action='+action;
                        break;
                        case "editpfp":
                                queryString = 'action='+action;
                        break;
                        case "viewprule":
                                queryString = 'action='+action;
                        break;
			
			case "editproject":
				queryString = 'action='+action;
			break;
                        case "editquestion":
				queryString = 'action='+action;
			break;
                        case "editquestionop":
				queryString = 'action='+action;
			break;
                        case "editsequence":
				queryString = 'action='+action;
			break;
			case "editroutine":
				queryString = 'action='+action;
			break;
			case "updatesequence":
				queryString = 'action='+action;
			break;

                        case "createproject":
				queryString = 'action='+action;
			break;
                        case "createqset":
				queryString = 'action='+action;
			break;
                        case "createquestion":
				queryString = 'action='+action;
			break;
                        case "createsequence":
				queryString = 'action='+action;
			break;
                        case "createroutine":
				queryString = 'action='+action;
			break;
                        case "createqbcat":
				queryString = 'action='+action;
			break;

                        case "addqbquest":
				queryString = 'action='+action;
			break;
                        case "addqop":
				queryString = 'action='+action;
			break;
                        case "addsequence":
				queryString = 'action='+action;
			break;
                        case "addpcentre":
				queryString = 'action='+action;
			break;
                        case "addcentre":
				queryString = 'action='+action;
			break;
                        case "addpproduct":
				queryString = 'action='+action;
			break;
                        case "addpstore":
				queryString = 'action='+action;
			break;
                        case "addpsec":
				queryString = 'action='+action;
			break;
                        case "addarea":
				queryString = 'action='+action;
			break;
                        case "addsubarea":
				queryString = 'action='+action;
			break;
                        case "addpage":
				queryString = 'action='+action;
			break;
                        case "addtransq":
				queryString = 'action='+action;
			break;
                        case "addtransqop":
				queryString = 'action='+action;
			break;
                        case "addpcrosstab":
				queryString = 'action='+action;
			break;
                        case "addrule":
				queryString = 'action='+action;
			break;
                        case "addmedia":
				queryString = 'action='+action;
			break;
                        case "copyqbquest":
				queryString = 'action='+action;
			break;
                        case "copyquestionop":
				queryString = 'action='+action;
			break;
                        case "copytquestionop":
                                queryString = 'action='+action;
                        break;
                        case "deletesequence":
				queryString = 'action='+action;
			break;
                        case "deleteroutine":
				queryString = 'action='+action;
			break;
                        case "deletequestion":
				queryString = 'action='+action;
			break;
                        case "deletequestionop":
				queryString = 'action='+action;
			break;
                        case "editrule":
				queryString = 'action='+action;
			break;
		}	 
	}
	jQuery.ajax({
	 url:'<?php echo base_url("siteadmin/user_action/action/"); ?>'+action,
    //url:'http://160.153.17.79/v/welcome/filter_product/action'+action,
	data:queryString,
	type: "POST",
	success:function(data){  
		$("#p-item").html(data);
		if(action != "") {
			switch(action) {
				case "getpqset":  
					$("#qset").html(81);
					$("#added_"+product_code).show();
				break;
				
                                case "prmassign":  
					$("#add_"+product_code).hide();
					$("#added_"+product_code).show();
				break;
			}	 
		}
	},
	 error: function (request, status, error) {//alert(error);
        $("#page-wrapper").html(request.responseText );
    }	

	});
}

function getmaxpsid()
{
   var queryString ='';
   var pid = document.getElementById('pn').value;
   queryString = 'pid='+pid;
   jQuery.ajax({
        url:'<?php echo base_url("siteadmin/getmaxpsid/pn"); ?>',
        data:queryString,
        type: "POST",
        success:function(data){
		console.log(data);
                $("#esid").val(data);
        },
        error:function (err){ console.log('error:'+err); }
        });
}

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
	 url:'<?php echo base_url("siteadmin/getpqs/pn"); ?>',
	data:queryString,
	type: "POST",
	success:function(data){  
		$("#pqid").html(data);
		$("#qs").html(data);
	},
	error:function (){}
	});
}
//to get qop for edit
function getpeditqs()
{
    var queryString ='';
   var pid = document.getElementById('qset').value;
   queryString = 'pn='+pid;
  jQuery.ajax({
         url:'<?php echo base_url("siteadmin/getpeditqs/pn"); ?>',
        data:queryString,
        type: "POST",
        success:function(data){
                //$("#pqid").html(data);
                $("#qs").html(data);
        },
        error:function (){}
        });
}

function getpqsf()
{
    var queryString ='';
   var pid = document.getElementById('qset').value;

   queryString = 'pn='+pid;

  jQuery.ajax({
         url:'<?php echo base_url("siteadmin/getpqsf/pn"); ?>',

        data:queryString,
        type: "POST",
        success:function(data){
                //$("#pqid").html(data);
                $("#qid").html(data);
        },
        error:function (){}
        });
}
function getqop()
{
   var queryString ='';
   var pqid = document.getElementById('qs').value;
   queryString = 'qs='+pqid;
   jQuery.ajax({
         url:'<?php echo base_url("siteadmin/getqop/qs"); ?>',

        data:queryString,
        type: "POST",
        success:function(data){
                $("#oplist").html(data);
        },
        error:function (){}
        });
}

function getpqop()
{
   var queryString ='';
   var pqid = document.getElementById('pqid').value;   
   queryString = 'pqid='+pqid;
   jQuery.ajax({
	 url:'<?php echo base_url("siteadmin/getpqop/pqid"); ?>',
     
	data:queryString,
	type: "POST",
	success:function(data){  
		$("#oplist").html(data);
	},
	error:function (){}
	});
}
function gettqop()
{
   var queryString ='';
   var qid = document.getElementById('qs').value;   
   queryString = 'qid='+qid;
   jQuery.ajax({
	 url:'<?php echo base_url("siteadmin/gettqop/pqid"); ?>',
     
	data:queryString,
	type: "POST",
	success:function(data){  
		$("#qop").html(data);
	},
	error:function (){}
	});
}
function getpqt()
{      var qt = document.getElementById('qt').value;   
       var elem = document.getElementById('oplist'); 
       var elem1 = document.getElementById('pqid'); 
       var elem2 = document.getElementById('rat');
      if(qt=='radio' || qt=='checkbox')
      {           
            elem.style.display = 'inline'; 
            elem1.style.display = 'inline';
            elem2.style.display = 'none';
      }
      if(qt=='rating')
      {
          elem.style.display = 'none';
          elem1.style.display = 'none';
          elem2.style.display = 'inline';
      }
      else
      {    //var elem1 = document.getElementById('pqid'); 
           //elem1.style.display = 'none';
           //var elem = document.getElementById('oplist');
          // elem.style.display = 'none';
           //elem2.style.display = 'none';
      }
             
}
function getrule()
{      var rt = document.getElementById('rt').value;
       var elem = document.getElementById('oplist');
       var elem1 = document.getElementById('list');
      if(rt=='1' || rt=='2' || rt=='3' || rt=='4' || rt=='5' || rt=='6' || rt == '7' || rt == '8' || rt == '9' || rt == '10' || rt == '11' || rt == '12' || rt == '13' || rt == '14' )
            elem.style.display = 'inline';
}
function editrule()
{      var rt = document.getElementById('rt').value;
       var qset = document.getElementById('qset').value;
       var elem = document.getElementById('list');
       var queryString ='';
      if(rt=='1' || rt=='2' || rt=='3' || rt =='4' || rt=='5' || rt == '6' || rt == '7' || rt== '8' || rt== '9' || rt == '10' || rt == '11' || rt == '12' || rt == '13' || rt == '14' )
            elem.style.display = 'inline';
        queryString = 'qset='+qset+'&rt='+rt;
        jQuery.ajax({
	url:'<?php echo base_url("siteadmin/editdrule"); ?>',
	data:queryString,
	type: "GET",
	success:function(data){
		$("#list").html(data);
	},
	error:function (){}
	});   
}

function getvrut()
{
    var queryString ='';
   var uid = document.getElementById('uid').value;
   queryString = 'uid='+uid;
  jQuery.ajax({
         url:'<?php echo base_url("siteadmin/getvrutype/"); ?>'+'/'+uid,
        data:queryString,
        type: "POST",
        success:function(data){
                //$("#pqid").html(data);
                $("#ut").html(data);
        },
        error:function (){}
        });
}
function getvrun()
{
    var queryString ='';
   var uid = document.getElementById('uid').value;
   queryString = 'uid='+uid;
  jQuery.ajax({
         url:'<?php echo base_url("siteadmin/getvruname/"); ?>'+'/'+uid,
        data:queryString,
        type: "POST",
        success:function(data){
                //$("#pqid").html(data);
                $("#un").html(data);
        },
        error:function (){}
        });
}
function getvrmob()
{
    var queryString ='';
   var uid = document.getElementById('uid').value;
   queryString = 'uid='+uid;
  jQuery.ajax({
         url:'<?php echo base_url("siteadmin/getvrumobile/"); ?>'+'/'+uid,
        data:queryString,
        type: "POST",
        success:function(data){
                //$("#pqid").html(data);
                $("#mobile").html(data);
        },
        error:function (){}
        });
}
function copyruleshowhidefirst()
{
        var cq = document.getElementById('cqid1').value;
        var pq = document.getElementById('pqid1').value;
        var op = document.getElementById('pqop1').value;
        var gr = document.getElementById('group1').value;
        var f = document.getElementById('flag1').value;

        var ctr = document.getElementById('cnt').value;
        for (i = 2; i <= ctr; i++) {
                var ii = i - 1;
                var cqn = parseInt(cq) + ii;
		var opn = parseInt(op) + ii;
                var stx = document.getElementById('cqid'+i).value = cqn;
                var tbx = document.getElementById('pqid'+i).value = pq;
                var sx = document.getElementById('pqop'+i).value = opn;
               var rwx = document.getElementById('group'+i).value = gr;
                var flx = document.getElementById('flag'+i).value = f;
        }
	return false;
}


function copyrulegridfirst()
{
        var st = document.getElementById('stb1').value;
        var tb = document.getElementById('tb1').value;
        var fl = document.getElementById('flag1').value;
        var rw = document.getElementById('rw1').value;

        var ctr = document.getElementById('cnt').value;
	for (i = 2; i <= ctr; i++) {
		var ii = i - 1;	
		var stn = parseInt(st) + ii;
		var stx = document.getElementById('stb'+i).value = stn;
        	var tbx = document.getElementById('tb'+i).value = tb;
        	var flx = document.getElementById('flag'+i).value = fl;
        	var rwx = document.getElementById('rw'+i).value = rw;
	}
	return false;
}

function copyrulefindreplacefirst()
{

        var st = document.getElementById('fwd1').value;
        var tb = document.getElementById('rwd1').value;
        var fl = document.getElementById('cqid1').value;
        var rw = document.getElementById('op1').value;
        var rq = document.getElementById('rqid1').value;

        var ctr = document.getElementById('cnt').value;
	for (i = 2; i <= ctr; i++) {
		var ii = i - 1;	
		var rwn = parseInt(rw) + ii;
		var stx = document.getElementById('fwd'+i).value = st;
        	var tbx = document.getElementById('rwd'+i).value=tb;
        	var flx = document.getElementById('cqid'+i).value=fl;
        	var rwx = document.getElementById('op'+i).value=rwn;
        	var rqx = document.getElementById('rqid'+i).value=rq;
		
	}
	return false;
}
function generaterule() {
        var a = parseInt(document.getElementById("cnt").value);  
	document.getElementById("list").innerHTML = "";
        var ch = document.getElementById("list");
        var rt = document.getElementById('rt').value;
        if(rt=='1')
        { 
           for (i = 1; i <= a; i++) {            
                var panel=document.createElement("div");
                panel.style.width="485px"; panel.style.padding="0px";panel.style.align="left";                
                var ch1 = document.createElement("input");
                ch1.style.width="105px";
                var tmp1='stb'+i; var tm=''+i+'';
                ch1.setAttribute("type", "text");
                ch1.setAttribute("value",  tm );
                ch1.setAttribute("id", tmp1);
                ch1.setAttribute("name", tmp1);
                ch1.required= true;
                panel.appendChild(ch1);
                var ch2 = document.createElement("input");
                ch2.style.width="150px";
                var tmp2='tb'+i;
                ch2.setAttribute("type", "text");
                ch2.setAttribute("placeholder", "QID "+i+"");
                ch2.setAttribute("id", tmp2);
                ch2.setAttribute("name", tmp2);
                ch2.required= true;
                panel.appendChild(ch2);
                 var ch3 = document.createElement("input");
                ch3.style.width="90px";
                var tmp3='grp'+i;
                ch3.setAttribute("type", "text");
                ch3.setAttribute("placeholder", "grp no "+i+"");
                ch3.setAttribute("id", tmp3);
                ch3.setAttribute("name", tmp3);
                ch3.required= true;
                panel.appendChild(ch3);
                ch.appendChild(panel);
           }   
        }
        if(rt=='2')
        { 
           for (i = 1; i <= a; i++) {            
                var panel=document.createElement("div");
                panel.style.width="485px"; panel.style.padding="0px";panel.style.align="left";                
                var ch1 = document.createElement("input");
                ch1.style.width="105px";
                var tmp='stb'+i; var tm=''+i+'';
                ch1.setAttribute("type", "text");
                //ch1.setAttribute("value",  tm );
                ch1.setAttribute("placeholder", "Tab ID "+i+"");
                ch1.setAttribute("id", tmp);
                ch1.setAttribute("name", tmp);
                ch1.required= true;
                panel.appendChild(ch1);
                var ch2 = document.createElement("input");
                ch2.style.width="150px";
                var tmp2='qid'+i;
                ch2.setAttribute("type", "text");
                ch2.setAttribute("placeholder", "QID "+i+"");
                ch2.setAttribute("id", tmp2);
                ch2.setAttribute("name", tmp2);
                ch2.required= true;
                panel.appendChild(ch2);
                 var ch3 = document.createElement("input");
                ch3.style.width="90px";
                var tmp3='op'+i;
                ch3.setAttribute("type", "text");
                ch3.setAttribute("placeholder", "OP Value "+i+"");
                ch3.setAttribute("id", tmp3);
                ch3.setAttribute("name", tmp3);
                ch3.required= true;
                panel.appendChild(ch3);
                var ch4 = document.createElement("input");
                ch4.style.width="105px";
                var tmp4='q'+i;
                ch4.setAttribute("type", "text");
                ch4.setAttribute("placeholder", "Quata Limit "+i+"");
                ch4.setAttribute("id", tmp4);
                ch4.setAttribute("name", tmp4);
                ch4.required= true;
                panel.appendChild(ch4);
                ch.appendChild(panel);
           }   
        }
        if(rt=='3')
        { 
           for (i = 1; i <= a; i++) {            
                var panel=document.createElement("div");
                panel.style.width="585px"; panel.style.padding="0px";panel.style.align="left";                
                var ch1 = document.createElement("input");
                ch1.style.width="115px";
                var tmp='stb'+i; var tm=''+i+'';
                ch1.setAttribute("type", "text");
                //ch1.setAttribute("value",  tm );
                ch1.setAttribute("placeholder", "CQID "+i+"");
                ch1.setAttribute("id", tmp);
                ch1.setAttribute("name", tmp);
                ch1.required= true;
                panel.appendChild(ch1);

                var ch3 = document.createElement("input");
                ch3.style.width="90px";
                var tmp2='tb'+i;
                ch3.setAttribute("type", "text");
                ch3.setAttribute("placeholder", "grp no "+i+"");
                ch3.setAttribute("id", tmp2);
                ch3.setAttribute("name", tmp2);
                ch3.required= true;
                panel.appendChild(ch3);

                var ch2 = document.createElement("select");
                ch2.style.width="250px";
                var tmp2='flag'+i;
                ch2.setAttribute("id", tmp2);
                ch2.setAttribute("name", tmp2);
                ch2.required= true;
                panel.appendChild(ch2);
                        var option1 = document.createElement("option");
                        option1.value = 1;
                        option1.text = 'Grid Only';
                        ch2.appendChild(option1);
                        var option2 = document.createElement("option");
                        option2.value = 2;
                        option2.text = 'Only Question rotation (Grid)';
                        ch2.appendChild(option2);
                        var option3 = document.createElement("option");
                        option3.value = 3;
                        option3.text = 'Only Option rotation (Grid)';
                        ch2.appendChild(option3);
                        var option4 = document.createElement("option");
                        option4.value = 4;
                        option4.text = 'Question & Options rotation (Grid)';
                        ch2.appendChild(option4);
                        var option5 = document.createElement("option");
                        option5.value = 5;
                        option5.text = 'Question rotation (No Grid)';
                        ch2.appendChild(option5);
                        var option6 = document.createElement("option");
                        option6.value = 6;
                        option6.text = 'Question Position Fix in rotation (No Grid)';
                        ch2.appendChild(option6);
                        var option7 = document.createElement("option");
                        option7.value = 7;
                        option7.text = 'Option rotation (No Grid)';
                        ch2.appendChild(option7);
                        var option8 = document.createElement("option");
                        option8.value = 8;
                        option8.text = 'Question & Options rotation (No Grid)';
                        ch2.appendChild(option8);

                var ch4 = document.createElement("input");
                ch4.style.width="40px";
                var tmp4='rw'+i;
                ch4.setAttribute("type", "text");
                ch4.setAttribute("placeholder", "Row"+i+"");
                ch4.setAttribute("id", tmp4);
                ch4.setAttribute("name", tmp4);
                ch4.required= true;
                panel.appendChild(ch4);


                ch.appendChild(panel);
           }   
        } 	
        if(rt=='4')
        { 
           for (i = 1; i <= a; i++) {            
                var panel=document.createElement("div");
                panel.style.width="585px"; panel.style.padding="0px";panel.style.align="left";                
                var ch1 = document.createElement("input");
                ch1.style.width="115px";
                var tmp='stb'+i; var tm=''+i+'';
                ch1.setAttribute("type", "text");
                //ch1.setAttribute("value",  tm );
                ch1.setAttribute("placeholder", "PQID "+i+"");
                ch1.setAttribute("id", tmp);
                ch1.setAttribute("name", tmp);
                ch1.required= true;
                panel.appendChild(ch1);
                var ch3 = document.createElement("input");
                ch3.style.width="90px";
                var tmp2='tb'+i;
                ch3.setAttribute("type", "text");
                ch3.setAttribute("placeholder", "CQID");
                ch3.setAttribute("id", tmp2);
                ch3.setAttribute("name", tmp2);
                ch3.required= true; 
               panel.appendChild(ch3);
                var ch4 = document.createElement("select");
                ch4.style.width="205px";
                var tmp4='flag'+i;
                ch4.setAttribute("id", tmp4);
                ch4.setAttribute("name", tmp4);
                ch4.required= true;
                panel.appendChild(ch4);
                        var option1 = document.createElement("option");
                        option1.value = 1;
                        option1.text = 'OR';
                        ch4.appendChild(option1);
                        var option2 = document.createElement("option");
                        option2.value = 2;
                        option2.text = 'AND';
                        ch4.appendChild(option2);

                ch.appendChild(panel);
           }   
        }
        if(rt=='5')
        { 
           for (i = 1; i <= a; i++) {            
                var panel=document.createElement("div");
                panel.style.width="485px"; panel.style.padding="0px";panel.style.align="left";                
                var ch1 = document.createElement("input");
                ch1.style.width="115px";
                var tmp='stb'+i; var tm=''+i+'';
                ch1.setAttribute("type", "text");
                //ch1.setAttribute("value",  tm );
                ch1.setAttribute("placeholder", "PQID "+i+"");
                ch1.setAttribute("id", tmp);
                ch1.setAttribute("name", tmp);
                ch1.required= true;
                panel.appendChild(ch1);
                var ch3 = document.createElement("input");
                ch3.style.width="90px";
                var tmp2='tb'+i;
                ch3.setAttribute("type", "text");
                ch3.setAttribute("placeholder", "CQID");
                ch3.setAttribute("id", tmp2);
                ch3.setAttribute("name", tmp2);
                ch3.required= true; 
               panel.appendChild(ch3);
                ch.appendChild(panel);
           }   
        }
        if(rt=='6')
        { 
           for (i = 1; i <= a; i++) {            
                var panel=document.createElement("div");
                panel.style.width="485px"; panel.style.padding="0px";panel.style.align="left";                
                var ch1 = document.createElement("input");
                ch1.style.width="115px";
                var tmp='stb'+i; var tm=''+i+'';
                ch1.setAttribute("type", "text");
                //ch1.setAttribute("value",  tm );
                ch1.setAttribute("placeholder", "PQID "+i+"");
                ch1.setAttribute("id", tmp);
                ch1.setAttribute("name", tmp);
                ch1.required= true;
                panel.appendChild(ch1);
                var ch3 = document.createElement("input");
                ch3.style.width="90px";
                var tmp2='tb'+i;
                ch3.setAttribute("type", "text");
                ch3.setAttribute("placeholder", "CQID");
                ch3.setAttribute("id", tmp2);
                ch3.setAttribute("name", tmp2);
                ch3.required= true;
                panel.appendChild(ch3);
                ch.appendChild(panel);
           }   
        }
        if(rt=='7')
        {
           for (i = 1; i <= a; i++) {
                var panel=document.createElement("div");
                panel.style.width="885px"; panel.style.padding="0px";panel.style.align="left";
                var ch1 = document.createElement("input");
                ch1.style.width="205px";
                var tmp='fwd'+i; var tm=''+i+'';
                ch1.setAttribute("type", "text");
                ch1.setAttribute("placeholder", "Find Word"+i+"");
                ch1.setAttribute("id", tmp);
                ch1.setAttribute("name", tmp);
                ch1.required= true;
                panel.appendChild(ch1);
                var chr = document.createElement("input");
                chr.style.width="305px";
                var tmp='rwd'+i; var tm=''+i+'';
                chr.setAttribute("type", "text");
                chr.setAttribute("placeholder", "Replace Word"+i+"");
                chr.setAttribute("id", tmp);
                chr.setAttribute("name", tmp);
                chr.required= true;
                panel.appendChild(chr);
                var ch2 = document.createElement("input");
                ch2.style.width="105px";
                var tmp2='cqid'+i;
                ch2.setAttribute("type", "text");
                ch2.setAttribute("placeholder", "CQID "+i+"");
                ch2.setAttribute("id", tmp2);
                ch2.setAttribute("name", tmp2);
                ch2.required= true;
                panel.appendChild(ch2);
                 var ch3 = document.createElement("input");
                ch3.style.width="90px";
                var tmp3='op'+i;
                ch3.setAttribute("type", "text");
                ch3.setAttribute("placeholder", "OP Value "+i+"");
                ch3.setAttribute("id", tmp3);
                ch3.setAttribute("name", tmp3);
                ch3.required= true;
                panel.appendChild(ch3);
                var ch4 = document.createElement("input");
                ch4.style.width="105px";
                var tmp4='rqid'+i;
                ch4.setAttribute("type", "text");
                ch4.setAttribute("placeholder", "To QID "+i+"");
                ch4.setAttribute("id", tmp4);
                ch4.setAttribute("name", tmp4);
                ch4.required= true;
                panel.appendChild(ch4);
                ch.appendChild(panel);
           }
        }
        if(rt=='8')
        {
           for (i = 1; i <= a; i++) {
                var panel=document.createElement("div");
                panel.style.width="885px"; panel.style.padding="0px";panel.style.align="left";
                var ch1 = document.createElement("input");
                ch1.style.width="205px";
                var tmp1='cqid'+i; var tm=''+i+'';
                ch1.setAttribute("type", "text");
                ch1.setAttribute("placeholder", "CQID"+i+"");
                ch1.setAttribute("id", tmp1);
                ch1.setAttribute("name", tmp1);
                ch1.required= true;
                panel.appendChild(ch1);
                var chr = document.createElement("input");
                chr.style.width="305px";
                var tmp='opv'+i; var tm=''+i+'';
                chr.setAttribute("type", "text");
                chr.setAttribute("placeholder", "OP Value"+i+"");
                chr.setAttribute("id", tmp);
                chr.setAttribute("name", tmp);
                chr.required= true;
                panel.appendChild(chr);
                var ch2 = document.createElement("input");
                ch2.style.width="105px";
                var tmp2='pqid'+i;
                ch2.setAttribute("type", "text");
                ch2.setAttribute("placeholder", "PQID "+i+"");
                ch2.setAttribute("id", tmp2);
                ch2.setAttribute("name", tmp2);
                ch2.required= true;
                panel.appendChild(ch2);
                 var ch3 = document.createElement("input");
                ch3.style.width="90px";
                var tmp3='sval'+i;
                ch3.setAttribute("type", "text");
                ch3.setAttribute("placeholder", "Start Value "+i+"");
                ch3.setAttribute("id", tmp3);
                ch3.setAttribute("name", tmp3);
                ch3.required= true;
                panel.appendChild(ch3);
                var ch4 = document.createElement("input");
                ch4.style.width="105px";
                var tmp4='eval'+i;
                ch4.setAttribute("type", "text");
                ch4.setAttribute("placeholder", "End Value "+i+"");
                ch4.setAttribute("id", tmp4);
                ch4.setAttribute("name", tmp4);
                ch4.required= true;
                panel.appendChild(ch4);

                ch.appendChild(panel);
           }
        }
        if(rt=='9')
        {
           for (i = 1; i <= a; i++) {
                var panel=document.createElement("div");
                panel.style.width="885px"; panel.style.padding="0px";panel.style.align="left";
                var ch1 = document.createElement("input");
                ch1.style.width="205px";
                var tmp1='cqid'+i; var tm=''+i+'';
                ch1.setAttribute("type", "text");
                ch1.setAttribute("placeholder", "CQID"+i+"");
                ch1.setAttribute("id", tmp1);
                ch1.setAttribute("name", tmp1);
                ch1.required= true;
                panel.appendChild(ch1);

                var ch2 = document.createElement("input");
                ch2.style.width="50px";
                var tmp2='opcode'+i;
                ch2.setAttribute("type", "text");
                ch2.setAttribute("placeholder", "OPCODE "+i+"");
                ch2.setAttribute("id", tmp2);
                ch2.setAttribute("name", tmp2);
                ch2.required= false;
                panel.appendChild(ch2);

                 var ch3 = document.createElement("input");
                ch3.style.width="90px";
                var tmp3='sval'+i;
                ch3.setAttribute("type", "text");
                ch3.setAttribute("placeholder", "Start Value "+i+"");
                ch3.setAttribute("id", tmp3);
                ch3.setAttribute("name", tmp3);
                ch3.required= true;
                panel.appendChild(ch3);
                var ch4 = document.createElement("input");
                ch4.style.width="105px";
                var tmp4='eval'+i;
                ch4.setAttribute("type", "text");
                ch4.setAttribute("placeholder", "End Value "+i+"");
                ch4.setAttribute("id", tmp4);
                ch4.setAttribute("name", tmp4);
                ch4.required= true;
                panel.appendChild(ch4);

                ch.appendChild(panel);
           }
        }

        if(rt=='10')
        {
           for (i = 1; i <= a; i++) {
                var panel=document.createElement("div");
                panel.style.width="485px"; panel.style.padding="0px";panel.style.align="left";
                var ch2 = document.createElement("input");
                ch2.style.width="150px";
                var tmp2='qid'+i;
                ch2.setAttribute("type", "text");
                ch2.setAttribute("placeholder", "QID "+i+"");
                ch2.setAttribute("id", tmp2);
                ch2.setAttribute("name", tmp2);
                ch2.required= true;
                panel.appendChild(ch2);
		ch.appendChild(panel);
           }
        }
        if(rt=='12')
        {
           for (i = 1; i <= a; i++) {
                var panel=document.createElement("div");
                panel.style.width="585px"; panel.style.padding="0px";panel.style.align="left";

                var ch1 = document.createElement("input");
                ch1.style.width="100px";
                var tmp1='cqid'+i;
                ch1.setAttribute("type", "text");
                ch1.setAttribute("placeholder", "CQID"+i+"");
                ch1.setAttribute("id", tmp1);
                ch1.setAttribute("name", tmp1);
                ch1.required= true;
                panel.appendChild(ch1);

                var ch2 = document.createElement("input");
                ch2.style.width="100px";
                var tmp2='cqopfr'+i;
                ch2.setAttribute("type", "text");
                ch2.setAttribute("placeholder", "CQ OP FR"+i+"");
                ch2.setAttribute("id", tmp2);
                ch2.setAttribute("name", tmp2);
                ch2.required= true;
                panel.appendChild(ch2);

                var ch3 = document.createElement("input");
                ch3.style.width="100px";
                var tmp3='cqopto'+i;
                ch3.setAttribute("type", "text");
                ch3.setAttribute("placeholder", "CQID OP TO"+i+"");
                ch3.setAttribute("id", tmp3);
                ch3.setAttribute("name", tmp3);
                ch3.required= true;
                panel.appendChild(ch3);

                var ch4 = document.createElement("input");
                ch4.style.width="100px";
                var tmp4='pqid'+i;
                ch4.setAttribute("type", "text");
                ch4.setAttribute("placeholder", "PQID"+i+"");
                ch4.setAttribute("id", tmp4);
                ch4.setAttribute("name", tmp4);
                ch4.required= true;
                panel.appendChild(ch4);

                var ch5 = document.createElement("input");
                ch5.style.width="100px";
                var tmp5='pqop'+i;
                ch5.setAttribute("type", "text");
                ch5.setAttribute("placeholder", "PQID OP"+i+"");
                ch5.setAttribute("id", tmp5);
                ch5.setAttribute("name", tmp5);
                ch5.required= true;
                panel.appendChild(ch5);

                ch.appendChild(panel);
           }
	}

        if(rt=='11')
        {
           for (i = 1; i <= a; i++) {
                var panel=document.createElement("div");
                panel.style.width="585px"; panel.style.padding="0px";panel.style.align="left";

                var ch1 = document.createElement("input");
                ch1.style.width="100px";
                var tmp1='cqid'+i;
                ch1.setAttribute("type", "text");
                ch1.setAttribute("placeholder", "CQID "+i+"");
                ch1.setAttribute("id", tmp1);
                ch1.setAttribute("name", tmp1);
                ch1.required= true;
                panel.appendChild(ch1);

                var ch2 = document.createElement("input");
                ch2.style.width="100px";
                var tmp2='pqid'+i;
                ch2.setAttribute("type", "text");
                ch2.setAttribute("placeholder", "PQID "+i+"");
                ch2.setAttribute("id", tmp2);
                ch2.setAttribute("name", tmp2);
                ch2.required= true;
                panel.appendChild(ch2);
                ch.appendChild(panel);

                var ch3 = document.createElement("input");
                ch3.style.width="100px";
                var tmp3='copv'+i;
                ch3.setAttribute("type", "text");
                ch3.setAttribute("placeholder", "CQID OP Value "+i+"");
                ch3.setAttribute("id", tmp3);
                ch3.setAttribute("name", tmp3);
                ch3.required= true;
                panel.appendChild(ch3);

                var ch4 = document.createElement("input");
                ch4.style.width="100px";
                var tmp4='val'+i;
                ch4.setAttribute("type", "text");
                ch4.setAttribute("placeholder", "Fix Value "+i+"");
                ch4.setAttribute("id", tmp4);
                ch4.setAttribute("name", tmp4);
                ch4.required= true;
                panel.appendChild(ch4);

                ch.appendChild(panel);

		} //end for loop
        } //end for  11
        if(rt=='13')
        {
           for (i = 1; i <= a; i++) {
                var panel=document.createElement("div");
                panel.style.width="685px"; panel.style.padding="0px";panel.style.align="left";

                var ch1 = document.createElement("input");
                ch1.style.width="100px";
                var tmp1='cqid'+i;
                ch1.setAttribute("type", "text");
                ch1.setAttribute("placeholder", "CQID"+i+"");
                ch1.setAttribute("id", tmp1);
                ch1.setAttribute("name", tmp1);
                ch1.required= true;
                panel.appendChild(ch1);

                var ch2 = document.createElement("input");
                ch2.style.width="100px";
                var tmp2='pqid'+i;
                ch2.setAttribute("type", "text");
                ch2.setAttribute("placeholder", "PQID"+i+"");
                ch2.setAttribute("id", tmp2);
                ch2.setAttribute("name", tmp2);
                ch2.required= true;
                panel.appendChild(ch2);

                var ch3 = document.createElement("input");
                ch3.style.width="100px";
                var tmp3='pqop'+i;
                ch3.setAttribute("type", "text");
                ch3.setAttribute("placeholder", "PQID OP"+i+"");
                ch3.setAttribute("id", tmp3);
                ch3.setAttribute("name", tmp3);
                ch3.required= true;
                panel.appendChild(ch3);

                var ch5 = document.createElement("input");
                ch5.style.width="100px";
                var tmp5='group'+i;
                ch5.setAttribute("type", "text");
                ch5.setAttribute("placeholder", "GROUP"+i+"");
                ch5.setAttribute("id", tmp5);
                ch5.setAttribute("name", tmp5);
                ch5.required= true;
                panel.appendChild(ch5);

                var ch4 = document.createElement("select");
                ch4.style.width="200px";
                var tmp4='flag'+i;
                ch4.setAttribute("id", tmp4);
                ch4.setAttribute("name", tmp4);
                ch4.required= true;
                panel.appendChild(ch4);
                        var option1 = document.createElement("option");
                        option1.value = 0;
                        option1.text = 'Hide Question';
                        ch4.appendChild(option1);
                        var option2 = document.createElement("option");
                        option2.value = 1;
                        option2.text = 'Hide Option';
                        ch4.appendChild(option2);
                        var option3 = document.createElement("option");
                        option3.value = 2;
                        option3.text = 'Show Question';
                        ch4.appendChild(option3);
                        var option4 = document.createElement("option");
                        option4.value = 3;
                        option4.text = 'Show Option';
                        ch4.appendChild(option4);

                ch.appendChild(panel);
           }
	} //end of rt==13 grid qop showhide
        if(rt=='14')
        {
           for (i = 1; i <= a; i++) {
                var panel=document.createElement("div");
                panel.style.width="785px"; panel.style.padding="0px";panel.style.align="left";

                var ch1 = document.createElement("input");
                ch1.style.width="100px";
                var tmp1='consider'+i;
                ch1.setAttribute("type", "text");
                ch1.setAttribute("placeholder", "OP Considration"+i+"");
                ch1.setAttribute("id", tmp1);
                ch1.setAttribute("name", tmp1);
                ch1.required= true;
                panel.appendChild(ch1);

                var ch2 = document.createElement("input");
                ch2.style.width="150px";
                var tmp2='group'+i;
                ch2.setAttribute("type", "text");
                ch2.setAttribute("placeholder", "Group "+i+"");
                ch2.setAttribute("id", tmp2);
                ch2.setAttribute("name", tmp2);
                ch2.required= true;
                panel.appendChild(ch2);
                ch.appendChild(panel);

                var ch3 = document.createElement("select");
                ch3.style.width="200px";
                var tmp3='rank'+i;
                ch3.setAttribute("id", tmp3);
                ch3.setAttribute("name", tmp3);
                ch3.required= true;
                panel.appendChild(ch3);
                        var option1 = document.createElement("option");
                        option1.value = 0;
                        option1.text = 'No';
                        ch3.appendChild(option1);
                        var option2 = document.createElement("option");
                        option2.value = 1;
                        option2.text = 'Yes';
                        ch3.appendChild(option2);


           }
        }


}
function generate() {
        var a = parseInt(document.getElementById("cnt").value);
        var ch = document.getElementById("pqid");
        for (i = 1; i <= a; i++) {
            
            //var input = document.createElement("input");
            //var tmp='op'+i;
            //input.setAttribute("type", "text");
            //input.setAttribute("id", tmp);
            //input.setAttribute("name", tmp);
            //ch.appendChild(input);
                var panel=document.createElement("div");
                panel.style.width=""; panel.style.padding="0px";panel.style.align="left";
                
                
                var ch1 = document.createElement("input");
                ch1.style.width="85px";
                var tmp='stb'+i; var tm=''+i+'';
                ch1.setAttribute("type", "text");
                ch1.setAttribute("value",  tm );
                ch1.setAttribute("id", tmp);
                ch1.setAttribute("name", tmp);
                panel.appendChild(ch1);

                var ch2 = document.createElement("input");
                ch2.style.width="350px";
                var tmp2='tb'+i;
                ch2.setAttribute("type", "text");
                ch2.setAttribute("placeholder", "Text Element "+i+"");
                ch2.setAttribute("id", tmp2);
                ch2.setAttribute("name", tmp2);
                panel.appendChild(ch2);

                var ch3 = document.createElement("select");
                ch3.style.width="150px";
                var tmp3='flag'+i;
                ch3.setAttribute("id", tmp3);
                ch3.setAttribute("name", tmp3);
                panel.appendChild(ch3);

    			var option1 = document.createElement("option");
    			option1.value = 0;
    			option1.text = 'Without Other';
    			ch3.appendChild(option1);
                        var option2 = document.createElement("option");
                        option2.value = 1;
                        option2.text = 'Others- Text';
                        ch3.appendChild(option2);
                        var option3 = document.createElement("option");
                        option3.value = 2;
                        option3.text = 'Others- Number';
                        ch3.appendChild(option3);
                        var option4 = document.createElement("option");
                        option4.value = 3;
                        option4.text = 'Others- Text Multiple box';
                        ch3.appendChild(option4);
                        var option5 = document.createElement("option");
                        option5.value = 4;
                        option5.text = 'Others- Number Multiple Box';
                        ch3.appendChild(option5);

                        var option6 = document.createElement("option");
                        option6.value = 5;
                        option6.text = 'None of Any';
                        ch3.appendChild(option6);

                ch.appendChild(panel);
        }

}
function update(action,item)
{
    var queryString =''; var ms='';

   if(action != "") {
		switch(action) {
			case "project":
                           // console.log("ACTION :: "+action);

                            var pid = document.getElementById('pn').value;
                            var pnn = document.getElementById('pnn').value;
                            var sdt = document.getElementById('sdt').value;
                            var edt = document.getElementById('edt').value;
                            var cn = document.getElementById('cn').value;
                            var v = document.getElementById('v').value;
                            var b = document.getElementById('b').value;
                            var rt = document.getElementById('rt').value;
                            var rp = document.getElementById('rp').value;
                            var ss = document.getElementById('ss').value;
                            var bk = document.getElementById('bk').value;
                            var st = document.getElementById('st').value;

                             queryString = 'pid='+pid+'&pn='+pnn+'&sdt='+sdt+'&edt='+edt+'&cn='+cn+'&v='+v+'&b='+b+'&rt='+rt+'&rp='+rp+'&ss='+ss+'&bk='+bk+'&st='+st;
                             ms='#'+pid;
                             //console.log("QUERY STRING :: "+action);

                             break;
            case "question":
			 	 q1='qid'+item;q2='qno'+item;q3='title'+item;q4='qt'+item;
                            var qid = document.getElementById(q1).value;
                            var qn = document.getElementById(q2).value;
                            var title = document.getElementById(q3).value;
                            var qt = document.getElementById(q4).value;

                           queryString = 'qid='+qid+'&qno='+qn+'&title='+title+'&qt='+qt;
                            //queryString = 'qid='+qid+'qno='+qn+'title='+title+'qt='+qt;
			    ms='#'+qid;
			break;
                        case "questionop":
			 	 q='id'+item;q1='qid'+item;q2='txt'+item;q3='value'+item; q4='term'+item; q5='flag'+item;
                            var qid = document.getElementById(q1).value;
                            var txt = document.getElementById(q2).value;
                            var val = document.getElementById(q3).value;
                            var term = document.getElementById(q4).value;
                            var flag = document.getElementById(q5).value;
                            var id = document.getElementById(q).value;

                            queryString = 'id='+id+'&qid='+qid+'&txt='+txt+'&val='+val+'&term='+term+'&flag='+flag;
                             ms='#'+id;
			break;
                        case "sequence":
			 	q='id'+item; q1='qid'+item;q2='sid'+item;q3='flag'+item;q0='qset'+item;
                            var qid = document.getElementById(q1).value;
                            var sid = document.getElementById(q2).value;
                            var flag= document.getElementById(q3).value;
                            var qset = document.getElementById(q0).value;
                            var id = document.getElementById(q).value;

                            queryString = 'qid='+qid+'&qset='+qset+'&sid='+sid+'&flag='+flag+'&id='+id;
                             ms='#'+id;
			break;
                        case "sequenced":
                                q='id'+item; q1='qid'+item;q2='sid'+item;q3='flag'+item;q0='qset'+item;
                            var qid = document.getElementById(q1).value;
                            var sid = document.getElementById(q2).value;
                            var flag= document.getElementById(q3).value;
                            var qset = document.getElementById(q0).value;
                            var id = document.getElementById(q).value;

                            queryString = 'qid='+qid+'&qset='+qset+'&sid='+sid+'&flag='+flag+'&id='+id;
                             ms='#'+id;
                        break;
                        case "routine":
			 	q0='id'+item; q1='qid'+item;q2='pqid'+item;q3='opval'+item;q4='flow'+item;
                            var qid = document.getElementById(q1).value;
                            var pqid = document.getElementById(q2).value;
                            var opval = document.getElementById(q3).value;
                            var flow = document.getElementById(q4).value;
                            var id = document.getElementById(q0).value;
                            queryString = 'id='+id+'&qid='+qid+'&pqid='+pqid+'&opval='+opval+'&flow='+flow;
                             ms='#'+id;
			break;
                        case "routined":
                                q0='id'+item; q1='qid'+item;q2='pqid'+item;q3='opval'+item;q4='flow'+item;
                            var qid = document.getElementById(q1).value;
                            var pqid = document.getElementById(q2).value;
                            var opval = document.getElementById(q3).value;
                            var flow = document.getElementById(q4).value;
                            var id = document.getElementById(q0).value;
                            queryString = 'id='+id+'&qid='+qid+'&pqid='+pqid+'&opval='+opval+'&flow='+flow;
                             ms='#'+id;
                        break;
                        case "updatesequence": 
			 	 	 q1='qset';q2='ssid';q3='esid';
                            var qset = document.getElementById(q1).value;
                            var ssid = document.getElementById(q2).value;
                            var esid= document.getElementById(q3).value;

                            queryString = 'qset='+qset+'&ssid='+ssid+'&esid='+esid;
                             ms='#msg';
			break;
                        case "pcentre":
			 	 q1='qid'+item;q2='qno'+item;q3='title'+item;q4='qt'+item;
                            var qid = document.getElementById(q1).value;
                            var qn = document.getElementById(q2).value;
                            var title = document.getElementById(q3).value;
                            var qt = document.getElementById(q4).value;

                            queryString = 'qid='+qid+'&qno='+qn+'&title='+title+'&qt='+qt;
                             ms='#'+qid;
			break;
                        case "rule1":
			 	 q1='qid'+item;q2='sn'+item;q3='gc'+item;q4='id'+item;
                            var qid = document.getElementById(q1).value;
                            var sn = document.getElementById(q2).value;
                            var gc = document.getElementById(q3).value;
                            var id = document.getElementById(q4).value;

                            queryString = 'qid='+qid+'&sn='+sn+'&gc='+gc+'&id='+id;
                             ms='#'+id;
			break;
                        case "rule2":
			 	 q1='qid'+item;q2='tab'+item;q3='q'+item;q4='id'+item;q5='op'+item;
                            var qid = document.getElementById(q1).value;
                            var tab = document.getElementById(q2).value;
                            var q = document.getElementById(q3).value;
                            var id = document.getElementById(q4).value;
                            var op = document.getElementById(q5).value;

                            queryString = 'qid='+qid+'&tab='+tab+'&op='+op+'&q='+q+'&id='+id;
                             ms='#'+id;
			break;
                        case "rule3":
			 	 q1='qid'+item; q2='flag'+item; q3='gc'+item; q4='id'+item; qr='rw'+item;
                            var qid = document.getElementById(q1).value;
                            var f = document.getElementById(q2).value;
                            var gc = document.getElementById(q3).value;
                            var id = document.getElementById(q4).value;
			    var r = document.getElementById(qr).value;
                            queryString = 'qid='+qid+'&gc='+gc+'&flag='+f+'&rw='+r+'&id='+id;
                             ms='#'+id;
			break;
                         case "rule1d":
			 	 q1='qid'+item;q2='sn'+item;q3='gc'+item;q4='id'+item;
                            var qid = document.getElementById(q1).value;
                            var sn = document.getElementById(q2).value;
                            var gc = document.getElementById(q3).value;
                            var id = document.getElementById(q4).value;

                            queryString = 'qid='+qid+'&sn='+sn+'&gc='+gc+'&id='+id;
                             ms='#'+id;
			break;
                        case "rule2d":
			 	 q1='qid'+item;q2='tab'+item;q3='q'+item;q4='id'+item;q5='op'+item;
                            var qid = document.getElementById(q1).value;
                            var tab = document.getElementById(q2).value;
                            var q = document.getElementById(q3).value;
                            var id = document.getElementById(q4).value;
                            var op = document.getElementById(q5).value;

                            queryString = 'qid='+qid+'&tab='+tab+'&op='+op+'&q='+q+'&id='+id;
                             ms='#'+id;
			break;
                        case "rule3d":
			 	 q1='qid'+item;q3='gc'+item;q4='id'+item;
                            var qid = document.getElementById(q1).value;
                            var gc = document.getElementById(q3).value;
                            var id = document.getElementById(q4).value;

                            queryString = 'qid='+qid+'&gc='+gc+'&id='+id;
                             ms='#'+id;
			break;
                        case "ruleand":
			 	 q1='qid'+item;q2='flag'+item; q3='gc'+item;q4='id'+item;
                            var qid = document.getElementById(q1).value;
                            var f = document.getElementById(q2).value;
                            var gc = document.getElementById(q3).value;
                            var id = document.getElementById(q4).value;

                            queryString = 'qid='+qid+'&cqid='+gc+'&flag='+f+'&id='+id;
                             ms='#'+id;
			break;
                        case "ruleandd":
			 	 q1='qid'+item;q3='gc'+item;q4='id'+item;
                            var qid = document.getElementById(q1).value;
                            var gc = document.getElementById(q3).value;
                            var id = document.getElementById(q4).value;

                            queryString = 'qid='+qid+'&cqid='+gc+'&id='+id;
                             ms='#'+id;
			break;
                        case "ruleshow":
			 	 q1='qid'+item;q3='gc'+item;q4='id'+item;
                            var qid = document.getElementById(q1).value;
                            var gc = document.getElementById(q3).value;
                            var id = document.getElementById(q4).value;

                            queryString = 'qid='+qid+'&cqid='+gc+'&id='+id;
                             ms='#'+id;
			break;
                        case "ruleshowd":
			 	 q1='qid'+item;q3='gc'+item;q4='id'+item;
                            var qid = document.getElementById(q1).value;
                            var gc = document.getElementById(q3).value;
                            var id = document.getElementById(q4).value;

                            queryString = 'qid='+qid+'&cqid='+gc+'&id='+id;
                             ms='#'+id;
			break;
                        case "rulehide":
			 	 q1='qid'+item;q3='gc'+item;q4='id'+item;
                            var qid = document.getElementById(q1).value;
                            var gc = document.getElementById(q3).value;
                            var id = document.getElementById(q4).value;

                            queryString = 'qid='+qid+'&cqid='+gc+'&id='+id;
                             ms='#'+id;
			break;
                        case "rulehided":
			 	 q1='qid'+item;q3='gc'+item;q4='id'+item;
                            var qid = document.getElementById(q1).value;
                            var gc = document.getElementById(q3).value;
                            var id = document.getElementById(q4).value;

                            queryString = 'qid='+qid+'&cqid='+gc+'&id='+id;
                             ms='#'+id;
			break;
                        case "rulefindreplace":
                                 q1='pqid'+item; q2='cqid'+item; q3='opv'+item; q4='fstr'+item;q5='rstr'+item;  idd='id'+item;
                            var pqid = document.getElementById(q1).value;
                            var cqid = document.getElementById(q2).value;
                            var opv = document.getElementById(q3).value;
                            var fstr = document.getElementById(q4).value
                            var rstr = document.getElementById(q5).value;

                            var id = document.getElementById(idd).value;

                            queryString = 'rqid='+pqid+'&cqid='+cqid+'&opv='+opv+'&fstr='+fstr+'&rstr='+rstr+'&id='+id;
                             ms='#'+id;
                        break;
                        case "rulefindreplaced":
                                 q1='pqid'+item; q2='cqid'+item; q3='opv'+item; q4='fstr'+item;q5='rstr'+item;  idd='id'+item;
                            var pqid = document.getElementById(q1).value;
                            var cqid = document.getElementById(q2).value;
                            var opv = document.getElementById(q3).value;
                            var fstr = document.getElementById(q4).value
                            var rstr = document.getElementById(q5).value;

                            var id = document.getElementById(idd).value;

                            queryString = 'rqid='+pqid+'&cqid='+cqid+'&opv='+opv+'&fstr='+fstr+'&rstr='+rstr+'&id='+id;
                             ms='#'+id;
                        break;
                        case "ruleautoselect":
                                 q1='pqid'+item; q2='cqid'+item; q3='opv'+item; q4='fstr'+item;q5='rstr'+item;  idd='id'+item;
                            var pqid = document.getElementById(q1).value;
                            var cqid = document.getElementById(q2).value;
                            var opv = document.getElementById(q3).value;
                            var fstr = document.getElementById(q4).value
                            var rstr = document.getElementById(q5).value;

                            var id = document.getElementById(idd).value;

                            queryString = 'pqid='+pqid+'&cqid='+cqid+'&opv='+opv+'&fstr='+fstr+'&rstr='+rstr+'&id='+id;
                             ms='#'+id;
                        break;
                        case "ruleautoselectd":
                                 q1='pqid'+item; q2='cqid'+item; q3='opv'+item; q4='fstr'+item;q5='rstr'+item;  idd='id'+item;
                            var pqid = document.getElementById(q1).value;
                            var cqid = document.getElementById(q2).value;
                            var opv = document.getElementById(q3).value;
                            var fstr = document.getElementById(q4).value
                            var rstr = document.getElementById(q5).value;

                            var id = document.getElementById(idd).value;

                            queryString = 'pqid='+pqid+'&cqid='+cqid+'&opv='+opv+'&fstr='+fstr+'&rstr='+rstr+'&id='+id;
                             ms='#'+id;
                        break;

                        case "rulenumlimit":
                                  q2='cqid'+item;q3='opcode'+item; q4='fstr'+item; q5='rstr'+item; idd='id'+item;
                            var cqid = document.getElementById(q2).value;
                            var opv = document.getElementById(q3).value;
                            var fstr = document.getElementById(q4).value
                            var rstr = document.getElementById(q5).value;
                            var id = document.getElementById(idd).value;

                            queryString = 'cqid='+cqid+'&opcode='+opv+'&fstr='+fstr+'&rstr='+rstr+'&id='+id;
                             ms='#'+id;
                        break;
                        case "rulenumlimitd":
                                  q2='cqid'+item; q3='opcode'+item;q4='fstr'+item; q5='rstr'+item; idd='id'+item;
                            var cqid = document.getElementById(q2).value;
                            var opv = document.getElementById(q3).value;
                            var fstr = document.getElementById(q4).value
                            var rstr = document.getElementById(q5).value;
                            var id = document.getElementById(idd).value;

                            queryString = 'cqid='+cqid+'&opcode='+opv+'&fstr='+fstr+'&rstr='+rstr+'&id='+id;
                             ms='#'+id;
                        break;

                        case "ruleqoprange":
                                  q1='cqid'+item;q2='cqopfr'+item; q3='cqopto'+item; q4='pqid'+item; q5='pqop'+item; idd='id'+item;
                            var cqid = document.getElementById(q1).value;
                            var cqopfr = document.getElementById(q2).value;
                            var cqopto = document.getElementById(q3).value;
                            var pqid = document.getElementById(q4).value
                            var pqop = document.getElementById(q5).value;
                            var id = document.getElementById(idd).value;

                            queryString = 'cqid='+cqid+'&cqopfr='+cqopfr+'&cqopto='+cqopto+'&pqid='+pqid+'&pqop='+pqop+'&id='+id;
                             ms='#'+id;
                        break;

                        case "ruleqopranged":
                                  q1='cqid'+item;q2='cqopfr'+item; q3='cqopto'+item; q4='pqid'+item; q5='pqop'+item; idd='id'+item;
                            var cqid = document.getElementById(q1).value;
                            var cqopfr = document.getElementById(q2).value;
                            var cqopto = document.getElementById(q3).value;
                            var pqid = document.getElementById(q4).value
                            var pqop = document.getElementById(q5).value;
                            var id = document.getElementById(idd).value;

                            queryString = 'cqid='+cqid+'&cqopfr='+cqopfr+'&cqopto='+cqopto+'&pqid='+pqid+'&pqop='+pqop+'&id='+id;
                             ms='#'+id;
                        break;


                        case "rulerecording":
                                  q2='qid'+item; idd='id'+item;
                            var cqid = document.getElementById(q2).value;
                            var id = document.getElementById(idd).value;

                            queryString = 'qid='+cqid+'&id='+id;
                             ms='#'+id;
                        break;
                        case "rulerecordingd":
                                  q2='qid'+item; idd='id'+item;
                            var cqid = document.getElementById(q2).value;
                            var id = document.getElementById(idd).value;

                            queryString = 'qid='+cqid+'&id='+id;
                             ms='#'+id;
                        break;
                        case "ruleautofixcode":
                                 q1='cqid'+item; q2='pqid'+item; q3='copv'+item; q4='val'+item; idd='id'+item;
                            var cqid = document.getElementById(q1).value;
                            var pqid = document.getElementById(q2).value;
                            var copv = document.getElementById(q3).value
                            var val = document.getElementById(q4).value;
                            var id = document.getElementById(idd).value;

                            queryString = 'cqid='+cqid+'&pqid='+pqid+'&copv='+copv+'&val='+val+'&id='+id;

                             ms='#'+id;
                        break;
                        case "ruleautofixcoded":
                                 q1='cqid'+item; q2='pqid'+item; q3='copv'+item; q4='val'+item; idd='id'+item;
                            var cqid = document.getElementById(q1).value;
                            var pqid = document.getElementById(q2).value;
                            var copv = document.getElementById(q3).value
                            var val = document.getElementById(q4).value;
                            var id = document.getElementById(idd).value;

                            queryString = 'cqid='+cqid+'&pqid='+pqid+'&copv='+copv+'&val='+val+'&id='+id;
                             ms='#'+id;
                        break;
                        case "rulegridrankc":
                                 q1='group'+item; q2='consider'+item; q3='rank'+item; idd='id'+item;
                            var rank = document.getElementById(q3).value
                            var consd = document.getElementById(q2).value;
                            var grp = document.getElementById(q1).value;
                            var id = document.getElementById(idd).value;
                            queryString = 'group='+grp+'&consider='+consd+'&rank='+rank+'&id='+id;
                             ms='#'+id;
                        break;
                        case "rulegridrankcd":
                                 q1='group'+item; q2='consider'+item; q3='rank'+item; idd='id'+item;
                            var rank = document.getElementById(q3).value
                            var consd = document.getElementById(q2).value;
                            var grp = document.getElementById(q1).value;
                            var id = document.getElementById(idd).value;
                            queryString = 'group='+grp+'&consider='+consd+'&rank='+rank+'&id='+id;
                             ms='#'+id;
                        break;

                        case "rulegridqopshowhide":
                                 q1='cqid'+item; q2='pqid'+item; q3='pqop'+item; q4='flag'+item; q5 = 'group'+item; idd='id'+item;
                            var cqid = document.getElementById(q1).value;
                            var pqid = document.getElementById(q2).value;
                            var pqopv = document.getElementById(q3).value
                            var val = document.getElementById(q4).value;
                            var grp = document.getElementById(q5).value;
                            var id = document.getElementById(idd).value;
                            queryString = 'cqid='+cqid+'&pqid='+pqid+'&pqop='+pqopv+'&group='+grp+'&flag='+val+'&id='+id;
                             ms='#'+id;
                        break;
                        case "rulegridqopshowhided":
                                 q1='cqid'+item; q2='pqid'+item; q3='pqop'+item; q4='flag'+item;q5 = 'group'+item; idd='id'+item;
                            var cqid = document.getElementById(q1).value;
                            var pqid = document.getElementById(q2).value;
                            var pqopv = document.getElementById(q3).value
                            var val = document.getElementById(q4).value;
                            var grp = document.getElementById(q5).value;
                            var id = document.getElementById(idd).value;
                            queryString = 'cqid='+cqid+'&pqid='+pqid+'&pqop='+pqopv+'&group='+grp+'&flag='+val+'&id='+id;
                             ms='#'+id;
                        break;


                        case "rule7e":
                            q1='cqid'+item;q2='rqid'+item;q3='fwd'+item;q4='rwd'+item;q5='op'+item;q6='id'+item;
                            var cqid = document.getElementById(q1).value;
                            var rqid = document.getElementById(q2).value;
                            var fwd = document.getElementById(q3).value;
                            var rwd = document.getElementById(q4).value;
                            var op = document.getElementById(q5).value;
                            var id = document.getElementById(q6).value;

                            queryString = 'cqid='+cqid+'&rqid='+rqid+'&op='+op+'&fwd='+fwd+'&rwd='+rwd+'&id='+id;
                             ms='#'+id;
                        break;
                        case "rule7d":
                            q1='cqid'+item;q2='rqid'+item;q3='fwd'+item;q4='rwd'+item;q5='op'+item;q6='id'+item;
                            var cqid = document.getElementById(q1).value;
                            var rqid = document.getElementById(q2).value;
                            var fwd = document.getElementById(q3).value;
                            var rwd = document.getElementById(q4).value;
                            var op = document.getElementById(q5).value;
                            var id = document.getElementById(q6).value;

                            queryString = 'cqid='+cqid+'&rqid='+rqid+'&op='+op+'&fwd='+fwd+'&rwd='+rwd+'&id='+id;
                             ms='#'+id;
                        break;
                        case "centre":
                            q1='id'+item;q2='pid'+item;q3='c'+item;
                            var id = document.getElementById(q1).value;
                            var pid = document.getElementById(q2).value;
                            var code = document.getElementById(q3).value;
                            // var qt = document.getElementById(q4).value;
                            queryString = 'id='+id+'&project_id='+pid+'&centre_id='+code;
                            ms='#'+id;
                        break;
                        case "store":
                            q1='id'+item;q2='pid'+item;q3='c'+item;q4='s'+item;
                            var id = document.getElementById(q1).value;
                            var pid = document.getElementById(q2).value;
                            var code = document.getElementById(q3).value;
                            var nm = document.getElementById(q4).value;
                            queryString = 'id='+id+'&qset_id='+pid+'&valuee='+code+'&store='+nm;
                            ms='#'+id;
                        break;
                        case "stored":
                            q1='id'+item;q2='pid'+item;q3='c'+item;q4='s'+item;
                            var id = document.getElementById(q1).value;
                            var pid = document.getElementById(q2).value;
                            var code = document.getElementById(q3).value;
                            var nm = document.getElementById(q4).value;
                            queryString = 'id='+id+'&qset_id='+pid+'&valuee='+code+'&store='+nm;
                            ms='#'+id;
                        break;
                        case "product":
                            q1='id'+item;q2='pid'+item;q3='c'+item;q4='s'+item;
                            var id = document.getElementById(q1).value;
                            var pid = document.getElementById(q2).value;
                            var code = document.getElementById(q3).value;
                            var nm = document.getElementById(q4).value;
                            queryString = 'id='+id+'&qset_id='+pid+'&valuee='+code+'&product='+nm;
                            ms='#'+id;
                        break;
                        case "productd":
                            q1='id'+item;q2='pid'+item;q3='c'+item;q4='s'+item;
                            var id = document.getElementById(q1).value;
                            var pid = document.getElementById(q2).value;
                            var code = document.getElementById(q3).value;
                            var nm = document.getElementById(q4).value;
                            queryString = 'id='+id+'&qset_id='+pid+'&valuee='+code+'&product='+nm;
                            ms='#'+id;
                        break;

                        case "sec":
                            q1='id'+item;q2='pid'+item;q3='c'+item;q4='s'+item;
                            var id = document.getElementById(q1).value;
                            var pid = document.getElementById(q2).value;
                            var code = document.getElementById(q3).value;
                            var nm = document.getElementById(q4).value;
                            queryString = 'id='+id+'&qset='+pid+'&valuee='+code+'&sec='+nm;
                            ms='#'+id;
                        break;
                        case "secd":
                            q1='id'+item;q2='pid'+item;q3='c'+item;q4='s'+item;
                            var id = document.getElementById(q1).value;
                            var pid = document.getElementById(q2).value;
                            var code = document.getElementById(q3).value;
                            var nm = document.getElementById(q4).value;
                            queryString = 'id='+id+'&qset='+pid+'&valuee='+code+'&sec='+nm;
                            ms='#'+id;
                        break;

                        case "age":
                            q1='id'+item;q2='pid'+item;q3='c'+item;q4='a'+item;
                            var id = document.getElementById(q1).value;
                            var pid = document.getElementById(q2).value;
                            var code = document.getElementById(q3).value;
                            var nm = document.getElementById(q4).value;
                            queryString = 'id='+id+'&qset='+pid+'&valuee='+code+'&age='+nm;
                            ms='#'+id;
                        break;
                        case "aged":
                            q1='id'+item;q2='pid'+item;q3='c'+item;q4='a'+item;
                            var id = document.getElementById(q1).value;
                            var pid = document.getElementById(q2).value;
                            var code = document.getElementById(q3).value;
                            var nm = document.getElementById(q4).value;
                            queryString = 'id='+id+'&qset='+pid+'&valuee='+code+'&age='+nm;
                            ms='#'+id;
                        break;

                        case "addfp":
                            q1='id'+item;q2='pid'+item;
                            var id = document.getElementById(q1).value;
                            var pid = document.getElementById(q2).value;
                            queryString = 'id='+id+'&qset='+pid;
                            ms='#'+id;
                        break;
                        case "deletefp":
                            q1='id'+item;q2='pid'+item;
                            var id = document.getElementById(q1).value;
                            var pid = document.getElementById(q2).value;
                            queryString = 'id='+id+'&qset='+pid;
                            ms='#'+id;
                        break;

		}
    }
 
// alert('Updating...'+item);
  console.log('ACTION :: SENDING QueryString '+queryString);
  console.log('ACTION :: SENDING Action '+action);

  jQuery.ajax({ 
	 url:'<?php echo base_url("siteadmin/updateproject/"); ?>'+action,
	data:queryString,
	type: "GET",
	success:function(data){

		$(ms).html(data);
        console.log('ACTION :: SENDING Data '+data);
	},
	error:function (er){ $(ms).html(er); 
        console.log('ACTION :: SENDING ERROR '+queryString);
}
	});
}

function cat(action,item)
{     
    var queryString =''; var ms='';  
   if(action != "") {
		switch(action) {			
                        case "catn":
                            var cnn = document.getElementById('catname').value;
                            queryString = 'catname='+cnn;
                             ms='#msg';
			break;
                        case "catv":
                            var cnn = document.getElementById('catname').value;
                            queryString = 'catname='+cnn;
                             ms='#msg';
			break;
		}
    }
  jQuery.ajax({
	 url:'<?php echo base_url("siteadmin/createqbcat/action/"); ?>'+action,
     
	data:queryString,
	type: "GET",
	success:function(data){  
		$(ms).html(data);
	},
	error:function (){}
	});
}
function qcat(action,item)
{     
    var queryString =''; var ms=''; 
   if(action != "") {
		switch(action) {	
                        case "qbycat":
                             var cn = document.getElementById('cat').value;
                             queryString = 'cat='+cn;
                             ms='#qlist';
			break;
                        case "qbykey":
                            var cnn = document.getElementById('skey').value;
                            queryString = 'key='+cnn;
                            ms='#qlist';
			break;
                        case "qbyp":
                            var cnn = document.getElementById('fpn').value;
                            queryString = 'fpn='+cnn;
                            ms='#qlist';
			break;
                        case "qbykeyp":
                            var k = document.getElementById('skey').value; 
                            var fpn = document.getElementById('fpn').value; 
                            queryString = 'key='+k+' &fpn='+fpn;
                            ms='#qlist';
			break;
		}
    }
  jQuery.ajax({
	 url:'<?php echo base_url("siteadmin/copyqbcat/action/"); ?>'+action,     
	data:queryString,
	type: "GET",
	success:function(data){  
		$(ms).html(data);
	},
	error:function (){}
	});
}
</script>
<script>
function showhideqop(id) {
    var x = document.getElementById(id);
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else { 
        x.className = x.className.replace(" w3-show", "");
    }
}
</script>

<script type="text/javascript">
        var specialKeys = new Array();
        specialKeys.push(8); //Backspace
        specialKeys.push(9); //Tab
        specialKeys.push(46); //Delete
        specialKeys.push(36); //Home
        specialKeys.push(35); //End
        specialKeys.push(37); //Left
        specialKeys.push(39); //Right

        function IsAlphaNumber(e) { 
		//alert('New Project');
            var keyCode = e.keyCode == 0 ? e.charCode : e.keyCode;
//            var ret = ((keyCode >= 48 && keyCode <= 57) || (keyCode >= 65 && keyCode <= 90) || (keyCode >= 97 && keyCode <= 122) || 
//(specialKeys.indexOf(e.keyCode) != -1 && e.charCode != e.keyCode));
//            document.getElementById("error").style.display = ret ? "none" : "inline";
//            return ret;
		if((keyCode >= 48 && keyCode <= 57) || (keyCode >= 65 && keyCode <= 90) || (keyCode >= 97 && keyCode <= 122)){
			document.getElementById("error").style.display = "none" ;
			return true;
		}
		else{
			document.getElementById("error").style.display =  "inline";
			return false;
		}
        }
        function IsNotAlphaNumber(e) {
              	var keyCode = e.keyCode == 0 ? e.charCode : e.keyCode;
         	var address = document.getElementById('qtitle').value;
  		if(JSON.parse(address))
  		{
    			alert('One or more illegal characters were found, the first being character ' + ( result.index + 1 ) + ' "' + result +'".\\Please edit your input.');
  		}
        }
</script>

    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>public/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url(); ?>public/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>


    <!-- Theme JavaScript -->
    <script src="<?php echo base_url(); ?>public/js/agency.min.js"></script>
    
<script src="<?php echo base_url(); ?>public/js/sb-admin-2.js"> </script>
<script src="<?php echo base_url(); ?>public/js/sb-admin-2.min.js"> </script>

<!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url(); ?>public/metismenu/metisMenu.min.js"></script>
<!-- check for submit button confirmation -->
<script type="text/javascript">

function validateproject()
{
    var appprotypes = document.getElementById("select_project_types").value;
    if(appprotypes == ''){
        alert('Please select project Types');
        return false;

    }
   
    var projectName = document.getElementById("pname").value;
    if(projectName == ''){
        alert('Please Enter project Name');
        document.getElementById("pname").focus()
        return false;
        
    }
    var brandName = document.getElementById("brand").value;
    if(brandName == ''){
        alert('Please Enter brand name Name');
        document.getElementById("brand").focus()
        return false;

    }
    var surveySize = document.getElementById("ss").value;
    if(surveySize == ''){
        alert('Please Enter survey Size');
        document.getElementById("ss").focus()
        return false;

    }
    var surveySrartdate = document.getElementById("ssdt").value;
    if(surveySrartdate == ''){
        alert('Please Enter Survey Start date');
        document.getElementById("ssdt").focus()
        return false;

    }

    var surveyEndtdate = document.getElementById("esdt").value;
    if(surveyEndtdate == ''){
        alert('Please Enter Survey End date');
        document.getElementById("esdt").focus()
        return false;

    }
    var surveyTypes = document.getElementById("survey_type").value;
    if(surveyTypes == 1){
       
        var surveyTimes = document.getElementById("occurancetimes").value;
        if(surveyTimes == ''){
        alert('Please Enter Survey Times');
        document.getElementById("occurancetimes").focus()
        return false;
        }
    }
    var r=confirm("Do you want to continue this?")
    if (r==true)
      return true;
    else
      return false;


}

function validate()
{
    var r=confirm("Do you want to continue this?")
    if (r==true)
      return true;
    else
      return false;
}

//shothan for document.ready function
$(function() {
	$('#rt').change(function(){
		let rt= $(this).val();
		//console.log('\n rt: '+rt);
		if(rt == 3){
			//console.log('RT in '+rt);
			$('#btn3').css('display','block');
			$('#btn13').css('display','none');
			$('#btn7').css('display','none');
		}
                else if(rt == 13){
                        $('#btn13').css('display','block');
                        $('#btn3').css('display','none');
                        $('#btn7').css('display','none');
                }
                else if(rt == 7){
                        $('#btn7').css('display','block');
                        $('#btn13').css('display','none');
                        $('#btn3').css('display','none');
                }
		else{
			//console.log('else block');
                        $('#btn7').css('display','none');
                        $('#btn13').css('display','none');
                        $('#btn3').css('display','none')
                }
		//console.log('RT is : '+rt)
	});
    //console.log( "ready!" );
});

</script>

<script type="text/javascript">

   function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            alert("Please enter only Numbers.");
            return false;
        }

        return true;
    }
</script>

<style>
.multiselect {
  width: 200px;
}

.selectBox {
  position: relative;
}

.selectBox select {
  width: 100%;
  font-weight: bold;
}

.overSelect {
  position: absolute;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
}

#fp {
  display: none;
  border: 1px #dadada solid;
}

#fp label {
  display: block;
}

#fp label:hover {
  background-color: #1e90ff;
}
</style>


<script type="text/javascript">
    var expanded = false;

function showCheckboxes() {
	  var checkboxes = document.getElementById("fp");
	  if (!expanded) {
	    checkboxes.style.display = "block";
	    expanded = true;
	  } else {
	    checkboxes.style.display = "none";
	    expanded = false;
	  }
}
function surveyType() {
    
	var surveyType = document.getElementById("survey_type").value;
    if(surveyType == 1)
    {   
        $('#survey_times').show(); 
        $('#surve_time').show();
        $('#surve_occurance').show(); 
        $('#survey_occurrence').show();  
        $('#occurance_time').show();  
        $('#restrict_occurance').show(); 


    }
    if(surveyType == 0)
	{
        $('#survey_times').hide(); 
        $('#surve_time').hide();
        $('#surve_occurance').hide(); 
        $('#survey_occurrence').hide(); 
        $('#occurance_time').hide();  
        $('#restrict_occurance').hide(); 

    }
	
	}
	
    

</script>
<script type="text/javascript">

function createProjectTypes()
{
    var apptypeproject = document.getElementById("select_project_types").value;
    

    if(apptypeproject == "servegenix")
    {   
       
        $('#tr_proj_name').show(); 
        $('#tr_brand_name').show();
        $('#tr_client_name').show(); 
        $('#tr_samplesize_name').show();  
        $('#tr_survestartdate').show();  
        $('#tr_rewardpoint_name').show();
        $('#tr_survenddate').show();  
        $('#tr_surveytypes_name').show(); 
        $('#tr_firstpage_info').show();
        $('#tr_research_name').show();
        $('#tr_surveyround_name').hide(); 
        $('#tr_firstpage_info').hide();
        $('#tr_questionversion_name').hide();
        $('#tr_response_types').show(); 
         
    }
    if(apptypeproject == "insightfix")
	{
       
       
        $('#tr_proj_name').show(); 
        $('#tr_brand_name').show();
        $('#tr_client_name').show(); 
        $('#tr_samplesize_name').show();  
        $('#tr_survestartdate').show(); 
        $('#tr_survenddate').show(); 
        $('#tr_questionversion_name').show(); 
        $('#tr_samplesize_name').show(); 
        $('#tr_rewardpoint_name').show(); 
        $('#tr_surveyround_name').show(); 
        $('#tr_firstpage_info').show(); 
        $('#surve_occurance').hide();     
        $('#surve_time').hide(); 
        $('#occurance_time').hide(); 
        $('#restrict_occurance').hide(); 
        $('#tr_surveytypes_name').hide(); 
        $('#tr_response_types').hide(); 


    }

   



}
</script>
	<!-- script to update tab status for a project based on dbl click -->
    <script type="text/javascript">
        function tab_prm_update(id){
            // console.log(type);
            //    console.log("Id =>"+id);
		//$(this).stopPropagation();
                var roleid =  $("#id_"+id).html();
		let vid= '#uid_'+id;
		let vval = $( vid ).val();
		if( vval === undefined ){
                	$("#id_"+id).html(""); 
			var noptions = $("<select id=\"uid_"+id+"\" onfocusout=\"updateVal("+id+")\"><option>Allowed</option><option>Not Allowed</option></select>");
                	$('#id_'+id).html( noptions );
		}
        }
        function updateVal(id ){
	    let vid= '#id_'+id;
	    let vvid='#uid_'+id;
	    let vstr = $( vvid ).val();

		//console.log('vstr: '+vstr);
		$( vvid ).hide();
	    $(vid).text( vstr );
            if(vstr != ""){
                //var role = $('#role_'+id).val();
		//console.log('Role : '+ vstr +' id: '+id);
                $.ajax({
                    type:"post",
                    url:"<?=base_url('/siteadmin/updatetabstatus')?>",
                    data:{'id': id,'status': vstr   },
                    success:function(response){ 
                        console.log("Success response"+response);
                    },
                    	error:function(response){console.log(response);}
                });
                  
            }else{
                console.log("Something going wrong...");
            }
        }
    </script>

        <script>
            $(document).ready(function() {
                // Initialise the table
                // $("#seqtable").tableDnD();
                $("#seqtable").tableDnD({
                    onDragClass: "myDragClass",
                    onDrop: function(table,row){
                            var rows = table.tBodies[0].rows;
                            var newSeqStr = "";
                            for (var i=0; i<rows.length; i++) {
                                if(i == rows.length -1){
                                    newSeqStr += rows[i].id;    
                                }else{
                                    newSeqStr += rows[i].id+",";    
                                }
                            }
                            var newSeqArray = newSeqStr.split(',');
                            var seq = 1;
				console.log(JSON.stringify(newSeqArray) );
                            $.each(newSeqArray,function(index,value){
                                $("#seq_val_"+value).val(seq);
                                seq++;
                            });

                        }
                });
            });
        </script>


<script>
! function($, window, document, undefined) {

    var startEvent = 'touchstart mousedown',
        moveEvent = 'touchmove mousemove',
        endEvent = 'touchend mouseup';

    $(document).ready(function() {
        function parseStyle(css) {
            var objMap = {},
                parts = css.match(/([^;:]+)/g) || [];
            while (parts.length)
                objMap[parts.shift()] = parts.shift().trim();

            return objMap;
        }
        $('table').each(function() {
            if ($(this).data('table') === 'dnd') {

                $(this).tableDnD({
                    onDragStyle: $(this).data('ondragstyle') && parseStyle($(this).data('ondragstyle')) || null,
                    onDropStyle: $(this).data('ondropstyle') && parseStyle($(this).data('ondropstyle')) || null,
                    onDragClass: $(this).data('ondragclass') === undefined && "tDnD_whileDrag" || $(this).data('ondragclass'),
                    onDrop: $(this).data('ondrop') && new Function('table', 'row', $(this).data('ondrop')), // 'return eval("'+$(this).data('ondrop')+'");') || null,
                    onDragStart: $(this).data('ondragstart') && new Function('table', 'row', $(this).data('ondragstart')), // 'return eval("'+$(this).data('ondragstart')+'");') || null,
                    onDragStop: $(this).data('ondragstop') && new Function('table', 'row', $(this).data('ondragstop')),
                    scrollAmount: $(this).data('scrollamount') || 5,
                    sensitivity: $(this).data('sensitivity') || 10,
                    hierarchyLevel: $(this).data('hierarchylevel') || 0,
                    indentArtifact: $(this).data('indentartifact') || '<div class="indent">&nbsp;</div>',
                    autoWidthAdjust: $(this).data('autowidthadjust') || true,
                    autoCleanRelations: $(this).data('autocleanrelations') || true,
                    jsonPretifySeparator: $(this).data('jsonpretifyseparator') || '\t',
                    serializeRegexp: $(this).data('serializeregexp') && new RegExp($(this).data('serializeregexp')) || /[^\-]*$/,
                    serializeParamName: $(this).data('serializeparamname') || false,
                    dragHandle: $(this).data('draghandle') || null
                });
            }


        });
    });

    jQuery.tableDnD = {
        /** Keep hold of the current table being dragged */
        currentTable: null,
        /** Keep hold of the current drag object if any */
        dragObject: null,
        /** The current mouse offset */
        mouseOffset: null,
        /** Remember the old value of X and Y so that we don't do too much processing */
        oldX: 0,
        oldY: 0,

        /** Actually build the structure */
        build: function(options) {
            // Set up the defaults if any

            this.each(function() {
                // This is bound to each matching table, set up the defaults and override with user options
                this.tableDnDConfig = $.extend({
                    onDragStyle: null,
                    onDropStyle: null,
                    // Add in the default class for whileDragging
                    onDragClass: "tDnD_whileDrag",
                    onDrop: null,
                    onDragStart: null,
                    onDragStop: null,
                    scrollAmount: 5,
                    /** Sensitivity setting will throttle the trigger rate for movement detection */
                    sensitivity: 10,
                    /** Hierarchy level to support parent child. 0 switches this functionality off */
                    hierarchyLevel: 0,
                    /** The html artifact to prepend the first cell with as indentation */
                    indentArtifact: '<div class="indent">&nbsp;</div>',
                    /** Automatically adjust width of first cell */
                    autoWidthAdjust: true,
                    /** Automatic clean-up to ensure relationship integrity */
                    autoCleanRelations: true,
                    /** Specify a number (4) as number of spaces or any indent string for JSON.stringify */
                    jsonPretifySeparator: '\t',
                    /** The regular expression to use to trim row IDs */
                    serializeRegexp: /[^\-]*$/,
                    /** If you want to specify another parameter name instead of the table ID */
                    serializeParamName: false,
                    /** If you give the name of a class here, then only Cells with this class will be draggable */
                    dragHandle: null
                }, options || {});

                // Now make the rows draggable
                $.tableDnD.makeDraggable(this);
                // Prepare hierarchy support
                this.tableDnDConfig.hierarchyLevel &&
                    $.tableDnD.makeIndented(this);
            });

            // Don't break the chain
            return this;
        },
        makeIndented: function(table) {
            var config = table.tableDnDConfig,
                rows = table.rows,
                firstCell = $(rows).first().find('td:first')[0],
                indentLevel = 0,
                cellWidth = 0,
                longestCell,
                tableStyle;

            if ($(table).hasClass('indtd'))
                return null;

            tableStyle = $(table).addClass('indtd').attr('style');
            $(table).css({ whiteSpace: "nowrap" });

            for (var w = 0; w < rows.length; w++) {
                if (cellWidth < $(rows[w]).find('td:first').text().length) {
                    cellWidth = $(rows[w]).find('td:first').text().length;
                    longestCell = w;
                }
            }
            $(firstCell).css({ width: 'auto' });
            for (w = 0; w < config.hierarchyLevel; w++)
                $(rows[longestCell]).find('td:first').prepend(config.indentArtifact);
            firstCell && $(firstCell).css({ width: firstCell.offsetWidth });
            tableStyle && $(table).css(tableStyle);

            for (w = 0; w < config.hierarchyLevel; w++)
                $(rows[longestCell]).find('td:first').children(':first').remove();

            config.hierarchyLevel &&
                $(rows).each(function() {
                    indentLevel = $(this).data('level') || 0;
                    indentLevel <= config.hierarchyLevel &&
                        $(this).data('level', indentLevel) ||
                        $(this).data('level', 0);
                    for (var i = 0; i < $(this).data('level'); i++)
                        $(this).find('td:first').prepend(config.indentArtifact);
                });

            return this;
        },
        /** This function makes all the rows on the table draggable apart from those marked as "NoDrag" */
        makeDraggable: function(table) {
            var config = table.tableDnDConfig;

            config.dragHandle
                // We only need to add the event to the specified cells
                &&
                $(config.dragHandle, table).each(function() {
                    // The cell is bound to "this"
                    $(this).bind(startEvent, function(e) {
                        $.tableDnD.initialiseDrag($(this).parents('tr')[0], table, this, e, config);
                        return false;
                    });
                })
                // For backwards compatibility, we add the event to the whole row
                // get all the rows as a wrapped set
                ||
                $(table.rows).each(function() {
                    // Iterate through each row, the row is bound to "this"
                    if (!$(this).hasClass("nodrag")) {
                        $(this).bind(startEvent, function(e) {
                            if (e.target.tagName === "TD") {
                                $.tableDnD.initialiseDrag(this, table, this, e, config);
                                return false;
                            }
                        }).css("cursor", "move"); // Store the tableDnD object
                    } else {
                        $(this).css("cursor", ""); // Remove the cursor if we don't have the nodrag class
                    }
                });
        },
        currentOrder: function() {
            var rows = this.currentTable.rows;
            return $.map(rows, function(val) {
                return ($(val).data('level') + val.id).replace(/\s/g, '');
            }).join('');
        },
        initialiseDrag: function(dragObject, table, target, e, config) {
            this.dragObject = dragObject;
            this.currentTable = table;
            this.mouseOffset = this.getMouseOffset(target, e);
            this.originalOrder = this.currentOrder();

            // Now we need to capture the mouse up and mouse move event
            // We can use bind so that we don't interfere with other event handlers
            $(document)
                .bind(moveEvent, this.mousemove)
                .bind(endEvent, this.mouseup);

            // Call the onDragStart method if there is one
            config.onDragStart &&
                config.onDragStart(table, target);
        },
        updateTables: function() {
            this.each(function() {
                // this is now bound to each matching table
                if (this.tableDnDConfig)
                    $.tableDnD.makeDraggable(this);
            });
        },
        /** Get the mouse coordinates from the event (allowing for browser differences) */
        mouseCoords: function(e) {
            if (e.originalEvent.changedTouches)
                return {
                    x: e.originalEvent.changedTouches[0].clientX,
                    y: e.originalEvent.changedTouches[0].clientY
                };

            if (e.pageX || e.pageY)
                return {
                    x: e.pageX,
                    y: e.pageY
                };

            return {
                x: e.clientX + document.body.scrollLeft - document.body.clientLeft,
                y: e.clientY + document.body.scrollTop - document.body.clientTop
            };
        },
        /** Given a target element and a mouse eent, get the mouse offset from that element.
         To do this we need the element's position and the mouse position */
        getMouseOffset: function(target, e) {
            var mousePos,
                docPos;

            e = e || window.event;

            docPos = this.getPosition(target);
            mousePos = this.mouseCoords(e);

            return {
                x: mousePos.x - docPos.x,
                y: mousePos.y - docPos.y
            };
        },
        /** Get the position of an element by going up the DOM tree and adding up all the offsets */
        getPosition: function(element) {
            var left = 0,
                top = 0;

            // Safari fix -- thanks to Luis Chato for this!
            // Safari 2 doesn't correctly grab the offsetTop of a table row
            // this is detailed here:
            // http://jacob.peargrove.com/blog/2006/technical/table-row-offsettop-bug-in-safari/
            // the solution is likewise noted there, grab the offset of a table cell in the row - the firstChild.
            // note that firefox will return a text node as a first child, so designing a more thorough
            // solution may need to take that into account, for now this seems to work in firefox, safari, ie
            if (element.offsetHeight === 0)
                element = element.firstChild; // a table cell

            while (element.offsetParent) {
                left += element.offsetLeft;
                top += element.offsetTop;
                element = element.offsetParent;
            }

            left += element.offsetLeft;
            top += element.offsetTop;

            return {
                x: left,
                y: top
            };
        },
        autoScroll: function(mousePos) {
            var config = this.currentTable.tableDnDConfig,
                yOffset = window.pageYOffset,
                windowHeight = window.innerHeight ?
                window.innerHeight :
                document.documentElement.clientHeight ?
                document.documentElement.clientHeight :
                document.body.clientHeight;

            // Windows version
            // yOffset=document.body.scrollTop;
            if (document.all)
                if (typeof document.compatMode !== 'undefined' &&
                    document.compatMode !== 'BackCompat')
                    yOffset = document.documentElement.scrollTop;
                else if (typeof document.body !== 'undefined')
                yOffset = document.body.scrollTop;

            mousePos.y - yOffset < config.scrollAmount &&
                window.scrollBy(0, -config.scrollAmount) ||
                windowHeight - (mousePos.y - yOffset) < config.scrollAmount &&
                window.scrollBy(0, config.scrollAmount);

        },
        moveVerticle: function(moving, currentRow) {

            if (0 !== moving.vertical
                // If we're over a row then move the dragged row to there so that the user sees the
                // effect dynamically
                &&
                currentRow &&
                this.dragObject !== currentRow &&
                this.dragObject.parentNode === currentRow.parentNode)
                0 > moving.vertical &&
                this.dragObject.parentNode.insertBefore(this.dragObject, currentRow.nextSibling) ||
                0 < moving.vertical &&
                this.dragObject.parentNode.insertBefore(this.dragObject, currentRow);

        },
        moveHorizontal: function(moving, currentRow) {
            var config = this.currentTable.tableDnDConfig,
                currentLevel;

            if (!config.hierarchyLevel ||
                0 === moving.horizontal
                // We only care if moving left or right on the current row
                ||
                !currentRow ||
                this.dragObject !== currentRow)
                return null;

            currentLevel = $(currentRow).data('level');

            0 < moving.horizontal &&
                currentLevel > 0 &&
                $(currentRow).find('td:first').children(':first').remove() &&
                $(currentRow).data('level', --currentLevel);

            0 > moving.horizontal &&
                currentLevel < config.hierarchyLevel &&
                $(currentRow).prev().data('level') >= currentLevel &&
                $(currentRow).children(':first').prepend(config.indentArtifact) &&
                $(currentRow).data('level', ++currentLevel);

        },
        mousemove: function(e) {
            var dragObj = $($.tableDnD.dragObject),
                config = $.tableDnD.currentTable.tableDnDConfig,
                currentRow,
                mousePos,
                moving,
                x,
                y;

            e && e.preventDefault();

            if (!$.tableDnD.dragObject)
                return false;

            // prevent touch device screen scrolling
            e.type === 'touchmove' &&
                event.preventDefault(); // TODO verify this is event and not really e

            // update the style to show we're dragging
            config.onDragClass &&
                dragObj.addClass(config.onDragClass) ||
                dragObj.css(config.onDragStyle);

            mousePos = $.tableDnD.mouseCoords(e);
            x = mousePos.x - $.tableDnD.mouseOffset.x;
            y = mousePos.y - $.tableDnD.mouseOffset.y;

            // auto scroll the window
            $.tableDnD.autoScroll(mousePos);

            currentRow = $.tableDnD.findDropTargetRow(dragObj, y);
            moving = $.tableDnD.findDragDirection(x, y);

            $.tableDnD.moveVerticle(moving, currentRow);
            $.tableDnD.moveHorizontal(moving, currentRow);

            return false;
        },
        findDragDirection: function(x, y) {
            var sensitivity = this.currentTable.tableDnDConfig.sensitivity,
                oldX = this.oldX,
                oldY = this.oldY,
                xMin = oldX - sensitivity,
                xMax = oldX + sensitivity,
                yMin = oldY - sensitivity,
                yMax = oldY + sensitivity,
                moving = {
                    horizontal: x >= xMin && x <= xMax ? 0 : x > oldX ? -1 : 1,
                    vertical: y >= yMin && y <= yMax ? 0 : y > oldY ? -1 : 1
                };

            // update the old value
            if (moving.horizontal !== 0)
                this.oldX = x;
            if (moving.vertical !== 0)
                this.oldY = y;

            return moving;
        },
        /** We're only worried about the y position really, because we can only move rows up and down */
        findDropTargetRow: function(draggedRow, y) {
            var rowHeight = 0,
                rows = this.currentTable.rows,
                config = this.currentTable.tableDnDConfig,
                rowY = 0,
                row = null;

            for (var i = 0; i < rows.length; i++) {
                row = rows[i];
                rowY = this.getPosition(row).y;
                rowHeight = parseInt(row.offsetHeight) / 2;
                if (row.offsetHeight === 0) {
                    rowY = this.getPosition(row.firstChild).y;
                    rowHeight = parseInt(row.firstChild.offsetHeight) / 2;
                }
                // Because we always have to insert before, we need to offset the height a bit
                if (y > (rowY - rowHeight) && y < (rowY + rowHeight))
                // that's the row we're over
                // If it's the same as the current row, ignore it
                    if (draggedRow.is(row) ||
                        (config.onAllowDrop &&
                            !config.onAllowDrop(draggedRow, row))
                        // If a row has nodrop class, then don't allow dropping (inspired by John Tarr and Famic)
                        ||
                        $(row).hasClass("nodrop"))
                        return null;
                    else
                        return row;
            }
            return null;
        },
        processMouseup: function() {
            if (!this.currentTable || !this.dragObject)
                return null;

            var config = this.currentTable.tableDnDConfig,
                droppedRow = this.dragObject,
                parentLevel = 0,
                myLevel = 0;

            // Unbind the event handlers
            $(document)
                .unbind(moveEvent, this.mousemove)
                .unbind(endEvent, this.mouseup);

            config.hierarchyLevel &&
                config.autoCleanRelations &&
                $(this.currentTable.rows).first().find('td:first').children().each(function() {
                    myLevel = $(this).parents('tr:first').data('level');
                    myLevel
                        &&
                        $(this).parents('tr:first').data('level', --myLevel) &&
                        $(this).remove();
                }) &&
                config.hierarchyLevel > 1 &&
                $(this.currentTable.rows).each(function() {
                    myLevel = $(this).data('level');
                    if (myLevel > 1) {
                        parentLevel = $(this).prev().data('level');
                        while (myLevel > parentLevel + 1) {
                            $(this).find('td:first').children(':first').remove();
                            $(this).data('level', --myLevel);
                        }
                    }
                });

            // If we have a dragObject, then we need to release it,
            // The row will already have been moved to the right place so we just reset stuff
            config.onDragClass &&
                $(droppedRow).removeClass(config.onDragClass) ||
                $(droppedRow).css(config.onDropStyle);

            this.dragObject = null;
            // Call the onDrop method if there is one
            config.onDrop &&
                this.originalOrder !== this.currentOrder() &&
                $(droppedRow).hide().fadeIn('fast') &&
                config.onDrop(this.currentTable, droppedRow);

            // Call the onDragStop method if there is one
            config.onDragStop &&
                config.onDragStop(this.currentTable, droppedRow);

            this.currentTable = null; // let go of the table too
        },
        mouseup: function(e) {
            e && e.preventDefault();
            $.tableDnD.processMouseup();
            return false;
        },
        jsonize: function(pretify) {
            var table = this.currentTable;
            if (pretify)
                return JSON.stringify(
                    this.tableData(table),
                    null,
                    table.tableDnDConfig.jsonPretifySeparator
                );
            return JSON.stringify(this.tableData(table));
        },
        serialize: function() {
            return $.param(this.tableData(this.currentTable));
        },
        serializeTable: function(table) {
            var result = "";
            var paramName = table.tableDnDConfig.serializeParamName || table.id;
            var rows = table.rows;
            for (var i = 0; i < rows.length; i++) {
                if (result.length > 0) result += "&";
                var rowId = rows[i].id;
                if (rowId && table.tableDnDConfig && table.tableDnDConfig.serializeRegexp) {
                    rowId = rowId.match(table.tableDnDConfig.serializeRegexp)[0];
                    result += paramName + '[]=' + rowId;
                }
            }
            return result;
        },
        serializeTables: function() {
            var result = [];
            $('table').each(function() {
                this.id && result.push($.param($.tableDnD.tableData(this)));
            });
            return result.join('&');
        },
        tableData: function(table) {
            var config = table.tableDnDConfig,
                previousIDs = [],
                currentLevel = 0,
                indentLevel = 0,
                rowID = null,
                data = {},
                getSerializeRegexp,
                paramName,
                currentID,
                rows;

            if (!table)
                table = this.currentTable;
            if (!table || !table.rows || !table.rows.length)
                return { error: { code: 500, message: "Not a valid table." } };
            if (!table.id && !config.serializeParamName)
                return { error: { code: 500, message: "No serializable unique id provided." } };

            rows = config.autoCleanRelations &&
                table.rows ||
                $.makeArray(table.rows);
            paramName = config.serializeParamName || table.id;
            currentID = paramName;

            getSerializeRegexp = function(rowId) {
                if (rowId && config && config.serializeRegexp)
                    return rowId.match(config.serializeRegexp)[0];
                return rowId;
            };

            data[currentID] = [];
            !config.autoCleanRelations &&
                $(rows[0]).data('level') &&
                rows.unshift({ id: 'undefined' });



            for (var i = 0; i < rows.length; i++) {
                if (config.hierarchyLevel) {
                    indentLevel = $(rows[i]).data('level') || 0;
                    if (indentLevel === 0) {
                        currentID = paramName;
                        previousIDs = [];
                    } else if (indentLevel > currentLevel) {
                        previousIDs.push([currentID, currentLevel]);
                        currentID = getSerializeRegexp(rows[i - 1].id);
                    } else if (indentLevel < currentLevel) {
                        for (var h = 0; h < previousIDs.length; h++) {
                            if (previousIDs[h][1] === indentLevel)
                                currentID = previousIDs[h][0];
                            if (previousIDs[h][1] >= currentLevel)
                                previousIDs[h][1] = 0;
                        }
                    }
                    currentLevel = indentLevel;

                    if (!$.isArray(data[currentID]))
                        data[currentID] = [];
                    rowID = getSerializeRegexp(rows[i].id);
                    rowID && data[currentID].push(rowID);
                } else {
                    rowID = getSerializeRegexp(rows[i].id);
                    rowID && data[currentID].push(rowID);
                }
            }
            return data;
        }
    };

    jQuery.fn.extend({
        tableDnD: $.tableDnD.build,
        tableDnDUpdate: $.tableDnD.updateTables,
        tableDnDSerialize: $.proxy($.tableDnD.serialize, $.tableDnD),
        tableDnDSerializeAll: $.tableDnD.serializeTables,
        tableDnDData: $.proxy($.tableDnD.tableData, $.tableDnD)
    });

}(jQuery, window, window.document);
</script>


<body id="page-top" class="index">
<div id="main" style="">
  <div id="header">
    <!-- Navigation -->
    <nav id="mainNav" class="navbar navbar-default navbar-custom navbar-fixed-top" style="background:white;">
	<div style="margin-left: 20px;float:left;position: relative;width:75px;">
		<img src="<?php echo base_url(); ?>public/img/logos/quantum-logo-big.png" height=80px width=80px/>
	</div>
    </nav>
   </div>
</div>

