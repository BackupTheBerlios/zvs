<?php
/***************************************************************
*  Copyright notice
*  
*  (c) 2003-2006 Christian Ehret (chris@ehret.name)
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
* Get a list of all guests with lastname beginning with a proper string
* 
* Guest
* 
* @since 2006-02-24
* @author Christian Ehret <chris@ehret.name> 
*/

include_once("../includes/default.inc.php");
$auth -> is_authenticated();
if ($request->GetVar('autocomplete', 'post')) {
  $entry = $request->GetVar('autocomplete', 'post');
	echo '<ul>';
	$query = sprintf("SELECT lastname, firstname, pk_guest_id FROM $tbl_guest 
		  WHERE lastname LIKE '%s%%' AND ISNULL(deleted_date)
		  ORDER BY lastname LIMIT 25",
	        $entry
	        );
	    $result = MetabaseQuery($gDatabase, $query);
	    if (!$result) {
	    } else {
	        for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
	            echo "<li id=\"".MetabaseFetchResult($gDatabase, $result, $row, 1)."\">".MetabaseFetchResult($gDatabase, $result, $row, 0) ."<span class=\"informal\">, ". MetabaseFetchResult($gDatabase, $result, $row, 1)."</span></li>";
	        } 
	     } 	
  echo '</ul>';
 
} 
?>

