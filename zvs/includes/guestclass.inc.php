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
* class Guest
* 
* Class for guests functionality
* 
* This class has all functions which are needed for the guests.
* 
* @since 2003-07-24
* @author Christian Ehret <chris@uffbasse.de> 
* @version $Id: guestclass.inc.php,v 1.1 2004/11/03 14:46:37 ehret Exp $
*/
class Guest {
    /**
    * Guest::setAddressesNoDefault()
    * 
    * Set all addresses of a given guest to default no
    * 
    * @param number $guestid address id
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function setAddressesNoDefault($guestid)
    {
        global $gDatabase, $tbl_guest_address, $errorhandler;
        $query = sprintf("UPDATE $tbl_guest_address ga 
		                  SET default_address = %s 
						  WHERE pk_fk_guest_id = %s ",
            MetabaseGetBooleanFieldValue($gDatabase, false),
            $guestid
            );

        $result = MetabaseQuery($gDatabase, $query);

        if (!$result) {
            $errorhandler->display('SQL', 'Guest::setAddressesNoDefault()', $query);
        } 
    } 

    /**
    * Guest::getAddress()
    * 
    * Get guest address
    * 
    * @param number $addressid address id
    * @param boolean $defaultaddress default address
    * @return array guestdata
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getAddress($addressid, $defaultaddress)
    {
        global $gDatabase, $tbl_address, $tbl_guest_address, $tbl_country, $tbl_user, $errorhandler;
        $address = array();
        $query = "SELECT address, postalcode, city, region, 
		          fk_country_id, phone, fax, mobile, email, homepage, 
				  DATE_FORMAT(address.inserted_date, '%d.%m.%Y'), user1.firstName, user1.lastName, 
				  DATE_FORMAT(address.updated_date, '%d.%m.%Y'), user2.firstName, user2.lastName,  
				  country_de, country_com 
				  FROM $tbl_address As address 
				  LEFT JOIN $tbl_user AS user1 ON user1.pk_user_id = address.fk_inserted_user_id 
				  LEFT JOIN $tbl_user AS user2 ON user2.pk_user_id = address.fk_updated_user_id 
				  LEFT JOIN $tbl_country ON pk_country_id = fk_country_id 
				  WHERE pk_address_id = " . $addressid;

        $result = MetabaseQuery($gDatabase, $query);

        if (!$result) {
            $errorhandler->display('SQL', 'Guest::getAddress()', $query);
        } else {
            // check if address is used more than this time
            $query = "SELECT count( * ) FROM $tbl_guest_address WHERE pk_fk_address_id = $addressid";
            $result2 = MetabaseQuery($gDatabase, $query);

            if (!$result2) {
                $errorhandler->display('SQL', 'Guest::getAddress()', $query);
            } else {
                $count = MetabaseFetchResult($gDatabase, $result2, 0, 0);
            } 
            $rows = MetabaseNumberOfRows($gDatabase, $result);
            if ($rows <> 1) {
                $errorhandler->display('SQL, no result', 'Guest::getAddress()', $query);
            } 

            $address = array ('addressid' => $addressid,
                'address' => MetabaseFetchResult($gDatabase, $result, 0, 0),
                'postalcode' => MetabaseFetchResult($gDatabase, $result, 0, 1),
                'city' => MetabaseFetchResult($gDatabase, $result, 0, 2),
                'region' => MetabaseFetchResult($gDatabase, $result, 0, 3),
                'country_id' => MetabaseFetchResult($gDatabase, $result, 0, 4),
                'phone' => MetabaseFetchResult($gDatabase, $result, 0, 5),
                'fax' => MetabaseFetchResult($gDatabase, $result, 0, 6),
                'mobile' => MetabaseFetchResult($gDatabase, $result, 0, 7),
                'email' => MetabaseFetchResult($gDatabase, $result, 0, 8),
                'homepage' => MetabaseFetchResult($gDatabase, $result, 0, 9),
                'inserteddate' => MetabaseFetchResult($gDatabase, $result, 0, 10),
                'inserted_user' => MetabaseFetchResult($gDatabase, $result, 0, 11) . " " . MetabaseFetchResult($gDatabase, $result, 0, 12),
                'updated_date' => MetabaseFetchResult($gDatabase, $result, 0, 13),
                'updated_user' => MetabaseFetchResult($gDatabase, $result, 0, 14) . " " . MetabaseFetchResult($gDatabase, $result, 0, 15),
                'country_Name' => MetabaseFetchResult($gDatabase, $result, 0, 16),
                'country_Name_int' => MetabaseFetchResult($gDatabase, $result, 0, 17),
                'defaultaddress' => $defaultaddress,
                'count' => $count

                );
        } 
        return $address;
    } 

    /**
    * Guest::getGuest()
    * 
    * Get guest data
    * 
    * @param number $guestid guest id
    * @return array guestdata
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getGuest($guestid)
    {
        global $gDatabase, $tbl_guest, $tbl_guest_address, $tbl_country, $tbl_user, $tbl_booking, $tbl_salutation, $errorhandler, $request;
        $addressP = array();
        $addressB = array();
        $addressO = array();
        $guest = array();
        $query = "SELECT fk_salutation_id, academic_title, guest.firstname, guest.lastname, gender, 
		          company, job, additional_info, 
				  DATE_FORMAT(date_of_birth, '%d.%m.%Y'), formal_greeting, status, 
				  passport, guest.fk_language_id, 
				  DATE_FORMAT(guest.inserted_date, '%d.%m.%Y'), user1.firstName, user1.lastName, 
				  DATE_FORMAT(guest.updated_date, '%d.%m.%Y'), user2.firstName, user2.lastName,  
				  additional_info, salutation_de, DATE_FORMAT(date_of_birth, '%Y-%m-%d'), birthplace, 
				  fk_nationality_id, c.country_de, identification, agency, 
				  DATE_FORMAT(issue_date, '%d.%m.%Y'), birthday_reminder  
				  FROM $tbl_guest As guest 
				  LEFT JOIN $tbl_user AS user1 ON user1.pk_user_id = guest.fk_inserted_user_id 
				  LEFT JOIN $tbl_user AS user2 ON user2.pk_user_id = guest.fk_updated_user_id 
				  LEFT JOIN $tbl_salutation ON pk_salutation_id = fk_salutation_id 
				  LEFT JOIN $tbl_country c ON c.pk_country_id = guest.fk_nationality_id 
				  WHERE pk_guest_id = " . $guestid;

        $result = MetabaseQuery($gDatabase, $query);

        if (!$result) {
            $errorhandler->display('SQL', 'Guest::getGuest()', $query);
        } else {
            $rows = MetabaseNumberOfRows($gDatabase, $result);
            if ($rows <> 1) {
                $errorhandler->display('SQL, no result', 'Guest::getGuest()', $query);
            } 

            $query = sprintf("SELECT pk_fk_address_id, default_address, address_type 
			                  FROM $tbl_guest_address 
							  WHERE pk_fk_guest_id = %s ",
                $guestid
                );

            $addressResult = MetabaseQuery($gDatabase, $query);
            if (!$addressResult) {
                $errorhandler->display('SQL', 'Guest::getGuest()', $query);
            } 

            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $addressResult)) == 0; ++$row) {
                $address_id = MetabaseFetchResult($gDatabase, $addressResult, $row, 0);
                $defaultaddress = MetabaseFetchBooleanResult($gDatabase, $addressResult, $row, 1);
                $address_type = MetabaseFetchResult($gDatabase, $addressResult, $row, 2);
                $addressvar = 'address' . $address_type;

                $$addressvar = $this->getAddress($address_id, $defaultaddress);
            } 
            $query = sprintf("SELECT count( pk_booking_id ) 
			                  FROM $tbl_booking 
							  WHERE fk_guest_id = %s 
							  AND booking_type <> %s ",
                $guestid,
                MetabaseGetTextFieldValue($gDatabase, "R")
                );

            $result2 = MetabaseQuery($gDatabase, $query);
            if (!$result2) {
                $errorhandler->display('SQL', 'Guest::getGuest()', $query);
            } 

            $query = "SELECT DATE_FORMAT(max( start_date ), '%d.%m.%Y') " .
            sprintf("FROM $tbl_booking " . "WHERE fk_guest_id = %s " . "AND booking_type <> %s ",
                $guestid,
                MetabaseGetTextFieldValue($gDatabase, "R")
                );

            $result3 = MetabaseQuery($gDatabase, $query);
            if (!$result3) {
                $errorhandler->display('SQL', 'Guest::getGuest()', $query);
            } 

            $guest = array ('guestid' => $guestid,
                'addressid' => $address_id,
                'salutation_id' => MetabaseFetchResult($gDatabase, $result, 0, 0),
                'academic_title' => MetabaseFetchResult($gDatabase, $result, 0, 1),
                'firstname' => MetabaseFetchResult($gDatabase, $result, 0, 2),
                'lastname' => MetabaseFetchResult($gDatabase, $result, 0, 3),
                'gender' => MetabaseFetchResult($gDatabase, $result, 0, 4),
                'company' => MetabaseFetchResult($gDatabase, $result, 0, 5),
                'job' => MetabaseFetchResult($gDatabase, $result, 0, 6),
                'additional_info' => MetabaseFetchResult($gDatabase, $result, 0, 7),
                'date_of_birth' => MetabaseFetchResult($gDatabase, $result, 0, 8),
                'formal_greeting' => MetabaseFetchResult($gDatabase, $result, 0, 9),
                'status' => MetabaseFetchResult($gDatabase, $result, 0, 10),
                'passport' => MetabaseFetchResult($gDatabase, $result, 0, 11),
                'language_id' => MetabaseFetchResult($gDatabase, $result, 0, 12),
                'inserteddate' => MetabaseFetchResult($gDatabase, $result, 0, 13),
                'inserted_user' => MetabaseFetchResult($gDatabase, $result, 0, 14) . " " . MetabaseFetchResult($gDatabase, $result, 0, 15),
                'updated_date' => MetabaseFetchResult($gDatabase, $result, 0, 16),
                'updated_user' => MetabaseFetchResult($gDatabase, $result, 0, 17) . " " . MetabaseFetchResult($gDatabase, $result, 0, 18),
                'additional_info' => MetabaseFetchResult($gDatabase, $result, 0, 19),
                'salutation_title' => MetabaseFetchResult($gDatabase, $result, 0, 20),
                'date_of_birth_int' => MetabaseFetchResult($gDatabase, $result, 0, 21),
                'birthplace' => MetabaseFetchResult($gDatabase, $result, 0, 22),
                'nationality_id' => MetabaseFetchResult($gDatabase, $result, 0, 23),
                'nationality_name' => MetabaseFetchResult($gDatabase, $result, 0, 24),
                'identification' => MetabaseFetchResult($gDatabase, $result, 0, 25),
                'agency' => MetabaseFetchResult($gDatabase, $result, 0, 26),
                'issue_date' => MetabaseFetchResult($gDatabase, $result, 0, 27),
                'reminder' => MetabaseFetchResult($gDatabase, $result, 0, 28),
                'privateAddress' => $addressP,
                'businessAddress' => $addressB,
                'otherAddress' => $addressO,
                'bookings' => MetabaseFetchResult($gDatabase, $result2, 0, 0),
                'lastvisit' => MetabaseFetchResult($gDatabase, $result3, 0, 0)
                );
        } 
        return $guest;
    } 

    /**
    * Guest::saveupdateaddress()
    * 
    * save a new or update an existing address
    * 
    * @param number $guestid guest id
    * @param string $type type: private, business, other
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function saveupdateaddress($guestid, $type)
    {
        global $gDatabase, $request, $tbl_address, $tbl_guest_address, $errorhandler;

        $address = 'frm_' . $type . '_address';
        $postalcode = 'frm_' . $type . '_postalcode';
        $city = 'frm_' . $type . '_city';
        $region = 'frm_' . $type . '_region';
        $country = 'frm_' . $type . '_country';
        $phone = 'frm_' . $type . '_phone';
        $fax = 'frm_' . $type . '_fax';
        $mobile = 'frm_' . $type . '_mobile';
        $email = 'frm_' . $type . '_email';
        $homepage = 'frm_' . $type . '_homepage';
        $frm_addressid = 'frm_' . $type . '_addressid';
        $copy = 'frm_' . $type . '_copy';
        $split = false;
        if ($request->GetVar($copy, 'post') !== $request->undefined) {
            if ($request->GetVar($copy, 'post') == 'true') {
                $split = true;
            } 
        } 

        if ($request->GetVar($country, 'post') !== $request->undefined) {
            $addressid = $request->GetVar($frm_addressid, 'post');

            if ($request->GetVar('frm_default_address', 'post') == $type) {
                $defaultaddress = true;
            } else {
                $defaultaddress = false;
            } 

            if ($addressid <> 0 && !$split) {
                $query = sprintf("UPDATE $tbl_address a, $tbl_guest_address ga SET 
								a.address = %s, 
								a.postalcode = %s, 
								a.city = %s, 
								a.region = UPPER(%s), 
								a.fk_country_id = %s, 
								a.phone = %s,
								a.fax = %s, 
								a.mobile = %s, 
								a.email = %s, 
								a.homepage = %s, 
								a.updated_date = NOW(),
								a.fk_updated_user_id = %s, 
								ga.default_address =  %s 
								WHERE a.pk_address_id = %s 
								AND a.pk_address_id=ga.pk_fk_address_id
								AND ga.pk_fk_guest_id = $guestid ",
                    MetabaseGetTextFieldValue($gDatabase, $request->GetVar($address, 'post')),
                    MetabaseGetTextFieldValue($gDatabase, $request->GetVar($postalcode, 'post')),
                    MetabaseGetTextFieldValue($gDatabase, $request->GetVar($city, 'post')),
                    MetabaseGetTextFieldValue($gDatabase, $request->GetVar($region, 'post')),
                    MetabaseGetTextFieldValue($gDatabase, $request->GetVar($country, 'post')),
                    MetabaseGetTextFieldValue($gDatabase, $request->GetVar($phone, 'post')),
                    MetabaseGetTextFieldValue($gDatabase, $request->GetVar($fax, 'post')),
                    MetabaseGetTextFieldValue($gDatabase, $request->GetVar($mobile, 'post')),
                    MetabaseGetTextFieldValue($gDatabase, $request->GetVar($email, 'post')),
                    MetabaseGetTextFieldValue($gDatabase, $request->GetVar($homepage, 'post')),
                    $request->GetVar('uid', 'session'),
                    MetabaseGetBooleanFieldValue($gDatabase, $request->GetVar($defaultaddress, 'post')),
                    $addressid
                    );

                $result = MetabaseQuery($gDatabase, $query);
                if (!$result) {
                    $success = MetabaseRollbackTransaction($gDatabase);
                    $errorhandler->display('SQL', 'Guest::saveupdateaddress()', $query);
                } else {
                    $query = sprintf("UPDATE $tbl_guest_address 
									SET default_address = %s 
									WHERE pk_fk_guest_id = %s 
									AND pk_fk_address_id = %s ",
                        MetabaseGetBooleanFieldValue($gDatabase, $defaultaddress),
                        $guestid,
                        $addressid
                        );

                    $result = MetabaseQuery($gDatabase, $query);
                    if (!$result) {
                        $success = MetabaseRollbackTransaction($gDatabase);
                        $errorhandler->display('SQL', 'Guest::saveupdateaddress()', $query);
                    } 
                } 
            } else {
                if ($split && $guestid <> 0) {
                    $query = "DELETE FROM $tbl_guest_address 
							  WHERE pk_fk_guest_id = $guestid
							  AND pk_fk_address_id = $addressid";
                    $result = MetabaseQuery($gDatabase, $query);
                    if (!$result) {
                        $success = MetabaseRollbackTransaction($gDatabase);
                        $errorhandler->display('SQL', 'Guest::saveupdateaddress()', $query);
                    } 
                } 
                // save
                $name = "zvs_pk_address_id";
                $sequence = MetabaseGetSequenceNextValue($gDatabase, $name, &$addressid);

                $query = sprintf("INSERT INTO $tbl_address 
								(pk_address_id, address, postalcode, city, 
								region, fk_country_id, phone, fax, mobile, homepage, email, 
								inserted_date, fk_inserted_user_id ) 
								VALUES (%s, %s, %s, %s, UPPER(%s), %s, %s, %s, %s, %s, %s, NOW(), %s) ",
                    $addressid,
                    MetabaseGetTextFieldValue($gDatabase, $request->GetVar($address, 'post')),
                    MetabaseGetTextFieldValue($gDatabase, $request->GetVar($postalcode, 'post')),
                    MetabaseGetTextFieldValue($gDatabase, $request->GetVar($city, 'post')),
                    MetabaseGetTextFieldValue($gDatabase, $request->GetVar($region, 'post')),
                    MetabaseGetTextFieldValue($gDatabase, $request->GetVar($country, 'post')),
                    MetabaseGetTextFieldValue($gDatabase, $request->GetVar($phone, 'post')),
                    MetabaseGetTextFieldValue($gDatabase, $request->GetVar($fax, 'post')),
                    MetabaseGetTextFieldValue($gDatabase, $request->GetVar($mobile, 'post')),
                    MetabaseGetTextFieldValue($gDatabase, $request->GetVar($homepage, 'post')),
                    MetabaseGetTextFieldValue($gDatabase, $request->GetVar($email, 'post')),
                    $request->GetVar('uid', 'session')
                    );

                $result = MetabaseQuery($gDatabase, $query);

                if (!$result) {
                    $success = MetabaseRollbackTransaction($gDatabase);
                    $errorhandler->display('SQL', 'Guest::saveupdateaddress()', $query);
                } else {
                    switch ($type) {
                        case 'private':
                            $dbtype = 'P';
                            break;
                        case 'business':
                            $dbtype = 'B';
                            break;
                        case 'other':
                            $dbtype = 'O';
                            break;
                    } 

                    $query = sprintf("INSERT INTO $tbl_guest_address 
									(pk_fk_guest_id, pk_fk_address_id, default_address, address_type) 
									VALUES (%s, %s, %s, %s) ",
                        $guestid,
                        $addressid,
                        MetabaseGetBooleanFieldValue($gDatabase, $defaultaddress),
                        MetabaseGetTextFieldValue($gDatabase, $dbtype)
                        );

                    $result = MetabaseQuery($gDatabase, $query);
                    if (!$result) {
                        $success = MetabaseRollbackTransaction($gDatabase);
                        $errorhandler->display('SQL', 'Guest::saveupdateaddress()', $query);
                    } 
                } 
            } 
        } 
        // remove empty addresses
        $query = "DELETE FROM $tbl_guest_address, $tbl_address 
				  USING $tbl_guest_address ga, $tbl_address a 
				  WHERE ga.pk_fk_guest_id = $guestid 
				  AND ga.pk_fk_address_id = a.pk_address_id 
				  AND ((trim( a.address )='' or a.address IS NULL) 
				  AND (trim( a.postalcode )='' or a.postalcode IS NULL)
				  AND (trim( a.city )='' or a.city IS NULL) 
				  AND (trim( a.region )='' or a.region IS NULL) 
				  AND (trim( a.phone )='' or a.phone IS NULL) 
				  AND (trim( a.fax )='' or a.fax IS NULL) 
				  AND (trim( a.mobile )='' or a.mobile IS NULL) 
				  AND (trim( a.email )='' or a.email IS NULL) 
				  AND (trim( a.homepage )='' or a.homepage IS NULL)) ";

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $success = MetabaseRollbackTransaction($gDatabase);
            $errorhandler->display('SQL', 'Guest::saveupdateaddress()', $query);
        } 
    } 

    /**
    * Guest::saveupdateguest()
    * 
    * save a new or update an existing guest
    * 
    * @return number guest id
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function saveupdateguest()
    {
        global $gDatabase, $request, $tbl_guest, $tbl_address, $tbl_guest_address, $errorhandler;
        if ($request->GetVar('frm_escort', 'post') !== $request->undefined) {
            $escort = true;
        } else {
            $escort = false;
        } 

        if ($request->GetVar('frm_status', 'post') == 'Y') {
            $status = true;
        } else {
            $status = false;
        } 

        if ($request->GetVar('frm_reminder', 'post') == 'Y') {
            $reminder = true;
        } else {
            $reminder = false;
        } 

        $guestid = $request->GetVar('frm_guestid', 'post');
        $gebdat = explode(".", $request->GetVar('frm_date_of_birth', 'post'));
        $strgebdat = $gebdat[2] . "-" . $gebdat[1] . "-" . $gebdat[0];
        $issuedat = explode(".", $request->GetVar('frm_issue_date', 'post'));
        $strissuedat = $issuedat[2] . "-" . $issuedat[1] . "-" . $issuedat[0]; 
        // update
        if ($guestid !== '0' && $escort == false) {
            // transaction control
            $auto_commit = false;
            $success = MetabaseAutoCommitTransactions($gDatabase, $auto_commit);

            $query = sprintf("UPDATE $tbl_guest g SET " . "g.fk_salutation_id = %s, " . "g.academic_title = %s, " . "g.firstname = %s, " . "g.lastname = %s, " . "g.gender = %s, " . "g.company = %s, " . "g.job = %s, " . "g.date_of_birth = %s, " . "g.formal_greeting = %s, " . "g.status = %s, " . "g.passport = %s, " . "g.fk_language_id = %s, " . "g.birthplace = %s, " . "g.fk_nationality_id = %s, " . "g.identification = %s, " . "g.agency = %s, " . "g.issue_date = %s, " . "g.birthday_reminder = %s, " . "g.updated_date = NOW(), " . "g.fk_updated_user_id = %s " . "WHERE g.pk_guest_id = %s ",
                $request->GetVar('frm_salutation', 'post'),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_academictitle', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_firstname', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_lastname', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_gender', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_company', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_job', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $strgebdat),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_formal_greeting', 'post')),
                MetabaseGetBooleanFieldValue($gDatabase, $status),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_passport', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_language', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_birthplace', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_nationality', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_identification', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_agency', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $strissuedat),
                MetabaseGetBooleanFieldValue($gDatabase, $reminder),
                $request->GetVar('uid', 'session'),
                $guestid
                );

            $result = MetabaseQuery($gDatabase, $query);
            if (!$result) {
                $success = MetabaseRollbackTransaction($gDatabase);
                $errorhandler->display('SQL', 'Guest::saveupdateguest()', $query);
            } else {
                $this->setAddressesNoDefault($guestid);
                $this->saveupdateaddress($guestid, 'private');
                $this->saveupdateaddress($guestid, 'business');
                $this->saveupdateaddress($guestid, 'other');

                $success = MetabaseCommitTransaction($gDatabase); 
                // end transaction
                $auto_commit = true;
                $success = MetabaseAutoCommitTransactions($gDatabase, $auto_commit);
                return $guestid;
            } 
        } else { // new
            // transaction control
            $auto_commit = false;
            $success = MetabaseAutoCommitTransactions($gDatabase, $auto_commit);

            $name = "zvs_pk_guest_id";
            $sequence = MetabaseGetSequenceNextValue($gDatabase, $name, &$guestid);
            $query = sprintf("INSERT INTO $tbl_guest
			                   (pk_guest_id, fk_salutation_id, academic_title, firstname, lastname, 
							   gender, company, job, date_of_birth, fk_language_id, 
							   formal_greeting, status, passport, birthplace, fk_nationality_id, 
							   identification, agency, issue_date, birthday_reminder, 
							   inserted_date, fk_inserted_user_id) 
							   VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 
							   %s, %s, %s, %s, %s, %s, NOW(), %s )",
                $guestid,
                $request->GetVar('frm_salutation', 'post'),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_academictitle', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_firstname', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_lastname', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_gender', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_company', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_job', 'post')),
                MetabaseGetDateFieldValue($gDatabase, $strgebdat),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_language', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_formal_greeting', 'post')),
                MetabaseGetBooleanFieldValue($gDatabase, $status),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_passport', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_birthplace', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_nationality', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_identification', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request->GetVar('frm_agency', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $strissuedat),
                MetabaseGetBooleanFieldValue($gDatabase, $reminder),
                $request->GetVar('uid', 'session')
                );

            $result = MetabaseQuery($gDatabase, $query);
            if (!$result) {
                $errorhandler->display('SQL', 'Guest::saveupdateguest()', $query);
                $success = MetabaseRollbackTransaction($gDatabase);
            } else {
                if ($addressid > 0) {
                    $result = true;
                } else {
                    $this->setAddressesNoDefault($guestid);
                    $this->saveupdateaddress($guestid, 'private');
                    $this->saveupdateaddress($guestid, 'business');
                    $this->saveupdateaddress($guestid, 'other');

                    $success = MetabaseCommitTransaction($gDatabase); 
                    // end transaction
                    $auto_commit = true;
                    $success = MetabaseAutoCommitTransactions($gDatabase, $auto_commit);
                    return $guestid;
                } 
            } 
        } 
    } 

    /**
    * Guest::updateinfo()
    * 
    * update info for a guest
    * 
    * @param string $guestid guestid
    * @param string $value info text
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function updateinfo($guestid, $value)
    {
        global $tbl_guest, $gDatabase;
        $query = sprintf("UPDATE $tbl_guest SET " . "additional_info  = %s " . "WHERE pk_guest_id = %s ",
            MetabaseGetTextFieldValue($gDatabase, $value),
            $guestid
            );
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Guest::updateinfo()', $query);
        } 
    } 

    /**
    * Guest::easysearch()
    * 
    * search for a guest
    * 
    * @param string $firstname firstname
    * @param string $lastname lastname
    * @return array guest data
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function easysearch($firstname, $lastname)
    {
        global $gDatabase, $tbl_guest, $tbl_address, $tbl_guest_address, $tbl_country, $tbl_booking, $tbl_booking_detail_guest, $tbl_booking_detail, $errorhandler, $request;

        $guest = array();

        $query = "SELECT g.pk_guest_id, 
				  IF ( g.firstname =  '' OR g.firstname IS  NULL ,  '-', g.firstname )firstname, 
				  g.lastname, 
				  IF ( g.gender =  '' OR g.gender IS  NULL ,  '-', g.gender )gender, 
				  IF ( g.company =  '' OR g.company IS  NULL ,  '-', g.company )company, 
				  IF ( a.address =  '' OR a.address IS  NULL ,  '-', a.address )address, 
				  IF ( a.postalcode =  '' OR a.postalcode IS  NULL ,  '-', a.postalcode )postalcode, 
				  IF ( a.city =  '' OR a.city IS  NULL ,  '-', a.city )city, 
				  IF ( a.fk_country_id =  '' OR a.fk_country_id IS  NULL ,  '-', a.fk_country_id )fk_country_id, 
				  IF ( c.country_de =  '' OR c.country_de IS  NULL ,  '-', c.country_de )country, 
				  IF ( b.inserted_date =  '' OR b.inserted_date IS  NULL ,  '-', DATE_FORMAT(max( b.inserted_date ), '%d.%m.%Y')  )last_booking, 
				  IF ( bd.end_date =  '' OR bd.end_date IS  NULL ,  '-', DATE_FORMAT(max( bd.end_date ), '%d.%m.%Y'))last_stay 
				  FROM $tbl_guest g 
				  LEFT  JOIN $tbl_guest_address ga ON g.pk_guest_id = ga.pk_fk_guest_id AND ga.default_address = " . MetabaseGetBooleanFieldValue($gDatabase, true) . " 
				  LEFT  JOIN $tbl_address a ON ga.pk_fk_address_id = a.pk_address_id 
				  LEFT  JOIN $tbl_country c ON a.fk_country_id = c.pk_country_id 
				  LEFT  JOIN $tbl_booking b ON g.pk_guest_id = b.fk_guest_id 
				  LEFT  JOIN $tbl_booking_detail_guest bdg ON g.pk_guest_id = bdg.pk_fk_guest_id 
				  LEFT  JOIN $tbl_booking_detail bd ON bdg.pk_fk_booking_detail_id = bd.pk_booking_detail_id ";

        if ($firstname != "" or $lastname != "") {
            $query .= "WHERE ";
        } 
        if ($firstname != "") {
            $query .= "firstname LIKE '%" . $firstname . "%' ";
        } 
        if ($firstname != "" and $lastname != "") {
            $query .= "AND ";
        } 
        if ($lastname != "") {
            $query .= "lastname LIKE '%" . $lastname . "%' ";
        } 
        $query .= "GROUP  BY g.pk_guest_id ";
        $query .= "ORDER BY lastname, firstname ";

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Guest::easysearch()', $query);
        } else {
            $row = 0;
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $color = 0;
                if ($row % 2 <> 0) {
                    $color = 1;
                } 
                $guest[$row] = array('guestid' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                    'firstname' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                    'lastname' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                    'gender' => MetabaseFetchResult($gDatabase, $result, $row, 3),
                    'company' => MetabaseFetchResult($gDatabase, $result, $row, 4),
                    'address' => MetabaseFetchResult($gDatabase, $result, $row, 5),
                    'postalcode' => MetabaseFetchResult($gDatabase, $result, $row, 6),
                    'city' => MetabaseFetchResult($gDatabase, $result, $row, 7),
                    'country' => MetabaseFetchResult($gDatabase, $result, $row, 8),
                    'country_name' => MetabaseFetchResult($gDatabase, $result, $row, 9),
                    'last_booking' => MetabaseFetchResult($gDatabase, $result, $row, 10),
                    'last_stay' => MetabaseFetchResult($gDatabase, $result, $row, 11),
                    'color' => $color
                    );
            } 
        } 

        return $guest;
    } 

    /**
    * Guest::getCountries()
    * 
    * get Countries form Database
    * 
    * @return array countries
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getCountries()
    {
        global $tbl_country, $gDatabase, $errorhandler;
        $query = "SELECT pk_country_id, country_de FROM $tbl_country ORDER BY country_de";
        $result = MetabaseQuery($gDatabase, $query);

        if (!$result) {
            $errorhandler->display('SQL', 'Guest:getCountries', $query);
        } else {
            $ret = array();
            $row = 0;

            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $ret[$row] = array('countrySuffix' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                    'countryName' => MetabaseFetchResult($gDatabase, $result, $row, 1)
                    );
            } 
        } 
        return $ret;
    } 

    /**
    * Guest::quickinsert()
    * 
    * insert only firstname and lastname from a new guest into the db
    * 
    * @param string $firstname firstname
    * @param string $lastname lastname
    * @return array userdata
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function quickinsert($firstname, $lastname)
    {
        global $tbl_guest, $tbl_address, $tbl_guest_address, $gDatabase, $errorhandler, $request; 
        // transaction control
        $auto_commit = false;
        $success = MetabaseAutoCommitTransactions($gDatabase, $auto_commit);

        $name = "zvs_pk_guest_id";
        $sequence = MetabaseGetSequenceNextValue($gDatabase, $name, &$guestid);

        $query = sprintf("INSERT INTO $tbl_guest 
						(pk_guest_id, firstname, lastname, 
						inserted_date, fk_inserted_user_id, fk_salutation_id, 
						fk_language_id ) 
						VALUES (%s, %s, %s, " . "NOW(), %s, %s, %s )",
            $guestid,
            MetabaseGetTextFieldValue($gDatabase, $firstname),
            MetabaseGetTextFieldValue($gDatabase, $lastname),
            $request->GetVar('uid', 'session'),
            1,
            1
            );

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Guest::quickinsert()', $query);
            $success = MetabaseRollbackTransaction($gDatabase);
        } else {
            $name = "zvs_pk_address_id";
            $sequence = MetabaseGetSequenceNextValue($gDatabase, $name, &$addressid);
            $query = sprintf("INSERT INTO $tbl_address " . "(pk_address_id, " . "fk_country_id, inserted_date, " . "fk_inserted_user_id ) " . "VALUES (%s, %s, NOW(), %s) ",
                $addressid,
                MetabaseGetTextFieldValue($gDatabase, '--'),
                $request->GetVar('uid', 'session')
                );

            $result = MetabaseQuery($gDatabase, $query);
            if (!$result) {
                $errorhandler->display('SQL', 'Guest::quickinsert()', $query);
                $success = MetabaseRollbackTransaction($gDatabase);
            } else {
                $query = sprintf("INSERT INTO $tbl_guest_address " . "(pk_fk_guest_id, pk_fk_address_id) " . "VALUES (%s, %s) ",
                    $guestid,
                    $addressid
                    );
                $result = MetabaseQuery($gDatabase, $query);
                if (!$result) {
                    $errorhandler->display('SQL', 'Guest::quickinsert()', $query);
                    $success = MetabaseRollbackTransaction($gDatabase);
                } else {
                    $success = MetabaseCommitTransaction($gDatabase); 
                    // end transaction
                    $auto_commit = true;
                    $success = MetabaseAutoCommitTransactions($gDatabase, $auto_commit);

                    $guest[0] = array('guestid' => $guestid,
                        'firstname' => $firstname,
                        'lastname' => $lastname,
                        'city' => ' ',
                        'country' => ' ',
                        'country_name' => ' ',
                        'color' => 1
                        );
                    return $guest;
                } 
            } 
        } 
    } 

    /**
    * Guest::checkaddress()
    * 
    * check if there exists an valid address for a guest
    * 
    * @param integer $guestid guestid
    * @return boolean exists
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function checkaddress($guestid)
    {
        global $tbl_guest, $tbl_address, $tbl_guest_address, $gDatabase, $errorhandler, $request;

        $query = sprintf("SELECT pk_fk_address_id " . "FROM $tbl_guest_address " . "WHERE pk_fk_guest_id = %s ",
            $guestid
            );

        $addressResult = MetabaseQuery($gDatabase, $query);
        if (!$addressResult) {
            $errorhandler->display('SQL', 'Guest::checkaddress()', $query);
        } 

        $rows = MetabaseNumberOfRows($gDatabase, $addressResult);
        if ($rows > 0) {
            $address_id = MetabaseFetchResult($gDatabase, $addressResult, 0, 0);
            $address = $this->getAddress($address_id, true);

            if ($address[address] == null && $address[city] == null && $address[postalcode] == null) {
                return false;
            } else {
                return true;
            } 
        } 
    } 

    /**
    * Guest::getSalutation()
    * 
    * get the salutation titles
    * 
    * @return array salutation
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getSalutation()
    {
        global $tbl_salutation, $gDatabase, $errorhandler, $request;
        $query = "SELECT pk_salutation_id, salutation_de " . "FROM $tbl_salutation " . "ORDER BY salutation_de";
        $result = MetabaseQuery($gDatabase, $query);

        if (!$result) {
            $errorhandler->display('SQL', 'Guest::getSalutation()', $query);
        } else {
            $ret = array();
            $row = 0;

            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $ret[$row] = array('salutation_id' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                    'salutation' => MetabaseFetchResult($gDatabase, $result, $row, 1)
                    );
            } 
            return $ret;
        } 
    } 

    /**
    * Guest::getEscort()
    * 
    * get escorts
    * 
    * @param number $guestid guestid
    * @return array escorts
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getEscort($guestid)
    {
        global $tbl_guest, $tbl_booking_detail_guest, $gDatabase, $errorhandler, $request;
        $query = "( " . "SELECT DISTINCT b.fk_guest_id AS pk_guest_id, g.lastname AS lastname, g.firstname AS firstname " . "FROM zvs_booking_detail_guest bdg " . "LEFT JOIN zvs_booking_detail bd ON bdg.pk_fk_booking_detail_id = bd.pk_booking_detail_id " . "LEFT JOIN zvs_booking b ON bd.fk_booking_id = b.pk_booking_id " . "LEFT JOIN zvs_guest g ON b.fk_guest_id = g.pk_guest_id " . "WHERE bdg.pk_fk_guest_id = " . $guestid . " AND b.fk_guest_id != " . $guestid . " " . ") " . "UNION ( " . "SELECT DISTINCT bdg2.pk_fk_guest_id AS pk_guest_id, g.lastname AS lastname, g.firstname AS firstname " . "FROM zvs_booking_detail_guest bdg " . "LEFT JOIN zvs_booking_detail bd ON bdg.pk_fk_booking_detail_id = bd.pk_booking_detail_id " . "LEFT JOIN zvs_booking b ON bd.fk_booking_id = b.pk_booking_id " . "LEFT JOIN zvs_booking_detail bd2 ON b.pk_booking_id = bd2.fk_booking_id " . "LEFT JOIN zvs_booking_detail_guest bdg2 ON bd2.pk_booking_detail_id = bdg2.pk_fk_booking_detail_id " . "LEFT JOIN zvs_guest g ON bdg2.pk_fk_guest_id = g.pk_guest_id " . "WHERE bdg.pk_fk_guest_id = " . $guestid . " AND bdg2.pk_fk_guest_id != " . $guestid . " " . ") " . "ORDER BY lastname, firstname ";

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Guest::getEscort()', $query);
        } else {
            $ret = array();
            $row = 0;

            for ($row = 0; $row < MetabaseNumberOfRows($gDatabase, $result); ++$row) {
                $color = 0;
                if ($row % 2 <> 0) {
                    $color = 1;
                } 

                $ret[$row] = array('guestid' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                    'lastname' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                    'firstname' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                    'color' => $color
                    );
            } 

            return $ret;
        } 
    } 

    /**
    * Guest::getMeldeData()
    * 
    * check if there exists an valid address for a guest
    * 
    * @param integer $guestid guestid
    * @param integer $number number of meldescheinen to show (0 for all)
    * @return array Meldebescheinigungen
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getMeldeData($guestid, $number)
    {
        global $tbl_booking, $gDatabase, $errorhandler, $request;

        $query = "SELECT b.pk_booking_id, DATE_FORMAT(b.start_date, '%d.%m.%Y'),  
		          DATE_FORMAT(b.end_date, '%d.%m.%Y') 
				  FROM $tbl_booking b
				  WHERE b.fk_guest_id = " . $guestid . "
				  AND b. booking_type <>  " . MetabaseGetTextFieldValue($gDatabase, "R") . "
				  AND ISNULL(deleted_date) 
				  ORDER BY start_date DESC ";

        if ($number <> 0) {
            $query .= " LIMIT 0," . $number;
        } 

        $result = MetabaseQuery($gDatabase, $query);

        if (!$result) {
            $errorhandler->display('SQL', 'Guest::getMeldeData()', $query);
        } else {
            $row = 0;
            $meldedocuments = array();
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $color = 0;
                if ($row % 2 <> 0) {
                    $color = 1;
                } 

                $meldedocuments[$row] = array ('booking_id' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                    'start_date' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                    'end_date' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                    'color' => $color
                    );
            } 
            return $meldedocuments;
        } 
    } 

    /**
    * Guest::getLastBookings()
    * 
    * get last bookings of a guest
    * 
    * @param integer $guestid guestid
    * @param integer $numaber number of bookings to show (0 for all)
    * @return array last bookings
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getLastBookings($guestid, $number)
    {
        global $tbl_booking, $gDatabase, $errorhandler, $request;

        $query = "SELECT b.pk_booking_id, 
		          DATE_FORMAT(b.start_date, '%d.%m.%Y'), 
				  DATE_FORMAT(b.end_date, '%d.%m.%Y'), b.booking_reference_id 
				  FROM $tbl_booking b 
				  WHERE b.fk_guest_id = " . $guestid . "
				  AND DATE_FORMAT(b.start_date, '%Y%m%d' ) >= date_format( sysdate( ) , '%Y%m%d' ) 
				  AND ISNULL(b.deleted_date)
				  ORDER BY b.start_date DESC";
        if ($number <> 0) {
            $query .= " LIMIT 0," . $number;
        } 
        $result = MetabaseQuery($gDatabase, $query);

        if (!$result) {
            $errorhandler->display('SQL', 'Guest::getLastBookings()', $query);
        } else {
            $row = 0;
            $meldedocuments = array();
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $color = 0;
                if ($row % 2 <> 0) {
                    $color = 1;
                } 

                $meldedocuments[$row] = array ('booking_id' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                    'start_date' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                    'end_date' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                    'reference_id' => MetabaseFetchResult($gDatabase, $result, $row, 3),
                    'color' => $color
                    );
            } 
            return $meldedocuments;
        } 
    } 

    /**
    * Guest::getLastStays()
    * 
    * get last stays of a guest
    * 
    * @param integer $guestid guestid
    * @param integer $number number of stays to show (0 for all)
    * @return array last bookings
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getLastStays($guestid, $number)
    {
        global $tbl_booking, $tbl_booking_detail, $tbl_booking_detail_guest, $tbl_guest, $gDatabase, $errorhandler, $request;
        $query = "SELECT b.pk_booking_id, 
		          DATE_FORMAT(b.start_date, '%d.%m.%Y'), 
				  DATE_FORMAT(b.end_date, '%d.%m.%Y'),
				  b.booking_reference_id, 
				  g.firstname, g.lastname, g.pk_guest_id
				  FROM $tbl_booking b
				  LEFT JOIN $tbl_booking_detail bd ON bd.fk_booking_id = b.pk_booking_id 
				  LEFT JOIN $tbl_booking_detail_guest bdg ON bdg.pk_fk_booking_detail_id = bd.pk_booking_detail_id 
				  LEFT JOIN $tbl_guest g ON b.fk_guest_id = g.pk_guest_id 
				  WHERE bdg.pk_fk_guest_id = $guestid 
				  AND DATE_FORMAT(b.end_date, '%Y%m%d' ) <= date_format( sysdate( ) , '%Y%m%d' ) 
				  AND ISNULL(b.deleted_date)
				  ORDER BY b.start_date DESC";

        if ($number <> 0) {
            $query .= " LIMIT 0," . $number;
        } 
        $result = MetabaseQuery($gDatabase, $query);

        if (!$result) {
            $errorhandler->display('SQL', 'Guest::getLastBookings()', $query);
        } else {
            $row = 0;
            $meldedocuments = array();
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $color = 0;
                if ($row % 2 <> 0) {
                    $color = 1;
                } 

                $meldedocuments[$row] = array ('booking_id' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                    'start_date' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                    'end_date' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                    'reference_id' => MetabaseFetchResult($gDatabase, $result, $row, 3),
                    'firstname' => MetabaseFetchResult($gDatabase, $result, $row, 4),
                    'lastname' => MetabaseFetchResult($gDatabase, $result, $row, 5),
                    'color' => $color,
                    'guestid' => $guestid,
					'thisguestid' => MetabaseFetchResult($gDatabase, $result, $row, 6)
                    );
            } 
            return $meldedocuments;
        } 
    } 

    /**
    * Guest::getGreeting()
    * 
    * get the greeting for a guest
    * 
    * @param integer $guestid guestid
    * @return string greeting
    * @access public 
    * @since 2003-09-30
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getGreeting($guestid)
    {
        global $tbl_guest, $tbl_salutation, $gDatabase, $errorhandler;
        $str = "";
        $query = sprintf("SELECT s.salutation_de, g.academic_title, 
		                  g.firstname, g.lastname, g.formal_greeting, g.gender 
						  FROM $tbl_guest g
						  LEFT JOIN $tbl_salutation s ON (g.fk_salutation_id = s.pk_salutation_id) 
						  WHERE g.pk_guest_id = %s",
            $guestid
            );

        $result = MetabaseQuery($gDatabase, $query);
        if ($result) {
            if (MetabaseFetchBooleanResult($gDatabase, $result, 0, 4)) {
                switch (MetabaseFetchResult($gDatabase, $result, 0, 0)) {
                    case 'Herr':
                        $str = "Sehr geehrter Herr ";
                        if (MetabaseFetchResult($gDatabase, $result, 0, 1) != "" && MetabaseFetchResult($gDatabase, $result, 0, 1) != null) {
                            $str .= MetabaseFetchResult($gDatabase, $result, 0, 1) . " ";
                        } 
                        break;
                    case 'Frau':
                        $str = "Sehr geehrte Frau ";
                        if (MetabaseFetchResult($gDatabase, $result, 0, 1) != "" && MetabaseFetchResult($gDatabase, $result, 0, 1) != null) {
                            $str .= MetabaseFetchResult($gDatabase, $result, 0, 1) . " ";
                        } 
                        break;
                    case 'Familie':
                        $str = "Sehr geehrte Familie ";
                        break;
                } 
                $str .= MetabaseFetchResult($gDatabase, $result, 0, 3) . ", ";
            } else {
                if (MetabaseFetchResult($gDatabase, $result, 0, 5) == "M") {
                    $str = "Lieber ";
                } else {
                    $str = "Liebe ";
                } 
                $str .= MetabaseFetchResult($gDatabase, $result, 0, 2) . ", ";
            } 
        } else {
            $str = "Sehr geehrte Damen und Herren, ";
        } 
        return $str;
    } 

    /**
    * Guest::getLastReceipts()
    * 
    * get last receipts of a guest
    * 
    * @param integer $guestid guestid
    * @param integer $numaber number of bookings to show (0 for all)
    * @return array last receipts
    * @access public 
    * @since 2004-03-04
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getLastReceipts($guestid, $number)
    {
        global $tbl_booking, $tbl_receipt, $tbl_receipt_booking, $gDatabase, $errorhandler, $request;
        include_once('accountclass.inc.php');
        $account = New Account;

        $query = "SELECT DISTINCT r.pk_receipt_id, 
				  DATE_FORMAT(r.receipt_date, '%d.%m.%Y') as thedate,
				  DATE_FORMAT(b.start_date, '%d.%m.%Y') as start, 
				  DATE_FORMAT(b.end_date, '%d.%m.%Y') AS end, 
				  r.receipt_reference_id,  r.fk_guest_id
				  FROM  $tbl_receipt r
				  LEFT JOIN $tbl_receipt_booking rb ON r.pk_receipt_id = rb.pk_fk_receipt_id
				  LEFT JOIN $tbl_booking b ON b.pk_booking_id = rb.pk_fk_booking_id 				  
				  WHERE r.fk_guest_id = $guestid 
				  ORDER BY r.receipt_date DESC"; 
		//b.pk_booking_id,
        // AND r.pk_receipt_id = rb.pk_fk_receipt_id
        // AND b.pk_booking_id = rb.pk_fk_booking_id
        // GROUP BY r.receipt_reference_id
        if ($number <> 0) {
            $query .= " LIMIT 0," . $number;
        } 

        $result = MetabaseQuery($gDatabase, $query);

        if (!$result) {
            $errorhandler->display('SQL', 'Guest::getLastReceipts()', $query);
        } else {
            $row = 0;
            $receipts = array();
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $color = 0;
                if ($row % 2 <> 0) {
                    $color = 1;
                } 
                $receiptsum = $account->getReceiptSum(MetabaseFetchResult($gDatabase, $result, $row, 0));

                $receipts[$row] = array ('receipt_id' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                    'receipt_date' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                    'start_date' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                    'end_date' => MetabaseFetchResult($gDatabase, $result, $row, 3),
                    'reference_id' => MetabaseFetchResult($gDatabase, $result, $row, 4),
                    'guest_id' => MetabaseFetchResult($gDatabase, $result, $row, 5),
                    'color' => $color,
                    'type' => $receiptsum['type'],
                    'sum' => $receiptsum['sum']
                    );
                 //'book_id' => MetabaseFetchResult($gDatabase, $result, $row, 5),					
            } 
            return $receipts;
        } 
    } 

    /**
    * Guest::getList()
    * 
    * get a list of all guests
    * 
    * @access public 
    * @since 2004-03-29
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getList()
    {
        global $gDatabase, $tbl_guest, $tbl_guest_address, $tbl_address, $errorhandler;
        $query = "SELECT pk_guest_id, firstname, lastname, 
				  IF ( a.city =  '' OR a.city IS  NULL ,  '-', a.city )city
				  FROM $tbl_guest g 
			 	  LEFT  JOIN $tbl_guest_address ga ON g.pk_guest_id = ga.pk_fk_guest_id AND ga.default_address = " . MetabaseGetBooleanFieldValue($gDatabase, true) . " 
				  LEFT  JOIN $tbl_address a ON ga.pk_fk_address_id = a.pk_address_id 
				  
				  ORDER BY lastname";

        $result = MetabaseQuery($gDatabase, $query);

        if (!$result) {
            $errorhandler->display('SQL', 'Guest::getList()', $query);
        } 
        $row = 0;
        $guests = array();
        for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
            $guests[$row] = array ('guest_id' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                'firstname' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                'lastname' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                'city' => MetabaseFetchResult($gDatabase, $result, $row, 3)
                );
        } 
        return $guests;
    } 

    /**
    * Guest::getListWithoutEscorts()
    * 
    * get a list of all guests
    * 
	* @param int $bookingdetailid booking detail id
	* @param int $oldguestid guest id of the original guest
    * @access public 
    * @since 2004-08-13
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getListWithoutEscorts($bookingdetailid, $oldguestid)
    {
        global $gDatabase, $tbl_guest, $tbl_guest_address, $tbl_booking_detail_guest, $tbl_address, $errorhandler;

        $query = "SELECT pk_fk_guest_id
				  FROM $tbl_booking_detail_guest 
			 	  WHERE pk_fk_booking_detail_id = $bookingdetailid
				  AND pk_fk_guest_id != $oldguestid";

        $result = MetabaseQuery($gDatabase, $query);

        if (!$result) {
            $errorhandler->display('SQL', 'Guest::getListWithoutEscorts()', $query);
        } 
        $row = 0;
        $guests = array();
		$guestids = '';
        for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
			if ($guestids == '') {
			    $guestids = MetabaseFetchResult($gDatabase, $result, $row, 0);
			} else {
				$guestids = $guestids . ", " . MetabaseFetchResult($gDatabase, $result, $row, 0);
			}
        } 

        $query = "SELECT pk_guest_id, firstname, lastname, 
				  IF ( a.city =  '' OR a.city IS  NULL ,  '-', a.city )city
				  FROM $tbl_guest g 
			 	  LEFT  JOIN $tbl_guest_address ga ON g.pk_guest_id = ga.pk_fk_guest_id AND ga.default_address = " . MetabaseGetBooleanFieldValue($gDatabase, true) . " 
				  LEFT  JOIN $tbl_address a ON ga.pk_fk_address_id = a.pk_address_id ";
		if ($guestids = '') {
		    $query .= "WHERE pk_guest_id NOT IN ($guestids) ";
		}
				  
		$query .= "ORDER BY lastname ";

        $result = MetabaseQuery($gDatabase, $query);

        if (!$result) {
            $errorhandler->display('SQL', 'Guest::getListWithoutEscorts()', $query);
        } 
        $row = 0;
        $guests = array();
        for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
            $guests[$row] = array ('guest_id' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                'firstname' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                'lastname' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                'city' => MetabaseFetchResult($gDatabase, $result, $row, 3)
                );
        } 
        return $guests;
    } 
} 

?>
