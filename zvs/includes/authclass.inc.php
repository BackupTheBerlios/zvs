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
* class auth
* 
* Class for authentification functionality
* 
* This class has all functions which are needed for the authentification.
* 
* @since 2003-07-24
* @author Christian Ehret <chris@uffbasse.de> 
* @version $Id: authclass.inc.php,v 1.1 2004/11/03 14:39:00 ehret Exp $
*/

class auth {
    /**
    * auth::is_authenticated()
    * 
    * check if there is a valid authentification
    * 
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function is_authenticated()
    {
        global $request, $defaultdata, $hoteltable;
        if ($request -> GetVar('authenticated', 'session') == 'valid') {
            setHotelDB();
            $defaultdata -> load();
            return true;
        } else {
            if ($this -> auth_validatelogin()) {
                setHotelDB();
                $defaultdata -> load();
                return true;
            } else {
                include_once('login.php');
                exit;
            } 
        } 
    } 

    /**
    * auth::auth_validatelogin()
    * 
    * validate login
    * 
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    * @return number user id
    */
    function auth_validatelogin()
    {
        global $gDatabase2, $tbl_user, $tbl_hotel, $uid, $firstname, $request, $sess, $smarty, $errorhandler;
        $auth_challenge = session_id();
        $auth_username = $request -> GetVar('username', 'post');
        $auth_password = $request -> GetVar('password', 'post');
        $auth_response = $request -> GetVar('response', 'post');

        $this -> auth["uname"] = $auth_username; ## This provides access for "loginform.ihtml"
        $query = sprintf("SELECT u.pk_user_id, u.password, u.firstname, u.lastname, 
		                  u.login, u.fk_hotel_id, h.database_schema, h.hotel_code 
						  FROM $tbl_user u, $tbl_hotel h 
						  WHERE u.login = %s 
						  AND u.locked = %s 
						  AND ISNULL(deleted_date)
						  AND u.fk_hotel_id = h.pk_hotel_id ",
            MetabaseGetTextFieldValue($gDatabase2, addslashes($auth_username)),
            MetabaseGetBooleanFieldValue($gDatabase2, false)
            );
        $result = MetabaseQuery($gDatabase2, $query);
        if (!$result) {
            $errorhandler -> display('SQL', 'auth::auth_validatelogin()', $query);
        } else {
            if (MetabaseNumberOfRows($gDatabase2, $result) <> 0) {
                if ($result) {
                    $uid = MetabaseFetchResult($gDatabase2, $result, 0, 0);
                    $pass = MetabaseFetchResult($gDatabase2, $result, 0, 1); ## Password is stored as a md5 hash
                    $firstname = MetabaseFetchResult($gDatabase2, $result, 0, 2);
                    $lastname = MetabaseFetchResult($gDatabase2, $result, 0, 3);
                    $login = MetabaseFetchResult($gDatabase2, $result, 0, 4);
                    $hotelid = MetabaseFetchResult($gDatabase2, $result, 0, 5);
                    $schema = MetabaseFetchResult($gDatabase2, $result, 0, 6);
                    $hotel_code = MetabaseFetchResult($gDatabase2, $result, 0, 7);
                } 
            } 
        } 
        $exspected_response = md5("$auth_username:$pass:$auth_challenge"); 
        // # True when JS is disabled
        if ($auth_response == "") {
            if (md5($auth_password) != $pass) { // # md5 hash for non-JavaScript browsers
                return false;
            } else {
                $sess -> SetVar("firstname", $firstname);
                $sess -> SetVar("lastname", $lastname);
                $sess -> SetVar("login", $login);
                $sess -> SetVar("uid", $uid);
                $sess -> SetVar("authenticated", 'valid');
                $sess -> SetVar("hotelid", $hotelid);
                $sess -> SetVar("schema", $schema);
                $sess -> SetVar("hotel_code", $hotel_code);
                return $uid;
            } 
        } 
        // # Response is set, JS is enabled
        if ($exspected_response != $auth_response) {
            return false;
        } else {
            $sess -> SetVar('firstname', $firstname);
            $sess -> SetVar('lastname', $lastname);
            $sess -> SetVar('login', $login);
            $sess -> SetVar('uid', $uid);
            $sess -> SetVar('authenticated', 'valid');
            $sess -> SetVar("hotelid", $hotelid);
            $sess -> SetVar("schema", $schema);
            $sess -> SetVar("hotel_code", $hotel_code);
            return $uid;
        } 
    } 
} 

?>
