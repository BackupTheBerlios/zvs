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
* class Statistics
* 
* Class for statistics
* 
* This class has all functions which are needed for the statistics.
* 
* @since 2004-01-19
* @author Christian Ehret <chris@uffbasse.de> 
* @version $Id: statisticsclass.inc.php,v 1.2 2004/11/03 16:33:52 ehret Exp $
*/
class Statistics {
    /**
    * Statistics::get()
    * 
    * This function returns statistics.
    * 
    * @param string $thestart start date
    * @param string $theend end date
	* @param int $id category
    * @return array statistic
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function get($thestart, $theend, $id)
    {
        global $gDatabase, $tbl_bought, $tbl_bararticle, $request, $errorhandler;

        $statistic = array();
        $query = "SELECT sum(num), description, price
		                 FROM $tbl_bought 
						 LEFT JOIN $tbl_bararticle ON $tbl_bought.fk_bararticle_id = $tbl_bararticle.pk_bararticle_id
						 WHERE timestamp >= '$thestart'
						 AND timestamp <= '$theend' ";
		if ($id != -1) {
		    $query .= "  AND $tbl_bararticle.fk_bararticlecat_id = $id "; 
		}						 
		$query .="		 GROUP BY description, price
						 ORDER BY description ";

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Statistics::get()', $query);
        } else {
            $row = 0;
            $sum = 0;
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $color = 0;
                if ($row % 2 <> 0) {
                    $color = 1;
                } 
                $total = MetabaseFetchResult($gDatabase, $result, $row, 2) * MetabaseFetchResult($gDatabase, $result, $row, 0);
                $sum += MetabaseFetchResult($gDatabase, $result, $row, 2) * MetabaseFetchResult($gDatabase, $result, $row, 0);
                $statistic[$row] = array ('num' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                    'description' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                    'price' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                    'total' => number_format($total, 2, '.', ''),
                    'color' => $color,
                    );
            } 
            $color = 0;
            if ($row % 2 <> 0) {
                $color = 1;
            } 
            $sum = number_format($sum, 2, '.', '');
            $statistic[$row] = array ('num' => '',
                'description' => '',
                'price' => '',
                'total' => $sum,
                'color' => $color
                );
        } 
        return $statistic;
    } 

    /**
    * Statistics::getNow()
    * 
    * This function returns sum of the day.
    * 
    * @return array statistic
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getNow()
    {
        global $gDatabase, $tbl_bought, $tbl_bararticle, $request, $errorhandler;

        $statistic = array();
        $todaydate = getdate();
        $day = $todaydate['mday'];
        $month = $todaydate['mon'];
        $year = $todaydate['year'];
        $thedate = "$day.$month.$year";
        list($day, $month, $year) = split('[.]', $thedate);
        $thestart = "$year-$month-$day 00:00:00";
        $theend = "$year-$month-$day 23:59:59";
        $sum = 0.00;
        $data = $this->get($thestart, $theend, -1);
        return $data[count($data)-1]['total'];
    } 
} 

?>