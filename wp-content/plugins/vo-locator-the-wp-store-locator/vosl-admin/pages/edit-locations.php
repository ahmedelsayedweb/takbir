<?php
if (!empty($_GET['pg']) && isset($wpdb) && $_GET['pg']=='add-locations') { /*include_once(SL_INCLUDES_PATH."/top-nav.php"); */}

if (!defined("VOSL_INCLUDES_PATH")) { include("../vosl-define.php"); }

global $wpdb;
$location_id = $_REQUEST['id'];
global $vosl_hooks, $wpdb;

require_once(VOSL_ACTIONS_PATH."/processLocationData.php");

$value=$wpdb->get_row("SELECT * FROM ".VOSL_TABLE." WHERE id = ".$location_id, ARRAY_A);

$rows_tag = $wpdb->get_results( $wpdb->prepare( "SELECT tag_id FROM ".VOSL_TAGS_ASSOC_TABLE." WHERE store_id = %d ",(int)$location_id ), ARRAY_A );

$tags_selected = array();

foreach($rows_tag as $tag)
{
	$tags_selected[] = $tag['tag_id'];
}
//$enable_default_tags = vosl_data('vosl_enable_default_tags');
	
///if($enable_default_tags)	
$tags_output = apply_filters( 'vosl_populate_tags_dropdown',$tags_selected, (int)$location_id);
?>
<div class='wrap'>
<table cellpadding='' cellspacing='0' style='width:100%' class='manual_edit_table'><tr>
<td style='padding-top:0px; width:50%' valign='top'>

