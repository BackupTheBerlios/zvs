<?php
/**
* class Archive
* 
* Class for archive
* 
* This class has all functions which are needed for the archive.
* 
* @since 2004-07-09
* @author Christian Ehret <chris@uffbasse.de> 
* @version $Id: archiveclass.inc.php,v 1.1 2004/11/03 15:31:32 ehret Exp $
*/
class Archive {
    /**
    * Archive::nullifempty()
    * 
    * This function returns a formated string for database inserts.
    * 
    * @param string $value the value to format
    * @param string $string quote the value or not
    * @return string $output
    * @access private 
    * @since 2004-07-09
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function nullifempty($value, $string)
    {
        $output = "";
        if ($string == 'yes') {
            $output = "'" . $value . "'";
        } elseif ($string == 'yesifnotnull') {
            if ($value == '' || $value == null) {
                $output = 'NULL';
            } else {
                $output = "'" . $value . "'";
            } 
        } elseif ($value == '' || $value == null) {
            $output = 'NULL';
        } else {
            $output = $value;
        } 
        return $output;
    } 
    /**
    * Archive::get()
    * 
    * This function returns the archived sql and depending on the parameters deletes data.
    * 
    * @param timestamp $thedate date till data should be archived
    * @param boolean $delete deletes the data if true
    * @return string $output
    * @access public 
    * @since 2004-07-09
    * @author Christian Ehret <chris@uffbasse.de> 
    */
    function get($thedate, $delete)
    {
        global $gDatabase, $tbl_bought, $tbl_bararticle, $tbl_barguest, $request, $errorhandler;
        $output = "/*Archiv bis $thedate*/\n";
        $output1 = "/*$tbl_bought*/\n";
        $output2 = "/*$tbl_bararticle*/\n";
        $output3 = "/*$tbl_barguest*/\n";
        list($day, $month, $year) = split('[.]', $thedate);
        $thedate = "$year-$month-$day 23:59:59";

        $query = "SELECT pk_bought_id, fk_barguest_id, fk_bararticle_id, timestamp, num,
		  paid, inserted_date, fk_inserted_user_id, updated_date, fk_updated_user_id
		  FROM $tbl_bought
		  WHERE timestamp <= '$thedate'";
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $errorhandler->display('SQL', 'Archive::get()', $query);
        } else {
            $guestids = array();
            $articleids = array();
            for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                if (!in_array(MetabaseFetchResult($gDatabase, $result, $row, 1), $guestids)) {
                    array_push($guestids, MetabaseFetchResult($gDatabase, $result, $row, 1));
                } 
                if (!in_array(MetabaseFetchResult($gDatabase, $result, $row, 2), $articleids)) {
                    array_push($articleids, MetabaseFetchResult($gDatabase, $result, $row, 2));
                } 
                $output1 .= "\n";
                $output1 .= "DELETE FROM $tbl_bought WHERE pk_bought_id = " . MetabaseFetchResult($gDatabase, $result, $row, 0) . ";";
                $output1 .= "\n";
                $output1 .= sprintf("INSERT INTO $tbl_bought (pk_bought_id, fk_barguest_id, fk_bararticle_id, timestamp, num, paid, inserted_date, fk_inserted_user_id, updated_date, fk_updated_user_id) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s);",
                    $this->nullifempty(MetabaseFetchResult($gDatabase, $result, $row, 0), 'no'),
                    $this->nullifempty(MetabaseFetchResult($gDatabase, $result, $row, 1), 'no'),
                    $this->nullifempty(MetabaseFetchResult($gDatabase, $result, $row, 2), 'no'),
                    $this->nullifempty(MetabaseFetchResult($gDatabase, $result, $row, 3), 'yesifnotnull'),
                    $this->nullifempty(MetabaseFetchResult($gDatabase, $result, $row, 4), 'no'),
                    $this->nullifempty(MetabaseFetchResult($gDatabase, $result, $row, 5), 'yes'),
                    $this->nullifempty(MetabaseFetchResult($gDatabase, $result, $row, 6), 'yesifnotnull'),
                    $this->nullifempty(MetabaseFetchResult($gDatabase, $result, $row, 7), 'no'),
                    $this->nullifempty(MetabaseFetchResult($gDatabase, $result, $row, 8), 'yesifnotnull'),
                    $this->nullifempty(MetabaseFetchResult($gDatabase, $result, $row, 9), 'no')
                    );
                if ($delete) {
                    $query = "DELETE FROM $tbl_bought WHERE pk_bought_id = " . MetabaseFetchResult($gDatabase, $result, $row, 0);
                    $result2 = MetabaseQuery($gDatabase, $query);
                    if (!$result2) {
                        $errorhandler->display('SQL', 'Archive::get()', $query);
                    } 
                } 
            } 
            for ($i = 0; $i < count($articleids); $i++) {
                $query = "SELECT pk_bararticle_id, description, price, hotkey, inserted_date,
				          fk_inserted_user_id, updated_date, fk_updated_user_id, deleted_date, fk_deleted_user_id
						  FROM $tbl_bararticle WHERE pk_bararticle_id = $articleids[$i]";

                $result = MetabaseQuery($gDatabase, $query);
                if (!$result) {
                    $errorhandler->display('SQL', 'Archive::get()', $query);
                } else {
                    for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                        $output2 .= "\n";
                        $output2 .= "DELETE FROM $tbl_bararticle WHERE pk_bararticle_id = " . MetabaseFetchResult($gDatabase, $result, $row, 0) . ";";
                        $output2 .= "\n";
                        $output2 .= sprintf ("INSERT INTO $tbl_bararticle (pk_bararticle_id, description, price, hotkey, inserted_date, fk_inserted_user_id, updated_date, fk_updated_user_id, deleted_date, fk_deleted_user_id) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s); ",
                            $this->nullifempty(MetabaseFetchResult($gDatabase, $result, $row, 0), 'no'),
                            $this->nullifempty(MetabaseFetchResult($gDatabase, $result, $row, 1), 'yes'),
                            $this->nullifempty(MetabaseFetchResult($gDatabase, $result, $row, 2), 'yes'),
                            $this->nullifempty(MetabaseFetchResult($gDatabase, $result, $row, 3), 'yes'),
                            $this->nullifempty(MetabaseFetchResult($gDatabase, $result, $row, 4), 'yesifnotnull'),
                            $this->nullifempty(MetabaseFetchResult($gDatabase, $result, $row, 5), 'no'),
                            $this->nullifempty(MetabaseFetchResult($gDatabase, $result, $row, 6), 'yesifnotnull'),
                            $this->nullifempty(MetabaseFetchResult($gDatabase, $result, $row, 7), 'no'),
                            $this->nullifempty(MetabaseFetchResult($gDatabase, $result, $row, 8), 'yesifnotnull'),
                            $this->nullifempty(MetabaseFetchResult($gDatabase, $result, $row, 9), 'no')
                            );
                    } 
                } 
            } 

            for ($i = 0; $i < count($guestids); $i++) {
                $query = "SELECT pk_barguest_id, firstname, lastname, inserted_date,
				          fk_inserted_user_id, updated_date, fk_updated_user_id, deleted_date, fk_deleted_user_id
						  FROM $tbl_barguest WHERE pk_barguest_id = $guestids[$i]";

                $result = MetabaseQuery($gDatabase, $query);
                if (!$result) {
                    $errorhandler->display('SQL', 'Archive::get()', $query);
                } else {
                    for ($row = 0; ($eor = MetabaseEndOfResult($gDatabase, $result)) == 0; ++$row) {
                        $output3 .= "\n";
                        $output3 .= "DELETE FROM $tbl_barguest WHERE pk_barguest_id = " . MetabaseFetchResult($gDatabase, $result, $row, 0) . ";";
                        $output3 .= "\n";
                        $output3 .= sprintf ("INSERT INTO $tbl_barguest (pk_barguest_id, firstname, lastname, inserted_date, fk_inserted_user_id, updated_date, fk_updated_user_id, deleted_date, fk_deleted_user_id) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s); ",
                            $this->nullifempty(MetabaseFetchResult($gDatabase, $result, $row, 0), 'no'),
                            $this->nullifempty(MetabaseFetchResult($gDatabase, $result, $row, 1), 'yes'),
                            $this->nullifempty(MetabaseFetchResult($gDatabase, $result, $row, 2), 'yes'),
                            $this->nullifempty(MetabaseFetchResult($gDatabase, $result, $row, 3), 'yesifnotnull'),
                            $this->nullifempty(MetabaseFetchResult($gDatabase, $result, $row, 4), 'no'),
                            $this->nullifempty(MetabaseFetchResult($gDatabase, $result, $row, 5), 'yesifnotnull'),
                            $this->nullifempty(MetabaseFetchResult($gDatabase, $result, $row, 6), 'no'),
                            $this->nullifempty(MetabaseFetchResult($gDatabase, $result, $row, 7), 'yesifnotnull'),
                            $this->nullifempty(MetabaseFetchResult($gDatabase, $result, $row, 8), 'no')
                            );
                    } 
                } 
            } 

            $output .= $output2 . "\n\n" . $output3 . "\n\n" . $output1;
        } 
        return $output;
    } 
} 

?>