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
* class account
* 
* Class for account functionality
* 
* This class has all functions which are needed for the accounts.
* 
* @since 2004-03-10
* @author Christian Ehret <chris@uffbasse.de> 
* @version $Id: accountclass.inc.php,v 1.2 2004/12/05 19:56:16 ehret Exp $
*/
class account {
    /**
    * account::get()
    * 
    * get
    * 
    * @param  $guestid guest id
    * @param integer $number number of bookings to show (0 for all)
    * @return $data data
    * @access public 
    * @since 2004-03-10
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function get($guestid, $number)
    {
        global $gDatabase, $tbl_account, $tbl_receipt, $tbl_booking, $tbl_booking_detail, $tbl_room, $tbl_paycat, $errorhandler, $request;

        $query = "SELECT a.description, a.amount, DATE_FORMAT(a.date_payment, '%d.%m.%Y'), 
				  a.fk_receipt_id, r.receipt_reference_id, b.booking_reference_id, b.pk_booking_id,
				  p.paycat, a.fk_paycat_id, a.on_receipt, a.pk_account_id, ro.room
				  FROM $tbl_account a 
				  LEFT JOIN $tbl_receipt r ON a.fk_receipt_id = r.pk_receipt_id
				  LEFT JOIN $tbl_booking b ON a.fk_booking_id = b.pk_booking_id
				  LEFT JOIN $tbl_paycat p ON a.fk_paycat_id = p.pk_paycat_id
				  LEFT JOIN $tbl_booking_detail bd ON b.pk_booking_id = bd.fk_booking_id
				  LEFT JOIN $tbl_room ro ON bd.fk_room_id = ro.pk_room_id
				  WHERE a.fk_guest_id = $guestid
				  ORDER BY a.date_payment DESC";
        if ($number <> 0) {
            $query .= " LIMIT 0," . $number;
        } 
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Account::get()', $query);
        } else {
            $data = array();
            $row = 0;
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $color = 1;
                if ($row % 2 <> 0) {
                    $color = 0;
                } 

                $data[$row] = array ('description' => nl2br(MetabaseFetchResult($gDatabase, $result, $row, 0)),
                    'amount' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                    'thedate' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                    'receiptid' => MetabaseFetchResult($gDatabase, $result, $row, 3),
                    'referenceid' => MetabaseFetchResult($gDatabase, $result, $row, 4),
                    'breferenceid' => MetabaseFetchResult($gDatabase, $result, $row, 5),
                    'bookingid' => MetabaseFetchResult($gDatabase, $result, $row, 6),
                    'paycat' => MetabaseFetchResult($gDatabase, $result, $row, 7),
                    'paycatid' => MetabaseFetchResult($gDatabase, $result, $row, 8),
                    'on_receipt' => MetabaseFetchBooleanResult($gDatabase, $result, $row, 9),
                    'accountid' => MetabaseFetchResult($gDatabase, $result, $row, 10),
                    'room' => MetabaseFetchResult($gDatabase, $result, $row, 11),
                    'color' => $color
                    );
            } 
            return $data;
        } 
    } 

    /**
    * account::del()
    * 
    * del
    * 
    * @param  $accountid account id
    * @access public 
    * @since 2004-05-18
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function del($accountid)
    {
        global $gDatabase, $tbl_account, $errorhandler, $request;

        $query = "DELETE FROM $tbl_account 
				  WHERE pk_account_id = $accountid"; 
        // AND ISNULL(fk_receipt_id)";
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Account::del()', $query);
        } 
    } 

    /**
    * account::getBalance()
    * 
    * get balance
    * 
    * @param  $guestid guest id
    * @return $data data
    * @access public 
    * @since 2004-03-10
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getBalance($guestid)
    {
        global $gDatabase, $tbl_account, $errorhandler, $request;

        $query = sprintf("SELECT SUM(amount)
				  		  FROM $tbl_account 
				  		  WHERE allocated = %s
						  AND fk_guest_id = %s",
            MetabaseGetBooleanFieldValue($gDatabase, false),
            $guestid
            );
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Account::getBalance()', $query);
        } else {
            return MetabaseFetchResult($gDatabase, $result, $row, 0);
        } 
    } 

    /**
    * account::setStatus()
    * 
    * set Status of a booking
    * 
    * @param integer $receiptid receipt id
    * @param integer $bookingid booking id
    * @access public 
    * @since 2004-04-06
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function setStatus($receiptid, $bookingid)
    {
        global $gDatabase, $tbl_account, $tbl_booking, $tbl_receipt_booking, $errorhandler, $request;

        $query = "SELECT pk_fk_receipt_id FROM $tbl_receipt_booking
					WHERE pk_fk_booking_id = $bookingid";
        $result = MetabaseQuery($gDatabase, $query);
        $receiptsum = 0;
        if (!$result) {
            $errorhandler->display('SQL', 'Account::setStatus()', $query);
        } else {
            $row = 0;
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $tmp = $this->getReceiptSum(MetabaseFetchResult($gDatabase, $result, $row, 0));
                $receiptsum += $tmp['sum'];
            } 
        } 
        $query = "SELECT booking_type FROM $tbl_booking
					  WHERE pk_booking_id = $bookingid";
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Account::setStatus()', $query);
        } else {
            if (MetabaseFetchResult($gDatabase, $result, 0, 0) == 'R') {
                if ($receiptsum <= 0 && $receiptid != -1) {
                    $type = 'P';
                } else {
                    $type = 'B';
                } 

                $query = sprintf("UPDATE $tbl_booking
				  					SET booking_type = %s
									WHERE pk_booking_id = %s",
                    MetabaseGetTextFieldValue($gDatabase, $type),
                    $bookingid
                    );
                $result = MetabaseQuery($gDatabase, $query);
                if (!$result) {
                    $errorhandler->display('SQL', 'Account::setStatus()', $query);
                } 
            } elseif (MetabaseFetchResult($gDatabase, $result, 0, 0) == 'B') {
                if ($receiptsum <= 0 && $receiptid != -1) {
                    $query = sprintf("UPDATE $tbl_booking
				  					SET booking_type = %s
									WHERE pk_booking_id = %s",
                        MetabaseGetTextFieldValue($gDatabase, 'P'),
                        $bookingid
                        );
                    $result = MetabaseQuery($gDatabase, $query);
                    if (!$result) {
                        $errorhandler->display('SQL', 'Account::setStatus()', $query);
                    } 
                } 
            } 
        } 
    } 
    /**
    * account::book()
    * 
    * book
    * 
    * @param integer $guestid guest id
    * @param integer $bookingid booking id
    * @param datetime $dateofpayment date of payment
    * @param text $description description
    * @param number $amount amount
    * @param integer $paycatid paycat id
    * @param integer $receiptid receipt it (-1 if no receipt)
    * @access public 
    * @since 2004-03-10
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function book($guestid, $bookingid, $dateofpayment, $description, $amount, $paycatid, $receiptid, $on_receipt)
    {
        global $gDatabase, $tbl_account, $tbl_booking, $errorhandler, $request;
        $name = "zvs_pk_account_id";
        $sequence = MetabaseGetSequenceNextValue($gDatabase, $name, &$accountid);
        if (($on_receipt === true || $on_receipt == 'true') && $receiptid != -1) {
            $on_receipt = true;
        } else {
            $on_receipt = false;
        } 
        list($day, $month, $year) = split('[.]', $dateofpayment);
        $dateofpayment = mktime(0, 0, 0, $month, $day, $year);
        if ($receiptid == -1) {
            $query = sprintf("INSERT INTO $tbl_account
							 (pk_account_id, fk_guest_id, fk_booking_id, date_payment, description, amount,
							 inserted_date, fk_inserted_user_id, fk_paycat_id, on_receipt)
							 VALUES (%s, %s, %s, %s, %s, %s, NOW(), %s, %s, %s )",
                $accountid,
                $guestid,
                $bookingid,
                MetabaseGetTextFieldValue($gDatabase, date("Y-m-d", $dateofpayment)),
                MetabaseGetTextFieldValue($gDatabase, $description),
                $amount,
                $request->GetVar('uid', 'session'),
                $paycatid,
                MetabaseGetBooleanFieldValue($gDatabase, $on_receipt)
                );
        } else {
            $query = sprintf("INSERT INTO $tbl_account
							 (pk_account_id, fk_guest_id, fk_booking_id, date_payment, description, amount, 
							 fk_receipt_id, allocated,
							 inserted_date, fk_inserted_user_id, fk_paycat_id, on_receipt)
							 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, NOW(), %s, %s, %s )",
                $accountid,
                $guestid,
                $bookingid,
                MetabaseGetTextFieldValue($gDatabase, date("Y-m-d", $dateofpayment)),
                MetabaseGetTextFieldValue($gDatabase, $description),
                $amount,
                $receiptid,
                MetabaseGetBooleanFieldValue($gDatabase, true),
                $request->GetVar('uid', 'session'),
                $paycatid,
                MetabaseGetBooleanFieldValue($gDatabase, $on_receipt)
                );
        } 

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Account::book()', $query);
        } else {
            $this->setStatus($receiptid, $bookingid);
            /*		
            $receiptsum = $this->getReceiptSum($receiptid);
            $receiptsum = $receiptsum['sum'];

            $query = "SELECT booking_type FROM $tbl_booking
					  WHERE pk_booking_id = $bookingid";
            $result = MetabaseQuery($gDatabase, $query);
            if (!$result) {
                $errorhandler->display('SQL', 'Account::book()', $query);
            } else {
                if (MetabaseFetchResult($gDatabase, $result, 0, 0) == 'R') {
                    if ($receiptsum <= 0 && $receiptid != -1) {
                        $type = 'P';
                    } else {
                        $type = 'B';
                    } 

                    $query = sprintf("UPDATE $tbl_booking
				  					SET booking_type = %s
									WHERE pk_booking_id = %s",
                        MetabaseGetTextFieldValue($gDatabase, $type),
                        $bookingid
                        );
                    $result = MetabaseQuery($gDatabase, $query);
                    if (!$result) {
                        $errorhandler->display('SQL', 'Account::book()', $query);
                    } 
                } elseif (MetabaseFetchResult($gDatabase, $result, 0, 0) == 'B') {
                    if ($receiptsum <= 0 && $receiptid != -1) {
                        $query = sprintf("UPDATE $tbl_booking
				  					SET booking_type = %s
									WHERE pk_booking_id = %s",
                            MetabaseGetTextFieldValue($gDatabase, 'P'),
                            $bookingid
                            );
                        print $query;
                        $result = MetabaseQuery($gDatabase, $query);
                        if (!$result) {
                            $errorhandler->display('SQL', 'Account::book()', $query);
                        } 
                    } 
                } 
            } 
*/
        } 
    } 

    /**
    * account::getOpenBookings()
    * 
    * get open bookings
    * 
    * @param  $guestid guest id
    * @return $bookings array of bookings
    * @access public 
    * @since 2004-03-16
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getOpenBookings($guestid)
    {
        global $gDatabase, $tbl_booking, $tbl_receipt, $tbl_booking_detail, $tbl_booking_detail_guest, $tbl_receipt_booking, $tbl_room, $errorhandler, $request;

        $query = "SELECT b.pk_booking_id, b.booking_reference_id,
					DATE_FORMAT(b.start_date, '%d.%m.%Y'), DATE_FORMAT(b.end_date, '%d.%m.%Y'),
					room
				  FROM $tbl_booking b
				  LEFT JOIN $tbl_booking_detail bd ON b.pk_booking_id = bd.fk_booking_id
				  LEFT JOIN $tbl_booking_detail_guest bdg ON bdg.pk_fk_booking_detail_id = bd.pk_booking_detail_id
				  LEFT JOIN $tbl_receipt_booking rb ON b.pk_booking_id = rb.pk_fk_booking_id
				  LEFT JOIN $tbl_receipt r ON rb.pk_fk_receipt_id = r.pk_receipt_id
				  LEFT JOIN $tbl_room ro ON bd.fk_room_id = ro.pk_room_id
				  WHERE rb.pk_fk_booking_id IS NULL 
				  AND ISNULL(b.deleted_date)
				  AND bdg.pk_fk_guest_id = $guestid
				  ORDER BY b.start_date ";

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Account::getOpenBookings()', $query);
        } else {
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $bookings[$row] = array ('bookingid' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                    'referenceid' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                    'start' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                    'end' => MetabaseFetchResult($gDatabase, $result, $row, 3),
                    'room' => MetabaseFetchResult($gDatabase, $result, $row, 4)
                    );
            } 
            return $bookings;
        } 
    } 

    /**
    * price::getReceiptSum()
    * 
    * get receipt sum including all payments (on receipt and not on receipt)
    * 
    * @access public 
    * @param  $receiptid receipt id
    * @return array receipt
    * @since 2004-03-25
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getReceiptSum($receiptid)
    {
        global $gDatabase, $tbl_receipt_item, $tbl_account, $errorhandler;
        $receipt = array();

        $query = "SELECT amount * price_brutto as total_brutto
					  FROM $tbl_receipt_item
					  WHERE fk_receipt_id = $receiptid 
					  AND ISNULL(fk_deleted_user_id) ";

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Acount::getReceiptSum()', $query);
        } else {
            $row = 0;
            $sumbrutto = 0.00;
            $payed = 0.00;
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $sumbrutto += MetabaseFetchResult($gDatabase, $result, $row, 0);
            } 
            $total = $sumbrutto;
            $query = "SELECT amount 
					  FROM $tbl_account
					  WHERE fk_receipt_id = $receiptid ";
            $result = MetabaseQuery($gDatabase, $query);
            if (!$result) {
                $errorhandler->display('SQL', 'Acount::getReceiptSum()', $query);
            } else {
                $row = 0;
                for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                    $payed += MetabaseFetchResult($gDatabase, $result, $row, 0);
                    $sumbrutto -= MetabaseFetchResult($gDatabase, $result, $row, 0);
                } 
            } 
			$sumbrutto = round($sumbrutto,2);
            if ($sumbrutto <= 0) {
                $type = 'green';
            } elseif ($total > $sumbrutto) {
                $type = 'yellow';
            } else {
                $type = 'red';
            } 
            $ret = array('sum' => $sumbrutto,
                'type' => $type,
                'payed' => $payed);
            return $ret;
        } 
    } 

    /**
    * Account::getlist()
    * 
    * This function returns all receipts.
    * 
    * @param date $thestart start date
    * @param date $theend end date
    * @param int $paycat paycat id (-1 for all)
    * @return array turnovers
    * @access public 
    * @since 2004-04-07
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getlist($thestart, $theend, $paycat)
    {
        global $gDatabase, $tbl_account, $tbl_receipt, $tbl_paycat, $tbl_guest, $request, $errorhandler;

        $turnovers = array();
        $query = "SELECT a.amount, DATE_FORMAT(a.date_payment, '%d.%m.%Y'), a.description, 
				  p.paycat, DATE_FORMAT(r.receipt_date, '%d.%m.%Y'), r.receipt_reference_id, g.firstname, g.lastname
		                 FROM $tbl_account a
						 LEFT JOIN $tbl_paycat p ON a.fk_paycat_id = p.pk_paycat_id
						 LEFT JOIN $tbl_receipt r ON a.fk_receipt_id = r.pk_receipt_id
 						 LEFT JOIN $tbl_guest g ON a.fk_guest_id = g.pk_guest_id								 
						 WHERE date_payment >= '$thestart'
						 AND date_payment <= '$theend' ";
        if ($paycat != -1) {
            $query .= "AND a.fk_paycat_id = $paycat ";
        } 
        $query .= "ORDER BY date_payment DESC";

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Account::getlist()', $query);
        } else {
            $row = 0;
            $sum = 0.00;
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $color = 0;
                if ($row % 2 <> 0) {
                    $color = 1;
                } 
                $turnovers[$row] = array ('amount' => number_format(MetabaseFetchResult($gDatabase, $result, $row, 0), 2, '.', ''),
                    'date_payment' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                    'description' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                    'paycat' => MetabaseFetchResult($gDatabase, $result, $row, 3),
                    'receipt_date' => MetabaseFetchResult($gDatabase, $result, $row, 4),
                    'receipt_reference_id' => MetabaseFetchResult($gDatabase, $result, $row, 5),
                    'firstname' => MetabaseFetchResult($gDatabase, $result, $row, 6),
                    'lastname' => MetabaseFetchResult($gDatabase, $result, $row, 7),
                    'color' => $color
                    );
                $sum += MetabaseFetchResult($gDatabase, $result, $row, 0);
            } 
            $color = 0;
            if ($row % 2 <> 0) {
                $color = 1;
            } 
            $turnovers[$row] = array ('amount' => number_format($sum, 2, '.', ''),
                'date_payment' => '',
                'description' => 'Gesamt:',
                'paycat' => '',
                'receipt_date' => '',
                'receipt_reference_id' => '',
                'firstname' => '',
                'lastname' => '',
                'color' => $color
                );
        } 
        return $turnovers;
    } 
    /**
    * Account::getdates()
    * 
    * This function returns an array with all dates.
    * 
    * @return array dates
    * @access public 
    * @since 2004-04-07
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getdates()
    {
        global $gDatabase, $tbl_account, $request, $errorhandler;

        $dates = array();
        $j = 0;
        $query = "SELECT DATE_FORMAT(min( date_payment  ) ,'%Y'),  DATE_FORMAT(max( date_payment  ),'%Y')  
		                 FROM $tbl_account  ";
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Account::getdates()', $query);
        } else {
            $startyear = MetabaseFetchResult($gDatabase, $result, 0, 0);
            $endyear = MetabaseFetchResult($gDatabase, $result, 0, 1);
            for ($year = $startyear; $year <= $endyear+1; ++$year) {
                for ($i = 1; $i <= 12; $i++) {
                    $dates[$j] = $i . '/' . $year;
                    $j++;
                } 
            } 
        } 
        return $dates;
    } 
} 

?>