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
* Email confirmation
* 
* @since 2003-10-12
* @author Christian Ehret <chris@uffbasse.de> 
* @version $Id: emailconfirmation.php,v 1.1 2004/11/03 13:56:59 ehret Exp $
*/

/**
* createEmailConfirmation()
* 
* Create a mailto link for email confirmation
* 
* @param number $bookid id of booking
* @return string mailto link
* @access public 
* @since 2003-10-12
* @author Christian Ehret <chris@uffbasse.de> 
*/
function createEmailConfirmation($bookid)
{
    global $tbl_booking, $tbl_guest, $tbl_address, $tbl_guest_address, $tbl_bookingcat, $tbl_country, $gDatabase, $errorhandler, $request;
    include_once('guestclass.inc.php');
    $guest = New Guest;

    $query = "SELECT $tbl_booking.fk_bookingcat_id, $tbl_booking.fk_guest_id, 
	          UNIX_TIMESTAMP(start_date), UNIX_TIMESTAMP(end_date), 
			  TO_DAYS( end_date ) - TO_DAYS( start_date ) AS days, 
			  $tbl_booking.persons, children, $tbl_guest.firstname, 
			  $tbl_guest.lastname, $tbl_bookingcat.bookingcat, 
			  DATE_FORMAT($tbl_guest.date_of_birth , '%d.%m.%Y'), 
			  postalcode, city, address, country_de, email, 
			  booking_type, $tbl_guest.formal_greeting,  
			  $tbl_guest.gender, 
			  COALESCE( CASE WHEN $tbl_bookingcat.description = '' THEN NULL ELSE $tbl_bookingcat.description END, CASE WHEN $tbl_bookingcat.bookingcat = '' THEN NULL ELSE $tbl_bookingcat.bookingcat END, '' ),
			  children2, children3 
			  FROM $tbl_booking 
			  LEFT JOIN $tbl_guest ON ($tbl_booking.fk_guest_id = $tbl_guest.pk_guest_id) 
			  LEFT JOIN $tbl_guest_address ON ($tbl_guest_address.default_address  = " . MetabaseGetBooleanFieldValue($gDatabase, true) . " 
			  AND $tbl_guest.pk_guest_id = $tbl_guest_address.pk_fk_guest_id) 
			  LEFT JOIN $tbl_address ON ($tbl_address.pk_address_id = $tbl_guest_address.pk_fk_address_id) 
			  LEFT JOIN $tbl_bookingcat ON ($tbl_booking.fk_bookingcat_id = $tbl_bookingcat.pk_bookingcat_id) 
			  LEFT JOIN $tbl_country ON (fk_country_id = $tbl_country.pk_country_id )
			  WHERE pk_booking_id =  " . $bookid;

    $result = MetabaseQuery($gDatabase, $query);

    if (!$result) {
        $errorhandler->display('SQL', 'Booking::emailConfirmation()', $query);
    } else {
        if (MetabaseNumberOfRows($gDatabase, $result) == 1) {
            $booking = array();
            $str = "";
            $bookingtype = "";
            $bookingstr = "";
            $isformal = MetabaseFetchBooleanResult($gDatabase, $result, 0, 16);
            $dirihnen = "Dir";
            if ($isformal) {
                $dirihnen = "Ihnen";
            } 
            switch (MetabaseFetchResult($gDatabase, $result, 0, 16)) {
                case 'R':
                    $bookingtype = "Reservierungsbest&auml;tigung";
                    $bookingstr = "Reservierung";
                    break;
                case 'B':
                    $bookingtype = "Buchungsbest&auml;tigung";
                    $bookingstr = "Buchung";
                    break;
                case 'P':
                    $bookingtype = "Buchungsbest&auml;tigung";
                    $bookingstr = "Buchung";
                    break;
            } 
            $body = "";
            $body .= $guest->GetGreeting(MetabaseFetchResult($gDatabase, $result, 0, 1)) . "\n";
            $body .= "hiermit bestätigen wir " . $dirihnen . " folgende " . $bookingstr . ":\n\n";
            $body .= "Anreise: " . date("d. m. Y", MetabaseFetchResult($gDatabase, $result, 0, 2)) . "\n";
            $body .= "Abreise: " . date("d. m. Y", MetabaseFetchResult($gDatabase, $result, 0, 3)) . "\n";
            $body .= "Kategorie: " . MetabaseFetchResult($gDatabase, $result, 0, 19) . "\n";
            $body .= "Erwachsene: " . MetabaseFetchResult($gDatabase, $result, 0, 5) . "\n";
            $body .= $request->GetVar('children1','session').": " . MetabaseFetchResult($gDatabase, $result, 0, 6) . "\n";
			$body .= $request->GetVar('children2','session').": " . MetabaseFetchResult($gDatabase, $result, 0, 20) . "\n";
			$body .= $request->GetVar('children3','session').": " . MetabaseFetchResult($gDatabase, $result, 0, 21) . "\n\n";
            $body .= "für:\n";
            $body .= MetabaseFetchResult($gDatabase, $result, 0, 7) . " " . MetabaseFetchResult($gDatabase, $result, 0, 8) . "\n";
            $body .= MetabaseFetchResult($gDatabase, $result, 0, 13) . "\n";
            $body .= MetabaseFetchResult($gDatabase, $result, 0, 11) . " " . MetabaseFetchResult($gDatabase, $result, 0, 12) . "\n";
            $body .= MetabaseFetchResult($gDatabase, $result, 0, 14) . "\n\n";

            $str = "mailto:" . MetabaseFetchResult($gDatabase, $result, 0, 7) . "%20" . MetabaseFetchResult($gDatabase, $result, 0, 8) . "%20&lt;" . MetabaseFetchResult($gDatabase, $result, 0, 15) . "&gt;?subject=$bookingtype" . "&body=" . rawurlencode($body) ;
        } 
        return $str;
    } 
} 

?>