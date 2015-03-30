<?php
//	License for all code of this FreePBX module can be found in the license file inside the module directory
//	Copyright 2015 Sangoma Technologies.
//
$miscdests = $md->mdlist();
foreach ($miscdests as $miscdest) {
	$lrows .= '<tr>';
	$lrows .= '<td>';
	$lrows .= $miscdest[1];
	$lrows .= '</td>';
	$lrows .= '<td>';
	$lrows .= '<a href="?display=miscdests&view=form&extdisplay='.$miscdest[0].'"><i class="fa fa-edit"></i></a>&nbsp;';
	$lrows .= '<a class="delAction" href="?display=miscdests&action=delete&extdisplay='.$miscdest[0].'"><i class="fa fa-trash"></i></a>';
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