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
* class RoomCategory
* 
* Class for categories for rooms
* 
* This class has all functions which are needed for the categories.
* 
* @since 2003-07-24
* @author Christian Ehret <chris@uffbasse.de> 
* @version $Id: roomcategoryclass.inc.php,v 1.1 2004/11/03 14:51:10 ehret Exp $
*/
class RoomCategory {
    /**
    * RoomCategory::getall()
    * 
    * This function returns all categories.
    * 
    * @return array categories
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getall()
    {
        global $gDatabase, $tbl_roomcat, $tbl_roomcat_article, $tbl_article, $errorhandler, $request;

        $cat = array();
        $query = "SELECT pk_roomcat_id, roomcat, price_type 
				  FROM $tbl_roomcat 
				  WHERE ISNULL(fk_deleted_user_id) 
				  ORDER BY roomcat";

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'RoomCategory::getall()', $query);
        } else {
            $row = 0;
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $color = 0;
                $articles = "";
                if ($row % 2 <> 0) {
                    $color = 1;
                } 
                $query = "SELECT a.article, ra.price_type, ra.person, ra.children, ra.children2, ra.children3, ra.included 
				          FROM $tbl_article a, $tbl_roomcat_article ra
						  WHERE a.pk_article_id = ra.pk_fk_article_id
						  AND ra.pk_fk_roomcat_id = " . MetabaseFetchResult($gDatabase, $result, $row, 0);

                $result2 = MetabaseQuery($gDatabase, $query);
                if (!$result2) {
                    $errorhandler->display('SQL', 'RoomCategory::getall()', $query);
                } else {
                    for ($row2 = 0; ($eor = MetabaseEndOfResult($gDatabase, $result2)) == 0; ++$row2) {
                        if ($articles !== "") {
                            $articles .= ",<br>";
                        } 
                        $text = "<b>" . MetabaseFetchResult($gDatabase, $result2, $row2, 0) . "</b><br>";
                        if (MetabaseFetchResult($gDatabase, $result2, $row2, 1) == 'PR') {
                            $text .= "pauschal";
                        } else {
                            $text .= "Pro Person f&uuml;r: <br>";
                            if (MetabaseFetchBooleanResult($gDatabase, $result2, $row2, 2)) {
                                $text .= "Erwachsene<br>";
                            } 
                            if (MetabaseFetchBooleanResult($gDatabase, $result2, $row2, 3)) {
                                $text .= $request->GetVar('children1', 'session') . "<br>";
                            } 
                            if (MetabaseFetchBooleanResult($gDatabase, $result2, $row2, 4)) {
                                $text .= $request->GetVar('children2', 'session') . "<br>";
                            } 
                            if (MetabaseFetchBooleanResult($gDatabase, $result2, $row2, 5)) {
                                $text .= $request->GetVar('children3', 'session') . "<br>";
                            } 
                        } 
                        if (MetabaseFetchBooleanResult($gDatabase, $result2, $row2, 6)) {
                            $text .= "Im Zimmerpreis enthalten<br>";
                        } 
                        $articles .= "<A ONMOUSEOVER=\" popup('$text','$wwwroot');\" ONMOUSEOUT=\"kill();\">" . MetabaseFetchResult($gDatabase, $result2, $row2, 0) . "</A>";
                    } 
                } 
                $cat[$row] = array ('catid' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                    'name' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                    'price_type' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                    'color' => $color,
                    'articles' => $articles,
                    );
            } 
        } 
        return $cat;
    } 

    /**
    * RoomCategory::saveupdate()
    * 
    * Save category as new or update existing one
    * 
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function saveupdate()
    {
        global $gDatabase, $request, $tbl_roomcat, $errorhandler;

        $catid = $request->GetVar('frm_catid', 'post'); 
        // update
        if ($catid !== '0') {
            $query = sprintf("UPDATE $tbl_roomcat SET
							  roomcat = %s, 
							  price_type = %s,
							  updated_date = NOW(),
							  fk_updated_user_id = %s 
							  WHERE pk_roomcat_id = %s ",
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_cat', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_price_type', 'post')),
                $request->GetVar('uid', 'session'),
                $catid
                );
        } else { // new
            $name = "zvs_pk_roomcat_id";
            $sequence = MetabaseGetSequenceNextValue($gDatabase, $name, &$catid);
            $query = sprintf("INSERT INTO $tbl_roomcat 
							(pk_roomcat_id, roomcat, price_type, inserted_date, fk_inserted_user_id)
							VALUES (%s, %s, %s, NOW(), %s )",
                $catid,
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_cat', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_price_type', 'post')),
                $request->GetVar('uid', 'session')
                );
        } 

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'RoomCategory::saveupdate()', $query);
        } 
    } 

    /**
    * RoomCategory::del()
    * 
    * Deletes a category
    * 
    * @param number $catid category id
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function del($catid)
    {
        global $gDatabase, $tbl_roomcat, $request, $errorhandler;

        $query = sprintf("UPDATE $tbl_roomcat SET 
							deleted_date = NOW(),
							fk_deleted_user_id = %s 
							WHERE pk_roomcat_id = %s ",
            $request->GetVar('uid', 'session'),
            $catid
            );

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'RoomCategory::del()', $query);
        } 
    } 

    /**
    * RoomCategory::get()
    * 
    * This function returns all categories of a price_type.
    * 
    * @param char $price_type price type
    * @return array categories
    * @access public 
    * @since 2004-03-20
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function get($price_type)
    {
        global $gDatabase, $tbl_roomcat, $errorhandler, $request;

        $cat = array();
        $query = sprintf("SELECT pk_roomcat_id, roomcat, price_type 
				  FROM $tbl_roomcat 
				  WHERE ISNULL(fk_deleted_user_id) 
				  AND price_type = %s
				  ORDER BY roomcat",
				  MetabaseGetTextFieldValue($gDatabase,$price_type)
            );

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'RoomCategory::get()', $query);
        } else {
            $row = 0;
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $color = 0;
                $articles = "";
                if ($row % 2 <> 0) {
                    $color = 1;
                } 
                 $cat[$row] = array ('catid' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                    'name' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                    'price_type' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                    'color' => $color
                    );
            } 
        } 
        return $cat;
    } 
} 

?>
