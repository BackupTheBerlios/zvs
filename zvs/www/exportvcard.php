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
* Export Vcard
* 
* guest
* 
* @since 2004-09-15
* @author Christian Ehret <chris@ehret.name> 
*/

include_once("../includes/default.inc.php");
$filename = $request->GetVar('lastname','get').$request->GetVar('firstname','get');
	header("Content-type: text/directory");
	header("Content-Disposition: attachment; filename=".$filename.".vcf");
	header("Pragma: public");


$auth -> is_authenticated();
include_once("guestclass.inc.php");
include_once("vcardclass.inc.php");
$guest = New Guest;
$vcard = New Vcard;

$vcard->fetch($guest->getGuest($request->GetVar('guestid','get')));

?>

