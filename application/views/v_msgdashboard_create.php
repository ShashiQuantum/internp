<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoReply | Questionnaire Create</title>
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
            <li> <a href="<?=base_url();?>message/dashboard_edit"> Edit Question</a> </li>
            <li> <a href="<?=base_url();?>message/dashboard_report">Response Data Report</a> </li>
        </ul>
    </div>

    <div class="col-md-9 colo-sm-9 col-lg-9">
        <div class="card">
            <div class="card-header">
                <p>Create Questions</p>
            </div>
            <div class="card-body">
                <div id="stproject" style="display:block;">
                    Project: <input type="text" id="project" name="project" placeholder="Project Name here" max="20" required>
                    Total Questions: <input type="number" min="1" max="50" style="width:135px;" id="qcount" placeholder="Total Questions" onchange="showques();" required>
                    <button id="startb" class="btn btn-primary">START</button>
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

        $('#startb').click(function()
        {
            showques();
        });

        function setop(a){
            	let n = a+1;
		let v=$('#msgv'+a).val();
		$('#op'+n).val(v);
		console.log(n);
	}

        function showques(){
            sstt='';
            prj = $('#project').val();
            qcount = $('#qcount').val();
            if( prj !='' && (qcount != 0 || qcount !='') ){
                $('#error').text('');
                $(this).css('display','none');
                $('#content').css('display','block');
                $('#disp').css('display','block');
                $('#startb').css('display','none');

                for(let i=1; i <= qcount; i++){
			if(i == 1){
                    sstt += '<div> <span class="badge badge-dark"> Q-'+i+'. </span><br> <span class="badge badge-dark"><input type="hidden" style="width:135px;" min=1 id="seq'+i+'" value="'+i+'" >  <input type="hidden" id="pqid'+i+'" placeholder="qids ex 2,3">  Trigger values :  <input type="text" id="op'+i+'" placeholder="Ex. 1,2,a1,a2"> Match Type <select id="mt'+i+'"><option value="2">Multiple Choice</option><option value="1">Signle Choice</option> </select> <br> Then reply as <textarea rows="3" cols="80" id="msg'+i+'" placeholder="Trigger Message or question "></textarea> <textarea rows="3"  id="msgv'+i+'"  placeholder="Next Q. Trigger values" onChange="setop('+i+')"></textarea> <br></span> </div>';
			}else{
                    sstt += '<div> <span class="badge badge-dark"> Q-'+i+'. </span><br> <span class="badge badge-dark"><input type="hidden" style="width:135px;" min=1 id="seq'+i+'" value="'+i+'" > Previous QIDs <input type="text" id="pqid'+i+'" placeholder="qids ex 2,3">  Trigger values :  <input type="text" id="op'+i+'" placeholder="Ex. 1,2,a1,a2"> With Match Type <select id="mt'+i+'"><option value="2">Multiple Choice</option><option value="1">Signle Choice</option> </select> <br> Then reply as <textarea rows="3" cols="80" id="msg'+i+'" placeholder="Trigger Message"></textarea> <textarea rows="3"  id="msgv'+i+'" placeholder="Next Q. Trigger values" onChange="setop('+i+')"></textarea> <br></span> </div>';
			}
                    if(i<qcount) sstt+= '<hr>';
                }
                sstt += '<br> <input type="submit" class="btn btn-primary" id="submit" value="Submit" onclick="onSubmit();">';
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
            for(let i=1; i<= qcount;i++){
                let pqid = $('#pqid'+i).val();
                let sq = $('#seq'+i).val();
                let mt = $('#mt'+i).val();
                let op = $('#op'+i).val();
                let msg = $('#msg'+i).val();

                //console.log('sq: '+sq + ' mt: '+mt+' op: '+op+' msg: '+msg);
                arr.push({"pqid":pqid,"sq":sq,"mt":mt,"op":op,"msg":msg});
		//let x=JSON.parse(arr); 
               //console.log('arr : '+ JSON.stringify(arr));
	    }
                let ar = JSON.stringify(arr);
		let js = {"prj":prj,"qcount":qcount,"data":ar};
		//let ar = JSON.stringify(arr);
	  	$.ajax({
        	 	url:'<?php echo base_url("message/savemsg/");?>',
        		data: js,
        		type: "POST",
			//dataType: "json",
        	  success:function(data){
			//alert(JSON.stringify(data));
			if( data === 1 || data === '1'){
			 	$('#stproject').css('display','none');
				$('#content').css('display','none');
                		$('#disp').css('display','none');
			 	$('#error').text('Saved successfully!');
			}
			else $('#error').text('Error! Duplicate project name exist. Try with different name.');
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


