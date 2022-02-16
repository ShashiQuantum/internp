<?php
include_once('../init.php');


if(!Session::exists('suser'))
{
	Redirect::to('login_fp.php');
}
Redirect::to('login_fp.php');

?>


            

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>VCIMS Admin Panel</title>
     <link rel="stylesheet" href="../../css/siteadmin.css">
    </head>
    <body id=pg>
    <div id=header>
    <?php
    	//include_once('../init.php');
        if(isset($_POST['logout']))
         {
            session_destroy();
		//Cookie::delete($this->_cookieName);
		
		Redirect::to('login_fp.php');
            
         }
         echo "Hi <font color='lightgreen'>".Session::get('suser')."</font>"; 
        ?>

                            <form action="" method=post><input type=submit name=logout value=Logout><div style=float:right><img src='../../images/Digiadmin_logo.jpg' height=50 width=150> </div> <center><h3><font color=red >DigiadminCIMS Admin Panel</font></h3></center>
    </div>
    <br><br>
    <center>
        
  
            <table border="0" cellpadding="0" cellspacing="0">
            
            <tr bgcolor=gray height=30><th >S.N.</th><th width=40%>Report Title</th><th>Remarks</th> </tr>
            <tr height=30 bgcolor=lightgray><td>1</td><td><a href="../QuestAdmin/questionnaire_admin.php" target="_blank">Online Questionnaire Admin Panel</a> </td><td>To create online questionnaire</td> </tr>
            <tr height=30><td>2</td><td><a href="crosstab_tool.php" target="_blank"> View Project Crosstab Report </a> </td><td>To view the cross tab report of projects</td> </tr>
          
            <tr height=30 bgcolor=lightgray><td>3</td><td><a href="../QuestAdmin/ques_sys.php" target="_blank">Add/Routine Questionnare</a> </td><td>To add New Question, QuestionSet,Project, and Routine</td></tr>
          
            <tr height=30><td>4</td><td><a href="../adminpanel/modify_quest.php" target="_blank">View/Edit Question</a> </td><td>To update existing question, options, translated question & options</td></tr>
            <tr height=30 bgcolor=lightgray><td>5</td><td><a href="question_trans.php" target="_blank">Add Questionnare Translation</a> </td><td>To add Translated Question and its options</td></tr>
            <tr height=30><td>6</td><td><a href="mail_survey_tool.php" target="_blank">Mail Link to Survey Respondent</a> </td><td>Send link to each respondentin bulk as unique/common URL</td> </tr>            
            <tr height=30 bgcolor=lightgray><td>7</td><td><a href="bulk_mail.php" target="_blank">Bulk Simple Mail Send</a> </td><td>Send bulk general mail in a single or bulk</td> </tr>
            <tr height=30 ><td>8</td><td><a href="project_details.php" target="_blank">Project Details</a> </td><td>Project details and status</td> </tr>
            <tr height=30 bgcolor=lightgray><td>9</td><td><a href="client.php" target="_blank">Client User </a> </td><td>Create/View  all user</td> </tr>
            <tr height=30 ><td>10</td><td><a target='_blank' href="../QuestAdmin/dictionary_map.php" target="_blank">Dictionary & Project Term Mapping</a> </td><td>Dictionary & Project Term Mapping</td> </tr>
            <tr height=30 bgcolor=lightgray><td>11</td><td><a target='_blank' href="rfid_installed_report.php">RFID Report</a> </td><td>RFID Report</td> </tr>  
            <tr height=30><td>12</td><td><a target='_blank' href="rfid_entry.php" target="_blank">RFID Tag Entry</a> </td><td>RFID Tag Entry</td> </tr> 
            <tr height=30 bgcolor=lightgray><td>13</td><td><a target='_blank' href="rfid_tag_upload.php">RFID Tag File Upload</a> </td><td>RFID Tag File Upload</td> </tr>
            <tr height=30><td>14</td><td><a target='_blank' href="tablet.php">Tablet Management</a> </td><td> Tablet Management </td> </tr>
            <tr height=30 bgcolor=lightgray><td>15</td><td><a target='_blank' href="md_dashboard.php">Mother Dairy Dashboard Report</a> </td><td> Mother Dairy Dashboard Report </td> </tr>
            <tr height=30><td>16</td><td><a target='_blank' href="md_dsr.php">Daily Mother Dairy Audit Report</a> </td><td> Mother Dairy Dashboard Report </td> </tr>
            <tr height=30 bgcolor=lightgray><td>17</td><td><a target='_blank' href="md_attribute2.php">Mother Dairy Umeed Booth Score</a> </td><td>Mother Dairy Umeed Score Details- Aug onwards</td> </tr> 
            <tr height=30><td>18</td><td><a target='_blank' href="survey_data_details.php">ONLINE SURVEY RAW DATA</a> </td><td> Online survey raw data details filled by respondent </td> </tr> 
            <tr height=30 bgcolor=lightgray><td>19</td><td><a target='_blank' href="pdata.php">Online Project Data [Single Code]</a> </td><td>Online respondent wise data of single code only questions</td> </tr>
            <tr height=30 bgcolor=lightgray><td>20</td><td><a target='_blank' href="pdatam.php">Online Project Data [Single Code & Multicode]</a> </td><td>Online respondent wise both Multicode & single code only questions</td> </tr>
             <tr height=30><td>21</td><td><a target='_blank' href="umeed_score.php">Umeed Booth wise Monthly Score</a> </td><td>Umeed Booth wise Monthly Score</td> </tr>
             <tr height=30 bgcolor=lightgray><td>22</td><td><a target='_blank' href="project_duplicate_data_remove.php">Duplicate Project Data Remove</a> </td><td>To remove the duplicated data of any projects</td> </tr>
             <tr height=30 ><td>23</td><td><a target='_blank' href="../adminpanel/mangopinion/resp_home.php">QTap Panel</a> </td><td>QTap PATAYA Admin Panel</td> </tr>
             <tr height=30 ><td>24</td><td><a target='_blank' href="../adminpanel/request_panel.php">Order Panel</a> </td><td>Order Request Panel</td> </tr>
             
            </table></center><br><br><br>
            </body>
</html>
