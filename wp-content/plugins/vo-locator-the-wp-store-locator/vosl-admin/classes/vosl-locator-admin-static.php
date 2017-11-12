<?php
class VoStoreLocator_AdminStatic
{
	public static function initHooks() {
        add_action( 'vosl_populate_tags_dropdown', array(__class__, 'vosl_populate_tags_dropdown_ui'), 50, 2 );
	    add_action( 'vosl_associate_tags_listings', array(__class__, 'vosl_associate_tags_listings_ui'), 50, 2 );
		add_action( 'vosl_listing_custom_marker_icon', array(__class__, 'vosl_listing_custom_marker_icon'), 50, 2 );
		add_filter( 'vosl_filter_front_tags', array(__class__, 'vosl_filter_front_tags'), 50, 1 );
    }
	
	public static function vosl_filter_front_tags($tags)
	{
		if(!is_array($tags) and is_int($tags))
		{
			return " AND id IN (SELECT store_id FROM ".VOSL_TAGS_ASSOC_TABLE." WHERE tag_id = ".(int)$tags.") ";
		}
	}
	
	public static function vosl_listing_custom_marker_icon($listing_id)
	{
		global $wpdb;
		
		$vosl_custom_map_marker_color = vosl_data("vosl_custom_map_marker_color");
	
		// we only assign single tag in our free version, so check to see if their is marker color for tag
		$row = $wpdb->get_row( $wpdb->prepare( "SELECT t.tag_color FROM ".VOSL_TAGS_TABLE." t JOIN ".VOSL_TAGS_ASSOC_TABLE." tl ON (tl.tag_id = t.id) WHERE tl.store_id = %d ", $listing_id ), ARRAY_A );
		
		$output = array();
		$output['marker_color'] = '';
		
		if($vosl_custom_map_marker_color!='')
		{
			$output['marker_color'] = $vosl_custom_map_marker_color;
		}
		
		if($row['tag_color']!='')
		{
			$output['marker_color'] = $row['tag_color'];	
		}
		
		$output['marker_icon'] = '';
		return $output;
	}
	
	public static function reInitializeVoslMap()
	{
		$vosl_lat = '';
		$vosl_long = '';
		$vosl_map_zoom_level = '';
		
		$vosl_map_zoom_level = vosl_data('vosl_map_zoom_level');
		$vosl_map_size_width = vosl_data('vosl_map_size_width');
		$vosl_map_size_height = vosl_data('vosl_map_size_height');
		$vosl_listing_column_width = vosl_data('vosl_listing_column_width');
		$vosl_listing_column_height = vosl_data('vosl_listing_column_height');
		$vosl_map_custom_center = vosl_data('vosl_map_custom_center');
		$vosl_search_box_width = vosl_data('vosl_search_box_width');
		$current_location_lookup = vosl_data('sl_current_location_lookup');
		
		if($vosl_map_size_width=='')
			$vosl_map_size_width = 800;
			
		if($vosl_map_size_height=='')
			$vosl_map_size_height = 350;
			
		if($vosl_listing_column_width=='')
			$vosl_listing_column_width = 267;
			
		if($vosl_listing_column_height=='')
			$vosl_listing_column_height = 350;
			
		if($vosl_search_box_width=='')
			$vosl_search_box_width = 336;		
			
		if($vosl_map_zoom_level=='')
			$vosl_map_zoom_level = 4;
			
		$json = vosl_data('vosl_map_custom_center_coordinates');
		$json_array = json_decode($json, true);
		
		if(is_array($json_array) and !empty($json_array))
		{
			$vosl_lat = $json_array['lat'];
			$vosl_long = $json_array['long'];
		}
		
		if($current_location_lookup==1)
		{
			// default to null
			$vosl_lat = '';
			$vosl_long = '';
		}
		
		?>
        <script type="text/javascript">
		<?php if($vosl_lat!='' and $vosl_long!=''){ ?>
		var vosl_map_object = {"lat":"<?=$vosl_lat?>","long":"<?=$vosl_long?>"};
		<?php } ?>
		jQuery(document).ready( function($) {
			var map = jQuery("#map_placeholder").gmap3('get');
			var newLatLng = map.getCenter();
			
			<?php if($vosl_lat!='' and $vosl_long!=''){ ?>
				newLatLng = new google.maps.LatLng(parseFloat(vosl_map_object.lat), parseFloat(vosl_map_object.long));	
			<?php } ?>
			
			jQuery('#map_placeholder').gmap3({
			 map:{
				options:{
				 center:newLatLng,
				 zoom: parseInt(<?=$vosl_map_zoom_level?>),
				 mapTypeId: google.maps.MapTypeId.ROADMAP,
				 mapTypeControl: true,
				 mapTypeControlOptions: {
				   style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
				 },
				 navigationControl: true,
				 scrollwheel: true,
				 streetViewControl: true
				}
			 }
			});
        });
        </script>
        <style type="text/css">
        
		@media (min-width: 1025px) {
			#maplist .overflowscroll{ height: <?=$vosl_listing_column_height?>px !important;width: <?=$vosl_listing_column_width?>px !important; max-height: <?=$vosl_listing_column_height?>px !important; }
			.voslpmapcontainer{ height: <?=$vosl_map_size_height?>px !important;width: <?=$vosl_map_size_width?>px !important; }
			#map_placeholder{height: <?=$vosl_map_size_height?>px !important;width: <?=$vosl_map_size_width?>px !important;}
			.voslpsearch{ width: <?=$vosl_search_box_width?>px !important; }
		}
        </style>
        <?php
	}
	
    public static function vosl_populate_tags_dropdown_ui($tags = array(), $store_id)
	{
		global $wpdb;
		$rows = $wpdb->get_results( "SELECT id, tag_name FROM ".VOSL_TAGS_TABLE." order by tag_name", ARRAY_A );
		
		if($store_id > 0)
			$extra = '-'.$store_id;
		else
			$extra = '';		
		
		$html = '<select name="voslSelTags'.$extra.'">
			<option value="">--'.__("Select Tag", VOSL_TEXT_DOMAIN).'--</option>';
		foreach($rows as $row){ 
			
			$selected = '';
			
			if(!empty($tags) and in_array($row['id'],$tags))
			{
				$selected = ' selected="selected" ';
			}
		
			$html .= '<option value="'.$row['id'].'" '.$selected.'>'.$row['tag_name'].'</option>';
		 }     
		$html .= '</select>';
		
		return $html;
	}
	
	public static function vosl_associate_tags_listings_ui($store_id, $tag_id)
	{
		global $wpdb;
	
		$wpdb->query($wpdb->prepare("DELETE FROM ".VOSL_TAGS_ASSOC_TABLE." WHERE store_id=%d", (int)$store_id));
		if($tag_id > 0)
		{
			$q = $wpdb->prepare("INSERT INTO ".VOSL_TAGS_ASSOC_TABLE." (store_id, tag_id) VALUES (%d, %d)", $store_id, $tag_id); 
			$wpdb->query($q);
		}
	}
}
?>