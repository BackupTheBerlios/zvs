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
* Guest "home page"
* 
* Guest
* 
* @since 2004-07-24
* @author Christian Ehret <chris@ehret.name> 
*/


function searchGuestByLastName($lastname)
{
    global $gDatabase2, $tbl_guest, $errorhandler; 
    $objResponse = new xajaxResponse();
    $ret = "";
    $query = "SELECT lastname, firstname FROM $tbl_guest WHERE lastname LIKE '$lastname%' AND ISNULL(deleted_date)";
    $result = MetabaseQuery($gDatabase2, $query);
    if (!$result) {
        $errorhandler->display('SQL', 'guest.php.searchGuestByLastName()', $query);
    } else {
        for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase2, $result)) == 0; ++$row) {
/*
            $ret .= '<div class="sr" onmouseover="gsc_mouseover(\'search-results\', \'fq\', 0)" onmouseout="gsc_mouseout(\'search-results\', 0)" onclick="gsc_mouseclick(\'search-results\', \'fq\', 0)">';
			$ret .= '<span class="srt">'.MetabaseFetchResult($gDatabase2, $result, $row, 0).'</span>';
			$ret .= '<span class="src">'.MetabaseFetchResult($gDatabase2, $result, $row, 1).'</span>';
			$ret .= '</div>';

*/
 			$ret .= MetabaseFetchResult($gDatabase2, $result, $row, 0) .'<br/>';
        } 
    } 
    $objResponse->addAssign("search-results", "innerHTML", $ret); 
    return $objResponse->getXML();
} 


$smartyType = "www";
include_once("../includes/default.inc.php");
$auth -> is_authenticated();
include_once('guestclass.inc.php');
$guest = New Guest;

require_once('searchguest.inc.php');
$ajax = new SearchGuest();
$ajax->handleRequest();

/*
$ajax->getSuggestions('aö', $arr);
print '<pre>';
print_r($arr);
print '</pre>';
*/
$smarty->assign('tpl_ajaxjs', $ajax->loadJsCore(true));
$smarty->assign('tpl_widgets', $ajax->attachWidgets(array('query'   => 'frm_lastname',
                                       					  'results' => 'search-results')));
$smarty->assign('tpl_loadapp', $ajax->loadJsApp(true));

$smarty -> assign("tpl_title", "Gast bearbeiten/anlegen");
$smarty -> assign('tpl_nav', 'gast');

if ($request -> GetVar('frm_firstname', 'post') !== $request -> undefined) {
    $guests = $guest -> easysearch($request -> GetVar('frm_firstname', 'post'), $request -> GetVar('frm_lastname', 'post'));
    $smarty -> assign('tpl_numresult', sizeof($guests));
    $smarty -> assign('tpl_isresult', 'true');
    $smarty -> assign('tpl_firstname', $request -> GetVar('frm_firstname', 'post'));
    $smarty -> assign('tpl_lastname', $request -> GetVar('frm_lastname', 'post'));
    $smarty -> assign('tpl_result', $guests);
} 
$smarty -> display('guest.tpl');

?>
