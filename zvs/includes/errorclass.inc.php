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
* class Error
* 
* Class for handling errors
* 
* This class has all functions which are needed for displaying errors in a nice manner.
* 
* @since 2003-08-08
* @author Christian Ehret <chris@uffbasse.de> 
* @version $Id: errorclass.inc.php,v 1.1 2004/11/03 14:45:35 ehret Exp $
*/

class Error {
    /**
    * error::display()
    * 
    * displays a page with information to the error
    * 
    * @param errortype $errortype type of the error
    * @param classname $classname name of the class
    * @param info $info more 	
	* @access public 
	* @since 2003-08-08
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function display($errortype, $classname, $info)
    {
        global $smarty, $request, $gDatabase;
        $pagename = $request -> GetURI();
        $smarty -> assign('tpl_title', 'Es ist ein Fehler aufgetreten');
        $smarty -> assign('tpl_page', $pagename);
        $smarty -> assign('tpl_errortype', $errortype);
        $smarty -> assign('tpl_classname', $classname);
        $smarty -> assign('tpl_info', $info);
        $smarty -> assign('tpl_dbinfo', MetabaseError($gDatabase));
        $smarty -> display('error.tpl');
        exit;
    } 
} 

?>
