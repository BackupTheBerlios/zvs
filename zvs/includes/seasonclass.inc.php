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
* class season
* 
* Class for season functionality
* 
* This class has all functions which are needed for the seasons.
* 
* @since 2003-12-24
* @author Christian Ehret <chris@uffbasse.de> 
* @version $Id: seasonclass.inc.php,v 1.1 2004/11/03 14:51:54 ehret Exp $
*/
class season {
    /**
    * season::get()
    * 
    * get all seasons
    * 
    * @return array seasons
    * @access public 
    * @since 2003-12-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function get()
    {
        global $gDatabase, $tbl_season, $tbl_booking, $errorhandler, $request;

        $season = array();
        $query = "SELECT pk_season_id, name, DATE_FORMAT(start_date, '%d.%m.%Y'), DATE_FORMAT(end_date, '%d.%m.%Y') 
		          FROM $tbl_season 
				  WHERE ISNULL(fk_deleted_user_id) 
				  ORDER BY start_date ";

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler -> display('SQL', 'Season::get()', $query);
        } else {
            $row = 0;
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $color = 0;
                if ($row % 2 <> 0) {
                    $color = 1;
                } 

                $season[$row] = array ('seasonid' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                    'name' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                    'start_date' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                    'end_date' => MetabaseFetchResult($gDatabase, $result, $row, 3),
                    'color' => $color
                    );
            } 
        } 
        return $season;
    } 

    /**
    * season::del()
    * 
    * delete a season
    * 
    * @param number $seasonid season id
    * @access public 
    * @since 2003-12-31
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function del($seasonid)
    {
        global $gDatabase, $tbl_season, $request, $errorhandler;

        $query = sprintf("UPDATE $tbl_season SET 
		                 deleted_date = NOW(), 
						 fk_deleted_user_id = %s 
						 WHERE pk_season_id = %s ",
            $request -> GetVar('uid', 'session'),
            $seasonid
            );

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler -> display('SQL', 'Season::del()', $query);
        } 
    } 

    /**
    * season::saveupdate()
    * 
    * save or update a season
    * 
    * @return number season id
    * @access public 
    * @since 2003-12-31
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function saveupdate()
    {
        global $gDatabase, $request, $tbl_season, $errorhandler;

        $seasonid = $request -> GetVar('frm_seasonid', 'post'); 
		$startdate = explode(".", $request -> GetVar('frm_start', 'post'));
        $strstartdate = $startdate[2] . "-" . $startdate[1] . "-" . $startdate[0]; 
		$enddate = explode(".", $request -> GetVar('frm_end', 'post'));
        $strenddate = $enddate[2] . "-" . $enddate[1] . "-" . $enddate[0]; 		
        // update
        if ($seasonid !== '0') {
            $query = sprintf("UPDATE $tbl_season SET 
			                  name = %s, 
							  start_date = %s,
							  end_date = %s, 
							  updated_date = NOW(), 
							  fk_updated_user_id = %s 
							  WHERE pk_season_id = %s ",
                MetabaseGetTextFieldValue($gDatabase, $request -> GetVar('frm_name', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $strstartdate),
                MetabaseGetTextFieldValue($gDatabase, $strenddate),
                $request -> GetVar('uid', 'session'),
                $seasonid
                );
        } else { // new
            $name = "zvs_pk_season_id";
            $sequence = MetabaseGetSequenceNextValue($gDatabase, $name, &$seasonid);
            $query = sprintf("INSERT INTO $tbl_season 
			                  (pk_season_id, name, start_date, end_date, inserted_date, fk_inserted_user_id )
							   VALUES (%s, %s, %s, %s, NOW(), %s )",
                $seasonid,
                MetabaseGetTextFieldValue($gDatabase, $request -> GetVar('frm_name', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $strstartdate),
                MetabaseGetTextFieldValue($gDatabase, $strenddate),
                $request -> GetVar('uid', 'session')
                );
        } 

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler -> display('SQL', 'Season::saveupdate()', $query);
        } else {
            return $seasonid;
        } 
    } 
    /**
    * season::getYears()
    * 
    * get all years with defined seasons
    * 
    * @return array years
    * @access public 
    * @since 2003-12-31
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getYears()
    {
        global $gDatabase, $tbl_season, $errorhandler, $request;

        $years = array();
        $query = "SELECT DISTINCT DATE_FORMAT( start_date,  '%Y'  ) 
		          FROM $tbl_season 
				  WHERE ISNULL(fk_deleted_user_id) 
				  ORDER BY start_date ";

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler -> display('SQL', 'Season::getYears()', $query);
        } else {
            $row = 0;
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {

                $years[$row] = MetabaseFetchResult($gDatabase, $result, $row, 0);
            } 
        } 
        return $years;
    } 
    /**
    * season::getOneYear()
    * 
    * get all season data of one year
    * 
	* @param number $year year
    * @return array season data
    * @access public 
    * @since 2003-12-31
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getOneYear($year)
    {
        global $gDatabase, $tbl_season, $errorhandler, $request;

        $season = array();
        $query = "SELECT pk_season_id, name 
		          FROM $tbl_season 
				  WHERE ISNULL(fk_deleted_user_id) 
				  AND DATE_FORMAT( start_date,  '%Y'  )  = $year
				  ORDER BY start_date ";

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler -> display('SQL', 'Season::getOneYear()', $query);
        } else {
            $row = 0;
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $season[$row] = array ('seasonid' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                    'name' => MetabaseFetchResult($gDatabase, $result, $row, 1)
                    );
            } 
			
        } 
        return $season;
    } 

} 

?>
