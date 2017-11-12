<?php
/*-----------------------------------------------------------*/
function vosl_data($setting_name, $i_u_d_s="select", $setting_value="") {
	global $wpdb;
	
	if(!is_array($setting_value))
	{
		$setting_value = sanitize_text_field($setting_value);
	}
	
	if ($i_u_d_s == "insert" || $i_u_d_s == "add" || $i_u_d_s == "update") {
		$setting_value = (is_array($setting_value))? serialize($setting_value) : $setting_value;
		$exists = $wpdb->get_var($wpdb->prepare("SELECT setting_id FROM ".VOSL_SETTING_TABLE." WHERE setting_name = %s", $setting_name));
		if (!$exists) {	
			$q = $wpdb->prepare("INSERT INTO ".VOSL_SETTING_TABLE." (setting_name, setting_value) VALUES (%s, %s)", $setting_name, $setting_value); 
		} else { 
			$q = $wpdb->prepare("UPDATE ".VOSL_SETTING_TABLE." SET setting_value = %s WHERE setting_name = %s", $setting_value, $setting_name);
		}
		$wpdb->query($q);
	} elseif ($i_u_d_s == "delete") {
		
		$q = $wpdb->prepare("DELETE FROM ".VOSL_SETTING_TABLE." WHERE setting_name = %s", $setting_name);
		$wpdb->query($q);
	} elseif ($i_u_d_s == "select" || $i_u_d_s == "get") {
		$q = $wpdb->prepare("SELECT setting_value FROM ".VOSL_SETTING_TABLE." WHERE setting_name = %s", $setting_name);
		$r = $wpdb->get_var($q);
		$r = (@unserialize($r) !== false || $r === 'b:0;')? unserialize($r) : $r;  //checking if stored in serialized form
		return $r;
	}
}

