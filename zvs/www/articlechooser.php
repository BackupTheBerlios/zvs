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
* Article chooser
* 
* Settings
* 
* @since 2004-10-03
* @author Christian Ehret <chris@ehret.name> 
*/

$smartyType = "www";
include_once("../includes/default.inc.php");
$auth->is_authenticated();
include_once('articleclass.inc.php');
$article = New Article;

$smarty->assign("tpl_title", "Artikel ausw&auml;hlen");
	$smarty -> assign('tpl_children_field1', $request->GetVar('children1', 'session'));
	$smarty -> assign('tpl_children_field2', $request->GetVar('children2', 'session'));
	$smarty -> assign('tpl_children_field3', $request->GetVar('children3', 'session'));	

if ($request->GetVar('frm_action', 'post') !== $request->undefined) {
    if ($request->GetVar('frm_type', 'post') == 'rcat') {
	$pricetype = $request->GetVar('frm_price_type','post');
	/*
		if ($request->GetVar('frm_price_type','post') == 'PP') {
		    $pricetype = 'PP';
		} else {
			$pricetype = 'PR';
		}
		*/ 
		if ($pricetype == 'PP' && $request->GetVar('frm_included','post') == 'yes') {
		    $included = true;
		} else {
			$included = false;
		}
		$smarty->assign('tpl_opener',$wwwroot.'roomcategory.php');
        if ($request->GetVar('frm_action', 'post') == 'del') {
            $article->delroom($request->GetVar('frm_id','post'), $request->GetVar('frm_article','post'));
        } else {

            $article->addroom($request->GetVar('frm_id','post'), $request->GetVar('frm_article','post'), $pricetype, $included);
        } 
    } 
	$smarty->assign('tpl_submitted','true');
} else {
    $smarty->assign('tpl_article', $article->get());
    $smarty->assign('tpl_id', $request->getVar('id', 'get'));
    $smarty->assign('tpl_type', $request->getVar('type', 'get'));
	$smarty->assign('tpl_submitted','false');
} 
$smarty->display('articlechooser.tpl');

?>
