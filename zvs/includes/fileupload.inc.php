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


/*
Error codes:
        0 - "No file was uploaded"
        1 - "Maximum file size exceeded"
        2 - "Maximum image size exceeded"
        3 - "Only specified file type may be uploaded"
        4 - "File already exists" (save only)
*/

class uploader {
    var $file;
    var $errors;
    var $accepted;
    var $new_file;
    var $max_filesize;
    var $max_image_width;
    var $max_image_height;

    function max_filesize($size)
    {
        $this -> max_filesize = $size;
    } 

    function max_image_size($width, $height)
    {
        $this -> max_image_width = $width;
        $this -> max_image_height = $height;
    } 

    function GetHeight()
    {
        return $this -> file["height"];
    } 

    function GetWidth()
    {
        return $this -> file["width"];
    } 

    function GetSize()
    {
        return $this -> file["size"];
    } 

    function GetThumbHeight()
    {
        return $this -> thumbHeight;
    } 

    function GetFileName()
    {
        return $this -> fileName;
    } 

    function _createThumb($imageName, $path, $path3, $width)
    {
        switch ($this -> file["extention"]) {
            case ".jpg":
                $ImageCreateFrom = 'ImageCreateFromJPEG';
                $ImageFrom = 'ImageJPEG';
                $noThumb = $path3 . 'nothumb.jpg';
                break;
            case ".gif":
                $ImageCreateFrom = 'ImageCreateFromGIF';
                $ImageFrom = 'ImageGIF';
                $noThumb = $path3 . 'nothumb.gif';
                break;
            case ".png":
                $ImageCreateFrom = 'ImageCreateFromPNG';
                $ImageFrom = 'ImagePNG';
                $noThumb = $path3 . 'nothumb.png';
                break;
        } 
        /* set up variables to hold the height and width of your new image */
        $newWidth = $width;
        $newHeight = $this -> file["height"] * $newWidth / $this -> file["width"];
        $this -> thumbHeight = $newHeight;

        /* create a blank, new image of the given new height and width */
        $newImg = ImageCreate($newWidth, $newHeight);

        /* test if image can be read */
        $im = @$ImageCreateFrom($this -> new_file);
        /* Attempt to open */
        if ($im) {
            /* get the data from the original, large image */
            $origImg = $ImageCreateFrom($this -> new_file);

            /* copy the resized image. Use the ImageSX() and ImageSY functions to get the x and y sizes of the orginal image. */
            ImageCopyResized($newImg, $origImg, 0, 0, 0, 0, $newWidth, $newHeight, ImageSX($origImg), ImageSY($origImg));
        } else {
            /* get the data from the noThumb Image */
            $newImg = $ImageCreateFrom($noThumb);
        } 

        /* create final image and free up the memory */

        $filename = $path . $imageName;
        $ImageFrom($newImg, $filename);
        ImageDestroy($newImg);
    } 

    function upload($filename, $accept_type, $extention)
    {
        global $HTTP_POST_FILES; 
        // get all the properties of the file
        $index = array("file", "name", "size", "type");
        for($i = 0; $i < 4; $i++) {
            $file_var2 = '$HTTP_POST_FILES[' . $filename . '][' . (($index[$i] == "file") ? "tmp_name" : $index[$i]) . ']';
            $file_var = '$' . $filename . (($index[$i] != "file") ? "_" . $index[$i] : "");
            eval('global ' . $file_var . ';');
            eval('$this->file[$index[$i]] = ' . $file_var2 . ';');
        } 

        if ($this -> file["file"] && $this -> file["file"] != "none") {
            // test max size
            if ($this -> max_filesize && $this -> file["size"] > $this -> max_filesize) {
                $this -> errors[1] = true;
                return false;
            } 
            if (ereg("image", $this -> file["type"])) {
                $image = getimagesize($this -> file["file"]);
                $this -> file["width"] = $image[0];
                $this -> file["height"] = $image[1]; 
                // test max image size
                if (($this -> max_image_width || $this -> max_image_height) && (($this -> file["width"] > $this -> max_image_width) || ($this -> file["height"] > $this -> max_image_height))) {
                    $this -> errors[2] = true;
                    return false;
                } 
                switch ($image[2]) {
                    case 1:
                        $this -> file["extention"] = ".gif";
                        break;
                    case 2:
                        $this -> file["extention"] = ".jpg";
                        break;
                    case 3:
                        $this -> file["extention"] = ".png";
                        break;
                    default:
                        $this -> file["extention"] = $extention;
                        break;
                } 
            } else if (!ereg("(\.)([a-z0-9]{3,5})$", $this -> file["name"]) && !$extention) {
                // add new mime types here
                switch ($this -> file["type"]) {
                    case "text/plain":
                        $this -> file["extention"] = ".txt";
                        break;
                    default:
                        break;
                } 
            } else {
                $this -> file["extention"] = $extention;
            } 
            // check to see if the file is of type specified
            if ($accept_type) {
                $this -> accepted = false;
                for ($i = 0; $i < sizeof($accept_type); $i++) {
                    if (ereg($accept_type[$i], $this -> file["type"])) {
                        $this -> accepted = true;
                    } 
                } 
                if (!$this -> accepted) {
                    $this -> errors[3] = true;;
                } 
            } else {
                $this -> accepted = true;
            } 
        } else {
            $this -> errors[0] = true;
        } 
        return $this -> accepted;
    } 

    function save_file($path, $mode, $path2, $path3, $width, $createthumb)
    {
        if ($this -> accepted) {
            // very strict naming of file.. only lowercase letters, numbers and underscores
            $new_name = ereg_replace("[^a-z0-9._]", "", ereg_replace(" ", "_", ereg_replace("%20", "_", strtolower($this -> file["name"])))); 
            // check for extention and remove
            if (ereg("(\.)([a-z0-9]{3,5})$", $new_name)) {
                $pos = strrpos($new_name, ".");
                if (!$this -> file["extention"]) {
                    $this -> file["extention"] = substr($new_name, $pos, strlen($new_name));
                } 
                $new_name = substr($new_name, 0, $pos);
            } 
            $this -> new_file = $path . $new_name . $this -> file["extention"];
            $NEW_NAME = $new_name . $this -> file["extention"];
            $fileCreated = false;
            switch ($mode) {
                case 1: // overwrite mode
                    $aok = copy($this -> file["file"], $this -> new_file);
                    $NEW_NAME = $new_name;
                    $fileCreated = true;
                    break;
                case 2: // create new with incremental extention
                    while (file_exists($path . $new_name . $copy . $this -> file["extention"])) {
                        $copy = "_copy" . $n;
                        $n++;
                    } 
                    $this -> new_file = $path . $new_name . $copy . $this -> file["extention"];
                    $aok = copy($this -> file["file"], $this -> new_file);
                    $NEW_NAME = $new_name . $copy . $this -> file["extention"];
                    $fileCreated = true;
                    break;
                case 3: // do nothing if exists, highest protection
                    if (file_exists($this -> new_file)) {
                        $this -> errors[4] = true;
                    } else {
                        $aok = rename($this -> file["file"], $this -> new_file);
                        $NEW_NAME = $new_name;
                        $fileCreated = true;
                    } 
                    break;
                default:
                    break;
            } 
            $this -> fileName = $NEW_NAME;
            if (!$aok) {
                unset($this -> new_file);
            } 
            if ($fileCreated && $createthumb && ($this -> file["extention"] == '.jpg' || $this -> file["extention"] == '.gif' || $this -> file["extention"] == '.png')) {
                $this -> _createThumb($NEW_NAME, $path2, $path3, $width);
            } 
            return $aok;
        } 
    } 
} 

?>