<?php
/**
* create a archive dump of a database
* 
* Calendar
* 
* 07/09/2004 by Christian Ehret chris@uffbasse.de
*/
$nocachecontrol = true;

include_once("../includes/default.inc.php");
include_once("archiveclass.inc.php");

$archive = New Archive;

$auth->is_authenticated();

$database = $request->getVar('frm_database', 'post');
$filename = $database . "_archive_" . date("Ymd") . ".sql";
$date = $request->getVar('frm_thedate', 'post');
if ($request->getVar('frm_delete') == 'yes') {
    $delete = true;
} else {
	$delete = false;
}
$output=$archive->get($date,$delete);


header("Cache-control: private");
header("Content-type: application/txt");
header("Content-Disposition: attachment; filename=\"$filename\"");

echo $output;

?>