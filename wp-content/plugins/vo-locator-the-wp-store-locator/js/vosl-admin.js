// JavaScript Document
jQuery(function() {
  // Handler for .ready() called.
	  initialize_vosl_admin_events();
	  vosl_load_selected_font_settings();
  // update co-ordination action button click
});

function initialize_vosl_admin_events()
{
	jQuery("#voslRedirectToTags").prev().hide();
	
	jQuery('#upload_image_button').click(function() {
		vosl_image_btn_id = jQuery('#upload_image').attr('id');
		tb_show('', 'media-upload.php?type=image&TB_iframe=true');
		return false;
	});
	
	window.send_to_editor = function(html) {	
		imgurl = jQuery("<div>" + html + "</div>").find('img').attr('src');
		jQuery('#'+vosl_image_btn_id).val(imgurl);
		
		if(typeof vosl_image_btn_id != 'undefined' && vosl_image_btn_id=='vosl_custom_listing_marker_icon')
		{
			// display image for pro addon
			vosl_display_custom_marker_icon_admin(imgurl);
			
		}else if(typeof vosl_image_btn_id != 'undefined' && vosl_image_btn_id=='vosl_bulk_update_marker_select')
		{
			vosl_bulk_update_marker_select(imgurl);
		}
		
		tb_remove();
	}

	jQuery('.nav-tab-wrapper .nav-tab').click(function(){
		el = jQuery(this);
		elid = el.attr('id');
		jQuery('.vosl-settings-menu-group').hide(); 
		jQuery('.'+elid).show();
	});
	jQuery('.nav-tab-wrapper .nav-tab').click(function(){
		jQuery('.nav-tab-wrapper .nav-tab').removeClass('nav-tab-active');
		jQuery(this).addClass('nav-tab-active');
	});
	
	jQuery('.vosladmintab .nav-tab').click(function(){
		voslResizeMapAdminSettings(); 
	});
	
	jQuery( "#vosl_listing_column_admin_settings" ).resizable({
	  resize: function( event, ui ) {
		 var height = Math.round(ui.size.height); 
		 var width = Math.round(ui.size.width);
		 jQuery("#vosl_listing_column_height").val(height);
		 jQuery("#vosl_listing_column_width").val(width);
		 jQuery("#vosl_listing_column_stats").html(width+"x"+height+" px");
	  }
	});
  
   jQuery( "#vosl_search_box_admin_settings" ).resizable({
	  handles: 'e',
	  resize: function( event, ui ) {
		 var height = Math.round(ui.size.height); 
		 var width = Math.round(ui.size.width);
		 jQuery("#vosl_search_box_height").val(height);
		 jQuery("#vosl_search_box_width").val(width);
		 jQuery("#vosl_search_box_stats").html(width+"x"+height+" px");
	  }
	});
	
	if(jQuery('#vosl_custom_map_popup_bgcolor_settings').length)
	 {
		  jQuery('#vosl_custom_map_popup_bgcolor_settings').wpColorPicker();
	 }
	  
	  if(jQuery('#vosl_custom_map_marker_color_settings').length)
	  {
		  jQuery('#vosl_custom_map_marker_color_settings').wpColorPicker();
	  }
	  
	  if(jQuery('#vosl_custom_map_popup_text_color_settings').length)
	  {
		  jQuery('#vosl_custom_map_popup_text_color_settings').wpColorPicker();
	  }
	  
	  if(jQuery('.vosl_marker_tag_color').length)
	 {
		  jQuery('.vosl_marker_tag_color').wpColorPicker();
	 }
	  
	  jQuery("#vosl_custom_font_settings").change(function () {
			vosl_load_selected_font_settings();
		});
		
	  jQuery( document ).on( "click", ".vosl_admin_listing_delete", function() {
		 		delete_vosl_listing(jQuery(this).attr("listing-id"));
				return false;
		});
		
		jQuery( document ).on( "click", ".vosl_admin_tags_listing_delete", function() {
		 		delete_vosl_tag(jQuery(this).attr("tag-id"));
				return false;
		});
		
		jQuery('#vosl_txtSearchText').keypress(function (e) {
		 var key = e.which;
		 if(key == 13)  // the enter key code
		  {
			vosl_listing_admin_table.search(jQuery("#vosl_txtSearchText").val()).draw() ;
			return false;  
		  }
		});  
		
		jQuery('#vosl_txtSearchTextTags').keypress(function (e) {
		 var key = e.which;
		 if(key == 13)  // the enter key code
		  {
			vosl_tags_admin_table.search(jQuery("#vosl_txtSearchTextTags").val()).draw() ;
			return false;  
		  }
		}); 
		
		jQuery( "#vosl_map_custom_center" ).keyup(function() {
		  if(jQuery( "#vosl_map_custom_center" ).val()=='')
		  {
			  jQuery( "#vosl_map_custom_center_lat" ).val('');
			  jQuery( "#vosl_map_custom_center_long" ).val('');
		  }
		});
		
		jQuery('input[type=radio][name=vosl_map_center_point_type]').change(function() {
			if (this.value == 1) {
				jQuery(".vosl_custom_center_point_container").hide();
			}
			else if (this.value == 0) {
				jQuery(".vosl_custom_center_point_container").show();
			}
		});
}

