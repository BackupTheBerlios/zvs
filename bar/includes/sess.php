<?php 
// {{{ Header
/* -File        $Id: sess.php,v 1.1 2004/11/03 15:31:33 ehret Exp $
 * -License     LGPL (http://www.gnu.org/copyleft/lesser.html)
 * -Copyright   2001, The Turing Studio, Inc.
 * -Author      alex black, enigma@turingstudio.com
 */
// }}}
$PACKAGE = 'binarycloud.core';
// }}}
// {{{ Sess
/**
* This is the binarycloud Sessions class, it is currently a simple wrapper for
* php4 sessions. It exists because many applications have special requirements
* for session handling, so users can write subclasses that override these methods
* for dealing with sessions. Eventually, we expect to have subclasses for
* PHPLIB, and SiteManager sessions. Note that this is entirely separate from
* a custom session save handler - which is dealt with by Init.
* 
* @author alex black, enigma@turingstudio.com 
*/

class Sess {
    // {{{ StartSession
    /**
    * This is the public StartSession method, it wraps the native php4
    * session_start function.
    * 
    * @author alex black, enigma@turingstudio.com 
    * @access public 
    */

    function StartSession()
    {
        session_start();
    } 
    // }}}
    // {{{ DestroySession
    /**
    * This is the public DestroySession method, it wraps the native php4
    * session_destroy function.
    * 
    * @author alex black, enigma@turingstudio.com 
    * @return true if the session is successfully destroyed
    * @access public 
    */

    function DestroySession()
    {
        $success = session_destroy();
        return $success;
    } 
    // }}}
    // {{{ Register
    /**
    * This is the public Register method, it wraps the native php4
    * session_register function. Note that this function allows any number
    * of arguments to be passed in, and will register all of them.
    * 
    * @author alex black, enigma@turingstudio.com 
    * @author Andreas Aderhold, a.aderhold@thyrell.de 
    * @return true if all arguments are successfuly registered in the session
    * @access public 
    */

    function Register()
    {
        $arguments = func_get_args();
        $success = true;

        for ($i = 0; $i < count($arguments); $i++) {
            $status = session_register($arguments[$i]);
            if ($status == false) {
                $success = false;
            } 
        } 
        return $success;
    } 
    // }}}
    // {{{ Unregister
    /**
    * This is the public Unregister method, it wraps the native php4
    * session_unregister function. Note that this function allows any number
    * of arguments to be passed in, and will unregister all of them.
    * 
    * @author alex black, enigma@turingstudio.com 
    * @author Andreas Aderhold, a.aderhold@thyrell.de 
    * @return true if all arguments are successfuly unregistered from the session
    * @access public 
    */

    function Unregister()
    {
        $arguments = func_get_args();
        $success = true;

        for ($i = 0; $i < count($arguments); $i++) {
            $status = session_unregister($arguments[$i]);
            if ($status == false) {
                $success = false;
            } 
        } 
        return $success;
    } 
    // }}}
    // {{{ UnsetAll
    /**
    * This is the public Unset method, it wraps the native php4
    * sessionunset function, which frees all variables from the session.
    * 
    * @author alex black, enigma@turingstudio.com 
    * @access public 
    */

    function UnsetAll()
    {
        session_unset();
    } 
    // }}}
    // {{{  Delete
    /**
    * This is the public Delete method, it uses the native php unset
    * function and then wraps the native php4 session_unregister function.
    * This is the only way to really get rid of a variable.
    * Note that this function allows any number
    * of arguments to be passed in, and will unregister all of them.
    * 
    * @author alex black, enigma@turingstudio.com 
    * @author Andreas Aderhold, a.aderhold@thyrell.de 
    * @author Christian Ehret, chris@uffbasse.de 
    * @return true if all arguments are successfuly unregistered
    *                 from the session
    * @access public 
    */
    function Delete()
    {
        $arguments = func_get_args();
        $success = true;
        global $HTTP_SESSION_VARS;

        for ($i = 0; $i < count($arguments); $i++) {
            unset($HTTP_SESSION_VARS[$arguments[$i]]);
            $status = session_unregister($arguments[$i]);
            if ($status == false) {
                $success = false;
            } 
        } 
        return $success;
    } 
    // }}}
    // {{{ CheckRegistered
    /**
    * This is the public CheckRegistered method, it wraps the native php4
    * session_is_registered function. Note the stupid hack to set $success
    * to false, because session_is_registered _only_ returns true if a var
    * is registered, and _null_ if it is not.
    * 
    * @author alex black, enigma@turingstudio.com 
    * @param  $var the variable to check
    * @return true if $var exists in the session
    * @access public 
    */

    function CheckRegistered($var_name)
    {
        $reg = session_is_registered($var_name);
        return $reg;
    } 
    // }}}
    // {{{ SetVar
    /**
    * This is the public SetVar method. It sets a session variable $_name to
    * a given value $_value and returns it's old value if present.
    * Optionally if the $_register parameter is set to true the variable is
    * registered to the session (default).
    * 
    * This comes in handy if register_globals is switched off.
    * 
    * @param string $ The name of the variable
    * @param mixed $ The value
    * @return mixed Former value of $_name
    * @access public 
    */

    function SetVar($_name, $_value, $_register = true)
    {
        global $HTTP_SESSION_VARS;
        if (!$this -> CheckRegistered($_name) && $register != false) {
            $this -> Register($_name);
        } 
        $oldValue = $HTTP_SESSION_VARS[$_name];
        $HTTP_SESSION_VARS[$_name] = $_value;
        return $oldValue;
    } 
    // }}}
} 
// }}}
/*
 * Local Variables:
 * mode: php
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */
?>
