<div id="sidebar_container">
    <img class="paperclip" src="<?=  base_url()?>public/images/paperclip.png" alt="paperclip" />
	<div class="sidebar">
		<h3>Search:</h3>
		<form method="get" action="<?= base_url() ?>index.php/applog/search" id="search">
			<p style="padding: 0 0 9px 0;"><input class="search" type="date" name="query" placeholder="Start Date"/></p>
			<p style="padding: 0 0 9px 0;"><input class="search" type="date" name="query2" placeholder="End Date"/></p>
			<p><a class="subscribe" href="javascript:void(0);" onclick="$('#search').submit();" >Find</a></p>
		</form>
	</div>
    
    <img class="paperclip" src="<?=  base_url()?>public/images/paperclip.png" alt="paperclip" />
    <div class="sidebar">
        <h3>Go to</h3>
        	<a href=''>Daily</a><br>
        	<a href=''>All Data</a>
    </div>
</div>
