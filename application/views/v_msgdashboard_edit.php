<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoReply | Questionnaire Edit </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.3/toastr.css"/>
    
    <!-- link rel="stylesheet" href="./css/style-custom.css">
    -->
</head>
<body>
    
<div class="row container">
    <div class="col-md-3 col-sm-3 col-lg-3 sidebar-left bg-dark" style="height:100vh; color: #FFF;">
        <p></p>
        <ul>
            <li> <a href="<?=base_url();?>message/dashboard">Create Question</a> </li>
            <li> <a href="<?=base_url();?>message/dashboard_edit">Edit Question</a> </li>
            <li> <a href="<?=base_url();?>message/dashboard_report">Response Data Report</a> </li>
        </ul>
    </div>

    <div class="col-md-9 colo-sm-9 col-lg-9">
        <div class="card">
            <div class="card-header">
                <p>Edit Questions</p>
            </div>
            <div class="card-body">
                <div id="stproject" style="display:block;">
                    Project: <select id="pid" name="pid" onchange="showques()"><option value=''>Select Project</option>
			<?php
				$qcnt = 0;
				$p_arr=array();
				foreach($projects as $prj){
					$qcnt=$prj->qcnt;
					$srv_url=$prj->server_url;
					$pid = $prj->pid;
					$pname = $prj->title;
					$qdata = $prj->data;
					$aa = array("pid"=>$pid,"title"=>$pname,"qcnt"=>$qcnt,"url"=>$srv_url,"data"=>$qdata);
					//array_push($p_arr,$aa);
					$p_arr[$pid]=$aa;
					echo "<option value=$prj->pid > $prj->title  [ $prj->created_at ][ Total Q: $qcnt ] </option>";
				}
			?>
		    </select>
		</div>
		<div class="card-body">
                    Server URL :  <span style="background:#e1e1e1; width:135px;" id="url"> </span>
                    <!-- button id="startb" class="btn btn-primary">START</button>
		    -->
                </div>
                    <span id="error" style="color:red;"></span>
                    <div id="content" style="display:none;">
                        
                            
                            <!-- input type="hidden" id="val" name="val">
                            <label for="val">Enter options separed by comma : </label>
                            <br><textarea id="roptions" cols="60" rows="2" placeholder="Enter multiple options separed by comma"></textarea>
                            <br><label for="rmessage">Enter message as replay : </label>
                            <br><textarea id="rmessage" cols="60" rows="4" placeholder="Enter reply message as next question"></textarea>
                            <br><button id="nextq" class="btn btn-primary">NEXT QUESTION</button>
                            <input type="submit" class="btn btn-primary" id="rfinish" value="FINISH">
                            -->

                                     
                    </div>
                </div>
            </div>
            <div class="card-body" id="disp" style="display: none;">
                <p>List Questions</p>
            </div>
    </div>

