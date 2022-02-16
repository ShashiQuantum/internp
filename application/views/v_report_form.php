<div id="sidebar_container">
    <img class="paperclip" src="<?=  base_url()?>public/images/paperclip.png" alt="paperclip" />
	<div class="sidebar">
		<h3>Search:</h3>
		<form method="get" action="<?= base_url() ?>index.php/startlist/do_report" id="search">
			<p style="padding: 0 0 9px 0;"><input class="search" type="date" name="query" placeholder="Start Date"/></p>
			<p style="padding: 0 0 9px 0;"><input class="search" type="date" name="query2" placeholder="End Date"/></p>
			<p><input type="submit" value="View Report"></p>
		</form>
	</div>
</div>

