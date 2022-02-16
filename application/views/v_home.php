

<div id="site_content">
    <?php include 'sidebar.php' ?>
    <div id="content">
        <?php if($this->session->userdata('user_id') && $this->session->userdata('user_type') != 'user')
        { ?>
        <h2><a style="color: green" href="<?=  base_url()?>index.php/blog/new_post/"><span class="glyphicon glyphicon-pencil"></span> Create a new post</a></h2>
        <?php } ?>
    <!-- insert the page content here -->
    <?php foreach($posts as $post)
    { ?>
    <h2><a style="color:red;" href="<?=  base_url()?>index.php/blog/post/<?=$post['post_id']?>"><?=$post['post_title'];?></a></h2>
        <?php if($this->session->userdata('user_id') && $this->session->userdata('user_type') != 'user')
        { ?>
        <p>
            <a href="<?=  base_url()?>index.php/blog/editpost/<?=$post['post_id']?>"><span class="glyphicon glyphicon-edit" title="Edit post"></span></a> | 
            <a href="<?=  base_url()?>index.php/blog/deletepost/<?=$post['post_id']?>"><span style="color:#f77;" class="glyphicon glyphicon-remove-circle" title="Delete post"></span></a>
        </p>
       <?php }?>
        <p><?=  substr(strip_tags($post['post']), 0, 200).'...';?></p>
        <p><a href="<?=  base_url()?>index.php/blog/post/<?=$post['post_id']?>">Read More</a></p>

<div align="center">
<?php 
 //$sp=base_url();
 //$sp.="index.php/blog/post/";
 $sp ='post/'.$post['post_id'];
 $ShareUrl = urlencode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]$sp");
 $Title = 'Share content URL in social media using PHP';
 $Media = '<?php echo base_url(); ?>public/img/logos/quantum-logo-big.png';
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
<img src="<?=  base_url()?>public/images/linkedin.gif" title="share in linkexdin" height=30px width=30px>
</a>


</div>


    <?php
    }?>
    <?=$pages?>
    </div>
</div>



<script type="text/javascript" async >
	function shareinsocialmedia(url){
	window.open(url,'sharein','toolbar=0,status=0,width=648,height=395');
	return true;
	}
</script>

