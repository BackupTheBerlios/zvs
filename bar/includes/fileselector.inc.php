<?php
/**
* File with functions to select the proper files for e.g. Meldeschein
* 
* @since 2003-10-12
* @author Christian Ehret <chris@uffbasse.de> 
* @version $Id: fileselector.inc.php,v 1.1 2004/11/03 15:31:33 ehret Exp $
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