<tr id='sl_tr_data-<?=$location_id?>'>
	
	<?php if($value['show_address_publicly']==1)
			$show_directions = ' checked="checked" ';
			
	/*if($value['default_map_center']==1)
			$default_map_center = ' checked="checked" ';*/ ?>		
			
	<td><form name='manualAddForm' id='locationForm' method=post>
    <input type="hidden" name="act" id="act" value="voslupdatelocation" />
    <input type="hidden" name="vosl_location_id" id="vosl_location_id" value="<?=$location_id?>" />
	<table cellpadding='0' class='widefat'>
    <thead><tr><th><?=__("Edit Listing", VOSL_TEXT_DOMAIN)?></th></tr></thead>
	<tr>
		<td style='vertical-align:top !important; width:40%'><b><?php echo __("Name of Listing", VOSL_TEXT_DOMAIN); ?></b><br><input name='store_name-<?=$location_id?>' id='store-<?=$location_id?>' value='<?=$value['store_name']?>' size=50 type='text'><br><br>
		<b><?php echo __("Address", VOSL_TEXT_DOMAIN); ?></b><br><input name='address-<?=$value['id']?>' id='address-<?=$value['id']?>' value='<?=$value['address']?>' size='35' type='text'>&nbsp;<small>("<?php echo __("Street - Line1", VOSL_TEXT_DOMAIN); ?> ")</small><br>
		<input name='address2-<?=$value['id']?>' id='address2-<?=$value['id']?>' value='<?=$value['address2']?>' size='35' type='text'>&nbsp;<small>("<?php echo __("Street - Line 2 - optional", VOSL_TEXT_DOMAIN); ?>")</small><br>
		<table cellpadding='0px' cellspacing='0px'><tr><td style='padding-left:0px' class='nobottom'><input name='city-<?=$value['id']?>' id='city-<?=$value['id']?>' value='<?=$value['city']?>' size='20' type='text'><br><small><?php echo __("City", VOSL_TEXT_DOMAIN); ?></small></td>
		<td><input name='state-<?=$value['id']?>' id='state-<?=$value['id']?>' value='<?=$value['state']?>' size='20' type='text'><br><small><?php echo __("State", VOSL_TEXT_DOMAIN); ?></small></td>
		<td><input name='zip-<?=$value['id']?>' id='zip-<?=$value['id']?>' value='<?=$value['zip']?>' size='6' type='text'><br><small><?php echo __("Zip", VOSL_TEXT_DOMAIN); ?></small>
		</td></tr>
		<tr><td style='padding-left:0px; padding-top:20px;' class='nobottom'><input name='show_address_publicly-<?=$value['id']?>' <?=$show_directions?> id='show_address_publicly-<?=$value['id']?>' value='1' type='checkbox'>&nbsp;<small><?php echo __("Share Address Publicly", VOSL_TEXT_DOMAIN); ?></small></td></tr>
        <?php do_action('vosl_show_custom_marker_icon_field',$location_id); ?>
        </table>
		
		
		</td><td style='width:60%; vertical-align:top !important;'>
		<b><?php echo __("Additional Information", VOSL_TEXT_DOMAIN); ?></b><br>
		<textarea name='description-<?=$value['id']?>' id='description-<?=$value['id']?>' rows='5' cols='50'><?=$value['description']?></textarea>&nbsp;<small><?=__("Description", VOSL_TEXT_DOMAIN)?></small><br>		
		<input name='url-<?=$value['id']?>' id='url-<?=$value['id']?>' value='<?=$value['url']?>' size='35' type='text'>&nbsp;<small><?php echo __("URL", VOSL_TEXT_DOMAIN); ?></small><br>
		<input name='phone-<?=$value['id']?>' id='phone-<?=$value['id']?>' value='<?=$value['phone']?>' size='35' type='text'>&nbsp;<small><?php echo __("Phone", VOSL_TEXT_DOMAIN); ?></small><br>
		<input name='fax-<?=$value['id']?>' id='fax-<?=$value['id']?>' value='<?=$value['fax']?>' size='35' type='text'>&nbsp;<small><?php echo __("Fax", VOSL_TEXT_DOMAIN); ?></small><br>
		<input name='email-<?=$value['id']?>' id='email-<?=$value['id']?>' value='<?=$value['email']?>' size='35' type='text'>&nbsp;<small><?php echo __("Email", VOSL_TEXT_DOMAIN); ?></small><br>
		<input id='upload_image' name='image-<?=$value['id']?>' id='image-<?=$value['id']?>' value='<?=$value['image']?>' size='35' type='text'>&nbsp;<small><?php echo __("Image URL (shown with location)", VOSL_TEXT_DOMAIN); ?></small>&nbsp;<input type='button' value='<?=__("Image Upload", VOSL_TEXT_DOMAIN);?>' class='button' id='upload_image_button' /><br /><input name='hours-<?=$value['id']?>' id='hours-<?=$value['id']?>'  type='text' value='<?=$value['hours']?>' size='35'>&nbsp;<small><?=__("Hours", VOSL_TEXT_DOMAIN);?></small><br /><?=$tags_output;?><?php /*?><input name='default_map_center-<?=$value['id']?>'  <?=$default_map_center?>  id='default_map_center-<?=$value['id']?>' value='1' type='checkbox'>&nbsp;<?=__("Default Map Center <small>(Set one profile as your default map center to center the map on this location when it first loads. If no default is set, the first location will be used as the default.)", VOSL_TEXT_DOMAIN);?></small><?php */?>
		
        <?php $cancel_onclick = "location.href=\"admin.php?page=".VOSL_PAGES_DIR.'/locations.php'."\"";
		
		$show_directions = ''; ?>
		
		<br><br>
		<nobr><input type='submit' value='<?php echo __("Update", VOSL_TEXT_DOMAIN); ?>' class='button-primary'>&nbsp;&nbsp;<input type='button' class='button' value='<?php echo __("Cancel", VOSL_TEXT_DOMAIN); ?>' onclick='<?=$cancel_onclick?>'></nobr>
        
		</td></tr>
	</table>
</form>
</td>
</tr>
</td>
<td style='padding-top:0px;' valign='top'>
</td>
</tr>
</table>
</div>