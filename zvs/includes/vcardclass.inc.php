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
* class vcard
* 
* Class for exporting vcards
* 
* This class has all functions which are needed for vcards.
* 
* @since 2003-09-15
* @author Christian Ehret <chris@uffbasse.de> 
* @version $Id: vcardclass.inc.php,v 1.1 2004/11/03 14:53:19 ehret Exp $
*/
class vcard {
    /**
    * Vcard::getVersion()
    * 
    * This functions get the vcard version of the settings
    * 
    * @access private 
    * @since 2003-09-16
    * @author Christian Ehret <chris@uffbasse.de> 
    * @return number vcard version ('2' for 2.1 or '3' for 3.0)
    */
    function getVersion()
    {
        global $request;
        $number = $request -> GetVar('vcard_version', 'session');
        if ($number != 2 and $number != 3) {
            $number = 2;
        } 
        return $number;
    } 

    /**
    * Vcard::fetch()
    * 
    * This functions exports a contact to a vcard
    * 
    * @param array $guest guest data
    * @access public 
    * @since 2003-09-15
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function fetch($guest)
    {
        $version = $this -> getVersion();
        if ($version == 2) {
            $linefeed = "\r\n";
            $strversion = "2.1";
        } else {
            $linefeed = "\n";
            $strversion = "3.0";
        } 
        $str = "BEGIN:VCARD" . $linefeed;
        $str .= "VERSION:" . $strversion . $linefeed;
        $str .= "REV:" . date("Y-m-d") . $linefeed;
        $str .= "TZ:" . date("O") . $linefeed;
        $str .= "FN:" . $guest[firstname] . " " . $guest[lastname] . $linefeed;
        $str .= "N:" . $guest[lastname] . ";" . $guest[firstname] . $linefeed;
        $str .= "ORG:" . $guest[company] . "\r\n";
        $str .= "BDAY:" . $guest[date_of_birth_int] . $linefeed;
        $str .= "ROLE:" . $guest[job] . $linefeed;
        $str .= "TITLE:" . $guest[academic_title] . $linefeed;
        $str .= "NOTE:" . $guest[additional_info] . $linefeed;

        if ($guest[privateAddress][defaultaddress] == 1) {
            $str .= "EMAIL;TYPE=INTERNET,PREF:" . $guest[privateAddress][email] . $linefeed;
            $str .= "EMAIL;TYPE=INTERNET:" . $guest[businessAddress][email] . $linefeed;
            $str .= "EMAIL;TYPE=INTERNET:" . $guest[otherAddress][email] . $linefeed;
            $str .= "TEL;TYPE=VOICE,CELL:" . $guest[privateAddress][mobile] . $linefeed;
        } elseif ($guest[businessAddress][defaultaddress] == 1) {
            $str .= "EMAIL;TYPE=INTERNET,PREF:" . $guest[businessAddress][email] . $linefeed;
            $str .= "EMAIL;TYPE=INTERNET:" . $guest[privateAddress][email] . $linefeed;
            $str .= "EMAIL;TYPE=INTERNET:" . $guest[otherAddress][email] . $linefeed;
            $str .= "TEL;TYPE=VOICE,CELL:" . $guest[businessAddress][mobile] . $linefeed;
        } elseif ($guest[otherAddress][defaultaddress] == 1) {
            $str .= "EMAIL;TYPE=INTERNET,PREF:" . $guest[otherAddress][email] . $linefeed;
            $str .= "EMAIL;TYPE=INTERNET:" . $guest[privateAddress][email] . $linefeed;
            $str .= "EMAIL;TYPE=INTERNET:" . $guest[businessAddress][email] . $linefeed;
            $str .= "TEL;TYPE=VOICE,CELL:" . $guest[otherAddress][mobile] . $linefeed;
        } 

        $str .= "TEL;TYPE=FAX,HOME:" . $guest[privateAddress][fax] . $linefeed;
        $str .= "TEL;TYPE=FAX,WORK:" . $guest[businessAddress][fax] . $linefeed;
        $str .= "TEL;TYPE=FAX,OTHER:" . $guest[otherAddress][fax] . $linefeed;

        $str .= "TEL;TYPE=VOICE,HOME:" . $guest[privateAddress][phone] . $linefeed;
        $str .= "TEL;TYPE=VOICE,WORK:" . $guest[businessAddress][phone] . $linefeed;
        $str .= "TEL;TYPE=VOICE,OTHER:" . $guest[otherAddress][phone] . $linefeed;

        $str .= "URL;HOME:" . $guest[privateAddress][homepage] . $linefeed;
        $str .= "URL;WORK:" . $guest[businessAddress][homepage] . $linefeed;
        $str .= "URL;OTHER:" . $guest[otherAddress][homepage] . $linefeed;

        $str .= "ADR;HOME:" . ";;" . $guest[privateAddress][address] . ";" . $guest[privateAddress][city] . ";" . $guest[privateAddress][region] . ";" . $guest[privateAddress][postalcode] . ";" . $guest[privateAddress][country_Name] . $linefeed;
        $str .= "ADR;WORK:" . ";;" . $guest[businessAddress][address] . ";" . $guest[businessAddress][city] . ";" . $guest[businessAddress][region] . ";" . $guest[businessAddress][postalcode] . ";" . $guest[businessAddress][country_Name] . $linefeed;
        $str .= "ADR;OTHER:" . ";;" . $guest[otherAddress][address] . ";" . $guest[otherAddress][city] . ";" . $guest[otherAddress][region] . ";" . $guest[otherAddress][postalcode] . ";" . $guest[otherAddress][country_Name] . $linefeed;

        if ($version == 3) {
            $str .= "CLASS:PUBLIC" . $linefeed;
            $str .= "PRODID: ZVS" . $linefeed;
        } 
        if ($version == 10) {
            $str .= "SORTSTRING:" . $guest[job] . $linefeed;
        } 
        $str .= "END:VCARD" . $linefeed;

        print $str;
    } 
} 

?>

