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
* class Category
* 
* Class for categories for guests (things like Family, Sport, ...)
* 
* This class has all functions which are needed for the categories.
* 
* @since 2003-07-24
* @author Christian Ehret <chris@uffbasse.de> 
* @version $Id: guestcategoryclass.inc.php,v 1.1 2004/11/03 14:46:21 ehret Exp $
*/
class GuestCategory {
    /**
    * Category::getall()
    * 
    * This function returns all categories.
    * 
    * @return array 	
	* @access public 
	* @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getall()
    {
        global $gDatabase, $tbl_guestcat, $errorhandler, $request;

        $cat = array();
        $query = "SELECT pk_guestcat_id, guestcat, description " . "FROM $tbl_guestcat " . "WHERE ISNULL(fk_deleted_user_id) " . "ORDER BY guestcat";
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler -> display('SQL', 'GuestCategory::getall()', $query);
        } else {
            $row = 0;
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $color = 0;
                if ($row % 2 <> 0) {
                    $color = 1;
                } 

                $cat[$row] = array ('catid' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                    'cat' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                    'description' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                    'color' => $color
                    );
            } 
        } 
        return $cat;
    } 

    /**
    * Category::saveupdate()
    * 
    * Save category as new or update existing 	
	* @access public 
	* @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function saveupdate()
    {
        global $gDatabase, $request, $tbl_guestcat, $errorhandler;

        $catid = $request -> GetVar('frm_catid', 'post'); 
        // update
        if ($catid !== '0') {
            $query = sprintf("UPDATE $tbl_guestcat SET " . "guestcat = %s, " . "description = %s, " . "updated_date = NOW(), " . "fk_updated_user_id = %s " . "WHERE pk_guestcat_id = %s ",
                MetabaseGetTextFieldValue($gDatabase, $request -> GetVar('frm_cat', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request -> GetVar('frm_description', 'post')),
                $request -> GetVar('uid', 'session'),
                $catid
                );
        } else 
            { // new
                $name = "zvs_pk_guestcat_id";
            $sequence = MetabaseGetSequenceNextValue($gDatabase, $name, &$catid);
            $query = sprintf("INSERT INTO $tbl_guestcat" . "(pk_guestcat_id, guestcat, description, inserted_date, fk_inserted_user_id )" . "VALUES (%s, %s, %s, NOW(), %s)",
                $catid,
                MetabaseGetTextFieldValue($gDatabase, $request -> GetVar('frm_cat', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request -> GetVar('frm_description', 'post')),
                $request -> GetVar('uid', 'session')
                );
        } 

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler -> display('SQL', 'GuestCategory::saveupdate()', $query);
        } 
    } 

    /**
    * Category::del()
    * 
    * Deletes a category
    * 
    * @param number $catid category 	
	* @access public 
	* @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function del($catid)
    {
        global $gDatabase, $tbl_guestcat, $request, $errorhandler;

        $query = sprintf("UPDATE $tbl_guestcat " . "SET deleted_date = NOW(), " . "fk_deleted_user_id = %s " . "WHERE pk_guestcat_id = %s ",
            $request -> GetVar('uid', 'session'),
            $catid
            );

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler -> display('SQL', 'GuestCategory::del()', $query);
        } 
    } 

    /**
    * Category::subscribe()
    * 
    * Subscribe a guest to a category
    * 
    * @param number $guestid id of a guest
    * @param number $catid id of the category
	* @access public 
	* @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function subscribe($guestid, $catid)
    {
        global $gDatabase, $request, $tbl_guest_guestcat, $errorhandler;
        $query = sprintf("INSERT INTO  $tbl_guest_guestcat " . "(pk_fk_guest_id, pk_fk_guestcat_id) " . "VALUES " . "(%s, %s) ",
            $guestid,
            $catid
            );
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler -> display('SQL', 'GuestCategory::subscribe()', $query);
        } 
    } 

    /**
    * Category::unsubscribe()
    * 
    * Unsubscribe a guest to a category
    * 
    * @param number $guestid id of the guest
    * @param number $catid id of the 	
	* @access public 
	* @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function unsubscribe($guestid, $catid)
    {
        global $gDatabase, $request, $tbl_guest_guestcat, $errorhandler;
        $query = sprintf("DELETE FROM $tbl_guest_guestcat " . "WHERE pk_fk_guest_id = %s " . "AND pk_fk_guestcat_id = %s ",
            $guestid,
            $catid
            );
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler -> display('SQL', 'GuestCategory::unsubscribe()', $query);
        } 
    } 

    /**
    * Category::getsubscribed()
    * 
    * Get categories a guest is subscribed to
    * 
    * @param number $guestid id of the guest
    * @return array categories
	* @access public 
	* @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getsubscribed($guestid)
    {
        global $gDatabase, $tbl_guestcat, $tbl_guest_guestcat, $errorhandler;

        $cat = array();
        $query = sprintf("SELECT pk_guestcat_id, guestcat, description " . "FROM $tbl_guestcat, $tbl_guest_guestcat " . "WHERE pk_fk_guest_id = %s " . "AND $tbl_guestcat.pk_guestcat_id = $tbl_guest_guestcat.pk_fk_guestcat_id " . "ORDER BY guestcat",
            $guestid
            );
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler -> display('SQL', 'GuestCategory::getsubscribed()', $query);
        } else {
            $row = 0;
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $cat[$row] = array ('catid' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                    'cat' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                    'description' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                    );
            } 
        } 
        return $cat;
    } 

    /**
    * Category::getallwithstatus()
    * 
    * Get all categories with status if
    * subscribed or not
    * 
    * @param number $guestid id of the guest
    * @return array categories and 	
	* @access public 
	* @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getallwithstatus($guestid)
    {
        global $gDatabase, $request, $tbl_guest_guestcat, $errorhandler;

        $allcat = $this -> getall();

        $cat = array();
        $query = sprintf("SELECT pk_fk_guestcat_id " . "FROM $tbl_guest_guestcat " . "WHERE pk_fk_guest_id = %s ",
            $guestid
            );

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler -> display('SQL', 'GuestCategory::getallwithstatus()', $query);
        } else {
            $row = 0;
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $cat[$row] = array ('catid' => MetabaseFetchResult($gDatabase, $result, $row, 0)
                    );
            } 
        } 

        for ($i = 0; $i < count($allcat); $i++) {
            $allcat[$i][subscribed] = 'no';
            for ($j = 0; $j < count($cat); $j++) {
                if ($allcat[$i][catid] == $cat[$j][catid]) {
                    $allcat[$i][subscribed] = 'yes';
                } 
            } 
        } 

        return $allcat;
    } 
} 

?>
