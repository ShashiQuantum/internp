<?php
date_default_timezone_set("Asia/Kolkata");
                 $dt=date("d-M-Y H:i:s");                  
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js"></script>
<script type="text/javascript">
var doc = new jsPDF();
var specialElementHandlers = {
'#editor': function (element, renderer) {
return true;
}
};

$(document).ready(function() {
$('#btn').click(function () {
doc.fromHTML($('#content').html(), 5, 15, {
'width': 170,
'elementHandlers': specialElementHandlers
});
doc.save('Digiadmin-Blog.pdf');
});
});
</script>

<div id="site_content">
    <div id="content">
    <!-- insert the page content here -->
        <?php if(!isset($post))
            {echo "This page was accessed incorrectly";}
            else //display the post
            {?>
                <h2><?=$post['post_title']?></h2>
                <p><?=$post['post']?></p>
                
                <hr>
                <h3>Comments</h3>
    <?php       //if there is comments then print the comments
                if(count($comments) > 0)
                {
                    foreach ($comments as $row)
                    {?>
                <p><strong><?=$row['user']?></strong> said at <?= date('d-M-Y h:i A',strtotime($row['date_added']))?><br>
                <?=$row['comment'];?></p><hr>
            <?php   }
                }
                else //when there is no comment
                {
                    echo "<p>Currently, there are no comment.</p>";
                }
                
                if($this->session->userdata('user_id'))//if user is loged in, display comment box
                {?>
                    <form action="<?=  base_url()?>index.php/comments/add_comment/<?=$post['post_id']?>" method="post">
                        <div class="form_settings">
                            <p>
                                <span>Comment</span>
                                <textarea class="textarea" rows="8" cols="100" name="comment"></textarea>
                            </p>
                            <p style="padding-top: 15px">
                                <span>&nbsp;</span>
                                <input class="submit" type="submit" name="add" value="Add comment" />
                            </p>
                        </div>
                    </form>
               <?php 
               
                }
                else {//if no user is loged in, then show the loged in button
                ?>
                <a href="<?=  base_url()?>index.php/users/login">Login to comment</a>
        <?php    }
            }?>   
    </div>
</div>

<div align="center">
<?php 
 //$sp=base_url();
 //$sp.="index.php/blog/post/";
 $sp ='post/'.$post['post_id'];
 $ShareUrl = urlencode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]$sp");
 $Title = 'Share content URL in social media using PHP';
 $Media = '<?php echo base_url(); ?>public/img/logos/varenia_logo2.png';
?>

<!-- Share in facebook -->
<a onclick="shareinsocialmedia('https://www.facebook.com/sharer/sharer.php?u=<?php echo $ShareUrl;?>&title=<?php echo $Title;?>')" href="">
<img src="<?=  base_url()?>public/images/facebook.gif" title="share in facebook" height=30px width=30px>
</a>


<!-- Share in twitter -->
<a onclick="shareinsocialmedia('http://twitter.com/home?status=<?php echo $Title; ?>+<?php echo $ShareUrl; ?>')" href="">
<img src="<?=  base_url()?>public/images/twitter.gif" title="share in twitter" height=30px width=30px>
</a>


<!-- Share in google plus -->
<a onclick="shareinsocialmedia('https://plus.google.com/share?url=<?php echo $ShareUrl; ?>&media=<?php echo $Media; ?>')" href="">
<img src="<?=  base_url()?>public/images/gplus.gif" title="share in google plus" height=30px width=30px>
</a>


<!-- Share in Linkedin -->
<a onclick="shareinsocialmedia('http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $ShareUrl; ?>&title=<?php echo $Title; ?>')" href="">
<img src="<?= base_url()?>public/images/linkedin.gif" title="share in linkexdin" height=30px width=30px>
</a>

<a href="<?= base_url()?>public/blog/pdf/<?=$post['post_id']?>.pdf" download="Digiadmin Blog <?=$post['post_id']?>">
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Download As PDF</b>
</a>

</div>

<div id="editor"></div>
<!-- <button id="btn">Download PDF</button> -->


<script type="text/javascript" async >
	function shareinsocialmedia(url){
	window.open(url,'sharein','toolbar=0,status=0,width=648,height=395');
	return true;
	}
</script>
