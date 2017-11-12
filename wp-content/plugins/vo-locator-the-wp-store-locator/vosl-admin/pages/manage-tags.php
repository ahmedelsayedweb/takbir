<?php
if( isset($_POST['dele']) and $_POST['dele']==1)
{
	$wpdb->query("DELETE FROM ".VOSL_TAGS_TABLE); 	
	$wpdb->query("DELETE FROM ".VOSL_TAGS_ASSOC_TABLE); 
}
?>
<div class='wrap'>
<h2></h2>
<input type='button' value='<?php echo __("Add Tag", VOSL_TEXT_DOMAIN); ?>' class='button-primary' onclick="location.href='<?=VOSL_ADD_TAGS_PAGE?>'">


<h2><div style="float:left;"><?php echo __("Manage Tags", VOSL_TEXT_DOMAIN); ?></div><div class="listingssearchbox"><form method="post" name="frmSearch" action="<?php echo str_replace("&paged=".$_REQUEST['paged'], "",$_SERVER['REQUEST_URI']); ?>"><input type="text" id="vosl_txtSearchTextTags" name="vosl_txtSearchTextTags" />&nbsp;&nbsp;<input type="button" value="<?php echo __("Search", VOSL_TEXT_DOMAIN); ?>" name="btnSearch" id="btnSearch" class='button-primary' /></form></div></h2>

<?php
require_once(VOSL_ACTIONS_PATH."/processLocationData.php");
?>
<table style='width:100%'><tr><td>
<div class='mng_loc_forms_links'>

</div>

</div>
</td><td>

</td></tr></table>

<form name='locationForm' id='locationForm' method='post'><input type='hidden' name='dele' id='dele' value='0' />
<table id="vosl_manage_tags_dt" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th><?php echo __("ID", VOSL_TEXT_DOMAIN); ?></th>
                <th><?php echo __("Name", VOSL_TEXT_DOMAIN); ?></th>
                <th><?php echo __("Action", VOSL_TEXT_DOMAIN); ?></th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th><?php echo __("ID", VOSL_TEXT_DOMAIN); ?></th>
                <th><?php echo __("Name", VOSL_TEXT_DOMAIN); ?></th>
                <th><?php echo __("Action", VOSL_TEXT_DOMAIN); ?></th>
            </tr>
        </tfoot>
    </table>
    <input type='button' value='<?=__("Delete All Tags", VOSL_TEXT_DOMAIN)?>' class='button-red' onclick="deleteAllTags();" style="float:right; margin-top:10px;">
</form>
<?php $ajax_url = admin_url( 'admin-ajax.php' ); ?>
</div>
<script type="text/javascript">
function deleteAllTags()
{
	if(confirm("<?php echo __("Do you want to delete all Tags?", VOSL_TEXT_DOMAIN); ?>"))
	{
			jQuery("#dele").val(1);
			jQuery("#locationForm").submit();
	 }
}

jQuery(document).ready(function() {
    
   vosl_tags_admin_table = jQuery('#vosl_manage_tags_dt').DataTable( {
        "processing": true,
        "serverSide": true,
		"ajax": {
            "url": "<?=$ajax_url?>?action=vosl_get_tags_listings_admin",
            "type": "POST"
        },
		"language": {
		  "emptyTable": "No data available for tags"
		},
		"columnDefs": [ {
		"targets": 2,
		"orderable": false
		} ]
    } );
	
	jQuery('#btnSearch').click(function(){
      vosl_tags_admin_table.search(jQuery("#vosl_txtSearchTextTags").val()).draw() ;
	});
   
});
</script>
<style type="text/css">
.listingssearchbox{ float:right; }
/* CSS Code - add this to the style.css file*/
.vosllogo{ float:left; }
.wp-core-ui .notice.is-dismissible{ margin-top:20px; }
.voslpromotelink{ background:#FFFFFF;padding: 6px 10px;font-size:14px; float:right;color: #008EC2;font-weight: bold;margin-left: 15px;border: 1px solid #cccccc; }
.voslpromotelink a{ text-decoration:none; }
</style>