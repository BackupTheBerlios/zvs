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
* class rtf
* 
* Class for building rtfs
* 
* This class has functions which are needed helpfull to build rtfs.
* 
* @since 2004-01-11
* @author Christian Ehret <chris@uffbasse.de> 
* @version $Id: rtfclass.inc.php,v 1.2 2004/11/03 16:33:52 ehret Exp $
*/
class rtf {
    /**
    * rtf::buildtable()
    * 
    * This function builds a table in rtf syntax.
    * 
    * @param array $input input data
    * @param array $header headline
    * @return string table in rtf syntax
    * @access public 
    * @since 2004-01-11
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function buildtable($input, $header)
    {
        $output = '\par';
        // Load NumCells variable to write table row properties
        $numCells = count($input[0]); 
        // load NumRows variable to set up table contents loop for recordset
        $numRows = count($input); 
		
        // populate header row
        $output .= '\trowd\trpaddl108\trpaddr108\trpaddfl3\trpaddfr3\trautofit1\pard\intbl';

        for ($i = 1; $i <= $numCells; $i++) {
            $output .= '\cellx' . $i;
        } 

        $output .= '{'; 
        // loop thru and write the column name from the db
        for ($i = 0; $i < count($header); $i++) {
            $output .= '\b\nowrap '.$header[$i] . '\b0\nowrap0 \cell ';
        } 

        $output .= '}';

        $output .= '{';
        $output .= '\trowd\trpaddl108\trpaddr108\trpaddfl3\trpaddfr3\trautofit1\pard\intbl';

        for ($i = 1; $i <= $numCells; $i++) {
            $output .= '\cellx' . $i;
        } 
        $output .= '\row }'; 

        // write table contents
        for ($j = 0; $j < $numRows; $j++) {
            $output .= '\trowd\trpaddl108\trpaddr108\trpaddfl3\trpaddfr3\trautofit1\pard\intbl';

            for ($i = 1; $i <= $numCells; $i++) {
                $output .= '\cellx' . $i;
            } 
            $output .= '{';

			foreach ($input[$j] as $child) {
			   $output .= '\nowrap '.$child . '\nowrap0 \cell ';
			}
	

            $output .= '}';

            $output .= "{";
            $output .= '\trowd\trpaddl108\trpaddr108\trpaddfl3\trpaddfr3\trautofit1\pard\intbl';

            for ($i = 1; $i <= $numCells; $i++) {
                $output .= '\cellx' . $i;
            } 
            $output .= '\row }';
		
        } 

/*
        print "Cells: " . $numCells;
        print " Rows: " . $numRows;
        print '<pre>';
        print_r($input);
        print '</pre><br><br>';
        print $output;
		exit;
*/

$output .= '\pard';

       return $output;
    } 
} 
?>