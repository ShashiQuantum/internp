<?php
include_once 'DBConnector.php';
include_once __DIR__.'/model/Question.php';
include_once __DIR__.'/model/Option.php';
include_once __DIR__.'/model/Question.php';
include_once __DIR__.'/model/SurveyQueryManager.php';

$resp_id=0;$qset=22;
/*
//=======================================================================================================================
//to get question details

  $qobj=new Question();

  $qobj=_getQuestion(1485);


  //print_r($qobj);

   $dd=$qobj->get_qid();
   echo $dd;
   echo $qobj->get_qtitle();
   echo "<br>";

//-------to get options details
  $oobj=new Option();
  $oobj=_getOption(1485);
  // print_r($oobj); 

  for($i=0;$i<count($oobj);$i++)
  {
     $opt=$oobj[$i]->get_optextvalue();
     $ov=$oobj[$i]->get_value();
     $trm=$oobj[$i]->get_term();

     echo "<br> $opt - $ov - $trm";
  }

  echo "<br> ";
//to get routine etails
   $robj=new Routine();
   $oval="1,4";
   $robj=_getRoutine(1485,30,$oval);
   //print_r($robj); 
  
   for($i=0;$i<count($robj);$i++)
  {
     $nq=$robj[$i]->get_nextqid();
     
     echo "<br> next_qid= $nq";
  }
  
//============================================================================================
*/
 //Survey code here 
 
      echo "<div id=header>";
      echo "<div style=float:right><img src='../../images/Digiadmin_logo.jpg' height=30 width=130> </div>";
                            
                            
 
 	if(isset($_POST['save']))
        {
               
                 
        
        }
        
            //save/update the selected options value by calling a save function
                  //=================================================================
                       // save($_POST);
                 
                 //find the  next_qid from routine
                 //==================================================================      
                     
                 
                 //display the question details
                 //==================================================================
                 echo "<form action='' method='post'>";       
                 
                       echo "<table><tr><td width=4%></td><td colspan=2><font color=blue>  qno  eng_qtitle </font><font color=red><span id='error'></span></font></td></tr>";     


                 //display the option details
                 //=================================================================
                            
                            
        
             //to display footer options
             //=================================================================           
                        echo "<br><div id=footer>";
			
 			echo "<tr><td width=4%></td><td colspan=2><a href='https://www.digiadmin.quantumcs.com/vcims/websurvey.php?qset=$qset&next=2&rsp=$resp_id'><input type='button' name='prev' value='Previous'    style=background-color:#004c00;color:white;height:35px;></a></td>";

			echo "<td><a href='https://www.digiadmin.quantumcs.com/vcims/websurvey.php?qset= $qset&next=1&rsp=$resp_id'> <input type='submit' name='save' value='Save & Next' onclick='return Validate();' style='background-color:#004c00;color:white;height:35px;position:absolute; left:50%;'></a> </td></tr></center> ";
                                
                         echo "<br><br><br>";
   echo "</div>";
   
                         echo "</form>";
                         
                         
    
    

?>
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
   <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
   <script>
            var arr1 = [];
            var temp = '';
            $(".xa").click(function () {
                 if(this.checked)
                 {     //alert(this.type);
                     if(this.type=='checkbox')
                     arr1.push($(this).val());
                     else temp=$(this).val();
                 }
                 else 
                 {if(this.type=='checkbox')arr1.splice($.inArray($(this).val(), arr1),1); else $(this).val();}
            if(this.type=='checkbox')
            $("#temp").val(arr1.join(","));
            //alert(temp);
            else if(this.type=='radio'){$("#temp").val(temp); }
            displib();
            });
            //$("#temp").change(function () { alert("Hi value change"); });
            $("#temp").change(function() { 
                alert('Demo: '+$(this).val());  
            }); 
    </script>

    

    <script type="text/javascript">
        $(function(){
           $("#temp").on('change', function(){

                        alert('Ajax Error !');

           }); 
        });
    </script>
    <style>
    table {
        border-collapse: collapse;
    }

    
    </style>

    <!-- Script by hscripts.com -->
    <script type="text/javascript">
    window.history.forward(1);
    function noBack(){
    window.history.forward();
    }
    </script>
    <!-- Script by hscripts.com -->

    <script>
        var a=0; var b=1; var c=0;
      $(document).ready(function() {
          
           $('#rank1').click(function() {
               if($(this).val()=='others') $('#other1').show();
               else $('#other1').hide();
           });
           $('#rank2').click(function() {
               if($(this).val()=='others') $('#other2').show();
               else $('#other2').hide();
           });
           $('#rank3').click(function() {
               if($(this).val()=='others') $('#other3').show();
               else $('#other3').hide();
           });
           $('#tp').change(function() {
               a=$(this).val();b=$("#ps").val();
               c=a*b;
               $("#tw").val(c);
               //alert("Hi"+c);    
           });
           $('#ps').change(function() {
               b=$(this).val();a=$("#tp").val();
               c=a*b;
               $("#tw").val(c);
               //alert("Hi"+c);.big{ width: 20em; height: 20em; }
           });
    });
    </script>
