<?php
/**
* Copyright notice
* 
*    (c) 2003-2004 Christian Ehret (chris@ehret.name)
*    All rights reserved
* 
*    This script is part of the ZVS project. The ZVS project is 
*    free software; you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation; either version 2 of the License, or
*    (at your option) any later version.
* 
*    The GNU General Public License can be found at
*    http://www.gnu.org/copyleft/gpl.html.
*    A copy is found in the textfile GPL.txt and important notices to the license 
*    from the author is found in LICENSE.txt distributed with these scripts.
* 
* 
*    This script is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU General Public License for more details.
* 
*    This copyright notice MUST APPEAR in all copies of the script!
*/
// no caching
header('Expires: 0');
// needed for rtf output
if (!isset($nocachecontrol)) {
    header('Pragma: no-cache');
    header('Cache-Control: no-cache, no-store, must-revalidate');
} 

ini_set('magic_quotes_gpc', false);
ini_set('magic_quotes_runtime', false);
ini_set('magic_quotes_sybase', false);
ini_set('session.cookie_lifetime', 0);

$metabasepath = $instpath . 'metabase';
$fontpath = $instpath . '/ext/fpdf/font/';
// error class
include_once('errorclass.inc.php');
$errorhandler = new Error;
// Request class
include_once('request.php');
$request = new Request();
// Session
include_once('sess.php');
$sess = new Sess;
// start session
session_name('zvs');
session_start();
// systemtables
$tbl_country = $systemtable . '.zvs_country';
$tbl_user = $systemtable . '.zvs_user';
$tbl_group = $systemtable . '.zvs_group';
$tbl_default = $systemtable . '.zvs_default';
$tbl_hotel = $systemtable . '.zvs_hotel';
$tbl_hotel_default = $systemtable . '.zvs_hotel_default';
$tbl_salutation = $systemtable . '.zvs_salutation';
// auhtenification
include_once('authclass.inc.php');
$auth = new Auth;
// default data
include_once("defaultdataclass.inc.php");
$defaultdata = new DefaultData;
// Smarty Templating
include_once('Smarty.class.php');
$smarty = new Smarty;
// Configure Smarty
$smarty->template_dir = '../templates';
$smarty->compile_dir = '../templates_c';
$smarty->compile_check = true;
$smarty->force_compile = false;
$smarty->debugging = false;
$smarty->cache_dir = '../cache';
$smarty->caching = false;
$smarty->left_delimiter = '<%';
$smarty->right_delimiter = '%>';
// Metabase
include_once('metabase_database.php');
include_once('metabase_interface.php');

global $gDatasource;
global $gDatabase2;

$gDatasource = array('Type' => 'mysql',
    'Host' => $mysqlhost,
    'User' => $mysqluser,
    'Password' => $mysqlpassword,
    'IncludePath' => $metabasepath,
    'Persistent' => true,
    'Options' => array('UseTransactions' => 1,
        'DefaultTableType' => "INNODB"
        )
    );

$error = MetabaseSetupDatabase($gDatasource, &$gDatabase2);

if ($error != '') {
    $errorhandler->display('SQL', 'default.inc.php', $error);
    die;
} else {
    // select database
    MetabaseSetDatabase($gDatabase2, $systemtable);
} 

function setHotelDB()
{
    global $errorhandler, $gDatasource, $gDatabase, $request, $tbl_bookingcat;
    global $tbl_bararticle, $tbl_barguest, $tbl_bought, $tbl_bararticlecat, $tbl_period;

    $hoteltable = $request->GetVar('schema', 'session') . "_bar";

    $error = MetabaseSetupDatabase($gDatasource, &$gDatabase);

    if ($error != '') {
        $errorhandler->display('SQL', 'default.inc.php', $error);
        die;
    } else {
        // select database
        MetabaseSetDatabase($gDatabase, $hoteltable);
    } 
    // global variables for DB fields
    $tbl_bararticle = $hoteltable . '.zvs_bararticle';
    $tbl_barguest = $hoteltable . '.zvs_barguest';
    $tbl_bought = $hoteltable . '.zvs_bought';
    $tbl_bararticlecat = $hoteltable . '.zvs_bararticlecat';
    $tbl_period = $hoteltable . '.zvs_period';
	$tbl_bookingcat = $hoteltable . '.zvs_barbookingcat';
} 

function setZVSHotelDB()
{
    global $errorhandler, $gZVSDatabase, $request;
    global $tbl_zvs_bookingcat, $tbl_zvs_guest, $tbl_zvs_booking, $tbl_zvs_booking_detail;
	global $zvsmysqlhost, $zvsmysqlpassword, $zvsmysqluser, $metabasepath;

    $hoteltable = $request->GetVar('schema', 'session');
    $gZVSDatasource = array('Type' => 'mysql',
        'Host' => $zvsmysqlhost,
        'User' => $zvsmysqluser,
        'Password' => $zvsmysqlpassword,
        'IncludePath' => $metabasepath,
        'Persistent' => true,
        'Options' => array('UseTransactions' => 1,
            'DefaultTableType' => "INNODB"
            )
        );
    $error = MetabaseSetupDatabase($gZVSDatasource, &$gZVSDatabase);

    if ($error != '') {
        $errorhandler->display('SQL', 'default.inc.php', $error);
        die;
    } else {
        // select database
        MetabaseSetDatabase($gZVSDatabase, $hoteltable);
    } 
    // global variables for DB fields
    $tbl_zvs_bookingcat = $hoteltable . '.zvs_bookingcat';
	$tbl_zvs_guest = $hoteltable . '.zvs_guest';
	$tbl_zvs_booking = $hoteltable . '.zvs_booking';
	$tbl_zvs_booking_detail = $hoteltable . '.zvs_booking_detail';
} 

$smarty->assign('wwwroot', $wwwroot);
$smarty->assign('tpl_level', $request->GetVar('level', 'session'));
$smarty->assign('tpl_loggedin', $request->GetVar('firstname', 'session') . " " . $request->GetVar('lastname', 'session'));

?>