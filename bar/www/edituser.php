<?php
/**
* Manage users
* 
* Settings
* 
* 07/24/2003 by Christian Ehret chris@uffbasse.de
*/
$smartyType = "www";
include_once("../includes/default.inc.php");
$auth -> is_authenticated();
include_once('userclass.inc.php');
$user = New User;
$smarty -> assign("tpl_title", "Benutzerverwaltung");
$smarty -> assign('tpl_nav', 'settings');
$smarty -> assign('tpl_subnav', 'edituser');
$smarty -> assign("tpl_challenge", session_id());

if ($request -> GetVar('frm_userid', 'post') !== $request -> undefined) {
    if ($request -> GetVar('frm_action', 'post') == 'edit') {
        $smarty -> assign('tpl_editid', $request -> GetVar('frm_userid', 'post'));
    } else if ($request -> GetVar('frm_action', 'post') == 'addnew') {
        $smarty -> assign('tpl_addnew', 'true');
    } else if ($request -> GetVar('frm_action', 'post') == 'del') {
        $user -> del($request -> GetVar('frm_userid', 'post'));
    } else {
        $check = $user -> saveupdate();
    } 
} 

$smarty -> assign('tpl_user', $user -> getall());

$smarty -> display('edituser.tpl');

?>
