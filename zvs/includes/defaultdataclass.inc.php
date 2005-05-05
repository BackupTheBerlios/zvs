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
* class DefaultData
* 
* Class for default data
* 
* This class has all functions which are needed for handling default data.
* 
* @since 2003-08-01
* @author Christian Ehret <chris@uffbasse.de> 
* @version $Id: defaultdataclass.inc.php,v 1.2 2005/05/05 10:03:20 ehret Exp $
*/
class DefaultData {
    /**
    * DefaultData::load()
    * 
    * This function loads default data into session
    * 
    * @access public 
    * @since 2003-08-01
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function load()
    {
        global $request, $sess, $gDatabase, $tbl_hotel_default, $tbl_default, $errorhandler;

        if ($request -> GetVar('hotel_name', 'session') == $request -> undefined && $request -> GetVar('hotelid', 'session') !== $request -> undefined) {
            $query = "SELECT def.pk_default_id, default_name, fieldtype, 
						IF(ISNULL(hotel.string_value),def.string_value,hotel.string_value) AS string_value, 
						IF(ISNULL(hotel.integer_value),def.integer_value,hotel.integer_value) AS integer_value, " . "IF(ISNULL(hotel.datetime_value),def.datetime_value,hotel.datetime_value) AS datetime_value, " . "IF(ISNULL(hotel.boolean_value),def.boolean_value,hotel.boolean_value) AS boolean_value " . "FROM $tbl_default AS def " . "LEFT JOIN $tbl_hotel_default AS hotel " . "ON (hotel.pk_fk_default_id = def.pk_default_id 
						AND hotel.pk_fk_hotel_id = " . $request -> GetVar('hotelid', 'session') . ")";

            $result = MetabaseQuery($gDatabase, $query);

            if (!$result) {
                $errorhandler -> display('SQL', 'defaultdata::load()', $query);
            } else {
                $row = 0;

                for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                    if (MetabaseFetchResult($gDatabase, $result, $row, 3) <> null) {
                        $sess -> SetVar(MetabaseFetchResult($gDatabase, $result, $row, 1), MetabaseFetchResult($gDatabase, $result, $row, 3));
                    } elseif (MetabaseFetchResult($gDatabase, $result, $row, 4) <> null) {
                        $sess -> SetVar(MetabaseFetchResult($gDatabase, $result, $row, 1), MetabaseFetchResult($gDatabase, $result, $row, 4));
                    } elseif (MetabaseFetchResult($gDatabase, $result, $row, 5) <> null) {
                        $sess -> SetVar(MetabaseFetchResult($gDatabase, $result, $row, 1), MetabaseFetchResult($gDatabase, $result, $row, 5));
                    } elseif (MetabaseFetchResult($gDatabase, $result, $row, 6) <> null) {
                        $sess -> SetVar(MetabaseFetchResult($gDatabase, $result, $row, 1), MetabaseFetchResult($gDatabase, $result, $row, 6));
                    } else {
                        $sess -> SetVar(MetabaseFetchResult($gDatabase, $result, $row, 1), '');
                    } 
                } 
            } 
        } 
    } 

    /**
    * DefaultData::geteditablefields()
    * 
    * This function returns an array with editable fields. The value is either
    * the hotel spezific one or - if none is set - the system default value
    * 
    * @return array returns an array of data fields
    * @access public 
    * @since 2003-08-01
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function geteditablefields()
    {
        global $gDatabase, $request, $tbl_default, $tbl_hotel_default, $sess, $errorhandler;
        $query = "SELECT def.pk_default_id, default_name, fieldtype, 
				  IF(ISNULL(hotel.string_value),def.string_value,hotel.string_value) AS string_value, 
				  IF(ISNULL(hotel.integer_value),def.integer_value,hotel.integer_value) AS integer_value, 
				  IF(ISNULL(hotel.datetime_value),def.datetime_value,hotel.datetime_value) AS datetime_value, 
				  IF(ISNULL(hotel.boolean_value),def.boolean_value,hotel.boolean_value) AS boolean_value, 
				  description 
				  FROM $tbl_default AS def 
				  LEFT JOIN $tbl_hotel_default AS hotel 
				  ON (hotel.pk_fk_default_id = def.pk_default_id 
				  AND hotel.pk_fk_hotel_id = " . $request -> GetVar('hotelid', 'session') . ") " . "
				  WHERE def.editable = 'Y' 
				  ORDER BY default_name";

        $result = MetabaseQuery($gDatabase, $query);

        if (!$result) {
            $errorhandler -> display('SQL', 'defaultdata::geteditablefields()', $query);
        } else {
            $row = 0;

            $fields = array();

            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                if (MetabaseFetchResult($gDatabase, $result, $row, 3) <> null) {
                    $value = MetabaseFetchResult($gDatabase, $result, $row, 3);
                } elseif (MetabaseFetchResult($gDatabase, $result, $row, 4) <> null) {
                    $value = MetabaseFetchResult($gDatabase, $result, $row, 4);
                } elseif (MetabaseFetchResult($gDatabase, $result, $row, 5) <> null) {
                    $value = MetabaseFetchResult($gDatabase, $result, $row, 5);
                } elseif (MetabaseFetchResult($gDatabase, $result, $row, 6) <> null) {
                    $value = MetabaseFetchResult($gDatabase, $result, $row, 6);
                } else {
                    $value = '';
                } 
                $color = 0;
                if ($row % 2 <> 0) {
                    $color = 1;
                } 

                $fields[$row] = array ('defaultid' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                    'title' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                    'fieldtype' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                    'description' => MetabaseFetchResult($gDatabase, $result, $row, 7),
                    'value' => $value,
                    'color' => $color
                    );
            } 
            return $fields;
        } 
    } 

    /**
    * DefaultData::´setfield()
    * 
    * This function updates a given field and updates the session value
    * 
    * @param number $id id of field
    * @param string $value value
    * @access public 
	* @since 2003-08-01
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function setfield($id, $value)
    {
        global $tbl_default, $tbl_hotel_default, $gDatabase, $request, $sess, $errorhandler;

        $query = sprintf("SELECT fieldtype, default_name 
						  FROM $tbl_default
						  WHERE pk_default_id = %s ",
            $id
            );
        $result = MetabaseQuery($gDatabase, $query);

        if (!$result) {
            $errorhandler -> display('SQL', 'defaultdata::setfield()', $query);
        } else {
            $fieldname = MetabaseFetchResult($gDatabase, $result, 0, 1);
            if (MetabaseFetchResult($gDatabase, $result, 0, 0) == "int") {
                $field = "integer_value";
                $inputvalue = MetabaseGetTextFieldValue($gDatabase, $value);
            } else if (MetabaseFetchResult($gDatabase, $result, 0, 0) == "boolean") {
                $field = "boolean_value";
                $inputvalue = MetabaseBooleanFieldValue($gDatabase, $value);
            } else if (MetabaseFetchResult($gDatabase, $result, 0, 0) == "date") {
                $field = "datetime_value";
                $inputvalue = MetabaseGetTextFieldValue($gDatabase, $value);
            } else {
                $field = "string_value";
                $inputvalue = MetabaseGetTextFieldValue($gDatabase, $value);
            } 

            $query = sprintf("SELECT updated_date 
							   FROM $tbl_hotel_default
							   WHERE pk_fk_hotel_id = %s 
  						       AND pk_fk_default_id = %s ",
                $request -> GetVar('hotelid', 'session'),
                $id
                );

            $result = MetabaseQuery($gDatabase, $query);
            $rows = MetabaseNumberOfRows($gDatabase, $result);

            if ($rows == 0) {
                $query = sprintf("INSERT INTO $tbl_hotel_default 
				                  (pk_fk_hotel_id, pk_fk_default_id, $field, 
								  fk_inserted_user_id, inserted_date) 
								  VALUES (%s, %s, %s, %s, NOW()) ",
                    $request -> GetVar('hotelid', 'session'),
                    $id,
                    $inputvalue,
                    $request -> GetVar('uid', 'session')
                    );
            } else {
                $query = sprintf("UPDATE $tbl_hotel_default 
								  SET $field = %s, 
								  fk_updated_user_id = %s, 
								  updated_date = NOW() 
								  WHERE pk_fk_hotel_id = %s 
								  AND pk_fk_default_id = %s ",
                    $inputvalue,
                    $request -> GetVar('uid', 'session'),
                    $request -> GetVar('hotelid', 'session'),
                    $id
                    );
            } 

            $result = MetabaseQuery($gDatabase, $query);

            if (!$result) {
                $errorhandler -> display('SQL', 'defaultdata::setfield()', $query);
            } else {
                $sess -> SetVar($fieldname, $value);
            } 
        } 
    } 
} 

?>