</div>



    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

    <script>
        var arr = [], prj='', qcount=0;
        let sstt='',allq='';
	var spid=0,qcnt=0;
        $('#startb').click(function()
        {
            showques();
        });


        function showques(){
	    spid = $('#pid').val();
	    let url='';
	    let qdata = '';
		//alert('Pid: '+spid);

	    let parr = <?=json_encode($p_arr); ?>;
	    //let pqarr =
                var result = [];
                for(var i in parr){
			if( parr [i].pid == spid){
				qcnt = parr[i].qcnt;
				url = parr[i].url;
				qdata = parr[i].data;
                        	result.push([i, parr [i]]);
			}
 		}

		$('#url').text( url );
		//console.log('qdata: '+JSON.stringify( JSON.parse(qdata) ));
	    	//console.log('PID: '+spid +'qcnt: '+qcnt+' ARR: '+JSON.stringify(result));
		let jqdata = {"q": JSON.parse(qdata)};
		//for( var j in jqdata.q){
        	//	console.log('\n j: '+ JSON.stringify(jqdata.q[j]) );
		//}

            sstt='';
            prj = $('#project').val();
            qcount = $('#qcount').val();
            if( spid !='' && qcnt != 0){
                $('#error').text('');
                $(this).css('display','none');
                $('#content').css('display','block');
                $('#disp').css('display','block');
                $('#startb').css('display','none');
		let i=0;
                for(let j in jqdata.q){
		    i = i+1;
		    let str1='',str2='';
		    let mt=jqdata.q[j].mt;
		    if(mt == 1)
			str1=' selected';
                    if(mt == 2)
                        str2=' selected';
                    //sstt += '<div> <span class="badge badge-dark"> Q-'+i+'. </span><br> <span class="badge badge-dark"> <textarea rows="3" id="op'+i+'" placeholder="Options separated by comma"> '+ jqdata.q[j].op +'</textarea> <textarea rows="3" cols="50" id="msg'+i+'" placeholder="Reply Message">'+ jqdata.q[j].msg +'</textarea> <br> Sequence ID: <input type="number" style="width:135px;" min=1 id="seq'+i+'" value="'+jqdata.q[j].sq+'">Option Match Type <select id="mt'+i+'"><option value="1" '+ str1 +'>Exact Match</option><option value="2"' + str2 +'>Contains Match</option> </select> <br></span> </div>';
			if(i == 1){
                    sstt += '<div> <span class="badge badge-dark"> Q-'+i+'. </span><br> <span class="badge badge-dark"><input type="hidden" style="width:135px;" min=1 id="seq'+i+'" value="'+ jqdata.q[j].sq +'" >  <input type="hidden" id="pqid'+i+'" placeholder="qids 2,3" value="'+ jqdata.q[j].pqid +'">  Trigger values :  <input type="text" id="tv'+i+'" placeholder="Ex. 1,2,a1,a2" value="'+ jqdata.q[j].tv +'"> Match Type <select id="mt'+i+'"><option value="2" '+str2+'>Multiple Choice</option><option value="1" '+str1+'>Signle Choice</option> </select> <br> Then reply as <textarea rows="3" cols="80" id="msg'+i+'" placeholder="Trigger Message or question ">'+ jqdata.q[j].msg +'</textarea><textarea rows="3"  id="op'+i+'" placeholder="Options">'+ jqdata.q[j].op +'</textarea>  <br></span> </div>';
			}else{
                    sstt += '<div> <span class="badge badge-dark"> Q-'+i+'. </span><br> <span class="badge badge-dark"><input type="hidden" style="width:135px;" min=1 id="seq'+i+'" value="'+i+'" > If Trigger/Prev QIDs <input type="text" id="pqid'+i+'" placeholder="qids ex 2,3" value="'+ jqdata.q[j].pqid +'"> having Trigger values :  <input type="text" id="tv'+i+'" placeholder="Ex. 1,2,a1,a2" value="'+ jqdata.q[j].tv +'"> With Match Type <select id="mt'+i+'"><option value="2" '+str2+'>Multiple Choice</option><option value="1" '+str1+'>Signle Choice</option> </select> <br> Then reply as <textarea rows="3" cols="80" id="msg'+i+'" placeholder="Trigger Message">'+ jqdata.q[j].msg +'</textarea><textarea rows="3"  id="op'+i+'" placeholder="Options">'+ jqdata.q[j].op +'</textarea> <br>Else skip this question <br></span> </div>';
			}

                    if(i<qcnt) sstt+= '<hr>';
                }
                sstt += '<br> <input type="submit" class="btn btn-primary" id="submit" value="Update" onclick="onSubmit();">';
                $('#disp').html(sstt);
            }
            else{
                $('#error').text('Project name and total questions field cannot be left blank.');
            }
        }

        function onSubmit(){
            //prj = $('#project').val();
            //qcount = $('#qcount').val();
            //console.log('count q : '+qcount);
		arr=[];
            for(let i=1; i<= qcnt;i++){
                let pqid = $('#pqid'+i).val();
                let tv = $('#tv'+i).val();
                let sq = $('#seq'+i).val();
                let mt = $('#mt'+i).val();
                let op = $('#op'+i).val();
                let msg = $('#msg'+i).val();

                //console.log('sq: '+sq + ' mt: '+mt+' op: '+op+' msg: '+msg);
                arr.push({"pqid":pqid,"tv":tv,"sq":sq,"mt":mt,"op":op,"msg":msg});
		//let x=JSON.parse(arr); 
               //console.log('arr : '+ JSON.stringify(arr));
	    }
                let ar = JSON.stringify(arr);
		let js = {"pid":spid,"qcnt":qcnt,"data":ar};
		//let ar = JSON.stringify(arr);
	  	$.ajax({
        	 	url:'<?php echo base_url("message/savemsgupdate/");?>',
        		data: js,
        		type: "POST",
			//dataType: "json",
        	  success:function(data){
			//alert(JSON.stringify(data));
			if( data === 1 || data === '1'){
			 	$('#stproject').css('display','none');
				$('#content').css('display','none');
                		$('#disp').css('display','none');
			 	$('#error').text('Updated successfully!');
			}
			else $('#error').text('Error! Not updates.');
                	//$("#pqid").html(data);
                	//$("#ut").html(data);
        	  },
        	  error:function (){}
        	});


            //}
        }

        /*
        $('#nextq').click(function(){
            let op = $('#roptions').val();
            let msg= $('#rmessage').val();
            $('#roptions').val('');
            $('#rmessage').val('');
            arr.push({'op':op,'msg':msg});             
            console.log('arr : '+ JSON.stringify(arr));
            sstt += '<div class=card-header>Options : '+ op + '</div> <div class=card-body> '+msg + '</div><hr>';
            $('#disp').html(sstt);

        });
        */

        $('#rfinish4').click(function(){
            alert('done!');

            /*             let stt ='';
            arr.forEach(item => {
                //console.log('Item : '+ JSON.stringify(item));
                console.log('Item op : '+ item.op + ' MSG :' +item.msg) ;
                stt += '<br> OP: '+item.op + 'MSG : '+item.msg;
            });
            $('#disp').html(stt); */



        });

    </script>


