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
* class Pay Category
* 
* Class for categories for account (things like credit card, cash, ...)
* 
* This class has all functions which are needed for the categories.
* 
* @since 2004-03-16
* @author Christian Ehret <chris@uffbasse.de> 
* @version $Id: paycategoryclass.inc.php,v 1.1 2004/11/03 14:48:26 ehret Exp $
*/
class PayCategory {
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
        global $gDatabase, $tbl_paycat, $errorhandler, $request;

        $cat = array();
        $query = "SELECT pk_paycat_id, paycat
		          FROM $tbl_paycat
				  WHERE ISNULL(fk_deleted_user_id) 
				  ORDER BY paycat";
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'PayCategory::getall()', $query);
        } else {
            $row = 0;
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $color = 0;
                if ($row % 2 <> 0) {
                    $color = 1;
                } 

                $cat[$row] = array ('catid' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                    'cat' => MetabaseFetchResult($gDatabase, $result, $row, 1),
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
    * 
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function saveupdate()
    {
        global $gDatabase, $request, $tbl_paycat, $errorhandler;

        $catid = $request->GetVar('frm_catid', 'post'); 
        // update
        if ($catid !== '0') {
            $query = sprintf("UPDATE $tbl_paycat SET 
			                  paycat = %s, 
							  updated_date = NOW(), 
							  fk_updated_user_id = %s 
							  WHERE pk_paycat_id = %s ",
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_cat', 'post')),
                $request->GetVar('uid', 'session'),
                $catid
                );
        } else { // new
            $name = "zvs_pk_paycat_id";
            $sequence = MetabaseGetSequenceNextValue($gDatabase, $name, &$catid);
            $query = sprintf("INSERT INTO $tbl_paycat
			               (pk_paycat_id, paycat, inserted_date, fk_inserted_user_id )
						   VALUES (%s, %s, NOW(), %s)",
                $catid,
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_cat', 'post')),
                $request->GetVar('uid', 'session')
                );
        } 

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'PayCategory::saveupdate()', $query);
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
        global $gDatabase, $tbl_paycat, $request, $errorhandler;

        $query = sprintf("UPDATE $tbl_paycat 
						SET deleted_date = NOW(), 
						fk_deleted_user_id = %s 
						WHERE pk_paycat_id = %s ",
            $request->GetVar('uid', 'session'),
            $catid
            );

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'PayCategory::del()', $query);
        } 
    } 

} 

?>
