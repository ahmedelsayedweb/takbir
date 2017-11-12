<?php
if (!defined("VOSL_INCLUDES_PATH")) { include("../vosl-define.php"); }

global $wpdb;
$tag_id = $_REQUEST['id'];
global $vosl_hooks, $wpdb;

require_once(VOSL_ACTIONS_PATH."/processLocationData.php");

$value=$wpdb->get_row("SELECT * FROM ".VOSL_TAGS_TABLE." WHERE id = ".$tag_id, ARRAY_A);
?>
<div class='wrap'>
<table cellpadding='' cellspacing='0' style='width:100%' class='manual_edit_table'><tr>
<td style='padding-top:0px; width:50%' valign='top'>

<tr style='background-color:$bgcol' id='sl_tr_data-<?=$value[id]?>'>
			
	<td><form name='manualAddForm' method=post>
	<table cellpadding='0' class='widefat'>
    <thead><tr><th><?=__("Edit Tag", VOSL_TEXT_DOMAIN)?></th></tr></thead>
	<tr>
		<td style='vertical-align:top !important; width:30%'><b><?=__("Name of Tag", VOSL_TEXT_DOMAIN)?></b><br><input name='tag_name-<?=$value['id']?>' id='tag-<?=$value['id']?>' value='<?=$value['tag_name']?>' size=30 type='text'><br>
		
		<br>
        <?php $cancel_onclick = "location.href=\"admin.php?page=".VOSL_PAGES_DIR.'/manage-tags.php'."\""; ?>
		<nobr><input type='submit' value='<?=__("Update", VOSL_TEXT_DOMAIN)?>' class='button-primary'>&nbsp;&nbsp;<input type='button' class='button' value='<?=__("Cancel", VOSL_TEXT_DOMAIN)?>' onclick='<?=$cancel_onclick?>'></nobr>
		</td><td style='width:60%; vertical-align:top !important;'>
		
		</td><td style='vertical-align:top !important; width:40%'>
	</td></tr>
	</table>
	<input type='hidden' name='act' value='voslupdatetags' />
    <input type="hidden" name="vosl_tag_id" id="vosl_tag_id" value="<?=$tag_id?>" />
</form>
</td>

</tr>

</td>
<td style='padding-top:0px;' valign='top'>
</td>
</tr>
</table>
</div>