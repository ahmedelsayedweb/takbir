<?php
if (!empty($_GET['pg']) && isset($wpdb) && $_GET['pg']=='add-locations') { /*include_once(SL_INCLUDES_PATH."/top-nav.php"); */}

if (!defined("VOSL_INCLUDES_PATH")) { include("../vosl-define.php"); }
echo  $view_link;
print "<div class='wrap'>";

global $wpdb;

$tags_output = apply_filters( 'vosl_populate_tags_dropdown', array(), 0);

//Inserting addresses by manual input
if (!empty($_POST['store_name']) && (empty($_GET['mode']) || $_GET['mode']!="pca")) {
	if (!empty($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], "add-location_single")){
		vosl_add_location();
		print "<div class='sl_admin_success'>".__("Successful Addition",VOSL_TEXT_DOMAIN).". <a href='admin.php?page=".VOSL_PAGES_DIR."/locations.php"."'>".__("Manage Locations", $text_domain)."</a> <script>setTimeout(function(){jQuery('.sl_admin_success').fadeOut('slow');}, 6000);</script></div> <!--meta http-equiv='refresh' content='0'-->"; 
	} else {
		print "<div class='sl_admin_warning'>".__("Unsucessful addition due to security check failure",VOSL_TEXT_DOMAIN).". $view_link</div>"; 
	}
}
?>

<table cellpadding='' cellspacing='0' style='width:100%' class='manual_add_table'><tr>
<td style=' padding-top:0px; width:50%' valign='top'>

<form name='manualAddForm' method='post' id='locationForm'>
	
	<table cellpadding='0' class='widefat'>
	<thead><tr><th><?=__("Add Listing", VOSL_TEXT_DOMAIN)?></th></tr></thead>
	<tr>
		<td style="vertical-align:top !important; width:40%">
		
		<span id='format' style='display:none'><i><?=__("Name of Listing", VOSL_TEXT_DOMAIN)?><br>
		<?=__("Address (Street - Line1)", VOSL_TEXT_DOMAIN)?><br>
		<?=__("Address (Street - Line2 - optional)", VOSL_TEXT_DOMAIN)?><br>
		<?=__("City, State Zip", VOSL_TEXT_DOMAIN)?></i></span>
		<?=__("Name of Listing", VOSL_TEXT_DOMAIN)?><br><input name='store_name' size=50 type='text'><br><br>
		<?=__("Address", VOSL_TEXT_DOMAIN)?><br><input name='address' size=35 type='text'>&nbsp;<small>(<?=__("Street - Line1", VOSL_TEXT_DOMAIN)?>)</small><br>
		<input name='address2' size=35 type='text'>&nbsp;<small>(<?=__("Street - Line 2 - optional", VOSL_TEXT_DOMAIN)?>)</small><br>
		<table cellpadding='0px' cellspacing='0px'><tr><td style='padding-left:0px' class='nobottom'><input name='city' size='20' type='text'><br><small><?=__("City", VOSL_TEXT_DOMAIN)?></small></td>
		<td><input name='state' size='20' type='text'><br><small><?=__("State", VOSL_TEXT_DOMAIN)?></small></td>
		<td><input name='zip' size='10' type='text'><br><small><?=__("Zip", VOSL_TEXT_DOMAIN)?></small></td></tr>
		<tr><td style='padding-left:0px' class='nobottom'>
		<input name='show_address_publicly' type='checkbox' value='1' checked='checked' >&nbsp;<small><?=__("Share Address Publicly", VOSL_TEXT_DOMAIN)?></small></td></tr>
        <?php do_action('vosl_show_custom_marker_icon_field',0); ?>
		</table><br>
		
        <td style="vertical-align:top !important; width:60%">
		<?=__("Additional Information", VOSL_TEXT_DOMAIN)?><br>
		<textarea name='description' rows='5' cols='50'></textarea>&nbsp;<small><?=__("Description", VOSL_TEXT_DOMAIN)?></small><br>
		<input name='url' type='text' size='35'>&nbsp;<small><?=__("URL", VOSL_TEXT_DOMAIN)?></small><br>
		<input name='phone' type='text' size='35'>&nbsp;<small><?=__("Phone", VOSL_TEXT_DOMAIN)?></small><br>
		<input name='fax' type='text' size='35'>&nbsp;<small><?=__("Fax", VOSL_TEXT_DOMAIN)?></small><br>
		<input name='email' type='text' size='35'>&nbsp;<small><?=__("Email", VOSL_TEXT_DOMAIN)?></small><br>
		<input id='upload_image' type='text' name='image' size='35'>&nbsp;<small><?=__("Image URL (shown with location)", VOSL_TEXT_DOMAIN)?></small>&nbsp;<input type='button' value='<?=__("Image Upload", VOSL_TEXT_DOMAIN)?>' id='upload_image_button' class='button' /><br>
		<input name='hours' type='text' size='35'>&nbsp;<small><?=__("Hours", VOSL_TEXT_DOMAIN)?></small><br />
		<?=$tags_output?>
		<?php /*?><input name='default_map_center' type='checkbox' value='1'>&nbsp;<?=__("Default Map Center <small>(Set one profile as your default map center to center the map on this location when it first loads. If no default is set, the first location will be used as the default.)", VOSL_TEXT_DOMAIN);?></small><?php */?>
		
		
		<?=wp_nonce_field("add-location_single", "_wpnonce", true, false);?>
		<br><br><?php $cancel_onclick = "location.href=\"admin.php?page=".VOSL_PAGES_DIR."/locations.php"."\""; ?>
	<input type='submit' value='<?=__("Add Listing", VOSL_TEXT_DOMAIN)?>' class='button-primary'>&nbsp;&nbsp;<input type='button' class='button' value='<?php echo __("Cancel", VOSL_TEXT_DOMAIN); ?>' onclick='<?=$cancel_onclick?>'>
	</td>
	</td>
		</tr>
	</table>
</form>
</td>
</tr>
</table>
</div>