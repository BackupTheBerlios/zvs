<?php
/**
* Login page
* 
* Global
* 
* 07/24/2003 by Christian Ehret chris@uffbasse.de
*/
global $smarty, $request, $sess, $auth;

$smarty -> assign("tpl_title", "Login");
if ($request -> GetVar('username', 'post') !== $request->undefined) {
    $auth_username = $request -> GetVar('username', 'post');
} 

$value = (isset($this -> auth["uname"]) ? $this -> auth["uname"] : "");

$sess -> SetVar("reg_url", $action);
$smarty -> assign("tpl_uname", $value);
$smarty -> assign("tpl_challenge", session_id());
$smarty -> assign("tpl_url", $request -> GetURI());
$smarty -> assign("tpl_hiddenfields", $request -> returnPostDataAsHiddenFields());
if ($request -> GetVar('login', 'get') !== $request->undefined ) {
    $smarty -> assign('tpl_login', $request -> GetVar('login', 'get'));
} else if ($request -> GetVar('username', 'post') !== $request->undefined ) {
    $smarty -> assign('tpl_login', $request -> GetVar('username', 'post'));
}

if (isset($auth_username)) {
    $smarty -> assign("tpl_issetuname", "true");
} 
$smarty -> display('login.tpl');

?>
