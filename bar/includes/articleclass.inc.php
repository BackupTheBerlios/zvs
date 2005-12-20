<?php
/**
* Copyright notice
* 
*                    (c) 2003-2004 Christian Ehret (chris@ehret.name)
*                    All rights reserved
* 
*                    This script is part of the ZVS project. The ZVS project is 
*                    free software; you can redistribute it and/or modify
*                    it under the terms of the GNU General Public License as published by
*                    the Free Software Foundation; either version 2 of the License, or
*                    (at your option) any later version.
* 
*                    The GNU General Public License can be found at
*                    http://www.gnu.org/copyleft/gpl.html.
*                    A copy is found in the textfile GPL.txt and important notices to the license 
*                    from the author is found in LICENSE.txt distributed with these scripts.
* 
* 
*                    This script is distributed in the hope that it will be useful,
*                    but WITHOUT ANY WARRANTY; without even the implied warranty of
*                    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*                    GNU General Public License for more details.
* 
*                    This copyright notice MUST APPEAR in all copies of the script!
*/

/**
* class Article
* 
* Class for articles
* 
* This class has all functions which are needed for the articles.
* 
* @since 2004-01-06
* @author Christian Ehret <chris@uffbasse.de> 
* @version $Id: articleclass.inc.php,v 1.5 2005/12/20 15:58:46 ehret Exp $
*/
class Article {
    /**
    * Article::getall()
    * 
    * This function returns all articles.
    * 
    * @param boolean $withspecial get special or not
    * @param int $period period
	* @param int $cat category
    * @return array articles
    * @access public 
    * @since 2004-01-06
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getall($withspecial, $period, $cat = -1)
    {
        global $gDatabase, $tbl_bararticle, $tbl_bararticlecat, $tbl_period, $request, $errorhandler, $articlerows;
        $article = array();
        if ($withspecial) {
            $article[0] = array ('articleid' => '0',
                'description' => "Sonderverkauf",
                'price' => "",
                'hotkey' => "",
                'catid' => "",
                'cat' => "",
                'newline' => "false",
                'tax' => ""
                );
        } 

        $query = "SELECT pk_bararticle_id, description, price, hotkey, fk_bararticlecat_id, bararticlecat, tax
		                 FROM $tbl_bararticle ba
						 LEFT JOIN $tbl_bararticlecat bac ON pk_bararticlecat_id = fk_bararticlecat_id
						 WHERE ISNULL(ba.deleted_date) AND fk_period_id = $period ";
		if ($cat != -1) {
		    $query .= "AND fk_bararticlecat_id = $cat ";
		}						 
		$query .= "ORDER BY description, price  ";
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Article::getall()', $query);
        } else {
            $row = 0;

            $startrow = 0;
            if ($withspecial) {
                $startrow = 1;
            } 

            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $color = 0;
                if ($row % 2 <> 0) {
                    $color = 1;
                } 
                if (($startrow) % $articlerows == 0) {
                    $newline = "true";
                } else {
                    $newline = "false";
                } 

                $article[$startrow] = array ('articleid' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                    'description' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                    'price' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                    'hotkey' => MetabaseFetchResult($gDatabase, $result, $row, 3),
                    'catid' => MetabaseFetchResult($gDatabase, $result, $row, 4),
                    'cat' => MetabaseFetchResult($gDatabase, $result, $row, 5),
                    'tax' => MetabaseFetchResult($gDatabase, $result, $row, 6),
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
        global $gDatabase, $tbl_bararticle, $tbl_period, $tbl_bararticlecat, $request, $errorhandler, $articlerows;
        $article = array();
        if ($withspecial) {
            $article[0] = array ('articleid' => '0',
                'description' => "Sonderverkauf",
                'price' => "",
                'hotkey' => "",
                'catid' => "",
                'cat' => "",
                'newline' => "false",
                'tax' => ""
                );
        } 

        $query = sprintf("SELECT pk_bararticle_id, description, price, hotkey, fk_bararticlecat_id, bararticlecat, tax
		                 FROM $tbl_bararticle ba
						 LEFT JOIN $tbl_bararticlecat bac ON pk_bararticlecat_id = fk_bararticlecat_id
						 LEFT JOIN $tbl_period p ON p.pk_period_id = ba.fk_period_id
						 WHERE ISNULL(ba.deleted_date)
						 AND fk_bararticlecat_id = $catid
						 AND p.active = %s
						 ORDER BY description, price ",
						 MetabaseGetBooleanFieldValue($gDatabase, true)
						 );
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Article::getall()', $query);
        } else {
            $row = 0;

            $startrow = 0;
            if ($withspecial) {
                $startrow = 1;
            } 

            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $color = 0;
                if ($row % 2 <> 0) {
                    $color = 1;
                } 
                if (($startrow) % $articlerows == 0) {
                    $newline = "true";
                } else {
                    $newline = "false";
                } 

                $article[$startrow] = array ('articleid' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                    'description' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                    'price' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                    'hotkey' => MetabaseFetchResult($gDatabase, $result, $row, 3),
                    'catid' => MetabaseFetchResult($gDatabase, $result, $row, 4),
                    'cat' => MetabaseFetchResult($gDatabase, $result, $row, 5),
                    'tax' => MetabaseFetchResult($gDatabase, $result, $row, 6),
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
        global $gDatabase, $tbl_bararticle, $request, $errorhandler;
        $article = array();

        $query = "SELECT DISTINCT description
		                 FROM $tbl_bararticle
						 ORDER BY description  ";
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Article::getList()', $query);
        } else {
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $article[$row] = MetabaseFetchResult($gDatabase, $result, $row, 0);
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
							 tax = %s,
							 updated_date = NOW(), 
							 fk_updated_user_id = %s 
							 WHERE pk_bararticle_id = %s ",
                $request->GetVar('frm_cat', 'post'),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_description', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_price', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_hotkey', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_tax', 'post')),
                $request->GetVar('uid', 'session'),
                $articleid
                );
        } else { // new
            $name = "zvs_pk_bararticle_id";
            $sequence = MetabaseGetSequenceNextValue($gDatabase, $name, &$articleid);
            $query = sprintf("INSERT INTO $tbl_bararticle
			                  (pk_bararticle_id, fk_bararticlecat_id, fk_period_id, description, price, hotkey, tax, inserted_date, fk_inserted_user_id, updated_date, fk_updated_user_id)
							  VALUES (%s, %s, %s, %s, %s, %s, %s, NOW(), %s, NULL, NULL )",
                $articleid,
                $request->GetVar('frm_cat', 'post'),
                $request->GetVar('frm_period', 'post'),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_description', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_price', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_hotkey', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_tax', 'post')),
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
		$active = $this->getactPeriod();
		
        $name = "zvs_pk_bararticle_id";
        $sequence = MetabaseGetSequenceNextValue($gDatabase, $name, &$articleid);
        $query = sprintf("INSERT INTO $tbl_bararticle
	                       (pk_bararticle_id, fk_bararticlecat_id, fk_period_id, description, price, tax, inserted_date, fk_inserted_user_id, deleted_date, fk_deleted_user_id)
					  	   VALUES (%s, %s, %s, %s, %s, %s, NOW(), %s, NOW(), %s )",
            $articleid,
			$request->GetVar('frm_catid','post'),
			$active['periodid'],
            MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_description', 'post')),
            MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_price', 'post')),
            MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_tax', 'post')),
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

    /**
    * Article::getPeriod()
    * 
    * This function returns all periods.
    * 
    * @return array periods
    * @access public 
    * @since 2004-12-13
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getPeriod()
    {
        global $gDatabase, $tbl_period, $request, $errorhandler;
        $period = array();

        $query = "SELECT pk_period_id, period
		                 FROM $tbl_period
						 WHERE ISNULL(deleted_date)
						 ORDER BY period  ";
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Article::getPeriod()', $query);
        } else {
            if (MetabaseNumberOfRows($gDatabase, $result) > 0) {
                for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                    $period[$row] = array("periodid" => MetabaseFetchResult($gDatabase, $result, $row, 0),
                        "period" => MetabaseFetchResult($gDatabase, $result, $row, 1)
                        );
                } 
            } 
        } 
        return $period;
    } 

    /**
    * Article::getactPeriod()
    * 
    * This function returns the active period.
    * 
    * @return array period
    * @access public 
    * @since 2004-12-13
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getactPeriod()
    {
        global $gDatabase, $tbl_period, $request, $errorhandler;
        $period = array();

        $query = sprintf ("SELECT pk_period_id, period
		                 FROM $tbl_period
						 WHERE active = %s ",
            MetabaseGetBooleanFieldValue($gDatabase, true)
            );
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Article::getactPeriod()', $query);
        } else {
            if (MetabaseNumberOfRows($gDatabase, $result) > 0) {
                $period = array("periodid" => MetabaseFetchResult($gDatabase, $result, 0, 0),
                    "period" => MetabaseFetchResult($gDatabase, $result, 0, 1)
                    );
            } else {
                $period = array("periodid" => -1, "period" => "");
            } 
        } 
        return $period;
    } 

    /**
    * Article::getselPeriod()
    * 
    * This function returns a period.
    * 
    * @param integer $periodid period id
    * @return array period
    * @access public 
    * @since 2004-12-13
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getselPeriod($periodid)
    {
        global $gDatabase, $tbl_period, $request, $errorhandler;
        $period = array();

        $query = "SELECT period, active
		                 FROM $tbl_period
						 WHERE pk_period_id = $periodid ";
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Article::getselPeriod()', $query);
        } else {
            if (MetabaseNumberOfRows($gDatabase, $result) > 0) {
                $period = array("periodid" => $period,
                    "period" => MetabaseFetchResult($gDatabase, $result, 0, 0),
                    "active" => MetabaseFetchBooleanResult($gDatabase, $result, 0, 1)
                    );
            } 
        } 
        return $period;
    } 

    /**
    * Article::saveupdatePeriod
    * 
    * Save period as new or update existing one
    * 
    * @access public 
    * @since 2004-12-13
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function saveupdatePeriod()
    {
        global $gDatabase, $request, $tbl_period, $tbl_bararticle, $errorhandler;

        $periodid = $request->GetVar('frm_theperiodid', 'post');
        $active = false;
        $auto_commit = false;
        $success = MetabaseAutoCommitTransactions($gDatabase, $auto_commit);
        if ($request->GetVar('frm_periodact', 'post') == 'true') {
            $active = true;
            $query = sprintf("UPDATE $tbl_period SET 
							 active = %s,
							 updated_date = NOW(), 
							 fk_updated_user_id = %s ",
                MetabaseGetBooleanFieldValue($gDatabase, false),
                $request->GetVar('uid', 'session')
                );
            $result = MetabaseQuery($gDatabase, $query);
            if (!$result) {
                $success = MetabaseRollbackTransaction($gDatabase);
                $errorhandler->display('SQL', 'Article::saveupdatePeriod()', $query);
            } 
        } 
        // update
        if ($periodid !== '-1') {
            $query = sprintf("UPDATE $tbl_period SET 
			                 period = %s, 
							 active = %s,
							 updated_date = NOW(), 
							 fk_updated_user_id = %s 
							 WHERE pk_period_id = %s ",
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_perioddesc', 'post')),
                MetabaseGetBooleanFieldValue($gDatabase, $active),
                $request->GetVar('uid', 'session'),
                $periodid
                );
        } else { // new
            $name = "zvs_pk_period_id";
            $sequence = MetabaseGetSequenceNextValue($gDatabase, $name, &$periodid);
            $query = sprintf("INSERT INTO $tbl_period
			                  (pk_period_id, period, active, inserted_date, fk_inserted_user_id, updated_date, fk_updated_user_id)
							  VALUES (%s, %s, %s, NOW(), %s, NULL, NULL )",
                $periodid,
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_perioddesc', 'post')),
                MetabaseGetBooleanFieldValue($gDatabase, $active),
                $request->GetVar('uid', 'session')
                );
        } 

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $success = MetabaseRollbackTransaction($gDatabase);
            $errorhandler->display('SQL', 'Article::saveupdatePeriod()', $query);
        } else {
            if ($request->GetVar('frm_cpyperiod', 'post') != -1) {
                $query = "SELECT fk_bararticlecat_id, description, price, hotkey
					  FROM $tbl_bararticle 
					  WHERE ISNULL(deleted_date) AND
					  fk_period_id = " . $request->GetVar('frm_cpyperiod', 'post');
                $result = MetabaseQuery($gDatabase, $query);
                if (!$result) {
                    $success = MetabaseRollbackTransaction($gDatabase);
                    $errorhandler->display('SQL', 'Article::saveupdatePeriod()', $query);
                } 
                for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                    $name = "zvs_pk_bararticle_id";
                    $sequence = MetabaseGetSequenceNextValue($gDatabase, $name, &$bararticleid);

                    $query = sprintf("INSERT INTO $tbl_bararticle 
					         (pk_bararticle_id, fk_period_id, fk_bararticlecat_id,
							 description, price, hotkey, inserted_date, 
							 fk_inserted_user_id)
							 VALUES (%s, %s, %s, %s, %s, %s, NOW(), %s) ",
                        $bararticleid,
                        $periodid,
                        MetabaseFetchResult($gDatabase, $result, $row, 0),
                        MetabaseGetTextFieldValue($gDatabase, MetabaseFetchResult($gDatabase, $result, $row, 1)),
                        MetabaseGetTextFieldValue($gDatabase, MetabaseFetchResult($gDatabase, $result, $row, 2)),
                        MetabaseGetTextFieldValue($gDatabase, MetabaseFetchResult($gDatabase, $result, $row, 3)),
                        $request->GetVar('uid', 'session')
                        );
                    $result2 = MetabaseQuery($gDatabase, $query);
                    if (!$result2) {
                        $success = MetabaseRollbackTransaction($gDatabase);
                        $errorhandler->display('SQL', 'Article::saveupdatePeriod()', $query);
                    } 
                } 
            } 

            $success = MetabaseCommitTransaction($gDatabase); 
            // end transaction
            $auto_commit = true;
            $success = MetabaseAutoCommitTransactions($gDatabase, $auto_commit);
        } 
        return $periodid;
    } 
} 

?>
