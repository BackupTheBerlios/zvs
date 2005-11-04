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

# no caching
header('Expires: 0');
header('Content-Type: text/html; charset=utf-8');

# needed for rtf output
if (!isset($nocachecontrol)) {
	header('Pragma: no-cache');
	header('Cache-Control: no-cache, no-store, must-revalidate');
} 


ini_set('magic_quotes_gpc', false);
ini_set('magic_quotes_runtime', false);
ini_set('magic_quotes_sybase', false);
ini_set('session.cookie_lifetime', 0);

$metabasepath = $instpath . '/ext/metabase';
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
$tbl_employee = $systemtable . '.zvs_employee';
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
include_once('multilanguage.php');

$smarty = new smartyML();
//$smarty = new Smarty;
// Configure Smarty
$smarty -> template_dir = '../templates_v2';
$smarty -> compile_dir = '../templates_v2_c';
$smarty -> compile_check = true;
$smarty -> force_compile = false;
$smarty -> debugging = true;
$smarty -> cache_dir = '../cache';
$smarty -> caching = false;
$smarty -> left_delimiter = '<%';
$smarty -> right_delimiter = '%>';
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
    $errorhandler -> display('SQL', 'default.inc.php', $error);
    die;
} else {
    // select database
    MetabaseSetDatabase($gDatabase2, $systemtable);
} 

function setHotelDB()
{
    global $errorhandler, $gDatasource, $gDatabase, $request;
    global $tbl_guest, $tbl_address, $tbl_guest_address, $tbl_gast_begleit,
    $tbl_begleit, $tbl_guestcat, $tbl_guest_guestcat, $tbl_room,
    $tbl_roomcat, $tbl_bookingcat, $tbl_booking, $tbl_booking_detail,
    $tbl_booking_detail_guest, $tbl_season, $tbl_price, $tbl_receipt, $tbl_receipt_item,
	$tbl_article, $tbl_roomcat_article, $tbl_account, $tbl_paycat, $tbl_price2, $tbl_receiptnumber,
	$tbl_receipt_booking, $tbl_draftreceipt_booking, $tbl_draftreceipt, $tbl_draftreceipt_item,
	$tbl_timetracker;

    $hoteltable = $request -> GetVar('schema', 'session');

    $error = MetabaseSetupDatabase($gDatasource, &$gDatabase);

    if ($error != '') {
        $errorhandler -> display('SQL', 'default.inc.php', $error);
        die;
    } else {
        // select database
        MetabaseSetDatabase($gDatabase, $hoteltable);
    } 
    // global variables for DB fields
    $tbl_guest = $hoteltable . '.zvs_guest';
    $tbl_address = $hoteltable . '.zvs_address';
    $tbl_guest_address = $hoteltable . '.zvs_guest_address';
    $tbl_gast_begleit = $hoteltable . '.zvs_guest_escort';
    $tbl_begleit = $hoteltable . '.zvs_escort';
    $tbl_guestcat = $hoteltable . '.zvs_guestcat';
    $tbl_guest_guestcat = $hoteltable . '.zvs_guest_guestcat';
    $tbl_room = $hoteltable . '.zvs_room';
    $tbl_roomcat = $hoteltable . '.zvs_roomcat';
    $tbl_bookingcat = $hoteltable . '.zvs_bookingcat';
    $tbl_booking = $hoteltable . '.zvs_booking';
    $tbl_booking_detail = $hoteltable . '.zvs_booking_detail';
    $tbl_booking_detail_guest = $hoteltable . '.zvs_booking_detail_guest';
	$tbl_season = $hoteltable . '.zvs_season';
	$tbl_price = $hoteltable . '.zvs_price';
	$tbl_receipt = $hoteltable. '.zvs_receipt';
	$tbl_receipt_item = $hoteltable. '.zvs_receipt_item';	
	$tbl_article = $hoteltable . '.zvs_article';
	$tbl_roomcat_article = $hoteltable . '.zvs_roomcat_article';
	$tbl_account = $hoteltable . '.zvs_account';
	$tbl_paycat = $hoteltable . '.zvs_paycat';
	$tbl_price2 = $hoteltable . '.zvs_price2';
	$tbl_receiptnumber = $hoteltable . '.zvs_receiptnumber';
	$tbl_receipt_booking = $hoteltable . '.zvs_receipt_booking';
	$tbl_draftreceipt_booking = $hoteltable . '.zvs_draftreceipt_booking';	
	$tbl_draftreceipt = $hoteltable. '.zvs_draftreceipt';
	$tbl_draftreceipt_item = $hoteltable. '.zvs_draftreceipt_item';	
	$tbl_timetracker = $hoteltable. '.zvs_timetracker';
} 

$smarty -> assign('wwwroot', $wwwroot);

?>