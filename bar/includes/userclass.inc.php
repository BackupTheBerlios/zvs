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
* class User
* 
* Class for user
* 
* This class has all functions which are needed for the users.
* 
* @since 2003-07-24
* @author Christian Ehret <chris@uffbasse.de> 
* @version $Id: userclass.inc.php,v 1.2 2004/11/03 16:33:52 ehret Exp $
*/
class User {
    /**
    * Category::getall()
    * 
    * This function returns all users.
    * 
    * @return array users
    * @access public 
	* @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getall()
    {
        global $gDatabase2, $tbl_user, $request, $errorhandler;

        $user = array();
        $query = sprintf("SELECT pk_user_id, lastname, firstname, login 
		                 FROM $tbl_user 
						 WHERE fk_hotel_id = %s 
						 AND ISNULL(deleted_date)
						 ORDER BY lastname ",
            $request -> GetVar('hotelid', 'session')
            );
        $result = MetabaseQuery($gDatabase2, $query);
        if (!$result) {
            $errorhandler -> display('SQL', 'Guest::quickinsert()', $query);
        } else {
            $row = 0;
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase2, $result)) == 0; ++$row) {
                $color = 0;
                if ($row % 2 <> 0) {
                    $color = 1;
                } 

                $user[$row] = array ('userid' => MetabaseFetchResult($gDatabase2, $result, $row, 0),
                    'lastname' => MetabaseFetchResult($gDatabase2, $result, $row, 1),
                    'firstname' => MetabaseFetchResult($gDatabase2, $result, $row, 2),
                    'login' => MetabaseFetchResult($gDatabase2, $result, $row, 3),
                    'color' => $color
                    );
            } 
        } 
        return $user;
    } 

    /**
    * User::saveupdate()
    * 
    * Save user as new or update existing one
    * 
    * @access public 
	* @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function saveupdate()
    {
        global $gDatabase2, $request, $tbl_user, $errorhandler;

        $userid = $request -> GetVar('frm_userid', 'post'); 
        // update
        if ($userid !== '0') {
            $query = sprintf("UPDATE $tbl_user SET 
							 fk_hotel_id = %s,
			                 lastname = %s, 
							 firstname = %s,
							 login = %s,
							 password = %s,
							 locked = %s,
							 fk_language_id = %s,
							 updated_date = NOW(), 
							 fk_updated_user_id = %s 
							 WHERE pk_user_id = %s ",
				$request -> GetVar('hotelid', 'session'),
                MetabaseGetTextFieldValue($gDatabase2, $request -> GetVar('frm_last', 'post')),
                MetabaseGetTextFieldValue($gDatabase2, $request -> GetVar('frm_first', 'post')),
                MetabaseGetTextFieldValue($gDatabase2, $request -> GetVar('frm_login', 'post')),
                MetabaseGetTextFieldValue($gDatabase2, $request -> GetVar('response', 'post')),												
				MetabaseGetBooleanFieldValue($gDatabase2, false),
				1,
                $request -> GetVar('uid', 'session'),
                $userid
                );
        } else { // new
            $name = "zvs_pk_user_id";
            $sequence = MetabaseGetSequenceNextValue($gDatabase2, $name, &$userid);
            $query = sprintf("INSERT INTO $tbl_user
			                  (pk_user_id, fk_hotel_id, lastname, firstname, login, password, locked, fk_language_id, inserted_date, fk_inserted_user_id, updated_date, fk_updated_user_id)
							  VALUES (%s, %s, %s, %s, %s, %s, %s, %s, NOW(), %s, NOW(), %s )",
				$userid,
				$request -> GetVar('hotelid', 'session'),
                MetabaseGetTextFieldValue($gDatabase2, $request -> GetVar('frm_last', 'post')),
                MetabaseGetTextFieldValue($gDatabase2, $request -> GetVar('frm_first', 'post')),
                MetabaseGetTextFieldValue($gDatabase2, $request -> GetVar('frm_login', 'post')),
                MetabaseGetTextFieldValue($gDatabase2, $request -> GetVar('response', 'post')),												
				MetabaseGetBooleanFieldValue($gDatabase2, false),
				1,
                $request -> GetVar('uid', 'session'),
				$request -> GetVar('uid', 'session')
                );
        } 

        $result = MetabaseQuery($gDatabase2, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'User::saveupdate()', $query);
        } 
    } 

    /**
    * User::del()
    * 
    * Deletes a user
    * 
    * @param number $userid user id
    * @access public 
	* @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function del($userid)
    {
        global $gDatabase2, $tbl_user, $errorhandler, $request;

            $query = sprintf("UPDATE $tbl_user SET 
							 locked = %s,
							 deleted_date = NOW(), 
							 fk_deleted_user_id = %s 
							 WHERE pk_user_id = %s ",
				MetabaseGetBooleanFieldValue($gDatabase2, true),
                $request -> GetVar('uid', 'session'),
                $userid
                );		
        $result = MetabaseQuery($gDatabase2, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'User::del()', $query);
        } 

    } 

} 

?>
