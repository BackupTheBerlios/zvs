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
* class bcat
* 
* Class for booking categories functionality
* 
* This class has all functions which are needed for the booking categories.
* 
* @since 2003-07-24
* @author Christian Ehret <chris@uffbasse.de> 
* @version $Id: bookingcategoryclass.inc.php,v 1.1 2004/11/03 14:39:17 ehret Exp $
*/
class BookingCategory {
    /**
    * bcat::get()
    * 
    * get all categories
    * 
    * @return array booking categories
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function get()
    {
        global $gDatabase, $tbl_bookingcat, $errorhandler, $request;

        $bcat = array();
        $query = "SELECT pk_bookingcat_id, bookingcat, color, description, days 
				  FROM $tbl_bookingcat 
				  WHERE ISNULL(fk_deleted_user_id)
				  ORDER BY bookingcat ";

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler -> display('SQL', 'BookingCategory::getall()', $query);
        } else {
            $row = 0;
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $color = 0;
                if ($row % 2 <> 0) {
                    $color = 1;
                } 

                $bcat[$row] = array ('bcatid' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                    'name' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                    'catcolor' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                    'description' => MetabaseFetchResult($gDatabase, $result, $row, 3),
					'days' => MetabaseFetchResult($gDatabase, $result, $row, 4),
                    'color' => $color
                    );
            } 
        } 
        return $bcat;
    } 

    /**
    * bcat::del()
    * 
    * delete a category
    * 
    * @param number $bcatid booking category id
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function del($bcatid)
    {
        global $gDatabase, $tbl_bookingcat, $request;

        $query = sprintf("UPDATE $tbl_bookingcat SET
						  deleted_date = NOW(), 
						  fk_deleted_user_id = %s 
						  WHERE pk_bookingcat_id = %s ",
            $request -> GetVar('uid', 'session'),
            $bcatid
            );

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler -> display('SQL', 'BookingCategory::del()', $query);
        } 
    } 

    /**
    * bcat::saveupdate()
    * 
    * save or update a booking category
    * 
    * @return number booking category id
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function saveupdate()
    {
        global $gDatabase, $request, $tbl_bookingcat, $errorhandler;

        $bcatid = $request -> GetVar('frm_bcatid', 'post'); 
        // update
        if ($bcatid !== '0') {
            $query = sprintf("UPDATE $tbl_bookingcat SET 
							  bookingcat = %s, 
							  color = %s, 
							  description = %s, 
							  days = %s,
							  updated_date = NOW(), 
							  fk_updated_user_id = %s 
							  WHERE pk_bookingcat_id = %s ",
                MetabaseGetTextFieldValue($gDatabase, $request -> GetVar('frm_name', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request -> GetVar('frm_color', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request -> GetVar('frm_description', 'post')),
				$request->GetVar('frm_days', 'post'),
                $request -> GetVar('uid', 'session'),
                $bcatid
                );
        } else { // new
            $name = "zvs_pk_bookingcat_id";
            $sequence = MetabaseGetSequenceNextValue($gDatabase, $name, &$bcatid);
            $query = sprintf("INSERT INTO $tbl_bookingcat
							 (pk_bookingcat_id, bookingcat, color, description, days, inserted_date, fk_inserted_user_id )
							 VALUES (%s, %s, %s, %s, %s, NOW(), %s )",
                $bcatid,
                MetabaseGetTextFieldValue($gDatabase, $request -> GetVar('frm_name', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request -> GetVar('frm_color', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request -> GetVar('frm_description', 'post')),
				$request->GetVar('frm_days','post'),
                $request -> GetVar('uid', 'session')
                );
        } 

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler -> display('SQL', 'BookingCategory::saveupdate()', $query);
        } else {
            return $bcatid;
        } 
    } 
} 

?>
