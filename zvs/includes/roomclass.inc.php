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
* class room
* 
* Class for rooms functionality
* 
* This class has all functions which are needed for the rooms.
* 
* @since 2003-07-24
* @author Christian Ehret <chris@uffbasse.de> 
* @version $Id: roomclass.inc.php,v 1.1 2004/11/03 14:51:40 ehret Exp $
*/
class room {
    /**
    * room::get()
    * 
    * get all rooms
    * 
    * @return array room data
    * @access public 
    * @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function get()
    {
        global $gDatabase, $tbl_room, $tbl_roomcat, $errorhandler, $request;

        $rooms = array();
        $query = "SELECT pk_room_id, $tbl_room.room, capacity, " . "$tbl_room.description, fk_roomcat_id, roomcat " . "FROM $tbl_room " . "LEFT JOIN $tbl_roomcat ON(pk_roomcat_id = fk_roomcat_id) " . "WHERE ISNULL($tbl_room.fk_deleted_user_id) " . "ORDER BY $tbl_room.room";

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler -> display('SQL', 'room::get()', $query);
        } else {
            $row = 0;
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                $color = 0;
                if ($row % 2 <> 0) {
                    $color = 1;
                } 
                $infotxt = "<strong>Bezeichnung:</strong> " . MetabaseFetchResult($gDatabase, $result, $row, 1) . "<br>" . "<strong>Personen:</strong> " . MetabaseFetchResult($gDatabase, $result, $row, 2) . "<br>" . "<strong>Kategorie:</strong> " . MetabaseFetchResult($gDatabase, $result, $row, 5) . "<br>";
                if (MetabaseFetchResult($gDatabase, $result, $row, 3) !== "") {
                    $infotxt .= "<strong>Info:</strong> " . nl2br(MetabaseFetchResult($gDatabase, $result, $row, 3));
                } 
                $rooms[$row] = array ('roomid' => MetabaseFetchResult($gDatabase, $result, $row, 0),
                    'name' => MetabaseFetchResult($gDatabase, $result, $row, 1),
                    'persons' => MetabaseFetchResult($gDatabase, $result, $row, 2),
                    'info' => MetabaseFetchResult($gDatabase, $result, $row, 3),
                    'roomcatid' => MetabaseFetchResult($gDatabase, $result, $row, 4),
                    'catname' => MetabaseFetchResult($gDatabase, $result, $row, 5),
                    'color' => $color,
                    'infotxt' => $infotxt
                    );
            } 
        } 
        return $rooms;
    } 

    /**
    * room::getname()
    * 
    * get the name of a room
    * 
    * @param number $roomid room id
    * @return string room name
    * @access public 
	* @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function getname($roomid)
    {
        global $gDatabase, $request, $tbl_room, $errorhandler;

        $query = sprintf ("SELECT room FROM $tbl_room WHERE pk_room_id = %s",
            $roomid
            );

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler -> display('SQL', 'room::getname()', $query);
        } else {
            return MetabaseFetchResult($gDatabase, $result, 0, 0);
        } 
    } 

    /**
    * room::del()
    * 
    * delete a room
    * 
    * @param number $roomid room id
    * @access public 
	* @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function del($roomid)
    {
        global $gDatabase, $tbl_room, $errorhandler, $request;

        $query = sprintf("UPDATE $tbl_room SET " . "deleted_date = NOW(), " . "fk_deleted_user_id = %s " . "WHERE pk_room_id = %s ",
            $request -> GetVar('uid', 'session'),
            $roomid
            );

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler -> display('SQL', 'room::del()', $query);
        } 
    } 

    /**
    * room::saveupdate()
    * 
    * save a new room or update an existing one
    * 
    * @return number room id
    * @access public 
	* @since 2003-07-24
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function saveupdate()
    {
        global $gDatabase, $request, $tbl_room, $errorhandler;

        $roomid = $request -> GetVar('frm_roomid', 'post'); 
        // update
        if ($roomid !== '0') {
            $query = sprintf("UPDATE $tbl_room SET " . "room = %s, " . "capacity = %s, " . "description = %s, " . "fk_roomcat_id = %s, " . "updated_date = NOW(), " . "fk_updated_user_id = %s " . "WHERE pk_room_id = %s ",
                MetabaseGetTextFieldValue($gDatabase, $request -> GetVar('frm_name', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request -> GetVar('frm_persons', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request -> GetVar('frm_info', 'post')),
                $request -> GetVar('frm_roomcat', 'post'),
                $request -> GetVar('uid', 'session'),
                $roomid
                );
        } else { // new
            $name = "zvs_pk_room_id";
            $sequence = MetabaseGetSequenceNextValue($gDatabase, $name, &$roomid);
            $query = sprintf("INSERT INTO $tbl_room" . "(pk_room_id, room, capacity, description, " . "fk_roomcat_id, inserted_date, fk_inserted_user_id )" . "VALUES (%s, %s, %s, %s, %s, NOW(), %s )",
                $roomid,
                MetabaseGetTextFieldValue($gDatabase, $request -> GetVar('frm_name', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request -> GetVar('frm_persons', 'post')),
                MetabaseGetTextFieldValue($gDatabase, $request -> GetVar('frm_info', 'post')),
                $request -> GetVar('frm_roomcat', 'post'),
                $request -> GetVar('uid', 'session')
                );
        } 

        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler -> display('SQL', 'room::saveupdate()', $query);
        } else {
            return $roomid;
        } 
    } 
} 

?>
