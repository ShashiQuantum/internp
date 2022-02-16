<?php

include_once('../init.php');
include_once('../functions.php');


?>
<body>
<table cellpadding="10" cellspacing="5">
		<tr>
			<td><a href="md_dsr.php">Daily Audit Report</a></td>
                        <td><a href="md_dsr_map.php">Audit Report with Map</a></td>
			
			
		</tr></table>
<center>
<h2>Daily Audit Report with MAP</h2>
<table border=0>
<form action="" method=post>
<tr><td>Start Date </td><td><input type=date name=st> </td></tr>

<tr><td>End Date </td><td><input type=date name=et></td></tr>

<tr><td>Tablets </td><td><select name="tab" id="tab" ><option value="0">--All tabs--</option><?php  $pt=get_tabs(); if($pt) foreach($pt as $p){?><option value="<?php echo $p->tab_id; ?>"> <?php echo $p->tab_name;  ?></option> <?php } ?></select></tr>
<tr><td> <input type=radio name=wm value=1 checked>With Map </td><td><input type=radio name=wm value=2> Without Map</td></tr>
<tr><td></td><td><input type=submit name=b_report value=View> </td></tr>
</form>

</table>
</center>
<br><br>
<?php 
 

 if(isset($_POST['b_report']))
  {
        //print_r($_POST);
        $st=$_POST['st'];
        $et=$_POST['et'];
        $wm=$_POST['wm'];
        $tab=$_POST['tab'];

        if($st!='' && $et!='')
        {
           if($wm==1)
           {
             if($tab==0)
             $qq="SELECT `booth_id`, `tab_id`, `booth_address`, `sm_mob`, `aud_name`, `aud_mob`, `v_shift`, `centre`,  `i_date`, e_date, `qset_id`, `status`, `lattitude`, `longitude` FROM `mdbooth_details` WHERE substring(`i_date`,1,10) BETWEEN '$st' AND '$et'";
             if($tab>0)
             $qq="SELECT `booth_id`, `tab_id`, `booth_address`, `sm_mob`, `aud_name`, `aud_mob`, `v_shift`, `centre`,  `i_date`, e_date, `qset_id`, `status`, `lattitude`, `longitude` FROM `mdbooth_details` WHERE tab_id=$tab AND substring(`i_date`,1,10) BETWEEN '$st' AND '$et'";

             $dr=DB::getInstance()->query($qq);
             if($dr->count()>0)
             {  echo "<center><h2>Booth Audit MAP Report</h2><table border=1>";
                echo "<tr><td> booth_id</td><td>booth_address</td><td>auditor_name </td><td>auditor_mob</td><td>visit_shift</td><td>start_time</td><td>end_time</td><td>status</td><td>location</td></tr>";
                foreach($dr->results() as $r)
                {
                   $long=$r->longitude;
                   $lat=$r->lattitude;
                   $bid=$r->booth_id;

                  echo "<tr><td> $r->booth_id</td><td>$r->booth_address</td><td>$r->aud_name </td><td>$r->aud_mob</td><td>$r->v_shift</td><td>$r->i_date</td><td>$r->e_date</td><td>$r->status</td><td>"; 

?>

<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>
<div style="overflow:hidden;height:350px;width:250px;">
 <div id="gmap_canvas<?php echo $bid; ?>" style="height:350px;width:250px;">
 </div>
<style>#gmap_canvas img{max-width:none!important;background:none!important}</style>

</div>

<script type="text/javascript"> 
function init_map(){var myOptions = {zoom:15,center:new google.maps.LatLng(<?php echo $lat; ?>,<?php echo $long; ?>),mapTypeId: google.maps.MapTypeId.ROADMAP};
map = new google.maps.Map(document.getElementById("gmap_canvas<?php echo $bid; ?>"), myOptions);
marker = new google.maps.Marker({map: map,position: new google.maps.LatLng(<?php echo $lat; ?>, <?php echo $long; ?>)});

infowindow = new google.maps.InfoWindow({content:"<b>Field Location</b>" });
google.maps.event.addListener(marker, "click", function(){infowindow.open(map,marker);});
infowindow.open(map,marker);}
google.maps.event.addDomListener(window, 'load', init_map);
</script>
<?php
              echo "</td></tr>"; 
               }
                  echo "</table></center>";
                }
             }
             else 
                 {
                      if($tab==0)
                      $qq="SELECT `booth_id`, `tab_id`, `booth_address`, `sm_mob`, `aud_name`, `aud_mob`, `v_shift`, `centre`,  `i_date`, e_date, `qset_id`, `status`, `lattitude`, `longitude` FROM `mdbooth_details` WHERE substring(`i_date`,1,10) BETWEEN '$st' AND '$et'";
                      if($tab>0)
                      $qq="SELECT `booth_id`, `tab_id`, `booth_address`, `sm_mob`, `aud_name`, `aud_mob`, `v_shift`, `centre`,  `i_date`, e_date, `qset_id`, `status`, `lattitude`, `longitude` FROM `mdbooth_details` WHERE tab_id=$tab AND substring(`i_date`,1,10) BETWEEN '$st' AND '$et'";

             $dr=DB::getInstance()->query($qq);
             if($dr->count()>0)
             {  echo "<center><h2>Booth Audit Report</h2><table border=1>";
                echo "<tr><td> booth_id</td><td>booth_address</td><td>auditor_name </td><td>auditor_mob</td><td>visit_shift</td><td>start_time</td><td>end_time</td><td>status</td></tr>";
                foreach($dr->results() as $r)
                {
                   $long=$r->longitude;
                   $lat=$r->lattitude;
                   $bid=$r->booth_id;

                  echo "<tr><td> $r->booth_id</td><td>$r->booth_address</td><td>$r->aud_name </td><td>$r->aud_mob</td><td>$r->v_shift</td><td>$r->i_date</td><td>$r->e_date</td><td>$r->status</td></tr>"; 
                      }
                }
                      
                 }
              
        }        
  }
?>



</script>

 