/*----------------------------*/
function vosl_install_tables() {
	global $wpdb, $vosl_db_version, $vosl_path, $vosl_hook, $vosl_db_prefix;
	
	vosl_add_custom_cap();
	
	if (!defined("VOSL_TABLE") || !defined("VOSL_SETTING_TABLE")){ 
		//add_option("sl_db_prefix", $wpdb->prefix); $sl_db_prefix = get_option('sl_db_prefix'); 
		$vosl_db_prefix = $wpdb->prefix; //better this way, in case prefix changes vs storing option - 1/29/15
	}
	if (!defined("VOSL_TABLE")){ define("VOSL_TABLE", $vosl_db_prefix."vostore_locator");}
	/*if (!defined("SL_TAG_TABLE")){ define("SL_TAG_TABLE", $sl_db_prefix."sl_tag"); }*/
	if (!defined("VOSL_SETTING_TABLE")){ define("VOSL_SETTING_TABLE", $vosl_db_prefix."vosl_setting"); }
	if (!defined("VOSL_PEOPLE_TABLE")){ define("VOSL_PEOPLE_TABLE", $vosl_db_prefix."vosl_people"); }
	if (!defined("VOSL_TAGS_TABLE")){ define("VOSL_TAGS_TABLE", $vosl_db_prefix."vosl_tags"); }
	if (!defined("VOSL_TAGS_ASSOC_TABLE")){ define("VOSL_TAGS_ASSOC_TABLE", $vosl_db_prefix."vosl_tags_locations"); }
	
	$table_name = VOSL_TABLE;
	$sql = "CREATE TABLE " . $table_name . " (
			id mediumint(8) unsigned NOT NULL auto_increment,
			store_name varchar(255) NULL,
			address varchar(255) NULL,
			address2 varchar(255) NULL,
			city varchar(255) NULL,
			state varchar(255) NULL,
			country varchar(255) NULL,
			zip varchar(255) NULL,
			latitude varchar(255) NULL,
			longitude varchar(255) NULL,
			description mediumtext NULL,
			url varchar(255) NULL,
			phone varchar(255) NULL,
			fax varchar(255) NULL,
			email varchar(255) NULL,
			image varchar(255) NULL,
			hours varchar(255) NULL,
			show_address_publicly int(3),
			_wpnonce varchar(255) NULL,
			_wp_http_referer text NULL,
			custom_marker_icon text NULL,
			PRIMARY KEY  (id)
			) ENGINE=innoDB  DEFAULT CHARACTER SET=utf8  DEFAULT COLLATE=utf8_unicode_ci;";
			
	$table_name_2 = VOSL_PEOPLE_TABLE;
	$sql .= "CREATE TABLE " . $table_name_2 . " (
			people_id bigint(20) unsigned NOT NULL auto_increment,
			place_id int(11) NULL,
			name varchar(255) NULL,
			category_id mediumint(8) NULL,
			PRIMARY KEY  (people_id)
			) ENGINE=innoDB  DEFAULT CHARACTER SET=utf8  DEFAULT COLLATE=utf8_unicode_ci;";
	
	$table_name_3 = VOSL_SETTING_TABLE;
	$sql .= "CREATE TABLE " . $table_name_3 . " (
			setting_id bigint(20) unsigned NOT NULL auto_increment,
			setting_name varchar(255) NULL,
			setting_value longtext NULL,
			PRIMARY KEY  (setting_id)
			) ENGINE=innoDB  DEFAULT CHARACTER SET=utf8  DEFAULT COLLATE=utf8_unicode_ci;";
			
	$table_name_4 = VOSL_TAGS_TABLE;
	$sql .= "CREATE TABLE " . $table_name_4 . " (
			id int(11) unsigned NOT NULL auto_increment,
			tag_name varchar(255) NULL,
			tag_color varchar(20) NULL,
			PRIMARY KEY  (id)
			) ENGINE=innoDB  DEFAULT CHARACTER SET=utf8  DEFAULT COLLATE=utf8_unicode_ci;";	
			
	$table_name_5 = VOSL_TAGS_ASSOC_TABLE;
	$sql .= "CREATE TABLE " . $table_name_5 . " (
			id int(11) unsigned NOT NULL auto_increment,
			tag_id int(11) unsigned NOT NULL,
			store_id int(11) NULL,
			PRIMARY KEY  (id),
			FOREIGN KEY (tag_id) 
			REFERENCES ".VOSL_TAGS_TABLE."(id)
			ON DELETE CASCADE

			) ENGINE=innoDB  DEFAULT CHARACTER SET=utf8  DEFAULT COLLATE=utf8_unicode_ci;";		
			
					
	//$sql .= "INSERT INTO " . $table_name_3 . " (sl_setting_name, sl_setting_value) VALUES ('sl_db_prefix', '" . $wpdb->prefix . "');";
			
	if($wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $table_name)) != $table_name || $wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $table_name_3)) != $table_name_3 || $wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $table_name_2)) != $table_name_2 || $wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $table_name_4)) != $table_name_4 || $wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $table_name_5)) != $table_name_5) {
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
		vosl_data("vosl_db_version", 'add', $vosl_db_version);
	}
	
	$installed_ver = vosl_data("vosl_db_version");
	if( $installed_ver != $vosl_db_version ) {
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
		
		// Need to remove this function from v 3.0 onwards, consolidating default center
		if(floatval($vosl_db_version) > 1.2)
		{
			$wpdb->query( "ALTER TABLE $table_name DROP COLUMN default_map_center" );
		}
			
		vosl_data("vosl_db_version", 'update', $vosl_db_version);
	}
	
	if (vosl_data("vosl_db_prefix")===""){
		vosl_data('vosl_db_prefix', 'update', $vosl_db_prefix);
	}
}
/*-------------------------------*/

function vosl_comma($a) {
	$a=str_replace('"', "&quot;", $a);
	$a=str_replace("'", "&#39;", $a);
	$a=str_replace(">", "&gt;", $a);
	$a=str_replace("<", "&lt;", $a);
	$a=str_replace(" & ", " &amp; ", $a);
	return str_replace("," ,"&#44;" ,$a);
	
}

function vosl_check_existing_tags($name)
{
	global $wpdb;
	
	$row = $wpdb->get_row( $wpdb->prepare( "SELECT id FROM ".VOSL_TAGS_TABLE." WHERE tag_name = %s ",$name ), ARRAY_A );
	
	if((int)$row['id'] > 0)
	{
		return array('msg' => 'Tag already exists. Pley try with another name');
	}else
	{
		return array('msg' => 'OK');
	}
}

function vosl_add_tag()
{
	global $wpdb;
	$fieldList=""; $valueList="";
	
	unset($_POST['_wpnonce']);
	unset($_POST['_wp_http_referer']);
	
	foreach ($_POST as $key=>$value) {
			$fieldList.="$key,";
			
			if (is_array($value)){
				$value=serialize($value); //for arrays being submitted
				$valueList.="'$value',";
				
			} else {
				$value = sanitize_text_field( $value );
				$valueList.=$wpdb->prepare("%s", vosl_comma(stripslashes($value))).",";
			}
	}

	$fieldList=substr($fieldList, 0, strlen($fieldList)-1);
	$valueList=substr($valueList, 0, strlen($valueList)-1);
	$wpdb->query("INSERT INTO ".VOSL_TAGS_TABLE." ($fieldList) VALUES ($valueList)") or die(mysql_error());
	$new_loc_id=$wpdb->insert_id;
}

