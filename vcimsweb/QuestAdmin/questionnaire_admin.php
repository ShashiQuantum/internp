<head>
<title>Questionnair Admin </title>
</head>
<body bgcolor=silver>
<center>
<br><h2>New Questionnaire Admin Panel</h2>
</center>
<br><br>
<font size=5>
 <a href="../uploads/pdf/QuestAdminProcessFlow.pdf" target="_blank">Process Guid</a>
<dl id="menu">
  <dt onclick="javascript:montre('smenu1');">Create Questionnaire</dt>
   <dd id="smenu1" onclick="javascript:montre('smenu1');" onclick="javascript:montre();">
   <ul>
    <li>1.1 <a href="add_project.php" target="_blank">Create Project</a></li>
    <li>1.2 <a href="add_project_qset.php" target="_blank">Create QuestionSet</a></li>
    <li>1.3 <a href="add_project_centre.php" target="_blank">Add Project Centre</a></li>
    <li>1.4 <a href="add_project_question.php" target="_blank">Create New Question</a></li>
    <li>1.5 <a href="add_project_sequence.php" target="_blank">Add Question Sequence</a></li>
    <li>1.6 <a href="add_routine.php" target="_blank">Add Routine</a></li>
    <li>1.7 <a href="../adminpanel/question_trans.php?st=101" target="_blank">Add Translated Questions</a></li>
    <li>1.8 <a href="../adminpanel/question_trans.php?st=102" target="_blank">Add Translated Question's Options</a></li>
    <li>1.9 <a href="add_project_crosstab.php" target="_blank">Add Project CrossTab</a></li>
    <li>1.10 <a href="project_questions_copy.php" target="_blank">Copy Project's All Questions</a></li>
    <li>1.11 <a href="add_project_product.php" target="_blank">Map Project's Age, SEC, Store, Product</a></li>
   </ul>
  </dd><br>
  <dt onclick="javascript:montre('smenu2');" > View Questionnaire</dt>
  <dd id="smenu2" onclick="javascript:montre('smenu2');" onclick="javascript:montre();">
   <ul>
    <li>2.1 <a href="view_question.php" target="_blank">Veiw Project's Question</a></li>
    <li>2.2 <a href="view_question_option.php" target="_blank">View Question's Option</a></li> 
    <li>2.3 <a href="view_sequence.php" target="_blank">View Project Sequence Details</a></li> 
    <li>2.4 <a href="view_routine.php" target="_blank">View Project Routine</a></li> 
   </ul>
  </dd><br>
  <dt onmouseover="javascript:montre('smenu3');" > Edit Questionnaire</dt>
  <dd id="smenu3" onmouseover="javascript:montre('smenu3');" onmouseout="javascript:montre();">
   <ul>
    <li>3.1 <a href="add_question_sequence.php" target="_blank">Add Question in Sequence</a></li>
    <li>3.2 <a href="edit_question_sequence.php" target="_blank">Edit Project's Question Sequence</a></li>
    <li>3.3 <a href="edit_question_routine.php" target="_blank">Edit Project Routine Details</a></li> 
    <li>3.4 <a href="edit_question.php" target="_blank">Edit Question</a></li> 
    <li>3.5 <a href="edit_question_option.php" target="_blank">Edit Question's Option</a></li> 
    <li>3.6 <a href="../adminpanel/modify_quest.php?st=103" target="_blank">Edit Translated Questions</a></li> 
    <li>3.7 <a href="../adminpanel/modify_quest.php?st=104" target="_blank">Edit Translated Question's Options</a></li> 
   </ul>
  </dd>
  <dt onmouseover="javascript:montre('smenu4');" > Delete Action</dt>
  <dd id="smenu4" onmouseover="javascript:montre('smenu4');" onmouseout="javascript:montre();">
   <ul>
    <li>4.1 <a href="delete_question_sequence.php" target="_blank">Delete Project Sequence</a></li>
    <li>4.2 <a href="delete_question_routine.php" target="_blank">Delete Project Routine</a></li>
    
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