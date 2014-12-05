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

?>

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-9">
			<div class="fpbx-container">
				<form autocomplete="off" class="fpbx-submit" name="editMD" action="config.php?display=miscdests" method="post" data-fpbx-delete="config.php?display=miscdests&amp;extdisplay=<?php echo $extdisplay ?>&amp;action=delete" role="form">
				<input type="hidden" name="display" value="<?php echo $dispnum?>">
				<input type="hidden" name="action" value="<?php echo ($extdisplay ? 'edit' : 'add') ?>">
				<input type="hidden" name="id" value="<?php echo $extdisplay; ?>">
					<div class="display full-border">
						<div>
							<h1><?php echo _("Misc Destination:")." ". $description; ?></h1>
							<h3><?php echo $subhead ?></h3>
							<p><?php echo $helptext ?></p>
						</div>
						<div class="element-container">
							<div class="row">
								<div class="col-md-12">
									<div class="row">
										<div class="form-group">
											<div class="col-md-3">
												<label class="control-label" for="description"><?php echo _("Description:")?></label>
												<i class="fa fa-question-circle fpbx-help-icon" data-for="description"></i>
											</div>
											<div class="col-md-9">
												<input type="text" class="form-control" id="description" name="description" value="<?php echo (isset($description) ? $description : ''); ?>" tabindex="<?php echo ++$tabindex;?>" >
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<span id="description-help" class="help-block fpbx-help-block"><?php echo _("Give this Misc Destination a brief name to help you identify it.")?></span>
								</div>
							</div>
						</div>
						<div class="element-container">
							<div class="row">
								<div class="col-md-12">
									<div class="row">
										<div class="form-group">
											<div class="col-md-3">
												<label class="control-label" for="destdial"><?php echo _("Dial:")?></label>
												<i class="fa fa-question-circle fpbx-help-icon" data-for="destdial"></i>
											</div>
											<div class="col-md-9">
												<input type="text" class="form-control" id="destdial" name="destdial" value="<?php echo (isset($destdial) ? $destdial : ''); ?>" tabindex="<?php echo ++$tabindex;?>">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<span id="destdial-help" class="help-block fpbx-help-block"><?php echo _("Enter the number this destination will simulate dialing, exactly as you would dial it from an internal phone. When you route a call to this destination, it will be as if the caller dialed this number from an internal phone.") ?></span>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	   <?php echo $bootnav ?>
	</div>
</div>
