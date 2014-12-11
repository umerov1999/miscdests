<?php /* $Id: $ */
if (!defined('FREEPBX_IS_AUTH')) { die('No direct script access allowed'); }

isset($_REQUEST['action'])?$action = $_REQUEST['action']:$action='';
isset($_REQUEST['id'])?$extdisplay = $_REQUEST['id']:$extdisplay='';
$md = FreePBX::create()->Miscdests;
$dispnum = "miscdests"; //used for switch on config.php
$miscdests = $md->mdlist();
//bootnav
$bootnav = '';
$bootnav .= '<div class="col-sm-3 hidden-xs bootnav">';
$bootnav .= '<div class="list-group">';
if($extdisplay == ''){
	$bootnav .= '<a href="config.php?display=miscdests" class="list-group-item active">'._("Add Misc Destination").'</a>';
}else{
	$bootnav .= '<a href="config.php?display=miscdests" class="list-group-item">'._("Add Misc Destination").'</a>';
}
if (isset($miscdests)) {
	foreach ($miscdests as $miscdest) {
		$bootnav .= '<a class="list-group-item '.($extdisplay==$miscdest[0] ? 'active':'').'" href="config.php?display='.urlencode($dispnum).'&id='.urlencode($miscdest[0]).'">'.$miscdest[1].'</a>';
	}
}
$bootnav .= '</div>';
$bootnav .= '</div>';
//end bootnav
$subhead = _("Add Misc Destination");
$helptext = _("Misc Destinations are for adding destinations that can be used by other FreePBX modules, generally used to route incoming calls. If you want to create feature codes that can be dialed by internal users and go to various destinations, please see the <strong>Misc Applications</strong> module.").' '._('If you need access to a Feature Code, such as *98 to dial voicemail or a Time Condition toggle, these destinations are now provided as Feature Code Admin destinations. For upgrade compatibility, if you previously had configured such a destination, it will still work but the Feature Code short cuts select list is not longer provided.<br/><br/>');
$usage_list = framework_display_destination_usage($md->getdest($extdisplay));
if($extdisplay){
	$thisMiscDest = $md->get($extdisplay);
	$thisMiscDest = $thisMiscDest[0];
	$description = $thisMiscDest['description'] ? $thisMiscDest['description']:'';
	$destdial = $thisMiscDest['destdial'] ? $thisMiscDest['destdial']:'';
	$subhead = _("Edit Misc Destination") . ": " . $destdial;
	$helptext = '';
	if(!empty($usage_list)){
		$objects = explode("\n", $usage_list['tooltip']);
		$helptext = '<div class="alert alert-info" role="alert">';
		$helptext .= '<i class="glyphicon glyphicon-info-sign fpbx-help-icon" data-for="inuse"></i>&nbsp;' . $usage_list['text'] . '<br/>';
		$helptext .= '<ul class="list-group">';
		foreach($objects as $o){
			$helptext .= '<li class="list-group-item" id="iteminuse">' . $o . '</li>';
		}
		$helptext .= '</ul>';
		$helptext .= '</div>';
	}
}

show_view(__DIR__."/views/main.php",array("description" => $description, "subhead" => $subhead, "helptext" => $helptext, "destdial" => $destdial, "bootnav" => $bootnav, "extdisplay" => $extdisplay));
