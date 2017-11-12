<?php
//ini_set("display_errors", "1");
//error_reporting(E_ALL);
global $vosl_admin_classes_dir;

require_once $vosl_admin_classes_dir . '/vosl-locator-admin.php';
$vosl_locator_admin = new VoStoreLocator_Admin();

if(isset($_POST['btnSubmit']))
{
	$vosl_locator_admin->save_admin_settings($_POST);
}

$location_value = vosl_data('sl_location_map');
$location_current = vosl_data('sl_current_location_lookup');
$enable_default_tags = vosl_data('vosl_enable_default_tags');
$vosl_show_love = vosl_data('vosl_show_love');
$vosl_map_region = vosl_data('vosl_map_region');
$vosl_map_api_key = vosl_data('vosl_map_api_key');
$kmmiles = vosl_data('vosl_km');
$enable_default_cluster = vosl_data("vosl_enable_default_cluster");
$vosl_custom_font = vosl_data("vosl_custom_font");
$fonts = $vosl_locator_admin->vosl_get_all_fonts();
uasort($fonts,  function($a, $b) { return strcasecmp($a["name"], $b["name"]); });

$vosl_custom_map_popup_width = vosl_data("vosl_custom_map_popup_width");
$vosl_custom_map_popup_bgcolor = vosl_data("vosl_custom_map_popup_bgcolor");
$vosl_custom_map_marker_color = vosl_data("vosl_custom_map_marker_color");
$vosl_custom_map_popup_textcolor = vosl_data("vosl_custom_map_popup_textcolor");
$vosl_custom_map_popup_bgcolor = (empty($vosl_custom_map_popup_bgcolor)?"#FFFFFF":$vosl_custom_map_popup_bgcolor);
$vosl_custom_map_popup_width = (empty($vosl_custom_map_popup_width)?420:$vosl_custom_map_popup_width);
$vosl_custom_map_popup_textcolor = (empty($vosl_custom_map_popup_textcolor)?"#000000":$vosl_custom_map_popup_textcolor);

if($enable_default_cluster=='')
	$enable_default_cluster = 1;

if($kmmiles=='')
{
	$kmmiles = 'mi';
}
	
if($vosl_show_love=='')
	$vosl_show_love = 1;	

if($location_value=='')
	$location_value = 1;
	
if(vosl_data('sl_find_location_text')=='')
	$location_text = '';
else
	$location_text = vosl_data('sl_find_location_text');	
	
if(vosl_data('vosl_tags_filter_label')=='')
	$vosl_tags_filter_label = '';
else
	$vosl_tags_filter_label = vosl_data('vosl_tags_filter_label');	
	
if(vosl_data('sl_highlight_color')=='')
	$vosl_highlight_color = '#3DA1D9';
else
	$vosl_highlight_color = vosl_data('sl_highlight_color');
	
if(vosl_data('sl_highlight_text_color')=='')
	$vosl_highlight_text_color = '#000000';
else
	$vosl_highlight_text_color = vosl_data('sl_highlight_text_color');		
	
if(vosl_data('sl_listing_bg_color')=='')
	$vosl_listing_bg_color = '#FFFFFF';
else
	$vosl_listing_bg_color = vosl_data('sl_listing_bg_color');		
	
if(vosl_data('sl_listing_bg_color')=='')
	$vosl_listing_bg_color = '#FFFFFF';
else
	$vosl_listing_bg_color = vosl_data('sl_listing_bg_color');				

include(VOSL_INCLUDES_PATH."/countries-regions.php");
?>
<style type="text/css">
.vosl-menu-documentation{ display:none; }
.form-table th{ width:210px; }
/*Options Settings*/
.vosl-menu-ui{ display:none; }
.vosl_map_stats{ clear:both; display:inline-block; margin:10px 0; }
.vosl_map_stats div{ margin-bottom:5px;}
#vosl_sample_preview{ display:inline-block; font-size:20px; }
/*Options Settings*/
</style>
<div class="wrap">

<div class="icon32" id="icon-options-general"><br></div><h2><?php echo __("VO Locator Settings", VOSL_TEXT_DOMAIN); ?></h2>
<div style="width:100%;float:left">
<h2 class="nav-tab-wrapper vosladmintab">
    <a href="#general" id="vosl-menu-general" class="nav-tab nav-tab-active"><?php echo __('General',VOSL_TEXT_DOMAIN); ?></a>
    <?php // removed and added functinality in free version
		  //do_action('vosl_tabs'); ?>
    <a href="#ui" id="vosl-menu-ui" class="nav-tab"><?php echo __('User Interface',VOSL_TEXT_DOMAIN); ?></a>      
    <a href="#documentation" id="vosl-menu-documentation" class="nav-tab"><?php echo __('Documentation',VOSL_TEXT_DOMAIN); ?></a>
