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
* class Article
* 
* Class for articles
* 
* This class has all functions which are needed for the articles.
* 
* @since 2004-01-06
* @author Christian Ehret <chris@uffbasse.de> 
* @version $Id: articleclass.inc.php,v 1.2 2004/11/03 16:33:52 ehret Exp $
*/
class Article {
    /**
    * Article::getall()
    * 
    * This function returns all articles.
    * 
    * @param boolean $withspecial get special or not
    * @return array articles
    * @access public 
    * @since 2004-01-06
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getall($withspecial)
    {
        global $gDatabase2, $tbl_bararticle, $tbl_bararticlecat, $request, $errorhandler, $articlerows;
        $article = array();
        if ($withspecial) {
            $article[0] = array ('articleid' => '0',
                'description' => "Sonderverkauf",
                'price' => "",
                'hotkey' => "",
                'catid' => "",
				'cat' => "",
                'newline' => "false"
                );
        } 

        $query = "SELECT pk_bararticle_id, description, price, hotkey, fk_bararticlecat_id, bararticlecat
		                 FROM $tbl_bararticle ba
						 LEFT JOIN $tbl_bararticlecat bac ON pk_bararticlecat_id = fk_bararticlecat_id
						 WHERE ISNULL(ba.deleted_date)
						 ORDER BY description, price  ";
        $result = MetabaseQuery($gDatabase2, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Article::getall()', $query);
        } else {
            $row = 0;

            $startrow = 0;
            if ($withspecial) {
                $startrow = 1;
            } 

            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase2, $result)) == 0; ++$row) {
                $color = 0;
                if ($row % 2 <> 0) {
                    $color = 1;
                } 
                if (($startrow) % $articlerows == 0) {
                    $newline = "true";
                } else {
                    $newline = "false";
                } 

                $article[$startrow] = array ('articleid' => MetabaseFetchResult($gDatabase2, $result, $row, 0),
                    'description' => MetabaseFetchResult($gDatabase2, $result, $row, 1),
                    'price' => MetabaseFetchResult($gDatabase2, $result, $row, 2),
                    'hotkey' => MetabaseFetchResult($gDatabase2, $result, $row, 3),
                    'catid' => MetabaseFetchResult($gDatabase2, $result, $row, 4),
                    'cat' => MetabaseFetchResult($gDatabase2, $result, $row, 5),
                    'newline' => $newline,
                    'color' => $color
                    );
                $startrow++;
            } 
        } 
        return $article;
    } 

    /**
    * Article::getallcat()
    * 
    * This function returns all articles of one cateogry.
    * 
    * @param boolean $withspecial get special or not
	* @param int $catid category id
    * @return array articles
    * @access public 
    * @since 2004-08-30
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getallcat($withspecial, $catid)
    {
        global $gDatabase2, $tbl_bararticle, $tbl_bararticlecat, $request, $errorhandler, $articlerows;
        $article = array();
        if ($withspecial) {
            $article[0] = array ('articleid' => '0',
                'description' => "Sonderverkauf",
                'price' => "",
                'hotkey' => "",
                'catid' => "",
				'cat' => "",
                'newline' => "false"
                );
        } 

        $query = "SELECT pk_bararticle_id, description, price, hotkey, fk_bararticlecat_id, bararticlecat
		                 FROM $tbl_bararticle ba
						 LEFT JOIN $tbl_bararticlecat bac ON pk_bararticlecat_id = fk_bararticlecat_id
						 WHERE ISNULL(ba.deleted_date)
						 AND fk_bararticlecat_id = $catid
						 ORDER BY description, price ";
        $result = MetabaseQuery($gDatabase2, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Article::getall()', $query);
        } else {
            $row = 0;

            $startrow = 0;
            if ($withspecial) {
                $startrow = 1;
            } 

            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase2, $result)) == 0; ++$row) {
                $color = 0;
                if ($row % 2 <> 0) {
                    $color = 1;
                } 
                if (($startrow) % $articlerows == 0) {
                    $newline = "true";
                } else {
                    $newline = "false";
                } 

                $article[$startrow] = array ('articleid' => MetabaseFetchResult($gDatabase2, $result, $row, 0),
                    'description' => MetabaseFetchResult($gDatabase2, $result, $row, 1),
                    'price' => MetabaseFetchResult($gDatabase2, $result, $row, 2),
                    'hotkey' => MetabaseFetchResult($gDatabase2, $result, $row, 3),
                    'catid' => MetabaseFetchResult($gDatabase2, $result, $row, 4),
                    'cat' => MetabaseFetchResult($gDatabase2, $result, $row, 5),
                    'newline' => $newline,
                    'color' => $color
                    );
                $startrow++;
            } 
        } 
        return $article;
    } 
	
	
    /**
    * Article::getlist()
    * 
    * This function returns all article names.
    * 
    * @return array articles
    * @access public 
    * @since 2004-01-06
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getlist()
    {
        global $gDatabase2, $tbl_bararticle, $request, $errorhandler;
        $article = array();

        $query = "SELECT DISTINCT description
		                 FROM $tbl_bararticle
						 ORDER BY description  ";
        $result = MetabaseQuery($gDatabase2, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Article::getList()', $query);
        } else {
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase2, $result)) == 0; ++$row) {
                $article[$row] = MetabaseFetchResult($gDatabase2, $result, $row, 0);
            } 
        } 
        return $article;
    } 

    /**
    * Article::saveupdate()
    * 
    * Save article as new or update existing one
    * 
    * @access public 
    * @since 2004-01-06
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function saveupdate()
    {
        global $gDatabase, $request, $tbl_bararticle, $errorhandler;

        $articleid = $request->GetVar('frm_articleid', 'post'); 
        // update
        if ($articleid !== '0') {
            $query = sprintf("UPDATE $tbl_bararticle SET 
							 fk_bararticlecat_id = %s,
			                 description = %s, 
							 price = %s,
							 hotkey = %s,
							 updated_date = NOW(), 
							 fk_updated_user_id = %s 
							 WHERE pk_bararticle_id = %s ",
                $request->GetVar('frm_cat', 'post'),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_description', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_price', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_hotkey', 'post')),
                $request->GetVar('uid', 'session'),
                $articleid
                );
        } else { // new
            $name = "zvs_pk_bararticle_id";
            $sequence = MetabaseGetSequenceNextValue($gDatabase, $name, &$articleid);
            $query = sprintf("INSERT INTO $tbl_bararticle
			                  (pk_bararticle_id, fk_bararticlecat_id, description, price, hotkey, inserted_date, fk_inserted_user_id, updated_date, fk_updated_user_id)
							  VALUES (%s, %s, %s, %s, %s, NOW(), %s, NOW(), %s )",
                $articleid,
                $request->GetVar('frm_cat', 'post'),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_description', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_price', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_hotkey', 'post')),
                $request->GetVar('uid', 'session'),
                $request->GetVar('uid', 'session')
                );
        } 

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Article::saveupdate()', $query);
        } 
    } 
    /**
    * Article::addSpecial()
    * 
    * Save article as deleted - used for single sell
    * 
    * @return $articleid article id
    * @access public 
    * @since 2004-01-10
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function addSpecial()
    {
        global $gDatabase, $request, $tbl_bararticle, $errorhandler;

        $name = "zvs_pk_bararticle_id";
        $sequence = MetabaseGetSequenceNextValue($gDatabase, $name, &$articleid);
        $query = sprintf("INSERT INTO $tbl_bararticle
	                       (pk_bararticle_id, fk_bararticlecat_id, description, price, inserted_date, fk_inserted_user_id, deleted_date, fk_deleted_user_id)
					  	   VALUES (%s, 1, %s, %s, NOW(), %s, NOW(), %s )",
            $articleid,
            MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_description', 'post')),
            MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_price', 'post')),
            $request->GetVar('uid', 'session'),
            $request->GetVar('uid', 'session')
            );

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Article::addSpecial()', $query);
        } else {
            return $articleid;
        } 
    } 

    /**
    * User::del()
    * 
    * Deletes an article
    * 
    * @param number $articleid article id
    * @access public 
    * @since 2004-01-06
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function del($articleid)
    {
        global $gDatabase, $tbl_bararticle, $errorhandler, $request;

        $query = sprintf("UPDATE $tbl_bararticle SET 
							 deleted_date = NOW(), 
							 fk_deleted_user_id = %s 
							 WHERE pk_bararticle_id = %s ",
            $request->GetVar('uid', 'session'),
            $articleid
            );
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Article::del()', $query);
        } 
    } 
} 

?>
