<?php

/**
* Settings
* 
* 
* 
* backup and restore database
* 
* 
* 
* 03/23/2004 by Christian Ehret chris@uffbasse.de
*/

$smartyType = "www";

include_once("../includes/default.inc.php");

$auth->is_authenticated();

/**
* Removes comment lines and splits up large sql files into individual queries
* 
* Last revision: September 23, 2001 - gandon
* 
* @param array $ the splitted sql commands
* @param string $ the sql commands
* @param integer $ the MySQL release number (because certains php3 versions
*                    can't get the value of a constant from within a function)
* @return boolean always true
* @access public 
*/
function splitSqlFile(&$ret, $sql)
{
    $sql = trim($sql);
    $sql_len = strlen($sql);
    $char = '';
    $string_start = '';
    $in_string = false;
    $time0 = time();

    for ($i = 0; $i < $sql_len; ++$i) {
        $char = $sql[$i]; 
        // We are in a string, check for not escaped end of strings except for
        // backquotes that can't be escaped
        if ($in_string) {
            for (;;) {
                $i = strpos($sql, $string_start, $i); 
                // No end of string found -> add the current substring to the
                // returned array
                if (!$i) {
                    $ret[] = $sql;
                    return true;
                } 
                // Backquotes or no backslashes before quotes: it's indeed the
                // end of the string -> exit the loop
                else if ($string_start == '`' || $sql[$i-1] != '\\') {
                    $string_start = '';
                    $in_string = false;
                    break;
                } 
                // one or more Backslashes before the presumed end of string...
                else {
                    // ... first checks for escaped backslashes
                    $j = 2;
                    $escaped_backslash = false;
                    while ($i - $j > 0 && $sql[$i - $j] == '\\') {
                        $escaped_backslash = !$escaped_backslash;
                        $j++;
                    } 
                    // ... if escaped backslashes: it's really the end of the
                    // string -> exit the loop
                    if ($escaped_backslash) {
                        $string_start = '';
                        $in_string = false;
                        break;
                    } 
                    // ... else loop
                    else {
                        $i++;
                    } 
                } // end if...elseif...else
            } // end for
        } // end if (in string) 
        // We are not in a string, first check for delimiter...
        else if ($char == ';') {
            // if delimiter found, add the parsed part to the returned array
            $ret[] = substr($sql, 0, $i);
            $sql = ltrim(substr($sql, min($i + 1, $sql_len)));
            $sql_len = strlen($sql);
            if ($sql_len) {
                $i = -1;
            } else {
                // The submited statement(s) end(s) here
                return true;
            } 
        } // end else if (is delimiter) 
        // ... then check for start of a string,...
        else if (($char == '"') || ($char == '\'') || ($char == '`')) {
            $in_string = true;
            $string_start = $char;
        } // end else if (is start of string) 
        // ... for start of a comment (and remove this comment if found)...
        else if ($char == '#' || ($char == ' ' && $i > 1 && $sql[$i-2] . $sql[$i-1] == '--')) {
            // starting position of the comment depends on the comment type
            $start_of_comment = (($sql[$i] == '#') ? $i : $i-2); 
            // if no "\n" exits in the remaining string, checks for "\r"
            // (Mac eol style)
            $end_of_comment = (strpos(' ' . $sql, "\012", $i + 2))
            ? strpos(' ' . $sql, "\012", $i + 2)
            : strpos(' ' . $sql, "\015", $i + 2);
            if (!$end_of_comment) {
                // no eol found after '#', add the parsed part to the returned
                // array if required and exit
                if ($start_of_comment > 0) {
                    $ret[] = trim(substr($sql, 0, $start_of_comment));
                } 
                return true;
            } else {
                $sql = substr($sql, 0, $start_of_comment)
                 . ltrim(substr($sql, $end_of_comment));
                $sql_len = strlen($sql);
                $i--;
            } // end if...else
        } // end else if (is comment) 
        // loic1: send a fake header each 30 sec. to bypass browser timeout
        $time1 = time();
        if ($time1 >= $time0 + 30) {
            $time0 = $time1;
            header('X-pmaPing: Pong');
        } // end if
    } // end for 
    // add any rest to the returned array
    if (!empty($sql) && ereg('[^[:space:]]+', $sql)) {
        $ret[] = $sql;
    } 

    return true;
} // end of the 'PMA_splitSqlFile()' function
$smarty->assign("tpl_title", "Datenbank sichern/wiederherstellen");

$smarty->assign('tpl_nav', 'settings');

$smarty->assign('tpl_subnav', 'backup');
$smarty->assign('tpl_db', $request->GetVar('schema', 'session').'_bar');

if ($request->GetVar('frm_schema', 'post') !== $request->undefined) {
    $file = $request->GetVar('frm_file', 'file');
    $schema = $request->GetVar('frm_schema', 'post');
    MetabaseSetDatabase($gDatabase, $schema);

    $filename = $HTTP_POST_FILES['frm_file']['tmp_name'];
    if (file_exists($filename)) {
        $sql = file_get_contents($filename);

        $auto_commit = false;
        $success = MetabaseAutoCommitTransactions($gDatabase, $auto_commit);

        $query = "SET FOREIGN_KEY_CHECKS = 0";
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $success = MetabaseRollbackTransaction($gDatabase);
            $errorhandler->display('SQL', 'database', $query);
        } 
        $success = splitSqlFile($queries, $sql);
        for ($i = 0; $i < count($queries); ++$i) {
			if (substr($queries[$i], 0, 3) == "USE" ) {
			     $query = "USE $schema";
			} else {
	             $query = $queries[$i];
		    }
            $result = MetabaseQuery($gDatabase, $query);
            if (!$result) {
                $success = MetabaseRollbackTransaction($gDatabase);
                $errorhandler->display('SQL', 'database', $query);
            } 
        } 


        $query = "SET FOREIGN_KEY_CHECKS = 0";
        $result = MetabaseQuery($gDatabase, $query);
        if (!$result) {
            $success = MetabaseRollbackTransaction($gDatabase);
            $errorhandler->display('SQL', 'database', $query);
        } 
        $success = MetabaseCommitTransaction($gDatabase); 
        // end transaction
        $auto_commit = true;
        $success = MetabaseAutoCommitTransactions($gDatabase, $auto_commit);
		$smarty->assign('tpl_ready','true');
    } 
} 
$smarty->display('database.tpl');

?>