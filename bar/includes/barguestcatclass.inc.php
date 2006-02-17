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
* class Barguestcat
* 
* Class for barguestcategories
* 
* This class has all functions which are needed for the barguestcategories.
* 
* @since 2006-02-17
* @author Christian Ehret <chris@uffbasse.de> 
* @version $Id: barguestcatclass.inc.php,v 1.1 2006/02/17 15:56:53 ehret Exp $
*/
class barguestcat {
    /**
    * Barguestcat::getall()
    * 
    * This function returns all barguestcategories.
    * 
    * @return array articles
    * @access public 
	* @since 2006-02-17
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getall()
    {
        global $gDatabase2, $tbl_barguestcat, $request, $errorhandler;
        $barguestcat = array();

        $query = "SELECT pk_barguestcat_id, barguestcat
		                 FROM $tbl_barguestcat
						 WHERE ISNULL(deleted_date)
						 ORDER BY barguestcat  ";
        $result = MetabaseQuery($gDatabase2, $query);
        if (!$result) {
            $errorhandler -> display('SQL', 'Barguestcat::getall()', $query);
        } else {
            $row = 0;
			
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase2, $result)) == 0; ++$row) {

                $color = 0;
                if ($row % 2 <> 0) {
                    $color = 1;
                } 


                $barguestcat[$row] = array ('barguestcatid' => MetabaseFetchResult($gDatabase2, $result, $row, 0),
                    'barguestcat' => MetabaseFetchResult($gDatabase2, $result, $row, 1),
					'color' => $color
                    );

            } 
        } 
        return $barguestcat;
    } 

    /**
    * Barguestcat::saveupdate()
    * 
    * Save Barguestcategory as new or update existing one
    * 
    * @access public 
	* @since 2006-02-17
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function saveupdate()
    {
        global $gDatabase, $request, $tbl_barguestcat, $errorhandler;

        $barguestcatid = $request -> GetVar('frm_barguestcatid', 'post'); 
        // update
        if ($barguestcatid !== '0') {
            $query = sprintf("UPDATE $tbl_barguestcat SET 
			                 barguestcat = %s, 
							 updated_date = NOW(), 
							 fk_updated_user_id = %s 
							 WHERE pk_barguestcat_id = %s ",
                MetabaseGetTextFieldValue($gDatabase, $request -> GetVar('frm_barguestcat', 'post')),
                $request -> GetVar('uid', 'session'),
                $barguestcatid
                );
        } else { // new
            $name = "zvs_pk_barguestcat_id";
            $sequence = MetabaseGetSequenceNextValue($gDatabase, $name, &$barguestcatid);
            $query = sprintf("INSERT INTO $tbl_barguestcat
			                  (pk_barguestcat_id, barguestcat, inserted_date, fk_inserted_user_id, updated_date, fk_updated_user_id)
							  VALUES (%s, %s, NOW(), %s, NOW(), %s )",
				$barguestcatid,
                MetabaseGetTextFieldValue($gDatabase, $request -> GetVar('frm_barguestcat', 'post')),
                $request -> GetVar('uid', 'session'),
				$request -> GetVar('uid', 'session')
                );
        } 

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Barguestcat::saveupdate()', $query);
        } 
    } 

    /**
    * User::del()
    * 
    * Deletes an Barguestcat
    * 
    * @param number $Barguestcatid Barguestcat id
    * @access public 
	* @since 2006-02-17
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function del($barguestcatid)
    {
        global $gDatabase, $tbl_barguestcat, $errorhandler, $request;

            $query = sprintf("UPDATE $tbl_barguestcat SET 
							 deleted_date = NOW(), 
							 fk_deleted_user_id = %s 
							 WHERE pk_barguestcat_id = %s ",
                $request -> GetVar('uid', 'session'),
                $barguestcatid
                );		
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Barguestcat::del()', $query);
        } 

    } 

} 

?>
