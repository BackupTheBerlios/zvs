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
* Newsletter
* 
* @since 2004-06-05
* @author Christian Ehret <chris@ehret.name> 
*/
$smartyType = "www";
include_once("../includes/default.inc.php");
$auth -> is_authenticated();
include_once('newsletterclass.inc.php');
$newsletter = New Newsletter;
$smarty -> assign("tpl_title", "Newsletter versenden");
$smarty -> assign('tpl_nav', 'newsletter');
$smarty -> assign('tpl_type', 'newsletter');
if ($request->GetVar('frm_cat','post') !== $request->undefined) {
    $cats = $request->GetVar('frm_cat','post');
	$sender = $request->GetVar('frm_sender','post');
	$senderemail = $request->GetVar('frm_senderemail','post');
	$subject = $request->GetVar('frm_subject','post');
	$body = $request->GetVar('frm_body','post');
	if ($request->GetVar('frm_andop','post') == 'yes') {
	    $andop = true;
	} else {
		$andop = false;
	}
	if ($request->GetVar('frm_salutation','post') == 'yes') {
	    $salutation = true;
	} else {
		$salutation = false;
	}	
	$number = $newsletter->send($cats, $sender, $senderemail, $subject, $body, $andop, $salutation);
	$smarty -> assign('tpl_number', $number);
	$smarty -> assign('tpl_sent', 'true');
} else {
    $smarty -> assign ('tpl_sent', 'false');
	$smarty -> assign('tpl_cat', $newsletter->getCategories());
	$smarty -> assign('tpl_hotelname', $request->getVar('hotel_name','session'));
	$smarty -> assign('tpl_hotelemail', $request->getVar('hotel_email','session'));	
}
$smarty -> display('newsletter.tpl');

?>