function vosl_add_location() {
	global $wpdb;
	$fieldList=""; $valueList="";
	
	$tags = $_POST['voslSelTags'];
	unset($_POST['voslSelTags']);
	unset($_POST['voslRedirectToTags']);
	
	/*if(!isset($_POST['default_map_center']))
			$_POST['default_map_center'] = 0;	*/
	
	foreach ($_POST as $key=>$value) {
			$fieldList.="$key,";
			
			if (is_array($value)){
				$value=serialize($value); //for arrays being submitted
				$valueList.="'$value',";
				
			} else {
				$value = sanitize_text_field( $value );
				$valueList.=$wpdb->prepare("%s", vosl_comma(stripslashes($value))).",";
			}
	}
	
	// clear other default center map locations
	//$sql_up = "UPDATE ".VOSL_TABLE." SET default_map_center = 0 ";
	//$wpdb->query($sql_up);
		
	$fieldList=substr($fieldList, 0, strlen($fieldList)-1);
	$valueList=substr($valueList, 0, strlen($valueList)-1);
	$wpdb->query("INSERT INTO ".VOSL_TABLE." ($fieldList) VALUES ($valueList)") or die(mysql_error());
	$new_loc_id=$wpdb->insert_id;
	
	if(is_array($tags) or is_int($tags))
		do_action('vosl_associate_tags_listings',(int)$new_loc_id,$tags);
	
	$address="$_POST[address], $_POST[address2], $_POST[city], $_POST[state] $_POST[zip]";
	vosl_do_geocoding($address);
}

function vosl_single_tag_info($value, $colspan, $bgcol)
{
	global $vosl_hooks;
	$_GET['edit'] = $value['id']; //die("edit: ".var_dump($_GET)); die();
	
	print "<tr style='background-color:$bgcol' id='sl_tr_data-$value[id]'>";	
			
	print "<td colspan='$colspan'><form name='manualAddForm' method=post>
	<a name='a$value[id]'></a>
	<table cellpadding='0' class='manual_update_table'>
	<tr>
		<td style='vertical-align:top !important; width:30%'><b>".__("Name of Tag", VOSL_TEXT_DOMAIN)."</b><br><input name='tag_name-$value[id]' id='tag-$value[id]' value='$value[tag_name]' size=30 type='text'><br>";
		
		$cancel_onclick = "location.href=\"".str_replace("&edit=$_GET[edit]", "",$_SERVER['REQUEST_URI'])."\"";
		
		print "<br><br>
		<nobr><input type='submit' value='".__("Update", VOSL_TEXT_DOMAIN)."' class='button-primary'>&nbsp;&nbsp;<input type='button' class='button' value='".__("Cancel", VOSL_TEXT_DOMAIN)."' onclick='$cancel_onclick'></nobr>
		</td><td style='width:60%; vertical-align:top !important;'>";
		
		print "</td><td style='vertical-align:top !important; width:40%'>";
	if (function_exists("do_vosl_hook")) {do_vosl_hook("sl_single_tag_edit", "select-top");}
	print "</td></tr>
	</table>
	<input type='hidden' name='act' value='updatetags' />
</form>
</td>";

print "</tr>";
}

