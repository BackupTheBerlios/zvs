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
* 
* @author Andreas Aderhold <a.aderhold@thyrell.com> 
* @author David Weingart <dweingart@pobox.com> 
* @author Christian Ehret <chris@uffbasse.de> 
* @copyright LGPL (http://www.gnu.org/copyleft/lesser.html)
* @version $Id: request.php,v 1.1 2004/11/03 14:50:40 ehret Exp $
*/

/**
* Request class.
* 
* Fetching variables from global HTTP_*_VARS hashes if
* register_globals is swichted off for security reasons.
* 
* TODO:
*             - add method to generate a uri in a specifc format i.e.
*               script/name.value/positional0/name2.value2 etc.
*             - make urldecoding more flexible, "slot-in" function to handle
*               user specific urldecoding
*             - fix decoding of n depth arrays (currently supportet n=1)
*             - add ability to fetch nested arrays directly
*               e.g something like:
*               $val = $R->GetVar("mPersistents[navbar]");
* 
*               instead of
* 
*               $tmp = $R->GetVar('mPersistents');
*               $val = $tmp['navbar'];
* 
*               Anyway, advanced dereferencing will be supportet by ZE2
* 
* @author Andreas Aderhold <a.aderhold@thyrell.com> 
* @author David Weingart <dweingart@pobox.com> 
* @version $Revision: 1.1 $
* @package binarycloud.core
*/

class Request {
    /**
    * default variables order
    * 
    * @access private 
    * @var string 
    */
    var $varOrder = "EGPCS";

    /**
    * value being returned if var is undefined
    * 
    * @access private 
    * @var type /constant   null
    */
    var $undefined = null;

    /**
    * switch to enable decode method
    * 
    * @access private 
    * @var boolean 
    */
    var $decode = true;

    /**
    * decode only scalar values or also
    * objects like arrays/objects?
    * 
    * @access private 
    * @var boolean 
    */
    var $decodeObjs = true;

    /**
    * array of vars extracted from pathinfo
    * 
    * @access private 
    * @var array 
    */
    var $pathvars = array(); 
    // }}}
    // {{{ public properties
    /**
    * SCRIPT_NAME of current request
    * 
    * @access public 
    * @var string 
    */
    var $scriptname = null;

    /**
    * PHP_SELF for current request
    * 
    * @access public 
    * @var string 
    */
    var $phpself = null;

    /**
    * PATH_INFO for current request
    * 
    * @access public 
    * @var string 
    */
    var $pathinfo = null;

    /**
    * basename of SCRIPT_NAME
    * 
    * @access public 
    * @var string 
    */
    var $scriptbase = null;

    /**
    * basepath of current script
    * 
    * @access public 
    * @var string 
    */
    var $scriptpath = null;

    /**
    * REQUEST_URI for current script
    * Manufactured if not given (stupid IIS)
    * 
    * @access public 
    * @var string 
    */
    var $requesturi = null;

    /**
    * method Request($_varOrder)
    * 
    * Constructor. Sets the default variables order if user wants to
    * override. Default is setting the php.ini/.htaccess/vhost defaults.
    * We also setup some useful values for this request (scriptname etc)
    * 
    * @access public 
    * @param string $_varOrder flag to control variable ordering
    * @author Andreas Aderhold <a.aderhold@thyrell.com> 
    */

    function Request($_varOrder = 'ini')
    {
        $this -> _SetVarOrder($_varOrder);
        $this -> _InitGlobals();
        $this -> _InitProperties();
        $this -> _ParsePathInfo();
    } 

    /**
    * method _Request()
    * 
    * Destructor. Not working yet. Included for future use.
    * 
    * @access public 
    * @author Andreas Aderhold, <a.aderhold@thyrell.com> 
    */

    function _Request()
    {
        return true;
    } 

    /**
    * method SetVarOrder($_varOrder)
    * 
    * Sets the varOrder property. If not given any parameter
    * the class default is used. You can pass the following
    * parameters:
    * 
    * ini:        use the variables_order setting from ini
    * user:       use the class default/already setted ($this->varOrder)
    * GPC-string: EGCPS or something valid. If this string is not
    *                   valid, the class default is used
    * 
    * @access private 
    * @param string $_varOrder ini|user|gpc-string
    * @return bool True if set, false on error (todo)
    * @author Andreas Aderhold <a.aderhold@thyrell.com> 
    */

    function _SetVarOrder($_varOrder = null)
    {
        $_varOrder = strtoupper($_varOrder);

        switch ($_varOrder) {
            case 'INI':
                $_varOrder = ini_get('variables_order');
                break;
            case 'USER':
                $_varOrder = $this -> varOrder;
                break;
            default:
                $valid = strspn($_varOrder, 'EGPCS');
                if (!$valid) {
                    $_varOrder = $this -> varOrder;
                } 
        } 
        $this -> varOrder = $_varOrder;
    } 

    /**
    * GetStringVar($_name, $_hash)
    * 
    * Gets a variable explicitly casted to string.
    * 
    * @access public 
    * @param string $_name Variable name
    * @param string $_hash hash
    * @return string Variable value
    * @author Andreas Aderhold <a.aderhold@thyrell.com> 
    */

    function GetStringVar($_name, $_hash = 'default')
    {
        $var = $this -> GetVar($_name, $_hash);
        if ($var === $this -> undefined) {
            return $this -> undefined;
        } else {
            return(strval($var));
        } 
    } 

    /**
    * GetIntegerVar($_name, $_hash)
    * 
    * Gets a variable explicitly casted to int.
    * 
    * @access public 
    * @param string $_name Variable name
    * @param string $_hash hash
    * @return int Variable value
    * @author Andreas Aderhold <a.aderhold@thyrell.com> 
    */

    function GetIntegerVar($_name, $_hash = 'default')
    {
        $var = $this -> GetVar($_name, $_hash);
        if ($var === $this -> undefined) {
            return $this -> undefined;
        } else {
            return(intval($var));
        } 
    } 

    /**
    * GetFloatVar($_name, $_hash)
    * 
    * Gets a variable explicitly casted to float.
    * Note: null-values will be casted to 0
    * 
    * @access public 
    * @param string $_name Variable name
    * @param string $_hash hash
    * @return float Variable value
    * @author Andreas Aderhold <a.aderhold@thyrell.com> 
    */

    function GetFloatVar($_name, $_hash = 'default')
    {
        $var = $this -> GetVar($_name, $_hash);
        if ($var === $this -> undefined) {
            return $this -> undefined;
        } else {
            return(doubleval($var));
        } 
    } 

    /**
    * GetDoubleVar($_name, $_hash)
    * 
    * Alias to GetFloatVar()
    * 
    * @see GetFloatVar
    */

    function GetDoubleVar($_name, $_hash = 'default')
    {
        return $this -> GetFloatVar();
    } 

    /**
    * method getURI($_elem1, $_elem2, $_elem3, ...)
    * 
    * Get pieces from the URI string.
    * 
    * This function is especially important for Cache seeds (see the doc
    * for more information)
    * To understand what this function does, consider the following examples:
    * 
    * $GLOBALS["REQUEST_URI"] == "/articles/23/04/2001/13";
    * 
    * // if no parameter is given, then the request uri is returned
    * $Request->getURI() == "/articles/23/04/2001/13"
    * 
    * // if there is *one* parameters given, then an the pieces of the URI
    * // with the given index is returned:
    * $Request->getURI(0) == "articles"
    * $Request->getURI(1) == "23"
    * $Request->getURI(10) == NULL // index bigger than array
    * 
    * // if *more than one* parameter is given, an array with the elements of
    * // the URI is returned:
    * $Request->getURI(0,1) == array("articles", "23")
    * $Request->getURI(0,3,2,1) == array("articles", "2001", "04", "23")
    * $Request->getURI(4,5) == array("13", NULL)
    * 
    * @access public 
    * @param int $ Parameters are optional. If there is no
    *                    parameter given, the result is a string
    *                    containing the request uri string.
    *                    If there are parameters given, each is taken
    *                    as the index of an element of the request
    *                    string to be returned.
    * @return mixed If no parameter is given then the whole
    *                    request string is returned. Otherwise an
    *                    array is returned. This array contains the
    *                    pieces of the URI specified in the parameters.
    * @author Manuel Holtgrewe <grin@gmx.net> 
    */

    function GetURI()
    {
        $arguments = func_get_args();

        if (count($arguments) == 0) {
            // Return entire request URI string
            return $this -> requesturi;
        } else {
            // Get an array of the pieces of the URI
            $uri_array = explode('/', trim($this -> requesturi, '/'));
            $result = array(); 
            // Fill the result only with what we were told to
            foreach ($arguments as $argument) {
                $result[] = $uri_array[$argument];
            } 
            return $result;
        } 
    } 

    /**
    * method GetVarTree($startName, $hash = 'default')
    * 
    * Gets a collection of variablenames=>values starting with
    * a given name
    * 
    * @access public 
    * @param string $startName Variabe starting name
    * @param string $hash hash
    * @return An array consisting of all the variablenames=>value pairs
    *                that keys start with $startName if any. Otherwithe undefined
    *                is returned (most likely null)
    * @author Andreas Aderhold <a.aderhold@thyrell.com> 
    */

    function GetVarTree($startName, $hash = 'default')
    {
        return($this -> GetVar($startName, $hash, false));
    } 
    // }}}
    // {{{ method GetVar($_name, $_hash = 'default')
    /**
    * Fetches and returns a given variable.
    * 
    * The default behavior is fetching variables depending on the
    * varOrder property. Optionally you can force pulling
    * the variable out of the named array. Possible values are
    * (case insensitive):
    * 
    *         'post'     $_POST[]
    *         'get'      $_GET[]
    *         'cookie'   $_COOKIE[]
    *         'session'  $_SESSION[]
    *         'server'   $_SERVER[]
    *         'env'      via getenv()
    *         'method'   via current $_SERVER['REQUEST_METHOD']
    *         'request'  $_REQUEST[]
    * 
    * TODO:
    *             - improve routine for default behaviour (if possible;-))
    * 
    * @access public 
    * @param string $ Variable name
    * @param string $ Where the var should come from (POST, GET, etc)
    * @param boolean $ If stricts is false variables starting with name
    *                            are also fetched and an array is returned. Don't use
    *                            this directly instead use getVarTree()
    * @return string Urldecoded variable
    * @author Andreas Aderhold <a.aderhold@thyrell.com> 
    * @author David Weingart <dweingart@pobox.com> 
    */

    function GetVar($_name, $_hash = 'default', $strict = true)
    {
        $strict = (boolean) $strict;
        $_hash = strtoupper($_hash); // just to be safe ;-)
        $ret = $this -> undefined; // yep - just to be safe ;-)
        if ($_hash == 'DEFAULT') {
            for ($i = 0; $i < strlen($this -> varOrder); ++$i) {
                switch ($this -> varOrder {
                        $i} 
                    ) {
                    case 'E' :
                        $value = $this -> _FetchVar($_name, 'ENV', $strict);
                        ($value !== $this -> undefined) ? ($ret = $value) : (null);
                        break;
                    case 'G' :
                        $value = $this -> _FetchVar($_name, 'GET', $strict);
                        ($value !== $this -> undefined) ? ($ret = $value) : (null);
                        break;
                    case 'P' :
                        $value = $this -> _FetchVar($_name, 'POST', $strict);
                        ($value !== $this -> undefined) ? ($ret = $value) : (null);
                        break;
                    case 'C' :
                        $value = $this -> _FetchVar($_name, 'COOKIE', $strict);
                        ($value !== $this -> undefined) ? ($ret = $value) : (null);
                        break;
                    case 'S' :
                        $value = $this -> _FetchVar($_name, 'SESSION', $strict);
                        ($value !== $this -> undefined) ? ($ret = $value) : (null);
                        break;
                    } 
                } 
            } elseif ($_hash == 'METHOD') {
                $ret = $this -> _FetchVar($_name, strtoupper($_SERVER['REQUEST_METHOD']), $strict);
            } elseif ($_hash == 'REQUEST') {
                $ret = $this -> _FetchVar($_name, 'REQUEST', $strict);
            } else {
                $ret = $this -> _FetchVar($_name, $_hash, $strict);
            } 

            if ($ret !== $this -> undefined) {
                $this -> _Decode($ret);
                return $ret;
            } else {
                return $this -> undefined;
            } 
        } 
        // }}}
        // {{{ method _FetchVar($_name, $_hash)
        /**
        * Fetching variable out of named array
        * 
        * @access private 
        * @param string $ Variable name
        * @return string variable || $this->undefined
        * @author Andreas Aderhold <a.aderhold@thyrell.com> 
        */

        function _FetchVar($_name, $_hash, $strict = true)
        {
            $strict = (boolean) $strict;

            if ($_hash == 'ENV') {
                $var = getenv($_name);
                if (isset($var)) {
                    return $var;
                } else {
                    return $this -> undefined;
                } 
            } else {
                $ary = '_' . $_hash; 
                // auto-global, my ass
                global ${$ary};
                if (isset(${$ary}[$_name]) && $strict === true) {
                    return(${$ary}[$_name]);
                } elseif (is_array(${$ary})) {
                    $keys = array_keys(${$ary});
                    $ret = array();
                    foreach($keys as $key) {
                        if ($this -> startsWith($_name, $key)) {
                            $ret[$key] = ${$ary}[$key];
                        } 
                    } 
                    if (!empty($ret)) {
                        return $ret;
                    } else {
                        return $this -> undefined;
                    } 
                } 
            } 
        } 

        /**
        * method _ParsePathInfo()
        * 
        * Takes the server $PATH_INFO variable, and parses it into GET
        * variables.
        * 
        * Parses 3 different formats:
        * 
        *         http://www.example.com/script.php/foo/bar
        *           -> array('foo', 'bar')
        * 
        *         http://www.example.com/script.php/foo.bar/baz.bat
        *           -> array('foo'=>'bar', 'baz'=>'bat')
        * 
        *         http://www.example.com/script.php/foo.bar.html
        *           -> Array('foo', 'bar', 'html')
        * 
        * The pathinfo is everything after after script.php
        * 
        * @access private 
        * @return boolean true
        * @author David Weingart <dweingart@pobox.com> 
        */

        function _ParsePathInfo()
        {
            if (!empty($this -> pathinfo)) {
                $parts = explode('/', trim($this -> pathinfo, '/'));

                /* process the parts of the pathinfo string, */
                /* adding values to $HTTP_GET_VARS */
                foreach ($parts as $part) {
                    if (strpos($part, '.') !== false) {
                        /* part contains periods */
                        $bits = explode('.', $part);
                        if (count($bits) == 2) {
                            if ($bits[0] == '') {
                                $_GET[] = $bits[1];
                            } else {
                                $_GET[$bits[0]] = $bits[1];
                            } 
                        } else {
                            foreach ($bits as $bit) {
                                $_GET[] = $bit;
                            } 
                        } 
                    } else {
                        /* interpret each part as a positional parameter */
                        $_GET[] = $part;
                    } 
                } 
            } 

            return true;
        } 

        /**
        * method _Decode(&$_data)
        * 
        * Private decode function. Handles decoding of the variable value
        * you are requesting.
        * Looks first if $this->decode is enabled, then it looks if
        * it should decode only scalar values or also decode objects like
        * class instances and arrays.
        * 
        * Note: Currently arrays are decoded with a depth of n=1 (don't like
        * recruison;-)).
        * So if you want to GetVar an array with nested objects/arrays it will
        * not decode the nested ones. This has to be fixed. Objects are not
        * decoded at all.
        * 
        * @access public 
        * @param string $_data Value to decode
        * @return bool Decoding ok/failed (TODO)
        * @author Andreas Aderhold <a.aderhold@thyrell.com> 
        */

        function _Decode(&$_data)
        {
            /* objects are not decoded */
            if (is_object($_data)) {
                return false;
            } 
            if (!is_array($_data)) {
                $data = urldecode($_data);
                return true;
            } else {
                /* we only enter the time consuming array decoding if */
                /* explicitly wanted */
                if ($this -> decodeObjs) {
                    reset($_data);
                    array_walk($_data, create_function('&$item', 'if (is_array($item) || is_object($item)) {return;} else {$item = urldecode($item);}'));
                    reset($_data);
                    return true;
                } 
            } 
        } 

        /**
        * method _InitGlobals()
        * 
        * Private setuo method. Detects version and sets global arrays
        * for incoming vars properly
        * 
        * @access private 
        * @return bool true
        * @author Andreas Aderhold <a.aderhold@thyrell.com> 
        */

        function _InitGlobals()
        {
            $phpVersion = intval(str_replace(".", "", PHP_VERSION));

            if ($phpVersion < 410) {
                global $_REQUEST; 
                // --FIXME--
                // this must be modded to merge by $this->varOrder
                // --FIXME --
                $_REQUEST = array_merge($_GET, $_POST, $_COOKIE);
            } 
            return true;
        } 

        /**
        * method _InitProperties()
        * 
        * Set some commonly used class properties
        * 
        * @access private 
        * @return bool true
        * @author Andreas Aderhold <a.aderhold@thyrell.com> 
        */

        function _InitProperties()
        {
            $this -> scriptname = $this -> GetVar('SCRIPT_NAME', 'SERVER');
            $this -> servername = $this -> GetVar('SERVER_NAME', 'SERVER');
            $this -> phpself = $this -> GetVar('PHP_SELF', 'SERVER');
            $this -> pathinfo = $this -> GetVar('PATH_INFO', 'SERVER');
            $this -> requesturi = $this -> GetVar('REQUEST_URI', 'SERVER');
            if ($this -> undefined === $this -> requesturi) {
                // This is for brain-damaged IIS
                $query_string = $this -> GetVar('QUERY_STRING', 'SERVER');
                if ($this -> undefined !== $query_string) {
                    // TODO: confirm that '?' is always the separator.
                    $this -> requesturi = $this -> pathinfo . '?' . $query_string;
                } 
            } 
            $this -> scriptbase = basename($this -> scriptname);
            $pos = strlen($this -> scriptname) - strlen($this -> scriptbase);
            $this -> scriptpath = substr($this -> scriptname, 0, $pos-1);
            return true;
        } 

        /**
        * method startsWith()
        * 
        * tests if a string starts with a given string
        * 
        * @access public 
        * @return bool true
        * @author Andreas Aderhold <a.aderhold@thyrell.com> 
        */

        function startsWith($check, $string)
        {
            if (empty($check) || $check === $string) {
                return true;
            } else {
                return (strpos((string) $string, (string) $check) === 0) ? true : false;
            } 
        } 

        /**
        * method returnPostDataAsHiddenFields()
        * 
        * returns all post data as hidden input fields
        * 
        * @access public 
        * @return string 
        * @author Christian Ehret <chris@uffbasse.de> 
        */

        function returnPostDataAsHiddenFields()
        {
            $str = "";
            $data = $_POST;
			reset($data);
            while (!is_null($key = key($data)) && $key != 'username' && $key != 'password') {
				$value = current($data);
                $str .= "<input type=\"hidden\" name=\"" . $key . "\" id=\"" . $key . "\" value=\"" . $value . "\">";
                next($data);
            }
			return $str;
        } 
    } 

    ?>
