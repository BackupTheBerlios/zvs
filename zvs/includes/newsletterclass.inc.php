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
* class Newsletter
* 
* Class for newsletter
* 
* This class has all functions which are needed for a newsletter.
* 
* @since 2004-07-10
* @author Christian Ehret <chris@uffbasse.de> 
* @version $Id: newsletterclass.inc.php,v 1.1 2004/11/03 14:48:12 ehret Exp $
*/
class Newsletter {
    /**
    * Newsletter::getCategories()
    * 
    * This function returns all categories with guest assigned.
    * 
    * @return array categories
    * @access public 
    * @since 2004-07-10
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getCategories()
    {
        global $gDatabase, $tbl_guestcat, $tbl_guest_guestcat, $tbl_guest_address, $tbl_address, $errorhandler, $request;

        $cat = array();
        $query = "SELECT gc.pk_guestcat_id, gc.guestcat, count(ggc.pk_fk_guest_id)
		          FROM $tbl_guestcat gc
				  LEFT JOIN $tbl_guest_guestcat ggc ON gc.pk_guestcat_id = ggc.pk_fk_guestcat_id
				  LEFT JOIN $tbl_guest_address ga ON ggc.pk_fk_guest_id = ga.pk_fk_guest_id AND
				  							         ga.default_address = 'Y'
				  LEFT JOIN $tbl_address a ON ga.pk_fk_address_id = a.pk_address_id 
				  WHERE 
				  ISNULL(gc.fk_deleted_user_id)
				  AND NOT ISNULL( a.email )
				  GROUP BY gc.pk_guestcat_id
				  ORDER BY guestcat";
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Newsletter::getCategories()', $query);
        } else {
            $row = 0;
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $cat[$row] = array ('catid' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                    'cat' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                    'count' => MetabaseFetchResult($gDatabase, $result, $row, 2)
                    );
            } 
        } 
        return $cat;
    } 

    /**
    * Newsletter::send()
    * 
    * This function sends eMail.
    * 
    * @param array $cats categories
    * @param string $sender sender
    * @param string $senderemail sender email
    * @param string $subject subject
    * @param string $body body
    * @param boolean $andop and operator
    * @param boolean $salutation insert salutation
	* @return number number of mails
    * @access public 
    * @since 2004-07-10
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function send($cats, $sender, $senderemail, $subject, $body, $andop, $salutation)
    {
        global $gDatabase, $tbl_guest, $tbl_guestcat, $tbl_guest_guestcat, $tbl_guest_address, $tbl_address, $errorhandler, $request;
        set_time_limit(0);
		$num = 0;
        if ($andop) {
            $query = "SELECT t0.pk_fk_guest_id, a.email, g.firstname, g.lastname
				  FROM ";
            for ($i = 0; $i < count($cats); $i++) {
                $query .= "$tbl_guest_guestcat t$i ";
                if ($i !== count($cats)-1) {
                    $query .= ", ";
                } 
            } 
            $query .= "LEFT JOIN $tbl_guest_address ga ON t0.pk_fk_guest_id = ga.pk_fk_guest_id AND
				  							         ga.default_address = 'Y'		
				       LEFT JOIN $tbl_address a ON ga.pk_fk_address_id = a.pk_address_id 
					   LEFT JOIN $tbl_guest g ON t0.pk_fk_guest_id = g.pk_guest_id ";
            $query .= "WHERE ";
            for ($i = 0; $i < count($cats); $i++) {
                $query .= "t$i.pk_fk_guestcat_id = $cats[$i] ";
                if ($i > 0) {
                    $query .= "AND t0.pk_fk_guest_id = t$i.pk_fk_guest_id ";
                } 
                if ($i !== count($cats)-1) {
                    $query .= "AND ";
                } 
            } 
            $query .= "AND NOT ISNULL( a.email ) ";
        } else {
            $query = "SELECT DISTINCT ggc.pk_fk_guest_id, a.email, g.firstname, g.lastname 
				  FROM $tbl_guest_guestcat ggc
				  LEFT JOIN $tbl_guest_address ga ON ggc.pk_fk_guest_id = ga.pk_fk_guest_id AND
				  							         ga.default_address = 'Y'		
				  LEFT JOIN $tbl_address a ON ga.pk_fk_address_id = a.pk_address_id 
				  LEFT JOIN $tbl_guest g ON ggc.pk_fk_guest_id = g.pk_guest_id		  
				  WHERE (";
            for ($i = 0; $i < count($cats); $i++) {
                $query .= "ggc.pk_fk_guestcat_id = " . $cats[$i];
                if ($i !== count($cats)-1) {
                    $query .= " OR ";
                } 
            } 
            $query .= ") AND NOT ISNULL( a.email ) ";
        } 

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Newsletter::send()', $query);
        } else {
            $row = 0;
            if ($salutation) {
                include_once("guestclass.inc.php");
                $guestclass = New Guest;
            } 

            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                if ($salutation) {
                    $salutationtxt = $guestclass->getGreeting(MetabaseFetchResult($gDatabase, $result, $row, 0))."\n";
                } else {
                    $salutationtxt = "";
                } 
                $files = $_FILES;
                $message = $salutationtxt;
                $message .= $body;
                $email = MetabaseFetchResult($gDatabase, $result, $row, 1);
                $firstname = MetabaseFetchResult($gDatabase, $result, $row, 2);
                $lastname = MetabaseFetchResult($gDatabase, $result, $row, 3);
                $from = $sender . " <" . $senderemail . ">";
                $recipient = $firstname . " " . $lastname . " <" . $email . ">";

                $mime_boundary = "<<<:" . md5(uniqid(mt_rand(), 1));
                $content = "";
                $header = "From: $from\r\n";
                $header .= "Reply-To: $from\r\n";
                $header .= "X-Priority: 3 (Normal)\r\n";
                $header .= "X-Mailer: PHP/" . phpversion() . "\r\n";
                $header .= "MIME-Version: 1.0\r\n";
                if (is_array($files)) {
                    $header .= "Content-Type: multipart/mixed;\r\n";
                    $header .= " boundary=\"" . $mime_boundary . "\"\r\n";
                    $content = "This is a multi-part message in MIME format.\r\n\r\n";
                    $content .= "--" . $mime_boundary . "\r\n";
                } 
                $content .= "Content-Type: text/plain; charset=\"ISO-8859-1\"\r\n";
                $content .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
                $content .= "$message\r\n\r\n";
                if (is_array($files)) {
                    $content .= "--" . $mime_boundary . "\r\n";
                    foreach($files as $filename => $filelocation) {
                        $filename = $filelocation['name'];
                        $filelocation = $filelocation['tmp_name'];
                        if (is_readable($filelocation)) {
                            $data = chunk_split(base64_encode(implode("", file($filelocation))));
                            $content .= "Content-Disposition: attachment;\r\n";
                            if (!function_exists ("mime_content_type")) {
                                $mimecontenttype = "application/octet-stream";
                            } else {
                                $mimecontenttype = mime_content_type($filelocation);
                            } 
                            $content .= "Content-Type: " . $mimecontenttype . ";";
                            $content .= " name=\"" . $filename . "\"\r\n";
                            $content .= "Content-Transfer-Encoding: base64\r\n\r\n";
                            $content .= $data . "\r\n";
                            $content .= "--" . $mime_boundary . "\r\n";
                        } 
                    } 
                } 
                mail($recipient, $subject, $content, $header);
				$num++;
            } 
        } 
		return $num;
    } 
} 

?>