function delete_vosl_listing(listing_id)
{
	if(confirm("Do you want to delete this listing?"))
	{
		var data = {
				action: 'vosl_delete_listing',
				loc_id: listing_id
			};
			
		jQuery.post(vosl_admin_ajax_script_url.ajaxurl, data, function(response) {
			
			if(response!='' && response=='OK')
			{
				alert("Listing deleted successfully.");
				vosl_listing_admin_table.search(jQuery("#vosl_txtSearchText").val()).draw() ;
			}
	 	});
	}
}

function delete_vosl_tag(tag_id)
{
	if(confirm("Do you want to delete this tag?"))
	{
		var data = {
				action: 'vosl_delete_tag',
				tag_id: tag_id
			};
			
		jQuery.post(vosl_admin_ajax_script_url.ajaxurl, data, function(response) {
			
			if(response!='' && response=='OK')
			{
				alert("Tag deleted successfully.");
				vosl_tags_admin_table.search(jQuery("#vosl_txtSearchTextTags").val()).draw() ;
			}
	 	});
	}
}

function vosl_load_selected_font_settings()
{
	if(jQuery('#vosl_custom_font_settings').length)
	{
		var str = jQuery('#vosl_custom_font_settings').val();									   
		var res = str.split("::");				
		
		WebFont.load({
			google: {
			  families: [res[0]]
			}
		  });
		
		jQuery("#vosl_sample_preview").css("font-family", res[0]);
	}
}

function voslResizeMapAdminSettings()
{
	var m = jQuery("#map_placeholder_admin").gmap3('get');
	x = m.getZoom();
    c = m.getCenter();
    google.maps.event.trigger(m, 'resize');
    m.setZoom(x);
    m.setCenter(c);
}

function checkToSaveVoslListing()
{
	if(confirm("Do you want to save current listing before going to manage tags?"))
	{
		jQuery("#voslRedirectToTags").val('save');
		
	}else
	{
		jQuery("#voslRedirectToTags").val('nosave');
	}
	
	jQuery("#locationForm").submit();
}

function changeMapCenterAdminSettings() {
  // Get the place details from the autocomplete object.
  geocoder = new google.maps.Geocoder();
  
  geocoder.geocode( { 'address': jQuery("#vosl_map_custom_center").val()}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        //In this case it creates a marker, but you can get the lat and lng from the location.LatLng
		var map = jQuery('#map_placeholder_admin').gmap3("get");
        map.setCenter(results[0].geometry.location);
      } else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    });
}

function voslInitializeSettingsMapAdmin(latitude,longitude, zoom)
{
	var lat = parseFloat(latitude);
    var long = parseFloat(longitude);
    var newLatLng = new google.maps.LatLng(lat,long);
	
	if(latitude=='')
		newLatLng = new google.maps.LatLng(37.09024, -95.712891);
	
	var map = jQuery('#map_placeholder_admin').gmap3({
	 map:{
		options:{
		 center:newLatLng,
		 zoom:zoom,
		 mapTypeId: google.maps.MapTypeId.ROADMAP,
		 mapTypeControl: true,
		 mapTypeControlOptions: {
		   style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
		 },
		 navigationControl: true,
		 scrollwheel: false,
		 streetViewControl: false
		}
	 }
	});
	
	var map = jQuery('#map_placeholder_admin.voslmapsettingsholder').gmap3("get");
	
	map.addListener('center_changed', function() {										 
		  var c = map.getCenter();
		  var lat = c.lat();
		  var long = c.lng();
		  
		  jQuery("#vosl_map_custom_center_lat").val(lat);
		  jQuery("#vosl_map_custom_center_long").val(long);
	  });
	
	map.addListener('zoom_changed', function() {
		var vosl_zoom = map.getZoom();											 	
		jQuery("#vosl_map_zoom_level").val(vosl_zoom);
		jQuery(".vosl_map_stats .vosl_zoom_stats span").html(vosl_zoom);
  	});
	
	jQuery( "#map_placeholder_admin.voslmapsettingsholder" ).resizable({
	  resize: function( event, ui ) {
		 voslResizeMapAdminSettings();
		 var height = Math.round(ui.size.height); 
		 var width = Math.round(ui.size.width);
		 jQuery("#vosl_map_size_height").val(height);
		 jQuery("#vosl_map_size_width").val(width);
		 jQuery(".vosl_map_stats .vosl_size_stats span").html(width+"x"+height+" (Pixels)");
	  }
	});
}