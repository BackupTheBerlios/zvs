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
* File with functions to select the proper files for e.g. Meldeschein
* 
* @since 2003-10-12
* @author Christian Ehret <chris@uffbasse.de> 
* @version $Id: fileselector.inc.php,v 1.2 2004/11/03 16:33:52 ehret Exp $
*/

/**
* selectfile()
* 
* This function returns the path to the include file for the actual hotel. 
* If this file does not exists, it returns the path to the default file.
* 
* @param string $filename name of the file
* @return string path to the file
* @access public 
* @since 2003-10-12
* @author Christian Ehret <chris@uffbasse.de> 
*/
function selectfile($filename)
{
    global $instpath;
    global $request;
    $testfilename = $instpath . $request->getVar('hotel_code', 'session') . '/' . $filename;

    if (file_exists($testfilename)) {
        return $filename;
    } else {
        return $instpath . 'default/' . $filename;
    } 
} 

?>