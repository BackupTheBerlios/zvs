<?php
/**
* Copyright notice
* 
*   (c) 2003-2004 Christian Ehret (chris@ehret.name)
*   All rights reserved
* 
*   This script is part of the ZVS project. The ZVS project is 
*   free software; you can redistribute it and/or modify
*   it under the terms of the GNU General Public License as published by
*   the Free Software Foundation; either version 2 of the License, or
*   (at your option) any later version.
* 
*   The GNU General Public License can be found at
*   http://www.gnu.org/copyleft/gpl.html.
*   A copy is found in the textfile GPL.txt and important notices to the license 
*   from the author is found in LICENSE.txt distributed with these scripts.
* 
* 
*   This script is distributed in the hope that it will be useful,
*   but WITHOUT ANY WARRANTY; without even the implied warranty of
*   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*   GNU General Public License for more details.
* 
*   This copyright notice MUST APPEAR in all copies of the script!
*/

/**
* class Employee
* 
* Class for employees
* 
* This class has all functions which are needed for the employees.
* 
* @since 2004-10-03
* @author Christian Ehret <chris@uffbasse.de> 
* @version $Id: employeeclass.inc.php,v 1.2 2005/06/08 20:49:17 ehret Exp $
*/
class Employee {
    /**
    * Category::getall()
    * 
    * This function returns all employees.
    * 
    * @return array employees
    * @access public 
    * @since 2004-10-03
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getall()
    {
        global $gDatabase2, $tbl_employee, $request, $errorhandler;

        $user = array();
        $query = sprintf("SELECT pk_employee_id, lastname, firstname, login, salary 
		                 FROM $tbl_employee 
						 WHERE fk_hotel_id = %s 
						 AND ISNULL(deleted_date)
						 ORDER BY lastname ",
            $request->GetVar('hotelid', 'session')
            );
        $result = MetabaseQuery($gDatabase2, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Employee::getall()', $query);
        } else {
            $row = 0;
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase2, $result)) == 0; ++$row) {
                $color = 0;
                if ($row % 2 <> 0) {
                    $color = 1;
                } 

                $user[$row] = array ('userid' => MetabaseFetchResult($gDatabase2, $result, $row, 0),
                    'lastname' => MetabaseFetchResult($gDatabase2, $result, $row, 1),
                    'firstname' => MetabaseFetchResult($gDatabase2, $result, $row, 2),
                    'login' => MetabaseFetchResult($gDatabase2, $result, $row, 3),
                    'salary' => MetabaseFetchResult($gDatabase2, $result, $row, 4),
                    'color' => $color
                    );
            } 
        } 
        return $user;
    } 

    /**
    * Category::getall2()
    * 
    * This function returns all employees from all hotels.
    * 
    * @return array employees
    * @access public 
    * @since 2004-10-03
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getall2()
    {
        global $gDatabase2, $tbl_employee, $request, $errorhandler;

        $user = array();
        $query = "SELECT pk_employee_id, lastname, firstname, login, salary 
		                 FROM $tbl_employee 
						 WHERE ISNULL(deleted_date)
						 ORDER BY login";
        $result = MetabaseQuery($gDatabase2, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Employee::getall2()', $query);
        } else {
            $row = 0;
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase2, $result)) == 0; ++$row) {
                $color = 0;
                if ($row % 2 <> 0) {
                    $color = 1;
                } 

                $user[$row] = array ('userid' => MetabaseFetchResult($gDatabase2, $result, $row, 0),
                    'lastname' => MetabaseFetchResult($gDatabase2, $result, $row, 1),
                    'firstname' => MetabaseFetchResult($gDatabase2, $result, $row, 2),
                    'login' => MetabaseFetchResult($gDatabase2, $result, $row, 3),
                    'salary' => MetabaseFetchResult($gDatabase2, $result, $row, 4),
                    'color' => $color
                    );
            } 
        } 
        return $user;
    } 

    /**
    * Employee::saveupdate()
    * 
    * Save employee as new or update existing one
    * 
    * @access public 
    * @since 2004-10-03
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function saveupdate()
    {
        global $gDatabase2, $request, $tbl_employee, $errorhandler;

        $userid = $request->GetVar('frm_userid', 'post'); 
		$salery = $request->GetVar('frm_salary', 'post');
		if (!is_numeric($salery)) {
		    $salery = '0.00';
		}
        // update
        if ($userid !== '0') {
            if ($request->GetVar('response', 'post') == 'd41d8cd98f00b204e9800998ecf8427e') {
                $query = sprintf("UPDATE $tbl_employee SET 
							 fk_hotel_id = %s,
			                 lastname = %s, 
							 firstname = %s,
							 login = %s,
							 locked = %s,
							 salary = %s,
							 fk_language_id = %s,
							 updated_date = NOW(), 
							 fk_updated_user_id = %s 
							 WHERE pk_employee_id = %s ",
                    $request->GetVar('hotelid', 'session'),
                    MetabaseGetTextFieldValue($gDatabase2, $request->GetVar('frm_last', 'post')),
                    MetabaseGetTextFieldValue($gDatabase2, $request->GetVar('frm_first', 'post')),
                    MetabaseGetTextFieldValue($gDatabase2, $request->GetVar('frm_login', 'post')),
                    MetabaseGetBooleanFieldValue($gDatabase2, false),
                    $salery,
                    1,
                    $request->GetVar('uid', 'session'),
                    $userid
                    );
            } else {
                $query = sprintf("UPDATE $tbl_employee SET 
							 fk_hotel_id = %s,
			                 lastname = %s, 
							 firstname = %s,
							 login = %s,
							 password = %s,
							 locked = %s,
							 salary = %s,
							 fk_language_id = %s,
							 updated_date = NOW(), 
							 fk_updated_user_id = %s 
							 WHERE pk_employee_id = %s ",
                    $request->GetVar('hotelid', 'session'),
                    MetabaseGetTextFieldValue($gDatabase2, $request->GetVar('frm_last', 'post')),
                    MetabaseGetTextFieldValue($gDatabase2, $request->GetVar('frm_first', 'post')),
                    MetabaseGetTextFieldValue($gDatabase2, $request->GetVar('frm_login', 'post')),
                    MetabaseGetTextFieldValue($gDatabase2, $request->GetVar('response', 'post')),
                    MetabaseGetBooleanFieldValue($gDatabase2, false),
                    $salery,
                    1,
                    $request->GetVar('uid', 'session'),
                    $userid
                    );
            } 
        } else { // new
            $name = "zvs_pk_employee_id";
            $sequence = MetabaseGetSequenceNextValue($gDatabase2, $name, &$employee_id);
            $query = sprintf("INSERT INTO $tbl_employee
			                  (pk_employee_id, fk_hotel_id, lastname, firstname, login, password, locked, salary, fk_language_id, inserted_date, fk_inserted_user_id, updated_date, fk_updated_user_id)
							  VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, NOW(), %s, NOW(), %s )",
                $employee_id,
                $request->GetVar('hotelid', 'session'),
                MetabaseGetTextFieldValue($gDatabase2, $request->GetVar('frm_last', 'post')),
                MetabaseGetTextFieldValue($gDatabase2, $request->GetVar('frm_first', 'post')),
                MetabaseGetTextFieldValue($gDatabase2, $request->GetVar('frm_login', 'post')),
                MetabaseGetTextFieldValue($gDatabase2, $request->GetVar('response', 'post')),
                MetabaseGetBooleanFieldValue($gDatabase2, false),
                $salery,
                1,
                $request->GetVar('uid', 'session'),
                $request->GetVar('uid', 'session')
                );
        } 

        $result = MetabaseQuery($gDatabase2, $query);

        if (!$result) {
            $errorhandler->display('SQL', 'Employee::saveupdate()', $query);
        } 
    } 

    /**
    * Employee::del()
    * 
    * Deletes an employee
    * 
    * @param number $userid user id
    * @access public 
    * @since 2004-10-03
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function del($userid)
    {
        global $gDatabase2, $tbl_employee, $errorhandler, $request;

        $query = sprintf("UPDATE $tbl_employee SET 
							 locked = %s,
							 deleted_date = NOW(), 
							 fk_deleted_user_id = %s 
							 WHERE pk_employee_id = %s ",
            MetabaseGetBooleanFieldValue($gDatabase2, true),
            $request->GetVar('uid', 'session'),
            $userid
            );
        $result = MetabaseQuery($gDatabase2, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Employee::del()', $query);
        } 
    } 
} 
 
?>
