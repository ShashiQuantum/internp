<?php
include_once('../../init.php');
include_once('../../functions.php');

 	
   	//print_r($_POST);
   	echo "<head><title>Filter Count Result</title></head><body>";

   	if(isset($_POST['get_resp']))
   	{       
   		$condition=''; $colms=array(); $col_str=null;
       		$conditions='SELECT * FROM `mangopinion_57`  WHERE ';

		$curr='';$prev='';$orflag=0;$andflag=0;$pstr='';$ctr=0;
		//$qset=$_POST['qset'];
       		$count=sizeof($_POST);
		 if($count>3)
		 {
		    foreach($_POST as $key=>$val)
		    {
		    	if($val!='')
		    	{       
		    	 	
		    		//echo "<br>".$key."=>".$val;
		    		if($key!='pn'  )
		    		if($key!='qset'  )
		    		if($key!='fr'  )
		    		if($key !='to' )
		    		{
		    		if($val!='View')
		    		{   
		    		        $ctr++; 
		    			$str='';
		    			$dlist=array();
		    			$dlist=explode('=',$val);
		    			$a=$dlist[0];
		    			$b=$dlist[1];
		    			$curr=$a;
		    			$str=$a."=".$b;
		    				array_push($colms,$a);
		    			//echo '<br>'.$ctr.'-'.$prev.'=:'.$curr;
		    			
		    			if($curr==$prev)
		    			{   
		    				$orflag++;
		    				if($orflag==1)
		    				{    		
		    						$orflag++;	
		    						if($ctr==1)		
		    							$condition.=' ( '.$pstr .' OR '.$str;  
		    						if($ctr>1)		
		    						{	
		    							$condition=chop($condition,$pstr);
		    							$condition.='  ( '.$pstr .' OR '.$str;
		    						}						
		    				}
		    				else if($orflag>1)
		    				{
		    					$condition.=' OR '.$str;
		    				}
		    				
		    				//echo "<br>rcondition=".$condition;
		    			}
		    			else
		    			{
		    				$andflag++;
		    				if($orflag>1)
		    				{
		    					$orflag=0;  
		    					$condition.=' ) '; 
		    				}
		    				if($ctr==1 && $orflag==0)
		    					$condition.=$str;	
		    				else if($ctr>1 && $orflag==0)
		    					$condition.=' AND '.$str;
		    			       //echo "<br>acondition=".$condition;
		    			}
		    			
		    			//$condition.=$str;
		    			//array_push($dlist,$clist);
		    			//echo "<br>fcondition=".$condition;
		    			
		    			$prev=$curr;
		    			$pstr=$str;
		    			
		    			
		    		} //view end
		    		} //val if end
		    	} //foreach end		    	
		    } //if count end
$colms=array_unique($colms);  $col_str=implode(",",$colms);		
		    if($orflag > 1)
		    {
		        $condition.=' )';
		    }
		
		   	  
		    if($_POST['fr']!='' && $_POST['to']!='')
		    {
		        $f=$_POST['fr'];
		        $t=$_POST['to'];
		        
		    	//$condition.=" AND nresp_age_yrs BETWEEN $f AND $t ";
                         if($orflag>0 || $andflag>0)
    	                      $condition.=" AND age_yrs BETWEEN $f AND $t ";
                         if($orflag<1 && $andflag<1)
    	                      $condition.=" age_yrs BETWEEN $f AND $t ";

		    }
		   // $condition.=" AND user_id NOT IN (SELECT `appuser_id` FROM `appuser_project_map` WHERE project_id=$qset AND status=0) ";
		    //echo "<br>fcondition=".$condition;
		
		    $conditions.=$condition;
		
		    $tot=0;$mct=0;$fct=0;
		
		    echo "<center><br><br><h2>Summary Report</h2><br><table border=1>";
		  
		    $pcondition="SELECT count(*) as cnt FROM `mangopinion_57`  WHERE ".$condition;
		    $dcnt=DB::getInstance()->query($pcondition);
		    if($dcnt->count()>0)
		    {
		        $ct=$dcnt->first()->cnt; 
		    } 
		
		    $vcondition="SELECT count(*) as cnt FROM app_user WHERE user_id in ( SELECT resp_id FROM `mangopinion_57` WHERE $condition ) and status=1";
		    $dcnt=DB::getInstance()->query($vcondition);
		    if($dcnt->count()>0)
		    {
		        $acnt=$dcnt->first()->cnt;   
		    }
		 /* //not approved count  
		    $wcondition="SELECT count(*) as cnt FROM app_user WHERE user_id in ( SELECT resp_id FROM `mangopinion_57` WHERE  $condition ) and status=0";
		    $dcnt=DB::getInstance()->query($wcondition);
		    if($dcnt->count()>0)
		    {
		      $nacnt=$dcnt->first()->cnt;   
		    }
		*/
		     $mcondition="SELECT count(*) as cnt FROM app_user WHERE user_id in ( SELECT resp_id FROM `mangopinion_57` WHERE gender_57=1 AND resp_id in ( SELECT resp_id FROM `mangopinion_57` WHERE  $condition ) ) ";
		    $mcnt=DB::getInstance()->query($mcondition);
		    if($mcnt->count()>0)
		    {
		        $mct=$mcnt->first()->cnt;   
		    }else $mct=0;
		
		    $fcondition="SELECT count(*) as cnt FROM app_user WHERE user_id in (SELECT resp_id FROM `mangopinion_57` WHERE gender_57=2 AND resp_id in ( SELECT resp_id FROM `mangopinion_57` WHERE  $condition ) ) ";
		    $fcnt=DB::getInstance()->query($fcondition);
		    if($fcnt->count()>0)
		    {
		        $fct=$fcnt->first()->cnt;   
		    }else $fct=0;
		
		
		        echo "<tr bgcolor=lightgray><td>Record Found</td><td>Male</td><td>Female</td></tr>";
		   	echo "<tr><td>$acnt</td><td>$mct</td><td>$fct</td></tr></table>";
                     //for display list
                      		$ct=0;
			    $pcondition="SELECT count(*) as cnt FROM `mangopinion_57`  WHERE ".$condition;
			    
			    $dcnt=DB::getInstance()->query($pcondition);
			   if($dcnt->count()>0)
			   {
			     $ct=$dcnt->first()->cnt;
			      
			   } 
			   	echo "<br><center><font color=red>($ct) records are found!</center></font><br>";
			   	
			   	 class TableRows extends RecursiveIteratorIterator 
				 { 
				     function __construct($it) { 
				         parent::__construct($it, self::LEAVES_ONLY); 
				     }
				
				     function current() {
				         return "<td style='width: 150px; border: 1px solid black;'>" . parent::current(). "</td>";
				     }
				
				     function beginChildren() { 
				         echo "<tr>"; 
				     } 
				
				     function endChildren() { 
				         echo "</tr>" . "\n";
				     } 
				 } 
				    //SELECT `resp_id`,  `r_name`, `mobile`, `email`, `address`, $col_str FROM `mangopinion_57` WHERE ".$condition

				  $colqry="SELECT `user_id`, `user_name`, `user`, `mobil`, `create_date` FROM `app_user` WHERE `user_id` in (SELECT `resp_id` FROM `mangopinion_57` WHERE $condition )" ;
			      	$mysqli = new mysqli("localhost", "user1", "vcims@user1", "vcims_12052015");
			  if (mysqli_multi_query($mysqli, $colqry)) 
			   {
			            do { $result=mysqli_multi_query($mysqli, $colqry);
			
			                $results_array = Array(Array());
			            $fillKeys = true;
			            if ($result = mysqli_store_result($mysqli)) { 
			             while ($row = $result->fetch_assoc()) 
			            {
			                $temp = Array();
			                foreach ($row as $key => $val)
			                {
			                    if ($fillKeys) {
			                        $results_array[0][] = $key;
			                    }
			                    $temp[] = $val;
			                }
			                $results_array[] = $temp;
			                $fillKeys = false;
			            }
			            } 
			              if(!mysqli_more_results($mysqli)) break;   
			            } while (mysqli_next_result($mysqli));
			   }
			    echo "<center><table border='1' cellpadding='0' cellspacing='0' style='margin-left:75px'>";
			
			    
			     $qst=new RecursiveArrayIterator($results_array);
			 
			     foreach(new TableRows($qst) as $k=>$v) 
			     { 
			          echo $v;  
			     }
			   	

		}
		else  
		{              
		    $tot=0;	
		    echo "<center><br><br><h2>Summary Report</h2><br><table border=1>";
		  
		    $pcondition="SELECT count(*) as cnt FROM app_user WHERE user_id in ( SELECT resp_id FROM `mangopinion_57`)";
		    $dcnt=DB::getInstance()->query($pcondition);
		    if($dcnt->count()>0)
		    {
		        $ct=$dcnt->first()->cnt; 
		    } 
		
		    $xcondition="SELECT count(*) as cnt FROM app_user WHERE status=1";
		    $dcntt=DB::getInstance()->query($xcondition);
		    if($dcntt->count()>0)
		    {
		        $acnt=$dcntt->first()->cnt;   
		    }
		    
		    $ycondition="SELECT count(*) as cnt FROM app_user WHERE status=0";
		    $dcnnt=DB::getInstance()->query($ycondition);
		    if($dcnnt->count()>0)
		    {
		        $nacnt=$dcnnt->first()->cnt;   
		    }
		    		
		    $mcondition="SELECT count(*) as cnt FROM app_user WHERE user_id in ( SELECT resp_id FROM `mangopinion_57` WHERE gender_57=1 ) ";
		    $mcnt=DB::getInstance()->query($mcondition);
		    if($mcnt->count()>0)
		    {
		        $mct=$mcnt->first()->cnt;   
		    }else $mct=0;
		
		    $fcondition="SELECT count(*) as cnt FROM app_user WHERE user_id in ( SELECT resp_id FROM `mangopinion_57` WHERE gender_57=2 ) ";
		    $fcnnt=DB::getInstance()->query($fcondition);
		    if($fcnnt->count()> 0 )
		    {
		        $fct=$fcnnt->first()->cnt;   
		    }else $fct=0;		 
		        echo "<tr bgcolor=lightgray><td>Record Available</td><td>Not Approved</td><td>Male</td><td>Female</td></tr>";
		   	echo "<tr><td>$acnt</td><td>$nacnt</td><td>$mct</td><td>$fct</td></tr>";
		}
   }
   
?>

