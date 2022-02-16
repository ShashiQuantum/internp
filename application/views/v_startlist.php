<div id="site_content">
    <?php include 'sidebar_startlist.php' ?>
    <div id="content">
        <?php if($this->session->userdata('user_id') && $this->session->userdata('user_type') != 'user')
        { ?>
        <h2><a style="color: green" href="<?=  base_url()?>index.php/startlist/"><span class="glyphicon glyphicon-pencil"></span> Create a new post</a></h2>
        <?php } ?>
    <!-- insert the page content here -->
   <center>
    <table border=0>
    <tr><td>Resp_id</td><td>Message</td></tr>
    
     <?php 
     if($posts)
    foreach($posts as $p)
    {    $r=$p;
    	//$dt=$p->start_time;
    
    ?>
    <tr><td><?= $r; ?></td><td> inserted sucessfully</td></tr>
        
    <?php
    }
    if(empty($posts)) echo "<font color=red>No data Pending for this date</font>";
    ?>
    
    </table>
    </center>
    </div>
</div>