</h2>
<form method="post">

<div class="vosl-menu-general vosl-settings-menu-group">
<table class="form-table" style="width:750px; display:inline-block;">
<tbody>
<tr valign="top">
<th scope="row"><?php echo __("Google Maps API Key", VOSL_TEXT_DOMAIN); ?></th>
<td>
<input type="text" value="<?php echo esc_html($vosl_map_api_key);?>" id="vosl_map_api_key" name="vosl_map_api_key" style="width:350px;" />
<span class="description" style="display:block;"><a href="http://www.vitalorganizer.com/vo-locator-documentation/#mapapi" target="_blank"><?php echo __("Show me how", VOSL_TEXT_DOMAIN); ?></a></span>
</fieldset></td>
</tr>
<tr valign="top">
<th scope="row"><?php echo __("Show some love", VOSL_TEXT_DOMAIN); ?></th>
<td> <fieldset><legend class="screen-reader-text"><span></span></legend><label for="users_can_register">
<input type="checkbox" value="1" id="vosl_show_love" name="vosl_show_love" <?php if($vosl_show_love==1){ ?> checked="checked" <?php } ?>>
<?php echo __("Enable branding on front-end", VOSL_TEXT_DOMAIN); ?></label>
</fieldset></td>
</tr>
<tr valign="top">
<th scope="row"><?php echo __("Show Map", VOSL_TEXT_DOMAIN); ?></th>
<td> <fieldset><legend class="screen-reader-text"><span><?php echo __("Show Location with Map", VOSL_TEXT_DOMAIN); ?></span></legend><label for="users_can_register">
<input type="checkbox" value="1" id="location_map" name="location_map" <?php if($location_value==1){ ?> checked="checked" <?php } ?>>
<?php echo __("Enable showing Map with listing", VOSL_TEXT_DOMAIN); ?></label>
</fieldset></td>
</tr>
<?php /*?><tr valign="top">
<th scope="row"><?php echo __("Current Location", VOSL_TEXT_DOMAIN); ?></th>
<td> <fieldset><legend class="screen-reader-text"><span><?php echo __("Enable Current Location Lookup on Load", VOSL_TEXT_DOMAIN); ?>?</span></legend><label for="users_can_register">
<input type="checkbox" value="1" id="find_current_location_lookup" name="find_current_location_lookup" <?php if($location_current==1){ ?> checked="checked" <?php } ?>>
<?php echo __("Enable Current Location Lookup on Load (Default Center)", VOSL_TEXT_DOMAIN); ?></label>
</fieldset></td>
</tr><?php */?>
<tr valign="top">
<th scope="row"><?php echo __("Show Tags", VOSL_TEXT_DOMAIN); ?></th>
<td> <fieldset><legend class="screen-reader-text"><span><?php echo __("Enable Current Location Lookup on Load", VOSL_TEXT_DOMAIN); ?>?</span></legend><label for="users_can_register">
<input type="checkbox" value="1" id="enable_default_tags" name="enable_default_tags" <?php if($enable_default_tags==1){ ?> checked="checked" <?php } ?>>
<?php echo __("Enable filtering by tags.", VOSL_TEXT_DOMAIN); ?></label>
</fieldset></td>
</tr>

        <tr valign="top">
            <th scope="row"><?php echo __("Enable Marker Clusterer", VOSL_TEXT_DOMAIN); ?></th>
            <td> <fieldset><legend class="screen-reader-text"><span></span></legend><label for="users_can_register">
            <input type="checkbox" value="1" id="enable_default_cluster" name="enable_default_cluster" <?php if($enable_default_cluster==1){ ?> checked="checked" <?php } ?>>
            <?php echo __("Enable marker clusterer on the map.", VOSL_TEXT_DOMAIN); ?></label>
            </fieldset></td>
        </tr>
        
        <?php if(!empty($fonts)){
		?>
        
         <tr valign="top">
            <th scope="row"><?php echo __("Custom Font", VOSL_TEXT_DOMAIN); ?></th>
            <td>
            <select name="vosl_custom_font" id="vosl_custom_font_settings">
                <option value="">Default Font</option>	
                <?php foreach($fonts as $key => $value){ $url = '';
				
				if($value['font_type']=='google')
					$url = $value['urls']['regular'];
				
				$full_name = $value['name']."::".$url;
				 ?>
                    <option value="<?php echo $value['name']."::".$url; ?>" <?php if($vosl_custom_font==$full_name){ ?> selected="selected" <?php } ?>><?php echo $value['name']; ?></option>	
                <?php } ?>
            </select>
            &nbsp;&nbsp;<div id="vosl_sample_preview"><?php echo __("Sample Preview Text", VOSL_TEXT_DOMAIN); ?></div>
            </td>
        </tr>
        <?php
		} 
