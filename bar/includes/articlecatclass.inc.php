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
* class Articlecat
* 
* Class for articlecategories
* 
* This class has all functions which are needed for the articlecategories.
* 
* @since 2004-08-30
* @author Christian Ehret <chris@uffbasse.de> 
* @version $Id: articlecatclass.inc.php,v 1.2 2004/11/03 16:33:52 ehret Exp $
*/
class Articlecat {
    /**
    * Articlecat::getall()
    * 
    * This function returns all articlecategories.
    * 
    * @return array articles
    * @access public 
	* @since 2004-09-30
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getall()
    {
        global $gDatabase2, $tbl_bararticlecat, $request, $errorhandler;
        $articlecat = array();

        $query = "SELECT pk_bararticlecat_id, bararticlecat
		                 FROM $tbl_bararticlecat
						 WHERE ISNULL(deleted_date)
						 ORDER BY bararticlecat  ";
        $result = MetabaseQuery($gDatabase2, $query);
        if (!$result) {
            $errorhandler -> display('SQL', 'Articlecat::getall()', $query);
        } else {
            $row = 0;
			
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase2, $result)) == 0; ++$row) {

                $color = 0;
                if ($row % 2 <> 0) {
                    $color = 1;
                } 


                $articlecat[$row] = array ('articlecatid' => MetabaseFetchResult($gDatabase2, $result, $row, 0),
                    'articlecat' => MetabaseFetchResult($gDatabase2, $result, $row, 1),
					'color' => $color
                    );

            } 
        } 
        return $articlecat;
    } 

    /**
    * Articlecat::saveupdate()
    * 
    * Save articlecategory as new or update existing one
    * 
    * @access public 
	* @since 2004-08-30
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function saveupdate()
    {
        global $gDatabase, $request, $tbl_bararticlecat, $errorhandler;

        $articlecatid = $request -> GetVar('frm_articlecatid', 'post'); 
        // update
        if ($articlecatid !== '0') {
            $query = sprintf("UPDATE $tbl_bararticlecat SET 
			                 bararticlecat = %s, 
							 updated_date = NOW(), 
							 fk_updated_user_id = %s 
							 WHERE pk_bararticlecat_id = %s ",
                MetabaseGetTextFieldValue($gDatabase, $request -> GetVar('frm_articlecat', 'post')),
                $request -> GetVar('uid', 'session'),
                $articlecatid
                );
        } else { // new
            $name = "zvs_pk_bararticlecat_id";
            $sequence = MetabaseGetSequenceNextValue($gDatabase, $name, &$articlecatid);
            $query = sprintf("INSERT INTO $tbl_bararticlecat
			                  (pk_bararticlecat_id, bararticlecat, inserted_date, fk_inserted_user_id, updated_date, fk_updated_user_id)
							  VALUES (%s, %s, NOW(), %s, NOW(), %s )",
				$articlecatid,
                MetabaseGetTextFieldValue($gDatabase, $request -> GetVar('frm_articlecat', 'post')),
                $request -> GetVar('uid', 'session'),
				$request -> GetVar('uid', 'session')
                );
        } 

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Articlecat::saveupdate()', $query);
        } 
    } 

    /**
    * User::del()
    * 
    * Deletes an articlecat
    * 
    * @param number $articlecatid articlecat id
    * @access public 
	* @since 2004-08-30
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function del($articlecatid)
    {
        global $gDatabase, $tbl_bararticlecat, $errorhandler, $request;

            $query = sprintf("UPDATE $tbl_bararticlecat SET 
							 deleted_date = NOW(), 
							 fk_deleted_user_id = %s 
							 WHERE pk_bararticlecat_id = %s ",
                $request -> GetVar('uid', 'session'),
                $articlecatid
                );		
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Articlecat::del()', $query);
        } 

    } 

} 

?>
