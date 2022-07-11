<?php

include_once('../../init.php');
include_once('../../functions.php');
?>
<head>
<title>Serveygenics | Admin</title>
</head>
<body bgcolor=lightgray>
<center>
<br><h2>Seveygenics Admin Panel</h2>
</center>
<br><br>
<font size=5>
 
<a href="../../uploads/pdf/mppflow.pdf" target="_blank">Serveygenics Process Guide</a>
<dl id="menu">
  <dt onclick="javascript:montre('smenu1');">Respondent Filter</dt>
   <dd id="smenu1" onclick="javascript:montre('smenu1');" onclick="javascript:montre();">
   <ul>
    <li><a href="registeredResp_count.php" target="_blank">View Registerd Respondents List</a></li>
	<li><a href="resp_count.php" target="_blank">View Survey Respondents List</a></li>
    <li><a href="respondent_filter.php" target="_blank">Survey Deploy Request</a></li>
    <li><a href="resp_project_undo.php" target="_blank">Cancel Survey Deployed Request</a></li>
    <li><a href="resp_dep_status.php" target="_blank">View Project Survey Status</a></li>
   </ul>
  </dd><br>
  <dt onclick="javascript:montre('smenu2');" > Reward Points</dt>
  <dd id="smenu2" onclick="javascript:montre('smenu2');" onclick="javascript:montre();">
   <ul>
    <li><a href="credit_store.php" target="_blank">View Credit Store/Redeem Detail</a></li>
    <li><a href="add_credit_store.php" target="_blank">Add/Deduct Reward Points</a></li> 
   </ul>
  </dd><br>
  <dt onclick="javascript:montre('smenu3');" > App User</dt>
  <dd id="smenu3" onclick="javascript:montre('smenu3');" onclick="javascript:montre();">
   <ul>
   <!-- <li><a href="app_approve.php" target="_blank">User Approval</a></li> -->
    <li><a href="notify_filter.php" target="_blank">Send User Notification</a></li>
    <li><a href="referral_centre_report.php" target="_blank">Centre wise Referral code List</a></li>
    <li><a href="referral_user.php" target="_blank">Registered Respondent List using Referral code</a></li>
    <li><a href="gen_ireferral.php" target="_blank">Interviewer Code Generate/View</a></li>
    <li><a href="view_ref_summary.php" target="_blank">Summary Report Referral User</a></li> 
   </ul>
  </dd>

  
</dl>
</font>
</body>
<script>
dl, dt, dd, ul, li {
margin: 0;
padding: 0;
list-style-type: none;
}
#menu {
position: absolute;
top: 1em;
left: 1em;
width: 10em;
}

#menu dt {
cursor: pointer;
background: #A9BFCB;
height: 20px;
line-height: 20px;
margin: 2px 0;
border: 1px solid gray;
text-align: center;
font-weight: bold;
}

#menu dd {
position: absolute;
z-index: 100;
left: 8em;
margin-top: -1.4em;
width: 10em;
background: #A9BFCB;
border: 1px solid gray;
}

#menu ul {
padding: 2px;
}
#menu li {
text-align: center;
font-size: 85%;
height: 18px;
line-height: 18px;
}
#menu li a, #menu dt a {
color: #000;
text-decoration: none;
display: block;
}

#menu li a:hover {
text-decoration: underline;
}

#mentions {
font-family: verdana, arial, sans-serif;
position: absolute;
bottom : 200px;
left : 10px;
color: #000;
background-color: #ddd;
}
#mentions a {text-decoration: none;
color: #222;
}
#mentions a:hover{text-decoration: underline;
}
</script>

<script type="text/javascript">
<!--
window.onload=montre;
function montre(id) {
var d = document.getElementById(id);
for (var i = 1; i<=10; i++) {
if (document.getElementById('smenu'+i)) {document.getElementById('smenu'+i).style.display='none';}
}
if (d) {d.style.display='block';}
}
//-->
</script>
