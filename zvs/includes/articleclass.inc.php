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
* class article
* 
* Class for article functionality
* 
* This class has all functions which are needed for the articles.
* 
* @since 2004-03-07
* @author Christian Ehret <chris@uffbasse.de> 
* @version $Id: articleclass.inc.php,v 1.1 2004/11/03 14:38:17 ehret Exp $
*/
class Article {
    /**
    * article::get()
    * 
    * get all articles
    * 
    * @return array articles
    * @access public 
    * @since 2004-03-07
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function get()
    {
        global $gDatabase, $tbl_article, $errorhandler, $request;

        $article = array();
        $query = "SELECT pk_article_id, article, price_netto, price_brutto, mwst
				  FROM $tbl_article 
				  WHERE ISNULL(fk_deleted_user_id) 
				  ORDER BY article ";

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Article::get()', $query);
        } else {
            $row = 0;
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $color = 0;
                if ($row % 2 <> 0) {
                    $color = 1;
                } 

                $article[$row] = array ('articleid' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                    'article' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                    'price_netto' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                    'price_brutto' => MetabaseFetchResult($gDatabase, $result, $row, 3),
                    'mwst' => MetabaseFetchResult($gDatabase, $result, $row, 4),
                    'color' => $color
                    );
            } 
        } 
        return $article;
    } 

    /**
    * article::getone()
    * 
    * get a article
    * 
    * @param  $articleid article id
    * @return array article
    * @access public 
    * @since 2004-03-09
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getone($articleid)
    {
        global $gDatabase, $tbl_article, $errorhandler, $request;

        $article = array();
        $query = "SELECT pk_article_id, article, price_netto, price_brutto, mwst
				  FROM $tbl_article 
				  WHERE pk_article_id = $articleid 
				  ORDER BY article ";

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Article::getone()', $query);
        } else {
            $row = 0;
            $article = array ('articleid' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                'article' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                'price_netto' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                'price_brutto' => MetabaseFetchResult($gDatabase, $result, $row, 3),
                'mwst' => MetabaseFetchResult($gDatabase, $result, $row, 4)
                );
        } 
        return $article;
    } 

    /**
    * article::del()
    * 
    * delete a article
    * 
    * @param number $articleid article id
    * @access public 
    * @since 2004-03-07
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function del($articleid)
    {
        global $gDatabase, $tbl_article, $request;

        $query = sprintf("UPDATE $tbl_article SET 
						  deleted_date = NOW(),
						  fk_deleted_user_id = %s 
						  WHERE pk_article_id = %s ",
            $request->GetVar('uid', 'session'),
            $articleid
            );

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Article::del()', $query);
        } 
    } 

    /**
    * article::saveupdate()
    * 
    * save or update an article
    * 
    * @param number $articleid article id
    * @return number article id
    * @access public 
    * @since 2004-03-07
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function saveupdate($articleid)
    {
        global $gDatabase, $request, $tbl_article, $errorhandler; 
        // update
        if ($articleid !== '0') {
            $query = sprintf("UPDATE $tbl_article SET 
							  article = %s, 
							  price_netto = %s, 
							  price_brutto = %s,
							  mwst = %s, 
							  updated_date = NOW(), 
							  fk_updated_user_id = %s 
							  WHERE pk_article_id = %s ",
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_name', 'post')),
                round($request->GetVar('frm_brutto', 'post') * 100 / (100 + $request->GetVar('frm_mwst', 'post')), 2),
                $request->GetVar('frm_brutto', 'post'),
                $request->GetVar('frm_mwst', 'post'),
                $request->GetVar('uid', 'session'),
                $articleid
                );
        } else { // new
            $name = "zvs_pk_article_id";
            $sequence = MetabaseGetSequenceNextValue($gDatabase, $name, &$articleid);
            $query = sprintf("INSERT INTO $tbl_article
							(pk_article_id, article, price_netto, price_brutto, mwst, inserted_date, fk_inserted_user_id )
							VALUES (%s, %s, %s, %s, %s, NOW(), %s )",
                $articleid,
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_name', 'post')),
                round($request->GetVar('frm_brutto', 'post') * 100 / (100 + $request->GetVar('frm_mwst', 'post')), 2),
                $request->GetVar('frm_brutto', 'post'),
                $request->GetVar('frm_mwst', 'post'),
                $request->GetVar('uid', 'session')
                );
        } 

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Article::saveupdate()', $query);
        } else {
            return $articlid;
        } 
    } 

    /**
    * article::delroom()
    * 
    * delete the link to a roomcategory
    * 
    * @param number $roomcatid room category id
    * @param number $articleid article id
    * @access public 
    * @since 2004-03-07
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function delroom($roomcatid, $articleid)
    {
        global $gDatabase, $request, $tbl_roomcat_article, $errorhandler;
        $query = sprintf("DELETE FROM $tbl_roomcat_article
				  		   WHERE pk_fk_roomcat_id = %s 
				           AND pk_fk_article_id = %s",
            $roomcatid,
            $articleid
            );
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Article::delroom()', $query);
        } 
    } 

    /**
    * article::addroom()
    * 
    * add the link to a roomcategory
    * 
    * @param number $roomcatid room category id
    * @param number $articleid article id
    * @param enum $pricetype price type PP or PR
	* @param boolean $included price included in room or not
    * @access public 
    * @since 2004-03-07
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function addroom($roomcatid, $articleid, $pricetype, $included)
    {
        global $gDatabase, $request, $tbl_roomcat_article, $errorhandler;
        $person = false;
        $children = false;
        if ($request->GetVar('frm_person', 'post') == 'true') {
            $person = true;
        } 
        if ($request->GetVar('frm_children', 'post') == 'true') {
            $children = true;
        } 
        if ($request->GetVar('frm_children2', 'post') == 'true') {
            $children2 = true;
        } 
        if ($request->GetVar('frm_children3', 'post') == 'true') {
            $children3 = true;
        } 

        $query = sprintf("SELECT pk_fk_article_id 
						  FROM $tbl_roomcat_article
						  WHERE pk_fk_roomcat_id = %s 
				           AND pk_fk_article_id = %s",
            $roomcatid,
            $articleid
            );
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Article::addroom()', $query);
        } elseif (MetabaseNumberOfRows($gDatabase, $result) == 0) {
            $query = sprintf("INSERT INTO $tbl_roomcat_article
				  		  (pk_fk_roomcat_id, pk_fk_article_id, price_type,
						  person, children, children2, children3, included)
						  VALUES (%s,%s, %s, %s, %s, %s, %s, %s)",
                $roomcatid,
                $articleid,
                MetabaseGetTextFieldValue($gDatabase, $pricetype),
                MetabaseGetBooleanFieldValue($gDatabase, $person),
                MetabaseGetBooleanFieldValue($gDatabase, $children),
                MetabaseGetBooleanFieldValue($gDatabase, $children2),
                MetabaseGetBooleanFieldValue($gDatabase, $children3),
				MetabaseGetBooleanFieldValue($gDatabase, $included)
                );
            $result = MetabaseQuery($gDatabase, $query);
            if (!$result) {
                $errorhandler->display('SQL', 'Article::addroom()', $query);
            } 
        } else {
            $query = sprintf("UPDATE $tbl_roomcat_article SET
						  price_type = %s,
						  person = %s, 
						  children = %s, 
						  children2 = %s, 
						  children3 = %s,
						  included = %s
						  WHERE pk_fk_roomcat_id = %s 
						  AND pk_fk_article_id = %s ",
                MetabaseGetTextFieldValue($gDatabase, $pricetype),
                MetabaseGetBooleanFieldValue($gDatabase, $person),
                MetabaseGetBooleanFieldValue($gDatabase, $children),
                MetabaseGetBooleanFieldValue($gDatabase, $children2),
                MetabaseGetBooleanFieldValue($gDatabase, $children3),
				MetabaseGetBooleanFieldValue($gDatabase, $included),
                $roomcatid,
                $articleid
                );

            $result = MetabaseQuery($gDatabase, $query);
            if (!$result) {
                $errorhandler->display('SQL', 'Article::addroom()', $query);
            } 
        } 
    } 
} 

?>