?>
<tr valign="top">
    <th scope="row"><?php echo __("Marker InfoWindow Width", VOSL_TEXT_DOMAIN); ?></th>
    <td><input type="text" style="width:50px;" value="<?php echo esc_html($vosl_custom_map_popup_width);?>" id="vosl_custom_map_popup_width" name="vosl_custom_map_popup_width" />&nbsp;<?php echo __("Pixels", VOSL_TEXT_DOMAIN); ?></td>
</tr>

<tr valign="top">
    <th scope="row"><?php echo __("Marker InfoWindow Background", VOSL_TEXT_DOMAIN); ?></th>
    <td>
    <input type="text" value="<?php echo esc_html($vosl_custom_map_popup_bgcolor);?>" id="vosl_custom_map_popup_bgcolor_settings" name="vosl_custom_map_popup_bgcolor" />
    </fieldset></td>
</tr>

<tr valign="top">
    <th scope="row"><?php echo __("Marker InfoWindow Text Color", VOSL_TEXT_DOMAIN); ?></th>
    <td>
    <input type="text" value="<?php echo esc_html($vosl_custom_map_popup_textcolor);?>" id="vosl_custom_map_popup_text_color_settings" name="vosl_custom_map_popup_textcolor" />
    </fieldset></td>
</tr>

<tr valign="top">
    <th scope="row"><?php echo __("Map Marker Color", VOSL_TEXT_DOMAIN); ?></th>
    <td>
    <input type="text" value="<?php echo esc_html($vosl_custom_map_marker_color);?>" id="vosl_custom_map_marker_color_settings" name="vosl_custom_map_marker_color" />
    </fieldset></td>
</tr>
        
<tr valign="top">
<th scope="row"><?php echo __("Tags Filter Label", VOSL_TEXT_DOMAIN); ?></th>
<td>
<input type="text" value="<?php echo esc_html($vosl_tags_filter_label);?>" id="vosl_tags_filter_label" name="vosl_tags_filter_label" />
</fieldset></td>
</tr>
<tr valign="top">
<th scope="row"><?php echo __("Search Box Heading Text", VOSL_TEXT_DOMAIN); ?></th>
<td>
<?php

// removed in version 1.3 as request came for removing label if not required
/*if(vosl_data('sl_find_location_text')=='')
	$text = 'Find a Location';
else
	$text = vosl_data('sl_find_location_text');	*/
	
?>
<input type="text" value="<?php echo esc_html($location_text);?>" id="fndLocationText" name="fndLocationText" />
</fieldset></td>
</tr>
<tr valign="top">
<th scope="row"><?php echo __("Listing Highlight Color", VOSL_TEXT_DOMAIN); ?></th>
<td>
<input type="text" value="<?php echo esc_html($vosl_highlight_color);?>" id="color-field" name="color-field" />
</fieldset></td>
</tr>
<tr valign="top">
<th scope="row"><?php echo __("Listing Text Color", VOSL_TEXT_DOMAIN); ?></th>
<td>
<input type="text" value="<?php echo esc_html($vosl_highlight_text_color);?>" id="color-field-text" name="color-field-text" />
</fieldset></td>
</tr>
<tr valign="top">
<th scope="row"><?php echo __("Listing background Color", VOSL_TEXT_DOMAIN); ?></th>
<td>
<input type="text" value="<?php echo esc_html($vosl_listing_bg_color);?>" id="color-field-text-bg" name="color-field-text-bg" />
</fieldset></td>
</tr>
<tr valign="top">
<th scope="row"><?php echo __("Distance in (Mi/Km)", VOSL_TEXT_DOMAIN); ?></th>
<td>
<select name="selMiles">
	<option value="mi" <?php if($kmmiles=='mi'){ ?> selected="selected" <?php } ?>><?php echo __("Miles", VOSL_TEXT_DOMAIN); ?></option>
	<option value="km" <?php if($kmmiles=='km'){ ?> selected="selected" <?php } ?>><?php echo __("Kilometers", VOSL_TEXT_DOMAIN); ?></option>
</select>
</fieldset></td>
</tr>

