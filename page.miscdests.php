<?php /* $Id: $ */
//Copyright (C) 2004 Coalescent Systems Inc. (info@coalescentsystems.ca)
//
//This program is free software; you can redistribute it and/or
//modify it under the terms of the GNU General Public License
//as published by the Free Software Foundation; either version 2
//of the License, or (at your option) any later version.
//
//This program is distributed in the hope that it will be useful,
//but WITHOUT ANY WARRANTY; without even the implied warranty of
//MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//GNU General Public License for more details.


isset($_REQUEST['action'])?$action = $_REQUEST['action']:$action='';
isset($_REQUEST['id'])?$extdisplay = $_REQUEST['id']:$extdisplay='';

$dispnum = "miscdests"; //used for switch on config.php

switch ($action) {
	case "add":
		miscdests_add($_REQUEST['description'],$_REQUEST['destdial']);
		needreload();
	break;
	case "delete":
		miscdests_del($extdisplay);
		needreload();
	break;
	case "edit":  //just delete and re-add
		miscdests_update($extdisplay,$_REQUEST['description'],$_REQUEST['destdial']);
		needreload();
	break;
}

//get meetme rooms
//this function needs to be available to other modules (those that use goto destinations)
//therefore we put it in globalfunctions.php
$miscdests = miscdests_list();
?>

</div>

<!-- right side menu -->
<div class="rnav">
    <li><a id="<?php echo ($extdisplay=='' ? 'current':'') ?>" href="config.php?display=<?php echo urlencode($dispnum)?>"><?php echo _("Add Misc Destination")?></a></li>
<?php
if (isset($miscdests)) {
	foreach ($miscdests as $miscdest) {
		echo "<li><a id=\"".($extdisplay==$miscdest[0] ? 'current':'')."\" href=\"config.php?display=".urlencode($dispnum)."&id=".urlencode($miscdest[0])."\">{$miscdest[1]}</a></li>";
	}
}
?>
</div>


<div class="content">
<?php
if ($action == 'delete') {
	echo '<br><h3>'._("Misc Destination").' '.$extdisplay.' '._("deleted").'!</h3><br><br><br><br><br><br><br><br>';
} else {
	if ($extdisplay){ 
		//get details for this meetme
		$thisMiscDest = miscdests_get($extdisplay);
		//create variables
		extract($thisMiscDest);
	}

	$delURL = $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'].'&action=delete';
?>

	
<?php		if ($extdisplay){ ?>
	<h2><?php echo _("Misc Destination:")." ". $description; ?></h2>
	<p><a href="<?php echo $delURL ?>"><?php echo _("Delete Misc Destination")?> '<?php echo $description; ?>'</a></p>
<?php		} else { ?>
	<h2><?php echo _("Add Misc Destination"); ?></h2>
<?php		}
?>
	<form autocomplete="off" name="editMD" action="<?php $_SERVER['PHP_SELF'] ?>" method="post" onsubmit="return editMD_onsubmit();">
	<input type="hidden" name="display" value="<?php echo $dispnum?>">
	<input type="hidden" name="action" value="<?php echo ($extdisplay ? 'edit' : 'add') ?>">
	<table>
	<tr><td colspan="2"><h5><?php echo ($extdisplay ? _("Edit Misc Destination") : _("Add Misc Destination")) ?><hr></h5></td></tr>
<?php		if ($extdisplay){ ?>
		<tr><td><input type="hidden" name="id" value="<?php echo $extdisplay; ?>"></td></tr>
<?php		} ?>
	<tr>
		<td><a href="#" class="info"><?php echo _("description:")?><span><?php echo _("Give this Misc Destination a brief name to help you identify it.")?></span></a></td>
		<td><input type="text" name="description" value="<?php echo (isset($description) ? $description : ''); ?>"></td>
	</tr>
	<tr>
		<td><a href="#" class="info"><?php echo _("dial:")?><span><?php echo _("Enter the digits to dial for this Misc Destination.")?></span></a></td>
		<td><input type="text" name="destdial" value="<?php echo (isset($destdial) ? $destdial : ''); ?>"></td>
	</tr>

	
	<tr>
		<td colspan="2"><br><h6><input name="Submit" type="submit" value="<?php echo _("Submit Changes")?>"></h6></td>		
	</tr>
	</table>
<script language="javascript">
<!--

var theForm = document.editMD;

if (theForm.description.value == "") {
	theForm.description.focus();
} else {
	theForm.destdial.focus();
}

function editMD_onsubmit()
{
	var msgInvalidDescription = "<?php echo _('Please enter a valid Description'); ?>";
	var msgInvalidDial = "<?php echo _('Please enter a valid Dial string'); ?>";
	
	defaultEmptyOK = false;
	if (!isAlphanumeric(theForm.description.value))
		return warnInvalid(theForm.description, msgInvalidDescription);
		
	if (!isDialDigits(theForm.destdial.value))
		return warnInvalid(theForm.destdial, msgInvalidDial);
		
	return true;
}

//-->
</script>
	</form>
<?php		
} //end if action == delGRP
?>
