<?php
/***************************************************************
*  Copyright notice
*  
*  (c) 2003-2004 Christian Ehret (chris@ehret.name)
*  All rights reserved
*
*  This script is part of the ZVS project. The ZVS project is 
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
* 
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*  A copy is found in the textfile GPL.txt and important notices to the license 
*  from the author is found in LICENSE.txt distributed with these scripts.
*
* 
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

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
$tmppath = getenv('TEMP')."/".$database."_".time().".sql";
set_time_limit(0);

$execstring = $mysqldump ." --comments=0 --single-transaction --opt --databases $database -u $mysqluser --password=\"$mysqlpassword\"  --no-create-db > $tmppath";
$output = shell_exec($execstring);

header("Cache-control: private");
header("Content-type: application/txt");
header("Content-Disposition: attachment; filename=\"$filename\"");
$handle = fopen ($tmppath, "r");
while (!feof($handle)) {
   $buffer = fgets($handle, 4096);
   echo $buffer;
}
fclose($handle); 

unlink($tmppath);

?>