<tr valign="top">
<th scope="row"><?php echo __("Region", VOSL_TEXT_DOMAIN); ?></th>
<td>
<select name='map_region'>
<?php 
foreach ($tld as $key=>$value) {
	$selected=($vosl_map_region==$value)?" selected " : "";
	$your_location_select.="<option value='$key:{$the_domain[$key]}:$value' $selected>$key</option>\n";
}
echo $your_location_select;
?></select>
</fieldset></td>
</tr>
</tbody></table>
   
<?php if (!defined('VOSLP_VERSION')) { ?>    
<table style="width: 350px; display: inline-block; vertical-align: top;margin: 20px;border: 1px solid #cccccc;"  border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td bgcolor="#FFFFFF" style="color:#008EC2;"><div align="center" style="font-size:14px; font-weight:bold;"><?php echo __("Need More Customizations?", VOSL_TEXT_DOMAIN); ?></div></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" style="color:#008EC2;">
      <ul style="list-style:disc; margin-left:20px; color:#444; margin-top:0px;">
      <li><?php echo __("Import/Export Listings", VOSL_TEXT_DOMAIN); ?></div></li>
      <?php /*?><li><?php echo __("Full Map Customization with Drag and Drop Interface", VOSL_TEXT_DOMAIN); ?></li>
      <li><?php echo __("Too Many Markers! Get Cleaner Map with Marker Clusters with Improved Performance", VOSL_TEXT_DOMAIN); ?></li><?php */?>
      <li><?php echo __("Update Multiple Listing Co-Ordinates in a Single Click", VOSL_TEXT_DOMAIN); ?></li>
      <li><?php echo __("Make customized instances that can be used on different pages", VOSL_TEXT_DOMAIN); ?></li>
      </ul>
    <p align="center"><a href="http://www.vitalorganizer.com/product/vo-store-locator-pro-add-on?utm_source=plugin&amp;utm_medium=pluginUI&amp;utm_campaign=settings" target="_blank"><?php echo __("Grab Your PRO ADDON Now", VOSL_TEXT_DOMAIN); ?></a></p></td>
  </tr>
</table>
<?php } ?>
</div>

<div style="width:100%;float:left;padding-left:10px" class="vosl-menu-documentation vosl-settings-menu-group">
<?php /*?><h2><?php echo __("Documentation", VOSL_TEXT_DOMAIN); ?></h2><?php */?>
<p><?php echo __("To use this plugin within pages and posts you simply will have to insert this shortcode", VOSL_TEXT_DOMAIN); ?> [VO-LOCATOR] <?php echo __("within your post/page content", VOSL_TEXT_DOMAIN); ?></p>
<p><?php echo __("If you need to use this plugin in php code you will need to call php function as belows:", VOSL_TEXT_DOMAIN); ?></p>
<p><strong>
if(function_exists("volocator_func"))<br />
{<br />
echo volocator_func();<br />
}</strong>
</p>
<p><?php echo __("Or else you can do as follows:", VOSL_TEXT_DOMAIN); ?></p><strong>
<p>echo do_shortcode( '[VO-LOCATOR]' ); </p></strong>
<p><?php echo __("For more information please visit our website:", VOSL_TEXT_DOMAIN); ?> <a href="http://www.vitalorganizer.com/vo-locator-wordpress-store-locator-plugin/" target="_blank"><?php echo __("Click Here", VOSL_TEXT_DOMAIN); ?></a>&nbsp;|&nbsp;<a href="http://www.vitalorganizer.com/vo-locator-documentation/" target="_blank"><?php echo __("Documentation", VOSL_TEXT_DOMAIN); ?></a>&nbsp;|&nbsp;<a href="http://www.vitalorganizer.com/product/vo-store-locator-pro-add-on?utm_source=plugin&amp;utm_medium=pluginUI&amp;utm_campaign=settings" target="_blank"><?php echo __("Get VO Locator PRO", VOSL_TEXT_DOMAIN); ?></a></p>
<p><a href="https://wordpress.org/support/plugin/vo-locator-the-wp-store-locator"><?php echo __("Ask for Support", VOSL_TEXT_DOMAIN); ?></a>&nbsp;|&nbsp;<a href="https://wordpress.org/support/view/plugin-reviews/vo-locator-the-wp-store-locator"><?php echo __("Review Us", VOSL_TEXT_DOMAIN); ?></a></p>
</div>

<?php //do_action('vosl_tabs_content');
	  $vosl_locator_admin->vosl_show_tabscontent();
 ?>

<p class="submit"><input type="submit" value="<?php echo __("Save Changes", VOSL_TEXT_DOMAIN); ?>" class="button button-primary" id="submit" name="btnSubmit"></p></form>
</div>

</div>