<?php
/**
* class Articlecat
* 
* Class for articlecategories
* 
* This class has all functions which are needed for the articlecategories.
* 
* @since 2004-08-30
* @author Christian Ehret <chris@uffbasse.de> 
* @version $Id: articlecatclass.inc.php,v 1.1 2004/11/03 15:31:33 ehret Exp $
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
