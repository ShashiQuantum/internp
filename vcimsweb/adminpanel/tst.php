<?php
include_once('../init.php');
include_once('../functions.php');

if(!Session::exists('suser'))
{
	//Redirect::to('login_fp.php');
       die('<font color=red>Please close this page and relogin again</font>');
}

$pid = $_GET['inv'];
//echo "<option name='$a'> $a </option>";

$data= get_project_term($pid);

            echo "<details> <summary><font color=green><b>Cross Tab</b></font></summary>";
                
            echo "<table  id='table1' border='1' cellpadding='0' cellspacing='0' style='margin-left:45px'>";
           echo "<tr bgcolor='lightgray'><th><font color=blue><b>Question List</b></font></th><th width='10%'><font color=green><b>X-Axis</b></font></th><th width='15%'><font color=red><b>Y-Axis</b></font></th></tr>";
           $str1='';$str2='';$nctr=0;

             //$data=DB::getInstance()->query("SELECT distinct title,term FROM `dictionary` where term in (select term from project_term_map where project_id=$pid and client_usr_perm=1 )");
            if($data) 
            foreach($data as $dd)
            {  
                    $nctr++;
                    $tt=$dd->title;
                    $term=$dd->term;
                    $tx=$term.'x';  
                    $ty=$term.'y';
                    $nx=$term.'x';
                    if (!empty($_POST[$tx]))
                    {
                        $str1="checked='checked'";
                    }   
                    if (!empty($_POST[$ty]))
                    { 
                        $str2="checked='checked'";
                    }
                    //name='$tx';
                  // echo " <tr><td>$tt</td> <td><input type='radio' class='xa' value='$term' id='xa' OnClick='javascript:enableTextBoxx();' name='xa' $str1></td> <td><input type='radio' OnClick='javascript:enableTextBoxy();' name='ya' class='ya' value='$term' $str2></td></tr>";
                    
                    if($nctr%2==0)
                    {
                      echo "<tr bgcolor='lightgray'><td>$tt</td> <td><input type='radio' class='xa' value='$term' id='xa' OnClick='javascript:enableTextBoxx();' name='xa' $str1></td> <td width='15%'><input type='checkbox' OnClick='javascript:enableTextBoxy();' name='$term' id='$term' class='ya' value='$term' $str2></td></tr>";
                    }
                    else
                    {
                       echo "<tr><td>$tt</td> <td><input type='radio' class='xa' value='$term' id='xa' OnClick='javascript:enableTextBoxx();' name='xa' $str1></td> <td width='15%'><input type='checkbox' OnClick='javascript:enableTextBoxy();' name='$term' id='$term' class='ya' value='$term' $str2></td></tr>";
                    }

            }    
            echo "</table></details>";


$nctr=0;
echo "</details><details><summary><font color=green><b>Filters</b></font></summary>";
               if($data) 
                   foreach($data as $d)
                   {     $nctr++;
                         $term=$d->term;
                       $t= $d->title;
                       if($nctr%2==0)
                       {
                echo "<details style='margin-left:25px'> <summary><font color=blue> $t </font> </summary> <p style='margin-left:25px'>";
                       }
                       else
                       { echo "<details style='margin-left:25px'> <summary> $t </summary> <p style='margin-left:25px'>"; }


                $ptt=get_dictionary($term,$pid); 
                if($ptt) 
                  foreach($ptt as $p)
                      { $k=$p->keyy;$v=$term.'='.$p->value;$str='';
                              if (!empty($_POST[$k]))
                                  { $str=" checked='checked'";}

                            echo "<input type='checkbox' class='fa' OnClick='javascript:enableTextBoxf();' name='$k' value='$v'>$k";
                        
                      }
                 echo "</details>";
                 }
                
                echo "</details>";
                
                

                
                ?>