/*-----------------------------------*/
if (!function_exists("vosl_do_geocoding")){
 function vosl_do_geocoding($address, $sl_id="") {
   if (empty($_POST['no_geocode']) || $_POST['no_geocode']!=1){
	global $wpdb, $text_domain, $vosl_vars;

	// Initialize delay in geocode speed
	$delay = 100000; 
	$vosl_map_api_key = vosl_data('vosl_map_api_key');
	
	// Fixed on for servers without SSL certificate, moved to http from https 19th Nov 15 
	$base_url = "https://maps.googleapis.com/maps/api/geocode/json?";

	if ($sensor!="" && !empty($sensor) && ($sensor === "true" || $sensor === "false" )) {$base_url .= "sensor=".$sensor;} else {$base_url .= "sensor=false";}
	
	$locale_info = get_locale();
	$locale_info = explode("_",$locale_info);
	$locale_info = $locale_info[0];	
	
	if($locale_info!='')
		$base_url .= "&language=".$locale_info;
		
	$map_region = vosl_data('vosl_map_region');
	$region=(!empty($map_region))?$map_region : "" ;
	
	if($region!='')
		$base_url .= "&region=".$region;	
		
	if($vosl_map_api_key!='')
		$base_url .= "&key=".$vosl_map_api_key;		
	
	// Iterate through the rows, geocoding each address
	$request_url = $base_url . "&address=" . urlencode(trim($address)); //print($request_url );
    
	//New code to accomdate those without 'file_get_contents' functionality for their server - added by Manoj M - thank you
	if (extension_loaded("curl") && function_exists("curl_init")) {
		$cURL = curl_init();
		curl_setopt($cURL, CURLOPT_URL, $request_url);
		curl_setopt($cURL, CURLOPT_RETURNTRANSFER, 1);
		$resp_json = curl_exec($cURL);
		curl_close($cURL);  
	}else{
		$resp_json = file_get_contents($request_url) or die("url not loading");
	}
	//End of new code

	$resp = json_decode($resp_json, true); //var_dump($resp);
    $status = $resp['status']; //$status = "";
    $lat = (!empty($resp['results'][0]['geometry']['location']['lat']))? $resp['results'][0]['geometry']['location']['lat'] : "" ;
    $lng = (!empty($resp['results'][0]['geometry']['location']['lng']))? $resp['results'][0]['geometry']['location']['lng'] : "" ;
	//die("<br>compare: ".strcmp($status, "OK")."<br>status: $status<br>");
    if (strcmp($status, "OK") == 0) {
		// successful geocode
		$geocode_pending = false;
		$lat = $resp['results'][0]['geometry']['location']['lat'];
		$lng = $resp['results'][0]['geometry']['location']['lng'];

		if ($sl_id==="") {
			$query = $wpdb->prepare("UPDATE ".VOSL_TABLE." SET latitude = '%s', longitude = '%s' WHERE id = %d LIMIT 1;", $lat, $lng, (int)$wpdb->insert_id);
			//$query = sprintf("UPDATE ".VOSL_TABLE." SET latitude = '%s', longitude = '%s' WHERE id = '%s' LIMIT 1;", esc_sql($lat), esc_sql($lng), esc_sql($wpdb->insert_id)); //die($query); 
		} else {
			$query = $wpdb->prepare("UPDATE ".VOSL_TABLE." SET latitude = '%s', longitude = '%s' WHERE id = %d LIMIT 1;", $lat, $lng, (int)$sl_id);
			//$query = sprintf("UPDATE ".VOSL_TABLE." SET latitude = '%s', longitude = '%s' WHERE id = '%s' LIMIT 1;", esc_sql($lat), esc_sql($lng), esc_sql($sl_id)); 
		}
		$update_result = $wpdb->query($query);
		if ($update_result === FALSE) {
			die("Invalid query: " . $wpdb->last_error);
		}
    } else if (strcmp($status, "OVER_QUERY_LIMIT") == 0) {
		// sent geocodes too fast
		$delay += 100000;
    } else {
		// failure to geocode
		$geocode_pending = false;
		$query = $wpdb->prepare("UPDATE ".VOSL_TABLE." SET latitude = NULL, longitude = NULL WHERE id = %d ", (int)$sl_id);
		$wpdb->query($query);
		echo __("Address " . $address . " <font color=red>failed to geocode</font>. ", VOSL_TEXT_DOMAIN);
		//if (!empty($status)) {
			echo __("Received status " . $status , VOSL_TEXT_DOMAIN)."\n<br>";
		/*} else {
			echo __("No status received from Google", VOSL_TEXT_DOMAIN)."\n<br>"; 
		}*/
    }
    usleep($delay);
  } else {
  	//print __("Geocoding bypassed ", VOSL_TEXT_DOMAIN);
  } @ob_flush(); flush();
 }
}
/*-------------------------------*/

/*-----------------------------------------------------------*/
function vo_url_test($url){
	if (preg_match("@^https?://@i", $url)) {
		return TRUE; 
	} else {
		return FALSE; 
	}
}

function vosl_add_custom_cap()
{
	global $vosl_capability;
	if ( ! function_exists( 'get_editable_roles' ) ) {
		require_once ABSPATH . 'wp-admin/includes/user.php';
	}
	// Add Custom Capability
	$roles = get_editable_roles();
	foreach ($GLOBALS['wp_roles']->role_objects as $key => $role) {
		if (isset($roles[$key]) && $role->has_cap('edit_pages')) {
			$role->add_cap($vosl_capability);
		}
	}
}

function vosl_deactivation()
{
	global $vosl_capability;
	// Remove Custom Capability
	$roles = get_editable_roles();
	foreach ($GLOBALS['wp_roles']->role_objects as $key => $role) {
		if (isset($roles[$key]) && $role->has_cap($vosl_capability)) {
			$role->remove_cap($vosl_capability);
		}
	}
}
?>