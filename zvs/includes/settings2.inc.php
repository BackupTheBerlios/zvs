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

ini_set('magic_quotes_gpc', false);
ini_set('magic_quotes_runtime', false);
ini_set('magic_quotes_sybase', false);
ini_set('session.cookie_lifetime', 3600);

$metabasepath = $instpath . 'metabase';

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
session_name('zvs_employee');
session_start();

// systemtables
$tbl_country = $systemtable . '.zvs_country';
$tbl_user = $systemtable . '.zvs_user';
$tbl_employee = $systemtable . '.zvs_employee';
$tbl_employee_times = $systemtable . '.zvs_employee_times';
$tbl_default = $systemtable . '.zvs_default';
$tbl_hotel = $systemtable . '.zvs_hotel';
$tbl_hotel_default = $systemtable . '.zvs_hotel_default';
$tbl_salutation = $systemtable . '.zvs_salutation';

// auhtenification
include_once('authclass2.inc.php');
$auth = new Auth;

// default data
include_once("defaultdataclass.inc.php");
$defaultdata = new DefaultData;

// Smarty Templating
include_once('Smarty.class.php');
$smarty = new Smarty;

// Configure Smarty
$smarty -> template_dir = '../templates2';
$smarty -> compile_dir = '../templates2_c';
$smarty -> compile_check = true;
$smarty -> force_compile = false;
$smarty -> debugging = false;
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
    global $tbl_timetracker;

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

	$tbl_timetracker = $hoteltable. '.zvs_timetracker';
} 



$smarty -> assign('wwwroot', $wwwroot);

?>