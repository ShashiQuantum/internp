<div id="sidebar_container">
    <img class="paperclip" src="<?=  base_url()?>public/images/paperclip.png" alt="paperclip" />
	<div class="sidebar">
		<h3>Daily Search:</h3>
		<form method="get" action="<?= base_url() ?>index.php/startlist/do_start" id="search">
			<p style="padding: 0 0 9px 0;"><input class="search" type="date" name="query" placeholder=" Date"/></p>
			
			<p><a class="subscribe" href="javascript:void(0);" onclick="$('#search').submit();" >Initiate App Log Report-1</a></p>
		</form>
	</div>
  
        <h3>Go to</h3>
        	<a href='index.php/startlist/do_eventrpt'>Generate Event Report-2</a><br>
        	<a href='index.php/startlist'> HOME </a>
                <a href='index.php/startlist/report'>Report</a>
</div>

