<?php
include_once('../init.php');
include_once('../functions.php');

 $data = $_GET['qid'];
 $qset=$_SESSION['qset'];
 $tt=$_GET['qc'];
 $qnext=$_GET['qnext'];
 $qnext_id=$_GET['qnext_id'];

$qtd="SELECT  `q_type` FROM `question_detail` WHERE `q_id`=$data";
$dd=DB::getInstance()->query($qtd);
if($dd->count()>0)
{    $qt=$dd->first()->q_type;
    
    if($qt=='radio' || $qt=='checkbox')
    {   
        echo "<table cellpadding=0 cellspacing=0 border=1 style=font-size:12px;><tr bgcolor=lightgray><td>Ques Options</td><td>Option Value </td><td>Routine Flow</td><td>Next Question </td> </tr>";
        $rd=DB::getInstance()->query("SELECT distinct `opt_text_value`,value FROM `question_option_detail` WHERE `q_id`=$data ");
        if($rd)
           $i=0;
    if($qnext==1)
    {    foreach($rd->results() as $r)
        {
            $i++;
            $op=$r->opt_text_value;
            $val=$r->value;
            //echo "<tr><td></td><td>Ques Options</td><td>Option Value </td><td>Routine Flow</td><td>Next Question </td> </tr>";
            echo "<tr><td><input type=text readonly name=option$i value='$op'></td><td><input readonly type=text name=value$i value='$val'> </td><td><select name=routine$i id=routine> <option value=continue>Continue</option><option value=terminate>Terminate</option></select></td><td><select name=nsqid$i id=qid2> <option value=0>--Select--</option>";
            //if($aq)
                if($tt==0)
                    $qr="SELECT * FROM `question_detail` WHERE qset_id=$qset";
                if($tt==1)
                    $qr="SELECT * FROM `question_detail`";
                
                $q=DB::getInstance()->query($qr);
                if($q->count()>0)
                {
                    echo "<option value='-1'>Last Question $qset</option>";
                foreach($q->results() as $d)
                { 
                    $qid=$d->q_id;
                    $qq= $d->q_title;
                    $l=substr($qq,0,80);
                    echo "<option value=' $qid '>$qid - $l </option>" ;        
                }
                }
            echo "</select> </td> </tr>";
         } //end of foreach
      }
      else if($qnext==0)
      {   foreach($rd->results() as $r)
        {
            $i++;
            $op=$r->opt_text_value;
            $val=$r->value;
            //echo "<tr><td></td><td>Ques Options</td><td>Option Value </td><td>Routine Flow</td><td>Next Question </td> </tr>";
            echo "<tr><td><input type=text readonly name=option$i value='$op'></td><td><input readonly type=text name=value$i value='$val'> </td><td><select name=routine$i id=routine> <option value=continue>Continue</option><option value=terminate>Terminate</option></select></td><td><select name=nsqid$i id=qid2> <option value=$qnext_id>$qnext_id</option>";
            
            echo "</select> </td> </tr>";
         } //end of foreach
     }    
         
        echo "</table>";
        
    }
    if($qt=='rating')
    {   
            $sv='';$ev='';$sl='';$el='';
            echo "<table cellpadding=0 cellspacing=0 border=1 style=font-size:12px;><tr bgcolor=lightgray><td>Rating Titles</td><td>Rating Value </td><td>Routine Flow</td><td>Next Question </td> </tr>";
            $sql="SELECT `scale_start_value`, `scale_end_value`, `scale_start_label`, `scale_end_label` FROM `question_option_detail` WHERE `q_id`=$data ";
            $da=DB::getInstance()->query($sql);
            if($da->count()>0)
            {
                $sv=$da->first()->scale_start_value;
                $ev=$da->first()->scale_end_value;
                $sl=$da->first()->scale_start_label;
                $el=$da->first()->scale_end_label;
            }
            $i=0;
            $str='';
            
            if($qnext==1)
            {
            for($s=$sv;$s<=$ev;$s++)
            {
                $i++;
                
                if($sv==0)
                    $str='NA';
                        
                if(($sv+1)==$s && $str=='NA')
                    $str=$sl;
                else if($sv==$s && $str!='NA')
                    $str=$sl;
                
                else if($ev==$s)
                    $str=$el;
                else
                    $str='';
                
                echo "<tr><td><input type=text readonly name=option$i value='$str'></td><td><input readonly type=text name=value$i value=$s> </td><td><select name=routine$i id=routine> <option value=continue>Continue</option><option value=terminate>Terminate</option></select></td><td><select name=nsqid$i id=qid2> <option value=0>--Select--</option>";
                if($tt==0)
                    $qr="SELECT * FROM `question_detail` WHERE qset_id=$qset";
                if($tt==1)
                    $qr="SELECT * FROM `question_detail`";
                
                $q=DB::getInstance()->query($qr);
                if($q)
                {
                    echo "<option value='-1'>Last Question</option>";
                    
                foreach($q->results() as $d)
                { 
                    $qid=$d->q_id;
                    $qq= $d->q_title;
                    $l=substr($qq,0,80);
                    echo "<option value=' $qid '>$qid - $l </option>" ;        
                }
                
                
                
                }
                echo "</select> </td> </tr>";
             }
            }
            else if($qnext==0)
            {
                for($s=$sv;$s<=$ev;$s++)
            	{
                $i++;
                
                if($sv==0)
                    $str='NA';
                        
                if(($sv+1)==$s && $str=='NA')
                    $str=$sl;
                else if($sv==$s && $str!='NA')
                    $str=$sl;
                
                else if($ev==$s)
                    $str=$el;
                else
                    $str='';
                
                echo "<tr><td><input type=text readonly name=option$i value='$str'></td><td><input readonly type=text name=value$i value=$s> </td><td><select name=routine$i id=routine> <option value=continue>Continue</option><option value=terminate>Terminate</option></select></td><td><select name=nsqid$i id=qid2> <option value=$qnext_id>$qnext_id</option>";
                                echo "</select> </td> </tr>";
               }
            }
        
        echo "</table>";
        
    }
    if($qt=='instruction' || $qt=='text' || $qt=='textarea' || $qt=='textrating' || $qt=='title2rating' || $qt=='first' || $qt=='last' || $qt=='dropdown')
    {
            echo "<table cellpadding=0 cellspacing=0 border=1 style=font-size:12px;><tr bgcolor=lightgray><td>Routine Flow</td><td>Next Question </td> </tr>";
            echo "<tr><td><select name=routine id=routine> <option value=continue>Continue</option><option value=terminate>Terminate</option></select></td><td><select name=nsqid id=qid2> <option value=0>--Select--</option>";
                if($tt==0)
                    $qr="SELECT * FROM `question_detail` WHERE qset_id=$qset";
                if($tt==1)
                    $qr="SELECT * FROM `question_detail`";
                
                $q=DB::getInstance()->query($qr);
                if($q)
                {
                   echo "<option value='-1'>Last Question</option>";
                foreach($q->results() as $d)
                { 
                    $qid=$d->q_id;
                    $qq= $d->q_title;
                    $l=substr($qq,0,80);
                    echo "<option value=' $qid '>$qid - $l </option>" ;        
                }
                }
            echo "</select> </td> </tr>";
    }
    if($qt=='calculated')
    {        echo "";
        echo "<table cellpadding=0 cellspacing=0 border=1 style=font-size:12px;><tr bgcolor=lightgray><td>If Condition</td><td>Total Weight Value</td><td>Routine Flow</td><td>Next Question </td><td>Join with</td> </tr>";
        
        echo "<tr><td><select name=comp0 class=comp0 id=comp0> <option value='>'>Greater Than (>)</option><option value='>='>Greater Than Equal To (>=)</option><option value='<'>Less Than(<)</option><option value='<='>Less Than Equal To (<=)</option><option value='=='>Equal To(==)</option><option value='!='>Not Equal To(!=)</option><option value='range'>In Between (specify <b>,</b> between range)</option><option value='not range'>Not In Between (specify <b>,</b> between range)</option></select></td><td><input type=text name=wt0 placeholder='in grams'></div></td><td><select name=routine0 id=routine0> <option value=continue>Continue</option><option value=terminate>Terminate</option></select></td><td><select name=nsqid0 id=nsqid0> <option value=0>--Select--</option>";
            //if($aq)
                if($tt==0)
                    $qr="SELECT * FROM `question_detail` WHERE qset_id=$qset";
                if($tt==1)
                    $qr="SELECT * FROM `question_detail`";
                
                $q=DB::getInstance()->query($qr);
                if($q)
                {
                   echo "<option value='-1'>Last Question</option>";
                foreach($q->results() as $d)
                { 
                    $qid=$d->q_id;
                    $qq= $d->q_title;
                    $l=substr($qq,0,80);
                    echo "<option value=' $qid '>$qid - $l </option>" ;        
                }
                }
            echo "</select> </td><td><select name=join0  id=join> <option value='none'>None </option><option value='and'>AND </option><option value='or'>OR</option> </td> </tr>";
            
            echo "<tr><td><select name=comp1 id=comp1> <option value='>'>Greater Than (>)</option><option value='>='>Greater Than Equal To (>=)</option><option value='<'>Less Than(<)</option><option value='<='>Less Than Equal To (<=)</option><option value='=='>Equal To(==)</option><option value='!='>Not Equal To (!=)</option><option value='range'>In Between (specify <b>,</b> between range)</option><option value='not in range'>Not In Between (specify <b>,</b> between range)</option></select></td><td><input type=text name=wt1 placeholder='in grams'></div></td><td><select name=routine1 id=routine1> <option value=continue>Continue</option><option value=terminate>Terminate</option></select></td><td><select name=nsqid1 id=nsqid1> <option value=0>--Select--</option>";
            //if($aq)
                if($tt==0)
                    $qr="SELECT * FROM `question_detail` WHERE qset_id=$qset";
                if($tt==1)
                    $qr="SELECT * FROM `question_detail`";
                
                $q=DB::getInstance()->query($qr);
                if($q)
                {
                    echo "<option value='-1'>Last Question</option>";
                foreach($q->results() as $d)
                { 
                    $qid=$d->q_id;
                    $qq= $d->q_title;
                    $l=substr($qq,0,80);
                    echo "<option value=' $qid '>$qid - $l </option>" ;        
                }
                }
            echo "</select> </td><td><select name=join1 class=join1 id=join1><option value='none'>None </option> <option value='and'>AND </option><option value='or'>OR</option> </td> </tr>";
            
            echo "<tr><td><select name=comp2 id=comp2> <option value='>'>Greater Than (>)</option><option value='>='>Greater Than Equal To (>=)</option><option value='<'>Less Than (<)</option><option value='<='>Less Than Equal To (<=)</option><option value='=='>Equal To (==)</option><option value='!='>Not Equal To (!=)</option><option value='range'>In Between (specify <b>,</b> between range)</option><option value='not in range'>Not In Between (specify <b>,</b> between range)</option></select></td><td><input type=text name=wt2 placeholder='in grams'></div></td><td><select name=routine2 id=routine2> <option value=continue>Continue</option><option value=terminate>Terminate</option></select></td><td><select name=nsqid2 id=nsqid2> <option value=0>--Select--</option>";
            //if($aq
                if($tt==0)
                    $qr="SELECT * FROM `question_detail` WHERE qset_id=$qset";
                if($tt==1)
                    $qr="SELECT * FROM `question_detail`";
                
                $q=DB::getInstance()->query($qr);
                if($q)
                {
                    echo "<option value='-1'>Last Question</option>";
                foreach($q->results() as $d)
                { 
                    $qid=$d->q_id;
                    $qq= $d->q_title;
                    $l=substr($qq,0,80);
                    echo "<option value=' $qid '>$qid - $l </option>" ;        
                }
                }
            echo "</select> </td> </tr>";
    }
    
    if($qt=='sec')
    {        echo "";
        echo "<table cellpadding=0 cellspacing=0 border=1 style=font-size:12px;><tr bgcolor=lightgray><td>SEC</td><td>Routine Flow</td><td>Next Question </td><td>More...</td> </tr>";
        
        echo "<tr><td><select name=comp0 class=comp0 id=comp0> <option value='1'>A1-1</option><option value='2'>A2-2</option><option value='3'>B1-3</option><option value='4'>B2-4</option><option value='5'>C-5</option><option value='6'>D-6</option><option value='7'>E1-7</option><option value='8'>E2-8</option><option value='9'>Others-9</option></select></td><td><select name=routine0 id=routine0> <option value=continue>Continue</option><option value=terminate>Terminate</option></select></td><td><select name=nsqid0 id=nsqid0> <option value=0>--Select--</option>";
            //if($aq)
                if($tt==0)
                    $qr="SELECT * FROM `question_detail` WHERE qset_id=$qset";
                if($tt==1)
                    $qr="SELECT * FROM `question_detail`";
                
                $q=DB::getInstance()->query($qr);
                if($q)
                {
                    echo "<option value='-1'>Last Question</option>";
                foreach($q->results() as $d)
                { 
                    $qid=$d->q_id;
                    $qq= $d->q_title;
                    $l=substr($qq,0,80);
                    echo "<option value=' $qid '>$qid - $l </option>" ;        
                }
                }
            echo "</select> </td><td><select name=join0  id=join> <option value='no'>No </option><option value='yes'>Yes </option></td> </tr>";
            
        echo "<tr><td><select name=comp1 class=comp1 id=comp1> <option value='1'>A1-1</option><option value='2'>A2-2</option><option value='3'>B1-3</option><option value='4'>B2-4</option><option value='5'>C-5</option><option value='6'>D-6</option><option value='7'>E1-7</option><option value='8'>E2-8</option><option value='9'>Others-9</option></select></td><td><select name=routine1 id=routine1> <option value=continue>Continue</option><option value=terminate>Terminate</option></select></td><td><select name=nsqid1 id=nsqid1> <option value=0>--Select--</option>";
            //if($aq)
                if($tt==0)
                    $qr="SELECT * FROM `question_detail` WHERE qset_id=$qset";
                if($tt==1)
                    $qr="SELECT * FROM `question_detail`";
                
                $q=DB::getInstance()->query($qr);
                if($q)
                {
                    echo "<option value='-1'>Last Question</option>";
                foreach($q->results() as $d)
                { 
                    $qid=$d->q_id;
                    $qq= $d->q_title;
                    $l=substr($qq,0,80);
                    echo "<option value=' $qid '>$qid - $l </option>" ;        
                }
                }
            echo "</select> </td><td><select name=join1 id=join1><option value='no'>No </option> <option value='yes'>Yes </option></td> </tr>";
            
            echo "<tr><td><select name=comp2 class=comp2 id=comp2> <option value='1'>A1-1</option><option value='2'>A2-2</option><option value='3'>B1-3</option><option value='4'>B2-4</option><option value='5'>C-5</option><option value='6'>D-6</option><option value='7'>E1-7</option><option value='8'>E2-8</option><option value='9'>Others-9</option></select></td><td><select name=routine2 id=routine2> <option value=continue>Continue</option><option value=terminate>Terminate</option></select></td><td><select name=nsqid2 id=nsqid2> <option value=0>--Select--</option>";

            //if($aq
                if($tt==0)
                    $qr="SELECT * FROM `question_detail` WHERE qset_id=$qset";
                if($tt==1)
                    $qr="SELECT * FROM `question_detail`";
                
                $q=DB::getInstance()->query($qr);
                if($q)
                {
                   echo "<option value='-1'>Last Question</option>";
                foreach($q->results() as $d)
                { 
                    $qid=$d->q_id;
                    $qq= $d->q_title;
                    $l=substr($qq,0,80);
                    echo "<option value=' $qid '>$qid - $l </option>" ;        
                }
                }
            echo "</select> </td><td><select name=join2 id=join2><option value='no'>No </option> <option value='yes'>Yes </option></td> </tr>";
            echo "<tr><td><select name=comp3 class=comp3 id=comp3> <option value='1'>A1-1</option><option value='2'>A2-2</option><option value='3'>B1-3</option><option value='4'>B2-4</option><option value='5'>C-5</option><option value='6'>D-6</option><option value='7'>E1-7</option><option value='8'>E2-8</option><option value='9'>Others-9</option></select></td><td><select name=routine3 id=routine3> <option value=continue>Continue</option><option value=terminate>Terminate</option></select></td><td><select name=nsqid3 id=nsqid3> <option value=0>--Select--</option>";
            //if($aq)
                if($tt==0)
                    $qr="SELECT * FROM `question_detail` WHERE qset_id=$qset";
                if($tt==1)
                    $qr="SELECT * FROM `question_detail`";
                
                $q=DB::getInstance()->query($qr);
                if($q)
                {
                    echo "<option value='-1'>Last Question</option>";
                foreach($q->results() as $d)
                { 
                    $qid=$d->q_id;
                    $qq= $d->q_title;
                    $l=substr($qq,0,80);
                    echo "<option value=' $qid '>$qid - $l </option>" ;        
                }
                }
            echo "</select> </td><td><select name=join3  id=join3> <option value='no'>No </option><option value='yes'>Yes </option></td> </tr>";
            
        echo "<tr><td><select name=comp4 id=comp4> <option value='1'>A1-1</option><option value='2'>A2-2</option><option value='3'>B1-3</option><option value='4'>B2-4</option><option value='5'>C-5</option><option value='6'>D-6</option><option value='7'>E1-7</option><option value='8'>E2-8</option><option value='9'>Others-9</option></select></td><td><select name=routine4 id=routine4> <option value=continue>Continue</option><option value=terminate>Terminate</option></select></td><td><select name=nsqid4 id=nsqid4> <option value=0>--Select--</option>";
            //if($aq)
                if($tt==0)
                    $qr="SELECT * FROM `question_detail` WHERE qset_id=$qset";
                if($tt==1)
                    $qr="SELECT * FROM `question_detail`";
                
                $q=DB::getInstance()->query($qr);
                if($q)
                {
                    echo "<option value='-1'>Last Question</option>";
                foreach($q->results() as $d)
                { 
                    $qid=$d->q_id;
                    $qq= $d->q_title;
                    $l=substr($qq,0,80);
                    echo "<option value=' $qid '>$qid - $l </option>" ;        
                }
                }
            echo "</select> </td><td><select name=join4 id=join4><option value='no'>No </option> <option value='yes'>Yes </option></td> </tr>";
            
            echo "<tr><td><select name=comp5 id=comp5> <option value='1'>A1-1</option><option value='2'>A2-2</option><option value='3'>B1-3</option><option value='4'>B2-4</option><option value='5'>C-5</option><option value='6'>D-6</option><option value='7'>E1-7</option><option value='8'>E2-8</option><option value='9'>Others-9</option></select></td><td><select name=routine5 id=routine5> <option value=continue>Continue</option><option value=terminate>Terminate</option></select></td><td><select name=nsqid5 id=nsqid5> <option value=0>--Select--</option>";

            //if($aq
                if($tt==0)
                    $qr="SELECT * FROM `question_detail` WHERE qset_id=$qset";
                if($tt==1)
                    $qr="SELECT * FROM `question_detail`";
                
                $q=DB::getInstance()->query($qr);
                if($q)
                {
                    echo "<option value='-1'>Last Question</option>";
                foreach($q->results() as $d)
                { 
                    $qid=$d->q_id;
                    $qq= $d->q_title;
                    $l=substr($qq,0,80);
                    echo "<option value=' $qid '>$qid - $l </option>" ;        
                }
                }
            echo "</select> </td><td><select name=join5 id=join5><option value='no'>No </option> <option value='yes'>Yes </option></td> </tr>";
        
            echo "<tr><td><select name=comp6 id=comp6> <option value='1'>A1-1</option><option value='2'>A2-2</option><option value='3'>B1-3</option><option value='4'>B2-4</option><option value='5'>C-5</option><option value='6'>D-6</option><option value='7'>E1-7</option><option value='8'>E2-8</option><option value='9'>Others-9</option></select></td><td><select name=routine6 id=routine6> <option value=continue>Continue</option><option value=terminate>Terminate</option></select></td><td><select name=nsqid6 id=nsqid6> <option value=0>--Select--</option>";
            //if($aq)
                if($tt==0)
                    $qr="SELECT * FROM `question_detail` WHERE qset_id=$qset";
                if($tt==1)
                    $qr="SELECT * FROM `question_detail`";
                
                $q=DB::getInstance()->query($qr);
                if($q)
                {
                    echo "<option value='-1'>Last Question</option>";
                foreach($q->results() as $d)
                { 
                    $qid=$d->q_id;
                    $qq= $d->q_title;
                    $l=substr($qq,0,80);
                    echo "<option value=' $qid '>$qid - $l </option>" ;        
                }
                }
            echo "</select> </td><td><select name=join6 id=join6><option value='no'>No </option> <option value='yes'>Yes </option></td> </tr>";
            
            echo "<tr><td><select name=comp7 id=comp7> <option value='1'>A1-1</option><option value='2'>A2-2</option><option value='3'>B1-3</option><option value='4'>B2-4</option><option value='5'>C-5</option><option value='6'>D-6</option><option value='7'>E1-7</option><option value='8'>E2-8</option><option value='9'>Others-9</option></select></td><td><select name=routine7 id=routine7> <option value=continue>Continue</option><option value=terminate>Terminate</option></select></td><td><select name=nsqid7 id=nsqid7> <option value=0>--Select--</option>";
                if($tt==0)
                    $qr="SELECT * FROM `question_detail` WHERE qset_id=$qset";
                if($tt==1)
                    $qr="SELECT * FROM `question_detail`";
                
                $q=DB::getInstance()->query($qr);
                if($q)
                {
                    echo "<option value='-1'>Last Question</option>";
                foreach($q->results() as $d)
                { 
                    $qid=$d->q_id;
                    $qq= $d->q_title;
                    $l=substr($qq,0,80);
                    echo "<option value=' $qid '>$qid - $l </option>" ;        
                }
                }
            echo "</select> </td><td><select name=join7 id=join7><option value='no'>No </option> <option value='yes'>Yes </option></td> </tr>";
            echo "<tr><td><select name=comp8 id=comp8> <option value='1'>A1-1</option><option value='2'>A2-2</option><option value='3'>B1-3</option><option value='4'>B2-4</option><option value='5'>C-5</option><option value='6'>D-6</option><option value='7'>E1-7</option><option value='8'>E2-8</option><option value='9'>Others-9</option></select></td><td><select name=routine8 id=routine8> <option value=continue>Continue</option><option value=terminate>Terminate</option></select></td><td><select name=nsqid8 id=nsqid8> <option value=0>--Select--</option>";
                if($tt==0)
                    $qr="SELECT * FROM `question_detail` WHERE qset_id=$qset";
                if($tt==1)
                    $qr="SELECT * FROM `question_detail`";
                
                $q=DB::getInstance()->query($qr);
                if($q)
                {
                    echo "<option value='-1'>Last Question</option>";
                foreach($q->results() as $d)
                { 
                    $qid=$d->q_id;
                    $qq= $d->q_title;
                    $l=substr($qq,0,80);
                    echo "<option value=' $qid '>$qid - $l </option>" ;        
                }
                }
            echo "</select> </td><td><select name=join8 id=join8><option value='no'>No </option> <option value='yes'>Yes </option></td> </tr>";
            
            echo "</select> </td> </tr>";
    }
}

            
?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
     
<script type="text/javascript">

function displib5()
{
        var pin;
	if(window.XMLHttpRequest)
	{
		pin=new XMLHttpRequest();
	}
	else
	{
		pin= new ActiveXobject("Microsoft.XMLHTTP");
	}
	var val=document.getElementById('comp').value;
        //document.write('Hello: '+val);
	pin.onreadystatechange=function()
	{
		if(pin.readyState==4)
		{
			document.getElementById('bt').innerHTML=pin.responseText;
			console.log(pin);
                        
		}
	}
	url="get_ques_not_qest.php?qset="+val;
	pin.open("GET",url,true);
	pin.send();
}

</script>
<script type="text/javascript">
    $(document).ready(function(){ alert("Hi");
 $("#comp").click(function () { alert("Hi");});
    });
</script>