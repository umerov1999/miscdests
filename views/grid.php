<?php
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
foreach ($miscdests as $miscdest) {
	$lrows .= '<tr>';
	$lrows .= '<td>';
	$lrows .= $miscdest[1];
	$lrows .= '</td>';
	$lrows .= '<td>';
	$lrows .= '<a href="?display=miscdests&view=form&extdisplay='.$miscdest[0].'"><i class="fa fa-edit"></i></a>&nbsp;';
	$lrows .= '<a href="?display=miscdests&action=delete&extdisplay='.$miscdest[0].'"><i class="fa fa-trash"></i></a>';
	$lrows .= '</td>';
	$lrows .= '</tr>';
}

?>
<table class="table table-striped">
	<thead>
		<th><?php echo _("Language")?></th>
		<th><?php echo _("Actions")?></th>
	</thead>
	<tbody>
		<?php echo $lrows ?>
	</tbody>
</table>