<style>
.big{ width: 2em; height: 2em; }

    body {
    font-family: 'Source Sans Pro', sans-serif;
    margin: 0;
    padding: 0;
    text-align: justify;
    text-justify: inter-word;
    text-decoration: none;
    font-size: 150%;
    background-color: #F9FCF8; 
    margin-top: 95px;
    margin-bottom: 5px;
    margin-right: 75px;
    margin-left: 75px;
    }

   div#header
   {
   
   height: 35px;
 

   top:0px;

	    right:0px;

	    left:0px;

	    position:fixed;

	    //background: #00e500;
            background: #fff;
	    border:1px solid #ccc;

	    padding: 0 10px 0 20px;
   }

   div#footer
   {
            height: 7%;
            right:0px;
            
	    left:0px;
            bottom:0px;
	    background: #1F5F04;
            //background: #fff;
	    border:1px solid #ccc;

	    padding: 0 10px 0 20px;
   }
submit{line-height:25px;height:25px;}
table{ border-style:hidden; border: none;}

</style>

<script type="text/javascript">

function Validate() {


var jArray= <?php echo json_encode($qlist ); ?>;
var error=0;
   //alert(jArray);
    for(var j=0;j<jArray.length;j++)
    {   var flag=0;
        var ctr=0;
        var elm=jArray[j];
        var qq='q'+elm; var nm='text'+elm;
        var radios = document.getElementsByName(qq); 
      
        var et=document.getElementById(qq).type;
        // alert(qq);
        //alert(et);
       


    if(et=='radio' )
    {   //alert('len:'+radios.length);
        //val=document.getElementById(qq).checked;
        for (var i = 0; i < radios.length; i++) 
        { 
           if (radios[i].checked) 
           { 
                ctr++;  
                elm+='e';       
                document.getElementById(elm).innerHTML = '';         
           }
       }
       if(ctr==0)
       {
       flag++;
       elm+='e';
       error++;
       document.getElementById(elm).innerHTML = ' [ Error! Please select options below to proceed!! ]';
       document.getElementById('err').innerHTML = 'Error! Please refill the above left blank responses to proceed...';
       }
     }

if(et=='checkbox')
    {   
         //val=document.getElementById(qq).checked;
        var oRadio = document.forms[0].elements[qq]; 
          //alert(oRadio.length);
         var nm=document.getElementById(qq).name; var ln=nm.length; var res = nm.substring(0,ln-1);

  //var rad = document.getElementsByTagName('input').type == "checkbox";
 
         //alert(res);
        for (var i = 1; i <= oRadio.length; i++) 
        {  
                var vstr=res+i; 
                //alert(vstr);
                 var radi = document.getElementsByName(vstr);
                if (radi[0].checked) 
              { 
                ctr++;
              
                elm+='e';       
                document.getElementById(elm).innerHTML = ''; }           
       } 
       if(ctr==0)
       {
       flag++;
       elm+='e';
       error++;
       document.getElementById(elm).innerHTML = ' [ Error! Please select options below to proceed!! ]'; 
       document.getElementById('err').innerHTML = 'Error! Please refill the above left blank responses to proceed...';
       }
     }
        if (et == 'text' || et=='textarea') 
         {    
              if(document.getElementById(qq).value=='')  
              {
              elm+='e';
              error++; flag=0;
              document.getElementById(elm).innerHTML = ' [ Error! Please specify below to proceed!! ]';
              document.getElementById('err').innerHTML = 'Error! Please refill the above left blank responses to proceed...';     
              } 
              else
              {
                elm+='e';       
                document.getElementById(elm).innerHTML = '';
              } 
         }
    }   
    if(error==0 && flag==0)
      { return true;}
    if(error>0 || flag>=1)
      { flag=0; window.stop();return false;}          
}

</script>