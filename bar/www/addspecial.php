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
* Add a special article
* 
* Settings
* 
* 01/10/2004 by Christian Ehret chris@uffbasse.de
*/

$smartyType = "www";
include_once("../includes/default.inc.php");
$auth->is_authenticated();
include_once("articleclass.inc.php");
$article = new Article;
$smarty->assign("tpl_title", "Sonderverkauf");

if ($request->GetVar('frm_description', 'post') !== $request->undefined) {
    include_once("barguestclass.inc.php");
    $barguest = new Barguest;

    $articleid = $article->addSpecial();

    $theguestid = $request->GetVar('frm_theguestid', 'post');
    $smarty->assign("tpl_theguestid", $theguestid);
    $num = $request->GetVar('frm_num', 'post');
    $barguest->buy($articleid, $theguestid, $num);

    $smarty->assign('tpl_added', 'true');
} else {
	$smarty->assign('tpl_articles', $article->getList());
    $smarty->assign("tpl_theguestid", $request->GetVar('guestid', get));
    $smarty->assign('tpl_added', 'false');
} 

$smarty->display('addspecial.tpl');

?>
