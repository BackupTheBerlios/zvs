<?php
/**
* create a dump of a database
* 
* Calendar
* 
* 03/23/2004 by Christian Ehret chris@uffbasse.de
*/
$nocachecontrol = true;

include_once("../includes/default.inc.php");

$auth->is_authenticated();

$database = $request->getVar('database','get');
$filename = $database."_".date("Ymd").".sql";

$execstring = $mysqldump ." --comments=0 --single-transaction --opt --databases $database -u $mysqluser --password=\"$mysqlpassword\"  --no-create-db";
$output = shell_exec($execstring);

header("Cache-control: private");
header("Content-type: application/txt");
header("Content-Disposition: attachment; filename=\"$filename\"");

echo $output;
?>