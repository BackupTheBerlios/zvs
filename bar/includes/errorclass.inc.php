<?php
/**
* class Error
* 
* Class for handling errors
* 
* This class has all functions which are needed for displaying errors in a nice manner.
* 
* @since 2003-08-08
* @author Christian Ehret <chris@uffbasse.de> 
* @version $Id: errorclass.inc.php,v 1.1 2004/11/03 15:31:33 ehret Exp $
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
